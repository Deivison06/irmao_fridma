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
        Schema::create('processo_detalhes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('processo_id')->constrained('processos')->onDelete('cascade');
            // Novos campos adicionados
            $table->enum('tipo_procedimento', ['compras', 'servicos'])->nullable();
            $table->enum('tipo_contratacao', ['lote', 'item'])->nullable();
            $table->string('secretaria')->nullable();
            $table->string('unidade_setor')->nullable();
            $table->string('servidor_responsavel')->nullable();

            $table->text('demanda')->nullable();
            $table->text('justificativa')->nullable();
            $table->string('prazo_entrega')->nullable();
            $table->string('local_entrega')->nullable();

            $table->enum('contratacoes_anteriores', ['sim', 'nao'])->nullable();

            $table->string('fiscais')->nullable();
            $table->string('gestor')->nullable();

            // Instrumento Vinculativo (array de opções + outro)
            $table->json('instrumento_vinculativo')->nullable();
            $table->string('instrumento_vinculativo_outro')->nullable();

            // Prazo Vigência (array de opções + outro)
            $table->json('prazo_vigencia')->nullable();
            $table->string('prazo_vigencia_outro')->nullable();

            $table->enum('objeto_continuado', ['sim', 'nao'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processo_detalhes');
    }
};
