<!-- Sidebar -->
<aside class="fixed inset-y-0 left-0 z-30 w-64 bg-gray-900 text-white flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out" id="sidebar">
    <!-- Logo -->
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-700">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
            </svg>
            <span class="text-lg font-bold">{{ config('app.name', 'ERP') }}</span>
        </a>
        <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="lg:hidden text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- Procurement -->
        @can('procurement-view')
        <div x-data="{ open: {{ request()->routeIs('admin.purchase-request*') || request()->routeIs('admin.purchase-order*') || request()->routeIs('admin.goods-receipt*') || request()->routeIs('admin.supplier-return*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open" class="sidebar-link w-full flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                    <span>Procurement</span>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            <div x-show="open" class="space-y-1 pl-4">
                <a href="{{ route('admin.purchase-requests.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.purchase-requests.*') ? 'active' : '' }}">
                    <span>Purchase Requests</span>
                </a>
                <a href="{{ route('admin.purchase-orders.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.purchase-orders.*') ? 'active' : '' }}">
                    <span>Purchase Orders</span>
                </a>
                <a href="{{ route('admin.goods-receipts.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.goods-receipts.*') ? 'active' : '' }}">
                    <span>Goods Receipts</span>
                </a>
                <a href="{{ route('admin.supplier-returns.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.supplier-returns.*') ? 'active' : '' }}">
                    <span>Supplier Returns</span>
                </a>
            </div>
        @endcan

        <!-- Business Partner -->
        @can('business-partner-view')
        <div x-data="{ open: {{ request()->routeIs('admin.business-partner*') || request()->routeIs('admin.payment-terms*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open" class="sidebar-link w-full flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Business Partners</span>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            <div x-show="open" class="space-y-1 pl-4">
                <a href="{{ route('admin.business-partners.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.business-partners.*') ? 'active' : '' }}">
                    <span>All Partners</span>
                </a>
                <a href="{{ route('admin.payment-terms.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.payment-terms.*') ? 'active' : '' }}">
                    <span>Payment Terms</span>
                </a>
            </div>
        @endcan

        <!-- Product Master -->
        @can('product-view')
        <div x-data="{ open: {{ request()->routeIs('admin.product*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open" class="sidebar-link w-full flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span>Product Master</span>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            <div x-show="open" class="space-y-1 pl-4">
                <a href="{{ route('admin.products.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <span>Products</span>
                </a>
                <a href="{{ route('admin.product-categories.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.product-categories.*') ? 'active' : '' }}">
                    <span>Categories</span>
                </a>
                <a href="{{ route('admin.units-of-measure.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.units-of-measure.*') ? 'active' : '' }}">
                    <span>Units of Measure</span>
                </a>
            </div>
        @endcan

        <!-- Administration -->
        @can('view-administration')
        <div x-data="{ open: {{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.branches.*') || request()->routeIs('admin.warehouses.*') || request()->routeIs('admin.departments.*') || request()->routeIs('admin.company.*') || request()->routeIs('admin.number-series.*') || request()->routeIs('admin.settings.*') || request()->routeIs('admin.audit-logs.*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open" class="sidebar-link w-full flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Administration</span>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            <div x-show="open" class="space-y-1 pl-4">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-sub-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span>Admin Dashboard</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <span>Users</span>
                </a>
                <a href="{{ route('admin.roles.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                    <span>Roles</span>
                </a>
                <a href="{{ route('admin.branches.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.branches.*') ? 'active' : '' }}">
                    <span>Branches</span>
                </a>
                <a href="{{ route('admin.warehouses.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.warehouses.*') ? 'active' : '' }}">
                    <span>Warehouses</span>
                </a>
                <a href="{{ route('admin.departments.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                    <span>Departments</span>
                </a>
                <a href="{{ route('admin.company.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.company.*') ? 'active' : '' }}">
                    <span>Company</span>
                </a>
                <a href="{{ route('admin.number-series.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.number-series.*') ? 'active' : '' }}">
                    <span>Number Series</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <span>Settings</span>
                </a>
                <a href="{{ route('admin.audit-logs.index') }}" class="sidebar-sub-link {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}">
                    <span>Audit Logs</span>
                </a>
            </div>
        @endcan
    </nav>

    <!-- User Menu -->
    <div class="border-t border-gray-700 p-4">
        <form method="POST" action="{{ route('logout') }}" class="flex items-center justify-between">
            @csrf
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-sm font-medium">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="text-sm">
                    <p class="font-medium truncate">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-gray-400 truncate text-xs">{{ auth()->user()->email ?? '' }}</p>
                </div>
            <button type="submit" class="text-gray-400 hover:text-white" title="Logout">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </form>
    </div>

    <style>
        .sidebar-link {
            @apply flex items-center space-x-2 px-3 py-2 rounded-lg text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors duration-150;
        }
        .sidebar-link.active {
            @apply bg-gray-800 text-white;
        }
        .sidebar-sub-link {
            @apply flex items-center space-x-2 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-gray-800 hover:text-white transition-colors duration-150;
        }
        .sidebar-sub-link.active {
            @apply text-blue-400;
        }
    </style>
</aside>

