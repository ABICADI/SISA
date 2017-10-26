<?php

use Illuminate\Database\Seeder;

class DiaSemanaTableSeeder extends Seeder {

    public function run() {

        $diassSemana = array(
            "NINGUNO",      //1
            "LUNES",        //2
            "MARTES",       //3
            "MIÉRCOLES",    //4
            "JUEVES",       //5
            "VIERNES",      //6
            "SÁBADO",       //7
            "DOMINGO",      //8
        );

        for($i=0;$i<count($diassSemana);$i++){
            $diasemana = factory(App\DiaSemana::class)->create([
             'nombre' => $diassSemana[$i]
            ]);
        }
    }
}
