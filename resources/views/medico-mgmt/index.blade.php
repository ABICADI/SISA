@extends('medico-mgmt.base')
@if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">Mostrar Médico</h3>
        </div>
        @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
        <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ route('medico-management.create') }}"><i class="glyphicon glyphicon-plus-sign"></i> Nuevo Medico</a>
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
      <form method="POST" action="{{ route('medico-management.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Buscar'])
            <div class="col-md-5">
              <input id="nombre1" type="text" class="form-control" placeholder="buscar por Nombre/Colegiado/Telefono" name="nombre1" value="{{ old('nombre1') }}"  onKeyUp="this.value=this.value.toUpperCase();" >     
            </div> 
         @endcomponent
      </form>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th width="5%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Colegiado</th>
                <th width="30%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Puesto: activate to sort column ascending">Nombre</th>
                <th width="5%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Teléfono</th>
                <th width="10%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Opciones</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($medicos as $medico)
                <tr role="row" class="odd">
                  <td class="sorting_1">{{ $medico->colegiado }}</td>
                  <td class="hidden-xs">{{ $medico->nombre }}</td>
                  <td class="hidden-xs">{{ $medico->telefono }}</td>
                  <td>
                        <input type="hidden" name="_token" onKeyUp="this.value=this.value.toUpperCase();" value="{{ csrf_token() }}">
                        @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
                        <a href="{{ route('medico-management.edit', ['id' => $medico->id]) }}" class="btn btn-warning col-sm-3 col-xs-2 btn-margin"><i class="fa fa-edit"></i>
                        </a>
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
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Registros mostrados {{count($medicos)}}, registros existentes {{count($medicos)}}</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $medicos->links() }}
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
@endif
