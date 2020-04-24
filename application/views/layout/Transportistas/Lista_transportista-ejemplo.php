<!--__________________TABLA___________________________-->
	<table id="tabla_transportistas" class="table table-bordered table-striped">
		<thead class="thead-dark" bgcolor="#eeeeee">
				<th>Acciones</th>
				<th>Nombre / Razon social</th>
				<th>Descripcion</th>
				<th>Registro</th>
		</thead>
		<tbody>
			<?php
				if($transportistas)
				{
					foreach($transportistas as $fila)
					{					
						echo "<tr data-json='".json_encode($fila)."' id='".$fila->tran_id."'>";
						echo    '<td>';
						echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modalEdit" id="btnEditar"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp					
										<button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
										
										<button type="button" title="eliminar" class="btn btn-primary btn-circle btnDelete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';                            
						echo   '</td>';
						echo    '<td>'.$fila->razon_social.'</td>';
						echo    '<td>'.$fila->descripcion.'</td>';
						echo    '<td>'.$fila->registro.'</td>';                       
						echo '</tr>';
					}
				}
			?>
		</tbody>
	</table>

<!--__________________FIN TABLA___________________________-->

<!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->

<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Transportista</h5>
            </div>

            <div class="modal-body">

							<!--__________________ FORMULARIO MODAL ___________________________-->

							<form method="POST" autocomplete="off" id="frm_transportista" class="registerForm">
								<div class="modal-body">
										<div class="row">
												<div class="col-md-6">
														<!-- Id de transportista y Usuario-->
														<div class="form-group">                                
																<input type="text" class="form-control" id="tran_id" name="tran_id" style="display:none;">
																<input type="text" class="form-control" id="usuario_app_edit" name="usuario_app" style="display:none;">
														</div>
														<!--_____________________________________________-->
														<!--Nombre/Razon social-->

														<div class="form-group">
																<label for="razon_social_edit" name="razon_social_edit">Nombre / Razon social:</label>
																<input type="text" class="form-control" id="razon_social_edit" name="razon_social">
														</div>
														<!--_____________________________________________-->

												</div>
												<div class="col-md-6">

														<!--Registro-->

														<div class="form-group">
																<label for="registro_edit" name="registro_edit">Registro:</label>
																<input type="text" class="form-control" id="registro_edit" name="registro">
														</div>
												</div>                         
										</div>

										<div class="row">
												<div class="col-md-6">

														<!--_____________________________________________-->
														<!--Direccion-->

														<div class="form-group">
																<label for="direccion_edit" name="direccion_edit">Direccion:</label>
																<input type="text" class="form-control" id="direccion_edit" name="direccion">
														</div>

														<!--_____________________________________________-->
														<!--Telefono-->

														<div class="form-group">
																<label for="telefono_edit" name="telefono_edit">Telefono:</label>
																<input type="text" class="form-control" id="telefono_edit" name="telefono">
														</div>
												</div> 
												<div class="col-md-6">
														<!--_____________________________________________-->
														
														<!--Fecha de alta-->                

														<div class="form-group">
																<label for="fec_alta_edit" name="fec_alta_edit" class="form-label label-sm">Fecha de alta:</label>                                              
																<div class="input-group date">
																		<div class="input-group-addon">
																				<i class="fa fa-calendar"></i>
																		</div>
																		<input type="date" class="form-control pull-right" name="fec_alta" id="fec_alta_edit">
																</div>
																
														</div>
												</div>
										</div>

										<div class="row">
												<div class="col-md-6"> 
													<!--_____________________________________________-->
													<!--Descripcion-->

															<div class="form-group">
																	<label for="descripcion_edit" name="descripcion_edit">Descripcion:</label>
																	<input type="text" class="form-control" id="descripcion_edit" name="descripcion">
															</div>
													
													<!--_____________________________________________-->
													<!--Contacto-->

															<div class="form-group">
																	<label for="contacto_edit" name="contacto_edit">Contacto:</label>
																	<input type="text" class="form-control" id="contacto_edit" name="contacto" >
															</div>
												</div>
												<div class="col-md-6"> 

														<!--_____________________________________________-->
														<!--Fecha baja-->

														<div class="form-group">
																<label for="fec_baja_efectiva" name="fec_baja_efectiva">Fecha de baja:</label>
																<div class="input-group date">
																		<div class="input-group-addon">
																				<i class="fa fa-calendar"></i>
																		</div>
																		<input type="date" class="form-control pull-right" name="fec_baja_efectiva" id="fec_baja_efectiva">
																</div>
														</div>														
														<!--_____________________________________________-->
														<!--Tipo RSU autorizado-->

														<div class="form-group">
																<label for="tipoResiduos">Tipos de residuo:</label>
																<div class="input-group date">
																		<div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
																		<select class="form-control select4 pull-right" multiple="multiple"  data-placeholder="Seleccione tipo residuo"  style="width: 100%;" id="tica_edit">
																			
																		</select>            
																</div>
														</div>
												</div>
										</div>


										<div class="row">
											<div class="col-md-6"> 
												<!--_____________________________________________-->
												<!--Cuit-->

														<div class="form-group">
																<label for="cuit_edit" name="cuit_edit">Cuit:</label>
																<input type="text" class="form-control" id="cuit_edit" name="cuit">
														</div>
											</div>	
											<div class="col-md-6"> 
												<!--_____________________________________________-->
												<!--Resolucion-->

														<div class="form-group">
																<label for="resolucion_edit" name="resolucion_edit">Resolucion:</label>
																<input type="text" class="form-control" id="resolucion_edit" name="resolucion">
														</div>
											</div>	
										</div>			



								</div>
							</form>

							<!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" data-dismiss="modal" id="btnsave">Guardar</button>
                    <button type="submit" class="btn btn-default" id="" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!---//////////////////////////////////////--- FIN MODAL EDITAR ---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- MODAL AVISO ---///////////////////////////////////////////////////////----->
	<div class="modal fade" id="modalaviso">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bg-blue">
					<h5 class="modal-title" ><span class="fa fa-fw fa-times-circle" style="color:#A4A4A4"></span>  Eliminar</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" >&times;</span>
					</button>
				</div>
				<input id="transp_delete" style="display: none;">
				<div class="modal-body">
					<center>
					<h4><p>¿ DESEA ELIMINAR TRANSPORTISTA ?</p></h4>
					</center>
				</div>
				<div class="modal-footer">
					<center>
					<button type="button" class="btn btn-primary" onclick="eliminar()">SI</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
					</center>
				</div>
			</div>
		</div>
	</div>
