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
													<input type="text" class="form-control" name="codigo" id="codigo" required>
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
													<select class="form-control select3" multiple="multiple"  data-placeholder="Seleccione tipo residuo"  style="width: 100%;"  id="tica_id" name="tica_id">															
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

							</form>		
									<!--Adjuntar imagen--> 
									<div class="col-md-12">
										<form action="cargar_archivo" method="post" enctype="multipart/form-data">
												<input type="file" id="img_File" onchange=convertA() style="font-size: smaller">
												<input type="text" name="imagen" id="input_aux_img" style="display:none" name="input_aux_img" >
							</form>
							<img src="" alt="" id="img_Base" width="" height="" style="margin-top: 20px;border-radius: 8px;">
							</div>
						<!--_____________________________________________-->					
					
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
															<input type="text" class="form-control" name="descripcion" id="descrip">
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
						<button type="button" class="close close_modal_edit" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
						</button>
						<h5 class="modal-title" id="exampleModalLabel">Circuitos</h5>
				</div>

				<div class="modal-body ">
					<div class="form-horizontal">
						<form class="frm_circuito_edit" id="frm_circuito_edit">
							<!--_____________ ID CIRCUITO, ID ZONA (HIDDEN) _____________-->
								<div class="hidden">							
									<div class="col-sm-8">
										<input type="text" class="form-control habilitar" name="zona_id" id="zona_id_edit">	
									</div>
								</div>
								<div class="hidden">							
									<div class="col-sm-8">
										<input type="text" class="form-control habilitar" name="circ_id" id="circ_id_edit">	
									</div>
								</div>
							<!--__________________________-->
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
										<label for="vehi_id_edit" class="col-sm-4 control-label">Vehiculo:</label>
										<div class="col-sm-8">
											<!-- <input type="text" class="form-control habilitar" id="vehiculo_edit">  -->
											<select class="form-control select2 select2-hidden-accesible selec_habilitar" name="vehi_id" id="vehi_id_edit">
												<option value="" disabled selected>-Seleccione opcion-</option>	
												<?php
													foreach ($Vehiculo as $i) {
													echo '<option  value="'.$i->equi_id.'">'.$i->dominio.'</option>';
													}
												?>
											</select>
										</div>										
									</div> 	
								<!--__________________________-->	 
							
								<!--_____________ CHOFER _____________-->
									<div class="form-group">																
										<label for="chof_id_edit" class="col-sm-4 control-label">Chofer:</label>
										<div class="col-sm-8">
											<select class="form-control select2 select2-hidden-accesible selec_habilitar" name="chof_id" id="chof_id_edit">
												<option value="" disabled selected>-Seleccione opcion-</option>
												<?php
													foreach ($Chofer as $i) {
														echo '<option  value="'.$i->chof_id.'">'.$i->nombre." ".$i->apellido.'</option>';
													}
												?>
											</select>	
										</div>	
									</div>
								<!--__________________________-->
							</div>

							<div class="col-sm-6">
								<!--_____________ TIPO RESIDUOS _____________-->
									<div class="form-group">															
											<label for="tica_edit" class="col-sm-4 control-label">Tipo de residuo:</label>
											<div class="col-sm-8">
											<select class="form-control select3 habilitar" multiple="multiple"  data-placeholder="Seleccione tipo residuo"  style="width: 100%;"   id="tica_edit"> 
												<?php
													foreach ($tipoResiduos as $i) {		
															echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
													}
												?>
											</select>                     
											</div>	
									</div>
								<!--__________________________-->		
										
								<!--_____________ DESCRIPCION _____________-->                 
									<div class="form-group">
											<label for="descripcion_edit" class="col-sm-4 control-label">Descripcion:</label>
											<div class="col-sm-8">
												<input type="text" class="form-control habilitar" name="descripcion" id="descripcion_edit"> 
											</div>
									</div>
								<!--__________________________-->	
								<!--_____________ Zona Acosiada a circuito _____________-->                 
								
								
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
						</form>	
						<div class="col-sm-6">	
						  	
								<div class="form-group">
												<label for="zona_asociada_edit" class="col-sm-4 control-label">Zona Asociada:</label>
												<br>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="zona_asociada_edit" id="zona_asociada_edit" readonly placeholder="zona asociada"> 
												</div>
								</div>
							<									
						</div>
							<!--_____________ IMAGEN _____________-->
								<div class="col-sm-12">	
										<div class="form-group pull-left">
											<form action="cargar_archivo" method="post" enctype="multipart/form-data">	
												<label for="img_file" class="col-sm-4 control-label" name="img">Imagen:</label>
												<div class="col-sm-8">
													<input type="file" class="ocultar habilitar" name="img" id="img_file" onchange=convert_Edit()>
													<input type="text" id="input_aux_img64" style="display:none">
													<input type="text" id="input_aux_zonaID" style="display:none">                                   
													<img src="" alt="imagen" id="img_base" width="" height="" style="margin-top: 20px;border-radius: 8px;" name="img_base">
												</div>
											</form>		
										</div>									
								</div>
							<!--__________________________-->
							
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
											<button type="" class="btn btn-default pull-right"id="btn_agregar_edit" onclick="Agregar_punto_edit()">AGREGAR</button>
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
							<button type="" class="btn btn-primary" data-dismiss="modal" id="btnsave_edit">Guardar</button>
							<button type="" class="btn btn-default cerrarModalEdit" id="" data-dismiss="modal">Cerrar</button>
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
													<?php
													foreach ($Departamentos as $f) {
															echo '<option  value="'.$f->depa_id.'">'.$f->nombre.'</option>';
													}
													?>												
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

