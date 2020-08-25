<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Representa la entidad Ingreso de contenedores
*
* @autor Hugo Gallardo
*/
class EntregaContenedor extends CI_Controller {
  /**
  * Constructor de Clase
  * @param
  * @return
  */
  function __construct(){
    parent::__construct();  
    $this->load->model('general/transporte-bpm/PedidoContenedores'); 
  }
    
  public function GuardaContEntregado(){
    log_message('INFO','#TRAZA|Tarea|GuardaContEntregados() >> ');
    $datos_contenedores =  $this->input->post('cont_entregados_listo'); 
    $resp = $this->PedidoContenedores->GuardarContEntregados($datos_contenedores);
    if($resp == 1){
     echo 1;
    }else{
     echo 0;   
    }

}
}