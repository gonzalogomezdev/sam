<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('Pacientes', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable()->after('Domicilio');
        });
    }

    public function down()
    {
        Schema::table('Pacientes', function (Blueprint $table) {
            $table->dropColumn('created_at');
        });
    }
};
