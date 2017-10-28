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
use App\Terapia;
use App\UsuarioDia;
use App\UsuarioTerapia;
use Auth;

class TerapiaUsuarioController extends Controller {

		protected $redirectTo = '/terapiausuario-management'; //redirecciona la ruta

		public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
    		$last = DB::table('users')->latest()->first();
        $user = User::find($last->id);

        $rols = Rol::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $municipios = Municipio::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $terapias = Terapia::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $userdiasemanas = DB::table('userdiasemanas')
        ->leftJoin('diasemanas', 'userdiasemanas.diasemana_id', '=', 'diasemanas.id')
        ->select('userdiasemanas.*', 'diasemanas.nombre as diasemanas_nombre')
        ->where('userdiasemanas.user_id', '=', $user->id)->get();
				$message = '';
        return view('terapiausuario-mgmt/create', ['user' => $user, 'rols' => $rols, 'departamentos' => $departamentos, 'municipios' => $municipios, 'terapias' => $terapias, 'userdiasemanas' => $userdiasemanas, 'message' => $message]);
    }

    public function store(Request $request){
        $last = DB::table('users')->latest()->first();
        $user = User::find($last->id);
        $terapias = $request->terapia;

				if($terapias != ''){
	        foreach ($terapias as $terapia) {
	        	$terapiausuario = new UsuarioTerapia();
	        	$terapiausuario->terapia_id = $terapia;
	        	$terapiausuario->user_id = $user->id;
	        	if($terapiausuario->save()){
	                $this->createTerpiaUsuario($request, $terapia, $user);
	            }
	        }
	        return redirect()->intended('/user-management');
				}

				if($terapias == ''){
						$last = DB::table('users')->latest()->first();
		        $user = User::find($last->id);

		        $rols = Rol::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
		        $departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
		        $municipios = Municipio::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
		        $terapias = Terapia::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
		        $userdiasemanas = DB::table('userdiasemanas')
		        ->leftJoin('diasemanas', 'userdiasemanas.diasemana_id', '=', 'diasemanas.id')
		        ->select('userdiasemanas.*', 'diasemanas.nombre as diasemanas_nombre')
		        ->where('userdiasemanas.user_id', '=', $user->id)->get();
						$message = 'Seleccionar una o más Terapias, caso contrario seleccionar Ninguno';
		        return view('terapiausuario-mgmt/create', ['user' => $user, 'rols' => $rols, 'departamentos' => $departamentos, 'municipios' => $municipios, 'terapias' => $terapias, 'userdiasemanas' => $userdiasemanas, 'message' => $message]);
				}
    }

    public function createTerpiaUsuario($request, $terapia, $user){
        //Datos para la Bitacora
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $log = Auth::user()->username;

        $terapias = $request->terapia;
        $cadena = '';
        foreach ($terapias as $terapia) {
            $nombreterapia=Terapia::findOrFail($terapia);
            $cadena = $cadena.' , '.$nombreterapia->nombre;
        }

             $data = 'Usuario: ' . $user->nombre1 .' '. $user->nombre2 .' '. $user->nombre3 .' '. $user->apellido1 .' '. $user->apellido2 .' '. $user->apellido3 . ' , Terapia: ' . $cadena;

            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'USUARIO TERAPIA';
            $bitacora->actividad = 'CREAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            $bitacora->save();
    }
}
