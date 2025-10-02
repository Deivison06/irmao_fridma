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
            $table->string('nome_equipe_planejamento')->nullable()->after('itens_e_seus_quantitativos_xml');
            $table->string('responsavel_equipe_planejamento')->nullable()->after('nome_equipe_planejamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('processo_detalhes', function (Blueprint $table) {
            $table->dropColumn(['nome_equipe_planejamento', 'responsavel_equipe_planejamento']);
        });
    }
};
