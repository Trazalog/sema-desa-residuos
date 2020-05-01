<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Zona extends CI_Controller {

    function __construct(){

      parent::__construct();

      $this->load->model('general/Estructura/Zonas');
     
      
      
   }

// --------------------------------- ZONAS ----------------------------------
  
   // ---------------- Funcion Cargar vista Zonas y Datos
      
      function templateZonas()
      
      {
         $data['Departamentos'] = $this->Zonas->obtener_Departamentos();
         $data['CircuitosAsignados'] = $this->Zonas->obtener_Circuitos_Asignados();
         // $this->load->view('layout/Zonas/Lista_zona',$data);
         $this->load->view('layout/Zonas/registrar_zona',$data);
          
      }
   
      // ---------------- Funcion Registrar Zona
   
      function Guardar_Zona()
      {

         {
            $datos =  $this->input->post('datos');
            $resp = $this->Zonas->Guardar_Zona($datos);
            if($resp){
            echo "ok";
            }else{
            echo "error";
            }
       }

      }
   
      // ---------------- Funcion Listar Zona
   
      function Listar_Zona()
      {
         $data["zonas"] = $this->Zonas->Listar_Zonas();         
         $this->load->view('layout/Zonas/Lista_zona',$data);
      }

   
   

   // --------------------------------- CIRCUITOS ----------------------------------

   
   // ---------------- Funciones Obtener ---------------- //

   

      // ---------------- Funcion Obtener Puntos Criticos
      function obtenerDeptoPorZona(){
         $depa_id = $this->input->post('idDepto');
         $resp = $this->Zonas->Asignar_Zona($depa_id);
         echo json_encode($resp);
      }
       
   

}
?>