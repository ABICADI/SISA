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
use Auth;

class DiaSemanaUsuarioController extends Controller {
	    protected $redirectTo = '/sisa/diasemanausuario-management';

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
    		$last = DB::table('users')->latest()->first();
        $user = User::join('municipios', 'users.municipio_id', 'municipios.id')
											->join('departamentos', 'municipios.departamento_id', 'departamentos.id')
											->join('rols', 'users.rol_id', 'rols.id')
											->join('generos', 'users.genero_id', 'generos.id')
											->select('municipios.nombre as Municipio', 'departamentos.nombre as Departamento', 'rols.nombre as Rol', 'generos.nombre as Genero', 'users.*')
											->find($last->id);
        $diasemanas = DiaSemana::where('id','!=',1)->get();
        return view('diasemanausuario-mgmt/create', ['user' => $user, 'diasemanas' => $diasemanas]);
    }

    public function store(Request $request){
        $last = DB::table('users')->latest()->first();
        $user = User::find($last->id);
        $diasemanas = $request->diasemana;
				if($request->check==null){
					if($diasemanas != ''){
						foreach ($diasemanas as $diasemana) {
								$diausuario = new UsuarioDia();
			        	$diausuario->diasemana_id = $diasemana;
			        	$diausuario->user_id = $user->id;
			        	$this->createDiaSemanaUsuarioBitacora($request, $diasemana, $user);
			          $diausuario->save();
		        }
						Flash('¡Se agregaron Exitosamente los dias al Empleado!')->success();
		        return redirect()->intended('/sisa/terapiausuario-management');
					}
					if($diasemanas == ''){
						$last = DB::table('users')->latest()->first();
		        $user = User::join('municipios', 'users.municipio_id', 'municipios.id')
													->join('departamentos', 'municipios.departamento_id', 'departamentos.id')
													->join('rols', 'users.rol_id', 'rols.id')
													->join('generos', 'users.genero_id', 'generos.id')
													->select('municipios.nombre as Municipio', 'departamentos.nombre as Departamento', 'rols.nombre as Rol', 'generos.nombre as Genero','users.*')
													->find($last->id);
		        $diasemanas = DiaSemana::all();
						Flash('¡Seleccionar uno o más Dias, caso contrario seleccionar Ninguno!')->error()->important();
		        return view('diasemanausuario-mgmt/create', ['user' => $user, 'diasemanas' => $diasemanas]);
					}
				}
				if($request->check==1){
					$diausuario = new UsuarioDia();
					$diausuario->diasemana_id = $request->check;
					$diausuario->user_id = $user->id;
					$this->createDiaNullSemanaUsuarioBitacora($request, $user);
					if($diausuario->save()){
						Flash('¡Se agregaron Exitosamente los dias al Empleado!')->success();
						return redirect()->intended('/sisa/terapiausuario-management');
					}
				}
    }

		public function show($id) {
      $user = User::findOrFail($id);
			$deleteDia = DB::table('userdiasemanas')
			->select('userdiasemanas.*')->where('userdiasemanas.user_id','=',$user->id);

			if($deleteDia->delete()){
				if($user->delete()){
						Flash('¡Se cancelo la creación del Empleado Exitosamente!')->error()->important();
	          return redirect()->intended('/sisa/user-management');
	      }
			}

    }

    public function createDiaSemanaUsuarioBitacora ($request, $diasemana, $user){
        //Datos para la Bitacora
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $log = Auth::user()->username;

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

		public function createDiaNullSemanaUsuarioBitacora ($request, $user){
        //Datos para la Bitacora
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $log = Auth::user()->username;

        $nombredia=DiaSemana::findOrFail($request->check);

             $data = 'Usuario: ' . $user->nombre1 .' '. $user->nombre2 .' '. $user->nombre3 .' '. $user->apellido1 .' '. $user->apellido2 .' '. $user->apellido3 . ' , Dia: ' . $nombredia->nombre;

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
