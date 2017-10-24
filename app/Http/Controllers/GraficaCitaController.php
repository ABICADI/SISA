<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Paciente;
use App\Medico;
use Charts;

class GraficaCitaController extends Controller{
		public function __construct() {
				$this->middleware('auth');
		}

		public function index() {

			$grafica_registro = Charts::multiDatabase('line', 'highcharts')
          ->title('Gráfica de Empleado, Paciente y Médico registrados en SISA')
          ->dataset('Empleados', User::all()->where('estado_id', '!=', 2)->where('id', '!=', 1))
          ->dataset('Pacientes', Paciente::all())
          ->dataset('Médicos', Medico::all())
          ->responsive(true)
          ->elementLabel("Cantidad")
          ->groupByMonth(2017, true);

      return view('grafica-mgmt/cita/index',['grafica_registro' => $grafica_registro]);
    }
}
