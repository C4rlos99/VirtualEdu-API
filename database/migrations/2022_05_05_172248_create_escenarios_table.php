<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('escenarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId("usuario_id")->constrained()->onDelete("cascade");
            $table->string("titulo", 64);
            $table->boolean("visible");
            $table->boolean("eliminado")->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('escenarios');
    }
};
