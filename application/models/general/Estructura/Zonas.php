<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Representa a la Entidad Zonas
*
* @autor SLedesma
*/
class Zonas extends CI_Model
{   	/**
    * Constructor de Clase
    * @param 
    * @return 
    */
	function __construct()
	{
		parent::__construct();
    }


		/**
		* Trae listado de Todos las zonas
		* @param 
		* @return array datos de todos las zonas
		*/
function Listar_Zonas()
{
    log_message('INFO','#TRAZA|Zonas|Listar_Zonas() >> ');   
    $aux = $this->rest->callAPI("GET",REST."/zonas");
    $aux =json_decode($aux["data"]);       
    return $aux->zonas->zona;
}

/**
		* Guarda una zona nueva
		* @param array datos zona
		* @return int retorna estado
		*/
function Guardar_Zona($data){

    
    log_message('INFO','#TRAZA|Zonas|Guardar_Zona() >> ');   
    $post["zona"] = $data;
    log_message('DEBUG','#Zonas/Guardar_Zona: '.json_encode($post));
    $aux = $this->rest->callAPI("POST",REST."/zonas", $post);
    $aux =json_decode($aux["status"]);
    return $aux;	

}

/**
		* Actualiza zona
		* @param array datos zona
		* @return string status del servicio
		*/
function Actualizar_Zona($data){
    log_message('INFO','#TRAZA|Zonas|Actualizar_Zona() >> ');   
    $post["zona"] = $data;
    log_message('DEBUG','#Zonas/Actualizar_Zona: '.json_encode($post));
    $aux = $this->rest->callAPI("PUT",REST."/zonas", $post);
    $aux =json_decode($aux["status"]);
    return $aux;
}

/**
		* Actualiza imagen de zona
		* @param array datos imagen
		* @return string status del servicio
		*/
function Actualizar_Zona_Img($data){
    log_message('INFO','#TRAZA|Zonas|Actualizar_Zona_Img() >> ');   
    $post["zona"] = $data;
    log_message('DEBUG','#Zonas/Actualizar_Zona_Img: '.json_encode($post));
    $aux = $this->rest->callAPI("PUT",REST."/zonas/update/imagen",$post);
    $aux =json_decode($aux["status"]);
    return $aux;
}

/**
		* Elimina zona
		* @param array datos zona
		* @return string status del servicio
		*/
public function eliminar_Zona($data){
     log_message('INFO','#TRAZA|Zonas|eliminar_Zona() >> ');   
     $post["_put_zonas_estado"] = $data;
     log_message('DEBUG','#Zonas/#Eliminar_Zona: '.json_encode($post));
     $aux = $this->rest->callAPI("PUT",REST."/zonas/estado", $post);
     $aux =json_decode($aux["status"]);
     return $aux;	
 }



function Guardar_tipo_carga($data){

    log_message('INFO','#TRAZA|Zonas|Guardar_tipo_carga() >> ');   
    $arraycargas["_post_circuitos_tipocarga"]  = $data;  
    $post["_post_circuitos_tipocarga_batch_req"]= $arraycargas;
       
    log_message('DEBUG','#Zonas/Guardar_tipo_carga: '.json_encode($post));
    $aux = $this->rest->callAPI("POST",REST."/_post_circuitos_tipocarga_batch_req", $post);
    return $aux;    
    
}



/**
		* Asignar zona
		* @param string id del departamento
		* @return string data
		*/
function Asignar_Zona($depa_id){

    log_message('INFO','#TRAZA|Zonas|Asignar_Zona() >> ');  
    log_message('DEBUG','#Zonas/Asignar_Zona: '.json_encode($depa_id)); 
    $aux = $this->rest->callAPI("GET",REST."/zonas/departamento/".$depa_id);
    $aux =json_decode($aux["data"]);
    return $aux->zonas->zona;	

}


/**
		* Inserta zona
		* @param array datos zona
		* @return string status del servicio
		*/
function Insertar_zona($data){
    log_message('INFO','#TRAZA|Zonas|Insertar_Zona() >> '); 
    log_message('DEBUG','#Zonas/Asignar_Zona: '.json_encode($data));  
    $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
    $aux =json_decode($aux["status"]);
    return $aux;	
    
    }



function obtener_RSU(){
    log_message('INFO','#TRAZA|Zonas|obtener_RSU() >> ');   
    log_message('DEBUG', 'Zonas/obtener_RSU');
    $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;
}

/**
		* Obtener departamentos
		* @param 
		* @return array departamentos
		*/
function obtener_Departamentos(){
    log_message('INFO','#TRAZA|Zonas|obtener_Departamentos() >> ');   
    $aux = $this->rest->callAPI("GET",REST."/departamentos");
    $aux =json_decode($aux["data"]);
    return $aux->departamentos->departamento;
}

/**
		* Obtener zonas
		* @param 
		* @return array zonas
		*/
function obtener_Zona(){
    log_message('INFO','#TRAZA|Zonas|obtener_Zona() >> ');   
    $aux = $this->rest->callAPI("GET",REST."/zonas");
    $aux =json_decode($aux["data"]);
    return $aux->zonas->Zona;
}

/**
		* Obtener zona por departamentos
		* @param 
		* @return array zonas
		*/

function obtener_Zona_departamento(){
    log_message('INFO','#TRAZA|Zonas|obtener_Zona_departamento() >> ');   
    $aux = $this->rest->callAPI("GET",REST."/zonas/departamento/");
    $aux =json_decode($aux["data"]);
    return $aux->zonas->zona;
}



function obtenerImagen_Zona_Id($dato){
    log_message('INFO','#TRAZA|Zonas|obtenerImagen_Zona_Id() >> ');   
    log_message('DEBUG','#Zonas/obtenerImagen_Zona_Id: '.json_encode($dato)); 
    $auxx = $this->rest->callAPI("GET",REST."/zona/get/imagen/$dato");
    $aux =json_decode($auxx["data"]);
    
    return $aux;
}



}
