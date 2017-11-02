<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;
use App\Cita;
use App\Tratamiento;
use App\Terapia;
use App\Paciente;
use Excel;
use Auth;
use PDF;

class ReportCitaController extends Controller{

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
										'terapia' => '',
										'paciente' => ''
			        ];
							$pacientes = Paciente::select('pacientes.*')->get();
							$terapias = Terapia::select('terapias.*')->where('id','!=',1)->get();
			        $citas = $this->getRangoCita($constraints);
							if($citas->count()==0){
								$si=1;
							}else {
								$si=0;
							}
			        $message = '';
			        return view('system-mgmt/report-cita/index', ['citas' => $citas, 'pacientes' => $pacientes, 'terapias' => $terapias, 'searchingVals' => $constraints, 'message' => $message, 'si' => $si]);
			    }

			    public function search(Request $request) {
							if($request->from != '' && $request->to != ''){
								$constraints = [
									'from' => $request['from'],
									'to' => $request['to'],
									'terapia' => $request['terapia_id'],
									'paciente' => $request['paciente_id']
				        ];
								$pacientes = Paciente::select('pacientes.*')->get();
								$terapias = Terapia::select('terapias.*')->where('id','!=',1)->get();
				        $citas = $this->getRangoCita($constraints);
								if($citas->count()==0){
									$si=1;
								}else {
									$si=0;
								}
				        $message = '';
				        return view('system-mgmt/report-cita/index', ['citas' => $citas, 'pacientes' => $pacientes, 'terapias' => $terapias, 'searchingVals' => $constraints, 'message' => $message, 'si' => $si]);
								}

			        if($request->from == '' || $request->to == ''){
								$constraints = [
									'from' => $request['from'],
									'to' => $request['to'],
									'terapia' => $request['terapia_id'],
									'paciente' => $request['paciente_id']
				        ];
								$pacientes = Paciente::select('pacientes.*')->get();
								$terapias = Terapia::select('terapias.*')->where('id','!=',1)->get();
				        $citas = $this->getRangoCita($constraints);
								if($citas->count()==0){
									$si=1;
								}else {
									$si=0;
								}
				        $message = 'No es valido el rango de fecha.';
				        return view('system-mgmt/report-cita/index', ['citas' => $citas, 'pacientes' => $pacientes, 'terapias' => $terapias, 'searchingVals' => $constraints, 'message' => $message, 'si' => $si]);
			        }
			    }

			    private function getRangoCita($constraints) {
							if($constraints['from'] == '' || $constraints['to'] == ''){
								if($constraints['paciente']!=0 && $constraints['terapia']!=0){
									$tratamientos = Tratamiento::select('id', 'terapia_id', 'paciente_id')
									->where('paciente_id', '=', $constraints['paciente'])
									->where('terapia_id', '=', $constraints['terapia'])->get();

									if(collect($tratamientos)->isEmpty()==false){
										$plucks=$tratamientos->pluck('id');
										$contar = $plucks->count();
										if($contar>1){
											foreach ($plucks as $key => $id) {
												$citas = Cita::join('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
																							->join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																							->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																							->select('citas.*', 'tratamientos.*', 'pacientes.*', 'terapias.*')
																							->where('citas.tratamiento_id', '=', $key)->get();
											}
										}elseif ($contar==1) {
											$citas = Cita::join('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
																						->join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																						->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																						->select('citas.*', 'tratamientos.*', 'pacientes.*', 'terapias.*')
																						->where('citas.tratamiento_id', '=', $plucks)->get();
										}
										return $citas;
									}
									if(collect($tratamientos)->isEmpty()==true){
										$citas = Cita::join('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
																					->join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																					->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																					->select('citas.*', 'tratamientos.*', 'pacientes.*', 'terapias.*')
																					->where('start', '>=', '1800-01-01')
																					->where('start', '<=', '1800-01-01')->get();
										return $citas;
									}
								}
								if($constraints['paciente']!=0 && $constraints['terapia']==0){
									$citas = Cita::join('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
																				->join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																				->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																				->select('citas.*', 'tratamientos.*', 'pacientes.*', 'terapias.*')
																				->where('start', '>=', '1800-01-01')
																				->where('start', '<=', '1800-01-01')->get();
									return $citas;
								}
								if($constraints['paciente']==0 && $constraints['terapia']!=0){
									$citas = Cita::join('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
																				->join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																				->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																				->select('citas.*', 'tratamientos.*', 'pacientes.*', 'terapias.*')
																				->where('start', '>=', '1800-01-01')
																				->where('start', '<=', '1800-01-01')->get();
									return $citas;
								}
								if($constraints['paciente']==0 && $constraints['terapia']==0){
									$citas = Cita::join('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
																				->join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																				->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																				->select('citas.*', 'tratamientos.*', 'pacientes.*', 'terapias.*')
																				->where('start', '>=', '1800-01-01')
																				->where('start', '<=', '1800-01-01')->get();
									return $citas;
								}
							}

			        if($constraints['from'] != '' && $constraints['to'] != ''){
								if($constraints['paciente']!=0 && $constraints['terapia']!=0){
									$tratamientos = Tratamiento::select('id', 'terapia_id', 'paciente_id')
									->where('paciente_id', '=', $constraints['paciente'])
									->where('terapia_id', '=', $constraints['terapia'])->get();

									if(collect($tratamientos)->isEmpty()==false){
										$plucks=$tratamientos->pluck('id');
										$contar = $plucks->count();
										if($contar>1){
											foreach ($plucks as $key => $id) {
												$citas = Cita::join('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
																							->join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																							->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																							->select('citas.*', 'tratamientos.*', 'pacientes.*', 'terapias.*')
																							->where('citas.tratamiento_id', '=', $key)
																							->where('start', '>=', $constraints['from'])
																						->where('start', '<=', $constraints['to'])->get();
											}
										}elseif ($contar==1) {
											$citas = Cita::join('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
																						->join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																						->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																						->select('citas.*', 'tratamientos.*', 'pacientes.*', 'terapias.*')
																						->where('citas.tratamiento_id', '=', $plucks)
																						->where('start', '>=', $constraints['from'])
																						->where('start', '<=', $constraints['to'])->get();
										}
										return $citas;
									}
									if(collect($tratamientos)->isEmpty()==true){
										$citas = Cita::join('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
																					->join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																					->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																					->select('citas.*', 'tratamientos.*', 'pacientes.*', 'terapias.*')
																					->where('start', '>=', '1800-01-01')
																					->where('start', '<=', '1800-01-01')->get();
										return $citas;
									}
								}
								if($constraints['paciente']!=0 && $constraints['terapia']==0){
									$citas = Cita::join('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
																				->join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																				->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																				->select('citas.*', 'tratamientos.*', 'pacientes.*', 'terapias.*')
																				->where('start', '>=', '1800-01-01')
																				->where('start', '<=', '1800-01-01')->get();
									return $citas;
								}
								if($constraints['paciente']==0 && $constraints['terapia']!=0){
									$citas = Cita::join('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
																				->join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																				->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																				->select('citas.*', 'tratamientos.*', 'pacientes.*', 'terapias.*')
																				->where('start', '>=', '1800-01-01')
																				->where('start', '<=', '1800-01-01')->get();
									return $citas;
								}
								if($constraints['paciente']==0 && $constraints['terapia']==0){
									$citas = Cita::join('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
																				->join('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
																				->join('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
																				->select('citas.*', 'tratamientos.*', 'pacientes.*', 'terapias.*')
																				->where('start', '>=', $constraints['from'])
																				->where('start', '<=', $constraints['to'])->get();
									return $citas;
								}
							}
			    }

			    public function exportExcel(Request $request) {
			        $this->prepareExportingData($request)->export('xlsx');
			        redirect()->intended('system-management/report-cita');
			    }

			    public function exportPDF(Request $request) {
							date_default_timezone_set('america/guatemala');
							$format = 'Y-m-d H:i:s';
							$now = date($format);
							$terapia = Terapia::find($request['terapia']);
							$paciente = Paciente::find($request['paciente']);
							$constraints = [
										'from' => $request['from'],
										'to' => $request['to'],
										'terapia' => $request['terapia'],
										'paciente' => $request['paciente']
							];
							if($request['from'] == '' || $request['to'] == ''){
								if($request['terapia']!=0 && $request['paciente']!=0){
									$title = 'Reporte de Citas Paciente: '. $paciente->nombre1 . ' ' . $paciente->apellido1 . ' y Terapia: ' . $terapia->nombre;
								}else{
									$title = 'Reporte de Cita';
								}
							}
							if($request['from'] != '' || $request['to'] != ''){
								if($request['terapia']!=0 && $request['paciente']!=0){
									$title = 'Reporte de Citas Rango de ' .$request['from']. ' hasta ' .$request['to'].' Paciente: '.$paciente->nombre1. ' ' .$paciente->apellido1. ' y Terapia: ' .$terapia->nombre;
								}else{
									$title = 'Reporte de Citas Rango de ' .$request['from']. ' hasta ' .$request['to'];
								}
							}
			        $citas = $this->getExportingData($constraints);
			        $pdf = PDF::loadView('system-mgmt/report-cita/pdf', ['citas' => $citas, 'searchingVals' => $constraints, 'title' => $title]);
			        return $pdf->download('reporte_cita_fecha_'. $now .'.pdf');
			        return view('system-mgmt/report-cita/pdf', ['citas' => $citas, 'searchingVals' => $constraints, 'title' => $title]);
			    }

			    private function prepareExportingData($request) {
							date_default_timezone_set('america/guatemala');
							$format = 'Y-m-d_H:i:s';
							$now = date($format);
			        $author = Auth::user()->username;
			        $citas = $this->getExportingData(['from'=> $request['from'],
																								'to' => $request['to'],
																								'terapia' => $request['terapia'],
																								'paciente' => $request['paciente']]);
			        return Excel::create('reporte_cita_de_fecha_'. $now, function($excel) use($citas, $request, $author) {
								$terapia = Terapia::find($request['terapia']);
								$paciente = Paciente::find($request['paciente']);
								date_default_timezone_set('america/guatemala');
								$format = 'd-m-Y';
								$now = date($format);
								if($request['from'] == '' || $request['to'] == ''){
									if($request['terapia']!=0 && $request['paciente']!=0){
										$title = 'Reporte de Citas Paciente: '. $paciente->nombre1 . ' ' . $paciente->apellido1 . ' y Terapia: ' . $terapia->nombre;
									}else{
										$title = 'Reporte de Cita';
									}
								}
								if($request['from'] != '' || $request['to'] != ''){
									if($request['terapia']!=0 && $request['paciente']!=0){
										$title = 'Reporte de Citas Rango de ' .$request['from']. ' hasta ' .$request['to'].' Paciente: '.$paciente->nombre1. ' ' .$paciente->apellido1. ' y Terapia: ' .$terapia->nombre;
									}else{
										$title = 'Reporte de Citas Rango de ' .$request['from']. ' hasta ' .$request['to'];
									}
								}
								$excel->setTitle($title);
				        $excel->setCreator($author)->setCompany('HoaDang');
				        $excel->setDescription('Listado de Citas');
				        $excel->sheet('Reporte_'.$now, function($sheet) use($citas) {
				        	$sheet->fromArray($citas);
			          });
			        });
			    }

			    private function getExportingData($constraints) {
						if($constraints['from'] == '' || $constraints['to'] == ''){
							if($constraints['paciente']!=0 && $constraints['terapia']!=0){
								$tratamientos = Tratamiento::select('id', 'terapia_id', 'paciente_id')
								->where('paciente_id', '=', $constraints['paciente'])
								->where('terapia_id', '=', $constraints['terapia'])->get();

								if(collect($tratamientos)->isEmpty()==false){
									$plucks=$tratamientos->pluck('id');
									$contar = $plucks->count();
									if($contar>1){
										foreach ($plucks as $keys => $id) {
											return DB::table('citas')
											->leftJoin('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
											->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
											->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
											->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
											->select('citas.start as Fecha',
																'pacientes.nombre1 as Primer_Nombre',
																'pacientes.nombre2 as Segundo_Nombre',
																'pacientes.nombre3 as Tercer_Nombre',
																'pacientes.apellido1 as Primer_Apellido',
																'pacientes.apellido2 as Segundo_Apellido',
																'pacientes.apellido3 as Tercer_Apellido',
																'terapias.nombre as Terapia',
																'medicos.nombre as Medico')
																->where('citas.tratamiento_id', '=', $keys)
											->get()
											->map(function ($item, $key) {
											return (array) $item;
											})
											->all();
										}
									}elseif ($contar==1) {
										return DB::table('citas')
										->leftJoin('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
										->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
										->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
										->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
										->select('citas.start as Fecha',
															'pacientes.nombre1 as Primer_Nombre',
															'pacientes.nombre2 as Segundo_Nombre',
															'pacientes.nombre3 as Tercer_Nombre',
															'pacientes.apellido1 as Primer_Apellido',
															'pacientes.apellido2 as Segundo_Apellido',
															'pacientes.apellido3 as Tercer_Apellido',
															'terapias.nombre as Terapia',
															'medicos.nombre as Medico')
															->where('citas.tratamiento_id', '=', $plucks)
										->get()
										->map(function ($item, $key) {
										return (array) $item;
										})
										->all();
									}
								}
						}
						if($constraints['paciente']!=0 && $constraints['terapia']==0){
							return DB::table('citas')
							->leftJoin('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
							->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
							->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
							->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
							->select('citas.start as Fecha',
												'pacientes.nombre1 as Primer_Nombre',
												'pacientes.nombre2 as Segundo_Nombre',
												'pacientes.nombre3 as Tercer_Nombre',
												'pacientes.apellido1 as Primer_Apellido',
												'pacientes.apellido2 as Segundo_Apellido',
												'pacientes.apellido3 as Tercer_Apellido',
												'terapias.nombre as Terapia',
												'medicos.nombre as Medico')
												->where('start', '>=', '1800-01-01')
												->where('start', '<=', '1800-01-01')
							->get()
							->map(function ($item, $key) {
							return (array) $item;
							})
							->all();
						}
						if($constraints['paciente']==0 && $constraints['terapia']!=0){
							return DB::table('citas')
							->leftJoin('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
							->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
							->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
							->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
							->select('citas.start as Fecha',
												'pacientes.nombre1 as Primer_Nombre',
												'pacientes.nombre2 as Segundo_Nombre',
												'pacientes.nombre3 as Tercer_Nombre',
												'pacientes.apellido1 as Primer_Apellido',
												'pacientes.apellido2 as Segundo_Apellido',
												'pacientes.apellido3 as Tercer_Apellido',
												'terapias.nombre as Terapia',
												'medicos.nombre as Medico')
												->where('start', '>=', '1800-01-01')
												->where('start', '<=', '1800-01-01')
							->get()
							->map(function ($item, $key) {
							return (array) $item;
							})
							->all();
						}
						if($constraints['paciente']==0 && $constraints['terapia']==0){
							return DB::table('citas')
							->leftJoin('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
							->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
							->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
							->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
							->select('citas.start as Fecha',
												'pacientes.nombre1 as Primer_Nombre',
												'pacientes.nombre2 as Segundo_Nombre',
												'pacientes.nombre3 as Tercer_Nombre',
												'pacientes.apellido1 as Primer_Apellido',
												'pacientes.apellido2 as Segundo_Apellido',
												'pacientes.apellido3 as Tercer_Apellido',
												'terapias.nombre as Terapia',
												'medicos.nombre as Medico')
												->where('start', '>=', '1800-01-01')
												->where('start', '<=', '1800-01-01')
							->get()
							->map(function ($item, $key) {
							return (array) $item;
							})
							->all();
						}
					}

					if($constraints['from'] != '' && $constraints['to'] != ''){
						if($constraints['paciente']!=0 && $constraints['terapia']!=0){
							$tratamientos = Tratamiento::select('id', 'terapia_id', 'paciente_id')
							->where('paciente_id', '=', $constraints['paciente'])
							->where('terapia_id', '=', $constraints['terapia'])->get();

							if(collect($tratamientos)->isEmpty()==false){
								$plucks=$tratamientos->pluck('id');
								$contar = $plucks->count();
								if($contar>1){
									foreach ($plucks as $keys => $id) {
										return DB::table('citas')
										->leftJoin('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
										->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
										->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
										->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
										->select('citas.start as Fecha',
															'pacientes.nombre1 as Primer_Nombre',
															'pacientes.nombre2 as Segundo_Nombre',
															'pacientes.nombre3 as Tercer_Nombre',
															'pacientes.apellido1 as Primer_Apellido',
															'pacientes.apellido2 as Segundo_Apellido',
															'pacientes.apellido3 as Tercer_Apellido',
															'terapias.nombre as Terapia',
															'medicos.nombre as Medico')
															->where('citas.tratamiento_id', '=', $keys)
															->where('start', '>=', $constraints['from'])
															->where('start', '<=', $constraints['to'])
										->get()
										->map(function ($item, $key) {
										return (array) $item;
										})
										->all();
									}
								}elseif ($contar==1) {
									return DB::table('citas')
									->leftJoin('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
									->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
									->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
									->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
									->select('citas.start as Fecha',
														'pacientes.nombre1 as Primer_Nombre',
														'pacientes.nombre2 as Segundo_Nombre',
														'pacientes.nombre3 as Tercer_Nombre',
														'pacientes.apellido1 as Primer_Apellido',
														'pacientes.apellido2 as Segundo_Apellido',
														'pacientes.apellido3 as Tercer_Apellido',
														'terapias.nombre as Terapia',
														'medicos.nombre as Medico')
														->where('citas.tratamiento_id', '=', $plucks)
														->where('start', '>=', $constraints['from'])
														->where('start', '<=', $constraints['to'])
									->get()
									->map(function ($item, $key) {
									return (array) $item;
									})
									->all();
								}
							}
					}
					if($constraints['paciente']!=0 && $constraints['terapia']==0){
						return DB::table('citas')
						->leftJoin('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
						->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
						->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
						->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
						->select('citas.start as Fecha',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'terapias.nombre as Terapia',
											'medicos.nombre as Medico')
											->where('start', '>=', '1800-01-01')
											->where('start', '<=', '1800-01-01')
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
					if($constraints['paciente']==0 && $constraints['terapia']!=0){
						return DB::table('citas')
						->leftJoin('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
						->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
						->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
						->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
						->select('citas.start as Fecha',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'terapias.nombre as Terapia',
											'medicos.nombre as Medico')
											->where('start', '>=', '1800-01-01')
											->where('start', '<=', '1800-01-01')
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
					if($constraints['paciente']==0 && $constraints['terapia']==0){
						return DB::table('citas')
						->leftJoin('tratamientos', 'citas.tratamiento_id', '=', 'tratamientos.id')
						->leftJoin('pacientes', 'tratamientos.paciente_id', '=', 'pacientes.id')
						->leftJoin('terapias', 'tratamientos.terapia_id', '=', 'terapias.id')
						->leftJoin('medicos', 'tratamientos.medico_id', '=', 'medicos.id')
						->select('citas.start as Fecha',
											'pacientes.nombre1 as Primer_Nombre',
											'pacientes.nombre2 as Segundo_Nombre',
											'pacientes.nombre3 as Tercer_Nombre',
											'pacientes.apellido1 as Primer_Apellido',
											'pacientes.apellido2 as Segundo_Apellido',
											'pacientes.apellido3 as Tercer_Apellido',
											'terapias.nombre as Terapia',
											'medicos.nombre as Medico')
											->where('start', '>=', $constraints['from'])
											->where('start', '<=', $constraints['to'])
						->get()
						->map(function ($item, $key) {
						return (array) $item;
						})
						->all();
					}
				}
			}
	}
