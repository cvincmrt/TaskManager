<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

//verejne routy pre vsetkych (dostupne pre kazdeho)
Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

//chranene routy pre prihlasenych uzivatelov

Route::middleware('auth')->group(function()
{
    //profil uzivatela
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    
    //zakladne CRUD operacie
    Route::resource('tasks', TaskController::class);

Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
