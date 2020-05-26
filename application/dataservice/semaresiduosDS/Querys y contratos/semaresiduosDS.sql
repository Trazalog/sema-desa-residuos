http://dev-trazalog.com.ar:8280/services/semaresiduosDS
http://trazalog.com.ar:8280/services/semaresiduosDS
http://34.66.255.127:8280/services/semaresiduosDS
http://10.142.0.3:8280/services/semaresiduosDS

//TODO: TERMINAR ACTA INFRACCION(revisar todo, no esta en WSO2), EVACUAR DUDAS CON ELI
  - falta saber de donde sale el destino acta para elegir
  - inspectores seran usrs?

-- actaInfraccion(Tipo)
  recurso:/tablas/tipo_infraccion
  metodo: get
  
  -- ejemplo de respuesta
  {
    "valores":{
        "valor":[
          {
            "tabl_id": "tipo_infraccionInfraccion1",
            "valor": "Infraccion1",
            "valor2": "$valor2",
            "valor3": "$valor3",
            "descripcion": ""
          },
          {
            "tabl_id": "tipo_infraccionInfraccion2",
            "valor": "Infraccion2",
            "valor2": "",
            "valor3": "",
            "descripcion": ""
          }
        ]
    }
  }






-- actaInfraccionSet
  recurso: /actaInfraccion
  metodo: post
  insert into fis.actas_infraccion (numero_acta, descripcion, tipo, sotr_id, inspector_id, tran_id, destino, usuario_app) values(CAST(:numero_acta AS INTEGER), :descripcion, :tipo, CAST(:sotr_id AS INTEGER), CAST(:inspector_id AS INTEGER), CAST(:tran_id AS INTEGER), :destino, :usuario_app);

  {
    "_post_actainfraccion":{
      "numero_acta": "01",
      "descripcion": "acta infraccion por descargar caballo antes de ser mortadela",
      "tipo": "preventiva",
      "sotr_id": "1",
      "inspector_id": "10",
      "tran_id": "01",
      "destino": "PTA",
      "usuario_app": "hugoDS"
    }
  }

-- actaInfraccionGet
  recurso: /actaInfraccion
  metodo: get
  select acin_id, numero_acta, descripcion, tipo, sotr_id, inspector_id, tran_id, destino from fis.actas_infraccion where eliminado = 0;
  {
    "actas":{
      "acta":[  
        {
          "acin_id": "$acin_id",
          "numero_acta": "$numero_acta",
          "descripcion": "$descripcion",
          "tipo": "$tipo",
          "sotr_id": "$sotr_id",
          "inspector_id": "$inspector_id",
          "tran_id": "$tran_id",
          "destino": "$destino"
        }
      ]
    }
  }

-- actaInfraccionGetPorId
  recurso: /actaInfraccion/{acin_id}
  metodo: get
  select acin_id, numero_acta, descripcion, tipo, sotr_id, inspector_id, tran_id, destino from fis.actas_infraccion where eliminado = 0 and acin_id = CAST(:acin_id AS INTEGER);
  {
    "actas":{
      "acta":{
        "acin_id": "$acin_id",
        "numero_acta": "$numero_acta",
        "descripcion": "$descripcion",
        "tipo": "$tipo",
        "sotr_id": "$sotr_id",
        "inspector_id": "$inspector_id",
        "tran_id": "$tran_id",
        "destino": "$destino"
      }
    }
  }  


  {    
      "acta":{
        "acin_id": "$acin_id",
        "numero_acta": "$numero_acta",
        "descripcion": "$descripcion",
        "tipo": "$tipo",
        "sotr_id": "$sotr_id",
        "inspector_id": "$inspector_id",
        "tran_id": "$tran_id",
        "destino": "$destino"
      }    
  }  
 
-- actaInfraccionDelete
  recurso: /actaInfraccion
  metodo: post
  update fis.actas_infraccion set eliminado = 1 where acin_id = CAST(:acin_id AS INTEGER);

  {
    "put_actainfraccion":{
      "acin_id": "2"
    }
  }

-- actaInfraccionUpdate

  recurso: /actaInfraccion
  metodo: put
  update fis.actas_infraccion set numero_acta = CAST(:numero_acta AS INTEGER), descripcion = :descripcion, tipo = :tipo, :sotr_id = CAST(:sotr_id AS INTEGER) , inspector_id = CAST(:inspector_id AS INTEGER), tran_id = CAST(:tran_id AS INTEGER), destino = :destino where acin_id =  CAST(:acin_id AS INTEGER);

  {
    "_post_actaInfraccion":{
      "acin_id": "2",
      "numero_acta": "5",
      "descripcion": "acta infraccion por descargar caballo antes de ser mortadela",
      "tipo": "naa",
      "sotr_id": "1",
      "inspector_id": "11",
      "tran_id": "2",
      "destino": "PTA"
    }
  }

-- departamentosSet
	recurso: /departamentos
  metodo: post
  insert into core.departamentos (nombre, descripcion) values(:nombre, :descripcion);
	
	{
		"_post_departamentos":{
			"nombre": "Santa Lucia",
			"descripcion": "Depto Santa Lucia"
		}
	}
	-- resp
	{"respuesta": {"depa_id": "4"}}

-- departamentosGet
  recurso: /departamentos
  metodo: get
  select depa_id, nombre from core.departamentos

  {
    "departamentos":{
        "departamento":[
          {
              "depa_id":"$depa_id",
              "nombre":"$nombre"
          }
        ]
    }
  }


-- circuitosGet (listado de circuitos con tipo residuo, camion y chofer)
  recurso: /circuitos
  metodo: get
  
  select 
   C.circ_id, C.codigo, C.descripcion, C.chof_id, 
   C.zona_id, CONCAT(CH.apellido, ', ', CH.nombre) as chofer, C.vehi_id, E.dominio 
  from 
    log.circuitos C, log.choferes CH, core.equipos E
  where 
    C.vehi_id = E.equi_id 
  and   
    C.chof_id = CH.chof_id 
  and   
    C.eliminado = 0   
  ORDER BY C.circ_id
  
  {
   "circuitos":{
      "circuito":[
         {
            "circ_id":"$circ_id",
            "codigo":"$codigo",
            "descripcion":"$descripcion",            
            "chof_id":"$chof_id",
            "chofer": "$chofer", 
            "zona_id":"$zona_id",
            "vehi_id":"$vehi_id",            
            "dominio": "$dominio",
            "@tiposCargaCicuitoGet":"$circ_id->circ_id",
            "@puntosCriticos": "$circ_id->circ_id"
         }
      ]
    }
  }

  -- ejemplo get circuitos todos con tipo de carga
  
  {
    "circuitos": {"circuito": [
      {
          "descripcion": "circuito desampardos 1",
          "codigo": "212",
          "chof_id": "circuito desampardos 1",
          "circ_id": "57",
          "imagen": "circuito desampardos 1",
          "vehi_id": "21",
          "tiposCarga": {},
          "zona_id": null
      },    
      {
          "descripcion": "prueba23",
          "codigo": "37823",
          "chof_id": "prueba23",
          "circ_id": "94",
          "imagen": "prueba23",
          "vehi_id": "22",
          "tiposCarga": {"carga":       [
                      {
                "tica_id": "tipo_cargaEscombros",
                "valor": "Escombros"
            },
                      {
                "tica_id": "tipo_cargaResiduos Quimicos",
                "valor": "Residuos Quimicos"
            }
          ]},
          "zona_id": null
      },
      {
        "descripcion": "prueba1234",
        "codigo": "435436",
        "chof_id": "prueba1234",
        "circ_id": "97",
        "imagen": "prueba1234",
        "vehi_id": "21",
        "tiposCarga": {"carga":       [
                    {
              "tica_id": "tipo_cargaResiduos Patologicos",
              "valor": "Residuos Patologicos"
          },
                    {
              "tica_id": "tipo_cargaResiduos Quimicos",
              "valor": "Residuos Quimicos"
          }
        ]},
        "zona_id": null
      }
    ]
    }
  }

-- circuitosGetPorId
  recurso: /circuitos/{circ_id}
  metodo: get
  
  select circ_id, codigo, descripcion, imagen, chof_id, vehi_id, zona_id from log.circuitos where circ_id = CAST(:circ_id AS INTEGER)
  
  {
    "circuito":   
          {
            "circ_id": "$circ_id", 
            "codigo": "$codigo", 
            "descripcion": "$descripcion", 
            "imagen": "$imagen", 
            "chof_id": "$chof_id", 
            "vehi_id": "$vehi_id", 
            "zona_id": "$zona_id",
            "@tiposCargaCicuitoGet":"$circ_id->circ_id"           
          }  
  }

  -- ejemplo get circuito con tipo de carga

  {
    "circuito": {
      "descripcion": "licia",
      "codigo": "4354353244",
      "chof_id": "4",
      "circ_id": "93",
      "imagen": "",
      "vehi_id": "21",
      "tiposCarga": {
            "carga": 
                  [
                    {
                      "tica_id": "tipo_cargaEscombros",
                      "valor": "Escombros"
                    },
                    {
                      "tica_id": "tipo_cargaResiduos Quimicos",
                      "valor": "Residuos Quimicos"
                    }
                  ]
      },
      "zona_id": null
    }
  }

-- tiposCargaCircuitoGet
  recurso: 
  metodo: get
  select TCC.tica_id , T.valor
  from log.tipos_carga_circuitos TCC , core.tablas T
  where circ_id = CAST(:circ_id as INTEGER)
  and TCC.tica_id = T.tabl_id 

  {
    "tiposCarga":{
      "carga":[
        {
          "tica_id": "$tica_id",
          "valor": "$valor"
        }
      ]
    }
  }


