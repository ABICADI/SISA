<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Actividad;
use Excel;
use Auth;
use PDF;

class ReportController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        date_default_timezone_set('america/guatemala');
        $format = 'd/m/Y';
        $now = date($format);
        $to = date($format, strtotime("-30 days"));
        $constraints = [
              'from' => $to,
              'to' => $now,
        ];
        $actividades = $this->getRangoAcitividad($constraints);
        if($actividades->count()==0){
          $si=1;
        }else {
          $si=0;
        }
        $message = '';
        return view('system-mgmt/report-actividad/index', ['actividades' => $actividades, 'searchingVals' => $constraints, 'message' => $message, 'si' => $si]);
    }

    public function search(Request $request) {

        if($request->from != '' && $request->to != ''){
          $constraints = [
              'from' => $request['from'],
              'to' => $request['to']
          ];
          $actividades = $this->getRangoAcitividad($constraints);
          if($actividades->count()==0){
            $si=1;
          }else {
            $si=0;
          }
          $message = '';
          return view('system-mgmt/report-actividad/index', ['actividades' => $actividades, 'searchingVals' => $constraints, 'message' => $message, 'si' => $si]);
        }

        if($request->from == '' || $request->to == ''){
          $constraints = [
              'from' => $request['from'],
              'to' => $request['to']
          ];
          $actividades = $this->getRangoAcitividad($constraints);
          if($actividades->count()==0){
            $si=1;
          }else {
            $si=0;
          }
          $message = 'Rango de Fecha inválido';
          return view('system-mgmt/report-actividad/index', ['actividades' => $actividades, 'searchingVals' => $constraints, 'message' => $message, 'si' => $si]);
        }


    }

    private function getRangoAcitividad($constraints) {
        if($constraints['from'] == '' || $constraints['to'] == ''){
          $actividades = Actividad::join('users', 'actividades.user_id', '=', 'users.id')
                          ->select('actividades.*', 'users.nombre1 as Nombre1', 'users.nombre2 as Nombre2', 'users.nombre3 as Nombre3', 'users.apellido1 as Apellido1', 'users.apellido2 as Apellido2', 'users.apellido3 as Apellido3')
                          ->where('fecha', '>=', '01/01/1850')
                          ->where('fecha', '<=', '01/01/1850')
                          ->get();
          return $actividades;
        }

        if($constraints['from'] != '' && $constraints['to'] != ''){
        $actividades = Actividad::join('users', 'actividades.user_id', '=', 'users.id')
                        ->select('actividades.*', 'users.nombre1 as Nombre1', 'users.nombre2 as Nombre2', 'users.nombre3 as Nombre3', 'users.apellido1 as Apellido1', 'users.apellido2 as Apellido2', 'users.apellido3 as Apellido3')
                        ->where('fecha', '>=', $constraints['from'])
                        ->where('fecha', '<=', $constraints['to'])
                        ->get();
                        //dd($actividades);
        return $actividades;
        }
    }

    public function exportExcel(Request $request) {
        $this->prepareExportingData($request)->export('xlsx');
        redirect()->intended('system-management/report-actividad');
    }

    public function exportPDF(Request $request) {
         $constraints = [
            'from' => $request['from'],
            'to' => $request['to']
        ];
        $actividades = $this->getExportingData($constraints);
        date_default_timezone_set('america/guatemala');
        $format = 'Y-m-d H:i:s';
        $now = date($format);
          if($request['from'] != '' && $request['to'] != ''){
              $title = 'Reporte de Actividades por Rango: de '.$request['from'].' al '.$request['to'];
          }else{
              $title = 'Reporte de Actividades';
          }
        $pdf = PDF::loadView('system-mgmt/report-actividad/pdf', ['actividades' => $actividades, 'searchingVals' => $constraints, 'title' => $title]);
        return $pdf->download('reporte_actividad_'.$now.'.pdf');
        return view('system-mgmt/report-actividad/pdf', ['actividades' => $actividades, 'searchingVals' => $constraints, 'title' => $title]);
    }

    private function prepareExportingData($request) {
        date_default_timezone_set('america/guatemala');
        $format = 'Y-m-d H:i:s';
        $now = date($format);
        $author = Auth::user()->username;
        $actividades = $this->getExportingData(['from'=> $request['from'], 'to' => $request['to']]);
        return Excel::create('reporte_actividad_del_'. $now, function($excel) use($actividades, $request, $author) {
        date_default_timezone_set('america/guatemala');
        $format = 'd-m-Y';
        $now = date($format);
          if($request['from'] != '' && $request['to'] != ''){
              $title = 'Reporte de Actividades por Rango: de '.$request['from'].' al '.$request['to'];
          }else{
              $title = 'Reporte de Actividades';
          }
        $excel->setTitle($title);
        $excel->setCreator($author)
            ->setCompany('HoaDang');
        $excel->setDescription('Listado de Actividades');
        $excel->sheet('Reporte_'.$now, function($sheet) use($actividades) {
        $sheet->fromArray($actividades);
            });
        });
    }

    private function getExportingData($constraints) {
        return DB::table('actividades')
        ->leftJoin('users', 'actividades.user_id', '=', 'users.id')
        ->leftJoin('municipios', 'actividades.municipio_id', '=', 'municipios.id')
        ->leftJoin('departamentos', 'municipios.departamento_id', '=', 'departamentos.id')
        ->select('actividades.nombre as Nombre_Actividad', 'users.nombre1 as Primer_Nombre', 'users.nombre2 as Segundo_Nombre','users.nombre3 as Tercer_Nombre', 'users.apellido1 as Primer_Apellido', 'users.apellido2 as Segundo_Apellido', 'users.apellido3 as Tercer_Apellido', 'users.telefono as Teléfono', 'departamentos.nombre as Departamento', 'municipios.nombre as Municipio', 'actividades.direccion as Dirección', 'actividades.fecha as Fecha', 'actividades.descripcion as Descripción')
        ->where('fecha', '>=', $constraints['from'])
        ->where('fecha', '<=', $constraints['to'])
        ->get()
        ->map(function ($item, $key) {
        return (array) $item;
        })
        ->all();
    }
  }
