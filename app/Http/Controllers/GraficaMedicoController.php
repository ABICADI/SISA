<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Medico;
use Charts;

class GraficaMedicoController extends Controller{
		public function __construct() {
				$this->middleware('auth');
		}

		public function index() {
			date_default_timezone_set('america/guatemala');
			$format = 'Y';
			$now = date($format);
			$grafica_registro = Charts::multiDatabase('line', 'highcharts')
          ->title('Gráfica de Médicos registrados en SISA')
          ->dataset('Médicos', Medico::all())
          ->responsive(true)
          ->elementLabel("Cantidad")
          ->groupByMonth($now, true);

      return view('grafica-mgmt/medico/index', ['grafica_registro' => $grafica_registro]);
    }
}
