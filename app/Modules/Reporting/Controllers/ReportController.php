<?php

namespace Modules\Reporting\Controllers;

use App\Http\Controllers\Controller;
use Modules\Reporting\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService,
    ) {}

    public function index(): View
    {
        return view('admin.reports.index');
    }

    public function procurement(Request $request): View
    {
        $filters = $request->only(['date_from', 'date_to', 'status']);
        $data = $this->reportService->procurementSummary($filters);
        return view('admin.reports.procurement.index', $data);
    }

    public function inventory(Request $request): View
    {
        $filters = $request->only(['date_from', 'date_to', 'product_id']);
        $data = $this->reportService->inventorySummary($filters);
        return view('admin.reports.inventory.index', $data);
    }

    public function manufacturing(Request $request): View
    {
        $filters = $request->only(['date_from', 'date_to', 'status']);
        $data = $this->reportService->manufacturingSummary($filters);
        return view('admin.reports.manufacturing.index', $data);
    }

    public function quality(Request $request): View
    {
        $filters = $request->only(['date_from', 'date_to', 'status']);
        $data = $this->reportService->qualitySummary($filters);
        return view('admin.reports.quality.index', $data);
    }

    public function warehouse(Request $request): View
    {
        $filters = $request->only(['date_from', 'date_to']);
        $data = $this->reportService->warehouseSummary($filters);
        return view('admin.reports.warehouse.index', $data);
    }

    public function sales(Request $request): View
    {
        $filters = $request->only(['date_from', 'date_to', 'status']);
        $data = $this->reportService->salesSummary($filters);
        return view('admin.reports.sales.index', $data);
    }

    public function accounting(Request $request): View
    {
        $filters = $request->only(['date_from', 'date_to']);
        $data = $this->reportService->accountingSummary($filters);
        return view('admin.reports.accounting.index', $data);
    }

    public function executive(): View
    {
        $data = $this->reportService->executiveSummary();
        return view('admin.reports.executive.index', $data);
    }
}

