@extends('layouts.app')

@section('title', 'Solicitar Orçamento')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp
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

                        <div class="row mb-4">
                            <div class="col-12">
                                <h4 class="mb-3"><i class="fas fa-shopping-cart text-primary me-2"></i>Produtos Selecionados</h4>
                                <p class="text-muted mb-2">
                                    Esses são os itens que você adicionou ao carrinho. Ajuste as quantidades antes de solicitar o orçamento.
                                </p>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Precisa alterar os itens? <a href="{{ route('carrinho.index') }}" class="text-decoration-none">volte ao carrinho</a>.
                                </p>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Produto</th>
                                                <th class="text-center" style="width: 140px;">Quantidade</th>
                                                <th class="text-end" style="width: 160px;">Preço unitário</th>
                                                <th class="text-end" style="width: 160px;">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($itensCarrinho as $item)
                                                @php
                                                    $imagem = $item['imagem'];
                                                    $imagemUrl = $imagem
                                                        ? (Str::startsWith($imagem, ['http://', 'https://'])
                                                            ? $imagem
                                                            : (Str::startsWith($imagem, 'storage/')
                                                                ? asset($imagem)
                                                                : asset('storage/' . ltrim($imagem, '/'))))
                                                        : asset('images/produto1.jpg');
                                                    $quantidadeAtual = old('quantidades.' . $item['id'], $item['quantidade']);
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="produtos[]" value="{{ $item['id'] }}">
                                                        <div class="d-flex align-items-start">
                                                            <img src="{{ $imagemUrl }}" alt="{{ $item['nome'] }}" class="carrinho-produto-img me-3">
                                                            <div>
                                                                <h5 class="fw-bold mb-1">{{ $item['nome'] }}</h5>
                                                                @if(!empty($item['descricao']))
                                                                    <p class="text-muted small mb-0">{{ Str::limit($item['descricao'], 120) }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="number" 
                                                               name="quantidades[{{ $item['id'] }}]" 
                                                               value="{{ $quantidadeAtual }}" 
                                                               min="1" max="1000" 
                                                               class="form-control form-control-sm campo-quantidade" 
                                                               data-preco="{{ $item['preco'] }}" 
                                                               data-item="{{ $item['id'] }}">
                                                        @error('quantidades.' . $item['id'])
                                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                    <td class="text-end">R$ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                                                    <td class="text-end">
                                                        <span class="fw-bold text-success" data-subtotal-for="{{ $item['id'] }}">
                                                            R$ {{ number_format($item['subtotal'], 2, ',', '.') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @error('produtos')
                            <div class="text-danger small mb-3">{{ $message }}</div>
                        @enderror

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Valor Total Estimado</h5>
                                        <h2 class="text-primary mb-0" id="valor-total">R$ {{ number_format($valorEstimado, 2, ',', '.') }}</h2>
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
.carrinho-produto-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 0.75rem;
}

.table thead th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.05em;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const valorTotal = document.getElementById('valor-total');
    const telefone = document.getElementById('telefone');
    const quantidadeInputs = document.querySelectorAll('.campo-quantidade');
    const moedaBR = new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    if (telefone) {
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
    }

    function atualizarTotais() {
        let total = 0;

        quantidadeInputs.forEach((input) => {
            const preco = parseFloat(input.dataset.preco);
            const quantidade = parseInt(input.value, 10) || 0;
            const subtotal = preco * quantidade;
            total += subtotal;

            const subtotalEl = document.querySelector(`[data-subtotal-for="${input.dataset.item}"]`);
            if (subtotalEl) {
                subtotalEl.textContent = `R$ ${moedaBR.format(subtotal)}`;
            }
        });

        if (valorTotal) {
            valorTotal.textContent = `R$ ${moedaBR.format(total)}`;
        }
    }

    quantidadeInputs.forEach((input) => {
        input.addEventListener('input', atualizarTotais);
        input.addEventListener('change', atualizarTotais);
    });

    atualizarTotais();
});
</script>
@endsection
