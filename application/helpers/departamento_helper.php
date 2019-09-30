<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('dpto')){

    function dpto($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->dpto->dpto as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        
        return $html;
    }
}