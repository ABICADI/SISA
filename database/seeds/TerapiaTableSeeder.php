<?php

use Illuminate\Database\Seeder;

class TerapiaTableSeeder extends Seeder {

    public function run() {

        $terapia = factory(App\Terapia::class)->create([
            'nombre' => 'Ninguna',
            'descripcion' => 'Ninguna',
            'color' => '#14eebb'
        ]);

		$terapia = factory(App\Terapia::class)->create([
            'nombre' => 'Fisioterapia',
            'descripcion' => 'Esta es una área de terapia física, los pacientes aprenden a levantarse, gatear, rodar, sentarse y sostener el peso.',
            'color' => '#14eebb'
        ]);

        $terapia = factory(App\Terapia::class)->create([
            'nombre' => 'Terapia del Lenguaje',
            'descripcion' => 'Con el apoyo de material interactivo, los pacientes aprenden a expresarse y desarrollar el lenguaje y la comprensión, se trabajan ejercicios de relajación, de mandíbula, músculos de la boca para adquirir la fuerza necesaria para comer y hablar.',
            'color' => '#14eebb'
        ]);

        $terapia = factory(App\Terapia::class)->create([
            'nombre' => 'Terapia Ocupacional',
            'descripcion' => 'Los ejercicios con objetos de uso cotidiano ayudan a los pacientes a independizarse con el propósito que cada paciente pueda realizar actividades basicas en el hogar por si solos.',
            'color' => '#14eebb'
        ]);

        $terapia = factory(App\Terapia::class)->create([
            'nombre' => 'Educación Especial',
            'descripcion' => 'En esta área los pacientes aprenden a utilizar su memoria y a reconocer letras u objetos que hayan olvidado. Se utiliza material de apoyo acorde a la necesidad de cada paciente y se estimula su cerebro.',
            'color' => '#14eebb'
        ]);


        $terapia = factory(App\Terapia::class)->create([
            'nombre' => 'Mecanoterapia',
            'descripcion' => 'Esta área ayuda a niños y adultos a controlar su peso y lograr un equilibrio adecuado. Aparatos como bicicleta, elípticas ayudan a desarrolar los músculos y a la fuerza de cada paciente.',
            'color' => '#14eebb'
        ]);
    }
}
