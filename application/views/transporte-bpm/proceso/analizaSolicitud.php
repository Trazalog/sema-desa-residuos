<h4>Analiza Solicitud de Contenedores</h4>

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
<!--_________________SEPARADOR_________________-->

<!--_____________ Tabla info soliccitaodos _____________-->
<div class="box-body table-scroll">
			<table id="tbl_contenedores" class="table table-bordered table-striped">
				<thead class="thead-dark" bgcolor="#eeeeee">				
						<tr>
								<th>Tipo Residuo</th>
								<th>Cantidad Solicitada</th>
								<th>Cantidad Propuesta</th>
						</tr>
				</thead>
				<tbody>
						<?php
							if($infoContenedores)
							{
								foreach($infoContenedores as $fila)
								{
									echo "<tr data-json='".json_encode($fila)."'>";
										echo "<td>".$fila->valor."</td>";
										echo "<td>".$fila->cantidad."</td>";
										echo "<td> <input id='' style='border:none;' placeholder='Ingrese cantidad'> </td>";
									echo '</tr>';
								}
							}
						?>
				</tbody>
		</table>
</div>
<!--_____________ Fin taba _____________-->

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"></div>
<!--_________________SEPARADOR_________________-->

<!--_____________ Observaciones _____________-->
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="form-group">
      <label for="disabledTextInput">Observaciones</label>
	<textarea class="form-control" rows="3" readonly><?php echo $infoSolicitud->observaciones ?></textarea>
</div>
</div>

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"><br></div>
<!--_________________SEPARADOR_________________-->

<!--_____________ motivo de rechazo _____________-->
<div class="col-md-12 col-sm-12 col-xs-12">
	<!--_____________ Descripcion _____________-->
		<div class="form-group">
			<!-- <label for="motivo" class="col-sm-4 control-label">Motivo rechazo:</label> -->
			<label for="motivo" class="disabledTextInput">Motivo rechazo:</label>
			<textarea class="form-control" id="motivo" rows="3" placeholder="Si rechaza la soicitud, por favor ingrese el motivo..."></textarea>
		</div>
	<!--__________________________-->
</div>

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
<!--_________________SEPARADOR_________________-->

<div class="text-right">
	<button class="btn btn-success estadoTarea" id="acepta" onclick="cerrarAnalisis('acepta')">Acepta Solicitud</button>
	<button class="btn btn-primary estadoTarea" id="noAcepta" onclick="cerrarAnalisis('rechaza')" style="margin-left:20px;">Rechaza Solicitud</button>
</div>

<script>

	//deshabilita los botones originales de la notificacion estandar						
	$(document).ready(function(){
			$('.btnNotifEstandar').hide();
	});						

	function recargaBandejaEntrada()
	{
		debugger;
		linkTo('<?php echo BPM ?>Proceso/index');
	}

	// para guardar						
	function cerrarAnalisis(opcion){

		wo();
		var taskId = $('#taskId').val();
		var elegido = {opcion: opcion};
		var contAcordados = [];		
		var vacio = 0;
		var igualCant = 0;
		var motivo = {};
		var rows = $('#tbl_contenedores tbody tr');
		var coincideCant = {};

		// recorre tabla guardando datos para enviar
		rows.each(function(i,e) {

				datajson = $(this).attr("data-json");
				data = JSON.parse(datajson); 
				var solicit= $(this).find("td").eq(1).html();			
				var propuesta= $(this).find("td").eq(2).find("input").val();
				var tmp = {};
				tmp.soco_id = data.soco_id;
				tmp.tica_id = data.tica_id;
				tmp.cantidad_acordada = propuesta;
				contAcordados.push(tmp);
				// si esta vacio el campo propuesta				
				if(propuesta === ""){	
					vacio = 1;
					return vacio; 					
				}	
				//si las cantidades no coinciden
				if (solicit != propuesta) {
					igualCant += 1;
				}			
		});
		// si los campos cantidad estan vacios
		if (vacio == 1) {
			alert("Por favor complete el/los campos Cantidad Propuesta");
			wc();
			return;
		}
		//  Si rechaza la solicitud
		if (opcion == "rechaza") {
			
			// si el campo motivo esta vacio
			var motRech = $('#motivo').val();
			if(motRech === ""){
					wc();
					alert('Por favor ingrese el Motivo de Rechazo');
					return;
			}else{
					motivo.motivo = motRech;
			}	
		}else{

			$('#motivo').val("");  // si acepta se vacia el campo motivo
		}

		// si las cantidades no coinciden
		if (igualCant > 0) {						
			coincideCant.cantIguales = 0;					
		}else{					
			coincideCant.cantIguales = 1;
		}

		$.ajax({
				type: 'POST',
				data:{ elegido, coincideCant, contAcordados, motivo },
				dataType: "json",
				url: 'traz-comp-bpm/Proceso/cerrarTarea/' + taskId,
				success: function(result) {
					debugger;
									wc();
									if(result.status){
										alertify.success("Respuesta enviada exitosamente...");
										recargaBandejaEntrada();
									}else{
										alertify.error('Error al enviar respuesta...');
										recargaBandejaEntrada();
									}
								},
				error: function(result){
									wc();
									recargaBandejaEntrada();
							 },
				complete: function(){
									wc();
									recargaBandejaEntrada();

									}
		});
	}


	// Datatable
	DataTable($('#tbl_contenedores'));	
</script>



