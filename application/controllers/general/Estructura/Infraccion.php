<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Infraccion extends CI_Controller {


    function __construct(){

      parent::__construct();


      $this->load->model('general/Estructura/Infracciones');

   }




  

      // ---------------- Funcion Cargar vista Contenedores y Datos

      function templateInfracciones()
      
      
      {
          $data['transportista'] = $this->Infracciones->obtener_Transportista();
          $data['generador'] = $this->Infracciones->obtener_Generador();
          // $data['inspector'] = $this->Infracciones->obtener_Inspector();
          // $data['tipoinfraccion'] = $this->Infracciones->obtener_Tipo_Infraccion();
          // $data['destino'] = $this->Infracciones->obtener_Destino_Acta();
          $this->load->view('layout/Infracciones/Registrar_Infraccion',$data);
          
          
      }
   
       // ---------------- Funcion Registrar Infraccion
   
       function Guardar_infraccion()
       
       {

        $datos =  $this->input->post();
        $resp = $this->Infracciones->Guardar_Infraccion($datos);
        if($resp){
          echo "ok";
        }else{
          echo "error";
        }
           
       }
   
    

      // ---------------- Funcion Listar Contenedor
   
      function Listar_infraccion()
      {
        $data["infracciones"] = $this->Infracciones->Lista_infracciones();         
        $this->load->view('layout/Infracciones/Lista_infracciones',$data);  
          
      }

   
      // ---------------- Funcion Modificar Generador
   
      function Modificar_Infraccion()
      {
          
          
      }
   
       // ---------------- Funcion Borrar Contenedor
   
       function Borrar_Contenedor()
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