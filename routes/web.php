<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;

// Página inicial - landing page moderna
Route::get('/', function () {
    return view('home');
})->name('home');

// Termos de Uso
Route::get('/termos-de-uso', function () {
    return view('termos-de-uso');
})->name('termos-de-uso');

// Política de Privacidade
Route::get('/politica-de-privacidade', function () {
    return view('politica-de-privacidade');
})->name('politica-de-privacidade');

// Página de imóveis/listagem
Route::get('/imoveis', [PropertyController::class, 'index'])->name('properties.index.public');

// Visualização pública de imóveis (sem autenticação)
Route::get('/imoveis/{property}', [PropertyController::class, 'show'])->name('properties.show');

// Rotas de autenticação (Breeze)
require __DIR__.'/auth.php';

// Rota específica para servir vídeos (contornando proxy Squid)
Route::get('/videos/{video}', function ($video) {
    $path = storage_path('app/public/properties/' . $video);

    if (!file_exists($path)) {
        abort(404, 'Video not found: ' . $path);
    }

    return response()->file($path, [
        'Content-Type' => 'video/mp4',
        'Accept-Ranges' => 'bytes',
        'Cache-Control' => 'public, max-age=3600'
    ]);
})->where('video', '.*')->name('serve.video');

// Dashboard personalizado por role
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rotas protegidas para usuários autenticados
Route::middleware('auth')->group(function () {

    // Relatórios (para corretores)
    Route::get('/relatorios', [DashboardController::class, 'relatorios'])
        ->middleware('corretor')
        ->name('relatorios');

    // Configurações do corretor
    Route::get('/configuracoes', [DashboardController::class, 'configuracoes'])
        ->middleware('corretor')
        ->name('configuracoes.corretor');

    // Funcionalidades Administrativas
    Route::middleware('admin')->prefix('admin')->group(function () {
        // Ações Administrativas
        Route::get('acoes', [AdminController::class, 'acoes'])->name('admin.acoes');
        Route::post('cache/clear', [AdminController::class, 'clearCache'])->name('admin.cache.clear');

        // Usuários
        Route::get('usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
        Route::patch('usuarios/{user}/role', [AdminController::class, 'updateUserRole'])->name('admin.usuarios.role');
        Route::delete('usuarios/{user}', [AdminController::class, 'deleteUser'])->name('admin.usuarios.delete');

        // Categorias
        Route::get('categorias', [AdminController::class, 'categorias'])->name('admin.categorias');
        Route::post('categorias', [AdminController::class, 'storeCategoria'])->name('admin.categorias.store');
        Route::patch('categorias/{categoria}', [AdminController::class, 'updateCategoria'])->name('admin.categorias.update');
        Route::patch('categorias/{categoria}/toggle', [AdminController::class, 'toggleCategoria'])->name('admin.categorias.toggle');
        Route::delete('categorias/{categoria}', [AdminController::class, 'deleteCategoria'])->name('admin.categorias.delete');

        // Imóveis
        Route::get('imoveis', [AdminController::class, 'imoveis'])->name('admin.imoveis');
        Route::patch('imoveis/{property}/status', [AdminController::class, 'updatePropertyStatus'])->name('admin.imoveis.status');

        // Relatórios Admin
        Route::get('relatorios', [AdminController::class, 'relatorios'])->name('admin.relatorios');

        // Configurações Admin
        Route::get('configuracoes', [AdminController::class, 'configuracoes'])->name('admin.configuracoes');
        Route::post('configuracoes', [AdminController::class, 'salvarConfiguracoes'])->name('admin.configuracoes.save');

        // Backup
        Route::get('backup', [AdminController::class, 'backup'])->name('admin.backup');
        Route::post('backup/create', [AdminController::class, 'createBackup'])->name('admin.backup.create');

        // Logs
        Route::get('logs', [AdminController::class, 'logs'])->name('admin.logs');
        Route::get('logs/download', [AdminController::class, 'downloadLogs'])->name('admin.logs.download');
    });

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Properties - CRUD completo (exceto show que é público)
    Route::resource('properties', PropertyController::class)->except(['show']);

    // Rotas adicionais para properties
    Route::get('properties/{property}/contact', [ContactController::class, 'create'])
        ->name('contacts.create');
    Route::get('properties/{property}/visit', [VisitController::class, 'create'])
        ->name('visits.create');
    Route::post('properties/{property}/favorite', [PropertyController::class, 'toggleFavorite'])
        ->name('properties.favorite');
    Route::get('favorites', [PropertyController::class, 'favorites'])
        ->name('properties.favorites');
    Route::post('properties/{property}/images', [PropertyController::class, 'uploadImages'])
        ->name('properties.upload-images');
    Route::delete('properties/{property}/images/{image}', [PropertyController::class, 'deleteImage'])
        ->name('properties.delete-image');
    Route::patch('properties/{property}/images/reorder', [PropertyController::class, 'updateImageOrder'])
        ->name('properties.reorder-images');

    // Contacts - Mensageria
    Route::resource('contacts', ContactController::class)->except(['create', 'store']);
    Route::post('properties/{property}/contacts', [ContactController::class, 'store'])
        ->name('contacts.store');
    Route::patch('contacts/{contact}/reply', [ContactController::class, 'markAsReplied'])
        ->name('contacts.reply');
    Route::patch('contacts/{contact}/archive', [ContactController::class, 'archive'])
        ->name('contacts.archive');

    // Visits - Agendamento
    Route::resource('visits', VisitController::class)->except(['create', 'store']);
    Route::post('properties/{property}/visits', [VisitController::class, 'store'])
        ->name('visits.store');
    Route::patch('visits/{visit}/confirm', [VisitController::class, 'confirm'])
        ->name('visits.confirm');
    Route::patch('visits/{visit}/complete', [VisitController::class, 'complete'])
        ->name('visits.complete');
    Route::patch('visits/{visit}/cancel', [VisitController::class, 'cancel'])
        ->name('visits.cancel');

// Rotas específicas para corretores (usando middleware)
Route::middleware('corretor')->group(function () {
    // Rotas adicionais específicas para corretores podem ser adicionadas aqui
});
});
