<?php defined('BASEPATH') or exit('No direct script access allowed');

class Orden_Trabajo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //Helpers
        $this->load->helper();

        //Models
        $this->load->model('traz-comp-orden/Ordenes_Trabajo');
    }

    // public function index()
    // {
    //     // var_dump("Holis");
    //     // $data['inicio'] =
    //     $this->load->view('traz-comp-orden/orden_trabajo');
    // }

    // llama ABM tareas estandar
    public function index2($permission)
    {
        $data['list']       = $this->Ordenes_Trabajo->Listado_Tareas();
        $data['permission'] = $permission;
        // $this->load->view('tarea/list', $data);
        $this->load->view('traz-comp-orden/orden_trabajo', $data);
    }

    public function guardarTiempo()
    {
        $tiempo = json_decode($this->input->post('data'));
        $array = array(
            "hora" => $tiempo['hora'],
            "minuto" => $tiempo['minuto'],
            "segundo" => $tiempo['segundo']
        );
        $rsp = $this->Ordenes_Trabajo->guardarTiempo($array);
        echo json_encode($array);
        // var_dump($tiempo);        
        // $this->index($tiempo);
    }

    public function detaTarea($permission, $idTarBonita)
    {

        // detecta dispositivo				
        $detect = new Mobile_Detect();
        if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
            $data['device'] = "android";
        } else {
            $data['device'] = "pc";
        }
        $data['permission'] = $permission;

        //OBTENER DATOS DE TAREA SELECCIONADA DESDE BONITA
        $data['TareaBPM'] = $this->getDatosBPM($idTarBonita);
        $data['idTarBonita'] = $idTarBonita;
        $caseId = $data['TareaBPM']["caseId"];

        // Trae id de OT y de Sol Serv por CaseId			
        $id_SS = $this->getIdSolServPorIdCase($caseId);
        log_message('DEBUG', '#TRAZA | #TAREA >> detatarea id_SS: ' . $id_SS);
        log_message('DEBUG', '#TRAZA | #TAREA >> detatarea tarea BPM: ' . json_encode($data['TareaBPM']));
        //dump($id_SS, 'id SolServicios en detatarea: ');
        // si la tarea se origino en una SServicio
        // if ($id_SS == 0) {
        // 	$id_OT = $this->getIdOTPorIdCase($caseId);					
        // } else {	// sino busca el id de OT en BPM
        // 	$id_OT = $this->Tareas->getIdOtPorid_SS($id_SS);

        // }
        // TODO: AHORA TODAS LAS OT TIENEN UN CASE ASOCIADO		
        $id_OT = $this->Ordenes_Trabajo->getIdOTPorIdCaseEnBD($caseId);

        // Si hay Sol Serv trae el id de equpo sino por id de Ot
        if ($id_SS != null) {
            $id_EQ = $this->Ordenes_Trabajo->getIdEquipoPorIdSolServ($id_SS);
        }
        if ($id_OT != null) {
            $id_EQ = $this->Ordenes_Trabajo->getIdEquipoPorIdOT($id_OT);
        }

        $data['id_OT'] = $id_OT;
        $data['id_SS'] = $id_SS;
        $data['id_EQ'] = $id_EQ;


        /* Bloque subtareas estandar */
        if ($id_OT != 0) {
            /* funcion nueva de asset */
            // traer subtareas estandar en funcion de id tarea estandar	
            //$tareaSTD = $this->Tareas->getIdTareaSTD($id_OT);
            //if ($tareaSTD) {
            if (!empty($this->Ordenes_Trabajo->getSubtareas($id_OT))) {
                $data['subtareas'] = $this->Ordenes_Trabajo->getSubtareas($id_OT);
            }
            //} 					
        }

        //LIBRERIA BPM
        $case_id = $data['TareaBPM']["caseId"];
        $case = array('caseId' => $case_id);

        // LINEA DE TIEMPO 			
        $data['timeline'] = $this->bpm->ObtenerLineaTiempo(BPM_PROCESS_ID, $case_id);
        //CARGAR VISTA COMENTARIOS 
        $data_aux = ['case_id' => $case_id, 'comentarios' => $this->bpm->ObtenerComentarios($case_id)['data']];
        // $data['comentarios'] = $this->load->view('tareas/componentes/comentarios', $data_aux, true);//+++++++++++++++++++++++++++++++++++
        $data['comentarios'] = $this->load->view('traz-comp-orden/comentarios', $data_aux, true);
        // Carga de vistas segun orden del proceso	
        switch ($data['TareaBPM']['displayName']) {

                // case 'Analisis de Solicitud de Servicio':
                //     $this->load->view('tareas/view_analisisSServicios', $data);
                //     $this->load->view('tareas/scripts/tarea_std');
                //     break;
                // case 'Planificar Solicitud':
                //     $this->load->view('tareas/view_planificar', $data);
                //     $this->load->view('tareas/scripts/tarea_std');
                //     break;
                // case 'Asignar Responsable OT Urgente ':
                //     $this->load->view('tareas/view_asignar', $data);
                //     $this->load->view('tareas/scripts/tarea_std');
                //     break;
                // case 'Asignar Resonsable OT':
                //     $this->load->view('tareas/view_asignar', $data);
                //     $this->load->view('tareas/scripts/tarea_std');
                //     break;
                // case 'Editar Backlog':
                //     $data['info'] = $this->getEditarBacklog($id_SS);
                //     $this->load->view('backlog/nuevo_edicion_view_', $data);
                //     $this->load->view('tareas/scripts/tarea_std');
                //     break;
                // case 'Planificar Backlog':
                //     $this->load->view('tareas/view_planificar', $data);
                //     $this->load->view('tareas/scripts/tarea_std');
                //     break;
            case 'Ejecutar OT':

                $this->load->model('traz-comp-orden/Componentes');
                // $this->load->model(ALM . '/new/Pedidos_Materiales'); //++++++++++++++++++++

                // $data['descripcionOT'] = $this->Otrabajos->obtenerOT($id_OT)->descripcion;//+++++
                $data['descripcionOT'] = $this->Ordenes_Trabajo->obtenerOT($id_OT)->descripcion;
                #COMPONENTE ARTICULOS
                $data['items'] = $this->Componentes->listaArticulos();
                $data['lang'] = lang_get('spanish', 'Ejecutar OT');
                #PEDIDO MATERIALES
                $info = new StdClass();
                $info->ortr_id = $id_OT;
                $info->modal = 'agregar_pedido';
                $data['info'] = $info;
                // $this->load->model(ALM . '/Notapedidos');//+++++++++++++++++++++++++++++++++
                // $data['list'] = $this->Notapedidos->notaPedidos_List($id_OT);//+++++++++++++
                $data['list'] = $this->Ordenes_Trabajo->notaPedidos_List($id_OT);
                // $this->load->model('traz-comp/Componentes');
                // $this->load->view('tareas/view_ejecutarOT', $data);//+++++++++++++++++++++++
                $this->load->view('traz-comp-orden/orden_trabajo', $data);
                //$this->load->view('tareas/scripts/tarea_std');	


                break;
                // case 'Esperando cambio estado "a Ejecutar"':
                //     $this->load->view('tareas/view_cambio_estado', $data);
                //     $this->load->view('tareas/scripts/tarea_std');
                //     break;
                // case 'Esperando cambio estado "a Ejecutar" 2':
                //     dump($data, 'datos de bpm: ');
                //     $this->load->view('tareas/view_cambio_estado', $data);
                //     $this->load->view('tareas/scripts/tarea_std');
                //     break;
                // case 'Confecciona informe servicio':
                //     $this->load->view('tareas/view_informe_servicio', $data);
                //     $this->load->view('tareas/scripts/tarea_std');
                //     break;
                // case 'Verifica Informe de Servicio':
                //     $this->load->view('tareas/view_verifica_informe', $data);
                //     $this->load->view('tareas/scripts/tarea_std');
                //     break;
                // case 'Presta conformidad':
                //     $this->load->view('tareas/view_presta_conformidad', $data);
                //     $this->load->view('tareas/scripts/tarea_std');
                //     break;

                // default:
                //     $this->load->view('tareas/view_', $data);
                //     $this->load->view('tareas/scripts/tarea_std');
                //     break;
        }
    }

    public function getDatosBPM($idTarBonita)
    {

        return $this->bpm->getTarea($idTarBonita)['data'];
    }

    function getIdSolServPorIdCase($caseId)
    {

        $rsp = $this->bpm->getCaseVariable($caseId, 'gIdSolicitudServicio');

        if (!$rsp['status']) {
            return 0;
        }

        return $rsp["data"];
    }

    /* INTEGRACION CON BPM */

    /*	./ FUNCIONES BPM */
    // Bandea de entrada
    public function index($permission = null)
    {
        ///$this->load->helper('control_sesion');
        // if	(validaSesion()){
        $detect = new Mobile_Detect();
        //Obtener Bandeja de Usuario desde Bonita
        $response = $this->bpm->getToDoList();
        //dump($response, 'respuesta tareas BPM: ');
        if (!$response['status']) {
            //$this->load->view('404');
            return;
        }
        //Completar Tareas con ID Solicitud y ID OT
        // $data_extend = $this->Tareas->CompletarToDoList($response['data']);
        $data_extend = $this->Ordenes_Trabajo->CompletarToDoList($response['data']);
        $data['list'] = $data_extend;
        $data['permission'] = $permission;

        if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
            $data['device'] = "android";
        } else {
            $data['device'] = "pc";
        }
        $this->load->view('traz-comp-orden/list', $data);
        //}			
    }
}
