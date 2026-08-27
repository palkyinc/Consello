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
use App\Livewire\ContactForm;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

### Para Borrar

/* 
use Illuminate\Support\Facades\Artisan;

Route::get('/ejecutar-migraciones-secretas', function () {
    Artisan::call('migrate', ['--force' => true]);
    return '<pre>' . Artisan::output() . '</pre>';
});
 */
#Route para realizar el Cron en Donweb
Route::get('/cron/run-scheduler-x98f', function () {
    try {
        Artisan::call('reservations:delete-unpaid');
        
        // Retorna éxito silencioso
        return response()->json(['status' => 'ok']);
    } catch (\Throwable $e) {
        // Se ejecuta y registra ÚNICAMENTE si ocurre un fallo
        Log::error("Error en ejecutor de reservas: " . $e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);

        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
});
# Routes para corregir pblic_html en el servidor
Route::get('/build/{path}', function ($path) {
    $filePath = base_path('public/build/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    $mimeType = match (pathinfo($filePath, PATHINFO_EXTENSION)) {
        'css' => 'text/css',
        'js' => 'text/javascript',
        'json' => 'application/json',
        default => mime_content_type($filePath) ?: 'text/plain',
    };
    return response()->file($filePath, [
        'Content-Type' => $mimeType,
    ]);
})->where('path', '.*');
# Routes para corregir pblic_html en el servidor
Route::get('/app-icons/{filename}', function ($filename) {
    // Busca el archivo dentro de la carpeta privada consello_app/public/icons
    $path = base_path('public/icons/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path, [
        'Content-Type' => 'image/svg+xml',
    ]);
})->where('filename', '.*\.svg$');

Route::view('/', 'welcome');

# Routes Basic by Template
Route::get('/dashboard', Dashboard::Class)->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/clientes', Clientes::Class)->middleware(['auth', 'verified'])->name('clientes');
Route::get('/users', Users::Class)->middleware(['auth', 'verified'])->name('users');
Route::get('/permissions', Permissions::Class)->middleware(['auth', 'verified'])->name('permissions');
Route::get('/roles', Roles::Class)->middleware(['auth', 'verified'])->name('roles');
Route::get('/changeViewMode', [UserController::Class, 'changeViewMode'])->middleware(['auth', 'verified']);
Route::get('/contacto', ContactForm::Class)->name('contacto');

# Routes
Route::get('/eventos', Eventos::Class)->middleware(['auth', 'verified'])->name('eventos');
Route::get('/reservas', Reservas::Class)->middleware(['auth', 'verified'])->name('reservas');
Route::get('/adicionales/{evento_id}', Adicionales::Class)->middleware(['auth', 'verified'])->name('adicionales');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';