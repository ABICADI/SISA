<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Paciente;
use App\Departamento;
use App\Municipio;
use App\Pago;
use Excel;
use Auth;
use PDF;

class ReportPacienteController extends Controller {

	    public function __construct() {
	        $this->middleware('auth');
	    }

	    public function index() {
	        date_default_timezone_set('america/guatemala');
	        $format = 'Y-m-d';
	        $now = date($format);
	        $to = date($format, strtotime("-366 days"));
	        $constraints = [
		            'from' => $to,
		            'to' => $now,
								'departamento' => '',
								'municipio' => '',
								'pago' => ''
	        ];
					$departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
	        $municipios = Municipio::select('id', 'nombre','departamento_id')->orderBy('nombre', 'asc')->get();
	        $pagos = Pago::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
	        $pacientes = $this->getRangoPaciente($constraints);
					if($pacientes->count()==0){
						$si=1;
					}else {
						$si=0;
					}
	        $message = '';
	        return view('system-mgmt/report-paciente/index', ['pacientes' => $pacientes, 'departamentos' => $departamentos, 'municipios' => $municipios, 'pagos' => $pagos, 'searchingVals' => $constraints, 'message' => $message, 'si' => $si]);
	    }

	    public function search(Request $request) {
					$departamentos = Departamento::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
					$municipios = Municipio::select('id', 'nombre','departamento_id')->orderBy('nombre', 'asc')->get();
					$pagos = Pago::select('id', 'nombre')->orderBy('nombre', 'asc')->get();

					if($request->from != '' && $request->to != ''){
						$constraints = [
									'from' => $request['from'],
									'to' =>$request['to'],
									'departamento' => $request['departamento_id'],
									'municipio' => $request['municipio_id'],
									'pago' => $request['pago_id'],
						];
						$pacientes = $this->getRangoPaciente($constraints);
						if($pacientes->count()==0){
							$si=1;
						}else {
							$si=0;
						}
		        $message = '';
		        return view('system-mgmt/report-paciente/index', ['pacientes' => $pacientes, 'departamentos' => $departamentos, 'municipios' => $municipios, 'pagos' => $pagos, 'searchingVals' => $constraints, 'message' => $message, 'si' => $si]);
	        }

	        if($request->from == '' || $request->to == ''){
						$constraints = [
									'from' => $request['from'],
									'to' =>$request['to'],
									'departamento' => $request['departamento_id'],
									'municipio' => $request['municipio_id'],
									'pago' => $request['pago_id'],
						];
	          $pacientes = $this->getRangoPaciente($constraints);
						if($pacientes->count()==0){
							$si=1;
						}else {
							$si=0;
						}
	          $message = 'Rango de Fecha inválido';
		        return view('system-mgmt/report-paciente/index', ['pacientes' => $pacientes, 'departamentos' => $departamentos, 'municipios' => $municipios, 'pagos' => $pagos, 'searchingVals' => $constraints, 'message' => $message, 'si' => $si]);
	        }
	    }

