<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('escenas', function (Blueprint $table) {
            $table->id();
            $table->string("titulo", 256);
            $table->foreignId("escena_tipo_id")->constrained()->onDelete("cascade");
            $table->foreignId("escenario_id")->constrained()->onDelete("cascade");
            $table->foreignId("video_id");
            $table->foreignId("video_apoyo_id")->nullable();
            $table->foreignId("video_refuerzo_id")->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('escenas');
    }
};
