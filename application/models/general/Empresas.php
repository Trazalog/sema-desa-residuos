<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Empresas extends CI_Model {
    function __construct()
    {
      parent::__construct();
    }
    
    public function obtener(){
        $aux = $this->rest->callAPI("GET","http://localhost:3000/empresas");
        $aux =json_decode($aux["data"]);
        return $aux->empresas->empresa;
   }
}