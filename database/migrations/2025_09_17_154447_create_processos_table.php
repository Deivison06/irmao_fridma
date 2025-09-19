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
        Schema::create('processos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prefeitura_id');
            $table->enum('modalidade', [1, 2, 3, 4])
                    ->comment('1 - Concorrência, 2 - Dispensa, 3 - Inexigibilidade, 4 - Pregão Eletrônico');
            $table->string('numero_processo', 10);
            $table->string('numero_procedimento', 10);
            $table->text('objeto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processos');
    }
};
