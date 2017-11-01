@extends('users-mgmt.base')
@if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">Mostrar Empleado</h3>
        </div>
        @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
        <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ route('user-management.create') }}"><i class="glyphicon glyphicon-plus-sign"></i> Nuevo Empleado</a>
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
      <form method="POST" action="{{ route('user-management.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Buscar'])
                <label for="nombre1" class="col-md-1 control-label">BUSCAR</label>
                    <div class="col-md-5">
                        <input id="nombre1" type="text" class="form-control" placeholder="buscar por Nombre/DPI/Puesto" name="nombre1" value="{{ old('nombre1') }}"  onKeyUp="this.value=this.value.toUpperCase();" >     
                    </div>
        @endcomponent
      </form>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th width="40%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Puesto: activate to sort column ascending">Nombre</th>
                <th width="10%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">DPI</th>
                <th width="15%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Puesto Encargado</th>
                <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Opciones</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr role="row" class="odd">
                  <td class="sorting_1">{{ $user->nombre1 }} {{ $user->nombre2 }} {{ $user->nombre3 }} {{ $user->apellido1 }} {{ $user->apellido2 }} {{ $user->apellido3 }}</td>
                  <td class="hidden-xs">{{ $user->dpi }}</td>
                  <td class="hidden-xs">{{ $user->nombre }}</td>
                  <td>
                    <form class="row" method="POST" action="{{ route('user-management.destroy', ['id' => $user->id]) }}" onsubmit = "return confirm('¿Está seguro que quiere eliminar a el registro?')">

                        <input type="hidden" name="_method" onKeyUp="this.value=this.value.toUpperCase();" value="DELETE">
                        <input type="hidden" name="_token" onKeyUp="this.value=this.value.toUpperCase();" value="{{ csrf_token() }}">
                        @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
                        <a href="{{ route('dia-terapia-user-management.edit', ['id' => $user->id]) }}" class="btn btn-warning col-sm-2 col-xs-3 btn-margin"><i class="fa fa-edit"></i>
                        </a>
                        @endif
                        @if (4 != Auth::user()->rol_id)
                        <a href="{{ route('user-management.view', ['id' => $user->id]) }}" class="btn btn-default col-sm-2 col-xs-3 btn-margin" style="background-color:#009e0f"><i class="fa fa-eye"></i>
                        </a>
                        @endif
                        @if (1 == Auth::user()->rol_id)
                        @if ($user->username != Auth::user()->username)
                        @if (2 != $user->estado_id)
                        <button type="submit" class="btn btn-danger col-sm-2 col-xs-3 btn-margin"><i class="fa fa-trash-o"></i>
                        </button>
                        @endif
                        @endif
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
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Registros mostrados {{count($users)}}, registros existentes {{count($users)}}</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $users->links() }}
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
