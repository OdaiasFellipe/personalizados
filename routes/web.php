<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

// Rota para a página inicial
Route::get('/', function () {
    return view('pagina-Inicial'); // Certifique-se de que o nome do arquivo está correto
})->name('pagina-Inicial');

Route::get('/catalogo', [ProdutoController::class, 'index'])->name('catalogo');

Route::get('/contato', function () {
    return view('contato'); // Certifique-se de que o nome do arquivo está correto
})->name('contato');
