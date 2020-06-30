<?php defined('BASEPATH') OR exit('No direct script access allowed');
   /**
    * Representa a la Entidad Orden
    *
    * @autor Ledesma Sergio
    */
class Orden extends CI_Controller {
  /**
      * Constructor de clase
      * @param 
      * @return 
   */
    function __construct(){

      parent::__construct();
      $this->load->model('general/Estructura/TemplateOrdenTP');
   }


   function ordenT()
   {
       $data['empresa'] = $this->Empresas->obtener();
       $data['disposicionFinal'] = $this->DisposisionesFinales->obtener();
       $data['tipoResiduo'] = $this->TipoResiduos->obtener();
       $data['fecha'] = date('Y-m-d');
       $this->load->view('layout/orden_transporte', $data);
   }

      /**
      * Carga pantalla ABM template OT y carga carga los datos para los select
      * @param 
      * @return view template_ot
    */
   function templateOt()
   {
       $data['empresa'] = $this->TemplateOrdenTP->obtenerEmpresa();
       $data['circuito'] = $this->TemplateOrdenTP->obtenerCircuito();
       $data['disposicionFinal'] = $this->TemplateOrdenTP->obtenerDispFinal();
       $data['tipoResiduo'] = $this->TemplateOrdenTP->obtenerTipoRes();
       $data['zona'] = $this->TemplateOrdenTP->obtenerZona();
       $data['chofer'] = $this->TemplateOrdenTP->obtenerChofer();
       $data['fecha'] = date('Y-m-d');
       $this->load->view('layout/template_ot',$data);
   }

   
   function solicitudRetiro()
   {
       $data['empresa'] = $this->Empresas->obtener();
       $data['disposicionFinal'] = $this->DisposisionesFinales->obtener();
       $data['tipoResiduo'] = $this->TipoResiduos->obtener();
       $data['fecha'] = date('Y-m-d');
       $this->load->view('layout/solicitud_retiro',$data);
   }

   function registrarRecepcionDeOrden()
   {
       $data['zonaDescarga'] = $this->Sectoresdescarga->obtener();
       $this->load->view('layout/registrar_recepcion_de_orden', $data);
   }
   function Controldedescarga()
   {
    
    $this->load->view('layout/control_descarga', $data);
   }

   function nueva()
   {
    
    $this->load->view('layout/nueva_vista', $data);
   }

   //COMIENZO FUNCIONES  TEMPLATE OT

    /**
      * Obtiene Vehiculos dado un id de transportista
      * @param 
      * @return json vehiculos
    */
   function obtenerVehixTran_id()
   {
    log_message('INFO','#TRAZA|Orden|obtenerVehixTran_id() >>');
    $resp = $this->TemplateOrdenTP->ObtenerVehixtran_id($this->input->post('id_empresa'));
    if($resp){
        echo json_encode($resp);
    }
   }

   
    /**
      * Registra Nueva Template OT 
      * @param array datos
      * @return string "Ok", "error"
    */
   function RegistrarTemplateOt()
   {
       log_message('INFO','#TRAZA|Orden|RegistrarTemplateOt() >>');
       $resp = $this->TemplateOrdenTP->RegistrarTemplateOT($this->input->post('datos'));
       if($resp == 1)
       {echo "Ok";}
       else
       {   
           log_message('ERROR','#TRAZA|Orden|RegistrarTemplateOt() >> $resp: '.$resp);
           echo "error";
       }
   }

     /**
      * Carga vista que lista las templates OT cargadas 
      * @param 
      * @return view Listar_templateOT
    */
  function Listar_templateOt()
  {
    log_message('INFO','#TRAZA|Orden|Listar_Vehiculo() >>');
    $data["templateot"] = $this->TemplateOrdenTP->Listar_templateOT();
    $this->load->view('layout/Listar_templateOT',$data);
  }

    /**
      * Actualiza un TemplateOT 
      * @param array datos
      * @return string "ok", "error"
    */
  function ActualizarTemplateOt()
  {
    log_message('INFO','#TRAZA|Orden|ActualizarTemplateOt() >>'); 
    $datos =  $this->input->post('datosEdit');
    $resp = $this->TemplateOrdenTP->actualizar_templateOT($datos);
    if($resp == 1 ){
        echo "ok";
    }else{
    log_message('ERROR','#TRAZA|Orden|ActualizarTemplateOt() >> $resp: '.$resp);
    echo "error";
    }
  }

    /**
      * Eliminar una  Template OT 
      * @param array datosDelete
      * @return string "Ok", "error"
    */
  function EliminarTemplateOt()
  {
    log_message('INFO','#TRAZA|Orden|EliminarTemplateOt() >>');
    $resp = $this->TemplateOrdenTP->Eliminar_templateOT($this->input->post('datosDelete'));
    if($resp == 1 ){
        echo "ok";
    }else{
    log_message('ERROR','#TRAZA|Orden|EliminarTemplateOt() >> $resp: '.$resp);
    echo "error";
    }
  }
   
}
?>