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
        Schema::table('processos', function (Blueprint $table) {
            $table->enum('tipo_procedimento', ['1', '2'])->comment('1-SERVIÇOS, 2-COMPRAS')->nullable();
            $table->enum('tipo_contratacao', ['1', '2'])->comment('1-LOTE, 2-ITEM')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('processos', function (Blueprint $table) {
             $table->dropColumn(['tipo_procedimento', 'tipo_contratacao']);
        });
    }
};
