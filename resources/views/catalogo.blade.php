@extends('layouts.app')

@section('title', 'Catálogo - NE Fotografias e Personalizados')

@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp
    {{-- Header da página --}}
    <section class="page-header py-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-gift text-warning me-3"></i>
                        Nossos Produtos
                    </h1>
                    <p class="lead text-muted">Descubra nossa coleção especial para festas de aniversário</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Filtros e busca --}}
    <section class="filter-section mb-5">
        <div class="container">
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

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        <input type="text" class="form-control" placeholder="Buscar produtos...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select">
                                        <option>Todos os produtos</option>
                                        <option>Decorações</option>
                                        <option>Lembrancinhas</option>
                                        <option>Convites</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-warning w-100">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                </div>
                            </div>
                            <hr class="my-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">
                                    Selecione os produtos e adicione ao carrinho para solicitar seu orçamento.
                                </span>
                                <a href="{{ route('carrinho.index') }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-shopping-cart me-2"></i>Ver carrinho
                                    <span class="badge bg-warning text-dark ms-2">{{ count($carrinho ?? []) }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Grid de produtos --}}
    <section class="products-grid">
        <div class="container">
            @if(isset($produtos) && $produtos->count() > 0)
                <div class="row g-4">
                    @foreach ($produtos as $produto)
                        <div class="col-lg-4 col-md-6">
                            <div class="product-card h-100">
                                <div class="product-image">
                                    @php
                                        $imagem = $produto->imagem;
                                        $imagemUrl = $imagem
                                            ? (Str::startsWith($imagem, ['http://', 'https://'])
                                                ? $imagem
                                                : (Str::startsWith($imagem, 'storage/')
                                                    ? asset($imagem)
                                                    : asset('storage/' . ltrim($imagem, '/'))))
                                            : asset('images/produto1.jpg');
                                    @endphp
                                    <img src="{{ $imagemUrl }}" 
                                         class="card-img-top" 
                                         alt="{{ $produto->nome }}"
                                         style="height: 250px; object-fit: cover;">
                                    <div class="product-overlay">
                                        <button class="btn btn-light btn-sm me-2">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-bold mb-2">{{ $produto->nome }}</h5>
                                    <p class="card-text text-muted mb-3">{{ Str::limit($produto->descricao, 80) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="price">
                                            <span class="h5 fw-bold text-warning mb-0">
                                                R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                    <form action="{{ route('carrinho.adicionar') }}" method="POST" class="mt-3">
                                        @csrf
                                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-sort-numeric-up"></i>
                                            </span>
                                            <input type="number" name="quantidade" class="form-control" min="1" max="1000" value="1" required>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-cart-plus me-1"></i>
                                                Adicionar
                                            </button>
                                        </div>
                                    </form>
                                    @if(isset($carrinho[$produto->id]))
                                        <p class="text-success small mt-2 mb-0">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Já no carrinho ({{ $carrinho[$produto->id]['quantidade'] }} unidade{{ $carrinho[$produto->id]['quantidade'] > 1 ? 's' : '' }})
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Estado vazio --}}
                <div class="row">
                    <div class="col-12">
                        <div class="empty-state text-center py-5">
                            <i class="fas fa-gift fa-5x text-muted mb-4"></i>
                            <h3 class="fw-bold mb-3">Ainda não temos produtos cadastrados</h3>
                            <p class="text-muted mb-4">Em breve teremos produtos incríveis para sua festa!</p>
                            <a href="{{ route('contato') }}" class="btn btn-warning btn-lg">
                                <i class="fas fa-envelope me-2"></i>
                                Entre em Contato
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Call to Action --}}
    <section class="py-5 mt-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h3 class="fw-bold mb-3">Não encontrou o que procurava?</h3>
                    <p class="text-muted mb-4">
                        Criamos produtos personalizados sob medida para sua festa. 
                        Entre em contato e vamos criar algo único para você!
                    </p>
                    <a href="{{ route('contato') }}" class="btn btn-warning btn-lg px-4">
                        <i class="fas fa-magic me-2"></i>
                        Produto Personalizado
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection