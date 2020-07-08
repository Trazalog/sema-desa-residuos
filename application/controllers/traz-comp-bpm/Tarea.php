<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tarea extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

        $this->load->model(BPM.'Tareas');  
        // SUPERVISOR1 => 102 => Aprueba pedido de Recursos Materiales
				// $data = ['userId' => 102, 'userName' => 'Fernando', 'userLastName' => 'Leiva', 'device' => '', 'permission' => 'Add-View-Del-Edit','id_empresa'=>1];

				$data = ['userId' => 402, 'userName' => 'Transportista', 'userLastName' => '1', 'device' => '', 'permission' => 'Add-View-Del-Edit','id_empresa'=>1];
				
        $this->session->set_userdata('user_data', $data);
    }

    public function index()
    {

        $data['device'] = "";
        $data['list'] = $this->Tareas->listar();
        $this->load->view(BPM.'bandeja_entrada', $data);

    }

    public function detalleTarea($taskId)
    {

        //PERMISOS PANTALLA
        $data['permission'] = $this->session->userdata('user_data')['permission'];

        //TIPO DISPOSITIVO
        $data['device'] = "";

        //INFORMACION DE TAREA
        $tarea = $this->Tareas->obtener($taskId); 

        //INFORMACION DE TAREA
        $data['tarea'] = $tarea;
        $data['info'] = $this->load->view(BPM.'componentes/informacion',null,true);

        //LINEA DE TIEMPO
        $aux = $this->bpm->ObtenerLineaTiempo($tarea->processId, $tarea->caseId);
        $aux = json_decode(json_encode($aux));
        $data['timeline'] = $this->load->view(BPM . 'componentes/timeline', $aux, true);

        //COMENTARIOS
        $aux = ['case_id' => $tarea->caseId, 'comentarios' => $this->bpm->ObtenerComentarios($tarea->caseId)['data']];
        $data['comentarios'] = $this->load->view(BPM .'componentes/comentarios', $aux, true);

        //DESPLEGAR VISTA
        $data['view'] = $this->deplegarVista($tarea);
        $this->load->view(BPM.'notificacion_estandar', $data);
				
			}

    public function tomarTarea()
    {
        $id = $this->input->post('id');
        echo json_encode($this->bpm->setUsuario($id, $this->session->userdata('user_data')['userId']));
    }

    public function soltarTarea()
    {
        $id = $this->input->post('id');
        echo json_encode($this->bpm->setUsuario($id, ""));

    }

    public function cerrarTarea($taskId)
    {

				//Obtener Infomracion de Tarea
				$tarea = $this->bpm->getTarea($taskId)['data'];

        //Formulario desde la Vista
        $form = $this->input->post();

				//Mapeo de la tarea y Contrato	
				$tar_mapeada = $this->Tareas->mapeoTarea($tarea);			
        $contrato = $this->getContrato($tar_mapeada, $form);
			
        //Cerrar Tarea
				$rsp = $this->bpm->cerrarTarea($taskId, $contrato);
				
				//echo json_encode($rsp);
    }

    public function getContrato($tarea, $form)
    {			
        switch ($tarea['nombreTarea']) {
            case 'Aprueba pedido de Recursos Materiales':

                $this->Notapedidos->setMotivoRechazo($form['pema_id'], $form['motivo_rechazo']);

                $contrato['apruebaPedido'] = $form['result'];

                return $contrato;

                break;

            case 'Entrega pedido pendiente':

                $contrato['entregaCompleta'] = $form['completa'];

                return $contrato;

                break;

            // ?PEDIDO MATERIALES EXTRAORDINARIOS

            case 'Aprueba pedido de Recursos Materiales Extraordinarios':

                $this->Pedidoextra->setMotivoRechazo($form['peex_id'], $form['motivo_rechazo']);

                $contrato['apruebaPedido'] = $form['result'];

                return $contrato;

                break;

            case 'Comunica Rechazo':

                $contrato['motivo'] = $form['motivo'];

                return $contrato;

                break;

            case 'Solicita Compra de Recursos Materiales Extraordiinarios':

                $this->Pedidoextra->setMotivoRechazo($form['peex_id'], $form['motivo_rechazo']);

                $contrato['apruebaCompras'] = $form['result'];

                return $contrato;

                break;

            case 'Comunica Rechazo por Compras':

                $contrato['motivo'] = $form['motivo'];

                return $contrato;

                break;

            case 'Generar Pedido de Materiales':

                $this->Pedidoextra->setPemaId($form['peex_id'], $form['pema_id']); 

                $this->Notapedidos->setCaseId($form['pema_id'], $tarea['rootCaseId']);

                return;

                break;
						//	PROCESO PEDIDO CONTENEDORES
						
						case 'Analizar Solicitud':

								$this->load->model('general/transporte-bpm/PedidoContenedores');
							
								$resp = $this->PedidoContenedores->actualizarSolicitud($form);
								
								if (isset($form['motivo'])) {												
									$respComentario = $this->PedidoContenedores->motivoRechazo($form);
								}
								
								$contrato = $this->PedidoContenedores->contratoAnalisisCont($form);								

								return $contrato;

								break;
						
						//  PROCESO RETIRO CONTENEDORES		

						case 'Retira contenedores':	
								
								$this->load->model('general/transporte-bpm/RetiroContenedores');

								$resp = $this->RetiroContenedores->actualizarContenedores($form);
								log_message('DEBUG','#TRAZA|TAREA|getContrato($tarea, $form)/Retira contenedores: $resp >> '.json_encode($resp));
								$contrato = $this->RetiroContenedores->contratoRetiro($form);
								log_message('DEBUG','#TRAZA|TAREA|getContrato($tarea, $form)/Retira contenedores: $contrato >> '.json_encode($contrato));
								return $contrato;
								break;

						//  PROCESO ENTREGA DE ORDENES DE TRANSPORTE
					
						case 'Registra Ingreso':
								$this->load->model('general/transporte-bpm/EntregaOrdenTransportes');	
								$resp = $this->EntregaOrdenTransportes->entregaOrdenTransporte($form);
								log_message('DEBUG','#TRAZA|TAREA|getContrato($tarea, $form)/Registra Ingreso: $resp  >> '.json_encode($resp));
								$contrato = $this->EntregaOrdenTransportes->contratoIngreso($form);
								log_message('DEBUG','#TRAZA|TAREA|getContrato($tarea, $form)/Registra Ingreso: $contrato >> '.json_encode($contrato));
								return $contrato;
								break;								

            default:
                # code...
                break;
        }
    }

    public function deplegarVista($tarea)
    {
        $data['tarea'] = $tarea;

        switch ($tarea->processId) {
            
            #Pedido de Materiales
            case BPM_PROCESS_ID_PEDIDOS_NORMALES:

                $this->load->model(ALM.'Procesos');
                
                return $this->Procesos->desplegarVista($tarea);
						
						case BPM_PROCESS_ID_PEDIDO_CONTENEDORES: 
								
								$this->load->model('general/transporte-bpm/PedidoContenedores');
								return $this->PedidoContenedores->desplegarVista($tarea);
								
						case BPM_PROCESS_ID_RETIRO_CONTENEDORES: 
							
								$this->load->model('general/transporte-bpm/RetiroContenedores');
								return $this->RetiroContenedores->desplegarVista($tarea);
								break;	

						case BPM_PROCESS_ID_ENTREGA_ORDEN_TRANSPORTE: 
								$this->load->model('general/transporte-bpm/EntregaOrdenTransportes');
								return $this->EntregaOrdenTransportes->desplegarVista($tarea);
								break;

            default:

                return $this->load->view(BPM.'view_proceso/test', $data, true);

                break;

        }
    }	

    public function guardarComentario()
    {
        echo $this->bpm->guardarComentario($this->input->post());
    }
}