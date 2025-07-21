<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
{
    $user = auth()->user();

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // 🔄 Upload de la nouvelle image si fournie
    if ($request->hasFile('profile_photo')) {
        $file = $request->file('profile_photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/profiles', $filename);

        // Supprimer l’ancienne si existante
        if ($user->profile_photo && Storage::exists('public/profiles/' . $user->profile_photo)) {
            Storage::delete('public/profiles/' . $user->profile_photo);
        }

        $user->profile_photo = $filename;
    }

    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->save();

    return back()->with('success', 'Profil mis à jour avec succès.');
}

}
