<?php

use Illuminate\Database\Seeder;

class EstadoTableSeeder extends Seeder {

    public function run() {
		
		$estado = factory(App\Estado::class)->create([
            'nombre' => 'Activo',
            'descripcion' => 'El empleado si está asistiendo a la institución'
        ]);

        $estado = factory(App\Estado::class)->create([
            'nombre' => 'Inactivo',
            'descripcion' => 'El empleado no está asistiendo a la institución'
        ]);

        $estado = factory(App\Estado::class)->create([
            'nombre' => 'Suspendido',
            'descripcion' => 'El empleado está en vacaciones'
        ]);
    }
}
