<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Paciente;
use App\Medico;

class DashboardController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
    	$count_user = User::where('estado_id', '!=', 2)->where('id', '!=', 1)->count();
      $count_paci = Paciente::where('id', '!=', 1)->count();
      $count_medi = Medico::where('id', '!=', 1)->count();

        return view('dashboard', ['count_user' => $count_user, 'count_paci' => $count_paci, 'count_medi' => $count_medi]);
    }
}
