endpoint de Desarrollo
http://10.142.0.7:8280/services/semaresiduosDS

endpoint de Test
http://10.142.0.3:8280/services/semaresiduosDS

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

-- contenedoresImagenPorId
  recurso: /contenedores/get/imagen/{cont_id}
  metodo: get

  select imagen from log.contenedores
  where cont_id = CAST(:cont_id AS INTEGER)

  {
    "respuesta":{
        "imagen": "$imagen"
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
  values(CAST(:codigo as INTEGER), :descripcion, CAST(:capacidad as float8), TO_DATE(:anio_elaboracion,'YYYY-MM-DD'), CAST(:tara as float8), :habilitacion, TO_DATE(:fec_alta,'YYYY-MM-DD'), :usuario_app, :esco_id, CAST(:tran_id AS INTEGER), :imagen)
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
      "tran_id": "2",
      "imagen": ""
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
  set codigo = CAST(:codigo as INTEGER), descripcion = :descripcion, capacidad = CAST(:capacidad as float8), tara = CAST(:tara as float8), habilitacion = :habilitacion, usuario_app = :usuario_app, esco_id = :esco_id, anio_elaboracion = TO_DATE(:anio_elaboracion,'YYYY-MM-DD'), imagen = :imagen
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
      "anio_elaboracion":"2019-01-01",
      "imagen": ""
    }
  }

 

