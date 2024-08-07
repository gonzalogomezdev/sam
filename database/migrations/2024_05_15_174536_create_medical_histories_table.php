<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Historiales_Clinicos', function (Blueprint $table) {
            $table->bigIncrements('idHistorial');
            $table->text('Diagnostico')->nullable();
            $table->text('Tratamiento')->nullable();
            $table->text('Medicamento')->nullable();
            $table->date('Fecha');

            $table->unsignedBigInteger('Pacientes_idPaciente');
            $table->foreign('Pacientes_idPaciente')->references('idPaciente')->on('Pacientes');

            $table->unsignedBigInteger('Historiales_idEstado_Historial');
            $table->foreign('Historiales_idEstado_Historial')->references('idEstado_Historial')->on('Estados_Historiales');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Historiales_Clinicos');
    }
};
