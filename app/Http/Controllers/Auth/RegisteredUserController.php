<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect to the designated dashboard based on user role
        $redirectRoute = 'dashboard';
        if ($user->can('view-administration')) {
            $redirectRoute = 'admin.dashboard';
        } elseif ($user->can('procurement-view')) {
            $redirectRoute = 'admin.purchase-requests.index';
        } elseif ($user->can('inventory-view')) {
            $redirectRoute = 'admin.inventory.index';
        } elseif ($user->can('manufacturing-order-view')) {
            $redirectRoute = 'admin.manufacturing.orders.index';
        } elseif ($user->can('sales-order-view')) {
            $redirectRoute = 'admin.sales.sales-orders.index';
        } elseif ($user->can('accounting-event-view')) {
            $redirectRoute = 'admin.accounting.events.index';
        }

        return redirect(route($redirectRoute, absolute: false));
    }
}
