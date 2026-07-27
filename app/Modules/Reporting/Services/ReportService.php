<?php

namespace Modules\Reporting\Services;

use Modules\Procurement\Models\PurchaseRequest;
use Modules\Procurement\Models\PurchaseOrder;
use Modules\Procurement\Models\GoodsReceipt;
use Modules\Procurement\Models\SupplierReturn;
use Modules\Inventory\Models\InventoryMovement;
use Modules\Inventory\Models\StockCard;
use Modules\Inventory\Models\InventoryAdjustment;
use Modules\Inventory\Models\StockReservation;
use Modules\Manufacturing\Models\ManufacturingOrder;
use Modules\Manufacturing\Models\ProductionOutput;
use Modules\Manufacturing\Models\WasteRecord;
use Modules\Manufacturing\Models\MaterialIssue;
use Modules\QualityControl\Models\QualityInspection;
use Modules\QualityControl\Models\NonConformance;
use Modules\Warehouse\Models\Putaway;
use Modules\Warehouse\Models\Picking;
use Modules\Warehouse\Models\Dispatch;
use Modules\Sales\Models\SalesOrder;
use Modules\Sales\Models\ExportOrder;
use Modules\Accounting\Models\AccountingEvent;
use Modules\Accounting\Models\PostingQueue;
use Illuminate\Support\Facades\DB;

class ReportService
{
    // ─── Procurement Reports ───

    public function procurementSummary(array $filters = []): array
    {
        $query = PurchaseRequest::query();
        if (!empty($filters['date_from'])) $query->whereDate('created_at', '>=', $filters['date_from']);
        if (!empty($filters['date_to'])) $query->whereDate('created_at', '<=', $filters['date_to']);
        if (!empty($filters['status'])) $query->where('status', $filters['status']);

        return [
            'total_purchase_requests' => PurchaseRequest::count(),
            'pending_requests' => PurchaseRequest::whereIn('status', ['draft', 'submitted'])->count(),
            'approved_requests' => PurchaseRequest::where('status', 'approved')->count(),
            'total_purchase_orders' => PurchaseOrder::count(),
            'pending_orders' => PurchaseOrder::whereIn('status', ['draft', 'sent'])->count(),
            'total_goods_receipts' => GoodsReceipt::count(),
            'total_supplier_returns' => SupplierReturn::count(),
            'purchase_requests' => PurchaseRequest::with('requestedBy')->orderBy('created_at', 'desc')->take(20)->get(),
            'purchase_orders' => PurchaseOrder::with('supplier')->orderBy('created_at', 'desc')->take(20)->get(),
        ];
    }

    // ─── Inventory Reports ───

    public function inventorySummary(array $filters = []): array
    {
        $movementQuery = InventoryMovement::query();
        if (!empty($filters['date_from'])) $movementQuery->whereDate('created_at', '>=', $filters['date_from']);
        if (!empty($filters['date_to'])) $movementQuery->whereDate('created_at', '<=', $filters['date_to']);
        if (!empty($filters['product_id'])) $movementQuery->where('product_id', $filters['product_id']);

        return [
            'total_movements' => InventoryMovement::count(),
            'today_movements' => InventoryMovement::whereDate('created_at', today())->count(),
            'pending_adjustments' => InventoryAdjustment::where('status', 'draft')->count(),
            'active_reservations' => StockReservation::where('status', 'active')->count(),
            'low_stock_products' => DB::table('stock_cards')
                ->join('products', 'stock_cards.product_id', '=', 'products.id')
                ->whereColumn('stock_cards.quantity', '<=', 'products.minimum_stock')
                ->count(),
            'recent_movements' => InventoryMovement::with(['product', 'warehouse'])
                ->orderBy('created_at', 'desc')->take(20)->get(),
            'stock_cards' => StockCard::with('product')->orderBy('quantity', 'asc')->take(50)->get(),
        ];
    }

    // ─── Manufacturing Reports ───

    public function manufacturingSummary(array $filters = []): array
    {
        $moQuery = ManufacturingOrder::query();
        if (!empty($filters['date_from'])) $moQuery->whereDate('created_at', '>=', $filters['date_from']);
        if (!empty($filters['date_to'])) $moQuery->whereDate('created_at', '<=', $filters['date_to']);
        if (!empty($filters['status'])) $moQuery->where('status', $filters['status']);

        $totalOutput = ProductionOutput::sum('quantity');
        $totalWaste = WasteRecord::sum('quantity');
        $yieldPercent = $totalOutput > 0
            ? round(($totalOutput / ($totalOutput + $totalWaste)) * 100, 2)
            : 0;

        return [
            'total_orders' => ManufacturingOrder::count(),
            'active_orders' => ManufacturingOrder::whereIn('status', ['released', 'in_progress'])->count(),
            'completed_orders' => ManufacturingOrder::where('status', 'completed')->count(),
            'total_output' => $totalOutput,
            'total_waste' => $totalWaste,
            'yield_percentage' => $yieldPercent,
            'waste_percentage' => $yieldPercent > 0 ? round(100 - $yieldPercent, 2) : 0,
            'orders' => ManufacturingOrder::with(['product'])
                ->orderBy('created_at', 'desc')->take(20)->get(),
            'recent_outputs' => ProductionOutput::with(['manufacturingOrder', 'product'])
                ->orderBy('created_at', 'desc')->take(20)->get(),
        ];
    }

    // ─── Quality Control Reports ───

