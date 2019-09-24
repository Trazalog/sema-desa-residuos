<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('tipoResiduos')){

    function tipoResiduos($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->tipoResiduos->tipoResiduo as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        
        return $html;
    }
}