<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inspectores extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Inspectores (MODIFICAR)

    function Listar_Inspector()
    {
        
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->inspectores->inspector;
    }
    
// Funcion Guardar Inspector

function Guardar_Inspector($data){

        $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;	

}

// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener Estados

//public function obtener_Estados(){
//    $aux = $this->rest->callAPI("GET",REST."/RECURSO");
//    $aux =json_decode($aux["data"]);
//    return $aux->estados->estado;
//}

// ---------------------- FUNCIONES SOLICITUDES ----------------------

}