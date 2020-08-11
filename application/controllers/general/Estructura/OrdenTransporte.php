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
        $data['chofer'] = $this->OrdenTransportes->obtenerChofer();
        $data['dispfinal'] = $this->OrdenTransportes->obtenerdispfinal();
        $data['equipo'] = $this->OrdenTransportes->obtenerEquipo();
        $data['contenedores'] = $this->OrdenTransportes->obtenerContenedores();
        $data['sotrid'] = $this->OrdenTransportes->obtenerSotrid();
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
   
       
   
       function Guardar_ordentransporte()
       {

        $resp = $this->OrdenTransportes->Guardar_ordenTransportes($this->input->post('datos'));
        if(!$resp){
          echo "ok";
       }
       else{
          log_message('ERROR','#TRAZA|ORDENTRANSPORTE|Guardar_ordentransporte() >> $resp: '.$resp);
          echo 'error';
       }
           
       }
   
       function ObtenerinfoOt()
       {
         $resp = $this->OrdenTransportes->ObtenerOTpordominio($this->input->post('dom_id'));
         echo json_encode($resp);
       }
        
       function GetChoferyTransportista()
       {
        $resp['chofer'] = $this->OrdenTransportes->Obtenerchofertran_id($this->input->post('tran_id'));
        $resp['transp'] = $this->OrdenTransportes->Obtenertranspo_id($this->input->post('tran_id'));
        echo json_encode($resp);
       }

       function Obtenerteot()
       {
        $resp = $this->OrdenTransportes->ObtenerTeot($this->input->post('sotr_id'));
        echo json_encode($resp);
       }
   

}
?>