<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class CalendarioController extends Controller {
	protected $redirectTo = '/sisa/calendario'; //redirecciona la ruta

	public function __construct() {
			$this->middleware('auth');
	}

	public function index()	{
			return view('calendario-mgmt/index');
	}
}
