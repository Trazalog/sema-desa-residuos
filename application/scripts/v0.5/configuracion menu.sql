
--USERS
	INSERT INTO seg.users (id, email, first_name, last_name, "role", "password", last_login, status, banned_users, passmd5, telefono, dni, usernick, depo_id) VALUES(1, 'admin@gmail.com', 'Lola', 'Meraz', '1', 'sha256:1000:UJxHaaFpM44Bj1ka7U58GiSHUx3zRWid:Hq86/PHYj0utJLz2ciHzSehsidHAZX+A', '2020-07-17 03:40:22 PM', 'approved', 'unban', NULL, NULL, NULL, 'Administrador', NULL);
	INSERT INTO seg.users (id, email, first_name, last_name, "role", "password", last_login, status, banned_users, passmd5, telefono, dni, usernick, depo_id) VALUES(2, 'juan@vea.com', 'Juan Jose', 'Vea', '2', 'sha256:1000:JDJ5JDEwJFgzSk5rLjhaZExJbFJDZ0h2cVZ5eE8vVkk0ckR5U0I3aGFCMkhaOGhkZ0IwSnZFLldoTVpH:OCpVyRx/4Ez3OTSvYsSxN2jlUFh9GkaR', NULL, 'approved', 'unban', NULL, '2345111111', '2222222222', 'juanVea', NULL);
	INSERT INTO seg.users (id, email, first_name, last_name, "role", "password", last_login, status, banned_users, passmd5, telefono, dni, usernick, depo_id) VALUES(3, 'ema@bustos.com', 'Ema Amado', 'Bustos', '2', 'sha256:1000:JDJ5JDEwJENxWFFSWU4vT0lKYjUvZG5BWk1mZ3VmRS41cFhUaTVBa0Zqc2VOSTBaS25OVzdndmZ0clRl:AJKJ0+bsGvcCuEXU2ZffVUBwe+HX6r+W', NULL, 'approved', 'unban', NULL, '1555555555', '21212121', 'emamadobustos', NULL);
	INSERT INTO seg.users (id, email, first_name, last_name, "role", "password", last_login, status, banned_users, passmd5, telefono, dni, usernick, depo_id) VALUES(4, 'pri-rsu@gmail.com', 'Operario', 'Depo PRI - RSU', '2', 'sha256:1000:JDJ5JDEwJE9ZcER4NmkxQVhPZGQvdko2NU14Wi5Ob0VwWlU5ZFZDLk5udHZUSGtJTFFMWlFSY2hNTHcu:BryQ3BAfQQhjZjDqYnpReA6DHWByCz6u', NULL, 'approved', 'unban', NULL, '11111111', '21212121', 'operarioPRI-RSU', 9);
	INSERT INTO seg.users (id, email, first_name, last_name, "role", "password", last_login, status, banned_users, passmd5, telefono, dni, usernick, depo_id) VALUES(5, 'pri-chatarra@gmail.com', 'Operario', 'Depo PRI - Chatarra', '2', 'sha256:1000:JDJ5JDEwJDNoVzBlbk9JT2YwQWFPM3puZEh0MWV1cTZFSDNlUXozSHlPN1oxSTZNZU0zODdsS1duZGFD:nbAcL16w6tMWLDqiHcS8JA1QXH/R9OLu', NULL, 'approved', 'unban', NULL, '4242424', '2222222222', 'operarioPRI-Chatarra', 10);
	INSERT INTO seg.users (id, email, first_name, last_name, "role", "password", last_login, status, banned_users, passmd5, telefono, dni, usernick, depo_id) VALUES(6, 'proramas@gmail.com', 'Operario', 'Descarga - PRO - Ramas', '2', 'sha256:1000:JDJ5JDEwJDNCdmlWdHE3QldvbFhiQmFzWjdDek9GQUZWOXVCNHlOQzhpOVdwcGtyYzFJcVA4b3lINTBD:b88ZBSA7RDq37ERSw9b9IB4x8TEijPSg', NULL, 'approved', 'unban', NULL, '21212121', '2222222222', ' operarioPRO-Ramas', 11);
	INSERT INTO seg.users (id, email, first_name, last_name, "role", "password", last_login, status, banned_users, passmd5, telefono, dni, usernick, depo_id) VALUES(7, 'elianabernaldez@gmail.com', 'Eliana', 'Bernaldez', '1', 'sha256:1000:JDJ5JDEwJGZyY2N4UkFjbWI0Qld2UXJqVC9DeS5XR1FQZEU1eXVUR2FDMTNVQ2tGUFpydVZHTi5qWW5P:3da6QA+QDvpmeF7Y4KInqQ26+HF3bLZn', NULL, 'approved', 'unban', NULL, '02644510131', '12345', 'eli', NULL);
	INSERT INTO seg.users (id, email, first_name, last_name, "role", "password", last_login, status, banned_users, passmd5, telefono, dni, usernick, depo_id) VALUES(8, 'elver@gmail.com', 'Elver', 'Gadura', '2', 'sha256:1000:JDJ5JDEwJDFhU2hqMngvY3o0TkdWanRJWEV0L09JZDRqc2NHTTVZTGxJRHNmUXQzTzBpclJFSlgweEdp:9kWV6i4WzKqjtmtCV3M9C5tPqzJep112', NULL, 'approved', 'unban', NULL, '4222222', '222222222', 'elvergadura', NULL);
	INSERT INTO seg.users (id, email, first_name, last_name, "role", "password", last_login, status, banned_users, passmd5, telefono, dni, usernick, depo_id) VALUES(9, 'administracion@sema.gob.ar', 'Administracion', 'Secretaria', '1', 'sha256:1000:JDJ5JDEwJC5TY3RQaGd2L3RwS3doNjB1UjhlanVHL2dsbVNrLlZtNWxsWnY0aUh0Zm9hS0hCUHpvOXNt:p6Cq6KQaMK64c8Lfy4hwnFZEhoTLCui9', NULL, 'approved', 'unban', NULL, '21212121', '21212121', 'administracion', NULL);
	INSERT INTO seg.users (id, email, first_name, last_name, "role", "password", last_login, status, banned_users, passmd5, telefono, dni, usernick, depo_id) VALUES(10, 'municipio@pocito.gob.ar', 'Municipio', 'Pocito', '2', 'sha256:1000:JDJ5JDEwJFRSVEpLT2t3Q21WTUg1bkxXWHZWemU4VWNQNjluOUJ3Um1PNXFxYnY4YlFMci9WeTJWWS9p:98W5UA+doaafjnNXrni+6nipiXyuhoji', NULL, 'approved', 'unban', NULL, '11111111', '21212121', 'pocito', NULL);

