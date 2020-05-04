<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Representa la entidad Circuitos
*
* @autor Hugo Gallardo
*/
class Circuito extends CI_Controller {

  /**
  * constructor de clase
  * @param 
  * @return 
  */
  function __construct(){

    parent::__construct();
    $this->load->model('general/Estructura/Circuitos');      
  }

  /**
  * Carga pantalla de ABM de circuitos y listados
  * @param 
  * @return 
  */
  function templateCircuitos()
  {     
     $data['tipoResiduos'] = $this->Circuitos->obtener_RSU();     
     $data['Departamentos'] = $this->Circuitos->obtener_Departamentos();    
     $data['Vehiculo'] = $this->Circuitos->obtener_Vehiculo();   
     $data['Chofer'] = $this->Circuitos->obtener_Chofer();   
     $this->load->view('layout/Circuitos/registrar_circuitos',$data);
  }   

  /**
  * carga tabla listado de circitos
  * @param 
  * @return view listado circuitos 
  */ 
  function Listar_Circuitos()
  {
     $data["circuitos"] = $this->Circuitos->Listar_Circuitos();
     $data['puntos_criticos'] = $this->Circuitos->obtener_Punto_Critico();  
     $this->load->view('layout/Circuitos/Lista_Circuitos',$data);
  }

  
  function Guardar_Circuito()
  {

		// datos de la vista  
		$datos_circuitos =  $this->input->post('datos_circuito'); 		  
		$datos_puntos_criticos =  $this->input->post('datos_puntos_criticos');
		$datos_tipo_carga =  $this->input->post('datos_tipo_carga'); 
     
		// guarda circuito 
			$circ_id = $this->Circuitos->Guardar_Circuito($datos_circuitos)->respuesta->circ_id;

			if ($circ_id == null) {
						echo "Circuito no registrado"; return;
			} 
     
    // 2 recorro  array puntos agregando id de circ y guardando de a uno     
      for ($i=0; $i < count($datos_puntos_criticos); $i++) { 
       
        $aux[$i]['circ_id'] = $circ_id;
        $aux[$i]['pucr_id'] = $this->Circuitos->Guardar_punto_critico($datos_puntos_criticos[$i])->respuesta->pucr_id;
     }
     
     // asociar Id circuito a punto critico
     $resp = $this->Circuitos->Asociar_punto_critico($aux);
     if(!$resp['status']){
        echo "punto no asociado";return;
        }
        
     
     // 3  con id circ  agregar a array tipo de carga armar batch  /_post_circuitos_tipocarga_batch_req  
     foreach ($datos_tipo_carga as $key => $carga) {
       
        $tipocarga[$key]['circ_id'] = $circ_id;
        $tipocarga[$key]['tica_id'] = $carga;
     
     }

     $resp = $this->Circuitos->Guardar_tipo_carga($tipocarga);

     // Operacion de validacion tipo carga
   
     if (!$resp['status']) {
        echo "tipo carga no asociado";return;
      }
     
     //-------------------------------------------------------------
     

     echo 'ok';
    


  } 
  /**
  * Actualiza los datos de cicuito y puntos criticos
  * @param obj info de circuitos y ptus criticos
  * @return string "error" y "ok"
  */
  function actulizaCircuitos()
  {
		log_message('INFO','#TRAZA|CIRCUITO|actulizaCircuitos() >> ');

		$circuitos = $this->input->post('circuito_edit');
	
		//TODO: SACARA CIRC_ID MANDAR A ACTUALIZAR
		
		$resp = $this->Circuitos->actulizaInfoCircuitos();
		
		
		//TODO: GUARDAR EL TIPO CARGA
		// 	$tipoCarga = $this->input->post('tica_edit');
		// 	var_dump($tipocarga);

		// 	foreach ($datos_tipo_carga as $key => $carga) {
		// 		$tipocarga[$key]['circ_id'] = $circ_id;
		// 		$tipocarga[$key]['tica_id'] = $carga;
		// 	}
		//  $resp = $this->Circuitos->Guardar_tipo_carga($tipocarga);

		//TODO: BORRAR PTOS CRITICOS ASOCIADOS A ID DE CRCUITOS
		//TODO: RECORRER ARAY ASOCIANDO A CIRCUITOS LOS PUNTOS CRITICOS    
     $ptos = $this->input->post('ptos_criticos_edit');
     var_dump($ptos); 

   }



   
	/**
	* Asigna una zona a un determinado circuito
	* @param array circ_id y zona_id
	* @return atring ok o error
	*/
	function Asignar_Zona()
  {
		//TODO: REVISAR ESTE METODO
		$resp = $this->Circuitos->Asignar_Zona($this->input->post('circ_zona'));
		if($resp){
		echo "ok";
		}else{
		echo "error";
		}
  }

	/**
	* Borra logicamente un circuito
	* @param int circ_id
	* @return string "ok" o "error"
	*/	
	function borrar_Circuito()
	{
		$circ_id = $this->input->post('circ_id');
		$resp = $this->Circuitos->borrar_Circuito($circ_id);
		if ($resp) {
			echo "ok";
		} else {
			log_message('ERROR','#TRAZA|CIRCUITOS|borrar_Circuito() >> ERROR EM BORRADO DE CIRCUITO');
			echo "error";
		}
		
	}
  
  
  // _________________________________________________________

   /**
    * Obtiene todos los tipos de carga
    * @param 
    * @return json tipos de carga
    */
   function obtener_RSU()
   { 
      log_message('INFO','#TRAZA|TRANSPORTISTA|obtener_RSU() >>');
      $rsu = $this->Circuitos->obtener_RSU();      
      echo json_encode($rsu);   
   } 
   
   /**
   * Obtiene Departamentos
   * @param 
   * @return json con departamentos
   */
   public function obtener_Departamentos()
   {
      $deptos = $this->Circuitos->obtener_Departamentos();
      echo json_encode($deptos);
   }
   /**
   * otiene Zonas de un departamento determinado
   * @param int depa_id
   * @return json con zonas
   */
   public function obtener_Zona_departamento()
   {
      $resp = $this->Circuitos->obtener_Zona_departamento($this->input->post('depa_id'));
      echo json_encode($resp);
   }


} 