    public function qualitySummary(array $filters = []): array
    {
        $inspectionQuery = QualityInspection::query();
        if (!empty($filters['date_from'])) $inspectionQuery->whereDate('created_at', '>=', $filters['date_from']);
        if (!empty($filters['date_to'])) $inspectionQuery->whereDate('created_at', '<=', $filters['date_to']);
        if (!empty($filters['status'])) $inspectionQuery->where('status', $filters['status']);

        $totalInspections = QualityInspection::count();
        $passed = QualityInspection::where('status', 'approved')->count();
        $failed = QualityInspection::where('status', 'rejected')->count();
        $passRate = $totalInspections > 0 ? round(($passed / $totalInspections) * 100, 2) : 0;

        return [
            'total_inspections' => $totalInspections,
            'passed' => $passed,
            'failed' => $failed,
            'pass_rate' => $passRate,
            'open_non_conformances' => NonConformance::whereIn('status', ['open', 'in_progress'])->count(),
            'inspections' => QualityInspection::with(['product', 'inspector'])
                ->orderBy('created_at', 'desc')->take(20)->get(),
        ];
    }

    // ─── Warehouse Reports ───

    public function warehouseSummary(array $filters = []): array
    {
        return [
            'total_putaway' => Putaway::count(),
            'pending_putaway' => Putaway::where('status', 'draft')->count(),
            'total_picking' => Picking::count(),
            'pending_picking' => Picking::where('status', 'draft')->count(),
            'total_dispatch' => Dispatch::count(),
            'pending_dispatch' => Dispatch::whereIn('status', ['draft', 'packed', 'loaded'])->count(),
            'dispatches_today' => Dispatch::whereDate('dispatch_date', today())->count(),
            'recent_dispatches' => Dispatch::with(['product', 'warehouse'])
                ->orderBy('created_at', 'desc')->take(20)->get(),
        ];
    }

    // ─── Sales & Export Reports ───

    public function salesSummary(array $filters = []): array
    {
        $soQuery = SalesOrder::query();
        if (!empty($filters['date_from'])) $soQuery->whereDate('created_at', '>=', $filters['date_from']);
        if (!empty($filters['date_to'])) $soQuery->whereDate('created_at', '<=', $filters['date_to']);
        if (!empty($filters['status'])) $soQuery->where('status', $filters['status']);

        return [
            'total_sales_orders' => SalesOrder::count(),
            'open_orders' => SalesOrder::whereIn('status', ['draft', 'confirmed', 'allocated'])->count(),
            'shipped_orders' => SalesOrder::where('status', 'shipped')->count(),
            'total_export_orders' => ExportOrder::count(),
            'pending_exports' => ExportOrder::whereIn('status', ['draft', 'planned'])->count(),
            'sales_orders' => SalesOrder::with('customer')
                ->orderBy('created_at', 'desc')->take(20)->get(),
            'export_orders' => ExportOrder::with('customer')
                ->orderBy('created_at', 'desc')->take(20)->get(),
        ];
    }

    // ─── Accounting Reports ───

    public function accountingSummary(array $filters = []): array
    {
        return [
            'total_events' => AccountingEvent::count(),
            'pending_events' => AccountingEvent::where('status', 'pending')->count(),
            'posted_events' => AccountingEvent::where('status', 'posted')->count(),
            'failed_events' => AccountingEvent::where('status', 'failed')->count(),
            'queue_pending' => PostingQueue::where('status', 'pending')->count(),
            'queue_failed' => PostingQueue::where('status', 'failed')->count(),
            'recent_events' => AccountingEvent::orderBy('created_at', 'desc')->take(20)->get(),
            'posting_queue' => PostingQueue::orderBy('created_at', 'desc')->take(20)->get(),
        ];
    }

    // ─── Executive Dashboard ───

    public function executiveSummary(): array
    {
        $totalOutput = ProductionOutput::sum('quantity');
        $totalWaste = WasteRecord::sum('quantity');
        $yieldPercent = $totalOutput > 0
            ? round(($totalOutput / ($totalOutput + $totalWaste)) * 100, 2)
            : 0;

        return [
            // Production
            'production_today' => ProductionOutput::whereDate('created_at', today())->sum('quantity'),
            'active_orders' => ManufacturingOrder::whereIn('status', ['released', 'in_progress'])->count(),
            'yield_percentage' => $yieldPercent,
            'waste_percentage' => $yieldPercent > 0 ? round(100 - $yieldPercent, 2) : 0,

            // Sales
            'sales_orders_today' => SalesOrder::whereDate('created_at', today())->count(),
            'open_sales_orders' => SalesOrder::whereIn('status', ['draft', 'confirmed', 'allocated'])->count(),
            'pending_exports' => ExportOrder::whereIn('status', ['draft', 'planned'])->count(),

            // Inventory
            'low_stock_count' => DB::table('stock_cards')
                ->join('products', 'stock_cards.product_id', '=', 'products.id')
                ->whereColumn('stock_cards.quantity', '<=', 'products.minimum_stock')
                ->count(),
            'pending_dispatches' => Dispatch::whereIn('status', ['draft', 'packed', 'loaded'])->count(),
            'active_reservations' => StockReservation::where('status', 'active')->count(),

            // Procurement
            'pending_purchase_requests' => PurchaseRequest::whereIn('status', ['draft', 'submitted'])->count(),
            'pending_purchase_orders' => PurchaseOrder::whereIn('status', ['draft', 'sent'])->count(),

            // Quality
            'failed_inspections' => QualityInspection::where('status', 'rejected')->count(),
            'open_non_conformances' => NonConformance::whereIn('status', ['open', 'in_progress'])->count(),

            // Accounting
            'pending_accounting_events' => AccountingEvent::where('status', 'pending')->count(),
        ];
    }
}

