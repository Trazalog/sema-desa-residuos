<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('zonag')){

    function zonag($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->zonag->zonag as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        
        return $html;
    }
}