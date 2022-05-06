<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escenas', function (Blueprint $table) {
            $table->id();
            $table->foreignId("escena_tipo_id")->constrained()->onDelete("cascade");
            $table->foreignId("escena_id")->nullable(true)->constrained()->onDelete("cascade");
            $table->string("respuesta1");
            $table->string("respuesta2")->nullable(true);
            $table->string("respuesta3")->nullable(true);
            $table->foreignId("escenario_id")->constrained()->onDelete("cascade");
            $table->string("url_video", 256);
            $table->string("url_video_apoyo", 256)->nullable(true);
            $table->string("url_video_refuerzo", 256)->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('escenas');
    }
};
