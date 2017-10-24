<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Paciente;
use App\Municipio;
use App\Departamento;
use App\Pago;
use Excel;
use Auth;
use PDF;

class ReportPacienteController extends Controller {

	    public function __construct() {
	        $this->middleware('auth');
	    }

	    public function index() {
	        $constraints = [
	            'from' => '',
	            'to' => '',
							'departamento' => 0,
							'municipio' => 0,
							'pago' => 0,
	        ];
					$pagos = Pago::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
					$departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
	        $municipios = Municipio::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
					$pacientes = $this->getRangoPaciente($constraints);
	        $message = '';
	        return view('system-mgmt/report-paciente/index', ['pacientes' => $pacientes, 'pagos' => $pagos, 'departamentos' => $departamentos, 'municipios' => $municipios, 'searchingVals' => $constraints, 'message' => $message]);
	    }

	    public function search(Request $request) {
				$pagos = Pago::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
				$departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
				$municipios = Municipio::select('id', 'nombre')->orderBy('nombre', 'asc')->get();

					if($request->from != '' && $request->to != ''){
	          $constraints = [
	              'from' => $request['from'],
	              'to' => $request['to'],
								'departamento' => $request['departamento_id'],
								'municipio' => $request['municipio_id'],
								'pago' => $request['pago_id']
	          ];
						$pacientes = $this->getRangoPaciente($constraints);
	          $message = '';
	          return view('system-mgmt/report-paciente/index', ['pacientes' => $pacientes, 'pagos' => $pagos, 'departamentos' => $departamentos, 'municipios' => $municipios, 'searchingVals' => $constraints, 'message' => $message]);
	       }

	       if($request->from == '' || $request->to == ''){
	          $constraints = [
							'from' => $request['from'],
							'to' => $request['to'],
							'departamento' => $request['departamento_id'],
							'municipio' => $request['municipio_id'],
							'pago' => $request['pago_id']
	          ];
	          $pacientes = $this->getRangoPaciente($constraints);
	          $message = 'Rango de Fecha inválido (Con este rango no podrá encontrar las Fechas de Nacimiento)';
	          return view('system-mgmt/report-paciente/index', ['pacientes' => $pacientes, 'pagos' => $pagos, 'departamentos' => $departamentos, 'municipios' => $municipios, 'searchingVals' => $constraints, 'message' => $message]);
	        }
	    }

	    private function getRangoPaciente($constraints) {
				//Busqueda de Fuera de Rango
					if($constraints['from'] == '' || $constraints['to'] == ''){
							$pacientes = Paciente::where('departamento_id', '=', $constraints['departamento'])->get();
							return $pacientes;
	        }
	    }

	    public function exportExcel(Request $request) {
	        $this->prepareExportingData($request)->export('xlsx');
	        redirect()->intended('system-management/report-paciente');
	    }

	    public function exportPDF(Request $request) {
					date_default_timezone_set('america/guatemala');
					$format = 'd/m/Y';
					$now = date($format);
	        $constraints = [
						'from' => $request['from'],
						'to' => $request['to'],
						'departamento' => $request['departamento_id'],
						'municipio' => $request['municipio_id'],
						'pago' => $request['pago_id']
	        ];
	        $pacientes = $this->getExportingData($constraints);
	        $pdf = PDF::loadView('system-mgmt/report-paciente/pdf', ['pacientes' => $pacientes, 'searchingVals' => $constraints]);
	        return $pdf->download('reporte_del_'. $now .'.pdf');
	        return view('system-mgmt/report-paciente/pdf', ['pacientes' => $pacientes, 'searchingVals' => $constraints]);
	    }

	    private function prepareExportingData($request) {
					date_default_timezone_set('america/guatemala');
					$format = 'd/m/Y';
					$now = date($format);
	       	$author = Auth::user()->username;
	        $pacientes = $this->getExportingData(['from' => $request['from'], 'to' => $request['to'], 'departamento' => $request['departamento'], 'municipio' => $request['municipio'], 'pago' => $request['pago']]);
	        return Excel::create('reporte_del_'. $now, function($excel) use($pacientes, $request, $author) {

	        $excel->setTitle('Reporte de Pacientes');
	        $excel->setCreator($author)->setCompany('HoaDang');
	        $excel->setDescription('Listado de Pacientes');
	        $excel->sheet('Reporte', function($sheet) use($pacientes) {
	        $sheet->fromArray($pacientes);
	            });
	        });
	    }

	    private function getExportingData($constraints) {
	       	return DB::table('pacientes')
	        ->leftJoin('pagos', 'pacientes.pago_id', '=', 'pagos.id')
	        ->leftJoin('departamentos', 'pacientes.departamento_id', '=', 'departamentos.id')
	        ->leftJoin('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
	        ->select('pacientes.nombre1 as Primer_Nombre', 'pacientes.nombre2 as Segundo_Nombre', 'pacientes.nombre3 as Tercer_Nombre', 'pacientes.apellido1 as Primer_Apellido', 'pacientes.apellido2 as Segundo_Apellido', 'pacientes.apellido3 as Tercer_Apellido', 'departamentos.nombre as Departamento', 'municipios.nombre as Municipio', 'pacientes.direccion as Direccion', 'pacientes.fecha_nacimiento as Fecha_Nacimiento', 'pacientes.encargado as Encargado', 'pacientes.fecha_ingreso as Fecha_Ingreso', 'pacientes.telefono as Telefono', 'pacientes.seguro_social as No_Social', 'pagos.nombre as Tipo_Pago')
	        ->Orwhere('municipio_id', '=', $constraints['municipio'])
	        ->Orwhere('pacientes.departamento_id', '=', $constraints['departamento'])
	        ->get()
					->map(function ($item, $key) {
	        return (array) $item;
	        })
	        ->all();
	    }
}
