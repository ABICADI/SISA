<?php

use Illuminate\Database\Seeder;

class RolTableSeeder extends Seeder {

    public function run() {
      $rol = factory(App\Rol::class)->create([
          'nombre' => 'ADMINISTRADOR',
          'descripcion' => 'EL ADMINISTRADOR PODRÁ HACER LOS SIGUIENTES PROCESOS: VER, INSERTAR, ELIMINAR, BUSCAR, ACTUALIZAR'
      ]);

      $rol = factory(App\Rol::class)->create([
          'nombre' => 'SECRETARIA',
          'descripcion' => 'LA SECRETARIA PODRÁ HACER LOS SIGUIENTES PROCESOS: VER, INSERTAR, BUSCAR, ACTUALIZAR'
      ]);

      $rol = factory(App\Rol::class)->create([
          'nombre' => 'EMPLEADO',
          'descripcion' => 'EL EMPLEADO PODRÁ HACER LOS SIGUIENTES PROCESOS: VER, BUSCAR'
      ]);

      $rol = factory(App\Rol::class)->create([
          'nombre' => 'VOLUNTARIO',
          'descripcion' => 'EL VOLUNTARIO PODRÁ HACER LOS SIGUIENTES PROCESOS: VER, BUSCAR'
      ]);
    }
}
