<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse|RedirectResponse
    {
        if ($request->wantsJson()) {
            if (!Auth::attempt($request->only('phone_number', 'password'), $request->filled('remember'))) {
                return back()->withErrors([
                    'phone_number' => 'The provided credentials do not match our records.',
                ]);
            }
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            if (!empty($user->id)) {
                $UID = $user->id;
            }
            return response()->json([
                'message' => 'Authenticated.',
                'token' => $token,
                'userId' => $UID,
            ], 200);
        }

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
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
