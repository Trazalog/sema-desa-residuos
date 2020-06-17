-- Agrega campo tran_id 
ALTER TABLE log.solicitudes_contenedor ADD tran_id int4 NOT NULL;

-- agrega clave foranea tran_id
ALTER TABLE log.solicitudes_contenedor ADD CONSTRAINT solicitudes_contenedor_tran_id_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);