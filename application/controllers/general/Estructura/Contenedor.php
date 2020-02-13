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
        $data['Estados'] = $this->Contenedores->obtener_Estados();
        // $data[''] = $this->Contenedores->obtener_();
        // $data[''] = $this->Contenedores->obtener_();
        // $data[''] = $this->Contenedores->obtener_();
        // $data[''] = $this->Contenedores->obtener_();
        $this->load->view('layout/Contenedores/registrar_contenedor',$data);
          
      }
   
       // ---------------- Funcion Registrar Contenedor
   
       function Guardar_Contenedor()

       {


        //  var_dump($data);
      // $data["imagen"] = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN";
      // $data["usuario_app"] = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario


           
            $datos =  $this->input->post('datos');
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
      

      
      $this->load->view('layout/Contenedores/solicitud_retiro');
        
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
      $this->load->view('layout/Contenedores/Lista_solicitudes_retiro',$data);
        
        
        
    }

    function Listar_Residuos()
    {

      // $data["residuos"] = $this->Contenedores->Listar_Solicitudes_retiro();
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
       
     // $data[''] = $this->Contenedores->obtener_();
     // $data[''] = $this->Contenedores->obtener_();
    //  $data['Empresas'] = $this->Contenedores->Obtener_empresas();
     // $data['residuos'] = $this->Contenedores->Listar_Residuos();
     // $data['contenedores'] = $this->Contenedores->obtener_();

    //  $data["residuos"] = $this->Contenedores->Listar_Residuos();
     
     $this->load->view('layout/Contenedores/solicitud_pedido');
       
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

   function Listar_SolicitudesPedido()
   {
    
    
    
    // $data["solicitudes"] = $this->Contenedores->Listar_Solicitudes_pedido();
   
    $this->load->view('layout/Contenedores/Lista_solicitudes_pedidos');
      
       
   }
     
  
      
  

     // ---------------- Funciones Obtener --------------------------------//
     

      // ---------------- Funcion Obtener tipo residuo
  
      // function Obtener_empresas()
      // {
          
         
          
      // }

       // ---------------- Funcion obtener contenedor
  
      //  function Obtener_contendor()
      //  {
            
            
      //  }


         
  // ---------------- Funciones ENTREGA CONTENEDOR --------------------------------//


   // ---------------- Funcion Cargar vista Entrega contenedor y Datos

   function templateEntregacontenedor()
   {
       
     // $data[''] = $this->Contenedores->obtener_();
     // $data[''] = $this->Contenedores->obtener_();
     // $data['residuos'] = $this->Contenedores->Listar_Residuos();
     // $data['contenedores'] = $this->Contenedores->obtener_();

    //  $data["residuos"] = $this->Contenedores->Listar_Residuos();
     
     $this->load->view('layout/Contenedores/Entrega_contenedor');
       
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

   function Listar_entregas()
   {
    
    $this->load->view('layout/Contenedores/Lista_entrega');
    
       
   }
     
  
      
  

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
