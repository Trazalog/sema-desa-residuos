<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Transportista extends CI_Controller 
{
    function __construct(){
      parent::__construct();
      $this->load->model('general/Estructura/Transportistas');
    }  

    // Funcion Cargar vista Transportistas y Datos
    function templateTransportistas()
    {
        $data['Rsu'] = $this->Transportistas->obtener_RSU();    
        $this->load->view('layout/Transportistas/registrar_transportista',$data);        
    }
  
    // Funcion Registrar Transportista
    function Guardar_Transportista()
    {
        $datos =  $this->input->post('datos');
        $tiposcarga = $this->input->post('tipocarga');        
        $tran_id = $this->Transportistas->Guardar_Transportista($datos);
        // agregar el id de transportista para asociar a tipo carga
        if($tran_id){
            foreach ($tiposcarga as $i=>$tipo_carga) {              
              $data[$i]['tran_id'] = $tran_id;
              $data[$i]['tica_id'] = $tipo_carga;              
            }
        }else{
          echo "error";
          return;
        }       
        // asocio tipo de carga a transportista nuevo
        $resp = $this->Transportistas->asociarTipoCarga($data);

        if($resp){
        echo "ok";
        }else{
        echo "error";
        }
    }    

    // Funcion Listar Transportista  
    function Listar_Transportista()
    {
      $data["transportistas"] = $this->Transportistas->Listar_Transportistas(); 
      $this->load->view('layout/Transportistas/Lista_transportista',$data);
    }
  
    // Funcion Modifica datos Transportista  
    function Modificar_Transportista()
    {        
        $transportista = $this->input->post('transportista');
        $tipo_carga = $this->input->post('tipo_carga');
        $tran_id = $transportista['tran_id']; 
        // actualiza datos trnasportista
        $response = $this->Transportistas->Modificar_Transportista($transportista, $tran_id); 
         
        if(!$response){
          echo "error_transportista";
          return;
        }else{          
          $response = $this->Transportistas->Borrar_TiposCarga($tran_id);
          foreach ($tipo_carga as $i=>$tipo_carga) {              
            $data[$i]['tran_id'] = $tran_id;
            $data[$i]['tica_id'] = $tipo_carga;              
          }
          $resp = $this->Transportistas->asociarTipoCarga($data);   
          if($resp){
            echo "ok";
          }else{
            echo "error";
          }
          
        }
       
    }
  
    // Funcion Borrar Transportista
    function Borrar_Transportista()
    {
        $tran_id = $this->input->post('tran_id');       
        $response = $this->Transportistas->Borrar_Transportista($tran_id);
        echo json_encode($response);
    }

  // ---------------- Funciones Obtener --------------------------------//

    // Funcion Obtener rsu
    function obtener_RSU()
    {
      $rsu = $this->Transportistas->obtener_RSU();      
      echo json_encode($rsu);   
    }         

}
?>