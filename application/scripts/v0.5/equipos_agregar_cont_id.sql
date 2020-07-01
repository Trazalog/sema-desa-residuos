ALTER TABLE core.equipos ADD cont_id int4 NULL;
ALTER TABLE core.equipos ADD CONSTRAINT equipos_equi_id_fk FOREIGN KEY (cont_id) REFERENCES log.contenedores(cont_id);

