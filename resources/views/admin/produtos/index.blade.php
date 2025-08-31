@extends('admin.layout')

@section('title', 'Gerenciar Produtos')
@section('page-title', 'Gerenciar Produtos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Produtos</h4>
        <p class="text-muted mb-0">Gerencie todos os produtos do seu catálogo</p>
    </div>
    <a href="{{ route('admin.produtos.create') }}" class="btn btn-warning btn-modern">
        <i class="fas fa-plus me-2"></i>Novo Produto
    </a>
</div>

{{-- Filtros --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" id="filtroNome" placeholder="Buscar por nome...">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filtroOrdem">
                    <option value="">Ordenar por...</option>
                    <option value="nome_asc">Nome (A-Z)</option>
                    <option value="nome_desc">Nome (Z-A)</option>
                    <option value="preco_asc">Menor Preço</option>
                    <option value="preco_desc">Maior Preço</option>
                    <option value="data_desc">Mais Recente</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filtroPreco">
                    <option value="">Faixa de preço...</option>
                    <option value="0-50">R$ 0 - R$ 50</option>
                    <option value="50-100">R$ 50 - R$ 100</option>
                    <option value="100-200">R$ 100 - R$ 200</option>
                    <option value="200+">R$ 200+</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100" onclick="limparFiltros()">
                    <i class="fas fa-eraser me-1"></i>Limpar
                </button>
            </div>
        </div>
    </div>
</div>

@if($produtos->count() > 0)
    {{-- Lista de Produtos --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover data-table" id="produtosTable">
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th>Data</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produtos as $produto)
                        <tr>
                            <td>
                                @if($produto->imagem)
                                    <img src="{{ asset($produto->imagem) }}" 
                                         alt="{{ $produto->nome }}" 
                                         class="rounded shadow-sm" 
                                         style="width: 60px; height: 60px; object-fit: cover;"
                                         data-bs-toggle="modal" 
                                         data-bs-target="#modalImagem{{ $produto->id }}"
                                         style="cursor: pointer;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center shadow-sm" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong class="d-block">{{ $produto->nome }}</strong>
                                <small class="text-muted">ID: #{{ $produto->id }}</small>
                            </td>
                            <td>
                                <span class="d-inline-block" style="max-width: 200px;" data-bs-toggle="tooltip" title="{{ $produto->descricao }}">
                                    {{ Str::limit($produto->descricao, 50) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success fs-6">
                                    R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $produto->created_at->format('d/m/Y H:i') }}
                                </small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.produtos.edit', $produto) }}" 
                                       class="btn btn-sm btn-outline-primary"
                                       data-bs-toggle="tooltip" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-info"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalVisualizacao{{ $produto->id }}"
                                            title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    <form method="POST" action="{{ route('admin.produtos.destroy', $produto) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="confirmarExclusao(this, 'Excluir produto?')"
                                                data-bs-toggle="tooltip" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal de Imagem --}}
                        @if($produto->imagem)
                        <div class="modal fade" id="modalImagem{{ $produto->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $produto->nome }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset($produto->imagem) }}" 
                                             alt="{{ $produto->nome }}" 
                                             class="img-fluid rounded">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Modal de Visualização --}}
                        <div class="modal fade" id="modalVisualizacao{{ $produto->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $produto->nome }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                @if($produto->imagem)
                                                    <img src="{{ asset($produto->imagem) }}" 
                                                         alt="{{ $produto->nome }}" 
                                                         class="img-fluid rounded">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                         style="height: 300px;">
                                                        <i class="fas fa-image fa-3x text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-7">
                                                <h4 class="fw-bold mb-3">{{ $produto->nome }}</h4>
                                                <p class="text-muted mb-3">{{ $produto->descricao }}</p>
                                                
                                                <div class="mb-3">
                                                    <span class="badge bg-success fs-5">
                                                        R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                                    </span>
                                                </div>
                                                
                                                <hr>
                                                
                                                <div class="row text-center">
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Criado em</small>
                                                        <strong>{{ $produto->created_at->format('d/m/Y') }}</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Atualizado em</small>
                                                        <strong>{{ $produto->updated_at->format('d/m/Y') }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                        <a href="{{ route('admin.produtos.edit', $produto) }}" class="btn btn-warning">
                                            <i class="fas fa-edit me-2"></i>Editar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Paginação --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $produtos->links() }}
    </div>
@else
    {{-- Estado Vazio --}}
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-gift fa-5x text-muted mb-4"></i>
            <h4 class="fw-bold mb-3">Nenhum produto cadastrado</h4>
            <p class="text-muted mb-4">
                Comece adicionando seu primeiro produto ao catálogo. 
                É fácil e rápido!
            </p>
            <a href="{{ route('admin.produtos.create') }}" class="btn btn-warning btn-lg">
                <i class="fas fa-plus me-2"></i>Adicionar Primeiro Produto
            </a>
        </div>
    </div>
@endif

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Filtro de busca em tempo real
        $('#filtroNome').on('keyup', function() {
            var table = $('#produtosTable').DataTable();
            table.search(this.value).draw();
        });

        // Filtros de ordenação
        $('#filtroOrdem').on('change', function() {
            var table = $('#produtosTable').DataTable();
            var valor = this.value;
            
            switch(valor) {
                case 'nome_asc':
                    table.order([1, 'asc']).draw();
                    break;
                case 'nome_desc':
                    table.order([1, 'desc']).draw();
                    break;
                case 'preco_asc':
                    table.order([3, 'asc']).draw();
                    break;
                case 'preco_desc':
                    table.order([3, 'desc']).draw();
                    break;
                case 'data_desc':
                    table.order([4, 'desc']).draw();
                    break;
            }
        });
    });

    function limparFiltros() {
        $('#filtroNome').val('');
        $('#filtroOrdem').val('');
        $('#filtroPreco').val('');
        
        var table = $('#produtosTable').DataTable();
        table.search('').order([4, 'desc']).draw();
    }
</script>
@endsection
