<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ordenes_Trabajo extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function guardarTiempo($tiempo = null)
    {
    }

    function Listado_Tareas()
    {
        $userdata  = $this->session->userdata('user_data');
        $empresaId = $userdata[0]['id_empresa'];
        $this->db->where('estado', 'AC');
        $this->db->where('tareas.id_empresa', $empresaId);
        $query = $this->db->get('tareas');
        if ($query->num_rows() != 0) {
            return $query->result_array();
        }
    }

    function getIdOTPorIdCaseEnBD($caseId)
    {
        $this->db->select('orden_trabajo.id_orden');
        $this->db->from('orden_trabajo');
        $this->db->where('orden_trabajo.case_id', $caseId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row('id_orden');
        } else {
            return 0;
        }
    }

    function getIdEquipoPorIdSolServ($id_SS)
    {

        $this->db->select('solicitud_reparacion.id_equipo');
        $this->db->from('solicitud_reparacion');
        $this->db->where('solicitud_reparacion.id_solicitud', $id_SS);
        $query = $this->db->get();

        if ($query->num_rows() != 0) {
            return $query->row('id_equipo');
        } else {
            return false;
        }
    }

    function getIdEquipoPorIdOT($id_OT)
    {

        $this->db->select('orden_trabajo.id_equipo');
        $this->db->from('orden_trabajo');
        $this->db->where('orden_trabajo.id_orden', $id_OT);
        $query = $this->db->get();

        if ($query->num_rows() != 0) {
            return $query->row('id_equipo');
        } else {
            return false;
        }
    }

    function getSubtareas($ot)
    {
        $this->db->select('tbl_listarea.*,
												asp_subtareas.tareadescrip AS subtareadescrip,
												asp_subtareas.id_subtarea,
												asp_subtareas.duracion_prog,
												asp_subtareas.form_asoc');
        $this->db->from('tbl_listarea');
        $this->db->join('asp_subtareas', 'asp_subtareas.id_subtarea = tbl_listarea.id_subtarea', 'left');
        $this->db->where('tbl_listarea.id_orden', $ot);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function obtenerOT($ot)
    {
        $this->db->where('orden_trabajo.id_orden', $ot);
        return $this->db->get('orden_trabajo')->first_row();
    }

    public function listaArticulos()
    {
        $this->load->model(ALM . '/Articulos');

        // $list = json_decode(json_encode($this->Articulos->getList()));
        $list = json_decode(json_encode($this->Ordenes_Trabajo->getList()));
        $aux = array();
        $obj = null;
        foreach ($list as $key => $o) {
            $obj = new stdClass();
            $obj->id = $o->arti_id;
            $obj->descripcion = $o->descripcion;
            $obj->codigo = $o->barcode;
            $obj->stock = $o->stock;
            $obj->json = json_encode($o);

            array_push($aux, $obj);
        }
        $data['items'] = $aux;
        //echo var_dump($data);die;
        /*$data['lang'] = json_decode(file_get_contents(base_url('lang.json')), true)['labels']['label'];
		$lenguaje =  array();
		 for($i=0;$i<count($data['lang'] );$i++)
		 {
			 $aux = array($data['lang'][$i]['id']=> $data['lang'][$i]['texto']);
			 $lenguaje = array_merge($lenguaje,$aux);
		 }
         $data['lang'] =$lenguaje;*/

        return $data['items'];
    }

    function notaPedidos_List()
    {
        $userdata = $this->session->userdata('user_data');
        $empId    = $userdata[0]['id_empresa'];
        $this->db->select('tbl_notapedido.id_notaPedido,
            tbl_notapedido.fecha,
            tbl_notapedido.id_ordTrabajo,
            orden_trabajo.descripcion');
        $this->db->from('tbl_notapedido');
        $this->db->join('orden_trabajo', 'tbl_notapedido.id_ordTrabajo = orden_trabajo.id_orden');
        $this->db->where('tbl_notapedido.id_empresa', $empId);

        $query = $this->db->get();

        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function getList()
    {
        $this->db->select('A.*, B.descripcion as medida,"AC" as valor, IFNULL(sum(C.cantidad),0) as stock');
        $this->db->from('alm_articulos A');
        $this->db->join('utl_tablas B', 'B.tabl_id = A.unidad_id', 'left');
        $this->db->join('alm_lotes C', 'C.arti_id = A.arti_id', 'left');
        $this->db->where('A.empr_id', empresa());
        $this->db->where('not A.eliminado');
        $this->db->group_by('arti_id');

        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }


    // Agrega datos desde BPM y BD local
    function CompletarToDoList($data)
    {



        foreach ($data as $key => $value) {

            if ($value['processId'] == BPM_PROCESS_ID_PEDIDOS_NORMALES) {
                $res = $this->db->get_where('alm_pedidos_materiales', ['case_id' => $value['caseId']])->row();
                $data[$key]['pema_id'] = $res->pema_id;
                $data[$key]['ot'] = $res->ortr_id;
                continue;
            }

            if ($value['processId'] == BPM_PROCESS_ID_PEDIDOS_EXTRAORDINARIOS) {
                $res = $this->db->get_where('alm_pedidos_extraordinario', ['case_id' => $value['caseId']])->row();
                $data[$key]['pema_id'] = $res->peex_id;
                $data[$key]['ot'] = $res->ortr_id;
                continue;
            }

            $this->db->select('A.id_solicitud as \'ss\', id_orden as \'ot\', descripcion as \'desc\', causa');
            $this->db->where('A.case_id', $value['caseId']);
            $this->db->from('solicitud_reparacion as A');
            $this->db->join('orden_trabajo as B', 'A.id_solicitud = B.id_solicitud', 'left');
            $res = $this->db->get()->first_row();

            if (!$res) {

                $this->db->select('A.id_solicitud as \'ss\', id_orden as \'ot\', descripcion as \'desc\', causa');
                $this->db->from('solicitud_reparacion as A');
                $this->db->from('orden_trabajo as B');
                $this->db->from('tbl_back as C');
                $this->db->where('A.case_id', $value['caseId']);
                $this->db->where('C.backId', 'B.id_solicitud', 'left');
                $this->db->where('C.sore_id', 'A.id_solicitud', 'left');

                $res = $this->db->get()->first_row();

                if (!$res) {

                    $this->db->select('id_orden as \'ot\', descripcion as \'desc\', causa');
                    $this->db->where('A.case_id', $value['caseId']);
                    $this->db->from('solicitud_reparacion as A');
                    $this->db->join('orden_trabajo as B', 'B.id_solicitud = A.id_solicitud', 'left');
                    $res = $this->db->get()->first_row();

                    if (!$res) {

                        $this->db->select('id_orden as \'ot\', descripcion as \'desc\'');
                        $this->db->from('orden_trabajo as A');
                        $this->db->where('A.case_id', $value['caseId']);
                        $res = $this->db->get()->first_row();

                        $data[$key]['ss'] = '';
                        $data[$key]['ot'] = $res->ot;
                        $data[$key]['displayDescription'] = $res->desc;
                    } else {
                        $data[$key]['ss'] = $res->ss;
                        $data[$key]['ot'] = $res->ot;

                        if ($res->desc != null) {
                            $data[$key]['displayDescription'] = $res->desc;
                        } else {
                            $data[$key]['displayDescription'] = $res->causa;
                        }
                    }
                } else {
                    $data[$key]['ss'] = $res->ss;
                    $data[$key]['ot'] = $res->ot;

                    if ($res->desc != null) {
                        $data[$key]['displayDescription'] = $res->desc;
                    } else {
                        $data[$key]['displayDescription'] = $res->causa;
                    }
                }
            } else {
                $data[$key]['ss'] = $res->ss;
                $data[$key]['ot'] = $res->ot;

                if ($res->desc != null) {
                    $data[$key]['displayDescription'] = $res->desc;
                } else {
                    $data[$key]['displayDescription'] = $res->causa;
                }
            }
        }

        return $data;
    }
    /* 	./ TAREAS BPM */
}
