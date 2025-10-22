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
            $table->string('pregoeiro')->nullable();
            $table->string('numero_items')->nullable();
            $table->dateTime('data_hora_limite_edital')->nullable();
            $table->dateTime('data_hora_fase_edital')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('processo_detalhes', function (Blueprint $table) {
            $table->dropColumn(['pregoeiro', 'numero_items', 'data_hora_limite_edital', 'data_hora_fase_edital']);
        });
    }
};
