@extends('paciente-mgmt.base')
@if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">Mostrar Paciente</h3>
        </div>
        @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
        <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ route('paciente-management.create') }}"><i class="glyphicon glyphicon-plus-sign"></i> Nuevo Paciente</a>
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
      <form method="POST" action="{{ route('paciente-management.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Buscar'])
          @component('layouts.two-cols-search-row', ['items' => ['Nombre1', 'CUI'],
          'oldVals' => [isset($searchingVals) ? strtoupper($searchingVals['nombre1']) : '', isset($searchingVals) ? $searchingVals['cui'] : '']])
          @endcomponent
        @endcomponent
      </form>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th width="5%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">No. Registro</th>
                <th width="40%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Puesto: activate to sort column ascending">Nombre</th>
                <th width="10%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Género</th>
                <th width="15%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Opciones</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($pacientes as $paciente)
                <tr role="row" class="odd">
                  <td class="sorting_1">{{ $paciente->seguro_social }}</td>
                  <td class="sorting_1">{{ $paciente->nombre1 }} {{ $paciente->nombre2 }} {{ $paciente->nombre3 }} {{ $paciente->apellido1 }} {{ $paciente->apellido2 }} {{ $paciente->apellido3 }}</td>
                  <td class="sorting_1 hidden-xs">{{ $paciente->Genero }}</td>
                  <td>
                        <input type="hidden" name="_token" onKeyUp="this.value=this.value.toUpperCase();" value="{{ csrf_token() }}">
                        @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
                        <a href="{{ route('paciente-management.edit', ['id' => $paciente->id]) }}" class="btn btn-warning col-sm-2 col-xs-3 btn-margin"><i class="fa fa-edit"></i>
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
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Registros mostrados {{count($pacientes)}}, registros existentes {{count($pacientes)}}</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $pacientes->links() }}
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
