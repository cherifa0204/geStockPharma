<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewUserWelcomeMail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

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
        $isAdminLoggedIn = Auth::check();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Envoi de l'email d'accueil contenant les identifiants et le lien de connexion
        try {
            Mail::to($user->email)->send(new NewUserWelcomeMail($user, $request->password));
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de l'email au nouvel utilisateur '{$user->email}': " . $e->getMessage());
        }

        if ($isAdminLoggedIn) {
            return redirect()->route('users.index')->with('success', "L'utilisateur '{$user->name}' a été créé avec succès ! Un email d'accès lui a été envoyé.");
        }

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
