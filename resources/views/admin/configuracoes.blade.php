@extends('admin.layout')

@section('title', 'Configurações')
@section('page-title', 'Configurações do Site')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Configurações do Site</h4>
                <p class="text-muted mb-0">Personalize as informações e aparência do seu site</p>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('admin.configuracoes.update') }}" method="POST" enctype="multipart/form-data" id="formConfiguracoes">
    @csrf
    
    <div class="row g-4">
        {{-- Informações Básicas --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle text-warning me-2"></i>
                        Informações Básicas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="nome_site" class="form-label fw-semibold">
                                Nome do Site <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="nome_site" 
                                   name="nome_site" 
                                   value="{{ old('nome_site', 'NE Fotografias e Personalizados') }}" 
                                   required
                                   placeholder="Nome da sua empresa">
                        </div>
                        
                        <div class="col-12">
                            <label for="descricao_site" class="form-label fw-semibold">
                                Descrição do Site <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" 
                                      id="descricao_site" 
                                      name="descricao_site" 
                                      rows="3" 
                                      required
                                      placeholder="Descreva sua empresa e serviços">{{ old('descricao_site', 'Especializados em produtos personalizados para tornar suas festas de aniversário ainda mais especiais!') }}</textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="telefone" class="form-label fw-semibold">
                                Telefone/WhatsApp <span class="text-danger">*</span>
                            </label>
                            <input type="tel" 
                                   class="form-control" 
                                   id="telefone" 
                                   name="telefone" 
                                   value="{{ old('telefone', '(11) 99999-9999') }}" 
                                   required
                                   placeholder="(11) 99999-9999">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">
                                E-mail <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', 'contato@nepersonalizados.com') }}" 
                                   required
                                   placeholder="contato@empresa.com">
                        </div>
                        
                        <div class="col-12">
                            <label for="endereco" class="form-label fw-semibold">
                                Endereço
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="endereco" 
                                   name="endereco" 
                                   value="{{ old('endereco', '') }}" 
                                   placeholder="Rua, número, bairro, cidade - UF">
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Redes Sociais --}}
            <div class="card mt-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-share-alt text-info me-2"></i>
                        Redes Sociais
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="instagram" class="form-label fw-semibold">
                                <i class="fab fa-instagram text-danger me-1"></i>
                                Instagram
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text" 
                                       class="form-control" 
                                       id="instagram" 
                                       name="instagram" 
                                       value="{{ old('instagram', 'ne_personalizados') }}" 
                                       placeholder="usuario_instagram">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="facebook" class="form-label fw-semibold">
                                <i class="fab fa-facebook text-primary me-1"></i>
                                Facebook
                            </label>
                            <input type="url" 
                                   class="form-control" 
                                   id="facebook" 
                                   name="facebook" 
                                   value="{{ old('facebook', '') }}" 
                                   placeholder="https://facebook.com/sua-pagina">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="whatsapp" class="form-label fw-semibold">
                                <i class="fab fa-whatsapp text-success me-1"></i>
                                WhatsApp (com código do país)
                            </label>
                            <input type="tel" 
                                   class="form-control" 
                                   id="whatsapp" 
                                   name="whatsapp" 
                                   value="{{ old('whatsapp', '5511999999999') }}" 
                                   placeholder="5511999999999">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Link do WhatsApp</label>
                            <div class="form-control bg-light" id="linkWhatsapp">
                                https://wa.me/5511999999999
                            </div>
                            <small class="text-muted">Gerado automaticamente</small>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Horários de Funcionamento --}}
            <div class="card mt-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock text-success me-2"></i>
                        Horários de Atendimento
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Segunda a Sexta</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="horario_semana" 
                                   value="{{ old('horario_semana', '09:00 às 18:00') }}" 
                                   placeholder="09:00 às 18:00">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Sábado</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="horario_sabado" 
                                   value="{{ old('horario_sabado', '09:00 às 14:00') }}" 
                                   placeholder="09:00 às 14:00">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Domingo</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="horario_domingo" 
                                   value="{{ old('horario_domingo', 'Fechado') }}" 
                                   placeholder="Fechado">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Personalização Visual --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-palette text-warning me-2"></i>
                        Personalização Visual
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Cor Principal</label>
                        <div class="color-options">
                            <div class="row g-2">
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="cor_principal" id="cor1" value="#ffc107" checked>
                                    <label class="btn btn-outline-secondary w-100 p-2" for="cor1">
                                        <div class="rounded" style="background: #ffc107; height: 30px;"></div>
                                        <small class="d-block mt-1">Amarelo</small>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="cor_principal" id="cor2" value="#e91e63">
                                    <label class="btn btn-outline-secondary w-100 p-2" for="cor2">
                                        <div class="rounded" style="background: #e91e63; height: 30px;"></div>
                                        <small class="d-block mt-1">Rosa</small>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="cor_principal" id="cor3" value="#2196f3">
                                    <label class="btn btn-outline-secondary w-100 p-2" for="cor3">
                                        <div class="rounded" style="background: #2196f3; height: 30px;"></div>
                                        <small class="d-block mt-1">Azul</small>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="cor_principal" id="cor4" value="#4caf50">
                                    <label class="btn btn-outline-secondary w-100 p-2" for="cor4">
                                        <div class="rounded" style="background: #4caf50; height: 30px;"></div>
                                        <small class="d-block mt-1">Verde</small>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="cor_principal" id="cor5" value="#ff5722">
                                    <label class="btn btn-outline-secondary w-100 p-2" for="cor5">
                                        <div class="rounded" style="background: #ff5722; height: 30px;"></div>
                                        <small class="d-block mt-1">Laranja</small>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="cor_principal" id="cor6" value="#9c27b0">
                                    <label class="btn btn-outline-secondary w-100 p-2" for="cor6">
                                        <div class="rounded" style="background: #9c27b0; height: 30px;"></div>
                                        <small class="d-block mt-1">Roxo</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="logo" class="form-label fw-semibold">Logo/Marca</label>
                        <input type="file" 
                               class="form-control" 
                               id="logo" 
                               name="logo" 
                               accept="image/*"
                               onchange="previewImagem(this, 'logoPreview')">
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Recomendado: 200x80px (PNG transparente)
                        </div>
                        
                        <div class="text-center mt-3">
                            <img id="logoPreview" 
                                 src="#" 
                                 alt="Logo Preview" 
                                 class="img-fluid rounded"
                                 style="display: none; max-height: 80px;">
                            
                            <div id="logoPlaceholder" class="border border-dashed border-2 rounded p-3 text-center text-muted">
                                <i class="fas fa-image fa-2x mb-2"></i>
                                <p class="mb-0 small">Selecione sua logo</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="imagem_fundo" class="form-label fw-semibold">Imagem de Fundo</label>
                        <input type="file" 
                               class="form-control" 
                               id="imagem_fundo" 
                               name="imagem_fundo" 
                               accept="image/*"
                               onchange="previewImagem(this, 'fundoPreview')">
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Recomendado: 1920x1080px para melhor qualidade
                        </div>
                        
                        <div class="text-center mt-3">
                            <img id="fundoPreview" 
                                 src="#" 
                                 alt="Fundo Preview" 
                                 class="img-fluid rounded"
                                 style="display: none; max-height: 100px;">
                            
                            <div id="fundoPlaceholder" class="border border-dashed border-2 rounded p-3 text-center text-muted">
                                <i class="fas fa-image fa-2x mb-2"></i>
                                <p class="mb-0 small">Selecione imagem de fundo</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Preview --}}
            <div class="card mt-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-eye me-2"></i>
                        Preview das Mudanças
                    </h6>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-outline-primary w-100 mb-2" onclick="previewSite()">
                        <i class="fas fa-desktop me-2"></i>
                        Ver Preview
                    </button>
                    
                    <button type="button" class="btn btn-outline-success w-100" onclick="window.open('{{ route('pagina-Inicial') }}', '_blank')">
                        <i class="fas fa-external-link-alt me-2"></i>
                        Abrir Site
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Botões de Ação --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            <i class="fas fa-save me-1"></i>
                            <small>As configurações serão aplicadas imediatamente</small>
                        </div>
                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary" onclick="resetarConfiguracoes()">
                                <i class="fas fa-undo me-2"></i>Resetar
                            </button>
                            
                            <button type="button" class="btn btn-outline-info" onclick="exportarConfiguracoes()">
                                <i class="fas fa-download me-2"></i>Exportar
                            </button>
                            
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Salvar Configurações
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Atualizar link do WhatsApp em tempo real
        $('#whatsapp').on('input', function() {
            var numero = $(this).val();
            $('#linkWhatsapp').text('https://wa.me/' + numero);
        });
        
        // Máscara para telefone
        $('#telefone').on('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 11) {
                value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (value.length >= 7) {
                value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else if (value.length >= 3) {
                value = value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
            }
            e.target.value = value;
        });
    });
    
    function previewSite() {
        Swal.fire({
            title: 'Preview das Configurações',
            html: `
                <div class="text-start">
                    <h5>${$('#nome_site').val()}</h5>
                    <p class="text-muted">${$('#descricao_site').val()}</p>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <strong>Telefone:</strong><br>
                            ${$('#telefone').val()}
                        </div>
                        <div class="col-6">
                            <strong>E-mail:</strong><br>
                            ${$('#email').val()}
                        </div>
                    </div>
                </div>
            `,
            icon: 'info',
            showConfirmButton: false,
            showCloseButton: true,
            width: 600
        });
    }
    
    function resetarConfiguracoes() {
        Swal.fire({
            title: 'Resetar configurações?',
            text: 'Isso restaurará as configurações padrão',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, resetar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });
    }
    
    function exportarConfiguracoes() {
        const config = {
            nome_site: $('#nome_site').val(),
            descricao_site: $('#descricao_site').val(),
            telefone: $('#telefone').val(),
            email: $('#email').val(),
            endereco: $('#endereco').val(),
            instagram: $('#instagram').val(),
            facebook: $('#facebook').val(),
            whatsapp: $('#whatsapp').val()
        };
        
        const dataStr = JSON.stringify(config, null, 2);
        const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
        
        const exportFileDefaultName = 'configuracoes_site.json';
        
        const linkElement = document.createElement('a');
        linkElement.setAttribute('href', dataUri);
        linkElement.setAttribute('download', exportFileDefaultName);
        linkElement.click();
        
        Swal.fire({
            icon: 'success',
            title: 'Configurações exportadas!',
            text: 'Arquivo baixado com sucesso',
            timer: 2000,
            showConfirmButton: false
        });
    }
</script>
@endsection
