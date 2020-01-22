<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Infracciones extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Infraccion (MODIFICAR)

    function Listar_Infraccion()
    {
        
        $aux = $this->rest->callAPI("GET",REST."/contenedores");
        $aux =json_decode($aux["data"]);       
        return $aux-Infracciones->Infraccion;
    }
    
// Funcion Guardar Infraccion

function Guardar_Infraccion($data){

    $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;	

}
}