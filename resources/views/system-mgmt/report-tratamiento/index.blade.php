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
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report-tratamiento.excel') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['medico']}}" name="medico" />
                <input type="hidden" value="{{$searchingVals['terapia']}}" name="terapia" />
                <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"></i>
                     Exportar
                </button>
            </form>
        </div>
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report-tratamiento.pdf') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['medico']}}" name="medico" />
                <input type="hidden" value="{{$searchingVals['terapia']}}" name="terapia" />
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
      <form method="POST" action="{{ route('report-tratamiento.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Buscar'])
				 <div class="row">
					 <table class="table responsive">
						 <tr>
							 <td>
								 <label class="col-md-2 control-label">Médico</label>
                     <div class="col-md-6">
                         <select class="form-control" name="medico_id" id="medico_id">
                             <option value="" selected>Ningun Médico Seleccionado</option>
                             @foreach ($medicos as $medico)
                                 <option value="{{$medico->id}}">{{$medico->nombre}}</option>
                             @endforeach
                         </select>
                     </div>
							 </td>
							 <td>
								 <label class="col-md-2 control-label">Terapia</label>
                     <div class="col-md-6">
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
                <th width = "30%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column ascending">Nombre del Paciente</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($tratamientos as $tratamiento)
                <tr role="row" class="odd">
                  <td>{{ $tratamiento['paciente_id'] }}</td>
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
