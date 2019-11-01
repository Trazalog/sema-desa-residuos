<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Hecha por Jose Roberto el mas vergas */

class Registrartransportista  extends CI_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model('general/Registrartransportistas');
    }
    public function guardarDato()
    {
        $datos =  $this->input->post();
        $resp = $this->Registrartransportistas->guardarDatos($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
    }
}