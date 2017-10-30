<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Municipio;

class MunicipioController extends Controller {
	public function getMunicipio(Request $request, $id2){
			if($request->ajax()){
				$municipios = Municipio::buscar($id2);
				return response()->json($municipios);
			}
	}
}
