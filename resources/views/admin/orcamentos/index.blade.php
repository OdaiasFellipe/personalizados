@extends('layouts.admin')

@section('title', 'Orçamentos')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Gerenciar Orçamentos</h1>
        <div>
            <a href="{{ route('admin.produtos') }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-gift me-2"></i>Gerenciar Produtos
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Resumo estatístico -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Pendentes</h5>
                            <h3>{{ $orcamentos->where('status', 'pendente')->count() }}</h3>
                        </div>
                        <i class="fas fa-clock fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Aprovados</h5>
                            <h3>{{ $orcamentos->where('status', 'aprovado')->count() }}</h3>
                        </div>
                        <i class="fas fa-check fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Convertidos</h5>
                            <h3>{{ $orcamentos->where('status', 'convertido')->count() }}</h3>
                        </div>
                        <i class="fas fa-trophy fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Rejeitados</h5>
                            <h3>{{ $orcamentos->where('status', 'rejeitado')->count() }}</h3>
                        </div>
                        <i class="fas fa-times fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de orçamentos -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Lista de Orçamentos</h5>
        </div>
        <div class="card-body">
            @if($orcamentos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Número</th>
                                <th>Cliente</th>
                                <th>Data do Evento</th>
                                <th>Pessoas</th>
                                <th>Valor Total</th>
                                <th>Status</th>
                                <th>Data Criação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orcamentos as $orcamento)
                            <tr>
                                <td>
                                    <strong class="text-primary">#{{ $orcamento->numero }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $orcamento->nome_cliente }}</strong><br>
                                        <small class="text-muted">{{ $orcamento->email_cliente }}</small>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($orcamento->data_evento)->format('d/m/Y') }}</td>
                                <td>{{ number_format($orcamento->numero_pessoas, 0, ',', '.') }}</td>
                                <td>
                                    <strong class="text-success">
                                        R$ {{ number_format($orcamento->valor_total, 2, ',', '.') }}
                                    </strong>
                                </td>
                                <td>
                                    @php
                                        $badgeClass = [
                                            'pendente' => 'bg-warning text-dark',
                                            'aprovado' => 'bg-success',
                                            'rejeitado' => 'bg-danger',
                                            'convertido' => 'bg-primary'
                                        ][$orcamento->status] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($orcamento->status) }}
                                    </span>
                                </td>
                                <td>{{ $orcamento->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.orcamentos.show', $orcamento) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($orcamento->status === 'pendente')
                                            <button type="button" class="btn btn-sm btn-outline-success" 
                                                    onclick="aprovarOrcamento({{ $orcamento->id }})" title="Aprovar">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="rejeitarOrcamento({{ $orcamento->id }})" title="Rejeitar">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                        
                                        @if($orcamento->status === 'aprovado')
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    onclick="converterOrcamento({{ $orcamento->id }})" title="Converter em Venda">
                                                <i class="fas fa-trophy"></i>
                                            </button>
                                        @endif
                                        
                                        <a href="{{ route('admin.orcamentos.edit', $orcamento) }}" 
                                           class="btn btn-sm btn-outline-secondary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{ $orcamentos->links() }}
            @else
                <div class="text-center py-5">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum orçamento encontrado</h5>
                    <p class="text-muted">Os orçamentos solicitados aparecerão aqui.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para rejeição -->
<div class="modal fade" id="rejeitarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejeitar Orçamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejeitarForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="motivo_rejeicao" class="form-label">Motivo da Rejeição *</label>
                        <textarea class="form-control" id="motivo_rejeicao" name="motivo_rejeicao" 
                                  rows="4" required placeholder="Explique o motivo da rejeição..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Rejeitar Orçamento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function aprovarOrcamento(id) {
    if (confirm('Tem certeza que deseja aprovar este orçamento?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/orcamentos/${id}/aprovar`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

function rejeitarOrcamento(id) {
    const modal = new bootstrap.Modal(document.getElementById('rejeitarModal'));
    const form = document.getElementById('rejeitarForm');
    form.action = `/admin/orcamentos/${id}/rejeitar`;
    modal.show();
}

function converterOrcamento(id) {
    if (confirm('Tem certeza que deseja converter este orçamento em venda?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/orcamentos/${id}/converter`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
