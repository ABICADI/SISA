@extends('system-mgmt.report-actividad.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-4">
          <h3 class="box-title">Listado de Actividades</h3>
        </div>
        @if($si==0)
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report-actividad.excel') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
                <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"></i>
                     Exportar
                </button>
            </form>
        </div>
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report-actividad.pdf') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
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
      <form method="POST" action="{{ route('report-actividad.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Buscar'])
				 <div class="row">
					 <table class="table responsive">
						 <tr>
							 <td>
								 <label class="col-md-2 control-label">De</label>
								 <div class="col-md-7">
										 <div class="input-group date">
												 <div class="input-group-addon">
														 <i class="fa fa-calendar"></i>
												 </div>
												 <input type="text" name="from" value="{{$searchingVals['from']}}" class="form-control pull-right" id="from" placeholder="Fecha Actividad">
										 </div>
								 </div>
						 	 </td>
							 <td>
								 <label class="col-md-2 control-label">Hasta</label>
								 <div class="col-md-6">
										 <div class="input-group date">
												 <div class="input-group-addon">
														 <i class="fa fa-calendar"></i>
												 </div>
												 <input type="text" name="to" value="{{$searchingVals['to']}}" class="form-control pull-right" id="to" placeholder="Fecha Actividad">
										 </div>
								 </div>
						 	 </td>
						 </tr>
				 	</table>
				 </div>
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
                <th width = "10%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column ascending">Nombre de la Actividad</th>
                <th width = "15%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column ascending">Nombre del Encargado</th>
                <th width = "5%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Fecha: activate to sort column ascending">Fecha</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($actividades as $actividad)
                <tr role="row" class="odd">
                  <td>{{ $actividad['nombre'] }}</td>
                  <td>{{ $actividad['Nombre1'] }} {{ $actividad['Nombre2'] }} {{ $actividad['Nombre3'] }} {{ $actividad['Apellido1'] }} {{ $actividad['Apellido2'] }} {{ $actividad['Apellido3'] }}</td>
                  <td>{{ $actividad['fecha'] }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Registros mostrados {{count($actividades)}}, registros existentes {{count($actividades)}}</div></div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  </div>
@endsection
