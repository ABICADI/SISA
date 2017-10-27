<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tratamiento;

class TratamientoCalendarioController extends Controller {
	protected $redirectTo = '/tratamientocalendario'; //redirecciona la ruta

	public function __construct() {
			$this->middleware('auth');
	}

	/*public function index()	{
			return view('tratamientocalendario-mgmt/index');
	}*/

	public function store(Request $request)	{
			$tratamiento = tratamiento::find($request->id);
			return view('tratamientocalendario-mgmt/edit', ['tratamiento' => $tratamiento]);
	}
}
