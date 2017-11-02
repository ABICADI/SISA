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

		protected $redirectTo = '/sisa/terapiausuario-management'; //redirecciona la ruta

		public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
    		$last = DB::table('users')->latest()->first();
				$user = User::join('municipios', 'users.municipio_id', 'municipios.id')
											->join('departamentos', 'municipios.departamento_id', 'departamentos.id')
											->join('rols', 'users.rol_id', 'rols.id')
											->join('generos', 'users.genero_id', 'generos.id')
											->select('municipios.nombre as Municipio', 'departamentos.nombre as Departamento', 'rols.nombre as Rol', 'generos.nombre as Genero','users.*')
											->find($last->id);
        $terapias = Terapia::select('id', 'nombre')->where('id','!=',1)->orderBy('nombre', 'asc')->get();
        $userdiasemanas = DB::table('userdiasemanas')
        ->leftJoin('diasemanas', 'userdiasemanas.diasemana_id', '=', 'diasemanas.id')
        ->select('userdiasemanas.*', 'diasemanas.nombre as diasemanas_nombre')
        ->where('userdiasemanas.user_id', '=', $user->id)->get();
        return view('terapiausuario-mgmt/create', ['user' => $user, 'terapias' => $terapias, 'userdiasemanas' => $userdiasemanas]);
    }

    public function store(Request $request){
        $last = DB::table('users')->latest()->first();
        $user = User::find($last->id);
        $terapias = $request->terapia;

				if($request->check==null){
					if($terapias != ''){
		        foreach ($terapias as $terapia) {
		        	$terapiausuario = new UsuarioTerapia();
		        	$terapiausuario->terapia_id = $terapia;
		        	$terapiausuario->user_id = $user->id;
		        	if($terapiausuario->save()){
		                $this->createTerpiaUsuario($request, $terapia, $user);
		            }
		        }
						Flash('¡El Empleado se ha agregado Exitosamente!')->success();
		        return redirect()->intended('/sisa/user-management');
					}
					if($terapias == ''){
							$last = DB::table('users')->latest()->first();
							$user = User::join('municipios', 'users.municipio_id', 'municipios.id')
														->join('departamentos', 'municipios.departamento_id', 'departamentos.id')
														->join('rols', 'users.rol_id', 'rols.id')
														->select('municipios.nombre as Municipio', 'departamentos.nombre as Departamento', 'rols.nombre as Rol', 'users.*')
														->find($last->id);
			        $terapias = Terapia::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
			        $userdiasemanas = DB::table('userdiasemanas')
			        ->leftJoin('diasemanas', 'userdiasemanas.diasemana_id', '=', 'diasemanas.id')
			        ->select('userdiasemanas.*', 'diasemanas.nombre as diasemanas_nombre')
			        ->where('userdiasemanas.user_id', '=', $user->id)->get();
							Flash('¡Seleccionar uno o más Terapias, caso contrario seleccionar Ninguno!')->error()->important();
			        return view('terapiausuario-mgmt/create', ['user' => $user, 'terapias' => $terapias, 'userdiasemanas' => $userdiasemanas]);
					}
				}
				if($request->check==1){
					$terapiausuario = new UsuarioTerapia();
					$terapiausuario->terapia_id = $request->check;
					$terapiausuario->user_id = $user->id;
					$this->createTerapiaNullUsuarioBitacora($request, $user);
					if($terapiausuario->save()){
						Flash('¡El Empleado se ha agregado Exitosamente!')->success();
		        return redirect()->intended('/sisa/user-management');
					}
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

		public function createTerapiaNullUsuarioBitacora($request, $user){
        //Datos para la Bitacora
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $log = Auth::user()->username;

        $nombreterapia=Terapia::findOrFail($request->check);

             $data = 'Usuario: ' . $user->nombre1 .' '. $user->nombre2 .' '. $user->nombre3 .' '. $user->apellido1 .' '. $user->apellido2 .' '. $user->apellido3 . ' , Terapia: ' . $nombreterapia->nombre;

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
