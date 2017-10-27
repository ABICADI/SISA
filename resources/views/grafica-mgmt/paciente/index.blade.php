@extends('system-mgmt.bitacora.base')
@if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">Gráficas de los Pacientes</h3>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  <table class="table responsive">
    <tr>
      <td>
        {!! $grafica_registro->render() !!}
      </td>
      </tr>
  </table>
  <table class="table responsive">
    <tr>
      <td>
        {!! $group_tipo_pago->render() !!}
      </td>
      </tr>
  </table>
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  </div>
@endsection
@endif
