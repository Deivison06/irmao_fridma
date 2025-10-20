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
        Schema::table('processo_detalhes', function (Blueprint $table) {
            $table->text('intervalo_lances')->nullable();
            $table->enum('exigencia_garantia_proposta', ['sim', 'nao'])->nullable();
            $table->enum('exigencia_garantia_contrato', ['sim', 'nao'])->nullable();
            $table->enum('participacao_exclusiva_mei_epp', ['sim', 'nao'])->nullable();
            $table->enum('reserva_cotas_mei_epp', ['sim', 'nao'])->nullable();
            $table->enum('prioridade_contratacao_mei_epp', ['sim', 'nao'])->nullable();
            $table->text('exigencias_tecnicas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('processo_detalhes', function (Blueprint $table) {
            //
        });
    }
};
