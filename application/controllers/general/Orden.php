<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orden extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('empresas_helper');
      $this->load->helper('movilidad_helper');
      $this->load->helper('chofer_helper');
   }
   function index(){
     
   }
   function ordenT()
   {
       $data['empresas'] = empresas(getJson("empresas"));
       $data['movilidad'] = movilidad(getJson("movilidad"));
       $data['chofer'] = chofer(getJson("chofer"));
       $data['fecha'] = date('Y-m-d');
       $this->load->view('layout/orden_transporte', $data);
   }
   function templateOt()
   {
       $this->load->view('layout/template_ot');
   }
}
?>