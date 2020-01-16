<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('carnet')){
    function carnet($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->carnet->carnet as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        return $html;
    }
}