<!---///////--- MODAL AVISO de ptos criticos no registrados ---///////--->
<div class="modal fade" id="modalavisoPtoCriticosFallido">		
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-blue">
				<h5 class="modal-title" ><span class="fa fa-fw fa-times-circle" style="color:#A4A4A4"></span>ATENCION</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="CerrarModalAviso()">
					<span aria-hidden="true" >&times;</span>
				</button>
			</div>
			<input id="circuito_delete" style="display: none;">
			<div class="modal-body">
				<center>
				<h4><p>LOS SIGUIENTES PUNTOS CRITICOS NO SE ASOCIARON AL CIRCUITO POR QUE YA EXISTEN</p></h4>
				</center>
				<!--_____________ Tabla Punto Critico _____________-->
				
							<div class="box " id="puntos_criticos_no_asociados">
									<div class="box-body table-responsive">											
											<table class="table table-striped" id="datos_ptos_noasociados">
													<thead class="thead-dark" bgcolor="#eeeeee">
															<th>Nombre Pto</th>
													</thead>	
													<tbody>	</tbody>
											</table>										
									</div>
							</div>
					
					<!--_____________________________________________-->
			</div>
			<div class="modal-footer">
				<center>
				<button type="button" class="btn btn-primary" onclick="CerrarModalAviso()">OK</button>
				
				</center>
			</div>
		</div>
	</div>
</div>
<!---///////--- FIN MODAL AVISO ---///////--->



<script>
$(".cerrarModalEdit").click(function(e){
    $("#modalEdit").data('bootstrapValidator').resetForm();
	// $("#formPuntos_edit").data('bootstrapValidator').resetForm();
   
});
$(".close_modal_edit").click(function(e){
    $("#modalEdit").data('bootstrapValidator').resetForm();
	// $("#formPuntos_edit").data('bootstrapValidator').resetForm();
   
});

