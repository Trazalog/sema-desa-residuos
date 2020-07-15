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
										"titulo": "Reportes",
										"icono": "fa fa-circle",
										"link": "general/Componente",
										"nivel": 2,
										"submenu": [
											{
												"titulo": "Pesajes de Báscula",
												"icono": "fa fa-genderless",
												"link": "Reportes/pesoDeBascula"
											},
											{
												"titulo": "Incidencias",
												"icono": "fa fa-genderless",
												"link": "Reportes/incidencia"
											},
											{
												"titulo": "Incidencias por transportista",
												"icono": "fa fa-genderless",
												"link": "Reportes/incidenciaPorTransportista"
											},
											{
												"titulo": "Incidencias por municipio",
												"icono": "fa fa-genderless",
												"link": "Reportes/incidenciaPorMunicipio"
											},
											{
												"titulo": "Incidencias por zona",
												"icono": "fa fa-genderless",
												"link": "Reportes/incidenciaPorZona"
											},
											{
												"titulo": "Tn. por transportista",
												"icono": "fa fa-genderless",
												"link": "Reportes/toneladasPorTransportista"
											},
											{
												"titulo": "Tn. por generador",
												"icono": "fa fa-genderless",
												"link": "Reportes/toneladasPorGenerador"
											},
											{
												"titulo": "Tn. por residuo",
												"icono": "fa fa-genderless",
												"link": "Reportes/toneladasPorResiduos"
											}
										]
									}
								]
							}
				}';

		$aux2  = $this->load->view('layout/menu/mis_tareas', null, true).$this->load->view('layout/menu/aux_menu_alm', null, true);

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