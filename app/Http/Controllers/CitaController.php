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
			$cita->title = $paciente->nombre1 . ' ' . $paciente->apellido1;
			$cita->start = $request->fecha;
			$cita->color = $terapia->color;
			$cita->tratamiento_id = $tratamiento->id;

			if($cita->save()){
				return redirect()->intended('/calendario');
			}
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
