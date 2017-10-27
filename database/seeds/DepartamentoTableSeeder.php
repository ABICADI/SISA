<?php

use Illuminate\Database\Seeder;

class DepartamentoTableSeeder extends Seeder {

    public function run() {

      $departamentoss = array(
                  "ALTA VERAPAZ",     //1
                  "BAJA VERAPAZ",     //2
                  "CHIMALTENANGO",    //3
                  "CHIQUIMULA",       //4
                  "GUATEMALA",        //5
                  "EL PROGRESO",      //6
                  "ESCUINTLA",        //7
                  "HUEHUETENANGO",    //8
                  "IZABAL",           //9
                  "JALAPA",           //10
                  "JUTIAPA",          //11
                  "PETÉN",            //12
                  "QUETZALTENANGO",   //13
                  "QUICHÉ",           //14
                  "RETALHULEU",       //15
                  "SACATEPÉQUEZ",     //16
                  "SAN MARCOS",       //17
                  "SANTA ROSA",       //18
                  "SOLOLÁ",           //19
                  "SUCHITEPÉQUEZ",    //20
                  "TOTONICAPÁN",      //21
                  "ZACAPA",           //22
        );


        for($i=0;$i<count($departamentoss);$i++){
            $departamento = factory(App\Departamento::class)->create([
             'nombre' => $departamentoss[$i]
            ]);
        }
    }
}
