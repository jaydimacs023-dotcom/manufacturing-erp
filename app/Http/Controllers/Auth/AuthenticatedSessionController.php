<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect to the designated dashboard based on user role/permissions
        $redirectRoute = $this->getRedirectRoute();

        return redirect()->intended(route($redirectRoute, absolute: false));
    }

    /**
     * Determine the designated dashboard route based on the authenticated user's permissions.
     */
    protected function getRedirectRoute(): string
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Priority-ordered permission checks for role-based redirect
        if ($user->can('view-administration')) {
            return 'admin.dashboard';
        }

        if ($user->can('procurement-view')) {
            return 'admin.purchase-requests.index';
        }

        if ($user->can('inventory-view')) {
            return 'admin.inventory.index';
        }

        if ($user->can('manufacturing-order-view')) {
            return 'admin.manufacturing.orders.index';
        }

        if ($user->can('inspection-view')) {
            return 'admin.quality-control.inspections.index';
        }

        if ($user->can('sales-order-view')) {
            return 'admin.sales.sales-orders.index';
        }

        if ($user->can('export-order-view')) {
            return 'admin.sales.export-orders.index';
        }

        if ($user->can('accounting-event-view')) {
            return 'admin.accounting.events.index';
        }

        // Fallback to the generic dashboard
        return 'dashboard';
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
