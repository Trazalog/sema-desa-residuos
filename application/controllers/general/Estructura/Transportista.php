<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Transportista extends CI_Controller {


    function __construct(){

      parent::__construct();


      $this->load->model('general/Estructura/Transportistas');
   }




  

      // ---------------- Funcion Cargar vista Transportistas y Datos

      function templateTransportistas()
      {

        // $data['Rsu'] = $this->Transportistas->obtener_RSU();
      
        $this->load->view('layout/Transportistas/registrar_transportista',$data);
          
      }
   
       // ---------------- Funcion Registrar Transportista
   
       function Guardar_Transportista()
       {
        $datos =  $this->input->post('datos');
        $resp = $this->Transportistas->Guardar_Transportista($datos);
        if($resp){
        echo "ok";
        }else{
        echo "error";
        }
       }
   
       // ---------------- Funcion Crear Transportista
   
      function Crear_Transportista()
      {
          
          
      }

      // ---------------- Funcion Listar Transportista
   
      function Listar_Transportista()
      {
        $data["transportistas"] = $this->Transportistas->Listar_Transportistas();         
        $this->load->view('layout/Transportistas/Lista_transportista',$data);

        
          
      }

   
      // ---------------- Funcion Modificar Transportista
   
      function Modificar_Transportista()
      {
          
          
      }
   
       // ---------------- Funcion Borrar Transportista
   
       function Borrar_Transportista()
       {
           
           
       }
   
       
   
       // ---------------- Funcion Suspender Transportista
   
      function Suspender_Transportista()
      {
          
          
      }

      // ---------------- Funciones Obtener --------------------------------//
      

       // ---------------- Funcion Obtener camion
   
       function Obtener_Camiones()
       {
           
           
       }

        // ---------------- Funcion Obtener Contenedores
   
        function Obtener_Contenedores()
        {
             
             
        }

        // ---------------- Funcion Obtener Generador
   
       function Obtener_Generador()
       {
           
           
       }

       
   

}
?>