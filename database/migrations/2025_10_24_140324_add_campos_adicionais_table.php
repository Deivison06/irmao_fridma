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
            $table->string('unidade_numeracao')->nullable()->after('tipo_contratacao');
            $table->string('responsavel_numeracao')->nullable()->after('unidade_numeracao');
            $table->string('portaria_numeracao')->nullable()->after('responsavel_numeracao');
        });
    }

    public function down(): void
    {
        Schema::table('processos', function (Blueprint $table) {
            $table->dropColumn(['unidade_numeracao', 'responsavel_numeracao', 'portaria_numeracao']);
        });
    }
};
