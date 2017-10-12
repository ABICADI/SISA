<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Rol;
use App\Estado;
use App\Departamento;
use App\Municipio;

class ProfileController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
    }

    public function view($id) {
        $user = User::find($id);

        $userdiasemanas = DB::table('userdiasemanas')
        ->leftJoin('diasemanas', 'userdiasemanas.diasemana_id', '=', 'diasemanas.id')
        ->select('userdiasemanas.*', 'diasemanas.nombre as diasemana_nombre')
        ->where('userdiasemanas.user_id', '=', $id)->orderBy('diasemana_id','asc')->get();

        $usuarioterapias = DB::table('userterapias')
        ->leftJoin('terapias', 'userterapias.terapia_id', '=', 'terapias.id')
        ->select('userterapias.*', 'terapias.nombre as terapia_nombre')
        ->where('userterapias.user_id', '=', $id)->orderBy('terapias.nombre','asc')->get();

        $rols = Rol::select('id', 'nombre')->where('rols.id', '=', $user->rol_id)->get();
        $departamentos = Departamento::select('id', 'nombre')->where('departamentos.id', '=', $user->departamento_id)->get();
        $municipios = Municipio::select('id', 'nombre')->where('municipios.id', '=', $user->municipio_id)->get();
        $estados = Estado::select('id', 'nombre')->where('estados.id', '=', $user->estado_id)->get();
        return view('profile', ['user' => $user, 'departamentos' => $departamentos, 'municipios' => $municipios, 'estados' => $estados, 'rols' => $rols, 'userdiasemanas' => $userdiasemanas, 'usuarioterapias' => $usuarioterapias]);
    }
}
