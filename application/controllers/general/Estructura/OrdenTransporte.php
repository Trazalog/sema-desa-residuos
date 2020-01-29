<?php defined('BASEPATH') OR exit('No direct script access allowed');


class OrdenTransporte extends CI_Controller {


    function __construct(){

      parent::__construct();

      $this->load->model('general/Estructura/OrdenTransportes');
      
   }

  


  // ---------------- Funcion Cargar vista Orden de transporte MUNICIPIOS y Datos

      // ---------------- Funcion Cargar vista Orden de transporte y Datos

      function templateOrdentransporte()
      {
          
        $data['empresa'] = $this->Empresas->obtener();
        $data['d'] = $this->DisposisionesFinales->obtener();
        $data['tipoResiduo'] = $this->TipoResiduos->obtener();
        $data['fecha'] = date('Y-m-d');

        // $data[''] = $this->OrdenTransportes->obtener_();
        // $data[''] = $this->OrdenTransportes->obtener_();
        // $data[''] = $this->OrdenTransportes->obtener_();
        // $data[''] = $this->OrdenTransportes->obtener_();
        

        $this->load->view('layout/orden_transporte', $data);
          
      }
   
       // ---------------- Funcion Registrar Orden Transporte
   
       function Guardar_OrdenTransporte()
       {

        $datos =  $this->input->post('datos');
        $resp = $this->OrdenTransportes->Guardar_OrdenT($datos);
        if($resp){
        echo "ok";
        }else{
        echo "error";
        }
           
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

       
    
       

       
   

}
?>