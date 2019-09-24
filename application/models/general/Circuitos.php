<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Circuitos extends CI_Model {
    function __construct()
    {
      parent::__construct();
    }
    
    public function obtener(){
        $aux = $this->rest->callAPI("GET","http://localhost:8080/circuitos");
        $aux =json_decode($aux["data"]);
        return $aux->circuitos->circuito;
   }
}