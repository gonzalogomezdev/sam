<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Mensajes', function (Blueprint $table) {
            $table->bigIncrements('idMensaje');
            $table->text('Mensaje')->nullable();
            $table->dateTime('Fecha_Hora')->nullable();
            $table->integer('Remitente_id')->nullable();
            $table->integer('Destinatario_id')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Mensajes');
    }
};
