<?php defined('BASEPATH') OR exit('No direct script access allowed');


class OrdenTransporte extends CI_Controller {


    function __construct(){

      parent::__construct();

      $this->load->model('general/Estructura/OrdenTransportes');
      
   }

  


  // ---------------- Funcion Cargar vista Orden de transporte  y Datos

      // ---------------- Funcion Cargar vista Orden de transporte y Datos

      function templateOrdentransporte()
      {     
       

        $data['Tiporesiduo'] = $this->OrdenTransportes->obtener_Tipo_residuo();
       
        $data['numero'] = $this->OrdenTransportes->obtener_numero_orden();
          // $data['chofer'] = $this->OrdenTransportes->obtener_chofer();
           // $data['chofer'] = $this->OrdenTransportes->obtener_chofer();
       

        $this->load->view('layout/Ordenes/orden_transporte',$data);
        
        
          
      }
   
       

      // ---------------- Funcion Listar OrdenTransporte
   
      function Listar_OrdenTransporte()
      {
        $data['ordenes'] = $this->OrdenTransportes->Listar_ordenes_transporte();
        $this->load->view('layout/Ordenes/lista_orden_transporte',$data); 
          
      }

 

    

       

  // ---------------- Funcion Cargar vista Recepcion de Orden y Datos

      // ---------------- Funcion Cargar vista Recepcion de orden

      function templateRecepcionOrden()
      
      {          
       

        // $data[''] = $this->OrdenTransportes->obtener_();
        // $data[''] = $this->OrdenTransportes->obtener_();
        // $data[''] = $this->OrdenTransportes->obtener_();
        // $data[''] = $this->OrdenTransportes->obtener_();
        

        $this->load->view('layout/Ordenes/recepcion_de_orden', $data);
          
      }
   
       // ---------------- Funcion Registrar Orden Transporte
   
       function Guardar_RecepcionOrden()
       {

        
           
       }
   
       
      // ---------------- Funcion Listar Recepcion Orden
   
      function Listar_RecepcionOrden()
      {
          
          
      }       

       
   

}
?>