<?php

use Illuminate\Database\Seeder;

class GeneroTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run() {
         $medico = factory(App\Genero::class)->create([
             'nombre' => 'FEMENINO'
         ]);

         $medico = factory(App\Genero::class)->create([
             'nombre' => 'MASCULINO'
         ]);
     }
}
