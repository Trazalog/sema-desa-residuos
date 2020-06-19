<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Cabeceras con informacion variable segun proceso BPM
*
* @autor Hugo Gallardo
*/
if(!function_exists('infoproceso')){
   
    function infoproceso($tarea){		
	
			$ci =& get_instance();
			$case_id = $tarea->caseId;
			$processId = $tarea->processId;
			
			switch ($processId) {
				case BPM_PROCESS_ID_PEDIDO_CONTENEDORES:
						log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|obtenerInFoSolicitud($case_id): $case_id >> '.json_encode($case_id));
						$aux = $ci->rest->callAPI("GET",REST."/solicitudContenedores/info/".$case_id);
						$aux =json_decode($aux["data"]);
					break;
				
				case BPM_PROCESS_ID_RETIRO_CONTENEDORES:
					# code...
					break;
					
				case BPM_PROCESS_ID_ENTREGA_ORDEN_TRANSPORTE:
					# code...
					break;
				
				default:
					# code...
					break;
			}
			

			?>

			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-bottom: 7px !important;">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
								Proceso
							</a>
						</h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">							
							
							<?php

								switch ($processId) {

									case BPM_PROCESS_ID_PEDIDO_CONTENEDORES: 
							?>
										<!--_____________ Formulario Solicitud _____________-->
										<form class="formNombre1" id="IDnombre">  
											<div class="col-md-12">
			
													<div class="col-md-6">
															<div class="form-group">
																	<label for="generador" name="">Nº Solicitud:</label>
																	<input type="text" class="form-control habilitar" id="generador" value="<?php echo $aux->solicitud->soco_id; ?>"  readonly>
															</div>
													</div>
													<!--_____________________________________________-->
													
													<div class="col-md-6">
															<div class="form-group">
																	<label for="pedido" name=""> Estado:</label>
																	<input type="text" class="form-control habilitar" id="pedido" value="<?php echo $aux->solicitud->estado; ?>"  readonly>
															</div>
													</div>
													<!--_____________________________________________-->
			
													<div class="col-md-6">
														<div class="form-group">
																<label for="domicilio" name="">Observacion:</label>
																<input type="text" class="form-control habilitar" id="domicilio" value="<?php echo $aux->solicitud->observaciones; ?>"  readonly>
														</div>
													</div>
													<!--_____________________________________________-->
			
													<div class="col-md-6">
															<div class="form-group">
																	<label for="fec_alta" name="">Fecha Alta:</label>
																	<input type="text" class="form-control habilitar" id="fec_alta" value="<?php echo $aux->solicitud->fec_alta; ?>"  readonly>
															</div>
													</div>
												<!--_____________________________________________-->
													
											</div>
										</form>
										<!--_____________ fin forulario solicitud _____________-->
							<?php		
										break;

									case BPM_PROCESS_ID_RETIRO_CONTENEDORES:
										# code...
										break;
											
									case BPM_PROCESS_ID_ENTREGA_ORDEN_TRANSPORTE:
										# code...
										break;		
									
									default:
										# code...
										break;
								}

							?>										
							
							
						</div>
					</div>
				</div>
				
				
			</div>
		
				
			<?php
		}

		

}




?>