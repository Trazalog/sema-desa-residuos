<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transportistas extends CI_Model
{
		function __construct()
		{
			parent::__construct();
    }

		// Funcion Listar Transportistas (MODIFICAR)
    function Listar_Transportistas()
    {        
        $aux = $this->rest->callAPI("GET",REST."/transportistas");
        $aux =json_decode($aux["data"]);       
        return $aux->transportistas->transportista;    
    }
    
		// Funcion Guardar Transportista
		function Guardar_Transportista($data){
				
				$post["post_transportista"] = $data;
				log_message('DEBUG','#Transportistas/Guardar_Transportista: '.json_encode($post));
				$aux = $this->rest->callAPI("POST",REST."/transportistas", $post);
				$aux =json_decode($aux["data"]);
				return $aux->respuesta->tran_id;
		}

		// Funcion asociar transportistas a tipos de carga	
		function asociarTipoCarga($data){

				$post['_post_transportistas_tipo_carga_batch_req']['_post_transportistas_tipo_carga'] = $data;
				log_message('DEBUG','#Transportistas/asociarTipoCarga: '.json_encode($post));
				$aux = $this->rest->callAPI("POST",REST."/_post_transportistas_tipo_carga_batch_req", $post);
				$aux =json_decode($aux["status"]);
				return $aux;
		}

		// modifica datos transportista
		function Modificar_Transportista($transportista){

			$data['_put_transportistas'] = $transportista;			
			log_message('DEBUG','#Transportistas/Modificar_Transportista (datos transportista): '.json_encode($data));		
			$aux = $this->rest->callAPI("PUT",REST."/transportistas", $data);
			$aux =json_decode($aux["status"]);
			return $aux;
		}

		// elimina transportista
		function Borrar_Transportista($tran_id){

			$comp['tran_id'] = $tran_id;
			$comp['eliminado'] = "1";			// para habilitar nuevamente cambiar a "0"
			$data['_put_transportistas_estado'] = $comp;			
			log_message('DEBUG','#Transportistas/Modificar_Transportista (datos transportista): '.json_encode($data));		
			$aux = $this->rest->callAPI("PUT",REST."/transportistas/estado", $data);
			$aux =json_decode($aux["status"]);
			return $aux;
		}

		// elimina tipos de cargas asociados a transportista
		function Borrar_TiposCarga($tran_id){
			
			$comp['tran_id'] = $tran_id;
			$data['_delete_transportista_tipo_carga'] = $comp;		
			log_message('DEBUG','#Transportistas/Borrar_Transportista (tran_id): '.json_encode($data));		
			$aux = $this->rest->callAPI("DELETE",REST."/transportista/tipo/carga", $data);
			$aux =json_decode($aux["status"]);
			return $aux;
		}
// ---------------------- FUNCIONES OBTENER ----------------------

		// Funcion Obtener RSU
    public function obtener_RSU(){
				$aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
				$aux =json_decode($aux["data"]);
				return $aux->valores->valor;
				
		}


}