//////// Tratamiento de Imagen en Registrar nuevo circuito
	async function convertA(){      
				
		var file = document.getElementById('img_File').files[0];
		console.table('imagen en convertA: ' + document.getElementById('img_File').files[0]);

		if (file) {

			var archivo = await GetFile(file);
			console.table(archivo);
			if(archivo.fileType == "image/jpeg"){
				
				var cod = "data:image/jpeg;base64,"+archivo.base64StringFile;
				//var cod = "data:image/png;base64,"+archivo.base64StringFile;
				$("#input_aux_img").val(cod);
				$("#img_Base").attr("src",$("#input_aux_img").val());
				$("#img_Base").attr("width",100);
				$("#img_Base").attr("height",100);
			}else{

				if(archivo.fileType == "application/pdf"){
					var cod = "data:application/pdf;base64,"+archivo.base64StringFile;
				}				
			}               
			$("#input_aux_img").val(cod);
			console.table($("#input_aux_img").val());  
		}        
	}
	//Convertir a base64 el archivo Imagen
	function GetFile(file){

		var reader = new FileReader();

		return new Promise((resolve, reject) => {

										reader.onerror = () => {
													reader.abort();
													reject(new Error("Error parsing file"));
										}
										reader.onload = function() {
													//This will result in an array that will be recognized by C#.NET WebApi as a byte[]
													let bytes = Array.from(new Uint8Array(this.result));
													//if you want the base64encoded file you would use the below line:
													let base64StringFile = btoa(bytes.map((item) => String.fromCharCode(item)).join(""));
													//Resolve the promise with your custom file structure
													resolve({
																bytes: bytes,
																base64StringFile: base64StringFile,
																fileName: file.name,
																fileType: file.type
													});
										}
										reader.readAsArrayBuffer(file);
		});
	}
//////// Fin Tratamiento de Imagen en Registrar nuevo circuito

