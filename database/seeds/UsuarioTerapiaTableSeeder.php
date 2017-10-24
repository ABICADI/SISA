<?php

use Illuminate\Database\Seeder;

class UsuarioTerapiaTableSeeder extends Seeder {

    public function run() {
        $terapiausuario = factory(App\UsuarioTerapia::class)->create([
            'user_id' => '1',
            'terapia_id' => '1'
        ]);
    }
}