-- circuitosSet
  recurso: /circuitos
  metodo: post
  insert into log.circuitos(codigo, descripcion, imagen, chof_id, vehi_id)
  values(:circ_id, :codigo, :descripcion, :imagen, :chof_id, :vehi_id)

  {
   "circuito":{     
      "codigo":"Circ AA-00",
      "descripcion":"desc circuito",
      "imagen":"",
      "usuario_app": "hugoDS",
      "chof_id":"2",
      "vehi_id":"21"     
   }
  } 

  {
    "respuesta": {
      "circ_id": "$circ_id"   // Necesita devolver id circ para asociar puntos criticos
    }
  }
  
-- circuitosSetTipoCarga
  recurso: /circuitos/tipoCarga
  metodo: post
  insert into log.tipos_carga_circuitos(circ_id, tica_id) values(CAST(:circ_id AS iNTEGER), :tica_id)
  {
    "circuito_carga":{
      "circ_id":"3",
      "tica_id":"tipo_cargaOrganico"
    }
  }

  recurso: /_post_circuitos_tipocarga_batch_req
  metodo: post
  {
    "_post_circuitos_tipocarga_batch_req":{
      "_post_circuitos_tipocarga":[
        {
          "circ_id":"3",
          "tica_id":"tipo_cargaOrganico"
        },
        {
          "circ_id":"3",
          "tica_id":"tipo_cargaEscombros"
        }
      ]
    }
  }

-- circuitosUpdateZona
  recurso: /circuitos/zonas
  metodo: put
  update log.circuitos set zona_id = CAST(:zona_id AS INTEGER)
  where circ_id = CAST(:circ_id AS INTEGER)

  {
    "circuito":{
      "zona_id": "5",
      "circ_id": "5"
    }
  }

-- circuitosGetPorZonaId

  recurso: /circuitos/{zona_id}
  metodo: get
  select circ_id, codigo, descripcion from log.circuitos where zona_id = :zona_id

  {
    "zonas":[
      "zona":
        {
          "cir_id": "$circ_id",
          "codigo": "$codigo",
          "descripcion": "$descripcion"
        }
    ]
  }


-- circuito->puntosPorCircuito
  recurso: /puntosCriticos/{circ_id}
  metodo: get

  select PC.nombre, PC.descripcion, PC.lat, PC.lng 
  from log.puntos_criticos PC, log.circuitos_puntos_criticos CPC
  where PC.pucr_id = CPC.pucr_id 
  and CPC.circ_id = CAST(:circ_id AS INTEGER)
  and CPC.eliminado = 0

  {
    "puntos":{
      "punto":[
        {          
          "nombre": "$nombre",
          "descripcion": "$descripcion",
          "lat": "$lat",
          "lng": "$lng"
        }
      ]
    }
  }


-- circuito->Puntos Criticos(deletePuntosPorCircuito) hacer que elimine fisicamete a relacion
  -- borra la relacion entre puntos criticos y  circuitos
    //FIXME: ARREGLAR RECURSO Y JSON NOMBRE
    recurso: /puntosCriticos/circuito
    metodo: delete
    -- update log.circuitos_puntos_criticos set eliminado = 1 where circ_id = CAST(:circ_id AS INTEGER) 

    delete from log.circuitos_puntos_criticos where circ_id = CAST(:circ_id AS INTEGER)
    
    {
      "_delete_circuitos_tipocarga":{
        "circ_id": "87"
      }
    }

-- circuito->Puntos Criticos (deletePuntosCriticos) 
  -- borra puntos criticos por circ_id
  recurso: /puntosCriticos
  metodo: delete
  
  delete from log.puntos_criticos PC
  using circuitos_puntos_criticos CPC
  where PC.pucr_id = CPC.pucr_id
  and CPC.circ_id = CAST(:circ_id AS INTEGER)



  {
      "":{
        "circ_id": "87"
      }
    }



-- circuitosSetTipoCarga
  recurso: /circuitos/tipoCarga
  metodo: post

  insert into log.tipos_carga_circuitos(circ_id, tica_id) values(CAST(:circ_id AS INTEGER), :tica_id);

  {
    "_post_circuitos_tipocarga":{
        "circ_id": "1",
        "tica_id": "tipo_cargaEscombros"
    }
  }

  -- batch request
  recurso: /_post_circuitos_tipocarga_batch_req
  metodo: post

  {
    "_post_circuitos_tipocarga_batch_req":{
      "_post_circuitos_tipocarga":[
        {
          "circ_id":"3",
          "tica_id":"tipo_cargaOrganico"
        },
        {
          "circ_id":"3",
          "tica_id":"tipo_cargaEscombros"
        }
      ]
    }
  }  

-- circuitosEstado ("borrado" se puede uasra para activar de nuevo pasando eliminado en 0)
  recurso: /circuitos/estado
  metodo: put

  update log.circuitos set eliminado = CAST(:eliminado AS BOOLEAN)
  where circ_id = CAST(:circ_id as INTEGER)
  -- ej de json contrato
  {
    "_put_circuitos_delete":{
      "circ_id": "118",
      "eliminado": "1"  // esto es fijo en este metodo
    }
  }


-- circuitoUpdate
  recurso: /circuitos
  metodo: put

  update log.circuitos set 
  codigo = sq.codigo, 
  descripcion = sq.descripcion,
  imagen = sq.imagen,
  usuario_app = sq.usuario_app , 
  chof_id = CAST(sq.chof_id as integer), 
  vehi_id = CAST(sq.vehi_id as integer), 
  zona_id = case when sq.zona_id = '' or sq.zona_id is null then null else cast(sq.zona_id as integer) end
  from (
    select :codigo codigo
            ,:descripcion descripcion
            ,:imagen imagen
            ,:usuario_app usuario_app
            ,:chof_id chof_id
            ,:vehi_id vehi_id 
            ,:zona_id zona_id) as sq
  where circ_id = CAST(:circ_id AS INTEGER)

  -- ejemplo de json contrato
  {
    "circuito":{ 
        "circ_id": "118",
        "codigo":"Circulito AA-00",
        "descripcion":"desc circuito",     
        "usuario_app": "hugoDS",
        "imagen": "",
        "chof_id":"2",
        "vehi_id":"21",
        "zona_id": ""
    }
  } 

-- circuitosGetImagen
  recurso: /circuitos/imagen/{circ_id}
  metodo: get
  select imagen from log.circuitos where circ_id = CAST(:circ_id AS INTEGER)
  {
    "circuito":{
      "imagen": "$imagen"
    }
  }


-- circuitoDeleteTipoCarga
  recurso: recurso: /circuitos/tipoCarga
  metodo: delete
  delete from log.tipos_carga_circuitos where circ_id = cast(:circ_id as integer)

  {
    "_delete_circuitos_tipocarga":{
      "circ_id": "94"
    }
  }




-- contenedoresGet (contenedor con tipo de carga por cont_id)
  recurso: /contenedores
  metodo: get
  
  select C.cont_id, C.codigo, C.descripcion, C.capacidad, C.anio_elaboracion, C.tara, C.habilitacion as habil_id, C.fec_alta, C.esco_id, C.reci_id, T.valor as estado, T2.valor as habilitacion 
  from log.contenedores C, core.tablas T, core.tablas T2
  where C.esco_id = T.tabl_id 
  and C.habilitacion = T2.tabl_id 

  {
    "contenedores":{
      "contenedor":
          [
            {
              "cont_id": "$cont_id",
              "codigo": "$codigo",
              "descripcion": "$descripcion",
              "capacidad": "$capacidad",
              "anio_elaboracion": "$anio_elaboracion",
              "tara": "$tara",
              "habil_id": "$habil_id",
              "fec_alta": "$fec_alta",
              "esco_id": "$esco_id",
              "reci_id": "$reci_id",          
              "estado": "$estado",
              "habilitacion": "$habilitacion"
              "@contenedoresGetTipoCargaPorId": "$cont_id->cont_id"
            }
          ]
    }
  }

