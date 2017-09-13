@extends('actividad-mgmt.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">Mostrar Actividad</h3>
        </div>
        @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
        <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ route('actividad-management.create') }}"><i class="glyphicon glyphicon-plus-sign"></i> Nueva Actividad</a>
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
      <form method="POST" action="{{ route('actividad-management.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Buscar'])
          @component('layouts.two-cols-search-row', ['items' => ['Nombre de la Actividad'], 
          'oldVals' => [isset($searchingVals) ? $searchingVals['nombre'] : '']])
          @endcomponent
        @endcomponent
      </form>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th width="20%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Puesto: activate to sort column ascending">Nombre de la Actividad</th>
                <th width="20%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Puesto: activate to sort column ascending">Presona Encargada</th>
                <th width="20%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Puesto: activate to sort column ascending">Lugar de la Actividad</th>
                <th width="10%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Fecha</th>
                <th tabindex="0" aria-controls="example2" rowspan="1" colspan="3" aria-label="Action: activate to sort column ascending">Opciones</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($actividades as $actividad)
                <tr role="row" class="odd">
                  <td class="sorting_1">{{ $actividad->nombre }}</td>
                  <td class="sorting_1">{{ $actividad->users_nombre1 }} {{ $actividad->users_nombre2 }} {{ $actividad->users_nombre3 }} {{ $actividad->users_apellido1 }} {{ $actividad->users_apellido2 }} {{ $actividad->users_apellido3 }}</td>
                  <td class="hidden-xs">{{ $actividad->departamentos_nombre }} {{ $actividad->municipios_nombre }} {{ $actividad->direccion }}</td>
                  <td class="hidden-xs">{{ $actividad->fecha }}</td>
                  <td>
                    <form class="row" method="POST" action="{{ route('actividad-management.destroy', ['id' => $actividad->id]) }}" onsubmit = "return confirm('¿Está seguro que quiere eliminar a el registro?')">
     
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
                        <a href="{{ route('actividad-management.edit', ['id' => $actividad->id]) }}" class="btn btn-warning col-sm-3 col-xs-2 btn-margin"><i class="fa fa-edit"></i></a>
                        @endif
                        @if (2 != Auth::user()->rol_id)
                        <a href="{{ route('actividad-management.view', ['id' => $actividad->id]) }}" class="btn btn-default col-sm-3 col-xs-2 btn-margin" style="background-color:#009e0f"><i class="fa fa-eye"></i></a>
                        @endif
                        @if (1 == Auth::user()->rol_id)
                         <button type="submit" class="btn btn-danger col-sm-3 col-xs-2 btn-margin"><i class="fa fa-trash-o"></i> 
                        </button>
                        @endif
                    </form>
                  </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Registros mostrados {{count($actividades)}}, registros existentes {{count($actividades)}}</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $actividades->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  </div>
@endsection