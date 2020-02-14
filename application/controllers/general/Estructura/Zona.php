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
      
      $data['tipoResiduos'] = $this->Zonas->obtener_RSU();
      // $data['puntos_criticos'] = $this->Zonas->obtener_Punto_Critico();
      $data['Departamentos'] = $this->Zonas->obtener_Departamentos();
      // $data['zonas_departamento'] = $this->Zonas->obtener_Zona_departamento(); 
      $data['Vehiculo'] = $this->Zonas->obtener_Vehiculo();   
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

    // ---------------- Funcion Asignar Circuito
    
   function Asignar_Circuito()
   {
        $datos =  $this->input->post('datos');
        $resp = $this->Zonas->Asignar_Zona($datos);
        if($resp){
        echo "ok";
        }else{
        echo "error";
        }
   }

    // ---------------- Funcion Registrar Punto critico
   
    function Guardar_PuntosCriticos()
    {
         $datos =  $this->input->post('datos');
         $resp = $this->Zonas->Guardar_Punto_Critico($datos);
         if($resp){
         echo "ok";
         }else{
         echo "error";
         }
    }

   // ---------------- Funcion Insertar zona a circuitos

    function insertCircuito()
    {
         $datos =  $this->input->post('datos');
         $resp = $this->Zonas->Insertar_zona($datos);
         if($resp){
         echo "ok";
         }else{
         echo "error";
         }
    }



    

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

       
       function obtenerDeptoPorZona(){
          $depa_id = $this->input->post('idDepto');
          $resp = $this->Zonas->Asignar_Zona($depa_id);
          echo json_encode($resp);
       }
       
   

}
}
?>