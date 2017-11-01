<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicosTable extends Migration {

    public function up() {
        Schema::create('medicos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('colegiado',10);
            $table->string('nombre');
            $table->string('telefono',8)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('medicos');
    }
}
