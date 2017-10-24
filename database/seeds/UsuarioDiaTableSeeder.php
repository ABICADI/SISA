<?php

use Illuminate\Database\Seeder;

class UsuarioDiaTableSeeder extends Seeder {

    public function run() {

        $diassSemana = array(
            "2",        
            "3",       
            "4",    
            "5",       
            "6",      
        );
        
        for($i=0;$i<count($diassSemana);$i++){
            $diausuario = factory(App\UsuarioDia::class)->create([
             'diasemana_id' => $diassSemana[$i],
             'user_id' => '1'
            ]);
        } 
    }
}
