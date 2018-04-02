<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FacebookMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_facebook')->unique(); //id del perfil o la pagina
            $table->string('email')->unique();
            $table->string('nombre'); //Nombre del perfil o la pagina
            $table->text('access_token');
            $table->text('data');
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
        Schema::drop('facebook');
    }
}
