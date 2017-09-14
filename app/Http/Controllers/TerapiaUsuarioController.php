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

class TerapiaUsuarioController extends Controller {
		    protected $redirectTo = '/terapiausuario-management'; //redirecciona la ruta

public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
    	$last = DB::table('users')->latest()->first();
        $user = User::find($last->id);

        $rols = Rol::all();
        $departamentos = Departamento::all();
        $municipios = Municipio::all();
        $terapias = Terapia::all();
        $userdiasemanas = DB::table('userdiasemanas')
        ->leftJoin('diasemanas', 'userdiasemanas.diasemana_id', '=', 'diasemanas.id')
        ->select('userdiasemanas.*', 'diasemanas.nombre as diasemanas_nombre')
        ->where('userdiasemanas.user_id', '=', $user->id)->get();
        return view('terapiausuario-mgmt/create', ['user' => $user, 'rols' => $rols, 'departamentos' => $departamentos, 'municipios' => $municipios, 'terapias' => $terapias, 'userdiasemanas' => $userdiasemanas]);
    }

    public function store(Request $request){
        //Datos para la Bitacora
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $log = $request->User()->username;
        $last = DB::table('users')->latest()->first();
        $user = User::find($last->id);
        $terapias = $request->terapia;

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

    public function createTerpiaUsuario($request, $terapia, $user){
        //Datos para la Bitacora
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $log = $request->User()->username;
        $terapiauser = Terapia::find($terapia);

             $data = 'Usuario: ' . $user->nombre1 .' '. $user->nombre2 .' '. $user->nombre3 .' '. $user->apellido1 .' '. $user->apellido2 .' '. $user->apellido3 . ' , Dia: ' . $terapiauser->nombre;  

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
