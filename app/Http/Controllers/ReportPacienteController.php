<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Paciente;
use Excel;
use Auth;
use PDF;

class ReportPacienteController extends Controller {

	    public function __construct() {
	        $this->middleware('auth');
	    }

	    public function index() {
	        date_default_timezone_set('america/guatemala');
	        $format = 'd/m/Y';
	        $now = date($format);
	        $to = date($format, strtotime("+366 days"));
	        $constraints = [
	            'from' => $now,
	            'to' => $to
	        ];

	        $pacientes = $this->getRangoPaciente($constraints);
	        $message = '';
	        return view('system-mgmt/report-paciente/index', ['pacientes' => $pacientes, 'searchingVals' => $constraints, 'message' => $message]);
	    }

	    public function search(Request $request) {

	        if($request->from != '' && $request->to != ''){
	          $constraints = [
	              'from' => $request['from'],
	              'to' => $request['to']
	          ];

	          $pacientes = $this->getRangoPaciente($constraints);
	          $message = '';
	          return view('system-mgmt/report-paciente/index', ['pacientes' => $pacientes, 'searchingVals' => $constraints, 'message' => $message]);
	        }

	        if($request->from == '' || $request->to == ''){
	          $constraints = [
	              'from' => $request['from'],
	              'to' => $request['to']
	          ];
	          $pacientes = $this->getRangoPaciente($constraints);
	          $message = 'Rango de Fecha inválido';
	          return view('system-mgmt/report-actividad/index', ['pacientes' => $pacientes, 'searchingVals' => $constraints, 'message' => $message]);
	        }
	    }

	    private function getRangoPaciente($constraints) {

	        if($constraints['from'] == '' || $constraints['to'] == ''){
	          $pacientes = Paciente::where('fecha_nacimiento', '>=', '01/01/1850')
	                          ->where('fecha_nacimiento', '<=', '01/01/1850')
	                          ->get();
	          return $pacientes;
	        }

	        if($constraints['from'] != '' && $constraints['to'] != ''){
	        	$pacientes = Paciente::where('fecha_nacimiento', '>=', $constraints['from'])
	                        ->where('fecha_nacimiento', '<=', $constraints['to'])
	                        ->get();
	        return $pacientes;
	        }
	    }

	    public function exportExcel(Request $request) {
	        $this->prepareExportingData($request)->export('xlsx');
	        redirect()->intended('system-management/report-paciente');
	    }

	    public function exportPDF(Request $request) {
	         $constraints = [
	            'from' => $request['from'],
	            'to' => $request['to']
	        ];
	        $pacientes = $this->getExportingData($constraints);
	        $pdf = PDF::loadView('system-mgmt/report-paciente/pdf', ['pacientes' => $pacientes, 'searchingVals' => $constraints]);
	        return $pdf->download('reporte_del_'. $request['from'].'_al_'.$request['to'].'.pdf');
	        return view('system-mgmt/report-paciente/pdf', ['pacientes' => $pacientes, 'searchingVals' => $constraints]);
	    }

	    private function prepareExportingData($request) {
	        $author = Auth::user()->username;
	        $pacientes = $this->getExportingData(['from'=> $request['from'], 'to' => $request['to']]);
	        return Excel::create('reporte_del_'. $request['from'].'_al_'.$request['to'], function($excel) use($pacientes, $request, $author) {


	        $excel->setTitle('Reporte de Pacientes del '. $request['from'].' al '. $request['to']);
	        $excel->setCreator($author)
	            ->setCompany('HoaDang');
	        $excel->setDescription('Listado de Actividades');
	        $excel->sheet('Reporte', function($sheet) use($pacientes) {
	        $sheet->fromArray($pacientes);
	            });
	        });
	    }

	    private function getExportingData($constraints) {
	        return DB::table('actividades')
	        ->leftJoin('users', 'actividades.user_id', '=', 'users.id')
	        ->leftJoin('departamentos', 'actividades.departamento_id', '=', 'departamentos.id')
	        ->leftJoin('municipios', 'actividades.municipio_id', '=', 'municipios.id')
	        ->select('actividades.nombre as Nombre_Actividad', 'users.nombre1 as Primer_Nombre', 'users.nombre2 as Segundo_Nombre','users.nombre3 as Tercer_Nombre', 'users.apellido1 as Primer_Apellido', 'users.apellido2 as Segundo_Apellido', 'users.apellido3 as Tercer_Apellido', 'users.telefono as Teléfono', 'departamentos.nombre as Departamento', 'municipios.nombre as Municipio', 'actividades.direccion as Dirección', 'actividades.fecha as Fecha', 'actividades.descripcion as Descripción')
	        ->where('fecha', '>=', $constraints['from'])
	        ->where('fecha', '<=', $constraints['to'])
	        ->get()
	        ->map(function ($item, $key) {
	        return (array) $item;
	        })
	        ->all();
	    }
}
