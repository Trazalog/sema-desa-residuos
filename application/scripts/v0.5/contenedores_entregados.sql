-- contenedores entregados

ALTER TABLE log.contenedores_entregados ADD peso_neto float4 NULL;

ALTER TABLE log.contenedores_entregados ADD difi_id varchar NULL;
ALTER TABLE log.contenedores_entregados ADD sector_descarga varchar NULL;