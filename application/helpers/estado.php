<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('estado')){

    function estado($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->estado->estado as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        
        return $html;
    }
}