<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Roles', function (Blueprint $table) {
            $table->bigIncrements('idRol');
            $table->string('Desc_Rol', 45)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Roles');
    }
};
