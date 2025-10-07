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
            $table->string('solucao_escolhida')->nullable();
            $table->text('justificativa_solucao_escolhida')->nullable();
            $table->text('impacto_ambiental')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('processo_detalhes', function (Blueprint $table) {
            $table->dropColumn(['solucao_escolhida', 'justificativa_solucao_escolhida', 'impacto_ambiental']);
        });
    }
};
