<?php

use Illuminate\Database\Seeder;

class DiaSemanaTableSeeder extends Seeder {

    public function run() {

        $diassSemana = array(
            "Ninguno",      //1
            "Lunes",        //2
            "Martes",       //3
            "Miércoles",    //4
            "Jueves",       //5
            "Viernes",      //6
            "Sábado",       //7
            "Domingo",      //8
        );
        
        for($i=0;$i<count($diassSemana);$i++){
            $diasemana = factory(App\DiaSemana::class)->create([
             'nombre' => $diassSemana[$i]
            ]);
        } 
    }
}
