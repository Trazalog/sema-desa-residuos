<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Registrarinspectores  extends CI_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model('general/Registrarinspectores');
    }

    public function guardarDato()
    {
        $datos =  $this->input->post();
        $resp = $this->Registrarinspectores->guardarDatos($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
    }

}