-- contenedoresGetPorTransp (contenedores por transporte y tipo de residuo agrupado por tipo de residuo)

  recurso: /contenedores/transportista/{tran_id}
  metodo: get

   select
    C.cont_id, C.codigo, C.descripcion, C.capacidad, C.tara,
    T.valor as estado,
    T2.valor as habilitacion
  from
    log.contenedores C, core.tablas T, core.tablas T2
  where
      C.esco_id = T.tabl_id
  and C.habilitacion = T2.tabl_id
  -- por transportista
  and C.tran_id = CAST(:tran_id  as INTEGER)

   {
    "contenedores": {
        "contenedor": [
            {
              "cont_id": "$cont_id",
              "codigo": "$codigo",
              "descripcion": "$descripcion",
              "capacidad": "$capacidad",
              "tara": "$tara",
              "estado": "$estado",
              "habilitacion": "$habilitacion"
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
--contenedoresEntregadosDescargarUpdate
 recurso /contenedoresEntregados/descargar
 metodo: PUT

  SELECT prd.cambiar_recipiente(ce.batch_id,:p_reci_id_destino,2000,1,:p_usuario_app,'false',ce.mts_cubicos)
  FROM log.contenedores_entregados ce
  WHERE ce.ortr_id = :ortr_id
  AND ce.cont_id = :cont_id;

    { "_put_contenedoresEntregados_descargar":{
        "p_reci_id_destino" :""
        "p_usuario_app" :""
        "ortr_id" :""
        "cont_id" :""
  }}

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
        ]
      }
  }

-- contenedoresEntregadosAsignaarVehiculo
  recurso: /contenedoresEntregados/vehiculo
  /_put_contenedoresentregados_vehiculo_batch_req
  metodo: put

  update log.contenedores_entregados 
  set equi_id = CAST(:equi_id as INTEGER)
  where coen_id = CAST(:coen_id as INTEGER)

  {
    "_put_contenedoresentregados_vehiculo_batch_req": {
        "_put_contenedoresentregados_vehiculo": [
            {
              "equi_id": "",
              "coen_id": ""
            }
        ]
    }
  }

--contenedoresEntregadosDescargarEnRecipiente
   recurso /contenedoresEntregados/descargar/recipiente
   metodo PUT
  SELECT prd.cambiar_recipiente(ce.batch_id,cast(:reci_id_destino as integer),2000,1,:usuario_app,'false'::varchar)
  FROM log.contenedores_entregados ce
  WHERE ce.ortr_id = cast(:ortr_id as integer)
  AND ce.cont_id = cast(:cont_id as integer);

    retorna 202 si ok
  --contenedoresEntregadosDescagarUpdate
    recurso /contenedoresEntregados/descargar
    metodo POST

  update log.contenedores_entregados
  set foto=:foto
  ,tiva_id=:tiva_id
  ,observaciones_descarga=:observaciones_descarga
  where ortr_id = cast(:ortr_id as integer)
  and cont_id =cast(:cont_id as integer)
   retorna 202 si ok

-- contenedoresEntregadosInfoEntregaCase
  recurso: /contenedoresEntregados/info/entrega/case/{case_id}
  metodo: get

  select 
      CE.coen_id, CE.porc_llenado, CE.mts_cubicos,C.cont_id, C.codigo, T.valor as tipo_carga
  from 
      log.contenedores C, log.contenedores_entregados CE, core.tablas T
  where 
      C.cont_id = CE.cont_id 
  and 
      CE.ortr_id = (select OT.ortr_id from log.ordenes_transporte OT
                    where OT.case_id = :case_id )
  and 
      CE.tica_id = T.tabl_id 
            
  and 
      CE.peso_neto is null
  and 
      CE.difi_id is null
  and 
      CE.depo_id is null                

  {
    "contenedores":{
        "contenedor":[
          {
            "coen_id": "$coen_id",
            "porc_llenado": "$porc_llenado",
            "mts_cubicos": "$mts_cubicos",
            "cont_id": "$cont_id",
            "codigo": "$codigo",
            "tipo_carga": "$tipo_carga"            
          }
        ] 
    }
  }


-- contenedoresEntregadosRegistraIngreso (registra ingreso de contenedores en bascula PTA)
  recurso: /contenedoresEntregados/registra/ingreso
  metodo: put

  update log.contenedores_entregados
  set peso_neto = CAST(:peso_neto AS FLOAT4), difi_id = :difi_id, depo_id = :depo_id
  where coen_id = CAST(:coen_id as INTEGER)

  {
    "_put_contenedoresentregados_registra_ingreso":{
      "peso_neto": "$peso_neto",
      "depo_id": "$depo_id",
      "difi_id": "$difi_id"
      "coen_id": "$coen_id"
    }
  }


-- contenedoresEntregadosInfoVuelcoCase (pantalla de certificado de vuelco)
  recurso: /contenedoresEntregados/info/vuelco/case/{case_id}
  metodo: get

  select 
      CE.coen_id, CE.porc_llenado, CE.depo_id, CE.mts_cubicos,C.cont_id, C.codigo, T.valor as tipo_carga
  from 
      log.contenedores C, log.contenedores_entregados CE, core.tablas T
  where 
      C.cont_id = CE.cont_id 
  and 
      CE.ortr_id = (select OT.ortr_id from log.ordenes_transporte OT
                    where OT.case_id = :case_id )
  and 
      CE.tica_id = T.tabl_id             
  and 
      CE.peso_neto is null
  and 
      CE.difi_id is null
  and 
      CE.tiva_id is null    
  
  {
    "contenedores":{
        "contenedor":[
          {
            "coen_id": "$coen_id",
            "porc_llenado": "$porc_llenado",
            "depo_id": "$depo_id",
            "mts_cubicos": "$mts_cubicos",
            "cont_id": "$cont_id",
            "codigo": "$codigo",
            "tipo_carga": "$tipo_carga"            
          }
        ] 
    }
  }




-- contenedoresEntregadosGetImgPorCoen_id (Trae imagen pot coen_id) 
  recurso: /contenedoresEntregados/ingreso/{coen_id}
  metodo: get

  select imagen 
  from log.contenedores C, log.contenedores_entregados CE 
  where C.cont_id = CE.cont_id 
  and CE.coen_id = CAST(:coen_id as INTEGER)

  {
	  "imag_contenedor":{
		  "imagen": "$imagen"
    }
  }

-- contenedoresEntregadosRedireccionar
  recurso: /contenedoresEntregados/redireccionar
  metodo POST
  UPDATE log.contenedores_entregados
  set depo_id = :depo_id,
  observaciones_descarga = observaciones_descarga ||'\r '||:observaciones_descarga
  where ortr_id=:ortr_id
  and cont_id = :cont_id

  {
    "_post_contenedoresEntregados_redireccionar":{
        "depo_id":"$depo_id",
        "observaciones_descarga":"$observaciones_descarga",
        "ortr_id":"$ortr_id",
        "cont_id":"$cont_id"
    }
  }

  retorna 202 si ok


-- contenedoresEntregadosGetPorTipoCargaNick (devuelve contenedores de a retirar por nick de generador logueado)
  recurso:/contenedoresEntregados/tipocarga/{tica_id}/user/{usernick}
  metodo: get

  SELECT
    C.cont_id
    , C.codigo
    , C.descripcion
  FROM
    log.contenedores C
    , log.contenedores_entregados CE
    , log.solicitantes_transporte st
    , seg.users u
    , log.solicitudes_contenedor sc
  WHERE
    C.cont_id = CE.cont_id
    AND CE.ortr_id IS NULL
    AND CE.tica_id = :tica_id
    AND st.sotr_id = sc.sotr_id
    AND sc.soco_id = ce.soco_id
    AND st.user_id = u.email
    AND u.usernick = :usernick

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

-- contenedoresSolicitadosUpdateCantidad (pantalla analisis de solicitud de contenedores)

  recurso: /_put_contenedoressolicitados_cantidad_batch_req (/contenedoresSolicitados/cantidad)
  metodo: put 
  update log.contenedores_solicitados CS set cantidad_acordada = :cantidad_acordada 
  where CS.soco_id = CAST(:soco_id as INTEGER)
  and CS.tica_id  = :tica_id 

  {
    "_put_contenedoressolicitados_cantidad_batch_req":{
        "_put_contenedoressolicitados_cantidad":[
            {
              "cantidad_acordada": ,
              "soco_id": ,
              "tica_id": 
            }
          ]
        }
  }







-- getDepositosEstablecimiento
  recurso: http://10.142.0.7:8280/services/PRDDataService/depositos_establecimiento/{esta_id}

  SELECT a.depo_id, a.descripcion, e.esta_id, e.nombre
  FROM alm.alm_depositos a 
  join prd.establecimientos e on e.esta_id = a.esta_id
  WHERE e.esta_id = CAST(:esta_id as integer)
  AND a.eliminado = false

  {
    "depositos":{
        "deposito":[
          {
              "depo_id":"$depo_id",
              "descripcion":"$descripcion",
              "esta_id":"$esta_id",
              "esta_nombre":"$nombre"
          }
        ]
    }
  }

-- depositosDescargaGet
  recurso: /deposito/descarga/{ortr_id}
  metodo: get

  select CE.depo_id, DE.descripcion
  from log.contenedores_entregados CE, alm.alm_depositos DE
  where Ce.ortr_id = CAST(:ortr_id as INTEGER)
  and DE.depo_id = CE.depo_id
  and CE.tiva_id is null
  and CE.fec_descarga is null

  {
    "deposito":{
      "depo_id": "$depo_id",
      "descripcion": "$descripcion"
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
   set nombre=:nombre, apellido=:apellido, documento=:documento, fec_nacimiento=TO_DATE(:fec_nacimiento,'YYYY-MM-DD'), direccion=:direccion, celular=:celular, codigo=:codigo, carnet=:carnet, vencimiento=TO_DATE(:vencimiento,'YYYY-MM-DD'), habilitacion=:habilitacion, imagen = :imagen, tran_id=CAST(:tran_id AS INTEGER), cach_id=:cach_id, usuario_app = :usuario_app 
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


-- contenedoresEntregadosSet"
  recurso: /contenedores/entregados/entregar
  _post_contenedores_entrega_batch_req
  metodo: post
      insert into log.contenedores_entregados(fec_entrega, cont_id, usuario_app, soco_id, tica_id ,equi_id_entrega)
  values(TO_DATE(:fec_entrega, 'YYYY-MM-DD'), CAST(:cont_id as INTEGER), :usuario_app, CAST(:soco_id AS INTEGER), :tica_id, cast(:equi_id_entrega as INTEGER))
  returning coen_id;

-- contenedoresEntregaSet
  recurso: /contenedores/entregados/entregar

  insert into log.contenedores_entregados(fec_entrega, cont_id, usuario_app, soco_id, tica_id )
  values(TO_DATE(:fec_entrega, 'YYYY-MM-DD'), CAST(:cont_id as INTEGER), :usuario_app, CAST(:soco_id AS INTEGER), :tica_id)
  --returning coen_id

  {"_post_contenedores_entregados_entregar":{
    "fec_entrega":"01/01/2020",
    "cont_id":"104",
    "usuario_app":"rodete",
    "soco_id":"86",
    "tica_id":"tipos_cargaResiduos Tecnologicos",
    "equi_id_entrega":"40"
    }
  }


  --{"respuesta": {"coen_id": "20"}}

  -- ejemplo

    recurso batch: /_post_contenedores_entregados_entregar_batch_req
    {
      "_post_contenedores_entregados_entregar_batch_req":{
          "_post_contenedores_entregados_entregar":[
            {
              "fec_entrega": "2020-04-02",
              "cont_id": "43",
              "usuario_app": "hugoDS",
              "soco_id": "2",
              "tica_id": "tipo_cargaOrganico",
              "equi_id_entrega":"40"
            },
            {
              "fec_entrega": "2020-04-02",
              "cont_id": "44",
              "usuario_app": "hugoDS",
              "soco_id": "2",
              "tica_id": "tipo_cargaOrganico",
              "equi_id_entrega":"40"
            },
            {
              "fec_entrega": "2020-04-02",
              "cont_id": "43",
              "usuario_app": "hugoDS",
              "soco_id": "2",
              "tica_id": "tipo_cargaOrganico",
              "equi_id_entrega":"40"
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


-- contenedoresEntregadosGetPorCaseId (pantalla retiro contenedores->PROCESO RETIRO CONTENEDORES)
  recurso: /contenedoresEntregados/case/{case_id}
  metodo: get

  select CE.coen_id, CE.cont_id, CE.porc_llenado, CE.mts_cubicos, CE.tica_id, T.valor 
  from log.contenedores_entregados CE, core.tablas T
  where CE.sore_id = (select SR.sore_id from log.solicitudes_retiro SR where SR.case_id = :case_id ) 
  and CE.tica_id = T.tabl_id 
  and CE.ortr_id is null
  and CE.equi_id is null

  {
    "contenedoresEntregados":{
        "contenedor":[
          {
            "coen_id": "$coen_id",
            "cont_id": "$cont_id",
            "porc_llenado": "$porc_llenado",
            "mts_cubicos": "$mts_cubicos",
            "tica_id": "$tica_id",
            "valor": "$valor"
          }
        ]
    }
  }

-- depositosGetPorEstablecimiento (depositos de descarga)
  recurso: /depositos/establecimiento/{esta_id}  (1 para PTA)
  metodo: get

  select D.depo_id, D.descripcion
  from alm.alm_depositos D
  where esta_id = cast(:esta_id as INTEGER)

  {
    "depositos":{
        "deposito":[
          {
            "depo_id": "$depo_id",
            "descripcion": "$descripcion"
          }
        ]
    }
  }


-- establecimientosGetTodos
  recurso: /establecimientos
  metodo: get

  select esta_id, nombre from prd.establecimientos
  where estado = "1" 

  {
    "establecimientos":{     
      "establecimiento":  [
        {
          "esta_id": "$esta_id",
          "nombre": "$nombre"
        }
      ]
    }
  }


-- contenedoresEntregadosInfoSalidaGet
   recurso /contenedoresEntregados/info/salida/case/{case_id}
   metodo: GET

      SELECT
	OT.ortr_id
	, OT.fec_alta
	, OT.estado
	, E.dominio
	, E.descripcion
	, E.imagen AS img_vehiculo
	, E.tara
	, CH.imagen AS img_chofer
	, concat(CH.nombre, ' ', CH.apellido) AS nom_chofer
	, CH.documento
	, ce.cont_id
	, con.codigo codigo_contenedor
	, ce.peso_neto
	, ce.observaciones_descarga
	, t.descripcion contenido_descarga
  FROM
    log.ordenes_transporte OT
    , core.equipos E
    , log.choferes CH
    , log.contenedores_entregados ce
    , core.tablas t
    , log.contenedores con
  WHERE
    OT.case_id = :case_id
    AND OT.equi_id = E.equi_id
    AND OT.chof_id = CH.documento
    AND OT.eliminado = 0
    AND CE.fec_salida IS NULL
    AND ce.fec_descarga IS NOT NULL
    AND ce.ortr_id = ot.ortr_id
    AND t.tabl_id = ce.tiva_id
    AND con.cont_id = ce.cont_id

    "contenedor":{
        "ortr_id":"$ortr_id",
        "fec_alta":"$fec_alta",
        "estado":"$estado",
        "dominio":"$dominio",
        "descripcion":"$descripcion",
        "img_vehiculo":"$img_vehiculo",
        "tara":"$tara",
        "img_chofer":"$img_chofer",
        "nom_chofer":"$nom_chofer",
        "documento":"$documento",
        "cont_id":"$cont_id",
        "codigo_contenedor":"$codigo_contenedor",
        "peso_neto":"$peso_neto",
        "observaciones_descarga":"$observaciones_descarga",
        "contenido_descarga":"$contenido_descarga"
    }


  -- contenedoresEntregadosSalidaUpdate
    recurso: /contenedoresEntregados/salida
    metodo: PUT

  update log.contenedores_entregados
  set fec_salida= now()
  where ortr_id = cast(:ortr_id as integer)
  and cont_id =cast(:cont_id as integer)

  retorna 202



-- contenedoresEntregadosRestantesDescargar
  recurso: /contenedoresEntregados/restantes/descarga/case/{case_id}
  metodo: get
  select count(ce.cont_id) as noEntregados from log.contenedores_entregados ce,  log.ordenes_transporte OT
  where ce.fec_descarga IS null
  AND ce.ortr_id = ot.ortr_id
  and OT.case_id = :case_id

  {
    "contenedores":{
      "noEntregados": "$noEntregados"
    }
  }

  -- repsuesta
  {
    "contenedores":{
      "noEntregados": "1"
    }
  }





-- (generadores)solicitanteTransporteGet
  recurso: /solicitantesTransporte
  metodo: get
  select ST.sotr_id, ST.razon_social, ST.cuit, ST.domicilio, ST.num_registro, 
  ST.lat, ST.lng, ST.zona_id, ST.rubr_id, ST.tist_id, ST.depa_id,
  D.nombre as depa_nombre, Z.nombre as zona_nombre 
  from log.solicitantes_transporte ST, core.departamentos D, core.zonas Z
  where ST.depa_id = D.depa_id
  and ST.zona_id = Z.zona_id 
  and ST.eliminado = 0

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
            "zona_nombre": "$zona_nombre",
            "depa_id": "$depa_id",
            "depa_nombre": "$depa_nombre", 
            "rubr_id": "$rubr_id",
            "tist_id": "$tist_id",
            "@solicitanteTransporteGetTipoCarga": "$sotr_id->sotr_id"	            
          }
        ]
    }
  }

-- (generadores)solicitanteTransporteGet(por soco_id)

  recurso: /solicitantesTransporte/solicitante/contenedor/{soco_id}

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

-- (generadores)solicitanteTransporteGetPorUsr(MODIFICADO HARDCODEADO SOLO A SOTR_ID)
  recurso: /solicitantesTransporte/{usuario_app}  (ej: /solicitantesTransporte/hugoDS)
  metodo: get
  select sotr_id 
  from log.solicitantes_transporte ST
  where ST.user_id = (select U.email from seg.users U
                      where U.usernick = :usuario_app)

  {
    "solicitantes_transporte": {     
            "sotr_id": "$sotr_id"
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
  razon_social=:razon_social, cuit=:cuit, domicilio = :domicilio, num_registro=:num_registro, lat=:lat, lng=:lng, usuario_app=:usuario_app, zona_id=CAST(:zona_id AS INTEGER), rubr_id=:rubr_id, tist_id=:tist_id
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
  

-- (generadores)solicitanteTransporteGetPorCaseId (CABECERA GENERADOR->SOLICITUD CONTENEDORES)
  recurso: /solicitantesTransporte/case/{case_id}
  metodo: get

  select  ST.sotr_id, ST.razon_social, ST.cuit, ST.domicilio, ST.num_registro,
		TTIPO.valor as tipo_generador,
		DEPA.nombre as departamento,
		ZONA.nombre as zona,
		TRUB.valor as rubro
  from
      log.solicitantes_transporte ST,
      core.tablas TTIPO,
      core.departamentos DEPA,
      core.zonas ZONA,
      core.tablas TRUB
  where ST.sotr_id = (select SC.sotr_id from log.solicitudes_contenedor SC where SC.case_id = :case_id)
  and ST.tist_id = TTIPO.tabl_id 
  and ST.depa_id = DEPA.depa_id
  and ST.zona_id = ZONA.zona_id
  and ST.rubr_id = TRUB.tabl_id

  {
    "generador":{
      "sotr_id": "$sotr_id",
      "razon_social": "$razon_social",
      "cuit": "$cuit",
      "domicilio": "$domicilio",
      "num_registro": "$num_registro",
      "tipo_generador": "$tipo_generador",
      "departamento": "$departamento",
      "zona": "$zona",
      "rubro": "$rubro",
      "@solicitanteTransporteGetTipoCarga": "$sotr_id->sotr_id"
    }
  }

-- (generadores)solicitanteTransporteGetPorCaseIdRetiro(CABECERA GENERADOR->RETIRO CONTENEDORES)
  recurso: /solicitantesTransporte/proceso/retiro/case/{case_id}
  metodo:

  select  ST.sotr_id, ST.razon_social, ST.cuit, ST.domicilio, ST.num_registro,
          TTIPO.valor as tipo_generador,
          DEPA.nombre as departamento,
          ZONA.nombre as zona,
          TRUB.valor as rubro
  from
        log.solicitantes_transporte ST,
        core.tablas TTIPO,
        core.departamentos DEPA, 
        core.zonas ZONA,
        core.tablas TRUB
  where      
      ST.sotr_id = (select SR.sotr_id from log.solicitudes_retiro SR where SR.case_id = :case_id)
  and 
      ST.tist_id = TTIPO.tabl_id	
  and
      ST.depa_id = DEPA.depa_id
  and 
      ST.zona_id = ZONA.zona_id 
  and
      ST.rubr_id = TRUB.tabl_id
  and 
      ST.eliminado = 0

  {
    "generador":{
      "sotr_id": "$sotr_id",
      "razon_social": "$razon_social",
      "cuit": "$cuit",
      "domicilio": "$domicilio",
      "num_registro": "$num_registro",
      "tipo_generador": "$tipo_generador",
      "departamento": "$departamento",
      "zona": "$zona",
      "rubro": "$rubro",
      "@solicitanteTransporteGetTipoCarga": "$sotr_id->sotr_id"
    }
  }

-- (generadores)solicitanteTransporteGetPorCaseIdIngreso(CABECERA GENERADOR->INGRESO CONTENEDORES)

  recurso: /solicitantesTransporte/proceso/ingreso/case/{case_id}
  metodo: get

  select  ST.sotr_id, ST.razon_social, ST.cuit, ST.domicilio, ST.num_registro,
          TTIPO.valor as tipo_generador,
          DEPA.nombre as departamento,
          ZONA.nombre as zona,
          TRUB.valor as rubro
  from 
        log.solicitantes_transporte ST,
        core.tablas TTIPO,
        core.departamentos DEPA, 
        core.zonas ZONA,
        core.tablas TRUB
  where      
      ST.sotr_id = (select OT.sotr_id 
                    from log.ordenes_transporte OT
                    where OT.case_id = :case_id)
  and 
      ST.tist_id = TTIPO.tabl_id	
  and 
      ST.depa_id = DEPA.depa_id
  and 
      ST.zona_id = ZONA.zona_id 
  and 
      ST.rubr_id = TRUB.tabl_id 
  and 
      ST.eliminado = 0

  {
    "generador":{
      "sotr_id": "$sotr_id",
      "razon_social": "$razon_social",
      "cuit": "$cuit",
      "domicilio": "$domicilio",
      "num_registro": "$num_registro",
      "tipo_generador": "$tipo_generador",
      "departamento": "$departamento",
      "zona": "$zona",
      "rubro": "$rubro",
      "@solicitanteTransporteGetTipoCarga": "$sotr_id->sotr_id"
    }
  }

-- (generadores)solicitanteTransporteGetTipoCarga (CABECERA GENERADOR Y LISTADO GENERAL)
  recurso: no hay recurso asociado solo la query
  metodo: 

  select T.valor, T.tabl_id 
  from log.tipos_carga_generadores TCG, core.tablas T
  where TCG.tica_id = T.tabl_id 
  and TCG.sotr_id = CAST(:sotr_id as INTEGER)


  {"tiposCarga":    
    {
      "carga":[
        {
        "tabl_id": "$tabl_id",
        "valor": "$valor" 		
        } 
      ]
    }
  } 

-- (generadores)solicitanteTransporteSetTipoCarga
  recurso: /_post_solicitantestransporte_tipocarga_batch_req
  metodo: post

  insert into log.tipos_carga_generadores(sotr_id, tica_id) 
  values(cast(:sotr_id as INTEGER), :tica_id)

  -- contrato json
  {
    "_post_solicitantestransporte_tipocarga_batch_req":{
        "_post_solicitantestransporte_tipocarga":[
          {
            "sotr_id": "40",
            "tica_id": "tipo_cargaResiduos Patologicos"
          }
        ]
    }
  }

-- (generadores)solicitanteTransporteDeleteTipoCarga
  recurso: /solicitantesTransporte/tipoCarga
  metodo: delete
  delete from log.tipos_carga_generadores where sotr_id = cast(:sotr_id as integer)  
  
  -- ejemplo contrato
  {
    "_delete_solicitantestransporte_tipocarga":{
      "sotr_id": "40"
    }
  }


-- incidenciaSet

   recurso: /incidencias
   metodo: post

  insert
    into
    ins.incidencias (descripcion,
    fecha,
    num_acta,
    adjunto,
    usuario_app,
    tiin_id,
    tica_id,
    difi_id,
    ortr_id)
  values(:descripcion,
    to_date(:fecha,'YYYY-MM-DD'),
    :num_acta,
    :adjunto,
    :usuario_app,
    :tiin_id ,
    :tire_id ,
    :difi_id ,
    cast(:ortr_id as integer)) returning inci_id

  {"respuesta":{"incidencia":"$inci_id"}}

-- incidenciasGet
   recurso: /incidencias
   metodo: get

  select
    i.inci_id
    ,i.descripcion
    ,i.fecha
    ,i.num_acta
    ,i.adjunto
    ,i.usuario_app 
    ,ti.valor as tipo_incidencia
    ,tc.valor as tipo_carga
    ,td.valor as disposicion_final
    from
    ins.incidencias i
  left join  core.tablas ti on ti.tabl_id = i.tiin_id
  left join   core.tablas tc on tc.tabl_id = i.tica_id
  left join core.tablas td on td.tabl_id = i.difi_id 
    where
    i.eliminado = 0
  order by
    i.inci_id

  {
    "incidencias":{
        "incidencia":[
          {
              "inci_id":"$inci_id",
              "descripcion":"$descripcion",
              "fecha":"$fecha",
              "num_acta":"$num_acta",
              "adjunto":"$adjunto",
              "usuario_app":"$usuario_app",
              "tipo_incidencia":"$tipo_incidencia",
              "tipo_carga":"$tipo_carga",
              "disposicion_final":"$disposicion_final"
          }
        ]
    }
  }


-- incidenciasDelete

   recurso: /incidencias/{inci_id}
   metodo: delete

  update ins.incidencias
  set eliminado = 1
  where inci_id = :inci_id

  respuesta: 200 si ok


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


-- ordenTransporteListaxId
  recurso: /ordenesTransporte/lista/{ortr_id} 
  metodo: get

  select
    ot.ortr_id,
    ot.fec_retiro,
    ot.caseid,
    ot.fec_alta,
    st.razon_social ,
    st.cuit ,
    e.dominio ,
    c.chof_id
  from
    log.ordenes_transporte ot,
    log.solicitantes_transporte st ,
    log.choferes c ,
    core.equipos e
  where ot.sotr_id = st.sotr_id
  and ot.chof_id = c.documento 
  and ot.equi_id = e.equi_id
  and cast(ot.ortr_id as varchar) like '%'||:ortr_id || '%'

  {
    "ordenTransporte":{
        "ordenesTransporte":[
          {
              "ortr_id":"$ortr_id",
              "fec_retiro":"$fec_retiro",
              "caseid":"$caseid",
              "fec_alta":"$fec_alta",
              "razon_social":"$razon_social",
              "cuit":"$cuit",
              "dominio":"$dominio",
              "chof_id":"$chof_id"
          }
        ]
    }
  }


-- ordTransGetPorCase
  recurso: /ordenTransporte/case/{case_id}
  metodo: get

  select OT.ortr_id, OT.fec_retiro, OT.case_id, OT.fec_alta, 
  OT.difi_id, T.valor as difi_nombre, OT.sotr_id
  from log.ordenes_transporte OT, core.tablas T
  where OT.case_id = :case_id 
  and OT.difi_id = T.tabl_id

  {"ordenTransp":
    {
      "ortr_id": "$ortr_id",
      "fec_retiro": "$fec_retiro",
      "case_id": "$case_id",
      "fec_alta": "$fec_alta",
      "difi_id": "$difi_id",
      "difi_nombre": "$difi_nombre",
      "sotr_id": "$sotr_id"      
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

-- ordenTransporteInfoEntrega
  recurso: /ordenTransporte/info/entrega/case/{case_id}
  metodo: get

  select OT.ortr_id, OT.fec_alta,
        E.dominio, E.descripcion, E.imagen as img_vehiculo, E.tara ,
        CH.imagen as img_chofer, concat(CH.nombre, ' ', CH.apellido) as nom_chofer, CH.documento
  from log.ordenes_transporte OT, core.equipos E, log.choferes CH
  where OT.case_id = :case_id 
  and OT.equi_id = E.equi_id 
  and OT.chof_id = CH.documento 
  and OT.eliminado = 0

  {
    "ordenTransporte":{
      "ortr_id": "$ortr_id",
      "fec_alta": "$fec_alta",
      "dominio": "$dominio",
      "descripcion": "$descripcion",
      "img_vehiculo": "$img_vehiculo",
      "tara": "$tara",
      "img_chofer": "$img_chofer",
      "nom_chofer": "$nom_chofer",
      "documento": "$documento"      
    }
  }

-- getOrdenTransporteNicks" 
   recurso /ordenTransporte/nicks/{ortr_id}
   metodo GET

SELECT u1.usernick tran_nick, u2.usernick sotr_nick
FROM log.ordenes_transporte ot 
,log.solicitantes_transporte st 
,log.transportistas tr
,seg.users u1
,seg.users u2
WHERE ot.ortr_id =  CAST ( :ortr_id AS integer)
AND tr.tran_id = ot.tran_id 
AND st.sotr_id = ot.sotr_id 
AND u1.email = tr.user_id 
AND u2.email = st.user_id</sql>

resultado
{
 "ordenTransporte": {
 "tran_nick": "$tran_nick",
 "sotr_nick": "$sotr_nick"
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


-- solicitudContenedorGetInfo (CABECERA PROCCESO->SOLICITUD CONTENEDORES)
  recurso: /solicitudContenedores/info/{case_id}
  metodo: get
  select 
  SC.soco_id, SC.estado, SC.observaciones, SC.fec_alta, SC.sotr_id,
  ST.razon_social, ST.domicilio 
  from log.solicitudes_contenedor SC, log.solicitantes_transporte ST
  where SC.sotr_id = ST.sotr_id 
  and SC.case_id = :case_id 
  and SC.eliminado = 0

  {
    "solicitud":{
      "soco_id": "$soco_id",
      "estado": "$estado",
      "observaciones": "$observaciones",
      "fec_alta": "$fec_alta",
      "sotr_id": "$sotr_id",
      "razon_social": "$razon_social",
      "domicilio": "$domicilio"
    } 
  }
  

-- solicitudContenedoresSetMotivo
  recurso: /contenedoresSolicitados/rechazados/motivo
  metodo: put
  update log.contenedores_solicitados
  set motivo_rechazo = :motivo_rechazo
  where soco_id = CAST(:soco_id as INTEGER)

  {
    "_put_contenedoressolicitados_rechazados_motivo":{
      "motivo_rechazo": "motivo ejemplo",
      "soco_id": "78"
    }
  }

-- solicitudContenedoresPorCase
  recurso: /contenedoresSolicitados/case/{case_id}
  metodo: get
  select cs.coso_id, cs.cantidad, cs.fec_alta,  cs.tica_id, cs.soco_id, cs.reci_id, cs.cantidad_acordada,
  t.valor, cs.motivo_rechazo
  from log.contenedores_solicitados cs, core.tablas t
  where cs.soco_id = (select soco_id from log.solicitudes_contenedor sc where sc.case_id = :case_id )
  and cs.tica_id = t.tabl_id

  {
    "contenedores":{
      "contenedor":[  		
        {
        "coso_id": "$coso_id",
        "cantidad": "$cantidad",
        "fec_alta": "$fec_alta",
        "tica_id": "$tica_id",
        "soco_id": "$soco_id",
        "reci_id": "$reci_id",
        "cantidad_acordada": "$cantidad_acordada",
        "valor": "$valor",
        "motivo_rechazo": "$motivo_rechazo"
        }
      ]
    }
  }

--getSolicitudContenedorNicks" 
  recurso: /solicitudContenedor/nicks/{soco_id}
  metodo: get

SELECT u1.usernick tran_nick, u2.usernick sotr_nick
FROM log.solicitudes_contenedor sc  
,log.solicitantes_transporte st 
,log.transportistas tr
,seg.users u1
,seg.users u2
WHERE sc.soco_id =  CAST ( :soco_id AS integer)
AND tr.tran_id = sc.tran_id  
AND st.sotr_id = sc.sotr_id  
AND u1.email = tr.user_id 
AND u2.email = st.user_id</sql>
resultado

{
 "solicitudContenedor": {
 "tran_nick": "$tran_nick",
 "sotr_nick": "$sotr_nick"
 }
}



-- solicitudContenedorEstadoUpdate" 
    recurso PUT /solicitudesContenedor/estado


    update log.solicitudes_contenedor
set estado = :estado
where soco_id = cast(:soco_id as integer)

    retorna 200 si ok

  {"_put_solicitudescontenedor_estado":{
    "soco_id":"114",
    "estado":"SOLICITADA"
  }
  }



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




--ordenTransporteEstadoUpdate" 
  update log.ordenes_transporte
set estado = :estado
where ortr_id = cast(:ortr_id as integer)

  {"_put_ordenesTransporte_estado":{
    "ortr_id":"21",
    "estado":"SOLICITADA"
  }
  }

  retorna
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



--templatesOrdenTransporteListGet
  GET /templatesOrdenTransporte/list/solicitanteTransporte/{sotr_id}
  SELECT
    tot.teot_id
    , zo.descripcion zona
    , zo.zona_id zona_id
    , ci.codigo || ' ' || ci.descripcion circuito
    , ci.zona_id
          , ci.circ_id circ_id
    , t.valor tipo_carga
    , t.tabl_id tica_id
    , t2.valor disposicion_final
    , t2.tabl_id difi_id
    , tr.descripcion || ' cuit:' || tr.cuit transportista
    , tr.tran_id tran_id
    , ch.documento chof_id
    , ch.apellido || ', ' || ch.nombre nombre_chofer
    , eq.dominio || ' ' || eq.codigo || ' ' || eq.marca || ' ' || eq.descripcion equipo
    , eq.equi_id equi_id
    , eq.cont_id cont_id
    , ot.ortr_id 
  FROM
    log.circuitos ci
  LEFT JOIN core.zonas zo ON
    zo.zona_id = ci.zona_id
    , log.templates_orden_transporte tot
  LEFT JOIN log.ordenes_transporte ot ON tot.teot_id = ot.teot_id 
  AND date_trunc('day',ot.fec_alta) = date_trunc('day',now()) 
    , log.choferes ch
    , core.tablas t
    , core.tablas t2
    , log.transportistas tr
    , core.equipos eq
  WHERE
    tot.chof_id = ch.documento
    AND tot.circ_id = ci.circ_id
    AND tot.tica_id = t.tabl_id
    AND tot.difi_id = t2.tabl_id
    AND tot.equi_id = eq.equi_id
    AND eq.tran_id = tr.tran_id
          AND tot.eliminado = 0
    AND tot.sotr_id = CAST(:sotr_id AS integer)

  Respuesta:
  {"templatesOrdenTransporte": {"templateOrdenTransporte": [
        {
        "transportista": "transportista 2 cuit:123456",
        "tica_id": "tipo_cargaResiduos Quimicos",
        "circ_id": "148",
        "tran_id": "47",
        "ortr_id": null,
        "tipo_carga": "Residuos Quimicos",
        "zona_id": "109",
        "equi_id": "39",
        "zona": "desc",
        "nombre_chofer": "led, pepe",
        "circuito": "1IIMZ desc",
        "chof_id": "2134545",
        "equipo": "wqe324 wqwer peugeot automovil",
        "difi_id": "disposicion_finalPTA",
        "teot_id": "17",
        "disposicion_final": "PTA",
        "cont_id": null
    },
        {
        "transportista": "transportista 2 cuit:123456",
        "tica_id": "tipo_cargaResiduos Quimicos",
        "circ_id": "168",
        "tran_id": "47",
        "ortr_id": null,
        "tipo_carga": "Residuos Quimicos",
        "zona_id": "109",
        "equi_id": "39",
        "zona": "desc",
        "nombre_chofer": "Fierro Delgado, Rosamel",
        "circuito": "BtaW444 desc123",
        "chof_id": "21206850",
        "equipo": "wqe324 wqwer peugeot automovil",
        "difi_id": "disposicion_finalPTA",
        "teot_id": "13",
        "disposicion_final": "PTA",
        "cont_id": null
    },
        {
        "transportista": "transportista 2 cuit:123456",
        "tica_id": "tipo_cargaResiduos Quimicos",
        "circ_id": "176",
        "tran_id": "47",
        "ortr_id": null,
        "tipo_carga": "Residuos Quimicos",
        "zona_id": "117",
        "equi_id": "39",
        "zona": "desc",
        "nombre_chofer": "Fierro Delgado, Rosamel",
        "circuito": "45545 circuito 5151",
        "chof_id": "21206850",
        "equipo": "wqe324 wqwer peugeot automovil",
        "difi_id": "disposicion_finalPTA",
        "teot_id": "8",
        "disposicion_final": "PTA",
        "cont_id": null
    },
        {
        "transportista": "una empresa soida como el agua cuit:2022020202",
        "tica_id": "tipo_cargaEscombros",
        "circ_id": "186",
        "tran_id": "51",
        "ortr_id": null,
        "tipo_carga": "Escombros",
        "zona_id": null,
        "equi_id": "43",
        "zona": null,
        "nombre_chofer": "led, pepe",
        "circuito": "BtaW445thk dfssg",
        "chof_id": "2134545",
        "equipo": "APT345 23456 Iveco Camion Rojo",
        "difi_id": "disposicion_finalPTA",
        "teot_id": "18",
        "disposicion_final": "PTA",
        "cont_id": null
    },
        {
        "transportista": "una empresa soida como el agua cuit:2022020202",
        "tica_id": "tipo_cargaOrganico",
        "circ_id": "149",
        "tran_id": "51",
        "ortr_id": null,
        "tipo_carga": "Organico",
        "zona_id": "110",
        "equi_id": "42",
        "zona": "we",
        "nombre_chofer": "led, pepe",
        "circuito": "123abcd6 descripcion",
        "chof_id": "2134545",
        "equipo": "TKG123 234457676786 Chevrolet Camion Verde",
        "difi_id": "disposicion_finalPTA",
        "teot_id": "7",
        "disposicion_final": "PTA",
        "cont_id": null
    }
  ]}}

--templateOrdenTransporteGet
  recurso /templatesOrdenTransporte/{teot_id}
  SELECT
    tot.teot_id
    , zo.descripcion zona
    , zo.zona_id zona_id
    , ci.codigo || ' ' || ci.descripcion circuito
    , ci.zona_id
          , ci.circ_id circ_id
    , t.valor tipo_carga
    , t.tabl_id tica_id
    , t2.valor disposicion_final
    , t2.tabl_id difi_id
    , tr.descripcion || ' cuit:' || tr.cuit transportista
    , tr.tran_id tran_id
    , ch.documento chof_id
    , ch.apellido || ', ' || ch.nombre nombre_chofer
    , eq.dominio || ' ' || eq.codigo || ' ' || eq.marca || ' ' || eq.descripcion equipo
    , eq.equi_id equi_id
    , eq.cont_id cont_id
    , ot.ortr_id 
  FROM
    log.circuitos ci
  LEFT JOIN core.zonas zo ON
    zo.zona_id = ci.zona_id
    , log.templates_orden_transporte tot
  LEFT JOIN log.ordenes_transporte ot ON tot.teot_id = ot.teot_id 
  AND date_trunc('day',ot.fec_alta) = date_trunc('day',now()) 
    , log.choferes ch
    , core.tablas t
    , core.tablas t2
    , log.transportistas tr
    , core.equipos eq
  WHERE
    tot.chof_id = ch.documento
    AND tot.circ_id = ci.circ_id
    AND tot.tica_id = t.tabl_id
    AND tot.difi_id = t2.tabl_id
    AND tot.equi_id = eq.equi_id
    AND eq.tran_id = tr.tran_id
  AND tot.eliminado = 0
  and tot.teot_id = cast(:teot_id as integer)

  Respuesta:
  {"templateOrdenTransporte": {
    "transportista": "transportista 2 cuit:123456",
    "tica_id": "tipos_cargaResiduos Urbanos",
    "circ_id": "182",
    "tran_id": "47",
    "ortr_id": "74",
    "tipo_carga": "Residuos Urbanos",
    "zona_id": null,
    "equi_id": "40",
    "zona": null,
    "nombre_chofer": ", sergio",
    "circuito": "2345qwer qwrqr",
    "chof_id": "23565",
    "equipo": "asf 34 asf asd",
    "difi_id": "disposicion_finalPTA",
    "teot_id": "1",
    "disposicion_final": "PTA",
    "cont_id": null
  }}

--templateOrdenTransporteSet
  recurso /semaresiduosDS/templatesOrdenTransporte 
  INSERT
    INTO
    log.templates_orden_transporte ( observaciones, usuario_app, circ_id, equi_id, chof_id, tica_id, difi_id, sotr_id )
  VALUES( :observaciones, :usuario_app, CAST(:circ_id AS integer), CAST( :equi_id AS integer), :chof_id, :tica_id, :difi_id, CAST( :sotr_id AS integer) ) returning teot_id

  {
  "_post_templatesOrdenTransporte":{
  "observaciones":"sarcangue",
  "usuario_app":"usuario_app",
  "circ_id":"182",
  "chof_id":"23565",
  "equi_id":"40",
  "tica_id":"tipos_cargaResiduos Urbanos",
  "difi_id":"disposicion_finalPTA",
  "sotr_id":"39"}
  }

  Respuesta:
  {"respuesta": {"teot_id": "3"}}

--templatesOrdenTransporteUpdate
  recurso PUT /templatesOrdenTransporte
  UPDATE log.templates_orden_transporte
  SET observaciones=:observaciones
  , usuario_app=:usuario_app
  , circ_id=cast(:circ_id AS integer)
  , equi_id=cast(:equi_id AS integer)
  , chof_id=:chof_id 
  , tica_id=:tica_id 
  , difi_id=:difi_id 
  WHERE teot_id = CAST(:teot_id AS integer);

  {
  "_put_templatesOrdenTransporte":{
  "observaciones":"sarcangue",
  "usuario_app":"usuario_app",
  "circ_id":"182",
  "chof_id":"23565",
  "equi_id":"40",
  "tica_id":"tipos_cargaResiduos Urbanos",
  "difi_id":"disposicion_finalPTA",
  "teot_id":"1"}
  }

  Respuesta
  HTTP/1.1 202 Accepted

--templateOrdenTransporteDelete
  recurso DELETE /templatesOrdenTransporte 

  UPDATE log.templates_orden_transporte
  SET eliminado = 1
  WHERE teot_id = CAST(:teot_id AS integer);

  {"_delete_templateOrdenTransporte":{
    "teot_id":"1"
  }
  }

  Respuesta
  HTTP/1.1 202 Accepted


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

-- transportistaGetIdPorNick(devuelve id de transportista por nick para helper sesion)
  recurso: /transportista/id/{usernick}
  metodo: get
  select T.tran_id
  from log.transportistas T
  where T.user_id = (select U.email
            from seg.users U
            where U.usernick = :usernick)

  --respuesta
  {
    "transportista":{
      "tran_id": "$tran_id"
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


-- transportistaGetPorCaseId
  recurso: /transportistas/case/{case_id}
  metodo: get

  select 
	TR.razon_social, TR.cuit, TR.direccion, TR.resolucion, TR.registro 
  from log.transportistas TR
  where TR.tran_id = (select SC.tran_id from log.solicitudes_contenedor SC where case_id = :case_id)
  
  {
    "transportista":{
      "razon_social": "$razon_social",
      "cuit": "$cuit",
      "direccion": "$direccion",
      "resolucion": "$resolucion",
      "registro": "$registro"
    }  
  }

-- transportistaGetPorCaseIdRetiro(CABECERA TRANSPORTISTA -> RETIRO CONTENEDORES)
  recurso: /transportistas/proceso/retiro/case/{case_id}
  metodo:

  select TR.razon_social, TR.cuit, TR.direccion, TR.resolucion, TR.registro 
  from log.transportistas TR, log.contenedores C
  where TR.tran_id = C.tran_id 
  and C.cont_id = (select CE.cont_id 
          from log.contenedores_entregados CE
          where CE.sore_id = (select SR.sore_id 
                    from log.solicitudes_retiro SR 
                    where SR.case_id  = :case_id)
          order by Ce.cont_id limit 1)


  {
    "transportista":{
      "razon_social": "$razon_social",
      "cuit": "$cuit",
      "direccion": "$direccion",
      "resolucion": "$resolucion",
      "registro": "$registro"
    }  
  }


-- transportistaGetPorCaseIdIngreso(CABECERA TRANSPORTISTA -> INGRESO CONTENEDORES)  
  recurso: /transportistas/proceso/ingreso/case/{case_id}
  metodo: get

  select TR.razon_social, TR.cuit, TR.direccion, TR.resolucion, TR.registro 
  from log.transportistas TR
  where tran_id = (select OT.tran_id 
            from log.ordenes_transporte OT
            where OT.case_id = :case_id )

  {
    "transportista":{
      "razon_social": "$razon_social",
      "cuit": "$cuit",
      "direccion": "$direccion",
      "resolucion": "$resolucion",
      "registro": "$registro"
    }  
  }







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

-- solicitudRetiroGetPorCaseRetiro (CABECERA PROCESO-> RETIRO CONTENEDORES)
  resurso: /solicitudRetiro/proceso/retiro/case/{case_id}
  metodo:
  select SR.sore_id, SR.fec_alta 
  from log.solicitudes_retiro SR
  where case_id = :case_id 

  {
    "solicitud_retiro":{
      "sore_id": "$sore_id",
      "fec_alta": "$fec_alta"
  }
    }

--solicitudRetiroEstadoUpdate
  update log.solicitudes_retiro
  set estado = :estado
  where sore_id = cast(:sore_id as integer)

  {"_put_solicitudesretiro_estado":{
    "sore_id":"24",
    "estado":"SOLICITADA"
  }
  }

  retorna 200 si ok



-- getSolicitudRetiroNicks" useConfig="semaresiduosDS">
   recurso /solicitudRetiro/nicks/{sore_id}
   metodo GET

SELECT u1.usernick tran_nick, u2.usernick sotr_nick
FROM log.solicitudes_retiro sr   
,log.solicitantes_transporte st 
,log.transportistas tr
,log.contenedores_entregados ce
,log.contenedores c 
,seg.users u1
,seg.users u2
WHERE sr.sore_id =  CAST ( :sore_id AS integer)
AND st.sotr_id = sr.sotr_id   
AND ce.sore_id = sr.sore_id
AND c.cont_id =ce.cont_id 
AND c.tran_id = tr.tran_id 
AND u1.email = tr.user_id 
AND u2.email = st.user_id 
LIMIT 1

resultado
{
 "solicitudRetiro": {
 "tran_nick": "$tran_nick",
 "sotr_nick": "$sotr_nick"
 }
}


-- updateSolicitudRetiroContenedores
  recurso:
  metodo:
  update log.contenedores_entregados set sore_id = CAST(:sore_id AS INTEGER), porc_llenado = CAST(:porc_llenado AS FLOAT4), mts_cubicos = CAST(:mts_cubicos AS FLOAT4)  
  where cont_id = CAST(:cont_id AS INTEGER) 


-- vehiculosGetActivos
  recurso: /vehiculos
  metodo: get
  select equi_id, descripcion, marca, dominio, codigo, ubicacion, tran_id, fecha_ingreso,  from core.equipos where estado = 'AC'

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

-- vehiculoAsignadoARetiro
  recurso: /vehiculo/asignadoARetiro/{dominio}/solicitanteTransporte/{sotr_id}
  metodo : get

  select eq.dominio dominio, eq.codigo codigo , eq.marca ||' '||eq.descripcion descripcion;  , :sotr_id sotr_id ;       , eq.equi_id equi_id       , eq.tran_id tran_id from core.equipos eq where eq.dominio = :dominio

  subquery contenedoresARetirarPorEquipoGet

  select ce.cont_id        ,t.valor tipo_carga       ,ce.porc_llenado        ,ce.mts_cubicos from log.contenedores_entregados ce	,core.tablas t 	,core.equipos eq	,log.solicitudes_retiro sr where eq.equi_id = ce.equi_id and ce.equi_id = cast(:equi_id as integer) and ce.sore_id = sr.sore_id and sr.sotr_id = cast(:sotr_id as integer)and ce.tica_id =t.tabl_id and ce.ortr_id is null

  {"vehiculoAsignadoARetiro": {
      "descripcion": "peugeot automovil",
      "codigo": "wqwer",
      "contenedores": {
        "contenedor": [   {
            "mts_cubicos": "300",
            "tipo_carga": "Organico",
            "cont_id": "104",
            "porc_llenado": "40"
        }]},
      "dominio": "wqe324",
      "tran_id": "47"
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
//TODO: BORRAR NO SE USA (REVISAR)bORRADO DE dev
-- vehiculosGetPorTransportistaUsr

  recurso: /vehiculos/transp/usr/{usuario_app}
  metodo: get

  select E.equi_id, E.descripcion, E.marca, E.dominio
  from core.equipos E
  where E.tran_id = (select TR.tran_id
                      from log.transportistas TR
                      where TR.usuario_app = :usuario_app)
  and estado = 'AC'

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
 
  insert into core.equipos (descripcion, marca, codigo, ubicacion, tran_id, dominio, fecha_ingreso, tara, imagen, cont_id)
        SELECT :descripcion, :marca, :codigo, :ubicacion, CAST(:tran_id AS INTEGER), :dominio, TO_DATE(:fecha_ingreso,'YYYY-MM-DD'), CAST(:tara as float8), :imagen,
        CASE
          WHEN cont.ID = 'X'
            THEN NULL
          ELSE CAST (cont.id AS integer)
        END
        FROM  (SELECT :cont_id ID) cont
  returning equi_id



  {
    "_post_vehiculos":{
      "descripcion": "Carreton grande",
      "marca": "MAC",
      "codigo": "8924ef",
      "ubicacion": "casa central",
      "tran_id": "3",
      "dominio": "AMD 456",
      "fecha_ingreso": "2020-05-21",
      "tara": "200.50",
      "imagen": "",
      "cont_id": "127"
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

  update core.equipos set descripcion = :descripcion, marca = :marca, codigo = :codigo, ubicacion = :ubicacion, tran_id = CAST(:tran_id AS INTEGER), dominio = :dominio, fecha_ingreso = TO_DATE(:fecha_ingreso,'YYYY-MM-DD')), tara = CAST(:tara as float8), imagen = :imagen
  where equi_id = CAST(:equi_id AS INTEGER)


  update core.equipos set descripcion = :descripcion, marca = :marca, codigo = :codigo, ubicacion = :ubicacion, tran_id = CAST(:tran_id AS INTEGER), dominio = :dominio, fecha_ingreso = TO_DATE(:fecha_ingreso,'YYYY-MM-DD'), tara = CAST(:tara as float8), imagen = :imagen
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
      "fecha_ingreso": "2020-05-21",
      "tara": "2000.000",
      "imagen": ""
    }
  }


-- vehiculosGetImagen

  recurso: /vehiculos/imagen/{equi_id}
  metodo: get
  select imagen from core.equipos where equi_id = CAST(:equi_id AS INTEGER)
  {
    "vehiculos":{
      "imagen": "$imagen"
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



-- ************************ APPI Y BONITA ***************************
  ************ ROLESSS
  GET http://10.142.0.7:8280/tools/bpm/roles/{session}

  {
    "session": "X-Bonita-API-Token=658fcd51-ef8b-48c3-9606-1d89a88cf3e5;JSESSIONID=BCDEA4A05749709F4DFBDCBB58A527E8;bonita.tenant=1;",
    "payload":    [
              {
          "displayName": "Administrativo depósito",
          "name": "Administrativo depósito",
          "icon": "",
          "description": "",
          "id": "233",
          "creation_date": "2020-02-12 16:45:09.755",
          "created_by_user_id": "7",
          "last_update_date": "2020-02-12 16:45:09.755"
        },
              {
          "displayName": "Almacen",
          "name": "Almacen",
          "icon": "",
          "description": "",
          "id": "5",
          "creation_date": "2019-09-09 20:22:33.960",
          "created_by_user_id": "-1",
          "last_update_date": "2019-09-09 20:22:33.960"
        } // mas datooooooooooosssssssssss
      ]
  }

-- ************ GRUPOS
  GET http://10.142.0.7:8280/tools/bpm/groups/{session}
  {
    "session": "X-Bonita-API-Token=1c403034-f28d-43f5-92f6-24b2bd3b586c;JSESSIONID=A27D589BB33BB5C6A8AB283FA33DF618;bonita.tenant=1;",
    "payload":    [
              {
          "path": "/Dirección/Gerencia General/Abastecimiento",
          "displayName": "Abastecimiento",
          "parent_group_id": "202",
          "icon": "",
          "name": "Abastecimiento",
          "description": "",
          "parent_path": "/Dirección/Gerencia General",
          "creation_date": "2020-02-12 16:45:09.919",
          "id": "207",
          "created_by_user_id": "7",
          "last_update_date": "2020-02-12 16:45:09.919"
        },
              {
          "path": "/Dirección/Gerencia General/Administración y Finanzas",
          "displayName": "Administración y Finanzas",
          "parent_group_id": "202",
          "icon": "",
          "name": "Administración y Finanzas",
          "description": "",
          "parent_path": "/Dirección/Gerencia General",
          "creation_date": "2020-02-12 16:45:09.891",
          "id": "205",
          "created_by_user_id": "7",
          "last_update_date": "2020-02-12 16:45:09.891"
        },
              {
          "path": "/Dirección/Gerencia General/Producción/Jefatura Técnica/Arnado",
          "displayName": "Arnado",
          "parent_group_id": "213",
          "icon": "",
          "name": "Arnado",
          "description": "",
          "parent_path": "/Dirección/Gerencia General/Producción/Jefatura Técnica",
          "creation_date": "2020-02-12 16:45:09.955",
          "id": "214",
          "created_by_user_id": "7",
          "last_update_date": "2020-02-12 16:45:09.955"
        }
  ]
  }


-- ************ CREAR USUARIOS

  POST http://10.142.0.7:8280/tools/bpm/users 
  {
    "session":"asfjas",
    "payload":{
                "userName":"Rodo",
                "password":"bpm",
                "password_confirm":"bpm",
                "icon":"",
                "firstname":"Rodito",
                "lastname":"Selattraga",
                "title":"Sr",
                "job_title":"Human resources benefits",
                "manager_id":""
              }
  }

  respuesta
  {
    "session": "X-Bonita-API-Token=300c6472-73df-4b59-badb-786791d2e3a9;JSESSIONID=AB1D6B4DDBEC4A457B1E43E2A6708D8B;bonita.tenant=1;",
    "payload":{
                "firstname": "Rodito",
                "icon": "icons/default/icon_user.png",
                "creation_date": "2020-07-31 15:39:33.340",
                "userName": "Rodo",
                "title": "Sr",
                "created_by_user_id": "7",
                "enabled": "false",
                "lastname": "Selattraga",
                "last_connection": "",
                "password": "",
                "manager_id": "0",
                "id": "503",
                "job_title": "Human resources benefits",
                "last_update_date": "2020-07-31 15:39:33.340"
              }
  }


-- ************ CREAR MEMBERSHIPS

  POST http://10.142.0.7:8280/tools/bpm/memberships 
  {
    "session":"asfjas",
    "payload":{
                "user_id":"503",
                "group_id":"5",
                "role_id":"1"
              }
  }

  respuesta
  {
    "session": "X-Bonita-API-Token=4e634a72-f990-46fe-bf7e-3b2dcf931b88;JSESSIONID=8F914E1EF70E23B71F5A96F9F8B168EB;bonita.tenant=1;",
    "payload":    {
        "assigned_date": "2020-07-31 15:42:59.428",
        "user_id": "503",
        "role_id": "1",
        "group_id": "5",
        "assigned_by_user_id": "7"
    }
  }



-- ************ ID DE USUARIO POR NOMBRE
  cuando consultes el api de ID de usuario por nombre te voy a devolver esssssssta

  {
    "last_connection":"",
    "created_by_user_id":"-1",
    "creation_date":"2014-12-01 10:39:55.177",
    "id":"21",
    "icon":"/default/icon_user.png",
    "enabled":"true",
    "title":"Mrs",
    "professional_data":{
      "fax_number":"484-302-0430",
      "building":"70",
      "phone_number":"484-302-5430",
      "website":"",
      "zipcode":"19108",
      "state":"PA",
      "city":"Philadelphia",
      "country":"United States",
      "id":"21",
      "mobile_number":"",
      "address":"Renwick Drive",
      "email":"giovanna.almeida@acme.com",
      "room":""
    },
    "manager_id":{
      "last_connection":"",
      "created_by_user_id":"-1",
      "creation_date":"2014-12-01 10:39:55.136",
      "id":"17",
      "icon":"/default/icon_user.png",
      "enabled":"true",
      "title":"Mrs",
      "manager_id":"1",
      "job_title":"Vice President of Sales",
      "userName":"daniela.angelo",
      "lastname":"Angelo",
      "firstname":"Daniela",
      "password":"",
      "last_update_date":"2014-12-01 10:39:55.136"
    },
    "job_title":"Account manager",
    "userName":"giovanna.almeida",
    "lastname":"Almeida",
    "firstname":"Giovanna",
    "password":"",
    "last_update_date":"2014-12-01 10:39:55.177"
  } 



-- ************ MENU 

  GET http://10.142.0.7:8280/services/sema/COREDataService/menuitems/byUserId/202 

  {"menu_items": {"menu_item": [
        {
            "texto": "Producción",
            "camino": "1.PRD.produccion",
            "opcion": "produccion",
            "url_icono": "/img/icono.gif",
            "habilitado": "false",
            "opcion_padre": null,
            "modulo": "PRD",
            "nivel": "1",
            "url": "",
            "javascript": null,
            "texto_onmouseover": "Módulo de Producción"
        },
        {
            "texto": "Planificar Etapas",
            "camino": "1.PRD.produccion>10.PRD.etapas",
            "opcion": "etapas",
            "url_icono": "/img/icono.gif",
            "habilitado": "false",
            "opcion_padre": "produccion",
            "modulo": "PRD",
            "nivel": "2",
            "url": "/traz-prod-trazasoft/dash",
            "javascript": null,
            "texto_onmouseover": "Planificación de etapas"
        },
        {
            "texto": "Pantalla Operario",
            "camino": "1.PRD.produccion>20.PRD.aminowana",
            "opcion": "aminowana",
            "url_icono": "/img/icono.gif",
            "habilitado": "false",
            "opcion_padre": "produccion",
            "modulo": "PRD",
            "nivel": "2",
            "url": "/traz-prod-trazasoft/amino",
            "javascript": null,
            "texto_onmouseover": "Etapas operario"
        },
        {
            "texto": "Mantenimiento",
            "camino": "2.MAN.mantenimiento",
            "opcion": "mantenimiento",
            "url_icono": "/img/asset.gif",
            "habilitado": "true",
            "opcion_padre": null,
            "modulo": "MAN",
            "nivel": "1",
            "url": "",
            "javascript": null,
            "texto_onmouseover": "Asset loco"
        },
        {
            "texto": "Crear Orde de Trabajo",
            "camino": "2.MAN.mantenimiento>100.MAN.ot",
            "opcion": "ot",
            "url_icono": "/img/asset.gif",
            "habilitado": "false",
            "opcion_padre": "mantenimiento",
            "modulo": "MAN",
            "nivel": "2",
            "url": "/traz-prod-assetplanner/asset",
            "javascript": null,
            "texto_onmouseover": "Crear ot"
        },
        {
            "texto": "Reporte ot",
            "camino": "2.MAN.mantenimiento>100.MAN.ot>1000.MAN.reporte",
            "opcion": "reporte",
            "url_icono": "/img/repo.gif",
            "habilitado": "false",
            "opcion_padre": "ot",
            "modulo": "MAN",
            "nivel": "3",
            "url": "/traz-prod_assetplanner/reportes",
            "javascript": null,
            "texto_onmouseover": "Sheportes"
        },
        {
            "texto": "Almacenes",
            "camino": "4.ALM.almacenes",
            "opcion": "almacenes",
            "url_icono": "/img/icono.gif",
            "habilitado": "true",
            "opcion_padre": null,
            "modulo": "ALM",
            "nivel": "1",
            "url": "",
            "javascript": null,
            "texto_onmouseover": "Almacenes"
        },
        {
            "texto": "Stock Articulos",
            "camino": "4.ALM.almacenes>50.ALM.stock",
            "opcion": "stock",
            "url_icono": "/img/alm.gif",
            "habilitado": "false",
            "opcion_padre": "almacenes",
            "modulo": "ALM",
            "nivel": "2",
            "url": "/traz-prod-trazasoft/stock",
            "javascript": null,
            "texto_onmouseover": null
        }
  ]}}

-- ************ CONSULTAR USUARIO POR USRNICK

  GET http://10.142.0.7:8280/tools/bpm/users/{usuario}/session/{session}

  te retorna

  {
    "session":"X-Bonita-API-Token=7e2dbb6d-2261-4571-809e-d2b55144a75d;JSESSIONID=D82EE7AD27E388E1624433D7BE30BA07;bonita.tenant=1;",
    "payload":[
        {
          "firstname":"usrtest depo",
          "icon":"icons/default/icon_user.png",
          "creation_date":"2020-08-13 17:21:35.777",
          "userName":"userTestDepoChat",
          "title":"Sr",
          "created_by_user_id":"7",
          "enabled":"true",
          "lastname":"user test depo apell",
          "last_connection":"",
          "password":"",
          "manager_id":"0",
          "id":"607",
          "job_title":"Human resources benefits",
          "last_update_date":"2020-08-13 17:21:35.849"
        }
    ]
  }

  ejemplo de llamada

  http://10.142.0.7:8280/tools/bpm/users/userTestDepoChat/session/X-Bonita-API-Token%3D7e2dbb6d-2261-4571-809e-d2b55144a75d%3BJSESSIONID%3DD82EE7AD27E388E1624433D7BE30BA07%3Bbonita.tenant%3D1%3B




























