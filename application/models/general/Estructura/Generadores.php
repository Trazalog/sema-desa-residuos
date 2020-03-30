<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generadores extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }


// ----------------------------------------------------------------
// Funcion Listar Generadores (MODIFICAR)

    function Lista_generadores()
    {
        $aux = $this->rest->callAPI("GET",REST."/solicitantesTransporte");
        $aux =json_decode($aux["data"]);       
        return $aux->solicitantes_transporte->solicitante;
    }

// ----------------------------------------------------------------
// Funcion Guardar zona

function Guardar_Generadores($data)
{
        $post["post_generador"] = $data;           
        log_message('DEBUG','#Generadores/Guardar_Generadores: '.json_encode($post));
        $aux = $this->rest->callAPI("POST",REST."/solicitantesTransporte", $post);
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
// // ----------------------------------------------------------------
// Funcion Obtener Tipo Generador

public function obtener_Tipo_Generador()
{
    $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_generador");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;
}
// ----------------------------------------------------------------
// Funcion Obtener Departamentos

public function obtener_Departamentos(){
    $aux = $this->rest->callAPI("GET",REST."/departamentos");
    $aux =json_decode($aux["data"]);    
    return $aux->departamentos->departamento;  
}
// ----------------------------------------------------------------
// Funcion Obtener Rubro

public function obtener_Rubro(){
    $aux = $this->rest->callAPI("GET",REST."/tablas/rubro_generador");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;
}
// ----------------------------------------------------------------
// Funcion Obtener Tipo Residuo

public function obtener_Tipo_residuo()
{
    $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;}





}

