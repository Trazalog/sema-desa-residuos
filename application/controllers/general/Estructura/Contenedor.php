<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contenedor extends CI_Controller {

    function __construct(){

      parent::__construct();

            $this->load->model('general/Estructura/Contenedores');
   }

      // ---------------- Funcion Cargar vista Contenedores y Datos

      function templateContenedores()
      {
        // $data['Estados'] = $this->Contenedores->obtener_();

        $this->load->view('layout/registrar_contenedor');
      }

       // ---------------- Funcion Registrar Contenedor

       function Guardar_Contenedor()
       {
            $datos =  $this->input->post();
            $resp = $this->Contenedores->Guardar_Contenedor($datos);
            if($resp){
            echo "ok";
            }else{
            echo "error";
            }
        }

       // ---------------- Funcion Crear Contenedor

      function Crear_Contenedor()
      {

      }

      // ---------------- Funcion Listar Contenedor

      function Listar_Contenedor()
      {

      }

      // ---------------- Funcion Modificar Generador

      function Modificar_Contenedor()
      {

      }

      // ---------------- Funcion Borrar Contenedor

      function Borrar_Contenedor()
      {

      }

      // ---------------- Funcion Suspender Contenedor

      function Suspender_Contenedor()
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

