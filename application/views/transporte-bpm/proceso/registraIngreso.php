
<h4>Registra Ingreso</h4>

<!-- ____________________________ GRUPO 1 ____________________________ -->

<div class="col-md-12">

      <div class="form-group">

					<input type="text" name="" id="difi_id" min="0" class="form-control hidden" value="<?php echo $infoOT->difi_id; ?>">
          <!-- ________________________________________________________ -->

          <div class="col-md-4 col-md-6 mb-4 mb-lg-0">
              <div class="form-group">
                  <label for="dominio" class="form-label">Dominio:</label>
                  <input type="text" name="" id="dominio" min="0" class="form-control" value="<?php echo $infoOTransporte->dominio; ?>" readonly>
              </div>
          </div>

          <!-- ________________________________________________________ -->


          <div class="col-md-4 col-md-6 mb-4 mb-lg-0">
              <div class="form-group">
                  <label for="cont_restantes" class="form-label">Contenedores Restantes:</label>
                  <input type="text" name="" id="cont_restantes" min="0" class="form-control" required readonly>
              </div>
          </div>

          <!-- ________________________________________________________ -->

          <div class="col-md-4 col-md-6 mb-4 mb-lg-0">
              <label for="coen_id" class="form-label">Contenedor:</label>
              <select class="form-control select2 select2-hidden-accesible" id="coen_id" name="coen_id" required>
                  <option value="" disabled selected>-Seleccione opcion-</option>
                  <?php
											$contRest = 0;											
                      foreach ($infoContenedores as $cont) {
													echo '<option value="'.$cont->coen_id.'">'.$cont->codigo.'</option>';
													$contRest++;
											}
											
                  ?>
              </select>
          </div>
          <!-- ________________________________________________________ -->

      </div>

  </div>

<!-- ____________________________ SEPARADOR ____________________________ -->
  <div class="col-md-12"> <br> </div>
<!-- ____________________________ / SEPARADOR ____________________________ -->



<!-- _____________ IMAGENES ________________ -->

  <div class="row">
      <div class="col-md-12">
          <div class="col-md-4">
              <div class="form-group">
                  <label for="imgchof" class="form-label">Chofer:</label>
                  <img src="<?php echo $infoOTransporte->img_chofer; ?>" id="imgchof" height="60" width="60">
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group">
                  <label for="imgmovil" class="form-label">Vehiculo:</label>
                  <img src="<?php echo $infoOTransporte->img_vehiculo; ?>" id="imgmovil" height="60" width="60">
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group">
                  <label for="img_contenedor" id="cont" class="form-label">Contenedor:</label>
									<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <img src="" id="img_contenedor" height="60" width="60">
              </div>
          </div>
      </div>
  </div>

<!-- _____________ IMAGENES ________________ -->                      


<!-- ____________________________ SEPARADOR ____________________________ -->
  <div class="col-md-12"> <hr> </div>
<!-- ____________________________ / SEPARADOR ____________________________ -->

<!-- ____________________________ GRUPO 2 ____________________________ -->
  <div class="col-md-12" style="background-color: #EFEFEF; ">

      <div class="form-group" style="padding-top: 16px;">

      		<div class="col-md-4 col-md-6 mb-4 mb-lg-0" style="margin-bottom: 20px;">
              <div class="form-group">
                  <label for="bruto" class="form-label">Bruto:</label>
                  <input type="text" name="" id="bruto" min="0" class="form-control" required>
              </div>
              <button class="btn btn-success btn-sm" id="pesar" onclick="pesarCamion()">Pesar</button>
          </div>

          <div class="col-md-4 col-md-6 mb-4 mb-lg-0">
              <div class="form-group">
                  <label for="tara" class="form-label">Tara:</label>
                  <input type="text" name="" id="tara" min="0" class="form-control" value="<?php echo  $infoOTransporte->tara; ?>" required readonly>
              </div>
          </div>

          <div class="col-md-4 col-md-6 mb-4 mb-lg-0">
              <div class="form-group">
                  <label for="peso_neto" class="form-label">Neto:</label>
                  <input type="text" name="peso_neto" id="peso_neto" min="0" class="form-control" required readonly>
              </div>
          </div>

      </div> 

  </div>

<!-- ____________________________ SEPARADOR ____________________________ -->
  <div class="col-md-12"> <hr> </div>
<!-- ____________________________ / SEPARADOR ____________________________ -->

