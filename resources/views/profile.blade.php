@extends('layouts.app-template')
@section('content')
  <div class="content-wrapper">
    @yield('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-47 col-md-offset-0">
            <div class="panel panel-default">
            	<div class="panel-heading" align="center"><p align="center"><img src="{{ asset("/bower_components/AdminLTE/dist/img/abicadi.png" ) }}" alt="No Disponible" width="100" height="100"/></p></div>
                <div class="panel-heading" align="center"><h1>Perfil del Usuario</h1></div>
                <div class="panel-body">

                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


		<table id="example2" class="table table-responsive" border="1">
            <tr>
            <td>
            <div class="form-group">
                <h2><label for="dpi" class="col-md-1 control-label">DPI</label></h2>
                <h3><label for="dpi" class="col-md-4 control-label">{{ $user->dpi }}</label></h3>
            </div>
            </td>
            </tr>
        </table>

		<table id="example2" class="table table-responsive" border="1">
            <tr>
            <td>
            <div class="form-group">
                <h2><label for="dpi" class="col-md-3 control-label">Nombre Completo</label></h2>
                <h3><label for="dpi" class="col-md-9 control-label">{{ $user->nombre1 }} {{ $user->nombre2 }} {{ $user->nombre3 }} {{ $user->apellido1 }} {{ $user->apellido2 }} {{ $user->apellido3 }}</label></h3>
            </div>
            </td>
            </tr>
        </table>

		<table id="example2" class="table table-responsive" align="center" border="1">
            <tr>
            <td>
            <div class="form-group" align="center">
                <h2><label for="dpi" class="col-md-10 control-label">Usuario</label></h2>
            </div>
            </td>
            <td>
            <div class="form-group" align="center">
                <h2><label for="dpi" class="col-md-10 control-label">E-mail</label></h2>
            </div>
            </td>
            </tr>
            <tr>
            <td>
            <div class="form-group" align="center">
                <h3><label for="dpi" class="col-md-10 control-label">{{ $user->username }}</label></h3>
            </div>
            </td>
            <td>
            <div class="form-group" align="center">
                <h3><label for="dpi" class="col-md-10 control-label">{{ $user->email }}</label></h3>
            </div>
            </td>
            </tr>
        </table>

		<table id="example2" class="table table-responsive" border="1">
            <tr>
            <td>
            <div class="form-group" align="center">
                <h2><label for="dpi" class="col-md-2 control-label">Dirección</label></h2>
                @foreach ($departamentos as $departamento)
                	<h3><label for="dpi" class="col-md-2 control-label">{{$departamento->nombre}}, </label></h3>
               	@endforeach
                @foreach ($municipios as $municipio)
                	<h3><label for="dpi" class="col-md-2 control-label">{{$municipio->nombre}}, </label></h3>
               	@endforeach
               		<h3><label for="dpi" class="col-md-6 control-label">{{ $user->direccion }}</label></h3>
            </div>
            </td>
            </tr>
        </table>


		<table id="example2" class="table table-responsive" align="center" border="1">
            <tr>
            <td>
            <div class="form-group" align="center">
                <h2><label for="dpi" class="col-md-10 control-label">Fecha de Nacimiento</label></h2>
            </div>
            </td>
            <td>
            <div class="form-group" align="center">
                <h2><label for="dpi" class="col-md-10 control-label">Edad</label></h2>
            </div>
            </td>
            <td>
            <div class="form-group" align="center">
                <h2><label for="dpi" class="col-md-10 control-label">Teléfono</label></h2>
            </div>
            </td>
            </tr>
            <tr>
            <td>
            <div class="form-group" align="center">
              <input id="fechaNacimiento" type="text" class="form-control" name="fechaNacimiento" disabled="" value="{{ $user->fecha_nacimiento }}" style='display:none;'>
                <h3><label for="dpi" class="col-md-10 control-label">{{ $user->fecha_nacimiento }}</label></h3>
            </div>
            </td>
            <td>
            <div class="form-group" align="center">
                <input id="edad" type="text" class="form-control" name="edad" disabled="" size="23" style="font-family: Arial; font-size: 16pt; text-align:center">
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
            </td>
            <td>
            <div class="form-group" align="center">
                <h3><label for="dpi" class="col-md-10 control-label">{{ $user->telefono }}</label></h3>
            </div>
            </td>
            </tr>
        </table>

		<table id="example2" class="table table-responsive" align="center" border="1">
            <tr>
            <td>
            <div class="form-group" align="center">
                <h2><label for="dpi" class="col-md-10 control-label">Fecha de Ingreso</label></h2>
            </div>
            </td>
            <td>
            <div class="form-group" align="center">
                <h2><label for="dpi" class="col-md-10 control-label">Puesto Encargado</label></h2>
            </div>
            </td>
            <td>
            <div class="form-group" align="center">
                <h2><label for="dpi" class="col-md-10 control-label">Estado</label></h2>
            </div>
            </td>
            </tr>
            <tr>
            <td>
            <div class="form-group" align="center">
                <h3><label for="dpi" class="col-md-10 control-label">{{ $user->fecha_ingreso }}</label></h3>
            </div>
            </td>
            <td>
            <div class="form-group" align="center">
                @foreach ($rols as $rol)
                	<h3><label for="dpi" class="col-md-10 control-label">{{$rol->nombre}}</label></h3>
               	@endforeach
            </div>
            </td>
            <td>
            <div class="form-group" align="center">
                @foreach ($estados as $estado)
                	<h3><label for="dpi" class="col-md-10 control-label">{{$estado->nombre}}</label></h3>
               	@endforeach
            </div>
            </td>
            </tr>
        </table>

		<table id="example2" class="table table-responsive" align="center" border="1">
            <tr>
            <td>
            <div class="form-group">
                <h2><label for="dpi" class="col-md-8 control-label">Dias a Laborar</label></h2>
            </div>
            </td>
            </tr>
            <tr>
           	<td>
            @foreach ($userdiasemanas as $userdiasemana)
                <td align="center"><h3><label id="label1" name="userdiasemanas[]">{{ $userdiasemana->diasemana_nombre }}</label></h3></td>
            @endforeach
            </td>
            </tr>
        </table>

		<table id="example2" class="table table-responsive" align="center" border="1">
            <tr>
            <td>
            <div class="form-group">
                <h2><label for="dpi" class="col-md-8 control-label">Areas a Laborar</label></h2>
            </div>
            </td>
            </tr>
            <tr>
           	<td>
            @foreach ($usuarioterapias as $usuarioterapia)
                <td align="center"><h3><label id="label1" name="userdiasemanas[]">{{ $usuarioterapia->terapia_nombre }}</label></h3></td>
            @endforeach
            </td>
            </tr>
        </table>
                </div>
            </div>
        </div>
    </div>
</div>
  </div>
@endsection