	    private function getRangoPaciente($constraints) {
					if($constraints['from'] == '' || $constraints['to'] == ''){
						if($constraints['pago']!=0 && $constraints['departamento']!=0 && $constraints['municipio']!=0){
							$pacientes = Paciente::join('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
																		->join('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
																		->join('pagos', 'pacientes.pago_id', '=', 'pagos.id')
																		->select('pacientes.*', 'municipios.nombre as Municipio', 'departamentos.nombre as Departamento', 'pagos.nombre as Pago')
																		->where('pacientes.municipio_id', '=', $constraints['municipio'])
																		->where('pacientes.pago_id', '=', $constraints['pago'])->get();
							return $pacientes;
						}
						if($constraints['pago']!=0 && $constraints['departamento']==0 && $constraints['municipio']==0){
							$pacientes = Paciente::join('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
																		->join('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
																		->join('pagos', 'pacientes.pago_id', '=', 'pagos.id')
																		->select('pacientes.*', 'municipios.nombre as Municipio', 'departamentos.nombre as Departamento', 'pagos.nombre as Pago')
																		->where('pacientes.pago_id', '=', $constraints['pago'])->get();
							return $pacientes;
						}
						if($constraints['pago']==0 && $constraints['departamento']!=0 && $constraints['municipio']!=0){
							$pacientes = Paciente::join('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
																		->join('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
																		->join('pagos', 'pacientes.pago_id', '=', 'pagos.id')
																		->select('pacientes.*', 'municipios.nombre as Municipio', 'departamentos.nombre as Departamento', 'pagos.nombre as Pago')
																		->where('pacientes.municipio_id', '=', $constraints['municipio'])->get();
							return $pacientes;
						}
						if($constraints['pago']==0 && $constraints['departamento']==0 && $constraints['municipio']==0){
							$pacientes = Paciente::join('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
																		->join('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
																		->join('pagos', 'pacientes.pago_id', '=', 'pagos.id')
																		->select('pacientes.*', 'municipios.nombre as Municipio', 'departamentos.nombre as Departamento', 'pagos.nombre as Pago')
																		->where('fecha_ingreso', '>=', '01/01/1800')
																		->where('fecha_ingreso', '<=', '01/01/1800')->get();
							return $pacientes;
						}
					}

	        if($constraints['from'] != '' && $constraints['to'] != ''){
						if($constraints['pago']!=0 && $constraints['departamento']!=0 && $constraints['municipio']!=0){
							$pacientes = Paciente::join('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
																		->join('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
																		->join('pagos', 'pacientes.pago_id', '=', 'pagos.id')
																		->select('pacientes.*', 'municipios.nombre as Municipio', 'departamentos.nombre as Departamento', 'pagos.nombre as Pago')
																		->where('pacientes.municipio_id', '=', $constraints['municipio'])
																		->where('pacientes.pago_id', '=', $constraints['pago'])->get();
							return $pacientes;
						}
						if($constraints['pago']!=0 && $constraints['departamento']==0 && $constraints['municipio']==0){
							$pacientes = Paciente::join('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
																		->join('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
																		->join('pagos', 'pacientes.pago_id', '=', 'pagos.id')
																		->select('pacientes.*', 'municipios.nombre as Municipio', 'departamentos.nombre as Departamento', 'pagos.nombre as Pago')
																		->where('pacientes.pago_id', '=', $constraints['pago'])->get();
							return $pacientes;
						}
						if($constraints['pago']==0 && $constraints['departamento']!=0 && $constraints['municipio']!=0){
							$pacientes = Paciente::join('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
																		->join('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
																		->join('pagos', 'pacientes.pago_id', '=', 'pagos.id')
																		->select('pacientes.*', 'municipios.nombre as Municipio', 'departamentos.nombre as Departamento', 'pagos.nombre as Pago')
																		->where('pacientes.municipio_id', '=', $constraints['municipio'])->get();
							return $pacientes;
						}
						if($constraints['municipio']==0 && $constraints['departamento']==0 && $constraints['pago']==0){
							$pacientes = Paciente::join('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
																		->join('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
																		->join('pagos', 'pacientes.pago_id', '=', 'pagos.id')
																		->select('pacientes.*', 'municipios.nombre as Municipio', 'departamentos.nombre as Departamento', 'pagos.nombre as Pago')
																		->where('fecha_ingreso', '>=', $constraints['from'])
																		->where('fecha_ingreso', '<=', $constraints['to'])
																		->get();
							return $pacientes;
						}
					}
	    }

	    public function exportExcel(Request $request) {
	        $this->prepareExportingData($request)->export('xlsx');
	        redirect()->intended('system-management/report-paciente');
	    }

	    public function exportPDF(Request $request) {
					$pago = Pago::find($request['pago']);
					$departamento = Departamento::find($request['departamento']);
					$municipio = Municipio::find($request['municipio']);
					date_default_timezone_set('america/guatemala');
					$format = 'Y-m-d H:i:s';
					$now = date($format);
					$constraints = [
								'from' => $request['from'],
								'to' =>$request['to'],
								'departamento' => $request['departamento'],
								'municipio' => $request['municipio'],
								'pago' => $request['pago']
					];
	        $pacientes = $this->getExportingData($constraints);
					if($request['from'] == '' || $request['to'] == ''){
						if($request['pago']!=0 && $request['departamento']!=0 && $request['municipio']!=0){
								$title = 'Reporte del Paciente por Departamento: '.$departamento->nombre.', Municipio: '.$municipio->nombre.', y Pago: '.$pago->nombre;
						}
						if($request['pago']!=0 && $request['departamento']==0 && $request['municipio']==0){
								$title = 'Reporte del Paciente por Pago: '.$pago->nombre;
						}
						if($request['pago']==0 && $request['departamento']!=0 && $request['municipio']!=0){
								$title = 'Reporte del Paciente por Departamento: '.$departamento->nombre.', y Municipio: '.$municipio->nombre;
						}
						if($request['pago']==0 && $request['departamento']==0 && $request['municipio']==0){
								$title = 'Reporte del Paciente';
						}
					}
					if($request['from'] != '' && $request['to'] != ''){
						if($request['pago']!=0 && $request['departamento']!=0 && $request['municipio']!=0){
								$title = 'Reporte del Paciente por Rango: de '.$request['from'].' hasta '.$request['to'].', Departamento: '.$departamento->nombre.', Municipio: '.$municipio->nombre.', y Pago: '.$pago->nombre;
						}
						if($request['pago']!=0 && $request['departamento']==0 && $request['municipio']==0){
								$title = 'Reporte del Paciente por Rango: de '.$request['from'].' hasta '.$request['to'].', y Pago: '.$pago->nombre;
						}
						if($request['pago']==0 && $request['departamento']!=0 && $request['municipio']!=0){
								$title = 'Reporte del Paciente por Rango: de '.$request['from'].' hasta '.$request['to'].', Departamento: '.$departamento->nombre.', y Municipio: '.$municipio->nombre;
						}
						if($request['pago']==0 && $request['departamento']==0 && $request['municipio']==0){
								$title = 'Reporte del Paciente por Rango: de '.$request['from'].' hasta '.$request['to'];
						}
					}
	        $pdf = PDF::loadView('system-mgmt/report-paciente/pdf', ['pacientes' => $pacientes, 'searchingVals' => $constraints, 'title' => $title]);
	        return $pdf->download('reporte_paciente_fecha_'. $now .'.pdf');
	        return view('system-mgmt/report-paciente/pdf', ['pacientes' => $pacientes, 'searchingVals' => $constraints, 'title' => $title]);
	    }

	    private function prepareExportingData($request) {
					date_default_timezone_set('america/guatemala');
					$format = 'Y-m-d H:i:s';
					$now = date($format);
	        $author = Auth::user()->username;
	        $pacientes = $this->getExportingData(['from'=> $request['from'],
																								'to' => $request['to'],
																								'departamento' => $request['departamento'],
																								'municipio' => $request['municipio'],
																								'pago' => $request['pago']]);
	        return Excel::create('reporte_paciente_de_fecha_'. $now, function($excel) use($pacientes, $request, $author) {
						$pago = Pago::find($request['pago']);
						$departamento = Departamento::find($request['departamento']);
						$municipio = Municipio::find($request['municipio']);
						date_default_timezone_set('america/guatemala');
						$format = 'd-m-Y';
						$now = date($format);
						if($constraints['from'] == '' || $constraints['to'] == ''){
							if($constraints['pago']!=0 && $constraints['departamento']!=0 && $constraints['municipio']!=0){
									$title = 'Reporte del Paciente por Departamento: '.$departamento->nombre.', Municipio: '.$municipio->nombre.', y Pago: '.$pago->nombre;
							}
							if($constraints['pago']!=0 && $constraints['departamento']==0 && $constraints['municipio']==0){
									$title = 'Reporte del Paciente por Pago: '.$pago->nombre;
							}
							if($constraints['pago']==0 && $constraints['departamento']!=0 && $constraints['municipio']!=0){
									$title = 'Reporte del Paciente por Departamento: '.$departamento->nombre.', y Municipio: '.$municipio->nombre;
							}else{
									$title = 'Reporte del Paciente';
							}
						}
						if($constraints['from'] != '' && $constraints['to'] != ''){
							if($constraints['pago']!=0 && $constraints['departamento']!=0 && $constraints['municipio']!=0){
									$title = 'Reporte del Paciente por Rango: de '.$request['from'].' hasta '.$request['to'].', Departamento: '.$departamento->nombre.', Municipio: '.$municipio->nombre.', y Pago: '.$pago->nombre;
							}
							if($constraints['pago']!=0 && $constraints['departamento']==0 && $constraints['municipio']==0){
									$title = 'Reporte del Paciente por Rango: de '.$request['from'].' hasta '.$request['to'].', y Pago: '.$pago->nombre;
							}
							if($constraints['pago']==0 && $constraints['departamento']!=0 && $constraints['municipio']!=0){
									$title = 'Reporte del Paciente por Rango: de '.$request['from'].' hasta '.$request['to'].', Departamento: '.$departamento->nombre.', y Municipio: '.$municipio->nombre;
							}else{
									$title = 'Reporte del Paciente por Rango: de '.$request['from'].' hasta '.$request['to'];
							}
						}
		        $excel->setTitle($title);
		        $excel->setCreator($author)->setCompany('HoaDang');
		        $excel->setDescription('Listado de Pacientes');
		        $excel->sheet('Reporte_'.$now, function($sheet) use($pacientes) {
		        	$sheet->fromArray($pacientes);
	          });
	        });
	    }

	    private function getExportingData($constraints) {
				if($constraints['from'] == '' || $constraints['to'] == ''){
					if($constraints['pago']!=0 && $constraints['departamento']!=0 && $constraints['municipio']!=0){
						return DB::table('pacientes')
						->leftJoin('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
						->leftJoin('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
						->leftJoin('pagos', 'pacientes.pago_id', '=', 'pagos.id')
						->leftJoin('generos', 'pacientes.genero_id', '=', 'generos.id')
						->select('pacientes.seguro_social as No_Registro',
											'pacientes.cui as CUI',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'generos.nombre as Género',
											'municipios.nombre as Municipio',
											'departamentos.nombre as Departamento',
											'pacientes.direccion as Dirección',
											'pacientes.fecha_nacimiento as Fecha_Nacimiento',
											'pacientes.encargado as Nombre_Encargado',
											'pacientes.fecha_ingreso as Fecha_Ingreso',
											'pacientes.telefono as Teléfono',
											'pagos.nombre as Tipo_Pago')
						->where('pacientes.municipio_id', '=', $constraints['municipio'])
						->where('pacientes.pago_id', '=', $constraints['pago'])
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
					if($constraints['pago']!=0 && $constraints['departamento']==0 && $constraints['municipio']==0){
						return DB::table('pacientes')
						->leftJoin('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
						->leftJoin('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
						->leftJoin('pagos', 'pacientes.pago_id', '=', 'pagos.id')
						->leftJoin('generos', 'pacientes.genero_id', '=', 'generos.id')
						->select('pacientes.seguro_social as No_Registro',
											'pacientes.cui as CUI',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'generos.nombre as Género',
											'municipios.nombre as Municipio',
											'departamentos.nombre as Departamento',
											'pacientes.direccion as Dirección',
											'pacientes.fecha_nacimiento as Fecha_Nacimiento',
											'pacientes.encargado as Nombre_Encargado',
											'pacientes.fecha_ingreso as Fecha_Ingreso',
											'pacientes.telefono as Teléfono',
											'pagos.nombre as Tipo_Pago')
						->where('pacientes.pago_id', '=', $constraints['pago'])
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
					if($constraints['pago']==0 && $constraints['departamento']!=0 && $constraints['municipio']!=0){
						return DB::table('pacientes')
						->leftJoin('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
						->leftJoin('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
						->leftJoin('pagos', 'pacientes.pago_id', '=', 'pagos.id')
						->leftJoin('generos', 'pacientes.genero_id', '=', 'generos.id')
						->select('pacientes.seguro_social as No_Registro',
											'pacientes.cui as CUI',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'generos.nombre as Género',
											'municipios.nombre as Municipio',
											'departamentos.nombre as Departamento',
											'pacientes.direccion as Dirección',
											'pacientes.fecha_nacimiento as Fecha_Nacimiento',
											'pacientes.encargado as Nombre_Encargado',
											'pacientes.fecha_ingreso as Fecha_Ingreso',
											'pacientes.telefono as Teléfono',
											'pagos.nombre as Tipo_Pago')
						->where('pacientes.municipio_id', '=', $constraints['municipio'])
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
					if($constraints['pago']==0 && $constraints['departamento']==0 && $constraints['municipio']==0){
						return DB::table('pacientes')
						->leftJoin('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
						->leftJoin('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
						->leftJoin('pagos', 'pacientes.pago_id', '=', 'pagos.id')
						->leftJoin('generos', 'pacientes.genero_id', '=', 'generos.id')
						->select('pacientes.seguro_social as No_Registro',
											'pacientes.cui as CUI',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'generos.nombre as Género',
											'municipios.nombre as Municipio',
											'departamentos.nombre as Departamento',
											'pacientes.direccion as Dirección',
											'pacientes.fecha_nacimiento as Fecha_Nacimiento',
											'pacientes.encargado as Nombre_Encargado',
											'pacientes.fecha_ingreso as Fecha_Ingreso',
											'pacientes.telefono as Teléfono',
											'pagos.nombre as Tipo_Pago')
						->where('fecha_ingreso', '>=', '01/01/1800')
						->where('fecha_ingreso', '<=', '01/01/1800')
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
				}
				if($constraints['from'] != '' && $constraints['to'] != ''){
					if($constraints['pago']!=0 && $constraints['departamento']!=0 && $constraints['municipio']!=0){
						return DB::table('pacientes')
						->leftJoin('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
						->leftJoin('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
						->leftJoin('pagos', 'pacientes.pago_id', '=', 'pagos.id')
						->leftJoin('generos', 'pacientes.genero_id', '=', 'generos.id')
						->select('pacientes.seguro_social as No_Registro',
											'pacientes.cui as CUI',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'generos.nombre as Género',
											'municipios.nombre as Municipio',
											'departamentos.nombre as Departamento',
											'pacientes.direccion as Dirección',
											'pacientes.fecha_nacimiento as Fecha_Nacimiento',
											'pacientes.encargado as Nombre_Encargado',
											'pacientes.fecha_ingreso as Fecha_Ingreso',
											'pacientes.telefono as Teléfono',
											'pagos.nombre as Tipo_Pago')
						->where('pacientes.municipio_id', '=', $constraints['municipio'])
						->where('pacientes.pago_id', '=', $constraints['pago'])
						->where('fecha_ingreso', '>=', $constraints['from'])
						->where('fecha_ingreso', '<=', $constraints['to'])
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
					if($constraints['pago']!=0 && $constraints['departamento']==0 && $constraints['municipio']==0){
						return DB::table('pacientes')
						->leftJoin('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
						->leftJoin('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
						->leftJoin('pagos', 'pacientes.pago_id', '=', 'pagos.id')
						->leftJoin('generos', 'pacientes.genero_id', '=', 'generos.id')
						->select('pacientes.seguro_social as No_Registro',
											'pacientes.cui as CUI',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'generos.nombre as Género',
											'municipios.nombre as Municipio',
											'departamentos.nombre as Departamento',
											'pacientes.direccion as Dirección',
											'pacientes.fecha_nacimiento as Fecha_Nacimiento',
											'pacientes.encargado as Nombre_Encargado',
											'pacientes.fecha_ingreso as Fecha_Ingreso',
											'pacientes.telefono as Teléfono',
											'pagos.nombre as Tipo_Pago')
						->where('pacientes.pago_id', '=', $constraints['pago'])
						->where('fecha_ingreso', '>=', $constraints['from'])
						->where('fecha_ingreso', '<=', $constraints['to'])
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
					if($constraints['pago']==0 && $constraints['departamento']!=0 && $constraints['municipio']!=0){
						return DB::table('pacientes')
						->leftJoin('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
						->leftJoin('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
						->leftJoin('pagos', 'pacientes.pago_id', '=', 'pagos.id')
						->leftJoin('generos', 'pacientes.genero_id', '=', 'generos.id')
						->select('pacientes.seguro_social as No_Registro',
											'pacientes.cui as CUI',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'generos.nombre as Género',
											'municipios.nombre as Municipio',
											'departamentos.nombre as Departamento',
											'pacientes.direccion as Dirección',
											'pacientes.fecha_nacimiento as Fecha_Nacimiento',
											'pacientes.encargado as Nombre_Encargado',
											'pacientes.fecha_ingreso as Fecha_Ingreso',
											'pacientes.telefono as Teléfono',
											'pagos.nombre as Tipo_Pago')
						->where('pacientes.municipio_id', '=', $constraints['municipio'])
						->where('fecha_ingreso', '>=', $constraints['from'])
						->where('fecha_ingreso', '<=', $constraints['to'])
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
					if($constraints['pago']==0 && $constraints['departamento']==0 && $constraints['municipio']==0){
						return DB::table('pacientes')
						->leftJoin('municipios', 'pacientes.municipio_id', '=', 'municipios.id')
						->leftJoin('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
						->leftJoin('pagos', 'pacientes.pago_id', '=', 'pagos.id')
						->leftJoin('generos', 'pacientes.genero_id', '=', 'generos.id')
						->select('pacientes.seguro_social as No_Registro',
											'pacientes.cui as CUI',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'generos.nombre as Género',
											'municipios.nombre as Municipio',
											'departamentos.nombre as Departamento',
											'pacientes.direccion as Dirección',
											'pacientes.fecha_nacimiento as Fecha_Nacimiento',
											'pacientes.encargado as Nombre_Encargado',
											'pacientes.fecha_ingreso as Fecha_Ingreso',
											'pacientes.telefono as Teléfono',
											'pagos.nombre as Tipo_Pago')
						->where('fecha_ingreso', '>=', $constraints['from'])
						->where('fecha_ingreso', '<=', $constraints['to'])
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
				}
	    }
}
