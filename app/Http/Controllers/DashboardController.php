<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Actividad;
use App\User;
use App\Paciente;
use App\Medico;
use App\Departamento;
use App\Municipio;
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
      $count_paci = Paciente::all()->count();
      $count_medi = Medico::all()->count();

      $grafica_registro = Charts::multiDatabase('line', 'highcharts')
          ->title('Gráfica de Empleado, Paciente y Médico registrados en SISA')
          ->dataset('Empleados', User::all()->where('estado_id', '!=', 2)->where('id', '!=', 1))
          ->dataset('Pacientes', Paciente::all())
          ->dataset('Médicos', Medico::all())
          ->responsive(true)
          ->elementLabel("Cantidad")
          ->groupByMonth(2017, true);

      return view('dashboard', ['count_user' => $count_user, 'count_paci' => $count_paci, 'count_medi' => $count_medi, 'grafica_registro' => $grafica_registro]);
    }
}
