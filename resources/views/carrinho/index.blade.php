@extends('layouts.app')

@section('title', 'Meu Carrinho')

@section('content')
    <section class="page-header py-5 mb-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-5 fw-bold mb-2">
                        <i class="fas fa-shopping-cart text-warning me-3"></i>
                        Meu Carrinho
                    </h1>
                    <p class="lead text-muted mb-0">Revise os produtos escolhidos antes de solicitar seu orçamento.</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('catalogo') }}" class="btn btn-outline-warning">
                        <i class="fas fa-arrow-left me-2"></i>Voltar ao catálogo
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="container pb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($itens->isEmpty())
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                    <h3 class="fw-bold mb-3">Seu carrinho está vazio</h3>
                    <p class="text-muted mb-4">Explore nossos produtos e adicione suas opções favoritas para solicitar um orçamento personalizado.</p>
                    <a href="{{ route('catalogo') }}" class="btn btn-warning btn-lg px-4">
                        <i class="fas fa-gift me-2"></i>Ver catálogo
                    </a>
                </div>
            </div>
        @else
            <div class="row g-4">
                <div class="col-lg-8">
                    @foreach($itens as $item)
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        @php
                                            $imagem = $item['imagem'];
                                            $imagemUrl = $imagem
                                                ? (\Illuminate\Support\Str::startsWith($imagem, ['http://', 'https://'])
                                                    ? $imagem
                                                    : (\Illuminate\Support\Str::startsWith($imagem, 'storage/')
                                                        ? asset($imagem)
                                                        : asset('storage/' . ltrim($imagem, '/'))))
                                                : asset('images/produto1.jpg');
                                        @endphp
                                        <img src="{{ $imagemUrl }}" alt="{{ $item['nome'] }}" class="img-fluid rounded">
                                    </div>
                                    <div class="col-md-5 mt-3 mt-md-0">
                                        <h5 class="fw-bold mb-2">{{ $item['nome'] }}</h5>
                                        @if(!empty($item['descricao']))
                                            <p class="text-muted mb-2">{{ \Illuminate\Support\Str::limit($item['descricao'], 120) }}</p>
                                        @endif
                                        <p class="mb-0"><strong>Preço unitário:</strong> R$ {{ number_format($item['preco'], 2, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-4 mt-3 mt-md-0">
                                        <form action="{{ route('carrinho.atualizar', $item['id']) }}" method="POST" class="d-flex align-items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <label for="quantidade_{{ $item['id'] }}" class="form-label mb-0 small text-muted">Quantidade</label>
                                            <input type="number" id="quantidade_{{ $item['id'] }}" name="quantidade" value="{{ $item['quantidade'] }}" min="1" max="1000" class="form-control" style="max-width: 90px;">
                                            <button type="submit" class="btn btn-outline-secondary btn-sm">Atualizar</button>
                                        </form>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <span class="fw-bold">Subtotal:</span>
                                            <span class="text-success fw-bold">R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</span>
                                        </div>
                                        <form action="{{ route('carrinho.remover', $item['id']) }}" method="POST" class="mt-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-0"><i class="fas fa-trash me-1"></i>Remover</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
                        <div class="card-body">
                            <h4 class="fw-bold mb-3">Resumo do pedido</h4>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Itens selecionados</span>
                                <span>{{ $itens->sum('quantidade') }}</span>
                            </div>
                            <div class="d-flex justify-content-between fw-bold h5">
                                <span>Total estimado</span>
                                <span>R$ {{ number_format($total, 2, ',', '.') }}</span>
                            </div>
                            <p class="small text-muted">*Valores indicativos para estimativa. O orçamento final será enviado por e-mail.</p>

                            <a href="{{ route('orcamentos.create') }}" class="btn btn-warning w-100 btn-lg mt-3">
                                <i class="fas fa-file-invoice me-2"></i>Solicitar orçamento
                            </a>

                            <form action="{{ route('carrinho.limpar') }}" method="POST" class="mt-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-times me-2"></i>Esvaziar carrinho
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
