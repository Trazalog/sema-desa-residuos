<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('infoGenerador')){
   
    function infoGenerador($case_id){		
	
			$ci =& get_instance();
		 
      log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|obtenerInFoSolicitud($case_id): $case_id >> '.json_encode($case_id));
      $aux = $ci->rest->callAPI("GET",REST."/solicitudContenedores/info/".$case_id);
      $aux =json_decode($aux["data"]);
      //var_dump($aux->solicitud);   


			?>
			<!-- echo '         -->
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
								Solicitud de Contenedor
							</a>
						</h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
							<!--_____________ Formulario informacion _____________-->
							<form class="formNombre1" id="IDnombre">  
								<div class="col-md-12">

										<div class="col-md-6">
												<div class="form-group">
														<label for="generador" name="">Generador:</label>
														<input type="text" class="form-control habilitar" id="generador" value="<?php echo $aux->solicitud->razon_social; ?>"  readonly>
												</div>
										</div>
										<!--_____________________________________________-->
										
										<div class="col-md-6">
												<div class="form-group">
														<label for="pedido" name=""> Nº Pedido:</label>
														<input type="text" class="form-control habilitar" id="pedido" value="<?php echo $aux->solicitud->soco_id; ?>"  readonly>
												</div>
										</div>
										<!--_____________________________________________-->

										<div class="col-md-6">
											<div class="form-group">
													<label for="domicilio" name="">Direccion:</label>
													<input type="text" class="form-control habilitar" id="domicilio" value="<?php echo $aux->solicitud->domicilio; ?>"  readonly>
											</div>
										</div>
										<!--_____________________________________________-->

										<div class="col-md-6">
												<div class="form-group">
														<label for="fec_alta" name="">Fecha Retiro:</label>
														<input type="text" class="form-control habilitar" id="fec_alta" value="<?php echo $aux->solicitud->fec_alta; ?>"  readonly>
												</div>
										</div>
									<!--_____________________________________________-->
										
								</div>
							</form>
							<!--_____________ fin forulario _____________-->
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingTwo">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								Transportista
							</a>
						</h4>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
						<div class="panel-body">
							Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingThree">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								Generador
							</a>
						</h4>
					</div>
					<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
						<div class="panel-body">
							Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
						</div>
					</div>
				</div>
			</div>
			<!-- '; -->
				
			<?php
		} 

}


?>