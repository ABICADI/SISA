<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tratamiento;
use App\Paciente;
use App\Medico;
use App\Terapia;
use Excel;
use Auth;
use PDF;

class ReportTratamientoController extends Controller {

		    public function __construct() {
		        $this->middleware('auth');
		    }

		    public function index() {
		        date_default_timezone_set('america/guatemala');
		        $constraints = [
									'medico' => 0,
									'terapia' => 0
		        ];
						$medicos = Medico::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
		        $terapias = Terapia::select('id', 'nombre')->where('id', '!=', 1)->orderBy('nombre', 'asc')->get();
						$tratamientos = $this->getRangoTratamiento($constraints);
		        return view('system-mgmt/report-tratamiento/index', ['tratamientos' => $tratamientos, 'medicos' => $medicos, 'terapias' => $terapias, 'searchingVals' => $constraints]);
		    }

		    public function search(Request $request) {
							$medicos = Medico::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
							$terapias = Terapia::select('id', 'nombre')->where('id', '!=', 1)->orderBy('nombre', 'asc')->get();
							$constraints = [
										'medico' => $request['medico_id'],
										'terapia' => $request['terapia_id']
			        ];
		        	$tratamientos = $this->getRangoTratamiento($constraints);
		        	return view('system-mgmt/report-tratamiento/index', ['tratamientos' => $tratamientos, 'medicos' => $medicos, 'terapias' => $terapias, 'searchingVals' => $constraints]);
		    }

		    private function getRangoTratamiento($constraints) {
						if($constraints['medico']==0 && $constraints['terapia']==0){
							$tratamientos = Tratamiento::join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																->join('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
																->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																->select('tratamientos.*', 'pacientes.nombre1 as Nombre1', 'pacientes.nombre2 as Nombre2', 'pacientes.nombre3 as Nombre3',
																'pacientes.apellido1 as Apellido1', 'pacientes.apellido2 as Apellido2', 'pacientes.apellido3 as Apellido3', 'medicos.nombre as Medico', 'terapias.nombre as Terapia')
																->where('medico_id', '=', $constraints['medico'])
																->where('terapia_id', '=', $constraints['terapia'])->get();
							return $tratamientos;
						}
							if($constraints['medico']!=0 && $constraints['terapia']!=0){
								$tratamientos = Tratamiento::join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																	->join('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
																	->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																	->select('tratamientos.*', 'pacientes.nombre1 as Nombre1', 'pacientes.nombre2 as Nombre2', 'pacientes.nombre3 as Nombre3',
																	'pacientes.apellido1 as Apellido1', 'pacientes.apellido2 as Apellido2', 'pacientes.apellido3 as Apellido3', 'medicos.nombre as Medico', 'terapias.nombre as Terapia')
																	->where('medico_id', '=', $constraints['medico'])
																	->where('terapia_id', '=', $constraints['terapia'])->get();
								return $tratamientos;
							}
							if($constraints['medico']!=0){
								$tratamientos = Tratamiento::join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																	->join('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
																	->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																	->select('tratamientos.*', 'pacientes.nombre1 as Nombre1', 'pacientes.nombre2 as Nombre2', 'pacientes.nombre3 as Nombre3',
																	'pacientes.apellido1 as Apellido1', 'pacientes.apellido2 as Apellido2', 'pacientes.apellido3 as Apellido3', 'medicos.nombre as Medico', 'terapias.nombre as Terapia')
																	->where('medico_id', '=', $constraints['medico'])->get();
								return $tratamientos;
							}
							if($constraints['terapia']!=0){
								$tratamientos = Tratamiento::join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																	->join('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
																	->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																	->select('tratamientos.*', 'pacientes.nombre1 as Nombre1', 'pacientes.nombre2 as Nombre2', 'pacientes.nombre3 as Nombre3',
																	'pacientes.apellido1 as Apellido1', 'pacientes.apellido2 as Apellido2', 'pacientes.apellido3 as Apellido3', 'medicos.nombre as Medico', 'terapias.nombre as Terapia')
																	->where('terapia_id', '=', $constraints['terapia'])->get();
								return $tratamientos;
							}
		    }

		    public function exportExcel(Request $request) {
		        $this->prepareExportingData($request)->export('xlsx');
		        redirect()->intended('system-management/report-tratamiento');
		    }

		    public function exportPDF(Request $request) {
						date_default_timezone_set('america/guatemala');
						$format = 'Y-m-d H:i:s';
						$now = date($format);
						$constraints = [
									'medico' => $request['medico'],
									'terapia' => $request['terapia']
						];
		        $tratamientos = $this->getExportingData($constraints);
		        $pdf = PDF::loadView('system-mgmt/report-tratamiento/pdf', ['tratamientos' => $tratamientos, 'searchingVals' => $constraints]);
		        return $pdf->download('reporte_tratamiento_fecha_'. $now .'.pdf');
		        return view('system-mgmt/report-tratamiento/pdf', ['tratamientos' => $tratamientos, 'searchingVals' => $constraints]);
		    }

		    private function prepareExportingData($request) {
						date_default_timezone_set('america/guatemala');
						$format = 'Y-m-d H:i:s';
						$now = date($format);
		        $author = Auth::user()->username;
		        $tratamientos = $this->getExportingData(['medico'=> $request['medico'],
																									'terapia' => $request['terapia']]);
		        return Excel::create('reporte_tratamiento_de_fecha_'. $now, function($excel) use($tratamientos, $request, $author) {
							date_default_timezone_set('america/guatemala');
							$format = 'Y-m-d H:i:s';
							$now = date($format);
			        $excel->setTitle('Reporte de Tratamientos del '. $now);
			        $excel->setCreator($author)->setCompany('HoaDang');
			        $excel->setDescription('Listado de Tratamientos');
			        $excel->sheet('Reporte', function($sheet) use($tratamientos) {
			        	$sheet->fromArray($tratamientos);
		          });
		        });
		    }

		    private function getExportingData($constraints) {
					if($constraints['medico']==0 && $constraints['terapia']==0){
						return DB::table('tratamientos')
						->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
						->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
						->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
						->select(	'tratamientos.*',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'medicos.nombre as Medico',
											'terapias.nombre as Terapia')
						->where('tratamientos.medico_id', '=', $constraints['medico'])
						->where('tratamientos.terapia_id', '=', $constraints['terapia'])
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
					if($constraints['medico']!=0 && $constraints['terapia']!=0){
						return DB::table('tratamientos')
						->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
						->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
						->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
						->select(	'tratamientos.*',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'medicos.nombre as Medico',
											'terapias.nombre as Terapia')
						->where('tratamientos.medico_id', '=', $constraints['medico'])
						->where('tratamientos.terapia_id', '=', $constraints['terapia'])
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
					if($constraints['medico']!=0){
						return DB::table('tratamientos')
						->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
						->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
						->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
						->select(	'tratamientos.*',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'medicos.nombre as Medico',
											'terapias.nombre as Terapia')
						->where('tratamientos.medico_id', '=', $constraints['medico'])
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
					if($constraints['terapia']!=0){
						return DB::table('tratamientos')
						->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
						->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
						->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
						->select(	'tratamientos.*',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'medicos.nombre as Medico',
											'terapias.nombre as Terapia')
						->where('tratamientos.terapia_id', '=', $constraints['terapia'])
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
		    }
	}
