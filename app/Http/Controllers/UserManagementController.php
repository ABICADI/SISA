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

class UserManagementController extends Controller {

    protected $redirectTo = '/user-management';

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $users = DB::table('users')
        ->leftJoin('rols', 'users.rol_id', '=', 'rols.id')
        ->select('users.*', 'rols.nombre as rols_nombre', 'rols.id as rols_id')->where('users.estado_id','!=','2')
        ->orWhere('users.rol_id', '!=', '1')
        ->paginate(10);

        return view('users-mgmt/index', ['users' => $users]);
    }


    public function create() {
        $rols = Rol::select('id', 'nombre')->where('rols.id','!=','1')->get();
        $departamentos = Departamento::all();
        $municipios = Municipio::all();
        $diasemanas = DiaSemana::all();
        $terapias = Terapia::all();

        return view('users-mgmt/create', ['rols' => $rols, 'departamentos' => $departamentos, 'municipios' => $municipios, 'diasemanas' => $diasemanas, 'terapias' => $terapias]);
    }

    public function store(Request $request){
        //Datos para la Bitacora
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $log = $request->User()->username;
        $estado_id = '1';
        
        $departamento = Departamento::findOrFail($request['departamento_id']);
        $municipio = Departamento::findOrFail($request['departamento_id']);
        $rol = Rol::findOrFail($request['rol_id']);
        $estado = Estado::findOrFail($estado_id);

        $data = 'DPI: ' . $request->dpi . ', Nombre Completo: ' . $request->nombre1 . $request->nombre2 . $request->nombre3 . $request->apellido1 . $request->apellido2 . $request->apellido3 . ', Datos de Usuario: ' . $request->username . $request->email . ', Direccion: ' . $departamento->nombre . $municipio->nombre . $request->direccion . ', Datos Personales: ' . $request->fecha_nacimiento . $request->telefono . ', Fecha de Ingreso: ' . $request->fecha_ingreso . ', Puesto Encargado: ' . $rol->nombre . ', Estado: ' . $estado->nombre;

        $this->validateInput($request);
        $user = new User();
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
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
        $user->estado_id = $estado_id;

        if($user->save()){
            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'EMPLEADO';
            $bitacora->actividad = 'CREAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            if($bitacora->save()){
                return redirect()->intended('/diasemanausuario-management');
            }
        } 
    }
    //proceso no funciona
    public function myformAjax($id){
        $municipios = DB::table("municipios")->where("departamento_id",$id)->lists("nombre","id");
        return json_encode($municipios);
    }

    public function show($id) {

    }

    public function view($id) {
        $user = User::find($id);
        if ($user == null || count($user) == 0) {
            return redirect()->intended('/user-management');
        }

        $rols = Rol::select('id', 'nombre')->where('rols.id','!=','1')->get();
        $departamentos = Departamento::all();
        $municipios = Municipio::all();
        return view('users-mgmt/view', ['user' => $user, 'rols' => $rols, 'departamentos' => $departamentos, 'municipios' => $municipios]);
    }

    public function edit($id) {
        $user = User::find($id);
        if ($user == null || count($user) == 0) {
            return redirect()->intended('/user-management');
        }

        $rols = Rol::select('id', 'nombre')->where('rols.id','!=','1')->get();
        $departamentos = Departamento::all();
        $municipios = Municipio::all();
        return view('users-mgmt/edit', ['user' => $user, 'rols' => $rols, 'departamentos' => $departamentos, 'municipios' => $municipios]);
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
        $user->estado_id = '1';

        if($user->save()){
           return redirect()->intended('/user-management'); 
        }
        
    }

    public function destroy($id) {
        //Datos para la Bitacora
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $log = Auth::User()->username;
        $userB = User::findOrFail($id);

        $data = 'Nombre y Apellido: ' . $userB->nombre1 . $userB->nombre2 . $userB->nombre3 . $userB->apellido1 . $userB->apellido2 . $userB->apellido3;
        
        $user = User::findOrFail($id);
        $user->fecha_egreso = $now;
        $user->estado_id = '2';

        if($user->save()){
            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'EMPLEADO';
            $bitacora->actividad = 'ELIMINAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            if($bitacora->save()){
                return redirect()->intended('/user-management');
            }
        }else{
            return redirect()->intended('error');
        }
    }

    public function search(Request $request) {
        $constraints = [
            'nombre1' => $request['nombre1'],
            'dpi' => $request['dpi']
        ];

       $users = $this->doSearchingQuery($constraints);
       return view('users-mgmt/index', ['users' => $users, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = User::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(10);
    }
    
    private function validateInput($request) {
        $this->validate($request, [
            'username' => 'required|min:6|max:20|unique:users',
            'email' => 'email|max:125|unique:users|nullable',
            'password' => 'required|min:8|confirmed',
            'dpi' => 'required|digits:13|unique:users',
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
