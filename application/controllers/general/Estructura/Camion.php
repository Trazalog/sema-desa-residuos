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
   
       // ---------------- Funcion Crear Chofer
   
      function Crear_Chofer()
      {
          
          
      }

      // ---------------- Funcion Listar Choferes
   
      function Listar_Choferes()
      {
          
          
      }

   
      // ---------------- Funcion Modificar Chofer
   
      function Modificar_Chofer()
      {
          
          
      }
   
       // ---------------- Funcion Borrar Chofer
   
       function Borrar_Chofer()
       {
           
           
       }
   
       
   
       // ---------------- Funcion Suspender Chofer
   
      function Suspender_Chofer()
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
   
       // ---------------- Funcion Crear Vehiculo
   
      function Crear_Vehiculo()
      {
          
          
      }

      // ---------------- Funcion Listar Vehiculos
   
      function Listar_Vehiculos()
      {
          
          
      }

   
      // ---------------- Funcion Modificar Vehiculo
   
      function Modificar_Vehiculo()
      {
          
          
      }
   
       // ---------------- Funcion Borrar Vehiculo
   
       function Borrar_Vehiculo()
       {
           
           
       }
   
       
   
       // ---------------- Funcion Suspender Vehiculo
   
      function Suspender_Vehiculo()
      {
          
          
      }

      // ---------------- Funciones Obtener --------------------------------//
      

       // ---------------- Funcion Obtener tipo de carnet
   
       function Obtener_Carnet()
       {
           
           
       }

        
       
   

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