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
        // $this->load->model('general/Estructura/Vehiculos');
      }

      function templateIncidencia(){
        $data["residuos"] = $this->Incidencias->getTipoResiduos();
        $data["dispfinal"] = $this->Incidencias->getDispFinal();
        $data["incidencia"] = $this->Incidencias->getIncidencia();
        $this->load->view('layout/registrar_incidencia', $data);
      }

      public function guardarIncidencia()
    {
        $datos =  $this->input->post('incidencia');
        $resp = $this->Incidencias->guardarIncidencias($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
    }
    function ListarIncidencias()
    {

       log_message('INFO','#TRAZA|Vehiculo|Listar_Vehiculo() >>');
       $data["incidencia"] = $this->Incidencias->ListarIncidencias(); 
       $this->load->view('layout/Listar_Incidencias', $data);

    }
    function obtenerOt(){
      $nro =  $this->input->post('nroOrden');
      $data["orden"]= $this->Incidencias->ObtenerOT($nro);
      echo json_encode($data);
    }

    function obtenerProximoId(){
      $data = $this->Incidencias->ObtenerProximoID();
      echo json_encode($data);
    }

    function anularIncidencia()
    {
      $data = $this->input->post('id_inci');
      $resp = $this->Incidencias->AnularIncidencia($data);
      if($resp){
        echo "ok";
      }else{
        echo "error";
      }
    }
}
?>