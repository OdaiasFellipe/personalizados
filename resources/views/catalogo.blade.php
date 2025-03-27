@extends('layouts.app')

@section('title', 'Catálogo')

@section('content')
    <div class="container">
        <h1 class="text-center mb-5">Confira aqui nossos produtos!</h1>
        
        <div class="row">
            @foreach ($produtos as $produto)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset($produto->imagem) }}" class="card-img-top img-fluid" alt="{{ $produto->nome }}" style="height: 100px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $produto->nome }}</h5>
                            <p class="card-text">{{ $produto->descricao }}</p>
                            <p class="card-text"><strong>R$ {{ number_format($produto->preco, 2, ',', '.') }}</strong></p>
                            <a href="#" class="btn btn-primary">Ver mais</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection