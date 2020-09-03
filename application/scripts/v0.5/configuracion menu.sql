-- truncado tablas menu

--Tareas
	--item tareas
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('PRO', 'tareas', 'Mis tareas', 'traz-comp-bpm/Proceso/index', NULL, 1, '/img/icono.gif', 'Mis tareas', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);

	--permisos de tareas
	INSERT INTO seg.memberships_menues (modulo, "opcion", "group", role, fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Transportista', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, "opcion", "group", role, fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Generador', '2020-09-02', 'postgres', 'hugoG');

	INSERT INTO seg.memberships_menues (modulo, "opcion", "group", role, fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Báscula', '2020-09-02', 'postgres', 'hugoG');

--depositos
	INSERT INTO seg.memberships_menues (modulo, "opcion", "group", role, fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - DF - Escombrera', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, "opcion", "group", role, fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - DF - Relleno Sanitario', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, "opcion", "group", role, fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRI - Chatarra', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, "opcion", "group", role, fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRI - RSU', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, "opcion", "group", role, fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRO - Industriales', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, "opcion", "group", role, fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRO - Ramas', '2020-09-02', 'postgres', 'hugoG');




--Gestion de Transportista
		--cabecera
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'transportista', 'Gestion de Transportista', '', NULL, 11, '/img/icono.gif', 'Módulo Gestión de Transportista', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);

		--items internos
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'transportista_abm', 'Registrar Contenedor', 'general/Estructura/Transportista/templateTransportistas', NULL, 10, '/img/icono.gif', 'Registrar Contenedor', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'transportista');
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'contenedor', 'Registrar Contenedor', 'general/Estructura/Contenedor/templateContenedores', NULL, 10, '/img/icono.gif', 'Registrar Contenedor', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'transportista');
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'vehiculo', 'Registrar Vehiculo', 'general/Estructura/Vehiculo/templateVehiculos', NULL, 10, '/img/icono.gif', 'Registrar Vehículo', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'transportista');
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'contenedor_entrega', 'Entrega Contenedor', 'sin link', NULL, 10, '/img/icono.gif', 'Entrega Contenedor', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'transportista');
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'chofer_abm', 'Registrar Chofer', 'general/Estructura/Chofer/templateChoferes', NULL, 10, '/img/icono.gif', 'Registrar Chofer', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'transportista');

	--Gestion de Ordenes de Transporte
		--cabecera
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'ordentransporte', 'Gestion Ord. Transporte', '', NULL, 12, '/img/icono.gif', 'Módulo Gestión de Orden Transporte', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);

		--items internos
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'zona_abm', 'Registrar Zona', 'general/Estructura/Zona/templateZonas', NULL, 12, '/img/icono.gif', 'Registrar Zona', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'ordentransporte');
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'circuito_abm', 'Registrar Circuito', 'general/Estructura/Circuito/templateCircuitos', NULL, 12, '/img/icono.gif', 'Registrar Circuito', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'ordentransporte');
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'orden_transporte_abm', 'Orden de Transporte', 'general/Estructura/OrdenTransporte/templateOrdentransporte', NULL, 12, '/img/icono.gif', 'Orden Transporte', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'ordentransporte');
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'recepcion_orden', 'Recepcion Orden', 'sin link', NULL, 12, '/img/icono.gif', 'Recepcion de Orden', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'ordentransporte');
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'incidencia_abm', 'ABM Incidencia', 'general/Estructura/Incidencia/templateIncidencia', NULL, 12, '/img/icono.gif', 'ABM Incidencia', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'ordentransporte');

--Gestion de Generadores
		--cabecera
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'generadores', 'Gestion de Generadores', '', NULL, 13, '/img/icono.gif', 'Módulo Gestion de Generadores', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);

		--items interno

	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'solicitud_contenedor', 'Solicitud de  Contenedor', 'general/transporte-bpm/Solicitud_Pedido/templateSolicitudPedidos', NULL, 13, '/img/icono.gif', 'Solicitud de Contenedor', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'generadores');
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'solicitud_retiro', 'Solicitud de Retiro', 'general/transporte-bpm/SolicitudRetiro/templateSolicitudRetiro', NULL, 13, '/img/icono.gif', 'Solicitud deRetiro', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'generadores');
	//FIXME:FALTA DE ACA EN ADELANTE
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'orden_transporte_abm', 'Orden de Transporte', 'general/Estructura/OrdenTransporte/templateOrdentransporte', NULL, 12, '/img/icono.gif', 'Orden Transporte', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'ordentransporte');



