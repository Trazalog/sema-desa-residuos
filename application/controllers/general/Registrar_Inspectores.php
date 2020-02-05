<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*----------- CONTROLADOR REGISTRAR Inspectores -----------*/
class RegistrarInspectores extends CI_Controller {
    function __construct(){

    //Controlador que carga todos los selectores de la pantalla 
      parent::__construct();
      //Carga de los Models
       $this->load->model('general/Zonag');
      $this->load->model('general/TipoG');
      $this->load->model('general/Dpto');
   }

   function registrarT()
   {
       $data['Zonag'] = $this->Zonag->obtener();
       $data['TipoG'] = $this->TipoG->obtener();
       $data['Dpto'] = $this->Dpto->obtener();
       $this->load->view('layout/registrar_inspectores', $data);
   }
   function templateRg()
   {
       $data['Zonag'] = $this->Zonag->obtener();
       $data['TipoG'] = $this->TipoG->obtener();
       $data['Dpto'] = $this->Dpto->obtener();
       $this->load->view('layout/registrar_inspectores',$data);
       
   }
}
?>