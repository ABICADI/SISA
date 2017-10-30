	$("#departamento_id").change(function(event){
			$.get("/"+event.target.value+"",function(response,departamento){
				$("#municipio_id").empty();
				for(i=0; i<response.length; i++){
					$("#municipio_id").append("<option value='"+response[i].id+"'> "+response[i].nombre+" </option>");
				}
			});
	});
