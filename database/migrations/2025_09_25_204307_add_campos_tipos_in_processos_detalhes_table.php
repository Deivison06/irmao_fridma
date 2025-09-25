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
             $table->enum('tipo_procedimento', ['compras', 'servicos'])->nullable();
            $table->enum('tipo_contratacao', ['lote', 'item'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('processo_detalhes', function (Blueprint $table) {
             $table->dropColumn(['tipo_procedimento', 'tipo_contratacao']);
        });
    }
};
