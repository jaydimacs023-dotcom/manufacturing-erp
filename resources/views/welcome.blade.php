<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Banana Chips Manufacturing System') }} | ERP</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .feature-card {
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="min-h-screen bg-[#06291f] text-white font-['Figtree',sans-serif]" aria-busy="true">
    <x-page-loader message="Preparing workspace" />
    <!-- Background gradients -->
    <div class="fixed inset-0 opacity-30 pointer-events-none" style="background-image: radial-gradient(circle at 15% 20%, #34d399 0, transparent 28%), radial-gradient(circle at 85% 80%, #0d9488 0, transparent 30%);"></div>

    <!-- Navigation -->
    <header class="relative z-10">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 sm:px-8">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-300 text-emerald-950">
                    <svg class="w-[21px] h-[21px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </span>
                <div class="hidden sm:block">
                    <p class="font-headline text-base font-bold">{{ config('app.name', 'Banana Chips Manufacturing System') }}</p>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-emerald-200">Banana Chips Manufacturing</p>
                </div>
            </a>

            <!-- Auth Links -->
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                           class="rounded-xl bg-emerald-400 px-5 py-2.5 text-sm font-bold text-emerald-950 shadow-lg shadow-emerald-900/20 transition hover:bg-emerald-300">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="rounded-xl border border-emerald-700 px-5 py-2.5 text-sm font-semibold text-emerald-100 transition hover:bg-emerald-800/50">
                            Sign in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="rounded-xl bg-emerald-400 px-5 py-2.5 text-sm font-bold text-emerald-950 shadow-lg shadow-emerald-900/20 transition hover:bg-emerald-300">
                                Get started
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <main class="relative z-10 mx-auto max-w-7xl px-5 sm:px-8">
        <section class="flex flex-col items-center justify-center py-16 text-center lg:py-24">
            <div class="inline-flex items-center gap-2 rounded-full border border-emerald-700/50 bg-emerald-900/30 px-4 py-1.5 text-xs font-semibold text-emerald-200 backdrop-blur-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Enterprise Resource Planning for Banana Chips Manufacturers
            </div>

            <h1 class="mt-8 max-w-4xl font-headline text-4xl font-bold leading-tight tracking-tight sm:text-5xl lg:text-6xl">
                Your entire manufacturing operation,<br />
                <span class="bg-gradient-to-r from-emerald-300 to-teal-200 bg-clip-text text-transparent">securely connected.</span>
            </h1>

            <p class="mt-6 max-w-2xl text-base leading-relaxed text-emerald-100/70 sm:text-lg">
                One powerful workspace to manage procurement, inventory, production, quality control, 
                warehouse operations, sales, and accounting — purpose-built for banana chips manufacturing.
            </p>

            <div class="mt-10 flex flex-col items-center gap-4 sm:flex-row">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                           class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-400 px-8 py-3.5 text-sm font-bold text-emerald-950 shadow-xl shadow-emerald-900/20 transition hover:bg-emerald-300 sm:w-auto">
                            Go to Dashboard
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}" 
                           class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-400 px-8 py-3.5 text-sm font-bold text-emerald-950 shadow-xl shadow-emerald-900/20 transition hover:bg-emerald-300 sm:w-auto">
                            Start free trial
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                        <a href="{{ route('login') }}" 
                           class="flex w-full items-center justify-center gap-2 rounded-xl border border-emerald-700 px-8 py-3.5 text-sm font-semibold text-emerald-100 transition hover:bg-emerald-800/50 sm:w-auto">
                            Sign in to existing account
                        </a>
                    @endauth
                @endif
            </div>
        </section>

        <!-- Feature Highlights -->
        <section class="pb-16 lg:pb-24">
            <div class="text-center">
                <h2 class="font-headline text-2xl font-bold tracking-tight sm:text-3xl">Everything you need to run production</h2>
                <p class="mt-3 text-sm text-emerald-100/60">Comprehensive modules designed for the complete manufacturing lifecycle</p>
            </div>

            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Procurement -->
                <div class="feature-card rounded-2xl border border-emerald-800/40 bg-emerald-900/20 p-6 backdrop-blur-sm">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500/20 text-blue-400">
                        <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                        </svg>
                    </span>
                    <h3 class="mt-4 font-headline text-lg font-bold">Procurement</h3>
                    <p class="mt-2 text-sm leading-relaxed text-emerald-100/60">
                        Manage purchase requests, purchase orders, goods receipts, and supplier returns with full approval workflows.
                    </p>
                </div>

                <!-- Inventory -->
                <div class="feature-card rounded-2xl border border-emerald-800/40 bg-emerald-900/20 p-6 backdrop-blur-sm">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500/20 text-emerald-400">
                        <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </span>
                    <h3 class="mt-4 font-headline text-lg font-bold">Inventory</h3>
                    <p class="mt-2 text-sm leading-relaxed text-emerald-100/60">
                        Real-time stock tracking, inventory adjustments, transfers between warehouses, and stock card visibility.
                    </p>
                </div>

                <!-- Production / Manufacturing -->
                <div class="feature-card rounded-2xl border border-emerald-800/40 bg-emerald-900/20 p-6 backdrop-blur-sm">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-500/20 text-amber-400">
                        <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </span>
                    <h3 class="mt-4 font-headline text-lg font-bold">Manufacturing</h3>
                    <p class="mt-2 text-sm leading-relaxed text-emerald-100/60">
                        Bill of Materials, manufacturing orders, production tracking, material issuance, and output recording.
                    </p>
                </div>

                <!-- Quality Control -->
                <div class="feature-card rounded-2xl border border-emerald-800/40 bg-emerald-900/20 p-6 backdrop-blur-sm">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-500/20 text-rose-400">
                        <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    <h3 class="mt-4 font-headline text-lg font-bold">Quality Control</h3>
                    <p class="mt-2 text-sm leading-relaxed text-emerald-100/60">
                        Incoming and in-process inspections, non-conformance tracking, and corrective action management.
                    </p>
                </div>

                <!-- Warehouse -->
                <div class="feature-card rounded-2xl border border-emerald-800/40 bg-emerald-900/20 p-6 backdrop-blur-sm">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-500/20 text-violet-400">
                        <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </span>
                    <h3 class="mt-4 font-headline text-lg font-bold">Warehouse</h3>
                    <p class="mt-2 text-sm leading-relaxed text-emerald-100/60">
                        Put-away, picking, internal transfers, and dispatch operations with full location tracking.
                    </p>
                </div>

                <!-- Sales & Export -->
                <div class="feature-card rounded-2xl border border-emerald-800/40 bg-emerald-900/20 p-6 backdrop-blur-sm">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-500/20 text-sky-400">
                        <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </span>
                    <h3 class="mt-4 font-headline text-lg font-bold">Sales & Export</h3>
                    <p class="mt-2 text-sm leading-relaxed text-emerald-100/60">
                        Sales orders, export documentation, packing lists, commercial invoices, and shipment tracking.
                    </p>
                </div>
            </div>
        </section>

        <!-- Trust & Security Section -->
        <section class="pb-16 lg:pb-24">
            <div class="rounded-3xl border border-emerald-800/30 bg-gradient-to-br from-emerald-900/40 to-teal-900/30 p-8 sm:p-12">
                <div class="grid gap-8 lg:grid-cols-[1.2fr_1fr] lg:items-center">
                    <div>
                        <h2 class="font-headline text-2xl font-bold tracking-tight sm:text-3xl">
                            Secure by design
                        </h2>
                        <p class="mt-4 text-sm leading-relaxed text-emerald-100/70">
                            Role-based access control, encrypted sessions, comprehensive audit logging, 
                            and approval workflows ensure your manufacturing data stays protected and compliant.
                        </p>
                        <ul class="mt-6 space-y-3">
                            <li class="flex items-start gap-3 text-sm text-emerald-100/70">
                                <svg class="mt-0.5 w-4 h-4 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Role-based permissions for granular access control
                            </li>
                            <li class="flex items-start gap-3 text-sm text-emerald-100/70">
                                <svg class="mt-0.5 w-4 h-4 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Full audit trail for every transaction and action
                            </li>
                            <li class="flex items-start gap-3 text-sm text-emerald-100/70">
                                <svg class="mt-0.5 w-4 h-4 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Multi-level approval workflows for critical operations
                            </li>
                            <li class="flex items-start gap-3 text-sm text-emerald-100/70">
                                <svg class="mt-0.5 w-4 h-4 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Encrypted data transmission and secure session management
                            </li>
                        </ul>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4 lg:gap-6">
                        <div class="flex h-24 w-24 items-center justify-center rounded-2xl border border-emerald-700/30 bg-emerald-900/30 backdrop-blur-sm sm:h-28 sm:w-28">
                            <div class="text-center">
                                <p class="font-headline text-2xl font-bold text-emerald-300">RBAC</p>
                                <p class="mt-1 text-[10px] text-emerald-100/50">Access Control</p>
                            </div>
                        </div>
                        <div class="flex h-24 w-24 items-center justify-center rounded-2xl border border-emerald-700/30 bg-emerald-900/30 backdrop-blur-sm sm:h-28 sm:w-28">
                            <div class="text-center">
                                <p class="font-headline text-2xl font-bold text-emerald-300">SOC 2</p>
                                <p class="mt-1 text-[10px] text-emerald-100/50">Compliance</p>
                            </div>
                        </div>
                        <div class="flex h-24 w-24 items-center justify-center rounded-2xl border border-emerald-700/30 bg-emerald-900/30 backdrop-blur-sm sm:h-28 sm:w-28">
                            <div class="text-center">
                                <p class="font-headline text-2xl font-bold text-emerald-300">AES-256</p>
                                <p class="mt-1 text-[10px] text-emerald-100/50">Encryption</p>
                            </div>
                        </div>
                        <div class="flex h-24 w-24 items-center justify-center rounded-2xl border border-emerald-700/30 bg-emerald-900/30 backdrop-blur-sm sm:h-28 sm:w-28">
                            <div class="text-center">
                                <p class="font-headline text-2xl font-bold text-emerald-300">99.9%</p>
                                <p class="mt-1 text-[10px] text-emerald-100/50">Uptime</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 border-t border-emerald-800/30">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-5 py-8 sm:flex-row sm:px-8">
            <div class="flex items-center gap-2 text-xs text-emerald-100/50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Role-based access &middot; Encrypted sessions &middot; Audited actions
            </div>
            <p class="text-xs text-emerald-100/40">
                &copy; {{ date('Y') }} {{ config('app.name', 'Banana Chips Manufacturing System') }}. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
