<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lenguajes', function (Blueprint $table) {
            $table->id();
            $table->char("nombre", 8)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lenguajes');
    }
};
