-- ordenes transporte 
ALTER TABLE log.ordenes_transporte ADD tran_id int4 NULL;
ALTER TABLE log.ordenes_transporte ADD CONSTRAINT ordenes_transporte_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);

ALTER TABLE log.templates_orden_transporte ADD CONSTRAINT templates_orden_transporte_un UNIQUE (teot_id);

ALTER TABLE log.ordenes_transporte ADD teot_id int4 NULL;
ALTER TABLE log.ordenes_transporte ADD CONSTRAINT ordenes_transporte_teot_id_fk FOREIGN KEY (teot_id) REFERENCES log.templates_orden_transporte(teot_id);