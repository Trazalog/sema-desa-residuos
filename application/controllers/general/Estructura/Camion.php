<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Camiones extends CI_Controller {


    function __construct(){

      parent::__construct();

            $this->load->model('general/Estructura/Camiones');
            // $this->load->model('general/Estructura/Contenedores');

    }

   // ---------------- Funcions CHOFERES ---------------------------------------

      // ---------------- Funcion Cargar vista Chofer y Datos
      function templateChoferes()
      {
          // $data[''] = $this->Infracciones->obtener_();
          // $data[''] = $this->Infracciones->obtener_();
          // $data[''] = $this->Infracciones->obtener_();
          // $data[''] = $this->Infracciones->obtener_();       
          
          $this->load->view('layout/registrar_chofer',$data);
      }
      // _________________________________________________________
   
      // ---------------- Funcion Registrar Chofer
      function Guardar_Chofer()
      {
          $datos =  $this->input->post();
          $resp = $this->Camiones->Guardar_Choferes($datos);
          if($resp){
          echo "ok";
          }else{
          echo "error";
          }
      }
      // _________________________________________________________

      // ---------------- Funcion Crear Chofer
      function Crear_Chofer()
      {

      }
      // _________________________________________________________

      // ---------------- Funcion Listar Choferes
      function Listar_Choferes()
      {
  
      }
      // _________________________________________________________
   
      // ---------------- Funcion Modificar Chofer
      function Modificar_Chofer()
      {

      }
      // _________________________________________________________
   
      // ---------------- Funcion Borrar Chofer
      function Borrar_Chofer()
      {

      }
      // _________________________________________________________

      // ---------------- Funcion Suspender Chofer
      function Suspender_Chofer()
      {

      }
      // _________________________________________________________

      // ---------------- Funciones Obtener --------------------------------//

      // ---------------- Funcion Obtener tipo de residuo
      function Obtener_Residuo()
      {
   
      }
      // _________________________________________________________

      // ---------------- Funcion Obtener Transportista
      function Obtener_transportista()
      {

      }
      // _________________________________________________________

      // ---------------- Funcion Obtener Generador
      function Obtener_Generador()
      {
  
      }
      // _________________________________________________________

      // ---------------- Funcions VEHICULORS---------------------------------------

      // ---------------- Funcion Cargar vista Vehiculos y Datos
      function templateVehiculos()
      {
          // $data[''] = $this->Infracciones->obtener_();
          // $data[''] = $this->Infracciones->obtener_();
          // $data[''] = $this->Infracciones->obtener_();
          // $data[''] = $this->Infracciones->obtener_();       
          
        $this->load->view('layout/registrar_vehiculo',$data);  
      }
      // _________________________________________________________

      // ---------------- Funcion Registrar Vehiculo
      function Guardar_Vehiculo()
      {
          $datos =  $this->input->post();
          $resp = $this->Camiones->Guardar_Choferes($datos);
          if($resp){
          echo "ok";
          }else{
          echo "error";
          }
      }
      // _________________________________________________________
   
      // ---------------- Funcion Crear Vehiculo
      function Crear_Vehiculo()
      {

      }
      // _________________________________________________________

      // ---------------- Funcion Listar Vehiculos
      function Listar_Vehiculos()
      {

      }
      // _________________________________________________________

   
      // ---------------- Funcion Modificar Vehiculo
      function Modificar_Vehiculo()
      {

      }
      // _________________________________________________________

      // ---------------- Funcion Borrar Vehiculo
      function Borrar_Vehiculo()
      {

      }
      // _________________________________________________________

      // ---------------- Funcion Suspender Vehiculo
      function Suspender_Vehiculo()
      {

      }
      // _________________________________________________________

      // ---------------- Funciones Obtener --------------------------------//
      
      // ---------------- Funcion Obtener tipo de carnet
      function Obtener_Carnet()
      {

      }
      // _________________________________________________________

}
?>

<!-- class RegistrarC extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('estado_helper');

      $this->load->model('general/Estados');
   }

   function registrarC()
   {
       $data['Estados'] = $this->Estados->obtener();
       $this->load->view('layout/registrar_contenedor', $data);
   }
   
   function templateRc()
   {
       $data['Estados'] = $this->Estados->obtener();
       $this->load->view('layout/registrar_contenedor',$data);
       
   }
} -->

<!-- 
class Registrarcontenedor  extends CI_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model('general/Registrarcontenedores');
    }
    public function guardarDato()
    {
        $datos =  $this->input->post();
        $resp = $this->Registrarcontenedores->guardarDatos($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
    }
} -->