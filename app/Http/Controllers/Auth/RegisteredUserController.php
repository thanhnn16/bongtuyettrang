<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function checkPhoneNumber(Request $request): JsonResponse
    {
        $user = User::where('phone_number', $request->phone_number)->first();
        if ($user) {
            return response()->json([
                'message' => 'Phone number already exists',
            ]);
        }
        return response()->json([
            'message' => 'Phone number is available',
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse|Application|JsonResponse
    {
        $request->validate([
            'phone_number' => 'required|string|max:20|unique:users',
            'email' => 'nullable|string|lowercase|email|max:255|unique:users',
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'phone_number' => $request->phone_number,
            'full_name' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($request->expectsJson()) {
            return response()->json([
                'token' => $user->createToken('auth_token')->plainTextToken,
                'userId' => $user->id,
            ]);
        } else {
            return redirect(RouteServiceProvider::HOME);
        }
    }
}
