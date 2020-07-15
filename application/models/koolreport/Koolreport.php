<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Koolreport extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function depurarJson($url)
    {
        $rsp = $this->rest->callApi('GET', $url);
        if ($rsp['status']) {
            $json = json_decode($rsp['data']);
        }
        log_message('DEBUG', '#TRAZA| #KOOLREPORT.PHP|#KOOLREPORT|#DEPURARJSON| #JSON: >>' . $json);
        return $json;
    }

    public function getPesosDeBascula(){

        $url = 'http://localhost:8080/bascula/pesajes';
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        $aux->pesajes->pesaje = $rsp->pesajes->pesaje;

        log_message('DEBUG', '#RECIDUOS| #KOOLREPORT.PHP|#KOOLREPORT|#GETPESOSDEBASCULA| #ARRAY: >>' . $aux);
        return $aux;
    }

    public function getFiltrosPesos()
    {

        $url = 'http://localhost:8080/zonas';
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        $aux = null;
        $i=0;
        foreach ($rsp->zonas->zona as $valor)
        {
            $aux[$i]->nombre = $valor->nombre;
            $aux[$i]->id = $valor->zona_id;
            $i++;
        }
        $data['filtro']->zonas = $aux;

        
        $url = 'http://localhost:8080/tablas/tipo_carga';
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        $aux = null;
        $i = 0;
        foreach ($rsp->valores->valor as $valor)
        {
            $aux[$i]->nombre = $valor->valor;
            $aux[$i]->id = $valor->tabl_id;
            $i++;
        }
        $data['filtro']->tipoCarga = $aux;


        $url = 'http://localhost:8080/solicitantesTransporte';
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        $aux = null;
        $i = 0;
        foreach ($rsp->solicitantesTransporte->solicitanteTransporte as $valor)
        {
            $aux[$i]->nombre = $valor->nombre;
            $aux[$i]->id = $valor->sotr_id;
            $i++;
        }
        $data['filtro']->solicitantesTransporte = $aux;
        

        $url = 'http://localhost:8080/transportistas';
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        $aux = null;
        $i = 0;
        foreach ($rsp->transportistas->transportista as $valor)
        {
            $aux[$i]->nombre = $valor->nombre;
            $aux[$i]->id = $valor->tran_id;
            $i++;
        }
        $data['filtro']->transportistas = $aux;
        

        $url = 'http://localhost:8080/contenedores';
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        $aux = null;
        $i = 0;
        foreach ($rsp->contenedores->contenedor as $valor)
        {
            $aux[$i]->nombre = $valor->codigo;
            $aux[$i]->id = $valor->cont_id;
            $i++;
        }
        $data['filtro']->contenedores = $aux;


        $url = 'http://localhost:8080/tablas/disposicion_final';
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        $aux = null;
        $i = 0;
        foreach ($rsp->valores->valor as $valor)
        {
            $aux[$i]->nombre = $valor->valor;
            $aux[$i]->id = $valor->tabl_id;
            $i++;
        }
        $data['filtro']->destinos = $aux;


        $data['op'] = "pesoDeBascula";
        log_message('DEBUG', '#RECIDUOS| #KOOLREPORT.PHP|#KOOLREPORT|#GETFILTROSPESOS| #ARRAY: >>' . $data);
        return $data;
    }

    public function getCantidadIncidencias($data)
    {
        return $data;
    }
    public function getIncidencias()
    {
        $url = "http://localhost:8080/incidencias";
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        $aux->incidencias->incidencia = $rsp->incidencias->incidencia;

        $a = $this->getCantidadIncidencias(count($aux->incidencias->incidencia));
        log_message('DEBUG', '#RECIDUOS| #KOOLREPORT.PHP|#KOOLREPORT|#GETINCIDENCIAS| #ARRAY: >>' . $aux);

        return $aux;
    }

    public function getFiltrosIncidencias()
    {
        $url = "http://localhost:8080/departamentos";
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        $aux = null;
        $i = 0;
        foreach ($rsp->departamentos->departamento as $valor)
        {
            $aux[$i]->nombre = $valor->nombre;
            $aux[$i]->id = $valor->id;
            $i++;
        }
        $data['filtro']->municipios = $aux;
        $data['cantidadMunicipios'] = $i;

        $url = "http://localhost:8080/tablas/tipo_incidencia";
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        $aux = null;
        $i = 0;
        foreach ($rsp->valores->valor as $valor)
        {
            $aux[$i]->nombre = $valor->valor;
            $aux[$i]->id = $valor->tabl_id;
            $i++;
        }
        $data['filtro']->tiposIncidencias = $aux;

        $url = 'http://localhost:8080/solicitantesTransporte';
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        $aux = null;
        $i = 0;
        foreach ($rsp->solicitantesTransporte->solicitanteTransporte as $valor)
        {
            $aux[$i]->nombre = $valor->nombre;
            $aux[$i]->id = $valor->sotr_id;
            $i++;
        }
        $data['filtro']->solicitantesTransporte = $aux;

        $url = 'http://localhost:8080/zonas';
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        $aux = null;
        $i=0;
        foreach ($rsp->zonas->zona as $valor)
        {
            $aux[$i]->nombre = $valor->nombre;
            $aux[$i]->id = $valor->zona_id;
            $i++;
        }
        $data['filtro']->zonas = $aux;
        $data['cantidadZonas'] = $i;

        $url = 'http://localhost:8080/transportistas';
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        $aux = null;
        $i = 0;
        foreach ($rsp->transportistas->transportista as $valor)
        {
            $aux[$i]->nombre = $valor->nombre;
            $aux[$i]->id = $valor->tran_id;
            $i++;
        }
        $data['filtro']->transportistas = $aux;

        log_message('DEBUG', '#RECIDUOS| #KOOLREPORT.PHP|#KOOLREPORT|#GETFILTROSINCIDENCIAS| #ARRAY: >>' . $data);

        return $data;
    }

    public function getIncidenciasPorTransportista($transportista)
    {
        $url = "http://localhost:8080/transportista/incidencias";
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        log_message('DEBUG', '#RECIDUOS| #KOOLREPORT.PHP|#KOOLREPORT|#GETINCIDENCIASPORTRANSPORTISTA|');
        return $rsp;
    }

    public function getMunicipios()
    {
        log_message('DEBUG', '#RECIDUOS| #KOOLREPORT.PHP|#KOOLREPORT|#GETMUNICIPIO');
        $url = 'http://localhost:8080/departamentos';
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        return $rsp;
    }

    public function getIncidenciasPorMunicipio()
    {
        $url = "http://localhost:8080/departamento/incidencias";
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        log_message('DEBUG', '#RECIDUOS| #KOOLREPORT.PHP|#KOOLREPORT|#GETINCIDENCIASPORMUNICIPIO|');
        return $rsp;
    }

    public function getIncidenciasPorZona()
    {
        $url = "http://localhost:8080/zona/incidencias";
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        log_message('DEBUG', '#RECIDUOS| #KOOLREPORT.PHP|#KOOLREPORT|#GETINCIDENCIASPORZONA|');
        return $rsp;
    }

    public function getFiltroMyA()
    {
        $aux["mes"] = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
        for($i = ANIO_BASE; $i <= date('Y'); $i++)
        {
            $aux["año"][$i - ANIO_BASE] = $i;
        }
        $data->filtro = $aux;
        return $data;
    }

    public function getToneladasPorTransportista()
    {
        $url = "http://localhost:8080/departamentos/pesajes";
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        log_message('DEBUG', '#RECIDUOS| #KOOLREPORT.PHP|#KOOLREPORT|#GETTONELADASPORTRANSPORTISTA|');
        return $rsp;
    }

    public function getToneladasPorGenerador()
    {
        $url = "http://localhost:8080/solicitantesTransporte";
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        log_message('DEBUG', '#RECIDUOS| #KOOLREPORT.PHP|#KOOLREPORT|#GETTONELADASPORGENERADOR|');
        return $rsp;
    }

    public function getToneladasPorResiduo()
    {
        $url = "http://localhost:8080/tipoDeCarga/porMunicipios";
        $rsp = $this->rest->callApi('GET', $url);
        $rsp = json_decode($rsp['data']);
        log_message('DEBUG', '#RECIDUOS| #KOOLREPORT.PHP|#KOOLREPORT|#GETTONELADASPORRESIDUO|');
        return $rsp;
    }

}
