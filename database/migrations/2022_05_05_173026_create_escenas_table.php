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
            $table->foreignId("escena_tipo_id")->constrained()->onDelete("cascade");
            $table->foreignId("escenario_id")->constrained()->onDelete("cascade");
            $table->string("url_video", 256);
            $table->string("url_video_apoyo", 256)->nullable(true);
            $table->string("url_video_refuerzo", 256)->nullable(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('escenas');
    }
};
