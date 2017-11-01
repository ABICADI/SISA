@extends('users-mgmt.base')
@if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-47 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Ver Empleado</div>
                <div class="panel-body">

                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        @component('layouts.esconder_info', ['title' => 'Nombre y Apellido'])
        <table id="example2" class="table table-responsive">
            <tr>
            <td>
            <div class="form-group">
                <label for="dpi" class="col-md-6 control-label"><label style="color:red">*</label> DPI</label>
                    <div class="col-md-6">
                        <input id="dpi" type="text" class="form-control" name="dpi" value="{{ $user->dpi }}" disabled>
                    </div>
            </div>
            </td>
            </tr>
            <tr>
            <td>
            <div class="form-group">
                <label for="nombre1" class="col-md-6 control-label"><label style="color:red">*</label> Primer Nombre</label>
                    <div class="col-md-5">
                        <input id="nombre1" type="text" class="form-control" placeholder="primer nombre" name="nombre1" value="{{ $user->nombre1 }}" disabled>
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group">
                <label for="nombre2" class="col-md-6 control-label">Segundo Nombre</label>

                    <div class="col-md-5">
                        <input id="nombre2" type="text" class="form-control" placeholder="segundo nombre" name="nombre2" value="{{ $user->nombre2 }}"" disabled>
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group">
                <label for="nombre3" class="col-md-6 control-label">Tercer Nombre</label>

                    <div class="col-md-5">
                        <input id="nombre3" type="text" class="form-control" placeholder="tercer nombre" name="nombre3" value="{{ $user->nombre3 }}" disabled>
                    </div>
            </div>
            </td>
            </tr>
            <tr>
            <td>
            <div class="form-group">
                <label for="apellido1" class="col-md-6 control-label"><label style="color:red">*</label> Primer Apellido</label>
                    <div class="col-md-5">
                        <input id="apellido1" type="text" class="form-control" placeholder="primer apellido" name="apellido1" value="{{ $user->apellido1 }}" disabled>

                    </div>
            </div>
            </td>
            <td>
            <div class="form-group">
                <label for="apellido2" class="col-md-6 control-label">Segundo Apellido</label>

                    <div class="col-md-5">
                        <input id="apellido2" type="text" class="form-control" placeholder="segundo apellido" name="apellido2" value="{{ $user->apellido2 }}" disabled>
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group">
                <label for="apellido3" class="col-md-6 control-label">Tercer Apellido</label>

                    <div class="col-md-5">
                        <input id="apellido3" type="text" class="form-control" placeholder="tercer apellido" name="apellido3" value="{{ $user->apellido3 }}" disabled>
                    </div>
            </div>
            </td>
            </tr>
        </div>
        </table>
        @endcomponent

        @component('layouts.esconder_info', ['title' => 'Datos de la Cuenta'])
        <table id="example2" class="table table-responsive">
            <tr>
            <td>
            <div class="form-group">
                <label for="username" class="col-md-4 control-label"><label style="color:red">*</label> Usuario</label>

                    <div class="col-md-6">
                        <input id="username" type="text" class="form-control" placeholder="usuario" name="username" value="{{ $user->username }}" disabled="">
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group">
                <label for="email" class="col-md-4 control-label">Correo Electrónico</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" disabled>
                    </div>
            </div>
            </td>
            </tr>
        </table>
        @endcomponent

        @component('layouts.esconder_info', ['title' => 'Dirección'])
        <table id="example2" class="table table-responsive">
            <tr>
            <td>
            <div class="form-group">
                <label class="col-md-5 control-label"><label style="color:red">*</label> Departamento</label>
                    <div class="col-md-6">
                        <select class="form-control" name="departamento_id" disabled>
                            @foreach ($departamentos as $departamento)
                                <option value="{{$departamento->id}}" {{$departamento->id == $user->departamento_id ? 'selected' : ''}}>{{$departamento->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group">
                <label class="col-md-5 control-label"><label style="color:red">*</label> Municipio</label>
                    <div class="col-md-6">
                        <select class="form-control" name="municipio_id" disabled>
                            @foreach ($municipios as $municipio)
                                <option value="{{$municipio->id}}" {{$municipio->id == $user->municipio_id ? 'selected' : ''}}>{{$municipio->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group">
                <label for="direccion" class="col-md-3 control-label">Dirección</label>

                    <div class="col-md-8">
                        <input id="direccion" type="text" class="form-control" name="direccion" value="{{ $user->direccion }}" disabled>
                    </div>
            </div>
            </td>
            </tr>
        </table>
        @endcomponent

        @component('layouts.esconder_info', ['title' => 'Datos Personales'])
        <table id="example2" class="table table-responsive">
            <tr>
            <td>
            <div class="form-group">
                <label class="col-md-5 control-label"><label style="color:red">*</label> Fecha de Nacimiento</label>
                    <div class="col-md-5">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" value="{{ $user->fecha_nacimiento }}" name="fecha_nacimiento" class="form-control pull-right" id="fechaNacimiento" disabled>
                        </div>
                    </div>
            </div>
            </td>
            <td>
                <label for="edad" class="col-md-3 control-label">Edad</label>

                    <div class="col-md-3">
                        <input id="edad" type="text" class="form-control" name="edad" disabled="">
                            <script type="text/javascript">
                                var fechaNac = document.getElementById("fechaNacimiento").value;
                                var fechaHoy = new Date();
                                var anioNac = parseInt(fechaNac.substring(fechaNac.lastIndexOf('/')+1));
                                var mesNac = parseInt(fechaNac.substr(fechaNac.indexOf('/')+1,fechaNac.lastIndexOf('/')+1));
                                var diaNac = parseInt(fechaNac.substr(0,fechaNac.lastIndexOf('/')+1));
                                var edad = parseInt(fechaHoy.getFullYear())-anioNac;
                                if(edad)
                                    if(mesNac<=parseInt(fechaHoy.getMonth()+1))
                                        document.getElementById("edad").value=edad;
                                    else
                                        document.getElementById("edad").value=edad-1;
                            </script>
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group">
                <label for="telefono" class="col-md-4 control-label">Teléfono</label>

                    <div class="col-md-6">
                        <input id="telefono" type="text" class="form-control" placeholder="00000000" name="telefono" value="{{ $user->telefono }}" disabled>
                    </div>
            </div>
            </td>
            </tr>
            <tr>
            <td>
              <div class="form-group">
                  <label class="col-md-5 control-label"><label style="color:red">*</label> Género</label>
                      <div class="col-md-7">
                          <select class="form-control" name="genero_id" disabled>
                              @foreach ($generos as $genero)
                                  <option value="{{$genero->id}}" {{$genero->id == $user->genero_id ? 'selected' : ''}}>{{$genero->nombre}}</option>
                              @endforeach
                          </select>
                      </div>
              </div>
            </td>
            </tr>
        </table>
        @endcomponent

        @component('layouts.esconder_info', ['title' => 'Datos Laborales'])
        <table id="example2" class="table table-responsive">
            <tr>
            <td>
            <div class="form-group">
                <label class="col-md-4 control-label"><label style="color:red">*</label> Fecha de Ingreso</label>
                    <div class="col-md-5">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" value="{{ $user->fecha_ingreso }}" name="fecha_ingreso" class="form-control pull-right" id="fechaIngreso" disabled>
                        </div>
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group">
                <label class="col-md-5 control-label"><label style="color:red">*</label> Puesto Encargado</label>
                    <div class="col-md-7">
                        <select class="form-control" name="municipio_id" disabled>
                            @foreach ($rols as $rol)
                                <option value="{{$rol->id}}" {{$rol->id == $user->rol_id ? 'selected' : ''}}>{{$rol->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group">
                <label class="col-md-5 control-label"><label style="color:red">*</label> Estado</label>
                    <div class="col-md-7">
                        <select class="form-control" name="estado_id" disabled>
                            @foreach ($estados as $estado)
                                <option value="{{$estado->id}}" {{$estado->id == $user->estado_id ? 'selected' : ''}}>{{$estado->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            </td>
            </tr>
        </table>
        @endcomponent

                </div>
            </div>
        </div>
    </div>

        <div class="row">
                <div class="col-md-47 col-md-offset-0">
                    <div class="panel panel-default">
                        @component('layouts.esconder_info', ['title' => 'Dias a Laborar'])
                        <div class="panel-body">

                                <div class="form-group">
                                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <table id="example2" class="table table-responsive" role="grid" aria-describedby="example2_info">
                                                @foreach ($userdiasemanas as $userdiasemana)
                                                    <tr>
                                    <td role="row"><label id="label1" name="userdiasemanas[]" disabled>{{ $userdiasemana->diasemana_nombre }}</label></td>
                                                    </tr>
                                                @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        @endcomponent
                    </div>
                </div>
            </div>

        <div class="row">
                <div class="col-md-47 col-md-offset-0">
                    <div class="panel panel-default">
                        @component('layouts.esconder_info', ['title' => 'Areas a Laborar'])
                        <div class="panel-body">

                                <div class="form-group">
                                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <table id="example2" class="table table-responsive" role="grid" aria-describedby="example2_info">
                                                @foreach ($usuarioterapias as $usuarioterapia)
                                                    <tr>
                                    <td role="row"><label id="label1" name="usuarioterapias[]" disabled>{{ $usuarioterapia->terapia_nombre }}</label></td>
                                                    </tr>
                                                @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        @endcomponent
                    </div>
                </div>
            </div>

                     <div class="panel-body" align="center">
                        <div class="form-group">
                            <a href="{{ route('user-management.index', ['id' => $user->id]) }}" class="btn btn-default" style="background-color:#3c8dbc"><i class="fa fa-reply-all"></i>
                          Atrás
                        </a>
                        </div>
                    </div>
</div>
@endsection
@endif
