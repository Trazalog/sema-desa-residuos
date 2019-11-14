<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('etapaproceso')){
    function etapaproceso($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->etapaproceso->etapaproceso as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        return $html;
    }
}