@extends('system-mgmt.terapia.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Actualizar Terapia</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('terapia.update', ['id' => $terapia->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div div id="desdeotro" style="display:none;">
                            <input id="username" type="text" class="form-control" name="username" value="{{ Auth::user()->username }}" disabled="help-block">
                        </div>

                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label"><label style="color:red">*</label> Nombre</label>
                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ $terapia->nombre }}" required autofocus disabled="">

                                @if ($errors->has('nombre'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

            <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                <label for="descripcion" class="col-md-4 control-label">Descripcion</label>

                    <div class="col-md-6">
                        <textarea id="descripcion" class="form-control" name="descripcion" placeholder="descripcion" cols="50" rows="10"  type="text" value="{{ $terapia->descripcion }}" autofocus>{{ $terapia->descripcion }}</textarea>

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
                                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Guardar</button>
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