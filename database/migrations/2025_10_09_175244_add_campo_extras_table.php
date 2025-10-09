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
            $table->string('encaminhamento_elaborar_editais')->nullable();
            $table->string('encaminhamento_parecer_juridico')->nullable();
            $table->string('encaminhamento_autorizacao_abertura')->nullable();
            $table->string('valor_estimado')->nullable();
            $table->string('portaria_agente_equipe_pdf')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('processo_detalhes', function (Blueprint $table) {
            $table->dropColumn([
                'encaminhamento_elaborar_editais',
                'encaminhamento_parecer_juridico',
                'encaminhamento_autorizacao_abertura',
                'valor_estimado',
                'portaria_agente_equipe_pdf',
            ]);
        });
    }
};
