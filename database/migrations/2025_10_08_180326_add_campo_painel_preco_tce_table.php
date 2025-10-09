<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('processo_detalhes', function (Blueprint $table) {
            $table->json('painel_preco_tce')->nullable();
            $table->string('anexo_pdf_analise_mercado')->nullable();
        });
    }

    public function down()
    {
        Schema::table('processo_detalhes', function (Blueprint $table) {
            $table->dropColumn(['painel_preco_tce', 'anexo_pdf_analise_mercado']);
        });
    }
};
