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
use App\UsuarioDia;

class DiaSemanaUsuarioController extends Controller
{
	    protected $redirectTo = '/diasemanausuario-management';

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
    	$last = DB::table('users')->latest()->first();
        $user = User::find($last->id);

        $rols = Rol::select('id', 'nombre')->where('rols.id','!=','1')->get();
        $departamentos = Departamento::all();
        $municipios = Municipio::all();
        $diasemanas = DiaSemana::all();
        return view('diasemanausuario-mgmt/index', ['user' => $user, 'rols' => $rols, 'departamentos' => $departamentos, 'municipios' => $municipios, 'diasemanas' => $diasemanas]);
    }

    public function store(Request $request){
        //Datos para la Bitacora
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $log = $request->User()->username;
        $last = DB::table('users')->latest()->first();
        $user = User::find($last->id);
        $diasemanas = $request->diasemana;

        foreach ($diasemanas as $diasemana) {
        	$diausuario = new UsuarioDia();
        	$diausuario->diasemana_id = $diasemana;
        	$diausuario->user_id = $user->id;
        	$diausuario->save();
        } 
    }
}
