<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Actividad;
use App\User;
use App\Paciente;
use App\Medico;
use App\Departamento;
use Charts;

class DashboardController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
      date_default_timezone_set('america/guatemala');
      $format = 'd/m/Y';
      $now = date($format);

    	$count_user = User::where('estado_id', '!=', 2)->where('id', '!=', 1)->count();
      $count_paci = Paciente::where('id', '!=', 1)->count();
      $count_medi = Medico::where('id', '!=', 1)->count();

      $grafica_actividades = Charts::database(Actividad::all(), 'bar', 'highcharts')
          ->title('Actividades')
          ->template('teal-material')
          ->elementLabel("Total")
          ->dimensions(5, 5)
          ->responsive(true)
          ->groupBy('fecha');

      $grafica_registro = Charts::multiDatabase('line', 'material')
          ->title('Gráfica de Empleado, Paciente y Médico registrados en SISA')
        ->dataset('Empleados', User::all())
        ->dataset('Pacientes', Paciente::all())
        ->dataset('Médicos', Medico::all())
        ->groupByMonth(2017, true);

      return view('dashboard', ['count_user' => $count_user, 'count_paci' => $count_paci, 'count_medi' => $count_medi, 'grafica_actividades' => $grafica_actividades, 'grafica_registro' => $grafica_registro]);
    }
}
