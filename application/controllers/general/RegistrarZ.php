<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Hecha por Jose Roberto el mas vergas */
class RegistrarZ extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('departamento_helper');
      $this->load->helper('circuitos_recorridos_helper');
      $this->load->model('general/Dpto');
      $this->load->model('general/CircR');
   }

   function registrarZ()
   {
       $data['Dpto'] = $this->Dpto->obtener();
       $data['CircR'] = $this->CircR->obtener();
       $this->load->view('layout/registrar_zona', $data);
       $this->cargar_archivo();
   }
   function templateRz()
   {
       $data['Dpto'] = $this->Dpto->obtener();
       $data['CircR'] = $this->CircR->obtener();
       $this->load->view('layout/registrar_zona',$data);
   }
   function cargar_archivo() {

    $upload = 'upload';
    $config['upload_path'] = "./uploads";
    //$config['file_name'] = "nombre_archivo";
    $config['allowed_types'] = "*";
    $config['max_height'] = "*";
    $this->load->library('upload', $config);
    
    if (!$this->upload->do_upload($upload)) {
        //*** ocurrio un error
        //$data['uploadError'] = $this->upload->display_errors();
        echo $this->upload->display_errors();
        return;
    }
     echo($this->uploads);
     var_dump($this->uploads->data());
    //$data['uploadSuccess'] = $this->upload->data();
}
}
?>