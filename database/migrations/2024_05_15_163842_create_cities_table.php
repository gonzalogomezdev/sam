<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Localidades', function (Blueprint $table) {
            $table->bigIncrements('idLocalidad');
            $table->string('Desc_Localidad', 45)->nullable();

            $table->unsignedBigInteger('Provincias_idProvincia');
            $table->foreign('Provincias_idProvincia')->references('idProvincia')->on('Provincias');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Localidades');
    }
};
