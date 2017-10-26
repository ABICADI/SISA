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

              /*select: function(start){
                  start = moment(start.format());
                  $('#date_start').val(start.format('DD-MM-YYYY'));
                  $('#responsive-modal').modal('show');
              },*/

        events: '/agregar-cita'

      });

    });
</script>
