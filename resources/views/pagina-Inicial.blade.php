{{-- filepath: resources/views/pagina-Inicial.blade.php --}}
@extends('layouts.app')

@section('title', 'NE Fotografias e Personalizados - Página Inicial')

@section('content')
    {{-- Hero Section --}}
    <section class="hero-section">
        <div class="hero-overlay">
            <div class="container">
                <div class="row align-items-center min-vh-100">
                    <div class="col-lg-6">
                        <div class="hero-content text-white">
                            <h1 class="display-4 fw-bold mb-4 animate-fade-in">
                                Transforme sua festa em 
                                <span class="text-warning">momentos únicos!</span>
                            </h1>
                            <p class="lead mb-4 animate-fade-in-delay">
                                Produtos personalizados e fotografias profissionais para tornar 
                                seu aniversário inesquecível. Criamos memórias que duram para sempre!
                            </p>
                            <div class="hero-buttons animate-fade-in-delay-2">
                                <a href="{{ route('catalogo') }}" class="btn btn-warning btn-lg me-3 px-4 py-3">
                                    <i class="fas fa-gift me-2"></i>Ver Produtos
                                </a>
                                <a href="{{ route('contato') }}" class="btn btn-outline-light btn-lg px-4 py-3">
                                    <i class="fas fa-phone me-2"></i>Falar Conosco
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Seção de Destaques --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 fw-bold mb-3">Por que escolher a NE?</h2>
                    <p class="lead text-muted">Oferecemos qualidade e criatividade em cada produto</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center p-4 h-100">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-palette fa-3x text-warning"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Design Personalizado</h4>
                        <p class="text-muted">Cada produto é único e criado especialmente para sua festa, com designs exclusivos e personalizados.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card text-center p-4 h-100">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-award fa-3x text-warning"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Qualidade Premium</h4>
                        <p class="text-muted">Utilizamos apenas materiais de alta qualidade para garantir que seus produtos durem muito tempo.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card text-center p-4 h-100">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-clock fa-3x text-warning"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Entrega Rápida</h4>
                        <p class="text-muted">Trabalhamos com prazos ágeis para que você tenha seus produtos no tempo certo para sua festa.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action --}}
    <section class="py-5 bg-warning">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="fw-bold mb-2">Pronto para criar sua festa dos sonhos?</h3>
                    <p class="mb-0">Entre em contato conosco e vamos criar algo incrível juntos!</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('contato') }}" class="btn btn-dark btn-lg px-4 py-3">
                        <i class="fas fa-rocket me-2"></i>Começar Agora
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection