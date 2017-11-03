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
									'paciente' => 0,
									'terapia' => 0
		        ];
						$pacientes = Paciente::select('pacientes.id as id', 'pacientes.nombre1 as nombre1', 'pacientes.nombre2 as nombre2', 'pacientes.nombre3 as nombre3', 'pacientes.apellido1 as apellido1', 'pacientes.apellido2 as apellido2', 'pacientes.apellido3 as apellido3')->orderBy('nombre1', 'asc')->get();
		        $terapias = Terapia::select('id', 'nombre')->where('id', '!=', 1)->orderBy('nombre', 'asc')->get();
						$tratamientos = $this->getRangoTratamiento($constraints);
						if($tratamientos->count()==0){
							$si=1;
						}else {
							$si=0;
						}
						return view('system-mgmt/report-tratamiento/index', ['tratamientos' => $tratamientos, 'pacientes' => $pacientes, 'terapias' => $terapias, 'searchingVals' => $constraints, 'si' => $si]);
		    }

		    public function search(Request $request) {
							$pacientes = Paciente::select('pacientes.id as id', 'pacientes.nombre1 as nombre1', 'pacientes.nombre2 as nombre2', 'pacientes.nombre3 as nombre3', 'pacientes.apellido1 as apellido1', 'pacientes.apellido2 as apellido2', 'pacientes.apellido3 as apellido3')->orderBy('nombre1', 'asc')->get();
							$terapias = Terapia::select('id', 'nombre')->where('id', '!=', 1)->orderBy('nombre', 'asc')->get();
							$constraints = [
										'paciente' => $request['paciente_id'],
										'terapia' => $request['terapia_id']
			        ];
		        	$tratamientos = $this->getRangoTratamiento($constraints);
							if($tratamientos->count()==0){
								$si=1;
							}else {
								$si=0;
							}
		        	return view('system-mgmt/report-tratamiento/index', ['tratamientos' => $tratamientos, 'pacientes' => $pacientes, 'terapias' => $terapias, 'searchingVals' => $constraints, 'si' => $si]);
		    }

		    private function getRangoTratamiento($constraints) {
						if($constraints['paciente']==0 && $constraints['terapia']==0){
							$tratamientos = Tratamiento::join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																->join('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
																->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																->select('tratamientos.*', 'pacientes.seguro_social as No_Registro', 'pacientes.nombre1 as Nombre1', 'pacientes.nombre2 as Nombre2', 'pacientes.nombre3 as Nombre3', 'pacientes.apellido1 as Apellido1', 'pacientes.apellido2 as Apellido2', 'pacientes.apellido3 as Apellido3', 'medicos.nombre as Medico', 'terapias.nombre as Terapia')
																->where('paciente_id', '=', $constraints['paciente'])
																->where('terapia_id', '=', $constraints['terapia'])->get();
							return $tratamientos;
						}
							if($constraints['paciente']!=0 && $constraints['terapia']!=0){
								$tratamientos = Tratamiento::join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																	->join('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
																	->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																	->select('tratamientos.*', 'pacientes.seguro_social as No_Registro', 'pacientes.nombre1 as Nombre1', 'pacientes.nombre2 as Nombre2', 'pacientes.nombre3 as Nombre3', 'pacientes.apellido1 as Apellido1', 'pacientes.apellido2 as Apellido2', 'pacientes.apellido3 as Apellido3', 'medicos.nombre as Medico', 'terapias.nombre as Terapia')
																	->where('paciente_id', '=', $constraints['paciente'])
																	->where('terapia_id', '=', $constraints['terapia'])->get();
								return $tratamientos;
							}
							if($constraints['paciente']!=0){
								$tratamientos = Tratamiento::join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																	->join('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
																	->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																	->select('tratamientos.*', 'pacientes.seguro_social as No_Registro', 'pacientes.nombre1 as Nombre1', 'pacientes.nombre2 as Nombre2', 'pacientes.nombre3 as Nombre3', 'pacientes.apellido1 as Apellido1', 'pacientes.apellido2 as Apellido2', 'pacientes.apellido3 as Apellido3', 'medicos.nombre as Medico', 'terapias.nombre as Terapia')
																	->where('paciente_id', '=', $constraints['paciente'])->get();
								return $tratamientos;
							}
							if($constraints['terapia']!=0){
								$tratamientos = Tratamiento::join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																	->join('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
																	->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																	->select('tratamientos.*', 'pacientes.seguro_social as No_Registro', 'pacientes.nombre1 as Nombre1', 'pacientes.nombre2 as Nombre2', 'pacientes.nombre3 as Nombre3', 'pacientes.apellido1 as Apellido1', 'pacientes.apellido2 as Apellido2', 'pacientes.apellido3 as Apellido3', 'medicos.nombre as Medico', 'terapias.nombre as Terapia')
																	->where('terapia_id', '=', $constraints['terapia'])->get();
								return $tratamientos;
							}
		    }

		    public function exportExcel(Request $request) {
		        $this->prepareExportingData($request)->export('xlsx');
		        redirect()->intended('system-management/report-tratamiento');
		    }

		    public function exportPDF(Request $request) {
						$paciente = Paciente::find($request['paciente']);
						$terapia = Terapia::find($request['terapia']);
						date_default_timezone_set('america/guatemala');
						$format = 'Y-m-d H:i:s';
						$now = date($format);
						$constraints = [
									'paciente' => $request['paciente'],
									'terapia' => $request['terapia']
						];
		        $tratamientos = $this->getExportingData($constraints);
						if($request['paciente']!=0 && $request['terapia']!=0){
								$title = 'Reporte de Tratamiento por Paciente: '.$paciente->nombre1.' '.$paciente->apellido1.', y por Terapia: '.$terapia->nombre;
						}
						if($request['paciente']!=0 && $request['terapia']==0){
								$title = 'Reporte de Tratamiento por Paciente: '.$paciente->nombre1.' '.$paciente->apellido1;
						}
						if($request['paciente']==0 && $request['terapia']!=0){
								$title = 'Reporte de Tratamiento por Terapia: '.$terapia->nombre;
						}
						if($request['paciente']==0 && $request['terapia']==0){
								$title = 'Reporte de Tratamiento';
						}
		        $pdf = PDF::loadView('system-mgmt/report-tratamiento/pdf', ['tratamientos' => $tratamientos, 'searchingVals' => $constraints, 'title' => $title]);
		        return $pdf->download('reporte_tratamiento_fecha_'. $now .'.pdf');
		        return view('system-mgmt/report-tratamiento/pdf', ['tratamientos' => $tratamientos, 'searchingVals' => $constraints, 'title' => $title]);
		    }

		    private function prepareExportingData($request) {
						date_default_timezone_set('america/guatemala');
						$format = 'Y-m-d H:i:s';
						$now = date($format);
		        $author = Auth::user()->username;
		        $tratamientos = $this->getExportingData(['paciente'=> $request['paciente'],
																									'terapia' => $request['terapia']]);
		        return Excel::create('reporte_tratamiento_de_fecha_'. $now, function($excel) use($tratamientos, $request, $author) {
							$paciente = Paciente::find($request['paciente']);
							$terapia = Terapia::find($request['terapia']);
							date_default_timezone_set('america/guatemala');
							$format = 'd-m-Y';
							$now = date($format);
								if($request['paciente']!=0 && $request['terapia']!=0){
										$title = 'Reporte de Tratamiento por Paciente: '.$paciente->nombre1.' '.$paciente->apellido1.', y por Terapia: '.$terapia->nombre;
								}
								if($request['paciente']!=0 && $request['terapia']==0){
										$title = 'Reporte de Tratamiento por Paciente: '.$paciente->nombre1.' '.$paciente->apellido1;
								}
								if($request['paciente']==0 && $request['terapia']!=0){
										$title = 'Reporte de Tratamiento por Terapia: '.$terapia->nombre;
								}
								if($request['paciente']==0 && $request['terapia']==0){
										$title = 'Reporte de Tratamiento';
								}
			        $excel->setTitle($title);
			        $excel->setCreator($author)->setCompany('HoaDang');
			        $excel->setDescription('Listado de Tratamientos');
			        $excel->sheet('Reporte_'.$now, function($sheet) use($tratamientos) {
			        	$sheet->fromArray($tratamientos);
		          });
		        });
		    }

		    private function getExportingData($constraints) {
					if($constraints['paciente']==0 && $constraints['terapia']==0){
						return DB::table('tratamientos')
						->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
						->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
						->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
						->select('pacientes.seguro_social as No. Registro',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'medicos.nombre as Medico',
											'terapias.nombre as Terapia',
											'tratamientos.descripcion as Diagnóstico')
						->where('tratamientos.paciente_id', '=', $constraints['paciente'])
						->where('tratamientos.terapia_id', '=', $constraints['terapia'])
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
					if($constraints['paciente']!=0 && $constraints['terapia']!=0){
						return DB::table('tratamientos')
						->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
						->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
						->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
						->select('pacientes.seguro_social as No. Registro',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'medicos.nombre as Medico',
											'terapias.nombre as Terapia',
											'tratamientos.descripcion as Diagnóstico')
						->where('tratamientos.paciente_id', '=', $constraints['paciente'])
						->where('tratamientos.terapia_id', '=', $constraints['terapia'])
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
					if($constraints['paciente']!=0){
						return DB::table('tratamientos')
						->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
						->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
						->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
						->select('pacientes.seguro_social as No. Registro',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'medicos.nombre as Medico',
											'terapias.nombre as Terapia',
											'tratamientos.descripcion as Diagnóstico')
						->where('tratamientos.paciente_id', '=', $constraints['paciente'])
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
						->select('pacientes.seguro_social as No. Registro',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'medicos.nombre as Medico',
											'terapias.nombre as Terapia',
											'tratamientos.descripcion as Diagnóstico')
						->where('tratamientos.terapia_id', '=', $constraints['terapia'])
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
		    }
	}
