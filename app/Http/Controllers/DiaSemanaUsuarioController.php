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

class DiaSemanaUsuarioController extends Controller {
	    protected $redirectTo = '/diasemanausuario-management';

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
    		$last = DB::table('users')->latest()->first();
        $user = User::find($last->id);

        $rols = Rol::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $municipios = Municipio::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $diasemanas = DiaSemana::all();
				$message = '';
        return view('diasemanausuario-mgmt/create', ['user' => $user, 'rols' => $rols, 'departamentos' => $departamentos, 'municipios' => $municipios, 'diasemanas' => $diasemanas, 'message' => $message]);
    }

    public function store(Request $request){
        $last = DB::table('users')->latest()->first();
        $user = User::find($last->id);
        $diasemanas = $request->diasemana;
				$p = "si";
				$r = "no";

				if($diasemanas != ''){
					foreach ($diasemanas as $diasemana) {
							$diausuario = new UsuarioDia();
		        	$diausuario->diasemana_id = $diasemana;
		        	$diausuario->user_id = $user->id;
		        	$this->createDiaSemanaUsuarioBitacora($request, $diasemana, $user);
		          $diausuario->save();
	        }
	        return redirect()->intended('/terapiausuario-management');
				}

				if($diasemanas == ''){
					$last = DB::table('users')->latest()->first();
	        $user = User::find($last->id);

	        $rols = Rol::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
	        $departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
	        $municipios = Municipio::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
	        $diasemanas = DiaSemana::all();
					$message = 'Seleccionar uno o más Dias, caso contrario seleccionar Ninguno';
	        return view('diasemanausuario-mgmt/create', ['user' => $user, 'rols' => $rols, 'departamentos' => $departamentos, 'municipios' => $municipios, 'diasemanas' => $diasemanas, 'message' => $message]);
				}

    }

		public function show($id) {

      $user = User::findOrFail($id);

			$deleteDia = DB::table('userdiasemanas')
			->select('userdiasemanas.*')->where('userdiasemanas.user_id','=',$user->id);

			if($deleteDia->delete()){
				if($user->delete()){
	          return redirect()->intended('/user-management');
	      }
			}

    }

    public function createDiaSemanaUsuarioBitacora ($request, $diasemana, $user){
        //Datos para la Bitacora
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $log = $request->User()->username;

        $diasemanas = $request->diasemana;
        $cadena = '';
        foreach ($diasemanas as $diasemana) {
            $nombredia=DiaSemana::findOrFail($diasemana);
            $cadena = $cadena.' , '.$nombredia->nombre;
        }

             $data = 'Usuario: ' . $user->nombre1 .' '. $user->nombre2 .' '. $user->nombre3 .' '. $user->apellido1 .' '. $user->apellido2 .' '. $user->apellido3 . ' , Dia: ' . $cadena;

            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'USUARIO DIA SEMANA';
            $bitacora->actividad = 'CREAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            $bitacora->save();
    }
}
