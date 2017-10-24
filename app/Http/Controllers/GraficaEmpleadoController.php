<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Charts;

class GraficaEmpleadoController extends Controller{
		public function __construct() {
				$this->middleware('auth');
		}

		public function index() {
      return view('grafica-mgmt/empleado/index');
    }
}
