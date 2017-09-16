<?php

use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder {
    
    public function run() {
        
        $this->call(RolTableSeeder::class);
        $this->call(EstadoTableSeeder::class);
        $this->call(TerapiaTableSeeder::class);
        $this->call(DiaSemanaTableSeeder::class);
        $this->call(DepartamentoTableSeeder::class);
        $this->call(MunicipioTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(UsuarioDiaTableSeeder::class);
        $this->call(UsuarioTerapiaTableSeeder::class);
    }
}