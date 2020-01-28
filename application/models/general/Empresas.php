<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Empresas extends CI_Model {
    function __construct()
    {
      parent::__construct();
    }
    
    public function obtener(){
        $aux = $this->rest->callAPI("GET",REST2."transportistas/todo");
        $aux =json_decode($aux["data"]);
        return $aux->transportistas->transportista;
   }
}