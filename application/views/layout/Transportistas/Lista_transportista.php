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

<!---///////--- MODAL EDITAR ---///////--->
	<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
						<div class="modal-header bg-blue">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
								</button>
								<h5 class="modal-title" id="exampleModalLabel">Editar Transportista</h5>
						</div>

						<div class="modal-body col-md-12 col-sm-12 col-xs-12">
							<!--__________________ FORMULARIO MODAL ___________________________-->
								<form method="POST" autocomplete="off" id="frm_transportista" class="registerForm">	

									<!-- Id de transportista y Usuario-->
										<div class="form-group">                                
											<input type="text" class="form-control habilitar" id="tran_id" name="tran_id" style="display:none;">
											<input type="text" class="form-control habilitar" id="usuario_app_edit" name="usuario_app" style="display:none;">
										</div>
									<!--______________________________-->

									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">

											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<!--Nombre/Razon social-->
															<div class="form-group">
																<label for="razon_social_edit" name="razon_social_edit">Razon social:</label>
																<input type="text" class="form-control habilitar" id="razon_social_edit" name="razon_social" size="30%">
															</div>
													<!--___________________-->
											</div>
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<!--Registro-->
														<div class="form-group">
															<label for="registro_edit" name="registro_edit">Registro:</label>
															<input type="text" class="form-control habilitar" id="registro_edit" name="registro" size="20%">
														</div>
													<!--____________________-->
											</div>

									</div>
									
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!--Direccion-->
											<div class="form-group">
												<label for="direccion_edit" name="direccion_edit">Direccion:</label>
												<input type="text" class="form-control habilitar" id="direccion_edit" name="direccion" size="40%">
											</div>
											<!--_________________-->
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!--Telefono-->
											<div class="form-group">
												<label for="telefono_edit" name="telefono_edit">Telefono:</label>
												<input type="text" class="form-control habilitar" id="telefono_edit" name="telefono" size="40%">
											</div>											
											<!--________-->
										</div>	
									</div>

									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!--Fecha de alta-->
											<div class="form-group">
												<label for="fec_alta_edit" name="fec_alta_edit" class="form-label label-sm">Fecha de alta:</label>                                              
												<div class="input-group date">
														<div class="input-group-addon">
																<i class="fa fa-calendar"></i>
														</div>
														<input type="date" class="form-control habilitar pull-right" name="fec_alta" id="fec_alta_edit">
												</div>																
											</div>											
											<!--_________-->
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!--Descripcion-->
											<div class="form-group">
												<label for="descripcion_edit" name="descripcion_edit">Descripcion:</label>
												<input type="text" class="form-control habilitar" id="descripcion_edit" name="descripcion">
											</div>													
											<!--__________-->
										</div>
									</div>	

									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!--Contacto-->
											<div class="form-group">
												<label for="contacto_edit" name="contacto_edit">Contacto:</label>
												<input type="text" class="form-control habilitar" id="contacto_edit" name="contacto" >
											</div>	
											<!--________-->
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!--Fecha baja-->
											<div class="form-group">
												<label for="fec_baja_efectiva" name="fec_baja_efectiva">Fecha de baja:</label>
												<div class="input-group date">
														<div class="input-group-addon">
																<i class="fa fa-calendar"></i>
														</div>
														<input type="date" class="form-control habilitar pull-right" name="fec_baja_efectiva" id="fec_baja_efectiva">
												</div>
											</div>														
											<!--_________-->
										</div>
									</div>	

									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!--Resolucion-->
											<div class="form-group">
												<label for="resolucion_edit" name="resolucion_edit">Resolucion:</label>
												<input type="text" class="form-control habilitar" id="resolucion_edit" name="resolucion">
											</div>
										<!--__________-->
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!-- Cuit -->
											<div class="form-group">
												<label for="cuit_edit" name="cuit_edit">Cuit:</label>
												<input type="text" class="form-control habilitar" id="cuit_edit" name="cuit">
											</div>											
											<!--______-->
										</div>
									</div>	

									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<!--Tipo RSU autorizado-->
											<div class="form-group">
												<label for="tipoResiduos">Tipos de residuo:</label>
												<div class="input-group date">
														<div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
														<select class="form-control habilitar select4" multiple="multiple"  data-placeholder="Seleccione tipo residuo"  size="40%" style="width: 100%; min-width: 30px;" id="tica_edit">
														</select>            
												</div>
											</div>
											<!--___________________-->
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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
<!---///////--- FIN MODAL EDITAR ---///////--->

<!---///////--- MODAL AVISO ---///////--->
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
<!---///////--- FIN MODAL AVISO ---///////--->

<!--- SCRIPTS --->
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

		$(".habilitar").attr("readonly","readonly");	
		$('#btnsave').hide();
	}

	//desbloquea campos en modal
	function habilitarEdicion(){

		$('.habilitar').removeAttr("readonly");//
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
	
		$.ajax({
				type: "POST",
				//data: {transportista, tipo_carga, tran_id},
				url: "general/Estructura/Transportista/obtener_RSU",
				success: function (result) {
					
						$('.select4').find('option').remove();							
						var tipos = JSON.parse(result);		
						var opcGuardadas = [];
						// recorro todos los tipos de carga 
						$.each(tipos, function(key,rsu){
								//agrega las opciones de RSU
								$('select#tica_edit').append("<option value='" + rsu.tabl_id + "'>" +rsu.valor+"</option");		
								// recorro los tipos de carga asociados
								$.each(data.tiposCarga.cargas, function(key,rsu_asociado){
									 if (rsu_asociado.tica_id == rsu.tabl_id) {	
											opcGuardadas.push(rsu.tabl_id);										
									 }									
								});								
						});
						// seteo as opciones predeterminadas
						$('select#tica_edit').val(opcGuardadas);
				}
		});
	}

	//boton guardar
	$("#btnsave").on("click", function() {
		//tomo datos del form y hago objeto
    var transportista = new FormData($('#frm_transportista')[0]);
    transportista = formToObject(transportista);    

		$.ajax({
				type: "POST",
				data: {transportista, tipo_carga},
				url: "general/Estructura/Transportista/Modificar_Transportista",
				success: function (result) {
					
					if(result == 'error_transportista'){
						alertify.error("Hubo un error a modificar Transportista");
					}else{
						$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Transportista/Listar_Transportista");
						alertify.success("Transportista modificado con exito...");
					}						
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
	$('.select4').select2();
</script>
           