////////// 	Guardado	//////////

	// carga tabla genaral de circuitos
		$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Circuito/Listar_Circuitos");

  //agrega punto critico a la tabla para guardar  
		function Agregar_punto() {
			var aux = 0;
			var aux2 = 0;
			if($("#descrip").val() != "")
			{
				if($("#nombre").val() != "")
				{
					if($("#lat").val() != "")
					{
						if($("#lng").val() != "")
						{
							aux = 1;
						}
					}

				}
			}
			if ($("#formPuntos").data('bootstrapValidator').isValid())
			{aux2=1;}
			if(aux!=0 && aux2!=0 ){
				$('#puntos_criticos').show();
			var data = new FormData($('#formPuntos')[0]);
			data = formToObject(data);
			data.nombre = $("#nombre").val().toLowerCase();
			data.descripcion = $("#descrip").val().toLowerCase();
			var table = $('#datos').DataTable();
			var row =  `<tr data-json='${JSON.stringify(data)}'> 
						<td>${data.nombre}</td>
						<td>${data.descripcion}</td>
						<td>${data.lat}</td>
						<td>${data.lng}</td>            
				</tr>`;
			table.row.add($(row)).draw();  
			$('#formPuntos')[0].reset();          
			}else{
				alert("Atencion!!! hay un campo de puntos criticos vacio o mal ingresados");
			}
			
		}
		
  // guarda circuito y puntos criticios nuevos 
		function Guardar_Circuito() { 
			debugger;
			// toma tabla tipos de carga
			var datos_tipo_carga= $('#tica_id').val();  
			// toma datos form circuitos
			var datos_circuito = new FormData($('#formCircuitos')[0]);
			console.table(datos_circuito);
			var inpImagen = $('input#imagen');	
			datos_circuito = formToObject(datos_circuito);
			datos_circuito.imagen = $("#input_aux_img").val();
			
			// recorre tabla guardando ptos criticos en array
			var datos_puntos_criticos = [];		
			var rows = $('#datos tbody tr');				
			rows.each(function(i,e) {  
					datos_puntos_criticos.push(getJson(e));
			});		
			console.table(datos_circuito.imagen);

			//asigno los datos del objeto datos_circuito a datos_circuito_enviar el cual va sin tica_id
			var datos_circuito_enviar = new FormData();
        	datos_circuito_enviar = formToObject(datos_circuito_enviar);
			datos_circuito_enviar.chof_id = datos_circuito.chof_id;
			datos_circuito_enviar.codigo = datos_circuito.codigo;
			datos_circuito_enviar.descripcion = datos_circuito.descripcion;
			datos_circuito_enviar.imagen = datos_circuito.imagen;
			datos_circuito_enviar.vehi_id = datos_circuito.vehi_id;
			// valida campos cargados y envia datos
			if ($("#formCircuitos").data('bootstrapValidator').isValid()) {
				
				if(datos_circuito.imagen == "")
				{
					alert("ATENCION! no cargo ninguna Imagen, Por favor cargue una");
				}else{
					$.ajax({
							type: "POST",
							data: {datos_circuito_enviar, datos_puntos_criticos,datos_tipo_carga},							
							url: "general/Estructura/Circuito/Guardar_Circuito",
							success: function($respuesta) {
									 debugger;
									
										if ($respuesta == "Error codigo existente")
										{
											alertify.error("Error...El codigo"+ datos_circuito_enviar.codigo+ "de circuito que ingreso ya existe, Pruebe con otro");
										}else{
											if($respuesta == "Error... Punto Crítico no asociado")
											{
												alertify.error("Error...El circuito se registro pero no se pudo asociar los ptos criticos ");
												$('#formCircuitos').data('bootstrapValidator').resetForm();
														$("#formCircuitos")[0].reset();
														$('#formPuntos').data('bootstrapValidator').resetForm();
														$("#formPuntos")[0].reset();
														$("#boxDatos").hide(500);
														$("#botonAgregar").removeAttr("disabled");	
														$('#datos tbody tr').remove();
											}
											else{
												if($respuesta == "Error... Tipo de RSU no asociado")
												{
													alertify.error("Error al vincular los tipos de residuos al circuito...");
													$('#formCircuitos').data('bootstrapValidator').resetForm();
														$("#formCircuitos")[0].reset();
														$('#formPuntos').data('bootstrapValidator').resetForm();
														$("#formPuntos")[0].reset();
														$("#boxDatos").hide(500);
														$("#botonAgregar").removeAttr("disabled");	
														$('#datos tbody tr').remove();
												}else{
													if ($respuesta != "") {
														$res = JSON.parse($respuesta);
														$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Circuito/Listar_Circuitos");
														alertify.success("Se Agregado con exito el circuito");
														$('#formCircuitos').data('bootstrapValidator').resetForm();
														$("#formCircuitos")[0].reset();
														$('#formPuntos').data('bootstrapValidator').resetForm();
														$("#formPuntos")[0].reset();
														
														$("#boxDatos").hide(500);
														$("#botonAgregar").removeAttr("disabled");
														console.table($res.length);
														console.table($res[0]);	
														// var data = new FormData($('#formPuntos')[0]);
														// data = formToObject(data);
														// data.nombre = $("#nombre").val().toLowerCase();
														// data.descripcion = $("#descrip").val().toLowerCase();
														var table = $('#datos_ptos_noasociados').DataTable();
														for(var i=0; i<$res.length; i++){
															
															var row =  `<tr data-json=''> 
																			<td>${$res[i]}</td>
																		</tr>`;
															table.row.add($(row)).draw(); 
														}
														$('#datos tbody tr').remove();
														$("#modalavisoPtoCriticosFallido").modal('show');
													
														// alert("Atencion hay algunos puntos criticos que no se asociaron al circuito");
													}else{
														$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Circuito/Listar_Circuitos");
														alertify.success("Se Agregado con exito el circuito");
														$('#formCircuitos').data('bootstrapValidator').resetForm();
														$("#formCircuitos")[0].reset();
														$('#formPuntos').data('bootstrapValidator').resetForm();
														$("#formPuntos")[0].reset();
														$("#boxDatos").hide(500);
														$("#botonAgregar").removeAttr("disabled");	
														$('#datos tbody tr').remove();
													}	
												}
												
											}
										}
										
									}
									
										

										
									
														
					});
				}
				
			 }else{alert("Hay campos de Informacion vacios! Por favor completelos");}
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
				$('#tica_id').select2('val', 'All');
				//para borrar tabla;
				var table = $('#datos').DataTable();
 				table.clear().draw();
				$('#formCircuitos').data('bootstrapValidator').resetForm();
				$("#formCircuitos")[0].reset();
				$('#formPuntos').data('bootstrapValidator').resetForm();
				$("#formPuntos")[0].reset();
				$("#boxDatos").hide(500);
				$("#botonAgregar").removeAttr("disabled");
				$('#formDatos').data('bootstrapValidator').resetForm();
				$("#formDatos")[0].reset();
				$('#selecmov').find('option').remove();
				

		});




	$(document).ready(function() {
   
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
						},
						input_aux_img:{
								message:'No puede estar vacio',
								validators: {
										notEmpty: {
												message: 'la entrada no puede ser vacia'
										}
								}
						}
				}
		}).on('success.form.bv', function(e) {
				e.preventDefault();
				//guardar();
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
										},
										regexp: {
                        					regexp: /[a-z]/,
                        					message: 'el nombre no debe contener numeros y mayusculas'
                    					}
								}
						},
						descripcion: {
								message: 'la entrada no es valida',
								validators: {
										notEmpty: {
												message: 'la entrada no puede ser vacia'
										},
										regexp: {
                        					regexp: /[A-Za-z]/,
                        					message: 'la descripcion no debe contener numeros'
                    					}

								}
						},
						lat: {
								message: 'la entrada no es valida',
								validators: {
										notEmpty: {
												message: 'la entrada no puede ser vacia'
										}, regexp: {
                       						 regexp: /^(0|[1-9][0-9]*)$/,
                       						 message: 'la entrada no debe ser un numero entero'
                    					}
								}
						},
						lng: {
								message: 'la entrada no es valida',
								validators: {
										notEmpty: {
												message: 'la entrada no puede ser vacia'
										}, regexp: {
                       						 regexp: /^(0|[1-9][0-9]*)$/,
                       						 message: 'la entrada no debe ser un numero entero'
                    					}
								}
						}
				}
		}).on('success.form.bv', function(e) {
				e.preventDefault();
				//guardar();
		})




	});		




	     
	
	// inicialliza box2 para agregar punto critico nuevo
	DataTable($('#datos'));

	
	
	//Initialize Select2 Elements
	$('.select3').select2();

