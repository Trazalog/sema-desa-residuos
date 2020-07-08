<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('CircR')){
    function CircR($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->CircR->CircR as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        return $html;
    }
}