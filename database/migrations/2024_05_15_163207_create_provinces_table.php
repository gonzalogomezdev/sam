<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Provincias', function (Blueprint $table) {
            $table->bigIncrements('idProvincia');
            $table->string('Desc_Prov', 45);
        });
    }

    public function down()
    {
        Schema::dropIfExists('Provincias');
    }
};
