<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        $credentials = $request->only('email', 'password');

        // Buscar solo un usuario activo con el correo especificado
        $user = User::where('email', $credentials['email'])->where('estado', true)->first();

        // Verificar si el usuario existe y si la contraseña es correcta
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user); // Autenticar manualmente al usuario encontrado y activo
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // Si no encuentra un usuario activo o la contraseña es incorrecta
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas son incorrectas o el usuario está desactivado.',
        ]);
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
