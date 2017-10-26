<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Paciente;
use Charts;

class GraficaPacienteController extends Controller{
		public function __construct() {
				$this->middleware('auth');
		}

		public function index() {
			date_default_timezone_set('america/guatemala');
			$format = 'Y';
			$now = date($format);
			$grafica_registro = Charts::multiDatabase('line', 'highcharts')
          ->title('Gráfica de Pacientes registrados en SISA')
          ->dataset('Pacientes', Paciente::all())
          ->responsive(true)
          ->elementLabel("Cantidad")
          ->groupByMonth($now, true);

      return view('grafica-mgmt/paciente/index', ['grafica_registro' => $grafica_registro]);
    }
}
