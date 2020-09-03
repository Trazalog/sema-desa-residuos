<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dash extends CI_Controller {
	function __construct(){

		parent::__construct();
		$this->load->helper('menu_helper');
		$this->load->helper('file');
		//TODO: PREGUNTAR SI ESTA VENCIDA LA SESION Y REDIRECCIONAR AL LOGIN SI ES NECESARIO
		$data = $this->session->userdata();
		log_message('DEBUG','#Main/login | '.json_encode($data));
		if(!$data['email']){
			log_message('DEBUG','#TRAZA|DASH|CONSTRUCT|ERROR  >> Sesion Expirada!!!');
			redirect(DNATO.'main/login');
		}
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
																	"titulo": "Chofer",
																	"icono": "fa fa-genderless",
																	"link": "general/Estructura/Chofer/templateChoferes"
															},
															{
																	"titulo": "Vehiculo",
																	"icono": "fa fa-genderless",
																	"link": "general/Estructura/Vehiculo/templateVehiculos"
															},
															{
																"titulo": "Registrar Transportista",
																"icono": "fa fa-genderless",
																"link": "general/Estructura/Transportista/templateTransportistas"
															},
															{
																	"titulo": "Registrar Generadores ",
																	"icono": "fa fa-genderless",
																	"link": "general/Estructura/Generador/templateGeneradores"
															},													
															{
																	"titulo": "Registrar Zona",
																	"icono": "fa fa-genderless",
																	"link": "general/Estructura/Zona/templateZonas"
															},
															{
																	"titulo": "Registrar Circuito",
																	"icono": "fa fa-genderless",
																	"link": "general/Estructura/Circuito/templateCircuitos"
															},
															{
																	"titulo": "Registrar Contenedor",
																	"icono": "fa fa-genderless",
																	"link": "general/Estructura/Contenedor/templateContenedores"
															},
															{
																	"titulo": "Liquidacion de O.T.",
																	"icono": "fa fa-genderless",
																	"link": "general/Estructura/LiquidacionOT/templateLiquidacion"
															},
															{
																"titulo": "Solicitud de Contenedores ",
																"icono": "fa fa-genderless",
																"link": "general/transporte-bpm/Solicitud_Pedido/templateSolicitudPedidos"
															},										
															{
																	"titulo": "Entrega contenedor",
																	"icono": "fa fa-genderless",
																	"link": "general/RegistrarVehi/templateVehi"
															},	
															{
																	"titulo": "Solicitud de retiro",
																	"icono": "fa fa-genderless",
																	"link": "general/transporte-bpm/SolicitudRetiro/templateSolicitudRetiro"
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
																"titulo": "Recepcion de orden",
																"icono": "fa fa-genderless",
																"link": "general/Orden/registrarRecepcionDeOrden"
															},
															{
																	"titulo": "Control de descarga",
																	"icono": "fa fa-genderless",
																	"link": "general/Orden/controlDeDescarga"
															},																									
															{
																	"titulo": "ABM Incidencias ",
																	"icono": "fa fa-genderless",
																	"link": "general/Estructura/Etapa/templateEtapas"
															},										
															{
																	"titulo": "Plantilla",
																	"icono": "fa fa-genderless",
																	"link": "Test/index"
															}
													]
											}
									]
								}
						}';

		$aux2  =$this->load->view('layout/menu/mis_tareas', null, true).$this->load->view('layout/menu/aux_menu_alm', null, true);

		$data['menu'] = menu(json_decode($aux), $aux2);
	
		$this->load->view('layout/Admin',$data);
	}
}

// {
// 	"titulo": "Registrar Inspectores",
// 	"icono": "fa fa-genderless",
// 	"link": "general/RegistrarIn/templateIn"
// 	},
// 	{
// 	"titulo": "Registrar Proceso Productivo",
// 	"icono": "fa fa-genderless",
// 	"link": "general/RegistrarPp/templatePp"
// 	},
// 	{
// 	"titulo": "Establecimiento",
// 	"icono": "fa fa-genderless",
// 	"link": "general/RegistrarE/templateEs"
// 	},
// 	{
// 	"titulo": "ABM establecimiento",
// 	"icono": "fa fa-genderless",
// 	"link": "general/Orden/nueva"
// 	},
// 	{
// 	"titulo": "ABM Infracciones ",
// 	"icono": "fa fa-genderless",
// 	"link": "general/Estructura/Infraccion/templateInfracciones"
// 	},
// 	{
// 	"titulo": "Etapa",
// 	"icono": "fa fa-genderless",
// 	"link": "general/RegistrarEt/templateEt"
// 	},
// 	{
// 	"titulo": "Gestion de seguimiento",
// 	"icono": "fa fa-genderless",
// 	"link": "general/Estructura/GestionDeSeguimiento/templateGestion"
// 	},
// 	{
// 	"titulo": "Registrar acta de infraccion",
// 	"icono": "fa fa-genderless",
// 	"link": "general/RegistrarVehi/templateVehi"
// 	},

?>