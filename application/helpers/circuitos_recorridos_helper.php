<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('circr')){

    function circr($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->circr->circr as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        
        return $html;
    }
}