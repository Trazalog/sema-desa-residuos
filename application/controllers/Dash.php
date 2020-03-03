<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dash extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('menu_helper');
      $this->load->helper('file');
   }

   function index(){
      
      $aux = '{"menuP" : {
                "menuH": [
                    {
                        "titulo": "Registros",
                        "icono": "fa fa-circle",
                        "link": "general/Componente",
                        "nivel": 2,
                        "submenu":[
                            {
                                "titulo": "Registrar Inspectores",
                                "icono": "fa fa-genderless",
                                "link": "general/RegistrarIn/templateIn"
                            },
                            {
                                "titulo": "Registrar Generadores ",
                                "icono": "fa fa-genderless",
                                "link": "general/Estructura/Generador/templateGeneradores"
                            },
                            {
                                "titulo": "Registrar Transportista",
                                "icono": "fa fa-genderless",
                                "link": "general/Estructura/Transportista/templateTransportistas"
                            },
                            {
                                "titulo": "Registrar Zona",
                                "icono": "fa fa-genderless",
                                "link": "general/Estructura/Zona/templateZonas"
                            },
                            {
                                "titulo": "Registrar Circuito",
                                "icono": "fa fa-genderless",
                                "link": "general/Estructura/Zona/templateCircuitos"
                            },
                            {
                                "titulo": "Registrar Contenedor",
                                "icono": "fa fa-genderless",
                                "link": "general/Estructura/Contenedor/templateContenedores"
                            },
                            {
                                "titulo": "Solicitud de retiro",
                                "icono": "fa fa-genderless",
                                "link": "general/Orden/solicitudRetiro"
                            },
                            {
                                "titulo": "Registrar Proceso Productivo",
                                "icono": "fa fa-genderless",
                                "link": "general/RegistrarPp/templatePp"
                            },
                            {
                                "titulo": "Establecimiento",
                                "icono": "fa fa-genderless",
                                "link": "general/RegistrarE/templateEs"
                            },
                            {
                                "titulo": "Orden de transporte",
                                "icono": "fa fa-genderless",
                                "link": "general/Estructura/OrdenTransporte/templateOrdentransporte"
                            },
                            {
                                "titulo": "Template OT",
                                "icono": "fa fa-genderless",
                                "link": "general/Orden/templateOt"
                            },
                            {
                                "titulo": "Control de descarga",
                                "icono": "fa fa-genderless",
                                "link": "general/Orden/controlDeDescarga"
                            },
                            {
                                "titulo": "Recepcion de orden",
                                "icono": "fa fa-genderless",
                                "link": "general/Orden/registrarRecepcionDeOrden"
                            },
                            {
                                "titulo": "ABM establecimiento",
                                "icono": "fa fa-genderless",
                                "link": "general/Orden/nueva"
                            },
                            {
                                "titulo": "ABM Incidencias ",
                                "icono": "fa fa-genderless",
                                "link": "general/Orden/nueva2"
                            },
                            {
                                "titulo": "ABM Infracciones ",
                                "icono": "fa fa-genderless",
                                "link": "general/Estructura/Infraccion/templateInfracciones"
                            },
                            {
                                "titulo": "Solicitud de Contenedores ",
                                "icono": "fa fa-genderless",
                                "link": "general/Solicitud_Pedido/templateSolicitudPedidos"
                            },
                            {
                                "titulo": "Etapa",
                                "icono": "fa fa-genderless",
                                "link": "general/RegistrarEt/templateEt"
                            },
                            {
                                "titulo": "Chofer",
                                "icono": "fa fa-genderless",
                                "link": "general/RegistrarCh/templateCh"
                            },
                            {
                                "titulo": "Vehiculo",
                                "icono": "fa fa-genderless",
                                "link": "general/RegistrarVehi/templateVehi"
                            },
                            {
                                "titulo": "Gestion de seguimiento",
                                "icono": "fa fa-genderless",
                                "link": "general/Estructura/GestionDeSeguimiento/templateGestion"
                            },
                            {
                                "titulo": "Control de Trayecto",
                                "icono": "fa fa-genderless",
                                "link": "general/RegistrarVehi/templateVehi"
                            },
                            {
                                "titulo": "Registrar acta de infraccion",
                                "icono": "fa fa-genderless",
                                "link": "general/RegistrarVehi/templateVehi"
                            }
                        ]
                    }
                ]
    }
}';

      $aux2  = $this->load->view('layout/menu/mis_tareas', null, true).$this->load->view('layout/menu/aux_menu_alm', null, true);

      $data['menu'] = menu(json_decode($aux), $aux2);
    
      $this->load->view('layout/Admin',$data);
   }
}
?>