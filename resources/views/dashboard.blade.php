<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
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
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
   <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/skin-blue.min.css")}}" rel="stylesheet" type="text/css" />

   <!-- Calendario Inicio -->
   <link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
   <link href="{{ asset("/bower_components/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css")}}" rel="stylesheet" type="text/css" />
   <!-- Calendario Fin -->

</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
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

  <!-- Calendario Inicio -->
  <table class="table responsive">
    <tr>
      <td>
      <div id='calendar'></div>
    </td>
    </tr>
</table>
  <!-- Calendario Fin -->

  <!-- Fila Contenido -->
  <div class="row">
    <!-- ./col -->
    @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
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
  <!-- /.row -->
  <!-- Main row -->
  @endif

  <div>
    <table class="table responsive">
      <tr>
        <td>
          <div>
              <h1 style ="background: rgba(203,96,179,1);" align="center">Misión</h1>
                  <p style="background:#B0E0E6 " align="center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis magni quisquam reiciendis obcaecati amet ea dolorum ut eaque hic, architecto blanditiis voluptates alias repellendus tempore ducimus, suscipit quo nam doloremque!</p>
          </div>
        </td>
        <td>
          <div>
              <h1 style ="background:#009f1d"; align="center">Visión</h1>
                  <p style="background:#B0E0E6 " align="center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis magni quisquam reiciendis obcaecati amet ea dolorum ut eaque hic, architecto blanditiis voluptates alias repellendus tempore ducimus, suscipit quo nam doloremque!</p>
          </div>
        </td>
        </tr>
        <tr>
        <td>
          <div>
              <h1 style="background:#ff3713;" align="center">Objetivos</h1>
                  <p style="background:#B0E0E6 " align="center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad possimus eum accusamus, recusandae deleniti quas delectus repellendus esse similique eveniet reiciendis unde ipsa eos minima natus adipisci odio assumenda repudiandae!</p>
          </div>
        </td>
        <td>
          <div>
              <p align="center"><img src="{{ asset("/bower_components/AdminLTE/dist/img/LOGO ABICADI 3.png") }}" alt="No Disponible" width="200" height="200"/></p>
          </div>
        </td>
        </tr>
    </table>
  </div>
  </section>
</div>
    <!-- /.content-wrapper -->

  <!-- Footer -->
  @include('layouts.footer')

<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

 <!-- jQuery 2.1.3 -->
<script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>

<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>
</body>

<script src='fullcalendar/lib/moment.min.js'></script>
<script src='fullcalendar/fullcalendar.js'></script>
<!-- Llamar Calendario Full -->
  @include('calendario-mgmt.calendario_view')
<!-- ************ -->
</html>
