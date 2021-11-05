<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('userid',20);
            $table->bigInteger('tipo_documento',20);
            $table->string('documento',30)->charset('utf32_general_ci');
            $table->string('nombres',250)->charset('utf8_bin');
            $table->string('apellidos',50)->charset('utf8_bin')->nullable();
            $table->string('correo',100)->charset('utf8_bin')->nullable();
            $table->timestamps('fecha_carga');

            $table->foreign('tipo_documento')->references('tipo_documentoId')->on('tipo__documentos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
