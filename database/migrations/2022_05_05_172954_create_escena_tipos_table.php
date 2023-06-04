<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('escena_tipos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 128)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('escena_tipos');
    }
};
