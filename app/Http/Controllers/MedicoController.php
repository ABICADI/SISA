<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Bitacora;
use App\Medico;
use Auth;

class MedicoController extends Controller {

	protected $redirectTo = '/sisa/medico-management';

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $medicos = DB::table('medicos')
        ->select('medicos.*')->paginate(10);
        return view('medico-mgmt/index', ['medicos' => $medicos]);
    }

    public function create() {
        return view('medico-mgmt/create');
    }

    public function store(Request $request) {
        //Validamos Campos del Formulario
        $this->validateInput($request);

        //Nuevo Forma de Inserta Datos
        $medico = new Medico();
        $medico->colegiado = $request["colegiado"];
        $medico->nombre = strtoupper($request["nombre"]);
        $medico->telefono = $request["telefono"];


        //Si la terapia se guarda, se crea un registro en la Bitacora
        if($medico->save()) {
            $this->crearMedicoBitacora($request);
						Flash('¡El Médico se ha agregado Exitosamente!')->success();
            return redirect()->intended('/sisa/medico-management');
        }
    }

    public function edit($id) {
        //Capturamos el ID seleccionado para la Actualizacion
        $medico = Medico::find($id);

        //Si la terapia seleccionada no tiene datos redireccionamos a la pagina principal de la Terapia
        if ($medico == null || count($medico) == 0) {
						Flash('¡Error al cargar los médicos!')->error();
            return redirect()->intended('/sisa/medico-management');
        }
        return view('medico-mgmt/edit', ['medico' => $medico]);
    }

    public function update(Request $request, $id) {
        //Nueva Forma de Insertar Datos
        $medico = Medico::findOrFail($id);
        //Validamos Datos del Formulario
        $this->validateUpdate($request);
        $medico->colegiado = $request["colegiado"];
        $medico->nombre = strtoupper($request["nombre"]);
        $medico->telefono = $request["telefono"];

        $this->updateMedicoBitacora($request, $id);
        if($medico->save()){
						Flash('¡El Médico se ha actualizado Exitosamente!')->success();
            return redirect()->intended('/sisa/medico-management');
        }
    }

    public function search(Request $request) {
        $constraints = [
            'nombre1' => strtoupper ($request['nombre1'])
        ];
  
        $nombre = strtoupper($request['nombre1']);
        $medicos = DB::table('medicos')
            ->select(DB::raw('*'))
            ->whereRaw("(colegiado like '%$nombre%')")
            ->orWhereRaw("(nombre like '%$nombre%')")
            ->orWhereRaw("(telefono like '%$nombre%')")
            ->paginate(10);
        return view('medico-mgmt/index', ['medicos' => $medicos, 'searchingVals' => $constraints]);
    }

    private function validateInput($request) {
        $this->validate($request, [
        'colegiado' => 'required|max:10|unique:medicos',
        'nombre' => 'max:150|required|unique:medicos',
        'telefono' => 'digits:8|nullable'
        ]);
    }

    private function validateUpdate($request) {
        $this->validate($request, [
        'colegiado' => 'required|max:10',
        'nombre' => 'max:150|required',
        'telefono' => 'digits:8|nullable'
        ]);
    }

    private function crearMedicoBitacora(Request $request){
        //Datos para la Bitacora
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $user = Auth::user()->username;
        $data = 'Colegiado: ' . $request->colegiado.', Nombre: ' . $request->nombre . ', Teléfono: ' . $request->telefono;

            $bitacora = new Bitacora();
            $bitacora->usuario = $user;
            $bitacora->nombre_tabla = 'MEDICO';
            $bitacora->actividad = 'CREAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            $bitacora->save();
    }

    private function updateMedicoBitacora($request, $id){
        //Datos para la Bitacora
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $user = Auth::user()->username;
        $medico = Medico::find($id);

            if ($medico->colegiado != $request['colegiado']) {
                $bitacora = new Bitacora();
                $bitacora->usuario = $user;
                $bitacora->nombre_tabla = 'MEDICO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Colegiado: ' . $medico->colegiado;
                $bitacora->nuevo = 'Colegiado: ' . $request->colegiado;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

						if ($medico->nombre != $request['nombre']) {
                $bitacora = new Bitacora();
                $bitacora->usuario = $user;
                $bitacora->nombre_tabla = 'MEDICO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Nombre: ' . $medico->nombre;
                $bitacora->nuevo = 'Nombre: ' . $request->nombre;
                $bitacora->fecha = $now;
                $bitacora->save();
            }

						if ($medico->telefono != $request['telefono']) {
                $bitacora = new Bitacora();
                $bitacora->usuario = $user;
                $bitacora->nombre_tabla = 'MEDICO';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Teléfono: ' . $medico->telefono;
                $bitacora->nuevo = 'Teléfono: ' . $request->telefono;
                $bitacora->fecha = $now;
                $bitacora->save();
            }
    }
}
