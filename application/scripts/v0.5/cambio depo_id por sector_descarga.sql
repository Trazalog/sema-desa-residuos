

ALTER TABLE log.contenedores_entregados ADD depo_id int4 NULL;

ALTER TABLE log.contenedores_entregados ADD CONSTRAINT contenedores_entregados_depo_idfk FOREIGN KEY (depo_id) REFERENCES alm.alm_depositos(depo_id);

ALTER TABLE log.contenedores_entregados DROP COLUMN sector_descarga;