--MEMBERSHIPS_USERS
	INSERT INTO seg.memberships_users ("group", "role", fec_alta, usuario, usuario_app, email) VALUES('Secretaria Medio Ambiente San Juan', 'SMA - Generador', '2020-08-29 02:15:58.017661+00', 'postgres', 'bascula', 'juan@vea.com');
	INSERT INTO seg.memberships_users ("group", "role", fec_alta, usuario, usuario_app, email) VALUES('Secretaria Medio Ambiente San Juan', 'SMA - Transportista', '2020-08-29 03:15:11.589224+00', 'postgres', 'bascula', 'ema@bustos.com');
	INSERT INTO seg.memberships_users ("group", "role", fec_alta, usuario, usuario_app, email) VALUES('Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRI - RSU', '2020-08-29 03:20:23.919088+00', 'postgres', 'bascula', 'pri-rsu@gmail.com');
	INSERT INTO seg.memberships_users ("group", "role", fec_alta, usuario, usuario_app, email) VALUES('Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRI - Chatarra', '2020-08-29 03:23:49.085264+00', 'postgres', 'bascula', 'pri-chatarra@gmail.com');
	INSERT INTO seg.memberships_users ("group", "role", fec_alta, usuario, usuario_app, email) VALUES('Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRO - Ramas', '2020-08-29 03:28:23.888365+00', 'postgres', 'bascula', 'proramas@gmail.com');
	INSERT INTO seg.memberships_users ("group", "role", fec_alta, usuario, usuario_app, email) VALUES('Secretaria Medio Ambiente San Juan', 'SMA - Operador de Bascula', '2020-08-31 14:23:56.103364+00', 'postgres', 'bascula', 'elianabernaldez@gmail.com');
	INSERT INTO seg.memberships_users ("group", "role", fec_alta, usuario, usuario_app, email) VALUES('Secretaria Medio Ambiente San Juan', 'SMA - Operador de Bascula', '2020-09-01 13:44:46.473861+00', 'postgres', 'bascula', 'elver@gmail.com');
	INSERT INTO seg.memberships_users ("group", "role", fec_alta, usuario, usuario_app, email) VALUES('Secretaria Medio Ambiente San Juan', 'SMA - Administracion', '2020-09-03 22:17:30.172132+00', 'postgres', 'bascula', 'administracion@sema.gob.ar');
	INSERT INTO seg.memberships_users ("group", "role", fec_alta, usuario, usuario_app, email) VALUES('Secretaria Medio Ambiente San Juan', 'SMA - Municipio', '2020-09-03 23:26:55.765173+00', 'postgres', 'bascula', 'municipio@pocito.gob.ar');



