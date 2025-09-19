<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProcessoController;
use App\Http\Controllers\PrefeituraController;

// Rotas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rota '/' apontando para o dashboard
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

// Rotas de usuários dentro do prefixo admin
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::get('/usuarios/{user}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{user}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{user}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

        Route::resource('prefeituras', PrefeituraController::class)->names([
            'index' => 'prefeituras.index',
            'create' => 'prefeituras.create',
            'store' => 'prefeituras.store',
            'show' => 'prefeituras.show',
            'edit' => 'prefeituras.edit',
            'update' => 'prefeituras.update',
            'destroy' => 'prefeituras.destroy'
        ]);

        // Rotas para unidades
        Route::post('prefeituras/{prefeitura}/unidades', [UnidadeController::class, 'storeUnidade'])->name('prefeituras.unidades.store');
        Route::get('unidades/{id}', [UnidadeController::class, 'getUnidade'])->name('unidades.get');
        Route::put('unidades/{id}', [UnidadeController::class, 'updateUnidade'])->name('unidades.update');
        Route::delete('unidades/{id}', [UnidadeController::class, 'destroyUnidade'])->name('unidades.destroy');

        Route::resource('processos', ProcessoController::class)->names([
            'index' => 'processos.index',
            'create' => 'processos.create',
            'store' => 'processos.store',
            'show' => 'processos.show',
            'edit' => 'processos.edit',
            'update' => 'processos.update',
            'destroy' => 'processos.destroy'
        ]);
    });

require __DIR__ . '/auth.php';
