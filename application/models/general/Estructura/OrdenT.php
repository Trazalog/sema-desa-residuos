<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class OrdenT extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Ordenes Transporte (MODIFICAR)

    function Listar_OrdenesT()
    {
        
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->Ordenes->Orden;
    }
    
// Funcion Guardar Orden

function Guardar_OrdenT($data){

        $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;	

}

function Asignar_Transportista($data){

    $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
    $aux =json_decode($aux["status"]);
    return $aux;	

}



// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener Zonas

public function obtener_Zona(){
    $aux = $this->rest->callAPI("GET","http://localhost:3000/rsu");
    $aux =json_decode($aux["data"]);
    return $aux->Zonas->Zona;
}

// Funcion Obtener Tipo de residuo

public function obtener_Tipo_residuo(){
    $aux = $this->rest->callAPI("GET","http://localhost:3000/rsu");
    $aux =json_decode($aux["data"]);
    return $aux->Rsu->Rsu;
}

// Funcion Obtener Disposicion final

public function obtener_Disposicion_Final(){
    $aux = $this->rest->callAPI("GET","http://localhost:3000/rsu");
    $aux =json_decode($aux["data"]);
    return $aux->Disposiciones->Disposicion;
}


// Funcion Obtener Circuitos

public function obtener_Circuitos(){
    $aux = $this->rest->callAPI("GET",REST."/RECURSO");
    $aux =json_decode($aux["data"]);
    return $aux->Ciruitos->Circuito;
}

// Funcion Obtener Chofer

public function obtener_Chofer(){
    $aux = $this->rest->callAPI("GET",REST."/RECURSO");
    $aux =json_decode($aux["data"]);
    return $aux->Choferes->Chofer;
}

// ---------------------- FUNCIONES RECEPCION DE ORDEN  ----------------------




}

