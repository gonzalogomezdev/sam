<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Turnos_Bloqueados', function (Blueprint $table) {
            $table->bigIncrements('idTurnoBloqueado');
            $table->date('Fecha')->nullable();
            $table->time('Hora')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Turnos_Bloqueados');
    }
};
