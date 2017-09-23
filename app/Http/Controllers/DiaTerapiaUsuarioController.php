<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Bitacora;
use App\Rol;
use App\Estado;
use App\Departamento;
use App\Municipio;
use App\DiaSemana;
use App\Terapia;
use App\UsuarioDia;
use App\UsuarioTerapia;

class DiaTerapiaUsuarioController extends Controller {

    public function edit($id) {
        $user = User::find($id);
        if ($user == null || count($user) == 0) {
            return redirect()->intended('/user-management');
        }

        $rols = Rol::select('id', 'nombre')->where('rols.id','!=','1')->orderBy('nombre', 'asc')->get();
        $departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $municipios = Municipio::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $estados = Estado::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $diasemanas = DiaSemana::all();
        $terapias = Terapia::select('id', 'nombre')->orderBy('nombre', 'asc')->get();

        $userdiasemanas = DB::table('userdiasemanas')
        ->leftJoin('diasemanas', 'userdiasemanas.diasemana_id', '=', 'diasemanas.id')
        ->select('userdiasemanas.*', 'diasemanas.id as diasemana_id', 'diasemanas.nombre as nombre_dia')
        ->where('userdiasemanas.user_id', '=', $id)->get();

        $usuarioterapias = DB::table('userterapias')
        ->leftJoin('terapias', 'userterapias.terapia_id', '=', 'terapias.id')
        ->select('userterapias.*', 'terapias.nombre as terapia_nombre', 'terapias.id as terapia_id')
        ->where('userterapias.user_id', '=', $id)->get();


        return view('users-mgmt/edit', ['user' => $user, 'rols' => $rols, 'departamentos' => $departamentos, 'municipios' => $municipios, 'estados' => $estados, 'diasemanas' => $diasemanas, 'terapias' => $terapias, 'userdiasemanas' => $userdiasemanas, 'usuarioterapias' => $usuarioterapias]);
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $this->validateUpdate($request);
        $this->updatediaBitacora($request, $id);
        $this->updateterapiaBitacora($request, $id);

        $deleteDia = DB::table('userdiasemanas')
        ->select('userdiasemanas.*')->where('userdiasemanas.user_id','=',$user->id);
        $deleteDia->delete();

        $deleteTerapia = DB::table('userterapias')
        ->select('userterapias.*')->where('userterapias.user_id','=',$user->id);
        $deleteTerapia->delete();

        $user->username = $request['username'];
        $user->email = $request['email'];
        if ($request['password'] != null && strlen($request['password']) > 0) {
            $request['password'] = 'required|min:8|confirmed';
            $user->password = bcrypt($request['password']);
        } 
        $user->dpi = $request['dpi'];
        $user->nombre1 = $request['nombre1'];
        $user->nombre2 = $request['nombre2'];
        $user->nombre3 = $request['nombre3'];
        $user->apellido1 = $request['apellido1'];
        $user->apellido2 = $request['apellido2'];
        $user->apellido3 = $request['apellido3'];
        $user->departamento_id = $request['departamento_id'];
        $user->municipio_id = $request['municipio_id'];
        $user->direccion = $request['direccion'];
        $user->fecha_nacimiento = $request['fecha_nacimiento'];
        $user->fecha_ingreso = $request['fecha_ingreso'];
        $user->telefono = $request['telefono'];
        $user->rol_id = $request['rol_id'];
        $user->estado_id = $request['estado_id'];

        $terapias = $request->terapia;
        foreach ($terapias as $terapia) {
            $terapiausuario = new UsuarioTerapia();
            $terapiausuario->terapia_id = $terapia;
            $terapiausuario->user_id = $user->id;
            $terapiausuario->save();
        }

        $diasemanas = $request->diasemana;
        foreach ($diasemanas as $diasemana) {
            $diausuario = new UsuarioDia();
            $diausuario->diasemana_id = $diasemana;
            $diausuario->user_id = $user->id;
            $diausuario->save();
        }

        $this->updateBitacora($request, $id);
        if($user->save()){
           return redirect()->intended('/user-management');
        }
        
    }

    private function validateUpdate($request) {
        $this->validate($request, [
            'username' => 'required|min:6|max:20',
            'email' => 'email|max:125|nullable',
            'dpi' => 'required|digits:13',
            'nombre1' => 'required|max:30',
            'nombre2' => 'max:30',
            'nombre3' => 'max:30',
            'apellido1' => 'required|max:30',
            'apellido2' => 'max:30',
            'apellido3' => 'max:30',
            'departamento_id' => 'required',
            'municipio_id' => 'required',
            'direccion' => 'max:75',
            'fecha_nacimiento' => 'required',
            'fecha_ingreso' => 'required',
            'telefono' => 'digits:8|nullable',
            'rol_id' => 'required',
        ]);
    }

