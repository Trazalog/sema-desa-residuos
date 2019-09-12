<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ordentrabajo  extends CI_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model('general/Ordentrabajos');
    }

    public function guardarInfo()
    {
        $datos =  $this->input->post();
        $this->Ordentrabajos->guardarInfos($datos);
    }

    public function guardarTransp()
    {
      $datos =  $this->input->post();
      $this->Ordentrabajos->guardarTransps($datos);
    }
}


