@extends('system-mgmt.bitacora.base')
@if (1 == Auth::user()->rol_id)
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">Mostrar Bitacora</h3>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  @if (1 == Auth::user()->rol_id)
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      @if (1 == Auth::user()->rol_id)
      <form method="POST" action="{{ route('bitacora.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Buscar'])
          @component('layouts.two-cols-search-row', ['items' => ['Usuario', 'Actividad', 'Nombre_Tabla'],
          'oldVals' => [isset($searchingVals) ? strtoupper($searchingVals['usuario']) : '', isset($searchingVals) ? strtoupper($searchingVals['actividad']) : '', isset($searchingVals) ? strtoupper($searchingVals['nombre_tabla']) : '']])
          @endcomponent
          @component('layouts.two-cols-date-search-row', ['items' => ['Fecha'],
          'oldVals' => [isset($searchingVals) ? $searchingVals['fecha'] : '']])
          @endcomponent
        @endcomponent
      </form>
      @endif
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th width="20%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="rol: activate to sort column ascending">Usuario</th>
                <th width="20%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="rol: activate to sort column ascending">Nombre Tabla</th>
                <th width="20%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="rol: activate to sort column ascending">Actividad</th>
                <th width="20%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="rol: activate to sort column ascending">Dato Anterior</th>
                <th width="20%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="rol: activate to sort column ascending">Dato Nuevo</th>
                <th width="20%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="rol: activate to sort column ascending">Fecha</th>
              </tr>
            </thead>
            <tbody>
            {{$bitacoras}}
            @foreach ($bitacoras as $bitacora)
                <tr role="row" class="odd">
                  <td>{{ $bitacora->usuario }}</td>
                  <td>{{ $bitacora->nombre_tabla }}</td>
                  <td>{{ $bitacora->actividad }}</td>
                  <td>{{ $bitacora->anterior }}</td>
                  <td>{{ $bitacora->nuevo }}</td>
                  <td>{{ $bitacora->fecha }}</td>
              </tr>
            @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th width="20%" rowspan="1" colspan="1">Usuario</th>
                <th width="20%" rowspan="1" colspan="1">Nombre Tabla</th>
                <th width="20%" rowspan="1" colspan="1">Actividad</th>
                <th width="20%" rowspan="1" colspan="1">Dato Anterior</th>
                <th width="20%" rowspan="1" colspan="1">Dato Nuevo</th>
                <th width="20%" rowspan="1" colspan="1">Fecha</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Registros mostrados {{count($bitacoras)}}, registros existentes {{count($bitacoras)}}</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $bitacoras->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  </div>
@endsection
@endif
