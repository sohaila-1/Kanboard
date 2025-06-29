<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class PasswordResetController extends Controller
{
    // Formulaire pour demander la réinitialisation
    public function showForgotForm()
    {
        return view('auth.passwords.email');
    }

    // Envoi de l'email avec le lien de réinitialisation
    public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    // Vérifie si l'utilisateur existe
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Aucun compte ne correspond à cet email.']);
    }

    $token = Str::random(60);
    DB::table('password_resets')->updateOrInsert(
        ['email' => $request->email],
        ['token' => $token, 'created_at' => Carbon::now()]
    );

    $link = url('/password/reset/' . $token . '/' . urlencode($request->email));

    Mail::raw("Cliquez sur ce lien pour réinitialiser votre mot de passe : $link", function ($message) use ($request) {
        $message->to($request->email)->subject('Réinitialisation de mot de passe');
    });

    return back()->with('status', 'Nous avons envoyé un lien de réinitialisation à votre email.');
}


    // Formulaire de réinitialisation
    public function showResetForm($token, $email)
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $email
        ]);
    }



    // Mise à jour du mot de passe
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        $record = DB::table('password_resets')->where([
            ['email', $request->email],
            ['token', $request->token]
        ])->first();

        if (!$record || Carbon::parse($record->created_at)->addMinutes(5)->isPast()) {
            return back()->withErrors(['token' => 'Ce token est invalide ou expiré.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('status', 'Mot de passe modifié avec succès');
    }
}
