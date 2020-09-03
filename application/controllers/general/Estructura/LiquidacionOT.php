<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
		* Representa a la Entidad LiquidacionOT
		*
		* @autor SLedesma
		*/
		class LiquidacionOT extends CI_Controller 
	{

		/**
		* Constructor de clase
		* @param 
		* @return 
		*/
		function __construct()
		{
			parent::__construct();
			$this->load->model('general/Estructura/LiquidacionesOT');
        }

        /**
		* Carga pantalla Liquidacion De Ordenes de transporte
		* @param 
		* @return view LiquidacionOt
		*/
		function templateLiquidacion()
		{
			log_message('INFO','#TRAZA|LiquidacionOT|templateLiquidacion() >>');
			$data['transportistas'] = $this->LiquidacionesOT->getTransportistas();
			// $data["vehiculos"] = $this->Vehiculos->Listar_Vehiculo();
			// $data["transportista"] = $this->Vehiculos->Obtener_Transportista();
			// $data['Rsu'] = $this->Vehiculos->obtener_RSU();
			$this->load->view('layout/LiquidacionesOT/LiquidacionOt',$data);
		}

		function getDataLiquidacion()
		{	
			log_message('INFO','#TRAZA|LiquidacionOT|getDataLiquidacion() >>');
			$data['tran_id'] = $this->input->post('transportista');
			$data['fec_inicio'] = $this->input->post('fecha_inicio');
			$data['fec_final'] = $this->input->post('fecha_final');
			log_message('DEBUG','#TRAZA|LiquidacionOT|getDataLiquidacion(): >> DATA() '.json_encode($data));
			$resp = $this->LiquidacionesOT->getDataLiquidaciones($data);
			//construccion de arreglo que contiene los nombres de los generadores sin repetir para utilizarlo en vista y evitar sobre carga en el cliente
			$aux = array();
			for($i=0; $i < count($resp); $i++)
			{
				if(count($aux) == 0)
				{
					$aux[]=$resp[$i]->razon_social; 	
				}else{
					$a = 0;
					for($j=0;$j < count($aux); $j++)
					{
						if($resp[$i]->razon_social == $aux[$j])
						{
							$a = 1;
						}
					}
					if($a == 0)
					{
						$aux[] = $resp[$i]->razon_social;
					}
				}
				
			}
			$respuesta['generadores']=$aux; 
			$respuesta['datos'] = $resp;
			echo json_encode($respuesta);
		}

		// function GetTrasnportista()
		// {
		// 	$resp = $this->LiquidacionesOT->getTransportistas($this->input->post());
		// 	echo json_encode($resp);
		// }

        
    }

?>