-- contenedoresEstado
  recurso: /contenedores/estado
  metodo: put
  eliminado = "1" para borrar y "0" para activar nuevamente
  update log.contenedores 
  set eliminado = cast(:eliminado as INTEGER) 
  where cont_id = cast(:cont_id as INTEGER)

  {
    "_put_contenedores_estado":{
      "eliminado": "1",
      "cont_id": "45"
    }
  }





  -- ejempo de respuesta
    {"contenedores": {"contenedor": [
      {
      "descripcion": "Descripcion prueba 5",
      "codigo": "123123123",
      "estado": "INGRESADO",
      "habil_id": "habilitacion_contenedorBaja",
      "reci_id": "117",
      "tipos_carga": {},
      "habilitacion": "Baja",
      "tara": "15.0",
      "anio_elaboracion": "2020-02-12+00:00",
      "fec_alta": "2021-12-12+00:00",
      "esco_id": "estado_contenedorINGRESADO",
      "cont_id": "47",
      "capacidad": "14.0"
      },
          {
          "descripcion": "Descripcion",
          "codigo": "123123",
          "estado": "EN_TRANSITO",
          "habil_id": "habilitacion_contenedorBaja",
          "reci_id": "116",
          "tipos_carga": {"tipoCarga":       [
                      {
                "rsu": "Organico",
                "tica_id": "tipo_cargaOrganico",
                "cont_id": "46"
            },
                      {
                "rsu": "Escombros",
                "tica_id": "tipo_cargaEscombros",
                "cont_id": "46"
            }
          ]},
          "habilitacion": "Baja",
          "tara": "5.0",
          "anio_elaboracion": "2020-02-01+00:00",
          "fec_alta": "2020-12-12+00:00",
          "esco_id": "estado_contenedorEN_TRANSITO",
          "cont_id": "46",
          "capacidad": "6.0"
      },
          {
          "descripcion": "contenedor 1",
          "codigo": "123456",
          "estado": "Activo",
          "habil_id": "habilitacion_contenedorBaja",
          "reci_id": "113",
          "tipos_carga": {"tipoCarga": [      {
            "rsu": "Organico",
            "tica_id": "tipo_cargaOrganico",
            "cont_id": "43"
          }]},
          "habilitacion": "Baja",
          "tara": "158.2",
          "anio_elaboracion": "2020-03-21+00:00",
          "fec_alta": "2020-03-21+00:00",
          "esco_id": "estado_contenedorActivo",
          "cont_id": "43",
          "capacidad": "50.8"
      },
          {
          "descripcion": "Descripcion prueba 4",
          "codigo": "9203",
          "estado": "INGRESADO",
          "habil_id": "habilitacion_contenedorUso",
          "reci_id": "115",
          "tipos_carga": {"tipoCarga": [      {
            "rsu": "Escombros",
            "tica_id": "tipo_cargaEscombros",
            "cont_id": "45"
          }]},
          "habilitacion": "Uso",
          "tara": "11.0",
          "anio_elaboracion": "2019-01-01+00:00",
          "fec_alta": "2021-05-01+00:00",
          "esco_id": "estado_contenedorINGRESADO",
          "cont_id": "45",
          "capacidad": "5.0"
      },
          {
          "descripcion": "Descripcion prueba hugo",
          "codigo": "0",
          "estado": "INGRESADO",
          "habil_id": "habilitacion_contenedorUso",
          "reci_id": "118",
          "tipos_carga": {"tipoCarga": [      {
            "rsu": "Organico",
            "tica_id": "tipo_cargaOrganico",
            "cont_id": "48"
          }]},
          "habilitacion": "Uso",
          "tara": "11.0",
          "anio_elaboracion": "2019-01-01+00:00",
          "fec_alta": "2021-05-01+00:00",
          "esco_id": "estado_contenedorINGRESADO",
          "cont_id": "48",
          "capacidad": "5.0"
      },
          {
          "descripcion": "probando nuevo contenedor 112233",
          "codigo": "112233",
          "estado": "Activo",
          "habil_id": "habilitacion_contenedorUso",
          "reci_id": "114",
          "tipos_carga": {"tipoCarga": [      {
            "rsu": "Escombros",
            "tica_id": "tipo_cargaEscombros",
            "cont_id": "44"
          }]},
          "habilitacion": "Uso",
          "tara": "3000.0",
          "anio_elaboracion": "2020-03-01+00:00",
          "fec_alta": "2020-03-01+00:00",
          "esco_id": "estado_contenedorActivo",
          "cont_id": "44",
          "capacidad": "4500.0"
      }
    ]}}

-- contenedoresGetPorId (contenedor por cont_id con su tipo de carga por cont_id)
  recurso: /contenedores/{cont_id}
  metodo: get

  select C.cont_id, C.codigo, C.descripcion, C.capacidad, C.anio_elaboracion, C.tara, C.habilitacion as habil_id, C.fec_alta, C.esco_id, C.reci_id, T.valor as estado, T2.valor as habilitacion 
  from log.contenedores C, core.tablas T, core.tablas T2
  where C.esco_id = T.tabl_id 
  and C.habilitacion = T2.tabl_id
  and C.cont_id = CAST(:cont_id as INTEGER)

  -- ejemplo de json respuesta
  {
    "contenedor": {
      "descripcion": "Descripcion prueba hugo",
      "codigo": "0",
      "estado": "INGRESADO",
      "habil_id": "habilitacion_contenedorUso",
      "reci_id": "118",
      "tipoCarga":    {
          "rsu": "Organico",
          "tica_id": "tipo_cargaOrganico",
          "cont_id": "48"
      },
      "habilitacion": "Uso",
      "tara": "11.0",
      "anio_elaboracion": "2019-01-01+00:00",
      "fec_alta": "2021-05-01+00:00",
      "esco_id": "estado_contenedorINGRESADO",
      "cont_id": "48",
      "capacidad": "5.0"
    }
  }

  {"contenedor": 
    {
      "cont_id": "$cont_id",
      "codigo": "$codigo",
      "descripcion": "$descripcion",
      "capacidad": "$capacidad",
      "anio_elaboracion": "$anio_elaboracion",
      "tara": "$tara",
      "habil_id": "$habil_id",
      "fec_alta": "$fec_alta",
      "esco_id": "$esco_id",
      "reci_id": "$reci_id",
      "estado": "estado",
      "habilitacion": "$habilitacion", 
      "@contenedoresGetTipoCargaPorId": "$cont_id->cont_id"
    }
  }

-- contenedoresSet (alta contenedores)
  recurso: /contenedores
  metodo: post
  insert into log.contenedores(codigo, descripcion, capacidad, anio_elaboracion, tara, habilitacion, fec_alta, usuario_app, esco_id, tran_id)
  values(CAST(:codigo as INTEGER), :descripcion, CAST(:capacidad as float8), TO_DATE(:anio_elaboracion,'YYYY-MM-DD'), CAST(:tara as float8), :habilitacion, TO_DATE(:fec_alta,'YYYY-MM-DD'), :usuario_app, :esco_id, CAST(:tran_id as INTEGER))
  returning cont_id

  {"post_contenedor":
    {
      "codigo":"0000",
      "descripcion":"Descripcion prueba hugo",
      "capacidad":"5",
      "anio_elaboracion":"2019-01-01",
      "tara":"11",
      "esco_id":"estado_contenedorINGRESADO",
      "habilitacion":"habilitacion_contenedorUso",
      "fec_alta":"2021-05-01",
      "usuario_app":"hugoDS",
      "tran_id": "2"
      }
  }

  {"respuesta": {"cont_id": "8"}}

-- contenedoresTipoCarga (SET asociar tipo carga a contenedores son varios por contenedor)  
  -- usar este formato xq puede ser varios tipos de carga por contenedor
  recurso: /_post_contenedores_tipocarga_batch_req
  metodo: post 
  {
    "_post_contenedores_tipocarga_batch_req":{
        "_post_contenedores_tipocarga":[
              {
                "cont_id": "46",
                "tica_id": "tipo_cargaOrganico"
              },
              {
                "cont_id": "46",
                "tica_id": "tipo_cargaOrganico"
              }
        ]
    }
  }
  
  resurso: /contenedores/tipoCarga
  metodo: post

  insert into log.tipos_carga_contenedores(cont_id, tica_id) values(CAST(:cont_id AS INTEGER), :tica__id)
 
  {
    "_post_contenedores_tipocarga":{
      "cont_id": "46",
      "tica_id": "tipo_cargaOrganico"
    }
  }


-- contenedoresTipoCargaEstado (borrado logico asociar tipo carga a contenedores) 
  recurso: /contenedores/tipoCarga/estado
  metodo: put

  update log.tipos_carga_contenedores set eliminado = CAST(:eliminado AS iNTEGER)
  where cont_id = CAST(:cont_id as INTEGER)


  -- ej de json contrato
  {
    "_put_contenedores_tipocarga_estado":{
      "cont_id": "48",
      "eliminado": "1"  // esto es fijo en este metodo
    }
  }

-- contenedoresGetTipoCargaPorId

  recurso: no hay recurso programado se llama solo la query desde otros metodos
  metodo: 

  select C.cont_id, C.tica_id, T.valor as rsu
  from 
    log.tipos_carga_contenedores C, core.tablas T
  where 
    C.tica_id = T.tabl_id 
  and  
    cont_id = CAST(:cont_id as INTEGER)
  and C.eliminado = 0  

  { 
    "tipos_carga":{
        "tipoCarga":[
          {
            "cont_id": "$cont_id",
            "tica_id": "$tica_id",
            "rsu": "$rsu"
          }
        ]
    }
  }

-- contenedoresUpdate (edicion de contenedores)

  -- instrucciones
  1- recurso: /contenedores/tipoCarga/estado (borrado de tipos de carga)
     metodo: put
  2- recurso:/contenedores (actuaizar info contenedores)
     metodo: put
  3- recurso: /_post_contenedores_tipocarga_batch_req
     metodo: post

  recurso:/contenedores
  metodo: put

  update log.contenedores 
  set codigo = CAST(:codigo as INTEGER), descripcion = :descripcion, capacidad = CAST(:capacidad as float8), tara = CAST(:tara as float8), habilitacion = :habilitacion, usuario_app = :usuario_app, esco_id = :esco_id, anio_elaboracion = TO_DATE(:anio_elaboracion,'YYYY-MM-DD')
  where cont_id = CAST(:cont_id as INTEGER)


  {"put_contenedor":
    {
      "cont_id": "46",
      "codigo":"0000",
      "descripcion":"Descripcion prueba hugo",
      "capacidad":"5",
      "tara":"11",
      "habilitacion":"habilitacion_contenedorUso",
      "usuario_app":"hugoDS",
      "esco_id":"estado_contenedorINGRESADO",
      "anio_elaboracion":"2019-01-01"
    }
  }

 
