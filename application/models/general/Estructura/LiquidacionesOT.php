<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Representa a la Entidad LiquidacionesOT
*
* @autor SLedesma
*/
class LiquidacionesOT extends CI_Model
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
	
	function getTransportistas()
	{
			$aux = $this->rest->callAPI("GET",REST."/transportistas");
			$aux =json_decode($aux["data"]);
			return $aux->transportistas->transportista;
	}

	function getDataLiquidaciones($data)
	{
		log_message('INFO','#TRAZA|LiquidacionesOT|getDataLiquidaciones() >> ');  
		log_message('DEBUG','#LiquidacionesOT/getDataLiquidaciones: '.json_encode($data)); 
		$auxx = $this->rest->callAPI("GET","http://localhost:9132/oeosft/api/rest/liquidacionot"); //cambiar recurso por el que haga rodo/hugo REST."/getLiqudaciones/$data"
		$aux =json_decode($auxx["data"]);
		return $aux->liquidacion_ot->liquidacion_ots;
	}
}

?>