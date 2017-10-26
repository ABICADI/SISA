<?php

use Illuminate\Database\Seeder;

class PagoTableSeeder extends Seeder {

    public function run() {
      $pago = factory(App\Pago::class)->create([
          'nombre' => 'MUNICIPALIDAD',
      ]);

      $pago = factory(App\Pago::class)->create([
          'nombre' => 'APADRINADO',
      ]);

      $pago = factory(App\Pago::class)->create([
          'nombre' => 'PREPAGO',
      ]);

      $pago = factory(App\Pago::class)->create([
          'nombre' => 'EXONERADO',
      ]);
    }
}
