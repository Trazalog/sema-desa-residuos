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
        
        $aux = $this->rest->callAPI("GET",REST."/contenedores");
        $aux =json_decode($aux["data"]);       
        // return $aux->Rsu->Rsu;
    }
    
// Funcion Guardar Contenedor

function Guardar_Contenedor($data){

    $aux = $this->rest->callAPI("POST",REST."tabladatos", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;	

}
}