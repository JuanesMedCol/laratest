<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario__admins', function (Blueprint $table) {
            $table->bigIncrements('adminId',20);
            $table->string('nombre',250)->charset('utf8_bin');
            $table->string('email',100)->charset('utf8_bin');
            $table->string('contrasena',100)->charset('utf8_bin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario__admins');
    }
}
