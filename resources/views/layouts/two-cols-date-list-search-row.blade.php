<table class="table responsive">
	<tr>
		<td>
			<label class="col-md-2 control-label" align="center">De</label>
			<div class="col-md-5">
					<div class="input-group date">
							<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
							</div>
							<input type="text" value="{{$searchingVals['from']}}" name="from" class="form-control pull-right" id="from" placeholder="Fecha Nacimiento">
					</div>
			</div>
		</td>
		<td>
			<label class="col-md-2 control-label" align="center">Hasta</label>
			<div class="col-md-5">
					<div class="input-group date">
							<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
							</div>
							<input type="text" value="{{$searchingVals['to']}}" name="to" class="form-control pull-right" id="to" placeholder="Fecha Nacimiento">
					</div>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<label class="col-md-2 control-label" align="center">Departamento</label>
			<div class="col-md-5">
				<select class="form-control" name="departamento_id" id='departamento_id' autofocus>
					<option value="0">Ningun Departamento</option>
						@foreach ($departamentos as $departamento)
								<option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
						@endforeach
				</select>
			</div>
		</td>
		<td>
			<label class="col-md-2 control-label" align="center">Municipio</label>
			<div class="col-md-5">
				<select class="form-control" name="municipio_id" id='municipio_id' autofocus>
					<option value="0">Ningun Municipio</option>
						@foreach ($municipios as $municipio)
								<option value="{{$municipio->id}}">{{$municipio->nombre}}</option>
						@endforeach
				</select>
			</div>
		</td>
	</tr>
</table>
<div class="box-footer">
		<button type="submit" class="btn btn-primary">
			<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
			Buscar
		</button>
	</div>
