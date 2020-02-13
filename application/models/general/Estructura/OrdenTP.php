<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class OrdenTP extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Ordenes Transporte Privados (MODIFICAR)

    function Listar_OrdenesTP()
    {
        
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->Ordenes->Orden;
    }
    
// Funcion Guardar Orden

function Guardar_OrdenTP($data){

        $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;	

}

// Funcion Guardar Asignar Transportista

function Asignar_Transportista($data){

    $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
    $aux =json_decode($aux["status"]);
    return $aux;	

}



// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener Disposicion Final

public function obtener_disposicion_Final(){
    $aux = $this->rest->callAPI("GET","http://localhost:3000/rsu");
    $aux =json_decode($aux["data"]);
    return $aux->Disposiciones->Disposicion;
}

public function obtener_Tipo_residuo(){
    $aux = $this->rest->callAPI("GET","http://localhost:3000/rsu");
    $aux =json_decode($aux["data"]);
    return $aux->Rsu->Rsu;
}

public function obtener_Generadores(){
    $aux = $this->rest->callAPI("GET","http://localhost:3000/rsu");
    $aux =json_decode($aux["data"]);
    return $aux->Generadores->Generador;
}



// ---------------------- FUNCIONES RECEPCION DE ORDEN  ----------------------





}

