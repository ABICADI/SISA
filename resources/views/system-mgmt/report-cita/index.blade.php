@extends('system-mgmt.report-cita.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-4">
          <h3 class="box-title">Listado de Citas</h3>
        </div>
        @if($si==0)
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report-cita.excel') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
                <input type="hidden" value="{{$searchingVals['terapia']}}" name="terapia" />
                <input type="hidden" value="{{$searchingVals['paciente']}}" name="paciente" />
                <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"></i>
                     Exportar
                </button>
            </form>
        </div>
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report-cita.pdf') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
                <input type="hidden" value="{{$searchingVals['terapia']}}" name="terapia" />
                <input type="hidden" value="{{$searchingVals['paciente']}}" name="paciente" />
                <button type="submit" class="btn btn-info"><i class="fa fa-file-pdf-o"></i>
                     Exportar
                </button>
            </form>
        </div>
        @endif
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ route('report-cita.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Buscar'])
         <table>
             <tr>
               <td  class="col-md-6">
                 <label>De</label>
                 <div>
                     <div class="input-group date">
                         <div class="input-group-addon">
                             <i class="fa fa-calendar"></i>
                         </div>
                         <input type="text" name="from" class="form-control pull-right" id="fromm" placeholder="Inicio">
                     </div>
                 </div>
               </td>
               <td class="col-md-6">
                 <label>Hasta</label>
                 <div>
                     <div class="input-group date">
                         <div class="input-group-addon">
                             <i class="fa fa-calendar"></i>
                         </div>
                         <input type="text" name="to" class="form-control pull-right" id="too" placeholder="Fin">
                     </div>
                 </div>
               </td>
             </tr>
            <div> </div>
             <tr>
               <td>
                 <label class="col-md-2 control-label">Paciente</label>
                     <div class="col-md-10">
                         <select class="form-control" name="paciente_id" id="paciente_id">
                             <option value="0" selected>Ningun Paciente Seleccionado</option>
                             @foreach ($pacientes as $paciente)
                                 <option value="{{$paciente->id}}">{{$paciente->nombre1}} {{$paciente->nombre2}} {{$paciente->nombre3}} {{$paciente->apellido1}} {{$paciente->apellido2}} {{$paciente->apellido3}}</option>
                             @endforeach
                         </select>
                     </div>
               </td>
               <td>
                 <label class="col-md-2 control-label">Terapia</label>
                     <div class="col-md-10">
                         <select class="form-control" name="terapia_id" id="terapia_id">
                             <option value="0" selected>Ninguna Terapia Seleccionada</option>
                             @foreach ($terapias as $terapia)
                                 <option value="{{$terapia->id}}">{{$terapia->nombre}}</option>
                             @endforeach
                         </select>
                     </div>
               </td>
             </tr>
				 	</table>
         @endcomponent
      </form>
      {{ csrf_field() }}
      <label style="color:red">{{ $message }}</label>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column ascending">Nombre del Paciente</th>
                <th width = "10%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column ascending">Terapia</th>
                <th width = "6%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Fecha: activate to sort column ascending">Fecha de Cita</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($citas as $cita)
                <tr role="row" class="odd">
                  <td>{{ $cita['nombre1'] }} {{ $cita['nombre2'] }} {{ $cita['nombre3'] }} {{ $cita['apellido1'] }} {{ $cita['apellido2'] }} {{ $cita['apellido3'] }}</td>
                  <td>{{ $cita['nombre'] }}</td>
                  <td>{{ $cita['start'] }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Registros mostrados {{count($citas)}}, registros existentes {{count($citas)}}</div></div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  </div>
@endsection
