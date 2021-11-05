<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->bigIncrements('cursoId',20);
            $table->string('codigoCurso',100)->charset('latin1_swedish_ci');
            $table->string('nombreCurso',150)->charset('latin1_swedish_ci');
            $table->string('nombreCurso2',100)->charset('latin1_swedish_ci');
            $table->bigInteger('plantillaId',2);
            $table->integer('horas',4);
            $table->timestamps('fechaCertificacion');
            $table->string('texto1',255)->charset('latin1_swedish_ci');
            $table->string('texto2',255)->charset('latin1_swedish_ci');
            $table->string('texto3',255)->charset('latin1_swedish_ci');
            $table->string('url_encuesta')->charset('latin1_swedish_ci');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos');
    }
}
