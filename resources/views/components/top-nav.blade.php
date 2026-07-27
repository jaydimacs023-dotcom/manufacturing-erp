@auth
<header class="sticky top-0 z-30 flex h-20 items-center border-b border-slate-200/80 bg-white/90 px-4 backdrop-blur-xl sm:px-6 lg:px-8" x-data="{ profileMenu: false }">
    <!-- Mobile hamburger -->
    <button class="mr-3 rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden" onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')">
        <svg class="w-[21px] h-[21px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <!-- Search (desktop) -->
    <div class="relative hidden max-w-sm flex-1 md:block">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 w-[17px] h-[17px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/10" placeholder="Search records, products, transactions…" />
    </div>

    <!-- Right side actions -->
    <div class="ml-auto flex items-center gap-2 sm:gap-4">
        <!-- Notifications -->
        <button class="relative rounded-xl p-2.5 text-slate-500 hover:bg-slate-100">
            <svg class="w-[19px] h-[19px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span class="absolute right-2 top-2 h-2 w-2 rounded-full border-2 border-white bg-rose-500"></span>
        </button>

        <div class="h-8 w-px bg-slate-200"></div>

        <!-- User dropdown -->
        <div class="relative">
            <button @click="profileMenu = !profileMenu" @click.away="profileMenu = false" class="flex items-center gap-3 rounded-xl p-1.5 pr-2 hover:bg-slate-50">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-xs font-bold text-emerald-800">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}{{ substr(auth()->user()->name ?? '', -1, 1) }}
                </span>
                <span class="hidden text-left sm:block">
                    <span class="block text-xs font-bold text-slate-800">{{ auth()->user()->name ?? 'User' }}</span>
                    <span class="block text-[10px] text-slate-500">
                        @can('view-administration') Super Admin
                        @elsecan('procurement-view') Procurement
                        @elsecan('inventory-view') Warehouse
                        @else Staff
                        @endcan
                    </span>
                </span>
                <svg class="w-[15px] h-[15px] text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div x-show="profileMenu" class="absolute right-0 top-14 w-64 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl shadow-slate-900/10 z-50" @click.away="profileMenu = false">
                <div class="px-3 py-2">
                    <p class="truncate text-xs font-bold text-slate-800">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="mt-0.5 text-[10px] text-slate-500">{{ auth()->user()->email ?? '' }}</p>
                </div>
                <div class="my-1 h-px bg-slate-100"></div>
                <a href="{{ route('profile.edit') }}" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                    <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile settings
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                        <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Sign out securely
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
@endauth

