<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Registrarinspector  extends CI_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model('general/Estructura/Inspectores');
    }
    public function guardarDato()
    {
        $datos =  $this->input->post();
        $resp = $this->Inspectores->guardarDatos($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
    }
}