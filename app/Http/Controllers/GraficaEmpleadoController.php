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

			$group_genero = Charts::database(User::all(), 'pie', 'highcharts')
	        ->title('Empleados por Género')
	        ->dimensions(10, 5)
	        ->responsive(true)
					->elementLabel("Cantidad")
					->groupBy('genero_id', null, [1 => 'FEMENINO', 2 => 'MASCULINO']);

			$municipio = User::join('municipios', 'users.municipio_id', 'municipios.id')
												->select('users.municipio_id')
												->where('municipios.departamento_id', '=', 18)->get();

			$group_municipio = Charts::database($municipio, 'bar', 'highcharts')
	        ->title('Empleados por Municipio de Santa Rosa')
	        ->dimensions(10, 5)
	        ->responsive(true)
					->elementLabel("Cantidad")
					->groupBy('municipio_id', null, [267 => 'BARBERENA', 268 => 'CASILLAS', 269 => 'CHIQUIMULILLA',
																									270 => 'CUILAPA', 271 => 'GUAZACAPAN', 272 => 'NUEVA SANTA ROSA',
																									273 => 'ORATORIO', 274 => 'PUEBLO NUEVO VIÑAS', 275 => 'SAN JUAN TECUACO',
																									276 => 'SAN RAFAEL LAS FLORES', 277 => 'SANTA CRUZ NARANJO', 278 => 'SANTA MARIA IXHUATAN',
																									279 => 'SANTA ROSA DE LIMA', 280 => 'TAXISCO']);


			$grafica_registro = Charts::multiDatabase('line', 'highcharts')
          ->title('Gráfica de Empleados registradas en SISA')
          ->dataset('Empleados', User::all()->where('estado_id', '!=', 2)->where('id', '!=', 1))
          ->responsive(true)
          ->elementLabel("Cantidad")
          ->groupByMonth($now, true);

      return view('grafica-mgmt/empleado/index', ['grafica_registro' => $grafica_registro, 'group_municipio' => $group_municipio, 'group_genero' => $group_genero]);
    }
}
