<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Hecha por Jose Roberto el mas vergas */

/*Ajax Pantalla Registrar Chofer*/
class Registrarvehiculo extends CI_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model('general/Registrarvehiculo');
    }
    public function guardarDato()
    {
        $datos =  $this->input->post();
        $resp = $this->Registrarvehiculo->guardarDatos($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
    }
}
/*_____________________________________________________________*/