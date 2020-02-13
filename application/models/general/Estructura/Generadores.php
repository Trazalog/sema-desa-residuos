<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Generadores extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Generadores (MODIFICAR)

    function Lista_generadores()
    {
        
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->generadores->generador;
    }
    
// Funcion Guardar Generador

function Guardar_Generadores($data){

        $post["post_generador"] = $data;
        log_message('DEBUG','#Generadores/Guardar_Generadores: '.json_encode($post));
        $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;
        
      	

}

// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener Zona

public function obtener_Zonas(){
    $aux = $this->rest->callAPI("GET",REST."/zonas");
    $aux =json_decode($aux["data"]);
    return $aux->zonas->zona;
}

// Funcion Obtener Tipo Generador

public function obtener_Tipo_Generador(){
    $aux = $this->rest->callAPI("GET",REST."http://localhost:3000/tipo");
    $aux =json_decode($aux["data"]);
    return $aux->TipoG->TipoG;
}

// Funcion Obtener Departamento

public function obtener_Departamentos(){
    $aux = $this->rest->callAPI("GET",REST."/departamentos");
    $aux =json_decode($aux["data"]);
    return $aux->departamentos->departamento;
}

// Funcion Obtener Tipo Residuo

public function obtener_Tipo_residuo(){
    $aux = $this->rest->callAPI("GET",REST."http://localhost:3000/tipo");
    $aux =json_decode($aux["data"]);
    return $aux->TipoRSU->residuo;
}





}

