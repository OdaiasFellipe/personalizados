@extends('layouts.app')

@section('title', 'Galeria - Nossos Trabalhos')

@section('content')
<div class="hero-section bg-gradient-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Nossa Galeria</h1>
                <p class="lead mb-4">
                    Explore nossos trabalhos realizados e inspire-se para seu próximo evento especial.
                    Cada projeto é único e criado com amor e dedicação.
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-images display-1 opacity-75"></i>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-outline-primary filter-btn active" data-filter="*">
                    <i class="fas fa-th me-2"></i>Todos
                </button>
                @foreach($categorias as $categoria)
                    <button class="btn btn-outline-primary filter-btn" data-filter=".{{ Str::slug($categoria) }}">
                        <i class="fas fa-tag me-2"></i>{{ $categoria }}
                    </button>
                @endforeach
            </div>
        </div>
        <div class="col-lg-4">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" class="form-control" id="searchInput" placeholder="Buscar na galeria...">
            </div>
        </div>
    </div>

    <!-- Destaques -->
    @if($destaques->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="h3 fw-bold mb-4">
                    <i class="fas fa-star text-warning me-2"></i>Trabalhos em Destaque
                </h2>
                <div class="row g-4">
                    @foreach($destaques as $item)
                        <div class="col-lg-4 col-md-6">
                            <div class="card gallery-card h-100 shadow-sm {{ Str::slug($item->categoria) }}" 
                                 data-title="{{ strtolower($item->titulo) }}" 
                                 data-tags="{{ strtolower(implode(' ', $item->tags ?? [])) }}">
                                <div class="position-relative overflow-hidden">
                                    @if($item->imagem && file_exists(public_path($item->imagem)))
                                        <img src="{{ asset($item->imagem) }}" alt="{{ $item->titulo }}" 
                                             class="card-img-top gallery-image">
                                    @else
                                        <div class="placeholder-image bg-light d-flex align-items-center justify-content-center">
                                            <i class="fas fa-image text-muted fa-3x"></i>
                                        </div>
                                    @endif
                                    <div class="gallery-overlay">
                                        <div class="overlay-content">
                                            <a href="{{ route('galeria.show', $item) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye me-2"></i>Ver Detalhes
                                            </a>
                                        </div>
                                    </div>
                                    <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">
                                        <i class="fas fa-star me-1"></i>Destaque
                                    </span>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->titulo }}</h5>
                                    <p class="card-text text-muted small">{{ Str::limit($item->descricao, 100) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-primary">{{ $item->categoria }}</span>
                                        @if($item->tags && count($item->tags) > 0)
                                            <small class="text-muted">
                                                <i class="fas fa-tags me-1"></i>
                                                {{ implode(', ', array_slice($item->tags, 0, 2)) }}
                                                @if(count($item->tags) > 2)
                                                    +{{ count($item->tags) - 2 }}
                                                @endif
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Todos os Trabalhos -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h3 fw-bold">
                <i class="fas fa-th-large me-2"></i>Todos os Trabalhos
            </h2>
        </div>
    </div>

    <div class="row g-4" id="galleryGrid">
        @foreach($galeria as $item)
            <div class="col-lg-4 col-md-6 gallery-item {{ Str::slug($item->categoria) }}" 
                 data-title="{{ strtolower($item->titulo) }}" 
                 data-tags="{{ strtolower(implode(' ', $item->tags ?? [])) }}">
                <div class="card gallery-card h-100 shadow-sm">
                    <div class="position-relative overflow-hidden">
                        @if($item->imagem && file_exists(public_path($item->imagem)))
                            <img src="{{ asset($item->imagem) }}" alt="{{ $item->titulo }}" 
                                 class="card-img-top gallery-image">
                        @else
                            <div class="placeholder-image bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-image text-muted fa-3x"></i>
                            </div>
                        @endif
                        <div class="gallery-overlay">
                            <div class="overlay-content">
                                <a href="{{ route('galeria.show', $item) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye me-2"></i>Ver Detalhes
                                </a>
                            </div>
                        </div>
                        @if($item->destaque)
                            <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">
                                <i class="fas fa-star me-1"></i>Destaque
                            </span>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->titulo }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($item->descricao, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary">{{ $item->categoria }}</span>
                            @if($item->tags && count($item->tags) > 0)
                                <small class="text-muted">
                                    <i class="fas fa-tags me-1"></i>
                                    {{ implode(', ', array_slice($item->tags, 0, 2)) }}
                                    @if(count($item->tags) > 2)
                                        +{{ count($item->tags) - 2 }}
                                    @endif
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($galeria->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-images text-muted display-1 mb-3"></i>
            <h3 class="text-muted">Galeria em Construção</h3>
            <p class="text-muted">Em breve você poderá ver nossos trabalhos incríveis aqui!</p>
        </div>
    @endif

    <!-- Paginação -->
    @if($galeria->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $galeria->links() }}
        </div>
    @endif
</div>

<!-- Call to Action -->
<section class="bg-gradient-primary text-white py-5 mt-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Gostou do Nosso Trabalho?</h2>
        <p class="lead mb-4">
            Entre em contato conosco e vamos criar algo incrível para seu próximo evento!
        </p>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('contato') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-envelope me-2"></i>Fale Conosco
                    </a>
                    <a href="{{ route('catalogo') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-gift me-2"></i>Ver Produtos
                    </a>
                    <a href="{{ route('galeria.depoimentos') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-comments me-2"></i>Depoimentos
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.gallery-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 15px;
    overflow: hidden;
}

.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
}

.gallery-card:hover .gallery-image {
    transform: scale(1.05);
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-card:hover .gallery-overlay {
    opacity: 1;
}

.placeholder-image {
    width: 100%;
    height: 250px;
}

.filter-btn {
    border-radius: 25px;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

.filter-btn.active {
    background-color: var(--bs-primary);
    color: white;
    border-color: var(--bs-primary);
}

.gallery-item {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.gallery-item.hidden {
    opacity: 0;
    transform: scale(0.8);
    pointer-events: none;
}

.hero-section {
    background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-info) 100%);
}

@media (max-width: 768px) {
    .gallery-image {
        height: 200px;
    }
    
    .filter-btn {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Filtro por categoria
    $('.filter-btn').click(function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        
        const filterValue = $(this).data('filter');
        
        if (filterValue === '*') {
            $('.gallery-item').removeClass('hidden');
        } else {
            $('.gallery-item').addClass('hidden');
            $(filterValue).removeClass('hidden');
        }
    });
    
    // Busca em tempo real
    $('#searchInput').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        
        $('.gallery-item').each(function() {
            const title = $(this).data('title');
            const tags = $(this).data('tags');
            
            if (title.includes(searchTerm) || tags.includes(searchTerm)) {
                $(this).removeClass('hidden');
            } else {
                $(this).addClass('hidden');
            }
        });
        
        // Se há busca ativa, desativar filtros de categoria
        if (searchTerm.length > 0) {
            $('.filter-btn').removeClass('active');
        }
    });
    
    // Animação de entrada
    function animateCards() {
        $('.gallery-card').each(function(index) {
            $(this).css('animation-delay', (index * 0.1) + 's');
            $(this).addClass('animate__animated animate__fadeInUp');
        });
    }
    
    // Lazy loading de imagens
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Inicializar animações
    setTimeout(animateCards, 100);
});
</script>
@endsection
