<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Municipio;
use Charts;

class GraficaEmpleadoController extends Controller{
		public function __construct() {
				$this->middleware('auth');
		}

		public function index() {
			date_default_timezone_set('america/guatemala');
			$format = 'Y';
			$now = date($format);

			$group_departamento = Charts::database(User::all(), 'bar', 'highcharts')
	        ->title('Empleados por Municipio de Santa Rosa')
	        ->dimensions(10, 5)
	        ->responsive(true)
					->elementLabel("Cantidad")
	        ->groupBy('municipio_id', null, [1 => 'ALTA VERAPAZ', 2 => 'BAJA VERAPAZ', 3 => 'CHIMALTENANGO',
																							4 => 'CHIQUIMULA', 5 => 'GUATEMALA', 6 => 'EL PROGRESO',
																							7 => 'ESCUINTLA', 8 => 'HUEHUETENANGO', 9 => 'IZABAL',
																							10 => 'JALAPA', 11 => 'JUTIAPA', 12 => 'PETÉN',
																							13 => 'QUETZALTENANGO', 14 => 'QUICHÉ', 15 => 'RETALHULEU',
																							16 => 'SACATEPÉQUEZ', 17 => 'SAN MARCOS', 18 => 'SANTA ROSA',
																							19 => 'SOLOLÁ', 20 => 'SUCHITEPÉQUEZ', 21 => 'TOTONICAPÁN',
																							22 => 'ZACAPA']);

			$grafica_registro = Charts::multiDatabase('line', 'highcharts')
          ->title('Gráfica de Empleados registradas en SISA')
          ->dataset('Empleados', User::all()->where('estado_id', '!=', 2)->where('id', '!=', 1))
          ->responsive(true)
          ->elementLabel("Cantidad")
          ->groupByMonth($now, true);

      return view('grafica-mgmt/empleado/index', ['grafica_registro' => $grafica_registro, 'group_departamento' => $group_departamento]);
    }
}
