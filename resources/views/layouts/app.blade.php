<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'ERP')) | Manufacturing ERP</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-brand-bg text-text-on-surface min-h-screen">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 lg:pl-72">
            <!-- Top Navigation / Header -->
            @include('components.top-nav')

            <!-- Page Content -->
            <main class="mx-auto max-w-[1500px] p-4 sm:p-6 lg:p-8">
                @if(session('success'))
                    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-medium text-rose-700">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Page Header -->
                @hasSection('page-header')
                    <div class="mb-7 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                        <div>
                            <div class="mb-2 flex items-center gap-2 text-xs font-semibold text-emerald-700">
                                <span>{{ config('app.name', 'ERP') }}</span>
                                <span class="text-slate-300">/</span>
                                <span class="text-slate-500">@yield('page-header')</span>
                            </div>
                            <h1 class="font-headline text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">
                                @yield('page-header')
                            </h1>
                            @hasSection('page-description')
                                <p class="mt-1 text-sm text-slate-500">@yield('page-description')</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 self-start rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-500 sm:self-auto">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Updated just now
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

