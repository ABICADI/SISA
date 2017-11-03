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
			 border: solid 1px;
			 padding: 5px 3px;
		 }
		 tr {
			 text-align: center;
		 }
		 .container {
			 width: 100%;
			 text-align: center;
			 font-size:10px;
			 font-family: "arial", serif;
		 }
	 </style>
 </head>
 <body>
	 <div class="container">
			 <div><h2>{{ $title }}</h2></div>
			<table id="example2" role="grid">
					 <thead>
						 <tr role="row">
							 <th width="1%">No. Registro</th>
							 <th width="1%">Nombre Completo y Género</th>
							 <th width="1%">Dirección</th>
							 <th width="1%">Fec. Nac.</th>
							 <th width="1%">Encargado y Télefono</th>
							 <th width="1%">Fecha Ingreso , CUI y Tipo de Pago</th>
						 </tr>
					 </thead>
					 <tbody>
					 @foreach ($pacientes as $paciente)
							 <tr role="row" class="odd">
								 <td>{{ $paciente['No_Registro'] }}</td>
								 <td>{{ $paciente['Primer_Nombre'] }} {{ $paciente['Segundo_Nombre'] }} {{ $paciente['Tercer_Nombre'] }} {{ $paciente['Primer_Apellido'] }} {{ $paciente['Segundo_Apellido'] }} {{ $paciente['Tercer_Apellido'] }}, {{ $paciente['Género'] }}</td>
								 <td>{{ $paciente['Departamento'] }}, {{ $paciente['Municipio'] }}, {{ $paciente['Dirección'] }}</td>
								 <td>{{ $paciente['Fecha_Nacimiento'] }}</td>
								 <td>{{ $paciente['Nombre_Encargado'] }} - {{ $paciente['Teléfono'] }}</td>
								 <td>{{ $paciente['Fecha_Ingreso'] }}, {{ $paciente['CUI'] }}, {{ $paciente['Tipo_Pago'] }}</td>
						 </tr>
					 @endforeach
					 </tbody>
				 </table>
	 </div>
 </body>
</html>
