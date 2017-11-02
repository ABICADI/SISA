 <!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
      table {
        border-collapse: collapse;
        width: 100%;
      }
      td, th {
        border: solid 2px;
        padding: 10px 5px;
      }
      tr {
        text-align: center;
      }
      .container {
        width: 100%;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="container">
        <div><h2>{{$title}}</h2></div>
       <table id="example2" role="grid">
            <thead>
              <tr role="row">
                <th width="5%">Nombre</th>
                <th width="8%">Encargado</th>
                <th width="5%">Teléfono</th>
                <th width="2%">Dirección</th>
                <th width="5%">Fecha</th>
                <th width="20%">Descripción</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($actividades as $actividad)
                <tr role="row" class="odd">
                  <td>{{ $actividad['Nombre_Actividad'] }}</td>
                  <td>{{ $actividad['Primer_Nombre'] }} {{ $actividad['Segundo_Nombre'] }} {{ $actividad['Tercer_Nombre'] }} {{ $actividad['Primer_Apellido'] }} {{ $actividad['Segundo_Apellido'] }} {{ $actividad['Tercer_Apellido'] }}</td>
                  <td>{{ $actividad['Teléfono'] }}</td>
                  <td>{{ $actividad['Departamento'] }}, {{ $actividad['Municipio'] }}, {{ $actividad['Dirección'] }}</td>
                  <td>{{ $actividad['Fecha'] }}</td>
                  <td>{{ $actividad['Descripción'] }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
    </div>
  </body>
</html>
