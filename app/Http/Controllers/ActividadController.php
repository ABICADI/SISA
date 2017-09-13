<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Actividad;
use App\Bitacora;
use App\Departamento;
use App\Municipio;
use App\User;

class ActividadController extends Controller {

    public function index() {
        $actividades = DB::table('actividades')
        ->leftJoin('users', 'actividades.user_id', '=', 'users.id')
        ->leftJoin('departamentos', 'actividades.departamento_id', '=', 'departamentos.id')
        ->leftJoin('municipios', 'actividades.municipio_id', '=', 'municipios.id')
        ->select('actividades.*', 'users.nombre1 as users_nombre1', 'users.nombre2 as users_nombre2', 'users.nombre3 as users_nombre3', 'users.apellido1 as users_apellido1', 'users.apellido2 as users_apellido2', 'users.apellido3 as users_apellido3', 'users.id as users_id', 'departamentos.nombre as departamentos_nombre', 'departamentos.id as departamentos_id' ,'municipios.nombre as municipios_nombre', 'municipios.id as municipios_id')
        ->paginate(10);

        return view('actividad-mgmt/index', ['actividades' => $actividades]);
    } 

    public function create() {
        $users = User::select('id', 'nombre1', 'nombre2', 'nombre3', 'apellido1', 'apellido2', 'apellido3')->where('users.estado_id','!=','2')->get();
        $departamentos = Departamento::all();
        $municipios = Municipio::all();

        return view('actividad-mgmt/create', ['users' => $users, 'departamentos' => $departamentos, 'municipios' => $municipios]);
    }   

    public function store(Request $request){
        //Datos para la Bitacora
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $log = $request->User()->username;
        $departamento = Departamento::findOrFail($request['departamento_id']);
        $municipio = Municipio::findOrFail($request['municipio_id']);
        $user = User::findOrFail($request['user_id']);

        $data = 'Nombre Actividad: ' . $request->nombre . ', Nombre Actividad: ' . $user->nombre1 . $user->nombre2 . $user->nombre3 . $user->apellido1 . $user->apellido2 . $user->apellido3 . ', Direccion: ' . $departamento->nombre . $municipio->nombre . $request->direccion . ', Descripcion: ' . $request->descripcion . ', Fecha de la Actividad: ' . $request->fecha;

        $this->validateInput($request);
        $actividad = new Actividad();
        $actividad->nombre = $request['nombre'];
        $actividad->direccion = $request['direccion'];
        $actividad->descripcion = $request['descripcion'];
        $actividad->fecha = $request->fecha;
        $actividad->user_id = $request['user_id'];
        $actividad->departamento_id = $request['departamento_id'];
        $actividad->municipio_id = $request['municipio_id'];

        if($actividad->save()){
            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'ACTIVIDAD';
            $bitacora->actividad = 'CREAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            if($bitacora->save()){
                return redirect()->intended('/actividad-management');
            }
        }else{
            return redirect()->intended('error');
        }
    }

    public function show($id) {

    }

   public function view($id) {
        $actividad = Actividad::find($id);
        if ($actividad == null || count($actividad) == 0) {
            return redirect()->intended('/actividad-management');
        }

        $users = User::select('id', 'nombre1', 'nombre2', 'nombre3', 'apellido1', 'apellido2', 'apellido3')->where('users.estado_id','!=','2')->get();
        $departamentos = Departamento::all();
        $municipios = Municipio::all();
        return view('actividad-mgmt/view', ['actividad' => $actividad, 'users' => $users, 'departamentos' => $departamentos, 'municipios' => $municipios]);
    }

    public function edit($id) {
        $actividad = Actividad::find($id);
        if ($actividad == null || count($actividad) == 0) {
            return redirect()->intended('/actividad-management');
        }

        $users = User::select('id', 'nombre1', 'nombre2', 'nombre3', 'apellido1', 'apellido2', 'apellido3')->where('users.estado_id','!=','2')->get();
        $departamentos = Departamento::all();
        $municipios = Municipio::all();
        return view('actividad-mgmt/edit', ['actividad' => $actividad, 'users' => $users, 'departamentos' => $departamentos, 'municipios' => $municipios]);
    }

    public function update(Request $request, $id) {
        //Falta agregar Bitacora
        $actividad = Actividad::findOrFail($id);
        $user = User::findOrFail($actividad->user_id);

         if ($actividad->descripcion != $request['descripcion']) {
                $this->validateDes($request);
                $actividad->descripcion = $request['descripcion'];

                if($actividad->save()){
                   return redirect()->intended('/actividad-management'); 
                }
        }elseif ($actividad->descripcion == $request['descripcion']) {
                $this->validateUpdate($request);
                $actividad->nombre = $request['nombre'];
                $actividad->direccion = $request['direccion'];
                $actividad->descripcion = $request['descripcion'];
                $actividad->fecha = $request['fecha'];
                $actividad->user_id = $request['user_id'];
                $actividad->departamento_id = $request['departamento_id'];
                $actividad->municipio_id = $request['municipio_id'];

                if($actividad->save()){
                   return redirect()->intended('/actividad-management'); 
                }
        }        
    }

    public function destroy($id) {
        //Datos para la Bitacora
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $log = 'Prueba';//Auth::User()->username;
        $actividadfin = Actividad::findOrFail($id);
        $encargado = User::findOrFail($actividadfin->user_id);

        $data = 'Nombre de la Actividad: ' . $actividadfin->nombre . ', Encargado: ' . $encargado->nombre1 . $encargado->nombre2 . $encargado->nombre3 . $encargado->apellido1 . $encargado->apellido2 . $encargado->apellido3;
        
        $actividad = Actividad::findOrFail($id);

        if($actividad->delete()){
            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'ACTIVIDAD';
            $bitacora->actividad = 'ELIMINAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            if($bitacora->save()){
                return redirect()->intended('/actividad-management');
            }
        }else{
            return redirect()->intended('error');
        }
    }

    public function search(Request $request) {
        $constraints = [
            'nombre' => $request['nombre1']
        ];

       $actividades = $this->doSearchingQuery($constraints);
       return view('actividad-mgmt/index', ['actividades' => $actividades, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Actividad::query();
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
            'nombre' => 'required|max:50',
            'direccion' => 'max:75',
            'descripcion' => 'max:250',
            'fecha' => 'required',
            'user_id' => 'required',
            'departamento_id' => 'required',
            'municipio_id' => 'required',
        ]);
    }

    private function validateUpdate($request) {
        $this->validate($request, [
            'nombre' => 'max:50',
            'direccion' => 'max:75',
            'descripcion' => 'max:250',
            'fecha' => 'required',
            'user_id' => 'required',
            'departamento_id' => 'required',
            'municipio_id' => 'required',
        ]);
    }

    private function validateDes($request) {
        $this->validate($request, [
            'descripcion' => 'max:250',
        ]);
    }
}
