<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contenedores extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Contenedores (MODIFICAR)

    function Listar_Contenedor()
    {
        
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->contenedores->contenedor;
    }
    
// Funcion Guardar Contenedor

function Guardar_Contenedor($data){

        $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;	

}

// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener Estados

public function obtener_Estados(){
    $aux = $this->rest->callAPI("GET",REST."/tablas/estado_contenedor");
    $aux =json_decode($aux["data"]);
    return $aux->estados->estado;
}

// ---------------------- FUNCIONES SOLICITUDES ----------------------

}