--MENUES
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('PRO', 'tareas', 'Mis tareas', 'traz-comp-bpm/Proceso/index', NULL, 1, '/img/icono.gif', 'Mis tareas', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'transportista', 'Gestion de Transportista', '', NULL, 11, '/img/icono.gif', 'Módulo Gestión de Transportista', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'contenedor', 'Registrar Contenedor', 'general/Estructura/Contenedor/templateContenedores', NULL, 10, '/img/icono.gif', 'Registrar Contenedor', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'transportista');
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'vehiculo', 'Registrar Vehiculo', 'general/Estructura/Vehiculo/templateVehiculos', NULL, 10, '/img/icono.gif', 'Registrar Vehículo', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'transportista');
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'contenedor_entrega', 'Entrega Contenedor', 'sin link', NULL, 10, '/img/icono.gif', 'Entrega Contenedor', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'transportista');
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'chofer_abm', 'Registrar Chofer', 'general/Estructura/Chofer/templateChoferes', NULL, 10, '/img/icono.gif', 'Registrar Chofer', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'transportista');
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'generadores', 'Gestion de Generadores', '', NULL, 13, '/img/icono.gif', 'Módulo Gestion de Generadores', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'zonas_municipio_admin', 'Registrar Zonas', 'general/Estructura/Zona/templateZonas', NULL, 10, '/img/icono.gif', 'Registrar Zonas', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'gestion_ot_municipio');
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'transportista_admin', 'Gestion de Transportista', '', NULL, 11, '/img/icono.gif', 'Módulo Gestión de Transportista', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'solicitud_contenedor', 'Solicitud de  Contenedor', 'general/transporte-bpm/Solicitud_Pedido/templateSolicitudPedidos', NULL, 13, '/img/icono.gif', 'Solicitud de Contenedor', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'generadores');
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'solicitud_retiro', 'Solicitud de Retiro', 'general/transporte-bpm/SolicitudRetiro/templateSolicitudRetiro', NULL, 13, '/img/icono.gif', 'Solicitud deRetiro', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'generadores');
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'orden_transporte_abm', 'Orden de Transporte', 'general/Estructura/OrdenTransporte/templateOrdentransporte', NULL, 12, '/img/icono.gif', 'Orden Transporte', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'generadores');
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'gestion_ot_municipio', 'Gestion Ord. Transporte', '', NULL, 11, '/img/icono.gif', 'Módulo Gestión Ord. Transporte', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'circuito_municipio_admin', 'Registrar Circuitos', 'general/Estructura/Circuito/templateCircuitos', NULL, 10, '/img/icono.gif', 'Registrar Circuitos', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'gestion_ot_municipio');
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'templateot_municipio_admin', 'Template O. Transporte', 'general/Orden/templateOt', NULL, 10, '/img/icono.gif', 'Template O. Transporte', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'gestion_ot_municipio');
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'otrasnporte_municipio_admin', 'Registrar O. Transporte', 'general/Estructura/OrdenTransporte/templateOrdentransporte', NULL, 10, '/img/icono.gif', 'Registrar O. Transporte', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'gestion_ot_municipio');
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'transportista_abm_admin', 'Registrar Trnasportista', 'general/Estructura/Transportista/templateTransportistas', NULL, 10, '/img/icono.gif', 'Registrar Trnasportista', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'transportista_admin');
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'generadores_admin', 'Gestion de Generadores', '', NULL, 13, '/img/icono.gif', 'Módulo Gestion de Generadores', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'generador_abm_admin', 'Registrar Generador', 'general/Estructura/Generador/templateGeneradores', NULL, 13, '/img/icono.gif', 'Registrar Generador', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'generadores_admin');
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'modulo_recepcion', 'Módulo Recepción', '', NULL, 11, '/img/icono.gif', 'Módulo Recepción', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', NULL);
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'modulo_recepcion_incidencias_abm', 'Registrar Incidencias', 'general/Estructura/Incidencia/templateIncidencia', NULL, 10, '/img/icono.gif', 'Registrar Incidencias', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'modulo_recepcion');
	INSERT INTO seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) VALUES('LOG', 'modulo_recepcion_recep_orden', 'Registrar Recepcion Ordenes', 'general/Orden/registrarRecepcionDeOrden', NULL, 10, '/img/icono.gif', 'Registrar Recepcion de Ordenes', 0, '2020-07-21 10:09:13.036498-03', 'postgres', 'HugoG', 'modulo_recepcion');