<!-- ____________________________ GRUPO 3 ____________________________ -->
  <div class="col-md-12">

    <div class="form-group">
      <div class="col-md-4 col-md-6 mb-4 mb-lg-0">
          <label for="deposito" class="form-label">Sector de Descarga:</label>
          <select class="form-control select2 select2-hidden-accesible" id="deposito" name="deposito" required>
              <option value="" disabled selected>-Seleccione opcion-</option>
              <?php
                  foreach ($depositos as $deposito) {
                      echo '<option value="'.$deposito->depo_id.'">'.$deposito->descripcion.'</option>';
                  }
              ?>
          </select>
      </div>
			<!-- ________________________________________________________ -->
			
			<div class="form-group text-center">
					<label> Incidencia:</label>					
					<button type="button" class="btn btn-primary btn-circle" aria-label="Left Align" onclick="modalIncidencia()">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>						
					</button> 
			</div>
			<!-- ________________________________________________________ -->		

    </div>

  </div>      

  <!-- ____________________________ SEPARADOR ____________________________ -->
  <div class="col-md-12"> <hr> </div>
<!-- ____________________________ / SEPARADOR ____________________________ -->


<div class="text-right">	
	<button class="btn btn-primary estadoTarea" id="noAcepta" onclick="cerrarTareaIngreso()" style="margin-left:20px;">Ingresar</button>
	<button class="btn btn-success estadoTarea" id="acepta" onclick="cerrar()">Cerrar</button>
</div>


<!-- Modal incidencia-->
	<div class="modal fade" id="modalIncidencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
			aria-hidden="true">
			<div class="modal-dialog" role="document">
					<div class="modal-content">
							<div class="modal-header bg-blue">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
									</button>
									<h5 class="modal-title" id="exampleModalLabel">Registrar incidencia</h5>
							</div>
							<div class="modal-body">
									<form id="formIncidencia" method="" autocomplete="off" class="registerForm">
											<div class="row">
													<div class="col-md-6">
															<div class="form-group">
																	<label for="ortr_id" class="form-label">Numero de orden:</label>
																	<input type="number" size="10" type="text" name="ortr_id" id="ortr_id" min="0"
																			class="form-control" value="<?php echo $infoOT->ortr_id ; ?>" readonly>
															</div>
															<div class="form-group">																

																	<label for="tica_id" class="form-label">Tipo residuo:</label>
																	<select class="form-control select2 select2-hidden-accesible" id="tica_id" name="tica_id" required>
																			<option value="" disabled selected>-Seleccione opcion-</option>
																			<?php
																					foreach ($tipoCarga as $carga) {
																							echo '<option value="'.$carga->tabl_id.'">'.$carga->valor.'</option>';
																					}
																			?>
																	</select>

															</div>
													</div>
													<div class="col-md-6">
															<div class="form-group">
																	<label for="fechaa" class="form-label">Fecha:</label>
																	<input type="date" name="" id="fechaa" class="form-control" value="<?php echo $infoOT->fec_alta ; ?>" readonly>
															</div>
															<div class="form-group">
																	<label for="dfinal" class="form-label">D. final:</label>
																	<input type="text" name="" id="dfinal" class="form-control" value="<?php echo $infoOT->difi_nombre ; ?>" readonly>
																	<!-- id de disposicion final -->				
																	<input type="text" name="difi_id" id="difi_id" class="form-control hidden" value="<?php echo $infoOT->difi_id ; ?>" readonly>																				 
															</div>
													</div>
											</div>

											<hr>

											<div class="row">
													<div class="col-md-6">
															<div class="form-group">
																	<label for="descripcion" class="form-label">Descripcion:</label>
																	<input type="text" name="descripcion" id="descripcion" class="form-control" required>
															</div>
															<div class="form-group">																	
																	<label for="tiin_id" class="form-label">Tipo incidencia:</label>
																	<select class="form-control select2 select2-hidden-accesible" id="tiin_id" name="tiin_id" required>
																			<option value="" disabled selected>-Seleccione opcion-</option>
																			<?php
																					foreach ($tipoIncidencia as $tipo) {
																							echo '<option value="'.$tipo->tabl_id.'">'.$tipo->valor.'</option>';
																					}
																			?>
																	</select>				
																	

															</div>
															<div class="form-group">
																	<label for="fecha" class="form-label">Fecha y hora:</label>
																	<!-- <input type="datetime-local" name="fecha" id="fecha" class="form-control" required> -->
																	<input type="date" name="fecha" id="fecha" class="form-control" required>
															</div>
													</div>
													<div class="col-md-6">														
															<div class="form-group">
																	<label for="num_acta" class="form-label">Nro acta:</label>
																	<input size="10" type="text" name="num_acta" id="num_acta" min="0" class="form-control"
																			required>
															</div>
															<!--Adjuntar imagen--> 
																<div class="col-md-12">
																	<form action="cargar_archivo" method="post" enctype="multipart/form-data">
																			<input type="file" id="img_File" onchange=convertA() style="font-size: smaller">
																			<input type="text" name="adjunto" id="input_aux_img" style="display:none" name="input_aux_img" >
																	</form>
																	<img src="" alt="" id="img_Base" width="" height="" style="margin-top: 20px;border-radius: 8px;">
																</div>
															<!--Adjuntar imagen-->
															
													</div>
											</div>
											<div>
													<div class="form-group text-right">
															<button type="button" class="btn btn-primary" onclick="guardarIncindencia()" id="btnsave">Guardar</button>
															<button type="button" class="btn btn-default" id="btnclose" data-dismiss="modal">Cerrar</button>
													</div>
											</div>
									</form>
							</div>
					</div>
			</div>
	</div>
