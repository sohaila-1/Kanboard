<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;

Route::resource('projects', ProjectController::class);
Route::resource('tasks', TaskController::class);
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::get('/projects/{project}/edit', [\App\Http\Controllers\ProjectController::class, 'edit'])->name('projects.edit');
Route::put('/projects/{project}', [\App\Http\Controllers\ProjectController::class, 'update'])->name('projects.update');
Route::delete('/projects/{project}', [\App\Http\Controllers\ProjectController::class, 'destroy'])->name('projects.destroy');
Route::get('/projects/{project}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/projects/{project}/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/projects/{project}/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/projects/{project}/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::post('/tasks/{task}/move', [TaskController::class, 'move']);
Route::get('/projects/{project}/tasks/list', [TaskController::class, 'list'])->name('projects.tasks.list');
Route::get('/projects/{project}/kanban', [ProjectController::class, 'kanban'])->name('projects.kanban');
Route::post('/tasks/{task}/move', [TaskController::class, 'move'])->name('tasks.move');
Route::get('/projects/{project}/calendar', [\App\Http\Controllers\ProjectController::class, 'calendar'])->name('projects.calendar');
Route::get('/projects/{project}/members/add', [ProjectMemberController::class, 'create'])->name('projects.members.add');
Route::get('/projects/{project}/calendar', [ProjectController::class, 'calendar'])->name('projects.calendar');



Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth']) // <- sans "verified"
    ->name('dashboard');



// Groupe de routes pour gérer le profil : nécessite d'être connecté
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes Breeze
require __DIR__.'/auth.php';
