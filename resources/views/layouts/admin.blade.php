<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Painel Administrativo</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Font Awesome Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 5px 0;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        
        .main-content {
            background: white;
            min-height: 100vh;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
        }
        
        .header-admin {
            background: white;
            border-bottom: 1px solid #dee2e6;
            padding: 15px 0;
        }
        
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 10px;
        }
        
        .btn {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            {{-- Sidebar --}}
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="p-3">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-cogs me-2"></i>
                        Painel Admin
                    </h4>
                    
                    <nav class="nav flex-column">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            <i class="fas fa-home me-2"></i>Dashboard
                        </a>
                        <a href="{{ route('admin.produtos') }}" class="nav-link">
                            <i class="fas fa-gift me-2"></i>Produtos
                        </a>
                        <a href="{{ route('admin.galeria') }}" class="nav-link">
                            <i class="fas fa-images me-2"></i>Galeria
                        </a>
                        <a href="{{ route('admin.depoimentos') }}" class="nav-link">
                            <i class="fas fa-comments me-2"></i>Depoimentos
                        </a>
                        <a href="{{ route('admin.orcamentos.index') }}" class="nav-link">
                            <i class="fas fa-calculator me-2"></i>Orçamentos
                        </a>
                        <a href="{{ route('admin.servicos.index') }}" class="nav-link">
                            <i class="fas fa-cogs me-2"></i>Serviços
                        </a>
                        <a href="{{ route('admin.configuracoes') }}" class="nav-link">
                            <i class="fas fa-tools me-2"></i>Configurações
                        </a>
                        
                        <hr class="text-white-50 my-3">
                        
                        <a href="{{ route('pagina-Inicial') }}" class="nav-link" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>Ver Site
                        </a>
                        
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                <i class="fas fa-sign-out-alt me-2"></i>Sair
                            </button>
                        </form>
                    </nav>
                </div>
            </div>
            
            {{-- Conteúdo Principal --}}
            <div class="col-md-9 col-lg-10 main-content">
                {{-- Header --}}
                <div class="header-admin">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="h5 mb-0">@yield('title', 'Painel Administrativo')</h2>
                            <div class="d-flex align-items-center">
                                <span class="text-muted me-3">
                                    <i class="fas fa-user-circle me-1"></i>
                                    {{ Auth::user()->name ?? 'Admin' }}
                                </span>
                                <small class="text-muted">{{ date('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Conteúdo --}}
                <div class="p-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Scripts adicionais --}}
    @stack('scripts')
</body>
</html>
