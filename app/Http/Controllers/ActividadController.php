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
        ->select('actividades.*', 'users.nombre1 as users_nombre1', 'users.nombre2 as users_nombre2', 'users.nombre3 as users_nombre3', 'users.apellido1 as users_apellido1', 'users.apellido2 as users_apellido2', 'users.apellido3 as users_apellido3', 'users.username as users_username', 'departamentos.nombre as departamentos_nombre', 'municipios.nombre as municipios_nombre')
        ->paginate(10);

        return view('actividad-mgmt/index', ['actividades' => $actividades]);
    } 

    public function create() {
        $users = User::select('id', 'nombre1', 'nombre2', 'nombre3', 'apellido1', 'apellido2', 'apellido3')
        ->where('users.estado_id','!=','2')->orderBy('nombre1', 'asc')->get();
        $departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $municipios = Municipio::select('id', 'nombre')->orderBy('nombre', 'asc')->get();

        return view('actividad-mgmt/create', ['users' => $users, 'departamentos' => $departamentos, 'municipios' => $municipios]);
    }   

    public function store(Request $request){
        $this->validateInput($request);
        $actividad = new Actividad();
        $actividad->nombre = $request['nombre'];
        $actividad->direccion = $request['direccion'];
        $actividad->descripcion = $request['descripcion'];
        $actividad->fecha = $request['fecha'];
        $actividad->user_id = $request['user_id'];
        $actividad->departamento_id = $request['departamento_id'];
        $actividad->municipio_id = $request['municipio_id'];

        if($actividad->save()){
            $this->createActividadBitacora($request);
            return redirect()->intended('/actividad-management');
        }
    }

    public function show($id) {

    }

   public function view($id) {
        $actividad = Actividad::find($id);
        if ($actividad == null || count($actividad) == 0) {
            return redirect()->intended('/actividad-management');
        }

        $users = User::select('id', 'nombre1', 'nombre2', 'nombre3', 'apellido1', 'apellido2', 'apellido3')
        ->where('users.estado_id','!=','2')->orderBy('nombre1', 'asc')->get();
        $departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $municipios = Municipio::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        return view('actividad-mgmt/view', ['actividad' => $actividad, 'users' => $users, 'departamentos' => $departamentos, 'municipios' => $municipios]);
    }

    public function edit($id) {
        $actividad = Actividad::find($id);
        if ($actividad == null || count($actividad) == 0) {
            return redirect()->intended('/actividad-management');
        }

        $users = User::select('id', 'nombre1', 'nombre2', 'nombre3', 'apellido1', 'apellido2', 'apellido3')
        ->where('users.estado_id','!=','2')->orderBy('nombre1', 'asc')->get();
        $departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $municipios = Municipio::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        return view('actividad-mgmt/edit', ['actividad' => $actividad, 'users' => $users, 'departamentos' => $departamentos, 'municipios' => $municipios]);
    }

    public function update(Request $request, $id) {
        $actividad = Actividad::findOrFail($id);

        $this->validateUpdate($request);
        $actividad->nombre = $request['nombre'];
        $actividad->direccion = $request['direccion'];
        $actividad->descripcion = $request['descripcion'];
        $actividad->fecha = $request['fecha'];
        $actividad->user_id = $request['user_id'];
        $actividad->departamento_id = $request['departamento_id'];
        $actividad->municipio_id = $request['municipio_id'];
        $this->updateActividadBitacora($request, $id);
            if($actividad->save()){
                return redirect()->intended('/actividad-management'); 
            }      
    }

    public function destroy($id) {
        $actividad = Actividad::findOrFail($id);
        $this->deleteActividadBitacora($id);

        if($actividad->delete()){
            return redirect()->intended('/actividad-management');
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
            'descripcion' => 'max:500',
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
            'descripcion' => 'max:500',
            'fecha' => 'required',
            'user_id' => 'required',
            'departamento_id' => 'required',
            'municipio_id' => 'required',
        ]);
    }

    private function createActividadBitacora($request){
        //Datos para la Bitacora
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $log = $request->User()->username;
        $departamento = Departamento::findOrFail($request['departamento_id']);
        $municipio = Municipio::findOrFail($request['municipio_id']);
        $user = User::findOrFail($request['user_id']);

        $data = 'Nombre Actividad: ' . $request->nombre . ', Nombre Actividad: ' . $user->nombre1 .' '. $user->nombre2 .' '. $user->nombre3 .' '. $user->apellido1 .' '. $user->apellido2 .' '. $user->apellido3 . ', Direccion: ' . $departamento->nombre .' '. $municipio->nombre .' '. $request->direccion . ', Descripcion: ' . $request->descripcion . ', Fecha de la Actividad: ' . $request->fecha;

            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'ACTIVIDAD';
            $bitacora->actividad = 'CREAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            $bitacora->save(); 
    }

    private function updateActividadBitacora($request, $id){
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $log = $request->User()->username;
        $actividad = Actividad::findOrFail($id);
        $departamentonew = Departamento::find($request['departamento_id']);
        $departamentoold = Departamento::find($actividad->departamento_id);
        $municipionew = Municipio::find($request['municipio_id']);
        $municipioold = Municipio::find($actividad->municipio_id);
        $usernew = User::find($request['user_id']);
        $userold = User::find($actividad->user_id);

        if($actividad->user_id != $request['user_id']){
            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'ACTIVIDAD';
            $bitacora->actividad = 'ACTUALIZAR';
            $bitacora->anterior = 'Encargado: ' . $userold->nombre1 .' '. $userold->nombre2 .' '. $userold->nombre3 .' '. $userold->apellido1 .' '.$userold->apellido2 .' '. $userold->apellido3;
            $bitacora->nuevo = 'Encargado: ' . $usernew->nombre1 .' '. $usernew->nombre2 .' '. $usernew->nombre3 .' '. $usernew->apellido1 .' '.$usernew->apellido2 .' '. $usernew->apellido3;
            $bitacora->fecha = $now;
            $bitacora->save();
        }

        if($actividad->nombre != $request['nombre']){
            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'ACTIVIDAD';
            $bitacora->actividad = 'ACTUALIZAR';
            $bitacora->anterior = 'Actividad: ' . $actividad->nombre;
            $bitacora->nuevo = 'Actividad: ' . $request->nombre;
            $bitacora->fecha = $now;
            $bitacora->save();
        }

        if($actividad->descripcion != $request['descripcion']){
            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'ACTIVIDAD';
            $bitacora->actividad = 'ACTUALIZAR';
            $bitacora->anterior = 'Descripcion: ' . $actividad->descripcion;
            $bitacora->nuevo = 'Descripcion: ' . $request->descripcion;
            $bitacora->fecha = $now;
            $bitacora->save();
        }

        if($actividad->departamento_id != $request['departamento_id']){
            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'ACTIVIDAD';
            $bitacora->actividad = 'ACTUALIZAR';
            $bitacora->anterior = 'Departamento: ' . $departamentoold->nombre;
            $bitacora->nuevo = 'Departamento: ' . $departamentonew->nombre;
            $bitacora->fecha = $now;
            $bitacora->save();
        }

        if($actividad->municipio_id != $request['municipio_id']){
            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'ACTIVIDAD';
            $bitacora->actividad = 'ACTUALIZAR';
            $bitacora->anterior = 'Municipio: ' . $municipioold->nombre;
            $bitacora->nuevo = 'Municipio: ' . $municipionew->nombre;
            $bitacora->fecha = $now;
            $bitacora->save();
        }
        
        if($actividad->direccion != $request['direccion']){
            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'ACTIVIDAD';
            $bitacora->actividad = 'ACTUALIZAR';
            $bitacora->anterior = 'Direccion: ' . $actividad->direccion;
            $bitacora->nuevo = 'Direccion: ' . $request->direccion;
            $bitacora->fecha = $now;
            $bitacora->save();
        }

        if($actividad->fecha != $request['fecha']){
            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'ACTIVIDAD';
            $bitacora->actividad = 'ACTUALIZAR';
            $bitacora->anterior = 'Fecha: ' . $actividad->fecha;
            $bitacora->nuevo = 'Fecha: ' . $request->fecha;
            $bitacora->fecha = $now;
            $bitacora->save();
        }
    }

    private function deleteActividadBitacora($id){
        //Datos para la Bitacora
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $actividadfin = Actividad::find($id);
        $encargado = User::find($actividadfin->user_id);

        $data = 'Nombre de la Actividad: ' . $actividadfin->nombre . ', Encargado: ' . $encargado->nombre1 .' '. $encargado->nombre2 .' '. $encargado->nombre3 .' '. $encargado->apellido1 .' '. $encargado->apellido2 .' '. $encargado->apellido3;

            $bitacora = new Bitacora();
            $bitacora->usuario = 'Administrador';
            $bitacora->nombre_tabla = 'ACTIVIDAD';
            $bitacora->actividad = 'ELIMINAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            $bitacora->save();
    }
}