<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dash extends CI_Controller {
	function __construct(){

		parent::__construct();
		$this->load->helper('menu_helper');
		$this->load->helper('file');
		//TODO: PREGUNTAR SI ESTA VENCIDA LA SESION Y REDIRECCIONAR AL LOGIN SI ES NECESARIO
		// $data = $this->session->userdata();
		// log_message('DEBUG','#Main/login | '.json_encode($data));
		// if(!$data['email']){
		// 	log_message('DEBUG','#TRAZA|DASH|CONSTRUCT|ERROR  >> Sesion Expirada!!!');
		// 	redirect(DNATO.'main/login');
		// }	
	}

	function index(){
		
	// $aux =	'{"menu_items": {"menu_item": [
	// 															{
	// 																			"texto": "Producción",
	// 																			"camino": "1.PRD.produccion",
	// 																			"opcion": "produccion",
	// 																			"url_icono": "/img/icono.gif",
	// 																			"habilitado": "false",
	// 																			"opcion_padre": null,
	// 																			"modulo": "PRD",
	// 																			"nivel": "1",
	// 																			"url": "",
	// 																			"javascript": null,
	// 																			"texto_onmouseover": "Módulo de Producción"
	// 															},
	// 															{
	// 																			"texto": "Planificar Etapas",
	// 																			"camino": "1.PRD.produccion>10.PRD.etapas",
	// 																			"opcion": "etapas",
	// 																			"url_icono": "/img/icono.gif",
	// 																			"habilitado": "false",
	// 																			"opcion_padre": "produccion",
	// 																			"modulo": "PRD",
	// 																			"nivel": "2",
	// 																			"url": "/traz-prod-trazasoft/dash",
	// 																			"javascript": null,
	// 																			"texto_onmouseover": "Planificación de etapas"
	// 															},
	// 															{
	// 																			"texto": "Pantalla Operario",
	// 																			"camino": "1.PRD.produccion>20.PRD.aminowana",
	// 																			"opcion": "aminowana",
	// 																			"url_icono": "/img/icono.gif",
	// 																			"habilitado": "false",
	// 																			"opcion_padre": "produccion",
	// 																			"modulo": "PRD",
	// 																			"nivel": "2",
	// 																			"url": "/traz-prod-trazasoft/amino",
	// 																			"javascript": null,
	// 																			"texto_onmouseover": "Etapas operario"
	// 															},
	// 															{
	// 																			"texto": "Mantenimiento",
	// 																			"camino": "2.MAN.mantenimiento",
	// 																			"opcion": "mantenimiento",
	// 																			"url_icono": "/img/asset.gif",
	// 																			"habilitado": "true",
	// 																			"opcion_padre": null,
	// 																			"modulo": "MAN",
	// 																			"nivel": "1",
	// 																			"url": "",
	// 																			"javascript": null,
	// 																			"texto_onmouseover": "Asset loco"
	// 															},
	// 															{
	// 																			"texto": "Crear Orde de Trabajo",
	// 																			"camino": "2.MAN.mantenimiento>100.MAN.ot",
	// 																			"opcion": "ot",
	// 																			"url_icono": "/img/asset.gif",
	// 																			"habilitado": "false",
	// 																			"opcion_padre": "mantenimiento",
	// 																			"modulo": "MAN",
	// 																			"nivel": "2",
	// 																			"url": "/traz-prod-assetplanner/asset",
	// 																			"javascript": null,
	// 																			"texto_onmouseover": "Crear ot"
	// 															},
	// 															{
	// 																			"texto": "Reporte ot",
	// 																			"camino": "2.MAN.mantenimiento>100.MAN.ot>1000.MAN.reporte",
	// 																			"opcion": "reporte",
	// 																			"url_icono": "/img/repo.gif",
	// 																			"habilitado": "false",
	// 																			"opcion_padre": "ot",
	// 																			"modulo": "MAN",
	// 																			"nivel": "3",
	// 																			"url": "/traz-prod_assetplanner/reportes",
	// 																			"javascript": null,
	// 																			"texto_onmouseover": "Sheportes"
	// 															},
	// 															{
	// 																			"texto": "Almacenes",
	// 																			"camino": "4.ALM.almacenes",
	// 																			"opcion": "almacenes",
	// 																			"url_icono": "/img/icono.gif",
	// 																			"habilitado": "true",
	// 																			"opcion_padre": null,
	// 																			"modulo": "ALM",
	// 																			"nivel": "1",
	// 																			"url": "",
	// 																			"javascript": null,
	// 																			"texto_onmouseover": "Almacenes"
	// 															},
	// 															{
	// 																			"texto": "Stock Articulos",
	// 																			"camino": "4.ALM.almacenes>50.ALM.stock",
	// 																			"opcion": "stock",
	// 																			"url_icono": "/img/alm.gif",
	// 																			"habilitado": "false",
	// 																			"opcion_padre": "almacenes",
	// 																			"modulo": "ALM",
	// 																			"nivel": "2",
	// 																			"url": "/traz-prod-trazasoft/stock",
	// 																			"javascript": null,
	// 																			"texto_onmouseover": null
	// 															}
	// 												]}}';
		
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
																	"link": "general/Estructura/Incidencia/templateIncidencia"
															},										
															{
																	"titulo": "Plantilla",
																	"icono": "fa fa-genderless",
																	"link": "Test/index"
															}                            
													]
											},
											{
												"titulo": "Mapas",
												"icono": "fa fa-map",
												"link": "general/",
												"nivel": 2,
												"submenu":[
													{
														"titulo": "Ultimo registro del camion",
														"icono": "fa fa-genderless",
														"link": "general/Estructura/Vehiculo/templateUltimoRegistro"
													},
													{
														"titulo": "Recorrido del camion",
														"icono": "fa fa-genderless",
														"link": "general/Estructura/Vehiculo/templateRecorridos"
													},
													{
														"titulo": "Incidencias por camion",
														"icono": "fa fa-genderless",
														"link": "general/Estructura/Vehiculo/templateIncidencias"
													}
												]
											}
											
									]
								}
						}';

		$aux2  =$this->load->view('layout/menu/mis_tareas', null, true).$this->load->view('layout/menu/aux_menu_alm', null, true);

		// $a= json_decode($aux);

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