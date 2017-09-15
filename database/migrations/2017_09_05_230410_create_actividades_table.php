<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->increments('id');
            $table->string("nombre");
            $table->string("direccion")->nullable();
            $table->string("descripcion")->nullable();
            $table->string("fecha");
            $table->integer("user_id");
            $table->integer("departamento_id");
            $table->integer("municipio_id");
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onUpdate('cascade');
            $table->foreign('municipio_id')->references('id')->on('municipios')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actividades');
    }
}
