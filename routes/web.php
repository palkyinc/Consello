<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Main;
use App\Livewire\Users;
use App\Livewire\Permissions;
use App\Livewire\Roles;
use App\Livewire\Dashboard;
use App\Livewire\Clientes;
use App\Livewire\Eventos;
use App\Livewire\Adicionales;
use App\Livewire\Reservas;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::view('/', 'welcome');

# Routes Basic by Template
Route::get('/dashboard', Dashboard::Class)->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/clientes', Clientes::Class)->middleware(['auth', 'verified'])->name('clientes');
Route::get('/users', Users::Class)->middleware(['auth', 'verified'])->name('users');
Route::get('/permissions', Permissions::Class)->middleware(['auth', 'verified'])->name('permissions');
Route::get('/roles', Roles::Class)->middleware(['auth', 'verified'])->name('roles');
Route::get('/changeViewMode', [UserController::Class, 'changeViewMode'])->middleware(['auth', 'verified']);

# Routes
Route::get('/eventos', Eventos::Class)->middleware(['auth', 'verified'])->name('eventos');
Route::get('/reservas', Reservas::Class)->middleware(['auth', 'verified'])->name('reservas');
Route::get('/adicionales/{evento_id}', Adicionales::Class)->middleware(['auth', 'verified'])->name('adicionales');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';