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
          <table id="example2" class="table table-responsive">
            <tr>
            <td>
            <div>
                    <div>
                        <input id="nombre1" type="text" class="form-control" placeholder="buscar por Usuario/Tabla/Actividad" name="nombre1" value="{{ old('nombre1') }}"  onKeyUp="this.value=this.value.toUpperCase();" >
                    </div>
            </div>
            </td>
            <td>
            <div>
                    <div class="col-md-6">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" value="{{ old('fecha_inicio') }}" placeholder="Inicio" name="fecha_inicio" class="form-control pull-right" id="from">
                        </div>
                    </div>
            </div>
            </td>
            <td>
            <div>
                    <div class="col-md-6">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" value="{{ old('fecha_fin') }}" placeholder="Fin" name="fecha_fin" class="form-control pull-right" id="to">
                        </div>
                    </div>
            </div>
            </td>
            </tr>
        </table>
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
