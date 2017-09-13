<?php

use Illuminate\Database\Seeder;

class Municipioss {
    public $municipio;
    public $id_depto;

    public function guardar($id_depto,$municipio){
        $user = factory(App\Municipio::class)->create([
            'departamento_id' => $id_depto,
            'nombre' => $municipio
        ]);
    }
}

class DatabaseSeeder extends Seeder {
    
    public function run() {
        $user = factory(App\Rol::class)->create([
            'nombre' => 'Administrador',
            'descripcion' => 'El Administrador podrá hacer los siguientes procesos: Ver, Insertar, Eliminar, Buscar, Actualizar'
        ]);

        $user = factory(App\Rol::class)->create([
            'nombre' => 'Secretaria',
            'descripcion' => 'La Secretaria podrá hacer los siguientes procesos: Ver, Insertar, Buscar, Actualizar'
        ]);

        $user = factory(App\Rol::class)->create([
            'nombre' => 'Empleado',
            'descripcion' => 'El Empleado podrá hacer los siguientes procesos: Ver, Buscar'
        ]);

        $user = factory(App\Rol::class)->create([
            'nombre' => 'Voluntario',
            'descripcion' => 'El Voluntario podrá hacer los siguientes procesos: Ver, Buscar'
        ]);

        $user = factory(App\Estado::class)->create([
            'nombre' => 'Activo',
            'descripcion' => 'El empleado si está asistiendo a la institución'
        ]);

        $user = factory(App\Estado::class)->create([
            'nombre' => 'Inactivo',
            'descripcion' => 'El empleado no está asistiendo a la institución'
        ]);

        $user = factory(App\Estado::class)->create([
            'nombre' => 'Suspendido',
            'descripcion' => 'El empleado está en vacaciones'
        ]);

        $user = factory(App\Terapia::class)->create([
            'nombre' => 'Fisioterapia',
            'descripcion' => 'Esta es una área de terapia física, los pacientes aprenden a levantarse, gatear, rodar, sentarse y sostener el peso.'
        ]);

        $user = factory(App\Terapia::class)->create([
            'nombre' => 'Terapia del Lenguaje',
            'descripcion' => 'Con el apoyo de material interactivo, los pacientes aprenden a expresarse y desarrollar el lenguaje y la comprensión, se trabajan ejercicios de relajación, de mandíbula, músculos de la boca para adquirir la fuerza necesaria para comer y hablar.'  
        ]);

        $user = factory(App\Terapia::class)->create([
            'nombre' => 'Terapia Ocupacional',
            'descripcion' => 'Los ejercicios con objetos de uso cotidiano ayudan a los pacientes a independizarse con el propósito que cada paciente pueda realizar actividades basicas en el hogar por si solos.'
        ]);

        $user = factory(App\Terapia::class)->create([
            'nombre' => 'Educación Especial',
            'descripcion' => 'En esta área los pacientes aprenden a utilizar su memoria y a reconocer letras u objetos que hayan olvidado. Se utiliza material de apoyo acorde a la necesidad de cada paciente y se estimula su cerebro.'
        ]);


        $user = factory(App\Terapia::class)->create([
            'nombre' => 'Mecanoterapia',
            'descripcion' => 'Esta área ayuda a niños y adultos a controlar su peso y lograr un equilibrio adecuado. Aparatos como bicicleta, elípticas ayudan a desarrolar los músculos y a la fuerza de cada paciente.'
        ]);

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
            $user = factory(App\DiaSemana::class)->create([
             'nombre' => $diassSemana[$i]
            ]);
        } 
        
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
            $user = factory(App\Departamento::class)->create([
             'nombre' => $departamentoss[$i]
            ]);
        }      

        $municipioss = new Municipioss();
        $municipioss->guardar("1","Chanal");
        $municipioss->guardar("1","Chisec");
        $municipioss->guardar("1","Cobán");
        $municipioss->guardar("1","Fray Bartolomé de las Casas");
        $municipioss->guardar("1","Lanquín");
        $municipioss->guardar("1","Panzós");
        $municipioss->guardar("1","San Cristóbal Verapaz");
        $municipioss->guardar("1","San Juan Chamelco");
        $municipioss->guardar("1","San Pedro Carchá");
        $municipioss->guardar("1","Santa Catalina La Tinta");
        $municipioss->guardar("1","Santa Cruz Verapaz");
        $municipioss->guardar("1","Santa María Cahabón");
        $municipioss->guardar("1","Senahú");
        $municipioss->guardar("1","Tactic");
        $municipioss->guardar("1","Tamahú");
        $municipioss->guardar("1","Tucurú");
        $municipioss->guardar("1","Raxuha");
        $municipioss->guardar("2","Cubulco");
        $municipioss->guardar("2","Granados");
        $municipioss->guardar("2","Parulhá");
        $municipioss->guardar("2","Rabinal");
        $municipioss->guardar("2","Salamá");
        $municipioss->guardar("2","San Jerónimo");
        $municipioss->guardar("2","San Miguel Chicaj");
        $municipioss->guardar("2","Santa Cruz el Chol");
        $municipioss->guardar("3","Acatenango");
        $municipioss->guardar("3","Chimaltenango");
        $municipioss->guardar("3","El tejar");
        $municipioss->guardar("3","Parramos");
        $municipioss->guardar("3","Patzicía");
        $municipioss->guardar("3","Patzún");
        $municipioss->guardar("3","San Adrés Itzapa");
        $municipioss->guardar("3","San José Poaquil");
        $municipioss->guardar("3","San Juan Comalapa");
        $municipioss->guardar("3","San Martín Jilotepeque");
        $municipioss->guardar("3","San Miguel Pochuta");
        $municipioss->guardar("3","San Pedro Yepocapa");
        $municipioss->guardar("3","Santa Apolonia");
        $municipioss->guardar("3","Santa Cruz Balanyá");
        $municipioss->guardar("3","Tecpán Guatemala");
        $municipioss->guardar("3","Zaragoza");
        $municipioss->guardar("4","Camotán");
        $municipioss->guardar("4","Chiquimula");
        $municipioss->guardar("4","Concepción Las Minas");
        $municipioss->guardar("4","Esquipulas");
        $municipioss->guardar("4","Ipala");
        $municipioss->guardar("4","Jocotán");
        $municipioss->guardar("4","Olapa");
        $municipioss->guardar("4","Quezaltepeque");
        $municipioss->guardar("4","San Jacinto");
        $municipioss->guardar("4","San José La Arada");
        $municipioss->guardar("4","San Juan Ermita");
        $municipioss->guardar("5","Amatitlán");
        $municipioss->guardar("5","Chinautla");
        $municipioss->guardar("5","Chuarrancho");
        $municipioss->guardar("5","Fraijanes");
        $municipioss->guardar("5","Guatemala");
        $municipioss->guardar("5","Mixco");
        $municipioss->guardar("5","Palencia");
        $municipioss->guardar("5","San José del Golfo");
        $municipioss->guardar("5","San José Pinula");
        $municipioss->guardar("5","San Juan Sacatepequez");
        $municipioss->guardar("5","San Miguel Petapa");
        $municipioss->guardar("5","San Pedro Ayampuc");
        $municipioss->guardar("5","San Pedro Sacatepequez");
        $municipioss->guardar("5","San Raymundo");
        $municipioss->guardar("5","Santa Catarina Pinula");
        $municipioss->guardar("5","Villa Canales");
        $municipioss->guardar("5","Villa Nueva");
        $municipioss->guardar("6","El Jícaro");
        $municipioss->guardar("6","Guastatoya");
        $municipioss->guardar("6","Morazán");
        $municipioss->guardar("6","San Agustín Acasaguastlán");
        $municipioss->guardar("6","San Antonio La Paz");
        $municipioss->guardar("6","San Cristóbal Acasaguastlán");
        $municipioss->guardar("6","Sanarate");
        $municipioss->guardar("6","Sansare");
        $municipioss->guardar("7","Escuintla");
        $municipioss->guardar("7","Guanagazapa");
        $municipioss->guardar("7","Iztapa");
        $municipioss->guardar("7","La Democracia");
        $municipioss->guardar("7","La Gomera");
        $municipioss->guardar("7","Masagua");
        $municipioss->guardar("7","Nueva Concepción");
        $municipioss->guardar("7","Palín");
        $municipioss->guardar("7","San José");
        $municipioss->guardar("7","San Vicente Pacaya");
        $municipioss->guardar("7","Santa Lucía Cotzumalguapa");
        $municipioss->guardar("7","Sipacate");
        $municipioss->guardar("7","Siquinalá");
        $municipioss->guardar("7","Tiquisate");
        $municipioss->guardar("8","Aguacatán");
        $municipioss->guardar("8","Chiantla");
        $municipioss->guardar("8","Colotenango");
        $municipioss->guardar("8","Concepción Huista");
        $municipioss->guardar("8","Cuilco");
        $municipioss->guardar("8","Huehuetenango");
        $municipioss->guardar("8","Jacaltenango");
        $municipioss->guardar("8","La Democracia");
        $municipioss->guardar("8","La Libertad");
        $municipioss->guardar("8","Malacatancito");
        $municipioss->guardar("8","Nentón");
        $municipioss->guardar("8","San Antonio Huista");
        $municipioss->guardar("8","San Gaspar Ixchil");
        $municipioss->guardar("8","San Ildefonso Ixtahuacán");
        $municipioss->guardar("8","San Juan Atitán");
        $municipioss->guardar("8","San Juan Ixcoy");
        $municipioss->guardar("8","San Mateo Ixtatán");
        $municipioss->guardar("8","San Miguel Acatán");
        $municipioss->guardar("8","San Pedro Necta");
        $municipioss->guardar("8","San Pedro Soloma");
        $municipioss->guardar("8","San Rafael La Independencia");
        $municipioss->guardar("8","San Rafael Petzal");
        $municipioss->guardar("8","San Sebastián Coatán");
        $municipioss->guardar("8","San Sebastián Huehuetenango");
        $municipioss->guardar("8","Santa Ana Huista");
        $municipioss->guardar("8","Santa Bárbara");
        $municipioss->guardar("8","Santa Cruz Barillas");
        $municipioss->guardar("8","Santa Eulalia");
        $municipioss->guardar("8","Santiago Chimaltenango");
        $municipioss->guardar("8","Tectitán");
        $municipioss->guardar("8","Todos Santos Cuchumatán");
        $municipioss->guardar("8","Unión Cantinil");
        $municipioss->guardar("9","El Estor");
        $municipioss->guardar("9","Livingston");
        $municipioss->guardar("9","Los amates");
        $municipioss->guardar("9","Morales");
        $municipioss->guardar("9","Puerto Barrios");
        $municipioss->guardar("10","Jalapa");
        $municipioss->guardar("10","Mataquescuintla");
        $municipioss->guardar("10","Monjas");
        $municipioss->guardar("10","San Carlos Alzatate");
        $municipioss->guardar("10","San Luis Jilotepeque");
        $municipioss->guardar("10","San Manuel Chaparrón");
        $municipioss->guardar("10","San Pedro Pinula");
        $municipioss->guardar("11","Agua Blanca");
        $municipioss->guardar("11","Asunción Mita");
        $municipioss->guardar("11","Atescatempa");
        $municipioss->guardar("11","Comapa");
        $municipioss->guardar("11","Conguaco");
        $municipioss->guardar("11","El Adelanto");
        $municipioss->guardar("11","El Progreso");
        $municipioss->guardar("11","Jalpatagua");
        $municipioss->guardar("11","Jerez");
        $municipioss->guardar("11","Jutiapa");
        $municipioss->guardar("11","Moyuta");
        $municipioss->guardar("11","Pasaco");
        $municipioss->guardar("11","Quezapa");
        $municipioss->guardar("11","San José Acatempa");
        $municipioss->guardar("11","Santa Catarina Minta");
        $municipioss->guardar("11","Yupiltepeque");
        $municipioss->guardar("11","Zapotitlán");
        $municipioss->guardar("12","Flores");
        $municipioss->guardar("12","Dolores");
        $municipioss->guardar("12","El Chal");
        $municipioss->guardar("12","La Libertad");
        $municipioss->guardar("12","Las Cruces");
        $municipioss->guardar("12","Melchor de Mencos");
        $municipioss->guardar("12","Poptún");
        $municipioss->guardar("12","San Andrés");
        $municipioss->guardar("12","San Benito");
        $municipioss->guardar("12","San Franchisco");
        $municipioss->guardar("12","San José");
        $municipioss->guardar("12","San Luis");
        $municipioss->guardar("12","Santa Ana ");
        $municipioss->guardar("12","Sayaxché");
        $municipioss->guardar("13","Almolonga");
        $municipioss->guardar("13","Cabricán");
        $municipioss->guardar("13","Cajolá");
        $municipioss->guardar("13","Cantel");
        $municipioss->guardar("13","Coatepeque");
        $municipioss->guardar("13","Colomba");
        $municipioss->guardar("13","Concepción Chiquirichapa");
        $municipioss->guardar("13","El Palmar");
        $municipioss->guardar("13","Flores Costa Cuca");
        $municipioss->guardar("13","Génova");
        $municipioss->guardar("13","Huitán");
        $municipioss->guardar("13","La Esperanza");
        $municipioss->guardar("13","Olintepeque");
        $municipioss->guardar("13","Ostuncalco");
        $municipioss->guardar("13","Palestina de los Altos");
        $municipioss->guardar("13","Quetzaltenango");
        $municipioss->guardar("13","Salcajá");
        $municipioss->guardar("13","San Carlos Sija");
        $municipioss->guardar("13","San Francisco La Unión");
        $municipioss->guardar("13","San Martín Sacatepéquez");
        $municipioss->guardar("13","San Mateo");
        $municipioss->guardar("13","San Miguel Sigüila");
        $municipioss->guardar("13","Sibilia");
        $municipioss->guardar("13","Zunil");
        $municipioss->guardar("14","Santa Cruz del Quiché");
        $municipioss->guardar("14","Canillá");
        $municipioss->guardar("14","Chajul");
        $municipioss->guardar("14","Chicamán");
        $municipioss->guardar("14","Chiché");
        $municipioss->guardar("14","Chichicastenango");
        $municipioss->guardar("14","Chinique");
        $municipioss->guardar("14","Cunén");
        $municipioss->guardar("14","Ixcán");
        $municipioss->guardar("14","Joyabaj");
        $municipioss->guardar("14","Pachulum");
        $municipioss->guardar("14","Patzité");
        $municipioss->guardar("14","Sacapulas");
        $municipioss->guardar("14","San Andrés Sajcabajá");
        $municipioss->guardar("14","San Antonio Ilotenango");
        $municipioss->guardar("14","San Bartolomé Jocotenango");
        $municipioss->guardar("14","San Juan Cotzal");
        $municipioss->guardar("14","San Pedro Jocopilas");
        $municipioss->guardar("14","Santa María Nebaj");
        $municipioss->guardar("14","Uspatán");
        $municipioss->guardar("14","Zacualpa");
        $municipioss->guardar("15","Champerico");
        $municipioss->guardar("15","El Asintal");
        $municipioss->guardar("15","Nuevo San Carlos");
        $municipioss->guardar("15","Retalhuleu");
        $municipioss->guardar("15","San Adrés Villa Seca");
        $municipioss->guardar("15","San Felipe");
        $municipioss->guardar("15","San Martín Zapotitlán");
        $municipioss->guardar("15","San Sebastián");
        $municipioss->guardar("15","Santa Cruz Muluá");
        $municipioss->guardar("16","Alotenango");
        $municipioss->guardar("16","Antigua Guatemala");
        $municipioss->guardar("16","Ciudad Vieja");
        $municipioss->guardar("16","Jocotenango");
        $municipioss->guardar("16","Magdalena Milpas Altas");
        $municipioss->guardar("16","Pastores");
        $municipioss->guardar("16","San Antonio Aguas Calientes");
        $municipioss->guardar("16","San Bartolomé Milpas Altas");
        $municipioss->guardar("16","San Lucas Sacatepéquez");
        $municipioss->guardar("16","San Miguel Dueñas");
        $municipioss->guardar("16","Santa Catarina Barahona");
        $municipioss->guardar("16","Santa Lucía Milpas Altas");
        $municipioss->guardar("16","Santa María de Jesús");
        $municipioss->guardar("16","Santiago Sacatepéquez");
        $municipioss->guardar("16","Santo Domingo Xenacoj");
        $municipioss->guardar("16","Sumpango");
        $municipioss->guardar("17","Ayutla");
        $municipioss->guardar("17","Catarina");
        $municipioss->guardar("17","Comitancillo");
        $municipioss->guardar("17","Concepción Tatuapa");
        $municipioss->guardar("17","El Quetzal");
        $municipioss->guardar("17","El Tumbador");
        $municipioss->guardar("17","Esquipulas Palo Gordo");
        $municipioss->guardar("17","Ixchiguán");
        $municipioss->guardar("17","La Blanca");
        $municipioss->guardar("17","La Reforma");
        $municipioss->guardar("17","Malacatán");
        $municipioss->guardar("17","Nuevo Progreso");
        $municipioss->guardar("17","Ocós");
        $municipioss->guardar("17","Pajapita");
        $municipioss->guardar("17","Río Blanco");
        $municipioss->guardar("17","San Antonio Sacatepéquez");
        $municipioss->guardar("17","San Cristóbalo Cucho");
        $municipioss->guardar("17","San José El Rodeo");
        $municipioss->guardar("17","San José Ojetenam");
        $municipioss->guardar("17","San Lorenzo");
        $municipioss->guardar("17","San Marcos");
        $municipioss->guardar("17","San Miguel Ixtahuacán");
        $municipioss->guardar("17","San Pablo");
        $municipioss->guardar("17","San Pedro Sacatepéquez");
        $municipioss->guardar("17","San Rafael Pie de la Cuesta");
        $municipioss->guardar("17","Sbinal");
        $municipioss->guardar("17","Sipacapa");
        $municipioss->guardar("17","Tacaná");
        $municipioss->guardar("17","Tajumulco");
        $municipioss->guardar("17","Tejutla");
        $municipioss->guardar("18","Barberena");
        $municipioss->guardar("18","Casillas");
        $municipioss->guardar("18","Chiquimulilla");
        $municipioss->guardar("18","Cuilapa");
        $municipioss->guardar("18","Guazacapán");
        $municipioss->guardar("18","Nueva Santa Rosa");
        $municipioss->guardar("18","Oratorio");
        $municipioss->guardar("18","Pueblo Nuevo Viñas");
        $municipioss->guardar("18","San Juan Tecuaco");
        $municipioss->guardar("18","San Rafael Las Flores");
        $municipioss->guardar("18","Santa Cruz Naranjo");
        $municipioss->guardar("18","Santa María Ixhuatán");
        $municipioss->guardar("18","Santa Rosa de Lima");
        $municipioss->guardar("18","Taxisco");
        $municipioss->guardar("19","Concepción");
        $municipioss->guardar("19","Nahualá");
        $municipioss->guardar("19","Panajachel");
        $municipioss->guardar("19","San Andrés Semetabaj");
        $municipioss->guardar("19","San Antonio Palopó");
        $municipioss->guardar("19","San José Chacayá");
        $municipioss->guardar("19","San Juan La Laguna");
        $municipioss->guardar("19","San Lucas Tolimán");
        $municipioss->guardar("19","San Marcos La Laguna");
        $municipioss->guardar("19","San Pablo La Laguna");
        $municipioss->guardar("19","San Pedro La Laguna");
        $municipioss->guardar("19","Santa Catarina Ixtahuacán");
        $municipioss->guardar("19","Santa Catarina Palopó");
        $municipioss->guardar("19","Santa Clara La Laguna");
        $municipioss->guardar("19","Santa Cruz la Laguna");
        $municipioss->guardar("19","Santa Lucía Utatlán");
        $municipioss->guardar("19","Santa María Visitación");
        $municipioss->guardar("19","Santiago Atitlán");
        $municipioss->guardar("19","Sololá");
        $municipioss->guardar("20","Chicacao");
        $municipioss->guardar("20","Cuyotenango");
        $municipioss->guardar("20","Mazatenango");
        $municipioss->guardar("20","Patulul");
        $municipioss->guardar("20","Pueblo Nuevo");
        $municipioss->guardar("20","Río Bravo");
        $municipioss->guardar("20","Samayac");
        $municipioss->guardar("20","San Antonio Suchitepéquez");
        $municipioss->guardar("20","San Bemardino");
        $municipioss->guardar("20","San Francisco Zapotitlán");
        $municipioss->guardar("20","San Gabriel");
        $municipioss->guardar("20","San José El Ídolo");
        $municipioss->guardar("20","San José La Maquina");
        $municipioss->guardar("20","San Juan Bautista");
        $municipioss->guardar("20","San Lorenzo");
        $municipioss->guardar("20","San Miguel Panán");
        $municipioss->guardar("20","San Pablo Jocopilas");
        $municipioss->guardar("20","Santa Bárbara");
        $municipioss->guardar("20","Santo Domingo Suchitepéquez");
        $municipioss->guardar("20","Santo Tomás La Unión");
        $municipioss->guardar("20","Zunilito");
        $municipioss->guardar("21","Momostenango");
        $municipioss->guardar("21","San Andrés Xecul");
        $municipioss->guardar("21","San Bartolo Aguas Calientes");
        $municipioss->guardar("21","San Cristóbal Totonicapán");
        $municipioss->guardar("21","San Francisco El Alto");
        $municipioss->guardar("21","Santa Lucía La Reforma");
        $municipioss->guardar("21","Santa María Chiquimula");
        $municipioss->guardar("21","Totonicapán");
        $municipioss->guardar("22","Cabañas");
        $municipioss->guardar("22","Estanzuela");
        $municipioss->guardar("22","Gualán");
        $municipioss->guardar("22","Huité");
        $municipioss->guardar("22","La Unión");
        $municipioss->guardar("22","Río Hondo");
        $municipioss->guardar("22","San Diego");
        $municipioss->guardar("22","San Jorge");
        $municipioss->guardar("22","Teculután");
        $municipioss->guardar("22","Usumatlán");
        $municipioss->guardar("22","Zacapa");

        $user = factory(App\User::class)->create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'dpi' => '000000000000',
            'nombre1' => 'ninguno',
            'nombre2' => 'ninguno',
            'nombre3' => 'ninguno',
            'apellido1' => 'ninguno',
            'apellido2' => 'ninguno',
            'apellido3' => 'ninguno',
            'departamento_id' => '1',
            'municipio_id' => '1',
            'direccion' => 'admin',
            'fecha_nacimiento' => '01/01/2017',
            'fecha_ingreso' => '01/01/2017',
            'telefono' => '00000000',
            'rol_id' => '1',
            'estado_id' => '1',
        ]);
    }
}