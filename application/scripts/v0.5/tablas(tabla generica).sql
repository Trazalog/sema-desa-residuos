INSERT INTO core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) VALUES('tipo_cargaResiduos Urbanos', 'tipo_carga', 'Residuos Urbanos', 'RO004', NULL, NULL, '2019-12-26 16:37:42.879', 'postgres', false);
INSERT INTO core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) VALUES('tipo_cargaResiduos Tecnologicos', 'tipo_carga', 'Residuos Tecnologicos', NULL, NULL, 'compus', '2019-12-26 16:35:02.518', 'postgres', false);

INSERT INTO alm.alm_articulos (arti_id, barcode, descripcion, costo, es_caja, cantidad_caja, punto_pedido, estado, unidad_medida, empr_id, es_loteado, fec_alta, eliminado, tipo) VALUES(72, 'RO004', 'Residuos Urbanos sin clasificar', NULL, false, NULL, NULL, 'AC', 'MTS', 1, false, '2020-07-16 19:23:06.592', false, NULL);
INSERT INTO alm.alm_articulos (arti_id, barcode, descripcion, costo, es_caja, cantidad_caja, punto_pedido, estado, unidad_medida, empr_id, es_loteado, fec_alta, eliminado, tipo) VALUES(75, 'RO005', 'Residuos Tipo Escombro', NULL, false, NULL, NULL, 'AC', 'MTS', 1, false, '2020-08-10 16:26:49.774', false, NULL);
INSERT INTO alm.alm_articulos (arti_id, barcode, descripcion, costo, es_caja, cantidad_caja, punto_pedido, estado, unidad_medida, empr_id, es_loteado, fec_alta, eliminado, tipo) VALUES(76, 'RO006', 'Residuos Patologicos', NULL, false, NULL, NULL, 'AC', 'MTS', 1, false, '2020-08-10 16:28:38.209', false, NULL);
INSERT INTO alm.alm_articulos (arti_id, barcode, descripcion, costo, es_caja, cantidad_caja, punto_pedido, estado, unidad_medida, empr_id, es_loteado, fec_alta, eliminado, tipo) VALUES(77, 'RO007', 'Residuos Organicos', NULL, false, NULL, NULL, 'AC', 'MTS', 1, false, '2020-08-10 16:30:14.309', false, NULL);
INSERT INTO alm.alm_articulos (arti_id, barcode, descripcion, costo, es_caja, cantidad_caja, punto_pedido, estado, unidad_medida, empr_id, es_loteado, fec_alta, eliminado, tipo) VALUES(79, 'RO008', 'Residuos Quimicos', NULL, false, NULL, NULL, 'AC', 'MTS', 1, false, '2020-08-10 16:32:16.790', false, NULL);
INSERT INTO alm.alm_articulos (arti_id, barcode, descripcion, costo, es_caja, cantidad_caja, punto_pedido, estado, unidad_medida, empr_id, es_loteado, fec_alta, eliminado, tipo) VALUES(80, 'RO009', 'Residuos Tecnológicos', NULL, false, NULL, NULL, 'AC', 'MTS', 1, false, '2020-08-10 16:32:16.790', false, NULL);


INSERT INTO core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) VALUES('cate_recipienteCONTENEDOR', 'cate_recipiente', 'CONTENEDOR', NULL, NULL, NULL, '2020-08-12 11:19:30.650', 'postgres', false);
INSERT INTO core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) VALUES('cate_recipienteBIN', 'cate_recipiente', 'BIN', NULL, NULL, NULL, '2020-07-20 18:40:42.310', 'postgres', false);

INSERT INTO core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) VALUES('sector_descargaDF - Escombrera', 'sector_descarga', 'DF - Escombrera', NULL, NULL, NULL, '2020-07-01 17:53:26.103', 'postgres', false);
INSERT INTO core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) VALUES('sector_descargaDF - Relleno Sanitario', 'sector_descarga', 'DF - Relleno Sanitario', NULL, NULL, NULL, '2020-07-01 17:53:25.933', 'postgres', false);
INSERT INTO core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) VALUES('sector_descargaPRI - Chatarra', 'sector_descarga', 'PRI - Chatarra', NULL, NULL, NULL, '2020-07-01 17:53:25.392', 'postgres', false);
INSERT INTO core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) VALUES('sector_descargaPRI - RSU', 'sector_descarga', 'PRI - RSU', NULL, NULL, NULL, '2020-07-01 17:53:25.142', 'postgres', false);
INSERT INTO core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) VALUES('sector_descargaPRO - Industriales', 'sector_descarga', 'PRO - Industriales', NULL, NULL, NULL, '2020-07-01 17:53:25.744', 'postgres', false);
INSERT INTO core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) VALUES('sector_descargaPRO - Ramas', 'sector_descarga', 'PRO - Ramas', NULL, NULL, NULL, '2020-07-01 17:53:25.570', 'postgres', false);


