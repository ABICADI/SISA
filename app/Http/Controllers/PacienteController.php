<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Paciente;
use App\Bitacora;
use App\Pago;
use App\Departamento;
use App\Municipio;
use App\Genero;
use Auth;


class PacienteController extends Controller {

    protected $redirectTo = '/sisa/paciente-management';

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $pacientes = DB::table('pacientes')
        ->join('generos', 'pacientes.genero_id', 'generos.id')
        ->select('pacientes.*', 'generos.nombre as nombre')->paginate(10);

        return view('paciente-mgmt/index', ['pacientes' => $pacientes]);
    }

    public function create() {
        $format = 'd/m/Y';
        $fecha = date($format);
        $departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $pagos = Pago::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $generos = Genero::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        return view('paciente-mgmt/create', ['departamentos' => $departamentos, 'pagos' => $pagos, 'generos' => $generos, 'fecha' => $fecha]);
    }

    public function getMunicipios(Request $request, $id){
        if($request->ajax()){
          $municipios = Municipio::buscar($id);
          return response()->json($municipios);
        }
    }

    public function store(Request $request){

        $this->validateInput($request);
        $paciente = new Paciente();
        $paciente->cui = $request['cui'];
        $paciente->nombre1 = strtoupper($request['nombre1']);
        $paciente->nombre2 = strtoupper($request['nombre2']);
        $paciente->nombre3 = strtoupper($request['nombre3']);
        $paciente->apellido1 = strtoupper($request['apellido1']);
        $paciente->apellido2 = strtoupper($request['apellido2']);
        $paciente->apellido3 = strtoupper($request['apellido3']);
        $paciente->municipio_id = $request['municipio_id'];
        $paciente->direccion = strtoupper($request['direccion']);
        $paciente->fecha_nacimiento = $request['fecha_nacimiento'];
        $paciente->encargado = strtoupper($request['encargado']);
        $paciente->fecha_ingreso = $request['fecha_ingreso'];
        $paciente->telefono = $request['telefono'];
        $paciente->seguro_social = $request['seguro_social'];
        $paciente->observacion = strtoupper($request['observacion']);
        $paciente->pago_id = $request['pago_id'];
        $paciente->genero_id = $request['genero_id'];

        if($paciente->save()){
            $this->crearPacienteBitacora($request);
            Flash('¡El paciente se ha creado Exitosamente!')->success();
            return redirect()->intended('/sisa/paciente-management');
        }
    }

    public function show($id) {

    }

    public function edit($id) {

        $paciente = Paciente::join('municipios', 'pacientes.municipio_id', 'municipios.id')
                              ->join('departamentos', 'municipios.departamento_id', 'departamentos.id')
                              ->select('pacientes.*', 'municipios.nombre as Municipio', 'departamentos.nombre as Departamento')->find($id);
        if ($paciente == null || count($paciente) == 0) {
            Flash('¡Error al cargar los Pacientes!')->error();
            return redirect()->intended('/sisa/paciente-management');
        }
        $departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $municipios = Municipio::select('id', 'nombre')->where('id', '=', $paciente->municipio_id)->get();
        $pagos = Pago::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $generos = Genero::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        return view('paciente-mgmt/edit', ['paciente' => $paciente, 'departamentos' => $departamentos, 'municipios' => $municipios, 'pagos' => $pagos, 'generos' => $generos]);
    }

    public function update(Request $request, $id) {
        $paciente = Paciente::findOrFail($id);

        $this->validateUpdate($request);
        if($request['municipio_paciente']!=0){
          $paciente->municipio_id = $request['municipio_paciente'];
        }
        $paciente->cui = $request['cui'];
        $paciente->nombre1 = strtoupper($request['nombre1']);
        $paciente->nombre2 = strtoupper($request['nombre2']);
        $paciente->nombre3 = strtoupper($request['nombre3']);
        $paciente->apellido1 = strtoupper($request['apellido1']);
        $paciente->apellido2 = strtoupper($request['apellido2']);
        $paciente->apellido3 = strtoupper($request['apellido3']);
        $paciente->direccion = strtoupper($request['direccion']);
        $paciente->fecha_nacimiento = $request['fecha_nacimiento'];
        $paciente->encargado = strtoupper($request['encargado']);
        $paciente->fecha_ingreso = $request['fecha_ingreso'];
        $paciente->telefono = $request['telefono'];
        $paciente->seguro_social = $request['seguro_social'];
        $paciente->observacion = strtoupper($request['observacion']);
        $paciente->pago_id = $request['pago_id'];
        $paciente->genero_id = $request['genero_id'];
        $this->updatePacienteBitacora($request, $id);
        if($paciente->save()) {
          Flash('¡El paciente se ha actualizado Exitosamente!')->success();
          return redirect()->intended('/sisa/paciente-management');
        }
    }

    public function search(Request $request) {
        $constraints = [
            'nombre1' => strtoupper ($request['nombre1'])
        ];

        $nombre = strtoupper($request['nombre1']);
        $pacientes = DB::table('pacientes')
            ->leftJoin('generos', 'pacientes.genero_id', '=', 'generos.id')
            ->select(DB::raw('*'))
            ->whereRaw("(pacientes.seguro_social like '%$nombre%')")
            ->orWhereRaw("(nombre like '%$nombre%')")
            ->orWhereRaw("(nombre1 like '%$nombre%')")
            ->orWhereRaw("(nombre2 like '%$nombre%')")
            ->orWhereRaw("(nombre3 like '%$nombre%')")
            ->orWhereRaw("(CONCAT(nombre1,' ',nombre2) like '%$nombre%')")
            ->orWhereRaw("(CONCAT(nombre1,' ',nombre2,' ',nombre3) like '%$nombre%')")
            ->orWhereRaw("(CONCAT(nombre1,' ',apellido1) like '%$nombre%')")
            ->orWhereRaw("(CONCAT(nombre1,' ',nombre2,' ',apellido1) like '%$nombre%')")
            ->paginate(10);

        return view('paciente-mgmt/index', ['pacientes' => $pacientes, 'searchingVals' => $constraints]);
    }

    private function validateInput($request) {
        $this->validate($request, [
            'cui' => 'min:13|max:13|unique:pacientes|nullable',
            'nombre1' => 'required|max:30',
            'nombre2' => 'max:30',
            'nombre3' => 'max:30',
            'apellido1' => 'required|max:30',
            'apellido2' => 'max:30',
            'apellido3' => 'max:30',
            'municipio_id' => 'required',
            'direccion' => 'max:75',
            'fecha_nacimiento' => 'required',
            'encargado' => 'max:100',
            'fecha_ingreso' => 'required',
            'telefono' => 'digits:8|nullable',
            'seguro_social' => 'max:10|unique:pacientes|required',
            'observacion' => 'max:500|nullable',
            'pago_id' => 'required',
            'genero_id' => 'required',
        ]);
    }

    private function validateUpdate($request) {
        $this->validate($request, [
            'cui' => 'min:13|max:13|nullable',
            'nombre1' => 'required|max:30',
            'nombre2' => 'max:30',
            'nombre3' => 'max:30',
            'apellido1' => 'required|max:30',
            'apellido2' => 'max:30',
            'apellido3' => 'max:30',
            'direccion' => 'max:75',
            'fecha_nacimiento' => 'required',
            'encargado' => 'max:100',
            'fecha_ingreso' => 'required',
            'telefono' => 'digits:8|nullable',
            'seguro_social' => 'max:10|required',
            'observacion' => 'max:500',
            'pago_id' => 'required',
            'genero_id' => 'required',
        ]);
    }

    private function crearPacienteBitacora(Request $request){
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $log = Auth::user()->username;

        $departamento = Departamento::findOrFail($request['departamento_id']);
        $municipio = Municipio::findOrFail($request['municipio_id']);
        $pago = Pago::findOrFail($request['pago_id']);
        $genero = Genero::findOrFail($request['genero_id']);

        $data = 'CUI: ' . $request->cui . ', Nombre Completo: ' . $request->nombre1 .' '. $request->nombre2 .' '. $request->nombre3 . $request->apellido1 .' '. $request->apellido2 .' '. $request->apellido3 . ', Datos del Paciente: ' . $request->fecha_nacimiento .' '. $genero->nombre . ', Direccion: ' . $departamento->nombre .' '. $municipio->nombre .' '. $request->direccion . ', Encargado: ' . $request->encargado .' '. $request->telefono . ', Fecha de Ingreso: ' . $request->fecha_ingreso . ', Datos Médicos: ' . $request->seguro_social .', Tipo de Pago: ' . $pago->nombre;

            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'PACIENTE';
            $bitacora->actividad = 'CREAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            $bitacora->save();
    }

    private function updatePacienteBitacora($request, $id){
      //Datos para la Bitacora
      date_default_timezone_set('america/guatemala');
      $format = 'd/m/Y';
      $now = date($format);
      $user = Auth::user()->username;
      $paciente = Paciente::findOrFail($id);

      $departamentonew = Departamento::find($request['departamento_paciente']);
      $municipionew = Municipio::find($request['municipio_paciente']);
      $municipioold = Municipio::find($paciente->municipio_id);
      $departamentoold = Departamento::find($municipioold->departamento_id);
      $pagonew = Pago::find($request['pago_id']);
      $pagoold = Pago::find($paciente->pago_id);
      $generonew = Genero::find($request['genero_id']);
      $generoold = Genero::find($paciente->genero_id);

          if ($paciente->cui != $request['cui']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'CUI: ' . $paciente->cui;
              $bitacora->nuevo = 'CUI: ' . $request->cui;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->nombre1 != $request['nombre1']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'Primer Nombre: ' . $paciente->nombre1;
              $bitacora->nuevo = 'Primer Nombre: ' . $request->nombre1;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->nombre2 != $request['nombre2']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'Segundo Nombre: ' . $paciente->nombre2;
              $bitacora->nuevo = 'Segundo Nombre: ' . $request->nombre2;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->nombre3 != $request['nombre3']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'Tercer Nombre: ' . $paciente->nombre3;
              $bitacora->nuevo = 'Tercer Nombre: ' . $request->nombre3;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->apellido1 != $request['apellido1']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'Primer Apellido: ' . $paciente->apellido1;
              $bitacora->nuevo = 'Primer Apellido: ' . $request->apellido1;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->apellido2 != $request['apellido2']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'Segundo Apellido: ' . $paciente->apellido2;
              $bitacora->nuevo = 'Segundo Apellido: ' . $request->apellido2;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->apellido3 != $request['apellido3']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'Tercer Apellido: ' . $paciente->apellido3;
              $bitacora->nuevo = 'Tercer Apellido: ' . $request->apellido3;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->municipio_id != $request['municipio_paciente']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'Departamento: ' . $departamentoold->nombre . ', Municipio: ' . $municipioold->nombre;
              $bitacora->nuevo = 'Departamento: ' . $departamentonew->nombre . ', Municipio: ' . $municipionew->nombre;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->direccion != $request['direccion']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'Dirección: ' . $paciente->direccion;
              $bitacora->nuevo = 'Dirección: ' . $request->direccion;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->fecha_nacimiento != $request['fecha_nacimiento']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'Fecha de Nacimiento: ' . $paciente->fecha_nacimiento;
              $bitacora->nuevo = 'Fecha de Nacimiento: ' . $request->fecha_nacimiento;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->encargado != $request['encargado']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'Encargado: ' . $paciente->encargado;
              $bitacora->nuevo = 'Encargado: ' . $request->encargado;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->fecha_ingreso != $request['fecha_ingreso']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'Fecha de Ingreso: ' . $paciente->fecha_ingreso;
              $bitacora->nuevo = 'Fecha de Ingreso: ' . $request->fecha_ingreso;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->telefono != $request['telefono']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'Teléfono: ' . $paciente->telefono;
              $bitacora->nuevo = 'Teléfono: ' . $request->telefono;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->seguro_social != $request['seguro_social']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'No. Seguro Social: ' . $paciente->seguro_social;
              $bitacora->nuevo = 'No. Seguro Social: ' . $request->seguro_social;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->observacion != $request['observacion']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'Observación: ' . $paciente->observacion;
              $bitacora->nuevo = 'Observación: ' . $request->observacion;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->pago_id != $request['pago_id']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'Tipo de Pago: ' . $pagoold->nombre;
              $bitacora->nuevo = 'Tipo de Pago: ' . $pagonew->nombre;
              $bitacora->fecha = $now;
              $bitacora->save();
          }

          if ($paciente->genero_id != $request['genero_id']) {
              $bitacora = new Bitacora();
              $bitacora->usuario = $user;
              $bitacora->nombre_tabla = 'PACIENTE';
              $bitacora->actividad = 'ACTUALIZAR';
              $bitacora->anterior = 'Género: ' . $generoold->nombre;
              $bitacora->nuevo = 'Género: ' . $generonew->nombre;
              $bitacora->fecha = $now;
              $bitacora->save();
          }
    }

}
