<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Bitacora;
use App\Rol;
use App\Estado;
use App\Departamento;
use App\Genero;
use App\Municipio;
use Auth;

class UserManagementController extends Controller {

    protected $redirectTo = '/sisa/user-management';

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $users = DB::table('users')
        ->leftJoin('rols', 'users.rol_id', '=', 'rols.id')
        ->leftJoin('estados', 'users.estado_id', '=', 'estados.id')
        ->select('users.*', 'rols.nombre as rols_nombre', 'estados.id as estado_id')
        ->where('users.estado_id','!=','2')
        ->where('users.id','!=','1')
        ->paginate(10);

        return view('users-mgmt/index', ['users' => $users]);
    }

    public function create() {
        $rols = Rol::select('id', 'nombre')->where('rols.id','!=','1')->orderBy('nombre', 'asc')->get();
        $departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $generos = Genero::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        return view('users-mgmt/create', ['rols' => $rols, 'departamentos' => $departamentos, 'generos' => $generos]);
    }

    public function getMunicipios(Request $request, $id){
        if($request->ajax()){
          $municipios = Municipio::buscar($id);
          return response()->json($municipios);
        }
    }

    public function store(Request $request){
        $estado_id = '1';

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
        $user->municipio_id = $request['municipio_id'];
        $user->direccion = $request['direccion'];
        $user->fecha_nacimiento = $request['fecha_nacimiento'];
        $user->fecha_ingreso = $request['fecha_ingreso'];
        $user->telefono = $request['telefono'];
        $user->rol_id = $request['rol_id'];
        $user->genero_id = $request['genero_id'];
        $user->estado_id = $estado_id;

        if($user->save()){
            $this->crearEmpleadoBitacora($request);
            Flash('¡Ha iniciado la creación del Empleado!')->success();
            return redirect()->intended('/sisa/diasemanausuario-management');
        }
    }

    public function show($id) {
      $user = User::findOrFail($id);
      if($user->delete()){
          Flash('¡Se cancelo la creación del Empleado Exitosamente!')->error()->important();
          return redirect()->intended('/sisa/user-management');
      }
    }

    public function view($id) {
        $user = User::find($id);
        if ($user == null || count($user) == 0) {
            return redirect()->intended('/sisa/user-management');
        }

        $userdiasemanas = DB::table('userdiasemanas')
        ->leftJoin('diasemanas', 'userdiasemanas.diasemana_id', '=', 'diasemanas.id')
        ->select('userdiasemanas.*', 'diasemanas.nombre as diasemana_nombre')
        ->where('userdiasemanas.user_id', '=', $id)->orderBy('diasemana_id','asc')->get();

        $usuarioterapias = DB::table('userterapias')
        ->leftJoin('terapias', 'userterapias.terapia_id', '=', 'terapias.id')
        ->select('userterapias.*', 'terapias.nombre as terapia_nombre')
        ->where('userterapias.user_id', '=', $id)->orderBy('terapias.nombre','asc')->get();

        $rols = Rol::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $municipios = Municipio::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $estados = Estado::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $generos = Genero::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        return view('users-mgmt/view', ['user' => $user, 'rols' => $rols, 'departamentos' => $departamentos, 'municipios' => $municipios, 'estados' => $estados, 'userdiasemanas' => $userdiasemanas, 'usuarioterapias' => $usuarioterapias, 'generos' => $generos]);
    }

    public function destroy($id) {
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);

        $user = User::findOrFail($id);
        $user->fecha_egreso = $now;
        $user->estado_id = '2';

        if($user->save()){
            $this->eliminarEmpleadoBitacora($id);
            Flash('¡El Empleado se ha eliminado Exitosamente!')->error();
            return redirect()->intended('/sisa/user-management');
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
            'municipio_id' => 'required',
            'direccion' => 'max:75',
            'fecha_nacimiento' => 'required',
            'fecha_ingreso' => 'required',
            'telefono' => 'digits:8|nullable',
            'rol_id' => 'required',
            'genero_id' => 'required',
        ]);
    }

    private function crearEmpleadoBitacora(Request $request){
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $log = Auth::user()->username;
        $estado_id = '1';

        $municipio = Municipio::findOrFail($request['municipio_id']);
        $departamento = Departamento::findOrFail($municipio->departamento_id);
        $rol = Rol::findOrFail($request['rol_id']);
        $estado = Estado::findOrFail($estado_id);
        $genero = Genero::findOrFail($request['genero_id']);

        $data = 'DPI: ' . $request->dpi . ', Nombre Completo: ' . $request->nombre1 .' '. $request->nombre2 .' '. $request->nombre3 . $request->apellido1 .' '. $request->apellido2 .' '. $request->apellido3 . ', Datos de Usuario: ' . $request->username . $request->email . ', Direccion: ' . $departamento->nombre .' '. $municipio->nombre .' '. $request->direccion . ', Datos Personales: ' . $request->fecha_nacimiento .' '. $request->telefono . ', Fecha de Ingreso: ' . $request->fecha_ingreso . ', Puesto Encargado: ' . $rol->nombre . ', Estado: ' . $estado->nombre . ', Genero: ' . $genero->nombre;

            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'EMPLEADO';
            $bitacora->actividad = 'CREAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            $bitacora->save();
    }

    private function eliminarEmpleadoBitacora($id){
        //Datos para la Bitacora
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $userB = User::findOrFail($id);

        $data = 'Nombre y Apellido: ' . $userB->nombre1 .' '. $userB->nombre2 .' '. $userB->nombre3 .' '. $userB->apellido1 .' '. $userB->apellido2 .' '. $userB->apellido3;

            $bitacora = new Bitacora();
            $bitacora->usuario = 'ADMIN';
            $bitacora->nombre_tabla = 'EMPLEADO';
            $bitacora->actividad = 'ELIMINAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            $bitacora->save();
    }
}
