<!-- Top Navigation -->
<header class="sticky top-0 z-20 bg-white border-b border-gray-200 shadow-sm">
    <div class="flex items-center justify-between h-16 px-4 lg:px-6">
        <!-- Mobile Menu Toggle -->
        <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Page Title (mobile) -->
        <div class="lg:hidden">
            <span class="text-sm font-medium text-gray-700">{{ $title ?? 'ERP' }}</span>
        </div>

        <!-- Right Side Actions -->
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <button class="relative text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </button>

            <!-- User Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center space-x-2 text-sm text-gray-700 hover:text-gray-900 focus:outline-none">
                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-medium">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <span class="hidden sm:block">{{ auth()->user()->name ?? 'User' }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <hr class="my-1 border-gray-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

