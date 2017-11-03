@extends('tratamientocalendario-mgmt.base')
@if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
@section('action-content')
  <!-- Calendario Inicio -->
  <table class="table responsive">
    <tr>
      <td>
        <div class="container">
            <div class="row">

            <form class="form-horizontal" role="form" method="POST" action="{{ route('agregar-cita.store') }}">
                {{ csrf_field() }}
            <div id="responsive-modal" class="modal fade" tabindex="-1" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header"><h4>Nueva Cita</h4></div>
												<input id="id" type="text" class="form-control" name="id" value="{{ $tratamiento->id }}"  style='display:none;'>
                        <div class="modal-body">
                              
                                  <div class="col-md-3">
                                      <input id="fecha" type="text" class="form-control" name="fecha" value="{{ old('fecha') }}"  autofocus style='display:none;'>
                                  </div>
                        </div>
                        @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
                        <div class="modal-footer">
                          <button type="button" class="btn btn-dafault" data-dismiss="modal">CANCELAR</button>
                          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i>
                        </div>
                        @endif
                        </form>
                    </div>
                </div>
            </div>

            <div id='calendar'></div>

            <div id="modal-event" class="modal fade" tabindex="-1" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Información de la Cita</h4>
                        </div>
                        <table class="table responsive">
                        <tr>
                          <td>
                            <div class="form-group">
                                <div class="form-group">
                                      <label for="cui" class="col-md-3 control-label">Información</label>
                                          <div class="col-md-7">
                                              <textarea id="_title" type="text" class="form-control" name="_title" value="{{ old('_title') }}" disabled></textarea>
                                          </div>
                                </div>
                            </div>
                          </td>
                        </tr>
                        </table>
                        @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
                        <div class="modal-footer">
                            <div class="modal-footer">
                              <a id="delete" data-href="{{ url('sisa/agregar-cita') }}" data-id="" class="btn btn-danger col-sm-2 col-xs-2 btn-margin">ELIMINAR</a>
                              <button type="button" class="btn btn-dafault" data-dismiss="modal">CANCELAR</button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

          </div>
        </div>
      </td>
    </tr>
  </table>
  @endsection
  @endif
