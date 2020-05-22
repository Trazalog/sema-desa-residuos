<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Representa a la Entidad Contenedores
*
* @autor SLedesma
*/
class Contenedores extends CI_Model
{       /**
    * Constructor de Clase
    * @param 
    * @return 
    */
    function __construct()
    {
        parent::__construct();
    }
        /**
        * Trae listado de Todos los contenedores
        * @param 
        * @return array datos de todos los contenedores
        */
    function Listar_Contenedor()
    {   
        log_message('INFO','#TRAZA|Contenedores|Listar_Contenedor() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/contenedores");
        $aux =json_decode($aux["data"]);       
        return $aux->contenedores->contenedor;
    }
    /**
        * Guarda un nuevo contendor
        * @param array datos del contenedor
        * @return string data
        */    
    function Guardar_Contenedor($data)
    {
        // var_dump($data);
        log_message('INFO','#TRAZA|Contenedores|Guardar_Contenedor() >> '); 
        $post["post_contenedor"] = $data;       
        log_message('DEBUG','#Contenedores/Guardar_Contenedor'.json_encode($post));
        $aux = $this->rest->callAPI("POST",REST."/contenedores", $post);
        $aux =json_decode($aux["data"]);
        return $aux;
    }
     /**
        * Guarda tipo de carga
        * @param array datos tipo de carga
        * @return array tipo de carga
        */  
    function Guardar_tipo_carga($data)
    {
    log_message('INFO','#TRAZA|Contenedores|Guardar_Tipo_Carga() >> '); 
    $arraycargas["_post_contenedores_tipocarga"]  = $data;  
    $post["_post_contenedores_tipocarga_batch_req"]= $arraycargas;
    log_message('DEBUG','#Contenedores/Guardar_tipo_carga: '.json_encode($post));
    $aux = $this->rest->callAPI("POST",REST."/_post_contenedores_tipocarga_batch_req", $post);
    return $aux;    
    }
     /**
        * Actualiza contenedor
        * @param array datos del contenedor
        * @return array contendor
        */
    function actualizar_Contenedor($data){
        log_message('INFO','#TRAZA|Contenedores|actualizar_Contenedor() >> '); 
        $post["put_contenedor"]= $data;
        log_message('DEBUG','#Contenedores/Actualizar_Contenedor'.json_encode($post));
        $aux = $this->rest->callAPI("PUT",REST."/contenedores", $post);
        return $aux;
    }
     /**
        * Eliminar contenedor
        * @param array datos del contenedor
        * @return string estatus del servicio
        */
    function eliminar_Contenedor($data){
         log_message('INFO','#TRAZA|Contenedores|eliminar_Contenedor() >> '); 
         $post["_put_contenedores_estado"] = $data;
         $post2["_put_contenedores_tipocarga_estado"] = $data;
         log_message('DEBUG','#Contenedores/#eliminar_Contenedor: '.json_encode($post));
         log_message('DEBUG','#Contenedores/#eliminar_Contenedor_tipocarga: '.json_encode($post2));
         $aux = $this->rest->callAPI("PUT",REST."/contenedores/estado", $post);
         $aux2= $this->rest->callAPI("PUT",REST."/contenedores/tipoCarga/estado", $post2);
         $aux =json_decode($aux["status"]);
         return $aux;
    }
     /**
        * Borra tipo carga del contenedor
        * @param array datos del tipo de carga del contenedor
        * @return string estatus del servicio
        */    
    function borrar_tipo_Carga($data){
        log_message('INFO','#TRAZA|Contenedores|borrar_tipo_Carga() >> '); 
        $post2["_put_contenedores_tipocarga_estado"] = $data;
        log_message('DEBUG','#Contenedores/#eliminar_Contenedor_tipocarga: '.json_encode($post2));
        $aux2= $this->rest->callAPI("PUT",REST."/contenedores/tipoCarga/estado", $post2);
        $aux =json_decode($aux2["status"]);
        return $aux;
    }
    /**
        * Obtiene el estado del contenedor 
        * @param 
        * @return array estado 
        */  
    function obtener_Estados()
    {
        log_message('INFO','#TRAZA|Contenedores|obtener_Estado() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/tablas/estado_contenedor");
        $aux =json_decode($aux["data"]);
        return $aux->valores->valor;
    }
    /**
        * Obtiene el tipo de carga del contenedor 
        * @param 
        * @return array tipo
        */
    function obtener_Tipo_Carga(){
        log_message('INFO','#TRAZA|Contenedores|obtener_Tipo_Carga() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
        $aux =json_decode($aux["data"]);
        return $aux->valores->valor;
    }
    /**
        * Obtiene los tipos de habilitaciones que posee los contendores
        * @param 
        * @return array data
        */
   function Obtener_Habilitacion()
    {
        log_message('INFO','#TRAZA|Contenedores|Obtener_Habilitacion() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/tablas/habilitacion_contenedor");
        $aux =json_decode($aux["data"]);
        return $aux->valores->valor;
    }
}