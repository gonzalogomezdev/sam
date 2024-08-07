<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Estados_Civiles', function (Blueprint $table) {
            $table->bigIncrements('idEstado_Civil');
            $table->string('Desc_Estado', 45)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Estados_Civiles');
    }
};
