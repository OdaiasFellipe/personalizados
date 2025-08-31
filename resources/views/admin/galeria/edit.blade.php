@extends('admin.layout')

@section('title', 'Editar Item da Galeria')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Editar Item da Galeria</h1>
        <a href="{{ route('admin.galeria') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.galeria.update', $galeria) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="titulo" class="form-label">Título*</label>
                                <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                       id="titulo" name="titulo" value="{{ old('titulo', $galeria->titulo) }}" required>
                                @error('titulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="categoria" class="form-label">Categoria*</label>
                                <select class="form-select @error('categoria') is-invalid @enderror" 
                                        id="categoria" name="categoria" required>
                                    <option value="">Selecione...</option>
                                    @foreach($categorias as $cat)
                                        <option value="{{ $cat }}" 
                                                {{ old('categoria', $galeria->categoria) == $cat ? 'selected' : '' }}>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição*</label>
                            <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                      id="descricao" name="descricao" rows="4" required>{{ old('descricao', $galeria->descricao) }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="imagem" class="form-label">Imagem</label>
                            @if($galeria->imagem)
                                <div class="mb-2">
                                    <img src="{{ asset($galeria->imagem) }}" alt="{{ $galeria->titulo }}" 
                                         class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <small class="d-block text-muted">Imagem atual</small>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('imagem') is-invalid @enderror" 
                                   id="imagem" name="imagem" accept="image/*">
                            <small class="form-text text-muted">
                                Deixe em branco para manter a imagem atual. Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 5MB
                            </small>
                            @error('imagem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                                   id="tags" name="tags" 
                                   value="{{ old('tags', $galeria->tags ? implode(', ', $galeria->tags) : '') }}" 
                                   placeholder="Ex: festa infantil, decoração, bolo">
                            <small class="form-text text-muted">
                                Separe as tags por vírgulas para facilitar a busca
                            </small>
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ordem" class="form-label">Ordem de Exibição</label>
                                <input type="number" class="form-control @error('ordem') is-invalid @enderror" 
                                       id="ordem" name="ordem" value="{{ old('ordem', $galeria->ordem) }}" min="0">
                                <small class="form-text text-muted">
                                    Menor número aparece primeiro na galeria
                                </small>
                                @error('ordem')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Configurações</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           id="destaque" name="destaque" value="1" 
                                           {{ old('destaque', $galeria->destaque) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="destaque">
                                        <i class="fas fa-star text-warning me-1"></i>
                                        Destacar na galeria
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" 
                                           id="ativo" name="ativo" value="1" 
                                           {{ old('ativo', $galeria->ativo) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ativo">
                                        <i class="fas fa-eye text-success me-1"></i>
                                        Ativo (visível na galeria)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Atualizar Item
                            </button>
                            <a href="{{ route('admin.galeria') }}" class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informações
                    </h5>
                </div>
                <div class="card-body">
                    <p><strong>Criado em:</strong> {{ $galeria->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Última atualização:</strong> {{ $galeria->updated_at->format('d/m/Y H:i') }}</p>
                    
                    @if($galeria->tags && count($galeria->tags) > 0)
                        <p><strong>Tags atuais:</strong></p>
                        <div class="mb-3">
                            @foreach($galeria->tags as $tag)
                                <span class="badge bg-secondary me-1">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="alert alert-info">
                        <h6><i class="fas fa-lightbulb me-2"></i>Dica</h6>
                        <p class="mb-0 small">
                            Mantenha as imagens organizadas por categoria e 
                            use tags descritivas para facilitar a navegação dos visitantes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Preview da nova imagem
document.getElementById('imagem').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Criar preview se não existir
            let preview = document.getElementById('imagePreview');
            if (!preview) {
                preview = document.createElement('div');
                preview.id = 'imagePreview';
                preview.className = 'mt-2';
                document.querySelector('input[type="file"]').parentNode.appendChild(preview);
            }
            
            preview.innerHTML = `
                <img src="${e.target.result}" class="img-thumbnail" 
                     style="max-width: 200px; max-height: 200px;">
                <small class="d-block text-muted mt-1">Nova imagem (preview)</small>
            `;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