////////// 	Fin Guardado	//////////

////// funciones imagen EDICION
	//cada vez que carga una imagen	
	async function convert_Edit(){       
		
		var file = document.getElementById('img_file').files[0];
		
		if (file) {
				
				var archivo = await getFile(file);			
				if(archivo.fileType == "image/jpeg"){
						var cod = "data:image/jpeg;base64,"+archivo.base64StringFile;
						//var cod = "data:image/png;base64,"+archivo.base64StringFile;
				}else{
						if(archivo.fileType == "application/pdf"){
								var cod = "data:application/pdf;base64,"+archivo.base64StringFile;
						}				
				}             
				console.table(archivo.fileType);				
				console.table(cod);
				$("#input_aux_img64").val(cod);
				console.table($("#input_aux_img64").val());
				$("#img_base").attr("src",$("#input_aux_img64").val());
				$("#img_base").attr("width",100);
				$("#img_base").attr("height",100);			
		}      
	}	
	// trae imagen guardada a vista previa
	function llenarImagen(circ_id){
			$.ajax({
					type: "POST",
					data: {circ_id: circ_id},
					url: "general/Estructura/Circuito/obtener_Imagen",
					success: function ($dato) {		
									var imagen = JSON.parse($dato);							
									var img_b64 = imagen;									
									if(img_b64[4]=='a'){
									pdf(img_b64);
									}else{
											if(img_b64[4]=='i'){jpg(img_b64);}
									}								
									//console.table("Como queda src final en llenar imagen: "+img_b64);
					}
			});
		}
	// carga la imagen en imagen base	
	function cargarImg(){   
			var val = $("#input_aux_img64").val();
			console.table(val);
			$("#img_base").attr("src",val);   
			return;   
		}	
	//3
	function pdf($img_b64){
			var aux_link = "";
			for(var i=25; i <= $img_b64.length-1; i++){
					aux_link = aux_link + $img_b64[i];
			}
			img = "data:application/pdf;base64,"+aux_link;
		
			var ref = img;
			ref= ref+"G";
			$("#input_aux_img64").val(ref);
			console.table("aca con la G agregada"+ref);
			$("#pdf").attr("href",ref);
			$("#img_base").attr("src",$("#input_aux_img64").val());
			$("#img_base").attr("width",100);
			$("#img_base").attr("height",100);
	}
	//2
	function jpg($img_b64){
			var aux_link = "/";
			for(var i=21; i <= $img_b64.length-1; i++){
					aux_link = aux_link + $img_b64[i];
			}
			img = "data:image/jpeg;base64,"+aux_link;
			$("#input_aux_img64").val(img);
			$("#img_base").attr("src",$("#input_aux_img64").val());
			$("#img_base").attr("width",100);
			$("#img_base").attr("height",100);
			var ref = $("#input_aux_img64").val();
			$("#pdf").attr("href",ref);
	}	
	//Convertir a base64 el archivo Imagen
	function getFile(file){
		var reader = new FileReader();
		return new Promise((resolve, reject) => {
			reader.onerror = () => {
				reader.abort();
				reject(new Error("Error parsing file"));
			}
			reader.onload = function() {
				//This will result in an array that will be recognized by C#.NET WebApi as a byte[]
				let bytes = Array.from(new Uint8Array(this.result));
				//if you want the base64encoded file you would use the below line:
				let base64StringFile = btoa(bytes.map((item) => String.fromCharCode(item)).join(""));
				//Resolve the promise with your custom file structure
				resolve({
					bytes: bytes,
					base64StringFile: base64StringFile,
					fileName: file.name,
					fileType: file.type
				});
			}
			reader.readAsArrayBuffer(file);
		});
	}
