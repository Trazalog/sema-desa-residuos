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
    
// Funcion Guardar Municipio

function Guardar_Transportista($data){

    $post["post_transportista"] = $data;
    log_message('DEBUG','#Transportistas/Guardar_Transportista: '.json_encode($post));
    $aux = $this->rest->callAPI("POST",REST."/transportistas", $post);
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

