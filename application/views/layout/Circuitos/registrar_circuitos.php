<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->
	<div class="box box-primary animated fadeInLeft">
			<div class="box-header with-border">
					<h4>Registrar Circuitos</h4>
			</div>
			<div class="box-body">
					<div class="row">
							<div class="col-md-2 col-lg-1 col-xs-12">
									<button type="button" id="botonAgregar" class="btn btn-primary" aria-label="Left Align">
											Agregar
									</button><br>
							</div>
							<div class="col-md-10 col-lg-11 col-xs-12"></div>
					</div>
			</div>
	</div>
<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<!---//////////////////////////////////////--- BOX 1 ---///////////////////////////////////////////////////////----->
	<div class="box box-primary animated bounceInDown" id="boxDatos" hidden>
			<div class="box-header with-border">
					<div class="box-tittle">
							<h5>Informacion</h5>
					</div>
					<div class="box-tools pull-right border ">
							<button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
									data-toggle="tooltip" title="" data-original-title="Remove">
									<i class="fa fa-times"></i>
							</button>
					</div>
			</div>
			<!--_____________________________________________-->

			<div class="box-body">

					<form class="formCircuitos" id="formCircuitos">
							<!--_____________________________________________-->
							<!--Codigo-->
							<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
											<label for="Codigo">Codigo:</label>
											<div class="input-group date">
													<div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
													<input type="number" class="form-control" name="codigo" id="codigo" required>
											</div>
									</div>
							</div>
							<!--_____________________________________________-->
							<!--Tipo de residuo-->
							<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
											<label for="tipoResiduos">Tipo de residuo:</label>
											<div class="input-group date">
													<div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
													<select class="form-control select3" multiple="multiple"  data-placeholder="Seleccione tipo residuo"  style="width: 100%;"  id="tica_id">															
															<?php
																	foreach ($tipoResiduos as $i) {		
																			echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
																	}
															?>
													</select>
											</div>
									</div>
							</div>
							<!--_____________________________________________-->
							<!--Descripcion-->
							<div class="col-md-12">
									<div class="form-group">
											<label for="Descripcion">Descripcion:</label>
											<textarea style="resize: none;" type="text" class="form-control" name="descripcion"
													id="descripcion"></textarea>
									</div>
							</div>
							<!--_____________________________________________-->
							<!--vehiculo-->
							<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
											<label for="Vehiculo">Vehiculo:</label>
											<div class="input-group date">
													<div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
													<select class="form-control select2 select2-hidden-accesible" name="vehi_id" id="vehi_id">
															<option value="" disabled selected>-Seleccione opcion-</option>
															<?php
																	foreach ($Vehiculo as $i) {
																	echo '<option  value="'.$i->equi_id.'">'.$i->dominio.'</option>';                         
																	
																	}
													?>
													</select>
											</div>
									</div>
							</div>
							<!--_____________________________________________-->

							<!--Chofer-->
							<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
											<label for="Chofer">Chofer:</label>
											<div class="input-group date">
													<div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
													<select class="form-control select2 select2-hidden-accesible" name="chof_id" id="chof_id">
															<option value="" disabled selected>-Seleccione opcion-</option>
															<?php
													foreach ($Chofer as $i) {
															echo '<option  value="'.$i->chof_id.'">'.$i->nombre." ".$i->apellido.'</option>';
													}
													?>
													
													</select>

						
											</div>
									</div>
							</div>
							<!--_____________________________________________-->

							<!--_________________SEPARADOR_________________-->
							<div class="col-md-12">
									<hr>
							</div>
							<!--_________________SEPARADOR_________________-->

							<!--Adjuntador de imagenes-->
							<div class="col-md-12">
									<div class="col-md-6 col-sm-6 col-xs-12">									
											<input type="file" id="imagen" name="imagen" value=" ">		
									</div>
							</div>
					</form>
					
					<!--_____________ SEPARADOR _____________-->
					<div class="col-md-12 col-sm-12 col-xs-12"> <br> <br></div>
					<!--__________________________-->

					<!---//////////////////////////////////////--- REGISTRAR PUNTO CRITICO ---///////////////////////////////////////////////////////----->

					<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box box-primary">
											<div class="box-header with-border">
													<h4>Registrar Punto Critico</h4>
											</div>
									</div>
							</div>
					</div>

					<div class="col-md-12 col-sm-12 col-xs-12">

							<form class="formPuntos" id="formPuntos">
					
									<!--Nombre-->
									<div class="col-md-5 col-sm-5 col-xs-12">
											<div class="form-group">

													<label for="Codigo">Nombre:</label>
													<div class="input-group date">
															<div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
															<input type="text" class="form-control" name="nombre" id="nombre" >
													</div>
											</div>
									</div>
									<!--_____________________________________________-->
									
									<!--Descripcion-->
									<div class="col-md-5 col-sm-5 col-xs-12">
											<div class="form-group">

													<label for="Codigo">Descripcion:</label>
													<div class="input-group date">
															<div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
															<input type="text" class="form-control" name="descripcion" id="">
													</div>
											</div>
									</div>
									<!--_____________________________________________-->
									
									<!--Latitud-->
									<div class="col-md-5 col-sm-5 col-xs-12">
											<div class="form-group">
													<label for="Codigo">Latitud:</label>
													<div class="input-group date">
															<div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
															<input type="text" class="form-control" name="lat" id="lat" >
													</div>
											</div>
									</div>
									<!--_____________________________________________-->
									
									<!--Longitud-->
									<div class="col-md-5 col-sm-5 col-xs-12">
											<div class="form-group">

													<label for="Codigo">Longitud:</label>
													<div class="input-group date">
															<div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
															<input type="text" class="form-control" name="lng" id="lng" >
													</div>
											</div>
									</div>
									<!--_____________________________________________-->

									<!--_____________ Boton mapa _____________-->
									<div class="col-md-2 col-sm-2 col-xs-12">
											<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="form-group ">
															<small for="agregar" class="form-label">MAPA</small>
															<button type="button" class="btn btn-primary btn-circle" data-toggle="modal"
																	data-target="#modalmapa" aria-label="Left Align">
																	<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
															</button>
													</div>
											</div>
									</div>
									<!--_________________________-->

							</form>

							<!--_________________SEPARADOR_________________-->
							<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
							<!--_________________SEPARADOR_________________-->

							<!--_____________ Boton agregar _____________-->	
							<div class="col-md-12">
									<button type="submit" class="btn btn-default pull-right" onclick="Agregar_punto()">AGREGAR</button>
							</div>
							<!--__________________________-->

							<!--_________________SEPARADOR_________________-->
							<div class="col-md-12 col-sm-12 col-xs-12"> <br></div>
							<!--_________________SEPARADOR_________________-->


					</div>

					<!--_____________ SEPARADOR _____________-->
					<div class="col-md-12 col-sm-12 col-xs-12"> <br></div>
					<!--_____________ SEPARADOR _____________-->

					<!--_____________ Tabla Punto Critico _____________-->
					<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="box " id="puntos_criticos" style="display:none">
									<div class="box-body table-responsive">											
											<table class="table table-striped" id="datos">
													<thead class="thead-dark" bgcolor="#eeeeee">
															<th>Nombre</th>
															<th>Descripcion</th>
															<th>Latitud</th>
															<th>Longitud</th>
													</thead>	
													<tbody>	</tbody>
											</table>										
									</div>
							</div>
					</div>
					<!--_____________________________________________-->

					<!--_________________SEPARADOR_________________-->
					<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
					<!--_________________SEPARADOR_________________-->


					<!--_________________ GUARDAR_________________-->
					<div class="col-md-12">
							<button type="submit" class="btn btn-primary pull-right" onclick="Guardar_Circuito()">GUARDAR</button>
					</div>
					<!--__________________________________-->

			</div>


	</div>
