<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Infracciones extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Infraccion (MODIFICAR)

    // function Listar_Infracciones()
    // {
        
    //     $aux = $this->rest->callAPI("GET",REST."RECURSO");
    //     $aux =json_decode($aux["data"]);       
    //     return $aux-infracciones->infraccion;
    // }
    
// Funcion Guardar Infraccion

function Guardar_Infraccion($data){


    $post["post_infraccion"] = $data;
    log_message('DEBUG','#Infracciones/Guardar_Infraccion: '.json_encode($post));
    $aux = $this->rest->callAPI("POST",REST."/RECURSO", $post);
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

// public function obtener_Generador(){
//     $aux = $this->rest->callAPI("GET",REST."RECURSO");
//     $aux =json_decode($aux["data"]);
//     return $aux->generadores->generador;
// }

// public function obtener_Inspector(){
//     $aux = $this->rest->callAPI("GET",REST."RECURSO");
//     $aux =json_decode($aux["data"]);
//     return $aux->inspectores->inspector;
// }

// public function obtener_Tipo_Infraccion(){
//     $aux = $this->rest->callAPI("GET",REST."RECURSO");
//     $aux =json_decode($aux["data"]);
//     return $aux->infracciones->infraccion;
// }

// public function obtener_Destino_Acta(){
//     $aux = $this->rest->callAPI("GET",REST."RECURSO");
//     $aux =json_decode($aux["data"]);
//     return $aux->destinos->acta;
// }




}