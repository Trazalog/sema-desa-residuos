<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Municipios extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Municipios (MODIFICAR)

    function Listar_Municipios()
    {
        
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->Municipios->Municipio;
    }
    
// Funcion Guardar Municipio

function Guardar_Municipio($data){

        $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;	

}
}

