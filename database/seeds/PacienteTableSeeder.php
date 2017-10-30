<?php

use Illuminate\Database\Seeder;

class PacienteTableSeeder extends Seeder {

    public function run() {
        $paciente = factory(App\Paciente::class)->create([
            'cui' => '4523658965425',
            'nombre1' => 'Hola',
            'nombre2' => 'Mundo',
            'nombre3' => 'Prueba',
            'apellido1' => 'Paciente',
            'apellido2' => 'Nuevo',
            'apellido3' => 'Uno',
            'municipio_id' => '2',
            'direccion' => 'Al otro lado',
            'fecha_nacimiento' => '18/12/1993',
            'encargado' => 'El primero en llegar',
            'fecha_ingreso' => '02/10/2017',
            'telefono' => '00000000',
            'seguro_social' => '5698',
            'observacion' => 'Ninguna por el momento',
            'pago_id' => '1'
        ]);
    }
}
