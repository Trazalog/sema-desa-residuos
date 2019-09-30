<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DisposisionesFinales extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

    public function obtener(){
         $aux = $this->rest->callAPI("GET","http://localhost:3000/disposisionesfinales");
         $aux =json_decode($aux["data"]);
         return $aux->disposicionesFinales->disposicionFinal;
    }
}