--*************************		PERMISOS MENU		**************************
--MODULO TRANSPORTISTAS
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'transportista', 'Secretaria Medio Ambiente San Juan', 'SMA - Transportista', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'contenedor', 'Secretaria Medio Ambiente San Juan', 'SMA - Transportista', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'vehiculo', 'Secretaria Medio Ambiente San Juan', 'SMA - Transportista', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'chofer_abm', 'Secretaria Medio Ambiente San Juan', 'SMA - Transportista', '2020-09-02', 'postgres', 'hugoG');

--MODULO GENERADORES
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'orden_transporte_abm', 'Secretaria Medio Ambiente San Juan', 'SMA - Generador', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'ordentransporte', 'Secretaria Medio Ambiente San Juan', 'SMA - Generador', '2020-09-02', 'postgres', 'hugoG');


--Registrar transportistas y generadores para administracion de secretaria
	--transportistas de admin
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'transportista_admin', 'Gestion de Transportista', '', NULL, 11, '/img/icono.gif', 'Módulo Gestión de Transportista', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'transportista_abm_admin', 'Registrar Contenedor', 'general/Estructura/Transportista/templateTransportistas', NULL, 10, '/img/icono.gif', 'Registrar Contenedor', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'transportista_admin');

	--generadores de admin
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'generadores_admin', 'Gestion de Generadores', '', NULL, 13, '/img/icono.gif', 'Módulo Gestion de Generadores', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);

		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'generador_abm_admin', 'Registrar Generador', 'general/Estructura/Generador/templateGeneradores', NULL, 13, '/img/icono.gif', 'Registrar Generador', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'generadores_admin');

	--permisos transportistas
		INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'transportista_admin', 'Secretaria Medio Ambiente San Juan', 'SMA - Administracion', '2020-09-02', 'postgres', 'hugoG');
		INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'transportista_abm_admin', 'Secretaria Medio Ambiente San Juan', 'SMA - Administracion', '2020-09-02', 'postgres', 'hugoG');

	-- permisos generadores
		INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'generadores_admin', 'Secretaria Medio Ambiente San Juan', 'SMA - Administracion', '2020-09-02', 'postgres', 'hugoG');
		INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'generador_abm_admin', 'Secretaria Medio Ambiente San Juan', 'SMA - Administracion', '2020-09-02', 'postgres', 'hugoG');


-- MENU MUNICIPIOS
	--cabecera
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'gestion_ot_municipio', 'Gestion Ord. Transporte', '', NULL, 11, '/img/icono.gif', 'Módulo Gestión Ord. Transporte', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);

	--items
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'zonas_municipio_admin', 'Registrar Zonas', 'general/Estructura/Zona/templateZonas', NULL, 10, '/img/icono.gif', 'Registrar Zonas', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'gestion_ot_municipio');

		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'circuito_municipio_admin', 'Registrar Circuitos', 'general/Estructura/Circuito/templateCircuitos', NULL, 10, '/img/icono.gif', 'Registrar Circuitos', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'gestion_ot_municipio');

		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'templateot_municipio_admin', 'Template O. Transporte', 'general/Orden/templateOt', NULL, 10, '/img/icono.gif', 'Template O. Transporte', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'gestion_ot_municipio');

		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'otrasnporte_municipio_admin', 'Registrar O. Transporte', 'general/Estructura/OrdenTransporte/templateOrdentransporte', NULL, 10, '/img/icono.gif', 'Registrar O. Transporte', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'gestion_ot_municipio');

		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'recepcion_orden_municipio_admin', 'Recepcion de Orden', 'general/Orden/registrarRecepcionDeOrden', NULL, 10, '/img/icono.gif', 'Recepcion de Orden', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'gestion_ot_municipio');

	--permisos
		INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'gestion_ot_municipio', 'Secretaria Medio Ambiente San Juan', 'SMA - Municipio', '2020-09-02', 'postgres', 'hugoG');
		INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'zonas_municipio_admin', 'Secretaria Medio Ambiente San Juan', 'SMA - Municipio', '2020-09-02', 'postgres', 'hugoG');
		INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'circuito_municipio_admin', 'Secretaria Medio Ambiente San Juan', 'SMA - Municipio', '2020-09-02', 'postgres', 'hugoG');
		INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'otrasnporte_municipio_admin', 'Secretaria Medio Ambiente San Juan', 'SMA - Municipio', '2020-09-02', 'postgres', 'hugoG');
		INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'recepcion_orden_municipio_admin', 'Secretaria Medio Ambiente San Juan', 'SMA - Municipio', '2020-09-02', 'postgres', 'hugoG');


