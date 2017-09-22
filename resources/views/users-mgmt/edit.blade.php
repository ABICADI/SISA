@extends('users-mgmt.base')
@if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-47 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Actualizar Empleado</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('dia-terapia-user-management.update', ['id' => $user->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div div id="desdeotro" style="display:none;">
                <input id="user" type="text" class="form-control" name="user" value="{{ Auth::user()->username }}" disabled="help-block">
            </div>

            <div class="form-group{{ $errors->has('dpi') ? ' has-error' : '' }}">
                <label for="dpi" class="col-md-4 control-label"><label style="color:red">*</label> DPI</label>
                    <div class="col-md-6">
                        <input id="dpi" type="text" class="form-control" name="dpi" value="{{ $user->dpi }}" onkeypress="return numeros(event)" minlength="13" maxlength="13" required>

                        @if ($errors->has('dpi'))
                            <span class="help-block">
                            <strong>{{ $errors->first('dpi') }}</strong>
                            </span>
                        @endif
                    </div>
            </div>

        @component('layouts.esconder_info', ['title' => 'Nombre y Apellido'])
        <table id="example2" class="table table-responsive">
            <tr>
            <td>   
            <div class="form-group{{ $errors->has('nombre1') ? ' has-error' : '' }}">
                <label for="nombre1" class="col-md-6 control-label"><label style="color:red">*</label> Primer Nombre</label>
                    <div class="col-md-5">
                        <input id="nombre1" type="text" class="form-control" placeholder="primer nombre" name="nombre1" value="{{ $user->nombre1 }}" onkeypress="return letras(event)" maxlength="30" required autofocus>

                        @if ($errors->has('nombre1'))
                            <span class="help-block">
                            <strong>{{ $errors->first('nombre1') }}</strong>
                            </span>
                        @endif
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group{{ $errors->has('nombre2') ? ' has-error' : '' }}">
                <label for="nombre2" class="col-md-6 control-label">Segundo Nombre</label>

                    <div class="col-md-5">
                        <input id="nombre2" type="text" class="form-control" placeholder="segundo nombre" name="nombre2" value="{{ $user->nombre2 }}" onkeypress="return letras(event)" maxlength="30" autofocus>

                            @if ($errors->has('nombre2'))
                                <span class="help-block">
                                <strong>{{ $errors->first('nombre2') }}</strong>
                                </span>
                            @endif
                    </div>
            </div>
            </td>
            <td>           
            <div class="form-group{{ $errors->has('nombre3') ? ' has-error' : '' }}">
                <label for="nombre3" class="col-md-6 control-label">Tercer Nombre</label>

                    <div class="col-md-5">
                        <input id="nombre3" type="text" class="form-control" placeholder="tercer nombre" name="nombre3" value="{{ $user->nombre3 }}" onkeypress="return letras(event)" maxlength="30" autofocus>

                            @if ($errors->has('nombre3'))
                                <span class="help-block">
                                <strong>{{ $errors->first('nombre3') }}</strong>
                                </span>
                            @endif
                    </div>
            </div> 
            </td>
            </tr> 
            <tr>
            <td> 
            <div class="form-group{{ $errors->has('apellido1') ? ' has-error' : '' }}">
                <label for="apellido1" class="col-md-6 control-label"><label style="color:red">*</label> Primer Apellido</label>
                    <div class="col-md-5">
                        <input id="apellido1" type="text" class="form-control" placeholder="primer apellido" name="apellido1" value="{{ $user->apellido1 }}" onkeypress="return letras(event)" maxlength="30" required autofocus>

                        @if ($errors->has('apellido1'))
                            <span class="help-block">
                            <strong>{{ $errors->first('apellido1') }}</strong>
                            </span>
                        @endif
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group{{ $errors->has('apellido2') ? ' has-error' : '' }}">
                <label for="apellido2" class="col-md-6 control-label">Segundo Apellido</label>

                    <div class="col-md-5">
                        <input id="apellido2" type="text" class="form-control" placeholder="segundo apellido" name="apellido2" value="{{ $user->apellido2 }}" onkeypress="return letras(event)" maxlength="30" autofocus>

                            @if ($errors->has('apellido2'))
                                <span class="help-block">
                                <strong>{{ $errors->first('apellido2') }}</strong>
                                </span>
                            @endif
                    </div>
            </div>
            </td>
            <td>           
            <div class="form-group{{ $errors->has('apellido3') ? ' has-error' : '' }}">
                <label for="apellido3" class="col-md-6 control-label">Tercer Apellido</label>

                    <div class="col-md-5">
                        <input id="apellido3" type="text" class="form-control" placeholder="tercer apellido" name="apellido3" value="{{ $user->apellido3 }}" onkeypress="return letras(event)" maxlength="30" autofocus>

                            @if ($errors->has('apellido3'))
                                <span class="help-block">
                                <strong>{{ $errors->first('apellido3') }}</strong>
                                </span>
                            @endif
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
            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                <label for="username" class="col-md-4 control-label"><label style="color:red">*</label> Usuario</label>

                    <div class="col-md-6">
                        <input id="username" type="text" class="form-control" placeholder="usuario" name="username" value="{{ $user->username }}" onkeypress="return letrasynumeros(event)" minlength="6" maxlength="30" required autofocus>

                            @if ($errors->has('username'))
                                <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">Correo Electrónico</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" onkeypress="return letrasynumeros(event)" maxlength="125" autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                    </div>
            </div>
            </td>
            </tr>
            <tr>
            <td>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label"><label style="color:red">*</label> Nueva Contraseña</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" autofocus>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group">
                <label for="password-confirm" class="col-md-4 control-label"><label style="color:red">*</label> Confirmar Contraseña</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autofocus>
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
                        <select class="form-control" name="departamento_id" required autofocus>
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
                        <select class="form-control" name="municipio_id" required autofocus>
                            @foreach ($municipios as $municipio)
                                <option value="{{$municipio->id}}" {{$municipio->id == $user->municipio_id ? 'selected' : ''}}>{{$municipio->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                <label for="direccion" class="col-md-3 control-label">Dirección</label>

                    <div class="col-md-8">
                        <input id="direccion" type="text" class="form-control" name="direccion" value="{{ $user->direccion }}" maxlength="75" autofocus>

                            @if ($errors->has('direccion'))
                                <span class="help-block">
                                <strong>{{ $errors->first('direccion') }}</strong>
                                </span>
                            @endif
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
                            <input type="text" value="{{ $user->fecha_nacimiento }}" name="fecha_nacimiento" class="form-control pull-right" id="fechaNacimiento" required>
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
                                var edad = parseInt(fechaHoy.getFullYear())-anioNac;
                                if(edad) document.getElementById("edad").value=edad;
                            </script>
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
                <label for="telefono" class="col-md-4 control-label">Teléfono</label>

                    <div class="col-md-6">
                        <input id="telefono" type="telefono" class="form-control" placeholder="00000000" name="telefono" value="{{ $user->telefono }}" onkeypress="return numeros(event)" minlength="8" maxlength="8" autofocus autofocus>

                            @if ($errors->has('telefono'))
                                <span class="help-block">
                                <strong>{{ $errors->first('telefono') }}</strong>
                                </span>
                            @endif
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
                    <div class="col-md-6">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" value="{{ $user->fecha_ingreso }}" name="fecha_ingreso" class="form-control pull-right" id="fechaIngreso" required>
                        </div>
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group">
                <label class="col-md-4 control-label"><label style="color:red">*</label> Puesto Encargado</label>
                    <div class="col-md-6">
                        <select class="form-control" name="rol_id" required autofocus>
                            @foreach ($rols as $rol)
                                <option value="{{$rol->id}}" {{$rol->id == $user->rol_id ? 'selected' : ''}}>{{$rol->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            </td>
            <td>
            @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
            <div class="form-group">
                <label class="col-md-5 control-label"><label style="color:red">*</label> Estado</label>
                    <div class="col-md-7">
                        <select class="form-control" name="estado_id">
                            @foreach ($estados as $estado)
                                <option value="{{$estado->id}}" {{$estado->id == $user->estado_id ? 'selected' : ''}}>{{$estado->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            @endif
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
                                            <tr>
                                            @foreach ($diasemanas as $diasemana)
                                            <?php $cont = 0; ?>
                                            @foreach ($userdiasemanas as $userdiasemana)
                                            
                                            @if($diasemana->id == $userdiasemana->diasemana_id)
                                            <td role="row"><input type="checkbox" id="{{$diasemana->id}}" name="diasemana[]" value="{{$diasemana->id}}" checked>  {{ $userdiasemana->nombre_dia }}</td>
                                            <?php $cont = 1; ?>
                                            @endif
                                            @endforeach
                                            <?php if($cont < 1) {?>
                                            @if($diasemana->id != $userdiasemana->diasemana_id)
                                            <td role="row"><input type="checkbox" id="{{$diasemana->id}}" name="diasemana[]" value="{{$diasemana->id}}">  {{ $diasemana->nombre }}</td>
                                            @endif
                                            <?php }?>
                                            @endforeach 
                                            </tr>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('terapiausuario-management.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <table id="example2" class="table table-responsive" role="grid" aria-describedby="example2_info">
                                            <tr>
                                            @foreach ($terapias as $terapia)
                                            <?php $cont = 0; ?>
                                            @foreach ($usuarioterapias as $usuarioterapia)
                                            
                                            @if($terapia->id == $usuarioterapia->terapia_id)
                                            <td role="row"><input type="checkbox" id="{{$terapia->id}}" name="terapia[]" value="{{$terapia->id}}" checked>  {{ $usuarioterapia->terapia_nombre }}</td>
                                            <?php $cont = 1; ?>
                                            @endif
                                            @endforeach
                                            <?php if($cont < 1) {?>
                                            @if($terapia->id != $usuarioterapia->terapia_id)
                                            <td role="row"><input type="checkbox" id="{{$terapia->id}}" name="terapia[]" value="{{$terapia->id}}">  {{ $terapia->nombre }}</td>
                                            @endif
                                            <?php }?>
                                            @endforeach 
                                            </tr>
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
                        @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> 
                                    Guardar
                                </button>
                            </div>
                        </div>
                        @endif
                    </form>
</div>
@endsection
@endif
