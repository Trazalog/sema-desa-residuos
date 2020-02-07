<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tarea extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

        $this->load->model(BPM . 'Tareas');


        // SUPERVISOR1 => 102 => Aprueba pedido de Recursos Materiales
        $data = ['userId' => 2, 'userName' => 'Fernando', 'userLastName' => 'Leiva', 'device' => '', 'permission' => 'Add-View-Del-Edit', 'id_empresa' => 1];
        $this->session->set_userdata('user_data', $data);
    }

    public function index()
    {

        $data['device'] = "";
        $data['list'] = $this->Tareas->listar();
        $this->load->view(BPM . 'bandeja_entrada', $data);
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
        $data['info'] = $this->load->view(BPM . 'componentes/informacion', null, true);

        //LINEA DE TIEMPO
        $aux = $this->bpm->ObtenerLineaTiempo($tarea->processId, $tarea->caseId);
        $aux = json_decode(json_encode($aux));
        $data['timeline'] = $this->load->view(BPM . 'componentes/timeline', $aux, true);

        //COMENTARIOS
        $aux = ['case_id' => $tarea->caseId, 'comentarios' => $this->bpm->ObtenerComentarios($tarea->caseId)['data']];
        $data['comentarios'] = $this->load->view(BPM . 'componentes/comentarios', $aux, true);

        //DESPLEGAR VISTA
        $data['view'] = $this->deplegarVista($tarea);
        $this->load->view(BPM . 'notificacion_estandar', $data);
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
        $tarea = $this->bpm->getTarea($taskId)['body'];

        //Formulario desde la Vista
        $form = $this->input->post();

        //Mapeo de Contrato
        $contrato = $this->getContrato($tarea, $form);

        //Cerrar Tarea
        $this->bpm->cerrarTarea($taskId, $contrato);
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

            default:
                # code...
                break;
        }
    }

    public function deplegarVista($tarea)
    {
        $data['tarea'] = $tarea;

        // switch ($tarea->processId) {

        //     #Pedido de Materiales
        //     case '6352939331165329370':

        //         $this->load->model(ALM.'Procesos');

        //         return $this->Procesos->desplegarVista($tarea);

        //     default:

        //         return $this->load->view(BPM.'view_proceso/test', $data, true);

        //         break;

        // }

        
        $this->load->model(ORD . 'Ordenes_Trabajo');        
        $this->load->model(ORD . 'Componentes');
        $this->load->controller(ORD . 'Orden_Trabajo');
        $this->Orden_Trabajo->detaTarea($data['permission'], $data['tarea']);
        // $this->load->model(ALM . '/new/Pedidos_Materiales'); //++++++++++++++++++++

        // // $data['descripcionOT'] = $this->Otrabajos->obtenerOT($id_OT)->descripcion;//+++++
        // $data['descripcionOT'] = $this->Ordenes_Trabajo->obtenerOT($id_OT)->descripcion;
        // #COMPONENTE ARTICULOS
        // $data['items'] = $this->Componentes->listaArticulos();
        // $data['lang'] = lang_get('spanish', 'Ejecutar OT');
        // #PEDIDO MATERIALES
        // $info = new StdClass();
        // $info->ortr_id = $id_OT;
        // $info->modal = 'agregar_pedido';
        // $data['info'] = $info;
        // // $this->load->model(ALM . '/Notapedidos');//+++++++++++++++++++++++++++++++++
        // // $data['list'] = $this->Notapedidos->notaPedidos_List($id_OT);//+++++++++++++
        // $data['list'] = $this->Ordenes_Trabajo->notaPedidos_List($id_OT);
        // // $this->load->model('traz-comp/Componentes');
        // // $this->load->view('tareas/view_ejecutarOT', $data);//+++++++++++++++++++++++
        // $this->load->view('traz-comp-orden/orden_trabajo', $data);
        // //$this->load->view('tareas/scripts/tarea_std');
    }

    public function guardarComentario()
    {
        echo $this->bpm->guardarComentario($this->input->post());
    }
}
