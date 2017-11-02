<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cita;
use App\Tratamiento;
use Charts;

class GraficaCitaController extends Controller{
		public function __construct() {
				$this->middleware('auth');
		}

		public function index() {
			date_default_timezone_set('america/guatemala');
			$format = 'Y';
			$now = date($format);

			$fisioterapia = Cita::join('tratamientos','citas.tratamiento_id','tratamientos.id')->where('tratamientos.terapia_id', '=', 2)->count('citas.id');
			$terapia_lenguaje = Cita::join('tratamientos','citas.tratamiento_id','tratamientos.id')->where('tratamientos.terapia_id', '=', 3)->count('citas.id');
			$terapia_ocupacional = Cita::join('tratamientos','citas.tratamiento_id','tratamientos.id')->where('tratamientos.terapia_id', '=', 4)->count('citas.id');
			$educacion_especial = Cita::join('tratamientos','citas.tratamiento_id','tratamientos.id')->where('tratamientos.terapia_id', '=', 5)->count('citas.id');
			$mecanoterapia = Cita::join('tratamientos','citas.tratamiento_id','tratamientos.id')->where('tratamientos.terapia_id', '=', 6)->count('citas.id');

			$grafica_terapia = Charts::create('area', 'highcharts')
					->title('Gráfica de Citas por terapias registradas en SISA')
					->labels(['Fisioterapia', 'Terapia de Lenguaje', 'Terapia Ocupacional', 'Educación Especial', 'Mecanoterapia'])
					->values([$fisioterapia,$terapia_lenguaje,$terapia_ocupacional,$educacion_especial,$mecanoterapia])
					->responsive(true)
					->dimensions(10, 5)
					->elementLabel("Cantidad")
					->colors(['#00a01c', '#009b95', '#f1b401', '#2e3ec7', '#222d32']);

			$grafica_registro = Charts::multiDatabase('line', 'highcharts')
          ->title('Gráfica de Citas registradas en SISA')
          ->dataset('Citas', Cita::all())
          ->responsive(true)
          ->elementLabel("Cantidad")
          ->groupByMonth($now, true);

      return view('grafica-mgmt/cita/index',['grafica_registro' => $grafica_registro, 'grafica_terapia' => $grafica_terapia]);
    }
}
