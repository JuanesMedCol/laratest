<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioCertificadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario__certificados', function (Blueprint $table) {
            $table->bigIncrements('certificadoId',20);
            $table->string('documento',30);
            $table->string('codigoCurso',40)->charset('utf32_general_ci');
            $table->string('tipoCertificacion',150)->charset('utf32_general_ci');
            $table->dateTime('fechaDescarga')->nullable();
            $table->integer('estadoDescarga',1)->nullable();
            $table->timestamps('fechaCarga');
            $table->string('calificacion',6)->charset('utf32_general_ci')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario__certificados');
    }
}
