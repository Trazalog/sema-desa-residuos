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

function RegistrarTemplateOT($datos)
{
    $usuario_app = userNick();
    $sotr = $this->rest->callAPI("GET",REST."/solicitantesTransporte/$usuario_app");
    $sotraux =json_decode($sotr["data"]);
    $sotr = $sotraux->solicitantes_transporte->solicitante;
    $sotr_id = $sotr->sotr_id;
    // $datos.sotr_id = $sotr_id;
    $datos->usuario_app = $usuario_app;
    $post["_post_templatesOrdenTransporte"]= $datos;
    $aux = $this->rest->callAPI("POST",REST."/templatesOrdenTransporte", $post);
    $aux =json_decode($aux["status"]);
    return $aux;
}

function Listar_templateOT()
{
    $usuario_app = userNick();
    $sotr = $this->rest->callAPI("GET",REST."/solicitantesTransporte/$usuario_app");
    $sotraux =json_decode($sotr["data"]);
    $sotr = $sotraux->solicitantes_transporte->solicitante;
    $sotr_id = $sotr->sotr_id;
    $aux = $this->rest->callAPI("GET",REST."/templatesOrdenTransporte/list/solicitanteTransporte/38");
    $aux =json_decode($aux["data"]);
    return $aux->templatesOrdenTransporte->templateOrdenTransporte;
}

function actualizar_templateOT($data)
{
    $usuario_app = userNick();
    // $sotr = $this->rest->callAPI("GET",REST."/solicitantesTransporte/$usuario_app");
    // $sotraux =json_decode($sotr["data"]);
    // $sotr = $sotraux->solicitantes_transporte->solicitante;
    // $sotr_id = $sotr->sotr_id;
    $data->usuario_app = $usuario_app;
    log_message('INFO','#TRAZA|TemplateOrdenTP|actualizar_templateOT() >> ');   
    $post["_put_templatesOrdenTransporte"] = $data;
    log_message('DEBUG','#TemplateOrdenTP/actualizar_templateOT: '.json_encode($post));
    $aux = $this->rest->callAPI("PUT",REST."/templatesOrdenTransporte", $post);
    $aux =json_decode($aux["status"]);
    return $aux;
}

function Eliminar_templateOT($data)
{
    log_message('INFO','#TRAZA|TemplateOrdenTP|actualizar_templateOT() >> ');   
    $post["_delete_templateOrdenTransporte"] = $data;
    log_message('DEBUG','#TemplateOrdenTP/actualizar_templateOT: '.json_encode($post));
    $aux = $this->rest->callAPI("DELETE",REST."/templatesOrdenTransporte", $post);
    $aux =json_decode($aux["status"]);
    return $aux;
}


}

