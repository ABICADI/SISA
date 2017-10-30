<?php


    $factory->define(App\User::class, function (Faker\Generator $faker) {
        static $password;

        return [
            'username' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => $password ?: $password = bcrypt('secret'),
            'dpi' => null,
            'nombre1' => null,
            'nombre2' => null,
            'nombre3' => null,
            'apellido1' => null,
            'apellido2' => null,
            'apellido3' => null,
            'municipio_id' => null,
            'direccion' => null,
            'fecha_nacimiento' => null,
            'fecha_ingreso' => null,
            'telefono' => null,
            'rol_id' => null,
            'fecha_egreso' => null,
            'estado_id' => null,
            'remember_token' => str_random(10),
        ];
    });

    $factory->define(App\Bitacora::class, function (Faker\Generator $faker) {

        return [
            'usuario' => null,
            'nombre_tabla' => null,
            'actividad' => null,
            'anterior' => null,
            'nuevo' => null,
            'fecha' => null,
        ];
    });

    $factory->define(App\Rol::class, function (Faker\Generator $faker) {

        return [
            'nombre' => null,
            'descripcion' => null,
        ];
    });

    $factory->define(App\Estado::class, function (Faker\Generator $faker) {

        return [
            'nombre' => null,
            'descripcion' => null,
        ];
    });

    $factory->define(App\Terapia::class, function (Faker\Generator $faker) {

        return [
            'nombre' => null,
            'descripcion' => null,
            'color' => null,
        ];
    });

    $factory->define(App\DiaSemana::class, function (Faker\Generator $faker) {

        return [
            'nombre' => null,
        ];
    });

    $factory->define(App\Departamento::class, function (Faker\Generator $faker) {

        return [
            'nombre' => null,
        ];
    });

    $factory->define(App\Municipio::class, function (Faker\Generator $faker) {

        return [
            'nombre' => null,
            'departamento_id' => null,
        ];
    });

    $factory->define(App\UsuarioTerapia::class, function (Faker\Generator $faker) {

        return [
            'user_id' => null,
            'terapia_id' => null,
        ];
    });

    $factory->define(App\UsuarioDia::class, function (Faker\Generator $faker) {

        return [
            'diasemana_id' => null,
            'user_id' => null,
        ];
    });

    $factory->define(App\Medico::class, function (Faker\Generator $faker) {

        return [
            'colegiado' => null,
            'nombre' => null,
            'telefono' => null,
        ];
    });

    $factory->define(App\Pago::class, function (Faker\Generator $faker) {

        return [
            'nombre' => null,
        ];
    });

    $factory->define(App\Paciente::class, function (Faker\Generator $faker) {

        return [
            'cui' => null,
            'nombre1' => null,
            'nombre2' => null,
            'nombre3' => null,
            'apellido1' => null,
            'apellido2' => null,
            'apellido3' => null,
            'municipio_id' => null,
            'direccion' => null,
            'fecha_nacimiento' => null,
            'encargado' => null,
            'fecha_ingreso' => null,
            'telefono' => null,
            'seguro_social' => null,
            'observacion' => null,
            'pago_id' => null,
        ];
    });
