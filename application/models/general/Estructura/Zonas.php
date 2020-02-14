<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Zonas extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// ---------------------- FUNCIONES ZONAS ----------------------

// Funcion Listar Zonas (MODIFICAR)
function Listar_Zonas()
{
    $aux = $this->rest->callAPI("GET",REST."/zonas");
    $aux =json_decode($aux["data"]);       
    return $aux->zonas->zona;
}

// Funcion Guardar Zona
function Guardar_Zona($data){

    // var_dump($data);
    // $data["imagen"] = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN";
    // $data["usuario_app"] = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario

    $post["post_zona"] = $data;
    log_message('DEBUG','#Zonas/Guardar_Zona: '.json_encode($post));
    $aux = $this->rest->callAPI("POST",REST."/zonas", $post);
    $aux =json_decode($aux["status"]);
    return $aux;	

}


// ---------------------- FUNCIONES CIRCUITOS ----------------------

// Funcion Listar Circuitos (MODIFICAR)
function Listar_Circuitos()
{
    $aux = $this->rest->callAPI("GET",REST."/circuitos");
    $aux =json_decode($aux["data"]);       
    return $aux->circuitos->circuito;
}

// Funcion Guardar Circuito
function Guardar_Circuito($data){

$post["post_circuito"] = $data;
log_message('DEBUG','#Zonas/Guardar_Circuito: '.json_encode($post));
$aux = $this->rest->callAPI("POST",REST."/circuitos", $post);
$aux =json_decode($aux["status"]);
return $aux;


// $post["post_zona"] = $data;
//     log_message('DEBUG','#Zonas/Guardar_Zona: '.json_encode($post));
//     $aux = $this->rest->callAPI("POST",REST."/zonas", $post);
//     $aux =json_decode($aux["status"]);
//     return $aux;	




}

// Funcion Guardar Zona
function Guardar_Punto_Critico($data){
    $aux = $this->rest->callAPI("POST",REST."/RECURSO",$data);
    $aux =json_decode($aux["status"]);
    return $aux;	
}

// Funcion Botener zonas por departamento

function Asignar_Zona($depa_id){


    $aux = $this->rest->callAPI("GET",REST."/zonas/departamento/".$depa_id);
    $aux =json_decode($aux["data"]);
    return $aux->zonas->zona;	

}

// Funcion Guardar Asignacion de  Zona

function Insertar_zona($data){

    $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
    $aux =json_decode($aux["status"]);
    return $aux;	
    
    }


// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener Circuitos
public function obtener_Circuitos(){
    $aux = $this->rest->callAPI("GET",REST."/circuitos/5");
    $aux =json_decode($aux["data"]);
    return $aux->zonas->zona;
}

// Funcion Obtener Punto Critico

// public function obtener_Punto_Critico(){
//     $aux = $this->rest->callAPI("GET",REST."/puntosCriticos");
//     $aux =json_decode($aux["data"]);
//     return $aux->puntos_criticos->punto;
// }

// Funcion Obtener Tipo RSU
public function obtener_RSU(){
    $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;
}

// Funcion Obtener Vehiculo
public function obtener_Vehiculo(){
    $aux = $this->rest->callAPI("GET",REST."/vehiculos");
    $aux =json_decode($aux["data"]);
    return $aux->vehiculos->vehiculo;
}

// Funcion Obtener Chofer
public function obtener_Chofer(){
    $aux = $this->rest->callAPI("GET",REST."/choferes");
    $aux =json_decode($aux["data"]);
    return $aux->choferes->chofere;
}

// Funcion Obtener Departamentos
public function obtener_Departamentos(){
    $aux = $this->rest->callAPI("GET",REST."/departamentos");
    $aux =json_decode($aux["data"]);
    return $aux->departamentos->departamento;
}

// Funcion Obtener Zona
public function obtener_Zona(){
    $aux = $this->rest->callAPI("GET",REST."/zonas");
    $aux =json_decode($aux["data"]);
    return $aux->zonas->Zona;
}

// Funcion Obtener Zona

public function obtener_Zona_departamento(){
    $aux = $this->rest->callAPI("GET",REST."/zonas/departamento/");
    $aux =json_decode($aux["data"]);
    return $aux->zonas->zona;
}

// Funcion Obtener Circuitos Asignados
public function obtener_Circuitos_Asignados(){
    $aux = $this->rest->callAPI("GET",REST."/circuitos/5");
    $aux =json_decode($aux["data"]);
    return $aux->zonas->zona;
}
}