//TODO: REVISAR ESTO POR LA MULTIPICIDAD DE RESIDUOS QUE LLEVA CADA CONTENEDOR
-- contenedoresGetPorTransp (contenedores por transporte y tipo de residuo agrupado por tipo de residuo)

  recurso: /contenedores/transportista/{tran_id}
  metodo: get    

  select 
    C.cont_id, C.codigo, C.descripcion, C.capacidad, C.tara, C.reci_id, 
    T.valor as estado, 
    T2.valor as habilitacion, 
    TCC.tica_id, 
    T3.valor as rsu
  from 
    log.contenedores C, core.tablas T, core.tablas T2, core.tablas T3, log.tipos_carga_contenedores TCC
  where 
      C.esco_id = T.tabl_id 
  and C.cont_id = TCC.cont_id 
  and TCC.tica_id = T3.tabl_id 
  and C.habilitacion = T2.tabl_id 
  -- por transportista
  and C.tran_id = CAST(:tran_id  as INTEGER)
  -- agrupados por tipo de carga
   group by TCC.tica_id, C.cont_id, T.valor, T2.valor, T3.valor

   {
    "contenedores": {
        "contenedor": [
            {
              "cont_id": "$cont_id",
              "codigo": "$codigo",
              "descripcion": "$descripcion",
              "capacidad": "$capacidad",
              "tara": "$tara"
              "reci_id": "$reci_id",
              "estado": "$estado",
              "habilitacion": "$habilitacion"
              "tica_id": "$tica_id",
              "rsu": "$rsu"
            }
        ]
        }
  }

-- contEntregadosSet
  recurso: /contEntregados
  metodo: post
  insert into log.contenedores_entregados(porc_llenado, mts_cubicos, fec_entrega, usuario_app, cont_id, soco_id, ortr_id, tica_id)
  values(CAST(:porc_llenado AS float8), CAST(:mts_cubicos AS float8), TO_DATE(:fec_entrega, 'YYYY-MM-DD'), :usuario_app, CAST(:cont_id AS INTEGER), CAST(:soco_id AS INTEGER), CAST(:ortr_id AS INTEGER), :tica_id) returning coen_id
  
  {
    "contenedor":{
        "porc_llenado":"50.40",
        "mts_cubicos":"120.50",
        "fec_entrega":"2020-02-10",
        "usuario_app":"hugoDs",
        "cont_id":"7",
        "soco_id":"1",
        "ortr_id":"1",
        "tica_id":"tipo_cargaOrganico"   
    }
  }
  
  {
    "respuesta":{
      "coen_id": "$coen_id"
    }
  }
 
-- contenedoresEntregados  (por soco_id)
  recurso: /contenedoresEntregados/{soco_id}
  metodo: get

  select COUNT(CE.coen_id) as cant_entregados, CE.tica_id, T.valor 
	from log.contenedores_entregados CE, core.tablas T
	where CE.soco_id = :soco_id and CE.tica_id = T.tabl_id
	group by CE.tica_id, T.valor

  {
    "contenedores":{
      "contenedor":[
        {
          "cant_entregados": "$cant_entregados",
          "tica_id": "$tica_id",
          "valor": "$valor"
        }
      ]
    }
  }

-- contenedoresEntregados (todos con camion y residuos para tabla entregas anteriores)
  recurso: /contenedoresEntregados/todos
  metodo: get
  select CE.porc_llenado, CE.fec_retiro, T.valor, CE.tica_id, E.dominio, CONCAT(CH.apellido, ', ', CH.nombre) as chofer  
	from log.contenedores_entregados CE, log.ordenes_transporte OT, core.equipos E, log.choferes CH, core.tablas T
	where CE.ortr_id = OT.ortr_id 
	and OT.equi_id = E.equi_id 
	and OT.chof_id = CH.documento 
	and CE.tica_id = T.tabl_id 

  {
    "contenedoresEntregados": {
      "contenedores": [
        {
        "porc_llenado": "$porc_llenado",
        "fec_retiro": "$fec_retiro",
        "rsu": "$valor",
        "tica_id": "$tica_id",
        "dominio": "$dominio",
        "chofer": "$chofer"
        }
      ]
    }
  }

-- contenedoresEntregadosPorTicaId (contenedores entregados por tipo de carga y usuario_app)
  recurso: /contenedoresEntregados/tipocarga/tipo_cargaOrganico/usr/hugoDS
  metodo: post
  select C.cont_id, C.codigo, C.descripcion
  from log.contenedores C, log.contenedores_entregados CE  
  where C.cont_id = CE.cont_id
  and CE.ortr_id is null 
  and CE.tica_id = :tica_id	
  and CE.usuario_app = :usuario_app
  
  {
    "contenedores":{
      "contenedor":[
        {
          "cont_id": "$cont_id",
          "codigo": "$codigo",
          "descripcion": "$descripcion"
        }
      ]
    }
  }

  -- ej contrato
  {
    "_post_contenedores_tipocarga":{
      "tica_id": "tipo_cargaOrganico",
      "usuario_app": "hugoDS"
    }
  }

  -- ej respuesta
  {"contenedores": 
      {
        "contenedor": [
          {
            "descripcion": "probando nuevo contenedor 112233",
            "codigo": "112233",
            "cont_id": "44"
          }
        ]}}


-- contenedoresSolicitadosGet (/solicitudContenedores/{usuario_app}, para pantalla entrega contenedores tambien)
  recurso: /contnedoresSolicitados/{soco_id}
  metodo: get

  select 
  CS.coso_id, CS.cantidad, CS.otro, CS.fec_alta, CS.tica_id, CS.soco_id, coalesce (CS.cantidad_acordada, null, 0) as cantidad_acordada, CS.reci_id, T.valor as rsu from log.contenedores_solicitados CS, core.tablas T
  where CS.tica_id = T.tabl_id 
  and soco_id = CAST(:soco_id as INTEGER)


   {
    "contSolicitados":{
      "contenedor":[
        {
          "coso_id": "$coso_id", 
          "cantidad": "$cantidad", 
          "otro": "$otro", 
          "fec_alta": "$fec_alta", 
          "tica_id": "$tica_id",
          "soco_id": "$soco_id",
          "valor": "$rsu",
          "cantidad_acordada": "$cantidad_acordada",
          "reci_id": "$reci_id" 
        }
      ]
    }  
  }


-- choferesGet
  recurso: /choferes
  metodo: get  
  select CH.chof_id, CH.nombre, CH.apellido, CH.documento, CH.fec_nacimiento, CH.direccion, 
      CH.celular, CH.codigo, CH.carnet as carn_id, CH.vencimiento, 
      CH.habilitacion, CH.tran_id, CH.cach_id,
      T.razon_social,
      TCAR.valor as carnet, 
      TCAT.valor as categoria
    from log.choferes CH, log.transportistas T, core.tablas as TCAR, core.tablas as TCAT
    where CH.tran_id = T.tran_id 
    and CH.carnet = TCAR.tabl_id 
    and CH.cach_id = TCAT.tabl_id 
    and CH.eliminado = 0 

    {
      "choferes":{
          "chofer":[
            {
              "chof_id": "$chof_id", 
              "nombre": "$nombre", 
              "apellido": "$apellido", 
              "documento": "$documento", 
              "fec_nacimiento": "$fec_nacimiento", 
              "direccion": "$direccion", 
              "celular": "$celular", 
              "codigo": "$codigo", 
              "carn_id": "$carn_id", 
              "vencimiento": "$vencimiento", 
              "habilitacion": "$habilitacion",              
              "tran_id": "$tran_id", 
              "cach_id": "$cach_id",
              "razon_social": "$razon_social",
              "carnet": "$carnet",
              "categoria": "$categoria"
            }
          ]
      }    
    }

-- choferesGetPorTransportistas
  recurso: /choferes/{tran_id}
  metodo: get
  select concat(apellido, ', ',nombre) from log.choferes 
  where tran_id = :tran_id

  {
    "choferes":{
      "chofer":[
        {
          "chof_id": "$chof_id",
          "nombre": "$nombre",
          "apellido": "$apellido"
        }
      ]
    }
  }

-- choferesSet
  recurso: /choferes
  metodo: post
  insert into log.choferes(nombre, apellido, documento, fec_nacimiento, direccion, celular, codigo, carnet, vencimiento, habilitacion, imagen, tran_id, cach_id, usuario_app)
  values(:nombre, :apellido, :documento, TO_DATE(:fec_nacimiento,'YYYY-MM-DD'), :direccion, CAST(:celular AS INTEGER), CAST(:codigo AS INTEGER), :carnet, TO_DATE(:vencimiento,'YYYY-MM-DD'), :habilitacion, :imagen, CAST(:tran_id AS INTEGER), :cach_id, :usuario_app)
  returning chof_id  

  {
    "_post_choferes":{
      "nombre": "Ruben", 
      "apellido": "Juarez", 
      "documento": "20202020" , 
      "fec_nacimiento": "1970", 
      "direccion": "Calle lemos 123", 
      "celular": "155555555", 
      "codigo": "789", 
      "carnet": "232145", 
      "vencimiento": "2020-11-05", 
      "habilitacion": "residuo patologico", 
      "imagen": "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN",
      "tran_id": "2", 
      "cach_id": "A1, A2"
    }
  }

  {"respuesta":{
      "chof_id": "$chof_id"
    }
  }

-- choferesUpdate
  recurso: /choferes
  metodo: put
   
  update log.choferes
  set nombre=:nombre, apellido=:apellido, documento=:documento, fec_nacimiento=TO_DATE(:fec_nacimiento,'YYYY-MM-DD'), direccion=:direccion, celular=CAST(:celular AS INTEGER), codigo=CAST(:codigo AS INTEGER), carnet=:carnet, vencimiento=TO_DATE(:vencimiento,'YYYY-MM-DD'), habilitacion=:habilitacion, imagen = :imagen, tran_id=CAST(:tran_id AS INTEGER), cach_id=:cach_id, usuario_app = :usuario_app 
  where chof_id = CAST(:chof_id AS INTEGER)

   {
     "chofer":{
       "nombre": "Bruno",
       "apellido": "Gelbert",
       "documento": "18887911",
       "fec_nacimiento": "1945-10-21",
       "direccion": "Calle Lemos 333",
       "celular": "1666555",
       "codigo": "321",
       "carnet": "45689", 
       "vencimiento": "2020-10-05",
       "habilitacion": "residuos equinos",
       "imagen": "",
       "tran_id": "2",
       "cach_id": "A1,A2,A3",
       "chof_id": "6",
      "usuario_app"
     }
   }


