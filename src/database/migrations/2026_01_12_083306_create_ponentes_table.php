<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ponentes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('biografia');
            $table->string('especialidad');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ponentes');
    }
};