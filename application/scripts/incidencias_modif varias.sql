ALTER TABLE ins.incidencias ADD eliminado int2 NOT NULL DEFAULT 0;
ALTER TABLE ins.incidencias RENAME COLUMN tire_id TO tica_id;
ALTER TABLE ins.incidencias ADD CONSTRAINT incidencias_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
ALTER TABLE ins.incidencias DROP CONSTRAINT incidencias_tire_id_fk;
