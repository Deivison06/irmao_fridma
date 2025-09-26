<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProcessoController;
use App\Http\Controllers\PrefeituraController;

// Rotas de perfil (usuário logado)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rota inicial -> Dashboard
Route::get('/', [PrefeituraController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('admin.dashboard');

// Grupo admin
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified'])
    ->group(function () {

        /**
         * Usuários
         */
        Route::resource('usuarios', UsuarioController::class)->names([
            'index'   => 'usuarios.index',
            'create'  => 'usuarios.create',
            'store'   => 'usuarios.store',
            'edit'    => 'usuarios.edit',
            'update'  => 'usuarios.update',
            'destroy' => 'usuarios.destroy',
        ])->except(['show']); // não tem show no CRUD de usuário

        /**
         * Prefeituras
         */
        Route::resource('prefeituras', PrefeituraController::class)->names([
            'index'   => 'prefeituras.index',
            'create'  => 'prefeituras.create',
            'store'   => 'prefeituras.store',
            'show'    => 'prefeituras.show',
            'edit'    => 'prefeituras.edit',
            'update'  => 'prefeituras.update',
            'destroy' => 'prefeituras.destroy',
        ]);

        /**
         * Unidades (vinculadas à prefeitura)
         */
        Route::post('prefeituras/{prefeitura}/unidades', [UnidadeController::class, 'storeUnidade'])->name('prefeituras.unidades.store');
        Route::get('unidades/{id}', [UnidadeController::class, 'getUnidade'])->name('unidades.get');
        Route::put('unidades/{id}', [UnidadeController::class, 'updateUnidade'])->name('unidades.update');
        Route::delete('unidades/{id}', [UnidadeController::class, 'destroyUnidade'])->name('unidades.destroy');

        /**
         * Processos
         */
        Route::resource('processos', ProcessoController::class)->names([
            'index'   => 'processos.index',
            'create'  => 'processos.create',
            'store'   => 'processos.store',
            'show'    => 'processos.show',
            'edit'    => 'processos.edit',
            'update'  => 'processos.update',
            'destroy' => 'processos.destroy',
        ]);

        // Rota extra para iniciar processo (se não for o mesmo que create)
        Route::get('processos/{processo}/iniciar', [ProcessoController::class, 'iniciar'])->name('processos.iniciar');
        Route::post('processos/{processo}/iniciar', [ProcessoController::class, 'storeDetalhe'])->name('processos.detalhes.store');
        Route::get('processos/{processo}/pdf', [ProcessoController::class, 'gerarPdf'])->name('processos.pdf');
        Route::get('/processos/{processo}/visualizar-pdf', [ProcessoController::class, 'visualizarPdf'])
         ->name('processos.visualizar-pdf');
        Route::get('/processo/{processo}/documento/{tipo}/baixar', [ProcessoController::class, 'baixarDocumento'])->name('processo.documento.dowload');
        Route::get('/processo/{processo}/documentos/baixar-todos', [ProcessoController::class, 'baixarTodosDocumentos'])->name('processo.documento.dowload-all');

    });

require __DIR__ . '/auth.php';
