<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Representa la entidad 
*
* @autor Hugo Gallardo
*/
class Dashs extends CI_Model {
  /**
  * 
  * @param
  * @return
  */
  function __construct(){
  parent::__construct();
  }

  function obtenerMenu(){

    $email = $this->session->userdata('email');
    $aux = $this->rest->callAPI("GET","http://10.142.0.7:8280/services/sema/COREDataService/menuitems/porEmail/".$email);
    $aux =json_decode($aux["data"]);
    return $aux;
  }

}