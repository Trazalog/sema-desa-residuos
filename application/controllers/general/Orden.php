<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orden extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('empresas_helper');
      $this->load->helper('zonas_helper');
      $this->load->helper('tipo_residuos_helper');
      $this->load->helper('circuitos_helper');
      $this->load->helper('disposiciones_finales_helper');
      $this->load->model('general/Zonas');
   }
   function index(){
     
   }
   function ordenT()
   {
       $data['empresas'] = empresas(getJson("empresas"));
       $data['disposicionFinal'] = disposicionesFinales(getJson("disposiciones_finales"));
       $data['tipoResiduo'] = tipoResiduos(getJson("tipo_residuos"));
       $data['fecha'] = date('Y-m-d');
       $this->load->view('layout/orden_transporte', $data);
   }
   function templateOt()
   {
       $data['empresas'] = empresas(getJson("empresas"));
       $data['circuito'] = circuitos(getJson("circuitos"));
       $data['disposicionFinal'] = disposicionesFinales(getJson("disposiciones_finales"));
       $data['tipoResiduo'] = tipoResiduos(getJson("tipo_residuos"));
       $data['zona'] = $this->Zonas->obtener();
       $data['fecha'] = date('Y-m-d');
       $this->load->view('layout/template_ot',$data);
       
   }
}
?>