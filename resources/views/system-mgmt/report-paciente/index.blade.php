@extends('system-mgmt.report-actividad.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-4">
          <h3 class="box-title">Listado de Pacientes</h3>
        </div>
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report-paciente.excel') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
								<input type="hidden" value="{{$searchingVals['departamento']}}" name="departamento" />
                <input type="hidden" value="{{$searchingVals['municipio']}}" name="municipio" />
                <input type="hidden" value="{{$searchingVals['pago']}}" name="pago" />
                <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"></i>
                     Exportar
                </button>
            </form>
        </div>
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report-paciente.pdf') }}">
                {{ csrf_field() }}
								<input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
								<input type="hidden" value="{{$searchingVals['departamento']}}" name="departamento" />
                <input type="hidden" value="{{$searchingVals['municipio']}}" name="municipio" />
                <input type="hidden" value="{{$searchingVals['pago']}}" name="pago" />
                <button type="submit" class="btn btn-info"><i class="fa fa-file-pdf-o"></i>
                     Exportar
                </button>
            </form>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ route('report-paciente.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Buscar'])
				 <div class="row">
					 <table class="table responsive">
						 <tr>
							 <td>
								 <label class="col-md-2 control-label">De</label>
								 <div class="col-md-5">
										 <div class="input-group date">
												 <div class="input-group-addon">
														 <i class="fa fa-calendar"></i>
												 </div>
												 <input type="text" value="{{$searchingVals['from']}}" name="from" class="form-control pull-right" id="from" placeholder="Fecha Ingreso">
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
												 <input type="text" value="{{$searchingVals['to']}}" name="to" class="form-control pull-right" id="to" placeholder="Fecha Ingreso">
										 </div>
								 </div>
						 	 </td>
						 </tr>
						 <tr>
							 <td>
								 <label class="col-md-2 control-label">Departamento</label>
                     <div class="col-md-6">
                         <select class="form-control" name="departamento_id" id="departamento_id">
                             <option value="" selected>Ningun Departamento Seleccionado</option>
                             @foreach ($departamentos as $departamento)
                                 <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                             @endforeach
                         </select>
                     </div>
							 </td>
							 <td>
								 <label class="col-md-2 control-label">Municipio</label>
                     <div class="col-md-6">
                         <select class="form-control" name="municipio_id" id="municipio_id">
                             <option value="" selected>Ningun Municipio Seleccionado</option>
                             @foreach ($municipios as $municipio)
                                 <option value="{{$municipio->id}}">{{$municipio->nombre}}</option>
                             @endforeach
                         </select>
                     </div>
							 </td>
						 </tr>
						 <tr>
							 <td>
								 <label class="col-md-2 control-label">Tipo de Pago</label>
                     <div class="col-md-5">
                         <select class="form-control" name="pago_id" id="pago_id">
                             <option value="" selected>Ningun Pago Seleccionado</option>
                             @foreach ($pagos as $pago)
                                 <option value="{{$pago->id}}">{{$pago->nombre}}</option>
                             @endforeach
                         </select>
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
                <th width = "15%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column ascending">Nombre del Paciente</th>
                <th width = "5%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column ascending">Departamento</th>
                <th width = "5%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column ascending">Municipio</th>
                <th width = "5%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column ascending">Pago</th>
                <th width = "5%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Fecha: activate to sort column ascending">Fecha Ingreso</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($pacientes as $paciente)
                <tr role="row" class="odd">
                  <td>{{ $paciente['nombre1'] }} {{ $paciente['nombre2'] }} {{ $paciente['nombre3'] }} {{ $paciente['apellido1'] }} {{ $paciente['apellido2'] }} {{ $paciente['apellido3'] }}</td>
                  <td>{{ $paciente['Departamento'] }}</td>
                  <td>{{ $paciente['Municipio'] }}</td>
                  <td>{{ $paciente['Pago'] }}</td>
                  <td>{{ $paciente['fecha_ingreso'] }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Registros mostrados {{count($pacientes)}}, registros existentes {{count($pacientes)}}</div></div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  </div>
@endsection
