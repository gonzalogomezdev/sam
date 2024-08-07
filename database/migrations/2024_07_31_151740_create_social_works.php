<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Obras_sociales', function (Blueprint $table) {
            $table->id('idObraSocial');
            $table->text('Nombre')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Obras_sociales');
    }
};
