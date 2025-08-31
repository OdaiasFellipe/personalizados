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
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('categoria'); // Decoração, Fotografia, Catering, etc.
            $table->decimal('preco_base', 8, 2);
            $table->enum('tipo_preco', ['fixo', 'por_pessoa', 'por_hora', 'personalizado']);
            $table->integer('min_pessoas')->nullable(); // Mínimo de pessoas para o serviço
            $table->integer('max_pessoas')->nullable(); // Máximo de pessoas para o serviço
            $table->json('opcoes_extras')->nullable(); // Opções adicionais com preços
            $table->boolean('ativo')->default(true);
            $table->integer('ordem')->default(0);
            $table->string('icone')->nullable(); // Ícone FontAwesome
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            // Índices
            $table->index(['categoria', 'ativo']);
            $table->index(['ativo', 'ordem']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};
