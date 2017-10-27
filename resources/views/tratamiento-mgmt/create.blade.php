@extends('tratamiento-mgmt.base')
@if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-47 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Nuevo Tratamiento</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('tratamiento-management.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-md-2 control-label"><label style="color:red">*</label> Paciente</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="paciente_id" id="paciente_id" required autofocus>
                                        <option value="" selected disabled>seleccione paciente</option>
                                        @foreach ($pacientes as $paciente)
                                            <option value="{{$paciente->id}}">{{$paciente->nombre1}} {{$paciente->nombre2}} {{$paciente->nombre3}} {{$paciente->apellido1}} {{$paciente->apellido2}} {{$paciente->apellido3}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"><label style="color:red">*</label> Medico</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="medico_id" id="medico_id" required autofocus>
                                        <option value="" selected disabled>seleccione medico</option>
                                        @foreach ($medicos as $medico)
                                            <option value="{{$medico->id}}">{{$medico->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"><label style="color:red">*</label> Terapia</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="terapia_id" id="terapia_id" required autofocus>
                                        <option value="" selected disabled>seleccione terapia</option>
                                        @foreach ($terapias as $terapia)
                                            <option value="{{$terapia->id}}">{{$terapia->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"><label style="color:red">*</label> Cantidad de Terapias</label>
                                <div class="col-md-6">
                                    <input value="{{ old('asignados') }}" class="form-control" name="asignados" id="asignados" placeholder="asignados" type="text">
                                </div>
                        </div>
                        <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                            <label for="descripcion" class="col-md-2 control-label">Descripcion</label>

                                <div class="col-md-6">
                                    <textarea id="descripcion" class="form-control" name="descripcion" placeholder="descripcion" cols="50" rows="10"  type="text" value="{{ old('descripcion') }}" maxlength="500" autofocus></textarea>

                                        @if ($errors->has('descripcion'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('descripcion') }}</strong>
                                            </span>
                                        @endif
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
@endif
