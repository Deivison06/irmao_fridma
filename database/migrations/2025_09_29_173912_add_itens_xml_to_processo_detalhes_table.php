<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('processo_detalhes', function (Blueprint $table) {
            $table->json('itens_e_seus_quantitativos_xml')->nullable(); // para armazenar XML/JSON
        });
    }

    public function down()
    {
        Schema::table('processo_detalhes', function (Blueprint $table) {
            $table->dropColumn('itens_e_seus_quantitativos_xml');
        });
    }
};
