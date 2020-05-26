<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Representa a la Entidad Choferes
*
* @autor Hugo Gallardo
*/
class Choferes extends CI_Model
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
		* Trae listado de Todos los Choferes
		* @param 
		* @return 
		*/
		function Listar_Chofer()
		{
				log_message('INFO','#TRAZA|CHOFERES|Listar_Choferes() >> ');
				$aux = $this->rest->callAPI("GET",REST."/choferes");
				$aux =json_decode($aux["data"]);
				return $aux->choferes->chofer;
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
				log_message('DEBUG','#TRAZA|CHOFERES|Guardar_Choferes(): $post '.json_encode($post));
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
				log_message('DEBUG','#CHOFERES/Modificar_Chofer (datos choferes): '.json_encode($data));		
				$aux = $this->rest->callAPI("PUT",REST."/choferes", $data);
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
				log_message('INFO','#TRAZA|Choferes|Borrar_Chofer() >> ');
				$chofer['chof_id'] = $data;
				$post["_delete_choferes"] = $chofer;
				log_message('DEBUG','#CHOFERES/#Borrar_Chofer: '.json_encode($post));
				$aux = $this->rest->callAPI("DELETE",REST."/choferes", $post);
				$aux =json_decode($aux["status"]);
				return $aux;	
		}

		// ___________________________FUNCIONES OBTENER______________________________

		/**
		* Funcion Obtener carnet
		* @param
		* @return array con tipos de carnet
		*/
		public function obtener_Carnet()
		{
				log_message('INFO','#TRAZA|CHOFERES|obtener_Carnet() >> ');
				$aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carnet");
				$aux =json_decode($aux["data"]);           
				return $aux->valores->valor;
		}

		/**
		* Funcion Obtener categorias
		* @param 
		* @return array con info de categorias de carnet 
		*/
		public function obtener_Categoria()
		{
				log_message('INFO','#TRAZA|CHOFERES|obtener_Categoria() >> ');
				$aux = $this->rest->callAPI("GET",REST."/tablas/categoria_carnet");
				$aux =json_decode($aux["data"]);
				return $aux->valores->valor;
		}

		/**
		* Funcion Obtener empresa
		* @param 
		* @return array con info de transportistas
		*/
		public function obtener_Empresa()
		{
				log_message('INFO','#TRAZA|CHOFERES|obtener_Empresa() >> ');
				$aux = $this->rest->callAPI("GET",REST."/transportistas");
				$aux =json_decode($aux["data"]);
				return $aux->transportistas->transportista;
		}

		/**
		* Obtine una imagen por chof_id
		* @param int chof_id
		* @return bynay imagen
		*/
		function obtener_Imagen($chof_id)
		{     
				log_message('INFO','#TRAZA|CHOFERES|obtener_Imagen() >> ');
				log_message('DEBUG','#TRAZA|CHOFERES|obtener_Imagen(): $chof_id >> '.json_encode($chof_id));
				$aux = $this->rest->callAPI("GET",REST."/choferes/imagen/".$chof_id);
				$aux =json_decode($aux["data"]);
				return $aux->choferes->imagen;
		}
		
}