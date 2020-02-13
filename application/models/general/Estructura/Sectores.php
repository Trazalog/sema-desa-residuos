<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Sectores extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Ordenes Transporte (MODIFICAR)

    function Listar_Sectores()
    {
        
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->Sectores->Sector;
    }
    
// Funcion Guardar Etapa

function Guardar_Sector($data){

        $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;	

}
}

