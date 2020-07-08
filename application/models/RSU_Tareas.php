<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class RSU_Tareas extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }

    // configuracion de la info que muestra la bandeja de entradas
    public function map($tarea)
    {
        $data['descripcion'] = 'soy una descripcion';

        $aux = new StdClass();
        $aux->color = 'warning';
        $aux->texto = 'yayayayaya';
        $data['info'][] = $aux;
        return $data;
    }

    public function desplegarVista($tarea)
    {
        switch ($tarea->nombreTarea) {
            default:
                # code...
                break;
        }
    }

    public function getContrato($tarea, $form)
    {
        switch ($tarea->nombreTarea) {
            default:
                # code...
                break;
        }
    }


}
