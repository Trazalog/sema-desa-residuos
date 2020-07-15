<h4>Confirma Pedido Modificado</h4>

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
<!--_________________SEPARADOR_________________-->

<div class="col-md-12 col-sm-12 col-xs-12">
	<!--_____________ Generador _____________-->
		<div class="form-group">															
			<label for="Generador" class="col-sm-4 control-label">Generador:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control habilitar" name="Generador" value="<?php echo $infoSolicitud->razon_social?>" id="generador" readonly> 
			</div>	
		</div>
	<!--__________________________-->
    <!--_____________ Nro Pedido _____________-->
		<div class="form-group">															
			<label for="NroPedido" class="col-sm-4 control-label">Nro Pedido:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control habilitar" name="NroPedido" value="<?php echo $infoSolicitud->sotr_id?>" id="nroPedido" readonly> 
			</div>	
		</div>
	<!--__________________________-->
      <!--_____________ Direccion _____________-->
		<div class="form-group">															
			<label for="Direcc" class="col-sm-4 control-label">Direccion:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control habilitar" name="Direcc" value="<?php echo $infoSolicitud->domicilio?>" id="Direccion" readonly> 
			</div>	
		</div>
	<!--__________________________-->
     <!--_____________ fecha de retiro_____________-->
		<div class="form-group">															
			<label for="Fecha_ret" class="col-sm-4 control-label">Fecha de retiro:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control habilitar" name="Fecha_ret" value="<?php echo $infoSolicitud->fec_alta?>" id="FechaRet" format="YYYY-MM-DD" readonly> 
			</div>	
		</div>
	<!--__________________________-->
</div>
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
									//echo "<tr data-json= >";
										echo "<td>".$fila->valor."</td>";
										echo "<td>".$fila->cantidad."</td>";										
                                        echo "<td>".$fila->cantidad_acordada."</td>";
                                        // echo "<td> <input id='' style='border:none;' placeholder='Ingrese cantidad'> </td>";
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

<!--_____________ motivo de rechazo _____________-->
<div class="col-md-12 col-sm-12 col-xs-12">
	<!--_____________ Descripcion _____________-->
		<div class="form-group">															
			<label for="motivo" class="col-sm-4 control-label">Motivo rechazo:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control habilitar" name="descripcion" value="<?php echo $infoSolicitud->observaciones?>" id="motivo" readonly> 
                
			</div>	
		</div>
	<!--__________________________-->
</div>

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
<!--_________________SEPARADOR_________________-->

<div class="text-right">
	<button class="btn btn-success estadoTarea" id="acepta" onclick="cerrarConfirma('acepta')">Acepta Solicitud</button>
	<button class="btn btn-primary estadoTarea" id="noAcepta" onclick="cerrarConfirma('rechaza')" style="margin-left:20px;">Rechaza Solicitud</button>
</div>


<script>
//deshabilita los botones originales de la notificacion estandar						
$(document).ready(function(){
	$('.btnNotifEstandar').hide();
});	

// Datatable	
DataTable($('#tbl_contenedores'));	

function cerrarConfirma(opcion)
{
	debugger;
	var taskId = $('#taskId').val();
	var elegido = {opcion: opcion};	
	$.ajax({
				type: 'POST',
				data:{ elegido },
				url: 'traz-comp-bpm/Proceso/cerrarTarea/' + taskId,
				success: function(result) {
					
									alert(result);

									wc();
									if( result.status ){										
										alertify.success("Tarea completada exitosamente...");	
									}else{
										alertify.error('Error en completar la Tarea...');
									}
								},
				error: function(result){
									wc();
							 },
				complete: function(){
									wc();
										if(existFunction('cerrarTarea')){
											cerrarTarea();
										}	
									}
		});
}

</script>