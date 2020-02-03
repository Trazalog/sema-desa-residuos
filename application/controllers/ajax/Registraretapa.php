<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Registraretapa  extends CI_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model('general/Registraretapas');
    }
    public function guardarDato()
    {
        $datos =  $this->input->post();
        $resp = $this->Registraretapas->guardarDatos($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
    }
}