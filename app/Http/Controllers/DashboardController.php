<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Paciente;
use App\Medico;
use App\Tratamiento;

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
      $count_trat = Tratamiento::all()->count();

      return view('dashboard', ['count_user' => $count_user, 'count_paci' => $count_paci, 'count_medi' => $count_medi, 'count_trat' => $count_trat]);
    }
}
