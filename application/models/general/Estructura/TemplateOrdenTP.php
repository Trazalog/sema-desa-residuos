<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class TemplateOrdenTP extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Ordenes Transporte Privados (MODIFICAR)

//     function Listar_OrdenesTP()
//     {
        
//         $aux = $this->rest->callAPI("GET",REST."/RECURSO");
//         $aux =json_decode($aux["data"]);       
//         return $aux->Ordenes->Orden;
//     }
    
// // Funcion Guardar Orden

// function Guardar_OrdenTP($data){

//         $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
//         $aux =json_decode($aux["status"]);
//         return $aux;	

// }

// // Funcion Guardar Asignar Transportista

// function Asignar_Transportista($data){

//     $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
//     $aux =json_decode($aux["status"]);
//     return $aux;	

// }



// // ---------------------- FUNCIONES OBTENER ----------------------

// // Funcion Obtener Disposicion Final

// public function obtener_disposicion_Final(){
//     $aux = $this->rest->callAPI("GET","http://localhost:3000/rsu");
//     $aux =json_decode($aux["data"]);
//     return $aux->Disposiciones->Disposicion;
// }

// public function obtener_Tipo_residuo(){
//     $aux = $this->rest->callAPI("GET","http://localhost:3000/rsu");
//     $aux =json_decode($aux["data"]);
//     return $aux->Rsu->Rsu;
// }

// public function obtener_Generadores(){
//     $aux = $this->rest->callAPI("GET","http://localhost:3000/rsu");
//     $aux =json_decode($aux["data"]);
//     return $aux->Generadores->Generador;
// }



// ---------------------- FUNCIONES RECEPCION DE ORDEN  ----------------------


function obtenerEmpresa()
{
    $aux = $this->rest->callAPI("GET",REST."/transportistas");
    $aux =json_decode($aux["data"]);
    return $aux->transportistas->transportista;
}

function obtenerCircuito()
{
    $aux = $this->rest->callAPI("GET",REST."/circuitos");
    $aux =json_decode($aux["data"]);
    return $aux->circuitos->circuito;
}

function obtenerDispFinal()
{
    $aux = $this->rest->callAPI("GET",REST."/tablas/disposicion_final");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;
}

function obtenerTipoRes()
{
    $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;
}

function obtenerZona()
{
    $aux = $this->rest->callAPI("GET",REST."/zonas");
    $aux =json_decode($aux["data"]);
    return $aux->zonas->zona;
}

function obtenerChofer()
{
    $aux = $this->rest->callAPI("GET",REST."/choferes");
    $aux =json_decode($aux["data"]);
    return $aux->choferes->chofer;
}

function ObtenerVehixtran_id($tran_id)
{
    $aux = $this->rest->callAPI("GET",REST."/vehiculos/transp/$tran_id");
    $aux =json_decode($aux["data"]);
    return $aux->vehiculos->vehiculo;
}
}

