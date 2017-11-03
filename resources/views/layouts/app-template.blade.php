<!DOCTYPE html>
<!--
  This is a starter template page. Use this page to start your new project from
  scratch. This page gets rid of all links and provides the needed markup only.
  -->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SISA | Sistema ABICADI</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link href="{{ asset("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css")}}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
      page. However, you can choose any other skin. Make sure you
      apply the skin class to the body tag so the changes take effect.
      -->
    <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app-template.css') }}" rel="stylesheet">
      <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>-->

    <link rel='stylesheet' href="/bower_components/AdminLTE/fullcalendar/fullcalendar.css"/>
    <link href="{{ asset("/bower_components/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- Graficas -->
    {!! Charts::assets() !!}
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

    @yield('content')
    </div>
    <!-- Footer -->
    @include('layouts.footer')
    <!-- ./wrapper -->
    <!-- REQUIRED JS SCRIPTS -->
    <!-- jQuery 2.1.3 -->
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/dropdowns.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/dropdown.js") }}"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js") }}" type="text/javascript" ></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js") }}" type="text/javascript" ></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js") }}" type="text/javascript" ></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/fastclick/fastclick.js") }}" type="text/javascript" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js") }}" type="text/javascript" ></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js") }}" type="text/javascript" ></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js") }}" type="text/javascript" ></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.js") }}" type="text/javascript" ></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}" type="text/javascript" ></script>
    <!-- AdminLTE App -->
    <script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/dist/js/demo.js") }}" type="text/javascript"></script>
    <script src='/bower_components/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js' type="text/javascript"/></script>

    <script type="text/javascript">
        function showContent() {
            element = document.getElementById("editar_direccion");
            check = document.getElementById("check");
            if (check.checked) {
                element.style.display='block';
            }
            else {
                element.style.display='none';
            }
        }
    </script>
    <script type="text/javascript">
        function EsconderDias() {
            element = document.getElementById("editar_dia");
            check = document.getElementById("dia_default");
            if (check.checked) {
                element.style.display='none';
            }
            else {
                element.style.display='block';
            }
        }
    </script>
    <script type="text/javascript">
        function EsconderTerapias() {
            element = document.getElementById("editar_terapia");
            check = document.getElementById("terapia_default");
            if (check.checked) {
                element.style.display='none';
            }
            else {
                element.style.display='block';
            }
        }
    </script>
    <script>
      $('div.alert').not('.alert-important').delay(1000).fadeOut(200);
    </script>
      <script>
        $(document).ready(function() {
          //Date picker
          $('#fechaNacimiento').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
          });
          $('#fechaIngreso').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
          });
          $('#from').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
          });
          $('#to').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
          });
          $('#fromm').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
          });
          $('#too').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
          });
          $('#fecha').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
          });
          $('#fechaInicio').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
          });
          $('#fechaFin').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
          });
          $('#fecha2').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
          });

        });
      </script>

    <script>
      (function(){
        var insertEdad = function(){
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
        }

        var input = document.getElementById("fechaNacimiento");
        input.addEventListener("transitionend",insertEdad);
        input.addEventListener("change",insertEdad);
      }())
    </script>

    <script>
          function letras(e) {
              tecla = (document.all) ? e.keyCode : e.which;
              if (tecla==8) return true;
              patron =/[A-Za-záéíóúñÑ ]+/;
              te = String.fromCharCode(tecla);
              return patron.test(te);
          }
    </script>

    <script>
          function numeros(e) {
              tecla = (document.all) ? e.keyCode : e.which;
              if (tecla==8) return true;
              patron =/[0-9]+/;
              te = String.fromCharCode(tecla);
              return patron.test(te);
          }
    </script>

    <script>
          function letrasynumeros(e) {
              tecla = (document.all) ? e.keyCode : e.which;
              if (tecla==8) return true;
              patron =/[A-Za-záéíóú-0-9 ]/;
              te = String.fromCharCode(tecla);
              return patron.test(te);
          }
    </script>

    <script type="text/javascript">
      function mostrarReferencia(){
        if (document.fcontacto.Conocido[1].checked == true) {
          document.getElementById('desdeotro').style.display='block';
        } else {
          document.getElementById('desdeotro').style.display='none';
        }
      }
    </script>

    <script>
      $(document).ready(function() {
        $('.colorpicker').colorpicker();
      })
    </script>

  </body>
  <script src="{{ asset ("/bower_components/AdminLTE/fullcalendar/lib/moment.min.js") }}"></script>
  <script src="{{ asset ("/bower_components/AdminLTE/fullcalendar/fullcalendar.js") }}"></script>
  <script src="{{ asset ("/bower_components/AdminLTE/fullcalendar/locale/es.js") }}"></script>
  <script>
      $(document).ready(function() {
          $('#calendar').fullCalendar({
            header: {
              left: 'prev,next today',
              center: 'title',
              right: 'month,basicWeek,basicDay'
            },
            navLinks: true, // can click day/week names to navigate views
            selectable: true,

                  select: function(start){
                      start = moment(start.format());
                      $('#fecha').val(start.format('DD-MM-YYYY'));
                      $('#responsive-modal').modal('show');


                  },
            events: '/sisa/agregar-cita',

                  eventClick: function(event, jsEvent, view){
                      $('#modal-event #delete').attr('data-id', event.id);
                      $('#modal-event #_id').val(event.id);
                      $('#modal-event #_title').val(event.title);
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
