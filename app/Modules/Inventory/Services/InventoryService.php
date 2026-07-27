<?php

namespace Modules\Inventory\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Inventory\Models\InventoryMovement;
use Modules\Inventory\Models\StockCard;
use Modules\Inventory\Repositories\InventoryMovementRepository;
use Modules\Inventory\Repositories\StockCardRepository;
use Modules\ProductMaster\Models\Product;

class InventoryService
{
    public function __construct(
        protected InventoryMovementRepository $movementRepository,
        protected StockCardRepository $stockCardRepository,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getInventoryOverview()
    {
        $totalProducts = Product::count();
        $totalStockValue = StockCard::sum(\DB::raw('quantity_on_hand * unit_cost'));
        $totalItemsOnHand = StockCard::sum('quantity_on_hand');
        $lowStockCount = $this->stockCardRepository->getLowStock()->count();
        $outOfStockCount = $this->stockCardRepository->getOutOfStock()->count();

        return compact(
            'totalProducts',
            'totalStockValue',
            'totalItemsOnHand',
            'lowStockCount',
            'outOfStockCount'
        );
    }

    public function getStockCards(int $perPage = 15)
    {
        return $this->stockCardRepository->paginate($perPage);
    }

    public function getStockCardByProduct(int $productId, ?int $warehouseId = null)
    {
        return $this->stockCardRepository->findByProduct($productId);
    }

    public function getMovements(int $perPage = 15)
    {
        return $this->movementRepository->paginate($perPage);
    }

    public function getProductMovements(int $productId)
    {
        return $this->movementRepository->findByProduct($productId);
    }

    public function getLowStock(int $threshold = 10)
    {
        return $this->stockCardRepository->getLowStock($threshold);
    }

    public function getOutOfStock()
    {
        return $this->stockCardRepository->getOutOfStock();
    }

    public function getExpiring(int $days = 30)
    {
        return $this->stockCardRepository->getExpiring($days);
    }

    /**
     * Record an inventory movement and update the stock card.
     */
    public function recordMovement(array $data): InventoryMovement
    {
        if (!isset($data['movement_number'])) {
            $data['movement_number'] = $this->numberSeriesService->generateNext('INVENTORY_MOVEMENT');
        }

        // Calculate total cost
        $data['total_cost'] = $data['quantity'] * ($data['unit_cost'] ?? 0);

        $movement = $this->movementRepository->create($data);

        // Update stock card
        $this->updateStockCard($data);

        $this->auditService->logCreate('inventory', $movement->movement_number, $data);

        return $movement;
    }

    /**
     * Update the stock card balance after a movement.
     */
    public function updateStockCard(array $data): StockCard
    {
        $card = $this->stockCardRepository->findCard(
            $data['product_id'],
            $data['warehouse_id'],
            $data['batch_number'] ?? null
        );

        if (!$card) {
            $card = $this->stockCardRepository->create([
                'product_id' => $data['product_id'],
                'warehouse_id' => $data['warehouse_id'],
                'quantity_on_hand' => 0,
                'quantity_reserved' => 0,
                'quantity_available' => 0,
                'quantity_in_transit' => 0,
                'quantity_quarantine' => 0,
                'batch_number' => $data['batch_number'] ?? null,
                'expiry_date' => $data['expiry_date'] ?? null,
                'unit_cost' => $data['unit_cost'] ?? 0,
            ]);
        }

        $quantity = $data['quantity'];
        $movementType = $data['movement_type'];

        // Determine the effect on stock card based on movement type
        switch ($movementType) {
            case 'receive':
            case 'transfer_in':
            case 'production_return':
            case 'finished_goods_receipt':
            case 'adjustment_plus':
                $card->quantity_on_hand += $quantity;
                $card->unit_cost = $data['unit_cost'] ?? $card->unit_cost;
                break;

            case 'issue':
            case 'transfer_out':
            case 'production_issue':
            case 'shipment':
            case 'return_to_supplier':
            case 'adjustment_minus':
                $card->quantity_on_hand -= $quantity;
                break;
        }

        $card->quantity_available = $card->quantity_on_hand - $card->quantity_reserved;
        $card->save();

        return $card;
    }
}

