<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('movilidades')){

    function movilidades($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->movilidades->movilidad as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        
        return $html;
    }
}