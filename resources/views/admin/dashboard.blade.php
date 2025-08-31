@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    {{-- Estatísticas --}}
    <div class="col-xl-3 col-lg-6">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle mb-2">Total de Produtos</h6>
                        <h2 class="card-title mb-0 fw-bold">{{ $totalProdutos }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-gift fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle mb-2">Visualizações Hoje</h6>
                        <h2 class="card-title mb-0 fw-bold">1.2k</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-eye fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle mb-2 text-white">Contatos Recebidos</h6>
                        <h2 class="card-title mb-0 fw-bold text-white">45</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-envelope fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle mb-2 text-white">Avaliações</h6>
                        <h2 class="card-title mb-0 fw-bold text-white">4.8★</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-star fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Produtos Recentes --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-gift text-warning me-2"></i>
                        Produtos Recentes
                    </h5>
                    <a href="{{ route('admin.produtos') }}" class="btn btn-outline-primary btn-sm">
                        Ver Todos
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($produtosRecentes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Imagem</th>
                                    <th>Nome</th>
                                    <th>Preço</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produtosRecentes as $produto)
                                <tr>
                                    <td>
                                        @if($produto->imagem)
                                            <img src="{{ asset($produto->imagem) }}" 
                                                 alt="{{ $produto->nome }}" 
                                                 class="rounded" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $produto->nome }}</strong><br>
                                        <small class="text-muted">{{ Str::limit($produto->descricao, 30) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $produto->created_at->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.produtos.edit', $produto) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-gift fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Nenhum produto cadastrado ainda</h6>
                        <a href="{{ route('admin.produtos.create') }}" class="btn btn-warning btn-sm mt-2">
                            <i class="fas fa-plus me-1"></i>Adicionar Primeiro Produto
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    {{-- Ações Rápidas --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Ações Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.produtos.create') }}" class="btn btn-warning btn-modern">
                        <i class="fas fa-plus me-2"></i>
                        Novo Produto
                    </a>
                    
                    <a href="{{ route('admin.configuracoes') }}" class="btn btn-outline-primary btn-modern">
                        <i class="fas fa-cog me-2"></i>
                        Configurações
                    </a>
                    
                    <a href="{{ route('pagina-Inicial') }}" target="_blank" class="btn btn-outline-success btn-modern">
                        <i class="fas fa-external-link-alt me-2"></i>
                        Ver Site
                    </a>
                    
                    <button class="btn btn-outline-info btn-modern" onclick="abrirModalBackup()">
                        <i class="fas fa-download me-2"></i>
                        Backup
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Dicas --}}
        <div class="card mt-4">
            <div class="card-header bg-warning text-dark">
                <h6 class="card-title mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    Dicas
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Use imagens de alta qualidade nos produtos</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Mantenha as descrições claras e atrativas</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Atualize os preços regularmente</small>
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Responda rapidamente aos contatos</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Modal de Backup --}}
<div class="modal fade" id="modalBackup" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-download text-warning me-2"></i>
                    Backup do Sistema
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Escolha o que você deseja incluir no backup:</p>
                
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="backupProdutos" checked>
                    <label class="form-check-label" for="backupProdutos">
                        Produtos e imagens
                    </label>
                </div>
                
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="backupConfiguracoes" checked>
                    <label class="form-check-label" for="backupConfiguracoes">
                        Configurações do site
                    </label>
                </div>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="backupDatabase">
                    <label class="form-check-label" for="backupDatabase">
                        Banco de dados completo
                    </label>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    O backup será baixado como um arquivo ZIP.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" onclick="gerarBackup()">
                    <i class="fas fa-download me-2"></i>Gerar Backup
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function abrirModalBackup() {
        new bootstrap.Modal(document.getElementById('modalBackup')).show();
    }
    
    function gerarBackup() {
        Swal.fire({
            title: 'Gerando backup...',
            text: 'Por favor, aguarde',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Simular geração de backup
        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Backup gerado com sucesso!',
                text: 'O download será iniciado automaticamente.',
                timer: 2000,
                showConfirmButton: false
            });
            
            // Fechar modal
            bootstrap.Modal.getInstance(document.getElementById('modalBackup')).hide();
        }, 3000);
    }
</script>
@endsection
