@extends('layouts.admin')

@section('title', 'Visualizar Orçamento')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Orçamento #{{ $orcamento->numero }}</h1>
        <div>
            <a href="{{ route('admin.orcamentos.index') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
            <a href="{{ route('admin.orcamentos.edit', $orcamento) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Informações do Cliente -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Dados do Cliente</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 fw-bold">Nome:</div>
                        <div class="col-sm-8">{{ $orcamento->nome_cliente }}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4 fw-bold">E-mail:</div>
                        <div class="col-sm-8">
                            <a href="mailto:{{ $orcamento->email_cliente }}">{{ $orcamento->email_cliente }}</a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4 fw-bold">Telefone:</div>
                        <div class="col-sm-8">
                            <a href="tel:{{ $orcamento->telefone_cliente }}">{{ $orcamento->telefone_cliente }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações do Evento -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Detalhes do Evento</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 fw-bold">Data:</div>
                        <div class="col-sm-8">{{ \Carbon\Carbon::parse($orcamento->data_evento)->format('d/m/Y') }}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4 fw-bold">Pessoas:</div>
                        <div class="col-sm-8">{{ number_format($orcamento->numero_pessoas, 0, ',', '.') }} pessoas</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4 fw-bold">Local:</div>
                        <div class="col-sm-8">{{ $orcamento->local_evento }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status e Ações -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Status e Ações</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <strong>Status Atual:</strong><br>
                            @php
                                $badgeClass = [
                                    'pendente' => 'bg-warning text-dark',
                                    'aprovado' => 'bg-success',
                                    'rejeitado' => 'bg-danger',
                                    'convertido' => 'bg-primary'
                                ][$orcamento->status] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $badgeClass }} fs-6">
                                {{ ucfirst($orcamento->status) }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <strong>Valor Total:</strong><br>
                            <span class="h4 text-success">R$ {{ number_format($orcamento->valor_total, 2, ',', '.') }}</span>
                        </div>
                        <div class="col-md-6 text-end">
                            @if($orcamento->status === 'pendente')
                                <button type="button" class="btn btn-success me-2" onclick="aprovarOrcamento({{ $orcamento->id }})">
                                    <i class="fas fa-check me-2"></i>Aprovar
                                </button>
                                <button type="button" class="btn btn-danger" onclick="rejeitarOrcamento({{ $orcamento->id }})">
                                    <i class="fas fa-times me-2"></i>Rejeitar
                                </button>
                            @elseif($orcamento->status === 'aprovado')
                                <button type="button" class="btn btn-primary" onclick="converterOrcamento({{ $orcamento->id }})">
                                    <i class="fas fa-trophy me-2"></i>Converter em Venda
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Produtos Solicitados -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Produtos Solicitados</h5>
                </div>
                <div class="card-body">
                    @if($orcamento->produtos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th class="text-center">Quantidade</th>
                                        <th class="text-end">Preço Unit.</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orcamento->produtos as $produto)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($produto->imagem)
                                                <img src="{{ asset('storage/' . $produto->imagem) }}" 
                                                     alt="{{ $produto->nome }}" 
                                                     class="rounded me-3" 
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 60px; height: 60px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                                @endif
                                                <div>
                                                    <strong>{{ $produto->nome }}</strong>
                                                    @if($produto->descricao)
                                                    <br><small class="text-muted">{{ Str::limit($produto->descricao, 80) }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $produto->pivot->quantidade }}</span>
                                        </td>
                                        <td class="text-end">
                                            R$ {{ number_format($produto->pivot->preco_unitario, 2, ',', '.') }}
                                        </td>
                                        <td class="text-end">
                                            <strong class="text-success">
                                                R$ {{ number_format($produto->pivot->preco_total, 2, ',', '.') }}
                                            </strong>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-primary">
                                        <th colspan="3" class="text-end">Total Geral:</th>
                                        <th class="text-end">
                                            <span class="h5 text-success mb-0">
                                                R$ {{ number_format($orcamento->valor_total, 2, ',', '.') }}
                                            </span>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-shopping-cart fa-2x text-muted mb-2"></i>
                            <p class="text-muted">Nenhum produto solicitado.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Observações -->
    @if($orcamento->observacoes || $orcamento->observacoes_internas)
    <div class="row">
        @if($orcamento->observacoes)
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-comment me-2"></i>Observações do Cliente</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $orcamento->observacoes }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($orcamento->observacoes_internas)
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Observações Internas</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $orcamento->observacoes_internas }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Histórico -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Histórico</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <i class="fas fa-plus-circle text-primary"></i>
                            <div class="timeline-content">
                                <strong>Orçamento Criado</strong>
                                <p class="text-muted mb-0">{{ $orcamento->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        @if($orcamento->updated_at != $orcamento->created_at)
                        <div class="timeline-item">
                            <i class="fas fa-edit text-warning"></i>
                            <div class="timeline-content">
                                <strong>Última Atualização</strong>
                                <p class="text-muted mb-0">{{ $orcamento->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
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

<style>
.timeline {
    position: relative;
    padding: 1rem 0;
}

.timeline-item {
    display: flex;
    align-items-start;
    margin-bottom: 1rem;
}

.timeline-item i {
    font-size: 1.2rem;
    margin-right: 1rem;
    margin-top: 0.2rem;
}

.timeline-content h6 {
    margin-bottom: 0.25rem;
}
</style>

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
