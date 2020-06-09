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
		//	 levanta solo tabla para pruebas
		//  $data["circuitos"] = $this->Circuitos->Listar_Circuitos();
		//  $this->load->view('layout/Circuitos/Lista_Circuitos',$data);
  }   

  /**
  * carga tabla listado de circitos
  * @param 
  * @return view listado circuitos 
  */ 
  function Listar_Circuitos()
  {
     $data["circuitos"] = $this->Circuitos->Listar_Circuitos();
     //$data['puntos_criticos'] = $this->Circuitos->obtener_Punto_Critico();  
     $this->load->view('layout/Circuitos/Lista_Circuitos',$data);
  }

	/**
	* Guarda Circuito nuevo, tipo de RSU asociado y Puntos Criticos
	* @param array datos circuito, rsu y ptos criticos
	* @return string "ok" o "error"
	*/
  function Guardar_Circuito()
  {
		log_message('INFO','#TRAZA|CIRCUITO|Guardar_Circuito() >> ');
		// datos de la vista  
		$datos_circuitos =  $this->input->post('datos_circuito'); 		  
		$datos_puntos_criticos =  $this->input->post('datos_puntos_criticos');
		$datos_tipo_carga =  $this->input->post('datos_tipo_carga');
		log_message('DEBUG','#TRAZA|CIRCUITO|Guardar_Circuito():$datos_circuitos  >> '.json_encode($datos_circuitos)); 
		log_message('DEBUG','#TRAZA|CIRCUITO|Guardar_Circuito():$datos_puntos_criticos >> '.json_encode($datos_puntos_criticos)); 
		log_message('DEBUG','#TRAZA|CIRCUITO|Guardar_Circuito():$datos_tipo_carga >> '.json_encode($datos_tipo_carga)); 
		
		// 1 guarda circuito 
			$circ_id = $this->Circuitos->Guardar_Circuito($datos_circuitos)->respuesta->circ_id;
			if ($circ_id == null) {
				log_message('ERROR','#TRAZA|CIRCUITO|$circ_id >> ERROR '.json_encode($circ_id));
				echo "Error... Circuito no registrado"; return;
			} 
		//  2 guarda puntos criticos si hubiera
			if(!empty($datos_puntos_criticos)){
				// recorro  array puntos agregando id de circ y guardando de a uno     
				for ($i=0; $i < count($datos_puntos_criticos); $i++) {        
					$aux[$i]['circ_id'] = $circ_id;
					$aux[$i]['pucr_id'] = $this->Circuitos->Guardar_punto_critico($datos_puntos_criticos[$i])->respuesta->pucr_id;
				 }
				// asociar Id circuito a punto critico
				$resp = $this->Circuitos->Asociar_punto_critico($aux);
				if(!$resp){
						log_message('ERROR','#TRAZA|CIRCUITO|Guardar_Circuito() >> ERROR al asociar puntos criticos');
						echo "Error... Punto Crítico no asociado";return;
				} 
			}
			
		// 3  con id circ  agregar a array tipo de carga armar batch  /_post_circuitos_tipocarga_batch_req  
			foreach ($datos_tipo_carga as $key => $carga) {  
				$tipocarga[$key]['circ_id'] = $circ_id;
				$tipocarga[$key]['tica_id'] = $carga;  
			}
			$resp = $this->Circuitos->Guardar_tipo_carga($tipocarga);
			if (!$resp) {
				log_message('ERROR','#TRAZA|CIRCUITOS|Guardar_Circuito() >> ERROR al guardar tipos de carga ');
				echo "Error... Tipo de RSU no asociado";return;
			}

    echo 'ok';
	} 
	
  /**
  * Actualiza los datos de cicuito y puntos criticos
  * @param obj info de circuitos y ptos criticos
  * @return string "error" y "ok"
  */
  function actulizaCircuitos()
  {
			log_message('INFO','#TRAZA|CIRCUITO|actulizaCircuitos() >> ');
			// actualiza dats de circuito
				$circuitos = $this->input->post('circuito_edit');
				$circuitos['usuario_app'] = userNick();
				$resp = $this->Circuitos->actulizaInfoCircuitos($circuitos);	
			// borra tipos de carga
				$circ_id = $circuitos['circ_id'];
				$respDeletTipoCarga = $this->Circuitos->deleteTiposCarga($circ_id);
				if(!$respDeletTipoCarga){
					echo "Error eliminando tipos de RSU...";
					log_message('ERROR','#TRAZA|CIRCUITO|actulizaCircuitos() >> ERROR eliminando tipos de carga');
					return;
				}			
			// guarda tipos de carga nuevos
				$datos_tipo_carga = json_decode($this->input->post('tica_edit'));		
				foreach ($datos_tipo_carga as $key => $carga) {
					$tipocarga[$key]['circ_id'] = $circ_id;
					$tipocarga[$key]['tica_id'] = $carga;
				}
				$respSetTipoCarga = $this->Circuitos->Guardar_tipo_carga($tipocarga);
				if(!$respSetTipoCarga){
					echo "Error al guardar tipos de RSU...";
					log_message('ERROR','#TRAZA|CIRCUITO|actulizaCircuitos() >> ERROR al guardar tipos de carga');
					return;
				}	
			// anula relacion de ptos criticos con circuitos	
				$respDelPtosCrit = $this->Circuitos->borrar_PCriticosPorCirc($circ_id);   
				if(!$respDelPtosCrit){
					log_message('ERROR','#TRAZA|CIRCUITO|actulizaCircuitos() >> ERROR al anular los Puntos Criticos');
					echo "Error al anular puntos criticos";
					return;
				}	
			// recorro  array puntos agregando id de circ y guardando de a uno 
				$datos_puntos_criticos = $this->input->post('ptos_criticos_edit');	
				if(empty($datos_puntos_criticos)){
						//recorre datos, crea puntos nuevos y arma array para asociar
						for ($i=0; $i < count($datos_puntos_criticos); $i++) {   						
							$pucr_id = $this->Circuitos->Guardar_punto_critico($datos_puntos_criticos[$i])->respuesta->pucr_id;							
							//si guarda punto critico devuelve pucr_id
							if ($pucr_id) {
								$aux[$i]['circ_id'] = $circ_id;
								$aux[$i]['pucr_id'] = $pucr_id;
							}else{
								// trae el pucr_id por nombre y guarda en array para asociar nuevamente						
								$pucr_id = $this->Circuitos->ObtenerPucr_id($datos_puntos_criticos[$i]['nombre']);
								$aux[$i]['circ_id'] = $circ_id;
								$aux[$i]['pucr_id'] = $pucr_id;
								log_message('DEBUG','#TRAZA|CIRCUITOS|actulizaCircuitos()|NO GUARDO PUNTO NUEVO|: $pucr_id >> '.json_encode($pucr_id));
							}					
						}
						// asociar Id circuito a punto critico
						$resp = $this->Circuitos->Asociar_punto_critico($aux);
						if(!$resp){
								log_message('ERROR','#TRAZA|CIRCUITO|Guardar_Circuito() >> ERROR al asociar puntos criticos');
								echo "punto no asociado";return;
						}
				}			 

			echo "ok";
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
	 
	 /**
	 * Obtiene imagen guardada por id de circuito
	 * @param int circ_id
	 * @return bynary imagen
	 */		
	 function obtener_Imagen(){
		 log_message('INFO','#TRAZA|CIRCUITO|obtener_Imagen() >> ');
		 $resp = $this->Circuitos->obtener_Imagen($this->input->post('circ_id'));
		 echo json_encode($resp);
	 }


} 