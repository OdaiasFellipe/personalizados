@extends('admin.layout')

@section('title', 'Editar Produto')
@section('page-title', 'Editar Produto')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Editar Produto</h4>
                <p class="text-muted mb-0">ID: #{{ $produto->id }} | Criado em {{ $produto->created_at->format('d/m/Y') }}</p>
            </div>
            <div class="btn-group">
                <a href="{{ route('admin.produtos') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar
                </a>
                <button type="button" class="btn btn-outline-danger" onclick="confirmarExclusao()">
                    <i class="fas fa-trash me-2"></i>Excluir
                </button>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('admin.produtos.update', $produto) }}" method="POST" enctype="multipart/form-data" id="formProduto">
    @csrf
    @method('PUT')
    
    <div class="row g-4">
        {{-- Informações Básicas --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle text-warning me-2"></i>
                        Informações Básicas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="nome" class="form-label fw-semibold">
                                Nome do Produto <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nome') is-invalid @enderror" 
                                   id="nome" 
                                   name="nome" 
                                   value="{{ old('nome', $produto->nome) }}" 
                                   required
                                   placeholder="Ex: Convite Personalizado Festa Unicórnio">
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <label for="descricao" class="form-label fw-semibold">
                                Descrição <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                      id="descricao" 
                                      name="descricao" 
                                      rows="5" 
                                      required
                                      placeholder="Descreva detalhadamente o produto...">{{ old('descricao', $produto->descricao) }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <span id="contadorCaracteres">{{ strlen($produto->descricao) }}</span> caracteres
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="preco" class="form-label fw-semibold">
                                Preço <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="number" 
                                       class="form-control @error('preco') is-invalid @enderror" 
                                       id="preco" 
                                       name="preco" 
                                       value="{{ old('preco', $produto->preco) }}" 
                                       step="0.01" 
                                       min="0" 
                                       required
                                       placeholder="0,00">
                            </div>
                            @error('preco')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Visualização do Preço</label>
                            <div class="form-control-static">
                                <span class="badge bg-success fs-6" id="precoFormatado">
                                    R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Histórico de Alterações --}}
            <div class="card mt-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history text-info me-2"></i>
                        Histórico
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <i class="fas fa-calendar-plus text-success fa-2x mb-2"></i>
                                <h6 class="fw-bold">Criado</h6>
                                <p class="text-muted mb-0">{{ $produto->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <i class="fas fa-calendar-edit text-warning fa-2x mb-2"></i>
                            <h6 class="fw-bold">Última Edição</h6>
                            <p class="text-muted mb-0">{{ $produto->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Imagem Atual e Nova --}}
        <div class="col-lg-4">
            {{-- Imagem Atual --}}
            @if($produto->imagem)
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-image text-success me-2"></i>
                        Imagem Atual
                    </h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset($produto->imagem) }}" 
                         alt="{{ $produto->nome }}" 
                         class="img-fluid rounded shadow mb-3"
                         style="max-height: 200px;"
                         data-bs-toggle="modal" 
                         data-bs-target="#modalImagemAtual"
                         style="cursor: pointer;">
                    
                    <button type="button" class="btn btn-outline-info btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalImagemAtual">
                        <i class="fas fa-search-plus me-1"></i>Ampliar
                    </button>
                </div>
            </div>
            @endif
            
            {{-- Nova Imagem --}}
            <div class="card mt-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-upload text-warning me-2"></i>
                        {{ $produto->imagem ? 'Alterar Imagem' : 'Adicionar Imagem' }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="imagem" class="form-label fw-semibold">
                            Nova Imagem {{ !$produto->imagem ? '*' : '' }}
                        </label>
                        <input type="file" 
                               class="form-control @error('imagem') is-invalid @enderror" 
                               id="imagem" 
                               name="imagem" 
                               accept="image/*" 
                               {{ !$produto->imagem ? 'required' : '' }}
                               onchange="previewImagem(this, 'imagemPreview')">
                        @error('imagem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            {{ $produto->imagem ? 'Deixe em branco para manter a imagem atual' : 'Selecione uma imagem' }}
                        </div>
                    </div>
                    
                    {{-- Preview da Nova Imagem --}}
                    <div class="text-center">
                        <img id="imagemPreview" 
                             src="#" 
                             alt="Preview" 
                             class="img-fluid rounded shadow"
                             style="display: none; max-height: 200px;">
                        
                        <div id="imagemPlaceholder" class="border border-dashed border-2 rounded p-3 text-center text-muted">
                            <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                            <p class="mb-0 small">Selecione para preview</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Botões de Ação --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            <i class="fas fa-save me-1"></i>
                            <small>As alterações serão salvas imediatamente</small>
                        </div>
                        
                        <div class="btn-group">
                            <a href="{{ route('admin.produtos') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            
                            <button type="button" class="btn btn-outline-primary" onclick="visualizarProduto()">
                                <i class="fas fa-eye me-2"></i>Prévia
                            </button>
                            
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Salvar Alterações
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Modal Imagem Atual --}}
@if($produto->imagem)
<div class="modal fade" id="modalImagemAtual" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $produto->nome }} - Imagem Atual</h5>
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

{{-- Modal de Prévia --}}
<div class="modal fade" id="modalPrevia" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye text-warning me-2"></i>
                    Prévia das Alterações
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <img id="previaImagem" src="{{ asset($produto->imagem) }}" alt="Produto" class="img-fluid rounded">
                    </div>
                    <div class="col-md-7">
                        <h4 class="fw-bold mb-3" id="previaNome">{{ $produto->nome }}</h4>
                        <p class="text-muted mb-3" id="previaDescricao">{{ $produto->descricao }}</p>
                        <div class="mb-3">
                            <span class="badge bg-success fs-5" id="previaPreco">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Esta é uma prévia de como o produto aparecerá após as alterações.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-warning" onclick="salvarProduto()">
                    <i class="fas fa-save me-2"></i>Salvar Alterações
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Form de Exclusão --}}
<form id="formExclusao" action="{{ route('admin.produtos.destroy', $produto) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Contador de caracteres
        $('#descricao').on('input', function() {
            var count = $(this).val().length;
            $('#contadorCaracteres').text(count);
        });
        
        // Formatação de preço em tempo real
        $('#preco').on('input', function() {
            var valor = parseFloat($(this).val()) || 0;
            var formatado = valor.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
            $('#precoFormatado').text(formatado);
        });
    });
    
    function visualizarProduto() {
        var nome = $('#nome').val();
        var descricao = $('#descricao').val();
        var preco = parseFloat($('#preco').val()) || 0;
        var novaImagem = $('#imagemPreview').attr('src');
        
        $('#previaNome').text(nome);
        $('#previaDescricao').text(descricao);
        $('#previaPreco').text(preco.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }));
        
        // Se há nova imagem, usar ela, senão manter a atual
        if (novaImagem && novaImagem !== '#') {
            $('#previaImagem').attr('src', novaImagem);
        }
        
        new bootstrap.Modal(document.getElementById('modalPrevia')).show();
    }
    
    function salvarProduto() {
        $('#formProduto').submit();
    }
    
    function confirmarExclusao() {
        Swal.fire({
            title: 'Excluir produto?',
            text: 'Esta ação não pode ser desfeita! O produto será removido permanentemente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#formExclusao').submit();
            }
        });
    }
</script>
@endsection