    private function updateBitacora($request, $id){
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $log = $request->User()->username;
        $user = User::findOrFail($id);
        
        $departamentonew = Departamento::find($request['departamento_id']);
        $departamentoold = Departamento::find($user->departamento_id);
        $municipionew = Municipio::find($request['municipio_id']);
        $municipioold = Municipio::find($user->municipio_id);
        $rolnew = Rol::find($request['rol_id']);
        $rolold = Rol::find($user->rol_id);
        $estadonew = Estado::find($request['estado_id']);
        $estadoold = Estado::find($user->estado_id);

            if($user->username != $request['username']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Username: ' . $user->username;
                $bitacora->nuevo = 'Username: ' . $request->username;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->email != $request['email']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'E-mail: ' . $user->email;
                $bitacora->nuevo = 'E-mail: ' . $request->email;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($request['password'] != null){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = '';
                $bitacora->nuevo = 'El Usuario |' . $user->username . '| cambio la contraseña';
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->dpi != $request['dpi']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'DPI: ' . $user->dpi;
                $bitacora->nuevo = 'DPI: ' . $request->dpi;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->nombre1 != $request['nombre1']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Primer Nombre: ' . $user->nombre1;
                $bitacora->nuevo = 'Primer Nombre: ' . $request->nombre1;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->nombre2 != $request['nombre2']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Segundo Nombre: ' . $user->nombre2;
                $bitacora->nuevo = 'Segundo Nombre: ' . $request->nombre2;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->nombre3 != $request['nombre3']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Tercer Nombre: ' . $user->nombre3;
                $bitacora->nuevo = 'Tercer Nombre: ' . $request->nombre3;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->apellido1 != $request['apellido1']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Primer Apellido: ' . $user->apellido1;
                $bitacora->nuevo = 'Primer Apellido: ' . $request->apellido1;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->apellido2 != $request['apellido2']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Segundo Apellido: ' . $user->apellido2;
                $bitacora->nuevo = 'Segundo Apellido: ' . $request->apellido2;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->apellido3 != $request['apellido3']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Tercer Apellido: ' . $user->apellido3;
                $bitacora->nuevo = 'Tercer Apellido: ' . $request->apellido3;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->departamento_id != $request['departamento_id']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Departamento: ' . $departamentoold->nombre;
                $bitacora->nuevo = 'Departamento: ' . $departamentonew->nombre;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->municipio_id != $request['municipio_id']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Municipio: ' . $municipioold->nombre;
                $bitacora->nuevo = 'Municipio: ' . $municipionew->nombre;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->direccion != $request['direccion']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Dirección: ' . $user->direccion;
                $bitacora->nuevo = 'Dirección: ' . $request->direccion;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->fecha_nacimiento != $request['fecha_nacimiento']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Dirección: ' . $user->fecha_nacimiento;
                $bitacora->nuevo = 'Dirección: ' . $request->fecha_nacimiento;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->fecha_ingreso != $request['fecha_ingreso']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Dirección: ' . $user->fecha_ingreso;
                $bitacora->nuevo = 'Dirección: ' . $request->fecha_ingreso;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->telefono != $request['telefono']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Dirección: ' . $user->telefono;
                $bitacora->nuevo = 'Dirección: ' . $request->telefono;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->rol_id != $request['rol_id']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Puesto Encargado: ' . $rolold->nombre;
                $bitacora->nuevo = 'Puesto Encargado: ' . $rolnew->nombre;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

            if($user->estado_id != $request['estado_id']){
                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'EMPLEADO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Puesto Encargado: ' . $estadoold->nombre;
                $bitacora->nuevo = 'Puesto Encargado: ' . $estadonew->nombre;
                $bitacora->fecha = $now;
                $bitacora->save();
            }
    }

    public function updatediaBitacora($request, $id){
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $log = $request->User()->username;
        $user = User::findOrFail($id);

        $userdiasemanas = DB::table('userdiasemanas')
        ->leftJoin('diasemanas', 'userdiasemanas.diasemana_id', '=', 'diasemanas.id')
        ->select('userdiasemanas.*', 'diasemanas.nombre as nombre_dia')
        ->where('userdiasemanas.user_id', '=', $id)->get();

        $cadena1 = '';
        foreach ($userdiasemanas as $userdiasemana) {
            $cadena1 = $cadena1.' , '.$userdiasemana->nombre_dia;
        }

        $diasemanas = $request->diasemana;
        $cadena = '';
        foreach ($diasemanas as $diasemana) {
            $nombredia=DiaSemana::findOrFail($diasemana);
            $cadena = $cadena.' , '.$nombredia->nombre;
        }

                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'USUARIO DIA SEMANA';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Dias Anteriores: ' . $cadena1;
                $bitacora->nuevo = 'Dias Actuales: ' . $cadena;
                $bitacora->fecha = $now;
                $bitacora->save();
    }

    public function updateterapiaBitacora($request, $id){
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $log = $request->User()->username;
        $user = User::findOrFail($id);

        $usuarioterapias = DB::table('userterapias')
        ->leftJoin('terapias', 'userterapias.terapia_id', '=', 'terapias.id')
        ->select('userterapias.*', 'terapias.nombre as terapia_nombre', 'terapias.id as terapia_id')
        ->where('userterapias.user_id', '=', $id)->get();

        $cadena1 = '';
        foreach ($usuarioterapias as $usuarioterapia) {
            $cadena1 = $cadena1.' , '.$usuarioterapia->terapia_nombre;
        }

        $terapias = $request->terapia;
        $cadena = '';
        foreach ($terapias as $terapia) {
            $nombreterapia=Terapia::findOrFail($terapia);
            $cadena = $cadena.' , '.$nombreterapia->nombre;
        }

                $bitacora = new Bitacora();
                $bitacora->usuario = $log;
                $bitacora->nombre_tabla = 'USUARIO TERAPIA';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Terapias Anteriores: ' . $cadena1;
                $bitacora->nuevo = 'Terapias Actuales: ' . $cadena;
                $bitacora->fecha = $now;
                $bitacora->save();
    }
}
