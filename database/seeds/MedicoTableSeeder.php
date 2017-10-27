<?php

use Illuminate\Database\Seeder;

class MedicoTableSeeder extends Seeder {

    public function run() {
        $medico = factory(App\Medico::class)->create([
            'colegiado' => '012',
            'nombre' => 'El Dr. Mielita',
            'telefono' => '00000000'
        ]);
    }
}
