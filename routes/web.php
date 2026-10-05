<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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
use App\Livewire\LectorPuerta;
use App\Livewire\LectorBarra;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Log;

#Route para realizar el Cron en Donweb
Route::get('/cron/run-scheduler-x98f', function (Request $request) {
    $secretKey = config('app.cron_secret_key', env('CRON_SECRET_KEY'));

    // Validar que la clave recibida coincida con la configurada
    if (!$secretKey || $request->query('key') !== $secretKey) {
        return response()->json([
            'status' => 'error',
            'message' => 'Acceso no autorizado.'
        ], 401);
    }

    try {
        // 1. Ejecutar el comando programado
        Artisan::call('reservations:delete-unpaid');

        // 2. Procesar los mails/trabajos pendientes en la cola y salir al terminar
        Artisan::call('queue:work', [
            '--stop-when-empty' => true,
            '--tries' => 3,
        ]);

        return response()->json(['status' => 'ok']);
    } catch (\Throwable $e) {
        Log::error("Error en ejecutor de cron: " . $e->getMessage(), [
            'exception' => $e
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
Route::get('/lectorPuerta', LectorPuerta::Class)->middleware(['auth', 'verified'])->name('lectorPuerta');
Route::get('/lectorBarra', LectorBarra::Class)->middleware(['auth', 'verified'])->name('lectorBarra');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
// Carga rutas secretas únicamente si el archivo existe en el servidor
if (file_exists(__DIR__ . '/secret.php')) {
    require __DIR__ . '/secret.php';
}