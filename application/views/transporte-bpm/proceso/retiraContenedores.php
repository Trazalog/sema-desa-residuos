<h4>Retira Contenedores</h4>

<!-- ______ TABLA PRINCIPAL DE PANTALLA ______ -->
<table id="tabla_contenedores" class="table table-bordered table-striped">
		<thead class="thead-dark" bgcolor="#eeeeee">
				<th>Seleccionar</th>
				<th>Codigo</th>
				<th>Contenedor</th>
				<th>Tipo Residuo</th>	
				<th>% de Llenado</th>
				<th>mts3</th>
		</thead>
		<tbody >
			<?php  
				if($contenedores)
				{
					$i=1;
					foreach($contenedores as $fila)
					{

						echo "<tr id='".$i."' data-registro='".$i."' data-json='".json_encode($fila)."'>";
							// echo "<td><button type='button' title='Eliminar' class='btn btn-primary btn-circle btnEliminar' id='btnBorrar'><span class='glyphicon glyphicon-ok' aria-hidden='true' ></span></button>&nbsp</td>";
							echo "<td> <input type='checkbox' id='".$i."' name='cont' value='".$i."'></td>";
							echo "<td>".$fila->cont_id."</td>";						
							echo "<td>".$fila->coen_id."</td>";
							echo "<td>".$fila->valor."</td>";					
							echo "<td>".$fila->porc_llenado."</td>";
							echo "<td>".$fila->mts_cubicos."</td>";
						echo '</tr>';
						$i++;
					}
				}
			?>
		</tbody>
</table>	
<!--_______ FIN TABLA PRINCIPAL DE PANTALLA ______-->

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"><br></div>
<!--_________________SEPARADOR_________________-->

<!--_____________ VEHICULO _____________-->
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="form-group">																
			<label for="vehiculo" class="col-sm-4 control-label">Vehiculo:</label>
			<div class="col-sm-8">
				<!-- <input type="text" class="form-control habilitar" id="vehiculo_edit">  -->
				<select class="form-control select2 select2-hidden-accesible selec_habilitar" name="vehi_id" id="vehiculo">
					<option value="" disabled selected>-Seleccione opcion-</option>	
					<?php
						foreach ($vehiculos as $vehic) {
							echo '<option  value="'.$vehic->equi_id.'">'.$vehic->dominio.'</option>';
						}
					?>
				</select>
			</div>										
	</div> 	
</div>	
<!--__________________________-->	

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"><br></div>
<!--_________________SEPARADOR_________________-->

<!--_________________ Agregar _________________-->
<div class="col-md-12">
		<button class="btn btn-primary pull-right" onclick="agregar()">Agregar</button>
</div>
<!--__________________________________-->

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
<!--_________________SEPARADOR_________________-->



<!-- ______ TABLA TEMPORAL ______ -->
<table id="tbl_temporal" class="table table-bordered table-striped">
		<thead class="thead-dark" bgcolor="#eeeeee">
				<th>Borrar</th>
				<th>Contenedor</th>
				<th>Dominio</th>					
		</thead>
		<tbody >
		</tbody>
</table>						
<!--_______ FIN TABLA TEMPORAL ______-->

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
<!--_________________SEPARADOR_________________-->


<div class="text-right">	
	<button class="btn btn-primary estadoTarea" id="noAcepta" onclick="guardar()" style="margin-left:20px;">Confirmar Retiro</button>
	<button class="btn btn-success estadoTarea" id="acepta" onclick="cerrar()">Cerrar</button>
</div>

</div>

<script>

function agregar(){

	var dom = $("#vehiculo").val();
	
	if(dom == null){
		alert("Por favor seleccione un vehiculo");
		return;
	}
	
	var rows = new Array();
	$("input:checkbox:checked").each( function() { 

			var datos = $(this).parents("tr").attr("data-json");		
			var reg = $(this).parents("tr");
			var id_row = $(this).parents("tr").attr("data-registro");
			if (datos != null) {	

				var d = JSON.parse(datos);
				var dom= $("#vehiculo").val();
				// dibujar tabla temporal
				if (!(reg).hasClass("hidden")) {
					
					$("#tbl_temporal").DataTable().row.add([
						'<button type="button" title="Eliminar" class="btn btn-primary btn-circle btnEliminar" onclick="sacar('+ id_row +')"><span class="glyphicon glyphicon-trash" aria-hidden="true" ></span></button>',
						d.coen_id,
						dom
					]).draw().node().id = id_row;
					//oculto el registro de la tabla principal
					reg.addClass('hidden');
				} 			
			}	
  });	
}

function sacar(data){

		// remueve el registro de la tabl temporal
		$("#tbl_temporal").DataTable().row( 'tr#'+data ).remove().draw();
		// vuelve a mostrar el registro en la tabla original
	  $("#tabla_contenedores tbody tr#"+data).removeClass("hidden");
}

function guardar(){

	wo();
	// valida si el retiro es completo
		var rows = $("#tabla_contenedores tbody tr");
		var retiro = {};
		retiro.retiroCompleto = true;

		rows.each( function() {

			if (! $(this).hasClass("hidden")) {	
				retiro.retiroCompleto = false;
				return;
			}		
		});
	// arma objeto contenedores y id vehiculo
		var taskId = $('#taskId').val();
		var fila = $("#tbl_temporal tbody tr");
		var contAsign = [];

		fila.each(function(i,e) { 

			var contenedor= $(this).find("td").eq(1).html();	
			var vehiculo = $(this).find("td").eq(2).html();	
			tmp = {};		
			tmp.coen_id = contenedor;
			tmp.equi_id = vehiculo;
			contAsign.push(tmp);
		});		

	// cierra tarea y guarda en tablas
	$.ajax({
			type: 'POST',
			data:{ contAsign, retiro },
			url: 'traz-comp-bpm/Proceso/cerrarTarea/' + taskId,
			success: function(result) {

						wc();
						resp = JSON.parse(result);
						if(resp["msj"] == 'OK'){
							alertify.success("Retiro de contenedores confirmado...");
							recargaBandejaEntrada();
						}else{
							alertify.error('Error en confirmación Retiro de contenedores....');
						}						
			},
			error: function(result){

						wc();
						alertify.error('Error en confirmación Retiro de contenedores....');
			},
			complete: function(){

						wc();
						recargaBandejaEntrada();
						if(existFunction('cerrarTarea')){
							cerrarTarea();
						}		
			}
	});

}

// Datatable	
	DataTable($('#tabla_contenedores'));

	
//deshabilita los botones originales de la notificacion estandar						
	$(document).ready(function(){
			$('.btnNotifEstandar').hide();
	});

// recarga la bandeja de entrada al cerrar la tarea
function recargaBandejaEntrada()
{
  linkTo('<?php echo BPM ?>Proceso/index');
}

</script>



