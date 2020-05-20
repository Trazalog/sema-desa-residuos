<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Representa a la Entidad Choferes
*
* @autor Ze Roberto Basañes
*/
class Camiones extends CI_Model
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
        * Trae obtener condicion
        * @param
        * @return
        */
        //FALTA AVERIGUAR DE DONDE VIENE ESTA MIERDA

        public function obtener_Condicion()
        {
            $aux = $this->rest->callAPI("GET",REST."/transportistas");
            $aux =json_decode($aux["data"]);
            return $aux->condiciones->condicion;
        }

    // CHOFERES 

        /**
        * Trae listado de Todos los Choferes
        * @param 
        * @return 
        */
        function Listar_Chofer()
        {
            log_message('INFO','#TRAZA|CHOFERES|Listar_Choferes() >> ');
            $aux = $this->rest->callAPI("GET",REST."/choferes");
            $aux =json_decode($aux["data"]);
            return $aux->choferes->chofere;
        }

        /**
        * Crea un chofer nuevo
        * @param array datos chofer
        * @return int tran_id (id de chofer nuevo)
        */
        function Guardar_Chofer($data)
        {
            log_message('INFO','#TRAZA|CHOFERES|Guardar_Choferes() >> ');
            $post["post_chofer"] = $data;
            log_message('DEBUG','#Choferes/Guardar_Chofer: '.json_encode($post));
            $aux = $this->rest->callAPI("POST",REST."/choferes", $post);
            $aux =json_decode($aux["data"]);
            return $aux;
        }

        /**
        * Actualiza datos del chofer
        * @param array datos de chofer
        * @return string status del servicio
        */
        function Modificar_Chofer($chofer)
        {
            log_message('INFO','#TRAZA|CHOFERES|Modificar_Chofer() >> ');
			$data['_put_choferes'] = $chofer;			
			log_message('DEBUG','#Camiones/Modificar_Chofer (datos choferes): '.json_encode($data));		
			$aux = $this->rest->callAPI("PUT",REST."/camiones", $data);
			$aux =json_decode($aux["status"]);
			return $aux;
        }

		/**
		* borrado logico de chofer
		* @param int id de chofer
		* @return string status del servicio
		*/
        function Borrar_Chofer($data)
        {
			log_message('INFO','#TRAZA|Camiones|Borrar_Chofer() >> ');
            $post["_put_choferes_estado"] = $data;
            log_message('DEBUG','#Camiones/#Borrar_Chofer: '.json_encode($post));
            $aux = $this->rest->callAPI("PUT",REST."/choferes/estado", $post);
            $aux =json_decode($aux["status"]);
            return $aux;	
		}
    // FUNCIONES OBTENER

    // AGREGAR log_message

        /**
        * Funcion Obtener carnet
        * @param
        * @return
        */
        public function obtener_Carnet()
        {
            $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carnet");
            $aux =json_decode($aux["data"]);           
            return $aux->valores->valor;
        }

        /**
        * Funcion Obtener categorias
        * @param 
        * @return 
        */
        public function obtener_Categoria()
        {
            $aux = $this->rest->callAPI("GET",REST."/tablas/categoria_carnet");
            $aux =json_decode($aux["data"]);
            return $aux->valores->valor;
        }

        /**
        * Funcion Obtener empresa
        * @param 
        * @return 
        */
        public function obtener_Empresa()
        {
            $aux = $this->rest->callAPI("GET",REST."/transportistas");
            $aux =json_decode($aux["data"]);
            return $aux->transportistas->transportista;
        }

}