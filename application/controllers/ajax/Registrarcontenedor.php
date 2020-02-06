<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Registrarcontenedor  extends CI_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model('general/Estructura/Contenedor');
    }
    public function guardarDato()
    {
        $datos =  $this->input->post();
        $resp = $this->Contenedor->guardarDatos($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
    }
}