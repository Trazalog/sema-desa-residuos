<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('tipo')){

    function tipo($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->tipo->tipo as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        
        return $html;
    }
}