-- choferesGetImagen
  recurso: /choferes/imagen/{chof_id}
  metodo: get
  select imagen from log.choferes where chof_id = CAST(:chof_id AS INTEGER)
  {
    "choferes":{
      "imagen": "$imagen"
    }
  }

-- choferesUpdateImagen
  recurso: /choferes/update/imagen
  metodo: get

    update 
    log.choferes
    set imagen = :imagen
    where chof_id = CAST(:chof_id AS INTEGER)

    {
      "choferes":{
        "chof_id": "6",
        "imagen": "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN"
      }
    }

-- choferesDelete
  recurso: /choferes
  metodo: delete
  
    update 
    log.choferes 
    set eliminado = 1
    where chof_id = CAST(:chof_id AS INTEGER)

    {
      "_delete_choferes":{
          "chof_id":"2"          
      }
    }


-- contenedoresEntregaSet 

  recurso: /entregaContenedores
  metodo: post

  insert into log.contenedores_entregados(fec_entrega, cont_id, usuario_app, soco_id, tica_id )
  values(TO_DATE(:fec_entrega, 'YYYY-MM-DD'), CAST(:cont_id as INTEGER), :usuario_app, CAST(:soco_id AS INTEGER), :tica_id)
  returning coen_id


  -- ejemplo

    {
      "_post_contenedores_entrega_batch_req":{
          "_post_contenedores_entrega":[
            {
              "fec_entrega": "2020-04-02",
              "cont_id": "43",
              "usuario_app": "hugoDS",
              "soco_id": "2",
              "tica_id": "tipo_cargaOrganico"
            },
            {
              "fec_entrega": "2020-04-02",
              "cont_id": "44",
              "usuario_app": "hugoDS",
              "soco_id": "2",
              "tica_id": "tipo_cargaOrganico"
            },
            {
              "fec_entrega": "2020-04-02",
              "cont_id": "43",
              "usuario_app": "hugoDS",
              "soco_id": "2",
              "tica_id": "tipo_cargaOrganico"
            }
          ]
      }
    }


    {
      "_post_contenedores_entrega":{
          "fec_entrega": "2020-04-02",
          "cont_id": "43",
          "usuario_app": "hugoDS",
          "soco_id": "2",
          "tica_id": "tipo_cargaOrganico"
      }
    }







-- (generadores)solicitanteTransporteGet
  recurso: /solicitantesTransporte
  metodo: get
  select sotr_id, razon_social, cuit, domicilio, num_registro, lat, lng, zona_id, rubr_id, tist_id, tica_id
  from log.solicitantes_transporte
  where eliminado = 0

  {
    "solicitantes_transporte": {
        "solicitante": [
          {
            "sotr_id": "$sotr_id",
            "razon_social": "$razon_social",
            "cuit": "$cuit",
            "domicilio": "$domicilio",
            "num_registro": "$num_registro",
            "lat": "$lat",
            "lng": "$lng",
            "zona_id": "$zona_id",
            "rubr_id": "$rubr_id",
            "tist_id": "$tist_id",
            "tica_id": "$tica_id"	            
          }
        ]
    }
  }

-- (generadores)solicitanteTransporteGet(por soco_id)

  recurso: /solicitantesTransporte/{soco_id}
  metodo: get

  select 
		razon_social, domicilio from log.solicitantes_transporte ST, log.solicitudes_contenedor SC
	where 
		ST.sotr_id = SC.sotr_id and 
		SC.soco_id = cast(:soco_id as integer)

  {
    "solicitante":{
      "razon_social": "$razon_social",
      "domicilio": "$domicilio"
    }
  }

  -- ejemplo de respuesta del servicio
  {"solicitante": {
    "domicilio": "Calle Mr. ED 45",
    "razon_social": "Residuos Caballos Salvajes"
  }}

-- (generadores)solicitanteTransportePorUsuario  
  recurso: /solicitantesTransporte/{usuario_app}  (ej: /solicitantesTransporte/hugoDS)
  metodo: get
  select ST.sotr_id, ST.razon_social, ST.cuit, ST.domicilio, ST.num_registro, ST.lat, ST.lng, ST.zona_id, ST.rubr_id, ST.tist_id, ST.tica_id, D.nombre as depa_nom
  from log.solicitantes_transporte ST, core.departamentos D 
  where usuario_app = :usuario_app 
  and ST.depa_id = D.depa_id 

  {
    "solicitantes_transporte": {
        "solicitante": [
          {
            "sotr_id": "$sotr_id",
            "razon_social": "$razon_social",
            "cuit": "$cuit",
            "domicilio": "$domicilio",
            "num_registro": "$num_registro",
            "lat": "$lat",
            "lng": "$lng",
            "zona_id": "$zona_id",
            "rubr_id": "$rubr_id",
            "tist_id": "$tist_id",
            "tica_id": "$tica_id",
            "depa_nom": "$depa_nom"	            
          }
        ]
    }
  }

-- (generadores)solicitanteTransporteSet
  recurso: /solicitantesTransporte
  metodo: post
  insert into log.solicitantes_transporte(razon_social, cuit, domicilio, num_registro, lat, lng, usuario_app, zona_id, rubr_id, tist_id, tica_id)
  values(:razon_social, :cuit, :domicilio, :num_registro, :lat, :lng, :usuario_app, :zona_id, :rubr_id, :tist_id, :tica_id)

	{
	   "solicitante_transporte":{
	      "razon_social":"Residuos Caballo Salvaje",
	      "cuit":"2022222229",
	      "domicilio":"Calle Mr. ED 45",
	      "num_registro":"123456",
	      "lat":"0.456",
	      "lng":"0.789",
	      "usuario_app": "hugoDS",
	      "zona_id":"4",
	      "rubr_id":"PRUEBATITOte",
	      "tist_id": "tipos_solicitantes_transporteMunicipio",
        "tica_id": "tipos_cargaResiduos Tecnologicos"
	   }
	}
-- (generadores)solicitanteTransporteUpdate
  recurso: /solicitantesTransporte
  metodo: put
  update 
  log.solicitantes_transporte 
  set 
  razon_social=:razon_social, cuit=:cuit, domicilio = :domicilio, num_registro=:num_registro, lat=:lat, lng=:lng, usuario_app=:usuario_app, zona_id=CAST(:zona_id AS INTEGER), rubr_id=:rubr_id, tist_id=:tist_id, tica_id=:tica_id
  where (sotr_id=CAST(:sotr_id AS INTEGER))

  {
   "solicitante_transporte":{
      "sotr_id":"1",
      "razon_social":"Residuos Caballos Salvajes",
      "cuit":"2022222229",
      "domicilio":"Calle Mr. ED 45",
      "num_registro":"123456",
      "lat":"0.456",
      "lng":"0.789",
      "usuario_app":"hugoDS",
      "zona_id":"4",
      "rubr_id":"PRUEBATITOte",
      "tist_id":"tipos_solicitantes_transporteMunicipio",
      "tica_id":"tipos_cargaResiduos Tecnologicos"
   }
  }

-- (generadores)solicitanteTransporteEstado (habilitar/deshabilitar)
  recurso: /solicitantesTransporte/estado
  metodo: put
  update 
  log.solicitantes_transporte 
  set eliminado = CAST(:eliminado AS INTEGER)
  where sotr_id = CAST(:sotr_id AS INTEGER)

  {
    "estado_nuevo":{
        "sotr_id":"1",
        "eliminado": "0"
    }
  }
   
-- inspectoresGet
  //TODO: CONDICIONAL
  recurso: /inspectores
  metodo: get
  
  select id, first_name, last_name from users where role='inspector' and banned_users ='unband';

  {
    "inspectores":{
      "inspector":[
        {
          "id": "$id",
          "nombre": "first_name",
          "apellido": "last_name"
        },
        {
          "id": "$id",
          "nombre": "first_name",
          "apellido": "last_name"
        },
        {
          "id": "$id",
          "nombre": "first_name",
          "apellido": "last_name"
        }
      ]
    }
  }

  --respuesta ejemplo
  {
    "inspectores":{
      "inspector":[
        {
          "id": "1",
          "nombre": "Luis",
          "apellido": "Suarez"
        },
        {
          "id": "2",
          "nombre": "Esteban",
          "apellido": "Quito"
        },
        {
          "id": "3",
          "nombre": "Benito",
          "apellido": "Camela"
        }
      ]
    }
  }



-- lotes -- getLotetodos
  recurso: /lote/todos/deposito
   metodo: get
  select reci_id, nombre from prd.recipientes where tipo = 'DEPOSITO' and estado = 'VACIO'

  {
    "recipientes":
          {"recipiente":
            [
              {
              "reci_id": "$reci_id",
              "nombre":"$nombre"
              }          
            ]
          }
  }

-- puntosCriticosCircuitosset
  recurso: /puntosCriticos/circuito
  metodo: post

  insert into log.circuitos_puntos_criticos (circ_id, pucr_id) values(CAST(:circ_id AS INTEGER), CAST(:pucr_id AS INTEGER));
  
  {
    "_post_puntoscriticos_circuito":{
      "circ_id": "1",
      "pucr_id": "6"
    }
  }  

  -- batch request (no se usa porq siempre debe tener el id de pto critico nuevo)
  recurso: /_post_puntoscriticos_circuito_batch_req
  metodo: post

  {
    "_post_puntoscriticos_batch_req": {
      "_post_puntoscriticos_circuito":[
        {
          "circ_id": "1",
          "pucr_id": "3"
        },
        {
          "circ_id": "1",
          "pucr_id": "6"
        },
        {
          "circ_id": "1",
          "pucr_id": "7"
        }
      ]
    }
  }



