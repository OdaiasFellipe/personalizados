@extends('admin.layout')

@section('title', 'Adicionar Item à Galeria')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Adicionar Item à Galeria</h1>
        <a href="{{ route('admin.galeria') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.galeria.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="titulo" class="form-label">Título*</label>
                                <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                       id="titulo" name="titulo" value="{{ old('titulo') }}" required>
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
                                        <option value="{{ $cat }}" {{ old('categoria') == $cat ? 'selected' : '' }}>
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
                                      id="descricao" name="descricao" rows="4" required>{{ old('descricao') }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="imagem" class="form-label">Imagem*</label>
                            <input type="file" class="form-control @error('imagem') is-invalid @enderror" 
                                   id="imagem" name="imagem" accept="image/*" required>
                            <small class="form-text text-muted">
                                Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 5MB
                            </small>
                            @error('imagem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                                   id="tags" name="tags" value="{{ old('tags') }}" 
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
                                       id="ordem" name="ordem" value="{{ old('ordem', 0) }}" min="0">
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
                                           {{ old('destaque') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="destaque">
                                        <i class="fas fa-star text-warning me-1"></i>
                                        Destacar na galeria
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Salvar Item
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
                        <i class="fas fa-info-circle me-2"></i>Dicas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-camera me-2"></i>Imagens</h6>
                        <ul class="mb-0 small">
                            <li>Use imagens de alta qualidade</li>
                            <li>Resolução recomendada: 1200x800px</li>
                            <li>Formato preferido: JPG</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-star me-2"></i>Destaque</h6>
                        <p class="mb-0 small">
                            Itens em destaque aparecem primeiro na galeria e 
                            podem ser exibidos na página inicial.
                        </p>
                    </div>
                    
                    <div class="alert alert-success">
                        <h6><i class="fas fa-tags me-2"></i>Tags</h6>
                        <p class="mb-0 small">
                            Use tags para facilitar a busca. Exemplos: 
                            "festa infantil", "casamento", "decoração temática".
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
// Preview da imagem
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
                e.target.parentNode.appendChild(preview);
            }
            
            preview.innerHTML = `
                <img src="${e.target.result}" class="img-thumbnail" 
                     style="max-width: 200px; max-height: 200px;">
                <small class="d-block text-muted mt-1">Preview da imagem</small>
            `;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
