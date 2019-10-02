<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Registrargenerador  extends CI_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model('general/Registrargeneradores');
    }

    public function guardarDato()
    {
        $datos =  $this->input->post();
        $resp = $this->Registrargeneradores->guardarDatos($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
    }

}


