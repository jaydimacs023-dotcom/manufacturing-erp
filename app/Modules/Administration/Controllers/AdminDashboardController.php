<?php

namespace Modules\Administration\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;
use Modules\Administration\Models\Branch;
use Modules\Administration\Models\Department;
use Modules\Administration\Models\Warehouse;
use Modules\Administration\Repositories\BranchRepository;
use Modules\Administration\Repositories\UserRepository;
use Modules\Administration\Repositories\WarehouseRepository;

class AdminDashboardController extends Controller
{
    public function __construct(
        protected UserRepository $userRepository,
        protected BranchRepository $branchRepository,
        protected WarehouseRepository $warehouseRepository,
    ) {}

    public function index(): View
    {
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $lockedAccounts = User::where('is_locked', true)->count();
        $branchCount = Branch::count();
        $warehouseCount = Warehouse::count();
        $departmentCount = Department::count();
        $recentLogins = User::whereNotNull('last_login_at')
            ->orderBy('last_login_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'activeUsers',
            'lockedAccounts',
            'branchCount',
            'warehouseCount',
            'departmentCount',
            'recentLogins'
        ));
    }
}

