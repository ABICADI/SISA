<?php

use Illuminate\Database\Seeder;

class TerapiaTableSeeder extends Seeder {

    public function run() {
      $terapia = factory(App\Terapia::class)->create([
          'nombre' => 'NINGUNA',
          'descripcion' => 'NINGUNA',
          'color' => '#ff3333'
      ]);

      $terapia = factory(App\Terapia::class)->create([
          'nombre' => 'FISIOTERAPIA',
          'descripcion' => 'ESTA ES UNA ÁREA DE TERAPIA FÍSICA, LOS PACIENTES APRENDEN A LEVANTARSE, GATEAR, RODAR, SENTARSE Y SOSTENER EL PESO.',
          'color' => '#33c4ff'
      ]);

      $terapia = factory(App\Terapia::class)->create([
          'nombre' => 'TERAPIA DEL LENGUAJE',
          'descripcion' => 'CON EL APOYO DE MATERIAL INTERACTIVO, LOS PACIENTES APRENDEN A EXPRESARSE Y DESARROLLAR EL LENGUAJE Y LA COMPRENSIÓN, SE TRABAJAN EJERCICIOS DE RELAJACIÓN, DE MANDÍBULA, MÚSCULOS DE LA BOCA PARA ADQUIRIR LA FUERZA NECESARIA PARA COMER Y HABLAR.',
          'color' => '#33ff6e'
      ]);

      $terapia = factory(App\Terapia::class)->create([
          'nombre' => 'TERAPIA OCUPACIONAL',
          'descripcion' => 'LOS EJERCICIOS CON OBJETOS DE USO COTIDIANO AYUDAN A LOS PACIENTES A INDEPENDIZARSE CON EL PROPÓSITO QUE CADA PACIENTE PUEDA REALIZAR ACTIVIDADES BASICAS EN EL HOGAR POR SI SOLOS.',
          'color' => '#4c33ff'
      ]);

      $terapia = factory(App\Terapia::class)->create([
          'nombre' => 'EDUCACIÓN ESPECIAL',
          'descripcion' => 'EN ESTA ÁREA LOS PACIENTES APRENDEN A UTILIZAR SU MEMORIA Y A RECONOCER LETRAS U OBJETOS QUE HAYAN OLVIDADO. SE UTILIZA MATERIAL DE APOYO ACORDE A LA NECESIDAD DE CADA PACIENTE Y SE ESTIMULA SU CEREBRO.',
          'color' => '#be33ff'
      ]);

      $terapia = factory(App\Terapia::class)->create([
          'nombre' => 'MECANOTERAPIA',
          'descripcion' => 'ESTA ÁREA AYUDA A NIÑOS Y ADULTOS A CONTROLAR SU PESO Y LOGRAR UN EQUILIBRIO ADECUADO. APARATOS COMO BICICLETA, ELÍPTICAS AYUDAN A DESARROLAR LOS MÚSCULOS Y A LA FUERZA DE CADA PACIENTE.',
          'color' => '#6b0a46'
      ]);
    }
}
