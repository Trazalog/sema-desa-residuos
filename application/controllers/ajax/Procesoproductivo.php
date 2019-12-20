<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Hecha por Jose Roberto el mas vergas */

class Procesoproductivo  extends CI_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model('general/Procesoproductivo');
    }
    public function guardarDato()
    {
        $datos =  $this->input->post();
        $resp = $this->Procesoproductivo->guardarDatos($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
    }
/*
    public function guardarProceso()
    {
      $datos =  $this->input->post();
      $resp = $this->Procesoproductivo->guardarProceso($datos);
      if($resp){
        echo "ok";
      }else{
        echo "error";
      }
    }
*/
}