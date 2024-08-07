<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Estados_Historiales', function (Blueprint $table) {
            $table->bigIncrements('idEstado_Historial');
            $table->string('Desc_Historial', 45)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('history_states');
    }
};
