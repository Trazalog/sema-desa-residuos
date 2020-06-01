<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Representa a la Entidad  Incidencia
*
* @autor SLedesma
*/
class Incidencia extends CI_Controller {
   /**
    * Constructor de Clase
    * @param 
    * @return 
    */
  function __construct()
      {
        parent::__construct();
        $this->load->model('general/Estructura/Incidencias');
      }

      function templateIncidencia(){
        $this->load->view('layout/registrar_incidencia');
      }

      public function guardarDato()
    {
        $datos =  $this->input->post('datos');
        $resp = $this->Incidencias->guardarDatos($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
    }

}
?>