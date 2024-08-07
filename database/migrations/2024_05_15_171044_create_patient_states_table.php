<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Estados_Pacientes', function (Blueprint $table) {
            $table->bigIncrements('idEstado');
            $table->tinyInteger('Habilitado')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Estados_Pacientes');
    }
};
