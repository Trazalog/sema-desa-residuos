<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Registrarchofer extends CI_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model('general/Registrarchofer');
    }
    public function guardarDato()
    {
        $datos =  $this->input->post();
        $resp = $this->Registrarchofer->guardarDatos($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
    }
}
/*_____________________________________________________________*/