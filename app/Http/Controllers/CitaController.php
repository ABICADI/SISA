<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Cita;
use App\Bitacora;
use App\Tratamiento;
use App\Paciente;
use App\Medico;
use App\Terapia;
use Auth;

class CitaController extends Controller {

	protected $redirectTo = '/sisa/agregar-cita'; //redirecciona la ruta

	public function __construct() {
			$this->middleware('auth');
	}

	public function index()	{
		$data = Cita::get(['id', 'title', 'start', 'color']);
		return Response()->json($data);
	}

	public function store(Request $request)	{
			if($request->id != 0){
				$restantes=0;

				$tratamiento = Tratamiento::find($request->id);
				$terapia = Terapia::find($tratamiento->terapia_id);
				$paciente = Paciente::find($tratamiento->paciente_id);

				$cita = new Cita();
				$cita->title = 'Paciente: ' . $paciente->nombre1 . ' ' . $paciente->apellido1 . ' ' . $terapia->nombre;
				$cita->start = $request->fecha;
				$cita->color = $terapia->color;
				$cita->tratamiento_id = $request->id;

				if($tratamiento->restantes>0){
					$restantes = $tratamiento->restantes-1;
					$tratamiento->restantes = $restantes;
					$tratamiento->save();
					if($cita->save()){
						Flash('¡La Cita se ha agregado Exitosamente!')->success();
						return view('tratamientocalendario-mgmt/edit', ['tratamiento' => $tratamiento]);
					}
				}else{
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
					$message = 'Ya no puede ingresar más citas al calendario, ya asigno las ' . $tratamiento->asignados . ' citas al paciente ' . $paciente->nombre1 . ' ' . $paciente->apellido1 . ' para la terapia ' . $terapia->nombre;
		          	return view('tratamiento-mgmt/index',['tratamientos' => $tratamientos, 'message' => $message]);
				}
			}else {
					$restantes=0;
					$last = DB::table('tratamientos')->latest()->first();
					$tratamiento = Tratamiento::find($last->id);

					$terapia = Terapia::find($tratamiento->terapia_id);
					$paciente = Paciente::find($tratamiento->paciente_id);

					$cita = new Cita();
					$cita->title = 'Paciente: ' . $paciente->nombre1 . ' ' . $paciente->apellido1 . ' - Asistencia: Sin evaluar';
					$cita->start = $request->fecha;
					$cita->color = $terapia->color;
					$cita->tratamiento_id = $tratamiento->id;

					if($tratamiento->restantes>0){
						$restantes = $tratamiento->restantes-1;
						$tratamiento->restantes = $restantes;
						$tratamiento->save();
						if($cita->save()){
							Flash('¡La Cita se ha agregado Exitosamente!')->success();
							return redirect()->intended('/sisa/calendario');
						}
					}else{
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
						$message = 'Ya no puede ingresar más citas al calendario, ya asgino las ' . $tratamiento->asignados . ' citas al paciente ' . $paciente->nombre1 . ' ' . $paciente->apellido1 . ' para la terapia ' . $terapia->nombre;
									return view('tratamiento-mgmt/index',['tratamientos' => $tratamientos, 'message' => $message]);
				}
			}
	}

	public function destroy($id){
			$cita = Cita::find($id);
			$tratamiento = Tratamiento::find($cita->tratamiento_id);
			$paciente = Paciente::find($tratamiento->paciente_id);
			$terapia = Terapia::find($tratamiento->terapia_id);

			$new = $tratamiento->restantes+1;
			$tratamiento->restantes = $new;
			$tratamiento->save();

			if($cita == null)
					return Response()->json([
							'message'   =>  'Error al Eliminar la Cita'
					]);
			$cita->delete();
			return Response()->json([
					'message'   =>  'Citas sin asignar ' . $tratamiento->restantes . ' para el paciente ' . $paciente->nombre1 . ' ' . $paciente->apellido1 . ' con la terapia ' . $terapia->nombre . '  (Refrescar la Página para ver los cambios)'
			]);
	}
}
