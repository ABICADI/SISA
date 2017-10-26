<?php

use Illuminate\Database\Seeder;

class EstadoTableSeeder extends Seeder {

    public function run() {

              $estado = factory(App\Estado::class)->create([
                  'nombre' => 'ACTIVO',
                  'descripcion' => 'EL EMPLEADO SI ESTÁ ASISTIENDO A LA INSTITUCIÓN'
              ]);

              $estado = factory(App\Estado::class)->create([
                  'nombre' => 'INACTIVO',
                  'descripcion' => 'EL EMPLEADO NO ESTÁ ASISTIENDO A LA INSTITUCIÓN'
              ]);

              $estado = factory(App\Estado::class)->create([
                  'nombre' => 'SUSPENDIDO',
                  'descripcion' => 'EL EMPLEADO ESTÁ EN VACACIONES'
              ]);
          }

}
