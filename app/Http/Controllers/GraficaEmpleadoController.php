<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Charts;

class GraficaEmpleadoController extends Controller{
		public function __construct() {
				$this->middleware('auth');
		}

		public function index() {
			date_default_timezone_set('america/guatemala');
			$format = 'Y';
			$now = date($format);
			$grafica_registro = Charts::multiDatabase('line', 'highcharts')
          ->title('Gráfica de Empleados registradas en SISA')
          ->dataset('Empleados', User::all()->where('estado_id', '!=', 2)->where('id', '!=', 1))
          ->responsive(true)
          ->elementLabel("Cantidad")
          ->groupByMonth($now, true);

      return view('grafica-mgmt/empleado/index', ['grafica_registro' => $grafica_registro]);
    }
}
