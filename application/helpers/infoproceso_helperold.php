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

						log_message('INFO','#TRAZA|INFOPROCESO_HELPER|/solicitudContenedores/info/.$case_id): $case_id >> '.json_encode($case_id));
						$aux = $ci->rest->callAPI("GET",REST."/solicitudContenedores/info/".$case_id);
						$aux =json_decode($aux["data"]);
					break;
				
				case BPM_PROCESS_ID_RETIRO_CONTENEDORES:

						log_message('INFO','#TRAZA|INFOPROCESO_HELPER|/solicitudRetiro/proceso/retiro/case/.$case_id): $case_id >> '.json_encode($case_id));
						$aux = $ci->rest->callAPI("GET",REST."/solicitudRetiro/proceso/retiro/case/".$case_id);
						$data =json_decode($aux["data"]);
						$aux = $data->solicitud_retiro;						
					break;
					
				case BPM_PROCESS_ID_ENTREGA_ORDEN_TRANSPORTE:

						log_message('INFO','#TRAZA|INFOPROCESO_HELPER|/ordenTransporte/info/entrega/case/".$case_id : $case_id >> '.json_encode($case_id));
						
						$aux = $ci->rest->callAPI("GET",REST."/ordenTransporte/info/entrega/case/".$case_id);
						$data =json_decode($aux["data"]);
						$aux = $data->ordenTransporte;
						
						$aux_cont = $ci->rest->callAPI("GET",REST."/contenedoresEntregados/info/entrega/case/".$case_id);
						$data_cont =json_decode($aux_cont["data"]);
						$aux_cont = $data_cont->contenedores->contenedor;
					break;
				
				default:
					# code...
					break;
			}			

		

			$cabecera = 	'<h1>aaaahhhhhhahahhahaha</h1>';
								
		}
		return $cabecera;
}




?>