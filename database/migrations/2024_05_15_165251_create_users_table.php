<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Usuarios', function (Blueprint $table) {
            $table->bigIncrements('idUsuario');
            $table->string('Email', 80)->nullable();
            $table->string('Password', 255)->nullable();
            $table->string('Token', 255)->nullable();
            $table->boolean('Email_verified')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Usuarios');
    }
};
