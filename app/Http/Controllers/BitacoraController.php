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
            'nombre1' => strtoupper ($request['nombre1']),
            'fechaInicio' => $request['fecha_inicio'],
            'fechaFin' => $request['fecha_fin']
        ];

        //dd($constraints);
  
        $nombre = strtoupper($request['nombre1']);
        
        $fechaInicio = $request['fecha_inicio'];
        $fechaFin = $request['fecha_fin'];

        if($request['nombre1']!=''){
          $bitacoras = DB::table('bitacoras')
            ->select(DB::raw('*'))
            ->whereRaw("(usuario like '%$nombre%')")
            ->orWhereRaw("(nombre_tabla like '%$nombre%')")
            ->orWhereRaw("(actividad like '%$nombre%')")
            ->paginate(10);
        } 

          else if($this->validar_fecha($fechaInicio)
            &&$this->validar_fecha($fechaInicio)){
          $bitacoras = DB::table('bitacoras')
            ->select(DB::raw('*'))
            ->whereRaw("(fecha::text like '%$fechaInicio%')")
            ->whereRaw("(fecha::text like '%$fechaFin%')")
            ->orWhereBetween('fecha', [$fechaInicio, $fechaFin])
            ->paginate(10);
          }
          else{
            $bitacoras = DB::table('bitacoras')
            ->select(DB::raw('*'))
            ->paginate(10);
          }
        //dd($bitacoras);
        $message = ' ';
        return view('system-mgmt/bitacora/index', ['bitacoras' => $bitacoras, 'searchingVals' => $constraints]);
    }

    private function validar_fecha($fecha){
      $valores = explode('-', $fecha);
      if((count($valores) == 3 && checkdate($valores[2], $valores[1], $valores[0]))
        ||($fecha==null)) return true;
        return false;
    }
}
