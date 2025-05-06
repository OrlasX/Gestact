<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Modificar la validación para que permita el uso de correos de usuarios inactivos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Verifica si el correo ya está en uso por un usuario activo
                    $userWithEmail = User::where('email', $value)->where('estado', true)->first();
                    if ($userWithEmail) {
                        $fail('El correo ya está en uso por un usuario activo.');
                    }
                }
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cargo' => ['required', 'string', 'max:255'],
            'firma' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Ajusta el tamaño máximo según sea necesario
        ]);

        // Almacena la firma y crea el usuario
        $firmaPath = $request->file('firma')->store('firmas', 'public');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cargo' => $request->cargo,
            'firma' => $firmaPath,
            'estado' => true, // El usuario nuevo se crea como activo
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

}
