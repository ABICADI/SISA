@extends('actividad-mgmt.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-47 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Actualizar Actividad</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('actividad-management.update', ['id' => $actividad->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label class="col-md-2 control-label"><label style="color:red">*</label> Encargado</label>
                    <div class="col-md-6">
                        <select class="form-control" name="user_id" onKeyUp="this.value=this.value.toUpperCase();" required autofocus>
                            <option value="" selected disabled>seleccione encargado</option>
                            @foreach ($users as $user)
                                <option value="{{$user->id}}" {{$user->id == $actividad->user_id ? 'selected' : ''}}>{{$user->nombre1}} {{$user->nombre2}} {{$user->nombre3}} {{$user->apellido1}} {{$user->apellido2}} {{$user->apellido3}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>

            <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                <label for="nombre" class="col-md-2 control-label"><label style="color:red">*</label> Nombre Actividad</label>
                    <div class="col-md-6">
                        <input id="nombre" type="text" class="form-control" placeholder="nombre" name="nombre" value="{{ $actividad->nombre }}" onkeypress="return letras(event)" maxlength="50" required>

                        @if ($errors->has('nombre'))
                            <span class="help-block">
                            <strong>{{ $errors->first('nombre') }}</strong>
                            </span>
                        @endif
                    </div>
            </div>
            @if (2 != Auth::user()->rol_id)
            <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                <label for="descripcion" class="col-md-2 control-label">Descripcion</label>

                    <div class="col-md-6">
                        <textarea id="descripcion" class="form-control" name="descripcion" placeholder="descripcion" cols="50" rows="10"  type="text" value="{{ $actividad->descripcion }}" maxlength="500" autofocus>{{ $actividad->descripcion }}</textarea>

                            @if ($errors->has('descripcion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('descripcion') }}</strong>
                                </span>
                            @endif
                    </div>
            </div>
            @endif

        <table id="example2" class="table table-responsive">
            <tr>
            <td>
            <div class="form-group">
                <label class="col-md-3 control-label"><label style="color:red">*</label> Departamento</label>
                    <div class="col-md-7">
                        <select class="form-control" name="departamento_id" onKeyUp="this.value=this.value.toUpperCase();" required autofocus>
                            <option value="" selected disabled>seleccione departamento</option>
                            @foreach ($departamentos as $departamento)
                                <option value="{{$departamento->id}}" {{$departamento->id == $actividad->departamento_id ? 'selected' : ''}}>{{$departamento->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group">
                <label class="col-md-3 control-label"><label style="color:red">*</label> Municipio</label>
                    <div class="col-md-7">
                        <select class="form-control" name="municipio_id" onKeyUp="this.value=this.value.toUpperCase();" required autofocus>
                            <option value="" selected disabled>seleccione municipio</option>
                            @foreach ($municipios as $municipio)
                                <option value="{{$municipio->id}}" {{$municipio->id == $actividad->municipio_id ? 'selected' : ''}}>{{$municipio->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            </td>
            </tr>
        </table>

            <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                <label for="direccion" class="col-md-2 control-label">Dirección</label>

                    <div class="col-md-6">
                        <input id="direccion" type="direccion" class="form-control" placeholder="colonia/barrio" name="direccion" value="{{ $actividad->direccion }}" maxlength="75" onKeyUp="this.value=this.value.toUpperCase();" autofocus>

                            @if ($errors->has('direccion'))
                                <span class="help-block">
                                <strong>{{ $errors->first('direccion') }}</strong>
                                </span>
                            @endif
                    </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label"><label style="color:red">*</label> Fecha de la Actividad</label>
                    <div class="col-md-5">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" value="{{ $actividad->fecha }}" placeholder="30/01/1990" name="fecha" class="form-control pull-right" id="fechaNacimiento" required>
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
            </div>
        </div>
    </div>
</div>
@endsection