-- puntosCriticosGet
  recurso: /puntosCriticos
  metodo: get
  select nombre, descripcion, lat, lng, zona_id from log.puntos_criticos  

  {"puntos_criticos":
    {
      "punto":[
          {
            "nombre": "$nombre",
            "descripcion": "$descripcion",
            "lat": "$lat",
            "lng": "$lng",
            "zona_id": "$zona_id"
          }     
      ]
    }
  } 

-- puntosCriticosGetId
  recurso: /puntosCriticos/nombre/{nombre}
  metodo: get

  select pucr_id from log.puntos_criticos where nombre = :nombre

  {
    "respuesta":{
      "pucr_id": "163"
    }
  }


-- puntosCriticosSet
  recurso: /puntosCriticos
  metodo: post
  insert into log.puntos_criticos (nombre, descripcion, lat, lng, usuario_app, zona_id) 
  values(:nombre, :descripcion, :lat, :lng, :usuario_app,cast(:zona_id as INTEGER))
  returning pucr_id

  {
    "post_puntos_criticos":{
      "nombre": "Puesto critico 3", 
      "descripcion": "probable descarga de vidrio", 
      "lat": "-31.5555", 
      "lng": "-31.8989", 
      "usuario_app": "hugoDs"
    }
  } 

  {
    "respuesta":{
      "pucr_id": "$pucr_id"
    }
  }
  -- batch request de puntos criticos (//FIXME: NO VA A GUARDAR PORQ RETORNA $pucr_id)
  recurso: /_post_puntoscriticos_batch_req
  metodo: post
  {
    "_post_puntoscriticos_batch_req": {
      "post_puntocritico": [
        {
          "nombre": "245245",
          "descripcion": "23523",
          "lat": "325235",
          "lng": "2352",
          "usuario_app": "almacen.tools"
        },
        {
          "nombre": "34436",
          "descripcion": "34345",
          "lat": "34534",
          "lng": "345345",
          "usuario_app": "almacen.tools"
        }
      ]
    }
  }

-- puntosCriticosEstados
    recurso: /puntosCriticos/estado
    metodo: put
    update 
    log.puntos_criticos 
    set eliminado = CAST(:eliminado AS INTEGER)
    where pucr_id = CAST(:pucr_id AS INTEGER) and eliminado = 'false'

    {
      "estado_nuevo":{
          "pucr_id":"2",
          "eliminado":"1"
      }
    }

-- puntosCriticosUpdate
    recurso: /puntosCriticos
    metodo: put
    update log.puntos_criticos set nombre=:nombre, descripcion=:descripcion, lat=:lat, lng=:lng, usuario_app=:usuario_app,zona_id=cast(:zona_id as INTEGER)
    where pucr_id = CAST(:pucr_id AS INTEGER)

    {
      "puntos_criticos":{
        "pucr_id": "1",
        "nombre": "Puesto critico 3", 
        "descripcion": "probable descarga de vidrio", 
        "lat": "-31.5555", 
        "lng": "-31.8989", 
        "usuario_app": "hugoDs", 
        "zona_id": "5"
      }
    }



-- solicitudContenedorSet(guardado de la cabecera de contenedores pedidos)
  recurso: /solicitudContenedor
  metodo: post
  insert into log.solicitudes_contenedor(estado, observaciones, usuario_app, sotr_id) values(:estado, :observaciones, :usuario_app, cast(:sotr_id as INTEGER))

  {
    "_post_solicitudcontenedor":{
      "estado": "SOLICITADA", 
      "observaciones": "observaciones test", 
      "usuario_app": "HugoDS", 
      "sotr_id": "1"
    }
  }

-- solicitudContenedorTipoCarga(guardado de contenedores pedidos con tipo carga)
  recurso: /solicitudContenedor/tipoCarga
  metodo: post
  insert into log.contenedoresSolicitados(cantidad, otro, usuario_app, tica_id, soco_id) values(CAST(:cantidad AS INTEGER), :otro, :usuario_app, :tica_id, CAST(:soco_id AS INTEGER))

  {
    "_post_solicitudcontenedor_tipocarga":{
      "cantidad": "1", 
      "otro": "", 
      "usuario_app": "hugoDS", 
      "tica_id": "tipos_cargaResiduos Patologicos", 
      "soco_id": "2"
    }
  }

  -- BATCH REQUEST
    recurso: /_post_solicitudcontenedor_tipocarga_batch_req
    metodo: post
    {
      "_post_solicitudcontenedor_tipocarga_batch_req":{
        "_post_solicitudcontenedor_tipocarga":[
            {
              "cantidad": "1", 
              "otro": "", 
              "usuario_app": "hugoDS", 
              "tica_id": "tipos_cargaResiduos Patologicos", 
              "soco_id": "2"
            },
            {
              "cantidad": "1", 
              "otro": "", 
              "usuario_app": "hugoDS", 
              "tica_id": "tipos_cargaResiduos Patologicos", 
              "soco_id": "2"
            },
            {
              "cantidad": "1", 
              "otro": "", 
              "usuario_app": "hugoDS", 
              "tica_id": "tipos_cargaResiduos Patologicos", 
              "soco_id": "2"
            }
        ]
      }
    }

-- solicitudContenedorProximo(numero automatico de nueva solicitud de contenedor)
    recurso: /solicitudContenedor/prox
    metodo: get
    select COALESCE(NULL,(max(soco_id) + 1), 1) as nuevo_soco_id from log.solicitudes_contenedor

    {"respuesta": {"nuevo_soco_id": "3"}}

-- solicitudContenedorGet  
  
  recurso: /solicitudContenedores/{usuario_app}
  metodo: get

  select soco_id, estado, observaciones, fec_alta, sotr_id from log.solicitudes_contenedor SC where usuario_app = :usuario_app  // donde usuario_app es el "generador" ver como resolverlo

  {
    "sol_cont":{
      "soco_id": "$soco_id", 
      "estado": "$estado", 
      "observaciones": "$observaciones", 
      "fec_alta": "$fec_alta", 
      "sotr_id": "$sotr_id",
      "@contenedoresSolicitadosGet": "$soco_id->soco_id"
    }
  }

  -- ejemplo de json respuesta del servicio
  {"sol_cont": {
   "estado": "SOLICITADA",
   "contSolicitados": {"contenedor":    [
            {
         "reci_id": null,
         "otro": "",
         "fec_alta": "2020-03-19+00:00",
         "tica_id": "tipos_cargaResiduos Patologicos",
         "valor": "Residuos Patologicos",
         "coso_id": "5",
         "cantidad_acordada": "3",
         "cantidad": "4",
         "soco_id": "2"
      },
            {
         "reci_id": null,
         "otro": "",
         "fec_alta": "2020-03-19+00:00",
         "tica_id": "tipos_cargaResiduos Patologicos",
         "valor": "Residuos Patologicos",
         "coso_id": "4",
         "cantidad_acordada": "6",
         "cantidad": "6",
         "soco_id": "2"
      },
            {
         "reci_id": null,
         "otro": "",
         "fec_alta": "2020-03-19+00:00",
         "tica_id": "tipos_cargaResiduos Patologicos",
         "valor": "Residuos Patologicos",
         "coso_id": "3",
         "cantidad_acordada": "8",
         "cantidad": "11",
         "soco_id": "2"
      },
            {
         "reci_id": null,
         "otro": "",
         "fec_alta": "2020-03-19+00:00",
         "tica_id": "tipos_cargaResiduos Patologicos",
         "valor": "Residuos Patologicos",
         "coso_id": "2",
         "cantidad_acordada": null,
         "cantidad": "1",
         "soco_id": "2"
      },
            {
         "reci_id": null,
         "otro": null,
         "fec_alta": "2020-03-19+00:00",
         "tica_id": "tipos_cargaResiduos Patologicos",
         "valor": "Residuos Patologicos",
         "coso_id": "1",
         "cantidad_acordada": null,
         "cantidad": "2",
         "soco_id": "2"
      }
    ]},
    "fec_alta": "2020-03-19+00:00",
    "observaciones": "OBSERVACIONES 1",
    "sotr_id": "1",
    "soco_id": "2"
  }}












-- ordTransPorIdGet
  recurso: /ordenTransporte/{ortr_id}
  metodo: get

  select ortr_id, fec_retiro, caseid, fec_alta, difi_id, sotr_id, equi_id, chof_id from log.ordenes_transporte where ortr_id = CAST(:ortr_id AS INTEGER)

  {"ordenTransp":
    {
      "ortr_id": "$ortr_id",
      "fec_retiro": "$fec_retiro",
      "caseid": "$caseid",
      "fec_alta": "$fec_alta",
      "difi_id": "$difi_id",
      "sotr_id": "$sotr_id",
      "equi_id": "$equi_id",
      "chof_id": "$chof_id"
    }
  }

-- ordTransProxId (numero automático próximo)
  recurso: /ordenTransporte/prox
  metodo: get

  select COALESCE(NULL,(max(ortr_id) + 1), 1) as nuevo_soco_id from log.solicitudes_contenedor

  {
    "respuesta":{
      "nueva_ortr_id": "$nueva_ortr_id"
    }
  }

-- ordenTransporteSet
  recurso: /ordenTransporte
  metodo: post
  insert into log.ordenes_transporte (fec_retiro, estado, caseid, difi_id, sotr_id, equi_id, chof_id)
  values(TO_DATE(:fec_retiro, 'YYYY-MM-DD'), :estado, :caseid, :difi_id, CAST(:sotr_id AS INTEGER), CAST(:equi_id AS INTEGER), :chof_id) returning ortr_id

  {
    "_post_ordentransporte":
      {
        "fec_retiro": "2020-03-23",
        "estado": "INGRESADO",             
        "caseid": "00001",                                    // de BPM
        "difi_id": "disposicion_finalPTA",                    // disposicion final
        "sotr_id": "1",                                       // solic transporte id
        "equi_id": "21",                                      // ide de equipo(camión)
        "chof_id": "18887911"                                 // recordar que es el dni de chofer
      }
  }

  {
    "respuesta":{
      "ortr_id": "15"
    }
  }

-- ordenTransporte->Estado (estados:'EN_TRANSITO', 'INGRESADO', 'DESCARGADO', 'INFRACCION', 'EGRESADO')
  recurso: tabla/estado_contenedor
  metodo: get
  
  -- ejemplo de respuesta
  {
    "valores":{
        "valor":[
          {
            "tabl_id": "estado_contenedorEN_TRANSITO",
            "valor": "EN_TRANSITO",
            "valor2": "",
            "valor3": "",
            "descripcion": ""
          },
          {
            "tabl_id": "estado_contenedorINGRESADO",
            "valor": "INGRESADO",
            "valor2": "",
            "valor3": "",
            "descripcion": ""
          },
          {
            "tabl_id": "estado_contenedorDESCARGADO",
            "valor": "DESCARGADO",
            "valor2": "",
            "valor3": "",
            "descripcion": ""
          }
        ]
    }
  }

-- transportistasSet
  recurso: /transportistas
  metodo: post

  insert into log.transportistas(razon_social,descripcion,direccion,telefono,contacto,resolucion,registro,fec_alta_efectiva,fec_baja_efectiva,usuario_app)
  values(:razon_social,:descripcion,:direccion,:telefono,:contacto,:resolucion,:registro,TO_DATE(:fec_alta_efectiva,'YYYY-MM-DD'),TO_DATE(:fec_baja_efectiva,'YYYY-MM-DD'),:usuario_app)
  returning tran_id
  {
    "_post_transportistas":{
      "razon_social": "Razon transportista",
      "descripcion": "decripcion transportista",
      "direccion": "calle gral acha 123",
      "telefono": "1555555",
      "contacto": "hongo, pepe",
      "resolucion": "123rh4",
      "registro": "registro test",
      "fec_alta_efectiva": "2019-12-20",
      "fec_baja_efectiva": "2019-12-20",
      "usuario_app": "hugoDS"
    }
  }

  {
    "respuesta":{
      "tran_id": "$tran_id"
    }
  }	


-- transportistaGet
  recurso: /transportistas
  metodo: get
  select tran_id,razon_social,descripcion,direccion,telefono,contacto,resolucion,registro,fec_alta_efectiva,fec_baja_efectiva,fec_alta,usuario,usuario_app from log.transportistas

  {"transportistas":
    {
      "transportista":[
        {
          "tran_id": "$tran_id",
          "razon_social": "$razon_social",
          "descripcion": "$descripcion",
          "direccion": "$direccion",
          "telefono": "$telefono",
          "contacto": "$contacto",
          "resolucion": "$resolucion",
          "registro": "$registro",
          "fec_alta_efectiva": "$fec_alta_efectiva",
          "fec_baja_efectiva": "$fec_baja_efectiva",
          "fec_alta": "$fec_alta",
          "usuario": "$usuario",
          "usuario_app": "$usuario_app",
          "@transportistaTipoCarga": "$tran_id->tran_id"
        }
      ]
    }
  }

-- transportistaGetPorId
  recurso: /transportistas/{tran_id}
  metodo: get
  select tran_id,razon_social,descripcion,direccion,telefono,contacto,resolucion,registro,fec_alta_efectiva,fec_baja_efectiva,fec_alta,usuario,usuario_app from log.transportistas
  where tran_id = CAST(:tran_id as INTEGER)

  {
      "transportista":
        {
          "tran_id": "$tran_id",
          "razon_social": "$razon_social",
          "descripcion": "$descripcion",
          "direccion": "$direccion",
          "telefono": "$telefono",
          "contacto": "$contacto",
          "resolucion": "$resolucion",
          "registro": "$registro",
          "fec_alta_efectiva": "$fec_alta_efectiva",
          "fec_baja_efectiva": "$fec_baja_efectiva",
          "fec_alta": "$fec_alta",
          "usuario": "$usuario",
          "usuario_app": "$usuario_app",
           "@transportistaTipoCarga": "$tran_id->tran_id"        
        }      
  }

  -- ejemplo de respuesta
    {"transportista": {
      "descripcion": "un transporte copado",
      "contacto": "Tomas O. Bámela",
      "fec_alta_efectiva": "2019-12-20+00:00",
      "resolucion": "Resolucion test1",
      "direccion": "libertador 1890",
      "usuario_app": "HugoDS",
      "tran_id": "3",
      "razon_social": "Transportes Capria y Asoc.",
      "registro": "registro test1",
      "fec_baja_efectiva": "2019-12-20+00:00",
      "fec_alta": "2019-12-27+00:00",
      "tiposCarga": {"cargas":    [
                {
            "tica_id": "tipo_cargaEscombros",
            "valor": "Escombros",
            "tran_id": "3"
          },
                {
            "tica_id": "tipo_cargaResiduos Patologicos",
            "valor": "Residuos Patologicos",
            "tran_id": "3"
          }
      ]},
      "usuario": "postgres",
      "telefono": "1234456789"
    }}







-- transportistaGetPorGenerador(transportistas que entregaron contenedores a un generador segun solicitud de contenedores)
  
  recurso: /transportistas/generador/{usuario_app}
  metodo: get
  select TR.tran_id,TR.razon_social 
  from  
      log.solicitudes_contenedor SC, log.contenedores_entregados CE, log.contenedores C, log.transportistas TR
  where 
      SC.soco_id = CE.soco_id and
      CE.cont_id = C.cont_id and
      C.tran_id = TR.tran_id and
      SC.usuario_app = :usuario_app
      limit (1)
  -- ejemplo de respuesta
  {"transportistas":
    {
      "transportista":[
        {
          "tran_id": "$tran_id",
          "razon_social": "$razon_social"
        }
      ]
    }
  }




-- transportistasGetTodo (todos transportistas con choferes)
  
  recurso: /transportistas/todo
  metodo: get
  select tran_id, razon_social from log.transportistas

  {"transportistas":
    {
      "transportista":[
        {
          "tran_id": "$tran_id",
          "razon_social": "$razon_social",
          "@choferesGetPorTransportistas": "$tran_id->tran_id" 
        }
      ]
    }
  }        

-- transportistaUpdate
  recurso: /transportistas
  metodo: put
  update log.transportistas set razon_social=:razon_social, descripcion=:descripcion, direccion=:direccion, telefono=:telefono,  contacto=:contacto, resolucion=:resolucion, registro=:registro, fec_alta_efectiva=TO_DATE(:fec_alta_efectiva,'YYYY-MM-DD'), fec_baja_efectiva=TO_DATE(:fec_baja_efectiva,'YYYY-MM-DD'), usuario_app=:usuario_app
  where tran_id = CAST(:tran_id AS INTEGER)

  {
   "_put_transportistas":{
      "tran_id":"1",
      "razon_social":"Razon transportista",
      "descripcion":"decripcion transportista",
      "direccion":"calle gral acha 123",
      "telefono":"1555555",
      "contacto":"hongo, pepe",
      "resolucion":"123rh4",
      "registro":"registro test",
      "fec_alta_efectiva":"2019-08-20",
      "fec_baja_efectiva":"2019-12-20",
      "usuario_app":"hugoDS"
   }
  }
-- transportistasEstado
  recurso: /transportistas/estado
  metodo: put
  / para eliminar un transportista en :eliminado = 1 caso contraio 0 */
  update 
  log.transportistas 
  set eliminado = CAST(:eliminado AS INTEGER)
  where tran_id = CAST(:tran_id AS INTEGER)

-- transportistasSetTipoCarga
  recurso: /transportistas/tipo/carga
  metodo: post
  
  insert into log.tipos_carga_transportistas(tran_id, tica_id) values(CAST(:tran_id AS INTEGER), :tica_id)

  {
    "tipo_carga":{
        "tran_id": "3",
        "tica_id": "tipo_cargaEscombros"
    }
  }

  {
    "_post_transportistas_tipo_carga_batch_req":{
        "_post_transportistas_tipo_carga":[
          {
              "tran_id":"3",
              "tica_id":"tipo_cargaEscombros"
          },
          {
              "tran_id":"3",
              "tica_id":"tipo_cargaResiduos Patologicos"
          }
        ]
    }
  }

-- transportistasDeleteTipoCarga
  recurso: /transportista/tipo/carga
  metodo:  delete
  delete from log.tipos_carga_transportistas where tran_id = CAST(:tran_id AS INTEGER)

  {
    "_delete_transportista_tipo_carga":{
      "tran_id": ""
    }
  }





-- transportistaTipoCarga(tipo de carga por id de transportista)

  recurso: /transportistas/{tran_id}/tipo/carga
  metodo: get
  
  select TCT.tran_id, TCT.tica_id, T.valor from log.tipos_carga_transportistas TCT, core.tablas T
  where TCT.tica_id = T.tabl_id 
  and TCT.tran_id = CAST(:tran_id as INTEGER) 

  {
    "tiposCarga":{
      "cargas":[
          "tran_id": "$tran_id",
          "tica_id": "$tica_id",
          "valor": "$valor"
      ]
    }
  }
  -- ejemplo de respuesta
  {"tiposCarga": {"cargas": [
        {
        "tica_id": "tipo_cargaEscombros",
        "valor": "Escombros",
        "tran_id": "3"
    },
        {
        "tica_id": "tipo_cargaResiduos Patologicos",
        "valor": "Residuos Patologicos",
        "tran_id": "3"
    }
  ]}}

-- tablasGet

  /* en core.tablas guardamos los tipos y los estados
  tabl_id = concatenacion de tabla+valor (unique key)
  tabla = nombre de la tabla ficticia
  valor = nombre a mostrar */

  recurso: /tablas/{tabla}  (ej: /tablas/tipo_carga -> para tipo de RSU )
  metodo: get

  select * from core.tablas where tabla = :tabla

  -- ejemplos (:tabla='tica_id', :tabla='tipo_articulo', :tabla='rubro_generador', etc)
  
  {
    "valores":{
        "valor":[
          {
            "tabl_id": "$tabl_id",
            "valor": "$valor",
            "valor2": "$valor2",
            "valor3": "$valor3",
            "descripcion": "$descripcion"
          }
        ]
    }
  }



-- tablasSet

  recurso: /tablas
  metodo: post
  insert into core.tablas(tabla, valor) values(:tabla, :valor)
  returning tabl_id

  {
    "valor":{
        "tabla": "tipo_carga",
        "valor": "Organico"
    }
  }

  {
    "respuesta":{
      "tabl_id": "$tabl_id"
    }
  }

// TODO: ACA ESTOY

-- solicitudRetiroProx
  recurso: /solicitudRetiro/prox
  metodo: get
  select COALESCE(NULL,(max(sore_id) + 1), 1) as nuevo_sore_id from log.solicitudes_retiro
  --ej de respuesta
  {"respuesta": {"nuevo_sore_id": "3"}}

-- solicitudRetiroSet
  recurso: /solicitudRetiro
  metodo: post
  insert into solicitudes_retiro(usuario_app) values(:usuario_app)
  
  {
    "_post_solicitudretiro":{
      "usuario_app": "hugoDS"
    }
  }
  --ejemplo de respuesta
  {"respuesta": {"sore_id": "9"}}

-- updateSolicitudRetiroContenedores
  recurso:
  metodo:
  update log.contenedores_entregados set sore_id = CAST(:sore_id AS INTEGER), porc_llenado = CAST(:porc_llenado AS FLOAT4), mts_cubicos = CAST(:mts_cubicos AS FLOAT4)  
  where cont_id = CAST(:cont_id AS INTEGER) 


-- vehiculosGetActivos
  recurso: /vehiculos
  metodo: get
  select equi_id, descripcion, marca, dominio, codigo, ubicacion, tran_id, fecha_ingreso from core.equipos where estado = 'AC'

  {
    "vehiculos":{
      "vehiculo":[
          {
            "equi_id": "$equi_id",
            "descripcion": "$descripcion",
            "marca": "$marca",
            "dominio": "$dominio",
            "codigo":"$codigo",
            "ubicacion":"$ubicacion",
            "tran_id":"$tran_id",
            "fecha_ingreso":"$fecha_ingreso"
          }
      ]
    }
  }


-- vehiculosGetPorTransportistas
  recurso: /vehiculos/transp/{tran_id}
  metodo: get
  select equi_id, descripcion, marca, dominio from core.equipos where tran_id = :tran_id and estado = 'AC'

  {
    "vehiculos":{
      "vehiculo":[
          {
            "equi_id": "$equi_id",
            "descripcion": "$descripcion",
            "marca": "$marca",
            "dominio": "$dominio"
          }
      ]
    }
  }
  
-- vehiculosSet
  recurso: /vehiculos
  metodo: post
 
  insert into core.equipos (descripcion, marca, codigo, ubicacion, tran_id, dominio, fecha_ingreso)
  values(:descripcion, :marca, :codigo, :ubicacion, :tran_id, :dominio, TO_DATE(:fecha_ingreso,'YYYY-MM-DD'))
  returning equi_id
  
  {
    "_post_vehiculos":{
      "descripcion": "Carreton grande",
      "marca": "MAC",
      "codigo": "8924ef",
      "ubicacion": "casa central",
      "tran_id": "3",
      "dominio": "AMD 456",
      "fecha_ingreso": "2020-05-21"
    }
  }
  
  {
    "respuesta":{
      "equi_id": "$equi_id"
    }
  }

-- vehiculoUpdate
  recurso: /vehiculos
  metodo: put

  update core.equipos set descripcion = :descripcion, marca = :marca, codigo = :codigo, ubicacion = :ubicacion, tran_id = CAST(:tran_id AS INTEGER), dominio = :dominio, fecha_ingreso = TO_DATE(:fecha_ingreso,'YYYY-MM-DD'))
  where equi_id = CAST(:equi_id AS INTEGER)

  {
    "_put_vehiculos":{
      "equi_id": "25"
      "descripcion": "Carreton grande",
      "marca": "MAC",
      "codigo": "8924ef",
      "ubicacion": "casa central",
      "tran_id": "3",
      "dominio": "AMD 456",
      "fecha_ingreso": "2020-05-21"
    }
  }

