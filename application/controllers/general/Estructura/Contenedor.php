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
      //___________________________________________________________

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
        //___________________________________________________________

      // ---------------- Funcion Crear Contenedor
      function Crear_Contenedor()
      {

      }
      //___________________________________________________________

      // ---------------- Funcion Listar Contenedor
      function Listar_Contenedor()
      {

      }
      //___________________________________________________________

      // ---------------- Funcion Modificar Generador
      function Modificar_Contenedor()
      {

      }
      //___________________________________________________________

      // ---------------- Funcion Borrar Contenedor
      function Borrar_Contenedor()
      {

      }
      //___________________________________________________________

      // ---------------- Funcion Suspender Contenedor
      function Suspender_Contenedor()
      {

      }
      //___________________________________________________________

      // ---------------- Funciones Obtener --------------------------------//

      // ---------------- Funcion Obtener tipo de residuo
      function Obtener_Residuo()
      {

      }
      //___________________________________________________________

      // ---------------- Funcion Obtener Transportista
      function Obtener_transportista()
      {

      }
      //___________________________________________________________

      // ---------------- Funcion Obtener Generador
      function Obtener_Generador()
      {
  
      }
      //___________________________________________________________

}
?>

