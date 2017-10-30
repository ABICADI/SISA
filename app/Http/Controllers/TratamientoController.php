<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\Tratamiento;
use App\Bitacora;
use App\Paciente;
use App\Medico;
use App\Terapia;
use Auth;

class TratamientoController extends Controller {

    protected $redirectTo = '/tratamiento-management'; //redirecciona la ruta

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $tratamientos = DB::table('tratamientos')
        ->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
        ->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
        ->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
        ->select('tratamientos.*',  'pacientes.nombre1 as primer_nombre',
                        'pacientes.nombre2 as segundo_nombre',
                        'pacientes.nombre3 as tercer_nombre',
                        'pacientes.apellido1 as primer_apellido',
                        'pacientes.apellido2 as segundo_apellido',
                        'pacientes.apellido3 as tercer_apellido',
                        'medicos.nombre as nombre_medico',
                        'terapias.nombre as nombre_terapia',
                        'terapias.color as color')
        ->orderBy('fecha', 'desc')->paginate(10);
        $message = '';
        return view('tratamiento-mgmt/index', ['tratamientos' => $tratamientos, 'message' => $message]);
    }

    public function create() {
        $pacientes = Paciente::select('pacientes.*')->orderBy('nombre1','asc')->get();
        $medicos = Medico::select('medicos.*')->orderBy('nombre','asc')->get();
        $terapias = Terapia::select('terapias.*')->orderBy('nombre','asc')->get();

        return view('tratamiento-mgmt/create', ['pacientes' => $pacientes, 'medicos' => $medicos, 'terapias' => $terapias]);
    }

    public function store(Request $request) {
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $this->validateInsertTratamiento($request);
        $tratamiento = new Tratamiento();
        $tratamiento->fecha = $now;
        $tratamiento->descripcion = $request['descripcion'];
        $tratamiento->paciente_id = $request['paciente_id'];
        $tratamiento->medico_id = $request['medico_id'];
        $tratamiento->terapia_id = $request['terapia_id'];
        $tratamiento->asignados = $request['asignados'];
        $tratamiento->restantes = $request['asignados'];

        if($tratamiento->save()){
          $this->insertBitacoraTratamiento($request);
          Flash('¡El Tratamiento se ha agregado Exitosamente!')->success();
          return redirect()->intended('/calendario');
        }
    }

    public function show($id) {

    }

    public function edit($id) {

      $tratamiento = Tratamiento::findOrFail($id);

      if($tratamiento == null && count($tratamiento)== 0){
        return redirect()->intended('/tratamiento-management');
      }

      $pacientes = Paciente::select('pacientes.*')->orderBy('nombre1','asc')->get();
      $medicos = Medico::select('medicos.*')->orderBy('nombre','asc')->get();
      $terapias = Terapia::select('terapias.*')->orderBy('nombre','asc')->get();

      return view('tratamiento-mgmt/edit',['tratamiento' => $tratamiento, 'pacientes' => $pacientes, 'medicos' => $medicos, 'terapias' => $terapias]);
    }

    public function update(Request $request, $id) {
      $tratamiento = Tratamiento::find($id);
      if($request['asignados']!=0){
        $new_asignado = $request['asignados'] + $tratamiento->asignados;
        $new_restante = $request['asignados'] + $tratamiento->restantes;
        $tratamiento->asignados = $new_asignado;
        $tratamiento->restantes = $new_restante;
      }
      $this->validateUpdateTratamiento($request);
      $tratamiento->descripcion = $request['descripcion'];
      $tratamiento->paciente_id = $request['paciente_id'];
      $tratamiento->medico_id = $request['medico_id'];
      $tratamiento->terapia_id = $request['terapia_id'];
      $this->updateBitacoraTratamiento($id, $request);

      if($tratamiento->save()){
        Flash('¡El Tratamiento se ha actualizado Exitosamente!')->success();
        return redirect()->intended('/tratamiento-management');
      }
    }

    public function search(Request $request) {
        $constraints = [
            'fecha' => $request['fecha']
        ];

       $tratamientos = $this->doSearchingQuery($constraints);
       return view('tratamiento-mgmt/index', ['tratamientos' => $tratamientos, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Tratamiento::query();
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

    private function validateInsertTratamiento($request){
      $this->validate($request, [
          'descripcion' => 'max:500',
          'paciente_id' => 'required',
          'medico_id' => 'required',
          'terapia_id' => 'required'
      ]);
    }

    private function validateUpdateTratamiento($request){
      $this->validate($request, [
          'descripcion' => 'max:500',
          'paciente_id' => 'required',
          'medico_id' => 'required',
          'terapia_id' => 'required'
      ]);
    }

    private function insertBitacoraTratamiento($request){

    }

    private function updateBitacoraTratamiento($id, $request){

    }

    private function deleteBitacoraTratamiento($id){

    }
}
