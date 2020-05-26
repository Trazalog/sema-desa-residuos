<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Representa a la Entidad Chofer
*
* @autor Ze Roberto Basañes
*/
class Chofer extends CI_Controller 
{

    /**
    * Constructor de clase
    * @param 
    * @return 
    */
    function __construct()
    {
        parent::__construct();
        $this->load->model('general/Estructura/Choferes');
    }

    /**
    * Carga pantalla ABM choferes y listado
    * @param 
    * @return view choferes
    */
    function templateChoferes()
    {
        log_message('INFO','#TRAZA|CHOFER|templateChoferes() >>');
        $data['carnet'] = $this->Choferes->obtener_Carnet();
        $data['categoria'] = $this->Choferes->obtener_Categoria();
        $data['empresa'] = $this->Choferes->obtener_Empresa();
        $this->load->view('layout/Choferes/registrar_chofer',$data);
    }

    /**
    * Guarda chofer nuevo
    * @param array datos chofer
    * @return string "ok, error"
    */
    function Guardar_Chofer()
    {
        log_message('INFO','#TRAZA|CHOFER|Guardar_Chofer() >>');
        $datos =  $this->input->post('datos');
        $datos['usuario_app'] = userNick();
        $resp = $this->Choferes->Guardar_Chofer($datos);
        if($resp){
        echo "ok";
        }else{
        log_message('ERROR','#TRAZA|Camion|Guardar_Chofer() >> $resp: '.$resp);
        echo "error";
        }
    }

    /**
    * Tabla con listado de todos los Choferes
    * @param 
    * @return view Lista_choferes
    */
    function Listar_Chofer()
    {
        log_message('INFO','#TRAZA|CHOFER|Listar_Chofer() >>');
        $data["choferes"] = $this->Choferes->Listar_Chofer();        
        $this->load->view('layout/Choferes/Lista_choferes',$data);
    }
    // _________________________________________________________

    /**
    * Actualiza datos choferes
    * @param array datos choferes
    * @return string "error, ok"
    */
    function Modificar_Chofer()
    {
        log_message('INFO','#TRAZA|CHOFER|Modificar_Chofer() >> ');
        $chofer = $this->input->post('chofer');
        $chofer['usuario_app'] = userNick();                 
        
        // actualiza datos chofer
        $response = $this->Choferes->Modificar_Chofer($chofer); 
        
        if(!$response){
          log_message('ERROR','#TRAZA|CHOFER|Modificar_Chofer() >> $response: '.$response);
          echo "error";
          return;
        }

        echo "ok";
    }

    /**
    * Borrado de Choferes
    * @param string id de chofer
    * @return json status servicio
    */
    function Borrar_Chofer()
    {
        log_message('INFO','#TRAZA|Chofer|Borrar_Chofer() >>');
       
        $resp = $this->Choferes->Borrar_Chofer($this->input->post('chof_id'));
        $chof_id = $this->input->post('chof_id');
        var_dump();
        if($resp){
          echo "ok";
        }else{
          log_message('ERROR','#TRAZA|Chofer|Borrar_Chofer() >> $resp: '.$resp);
          echo "error";
        }
    }

    // ___________________________FUNCIONES OBTENER______________________________
    /**
    * Obtiene imagen por chof_id
    * @param int chof_id
    * @return bynary imagen
    */    
    function obtener_Imagen(){
      log_message('INFO','#TRAZA|CIRCUITO|obtener_Imagen() >> ');
      $resp = $this->Choferes->obtener_Imagen($this->input->post('chof_id'));
      echo json_encode($resp);
    }

}
?>