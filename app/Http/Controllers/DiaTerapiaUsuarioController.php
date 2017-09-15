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
use App\UsuariaDia;
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
        ->select('userdiasemanas.*', 'diasemanas.id as diasemana_id')
        ->where('userdiasemanas.user_id', '=', $id)->get();

        $usuarioterapias = DB::table('userterapias')
        ->leftJoin('terapias', 'userterapias.terapia_id', '=', 'terapias.id')
        ->select('userterapias.*', 'terapias.nombre as terapia_nombre')
        ->where('userterapias.user_id', '=', $id)->get();

        return view('users-mgmt/edit', ['user' => $user, 'rols' => $rols, 'departamentos' => $departamentos, 'municipios' => $municipios, 'estados' => $estados, 'diasemanas' => $diasemanas, 'terapias' => $terapias, 'userdiasemanas' => $userdiasemanas, 'usuarioterapias' => $usuarioterapias]);
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $this->validateUpdate($request);

        $user->dpi = $request['dpi'];
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
}
