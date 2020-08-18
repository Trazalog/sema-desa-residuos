<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
* Representa a la Entidad Generadores
*
* @autor Sledesma
*/
class Generador extends CI_Controller {

	/**
	 * Constructor de Clase
	* @param 
	* @return 
	*/  
	function __construct(){

		parent::__construct();

		$this->load->model('general/Estructura/Generadores');
	}


	/**
	 *template obtiene los datos necesarios carga  la vista con ellos
	* @param 
	* @return view registrar_generadores
	*/  
	
	function templateGeneradores()
	{
				log_message('INFO','#TRAZA|Generador|templateGeneradores() >>'); 
				$data['departamentos'] = $this->Generadores->obtener_Departamentos();
				$data['Tipogenerador'] = $this->Generadores->obtener_Tipo_Generador();
				$data['Zonagenerador'] = $this->Generadores->obtener_Zonas();
				$data['Tiporesiduo'] = $this->Generadores->obtener_Tipo_residuo();
				$data['Rubro'] = $this->Generadores->obtener_Rubro();           
				$this->load->view('layout/Generadores/registrar_generadores',$data);
	}

	/**
	 *Guarda un generador nuevo dado de alta
	* @param 
	* @return string "ok","error"
	*/  
	function Guardar_Generador()
	{
			log_message('INFO','#TRAZA|Generador|Guardar_Generador() >>'); 
			$datos =  $this->input->post('datos');
			unset($datos['tica_id']);
			$datos_tipo_carga = $this->input->post('datos_tipo_carga');
			// guarda nuevo generador
			$sotr_id = $this->Generadores->Guardar_Generadores($datos); 			
			if ($sotr_id == null) {
				log_message('ERROR','#TRAZA|GENERADOR|Guardar_Generador(): NO GUARDO GENERADOR $sotr_id >> ERROR '.$sotr_id);
				return;
			} 
			//arma array con id de generador y tipos de carga
			foreach ($datos_tipo_carga as $key => $carga) {
				$tipocarga[$key]['sotr_id'] = $sotr_id;
				$tipocarga[$key]['tica_id'] = $carga;
			}
			// guarda tipos de carga asociado al generador
			$resp = $this->Generadores->guardar_tipo_carga($tipocarga);
			
			if($resp){
					echo "ok";
			}else{
					log_message('ERROR','#TRAZA|Generador|Guardar_Generador() >> $resp: '.$resp); 
					echo "error";
			}
	}
    

	/**
	*Lista los diferentes generadores que existen en la db
	* @param 
	* @return view Lista_Generadores
	*/  
	function Listar_Generador()
	{
			log_message('INFO','#TRAZA|Generador|Listar_Generador() >>'); 
			$data['generadores'] = $this->Generadores->Lista_generadores();
			
			$this->load->view('layout/Generadores/Lista_generadores',$data);
	}

	/**
	*Actualiza un generador en especifico 
	* @param 
	* @return string "ok","error"
	*/  
	function Actualizar_Generador()
	{
        log_message('INFO','#TRAZA|Generador|Actualizar_Generador() >>'); 
        $datos =  $this->input->post('generador');
				$datos_tipo_carga = $this->input->post('datos_tipo_carga');
				// actualiza los datos del generador
				$respGen = $this->Generadores->actualizar_Generador($datos);
				if ($respGen == null) {
					echo "error en actualizar generador";
					return;
				}
				// borra tipos de carga asociados
				$sotr_id = $datos['sotr_id'];
				$resTipoCarga = $this->Generadores->borrar_tipos_carga($sotr_id);
				if ($resTipoCarga == null) {
					echo "error en borrado tipos de carga";
					return;
				}

				//arma array con id de generador y tipos de carga				
				foreach ($datos_tipo_carga as $key => $carga) {
					$tipocarga[$key]['sotr_id'] = $sotr_id;
					$tipocarga[$key]['tica_id'] = $carga;
				}


				// guarda tipos de carga asociado al generador
				$resp = $this->Generadores->guardar_tipo_carga($tipocarga);
				
				if($resp){
						echo "ok";
				}else{
						log_message('ERROR','#TRAZA|Generador|Guardar_Generador() >> $resp: '.$resp); 
						echo "error";
				}
				
				
				
				
				
				// if($resp == 1){
        //     echo "ok";
        // }else{
        // log_message('ERROR','#TRAZA|Generador|Actualizar_Generador() >> $resp: '.$resp);
        // echo "error";
        // }
   }

   
  
    /**
    *Elimina un Genereador en especifico
    * @param 
    * @return string "ok","error"
    */  
    function Eliminar_Generador()
    {
        log_message('INFO','#TRAZA|Generador|Eliminar_Generador() >>');
        $resp = $this->Generadores->Borrar_Generador($this->input->post('elimina'));
        if($resp == 1){
            echo "ok";
        }else{
            log_message('ERROR','#TRAZA|Generador|Elimina_Generador() >> $resp: '.$resp); 
            echo "error";
        }

   }

     /**
   * otiene Zonas de un departamento determinado
   * @param int depa_id
   * @return json con zonas
   */
  public function obtener_Zona_departamento()
  {
	 $resp = $this->Generadores->obtener_Zona_departamento($this->input->post('depa_id'));
	 echo json_encode($resp);
	}

}
?>