<!---//////////////////////////////////////--- FIN BOX 1---///////////////////////////////////////////////////////----->


<!---//////////////////////////////////////---BOX 2 DATATBLE ---///////////////////////////////////////////////////////----->
	<div class="box box-primary">
		<div class="box-body">
				<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
						
					<div class="row">
								<div class="col-sm-6"></div>
								<div class="col-sm-6"></div>
						</div>

						<div class="row">
								<div class="col-sm-12 table-scroll" id="cargar_tabla">

								</div>
						</div>
						
				</div>
		</div>
	</div>
<!---//////////////////////////////////////--- FIN BOX 2 DATATABLE---///////////////////////////////////////////////////////----->

<!---///////--- MODAL MAPA ---///////--->
	<div class="modal fade" id="modalmapa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
			aria-hidden="true">
			<div class="modal-dialog" role="document">
					<div class="modal-content">
							<div class="modal-header bg-blue">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
									</button>
									<h5 class="modal-title" id="exampleModalLabel">MAPA - Puntos criticos</h5>
							</div>

							<div class="modal-body">										

																	
							</div>

							<div class="modal-footer">
									<div class="form-group text-right">													
											<button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
									</div>
							</div>
					</div>
			</div>
	</div>
<!---///////--- MODAL MAPA ---///////--->


