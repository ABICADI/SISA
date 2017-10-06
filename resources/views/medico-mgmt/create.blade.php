@extends('medico-mgmt.base')
@if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
@section('action-content')
<div class="container">
    <div class="row">

        <div class="col-md-47 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Nuevo Médico</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('medico-management.store') }}">
                        {{ csrf_field() }}

            <div class="form-group{{ $errors->has('colegiado') ? ' has-error' : '' }}">
                <label for="cui" class="col-md-2 control-label"><label style="color:red">*</label> Colegiado</label>
                    <div class="col-md-3">
                        <input id="colegiado" type="text" class="form-control" placeholder="0000" name="colegiado" value="{{ old('colegiado') }}" onkeypress="return numeros(event)" minlength="2" maxlength="8" required autofocus>

                        @if ($errors->has('colegiado'))
                            <span class="help-block">
                            <strong>{{ $errors->first('colegiado') }}</strong>
                            </span>
                        @endif
                    </div>
            </div>

            <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                <label for="nombre" class="col-md-2 control-label"><label style="color:red">*</label> Nombre completo</label>
                    <div class="col-md-5">
                        <input id="nombre" type="text" class="form-control" placeholder="Nombre completo" name="nombre" value="{{ old('nombre') }}" onkeypress="return letras(event)" maxlength="150" onKeyUp="this.value=this.value.toUpperCase();" required autofocus>

                        @if ($errors->has('nombre'))
                            <span class="help-block">
                            <strong>{{ $errors->first('nombre') }}</strong>
                            </span>
                        @endif
                    </div>
            </div>

            <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
                <label for="cui" class="col-md-2 control-label"><label style="color:red">*</label> Teléfono</label>
                    <div class="col-md-3">
                        <input id="telefono" type="text" class="form-control" placeholder="78840000" name="telefono" value="{{ old('telefono') }}" onkeypress="return numeros(event)" minlength="8" maxlength="8" required autofocus>

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
@endif
