<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Contenedores extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Contenedores

    function Listar_Contenedor()
    {
        
        $parametros["http"]["method"] = "GET";
        $parametros["http"]["header"] = "Accept: application/json";	 		 
        $param = stream_context_create($parametros);
        $resource = '';	 	
        $url = REST.$resource;
        $array = file_get_contents($url, false, $param);
        return json_decode($array);
    }
    
// Funcion Guardar Contenedor

function Guardar_Contenedor($data){

    $_post_setContenedor = array(
        "nombre"=> $data["nombre"]				
    );

    $datos ['_post_setContenedor'] = $_post_setContenedor;
    $data = json_encode($datos);

    $parametros["http"]["method"] = "POST";
    $parametros["http"]["header"] = "Accept: application/json";	
    $parametros["http"]["header"] = "Content-Type: application/json";	
    $parametros["http"]["content"] = $data;	
    $param = stream_context_create($parametros);
    $resource = '/';	 				
    $url = REST.$resource;
    $array = file_get_contents($url, false, $param);
    return json_decode($array);	

}
}