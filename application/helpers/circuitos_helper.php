<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('circuitos')){
    function circuitos($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->circuitos->circuito as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        return $html;
    }
}