<!---///////--- MODAL EDICION E INFORMACION ---///////---> 
	<div class="modal fade bs-example-modal-lg" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header bg-blue">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
						</button>
						<h5 class="modal-title" id="exampleModalLabel">Circuitos</h5>
				</div>

				<div class="modal-body ">
					<div class="form-horizontal">
						<form class="frm_circuito_edit" id="frm_circuito_edit">
							<div class="col-sm-6">
								<!--_____________ CODIGO _____________-->
									<div class="form-group">																
										<label for="codigo_edit" class="col-sm-4 control-label">Código:</label>
										<div class="col-sm-8">
											<input type="text" class="form-control habilitar" name="codigo" id="codigo_edit">	
										</div>
									</div> 
								<!--___________________________-->
					
								<!--_____________ VEHICULO _____________-->
									<div class="form-group">																
										<label for="vehiculo_edit" class="col-sm-4 control-label">Vehiculo:</label>
										<div class="col-sm-8">
											<input type="text" class="form-control habilitar" id="vehiculo_edit"> 
										</div>
										<input type="text" class="form-control habilitar hidden" id="vehi_id_edit" name="vehi_id"> 
									</div>   
								<!--__________________________-->	 
							
								<!--_____________ CHOFER _____________-->
									<div class="form-group">																
										<label for="chofer_edit" class="col-sm-4 control-label">Chofer:</label>
										<div class="col-sm-8">
											<input type="text" class="form-control habilitar hidden" name="chof_id" id="chof_id_edit">
											<input type="text" class="form-control habilitar" name="chofer" id="chofer_edit">
										</div>	
									</div>
								<!--__________________________-->
							</div>

							<div class="col-sm-6">
								<!--_____________ TIPO RESIDUOS _____________-->
									<div class="form-group">															
											<label for="tica_edit" class="col-sm-4 control-label">Tipo de residuo:</label>
											<div class="col-sm-8">
											<select class="form-control select3 habilitar" multiple="multiple"  data-placeholder="Seleccione tipo residuo"  style="width: 100%;"  id="tica_edit"> </select>                     
											</div>	
									</div>
								<!--__________________________-->		
										
								<!--_____________ DESCRIPCION _____________-->                 
									<div class="form-group">
											<label for="descripcion_edit" class="col-sm-4 control-label">Descripcion:</label>
											<div class="col-sm-8">
												<input type="text" class="form-control habilitar" id="descripcion_edit"> 
											</div>
									</div>
								<!--__________________________-->	
								
								<!--_____________ ZONA _____________-->                 
								<!-- <div class="form-group">
									<label for="zonaAsociar" class="col-sm-4 control-label">Zona:</label>
									<div class="col-sm-8">
										<select class="form-control select2 select2-hidden-accesible" name="zona_id" id="zonaAsociar">
											<option value="" disabled selected>-Seleccione opcion-</option>		
											<?php
													//foreach($Departamentos as $fila)
													//{
													//echo '<option value="'.$fila->depa_id.'">'.$fila->nombre.'</option>' ;
													//}
											?>																					
										</select>
									</div>
								</div> -->
								<!--__________________________-->	

							</div>

							<div class="col-sm-12">
								<!--_____________ IMAGEN _____________-->
									<div class="form-group pull-left">
										<label for="imagen_edit" class="col-sm-4 control-label">Imágen:</label>
										<div class="col-sm-8">
											<input type="file" class="habilitar" id="imagen_edit"> 
										</div>
									</div> 
								<!--__________________________-->	
							</div>
						</form>	
					</div>

					<!--_____________ SECCION P. CRITICOS _____________-->	
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box box-primary">
											<div class="box-header with-border">
													<h4> Puntos Criticos</h4>
											</div>
									</div>
							</div>
						
						<div class="form-horizontal" id="form_editar_pto_critico">	
								<form class="formPuntos_edit" id="formPuntos_edit">
										<!--_____________ columna 1 _____________-->
										<div class="col-sm-6">
											<!--_____________ Nombre _____________-->
												<div class="form-group">															
													<label for="nombre_edit_pto" class="col-sm-4 control-label">Nombre:</label>
													<div class="col-sm-8">
														<input type="text" class="form-control habilitar" name="nombre" id="nombre_edit_pto"> 
													</div>	
												</div>
											<!--__________________________-->
											
											<!--_____________ Latitud _____________-->
											<div class="form-group">															
												<label for="latitud_edit_pto" class="col-sm-4 control-label">Latitud:</label>
												<div class="col-sm-8">
													<input type="text" class="form-control habilitar" name="lat" id="latitud_edit_pto"> 
												</div>	
											</div>
										<!--__________________________-->
										</div>	
										<!--__________________________-->

										<!--_____________ columna 2 _____________-->
										<div class="col-sm-6">
											<!--_____________ Descripcion _____________-->
												<div class="form-group">															
													<label for="descripcion_edit_punto" class="col-sm-4 control-label">Descripcion:</label>
													<div class="col-sm-8">
														<input type="text" class="form-control habilitar" name="descripcion" id="descripcion_edit_punto"> 
													</div>	
												</div>
											<!--__________________________-->
											
											<!--_____________ Longitud _____________-->
											<div class="form-group">															
												<label for="long_edit_pto" class="col-sm-4 control-label">Longitud:</label>
												<div class="col-sm-8">
													<input type="text" class="form-control habilitar" name="lng" id="long_edit_pto"> 
												</div>	
											</div>
										<!--__________________________-->
										</div>		
										<!--__________________________-->

										<!--_____________ Btn agregar _____________-->	
										<div class="col-md-12">
											<button type="submit" class="btn btn-default pull-right"id="btn_agregar_edit" onclick="Agregar_punto_edit()">AGREGAR</button>
										</div>
										<!--__________________________-->
								</form> 
						</div>

						<!--_________________SEPARADOR_________________-->
							<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
						<!--_________________SEPARADOR_________________-->

						<!--_____________ TABLA EDITAR PUNTOS CRITICOS _____________-->							
							<div class="col-md-12">                                          
								
								<table id="tabla_puntos_criticos_edit" class="table table-bordered table-striped">
										<thead class="thead-dark" bgcolor="#eeeeee">																										
												<th>Acciones</th>
												<th>Nombre</th>
												<th>Descripcion</th>
												<th>Latitud</th>
												<th>Longitud</th>								
									</thead>
								
									<tbody>
										<!-- <i class="fa fa-fw fa-minus text-light-blue tablamateriasasignadas_borrar" style="cursor: pointer; margin-left: 15px;" title="Nuevo"></i> -->
									</tbody>
								</table>                                    
																											
							</div> 
						<!--_____________ FIN TABLA EDITAR PUNTOS CRITICOS _____________-->
									
					</div>
					<!--____________ FIN SECCION P. CRITICOS ______________-->


				</div>			

				<div class="modal-footer">
					<div class="form-group text-right">
							<button type="submit" class="btn btn-primary" data-dismiss="modal" id="btnsave_edit">Guardar</button>
							<button type="submit" class="btn btn-default" id="" data-dismiss="modal">Cerrar</button>
					</div>
				</div>

			</div>
		</div>
	</div>
