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

	protected $redirectTo = '/agregar-cita'; //redirecciona la ruta

	public function __construct() {
			$this->middleware('auth');
	}

	public function index()	{
		$data = Cita::get(['id', 'title', 'start', 'color']);
		return Response()->json($data);
	}

	public function store(Request $request)	{
			$last = DB::table('tratamientos')->latest()->first();
			$tratamiento = Tratamiento::find($last->id);

			$terapia = Terapia::find($tratamiento->terapia_id);
			$paciente = Paciente::find($tratamiento->paciente_id);

			$cita = new Cita();
			$cita->title = 'Paciente: ' . $paciente->nombre1 . ' ' . $paciente->apellido1 . ' - Asistencia: ';
			$cita->start = $request->fecha;
			$cita->color = $terapia->color;
			$cita->tratamiento_id = $tratamiento->id;

			$update_cant_citas = Tratamiento::findOrFail($tratamiento->id);

			if($update_cant_citas->restantes){
				$update_cant_citas->restantes = $tratamiento->restantes-1;
				$update_cant_citas->save();
				if($cita->save()){
					return redirect()->intended('/calendario');
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
				$message = 'Ya no puede ingresar más citas al calendario, ya asgino las ' . $update_cant_citas->asignados . ' citas al paciente ' . $paciente->nombre1 . ' ' . $paciente->apellido1 . ' para la terapia ' . $terapia->nombre;
	          	return view('tratamiento-mgmt/index',['tratamientos' => $tratamientos, 'message' => $message]);
			}
          	//return view('calendario-mgmt/index', ['restantes' => $update_cant_citas->restantes]);
	}

	public function destroy($id){
			$cita = Cita::find($id);
			if($cita == null)
					return Response()->json([
							'message'   =>  'Error al Eliminar la Cita'
					]);
			$cita->delete();
			return Response()->json([
					'message'   =>  'Eliminación de la Cita con Éxito'
			]);
	}
}
