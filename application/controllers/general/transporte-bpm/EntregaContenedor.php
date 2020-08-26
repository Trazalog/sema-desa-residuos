<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Representa la entidad Ingreso de contenedores
*
* @autor
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
    $usuario_app = userNick(); //para q en la iteracion sea mas optima
    foreach ($datos_contenedores as $key => $value) {
      $datos_contenedores[$key]['usuario_app'] = $usuario_app;
    }
    $resp = $this->PedidoContenedores->GuardarContEntregados($datos_contenedores);
    if($resp == 1){
     echo 1;
    }else{
     echo 0;
    }

}
}