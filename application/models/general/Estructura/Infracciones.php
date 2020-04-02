<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Infracciones extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Infraccion (MODIFICAR)

    function Lista_infracciones()
    {
        
        $aux = $this->rest->callAPI("GET",REST."/actaInfraccion");
        $aux =json_decode($aux["data"]);       
        return $aux->actas->acta;
    }
    
// Funcion Guardar Infraccion

function Guardar_Infraccion($data){

    // $data['usuario_app'] = userNick();   
    $post["_post_actainfraccion"] = $data;
    log_message('DEBUG','#Infracciones/Guardar_Infraccion: '.json_encode($post));
    $aux = $this->rest->callAPI("POST",REST."/actaInfraccion", $post);
    $aux =json_decode($aux["status"]);
    return $aux;
        
        
   
}




// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener Transportista

public function obtener_Transportista(){
    $aux = $this->rest->callAPI("GET",REST."/transportistas/todo");
    $aux =json_decode($aux["data"]);    
    return $aux->transportistas->transportista;
}

// Funcion Obtener Generador

public function obtener_Generador(){
    $aux = $this->rest->callAPI("GET",REST."/solicitantesTransporte");
    $aux =json_decode($aux["data"]);
    return $aux->solicitantes_transporte->solicitante;
}

// public function obtener_Inspector(){
//     $aux = $this->rest->callAPI("GET",REST."RECURSO");
//     $aux =json_decode($aux["data"]);
//     return $aux->inspectores->inspector;
// }

public function obtener_Tipo_Infraccion(){
    $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_infraccion");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;
}

// public function obtener_Destino_Acta(){
//     $aux = $this->rest->callAPI("GET",REST."RECURSO");
//     $aux =json_decode($aux["data"]);
//     return $aux->destinos->acta;
// }




}