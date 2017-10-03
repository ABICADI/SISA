<?php

use Illuminate\Database\Seeder;

class PagoTableSeeder extends Seeder {

    public function run() {

      $pago = factory(App\Pago::class)->create([
          'nombre' => 'Municipalidad',
      ]);

      $pago = factory(App\Pago::class)->create([
          'nombre' => 'Apadrinado',
      ]);

      $pago = factory(App\Pago::class)->create([
          'nombre' => 'Prepago',
      ]);

      $pago = factory(App\Pago::class)->create([
          'nombre' => 'Exonerado',
      ]);
    }
}
