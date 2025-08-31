@extends('layouts.app')

@section('title', $galeria->titulo . ' - Detalhes')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('pagina-Inicial') }}">Início</a></li>
            <li class="breadcrumb-item"><a href="{{ route('galeria') }}">Galeria</a></li>
            <li class="breadcrumb-item active">{{ $galeria->titulo }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Imagem Principal -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg mb-4">
                <div class="position-relative">
                    @if($galeria->imagem && file_exists(public_path($galeria->imagem)))
                        <img src="{{ asset($galeria->imagem) }}" alt="{{ $galeria->titulo }}" 
                             class="card-img-top detail-image">
                    @else
                        <div class="placeholder-detail-image bg-light d-flex align-items-center justify-content-center">
                            <i class="fas fa-image text-muted fa-5x"></i>
                        </div>
                    @endif
                    
                    @if($galeria->destaque)
                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-3 fs-6">
                            <i class="fas fa-star me-2"></i>Trabalho em Destaque
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informações -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h1 class="h2 fw-bold mb-3">{{ $galeria->titulo }}</h1>
                    
                    <div class="mb-3">
                        <span class="badge bg-primary fs-6 px-3 py-2">
                            <i class="fas fa-tag me-2"></i>{{ $galeria->categoria }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <h3 class="h5 fw-bold mb-2">
                            <i class="fas fa-info-circle me-2 text-primary"></i>Descrição
                        </h3>
                        <p class="text-muted lh-base">{{ $galeria->descricao }}</p>
                    </div>

                    @if($galeria->tags && count($galeria->tags) > 0)
                        <div class="mb-4">
                            <h3 class="h5 fw-bold mb-3">
                                <i class="fas fa-tags me-2 text-primary"></i>Tags
                            </h3>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($galeria->tags as $tag)
                                    <span class="badge bg-light text-dark border">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mb-4">
                        <h3 class="h5 fw-bold mb-3">
                            <i class="fas fa-calendar me-2 text-primary"></i>Realizado em
                        </h3>
                        <p class="text-muted">{{ $galeria->created_at->format('F Y') }}</p>
                    </div>

                    <!-- Call to Action -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('contato') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-envelope me-2"></i>Solicitar Orçamento
                        </a>
                        <a href="{{ route('galeria') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Voltar à Galeria
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trabalhos Relacionados -->
    @if($relacionados->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h2 class="h3 fw-bold mb-4">
                    <i class="fas fa-images me-2"></i>Trabalhos Similares
                </h2>
                <div class="row g-4">
                    @foreach($relacionados as $relacionado)
                        <div class="col-lg-4 col-md-6">
                            <div class="card gallery-card h-100 shadow-sm">
                                <div class="position-relative overflow-hidden">
                                    @if($relacionado->imagem && file_exists(public_path($relacionado->imagem)))
                                        <img src="{{ asset($relacionado->imagem) }}" alt="{{ $relacionado->titulo }}" 
                                             class="card-img-top related-image">
                                    @else
                                        <div class="placeholder-related-image bg-light d-flex align-items-center justify-content-center">
                                            <i class="fas fa-image text-muted fa-2x"></i>
                                        </div>
                                    @endif
                                    <div class="gallery-overlay">
                                        <div class="overlay-content">
                                            <a href="{{ route('galeria.show', $relacionado) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye me-2"></i>Ver Detalhes
                                            </a>
                                        </div>
                                    </div>
                                    @if($relacionado->destaque)
                                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">
                                            <i class="fas fa-star me-1"></i>
                                        </span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $relacionado->titulo }}</h5>
                                    <p class="card-text text-muted small">{{ Str::limit($relacionado->descricao, 80) }}</p>
                                    <span class="badge bg-primary">{{ $relacionado->categoria }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Depoimentos da Categoria -->
    @if($depoimentosCategoria->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h2 class="h3 fw-bold mb-4">
                    <i class="fas fa-comments me-2"></i>O que nossos clientes dizem sobre {{ $galeria->categoria }}
                </h2>
                <div class="row g-4">
                    @foreach($depoimentosCategoria as $depoimento)
                        <div class="col-lg-6">
                            <div class="card testimonial-card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        @if($depoimento->foto_cliente && file_exists(public_path($depoimento->foto_cliente)))
                                            <img src="{{ asset($depoimento->foto_cliente) }}" alt="{{ $depoimento->nome_cliente }}" 
                                                 class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 50px; height: 50px;">
                                                <span class="text-white fw-bold">
                                                    {{ strtoupper(substr($depoimento->nome_cliente, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="fw-bold mb-1">{{ $depoimento->nome_cliente }}</h6>
                                            <div class="text-warning">
                                                {!! $depoimento->getEstrelas() !!}
                                            </div>
                                        </div>
                                    </div>
                                    <blockquote class="blockquote mb-0">
                                        <p class="text-muted fst-italic">{{ $depoimento->depoimento }}</p>
                                    </blockquote>
                                    @if($depoimento->data_evento)
                                        <small class="text-muted">
                                            Evento realizado em {{ \Carbon\Carbon::parse($depoimento->data_evento)->format('M/Y') }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('galeria.depoimentos') }}" class="btn btn-outline-primary">
                        <i class="fas fa-comments me-2"></i>Ver Todos os Depoimentos
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.detail-image {
    width: 100%;
    height: 500px;
    object-fit: cover;
    border-radius: 15px;
}

.placeholder-detail-image {
    width: 100%;
    height: 500px;
    border-radius: 15px;
}

.related-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.placeholder-related-image {
    width: 100%;
    height: 200px;
}

.gallery-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
}

.gallery-card:hover .related-image {
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

.testimonial-card {
    border-radius: 15px;
    transition: transform 0.3s ease;
}

.testimonial-card:hover {
    transform: translateY(-3px);
}

.breadcrumb {
    background: none;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    color: var(--bs-primary);
}

@media (max-width: 768px) {
    .detail-image {
        height: 300px;
    }
    
    .placeholder-detail-image {
        height: 300px;
    }
}
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Animação de entrada
    $('.card').each(function(index) {
        $(this).css('animation-delay', (index * 0.2) + 's');
        $(this).addClass('animate__animated animate__fadeInUp');
    });
    
    // Smooth scroll para âncoras
    $('a[href^="#"]').on('click', function(event) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 800);
        }
    });
});
</script>
@endsection