-- vehiculoDelete
  recurso: /vehiculos
  metodo: delete

  update core.equipos set estado = 'AN'
  where equi_id = CAST(:equi_id AS INTEGER)

  {
    "_delete_vehiculos":{
      "equi_id": "33"
    }
  }

-- zonaGet
  recurso: /zonas
  metodo: get
  select 
  zonas.zona_id, zonas.nombre, zonas.descripcion, zonas.depa_id, departamentos.nombre as depa_nom from core.zonas
  join core.departamentos on core.zonas.depa_id = core.departamentos.depa_id

  {
   "zonas":{
      "zona":[
         {
            "zona_id":"$zona_id",
            "zona_nom":"$nombre",
            "zona_descrip":"$descripcion",
            "depa_id": "$depa_id",
            "depa_nom": "$depa_nom"          
         }      
      ]   
   }
  } 

-- zonaGetPorId
  recurso: /zonas/{zona_id}
  metodo: get
  select 
  zonas.zona_id, zonas.nombre, zonas.imagen, zonas.descripcion, zonas.depa_id, departamentos.nombre as depa_nom from core.zonas
  join core.departamentos on core.zonas.depa_id = core.departamentos.depa_id 
  where eliminado = 0  and zona_id = CAST(:zona_id AS INTEGER)

  {  
    "zona":
        {
          "zona_id":"$zona_id",
          "nombre":"$nombre",
          "imagen": "$imagen",
          "descripcion":"$descripcion",
          "depa_id": "$depa_id",
          "depa_nom": "$depa_nom"          
    }  
  }

  -- ejemplo de respuesta
    {"zona": {
    "descripcion": "Zona Centro",
    "depa_nom": "Capital",
    "depa_id": "1",
    "imagen": "L2Fzc2V0L2ltYWdlbm5vc3ViaWRhLmpwZw==",
    "nombre": "Trinidad",
    "zona_id": "5"
  }}

