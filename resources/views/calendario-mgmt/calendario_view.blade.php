<script>

  $(document).ready(function() {

    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'listDay,listWeek,month'
      },

      views: {
        listDay: { buttonText: 'Agenda' },
        listWeek: { buttonText: 'Semana' },
      },

      defaultView: 'listWeek',
      defaultDate: $('#calendar').fullCalendar('today'),
      navLinks: true, // can click day/week names to navigate views
      eventLimit: true, // allow "more" link when too many events
      events: '/sisa/agregar-cita'
    });
    $('#calendar').fullCalendar('option', 'contentHeight', 450);

  });

</script>
<style>
  #calendar {
    max-width: 1200px;
    margin: 0 auto;
  }
</style>
