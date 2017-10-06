<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Actividad;
use App\User;
use App\Paciente;
use App\Medico;
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

      $chart = Charts::multi('bar', 'material')
          // Setup the chart settings
          ->title("My Cool Chart")
          // A dimension of 0 means it will take 100% of the space
          ->dimensions(0, 400) // Width x Height
          // This defines a preset of colors already done:)
          ->template("material")
          // You could always set them manually
          // ->colors(['#2196F3', '#F44336', '#FFC107'])
          // Setup the diferent datasets (this is a multi chart)
          ->dataset('Element 1', [5,20,100])
          ->dataset('Element 2', [15,30,80])
          ->dataset('Element 3', [25,10,40])
          // Setup what the values mean
          ->labels(['One', 'Two', 'Three']);

      return view('dashboard', ['count_user' => $count_user, 'count_paci' => $count_paci, 'count_medi' => $count_medi, 'chart' => $chart]);
    }
}
