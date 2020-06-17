<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class OrdenTransportes extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Ordenes Transporte (MODIFICAR)

    function Listar_ordenes_transporte()
    {
        
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->Ordenes->Orden;
    }
    
// Funcion Guardar Orden

function Guardar_OrdenT(){

        // $post["post_ordenT"] = $data;
        // log_message('DEBUG','#OrdenTransporte/Guardar_OrdenTransporte: '.json_encode($post))
        // $aux = $this->rest->callAPI("POST",REST."/RECURSO", $post);
        // $aux =json_decode($aux["status"]);
        // return $aux;	

        

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

public function obtener_Tipo_residuo()
{
    $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;}

// Funcion Obtener Disposicion final

public function obtener_Disposicion_Final(){
    $aux = $this->rest->callAPI("GET","http://localhost:3000/rsu");
    $aux =json_decode($aux["data"]);
    return $aux->disposiciones->disposicion;
}


// Funcion Obtener Circuitos

public function obtener_Circuitos(){
    $aux = $this->rest->callAPI("GET",REST."/RECURSO");
    $aux =json_decode($aux["data"]);
    return $aux->ciruitos->circuito;
}

// Funcion Obtener Chofer

public function obtener_numero_orden(){
    $aux = $this->rest->callAPI("GET",REST."/ordenTransporte/prox");
    $aux =json_decode($aux["data"]);
    return $aux->respuesta->nueva_ortr_id;
}

function obtenerChofer()
{
    $aux = $this->rest->callAPI("GET",REST."/choferes");
    $aux =json_decode($aux["data"]);
    return $aux->choferes->chofer;
}

function obtenerdispfinal()
{
        log_message('INFO','#TRAZA|Contenedores|obtener_Estado() >> '); 
      $aux = $this->rest->callAPI("GET",REST."/tablas/disposicion_final");
      $aux =json_decode($aux["data"]);
      return $aux->valores->valor;
}

function obtenerEquipo()
{
    log_message('INFO','#TRAZA|Contenedores|obtener_Estado() >> '); 
      $aux = $this->rest->callAPI("GET",REST."/vehiculos");
      $aux =json_decode($aux["data"]);
      return $aux->vehiculos->vehiculo;
    
}

function obtenerContenedores()
{
    log_message('INFO','#TRAZA|SolicitudesRetiro|obtenerContenedor >> ');
    $aux = $this->rest->callAPI("GET",REST."/contenedores");
    $aux =json_decode($aux["data"]);
    return $aux->contenedores->contenedor;	
}
// Funcion Obtener Empresa

// public function obtener_empresa(){
//     $aux = $this->rest->callAPI("GET",REST."/vehiculos/transp/");
//     $aux =json_decode($aux["data"]);
//     return $aux->->;
// }


// Funcion Obtener Vehiculo

// public function obtener_chofer(){
//     $aux = $this->rest->callAPI("GET",REST."/choferes/".);
//     $aux =json_decode($aux["data"]);
//     return $aux->choferes->chofer;
// }
// public function obtener_vehiculo(){
//     $aux = $this->rest->callAPI("GET",REST."/vehiculos/transp/");
//     $aux =json_decode($aux["data"]);
//     return $aux->->;
// }


// ---------------------- FUNCIONES RECEPCION DE ORDEN  ----------------------


// Funcion Listar Ordenes Transporte (MODIFICAR)

// function Listar_OrdenesT()
// {
    
//     $aux = $this->rest->callAPI("GET",REST."/RECURSO");
//     $aux =json_decode($aux["data"]);       
//     return $aux->Ordenes->Orden;

    
// }

// Funcion Guardar Orden

// function Guardar_SolicitudOrden($data){

//     $post["post_solicitudorden"] = $data;
//         log_message('DEBUG','#: '.json_encode($post))
//     $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
//     $aux =json_decode($aux["status"]);
//     return $aux;	

// }

function Asignar_($data){

$aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
$aux =json_decode($aux["status"]);
return $aux;	

}



// ---------------------- FUNCIONES SOLICITUD DE ORDEN  ----------------------





}

