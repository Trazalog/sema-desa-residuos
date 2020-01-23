<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Zona extends CI_Controller {


    function __construct(){

      parent::__construct();

      $this->load->model('general/Estructura/Zonas');
      
      
   }




  

      // ---------------- Funcion Cargar vista Zonas y Datos

      function templateCircuitos()
      
      {
         
         // $data[''] = $this->Zonas->obtener_Transportista();
         // $data[''] = $this->Zonas->obtener_Transportista();
         // $data[''] = $this->Zonas->obtener_Transportista();
         // $data[''] = $this->Zonas->obtener_Transportista();
         $this->load->view('layout/registrar_circuitos',$data);
          
      }
      function templateZonas()
      
      {
         $data['Departamento'] = $this->Zonas->obtener_Departamentos();
         $this->load->view('layout/registrar_zona',$data);
          
      }


   
       // ---------------- Funcion Registrar Zona
   
       function Guardar_Zona()
       {
            $datos =  $this->input->post();
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
          
          
      }

   
      // ---------------- Funcion Modificar Zona
   
      function Modificar_Zona()
      {
          
          
      }
   
       // ---------------- Funcion Borrar Zona
   
       function Borrar_Zona()
       {
           
           
       }

       // ---------------- Funcion Zona 
   
       function Suspender_Zona()
       {
           
           
       }
   
       
   

      // ---------------- Funciones Obtener --------------------------------//
      

       // ---------------- Funcion Obtener Circuitos
   
       function Obtener_Circuitos()
       {
           
           
       }

       // ---------------- Funcion Obtener Puntos Criticos
   
       function Obtener_PuntosCriticos()
       {
           
           
       }

       

       
   

}
?>