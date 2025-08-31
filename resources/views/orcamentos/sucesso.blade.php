@extends('layouts.app')

@section('title', 'Orçamento Enviado')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                </div>
                
                <h1 class="display-4 text-success mb-3">Orçamento Enviado!</h1>
                
                @if(session('numero_orcamento'))
                    <div class="alert alert-info">
                        <h5 class="mb-2">Número do seu orçamento:</h5>
                        <h3 class="text-primary mb-0">#{{ session('numero_orcamento') }}</h3>
                    </div>
                @endif

                <p class="lead mb-4">
                    Obrigado por solicitar um orçamento conosco! Recebemos sua solicitação e nossa equipe irá analisá-la cuidadosamente.
                </p>

                <div class="row mb-5">
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-clock text-primary mb-3" style="font-size: 2rem;"></i>
                                <h5>Análise Rápida</h5>
                                <p class="small text-muted mb-0">Analisaremos sua solicitação em até 24 horas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-phone text-primary mb-3" style="font-size: 2rem;"></i>
                                <h5>Contato Direto</h5>
                                <p class="small text-muted mb-0">Entraremos em contato via telefone ou e-mail</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-file-alt text-primary mb-3" style="font-size: 2rem;"></i>
                                <h5>Proposta Detalhada</h5>
                                <p class="small text-muted mb-0">Você receberá uma proposta completa e personalizada</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-primary">
                    <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Próximos Passos</h5>
                    <p class="mb-2">1. Nossa equipe analisará os detalhes do seu evento</p>
                    <p class="mb-2">2. Entraremos em contato para esclarecer possíveis dúvidas</p>
                    <p class="mb-0">3. Enviaremos uma proposta comercial detalhada</p>
                </div>

                <div class="mb-4">
                    <h5>Precisa falar conosco?</h5>
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <a href="tel:+5511999999999" class="btn btn-outline-primary me-2">
                                <i class="fas fa-phone me-2"></i>(11) 99999-9999
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="mailto:contato@personalizados.com" class="btn btn-outline-primary">
                                <i class="fas fa-envelope me-2"></i>contato@personalizados.com
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <a href="{{ route('pagina-Inicial') }}" class="btn btn-primary me-3">
                        <i class="fas fa-home me-2"></i>Voltar ao Início
                    </a>
                    <a href="{{ route('orcamentos.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>Novo Orçamento
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.alert {
    text-align: left;
}
</style>
@endsection
