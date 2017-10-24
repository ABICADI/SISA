<?php

use Illuminate\Database\Seeder;

class RolTableSeeder extends Seeder {

    public function run() {

    	$rol = factory(App\Rol::class)->create([
            'nombre' => 'Administrador',
            'descripcion' => 'El Administrador podrá hacer los siguientes procesos: Ver, Insertar, Eliminar, Buscar, Actualizar'
        ]);

        $rol = factory(App\Rol::class)->create([
            'nombre' => 'Secretaria',
            'descripcion' => 'La Secretaria podrá hacer los siguientes procesos: Ver, Insertar, Buscar, Actualizar'
        ]);

        $rol = factory(App\Rol::class)->create([
            'nombre' => 'Empleado',
            'descripcion' => 'El Empleado podrá hacer los siguientes procesos: Ver, Buscar'
        ]);

        $rol = factory(App\Rol::class)->create([
            'nombre' => 'Voluntario',
            'descripcion' => 'El Voluntario podrá hacer los siguientes procesos: Ver, Buscar'
        ]);
    }
}
