<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SISA | Sistema ABICADI</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
   <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
   <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
   <link href="{{ asset('css/app-template.css') }}" rel="stylesheet">

   <!-- Calendario Inicio -->
   <link rel='stylesheet' href="/bower_components/AdminLTE/fullcalendar/fullcalendar.css"/>
   <link href="{{ asset("/bower_components/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css")}}" rel="stylesheet" type="text/css" />
   <!-- Calendario Fin -->

</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  @include('layouts.header')
  <!-- Sidebar -->
  @include('layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      @if (4 != Auth::user()->rol_id)
      <!-- Calendario Inicio -->
      <div class="form-group" style="text-align:center;">
        <h1>AGENDA</h1>
      </div>
      <table class="table responsive">
        <tr>
          <td>
          <div id='calendar'></div>
        </td>
        </tr>
    </table>
      <!-- Calendario Fin -->
      @endif
  @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
  <!-- Fila Contenido -->
  <div class="row">
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{$count_user}}</h3>
          <p>Empleados Ingresados</p>
        </div>
        <div class="icon">
          <a href="{{ route('user-management.create') }}"><i class="fa fa-users"></i></a>
        </div>
        <a href="{{ route('user-management.index') }}" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{$count_paci}}</h3>
          <p>Pacientes Ingresados</p>
        </div>
        <div class="icon">
          <a href="{{ route('paciente-management.create') }}"><i class="fa fa-user"></i></a>
        </div>
        <a href="{{ route('paciente-management.index') }}" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{$count_medi}}</h3>
          <p>Médicos Ingresados</p>
        </div>
        <div class="icon">
          <a href="{{ route('medico-management.create') }}"><i class="fa fa-user-md"></i></a>
        </div>
        <a href="{{ route('medico-management.index') }}" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-blue">
        <div class="inner">
          <h3>{{$count_trat}}</h3>
          <p>Tratamientos Ingresados</p>
        </div>
        <div class="icon">
          <a href="{{ route('tratamiento-management.create') }}"><i class="fa fa-heartbeat"></i></a>
        </div>
        <a href="{{ route('tratamiento-management.index') }}" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <!-- Main row -->
</script>
</div>
  @endif
</section>
</div>
</div>
  @include('layouts.footer')

 <!-- jQuery 2.1.3 -->
<script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>

<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>
</body>

<script src="{{ asset ("/bower_components/AdminLTE/fullcalendar/lib/moment.min.js") }}"></script>
<script src="{{ asset ("/bower_components/AdminLTE/fullcalendar/fullcalendar.js") }}"></script>
<script src="{{ asset ("/bower_components/AdminLTE/fullcalendar/locale/es.js") }}"></script>
<script src='/bower_components/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js' type="text/javascript"/></script>
<!-- Llamar Calendario Full -->
  @include('calendario-mgmt.calendario_view')
<!-- ************ -->
</html>
