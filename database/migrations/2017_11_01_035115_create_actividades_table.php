<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadesTable extends Migration {

    public function up() {
        Schema::create('actividades', function (Blueprint $table) {
            $table->increments('id');
            $table->string("nombre");
            $table->string("direccion")->nullable();
            $table->string("descripcion",1000)->nullable();
            $table->date("fecha");
            $table->integer("user_id");
            $table->integer("municipio_id");
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');            $table->foreign('municipio_id')->references('id')->on('municipios')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('actividades');
    }
}
