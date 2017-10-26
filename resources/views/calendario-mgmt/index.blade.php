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
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
   <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/skin-blue.min.css")}}" rel="stylesheet" type="text/css" />

   {!! Charts::assets() !!}

   <!-- Calendario Inicio -->
   <link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
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
                        <div class="modal-body">
                              <label for="cui" class="col-md-2 control-label">Fecha</label>
                                  <div class="col-md-3">
                                      <input id="fecha" type="text" class="form-control" name="fecha" value="{{ old('fecha') }}" equired autofocus>
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

          </div>
        </div>
      </td>
    </tr>
  </table>
  <!-- Calendario Fin -->

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

<!-- Calendario Inicio JS-->
<script src='fullcalendar/lib/moment.min.js'></script>
<script src='fullcalendar/fullcalendar.js'></script>
<script src='fullcalendar/locale/es.js'></script>
<!-- Calendario Fin -->

<script>
    $(document).ready(function() {
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,basicDay'
      },
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      selectable: true,
      selectHelper: true,

            select: function(start){
                start = moment(start.format());
                $('#fecha').val(start.format('DD-MM-YYYY'));
                $('#responsive-modal').modal('show');
            },
      events: '/agregar-cita',
            eventClick: function(event, jsEvent, view){
                var fecha = $.fullCalendar.moment(event.start).format('YYYY-MM-DD');
                $('#modal-event #delete').attr('data-id', event.id);
                $('#modal-event #_title').val(event.title);
                $('#modal-event #fecha').val(fecha);
                $('#modal-event #_time_start').val(time_start);
                $('#modal-event #_date_end').val(date_end);
                $('#modal-event #_color').val(event.color);
                $('#modal-event').modal('show');
            }
    });
  });

    $('#delete').on('click', function(){
        var x = $(this);
        var delete_url = x.attr('data-href')+'/'+x.attr('data-id');
        $.ajax({
            url: delete_url,
            type: 'DELETE',
            success: function(result){
                $('#modal-event').modal('hide');
                alert(result.message);
            },
            error: function(result){
                $('#modal-event').modal('hide');
                alert(result.message);
            }
        });
    });
</script>
</html>
