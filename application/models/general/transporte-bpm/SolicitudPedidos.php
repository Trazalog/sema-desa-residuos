<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Representa a la Entidad SolicitudPedidos
*
* @autor SLedesma
*/
class SolicitudPedidos extends CI_Model
{   
  /**
  * Constructor de Clase
  * @param 
  * @return 
  */
	function __construct()
	{
    parent::__construct();
  }

  /**
  * carga Lista solicitudes_Pedido
  * @param  string user
  * @return string data
  */
  function Listar_Solicitudes_pedido()
  {   
      $data = userNick();
      // $aux = $this->rest->callAPI("GET",REST."/solicitudContenedores/$data"); // servicio que usaria 
      log_message('INFO','#TRAZA|SolicitudPedidos|Listar_Solicitudes_pedido() >> ');
      log_message('DEBUG','#SolicitudPedidos/Listar_Solicitudes_pedido: '.json_encode($data));
      $aux = $this->rest->callAPI("GET",REST."/solicitudContenedor/$data");
      $aux =json_decode($aux["data"]);       
      return $aux;
      
  }

  /**
  * Guarda solicitud_Pedido
  * @param array datos del pedido
  * @return string status
  */
  function Guardar_Solicitud_pedido($data)
  {   
      log_message('INFO','#TRAZA|SolicitudPedidos|Guardar_Solicitud_pedido() >> '); 
      $post["post_solicitud"] = $data;
      log_message('DEBUG','#SolicitudPedidos/Guardar_Solicitud_pedido: '.json_encode($post));
      $aux = $this->rest->callAPI("POST",REST."/RECURSO", $post);
      $aux =json_decode($aux["status"]);
      return $aux;
  }
    
  /**
  * Obtiene Transportistas
  * @param 
  * @return array data
  */
  function obtenerTransportista(){

    log_message('INFO','#TRAZA|SolicitudPedidos|obtenerTransportista() >> ');
    $aux = $this->rest->callAPI("GET",REST."/transportistas");
    $aux =json_decode($aux["data"]);
    return $aux->transportistas->transportista;
  }

  /**
  * Obtiene los tipo de carga
  * @param 
  * @return array data
  */
  function obtener_Tipo_Carga(){
    log_message('INFO','#TRAZA|SolicitudPedidos|obtener_Tipo_Carga() >> '); 
    $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;
  }
   
  /**
  * Obtiene tipos de residuos
  * @param int id del transportista
  * @return array data
  */
  function obtenerTipoResiduos($tran_id){
    log_message('INFO','#TRAZA|SolicitudPedidos|obtenerTipoResiduos() >> '); 
    log_message('DEBUG','#SolicitudPedidos/obtenerTipoResiduos: '.json_encode($tran_id));
    $aux = $this->rest->callAPI("GET",REST."/transportistas/$tran_id/tipo/carga");
    $aux =json_decode($aux["data"]);
    return $aux->tiposCarga->cargas;
  }
  
    /**
		* Registra un nuevo contenedor
		* @param  array datos del contenedor
		* @return array data
		*/
    function RegistrarPedidoContenedor($data){

        $post["solicitudContenedores"] = $data;
        log_message('INFO','#TRAZA|SolicitudPedidos|RegistrarPedidoContenedor() >> ');
        log_message('DEBUG','#SolicitudPedidos/RegistrarPedidoContenedor: '.json_encode($post));
        // $aux = $this->rest->callAPI("POST",REST."/solicitudContenedores", $post); //servicio que llamaba antes de que caiga el server
        $aux = $this->rest->callAPI("POST",API_URL."/solicitudContenedores",$post);
        $aux =json_decode($aux["status"]);
        return $aux;
    }




  function Obtenersoltransp($user)
  {
    $aux = $this->rest->callAPI("GET",REST."/solicitantesTransporte/".$user);
    $aux =json_decode($aux["data"]);
    return $aux->solicitantes_transporte->sotr_id;
  }   

    
}