endpoint: 'http://pc-pc:8280/services/semaresiduosDS'	
-- departamentosSet
	recurso: /departamentos
  metodo: post
  insert into core.departamentos (nombre, descripcion) values(:nombre, :descripcion);
	
	{
		"departamentos":{
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
  where eliminado = 0  and zona_id = zona_id
  //TODO: TERMINAR Y REVISAR

  {  
    "zona":
        {
          "zona_id":"$zona_id",
          "nombre":"$nombre",
          "descripcion":"$descripcion",
          "depa_id": "$depa_id",
          "depa_nom": "$depa_nom"          
    }  
  }

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
    "zona":{
      "nombre": "Concepción", 
      "descripcion": "Zona Norte", 
      "imagen": "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN",
      "usuario_app": "hugoDS", 
      "depa_id": "1"
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

-- zonaUpdateImagen
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



-- transportistasSet
  recurso: /transportistas
  metodo: post

  insert into log.transportistas(razon_social,descripcion,direccion,telefono,contacto,resolucion,registro,fec_alta_efectiva,fec_baja_efectiva,usuario_app)
  values(:razon_social,:descripcion,:direccion,:telefono,:contacto,:resolucion,:registro,TO_DATE(:fec_alta_efectiva,'YYYY-MM-DD'),TO_DATE(:fec_baja_efectiva,'YYYY-MM-DD'),:usuario_app)
  returning tran_id
  {
    "transportista":{
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
          "usuario_app": "$usuario_app"
        }
      ]
    }
  }

-- transportistasGetTodo
  
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
   "transportista":{
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
  /* para eliminar un transportista en :eliminado = 1 caso contraio 0 */
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
        "cargas":[
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


-- vehiculosGetActivos
  recurso: /vehiculos
  metodo: get
  select equi_id, descripcion, marca, dominio from core.equipos where estado = 'AC'

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
  /vehiculos
  insert into core.equipos (descripcion, marca, codigo, ubicacion, tran_id, dominio)
  values(:descripcion, :marca, :codigo, :ubicacion, :tran_id, :dominio)
  returning equi_id
  
  {
    "equipo":{
      "descripcion": "Carreton grande",
      "marca": "MAC",
      "codigo": "8924ef",
      "ubicacion": "casa central",
      "tran_id": "3",
      "dominio": "AMD 456"
    }
  }
  
  {
    "respuesta":{
      "equi_id": "$equi_id"
    }
  }
-- circuitosGet
  recurso: /circuitos
  metodo: get
  
  select circ_id, codigo, descripcion, imagen, chof_id, vehi_id, zona_id from log.circuitos 
  
  {"circuitos":{
      "circuito":[
          {
          "circ_id": "$circ_id", 
          "codigo": "$codigo", 
          "descripcion": "$descripcion", 
          "imagen": "$imagen", 
          "chof_id": "$chof_id", 
          "vehi_id": "$vehi_id", 
          "zona_id": "$zona_id"
          }
      ]    
    }
  }  

-- circuitosSet
  recurso: /circuitos
  metodo: post
  insert into log.circuitos(codigo, descripcion, imagen, chof_id, vehi_id, zona_id)
  values(:circ_id, :codigo, :descripcion, :imagen, :chof_id, :vehi_id, :zona_id)

  {
   "circuito":{     
      "codigo":"Circ AA-00",
      "descripcion":"desc circuito",
      "imagen":"",
      "usuario_app": "hugoDS",
      "chof_id":"2",
      "vehi_id":"21",
      "zona_id":"5"
   }
  } 
  -- batch request para usar en zona set Probar no funciona en SoapUI
  {
    "_post_circuitos_batch_request":{
        "circuito":[
          {
              "codigo":"Circ AA-00",
              "descripcion":"desc circuito",
              "imagen":"",
              "usuario_app":"hugoDS",
              "chof_id":"4",
              "vehi_id":"22",
              "zona_id":"5"
          },
          {
              "codigo":"Circ BB-00",
              "descripcion":"desc circuito",
              "imagen":"",
              "usuario_app":"hugoDS",
              "chof_id":"6",
              "vehi_id":"23",
              "zona_id":"5"
          }
        ]
    }
  }


-- circuitosSetTiposCarga (ejecutar tablasSet como batch_request) 
  -- 

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


-- puntosPorCircuito
  recurso: /puntosCriticos/{circ_id}
  metodo: get

  select PC.pucr_id, PC.nombre, PC.descripcion, PC.lat, PC.lng 
  from log.puntos_criticos PC, log.circuitos_puntos_criticos CPC
  where PC.pucr_id = CPC.pucr_id 
  and CPC.circ_id = CAST(:circ_id AS INTEGER)

  {
    "puntos":{
      "punto":[
        {
          "pucr_id": "$pucr_id",
          "nombre": "$nombre",
          "descripcion": "$descripcion",
          "lat": "$lat",
          "lng": "$lng"
        }
      ]
    }
  }

-- choferesGet
  recurso: /choferes
  metodo: get
  
  select chof_id, nombre, apellido, documento, fec_nacimiento, direccion, celular, codigo, carnet, vencimiento, habilitacion, imagen, tran_id, cach_id  
  from log.choferes     
      
  {
    "choferes":{
        "chofere":[
          {
            "chof_id": "$chof_id", 
            "nombre": "$nombre", 
            "apellido": "$apellido", 
            "documento": "$documento", 
            "fec_nacimiento": "$fec_nacimiento", 
            "direccion": "$fec_nacimiento", 
            "celular": "$celular", 
            "codigo": "$codigo", 
            "carnet": "$carnet", 
            "vencimiento": "$vencimiento", 
            "habilitacion": "$habilitacion", 
            "imagen": "$imagen", 
            "tran_id": "$tran_id", 
            "cach_id": "$cach_id"
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
  insert into log.choferes(nombre, apellido, documento, fec_nacimiento, direccion, celular, codigo, carnet, vencimiento, habilitacion, imagen, tran_id, cach_id)
  values(:nombre, :apellido, :documento, TO_DATE(:fec_nacimiento,'YYYY-MM-DD'), :direccion, CAST(:celular AS INTEGER), CAST(:codigo AS INTEGER), :carnet, TO_DATE(:vencimiento,'YYYY-MM-DD'), :habilitacion, :imagen, CAST(:tran_id AS INTEGER), :cach_id)
  returning chof_id  

  {
    "chofer":{
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
   set nombre=:nombre, apellido=:apellido, documento=:documento, fec_nacimiento=TO_DATE(:fec_nacimiento,'YYYY-MM-DD'), direccion=:direccion, celular=CAST(:celular AS INTEGER), codigo=CAST(:codigo AS INTEGER), carnet=:carnet, vencimiento=TO_DATE(:vencimiento,'YYYY-MM-DD'), habilitacion=:habilitacion, tran_id=CAST(:tran_id AS INTEGER), cach_id=:cach_id 
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
       "tran_id": "2",
       "cach_id": "A1,A2,A3",
       "chof_id": "6"
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

-- choferesEstado
  recurso: /choferes/estado
  metodo: put
  
    update 
    log.choferes 
    set eliminado = CAST(:eliminado AS INTEGER)
    where chof_id = CAST(:chof_id AS INTEGER)

    {
      "estado_nuevo":{
          "chof_id":"2",
          "eliminado":"1"
      }
    }


-- contenedoresGet
  recurso: /contenedores
  metodo: get

  select cont_id, codigo, descripcion, capacidad, anio_elaboracion, tara, habilitacion, fec_alta, esco_id, reci_id from log.contenedores

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
              "habilitacion": "$habilitacion",
              "fec_alta": "$fec_alta",
              "esco_id": "$esco_id",
              "reci_id": "$reci_id"
            }
          ]
    }
  }

-- contenedoresSet
  recurso: /contenedores
  metodo: post
  insert into log.contenedores(codigo, descripcion, capacidad, anio_elaboracion, tara, habilitacion, fec_alta, usuario_app, esco_id, reci_id)
  values(CAST(:codigo as INTEGER), :descripcion, CAST(:capacidad as float8), CAST(:anio_elaboracion as INTEGER), CAST(:tara as float8), :habilitacion, TO_DATE(:fec_alta,'YYYY-MM-DD'), :usuario_app, :esco_id, CAST(:reci_id as INTEGER))

  {
    "contenedores":
      {
        "codigo": "56789",
        "descripcion": "contenedor 2",
        "capacidad": "56.89",
        "anio_elaboracion": "2010",
        "tara": "200.75",
        "habilitacion": "habilitacion 234h",
        "fec_alta": "2019-10-11",
        "usuario_app": "hugoDS",
        "esco_id": "escoActivo",
        "reci_id": "100"
      }
  }

  {"respuesta": {"cont_id": "8"}}

-- (generadores)solicitanteTransporteGet
  recurso: /solicitantesTransporte
  metodo: get
  select sotr_id, razon_social, cuit, domicilio, num_registro, lat, lng, zona_id, rubr_id, tist_id, tica_id
  from log.solicitantes_transporte

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

-- alternativa a get orden transporte
  select CE.fec_retiro, 
  from log.contenedores_entregados, core.tablas
  


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

-- puntosCriticosSet
  recurso: /puntosCriticos
  metodo: post
  insert into log.puntos_criticos (nombre, descripcion, lat, lng, usuario_app, zona_id) 
  values(:nombre, :descripcion, :lat, :lng, :usuario_app,cast(:zona_id as INTEGER))
  returning pucr_id

  {
    "puntos_criticos":{
      "nombre": "Puesto critico 3", 
      "descripcion": "probable descarga de vidrio", 
      "lat": "-31.5555", 
      "lng": "-31.8989", 
      "usuario_app": "hugoDs", 
      "zona_id": ""
    }
  }

  {
    "respuesta":{
      "pucr_id": "$pucr_id"
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


//TODO: ANOTACIONES 


  -- sector descarga es un deposito de trazasoft
  -- en bascula es un recipiente




