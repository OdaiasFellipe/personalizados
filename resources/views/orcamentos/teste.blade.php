@extends('layouts.app')

@section('title', 'Teste Orçamento')

@section('content')
<div class="container py-5">
    <h1>Teste de Orçamento</h1>
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('orcamentos.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" name="nome" value="João Silva" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="joao@teste.com" required>
        </div>
        
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" name="telefone" value="11999999999" required>
        </div>
        
        <div class="mb-3">
            <label for="data_evento" class="form-label">Data do Evento</label>
            <input type="date" class="form-control" name="data_evento" value="2025-09-15" required>
        </div>
        
        <div class="mb-3">
            <label for="local_evento" class="form-label">Local</label>
            <input type="text" class="form-control" name="local_evento" value="São Paulo" required>
        </div>
        
        <div class="mb-3">
            <label for="numero_pessoas" class="form-label">Número de Pessoas</label>
            <input type="number" class="form-control" name="numero_pessoas" value="50" required>
        </div>
        
        <div class="mb-3">
            <label>Produtos</label>
            @foreach($produtos as $produto)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="produtos[]" value="{{ $produto->id }}">
                <label class="form-check-label">{{ $produto->nome }} - R$ {{ number_format($produto->preco, 2, ',', '.') }}</label>
                <input type="number" name="quantidades[]" value="1" min="1" style="width: 60px; margin-left: 10px;">
            </div>
            @endforeach
        </div>
        
        <button type="submit" class="btn btn-primary">Enviar Teste</button>
    </form>
</div>
@endsection
