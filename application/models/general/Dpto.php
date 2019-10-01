<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dpto extends CI_Model {
    function __construct()
    {
      parent::__construct();
    }
    
    public function obtener(){
        $aux = $this->rest->callAPI("GET","http://localhost:3000/dpto");
        $aux =json_decode($aux["data"]);
        return $aux->Dpto->Dpto;
   }
}