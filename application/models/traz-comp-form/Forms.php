<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Forms extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function guardar($form_id, $data = false)
    {
        $items = $this->obtenerPlantilla($form_id);

        $newInfo = $this->db->select_max('info_id')->get('frm.instancias_items')->row('info_id') + 1;

        $array = array();

        $aux = array();

        foreach ($items->items as $key => $o) {

            $o->info_id = $newInfo;
            unset($o->nombre);
            unset($o->tipo);

            if ($o->name) {
                $o->valor = $data ? $data[$o->name] : null;
                array_push($array, $o);
            } else {
                array_push($aux, $o);
            }
        }

        $this->db->insert_batch('frm.instancias_items', $aux);
        return $this->db->insert_batch('frm.instancias_items', $array);
    }

    public function actualizar($info_id, $data)
    {

        foreach ($data as $key => $o) {

            $this->db->where('info_id', $info_id);
            $this->db->where('name', $key);
            $this->db->set('valor', $o);
            $this->db->update('frm.instancias_items');
        }

        return;
    }

    public function obtener($info_id)
    {
        $this->db->select('name, label, requerido, tipo_dato as tipo, valo_id, orden, A.form_id, A.valor, C.nombre');
        $this->db->from('frm.instancias_items as A');
        #$this->db->join('alm.utl_tablas as B', 'B.tabl_id = A.tida_id');
        $this->db->join('frm.formularios as C', 'C.form_id = A.form_id');
        $this->db->where('A.info_id', $info_id);
       # $this->db->where('A.eliminado', false);
        $this->db->order_by('A.orden');

        $res = $this->db->get();

        $aux = new StdClass();
        $aux->info_id = $info_id;
        $aux->nombre = $res->row()->nombre;
        $aux->id = $info_id;
        $aux->items = $res->result();

        foreach ($aux->items as $key => $o) {

            if ($o->tipo == 'radio' || $o->tipo == 'check' || $o->tipo == 'select') {

                $aux->items[$key]->values = $this->obtenerValores($o->valo_id);

            }
        }

        return $aux;
    }

    public function obtenerPlantilla($id)
    {
        $this->db->select('name, label, requerido, tipo_dato as tipo, valo_id, orden, form_id');
        $this->db->from('frm.items');
        #$this->db->join('alm.utl_tablas as B', 'B.tabl_id = A.tida_id');
        // $this->db->join('frm.formularios as C', 'C.form_id = A.form_id');
        $this->db->where('form_id', $id);
        #$this->db->where('A.eliminado', false);
        $this->db->order_by('orden');

        $res = $this->db->get();

        $aux = $res->result();

        if($res->num_rows() == 0) return null;

        $newInfo = $this->db->select_max('info_id')->get('frm.instancias_items')->row('info_id') + 1;
        
        $aux = new StdClass();
        $aux->info_id = false;
        $aux->form_id = $id;
        $aux->nombre = $res->row()->nombre;
        $aux->id = $newInfo; 
        $aux->items = $res->result();

        foreach ($aux->items as $key => $o) {

            if ($o->tipo == 'radio' || $o->tipo == 'check' || $o->tipo == 'select') {

                $aux->items[$key]->values = $this->obtenerValores($o->valo_id);

            }
        }

        return $aux;
    }

    public function obtenerValores($id)
    {
        $this->db->select('valor as value, valor as label');
        return $this->db->get_where('alm.utl_tablas', array('tabla' => $id))->result();
    }

    public function listado()
    {
        $this->db->select('nombre, A.form_id, info_id');
        $this->db->from('frm.instancias_items as A');
        $this->db->join('frm.formularios as B', 'B.form_id = A.form_id');
        $this->db->group_by('A.info_id');
        return $this->db->get()->result();
    }

    public function listadoPlantillas()
    {
        return $this->db->get('frm.formularios')->result();
    }
}
