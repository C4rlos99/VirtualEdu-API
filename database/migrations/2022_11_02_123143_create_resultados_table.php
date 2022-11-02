<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('resultados', function (Blueprint $table) {
            $table->id();
            $table->foreignId("usuario_id")->nullable()->constrained()->onDelete("set null");
            $table->foreignId("escenario_id")->nullable()->constrained()->onDelete("set null");
            $table->string("respuestas");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resultados');
    }
};
