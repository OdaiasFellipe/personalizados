@extends('admin.layout')

@section('title', 'Galeria')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Gerenciar Galeria</h1>
        <a href="{{ route('admin.galeria.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Adicionar Item
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="galeriaTable">
                    <thead class="table-dark">
                        <tr>
                            <th>Imagem</th>
                            <th>Título</th>
                            <th>Categoria</th>
                            <th>Destaque</th>
                            <th>Status</th>
                            <th>Ordem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($galeria as $item)
                        <tr>
                            <td>
                                @if($item->imagem)
                                    <img src="{{ asset($item->imagem) }}" alt="{{ $item->titulo }}" 
                                         class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $item->titulo }}</strong>
                                <small class="d-block text-muted">{{ Str::limit($item->descricao, 50) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $item->categoria }}</span>
                            </td>
                            <td>
                                @if($item->destaque)
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-star me-1"></i>Destaque
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark">Normal</span>
                                @endif
                            </td>
                            <td>
                                @if($item->ativo)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td>{{ $item->ordem }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.galeria.edit', $item) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="confirmarExclusao({{ $item->id }})" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-images text-muted fs-1 mb-3"></i>
                                <p class="text-muted">Nenhum item na galeria ainda.</p>
                                <a href="{{ route('admin.galeria.create') }}" class="btn btn-primary">
                                    Adicionar Primeiro Item
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($galeria->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $galeria->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Formulário oculto para exclusão -->
<form id="formExcluir" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#galeriaTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
        },
        "order": [[ 5, "asc" ]], // Ordenar por ordem
        "pageLength": 25,
        "columnDefs": [
            { "orderable": false, "targets": [0, 6] } // Imagem e ações não ordenáveis
        ]
    });
});

function confirmarExclusao(id) {
    Swal.fire({
        title: 'Confirmar Exclusão',
        text: 'Tem certeza que deseja excluir este item da galeria? Esta ação não pode ser desfeita.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('formExcluir');
            form.action = `/admin/galeria/${id}`;
            form.submit();
        }
    });
}
</script>
@endsection
