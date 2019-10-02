<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('rsu')){

    function rsu($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->rsu->rsu as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        
        return $html;
    }
}