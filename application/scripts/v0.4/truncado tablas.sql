-- VEHICULOS
  -- Vehiculos
  truncate core.equipos; 

-- TRANSPORTISTAS
  -- transportistas-tipo residuos
  truncate core.transportistas_tipo_residuos; 
  -- tipos carga transportista
  truncate log.tipos_carga_transportistas;
  -- Transportistas
  truncate log.transportistas; 

-- ZONAS
  -- zonas
  truncate core.zonas; 

-- CHOFERES
  -- choferes
  truncate log.choferes; 

-- CIRCUITOS
  -- circuitos puntos criticos
  truncate log.circuitos_puntos_criticos; 
  -- tipo carga circuitos
  truncate log.tipos_carga_circuitos;
  -- circuitos
  truncate log.circuitos;

-- PUNTOS CRITICOS
  -- puntos criticos
  truncate log.puntos_criticos; 

-- CONTENEDORES
  -- contenedores
  truncate log.contenedores;
  -- tipos carga contenedores
  truncate log.tipos_carga_contenedores; 
  -- tipos carga contenedores
  truncate log.tipos_carga_contenedores; 

-- INSPECTORES
  -- inspectores
  truncate sma.inspectores;

-- ELIMINAR TABLAS SOBRANTES
drop table core.transportistas cascade
drop table core.transportistas_tipo_residuos cascade



