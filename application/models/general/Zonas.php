<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zonas extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    public function obtener(){
         $aux = $this->rest->callAPI("GET",REST."zonas");
         $aux =json_decode($aux["data"]);
         return $aux->zonas->zona;
    }
}
