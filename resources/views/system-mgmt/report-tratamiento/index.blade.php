@extends('system-mgmt.report-tratamiento.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-4">
          <h3 class="box-title">Listado de Tratamientos</h3>
        </div>
        @if($si==0)
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report-tratamiento.excel') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['paciente']}}" name="paciente" />
                <input type="hidden" value="{{$searchingVals['terapia']}}" name="terapia" />
                <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"></i>
                     Exportar
                </button>
            </form>
        </div>
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report-tratamiento.pdf') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['paciente']}}" name="paciente" />
                <input type="hidden" value="{{$searchingVals['terapia']}}" name="terapia" />
                <button type="submit" class="btn btn-info"><i class="fa fa-file-pdf-o"></i>
                     Exportar
                </button>
            </form>
        </div>
    </div>
    @endif
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ route('report-tratamiento.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Buscar'])
				 <div class="row">
					 <table class="table responsive">
						 <tr>
							 <td>
								 <label class="col-md-2 control-label">Paciente</label>
                     <div class="col-md-9">
                         <select class="form-control" name="paciente_id" id="paciente_id">
                             <option value="" selected>Ningun Paciente Seleccionado</option>
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
                             <option value="" selected>Ninguna Terapia Seleccionado</option>
                             @foreach ($terapias as $terapia)
                                 <option value="{{$terapia->id}}">{{$terapia->nombre}}</option>
                             @endforeach
                         </select>
                     </div>
							 </td>
						 </tr>
				 	</table>
				 </div>
         @endcomponent
      </form>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                  <th width = "5%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column ascending">Nombre del No. Registro</th>
                <th width = "15%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column ascending">Nombre del Paciente</th>
                <th width = "15%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column ascending">Nombre del Médico</th>
                <th width = "10%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column ascending">Nombre de la Terapia</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($tratamientos as $tratamientos)
                  <tr role="row" class="odd">
                    <td>{{ $tratamientos['No_Registro'] }}</td>
                    <td>{{ $tratamientos['Nombre1'] }} {{ $tratamientos['Nombre2'] }} {{ $tratamientos['Nombre3'] }}  {{ $tratamientos['Apelllido1'] }} {{ $tratamientos['Apelllido2'] }} {{ $tratamientos['Apelllido3'] }}</td>
                    <td>{{ $tratamientos['Medico'] }}</td>
                    <td>{{ $tratamientos['Terapia'] }}</td>
                </tr>
              @endforeach

            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Registros mostrados {{count($tratamientos)}}, registros existentes {{count($tratamientos)}}</div></div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  </div>
@endsection
