<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tratamiento;
use Charts;

class GraficaTratamientoController extends Controller{
		public function __construct() {
				$this->middleware('auth');
		}

		public function index() {
			date_default_timezone_set('america/guatemala');
			$format = 'Y';
			$now = date($format);

			$fisioterapia = Tratamiento::where('terapia_id', '=', 2)->get();
			$terapia_lenguaje = Tratamiento::where('terapia_id', '=', 3)->get();
			$terapia_ocupacional = Tratamiento::where('terapia_id', '=', 4)->get();
			$educacion_especial = Tratamiento::where('terapia_id', '=', 5)->get();
			$mecanoterapia = Tratamiento::where('terapia_id', '=', 6)->get();

			$grafica_terapia = Charts::multiDatabase('bar', 'highcharts')
					->title('Gráfica de Tratamientos por terapia registradas en SISA')
					->dataset('Fisioterapia', $fisioterapia)
					->dataset('Terapia de Lenguaje', $terapia_lenguaje)
					->dataset('Terapia Ocupacional', $terapia_ocupacional)
					->dataset('Educación Especial', $educacion_especial)
					->dataset('Mecanoterapia', $mecanoterapia)
					->responsive(true)
					->dimensions(10, 5)
					->elementLabel("Cantidad")
					->colors(['#00a01c', '#009b95', '#f1b401', '#2e3ec7', '#222d32'])
					->groupByMonth($now, true);

			$grafica_registro = Charts::multiDatabase('line', 'highcharts')
          ->title('Gráfica de Tratamientos registrados en SISA')
          ->dataset('Tratamientos', Tratamiento::all())
          ->responsive(true)
          ->elementLabel("Cantidad")
          ->groupByMonth($now, true);

      return view('grafica-mgmt/tratamiento/index',['grafica_registro' => $grafica_registro, 'grafica_terapia' => $grafica_terapia]);
    }
}
