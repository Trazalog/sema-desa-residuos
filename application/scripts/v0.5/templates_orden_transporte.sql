-- log.templates_orden_transporte definition

-- Drop table

-- DROP TABLE log.templates_orden_transporte;

CREATE TABLE log.templates_orden_transporte (
	teot_id serial NOT NULL,
	observaciones varchar NULL,
	eliminado int2 NOT NULL DEFAULT 0,
	fec_alta date NOT NULL DEFAULT now(),
	usuario varchar NOT NULL DEFAULT CURRENT_USER,
	usuario_app varchar NOT NULL,
	circ_id int4 NOT NULL,
	equi_id int4 NOT NULL,
	chof_id varchar NOT NULL,
	tica_id varchar NOT NULL,
	difi_id varchar NOT NULL,
	sotr_id int4 NOT NULL
);


-- log.templates_orden_transporte foreign keys

ALTER TABLE log.templates_orden_transporte ADD CONSTRAINT templates_orden_transporte_chof_id_fk FOREIGN KEY (chof_id) REFERENCES log.choferes(documento);
ALTER TABLE log.templates_orden_transporte ADD CONSTRAINT templates_orden_transporte_circ_id_fk FOREIGN KEY (circ_id) REFERENCES log.circuitos(circ_id);
ALTER TABLE log.templates_orden_transporte ADD CONSTRAINT templates_orden_transporte_difi_id_fk FOREIGN KEY (difi_id) REFERENCES core.tablas(tabl_id);
ALTER TABLE log.templates_orden_transporte ADD CONSTRAINT templates_orden_transporte_equi_id_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
ALTER TABLE log.templates_orden_transporte ADD CONSTRAINT templates_orden_transporte_sotr_id_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
ALTER TABLE log.templates_orden_transporte ADD CONSTRAINT templates_orden_transporte_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
