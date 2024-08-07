<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Generos', function (Blueprint $table) {
            $table->bigIncrements('idGenero');
            $table->string('Desc_Genero', 45)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Generos');
    }
};
