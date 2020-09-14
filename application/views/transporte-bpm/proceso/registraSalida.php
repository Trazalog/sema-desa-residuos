<h4>Registra Salida</h4>

<!-- ____________________________ GRUPO 1 ____________________________ -->

<div class="col-md-12">

      <div class="form-group">

					<input type="text" name="" id="difi_id" min="0" class="form-control hidden" value="<?php echo $infoOT->difi_id; ?>">
          <!-- ________________________________________________________ -->

          <div class="col-md-4 col-md-6 mb-4 mb-lg-0">
              <div class="form-group">
                  <label for="dominio" class="form-label">Nro de Dominio:</label>
                  <input type="text" name="" id="dominio" min="0" class="form-control" value="<?php echo $infoOTransporte->dominio; ?>" readonly>                                      
              </div>
          </div>

          <!-- ________________________________________________________ -->


          <div class="col-md-4 col-md-6 mb-4 mb-lg-0">
              <div class="form-group">
                  <label for="cont_restantes" class="form-label">Contenedores Restantes:</label>
                  <input type="text" name="" id="cont_restantes" min="0" class="form-control" required readonly value="<?php echo $contRestanteDescarga->noEntregados; ?>">
              </div>
          </div>

          <!-- ________________________________________________________ -->

          <div class="col-md-4 col-md-6 mb-4 mb-lg-0">
              <label for="coen_id" class="form-label">Contenedor:</label>
              <input type="text" id="contenedor_box" class="form-control" readonly value="<?php echo $infoContenedores->codigo_contenedor; ?>">
              <input type="text" id="cont_id" class="form-control" style="display:none" value="<?php echo $infoContenedores->cont_id; ?>">

              <select class="form-control select2 select2-hidden-accesible" id="coen_id" name="coen_id" style="display:none">
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
                  <input type="text" id="input_aux_img64" style="display:none" >
                  <img src="" id="img_base" height="" width="">
              </div>
          </div>
      </div>
  </div>
<!-- ____________________________ SEPARADOR ____________________________ -->
<div class="col-md-12"> <hr> </div>
<!-- ____________________________ / SEPARADOR ____________________________ -->


   
<!-- ____________________________ GRUPO 2 ____________________________ -->
  <div class="col-md-12" style="background-color: #EFEFEF; ">

      <div class="form-group" style="padding-top: 16px;">

      		<div class="col-md-4 col-md-6 mb-4 mb-lg-0" style="margin-bottom: 20px;">
              <div class="form-group">
                  <label for="bruto" class="form-label">Bruto:</label>
                  <input type="text" name="" id="bruto" min="0" class="form-control" readonly>
                
              </div>
              
          </div>

          <div class="col-md-4 col-md-6 mb-4 mb-lg-0">
              <div class="form-group">
                  <label for="tara" class="form-label">Tara:</label>
                  <input type="number" name="" id="tara" min="0" class="form-control" value="<?php echo  $infoContenedores->tara; ?>" required readonly>
              </div>
          </div>

          <div class="col-md-4 col-md-6 mb-4 mb-lg-0">
              <div class="form-group">
                  <label for="peso_neto" class="form-label">Neto:</label>
                  <input type="number" name="peso_neto" id="peso_neto" min="0" class="form-control" value="<?php echo  $infoContenedores->peso_neto; ?>" readonly required>
              </div>
          </div>
          
            
       
    </div>

      </div> 

  </div>

    <!-- ____________________________ SEPARADOR ____________________________ -->
    <div class="col-md-12"> <hr> </div>
    <!-- ____________________________ / SEPARADOR ____________________________ -->
    <label for="inci">Incidencia</label>
    <button type="button" title="Incidencia" calss="btn btn-primary btn-circle" id="incidencia"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>                                     
                 

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
																			class="form-control" value="<?php echo $infoContenedores->ortr_id ; ?>" readonly>
                                                                    <input type="text" id="tieneInci" style="display:none">   
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
																	<input type="date" name="" id="fechaa" class="form-control" value="<?php echo $infoOTransporte->fec_alta ; ?>" readonly>
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




// llena cantidad de contenedores que faltan 
$( document ).ready(function() {

		var tara = parseInt($("#tara").val());
		var neto =parseInt($("#peso_neto").val());
		var bruto = neto + tara;
		$("#bruto").val(bruto);
		var cont = $("#cont_id").val();
		GetImagen(cont);
});

function jpg($img_b64)
{
    var aux_link = "/";
    for(var i=21; i <= $img_b64.length-1; i++){
                        aux_link = aux_link + $img_b64[i];
                         }
                         img = "data:image/jpeg;base64,"+aux_link;
                         $("#input_aux_img64").val(img);
                         $("#img_base").attr("src",$("#input_aux_img64").val());
                         $("#img_base").attr("width",60);
                         $("#img_base").attr("height",60);
                         var ref = $("#input_aux_img64").val();
                         $("#pdf").attr("href",ref);

}
function GetImagen($cont_id)
{   $(".fa-spinner").show();
    $("#img_base").hide();
    $.ajax({
                type: "POST",
                data: {cont_id: $cont_id},
                url: 'general/transporte-bpm/RegistraSalida/GetImagen',
                success: function ($dato) {
                    
                    $(".fa-spinner").hide();
                    var res = JSON.parse($dato);
                    console.table(res);
                    console.table(res.respuesta.imagen);
                   
                     var img_b64 = res.respuesta.imagen;
            
                   
                   if(img_b64[4]=='a'){
                    pdf(img_b64);
                   }else{
                       if(img_b64[4]=='i'){jpg(img_b64);}
                   }
                   $("#img_base").show();
                    console.table("Como queda src final: "+img_b64);
                }
            });
}
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
                // guarda incidencia nueva
		$("#incidencia").click(function(){
            alert("");
            $("#modalIncidencia").modal('show');
        });
			


function guardarIncindencia(){

	// tomo los datos de circuito editados
	var incidencia = new FormData($('#formIncidencia')[0]);
	incidencia.adjunto = $("#input_aux_img").val();
	incidencia = formToObject(incidencia);		
	//console.table(incidencia);
				var aux = 1;
				$("tieneInci").val(aux);
				
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

function cerrarTarea ()
{

				var taskId = $('#taskId').val();

				var salida = new FormData();
				salida = formToObject(salida);
				salida.cont_id = $("#cont_id").val();
				salida.ortr_id = $("#ortr_id").val();

				if($("#cont_restantes").val() != 0){
						var op = "true";
						var quedanCont = {quedanContenedores : op};
						salida.contrato = quedanCont;
				}else{
						var op = "false";
						var quedanCont = {quedanContenedores : op};
						salida.contrato = quedanCont;
				}

				$.ajax({
								type: 'POST',
								data:{salida},
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

								}
				});
}
</script>