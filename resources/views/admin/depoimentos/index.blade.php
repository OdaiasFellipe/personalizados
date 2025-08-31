@extends('admin.layout')

@section('title', 'Depoimentos')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Gerenciar Depoimentos</h1>
        <div class="btn-group">
            <a href="{{ route('galeria.depoimentos') }}" class="btn btn-outline-primary" target="_blank">
                <i class="fas fa-eye me-2"></i>Ver Página Pública
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="filtroStatus">
                        <option value="">Todos</option>
                        <option value="aprovado">Aprovados</option>
                        <option value="pendente">Pendentes</option>
                        <option value="destaque">Em Destaque</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tipo de Evento</label>
                    <select class="form-select" id="filtroTipo">
                        <option value="">Todos</option>
                        <option value="Festa Infantil">Festa Infantil</option>
                        <option value="Casamento">Casamento</option>
                        <option value="Aniversário Adulto">Aniversário Adulto</option>
                        <option value="Formatura">Formatura</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Avaliação</label>
                    <select class="form-select" id="filtroAvaliacao">
                        <option value="">Todas</option>
                        <option value="5">5 Estrelas</option>
                        <option value="4">4 Estrelas</option>
                        <option value="3">3 Estrelas</option>
                        <option value="2">2 Estrelas</option>
                        <option value="1">1 Estrela</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-outline-secondary" onclick="limparFiltros()">
                        <i class="fas fa-refresh me-2"></i>Limpar Filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="depoimentosTable">
                    <thead class="table-dark">
                        <tr>
                            <th>Cliente</th>
                            <th>Depoimento</th>
                            <th>Evento</th>
                            <th>Avaliação</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($depoimentos as $depoimento)
                        <tr data-status="{{ $depoimento->aprovado ? 'aprovado' : 'pendente' }}"
                            data-destaque="{{ $depoimento->destaque ? 'destaque' : '' }}"
                            data-tipo="{{ $depoimento->evento_tipo }}"
                            data-avaliacao="{{ $depoimento->avaliacao }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($depoimento->foto_cliente)
                                        <img src="{{ asset($depoimento->foto_cliente) }}" alt="{{ $depoimento->nome_cliente }}" 
                                             class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                             style="width: 40px; height: 40px;">
                                            <span class="text-white fw-bold">
                                                {{ strtoupper(substr($depoimento->nome_cliente, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ $depoimento->nome_cliente }}</strong>
                                        <small class="d-block text-muted">
                                            {{ $depoimento->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-1">{{ Str::limit($depoimento->depoimento, 80) }}</p>
                                @if(strlen($depoimento->depoimento) > 80)
                                    <button class="btn btn-link btn-sm p-0" onclick="verDepoimento('{{ $depoimento->id }}')">
                                        Ver completo
                                    </button>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $depoimento->evento_tipo }}</span>
                                @if($depoimento->data_evento)
                                    <small class="d-block text-muted">
                                        {{ \Carbon\Carbon::parse($depoimento->data_evento)->format('d/m/Y') }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                <div class="text-warning">
                                    {!! $depoimento->getEstrelas() !!}
                                </div>
                                <small class="text-muted">{{ $depoimento->avaliacao }}/5</small>
                            </td>
                            <td>{{ $depoimento->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    @if($depoimento->aprovado)
                                        <span class="badge bg-success">Aprovado</span>
                                    @else
                                        <span class="badge bg-warning">Pendente</span>
                                    @endif
                                    
                                    @if($depoimento->destaque)
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-star"></i> Destaque
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if($depoimento->aprovado)
                                        <button type="button" class="btn btn-sm btn-outline-warning" 
                                                onclick="alterarAprovacao({{ $depoimento->id }})" 
                                                title="Reprovar">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-outline-success" 
                                                onclick="alterarAprovacao({{ $depoimento->id }})" 
                                                title="Aprovar">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    
                                    <button type="button" class="btn btn-sm btn-outline-warning" 
                                            onclick="alterarDestaque({{ $depoimento->id }})" 
                                            title="{{ $depoimento->destaque ? 'Remover destaque' : 'Destacar' }}">
                                        <i class="fas fa-star{{ $depoimento->destaque ? '' : '-o' }}"></i>
                                    </button>
                                    
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="confirmarExclusao({{ $depoimento->id }})" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-comments text-muted fs-1 mb-3"></i>
                                <p class="text-muted">Nenhum depoimento recebido ainda.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($depoimentos->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $depoimentos->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para ver depoimento completo -->
<div class="modal fade" id="modalDepoimento" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Depoimento Completo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="conteudoDepoimento">
                <!-- Conteúdo será carregado via JavaScript -->
            </div>
        </div>
    </div>
</div>

<!-- Formulários ocultos -->
<form id="formAprovacao" method="POST" style="display: none;">
    @csrf
    @method('PUT')
</form>

<form id="formDestaque" method="POST" style="display: none;">
    @csrf
    @method('PUT')
</form>

<form id="formExcluir" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#depoimentosTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
        },
        "order": [[ 4, "desc" ]], // Ordenar por data (mais recentes primeiro)
        "pageLength": 25,
        "columnDefs": [
            { "orderable": false, "targets": [6] } // Ações não ordenáveis
        ]
    });

    // Filtros
    $('#filtroStatus, #filtroTipo, #filtroAvaliacao').change(function() {
        aplicarFiltros();
    });
});

function aplicarFiltros() {
    const status = $('#filtroStatus').val();
    const tipo = $('#filtroTipo').val();
    const avaliacao = $('#filtroAvaliacao').val();

    $('#depoimentosTable tbody tr').each(function() {
        let mostrar = true;
        const $row = $(this);

        if (status && status !== $row.data('status') && 
            !(status === 'destaque' && $row.data('destaque'))) {
            mostrar = false;
        }

        if (tipo && tipo !== $row.data('tipo')) {
            mostrar = false;
        }

        if (avaliacao && avaliacao != $row.data('avaliacao')) {
            mostrar = false;
        }

        $row.toggle(mostrar);
    });
}

function limparFiltros() {
    $('#filtroStatus, #filtroTipo, #filtroAvaliacao').val('');
    $('#depoimentosTable tbody tr').show();
}

function verDepoimento(id) {
    // Encontrar o depoimento na tabela
    const row = $(`tr[data-status]:has(button[onclick*="${id}"])`);
    const depoimento = @json($depoimentos->keyBy('id'));
    
    $('#conteudoDepoimento').html(depoimento[id]?.depoimento || 'Depoimento não encontrado');
    $('#modalDepoimento').modal('show');
}

function alterarAprovacao(id) {
    const form = document.getElementById('formAprovacao');
    form.action = `/admin/depoimentos/${id}/aprovar`;
    form.submit();
}

function alterarDestaque(id) {
    const form = document.getElementById('formDestaque');
    form.action = `/admin/depoimentos/${id}/destacar`;
    form.submit();
}

function confirmarExclusao(id) {
    Swal.fire({
        title: 'Confirmar Exclusão',
        text: 'Tem certeza que deseja excluir este depoimento? Esta ação não pode ser desfeita.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('formExcluir');
            form.action = `/admin/depoimentos/${id}`;
            form.submit();
        }
    });
}
</script>
@endsection
