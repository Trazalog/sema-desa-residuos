<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Representa a la Entidad Generadores
*
* @autor SLedesma
*/
class Generadores extends CI_Model
{
    /**
    * Constructor de Clase
    * @param 
    * @return 
    */
		function __construct()
		{
			parent::__construct();
    }

    /**
    * Lista los generadores, obtiene los generadores para listarlos
    * @param 
    * @return array solicitantes, (son los generadores)
    */
    function Lista_generadores()
    {
        log_message('INFO','#TRAZA|Generadores|Lista_generadores() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/solicitantesTransporte");
        $aux =json_decode($aux["data"]);       
        return $aux->solicitantes_transporte->solicitante;
    }


    /**
    * Guarda un nuevo generdaor
    * @param  array data
    * @return int status
    */
    function Guardar_Generadores($data)
    {
        log_message('INFO','#TRAZA|Generadores|Guardar_Generadores() >> '); 
        $usuario = userNick();
        $data['usuario_app'] = $usuario;
        $post["post_generador"] = $data;           
        log_message('DEBUG','#Generadores/Guardar_Generadores: '.json_encode($post));
        $aux = $this->rest->callAPI("POST",REST."/solicitantesTransporte", $post);
        $aux =json_decode($aux["data"]);       
        return $aux->respuesta->sotr_id; 
		}
		
		/**
		* Guarda batch de tipos de carga asociado a un generador (solicitante de transporte)
		* @param array tipos de carga y sotro_id
		* @return 'status' de respuesta servicio
		*/
		function guardar_tipo_carga($data)
		{     
			log_message('INFO','#TRAZA|GENERADORES|guardar_tipo_carga($data) >> ');
			$arraycargas['_post_solicitantestransporte_tipocarga'] = $data;
			$post['_post_solicitantestransporte_tipocarga_batch_req'] = $arraycargas;
			log_message('DEBUG','#TRAZA|GENERADORES|guardar_tipo_carga($data): $post >> '.json_encode($post));
			$aux = $this->rest->callAPI("POST",REST."/_post_solicitantestransporte_tipocarga_batch_req", $post);
			$aux =json_decode($aux["status"]);
			return $aux;
		}


    /**
    * Obtiene todas las zonas 
    * @param  
    * @return array zonas
    */
    public function obtener_Zonas()
    {
        log_message('INFO','#TRAZA|Generadores|obtener_Zonas() >> ');     
        $aux = $this->rest->callAPI("GET",REST."/zonas");
        $aux =json_decode($aux["data"]);
        return $aux->zonas->zona;
    }

    
    /**
    * Obtiene los tipos de generadores
    * @param  
    * @return array valor , tipo de generadores
    */
    public function obtener_Tipo_Generador()
    {   
        log_message('INFO','#TRAZA|Generadores|obtener_Tipo_Generador() >> ');  
        $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_generador");
        $aux =json_decode($aux["data"]);
        return $aux->valores->valor;
    }

    
    /**
    * Obtiene todas los departamentos 
    * @param  
    * @return array departamentos
    */
    public function obtener_Departamentos()
    {
        log_message('INFO','#TRAZA|Generadores|obtener_Departamentos() >> ');  
        $aux = $this->rest->callAPI("GET",REST."/departamentos");
        $aux =json_decode($aux["data"]);    
        return $aux->departamentos->departamento;  
    }

    
    /**
    * Obtiene los rubros
    * @param  
    * @return array valor , rubros
    */
    public function obtener_Rubro()
    {
        log_message('INFO','#TRAZA|Generadores|obtener_Rubro() >> ');  
        $aux = $this->rest->callAPI("GET",REST."/tablas/rubro_generador");
        $aux =json_decode($aux["data"]);
        return $aux->valores->valor;
    }

    
    /**
    * Obtiene todas los tipos de residuos 
    * @param  
    * @return array valort, tipo de residuos
    */
    public function obtener_Tipo_residuo()
    {
        log_message('INFO','#TRAZA|Generadores|obtener_Tipo_residuo() >> ');   
        $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
        $aux =json_decode($aux["data"]);
        return $aux->valores->valor;
    }

    
    /**
    * Actualiza un  generador
    * @param  array data
    * @return array int status
    */
    function actualizar_Generador($data)
    {
        log_message('INFO','#TRAZA|Generadores|actualizar_Generador() >> ');   
        $post["solicitante_transporte"] = $data;
        log_message('DEBUG','#Generadores/actualizar_Generador: '.json_encode($post));
        $aux = $this->rest->callAPI("PUT",REST."/solicitantesTransporte", $post);
        $aux =json_decode($aux["status"]);
        return $aux;
		}
		
		/**
		* Borra tipos de carga asociados a generador
		* @param array tipos carga
		* @return string status de respuesta del servicio
		*/
		function borrar_tipos_carga($data)
		{     
			log_message('INFO','#TRAZA|GENERADORES|borrar_tipos_carga($data) >> ');

			$sotr["sotr_id"] = $data;
			$contrato["_delete_solicitantestransporte_tipocarga"] = $sotr;
			$aux = $this->rest->callAPI("DELETE",REST."/solicitantesTransporte/tipoCarga", $contrato);
			$aux =json_decode($aux["status"]);
			return $aux;			
		}

    /**
    * Borra un  generador
    * @param  array data
    * @return array int status
    */
    function Borrar_Generador($data)
    {
        log_message('INFO','#TRAZA|Generadores|Borrar_Generador() >> '); 
        $post["estado_nuevo"]= $data;
        log_message('DEBUG','#Generadores/#Borrar_Generador: '.json_encode($post));
        $aux = $this->rest->callAPI("PUT",REST."/solicitantesTransporte/estado", $post);
        $aux =json_decode($aux["status"]);
        return $aux;
    }

        /**
     * Devuelve zonas por un determinado departamnto
    * @param int depa_id
    * @return array con info basica de zonas
    */
    function obtener_Zona_departamento($depa_id){
        log_message('INFO','#TRAZA|Generadores| >> ');
        $aux = $this->rest->callAPI("GET",REST."/zonas/departamento/".$depa_id);
        $aux =json_decode($aux["data"]);
        return $aux->zonas->zona;
    }


}

