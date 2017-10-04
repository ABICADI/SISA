<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Paciente;
use App\Bitacora;
use App\Medico;
use App\Pago;
use App\Estado;
use App\Departamento;
use App\Municipio;


class PacienteController extends Controller {

    protected $redirectTo = '/paciente-management';

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $pacientes = DB::table('pacientes')
        ->select('pacientes.*')->paginate(10);

        return view('paciente-mgmt/index', ['pacientes' => $pacientes]);
    }

    public function create() {
    	  $medicos = Medico::select('id', 'colegiado', 'nombre')->orderBy('nombre', 'asc')->get();
        $departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $municipios = Municipio::select('id', 'nombre','departamento_id')->orderBy('nombre', 'asc')->get();
        $pagos = Pago::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        return view('paciente-mgmt/create', ['medicos' => $medicos, 'departamentos' => $departamentos, 'municipios' => $municipios, 'pagos' => $pagos]);
    }

    public function store(Request $request){

        $this->validateInput($request);
        $paciente = new Paciente();
        $paciente->cui = $request['cui'];
        $paciente->nombre1 = $request['nombre1'];
        $paciente->nombre2 = $request['nombre2'];
        $paciente->nombre3 = $request['nombre3'];
        $paciente->apellido1 = $request['apellido1'];
        $paciente->apellido2 = $request['apellido2'];
        $paciente->apellido3 = $request['apellido3'];
        $paciente->departamento_id = $request['departamento_id'];
        $paciente->municipio_id = $request['municipio_id'];
        $paciente->direccion = $request['direccion'];
        $paciente->fecha_nacimiento = $request['fecha_nacimiento'];
        $paciente->encargado = $request['encargado'];
        $paciente->fecha_ingreso = $request['fecha_ingreso'];
        $paciente->telefono = $request['telefono'];
        $paciente->medico_id = $request['medico_id'];
        $paciente->seguro_social = $request['seguro_social'];
        $paciente->observacion = $request['observacion'];
        $paciente->pago_id = $request['pago_id'];

        if($paciente->save()){
            $this->crearPacienteBitacora($request);
            return redirect()->intended('/paciente-management');
        }
    }

    public function show($id) {

    }

    public function view($id) {
        $user = User::find($id);
        if ($user == null || count($user) == 0) {
            return redirect()->intended('/user-management');
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
        return view('users-mgmt/view', ['user' => $user, 'rols' => $rols, 'departamentos' => $departamentos, 'municipios' => $municipios, 'estados' => $estados, 'userdiasemanas' => $userdiasemanas, 'usuarioterapias' => $usuarioterapias]);
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
            return redirect()->intended('/user-management');
        }
    }

    public function search(Request $request) {
        $constraints = [
            'nombre1' => $request['nombre1'],
            'cui' => $request['cui']
        ];

       $pacientes = $this->doSearchingQuery($constraints);
       return view('paciente-mgmt/index', ['pacientes' => $pacientes, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Paciente::query();
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
            'cui' => 'min:13|max:13|unique:pacientes|nullable',
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
            'encargado' => 'max:100',
            'fecha_ingreso' => 'required',
            'telefono' => 'digits:8|nullable',
            'medico_id' => 'required',
            'seguro_social' => 'max:10|unique:pacientes|nullable',
            'observacion' => 'max:500',
            'pago_id' => 'required',
        ]);
    }

    private function crearPacienteBitacora(Request $request){
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $log = $request->User()->username;

        $departamento = Departamento::findOrFail($request['departamento_id']);
        $municipio = Municipio::findOrFail($request['municipio_id']);
        $medico = Medico::findOrFail($request['medico_id']);
        $pago = Pago::findOrFail($request['pago_id']);

        $data = 'CUI: ' . $request->cui . ', Nombre Completo: ' . $request->nombre1 .' '. $request->nombre2 .' '. $request->nombre3 . $request->apellido1 .' '. $request->apellido2 .' '. $request->apellido3 . ', Datos del Paciente: ' . $request->fecha_nacimiento . ', Direccion: ' . $departamento->nombre .' '. $municipio->nombre .' '. $request->direccion . ', Encargado: ' . $request->encargado .' '. $request->telefono . ', Fecha de Ingreso: ' . $request->fecha_ingreso . ', Datos Médicos: ' . $medico->nombre .' '. $request->seguro_social .', Tipo de Pago: ' . $pago->nombre;

            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'PACIENTE';
            $bitacora->actividad = 'CREAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            $bitacora->save();
    }
}
