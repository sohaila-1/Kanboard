<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;


Route::post('/login', [LoginController::class, 'login']);

// Accueil
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
});


// AUTHENTIFICATION
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


// RESET PASSWORD
Route::get('/password/forgot', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}/{email}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');



// VÉRIFICATION EMAIL
// Page qui demande à vérifier l'email
Route::get('/email/verify', function () {
    return view('auth.verify-email'); // crée cette vue si nécessaire
})->middleware('auth')->name('verification.notice');

// Lien de vérification (cliqué dans l'email)
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // marque comme vérifié
    return redirect('/'); // ou dashboard
})->middleware(['auth', 'signed'])->name('verification.verify');

// Relancer l'envoi de l'email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'Un nouveau lien de vérification a été envoyé.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/projects/invite/accept/{token}', [ProjectMemberController::class, 'acceptInvitation'])
    ->name('projects.invite.accept');

// Routes protégées après authentification et vérification d'email
Route::middleware(['auth', 'verified'])->group(function () {
    // Gestion des projets
    Route::resource('projects', ProjectController::class);
    Route::get('/projects/{project}/members/add', [ProjectMemberController::class, 'create'])->name('projects.members.add');
    Route::post('/projects/{project}/members', [ProjectMemberController::class, 'store'])->name('projects.members.store');
    Route::delete('/projects/{project}/members/{member}', [ProjectMemberController::class, 'destroy'])->name('projects.members.destroy');
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/projects/{project}/kanban', [ProjectController::class, 'kanban'])->name('projects.kanban');
    Route::get('/projects/{project}/calendar', [ProjectController::class, 'calendar'])->name('projects.calendar');
    Route::get('/projects/{project}/tasks/list', [TaskController::class, 'list'])->name('projects.tasks.list');
    Route::post('/projects/{project}/tasks/{task}/assign', [TaskController::class, 'assign'])->name('tasks.assign');
      // Gestion des tâches
    Route::post('/tasks/{task}/move', [TaskController::class, 'move'])->name('tasks.move');
    Route::get('/projects/{project}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    // Édition d'une tâche
    Route::get('/projects/{project}/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    // Mise à jour d'une tâche
    Route::put('/projects/{project}/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    // Suppression d'une tâche
    Route::delete('/projects/{project}/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/projects/{project}/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

    Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::view('/offline', 'offline');

    });

    // Dashboard
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
