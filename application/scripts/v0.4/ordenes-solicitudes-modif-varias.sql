ALTER TABLE log.ordenes_transporte RENAME COLUMN caseid TO case_id;
ALTER TABLE log.ordenes_transporte ADD usuario_app varchar NOT NULL;
ALTER TABLE log.ordenes_transporte ADD eliminado int2 NOT NULL DEFAULT 0;
UPDATE log.ordenes_transporte set usuario_app ='default';
ALTER TABLE log.ordenes_transporte ALTER COLUMN usuario_app SET NOT NULL;

ALTER TABLE log.solicitudes_contenedor ADD tran_id int4 NULL;
UPDATE log.solicitudes_contenedor set tran_id=49;
ALTER TABLE log.solicitudes_contenedor ALTER COLUMN tran_id SET NOT NULL;
ALTER TABLE log.solicitudes_contenedor ADD CONSTRAINT solicitudes_contenedor_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);

UPDATE log.solicitudes_retiro set sotr_id=38 where sotr_id is null;
ALTER TABLE log.solicitudes_retiro ALTER COLUMN sotr_id SET NOT NULL;
ALTER TABLE log.solicitudes_retiro DROP CONSTRAINT solicitudes_retiro_fk;
ALTER TABLE log.solicitudes_retiro ADD CONSTRAINT solicitudes_retiro_sotr_id_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);


