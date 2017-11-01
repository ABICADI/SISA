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
			 <div><h2>{{ $title }}</h2></div>
			<table id="example2" role="grid">
					 <thead>
						 <tr role="row">
               <th width="3%">No. Registro</th>
							 <th width="6%">Nombre Completo</th>
							 <th width="6%">Médico</th>
							 <th width="6%">Terapia</th>
               <th width="20%">Diagnóstico</th>
						 </tr>
					 </thead>
					 <tbody>
					 @foreach ($tratamientos as $tratamiento)
							 <tr role="row" class="odd">
                 <td>{{ $tratamiento['No. Registro'] }}</td>
								 <td>{{ $tratamiento['Primer_Nombre'] }} {{ $tratamiento['Segundo_Nombre'] }} {{ $tratamiento['Tercer_Nombre'] }} {{ $tratamiento['Primer_Apellido'] }} {{ $tratamiento['Segundo_Apellido'] }} {{ $tratamiento['Tercer_Apellido'] }}</td>
								 <td>{{ $tratamiento['Medico'] }}</td>
								 <td>{{ $tratamiento['Terapia'] }}</td>
                 <td>{{ $tratamiento['Diagnóstico'] }}</td>
						 </tr>
					 @endforeach
					 </tbody>
				 </table>
	 </div>
 </body>
</html>
