<?php

use Illuminate\Database\Seeder;

class DepartamentoTableSeeder extends Seeder {

    public function run() {

		$departamentoss = array(
            "Alta Verapaz",     //1
            "Baja Verapaz",     //2
            "Chimaltenango",    //3
            "Chiquimula",       //4
            "Guatemala",        //5
            "El Progreso",      //6
            "Escuintla",        //7
            "Huehuetenango",    //8
            "Izabal",           //9
            "Jalapa",           //10
            "Jutiapa",          //11
            "Petén",            //12
            "Quetzaltenango",   //13
            "Quiché",           //14
            "Retalhuleu",       //15
            "Sacatepéquez",     //16
            "San Marcos",       //17
            "Santa Rosa",       //18
            "Sololá",           //19
            "Suchitepéquez",    //20
            "Totonicapán",      //21
            "Zacapa",           //22
        );
        
        for($i=0;$i<count($departamentoss);$i++){
            $departamento = factory(App\Departamento::class)->create([
             'nombre' => $departamentoss[$i]
            ]);
        } 
    }
}
