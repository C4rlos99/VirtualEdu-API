<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId("escena_id")->constrained()->onDelete("cascade");
            $table->string("valores");
            $table->timestamps();
        });

        Schema::table("escenas", function (Blueprint $table) {
            $table->foreignId("respuesta_id")->nullable(true)->constrained()->onDelete("cascade");
        });
    }

    public function down()
    {
        Schema::dropIfExists('respuestas');
    }
};
