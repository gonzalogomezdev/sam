<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Turnos', function (Blueprint $table) {
            $table->bigIncrements('idTurno');
            $table->date('Fecha')->nullable();
            $table->integer('Estado_Turno')->nullable();

            $table->unsignedBigInteger('Horarios_idHorario');
            $table->foreign('Horarios_idHorario')->references('idHorario')->on('Horarios');

            $table->unsignedBigInteger('Pacientes_idPaciente');
            $table->foreign('Pacientes_idPaciente')->references('idPaciente')->on('Pacientes');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Turnos');
    }
};
