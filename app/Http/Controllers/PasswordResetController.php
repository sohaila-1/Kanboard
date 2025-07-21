<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PasswordResetController extends Controller
{
    // Affiche le formulaire pour entrer l'email
    public function showForgotForm()
    {
        return view('auth.passwords.email');
    }

    // Envoie le lien de réinitialisation
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Un lien de réinitialisation a été envoyé par email.')
            : back()->withErrors(['email' => __($status)]);
    }

    // Affiche le formulaire de réinitialisation
    public function showResetForm($token, $email)
    {
        return view('auth.passwords.reset', compact('token', 'email'));
    }

    // Met à jour le mot de passe
    public function reset(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Mot de passe réinitialisé. Vous pouvez vous connecter.')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
