<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Etapa extends CI_Controller {


    function __construct(){

      parent::__construct();
   }




  

      // ---------------- Funcion Cargar vista Etapas y Datos

      function templateEtapas()
      
      {

          // $data[''] = $this->Infracciones->obtener_();
          // $data[''] = $this->Infracciones->obtener_();
          // $data[''] = $this->Infracciones->obtener_();
          // $data[''] = $this->Infracciones->obtener_();
       
         $this->load->view('layout/registrar_etapa');
          
      }
   
       // ---------------- Funcion Registrar Etapas
   
       function Guardar_Etapa()
       {
           // $this->load->view('layout/registrar_infraccion');
       }
   
       // ---------------- Funcion Crear Etapas
   
      function Crear_Etapa()
      {
          
          
      }

      // ---------------- Funcion Listar Etapas
   
      function Listar_Etapas()
      {
          
          
      }

   
      // ---------------- Funcion Modificar Etapas
   
      function Modificar_Etapa()
      {
          
          
      }
   
       // ---------------- Funcion Borrar Etapas
   
       function Borrar_Etapa()
       {
           
           
       }
   
       
   
       // ---------------- Funcion Iniciar Etapa
   
      function Iniciar_Etapa()
      {
          
          
      }

       // ---------------- Funcion Finalizar Etapa
   
       function Finalizar_Etapa()
       {
           
           
       }

       
        // ---------------- Funcion Planificar Etapa
   
      function Planificar_Etapa()
      {
          
          
      }

       // ---------------- Funcion Controlar Calidad
   
       function Controlar_Calidad()
       {
           
           
       }
 

      // ---------------- Funciones Obtener --------------------------------//
      

       // ---------------- Funcion Obtener Tareas
   
       function Obtener_Tareas()
       {
           
           
       }

        // ---------------- Funcion Obtener Batch inicial
   
        function Obtener_BatchInicial()
        {
             
             
        }

        // ---------------- Funcion Obtener Batch Producto final
   
        function Obtener_BatchProductoFinal()
        {
             
             
        }

       
   

}
?>