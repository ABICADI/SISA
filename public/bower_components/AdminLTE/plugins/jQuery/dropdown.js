$("#departamento_paciente").change(function(event){
		$.get("/"+event.target.value+"",function(response,departamento){
			$("#municipio_paciente").empty();
			for(i=0; i<response.length; i++){
				$("#municipio_paciente").append("<option value='"+response[i].id+"'> "+response[i].nombre+" </option>");
			}
		});
});
