<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Actividad;
use App\Bitacora;
use App\User;
use App\Departamento;
use App\Municipio;
use Auth;

class ActividadController extends Controller {

    protected $redirectTo = '/sisa/actividad-management';

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $actividades = DB::table('actividades')
        ->leftJoin('users', 'actividades.user_id', '=', 'users.id')
        ->leftJoin('municipios', 'actividades.municipio_id', '=', 'municipios.id')
        ->leftJoin('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
        ->select('actividades.*', 'users.nombre1 as users_nombre1', 'users.nombre2 as users_nombre2', 'users.nombre3 as users_nombre3', 'users.apellido1 as users_apellido1', 'users.apellido2 as users_apellido2', 'users.apellido3 as users_apellido3', 'users.username as users_username', 'departamentos.nombre as departamentos_nombre', 'municipios.nombre as municipios_nombre')
        ->paginate(10);

        return view('actividad-mgmt/index', ['actividades' => $actividades]);
    }

    public function create() {
        $format = 'd/m/Y';
        $fecha = date($format);
        $users = User::select('id', 'nombre1', 'nombre2', 'nombre3', 'apellido1', 'apellido2', 'apellido3')
        ->where('users.estado_id','!=','2')->orderBy('nombre1', 'asc')->get();
        $departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();

        return view('actividad-mgmt/create', ['users' => $users, 'departamentos' => $departamentos, 'fecha' => $fecha]);
    }

    public function store(Request $request){
        $this->validateInput($request);
        $actividad = new Actividad();
        $actividad->nombre = strtoupper($request['nombre']);
        $actividad->direccion = strtoupper($request['direccion']);
        $actividad->descripcion = strtoupper($request['descripcion']);
        $actividad->fecha = $request['fecha'];
        $actividad->user_id = $request['user_id'];
        $actividad->municipio_id = $request['municipio_id'];

        if($actividad->save()){
            $this->createActividadBitacora($request);
            Flash('¡La Actividad se ha creado Exitosamente!')->success();
            return redirect()->intended('/sisa/actividad-management');
        }
    }

    public function show($id) {

    }

   public function view($id) {
        $actividad = Actividad::find($id);
        if ($actividad == null || count($actividad) == 0) {
            Flash('¡Error al cargar Actividades!')->error();
            return redirect()->intended('/sisa/actividad-management');
        }

        $users = User::select('id', 'nombre1', 'nombre2', 'nombre3', 'apellido1', 'apellido2', 'apellido3')
        ->where('users.estado_id','!=','2')->orderBy('nombre1', 'asc')->get();
        $departamentos = Municipio::join('departamentos', 'municipios.departamento_id', 'departamentos.id')
                                  ->select('departamentos.id as id', 'departamentos.nombre as nombre')
                                  ->where('municipios.id', '=', $actividad->municipio_id)->get();
        $municipios = Municipio::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        return view('actividad-mgmt/view', ['actividad' => $actividad, 'users' => $users, 'departamentos' => $departamentos, 'municipios' => $municipios]);
    }

    public function edit($id) {
        $actividad = Actividad::join('municipios', 'actividades.municipio_id', 'municipios.id')
                              ->join('departamentos', 'municipios.departamento_id', 'departamentos.id')
                              ->select('actividades.*', 'municipios.nombre as Municipio', 'departamentos.nombre as Departamento')->find($id);
        if ($actividad == null || count($actividad) == 0) {
            Flash('¡Error al cargar Actividades!')->error();
            return redirect()->intended('/sisa/actividad-management');
        }

        $users = User::select('id', 'nombre1', 'nombre2', 'nombre3', 'apellido1', 'apellido2', 'apellido3')
        ->where('users.estado_id','!=','2')->orderBy('nombre1', 'asc')->get();
        $departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $municipios = Municipio::select('id', 'nombre')->where('id', '=', $actividad->municipio_id)->get();
        return view('actividad-mgmt/edit', ['actividad' => $actividad, 'users' => $users, 'departamentos' => $departamentos, 'municipios' => $municipios]);
    }

    public function update(Request $request, $id) {
        $actividad = Actividad::findOrFail($id);

        $this->validateUpdate($request);
        $actividad->nombre = strtoupper($request['nombre']);
        $actividad->direccion = strtoupper($request['direccion']);
        $actividad->descripcion = strtoupper($request['descripcion']);
        $actividad->fecha = $request['fecha'];
        $actividad->user_id = $request['user_id'];
        $actividad->municipio_id = $request['municipio_paciente'];
        $this->updateActividadBitacora($request, $id);
            if($actividad->save()){
                Flash('¡La Actividad se ha actualizado Exitosamente!')->success();
                return redirect()->intended('/sisa/actividad-management');
            }
    }

