<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Hecha por Jose Roberto el mas vergas */
class Registrarinspector  extends CI_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model('general/Registrarestablecimientos');
    }
    public function guardarDato()
    {
        $datos =  $this->input->post();
        $resp = $this->Registrarestablecimientos->guardarDatos($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
    }
}