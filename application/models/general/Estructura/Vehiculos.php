<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Representa a la Entidad Vehiculos
*
* @autor Ze Roberto Basañes
*/
class Vehiculos extends CI_Model
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
	* Trae listado de Todos los Vehiculos
	* @param
	* @return string data
	*/
	function Listar_Vehiculo()
	{
			$aux = $this->rest->callAPI("GET",REST."/vehiculos");
			$aux =json_decode($aux["data"]);
			return $aux->vehiculos->vehiculo;
	}

		/**
	* Guarda un nuevo vehiculo
	* @param  string data
	* @return string status
	*/
	function Guardar_Vehiculos($data)
	{
			$post["post_vehiculo"] = $data;
			log_message('DEBUG','#Vehiculos/Guardar_Vehiculos:'.json_encode($post));
			$aux = $this->rest->callAPI("POST",REST."/vehiculos", $post);
			$aux =json_decode($aux["status"]);
			return $aux;
	}

	/**
	* obtiene los transportistas
	* @param 
	* @return string data
	*/
	public function Obtener_Transportista()
	{
			$aux = $this->rest->callAPI("GET",REST."/transportistas");
			$aux =json_decode($aux["data"]);
			return $aux->transportistas->transportista;
	}

		/**
	* Elimina un vehiculo dado su id
	* @param  string equi_id , numero
	* @return string status
	*/
	function Borrar_vehiculo($data){
			log_message('INFO','#TRAZA|Vehiculos|Borrar_vehiculo() >> '); 
			$post["_delete_vehiculos"]= $data;
			log_message('DEBUG','#Vehiculos/#Borrar_vehiculo: '.json_encode($post));
			$aux = $this->rest->callAPI("DELETE",REST."/vehiculos", $post);
			$aux =json_decode($aux["status"]);
			return $aux;
	}

	function actualizar_Vehiculo($data){
			log_message('INFO','#TRAZA|Vehiculos|Actualizar_Vehiculo() >> ');   
			$post["_put_vehiculos"] = $data;
			log_message('DEBUG','#Vehiculos/Actualizar_Vehiculo: '.json_encode($post));
			$aux = $this->rest->callAPI("PUT",REST."/vehiculos", $post);
			$aux =json_decode($aux["status"]);
			return $aux;
	}
	function obtenerImagen_Vehi_Id($equi_id)
	{
			log_message('INFO','#TRAZA|Vehiculo|obtenerImagen_Vehi_Id() >> ');   
			log_message('DEBUG','#Vehiculo/obtenerImagen_Vehi_Id: '.json_encode($equi_id)); 
			$auxx = $this->rest->callAPI("GET",REST."/vehiculos/imagen/$equi_id");
			$aux =json_decode($auxx["data"]);
			return $aux;
	}

	/**
	* Obtiene todos los tipos de carga
	* @param
	* @return array con tipos de carga
	*/
	public function obtener_RSU(){

		log_message('INFO','#TRAZA|TRANSPORTISTAS|obtener_RSU >> ');
		$aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
		$aux =json_decode($aux["data"]);
		return $aux->valores->valor;
	}


}

?>