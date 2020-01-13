<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Hecha por Fer Guardia el mascapito */
class Orden extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('empresas_helper');
      $this->load->helper('zonas_helper');
      $this->load->helper('tipo_residuos_helper');
      $this->load->helper('circuitos_helper');
      $this->load->helper('disposiciones_finales_helper');
      $this->load->model('general/Zonas');
      $this->load->model('general/Circuitos');
      $this->load->model('general/DisposisionesFinales');
      $this->load->model('general/TipoResiduos');
      $this->load->model('general/Empresas');
      $this->load->model('general/Sectoresdescarga');
   }

   function ordenT()
   {
       $data['empresa'] = $this->Empresas->obtener();
       $data['disposicionFinal'] = $this->DisposisionesFinales->obtener();
       $data['tipoResiduo'] = $this->TipoResiduos->obtener();
       $data['fecha'] = date('Y-m-d');
       $this->load->view('layout/orden_transporte', $data);
   }

   function templateOt()
   {
       $data['empresa'] = $this->Empresas->obtener();
       $data['circuito'] = $this->Circuitos->obtener();
       $data['disposicionFinal'] = $this->DisposisionesFinales->obtener();
       $data['tipoResiduo'] = $this->TipoResiduos->obtener();
       $data['zona'] = $this->Zonas->obtener();
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

   function controlDeDescarga(){
        $this->load->view('layout/control_descarga');
   }

   function nueva(){
       $this->load->view('layout/nueva_vista');
   }
}
?>