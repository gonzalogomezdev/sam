<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Pacientes', function (Blueprint $table) {
            $table->bigIncrements('idPaciente');
            $table->string('Nombre', 80)->nullable();
            $table->string('Apellido', 80)->nullable();
            $table->string('DNI', 10)->nullable();
            $table->string('Telefono', 15)->nullable();
            $table->date('Fecha_Nacimiento')->nullable();
            $table->string('Domicilio', 45)->nullable();

            $table->unsignedBigInteger('Localidades_idLocalidad');
            $table->foreign('Localidades_idLocalidad')->references('idLocalidad')->on('Localidades');
        
            $table->unsignedBigInteger('Generos_idGenero');
            $table->foreign('Generos_idGenero')->references('idGenero')->on('Generos');
 
            $table->unsignedBigInteger('Estados_Civiles_idEstado_Civil');
            $table->foreign('Estados_Civiles_idEstado_Civil')->references('idEstado_Civil')->on('Estados_Civiles');

            $table->unsignedBigInteger('Roles_idRol');
            $table->foreign('Roles_idRol')->references('idRol')->on('Roles');

            $table->unsignedBigInteger('Estados_Pacientes_idEstado');
            $table->foreign('Estados_Pacientes_idEstado')->references('idEstado')->on('Estados_Pacientes');

            $table->unsignedBigInteger('Usuarios_idUsuario');
            $table->foreign('Usuarios_idUsuario')->references('idUsuario')->on('Usuarios');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Pacientes');
    }
};
