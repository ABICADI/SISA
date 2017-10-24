<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Bitacora;

class BitacoraController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {

        $bitacoras = DB::table('bitacoras')->orderBy('fecha', 'desc')->paginate(10);
        return view('system-mgmt/bitacora/index', ['bitacoras' => $bitacoras]);
    }

    public function search(Request $request) {
        $constraints = [
            'usuario' => $request['usuario'],
            'actividad' => $request['actividad'],
            'fecha' => $request['fecha'],
            'nombre_tabla' => $request['nombre_tabla'],
            ];


       $bitacoras = $this->doSearchingQuery($constraints);
       return view('system-mgmt/bitacora/index', ['bitacoras' => $bitacoras, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Bitacora::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(10);
    }
}
