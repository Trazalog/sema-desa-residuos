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
         // $data['CircuitosAsignados'] = $this->Zonas->obtener_Circuitos_Asignados();
         // $this->load->view('layout/Zonas/Lista_zona',$data);
         $this->load->view('layout/Zonas/registrar_zona',$data);
          
      }
   
      // ---------------- Funcion Registrar Zona
   
      function Guardar_Zona()
      {
         $datos =  $this->input->post('datos');
         $resp = $this->Zonas->Guardar_Zona($datos);
         if($resp){
         echo "ok";
         }else{
         echo "error";
         }
      }
   
      // ---------------- Funcion Crear Zona
   
      function Crear_Zona()
      {

      }

      // ---------------- Funcion Listar Zona
   
      function Listar_Zona()
      {
         $data["zonas"] = $this->Zonas->Listar_Zonas();         
         $this->load->view('layout/Zonas/Lista_Zona',$data);
      }

   
      // ---------------- Funcion Modificar Zona
      function Modificar_Zona()
      {

      }
      // _________________________________________________________
   
      // ---------------- Funcion Borrar Zona
      function Borrar_Zona()
      {

      }
      // _________________________________________________________

      // ---------------- Funcion Zona 
      function Suspender_Zona()
      {

      }
      // _________________________________________________________

   // --------------------------------- CIRCUITOS ----------------------------------

   // ---------------- Funcion Cargar vista CIRCUITOS y Datos
   function templateCircuitos()
   {
      // $data['tipoResiduos'] = $this->Zonas->obtener_RSU();
      // $data['Vehiculo'] = $this->Zonas->obtener_Vehiculo();
      $data['Chofer'] = $this->Zonas->obtener_Chofer();

      $this->load->view('layout/Zonas/registrar_circuitos',$data);
   }
   // _________________________________________________________

   // ---------------- Funcion Registrar Circuito
   function Guardar_Circuito()
   {
      $datos =  $this->input->post('datos');
      $resp = $this->Zonas->Guardar_Circuito($datos);
      if($resp){
      echo "ok";
      }else{
      echo "error";
      }
   }
   // _________________________________________________________

   // ---------------- Funcion Listar Zona
   function Listar_Circuitos()
   {
      $data["circuitos"] = $this->Zonas->Listar_Circuitos();

      $this->load->view('layout/Zonas/Lista_Circuitos',$data);
   }
   // _________________________________________________________

   // ---------------- Funciones Obtener ---------------- //

      // ---------------- Funcion Obtener Circuitos
      function Obtener_Circuitos()
      {

      }
      // _________________________________________________________

      // ---------------- Funcion Obtener Puntos Criticos
      function Obtener_PuntosCriticos()
      {

      }
      // _________________________________________________________

}
?>