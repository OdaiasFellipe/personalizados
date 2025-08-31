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
        Schema::create('depoimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_cliente');
            $table->text('depoimento');
            $table->integer('avaliacao')->default(5); // 1-5 estrelas
            $table->string('foto_cliente')->nullable();
            $table->string('evento_tipo')->nullable();
            $table->date('data_evento')->nullable();
            $table->boolean('destaque')->default(false);
            $table->boolean('aprovado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depoimentos');
    }
};
