-- multiple tipos de carga en generadores

CREATE TABLE log.tipos_carga_generadores (
	tica_id varchar NOT NULL,
	sotr_id int4 NOT NULL,
	CONSTRAINT tipos_carga_generadores_sotr_id_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id),
	CONSTRAINT tipos_carga_generadores_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id)
);
