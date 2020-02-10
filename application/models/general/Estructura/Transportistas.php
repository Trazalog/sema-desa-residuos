<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Transportistas extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

    // Funcion Listar Transportistas (MODIFICAR)
    function Listar_Transportistas()
    {
        $aux = $this->rest->callAPI("GET",REST."/transportista");
        $aux =json_decode($aux["data"]);       
        return $aux->Transportistas->Transportista;
    }

    // Funcion Guardar Zona
    function Guardar_Transportista($data){

        // var_dump($data);
        // $data["imagen"] = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN";
        // $data["usuario_app"] = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario

        $post["post_transportista"] = $data;
        log_message('DEBUG','#Transportistas/Guardar_Transportista: '.json_encode($post));
        $aux = $this->rest->callAPI("POST",REST."/transportistas", $post);
        $aux =json_decode($aux["status"]);
        return $aux;	

    }

    // ---------------------- FUNCIONES OBTENER ----------------------

    // Funcion Obtener RSU
    public function obtener_RSU()
    {
        $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
        $aux =json_decode($aux["data"]);
        return $aux->valores->valor;
    }

    // Funcion Obtener Zona
    public function obtener_Zonas()
    {
        $aux = $this->rest->callAPI("GET",REST."/zonas");
        $aux =json_decode($aux["data"]);
        return $aux->zonas->zona;
    }
    // ----------------------------------------------------------------
}