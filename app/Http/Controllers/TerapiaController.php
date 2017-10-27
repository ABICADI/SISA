<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Terapia;
use App\Bitacora;
use App\Cita;
use Auth;

class TerapiaController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $terapias = DB::table('terapias')
        ->select('terapias.*')->orderBy('nombre', 'asc')->paginate(10);
        return view('system-mgmt/terapia/index', ['terapias' => $terapias]);
    }

    public function create() {
        return view('system-mgmt/terapia/create');
    }

    public function store(Request $request) {
        //Validamos Campos del Formulario
        $this->validateInput($request);

        //Nuevo Forma de Inserta Datos
        $terapia = new Terapia();
        $terapia->nombre = $request["nombre"];
        $terapia->descripcion = $request["descripcion"];
        $terapia->color = $request["color"];

        //Si la terapia se guarda, se crea un registro en la Bitacora
        if($terapia->save()) {
            $this->crearTerapiaBitacora($request);
            return redirect()->intended('system-management/terapia');
        }
    }

    public function edit($id) {
        //Capturamos el ID seleccionado para la Actualizacion
        $terapia = Terapia::find($id);

        //Si la terapia seleccionada no tiene datos redireccionamos a la pagina principal de la Terapia
        if ($terapia == null || count($terapia) == 0) {
            return redirect()->intended('/system-management/terapia');
        }
        return view('system-mgmt/terapia/edit', ['terapia' => $terapia]);
    }

    public function update(Request $request, $id) {
        //Nueva Forma de Insertar Datos
        $terapia = Terapia::findOrFail($id);
        $citas = DB::table('citas')->select('citas.*')->where('citas.color', '=', $terapia->color)->get();
        //Validamos Datos del Formulario
        $this->validateUpdate($request);
        $terapia->descripcion = $request["descripcion"];
        $terapia->color = $request["color"];
        $this->updateTerapiaBitacora($request, $id);
        if($terapia->save()){
            foreach ($citas as &$cita) {
                $update_cita = Cita::findOrFail($cita->id);
                $update_cita->start = $cita->start;
                $update_cita->title = $cita->title;
                $update_cita->color = $request["color"];
                $update_cita->tratamiento_id = $cita->tratamiento_id;
                $update_cita->save();
            }
        }
        return redirect()->intended('system-management/terapia');
    }

    public function search(Request $request) {
        $constraints = [
            'nombre' => $request['nombre']
            ];

       $terapias = $this->doSearchingQuery($constraints);
       return view('system-mgmt/terapia/index', ['terapias' => $terapias, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Terapia::query();
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

    private function validateInput($request) {
        $this->validate($request, [
        'nombre' => 'required|max:30|unique:terapias',
        'descripcion' => 'max:500',
        'color' => 'required|unique:terapias'
        ]);
    }

    private function validateUpdate($request) {
        $this->validate($request, [
        'descripcion' => 'max:500',
        'color' => 'required'
        ]);
    }

    private function crearTerapiaBitacora(Request $request){
        //Datos para la Bitacora
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $user = Auth::user()->username;
        $data = 'Nombre: ' . $request->nombre . ', Descripción: ' . $request->descripcion;

            $bitacora = new Bitacora();
            $bitacora->usuario = $user;
            $bitacora->nombre_tabla = 'TERAPIA';
            $bitacora->actividad = 'CREAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            $bitacora->save();
    }

    private function updateTerapiaBitacora($request, $id){
        //Datos para la Bitacora
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $user = Auth::user()->username;
        $terapia1 = Terapia::find($id);

            if ($terapia1->descripcion != $request['descripcion']) {
                $bitacora = new Bitacora();
                $bitacora->usuario = $user;
                $bitacora->nombre_tabla = 'TERAPIA';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Descripción: ' . $terapia1->descripcion;
                $bitacora->nuevo = 'Descripción: ' . $request->descripcion;
                $bitacora->fecha = $now;
                $bitacora->save();
            }
    }
}