--MEMBERSHIP_MENUES
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Transportista', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Generador', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - DF - Escombrera', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - DF - Relleno Sanitario', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRI - Chatarra', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRI - RSU', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRO - Industriales', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRO - Ramas', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Municipio', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'contenedor_entrega', 'Secretaria Medio Ambiente San Juan', 'SMA - Transportista', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'contenedor', 'Secretaria Medio Ambiente San Juan', 'SMA - Transportista', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'vehiculo', 'Secretaria Medio Ambiente San Juan', 'SMA - Transportista', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'chofer_abm', 'Secretaria Medio Ambiente San Juan', 'SMA - Transportista', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'transportista', 'Secretaria Medio Ambiente San Juan', 'SMA - Transportista', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'generadores', 'Secretaria Medio Ambiente San Juan', 'SMA - Generador', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'gestion_ot_municipio', 'Secretaria Medio Ambiente San Juan', 'SMA - Municipio', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'generadores_admin', 'Secretaria Medio Ambiente San Juan', 'SMA - Administracion', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'transportista_abm_admin', 'Secretaria Medio Ambiente San Juan', 'SMA - Administracion', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'transportista_admin', 'Secretaria Medio Ambiente San Juan', 'SMA - Administracion', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_recepcion', 'Secretaria Medio Ambiente San Juan', 'SMA - Operador de Bascula', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('PRO', 'tareas', 'Secretaria Medio Ambiente San Juan', 'SMA - Operador de Bascula', '2020-09-02', 'postgres', 'hugoG');
	INSERT INTO seg.memberships_menues (modulo, opcion, "group", "role", fec_alta, usuario, usuario_app) VALUES('LOG', 'modulo_descarga', 'Secretaria Medio Ambiente San Juan', 'SMA - Operario Descarga - PRI - RSU', '2020-09-02', 'postgres', 'hugoG');