<!---///////--- FIN MODAL EDICION E INFORMACION ---///////--->

<!---///////--- MODAL ASOCIAR ZONA ---///////--->
	<div class="modal fade bs-example-modal-lg" id="modalAsociar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header bg-blue">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
						</button>
						<h5 class="modal-title" id="exampleModalLabel">Asociar Zona a Circuito</h5>
				</div>

				<div class="modal-body ">
					<div class="form-horizontal">
								
						<input type="text" class="form-control hidden" id="circ_id_asociar">	

							<div class="col-sm-6">
								<!--_____________ DEPARTAMENTO _____________-->
									<div class="form-group">															
											<label for="depAsociar" class="col-sm-4 control-label">Departamento:</label>
											<div class="col-sm-8">
												<select class="form-control select2 select2-hidden-accesible" name="depa_id" id="depAsociar">
													<option value="" disabled selected>-Seleccione opcion-</option>												
												</select>
																	
											</div>	
									</div>
								<!--__________________________-->		
							</div>
							<div class="col-sm-6">			
								<!--_____________ ZONA _____________-->                 
									<div class="form-group">
											<label for="zonaAsociar" class="col-sm-4 control-label">Zona:</label>
											<div class="col-sm-8">
												<select class="form-control select2 select2-hidden-accesible" name="zona_id" id="zonaAsociar">
													<option value="" disabled selected>-Seleccione opcion-</option>												
												</select>
											</div>
									</div>
								<!--__________________________-->								
							</div>

					</div>		

					<!--_________________SEPARADOR_________________-->
					<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
					<!--_________________SEPARADOR_________________-->

				</div>			

				<div class="modal-footer">
					<div class="form-group text-right">
							<button type="submit" class="btn btn-primary" data-dismiss="modal" id="btnsaveAsociacion">Asociar</button>
							<button type="submit" class="btn btn-default" id="" data-dismiss="modal">Cancelar</button>
					</div>
				</div>

			</div>
		</div>
	</div>
