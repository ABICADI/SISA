@extends('paciente-mgmt.base')
@if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-47 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Actualizar Paciente</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('paciente-management.update', ['id' => $paciente->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="box box-default">
            <div class="box-body">
                <table id="example2" class="table table-responsive">
                  <tr>
                  <td>
                    <div class="form-group{{ $errors->has('seguro_social') ? ' has-error' : '' }}">
                        <label for="seguro_social" class="col-md-3 control-label"><label style="color:red">*</label> No. Registro</label>

                            <div class="col-md-3">
                                <input id="seguro_social" type="text" class="form-control" placeholder="0000000000" name="seguro_social" value="{{ $paciente->seguro_social }}" onkeypress="return numeros(event)" maxlength="10" required autofocus>

                              @if ($errors->has('seguro_social'))
                                  <span class="help-block">
                                        <strong>{{ $errors->first('seguro_social') }}</strong>
                                  </span>
                              @endif
                            </div>
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <label for="cui" class="col-md-2 control-label">CUI</label>
                          <div class="col-md-4">
                            <input id="cui" type="text" class="form-control" placeholder="0000000000000" name="cui" value="{{ $paciente->cui }}" onkeypress="return numeros(event)" minlength="13" maxlength="13" autofocus>

                                @if ($errors->has('cui'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('cui') }}</strong>
                                  </span>
                                @endif
                            </div>
                        </div>
                      </td>
                      </tr>
                    </table>
              </div>
      </div>

        @component('layouts.esconder_info', ['title' => 'Nombre y Apellido'])
        <table id="example2" class="table table-responsive">
            <tr>
            <td>
            <div class="form-group{{ $errors->has('nombre1') ? ' has-error' : '' }}">
                <label for="nombre1" class="col-md-6 control-label"><label style="color:red">*</label> Primer Nombre</label>
                    <div class="col-md-5">
                        <input id="nombre1" type="text" class="form-control" placeholder="primer nombre" name="nombre1" value="{{ $paciente->nombre1 }}" onkeypress="return letras(event)" maxlength="30" onKeyUp="this.value=this.value.toUpperCase();" required autofocus>

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
                        <input id="nombre2" type="text" class="form-control" placeholder="segundo nombre" name="nombre2" value="{{ $paciente->nombre2 }}" onkeypress="return letras(event)" maxlength="30" onKeyUp="this.value=this.value.toUpperCase();" autofocus>

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
                        <input id="nombre3" type="text" class="form-control" placeholder="tercer nombre" name="nombre3" value="{{ $paciente->nombre3 }}" onkeypress="return letras(event)" maxlength="30" onKeyUp="this.value=this.value.toUpperCase();" autofocus>

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
                        <input id="apellido1" type="text" class="form-control" placeholder="primer apellido" name="apellido1" value="{{ $paciente->apellido1 }}" onkeypress="return letras(event)" maxlength="30" onKeyUp="this.value=this.value.toUpperCase();" required autofocus>

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
                        <input id="apellido2" type="text" class="form-control" placeholder="segundo apellido" name="apellido2" value="{{ $paciente->apellido2 }}" onkeypress="return letras(event)" maxlength="30" onKeyUp="this.value=this.value.toUpperCase();" autofocus>

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
                        <input id="apellido3" type="text" class="form-control" placeholder="tercer apellido" name="apellido3" value="{{ $paciente->apellido3 }}" onkeypress="return letras(event)" maxlength="30" onKeyUp="this.value=this.value.toUpperCase();" autofocus>

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
        <table id="example2" class="table table-responsive">
            <tr>
              <td>
                <div class="form-group">
                    <label class="col-md-2 control-label"><label style="color:red">*</label> Género</label>
                        <div class="col-md-2">
                            <select class="form-control" name="genero_id" id="genero_id" autofocus>
                                <option value="0" selected disabled>seleccione género</option>
                                @foreach ($generos as $genero)
                                    <option value="{{$genero->id}}" {{$genero->id == $paciente->genero_id ? 'selected' : ''}}>{{$genero->nombre}}</option>
                                @endforeach
                            </select>
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
                <label for="direccion" class="col-md-3 control-label">Dirección Actual</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" value="{{ $paciente->Departamento }}, {{ $paciente->Municipio }}, {{ $paciente->direccion }}" disabled>
                    </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="check" id="check" value="1" onchange="javascript:showContent()" />
                        Editar
                    </label>
                </div>
            </td>
            </tr>
        </table>
        <div class="form-group" id="editar_direccion" style="display: none;">
        <table id="example2" class="table table-responsive">
            <tr>
            <td>
            <div class="form-group">
                <label class="col-md-5 control-label"><label style="color:red">*</label> Departamento</label>
                    <div class="col-md-7">
                        <select class="form-control" name="departamento_paciente" id="departamento_paciente" autofocus>
                            <option value="0" selected disabled>seleccione departamento</option>
                            @foreach ($departamentos as $departamento)
                                <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group">
                <label class="col-md-4 control-label"><label style="color:red">*</label> Municipio</label>
                  <div class="col-md-7">
                    <select class="form-control" name="municipio_paciente" id="municipio_paciente" autofocus>
                    @foreach ($municipios as $municipio)
                        <option value="{{$municipio->id}}">{{$municipio->nombre}}</option>
                    @endforeach
                    </select>
                  </div>
            </div>
            </td>
            <td>
            <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                <label for="direccion" class="col-md-3 control-label">Dirección</label>
                    <div class="col-md-9">
                        <input id="direccion" type="text" class="form-control" placeholder="colonia/barrio" name="direccion" value="{{$paciente->direccion}}" maxlength="75" onKeyUp="this.value=this.value.toUpperCase();" autofocus>

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
        </div>
        @endcomponent

        @component('layouts.esconder_info', ['title' => 'Referencias'])
        <table id="example2" class="table table-responsive">
            <tr>
            <td>
            <div class="form-group">
                <label class="col-md-5 control-label"><label style="color:red">*</label> Fecha de Nacimiento</label>
                    <div class="col-md-3">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" value="{{ $paciente->fecha_nacimiento }}" placeholder="30/01/1990" name="fecha_nacimiento" class="form-control pull-right" id="fechaNacimiento" required>
                        </div>
                    </div>
            </div>
            </td>
            <td>
                <div class="form-group">
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
            </tr>
            <tr>
            <td>
            <div class="form-group{{ $errors->has('encargado') ? ' has-error' : '' }}">
                <label for="encargado" class="col-md-3 control-label">Encargado</label>

                    <div class="col-md-9">
                        <input id="encargado" type="text" class="form-control" placeholder="nombre completo" name="encargado" value="{{ $paciente->encargado }}" onkeypress="return letras(event)" maxlength="100" onKeyUp="this.value=this.value.toUpperCase();" autofocus>

                            @if ($errors->has('encargado'))
                                <span class="help-block">
                                <strong>{{ $errors->first('encargado') }}</strong>
                                </span>
                            @endif
                    </div>
            </div>
            </td>
            <td>
            <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
                <label for="telefono" class="col-md-3 control-label">Teléfono</label>

                    <div class="col-md-4">
                        <input id="telefono" type="text" class="form-control" placeholder="00000000" name="telefono" value="{{ $paciente->telefono }}" onkeypress="return numeros(event)" minlength="8" maxlength="8" autofocus>

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

        @component('layouts.esconder_info', ['title' => 'Registro Clinico'])
        <table id="example2" class="table table-responsive">
            <tr>
            <td>
            <div class="form-group">
                <label class="col-md-4 control-label"><label style="color:red">*</label> Fecha de Ingreso</label>
                    <div class="col-md-3">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" value="{{ $paciente->fecha_ingreso }}" placeholder="30/01/1990" name="fecha_ingreso" class="form-control pull-right" id="fechaIngreso" required>
                        </div>
                    </div>
            </div>
            </td>
            <td>
              <div class="form-group">
                  <label class="col-md-3 control-label"><label style="color:red">*</label> Tipo de Pago</label>
                      <div class="col-md-5">
                          <select class="form-control" name="pago_id" id='pago_id' required autofocus>
                              @foreach ($pagos as $pago)
                                  <option value="{{$pago->id}}" {{$pago->id == $paciente->pago_id ? 'selected' : ''}}>{{$pago->nombre}}</option>
                              @endforeach
                          </select>
                      </div>
              </div>
            </td>
            </tr>
        </table>
            <div class="form-group{{ $errors->has('observacion') ? ' has-error' : '' }}">
                <label for="observacion" class="col-md-2 control-label">Observaciones</label>

                    <div class="col-md-6">
                        <textarea id="observacion" class="form-control" name="observacion" placeholder="observaciones" cols="50" rows="10"  type="text" value="{{ $paciente->observacion }}" onKeyUp="this.value=this.value.toUpperCase();"  maxlength="1000" autofocus>{{ $paciente->observacion }}</textarea>

                            @if ($errors->has('observacion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('observacion') }}</strong>
                                </span>
                            @endif
                    </div>
            </div>
        @endcomponent

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
@endif
