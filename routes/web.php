<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrcamentoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\Admin\ServicoController;

// Rotas públicas do site
Route::get('/', function () {
    return view('pagina-Inicial');
})->name('pagina-Inicial');

Route::get('/catalogo', [ProdutoController::class, 'index'])->name('catalogo');

Route::get('/contato', function () {
    return view('contato');
})->name('contato');

// Rotas de orçamento (público)
Route::get('/orcamento', [OrcamentoController::class, 'create'])->name('orcamentos.create');
Route::post('/orcamento', [OrcamentoController::class, 'store'])->name('orcamentos.store');
Route::get('/orcamento/sucesso', [OrcamentoController::class, 'sucesso'])->name('orcamentos.sucesso');
Route::post('/orcamento/buscar-preco', [OrcamentoController::class, 'buscarPreco'])->name('orcamentos.buscar-preco');

// Rotas de autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas do sistema de orçamentos (público)
Route::get('/orcamento', [App\Http\Controllers\OrcamentoController::class, 'create'])->name('orcamentos.create');
Route::get('/orcamento/teste', function() {
    // Criar alguns produtos se não existirem
    if (App\Models\Produto::count() == 0) {
        App\Models\Produto::create([
            'nome' => 'Convite Personalizado',
            'descricao' => 'Convite personalizado para festas',
            'preco' => 5.50
        ]);
        
        App\Models\Produto::create([
            'nome' => 'Lembrancinha Infantil',
            'descricao' => 'Lembrancinha temática infantil',
            'preco' => 8.00
        ]);
        
        App\Models\Produto::create([
            'nome' => 'Toalha de Mesa',
            'descricao' => 'Toalha de mesa personalizada',
            'preco' => 25.00
        ]);
    }
    
    $produtos = App\Models\Produto::all();
    return view('orcamentos.teste', compact('produtos'));
})->name('orcamentos.teste');
Route::post('/orcamento', [App\Http\Controllers\OrcamentoController::class, 'store'])->name('orcamentos.store');
Route::get('/orcamento/sucesso', [App\Http\Controllers\OrcamentoController::class, 'sucesso'])->name('orcamentos.sucesso');
Route::post('/orcamento/buscar-preco', [App\Http\Controllers\OrcamentoController::class, 'buscarPreco'])->name('orcamentos.buscar-preco');

// Carrinho de produtos (público)
Route::prefix('carrinho')->name('carrinho.')->group(function () {
    Route::get('/', [CarrinhoController::class, 'index'])->name('index');
    Route::post('/adicionar', [CarrinhoController::class, 'adicionar'])->name('adicionar');
    Route::patch('/{produto}/atualizar', [CarrinhoController::class, 'atualizar'])->name('atualizar');
    Route::delete('/{produto}', [CarrinhoController::class, 'remover'])->name('remover');
    Route::delete('/limpar', [CarrinhoController::class, 'limpar'])->name('limpar');
});

// Rotas da galeria (público)
Route::get('/galeria', [App\Http\Controllers\GaleriaController::class, 'index'])->name('galeria');
Route::get('/galeria/{galeria}', [App\Http\Controllers\GaleriaController::class, 'show'])->name('galeria.show');
Route::get('/depoimentos', [App\Http\Controllers\GaleriaController::class, 'depoimentos'])->name('galeria.depoimentos');
Route::post('/depoimentos', [App\Http\Controllers\GaleriaController::class, 'storeDepoimento'])->name('galeria.depoimentos.store');

// Rotas administrativas protegidas
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Produtos
    Route::get('/produtos', [AdminController::class, 'produtos'])->name('produtos');
    Route::get('/produtos/criar', [AdminController::class, 'createProduto'])->name('produtos.create');
    Route::post('/produtos', [AdminController::class, 'storeProduto'])->name('produtos.store');
    Route::get('/produtos/{produto}/editar', [AdminController::class, 'editProduto'])->name('produtos.edit');
    Route::put('/produtos/{produto}', [AdminController::class, 'updateProduto'])->name('produtos.update');
    Route::delete('/produtos/{produto}', [AdminController::class, 'destroyProduto'])->name('produtos.destroy');
    
    // Galeria
    Route::get('/galeria', [AdminController::class, 'galeria'])->name('galeria');
    Route::get('/galeria/create', [AdminController::class, 'createGaleria'])->name('galeria.create');
    Route::post('/galeria', [AdminController::class, 'storeGaleria'])->name('galeria.store');
    Route::get('/galeria/{galeria}/edit', [AdminController::class, 'editGaleria'])->name('galeria.edit');
    Route::put('/galeria/{galeria}', [AdminController::class, 'updateGaleria'])->name('galeria.update');
    Route::delete('/galeria/{galeria}', [AdminController::class, 'destroyGaleria'])->name('galeria.destroy');
    
    // Depoimentos
    Route::get('/depoimentos', [AdminController::class, 'depoimentos'])->name('depoimentos');
    Route::put('/depoimentos/{depoimento}/aprovar', [AdminController::class, 'aprovarDepoimento'])->name('depoimentos.aprovar');
    Route::put('/depoimentos/{depoimento}/destacar', [AdminController::class, 'destacarDepoimento'])->name('depoimentos.destacar');
    Route::delete('/depoimentos/{depoimento}', [AdminController::class, 'destroyDepoimento'])->name('depoimentos.destroy');
    
    // Orçamentos (Admin)
    Route::get('/orcamentos', [App\Http\Controllers\OrcamentoController::class, 'index'])->name('orcamentos.index');
    Route::get('/orcamentos/{orcamento}', [App\Http\Controllers\OrcamentoController::class, 'show'])->name('orcamentos.show');
    Route::get('/orcamentos/{orcamento}/editar', [App\Http\Controllers\OrcamentoController::class, 'edit'])->name('orcamentos.edit');
    Route::put('/orcamentos/{orcamento}', [App\Http\Controllers\OrcamentoController::class, 'update'])->name('orcamentos.update');
    Route::delete('/orcamentos/{orcamento}', [App\Http\Controllers\OrcamentoController::class, 'destroy'])->name('orcamentos.destroy');
    Route::put('/orcamentos/{orcamento}/aprovar', [App\Http\Controllers\OrcamentoController::class, 'aprovar'])->name('orcamentos.aprovar');
    Route::put('/orcamentos/{orcamento}/rejeitar', [App\Http\Controllers\OrcamentoController::class, 'rejeitar'])->name('orcamentos.rejeitar');
    Route::put('/orcamentos/{orcamento}/converter', [App\Http\Controllers\OrcamentoController::class, 'converter'])->name('orcamentos.converter');
    
    // Serviços (Admin)
    Route::resource('servicos', App\Http\Controllers\Admin\ServicoController::class);
    Route::put('/servicos/{servico}/toggle-status', [App\Http\Controllers\Admin\ServicoController::class, 'toggleStatus'])->name('servicos.toggle-status');
    
    // Configurações
    Route::get('/configuracoes', [AdminController::class, 'configuracoes'])->name('configuracoes');
    Route::post('/configuracoes', [AdminController::class, 'updateConfiguracoes'])->name('configuracoes.update');
    
    // Upload de imagens
    Route::post('/upload-imagem', [AdminController::class, 'uploadImagem'])->name('upload-imagem');
});

// Redirecionamento para o painel após login
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
})->middleware('auth');
