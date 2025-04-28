<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
 
Route::resource('projects', ProjectController::class);
Route::resource('tasks', TaskController::class);

Route::get('/', function () {
    return view('welcome');
});

// Dashboard protégé : l'utilisateur doit être connecté ET avoir validé son email
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Groupe de routes pour gérer le profil : nécessite d'être connecté
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes Breeze
require __DIR__.'/auth.php';
