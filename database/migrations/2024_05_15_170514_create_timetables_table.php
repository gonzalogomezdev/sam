<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Horarios', function (Blueprint $table) {
            $table->bigIncrements('idHorario');
            $table->time('Hora')->nullable();
            $table->string('Franja_Horaria', 45)->nullable();
            $table->date('Fecha')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Horarios');
    }
};
