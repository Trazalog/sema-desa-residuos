<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SolicitudPedidos extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

    function Listar_Solicitudes_pedido()
    {
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->solicitudes->solicitud;
    }

    function Guardar_Solicitud_pedido($data)
    {
        $post["post_solicitud"] = $data;
        log_message('DEBUG','#Contenedores/Guardar_Solicitud_pedido: '.json_encode($post));
        $aux = $this->rest->callAPI("POST",REST."/RECURSO", $post);
        $aux =json_decode($aux["status"]);
        return $aux;
    }
    
    // Funcion Obtener Transportista
	function obtenerTransportista(){
		//FIXME: DESHARDCODEAR USUARIO
		$usuario_app  = "hugoDS";
		$aux = $this->rest->callAPI("GET",REST."/transportistas");
		$aux =json_decode($aux["data"]);    
		return $aux->transportistas->transportista;
    }
     //esta forma es como esta hecho al principio
   // function obtener_Transportista(){
	// 	//FIXME: DESHARDCODEAR USUARIO
	// 	$usuario_app  = "hugoDS";
	// 	$aux = $this->rest->callAPI("GET",REST."/transportistas/generador/".$usuario_app);
	// 	$aux =json_decode($aux["data"]);    
	// 	return $aux->transportistas->transportista;
    // }
    function obtenerTipoResiduos($tran_id){
        $aux = $this->rest->callAPI("GET",REST."/transportistas/$tran_id/tipo/carga");
        $aux =json_decode($aux["data"]);
        return $aux->tiposCarga->cargas;
    }
    // // Funcion obtenesr RSU habilitado por transportista 
	// function obtener_Tipo_residuo($tran_id)
	// {
	// 	$aux = $this->rest->callAPI("GET",REST."/transportistas/".$tran_id."/tipo/carga");
	// 	$aux =json_decode($aux["data"]);
	// 	//var_dump($aux->tiposCarga->cargas);
	// 	return $aux->tiposCarga->cargas;
	// }
    
}