////// fin funciones imagen EDICION

	// Asocia zona a circuito
	$("#btnsaveAsociacion").on("click", function() {
		
		var idcircuito	= $('#circ_id_asociar').val();	
		var idzona = $('#zonaAsociar option:selected').val();
		
		var circ_zona = new Object();
		circ_zona.circ_id = idcircuito;
		circ_zona.zona_id = idzona;	

		console.table('array objeto no se: ' + circ_zona);

		$.ajax({
				type: 'POST',
				data:{circ_zona},
				url: "general/Estructura/Circuito/Asignar_Zona",
				success: function(result) {					
							if(result == 'ok'){
								alertify.success("Zona asociada con exito...!!!!!");
								$("#cargar_tabla").load(
												"<?php echo base_url(); ?>index.php/general/Estructura/Circuito/Listar_Circuitos"
										);
							}else{
								alertify.error("Hubo error en la Asociacion...");
							}
				},
				error: function(result){
									
				}
		});

	});

</script>
<script>
    $('#modalEdit').bootstrapValidator({
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

			descripcion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            }
        
    }
    }).on('success.form.bv', function (e) {
        e.preventDefault();
        //guardar();
    });
</script>
<script>
$('#formPuntos_edit').bootstrapValidator({
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
										},
										regexp: {
                        					regexp: /[a-z]/,
                        					message: 'el nombre no debe contener numeros y mayusculas'
                    					}
								}
						},
						descripcion: {
								message: 'la entrada no es valida',
								validators: {
										notEmpty: {
												message: 'la entrada no puede ser vacia'
										},
										regexp: {
                        					regexp: /[A-Za-z]/,
                        					message: 'la descripcion no debe contener numeros'
                    					}

								}
						},
						lat: {
								message: 'la entrada no es valida',
								validators: {
										notEmpty: {
												message: 'la entrada no puede ser vacia'
										}, regexp: {
                       						 regexp: /^(0|[1-9][0-9]*)$/,
                       						 message: 'la entrada no debe ser un numero entero'
                    					}
								}
						},
						lng: {
								message: 'la entrada no es valida',
								validators: {
										notEmpty: {
												message: 'la entrada no puede ser vacia'
										}, regexp: {
                       						 regexp: /^(0|[1-9][0-9]*)$/,
                       						 message: 'la entrada no debe ser un numero entero'
                    					}
								}
						}
				}
		}).on('success.form.bv', function(e) {
				e.preventDefault();
				//guardar();
		})



