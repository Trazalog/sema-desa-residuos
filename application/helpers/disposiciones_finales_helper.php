<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('disposicionesFinales')){
    function disposicionesFinales($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->disposicionesFinales->disposicionFinal as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        return $html;
    }
}