ALTER TABLE log.contenedores_entregados ADD equi_id int4 NULL;
ALTER TABLE log.contenedores_entregados ADD CONSTRAINT contenedores_entregados_equi_id_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
CREATE UNIQUE INDEX equipos_dominio_idx ON core.equipos (dominio);
ALTER TABLE core.equipos ADD CONSTRAINT equipos_tran_id_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);

