@extends('system-mgmt.terapia.base')
@if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">Mostrar Terapias</h3>
        </div>
        @if (1 == Auth::user()->rol_id)
        <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ route('terapia.create') }}"><i class="glyphicon glyphicon-plus-sign"></i> Nueva Terapia</a>
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
      <form method="POST" action="{{ route('terapia.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Buscar'])
          @component('layouts.two-cols-search-row', ['items' => ['Nombre'],
          'oldVals' => [isset($searchingVals) ? strtoupper($searchingVals['nombre']) : '']])
          @endcomponent
        @endcomponent
      </form>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th width="20%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="terapia: activate to sort column ascending">Nombre</th>
                <th width="40%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="terapia: activate to sort column ascending">Descripcion</th>
                <th width="10%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="terapia: activate to sort column ascending">Color</th>
                <th tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending">Opciones</th>
              </tr>
            </thead>
            <tbody>
            {{$terapias}}
            @foreach ($terapias as $terapia)
                <tr role="row" class="odd">
                  <td>{{ $terapia->nombre }}</td>
                  <td>{{ $terapia->descripcion }}</td>
                  <td><a class="btn btn-warning col-sm-4 col-xs-5 btn-margin" style="background-color:{{ $terapia->color }}"><i class="fa fa-paint-brush"></i></a></td>
                  <td>
                      @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
                        <a href="{{ route('terapia.edit', ['id' => $terapia->id]) }}" class="btn btn-warning col-sm-2 col-xs-5 btn-margin"><i class="fa fa-edit"></i></a>
                      @endif
                  </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Registros mostrados {{count($terapias)}}, registros existentes{{count($terapias)}}</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $terapias->links() }}
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
