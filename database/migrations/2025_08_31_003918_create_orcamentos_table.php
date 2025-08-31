<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_orcamento')->unique(); // Número sequencial do orçamento
            $table->string('nome_cliente');
            $table->string('email_cliente');
            $table->string('telefone_cliente');
            $table->string('tipo_evento');
            $table->date('data_evento');
            $table->time('horario_evento')->nullable();
            $table->integer('numero_convidados');
            $table->string('local_evento')->nullable();
            $table->text('observacoes')->nullable();
            
            // Valores
            $table->decimal('valor_total', 10, 2)->default(0);
            $table->decimal('desconto', 10, 2)->default(0);
            $table->decimal('valor_final', 10, 2)->default(0);
            
            // Status do orçamento
            $table->enum('status', ['pendente', 'aprovado', 'rejeitado', 'convertido'])->default('pendente');
            $table->text('observacoes_admin')->nullable();
            $table->timestamp('data_aprovacao')->nullable();
            $table->timestamp('data_vencimento')->nullable();
            
            // Controle
            $table->boolean('visualizado_cliente')->default(false);
            $table->boolean('enviado_email')->default(false);
            $table->integer('tentativas_contato')->default(0);
            
            $table->timestamps();
            
            // Índices
            $table->index(['status', 'created_at']);
            $table->index(['email_cliente', 'telefone_cliente']);
            $table->index('data_evento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamentos');
    }
};
