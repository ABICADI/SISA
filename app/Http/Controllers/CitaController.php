<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
		$data = Cita::get(['id', 'start', 'end']);
		return Response()->json($data);
	}

	public function store(Request $request)	{
			$last = DB::table('tratamientos')->latest()->first();
			$tratamiento = Tratamiento::find($last->id);

			$cita = new Cita();
			$cita->start = $request->fecha;
			$cita->end = $request->fecha;
			$cita->tratamiento_id = $tratamiento->id;

			if($cita->save()){
				return redirect()->intended('/calendario');
			}
	}
}