-- zonaGetPorDepto

  recurso: /zonas/departamento/{depa_id}
  metodo: get
  
  select 
  zonas.zona_id, zonas.nombre from core.zonas 
  where eliminado = 0  and depa_id = cast(:depa_id as integer)  
  {
    "zonas":{
        "zona":[
          {
              "zona_id":"$zona_id",
              "zona_nom":"$nombre"         
          }      
        ]   
    }
  }

-- zonaSet
  recurso: /zonas
  metodo: post
  insert into 
   core.zonas(nombre, descripción, imagen,usuario_app, depa_id)
  values(:nombre, :descripción, :imagen, :usuario_app, CAST(:depa_id AS INTEGER))
  returning zona_id
  {
    "_post_zonas":{
      "nombre": "Jachal", 
      "descripcion": "Zona Norte", 
      "imagen": "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN",
      "usuario_app": "hugoDS", 
      "depa_id": "5"
    }
  }

  { "respuesta":{
     "zona_id": "$zona_id"
    }
  }

-- zonaSetCircuitos  
  recurso: /zonas/circuitos
  metodo: post
  insert into log.zonas_circuitos(zona_id, circ_id) values(CAST(:zona_id as INTEGER), CAST(:circ_id AS INTEGER))

  {
    "circuitos":{
      "zona_id": "5",
      "circ_id": "1"
    }
  }

  {
    "_post_zonas_circuitos_batch_req":{
        "circuitos":[
          {
            "zona_id": "5",
            "circ_id": "1"
          },
          {
            "zona_id": "4",
            "circ_id": "2"
          }
        ]
    }

  }



-- zonaUpdate
  recurso: /zonas
  metodo: put
  update 
   core.zonas
  set nombre=:nombre, descripcion=:descripcion, usuario_app=:usuario_app, depa_id=CAST(:depa_id AS INTEGER)
  where zona_id = CAST(:zona_id AS INTEGER)

  {
    "zona":{
      "zona_id": "7",
      "nombre": "Concepción", 
      "descripcion": "Zona Norte",       
      "usuario_app": "hugoDS", 
      "depa_id": "1"
    }
  }

-- zonaGetImagen
  recurso: /zona/get/imagen/{zona_id}
  metodo: get

  select imagen from core.zonas
  where zona_id = CAST(:zona_id AS INTEGER)

  {
    "respuesta":{
        "imagen": "$imagen"
    }
  }

  -- ejemplo de respuesta
  {"respuesta": {"imagen": "dataimage/jpegbase64/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPU"}}



-- 
  recurso: /zonas/update/imagen
  metodo: put

  update 
   core.zonas
  set imagen = :imagen
  where zona_id = CAST(:zona_id AS INTEGER)

  {
    "zona":{
      "zona_id": "7",
      "imagen": "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN"
    }
  }

-- zonaDelete

  recurso: /zonas/estado
  metodo: put
   update core.zonas set eliminado = CAST(:eliminado as INTEGER) where zona_id = CAST(:zona_id as INTEGER)

  -- ej de json contrato
  {
    "_put_zonas_estado":{
      "zona_id":"93",
      "eliminado":"1"   // valor fijo en "1" para borrar, en "0" para habilitar nuevamente
    }  
  }

























