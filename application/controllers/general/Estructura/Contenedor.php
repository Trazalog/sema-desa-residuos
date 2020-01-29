<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Contenedor extends CI_Controller {


    function __construct(){

      parent::__construct();

            
            $this->load->model('general/Estructura/Contenedores');

            
    



   }
  
   // ---------------- Funciones  CONTENEDOR --------------------------------//

      // ---------------- Funcion Cargar vista Contenedores y Datos

      function templateContenedores()
      {
        // $data['Estado'] = $this->Contenedores->obtener_();
        // $data[''] = $this->Contenedores->obtener_();
        // $data[''] = $this->Contenedores->obtener_();
        // $data[''] = $this->Contenedores->obtener_();
        // $data[''] = $this->Contenedores->obtener_();
        $this->load->view('layout/Contenedores/registrar_contenedor',$data);
          
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

        $data["contenedores"] = $this->Contenedores->Listar_Contenedor();
        $this->load->view('layout/Contenedores/Lista_contenedores',$data);
          
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

  // ---------------- Funciones SOLICITUD RETIRO DE ORDEN CONTENEDOR --------------------------------//


    // ---------------- Funcion Cargar vista Solicitud retiroy Datos

    function templateSolicitudRetiro()
    {
        
      // $data[''] = $this->->obtener_();
      // $data[''] = $this->->obtener_();
      // $data[''] = $this->->obtener_();
      // $data[''] = $this->->obtener_();
      

      
      $this->load->view('layout/Contenedores/solicitud_retiro', $data);
        
    }

      // ---------------- Funcion Registrar Orden Transporte

      function Guardar_SolicitudRetiro()
      {
          
      }

      // ---------------- Funcion Crear Orden de transporte

    function Crear_SolicitudRetiro()
    {
        
        
    }

    // ---------------- Funcion Listar OrdenTransporte

    function Listar_SolicitudesRetiro()
    {

      // $data["solicitudes_retiros"] = $this->Contenedores->Listar_Solicitudes_retiro();
      // $this->load->view('layout/Contenedores/Lista_solicitudes_retiro',$data);
        
        
        
    }
      
   
       
   

      // ---------------- Funciones Obtener --------------------------------//
      

       // ---------------- Funcion Obtener tipo residuo
   
       function Obtener_tipo_residuo()
       {
           
           
       }

        // ---------------- Funcion obtener contenedor
   
        function Obtener_contendor()
        {
             
             
        }


       
  // ---------------- Funciones SOLICITUD PEDIDO DE ORDEN CONTENEDOR --------------------------------//


   // ---------------- Funcion Cargar vista Solicitud retiroy Datos

   function templateSolicitudPedido()
   {
       
     // $data[''] = $this->->obtener_();
     // $data[''] = $this->->obtener_();
     // $data[''] = $this->->obtener_();
     // $data['contenedores'] = $this->->obtener_();

     
     $this->load->view('layout/Contenedores/solicitud_pedido',$data);
       
   }

     // ---------------- Funcion Registrar Solicitud Pedido

    //  function Guardar_SolicitudPedido()
    //  {
         
    //  }

     // ---------------- Funcion Crear Solicitud Pedido

  //  function Crear_SolicitudPedido()
  //  {
       
       
  //  }

   // ---------------- Funcion Listar Solicitud Pedido

  //  function Listar_SolicitudesPedido()
  //  {
    
    // $data["solicitudes_pedidos"] = $this->Contenedores->Listar_Solicitudes_pedido();
    // $this->load->view('layout/Contenedores/Lista_solicitudes_pedidos',$data);
      
       
  //  }
     
  
      
  

     // ---------------- Funciones Obtener --------------------------------//
     

      // ---------------- Funcion Obtener tipo residuo
  
      // function Obtener_tipo_residuo()
      // {
          
          
      // }

       // ---------------- Funcion obtener contenedor
  
      //  function Obtener_contendor()
      //  {
            
            
      //  }

   

}
?>

