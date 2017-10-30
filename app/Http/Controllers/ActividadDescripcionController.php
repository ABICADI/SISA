<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Actividad;
use App\Bitacora;
use App\Departamento;
use App\Municipio;
use App\User;
use Auth;

class ActividadDescripcionController extends Controller {

    public function update(Request $request, $id) {
        $actividad = Actividad::findOrFail($id);

        $this->validateDes($request);
        $actividad->descripcion = $request['descripcion'];
        $this->updateDesActividadBitacora($request, $id);
            if($actividad->save()){
                Flash('¡La Descripción de la Actividad se ha actualizado Exitosamente!')->success();
                return redirect()->intended('/actividad-management');
            }
    }

    private function validateDes($request) {
        $this->validate($request, [
            'descripcion' => 'max:250',
        ]);
    }

    private function updateDesActividadBitacora($request, $id){
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $log = Auth::user()->username;
        $actividad = Actividad::findOrFail($id);

        if($actividad->descripcion != $request['descripcion']){
            $bitacora = new Bitacora();
            $bitacora->usuario = $log;
            $bitacora->nombre_tabla = 'ACTIVIDAD';
            $bitacora->actividad = 'ACTUALIZAR';
            $bitacora->anterior = 'Descripcion: ' . $actividad->descripcion;
            $bitacora->nuevo = 'Descripcion: ' . $request->descripcion;
            $bitacora->fecha = $now;
            $bitacora->save();
        }
    }
}