<!---///////--- FIN MODAL ASOCIAR ZONA ---///////--->

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
			<input id="circuito_delete" style="display: none;">
			<div class="modal-body">
				<center>
				<h4><p>¿ DESEA ELIMINAR CIRCUITO ?</p></h4>
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



<script>

////////// 	Guardado	//////////

	// carga tabla genaral de circuitos
	$("#cargar_tabla").load("<?php //echo base_url(); ?>index.php/general/Estructura/Circuito/Listar_Circuitos");

  //agrega punto critico a la tabla para guardar  
	function Agregar_punto() {

		$('#puntos_criticos').show();
		var data = new FormData($('#formPuntos')[0]);
		data = formToObject(data);
		var table = $('#datos').DataTable();
		var row =  `<tr data-json='${JSON.stringify(data)}'> 
					<td>${data.nombre}</td>
					<td>${data.descripcion}</td>
					<td>${data.lat}</td>
					<td>${data.lng}</td>            
			</tr>`;
		table.row.add($(row)).draw();  
		$('#formPuntos')[0].reset();          
	}
		
  // guarda circuito y puntos criticios nuevos 
	function Guardar_Circuito() { 
		
		// toma tabla tipos de carga
		var datos_tipo_carga= $('#tica_id').val();  
		// toma datos form circuitos
		var datos_circuito = new FormData($('#formCircuitos')[0]);
		var inpImagen = $('input#imagen');
		//agrego el campo vacio sino tiene dato para completar el json
		if( document.getElementById("imagen").files.length == 0 ){					
			datos_circuito.append("imagen", "");
		}
	
		datos_circuito = formToObject(datos_circuito);
		// recorre tabla guardando ptos criticos en array
		var datos_puntos_criticos = [];		
		var rows = $('#datos tbody tr');				
		rows.each(function(i,e) {  
				datos_puntos_criticos.push(getJson(e));
		});				

		//TODO: VER VALIDACION DE GUARDADO SIN PUNTOS CRITICOS
		// valida existencia de ptos criticos en tabla
		if (datos_puntos_criticos.lenght==0) {
				alert('Sin Datos para Registrar.');
				return;
		}
		// valida campos cargados y envia datos
		if ($("#formCircuitos").data('bootstrapValidator').isValid()) {
					
					$.ajax({
							type: "POST",
							data: {datos_circuito, datos_puntos_criticos,datos_tipo_carga},							
							url: "general/Estructura/Circuito/Guardar_Circuito",
							success: function(r) {
									console.log(r);
									if (r == "ok") {

											$("#cargar_tabla").load(
													"<?php echo base_url(); ?>index.php/general/Estructura/Circuito/Lista_Circuitos"
											);
											alertify.success("Agregado con exito");

											$('#formCircuitos').data('bootstrapValidator').resetForm();
											$("#formCircuitos")[0].reset();

											$("#boxDatos").hide(500);
											$("#botonAgregar").removeAttr("disabled");

									} else {
											console.log(r);
											alertify.error("error al agregar");
									}
							}
					});
		}
	}  
 
	// muestra box de datos al dar click en boton agregar
	$("#botonAgregar").on("click", function() {
	
			$("#botonAgregar").attr("disabled", "");
			//$("#boxDatos").removeAttr("hidden");
			$("#boxDatos").focus();
			$("#boxDatos").show();

	});   
	
	// muestra box de datos al dar click en X
	$("#btnclose").on("click", function() {
			$("#boxDatos").hide(500);
			$("#botonAgregar").removeAttr("disabled");
			$('#formDatos').data('bootstrapValidator').resetForm();
			$("#formDatos")[0].reset();
			$('#selecmov').find('option').remove();

	});
	
	// inicializa validador de formulario circuitos
	$('#formCircuitos').bootstrapValidator({
			message: 'This value is not valid',
			/*feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
			},*/
			//excluded: ':disabled',
			fields: {
					codigo: {
							message: 'la entrada no es valida',
							validators: {
									notEmpty: {
											message: 'la entrada no puede ser vacia'
									}
							}
					},
					tica_id: {
							message: 'la entrada no es valida',
							validators: {
									notEmpty: {
											message: 'la entrada no puede ser vacia'
									}
							}
					},
					descripcion: {
							message: 'la entrada no es valida',
							validators: {
									notEmpty: {
											message: 'la entrada no puede ser vacia'
									}

							}
					},
					vehi_id: {
							message: 'la entrada no es valida',
							validators: {
									notEmpty: {
											message: 'la entrada no puede ser vacia'
									}
							}
					},
					chof_id: {
							message: 'la entrada no es valida',
							validators: {
									notEmpty: {
											message: 'la entrada no puede ser vacia'
									}
							}
					}
			}
	}).on('success.form.bv', function(e) {
			e.preventDefault();
			guardar();
	});    
	
	// inicializa validador de form puntos criticos
	$('#formPuntos').bootstrapValidator({
			message: 'This value is not valid',
			/*feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
			},*/
			//excluded: ':disabled',
			fields: {
					nombre: {
							message: 'la entrada no es valida',
							validators: {
									notEmpty: {
											message: 'la entrada no puede ser vacia'
									}
							}
					},
					descripcion: {
							message: 'la entrada no es valida',
							validators: {
									notEmpty: {
											message: 'la entrada no puede ser vacia'
									}

							}
					},
					lat: {
							message: 'la entrada no es valida',
							validators: {
									notEmpty: {
											message: 'la entrada no puede ser vacia'
									}
							}
					},
					lng: {
							message: 'la entrada no es valida',
							validators: {
									notEmpty: {
											message: 'la entrada no puede ser vacia'
									}
							}
					}
			}
	}).on('success.form.bv', function(e) {
			e.preventDefault();
			guardar();
	});      
	
	// inicialliza box2 para agregar punto critico nuevo
	DataTable($('#datos'));

	// inicialia tabla para moda edicion e info
	//DataTable($('#tabla_puntos_criticos_edit'));
	
	//Initialize Select2 Elements
	$('.select3').select2();

////////// 	Fin Guardado	//////////

////////// 	Edicion y Borrado	//////////

	


</script>