@extends('layouts.app')

@section('title', 'Solicitar Orçamento')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-4 mb-3">Solicitar Orçamento</h1>
                <p class="lead text-muted">Preencha o formulário abaixo e receba um orçamento personalizado para seu evento</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <form action="{{ route('orcamentos.store') }}" method="POST" id="orcamentoForm">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-12">
                                <h4 class="mb-3"><i class="fas fa-user text-primary me-2"></i>Dados Pessoais</h4>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="nome" class="form-label">Nome Completo *</label>
                                <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                                       id="nome" name="nome" value="{{ old('nome') }}" required>
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">E-mail *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone *</label>
                                <input type="tel" class="form-control @error('telefone') is-invalid @enderror" 
                                       id="telefone" name="telefone" value="{{ old('telefone') }}" required>
                                @error('telefone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row mb-4">
                            <div class="col-12">
                                <h4 class="mb-3"><i class="fas fa-calendar-alt text-primary me-2"></i>Detalhes do Evento</h4>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="data_evento" class="form-label">Data do Evento *</label>
                                <input type="date" class="form-control @error('data_evento') is-invalid @enderror" 
                                       id="data_evento" name="data_evento" value="{{ old('data_evento') }}" 
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                @error('data_evento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="numero_pessoas" class="form-label">Número de Pessoas *</label>
                                <input type="number" class="form-control @error('numero_pessoas') is-invalid @enderror" 
                                       id="numero_pessoas" name="numero_pessoas" value="{{ old('numero_pessoas') }}" 
                                       min="1" max="10000" required>
                                @error('numero_pessoas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <label for="local_evento" class="form-label">Local do Evento *</label>
                                <textarea class="form-control @error('local_evento') is-invalid @enderror" 
                                          id="local_evento" name="local_evento" rows="2" required>{{ old('local_evento') }}</textarea>
                                @error('local_evento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row mb-4">
                            <div class="col-12">
                                <h4 class="mb-3"><i class="fas fa-shopping-cart text-primary me-2"></i>Produtos Desejados</h4>
                                <p class="text-muted">Selecione os produtos que você gostaria de incluir em seu orçamento:</p>
                            </div>
                        </div>

                        <div id="produtos-container">
                            @if($produtos->count() > 0)
                                <div class="row">
                                    @foreach($produtos as $produto)
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="card h-100 produto-card" style="cursor: pointer;">
                                            @if($produto->imagem)
                                            <img src="{{ asset('storage/' . $produto->imagem) }}" 
                                                 class="card-img-top" alt="{{ $produto->nome }}" 
                                                 style="height: 200px; object-fit: cover;">
                                            @else
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                                 style="height: 200px;">
                                                <i class="fas fa-image fa-3x text-muted"></i>
                                            </div>
                                            @endif
                                            
                                            <div class="card-body">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input produto-check" type="checkbox" 
                                                           name="produtos[]" value="{{ $produto->id }}" 
                                                           id="produto_{{ $produto->id }}">
                                                    <label class="form-check-label fw-bold" for="produto_{{ $produto->id }}">
                                                        {{ $produto->nome }}
                                                    </label>
                                                </div>
                                                
                                                @if($produto->descricao)
                                                <p class="text-muted small mb-3">{{ Str::limit($produto->descricao, 100) }}</p>
                                                @endif
                                                
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <span class="h5 text-primary mb-0">{{ $produto->preco_formatado }}</span>
                                                </div>
                                                
                                                <div class="produto-detalhes" style="display: none;">
                                                    <div class="row align-items-center">
                                                        <div class="col-6">
                                                            <label class="form-label small">Quantidade:</label>
                                                            <input type="number" class="form-control form-control-sm quantidade-input" 
                                                                   name="quantidades[]" value="1" min="1" max="1000">
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="text-end">
                                                                <small class="text-muted">Total:</small><br>
                                                                <span class="fw-bold text-success preco-display">{{ $produto->preco_formatado }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Nenhum produto disponível no momento. Entre em contato conosco para mais informações.
                                </div>
                            @endif
                        </div>

                        @error('produtos')
                            <div class="text-danger small mb-3">{{ $message }}</div>
                        @enderror

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Valor Total Estimado</h5>
                                        <h2 class="text-primary mb-0" id="valor-total">R$ 0,00</h2>
                                        <small class="text-muted">*Valor sujeito a alterações após análise</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row mb-4">
                            <div class="col-12">
                                <label for="observacoes" class="form-label">Observações Adicionais</label>
                                <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                                          id="observacoes" name="observacoes" rows="4" 
                                          placeholder="Descreva detalhes específicos do seu evento, preferências especiais ou qualquer informação adicional...">{{ old('observacoes') }}</textarea>
                                @error('observacoes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-paper-plane me-2"></i>Solicitar Orçamento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.produto-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.produto-card:hover {
    border-color: var(--bs-primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.produto-card.selected {
    border-color: var(--bs-primary);
    background-color: rgba(var(--bs-primary-rgb), 0.05);
}

.form-check-input:checked + .form-check-label {
    color: var(--bs-primary);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('orcamentoForm');
    const numeroPessoas = document.getElementById('numero_pessoas');
    const valorTotal = document.getElementById('valor-total');
    
    // Máscara de telefone
    const telefone = document.getElementById('telefone');
    telefone.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0) {
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
            } else {
                value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            }
        }
        e.target.value = value;
    });

    // Gerenciar seleção de produtos
    document.querySelectorAll('.produto-card').forEach(card => {
        const checkbox = card.querySelector('.produto-check');
        const detalhes = card.querySelector('.produto-detalhes');
        const quantidadeInput = card.querySelector('.quantidade-input');
        const precoDisplay = card.querySelector('.preco-display');

        card.addEventListener('click', function(e) {
            if (e.target.type !== 'checkbox' && e.target.type !== 'number') {
                checkbox.checked = !checkbox.checked;
                toggleProduto();
            }
        });

        checkbox.addEventListener('change', toggleProduto);
        quantidadeInput.addEventListener('input', calcularPrecoProduto);

        function toggleProduto() {
            if (checkbox.checked) {
                card.classList.add('selected');
                detalhes.style.display = 'block';
                calcularPrecoProduto();
            } else {
                card.classList.remove('selected');
                detalhes.style.display = 'none';
                precoDisplay.textContent = 'R$ 0,00';
            }
            calcularTotal();
        }

        function calcularPrecoProduto() {
            if (!checkbox.checked) return;

            const produtoId = checkbox.value;
            const quantidade = quantidadeInput.value || 1;

            fetch('{{ route("orcamentos.buscar-preco") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    produto_id: produtoId,
                    quantidade: quantidade
                })
            })
            .then(response => response.json())
            .then(data => {
                precoDisplay.textContent = data.total_formatado;
                calcularTotal();
            })
            .catch(error => {
                console.error('Erro ao calcular preço:', error);
                precoDisplay.textContent = 'Erro';
            });
        }
    });

    function calcularTotal() {
        let total = 0;
        document.querySelectorAll('.produto-card.selected .preco-display').forEach(display => {
            const valor = display.textContent.replace(/[R$\s.]/g, '').replace(',', '.');
            if (!isNaN(valor) && valor !== '') {
                total += parseFloat(valor);
            }
        });
        
        valorTotal.textContent = 'R$ ' + total.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Validação do formulário
    form.addEventListener('submit', function(e) {
        const produtosSelecionados = document.querySelectorAll('.produto-check:checked');
        if (produtosSelecionados.length === 0) {
            e.preventDefault();
            alert('Por favor, selecione pelo menos um produto.');
            return false;
        }
    });
});
</script>
@endsection
