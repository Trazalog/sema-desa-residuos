<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Hecha por Jose Roberto el mas vergas */
class Registrarcircuito  extends CI_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model('general/Registrarcircuitos');
    }
    public function guardarDato()
    {
        $datos =  $this->input->post();
        $resp = $this->Registrarcircuitos->guardarDatos($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
    }

    public function guardarCircuito()
    {
      $datos =  $this->input->post();
      $resp = $this->Registrarcircuitos->guardarCircuito($datos);
      if($resp){
        echo "ok";
      }else{
        echo "error";
      }
    }

}