<!---//////////////////////////////////////--- MODAL AVISO ---///////////////////////////////////////////////////////----->


<script>
	
	// llena modal solo lectura
	$(".btnInfo").on("click", function() {
		datajson = $(this).parents("tr").attr("data-json");
		llenarModal(datajson);	
		blockEdicion();
	});

	// llena modal para edicion
	$(".btnEditar").on("click", function() {
		datajson = $(this).parents("tr").attr("data-json");
		llenarModal(datajson);
		habilitarEdicion();
	});

	//bloquea campos en modal
	function blockEdicion(){
		
		$("input#razon_social_edit").attr("readonly","readonly");		
		$("input#direccion_edit").attr("readonly","readonly");
		$("input#telefono_edit").attr("readonly","readonly");
		$("input#descripcion_edit").attr("readonly","readonly");
		$("input#contacto_edit").attr("readonly","readonly");
		$("input#registro_edit").attr("readonly","readonly");
		$('input#fec_alta_edit').attr("readonly","readonly");
		$('input#fec_baja_efectiva').attr("readonly","readonly");
		$('input#cuit_edit').attr("readonly","readonly");
		$('input#resolucion_edit').attr("readonly","readonly");		
		$('#btnsave').hide();
	}

	//desbloquea campos en modal
	function habilitarEdicion(){
	
		$("input#razon_social_edit").removeAttr("readonly");		//
		$("input#direccion_edit").removeAttr("readonly");//
		$("input#telefono_edit").removeAttr("readonly");//
		$("input#descripcion_edit").removeAttr("readonly");//
		$("input#contacto_edit").removeAttr("readonly");//
		$("input#registro_edit").removeAttr("readonly");//
		$('input#fec_alta_edit').removeAttr("readonly");//
		$('input#fec_baja_efectiva').removeAttr("readonly");//
		$('input#cuit_edit').removeAttr("readonly");//
		$('input#resolucion_edit').removeAttr("readonly");//
		$('#btnsave').show();	
	}

	//llena modal Editar
	function llenarModal(datajson){

		data = JSON.parse(datajson);

		$("input#usuario_app_edit").val('hugoDS'); //FIXME: DESHARDCODEAR USUARIO

		$("input#tran_id").val(data.tran_id);			
		$("input#razon_social_edit").val(data.razon_social);			
		$("input#direccion_edit").val(data.direccion);
		$("input#telefono_edit").val(data.telefono);
		$("input#descripcion_edit").val(data.descripcion);
		$("input#contacto_edit").val(data.contacto);
		$("input#registro_edit").val(data.registro);	
		$("input#cuit_edit").val(data.cuit);
		$("input#resolucion_edit").val(data.resolucion);	
		// formateo fecha en input tipo date
		var fecha_alta = data.fec_alta.slice(0, 10)	// saco hs y minutos
		Date.prototype.toDateInputValue = (function() {
			var local = new Date(fecha_alta);
			// local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
			return local.toJSON().slice(0, 10);
		});
		$('input#fec_alta_edit').val(new Date().toDateInputValue());
		// formateo fecha en input tipo date
		var fecha_baja = data.fec_baja_efectiva.slice(0, 10)	// saco hs y minutos
		Date.prototype.toDateInputValue = (function() {
			var local = new Date(fecha_baja);
			// local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
			return local.toJSON().slice(0, 10);
		});
		$('input#fec_baja_efectiva').val(new Date().toDateInputValue());
	
		// $.each(data.tiposCarga.cargas, function(key,rsu_asociado){
		// 	//var rsu_asociado = rsu_asociado.valor;
		// 	console.log('tipo carga asociado' + rsu_asociado.valor);
		// 	console.log("id debasura: " + rsu_asociado.tica_id);
		// });
		// llena select tipo de residuos marcando los ya asociados a transportista
		$.ajax({
				type: "POST",
				//data: {transportista, tipo_carga, tran_id},
				url: "general/Estructura/Transportista/obtener_RSU",
				success: function (result) {
					// console.log('respuesta tipos carga todos: ');	
					// console.table(result);
					$('.select4').find('option').remove();
					$('.select4').select2();
					
						var tipos = JSON.parse(result);		
						var opcGuardadas = [];
						// recorro todos los tipos de carga 
						$.each(tipos, function(key,rsu){			

							// console.log(' tipo de rsu tabl_id: ' + rsu.tabl_id);	
							// console.log(' tipo de rsu valor: ' + rsu.valor);
							console.log("agrego afuera");
							$('select#tica_edit').append("<option value='" + rsu.tabl_id + "'>" +rsu.valor+"</option"); 
							//$('select#tica_edit').trigger('change');	

								// recorro los tipos de carga asociados
								$.each(data.tiposCarga.cargas, function(key,rsu_asociado){									

									// console.log('rsu asociado tica_id: ' + rsu_asociado.tica_id);
									// console.log('rsu asociado valor: ' + rsu_asociado.valor);
									 if (rsu_asociado.tica_id == rsu.tabl_id) {

											console.log('coincide: ' + rsu.tabl_id + ' con ' + rsu_asociado.tica_id);
										
											opcGuardadas.push(rsu.tabl_id);
											//$('select#tica_edit').trigger('change');
									 }
									//  else {
									// 	 	console.log("agrego afuera");
									// 	 $('select#tica_edit').append("<option value='" + rsu.tabl_id + "'>" +rsu.valor+"</option"); 
									// 		$('select#tica_edit').trigger('change');	
									//  }	

								});									

						});
						//$('.select4').select2();
						$('select#tica_edit').val(opcGuardadas);
				}
		});
	}

	//boton guardar
	$("#btnsave").on("click", function() {
		//tomo datos del form y hago objeto
    var transportista = new FormData($('#frm_transportista')[0]);
    transportista = formToObject(transportista);    
		var tipo_carga = $("#tica_edit").val();		
		//tomo tran_id y lo hago objeto para enviar
		var tran = $("#tran_id").val();		
		var tran_id = {tran_id: tran};

		$.ajax({
				type: "POST",
				data: {transportista, tipo_carga, tran_id},
				url: "general/Estructura/Transportista/Modificar_Transportista",
				success: function (result) {
						
					$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Transportista/Listar_Transportista");
				}
		});
	});	

	//levanta modal y guarda tran_id
	$(".btnDelete").on("click", function() {
		datajson = $(this).parents("tr").attr("data-json");
		data = JSON.parse(datajson);
		var tran_id = data.tran_id;
		// guardo tran_id en modal para usar en funcion eliminar
		$("#transp_delete").val(tran_id);
		//levanto modal	
		$("#modalaviso").modal('show');		
	});

	//elimina transp y recarga la tabla
	function eliminar(){
		var tran_id = $("#transp_delete").val();
		$.ajax({
				type: "POST",
				data: {tran_id:tran_id},
				url: "general/Estructura/Transportista/Borrar_Transportista",
				success: function(result) {
					
					$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Transportista/Listar_Transportista");	
					$("#modalaviso").modal('hide');
				},
				error: function(result){
					$("#modalaviso").modal('hide');
				}
		});
	}

	// inicializo tabla
	DataTable($('#tabla_transportistas'));	
	
	//Initialize Select2 Elements
	// $('.select4').select2();
</script>
           
