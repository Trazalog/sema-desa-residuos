ALTER TABLE log.solicitudes_retiro ADD estado varchar NOT NULL DEFAULT 'SOLICITADA';
ALTER TABLE log.solicitudes_retiro ADD CONSTRAINT solicitudes_retiro_check CHECK (estado='SOLICITADA' or estado = 'RETIRO_ASIGNADO_PARCIAL' or estado='RETIRO_ASIGNADO_TOTAL');
