@extends('layouts.app')

@section('title', 'Depoimentos - O que nossos clientes dizem')

@section('content')
<div class="hero-section bg-gradient-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Depoimentos</h1>
                <p class="lead mb-4">
                    Veja o que nossos clientes falam sobre nossos serviços e como tornamos seus eventos inesquecíveis.
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-comments display-1 opacity-75"></i>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <!-- Estatísticas -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-4">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="fw-bold text-primary mb-1">{{ $totalDepoimentos }}</h3>
                                <p class="text-muted mb-0">Depoimentos</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="fw-bold text-warning mb-1">{{ number_format($mediaAvaliacoes, 1) }}</h3>
                                <p class="text-muted mb-0">Avaliação Média</p>
                                <div class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $mediaAvaliacoes)
                                            <i class="fas fa-star"></i>
                                        @elseif($i - 0.5 <= $mediaAvaliacoes)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="fw-bold text-success mb-1">{{ $satisfacao }}%</h3>
                                <p class="text-muted mb-0">Satisfação</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="fw-bold text-info mb-1">{{ $eventosRealizados }}+</h3>
                                <p class="text-muted mb-0">Eventos Realizados</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-outline-primary filter-btn active" data-filter="*">
                    <i class="fas fa-th me-2"></i>Todos
                </button>
                @foreach($tiposEvento as $tipo)
                    <button class="btn btn-outline-primary filter-btn" data-filter=".{{ Str::slug($tipo) }}">
                        <i class="fas fa-tag me-2"></i>{{ $tipo }}
                    </button>
                @endforeach
            </div>
        </div>
        <div class="col-lg-4">
            <select class="form-select" id="avaliacaoFilter">
                <option value="">Todas as avaliações</option>
                <option value="5">5 Estrelas</option>
                <option value="4">4 Estrelas</option>
                <option value="3">3 Estrelas</option>
                <option value="2">2 Estrelas</option>
                <option value="1">1 Estrela</option>
            </select>
        </div>
    </div>

    <!-- Depoimentos em Destaque -->
    @if($destaques->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="h3 fw-bold mb-4">
                    <i class="fas fa-star text-warning me-2"></i>Depoimentos em Destaque
                </h2>
                <div class="row g-4">
                    @foreach($destaques as $depoimento)
                        <div class="col-lg-6">
                            <div class="card testimonial-card testimonial-featured h-100 border-0 shadow-lg {{ Str::slug($depoimento->evento_tipo) }}"
                                 data-rating="{{ $depoimento->avaliacao }}">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        @if($depoimento->foto_cliente && file_exists(public_path($depoimento->foto_cliente)))
                                            <img src="{{ asset($depoimento->foto_cliente) }}" alt="{{ $depoimento->nome_cliente }}" 
                                                 class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 60px; height: 60px;">
                                                <span class="text-white fw-bold h5 mb-0">
                                                    {{ strtoupper(substr($depoimento->nome_cliente, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h5 class="fw-bold mb-1">{{ $depoimento->nome_cliente }}</h5>
                                            <div class="text-warning mb-1">
                                                {!! $depoimento->getEstrelas() !!}
                                            </div>
                                            <span class="badge bg-primary">{{ $depoimento->evento_tipo }}</span>
                                        </div>
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-star me-1"></i>Destaque
                                        </span>
                                    </div>
                                    <blockquote class="blockquote mb-3">
                                        <p class="text-muted fst-italic lh-base">{{ $depoimento->depoimento }}</p>
                                    </blockquote>
                                    @if($depoimento->data_evento)
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            Evento realizado em {{ \Carbon\Carbon::parse($depoimento->data_evento)->format('d/m/Y') }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Todos os Depoimentos -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h3 fw-bold">
                <i class="fas fa-comments me-2"></i>Todos os Depoimentos
            </h2>
        </div>
    </div>

    <div class="row g-4" id="depoimentosGrid">
        @foreach($depoimentos as $depoimento)
            <div class="col-lg-6 testimonial-item {{ Str::slug($depoimento->evento_tipo) }}" 
                 data-rating="{{ $depoimento->avaliacao }}">
                <div class="card testimonial-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
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
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1">{{ $depoimento->nome_cliente }}</h6>
                                <div class="text-warning mb-1">
                                    {!! $depoimento->getEstrelas() !!}
                                </div>
                                <span class="badge bg-secondary">{{ $depoimento->evento_tipo }}</span>
                            </div>
                            @if($depoimento->destaque)
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-star me-1"></i>
                                </span>
                            @endif
                        </div>
                        <blockquote class="blockquote mb-3">
                            <p class="text-muted fst-italic">{{ $depoimento->depoimento }}</p>
                        </blockquote>
                        @if($depoimento->data_evento)
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($depoimento->data_evento)->format('d/m/Y') }}
                            </small>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($depoimentos->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-comments text-muted display-1 mb-3"></i>
            <h3 class="text-muted">Nenhum depoimento encontrado</h3>
            <p class="text-muted">Seja o primeiro a compartilhar sua experiência conosco!</p>
        </div>
    @endif

    <!-- Paginação -->
    @if($depoimentos->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $depoimentos->links() }}
        </div>
    @endif
</div>

<!-- Seção de Envio de Depoimento -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold mb-3">Compartilhe Sua Experiência</h2>
                <p class="lead text-muted mb-4">
                    Já realizamos seu evento? Conte como foi sua experiência conosco!
                </p>
                <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#depoimentoModal">
                    <i class="fas fa-pen me-2"></i>Deixar Depoimento
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Modal de Depoimento -->
<div class="modal fade" id="depoimentoModal" tabindex="-1" aria-labelledby="depoimentoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="depoimentoModalLabel">
                    <i class="fas fa-pen me-2"></i>Deixar Depoimento
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('galeria.depoimentos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome_cliente" class="form-label">Seu Nome *</label>
                            <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="evento_tipo" class="form-label">Tipo de Evento *</label>
                            <select class="form-select" id="evento_tipo" name="evento_tipo" required>
                                <option value="">Selecione...</option>
                                @foreach($tiposEvento as $tipo)
                                    <option value="{{ $tipo }}">{{ $tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="avaliacao" class="form-label">Avaliação *</label>
                            <div class="rating-input">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="avaliacao" value="{{ $i }}">
                                    <label for="star{{ $i }}" class="star">
                                        <i class="fas fa-star"></i>
                                    </label>
                                @endfor
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="data_evento" class="form-label">Data do Evento</label>
                            <input type="date" class="form-control" id="data_evento" name="data_evento">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="depoimento" class="form-label">Seu Depoimento *</label>
                        <textarea class="form-control" id="depoimento" name="depoimento" rows="4" required 
                                  placeholder="Conte como foi sua experiência conosco..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="foto_cliente" class="form-label">Sua Foto (Opcional)</label>
                        <input type="file" class="form-control" id="foto_cliente" name="foto_cliente" accept="image/*">
                        <small class="form-text text-muted">Formatos aceitos: JPG, PNG. Tamanho máximo: 2MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Enviar Depoimento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.hero-section {
    background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-info) 100%);
}

.testimonial-card {
    border-radius: 15px;
    transition: all 0.3s ease;
}

.testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
}

.testimonial-featured {
    background: linear-gradient(135deg, #fff 0%, #f8f9ff 100%);
    border-left: 4px solid var(--bs-warning) !important;
}

.stat-item {
    padding: 1rem;
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

.testimonial-item {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.testimonial-item.hidden {
    opacity: 0;
    transform: scale(0.8);
    pointer-events: none;
}

.rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 0.25rem;
}

.rating-input input[type="radio"] {
    display: none;
}

.rating-input .star {
    cursor: pointer;
    color: #ddd;
    font-size: 1.5rem;
    transition: color 0.2s ease;
}

.rating-input input[type="radio"]:checked ~ .star,
.rating-input .star:hover,
.rating-input .star:hover ~ .star {
    color: #ffc107;
}

@media (max-width: 768px) {
    .stat-item {
        padding: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .filter-btn {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
        margin-bottom: 0.5rem;
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
            $('.testimonial-item').removeClass('hidden');
        } else {
            $('.testimonial-item').addClass('hidden');
            $(filterValue).removeClass('hidden');
        }
    });
    
    // Filtro por avaliação
    $('#avaliacaoFilter').change(function() {
        const rating = $(this).val();
        
        if (rating === '') {
            $('.testimonial-item').removeClass('hidden');
        } else {
            $('.testimonial-item').addClass('hidden');
            $(`.testimonial-item[data-rating="${rating}"]`).removeClass('hidden');
        }
        
        // Se há filtro de avaliação ativo, desativar filtros de categoria
        if (rating !== '') {
            $('.filter-btn').removeClass('active');
        }
    });
    
    // Rating interativo no modal
    $('.rating-input .star').hover(function() {
        $(this).addClass('hover');
        $(this).nextAll('.star').addClass('hover');
    }, function() {
        $('.rating-input .star').removeClass('hover');
    });
    
    // Animação de entrada
    $('.testimonial-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
        $(this).addClass('animate__animated animate__fadeInUp');
    });
    
    // Validação do formulário
    $('#depoimentoModal form').on('submit', function(e) {
        const rating = $('input[name="avaliacao"]:checked').val();
        if (!rating) {
            e.preventDefault();
            alert('Por favor, selecione uma avaliação!');
            return false;
        }
    });
});

// Feedback após envio do depoimento
@if(session('success'))
    $(document).ready(function() {
        Swal.fire({
            title: 'Obrigado!',
            text: 'Seu depoimento foi enviado e será analisado em breve.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    });
@endif
</script>
@endsection
