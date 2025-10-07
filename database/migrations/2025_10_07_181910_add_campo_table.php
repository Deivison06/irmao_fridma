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
            $table->enum('tipo_srp', ['sim', 'nao'])->nullable();
            $table->enum('prevista_plano_anual', ['sim', 'nao'])->nullable();
            $table->string('encaminhamento_pesquisa_preco')->nullable();
            $table->string('encaminhamento_doacao_orcamentaria')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('processo_detalhes', function (Blueprint $table) {
            $table->dropColumn([
                'tipo_srp',
                'prevista_plano_anual',
                'encaminhamento_pesquisa_preco',
                'encaminhamento_doacao_orcamentaria',
            ]);
        });
    }
};
