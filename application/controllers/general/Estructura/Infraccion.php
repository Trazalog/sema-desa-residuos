<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Infraccion extends CI_Controller {


    function __construct(){

      parent::__construct();
   }




  

      // ---------------- Funcion Cargar vista Contenedores y Datos

      function templateInfracciones()
      {
          $this->load->view('layout/registrar_infraccion');
          
          
      }
   
       // ---------------- Funcion Registrar Infraccion
   
       function Guardar_Infraccion()
       
       {

        $datos =  $this->input->post();
        $resp = $this->Infracciones->Guardar_Infraccion($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
           
       }
   
       // ---------------- Funcion Crear Infraccion
   
      function Crear_Infraccion()
      {
          
          
      }

      // ---------------- Funcion Listar Contenedor
   
      function Listar_Infraccion()
      {
          
          
      }

   
      // ---------------- Funcion Modificar Generador
   
      function Modificar_Infraccion()
      {
          
          
      }
   
       // ---------------- Funcion Borrar Contenedor
   
       function Borrar_Contenedor()
       {
           
           
       }
   
       
   
     

      // ---------------- Funciones Obtener --------------------------------//
      

       // ---------------- Funcion Obtener tipo de residuo
   
       function Obtener_Residuo()
       {
           
           
       }

        // ---------------- Funcion Obtener Transportista
   
        function Obtener_transportista()
        {
             
             
        }

        // ---------------- Funcion Obtener Generador
   
       function Obtener_Generador()
       {
           
           
       }

       
   

}
?>