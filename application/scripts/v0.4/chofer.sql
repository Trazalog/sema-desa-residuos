-- cambio campo codigo de integer a varchar
ALTER TABLE log.choferes ALTER COLUMN codigo TYPE varchar USING codigo::varchar;