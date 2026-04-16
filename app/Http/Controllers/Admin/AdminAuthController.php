<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        $user = Auth::user();
        if ($user instanceof User && $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Adresse e-mail ou mot de passe incorrect.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();
        if (! $user instanceof User || ! $user->isAdmin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => 'Ce compte n’a pas accès à l’administration.'])
                ->onlyInput('email');
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    public function showForgotPassword(string $locale)
    {
        return view('admin.forgot-password');
    }

    public function sendResetLink(string $locale, Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::query()
            ->where('email', $validated['email'])
            ->where('is_admin', true)
            ->first();

        if (! $user) {
            return back()->with('status', 'Si cette adresse existe dans l’administration, un lien de réinitialisation a été envoyé.');
        }

        $status = Password::broker()->sendResetLink([
            'email' => $user->email,
        ]);

        if ($status !== Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => 'Impossible d’envoyer le lien de réinitialisation pour le moment.',
            ]);
        }

        return back()->with('status', 'Si cette adresse existe dans l’administration, un lien de réinitialisation a été envoyé.');
    }

    public function showResetPassword(string $locale, Request $request, string $token)
    {
        return view('admin.reset-password', [
            'token' => $token,
            'email' => (string) $request->query('email', ''),
        ]);
    }

    public function resetPassword(string $locale, Request $request)
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
        ]);

        $user = User::query()
            ->where('email', $validated['email'])
            ->where('is_admin', true)
            ->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => 'Ce compte n’a pas accès à l’administration.',
            ]);
        }

        $status = Password::broker()->reset(
            $validated,
            function (User $user, string $password): void {
                if (! $user->isAdmin()) {
                    return;
                }

                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => 'Le lien est invalide ou a expiré.',
            ]);
        }

        return redirect()
            ->route('admin.login')
            ->with('status', 'Votre mot de passe administrateur a été réinitialisé. Vous pouvez vous connecter.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
