<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Representa a la Solicitud de Retiro de Contenedores
*
* @autor Hugo Gallardo
*/
class SolicitudesRetiro extends CI_Model {
  
  /**
  * constructor de clase SolicitudRetiro
  * @param 
  * @return 
  */
  function __construct()
  {
    parent::__construct();
  }     

  // ---------------------- FUNCIONES OBTENER ----------------------
  
  /**
  * Devuelve id de proxima solicitud de retiro
  * @param 
  * @return int nuevo_sore_id
  */
  function solicitudRetiroProx(){
		$aux = $this->rest->callAPI("GET",REST."/solicitudRetiro/prox");
		$aux =json_decode($aux["data"]);   
		return $aux->respuesta->nuevo_sore_id;
	}

  /**
  * Trae listado de Todos los transportistas 
  * @param 
  * @return array datos de todos los transportistas
  */  
  function obtener_Transportista()
  {
    log_message('INFO','#TRAZA|SolicitudesRetiro|Listar_Transportistas() >> '); 
      $aux = $this->rest->callAPI("GET",REST."/transportistas");
      $aux =json_decode($aux["data"]);
      return $aux->transportistas->transportista;
  }

  /**
  * Obtiene los tipos de carga autorizados de cada transportista
  * @param 
  * @return array con tipos de carga
  */
  public function obtener_Tipo_residuo($tran_id){
    
    log_message('INFO','#TRAZA|SolicitudesRetiro|obtener_Tipo_residuo >> ');
    $aux = $this->rest->callAPI("GET",REST."/transportistas/".$tran_id."/tipo/carga");
    $aux =json_decode($aux["data"]);
    return $aux->tiposCarga->cargas;				
  }

    
}