    public function search(Request $request) {
        $constraints = [
            'nombre1' => strtoupper($request['nombre1']),
            'fechaInicio' => $request['fecha_inicio'],
            'fechaFin' => $request['fecha_fin']
        ];

        //dd($constraints);

        $nombre = strtoupper($request['nombre1']);

        $fechaInicio = $request['fecha_inicio'];
        $fechaFin = $request['fecha_fin'];

        if($request['nombre1']!=''){
          $actividades = DB::table('actividades')
            ->leftJoin('users', 'actividades.user_id', '=', 'users.id')
            ->leftJoin('municipios', 'actividades.municipio_id', '=', 'municipios.id')
            ->leftJoin('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
            ->select(DB::raw('users.nombre1 as users_nombre1,
                              users.nombre2 as users_nombre2,
                              users.nombre3 as users_nombre3,
                              users.apellido1 as users_apellido1,
                              users.apellido2 as users_apellido2,
                              users.apellido3 as users_apellido3,
                              users.username as users_username,
                              departamentos.nombre as departamentos_nombre,
                              municipios.nombre as municipios_nombre,
                              actividades.*'))
            ->whereRaw("(actividades.nombre like '%$nombre%')")
            ->orWhereRaw("(users.nombre1 like '%$nombre%')")
            ->orWhereRaw("(users.nombre2 like '%$nombre%')")
            ->orWhereRaw("(users.nombre3 like '%$nombre%')")
            ->orWhereRaw("(CONCAT(users.nombre1,' ',users.nombre2) like '%$nombre%')")
            ->orWhereRaw("(CONCAT(users.nombre1,' ',users.nombre2,' ',users.nombre3) like '%$nombre%')")
            ->orWhereRaw("(CONCAT(users.nombre1,' ',users.apellido1) like '%$nombre%')")
            ->orWhereRaw("(CONCAT(users.nombre1,' ',users.nombre2,' ',users.apellido1) like '%$nombre%')")
            ->orWhereRaw("(actividades.direccion like '%$nombre%')")
            ->orWhereRaw("(municipios.nombre like '%$nombre%')")
            ->orWhereRaw("(departamentos.nombre like '%$nombre%')")
            ->paginate(10);
        }

          else if($this->validar_fecha($fechaInicio)
            &&$this->validar_fecha($fechaFin)){
            //dd($constraints);
            $actividades = DB::table('actividades')
            ->leftJoin('users', 'actividades.user_id', '=', 'users.id')
            ->leftJoin('municipios', 'actividades.municipio_id', '=', 'municipios.id')
            ->leftJoin('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
            ->select(DB::raw('users.nombre1 as users_nombre1,
                              users.nombre2 as users_nombre2,
                              users.nombre3 as users_nombre3,
                              users.apellido1 as users_apellido1,
                              users.apellido2 as users_apellido2,
                              users.apellido3 as users_apellido3,
                              users.username as users_username,
                              departamentos.nombre as departamentos_nombre,
                              municipios.nombre as municipios_nombre,
                              actividades.*'))
            ->whereRaw("(actividades.fecha::text like '%$fechaInicio%')")
            ->whereRaw("(actividades.fecha::text like '%$fechaFin%')")
            ->orWhereBetween('actividades.fecha', [$fechaInicio, $fechaFin])
            ->paginate(10);
          }
          else{
            $actividades = DB::table('actividades')
            ->leftJoin('users', 'actividades.user_id', '=', 'users.id')
            ->leftJoin('municipios', 'actividades.municipio_id', '=', 'municipios.id')
            ->leftJoin('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
            ->select(DB::raw('users.nombre1 as users_nombre1,
                              users.nombre2 as users_nombre2,
                              users.nombre3 as users_nombre3,
                              users.apellido1 as users_apellido1,
                              users.apellido2 as users_apellido2,
                              users.apellido3 as users_apellido3,
                              users.username as users_username,
                              departamentos.nombre as departamentos_nombre,
                              municipios.nombre as municipios_nombre,
                              actividades.*'))
            ->paginate(10);
          }

        $message = ' ';
        return view('actividad-mgmt/index', ['actividades' => $actividades, 'searchingVals' => $constraints]);
    }

    private function validar_fecha($fecha){

      $valores = explode('-', $fecha);
      if((count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0]))
        ||($fecha==null)) return true;
        return false;
    }

    private function validateInput($request) {
        $this->validate($request, [
            'nombre' => 'required|max:50',
            'direccion' => 'max:75',
            'descripcion' => 'max:1000',
            'fecha' => 'required',
            'user_id' => 'required',
            'municipio_id' => 'required',
        ]);
    }

    private function validateUpdate($request) {
        $this->validate($request, [
            'nombre' => 'max:50',
            'direccion' => 'max:75',
            'descripcion' => 'max:1000',
            'fecha' => 'required',
            'user_id' => 'required',
            'municipio_paciente' => 'required',
        ]);
    }

    private function createActividadBitacora($request){
        //Datos para la Bitacora
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $log = Auth::user()->username;
        $municipio = Municipio::findOrFail($request['municipio_id']);
        $departamento = Departamento::findOrFail($municipio->departamento_id);
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
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $log = Auth::user()->username;
        $actividad = Actividad::findOrFail($id);
        $departamentonew = Departamento::find($request['departamento_paciente']);
        $municipionew = Municipio::find($request['municipio_paciente']);
        $municipioold = Municipio::find($actividad->municipio_id);
        $departamentoold = Departamento::find($municipioold->departamento_id);
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

        if($actividad->municipio_id != $request['municipio_paciente']){
            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'ACTIVIDAD';
            $bitacora->actividad = 'ACTUALIZAR';
            $bitacora->anterior = 'Departamento: ' . $departamentoold->nombre.', Municipio: ' . $municipioold->nombre;
            $bitacora->nuevo = 'Departamento: ' . $departamentonew->nombre.', Municipio: ' . $municipionew->nombre;
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
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $user = Auth::user()->username;
        $actividadfin = Actividad::find($id);
        $encargado = User::find($actividadfin->user_id);

        $data = 'Nombre de la Actividad: ' . $actividadfin->nombre . ', Encargado: ' . $encargado->nombre1 .' '. $encargado->nombre2 .' '. $encargado->nombre3 .' '. $encargado->apellido1 .' '. $encargado->apellido2 .' '. $encargado->apellido3;

            $bitacora = new Bitacora();
            $bitacora->usuario = $user;
            $bitacora->nombre_tabla = 'ACTIVIDAD';
            $bitacora->actividad = 'ELIMINAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            $bitacora->save();
    }
}