--OPERARIO BASCULA

	--cabecera
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'modulo_recepcion', 'Módulo Recepción', '', NULL, 11, '/img/icono.gif', 'Módulo Recepción', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);

	--items
		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'modulo_recepcion_recep_orden', 'Registrar Recepcion de Ordenes', 'general/Orden/registrarRecepcionDeOrden', NULL, 10, '/img/icono.gif', 'Registrar Recepcion de Ordenes', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'modulo_recepcion');

		INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'modulo_recepcion_incidencias_abm', 'Registrar Incidencias', 'general/Estructura/Incidencia/templateIncidencia', NULL, 10, '/img/icono.gif', 'Registrar Incidencias', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'modulo_recepcion');

	--permisos
		INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_recepcion', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Báscula', '2020-09-02', 'postgres', 'hugoG');
		INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_recepcion_incidencias_abm', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Báscula', '2020-09-02', 'postgres', 'hugoG');

		INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_recepcion_recep_orden', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Báscula', '2020-09-02', 'postgres', 'hugoG');


--DEPOSITOS


	--MENU
		--cabecera
			INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'modulo_descarga', 'Módulo Descarga', '', NULL, 11, '/img/icono.gif', 'Módulo Descarga', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);
		--items
			INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'modulo_descarga_incidencias_abm', 'Registrar Incidencias', 'general/Estructura/Incidencia/templateIncidencia', NULL, 10, '/img/icono.gif', 'Registrar Incidencias', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'modulo_descarga');
			INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'modulo_descarga_control_descarga', 'Control de Descarga', 'general/Orden/controlDeDescarga', NULL, 10, '/img/icono.gif', 'Control de Descarga', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'modulo_descarga');
			INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'modulo_descarga_cierre_sector', 'Cierre de Sector', 'sin link', NULL, 10, '/img/icono.gif', 'Cierre de Sector', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'modulo_descarga');

		--permisos
			--cabeceras
				INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_descarga', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRI - RSU', '2020-09-02', 'postgres', 'hugoG');
				INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_descarga', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - DF - Escombrera', '2020-09-02', 'postgres', 'hugoG');
				INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_descarga', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - DF - Relleno Sanitario', '2020-09-02', 'postgres', 'hugoG');
				INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_descarga', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRI - Chatarra', '2020-09-02', 'postgres', 'hugoG');
				INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_descarga', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRO - Industriales', '2020-09-02', 'postgres', 'hugoG');
				INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_descarga', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRO - Ramas', '2020-09-02', 'postgres', 'hugoG');


		--items
		-- INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_descarga_incidencias_abm', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - DF - Escombrera', '2020-09-02', 'postgres', 'hugoG');
		-- INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_descarga_incidencias_abm', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - DF - Relleno Sanitario', '2020-09-02', 'postgres', 'hugoG');
		-- INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_descarga_incidencias_abm', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRI - Chatarra', '2020-09-02', 'postgres', 'hugoG');
		-- INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_descarga_incidencias_abm', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRO - Industriales', '2020-09-02', 'postgres', 'hugoG');
		-- INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_descarga_incidencias_abm', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRO - Ramas', '2020-09-02', 'postgres', 'hugoG');


















