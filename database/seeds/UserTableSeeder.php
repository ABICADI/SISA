<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

    public function run() {
        $user = factory(App\User::class)->create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'dpi' => '000000000000',
            'nombre1' => 'ninguno',
            'nombre2' => 'ninguno',
            'nombre3' => 'ninguno',
            'apellido1' => 'ninguno',
            'apellido2' => 'ninguno',
            'apellido3' => 'ninguno',
            'departamento_id' => '1',
            'municipio_id' => '1',
            'direccion' => 'admin',
            'fecha_nacimiento' => '01/01/2000',
            'fecha_ingreso' => '01/01/2017',
            'telefono' => '00000000',
            'rol_id' => '1',
            'estado_id' => '1',
        ]);
    }
}
