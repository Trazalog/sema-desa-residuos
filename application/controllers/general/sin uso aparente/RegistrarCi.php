<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RegistrarCi extends CI_Controller {
    function __construct(){

    //Controlador que carga todos los selectores de la pantalla 
      parent::__construct();
      //Carga de los Helpers
      $this->load->helper('choferes_helper');
      $this->load->helper('vehiculos_helper');
      $this->load->helper('tipo_residuos_helper');

      //Carga de los Models
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
/*____________________________________________________________*/
   }
}
?>