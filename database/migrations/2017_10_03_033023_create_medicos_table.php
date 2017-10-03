<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicosTable extends Migration {

    public function up() {
        Schema::create('medicos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('colegiado',10);
            $table->string('nombre')->nullabel();
            $table->string('telefono')->nullabel();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('medicos');
    }
}
