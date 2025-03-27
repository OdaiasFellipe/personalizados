{{-- filepath: resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NE Fotografias e Personalizados')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- CSS personalizado --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="background-image">
    <header class="custom-navbar text-white py-3 ">
        <nav class="container navbar navbar-expand-lg navbar-dark ">
            <a class="navbar-brand" href="{{ route('pagina-Inicial') }}">Inicial</a>
            <a class="navbar-brand" href="{{ route('catalogo') }}">Nossos produtos</a>
            <a class="navbar-brand" href="{{ route('contato') }}">Contato</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            {{-- <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('pagina-Inicial') }}">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('products') }}">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contato</a></li>
                </ul>
            </div> --}}
        </nav>
    </header>

    <main class="container my-5">
        @yield('content')
    </main>

    <footer class="custom-navbar">
        <p>&copy; {{ date('Y') }} NE Fotografias e Personalizados. Todos os direitos reservados.</p>
    </footer>

    {{-- Incluindo jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script para configurar a imagem de fundo --}}
    <script>
        $(document).ready(function () {
            $('body').css({
                'background-image': 'url("{{ asset('images/background.png') }}")',
                'background-size': 'cover',
                'background-position': 'center',
                'background-repeat': 'no-repeat',
                'height': '100vh'
            });
        });
    </script>

    {{-- JS personalizado --}}
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>