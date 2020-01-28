<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Etapas extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Etapas (MODIFICAR)

    function Listar_Etapas()
    {
        
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->Etapas->Etapa;
    }
    
// Funcion Guardar Etapa

function Guardar_Etapa($data){

        $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;	

}
}