<!-- Fin Modal incidencia-->


<script>
	
	//deshabilita los botones originales de la notificacion estandar						
		$(document).ready(function(){
				$('.btnNotifEstandar').hide();
		});
	// deshabilita img y spinner	
		$(document).ready(function(){			
				$("#img_contenedor").hide();
				$(".fa-spinner").hide();
		});

	// llena cantidad de contenedores que faltan 
		$( document ).ready(function() {
				var cant = <?php echo $contRest; ?>;
				$("#cont_restantes").val(cant);
		});
	// resta contenedores al seleccionar uno	
		var band = 0;	
		$("#coen_id").on('change', function(){
			if (!band) {
				var nuevaCant = parseInt($("#cont_restantes").val());
				nuevaCant = nuevaCant - 1;
				$("#cont_restantes").val(nuevaCant);
				band = 1;
			}			
		});	

	// pesa camion y llena cantidad neta de contenedor
		function pesarCamion(){
	
			var bruto = parseFloat($("#bruto").val());
			var tara = parseFloat($("#tara").val());
			var neto = 0;

			if ( bruto < tara ) {
				alert("El peso Bruto es menor que la Tara...");
				return;
			}
			neto = bruto - tara;
			$("#peso_neto").val(neto);		
		}
	
	// cierra tarea
		function cerrarTareaIngreso(){
			wo();
			var taskId = $('#taskId').val();
			var data= {};
			data.peso_neto = $("#peso_neto").val();
			data.difi_id = $("#difi_id").val();
			data.depo_id = $("#deposito").val();
			data.coen_id = $("#coen_id").val();

			$.ajax({
					type: 'POST',
					data:{ data },
					url: 'traz-comp-bpm/Proceso/cerrarTarea/' + taskId,
					success: function(result) {

								wc();
								if(result.status){
									alertify.success("Contenedoes actualizados exitosamente...");
									recargaBandejaEntrada();
								}else{
									alertify.error('Error en completar la Tarea...');
								}
					},
					error: function(result){
								alertify.error('Error ingresando contenedor...');
								wc();		
					},
					complete: function(){
								wc();
					}
			});
		}	

	// guarda incidencia nueva
		function modalIncidencia(){
			$("#modalIncidencia").modal('show');
		}

		function guardarIncindencia(){

			// tomo los datos de circuito editados
			var incidencia = new FormData($('#formIncidencia')[0]);
			incidencia.adjunto = $("#input_aux_img").val();
			incidencia = formToObject(incidencia);		
			//console.table(incidencia);

			$.ajax({
					type: 'POST',
					data:{ incidencia },
					url: "general/Estructura/Incidencia/guardarIncidencia",
					success: function(result) {		
						
								if(result == 'ok'){
									$("#modalIncidencia").modal('hide');
									alertify.success("Incidencia agregada con exito...");
								}
					},
					error: function(result){
								$("#modalIncidencia").modal('hide');
								alertify.error('Error agregando incidencia...');
					},
					complete: function(){
									
					}
			});
		}

		// recarga bandeja de entrada
		function recargaBandejaEntrada()
		{
			linkTo('<?php echo BPM ?>Proceso/index');
		}
	// trae imagen al cambiar de contenedore en el select contenedores
		$("#coen_id").on("change", function(){

				$("#img_contenedor").hide();			
				$(".fa-spinner").show();		

				coen_id = $(this).val();				
				var coen = {};
				coen.coen_id = $(this).val();
				$.ajax({
						type: 'POST',
						data:{coen},
						url: 'general/transporte-bpm/EntregaOrdenTransporte/obtenerImagenContenedor',
						success: function(result) {
							$(".fa-spinner").hide();
							var img = JSON.parse(result);							
							var imagen = img.replace('dataimage/jpegbase64', 'data:image/jpeg;base64,');							
              $('#img_contenedor').prop("src", imagen);	
							$("#img_contenedor").show();								
						},
						error: function(result){
											
						},
						complete: function(){
											
						}
				});
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

</script>