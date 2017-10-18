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

class CalendarioController extends Controller {
	protected $redirectTo = '/calendario'; //redirecciona la ruta

	public function __construct() {
			$this->middleware('auth');
	}

	public function index()	{
			return view('calendario-mgmt/index');
	}
}
