<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Representa a la Entidad Camiones
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

// ---------------------- FUNCIONES OBTENER ----------------------

    // Funcion Obtener condicion vehiculo
        public function obtener_Condicion()
        {
            $aux = $this->rest->callAPI("GET",REST."/transportistas");
            $aux =json_decode($aux["data"]);
            return $aux->condiciones->condicion;
        }

// ---------------------- CHOFERES ----------------------

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
            return $aux->respuesta->chof_id;
        }

        /**
        * Actualiza datos del chofer
        * @param array datos de chofer
        * @return string status del servicio
        */
        function Modificar_Chofer($chofer){
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
		function Borrar_Chofer($chof_id){
			log_message('INFO','#TRAZA|CHOFERES|Borrar_Chofer() >> ');
			$comp['chof_id'] = $chof_id;
			$comp['eliminado'] = "1";			// para habilitar nuevamente cambiar a "0"
			$data['_put_choferes_estado'] = $comp;			
			log_message('DEBUG','#Camiones/Modificar_Chofer (datos chofer): '.json_encode($data));		
			$aux = $this->rest->callAPI("PUT",REST."/choferes/estado", $data);
			$aux =json_decode($aux["status"]);
			return $aux;
		}
// ---------------------- FUNCIONES OBTENER ----------------------

    // Funcion Obtener carnet
        public function obtener_Carnet()
        {
            $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carnet");
            $aux =json_decode($aux["data"]);
            return $aux->valores->valor;
        }
    //________________________________________________________

    // Funcion Obtener categorias
        public function obtener_Categoria()
        {
            $aux = $this->rest->callAPI("GET",REST."/tablas/categoria_carnet");
            $aux =json_decode($aux["data"]);
            return $aux->valores->valor;
        }
    //________________________________________________________

    // Funcion Obtener empresa
        public function obtener_Empresa()
        {
            $aux = $this->rest->callAPI("GET",REST."/transportistas");
            $aux =json_decode($aux["data"]);
            log_message('DEBUG','ZEROBERTO BALA'.json_encode($aux->transportistas));
            // return $aux->transportistas;
            return $aux->transportistas->transportista;
        }
    //________________________________________________________

}