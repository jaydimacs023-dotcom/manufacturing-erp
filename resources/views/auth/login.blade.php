<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ERP') }} | Sign In</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-[#06291f] text-white">
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden p-5">
        <!-- Background gradients -->
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 15% 20%, #34d399 0, transparent 28%), radial-gradient(circle at 85% 80%, #0d9488 0, transparent 30%);"></div>

        <div class="relative grid w-full max-w-5xl overflow-hidden rounded-3xl bg-white shadow-2xl shadow-black/30 lg:grid-cols-[1.05fr_1fr]">
            <!-- Left panel - Branding -->
            <section class="hidden flex-col justify-between bg-gradient-to-br from-emerald-900 to-teal-800 p-12 text-white lg:flex">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-300 text-emerald-950">
                        <svg class="w-[23px] h-[23px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                        </svg>
                    </span>
                    <div>
                        <p class="font-headline text-lg font-bold">{{ config('app.name', 'ERP') }}</p>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-emerald-200">Manufacturing System</p>
                    </div>
                </div>

                <div>
                    <h1 class="max-w-sm font-headline text-4xl font-bold leading-tight">Your manufacturing, securely connected.</h1>
                    <p class="mt-4 max-w-sm text-sm leading-7 text-emerald-100/80">One protected workspace for procurement, inventory, production, quality control, and operations.</p>
                </div>

                <div class="flex items-center gap-2 text-xs text-emerald-100/70">
                    <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Role-based access &middot; Encrypted sessions &middot; Audited actions
                </div>
            </section>

            <!-- Right panel - Login form -->
            <section class="p-7 sm:p-12 lg:p-14">
                <div class="mb-9 lg:hidden">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-800">
                            <svg class="w-[21px] h-[21px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                            </svg>
                        </span>
                        <b class="font-headline text-lg text-slate-900">{{ config('app.name', 'ERP') }}</b>
                    </div>
                </div>

                <p class="text-xs font-bold uppercase tracking-[0.16em] text-emerald-700">Secure portal</p>
                <h2 class="mt-2 font-headline text-3xl font-bold tracking-tight text-slate-950">Welcome back</h2>
                <p class="mt-2 text-sm text-slate-500">Sign in with your assigned account.</p>

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                    @csrf

                    <!-- Email -->
                    <label class="block">
                        <span class="mb-2 block text-xs font-bold text-slate-700">Email address</span>
                        <span class="relative block">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 w-[17px] h-[17px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                                placeholder="you@company.ph" />
                        </span>
                        @error('email')
                            <p class="mt-2 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </label>

                    <!-- Password -->
                    <label class="block" x-data="{ show: false }">
                        <span class="mb-2 block text-xs font-bold text-slate-700">Password</span>
                        <span class="relative block">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 w-[17px] h-[17px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <input :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" minlength="8"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-11 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                                placeholder="Enter your password" />
                            <button type="button" @click="show = !show" aria-label="Toggle password visibility" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700">
                                <template x-if="!show">
                                    <svg class="w-[17px] h-[17px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </template>
                                <template x-if="show">
                                    <svg class="w-[17px] h-[17px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
