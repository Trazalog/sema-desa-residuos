<?php defined('BASEPATH') OR exit('No direct script access allowed');


class OrdenTransporte extends CI_Controller {


    function __construct(){

      parent::__construct();
   }

  


  

      // ---------------- Funcion Cargar vista Orden de transporte y Datos

      function templateOrdentransporte()
      {
          
        $data['empresa'] = $this->Empresas->obtener();
        $data['disposicionFinal'] = $this->DisposisionesFinales->obtener();
        $data['tipoResiduo'] = $this->TipoResiduos->obtener();
        $data['fecha'] = date('Y-m-d');
        $this->load->view('layout/orden_transporte', $data);
          
      }
   
       // ---------------- Funcion Registrar Orden Transporte
   
       function Guardar_OrdenTransporte()
       {
           // $this->load->view('layout/registrar_infraccion');
       }
   
       // ---------------- Funcion Crear Orden de transporte
   
      function Crear_OrdenTransporte()
      {
          
          
      }

      // ---------------- Funcion Listar OrdenTransporte
   
      function Listar_OrdenTransporte()
      {
          
          
      }

   
      // ---------------- Funcion Modificar OrdenTransporte
   
      function Modificar_OrdenTransporte()
      {
          
          
      }
   
       // ---------------- Funcion Borrar OrdenTransporte
   
       function Borrar_OrdenTransporte()
       {
           
           
       }

       
      // ---------------- Funciones Solicitudes --------------------------------//



      
   
       
   

      // ---------------- Funciones Obtener --------------------------------//
      

       // ---------------- Funcion Obtener Estado
   
       function Obtener_Estado()
       {
           
           
       }

        // ---------------- Funcion Agregar Incidencia
   
        function Agregar_Incidencia()
        {
             
             
        }

        // ---------------- Funcion Agregar Rectificada
   
       function Agregar_Rectificada()
       {
           
           
       }

       
   

}
?>