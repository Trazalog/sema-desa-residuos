<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Registrarzona  extends CI_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model('general/Registrarzonas');
    }
    public function guardarDato()
    {
        $datos =  $this->input->post();
        $resp = $this->Registrarzonas->guardarDatos($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
    }
}