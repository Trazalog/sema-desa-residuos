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
      //___________________________________________________________
   
      // ---------------- Funcion Crear Etapas
      function Crear_Etapa()
      {

      }
      //___________________________________________________________

      // ---------------- Funcion Listar Etapas
      function Listar_Etapas()
      {

      }
      //___________________________________________________________

      // ---------------- Funcion Modificar Etapas
      function Modificar_Etapa()
      {

      }
      //___________________________________________________________
   
      // ---------------- Funcion Borrar Etapas
      function Borrar_Etapa()
      {

      }
      //___________________________________________________________

      // ---------------- Funcion Iniciar Etapa
      function Iniciar_Etapa()
      {

      }
      //___________________________________________________________

      // ---------------- Funcion Finalizar Etapa
      function Finalizar_Etapa()
      {
   
      }
      //___________________________________________________________

       
      // ---------------- Funcion Planificar Etapa
      function Planificar_Etapa()
      {

      }
      //___________________________________________________________

      // ---------------- Funcion Controlar Calidad
      function Controlar_Calidad()
      {

      }
      //___________________________________________________________
 
      // ---------------- Funciones Obtener --------------------------------//
      

      // ---------------- Funcion Obtener Tareas
      function Obtener_Tareas()
      {

      }
      //___________________________________________________________

      // ---------------- Funcion Obtener Batch inicial
      function Obtener_BatchInicial()
      {
     
      }
      //___________________________________________________________

      // ---------------- Funcion Obtener Batch Producto final
      function Obtener_BatchProductoFinal()
      {
     
      }
      //___________________________________________________________
}
?>