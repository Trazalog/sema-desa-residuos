<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Transportista extends CI_Controller {


    function __construct(){

      parent::__construct();


      $this->load->model('general/Estructura/Transportistas');
   }




  

      // ---------------- Funcion Cargar vista Transportistas y Datos

      function template()
      {
        $this->load->view('layout/registrar_transportista', $data);
          
      }
   
       // ---------------- Funcion Registrar Transportista
   
       function Guardar_Transportista()
       {
           // $this->load->view('layout/registrar_infraccion');
       }
   
       // ---------------- Funcion Crear Transportista
   
      function Crear_Transportista()
      {
          
          
      }

      // ---------------- Funcion Listar Transportista
   
      function Listar_Transportista()
      {
          
          
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