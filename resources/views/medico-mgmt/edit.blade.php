@extends('medico-mgmt.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-47 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Actualizar Médico</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('medico-management.update', ['id' => $medico->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div div id="desdeotro" style="display:none;">
                <input id="username" type="text" class="form-control" name="username" value="{{ Auth::user()->username }}" disabled="help-block">
            </div>

            <div class="form-group{{ $errors->has('colegiado') ? ' has-error' : '' }}">
                <label for="nombre" class="col-md-2 control-label"><label style="color:red">*</label> Colegiado</label>
                    <div class="col-md-6">
                        <input id="nombre" type="text" class="form-control" placeholder="nombre" name="nombre" value="{{ $medico->colegiado }}" onkeypress="return numeros(event)" maxlength="10" required>
                        
                        @if ($errors->has('colegiado'))
                            <span class="help-block">
                            <strong>{{ $errors->first('colegiado') }}</strong>
                            </span>
                        @endif
                    </div>
            </div>

						<div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                <label for="nombre" class="col-md-2 control-label">Nombre</label>
                    <div class="col-md-6">
                        <input id="nombre" type="text" class="form-control" placeholder="nombre" name="nombre" value="{{ $medico->nombre }}" onkeypress="return letras(event)" maxlength="125">

                        @if ($errors->has('nombre'))
                            <span class="help-block">
                            <strong>{{ $errors->first('nombre') }}</strong>
                            </span>
                        @endif
                    </div>
            </div>

						<div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
                <label for="nombre" class="col-md-2 control-label">Teléfono</label>
                    <div class="col-md-6">
                        <input id="nombre" type="text" class="form-control" placeholder="nombre" name="nombre" value="{{ $medico->telefono }}" onkeypress="return numeros(event)" minlength="8" maxlength="8">

                        @if ($errors->has('telefono'))
                            <span class="help-block">
                            <strong>{{ $errors->first('telefono') }}</strong>
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
