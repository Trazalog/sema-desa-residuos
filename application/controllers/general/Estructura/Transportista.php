<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Representa a la Entidad Transportistas
*
* @autor Hugo Gallardo
*/
class Transportista extends CI_Controller 
{   
    /**
    * Constructor de Clase
    * @param 
    * @return
    */
    function __construct(){
      parent::__construct();
      $this->load->model('general/Estructura/Transportistas');
    }  
   
    /**
    * Carga pantalla ABM transportistas y listado   
    * @param 
    * @return view transportistas
    */
    function templateTransportistas()
    {
        log_message('INFO','#TRAZA|TRANSPORTISTA|templateTransportistas() >>');
        $data['Rsu'] = $this->Transportistas->obtener_RSU();    
        $this->load->view('layout/Transportistas/registrar_transportista',$data);        
    }
   
    /**
    * Guarda transportista nuevo
    * @param array datos transportista y tipo carga asociada
    * @return string "ok, error"
    */
    function Guardar_Transportista()
    {   
        log_message('INFO','#TRAZA|TRANSPORTISTA|Guardar_Transportista() >>');
        $datos =  $this->input->post('datos');
        $usr = userNick();
        $datos['usuario_app'] = $usr;
        unset($datos['tica_edit']);
        $tiposcarga = $this->input->post('tipocarga');        
        $tran_id = $this->Transportistas->Guardar_Transportista($datos);
        // agregar el id de transportista para asociar a tipo carga
        if($tran_id){
            foreach ($tiposcarga as $i=>$tipo_carga) {              
              $data[$i]['tran_id'] = $tran_id;
              $data[$i]['tica_id'] = $tipo_carga;              
            }
        }else{
          log_message('ERROR','#TRAZA|TRANSPORTISTAS|Guardar_Transportista() >> $tran_id: '.$tran_id);
          echo "error";
          return;
        }       
        // asocio tipo de carga a transportista nuevo
        $resp = $this->Transportistas->asociarTipoCarga($data);

        if($resp){
          echo "ok";
        }else{
          log_message('ERROR','#TRAZA|TRANSPORTISTA|Guardar_Transportista() >> $resp: '.$resp);
          echo "error";
        }
    }    

    /**
    * Tabla con listado de todos los Transportistas
    * @param
    * @return view Lista_transportista
    */
    function Listar_Transportista()
    {
      log_message('INFO','#TRAZA|TRANSPORTISTA|Listar_Transportista() >>');
      $data["transportistas"] = $this->Transportistas->Listar_Transportistas(); 
      $this->load->view('layout/Transportistas/Lista_transportista',$data);
    }

    /**
    * Actualiza datos transportistas
    * @param array datos transportistas y tipos de carga
    * @return string "error, ok"
    */
    function Modificar_Transportista()
    {   
        log_message('INFO','#TRAZA|TRANSPORTISTA|Modificar_Transportista() >> ');     
        $transportista = $this->input->post('transportista');
        unset($transportista['ticaedit']);
        $tipo_carga = $this->input->post('tipo_carga');
        $tran_id = $transportista['tran_id']; 
        // actualiza datos trnasportista
        $response = $this->Transportistas->Modificar_Transportista($transportista); 
         
        if(!$response){
          log_message('ERROR','#TRAZA|TRANSPORTISTA|Modificar_Transportista() >> $response: '.$response);
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
            log_message('ERROR','#TRAZA|TRANSPORTISTA|Modificar_Transportista() >> $resp: '.$resp);
            echo "error";
          }          
        }       
    }
  
    /**
    * Borrado de Transportistas
    * @param string id de transportista
    * @return json status servicio 
    */
    function Borrar_Transportista()
    {   
        log_message('INFO','#TRAZA|TRANSPORTISTA|Borrar_Transportista() >>');
        $tran_id = $this->input->post('tran_id');       
        $response = $this->Transportistas->Borrar_Transportista($tran_id);
        echo json_encode($response);
    }

  // ---------------- Funciones Obtener --------------------------------//

    /**
    * Obtiene todos los tipos de carga
    * @param 
    * @return json tipos de carga
    */
    function obtener_RSU()
    { 
      log_message('INFO','#TRAZA|TRANSPORTISTA|obtener_RSU() >>');
      $rsu = $this->Transportistas->obtener_RSU();      
      echo json_encode($rsu);   
    }         

}

?>