</script>

<script>
DataTable($('#tabla_puntos_criticos_edit'));	
  // Initialize Select2 Elements
  	$('.select3').select2();
</script>
<script>
// Elimina circuito 
function eliminar(){

var circ_id = $("#circuito_delete").val();
$.ajax({
		type: 'POST',
		data:{circ_id: circ_id},
		url: "general/Estructura/Circuito/borrar_Circuito",
		success: function(result) {
					if(result == "ok"){
						$("#modalaviso").modal('hide');
						alertify.success("circuito eliminado con exito...");
						$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Circuito/Listar_Circuitos");	
						
					}else{
						$("#modalaviso").modal('hide');	
						alertify.success("error al eliminar...");
					}
		},
		error: function(result){
			$("#modalaviso").modal('hide');			
		}
});

}	
//function para modal aviso de ptos criticos no asociados
function CerrarModalAviso()
{
	$("#modalavisoPtoCriticosFallido").modal('hide');
	$('#datos_ptos_noasociados tbody tr').remove();
}

// guarda Edicion completa		
$("#btnsave_edit").on("click", function() {
			
			// tomo los datos de circuito editados
			var circuito_edit = new FormData($('#frm_circuito_edit')[0]);
			circuito_edit = formToObject(circuito_edit);		
			circuito_edit.imagen = $("#input_aux_img64").val(); 
			// tipos de carga asociados
			var tipoCarga = $("#tica_edit").val();
			var tica_edit = JSON.stringify(tipoCarga);
			// tomo la tabla de puntos criticos editados
			var ptos_criticos_edit = [];		
			var rows = $('#tabla_puntos_criticos_edit tbody tr');				
			rows.each(function(i,e) {  
				console.table('ptos criticos' + ptos_criticos_edit);
				// setTimeout(doSomething, 9000);
				// setTimeout(doSomething, 9000);
				setTimeout(doSomething, 9000);
				var a = getJson(e);
				// setTimeout(doSomething, 9000);
				// setTimeout(doSomething, 9000);
				setTimeout(doSomething, 9000);
				ptos_criticos_edit.push(a);
				setTimeout(doSomething, 9000);
			});	

			// var algo = ptos_criticos_edit;
			var aux =0; 
			if($("#codigo_edit").val() != "")
			{
				
					if($("#descripcion_edit").val()!= "")
					{
						aux = 1;
						
					}
				
			
			}
			
			
			console.table('ptos criticos' + ptos_criticos_edit);
		
			if(aux == 1){
				
				if( circuito_edit.imagen != "")
				{   
					if($("#tica_edit").val() != "")
					{
						$.ajax({
								type: 'POST',
								data:{ circuito_edit, tica_edit, ptos_criticos_edit},
								url: "general/Estructura/Circuito/actulizaCircuitos",
								success: function(result) {
											if(result == "ok"){
												
													alertify.success("Circuito editado con exito...");
												$("#cargar_tabla").load(
																"<?php echo base_url(); ?>index.php/general/Estructura/Circuito/Listar_Circuitos"
														);
											
												$("#modalEdit").data('bootstrapValidator').resetForm();
												$("#formPuntos_edit").data('bootstrapValidator').resetForm();
											}else{
												
												alertify.error("Error El nombre del circuito editado o ingresado ya existe pruebe con otro...");
												$("#modalEdit").data('bootstrapValidator').resetForm();
												$("#formPuntos_edit").data('bootstrapValidator').resetForm();
											}
								},
								error: function(result){
													
								}
						});
					}else{
						alert("Atencion!!! tipo de residuos esta vacio ");
					}
				}else{
            	alert("Atencion!!! No ha cargado una imagen");
        		}

			}else{
				$("#modalEdit").data('bootstrapValidator').resetForm();
        	alert("Atencion!!! hay un campo que esta vacio");
			
    		}

		});

</script>