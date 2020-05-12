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

    $post["zona"] = $data;
    log_message('DEBUG','#Zonas/Guardar_Zona: '.json_encode($post));
    $aux = $this->rest->callAPI("POST",REST."/zonas", $post);
    $aux =json_decode($aux["status"]);
    return $aux;	

}

//Funcion Editar Zona
function Actualizar_Zona($data){
    $post["zona"] = $data;
    log_message('DEBUG','#Zonas/Actualizar_Zona: '.json_encode($post));
    $aux = $this->rest->callAPI("PUT",REST."/zonas", $post);
    $aux =json_decode($aux["status"]);
    return $aux;
}
function Actualizar_Zona_Img($data){
    $post["zona"] = $data;
    log_message('DEBUG','#Zonas/Actualizar_Zona: '.json_encode($post));
    $aux = $this->rest->callAPI("PUT",REST."/zonas/update/imagen",$post);
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



}

public function obtenerImagen_Zona_Id($dato){
    $auxx = $this->rest->callAPI("GET",REST."/zona/get/imagen/$dato");
    $aux =json_decode($auxx["data"]);
    
    return $aux;
}
public function obtener_Zona_departamento(){
    $aux = $this->rest->callAPI("GET",REST."/zonas/departamento/");
    return $aux->zonas->zona;
}
    $aux =json_decode($aux["data"]);
public function obtener_Zona(){
    $aux = $this->rest->callAPI("GET",REST."/zonas");
    $aux =json_decode($aux["data"]);
    return $aux->zonas->Zona;
}
// Funcion Obtener Departamentos
public function obtener_Departamentos(){
    $aux =json_decode($aux["data"]);
    $aux = $this->rest->callAPI("GET",REST."/departamentos");
    return $aux->departamentos->departamento;
}