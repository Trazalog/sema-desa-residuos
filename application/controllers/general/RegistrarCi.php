<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Hecha por Jose Roberto el mas vergas */
class RegistrarCi extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('choferes_helper');
      $this->load->helper('vehiculos_helper');
      $this->load->helper('tipo_residuos_helper');

      $this->load->model('general/Choferes');
      $this->load->model('general/Vehiculos');
      $this->load->model('general/TipoResiduos');
   }

   function registrarCi()
   {
       $data['Chofer'] = $this->Chofer->obtener();
       $data['Vehiculo'] = $this->Vehiculo->obtener();
       $data['tipoResiduos'] = $this->tipoResiduos->obtener();
       $this->load->view('layout/registrar_circuitos', $data);
   }
   
   function templateRci()
   {
       $data['Chofer'] = $this->Chofer->obtener();
       $data['Vehiculo'] = $this->Vehiculo->obtener();
       $data['tipoResiduos'] = $this->tipoResiduos->obtener();
       $this->load->view('layout/registrar_circuitos', $data);
       
   }
}
?>