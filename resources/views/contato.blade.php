
@extends('layouts.app')

@section('title', 'Contato - NE Fotografias e Personalizados')

@section('content')
    {{-- Header da página --}}
    <section class="page-header py-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-envelope text-warning me-3"></i>
                        Entre em Contato
                    </h1>
                    <p class="lead text-muted">Vamos conversar sobre sua festa dos sonhos!</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row g-5">
            {{-- Formulário de contato --}}
            <div class="col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4">Envie sua mensagem</h3>
                        
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nome" class="form-label fw-semibold">Nome completo</label>
                                    <input type="text" class="form-control form-control-lg" id="nome" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">E-mail</label>
                                    <input type="email" class="form-control form-control-lg" id="email" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="telefone" class="form-label fw-semibold">Telefone/WhatsApp</label>
                                    <input type="tel" class="form-control form-control-lg" id="telefone" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="evento" class="form-label fw-semibold">Tipo de evento</label>
                                    <select class="form-select form-select-lg" id="evento">
                                        <option value="">Selecione...</option>
                                        <option value="aniversario-infantil">Aniversário Infantil</option>
                                        <option value="aniversario-adulto">Aniversário Adulto</option>
                                        <option value="festa-tematica">Festa Temática</option>
                                        <option value="outro">Outro</option>
                                    </select>
                                </div>
                                
                                <div class="col-12">
                                    <label for="mensagem" class="form-label fw-semibold">Conte-nos sobre sua festa</label>
                                    <textarea class="form-control" id="mensagem" rows="5" 
                                              placeholder="Descreva sua festa: tema, data, número de convidados, produtos de interesse..."></textarea>
                                </div>
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-warning btn-lg px-5 py-3">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        Enviar Mensagem
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Informações de contato --}}
            <div class="col-lg-4">
                <div class="contact-info">
                    {{-- WhatsApp --}}
                    <div class="contact-card mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="contact-icon mb-3">
                                    <i class="fab fa-whatsapp fa-3x text-success"></i>
                                </div>
                                <h5 class="fw-bold mb-2">WhatsApp</h5>
                                <p class="text-muted mb-3">Resposta mais rápida</p>
                                <a href="https://wa.me/5511999999999" class="btn btn-success btn-lg w-100">
                                    <i class="fab fa-whatsapp me-2"></i>
                                    Chamar no WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Instagram --}}
                    <div class="contact-card mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="contact-icon mb-3">
                                    <i class="fab fa-instagram fa-3x text-danger"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Instagram</h5>
                                <p class="text-muted mb-3">Veja nossos trabalhos</p>
                                <a href="#" class="btn btn-outline-danger btn-lg w-100">
                                    <i class="fab fa-instagram me-2"></i>
                                    @ne_personalizados
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- E-mail --}}
                    <div class="contact-card mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="contact-icon mb-3">
                                    <i class="fas fa-envelope fa-3x text-warning"></i>
                                </div>
                                <h5 class="fw-bold mb-2">E-mail</h5>
                                <p class="text-muted mb-3">contato@nepersonalizados.com</p>
                                <a href="mailto:contato@nepersonalizados.com" class="btn btn-outline-warning btn-lg w-100">
                                    <i class="fas fa-envelope me-2"></i>
                                    Enviar E-mail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Seção de horários --}}
        <div class="row mt-5">
            <div class="col-12">
                <div class="card bg-light border-0">
                    <div class="card-body p-5 text-center">
                        <h4 class="fw-bold mb-4">
                            <i class="fas fa-clock text-warning me-2"></i>
                            Horários de Atendimento
                        </h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="schedule-item">
                                    <h6 class="fw-bold">Segunda a Sexta</h6>
                                    <p class="text-muted mb-0">09:00 às 18:00</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="schedule-item">
                                    <h6 class="fw-bold">Sábado</h6>
                                    <p class="text-muted mb-0">09:00 às 14:00</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="schedule-item">
                                    <h6 class="fw-bold">Domingo</h6>
                                    <p class="text-muted mb-0">Fechado</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection