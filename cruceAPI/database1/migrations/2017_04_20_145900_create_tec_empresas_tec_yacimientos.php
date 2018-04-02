<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTecEmpresasTecYacimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tec_empresas_tec_yacimientos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_empresa');
            $table->foreign('id_empresa')->references('id')->on('tec_empresas');
            $table->integer('id_yacimiento');
            $table->foreign('id_yacimiento')->references('id')->on('tec_yacimientos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tec_empresas_tec_yacimientos');
    }
}
