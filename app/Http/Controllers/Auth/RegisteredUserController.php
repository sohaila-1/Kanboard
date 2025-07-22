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
use Illuminate\View\View;


class RegisterUserController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
    ]);

    event(new Registered($user)); // 📩 envoie de l'email

    // ✅ PAS de auth()->login()

    return redirect()->route('login')->with('success', 'Inscription réussie ✅. Veuillez vérifier votre email.');
}
}
