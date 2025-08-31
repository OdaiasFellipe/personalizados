{{-- filepath: resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NE Fotografias e Personalizados')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Font Awesome Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- CSS personalizado --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    {{-- Navegação moderna --}}
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top modern-navbar">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('pagina-Inicial') }}">
                <i class="fas fa-camera-retro me-2 text-warning"></i>
                NE Personalizados
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pagina-Inicial') }}">
                            <i class="fas fa-home me-1"></i>Início
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalogo') }}">
                            <i class="fas fa-gift me-1"></i>Produtos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('galeria') }}">
                            <i class="fas fa-images me-1"></i>Galeria
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orcamentos.create') }}">
                            <i class="fas fa-calculator me-1"></i>Orçamento
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contato') }}">
                            <i class="fas fa-envelope me-1"></i>Contato
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}" target="_blank">
                            <i class="fas fa-cogs me-1"></i>Painel
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    {{-- Rodapé moderno --}}
    <footer class="modern-footer bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="mb-3">
                        <i class="fas fa-camera-retro me-2 text-warning"></i>
                        NE Fotografias
                    </h5>
                    <p class="text-light">Especializados em produtos personalizados para tornar suas festas de aniversário ainda mais especiais!</p>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Links Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('pagina-Inicial') }}" class="text-light text-decoration-none"><i class="fas fa-chevron-right me-2"></i>Início</a></li>
                        <li><a href="{{ route('catalogo') }}" class="text-light text-decoration-none"><i class="fas fa-chevron-right me-2"></i>Catálogo</a></li>
                        <li><a href="{{ route('galeria') }}" class="text-light text-decoration-none"><i class="fas fa-chevron-right me-2"></i>Galeria</a></li>
                        <li><a href="{{ route('galeria.depoimentos') }}" class="text-light text-decoration-none"><i class="fas fa-chevron-right me-2"></i>Depoimentos</a></li>
                        <li><a href="{{ route('contato') }}" class="text-light text-decoration-none"><i class="fas fa-chevron-right me-2"></i>Contato</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Redes Sociais</h5>
                    <div class="social-links">
                        <a href="#" class="text-warning me-3 fs-4"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-warning me-3 fs-4"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-warning me-3 fs-4"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} NE Fotografias e Personalizados. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    {{-- Incluindo jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- JS personalizado --}}
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>