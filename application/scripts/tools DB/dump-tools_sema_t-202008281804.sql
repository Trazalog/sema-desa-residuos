PGDMP     *                    x            tools_sema_t    11.7    12.2 B   �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    21631    tools_sema_t    DATABASE     ~   CREATE DATABASE tools_sema_t WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'en_US.UTF-8' LC_CTYPE = 'en_US.UTF-8';
    DROP DATABASE tools_sema_t;
                postgres    false                        2615    21632    alm    SCHEMA        CREATE SCHEMA alm;
    DROP SCHEMA alm;
                postgres    false            
            2615    21633    core    SCHEMA        CREATE SCHEMA core;
    DROP SCHEMA core;
                postgres    false                        2615    21634    fis    SCHEMA        CREATE SCHEMA fis;
    DROP SCHEMA fis;
                postgres    false                        2615    21635    frm    SCHEMA        CREATE SCHEMA frm;
    DROP SCHEMA frm;
                postgres    false                        2615    21636    ins    SCHEMA        CREATE SCHEMA ins;
    DROP SCHEMA ins;
                postgres    false                        2615    21637    log    SCHEMA        CREATE SCHEMA log;
    DROP SCHEMA log;
                postgres    false                        2615    21638    prd    SCHEMA        CREATE SCHEMA prd;
    DROP SCHEMA prd;
                postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
                postgres    false            �           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                   postgres    false    3                        2615    24301    seg    SCHEMA        CREATE SCHEMA seg;
    DROP SCHEMA seg;
                postgres    false            e           1255    21639 /   agregar_lote_articulo(bigint, double precision)    FUNCTION     a  CREATE FUNCTION alm.agregar_lote_articulo(p_batch_id bigint, p_cantidad double precision) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
/**
 * Función para actualizar un lote de almacen con p_batch_id
 * Si no encuentra el lote lanza excepcion BATCH_NO_EXISTE
 */
declare
	v_cuenta integer; 
	v_existencia alm.alm_lotes.cantidad%type;
begin
	with updated_lotes as (	
		update alm.alm_lotes
		set cantidad = cantidad + p_cantidad
		where batch_id = p_batch_id
		returning 1)
		
	select count(1)
	from updated_lotes
	into strict v_cuenta;

	if v_cuenta = 0 then
    	    RAISE INFO 'ALMEXLO - no se encontro el batch id % ', p_batch_id;
    	    raise 'BATCH_INEXISTENTE';
    end if;

   	RAISE INFO 'ALMEXLO - actualizando el batch id % con cantidad %', p_batch_id,p_cantidad;
    return 'CORRECTO';

exception
		when others then 
			raise;
end;
		
$$;
 Y   DROP FUNCTION alm.agregar_lote_articulo(p_batch_id bigint, p_cantidad double precision);
       alm          postgres    false    6            V           1255    21640 ;   ajuste_detalle_ingresar(integer, integer, double precision)    FUNCTION     �  CREATE FUNCTION alm.ajuste_detalle_ingresar(p_ajus_id integer, p_lote_id integer, p_cantidad double precision) RETURNS integer
    LANGUAGE plpgsql
    AS $$
#print_strict_params on

declare
	v_deaj_id alm.deta_ajustes.deaj_id%type;
	v_mensaje varchar;
	v_empr_id alm.ajustes.empr_id%type;
begin
  begin
	  	
	    RAISE INFO 'Obtengo empresa de tabla ajuste con ajus_id %',p_ajus_id;

	    select empr_id 
		into strict v_empr_id
		from alm.ajustes
		where ajus_id = p_ajus_id;
		     
	    RAISE INFO 'insertando en deta ajustes %,%,%',p_cantidad,v_empr_id,p_lote_id;

		insert into alm.deta_ajustes (
			   cantidad
	          ,empr_id
	          ,lote_id
	          ,ajus_id)
		values (
			p_cantidad
		    ,v_empr_id
		    ,p_lote_id
		    ,p_ajus_id)
		returning deaj_id into strict v_deaj_id;
		   
	    RAISE INFO 'actualizando alm_lotes % ',p_lote_id;
		   
		update alm.alm_lotes
		set cantidad = cantidad + p_cantidad
		where lote_id = p_lote_id;
	   
	   return v_deaj_id;
	
		
       	exception	   
			when NO_DATA_FOUND then
		        RAISE INFO ' ajus_id inexistente %', p_ajus_id;
				v_mensaje = 'AJUS_NO_ENCONTRADO';
		        raise exception 'AJUS_NO_ENCONTRADO:%',p_ajus_id;

       		when FOREIGN_KEY_VIOLATION then
		        RAISE INFO 'lote  inexistente %', p_lote_id;
				v_mensaje = 'LOTEALM_NO_ENCONTRADO';
		        raise exception 'LOTEALM_NO_ENCONTRADO:%',p_lote_id;
		       
		end;	

exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
		raise warning 'ajuste_detalle_lote: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;
END; 
$$;
 n   DROP FUNCTION alm.ajuste_detalle_ingresar(p_ajus_id integer, p_lote_id integer, p_cantidad double precision);
       alm          postgres    false    6            W           1255    21641 j   crear_lote_articulo(integer, integer, integer, character varying, double precision, date, integer, bigint)    FUNCTION       CREATE FUNCTION alm.crear_lote_articulo(p_prov_id integer, p_arti_id integer, p_depo_id integer, p_codigo character varying, p_cantidad double precision, p_fec_vencimiento date, p_empr_id integer, p_batch_id bigint) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
/**
 * Crea un nuevo lote para un articulo determinado en el deposito informado
 */
begin

	insert into alm.alm_lotes (
	prov_id
	,arti_id
	,depo_id
	,codigo
	,cantidad
	,fec_vencimiento
	,empr_id
	,estado
	,batch_id)
	VALUES( 
	p_prov_id
	,p_arti_id
	,p_depo_id
	,p_codigo
	,p_cantidad
	,p_fec_vencimiento
	,p_empr_id
	,'AC'
	,p_batch_id);

	return 'CORRECTO';

exception
	when unique_violation then 
		RAISE INFO 'error al insertar % : %',sqlerrm,sqlstate;
    	RAISE 'DUP_VAL_LOTALM';
    
    when others then 
		RAISE INFO 'error al insertar % : %',sqlerrm,sqlstate;
    	RAISE;
end;
	-- Enter function body here
$$;
 �   DROP FUNCTION alm.crear_lote_articulo(p_prov_id integer, p_arti_id integer, p_depo_id integer, p_codigo character varying, p_cantidad double precision, p_fec_vencimiento date, p_empr_id integer, p_batch_id bigint);
       alm          postgres    false    6            H           1255    24489    eliminar_lote_articulo(bigint)    FUNCTION     �  CREATE FUNCTION alm.eliminar_lote_articulo(p_batch_id bigint) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
/**
 * Elimina el lote creado anteriorimente
 */
begin

	delete from alm.alm_lotes 
	where batch_id = p_batch_id;

	return 'CORRECTO';

exception
    
    when others then 
		RAISE INFO 'error al eliminar % : %',sqlerrm,sqlstate;
    	RAISE;
end;
	-- Enter function body here
$$;
 =   DROP FUNCTION alm.eliminar_lote_articulo(p_batch_id bigint);
       alm          postgres    false    6            I           1255    21642 /   extraer_lote_articulo(bigint, double precision)    FUNCTION     �  CREATE FUNCTION alm.extraer_lote_articulo(p_batch_id bigint, p_cantidad double precision) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
/**
 * Función para actualizar un lote de almacen con p_batch_id
 * Si no encuentra el lote lanza excepcion BATCH_NO_EXISTE
 */
declare
	v_updated integer; 
	v_existencia alm.alm_lotes.cantidad%type;
begin
	
	select cantidad
	into strict v_existencia
	from alm.alm_lotes
	where batch_id = p_batch_id;

	if v_existencia >= p_cantidad then
		update alm.alm_lotes
		set cantidad = cantidad - p_cantidad
		where batch_id = p_batch_id;
	else 
    	    RAISE INFO 'ALMEXLO - la cantidad no puede ser negativa  existencia % ', v_existencia;
    	    raise 'CANT_MAYOR_EXISTENCIA';
    end if;

    return 'CORRECTO';

	exception
		when NO_DATA_FOUND then 
	 	  RAISE INFO 'ALMEXLO - batch no encontrado %', p_batch_id;
    	  raise 'BATCH_NO_EXISTE';
		when others then 
			raise;
end;
		
$$;
 Y   DROP FUNCTION alm.extraer_lote_articulo(p_batch_id bigint, p_cantidad double precision);
       alm          postgres    false    6            X           1255    21643     obtener_existencia_batch(bigint)    FUNCTION     t  CREATE FUNCTION alm.obtener_existencia_batch(p_batch_id bigint) RETURNS double precision
    LANGUAGE plpgsql
    AS $$
declare	
	v_cantidad alm.alm_lotes.cantidad%type =0;
begin
	select sum(cantidad)
	into strict v_cantidad
	from alm.alm_lotes
	where batch_id = p_batch_id;

	return v_cantidad;
exception
	when no_data_found then	
		raise 'BATCH_INEXISTENTE';

end;

$$;
 ?   DROP FUNCTION alm.obtener_existencia_batch(p_batch_id bigint);
       alm          postgres    false    6            F           1255    21644    log(character varying) 	   PROCEDURE     *  CREATE PROCEDURE core.log(p_msg character varying)
    LANGUAGE plpgsql
    AS $$
declare

begin
     INSERT INTO core.log ( msg)
	           VALUES ( p_msg);
		 commit;
	exception
		when others then	
			raise warning 'error loggeando % - %', sqlerrm,sqlstate;
end
	-- Enter function body here
$$;
 2   DROP PROCEDURE core.log(p_msg character varying);
       core          postgres    false    10            G           1255    21645    set_tabla_id_trg()    FUNCTION     �  CREATE FUNCTION core.set_tabla_id_trg() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
  declare
  	v_mensaje varchar;
  BEGIN
    /** calculo el id de tabla concatenando el nombre de tabla y el valor
     * 
     */
	new.tabl_id = new.tabla||new.valor;

	return new;

exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
	    raise warning 'SETTABLAID: error generando tabla _id %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;
end;

$$;
 '   DROP FUNCTION core.set_tabla_id_trg();
       core          postgres    false    10            _           1255    24490 %   crear_batch_contenedor_retirado_trg()    FUNCTION     e	  CREATE FUNCTION log.crear_batch_contenedor_retirado_trg() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
	DECLARE 	
		v_arti_id alm.alm_articulos.arti_id%TYPE;
		v_prov_id alm.alm_proveedores.prov_id%TYPE;
		v_reci_id prd.recipientes.reci_id%TYPE;
		v_batch_id prd.lotes.batch_id%TYPE;
	    v_step varchar = '0';
	BEGIN
		
		/* Ejecuto solo si se esta generando una orden de transporte
		 * por lo tanto se esta retirando el contenedor con contenido
		 */
	    raise info 'LOGCREABATCH: ortr_id : %',NEW.ortr_id;

		IF NEW.ortr_id IS NOT NULL AND OLD.ortr_id IS NULL THEN 

			raise info 'LOGCREABATCH: generando batch, tica % cont %',NEW.tica_id,NEW.cont_id;

			/* Selecciono el articulo de almacen correspondiente 
			 * al tipo de carga de residuos declarado*/
			SELECT aa.arti_id
			INTO STRICT v_arti_id
			FROM alm.alm_articulos aa 
				,core.tablas t 
			WHERE t.tabl_id = NEW.tica_id
			AND t.valor2 = aa.barcode ;

			v_step = '1';
			raise info 'LOGCREABATCH: articulo %',v_arti_id;

			/* Calculo el proveedor generado para el Solicitante de Transporte
			 * */
			SELECT st.prov_id
			INTO STRICT v_prov_id
			FROM  log.solicitantes_transporte st 
				  ,log.ordenes_transporte ot 
		    WHERE st.sotr_id = ot.sotr_id 
		    AND ot.ortr_id = NEW.ortr_id;

           v_step = '2';
		   raise info 'LOGCREABATCH: prov %',v_prov_id;

		    /* Obtengo el recipiente asociado al contenedor
		     * recibido
		     */
		   
		    SELECT reci_id
		    INTO STRICT v_reci_id
		    FROM log.contenedores c 
		    WHERE c.cont_id = NEW.cont_id;

			v_step = '3';

		    raise info 'LOGCREABATCH: reci %',v_reci_id;

			v_batch_id = prd.crear_lote_v2(NEW.ortr_id||'-'||NEW.cont_id
							  ,v_arti_id
							  ,v_prov_id
							  ,0
							  ,NEW.mts_cubicos
							  ,CAST(0 AS float)
							  ,CAST(NEW.ortr_id AS varchar)
							  ,v_reci_id
							  ,1000 
							  ,NEW.usuario_app
							  ,1
							  ,'false'
							  ,to_date('DD-MM-YYYY','01/01/3000')
							  ,0
							  ,CAST('' AS varchar)
							  ,'false'
							  ,0);
	
	       	   	raise info 'LOGCREABATCH: batch_id creado : %',v_batch_id;
		        v_step = '4';
 
       	   		NEW.batch_id = v_batch_id;
		   END IF;
       	   RETURN NEW;

   exception	
		when no_data_found then 
	        RAISE INFO 'LOGCREABATCH - error creando batch  %: %', sqlstate,sqlerrm;
	        raise exception 'DATOS_BATCH_NF %',v_step;


	END;
$$;
 9   DROP FUNCTION log.crear_batch_contenedor_retirado_trg();
       log          postgres    false    15            `           1255    24491    crear_proveedor_sotr_trg()    FUNCTION     k  CREATE FUNCTION log.crear_proveedor_sotr_trg() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
	DECLARE 
		v_prov_id alm.alm_proveedores.prov_id%TYPE;
	BEGIN
		/* Para un nuevo Solicitante de Transporte genera un nuevo proveedor en almacenes*/
		WITH proveedor_insertado AS (
			INSERT INTO alm.alm_proveedores (nombre,cuit,domicilio,empr_id)
			VALUES (NEW.razon_social,NEW.cuit,NEW.domicilio,1)
			RETURNING prov_id
		)
		
		select prov_id
		into strict v_prov_id
		from proveedor_insertado;

		/* guardo la relación entre el sotr y el proveedor de almacenes*/	
		NEW.prov_id = v_prov_id;
	
		RETURN NEW;
	
	END;
$$;
 .   DROP FUNCTION log.crear_proveedor_sotr_trg();
       log          postgres    false    15            Y           1255    21646    asociar_lote_hijo_trg()    FUNCTION     �
  CREATE FUNCTION prd.asociar_lote_hijo_trg() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
  declare
  v_batch_id_hijo prd.lotes.batch_id%type;
  v_cantidad_hijo alm.alm_deta_entrega_materiales.cantidad%type;
  v_batch_id alm.alm_lotes.batch_id%type;
  v_mensaje varchar;
  v_aux int4;
  BEGIN
    /** primero obtengo el batch_id hijo
     * 
     */
	BEGIN  
		select batch_id
		into strict v_batch_id_hijo
		from alm.alm_pedidos_materiales pema
		     ,alm.alm_entrega_materiales enma
		where pema.pema_id = enma.pema_id
	    and enma.enma_id = new.enma_id;
	   
	   	raise info 'TRASLOHI: batch_id_hijo : %',v_batch_id_hijo;

	exception	
		when no_data_found then 
	        RAISE INFO 'TRASLOHI - error  - Entrega o pedido no existente %', new.enma_id;
			v_mensaje = 'ENMA_NO_ENCONTRADO';
	        raise exception 'ENMA_NO_ENCONTRADO:%',new.enma_id;
	end;
	
	/** Obtengo el batch id del lote de la linea entregada actual **/
	begin
		select batch_id
		into v_batch_id
		from alm.alm_lotes
		where lote_id = new.lote_id;

		raise info 'TRASLOHI: batch id actual : %',v_batch_id;

	exception	
		when no_data_found then 
	        RAISE INFO 'TRASLOHI - error  - alm lote inexistente %', new.lote_id;
			v_mensaje = 'ALOT_NO_ENCONTRADO';
	        raise exception 'ALOT_NO_ENCONTRADO:%',new.lote_id;
		
	end;
	
	/** Verifico si ya se asocio un batch_padre al hijo, sino inserto un registro nuevo de lote hijo**/

	begin
		select 1
		into strict v_aux
		from prd.lotes_hijos
		where batch_id = v_batch_id_hijo
		and batch_id_padre is null;
	
		raise info 'TRASLOHI: hay hijos sin padre con batch id : %',v_batch_id_hijo;

	    update prd.lotes_hijos
	    set batch_id_padre = v_batch_id
	    where batch_id = v_batch_id_hijo
	    and batch_id_padre is null;
	    
	exception
		when no_data_found then 
			/** El lote hijo ya tiene un padre, creo una nueva linea padre para el articulo actual**/
			raise info 'TRASLOHI: NO hay hijos sin padre con batch id : %',v_batch_id_hijo;

			select distinct(cantidad)
			into strict v_cantidad_hijo
			from prd.lotes_hijos
			where batch_id = v_batch_id_hijo;
			
			raise info 'TRASLOHI: cantidad hijo : %',v_cantidad_hijo;
			insert into prd.lotes_hijos
			(batch_id
			 ,batch_id_padre
			 ,empr_id
			 ,cantidad
			 ,cantidad_padre)	
			values(
			v_batch_id_hijo
			,v_batch_id
			,new.empr_id
			,v_cantidad_hijo
			,new.cantidad);

	end;
    
    return new;


exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
	    raise warning 'TRASLOHI: error actualizando lotes hijos %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;
end;

$$;
 +   DROP FUNCTION prd.asociar_lote_hijo_trg();
       prd          postgres    false    8            ]           1255    21647 m   cambiar_recipiente(bigint, integer, integer, integer, character varying, character varying, double precision)    FUNCTION     J  CREATE FUNCTION prd.cambiar_recipiente(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision DEFAULT 0) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
#print_strict_params on

declare
	v_result_lote varchar;
	v_mensaje varchar;
	v_updated integer; 
	v_lote_id prd.lotes.lote_id%type;
	v_num_orden_prod prd.lotes.num_orden_prod%type;
    v_depo_id_destino alm.alm_depositos.depo_id%type;
    v_arti_id prd.lotes.arti_id%type;
    v_prov_id alm.alm_lotes.prov_id%type;
    v_fec_vencimiento alm.alm_lotes.fec_vencimiento%type;
    v_existencia alm.alm_lotes.cantidad%type;
begin

		begin
	        RAISE INFO 'seleccionando datos para lote = %, p_lote_id', p_batch_id_origen;

		   /** tomos los datos del lote de origen a copiar en el nuevo lote **/
		    select lo.lote_id
		    	,lo.num_orden_prod
		    	,al.arti_id
		    	,al.prov_id
		    	,al.fec_vencimiento
		    into strict v_lote_id
		    	 , v_num_orden_prod
		    	 , v_arti_id
		    	 , v_prov_id
		    	 , v_fec_vencimiento
		    from prd.lotes lo
		    	, alm.alm_lotes al
		    where lo.batch_id = p_batch_id_origen
		    and al.batch_id = lo.batch_id;
		   
	        RAISE INFO 'batch, lote, ord prod, arti_id ,prov_id, orden_prod= %, % , % , % , % , %', p_batch_id_origen,v_lote_id,v_num_orden_prod,v_arti_id,v_prov_id,v_fec_vencimiento;

       	exception	   
			when NO_DATA_FOUND then
		        RAISE INFO 'batch no existe %', p_batch_id_origen;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO:%',p_batch_id_origen;
		       
		end;	

	    begin
	        /** obtengo el deposito de destino del recipiente
	         * de destino
	         */
		    select reci.depo_id
		    into strict v_depo_id_destino
		    from prd.recipientes reci
		    where reci.reci_id = p_reci_id_destino;

	   exception	   
			when NO_DATA_FOUND then
		        RAISE INFO 'recipiente no existe %', p_reci_id_destino;
				v_mensaje = 'RECI_NO_ENCONTRADO';
		        raise exception 'RECI_NO_ENCONTRADO:%',p_reci_id_destino;
		       
		end;	
	
		/* Si la cantidad informada es 0, hay que vaciar el lote entero y llevarlo al nuevo recipiente,
		 * sino descuento parcial
		 */
	
		v_existencia = alm.obtener_existencia_batch(p_batch_id_origen);

	 	/* si la cantidad es mayor a la existencia abortamos, sino uso la variable v_existencia para descontar
	 	 * con el valor solicitado por parametro
	 	 */
		if p_cantidad != 0 then
			if p_cantidad > v_existencia then	
			    RAISE INFO 'cantidad mayor a existencia %:%',p_cantidad,v_existencia;
				v_mensaje = 'CANT_MAYOR_EXISTENCIA';
		        raise exception 'CANT_MAYOR_EXISTENCIA:%:%',p_cantidad,v_existencia;
		    else
				v_existencia = p_cantidad;
			end if;
		end if;
	
		/** Crea el batch
		 *  para el movimiento de destino
		 */	   
	   	v_result_lote =
		   	prd.crear_lote_v2(
		   	v_lote_id
		   	,v_arti_id
		   	,v_prov_id
		   	,p_batch_id_origen
		   	,v_existencia
		   	,v_existencia
		   	,v_num_orden_prod  
		   	,p_reci_id_destino 
		   	,p_etap_id_destino
		   	,p_usuario_app 
		   	,p_empre_id
		   	,p_forzar_agregar
		    ,v_fec_vencimiento);
	
	
		return 'CORRECTO';
exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
		raise warning 'cambiar_recipiente: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;
END; 
$$;
 �   DROP FUNCTION prd.cambiar_recipiente(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision);
       prd          postgres    false    8            a           1255    24492 w   cambiar_recipiente_no_return(bigint, integer, integer, integer, character varying, character varying, double precision)    FUNCTION     ?  CREATE FUNCTION prd.cambiar_recipiente_no_return(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision DEFAULT 0) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
#print_strict_params on

declare
	v_result_lote varchar;
	v_mensaje varchar;
	v_updated integer; 
	v_lote_id prd.lotes.lote_id%type;
	v_num_orden_prod prd.lotes.num_orden_prod%type;
    v_depo_id_destino alm.alm_depositos.depo_id%type;
    v_arti_id prd.lotes.arti_id%type;
    v_prov_id alm.alm_lotes.prov_id%type;
    v_fec_vencimiento alm.alm_lotes.fec_vencimiento%type;
    v_existencia alm.alm_lotes.cantidad%type;
begin

		begin
	        RAISE INFO 'seleccionando datos para lote = %, p_lote_id', p_batch_id_origen;

		   /** tomos los datos del lote de origen a copiar en el nuevo lote **/
		    select lo.lote_id
		    	,lo.num_orden_prod
		    	,al.arti_id
		    	,al.prov_id
		    	,al.fec_vencimiento
		    into strict v_lote_id
		    	 , v_num_orden_prod
		    	 , v_arti_id
		    	 , v_prov_id
		    	 , v_fec_vencimiento
		    from prd.lotes lo
		    	, alm.alm_lotes al
		    where lo.batch_id = p_batch_id_origen
		    and al.batch_id = lo.batch_id;
		   
	        RAISE INFO 'batch, lote, ord prod, arti_id ,prov_id, orden_prod= %, % , % , % , % , %', p_batch_id_origen,v_lote_id,v_num_orden_prod,v_arti_id,v_prov_id,v_fec_vencimiento;

       	exception	   
			when NO_DATA_FOUND then
		        RAISE INFO 'batch no existe %', p_batch_id_origen;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO:%',p_batch_id_origen;
		       
		end;	

	    begin
	        /** obtengo el deposito de destino del recipiente
	         * de destino
	         */
		    select reci.depo_id
		    into strict v_depo_id_destino
		    from prd.recipientes reci
		    where reci.reci_id = p_reci_id_destino;

	   exception	   
			when NO_DATA_FOUND then
		        RAISE INFO 'recipiente no existe %', p_reci_id_destino;
				v_mensaje = 'RECI_NO_ENCONTRADO';
		        raise exception 'RECI_NO_ENCONTRADO:%',p_reci_id_destino;
		       
		end;	
	
		/* Si la cantidad informada es 0, hay que vaciar el lote entero y llevarlo al nuevo recipiente,
		 * sino descuento parcial
		 */
	
		v_existencia = alm.obtener_existencia_batch(p_batch_id_origen);

	 	/* si la cantidad es mayor a la existencia abortamos, sino uso la variable v_existencia para descontar
	 	 * con el valor solicitado por parametro
	 	 */
		if p_cantidad != 0 then
			if p_cantidad > v_existencia then	
			    RAISE INFO 'cantidad mayor a existencia %:%',p_cantidad,v_existencia;
				v_mensaje = 'CANT_MAYOR_EXISTENCIA';
		        raise exception 'CANT_MAYOR_EXISTENCIA:%:%',p_cantidad,v_existencia;
		    else
				v_existencia = p_cantidad;
			end if;
		end if;
	
		/** Crea el batch
		 *  para el movimiento de destino
		 */	   
	   	v_result_lote =
		   	prd.crear_lote_v2(
		   	v_lote_id
		   	,v_arti_id
		   	,v_prov_id
		   	,p_batch_id_origen
		   	,v_existencia
		   	,v_existencia
		   	,v_num_orden_prod  
		   	,p_reci_id_destino 
		   	,p_etap_id_destino
		   	,p_usuario_app 
		   	,p_empre_id
		   	,p_forzar_agregar
		    ,v_fec_vencimiento);
	
	
exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
		raise warning 'cambiar_recipiente: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;
END; 
$$;
 �   DROP FUNCTION prd.cambiar_recipiente_no_return(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision);
       prd          postgres    false    8            b           1255    24494 r   cambiar_recipiente_proc(bigint, integer, integer, integer, character varying, character varying, double precision) 	   PROCEDURE     !  CREATE PROCEDURE prd.cambiar_recipiente_proc(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision DEFAULT 0)
    LANGUAGE plpgsql
    AS $$
#print_strict_params on

declare
	v_result_lote varchar;
	v_mensaje varchar;
	v_updated integer; 
	v_lote_id prd.lotes.lote_id%type;
	v_num_orden_prod prd.lotes.num_orden_prod%type;
    v_depo_id_destino alm.alm_depositos.depo_id%type;
    v_arti_id prd.lotes.arti_id%type;
    v_prov_id alm.alm_lotes.prov_id%type;
    v_fec_vencimiento alm.alm_lotes.fec_vencimiento%type;
    v_existencia alm.alm_lotes.cantidad%type;
begin

		begin
	        RAISE INFO 'seleccionando datos para lote = %, p_lote_id', p_batch_id_origen;

		   /** tomos los datos del lote de origen a copiar en el nuevo lote **/
		    select lo.lote_id
		    	,lo.num_orden_prod
		    	,al.arti_id
		    	,al.prov_id
		    	,al.fec_vencimiento
		    into strict v_lote_id
		    	 , v_num_orden_prod
		    	 , v_arti_id
		    	 , v_prov_id
		    	 , v_fec_vencimiento
		    from prd.lotes lo
		    	, alm.alm_lotes al
		    where lo.batch_id = p_batch_id_origen
		    and al.batch_id = lo.batch_id;
		   
	        RAISE INFO 'batch, lote, ord prod, arti_id ,prov_id, orden_prod= %, % , % , % , % , %', p_batch_id_origen,v_lote_id,v_num_orden_prod,v_arti_id,v_prov_id,v_fec_vencimiento;

       	exception	   
			when NO_DATA_FOUND then
		        RAISE INFO 'batch no existe %', p_batch_id_origen;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO:%',p_batch_id_origen;
		       
		end;	

	    begin
	        /** obtengo el deposito de destino del recipiente
	         * de destino
	         */
		    select reci.depo_id
		    into strict v_depo_id_destino
		    from prd.recipientes reci
		    where reci.reci_id = p_reci_id_destino;

	   exception	   
			when NO_DATA_FOUND then
		        RAISE INFO 'recipiente no existe %', p_reci_id_destino;
				v_mensaje = 'RECI_NO_ENCONTRADO';
		        raise exception 'RECI_NO_ENCONTRADO:%',p_reci_id_destino;
		       
		end;	
	
		/* Si la cantidad informada es 0, hay que vaciar el lote entero y llevarlo al nuevo recipiente,
		 * sino descuento parcial
		 */
	
		v_existencia = alm.obtener_existencia_batch(p_batch_id_origen);

	 	/* si la cantidad es mayor a la existencia abortamos, sino uso la variable v_existencia para descontar
	 	 * con el valor solicitado por parametro
	 	 */
		if p_cantidad != 0 then
			if p_cantidad > v_existencia then	
			    RAISE INFO 'cantidad mayor a existencia %:%',p_cantidad,v_existencia;
				v_mensaje = 'CANT_MAYOR_EXISTENCIA';
		        raise exception 'CANT_MAYOR_EXISTENCIA:%:%',p_cantidad,v_existencia;
		    else
				v_existencia = p_cantidad;
			end if;
		end if;
	
		/** Crea el batch
		 *  para el movimiento de destino
		 */	   
	   	v_result_lote =
		   	prd.crear_lote_v2(
		   	v_lote_id
		   	,v_arti_id
		   	,v_prov_id
		   	,p_batch_id_origen
		   	,v_existencia
		   	,v_existencia
		   	,v_num_orden_prod  
		   	,p_reci_id_destino 
		   	,p_etap_id_destino
		   	,p_usuario_app 
		   	,p_empre_id
		   	,p_forzar_agregar
		    ,v_fec_vencimiento);
	
	
exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
		raise warning 'cambiar_recipiente: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;
END; 
$$;
 �   DROP PROCEDURE prd.cambiar_recipiente_proc(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision);
       prd          postgres    false    8            Z           1255    21649 �   crear_lote(character varying, integer, integer, bigint, double precision, double precision, character varying, integer, integer, character varying, integer, character varying, date, integer, character varying)    FUNCTION     �  CREATE FUNCTION prd.crear_lote() RETURNS 
    LANGUAGE plpgsql
    AS $$
/** Funcion para generar un nuevo lote
 *  Recibe como parametro un id de lote
 *  y un recipiente donde crear el batch.
 *  Si el recipiente esta ocupado, devuelve el error
 */
#print_strict_params on
DECLARE
 v_estado_recipiente prd.recipientes.estado%type; 
 v_batch_id prd.lotes.batch_id%type;
 v_mensaje varchar;
 v_reci_id_padre prd.recipientes.reci_id%type;
 v_depo_id prd.recipientes.depo_id%type;
 v_lote_id prd.lotes.lote_id%type;
 v_arti_id alm.alm_lotes.arti_id%type;
 v_cantidad_padre alm.alm_lotes.cantidad%type;
 v_recu_id prd.recursos_lotes.recu_id%type;
 v_resultado varchar;
BEGIN


		begin
	        RAISE INFO 'PRDCRLO - ṕ_forzar_agregar = %, p_lote_id % y p_batch_id_padre %: ', p_forzar_agregar, p_lote_id, p_batch_id_padre;

			select reci.estado
				   ,reci.depo_id
			into strict v_estado_recipiente
				,v_depo_id
			from PRD.RECIPIENTES reci
			where reci.reci_id = p_reci_id;

			/** Valido que el recipiente exista y no tenga contenido **/
		    if (p_forzar_agregar!='true') then
				
				    if v_estado_recipiente != 'VACIO' then
		
				        RAISE INFO 'PRDCRLO - error 1 - recipiente lleno , estado = % ', v_estado_recipiente;
		                v_mensaje = 'RECI_NO_VACIO';
				    	raise exception 'RECI_NO_VACIO:%',p_reci_id;
				    end if;
				   
		    end if;
		exception	   
			when too_many_rows then
		        RAISE INFO 'PRDCRLO - error 9 - recipiente duplicado %', p_reci_id;
				v_mensaje = 'RECI_DUPLICADO';
		        raise exception 'RECI_DUPLICADO:%',p_reci_id;
		       

			when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 2 - recipiente no encontrado %', p_reci_id;
				v_mensaje = 'RECI_NO_ENCONTRADO';
		        raise exception 'RECI_NO_ENCONTRADO:%',p_reci_id;
		       
		end;	

   /**
	 * Una vez validado el recipiente, creo el nuevo lote
	 */		
		
    if (p_forzar_agregar='true') then
	    RAISE INFO 'PRDCRLO - 2 - ṕ_forzar_agregar = %, p_lote_id % y p_batch_id_padre %: ', p_forzar_agregar, p_lote_id, p_batch_id_padre;

        begin
	        select lo.batch_id
	        	   ,lo.lote_id
	        	   ,al.arti_id
	        into strict v_batch_id
	        	 ,v_lote_id
	        	 ,v_arti_id
	        from prd.lotes lo
	             ,alm.alm_lotes al
	        where reci_id  = p_reci_id
	        and lo.batch_id = al.batch_id
	        and lo.estado = 'En Curso';

	     /**
	      * Valido que si se quieren unir lotes, coincida el articulo y el nuemro de lote
	      */
	    if v_arti_id != p_arti_id or p_lote_id != v_lote_id then
		        RAISE INFO 'PRDCRLO - error 3 el articulo y lote destino %:% son != de los solicitados %,%',v_arti_id,v_lote_id,p_arti_id,p_lote_id;
				v_mensaje = 'ART_O_LOTE_DISTINTO';
				raise exception 'ART_O_LOTE_DISTINTO:%-%-%-%',v_arti_id,v_lote_id,p_arti_id,p_lote_id;
	    end if;
	       
	    exception
		   when TOO_MANY_ROWS then
		        RAISE INFO 'PRDCRLO - error 20 = %',sqlerrm;
				v_mensaje = 'RECI_DUPLICADO';
				raise exception 'RECI_DUPLICADO:%',p_reci_id;

	    	when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 4 = %',sqlerrm;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
				raise exception 'BATCH_NO_ENCONTRADO:%',sqlerrm;
        end;
	       
    else
		begin
    		RAISE INFO 'PRDCRLO - p_forzar_agregar = %, p_lote_id % y p_batch_id_padre %: ', p_forzar_agregar, p_lote_id, p_batch_id_padre;
	
		    /** Inserto en la tabla de batch, creando el batch_id
		     * de la secuencia de lotes
		     */
			with inserted_batch as (
				insert into 
				prd.lotes (
				lote_id
				,estado
				,num_orden_prod
				,etap_id
				,usuario_app
				,reci_id
				,empr_id)	
				values (
				p_lote_id
				,'En Curso'
				,p_num_orden_prod
				,p_etap_id
				,p_usuario_app
				,p_reci_id
				,p_empr_id
				)
				returning batch_id
			)
		
			select batch_id
			into strict v_batch_id
			from inserted_batch;
		    
		    /** Actualizo el recipiente como lleno
		     */
		    update prd.recipientes 
		    set estado = 'LLENO'
		    where reci_id = p_reci_id;

	   exception
		   when others then
		        RAISE INFO 'PRDCRLO - error 5 - error creando lote y recipiente  %:% ',sqlstate,sqlerrm;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO:%',sqlerrm;
		   end;
		  
    end if;
		
    /** Actualizo el arbol de batchs colocando el 
     *  nuevo batch como hijo del p_batch_id_padre
     * si el padre viene en 0 es un batch al inicio 
     * del proceso productivo 
     */
	insert into prd.lotes_hijos (
	batch_id
	,batch_id_padre
	,empr_id
	,cantidad
	,cantidad_padre)
	values
	(v_batch_id
	,case when p_batch_id_padre = 0 then null else p_batch_id_padre end
	,p_empr_id
	,p_cantidad
	,p_cantidad_padre);
	
	RAISE INFO 'PRDCRLO - Batch id % generado en recipiente %',v_batch_id,p_reci_id;

    /**Cambiamos el estado del lote origen a FINALIZADO si ya no quedan existencias
	 * y vacio el recipiente
	 */

	
	if (p_batch_id_padre !=0 and p_cantidad_padre != 0) then
	
		--Obtengo la exisstencia actual del padre para entender si finalizar
		v_cantidad_padre = alm.obtener_existencia_batch(p_batch_id_padre);
		
		RAISE INFO 'PRDCRLO - cantidad padre existente:informada %.%',v_cantidad_padre,p_cantidad_padre;

		if v_cantidad_padre - p_cantidad_padre = 0 then
	
			RAISE INFO 'PRDCRLO - Finalizando lote % ',p_batch_id_padre;

			update prd.lotes
			set estado = 'FINALIZADO'
			where batch_id = p_batch_id_padre
			returning reci_id into v_reci_id_padre;
	
			update prd.recipientes
			set estado = 'VACIO'
			where reci_id = v_reci_id_padre;
		end if;
	

		/**
		 * Actualizo la existencia del padre
		 */

		RAISE INFO 'PRDCRLO - actualizo existencia %:% ',p_batch_id_padre,p_cantidad_padre;

		v_resultado = alm.extraer_lote_articulo(p_batch_id_padre
												,p_cantidad_padre);
	
	end if;
    /**
     * Genera el lote asociado en almacenes
     *
     */
	if p_arti_id != 0 then --si se informa articulos del lote los inserto en alm_lotes, sino no
	    if (p_forzar_agregar='true') then
	
	    	RAISE INFO 'PRDCRLO - forzar agregar es true, agrego cantidad % al batch %',p_cantidad,v_batch_id;
	    	v_resultado = alm.agregar_lote_articulo(v_batch_id
													,p_cantidad);
		else
	    	RAISE INFO 'PRDCRLO - forzar agregar es false, ingreso cantidad % al batch %',p_cantidad,v_batch_id;
	 
			v_resultado = alm.crear_lote_articulo(
									p_prov_id
									,p_arti_id 
									,v_depo_id
									,p_lote_id 
									,p_cantidad 
									,p_fec_vencimiento
									,p_empr_id 
									,v_batch_id );
		end if;						
	end if;

	RAISE INFO 'PRDCRLO - resultado ops almacen %',v_resultado;

	/** Si el actual lote tiene un recurso asociado lo asocio **/
    if p_recu_id is not null and p_recu_id != 0 then
    	
       begin
    		RAISE INFO 'PRDCRLO - p_recu_id = %', p_recu_id;

			/** Valido que el recursos  exista  **/
			select recu_id
			into strict v_recu_id
			from prd.recursos recu
			where recu.recu_id = p_recu_id;

			insert into prd.recursos_lotes(batch_id
											,recu_id
											,empr_id
											,cantidad
											,tipo)
					values (v_batch_id
							,p_recu_id
							,p_empr_id
							,p_cantidad
							,p_tipo_recurso);
						
		exception	   
		
			when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 10 - recurso no encontrado %', p_recu_id;
				v_mensaje = 'RECU_NO_ENCONTRADO';
		        raise exception 'RECU_NO_ENCONTRADO:%',p_recu_id;
		       
		end;	

	end if;

	return v_batch_id;


exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
	    raise warning 'crear_lote: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;

END; 
$$;
     DROP FUNCTION prd.crear_lote();
       prd          postgres    false    8            c           1255    24496 �   crear_lote(character varying, integer, integer, bigint, double precision, double precision, character varying, integer, integer, character varying, integer, character varying, date, integer, character varying, character varying, bigint)    FUNCTION     �*  CREATE FUNCTION prd.crear_lote(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying DEFAULT 'false'::character varying, p_fec_vencimiento date DEFAULT NULL::date, p_recu_id integer DEFAULT NULL::integer, p_tipo_recurso character varying DEFAULT NULL::character varying, p_planificado character varying DEFAULT 'false'::character varying, p_batch_id bigint DEFAULT NULL::bigint) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
/** Funcion para generar un nuevo lote
 *  Recibe como parametro un id de lote
 *  y un recipiente donde crear el batch.
 *  Si el recipiente esta ocupado, devuelve el error
 */
#print_strict_params on
DECLARE
 v_estado_recipiente prd.recipientes.estado%type; 
 v_batch_id prd.lotes.batch_id%type;
 v_mensaje varchar;
 v_reci_id_padre prd.recipientes.reci_id%type;
 v_depo_id prd.recipientes.depo_id%type;
 v_lote_id prd.lotes.lote_id%type;
 v_arti_id alm.alm_lotes.arti_id%type;
 v_cantidad_padre alm.alm_lotes.cantidad%type;
 v_recu_id prd.recursos_lotes.recu_id%type;
 v_resultado varchar;
 v_estado varchar;
 v_cantidad float;
 v_cuenta integer;
BEGIN
		
	/* seteo el estado inicial dependiendo si se llama al procedure desde Guardar o desde Planificar estapa */
		if (p_planificado='true') then
			v_estado = 'PLANIFICADO';
		else
			v_estado = 'En Curso';
		end if;
		
		/**************************
		 * BLOQUE 1: VALIDO EL ESTADO DEL RECIPIENTE
		 */
		begin
		        
			RAISE INFO 'PRDCRLO - ṕ_forzar_agregar = %, p_lote_id % y p_batch_id_padre %: ', p_forzar_agregar, p_lote_id, p_batch_id_padre;

			select reci.estado
				   ,reci.depo_id
			into strict v_estado_recipiente
				,v_depo_id
			from PRD.RECIPIENTES reci
			where reci.reci_id = p_reci_id;

			/** Valido que el recipiente exista y no tenga contenido **/
		    if (p_forzar_agregar!='true') and p_planificado = 'false' then
				
				    if v_estado_recipiente != 'VACIO' then
		
				        RAISE INFO 'PRDCRLO - error 1 - recipiente lleno , estado = % ', v_estado_recipiente;
		                v_mensaje = 'RECI_NO_VACIO';
				    	raise exception 'RECI_NO_VACIO:%',p_reci_id;
				    end if;
				   
		    end if;
		exception	   
			when too_many_rows then
		        RAISE INFO 'PRDCRLO - error 9 - recipiente duplicado %', p_reci_id;
				v_mensaje = 'RECI_DUPLICADO';
		        raise exception 'RECI_DUPLICADO:%',p_reci_id;
		       

			when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 2 - recipiente no encontrado %', p_reci_id;
				v_mensaje = 'RECI_NO_ENCONTRADO';
		        raise exception 'RECI_NO_ENCONTRADO:%',p_reci_id;
		       
		end;	

   /*******************************************
    * BLOQUE 2 CREO O REUTILIZO LOTE
    * 
    */
	
   /**
	 * Una vez validado el recipiente, creo el nuevo lote
	 */		
		
    if (p_forzar_agregar='true') then
	    RAISE INFO 'PRDCRLO - 2 - ṕ_forzar_agregar = %, p_lote_id % y p_batch_id_padre %: ', p_forzar_agregar, p_lote_id, p_batch_id_padre;

        begin
	        select lo.batch_id
	        	   ,lo.lote_id
	        	   ,al.arti_id
	        into strict v_batch_id
	        	 ,v_lote_id
	        	 ,v_arti_id
	        from prd.lotes lo
	             ,alm.alm_lotes al
	        where reci_id  = p_reci_id
	        and lo.batch_id = al.batch_id
	        and lo.estado = 'En Curso';

	     /**
	      * Valido que si se quieren unir lotes, coincida el articulo y el nuemro de lote
	      */
	    if v_arti_id != p_arti_id or p_lote_id != v_lote_id then
		        RAISE INFO 'PRDCRLO - error 3 el articulo y lote destino %:% son != de los solicitados %,%',v_arti_id,v_lote_id,p_arti_id,p_lote_id;
				v_mensaje = 'ART_O_LOTE_DISTINTO';
				raise exception 'ART_O_LOTE_DISTINTO:%-%-%-%',v_arti_id,v_lote_id,p_arti_id,p_lote_id;
	    end if;
	       
	    exception
		   when TOO_MANY_ROWS then
		        RAISE INFO 'PRDCRLO - error 20 = %',sqlerrm;
				v_mensaje = 'RECI_DUPLICADO';
				raise exception 'RECI_DUPLICADO:%',p_reci_id;

	    	when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 4 = %',sqlerrm;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
				raise exception 'BATCH_NO_ENCONTRADO:%',sqlerrm;
        end;
	       
    else
		begin
    		RAISE INFO 'PRDCRLO - p_forzar_agregar = %, p_lote_id % y p_batch_id_padre %: ', p_forzar_agregar, p_lote_id, p_batch_id_padre;
	
		    /** Inserto en la tabla de batch, creando el batch_id
		     * de la secuencia de lotes
		     */
    		if p_batch_id is not null and p_batch_id != 0 then
    		/* me informan un batch id existente, viene de un batch guardado pero no iniciado, no lo inserto*/
    			v_batch_id = p_batch_id;
    			
    			with updated_batch as (
	    			update prd.lotes 
	    			set lote_id = p_lote_id
	    				,estado = v_estado
	    				,num_orden_prod = p_num_orden_prod
	    				,reci_id = p_reci_id
	    			where batch_id = v_batch_id
	    			returning 1)
	    			
				select count(1)
				from updated_batch
				into strict v_cuenta;

				if v_cuenta = 0 then
			    	    RAISE INFO 'PRDCLO - no se encontro el batch id % cuenta % ', p_batch_id,v_cuenta;
			    	    raise 'BATCH_NO_ENCONTRADO';
			    end if;
    		
    		
    		else
				with inserted_batch as (
					insert into 
					prd.lotes (
					lote_id
					,estado
					,num_orden_prod
					,etap_id
					,usuario_app
					,reci_id
					,empr_id)	
					values (
					p_lote_id
					,v_estado
					,p_num_orden_prod
					,p_etap_id
					,p_usuario_app
					,p_reci_id
					,p_empr_id
					)
					returning batch_id
				)

				select batch_id
				into strict v_batch_id
				from inserted_batch;

			end if;
		
			/** si estay grabando planificado no debo lockear el recipiente */
			if v_estado != 'En Curso' then		
			    
			    /** Actualizo el recipiente como lleno
			     */
			    update prd.recipientes 
			    set estado = 'LLENO'
			    where reci_id = p_reci_id;

			end if;
		
	   exception
		   when others then
		        RAISE INFO 'PRDCRLO - error 5 - error creando lote y recipiente  %:% ',sqlstate,sqlerrm;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO:%',sqlerrm;
		   end;
		  
    end if;
		
    /******************************************************************************
     * BLOQUE 3: ASOCIACION CON LOTES PADRE Y ACTUALIZACION ESTADOS Y  DE CANTIDADES
     * 
     */
   
    if v_estado != 'PLANIFICADO' then
	    /** Actualizo el arbol de batchs colocando el 
	     *  nuevo batch como hijo del p_batch_id_padre
	     * si el padre viene en 0 es un batch al inicio 
	     * del proceso productivo 
	     */
		insert into prd.lotes_hijos (
		batch_id
		,batch_id_padre
		,empr_id
		,cantidad
		,cantidad_padre)
		values
		(v_batch_id
		,case when p_batch_id_padre = 0 then null else p_batch_id_padre end
		,p_empr_id
		,p_cantidad
		,p_cantidad_padre);
		
		RAISE INFO 'PRDCRLO - Batch id % generado en recipiente %',v_batch_id,p_reci_id;
	
	    /**Cambiamos el estado del lote origen a FINALIZADO si ya no quedan existencias
		 * y vacio el recipiente
		 */
	
		
		if (p_batch_id_padre !=0 and p_cantidad_padre != 0) then
		
			--Obtengo la exisstencia actual del padre para entender si finalizar
			v_cantidad_padre = alm.obtener_existencia_batch(p_batch_id_padre);
			
			RAISE INFO 'PRDCRLO - cantidad padre existente:informada %.%',v_cantidad_padre,p_cantidad_padre;
	
			if v_cantidad_padre - p_cantidad_padre = 0 then
		
				RAISE INFO 'PRDCRLO - Finalizando lote % ',p_batch_id_padre;
	
				update prd.lotes
				set estado = 'FINALIZADO'
				where batch_id = p_batch_id_padre
				returning reci_id into v_reci_id_padre;
		
				update prd.recipientes
				set estado = 'VACIO'
				where reci_id = v_reci_id_padre;
			end if;
		
	
			/**
			 * Actualizo la existencia del padre
			 */
	
			RAISE INFO 'PRDCRLO - actualizo existencia %:% ',p_batch_id_padre,p_cantidad_padre;
	
			v_resultado = alm.extraer_lote_articulo(p_batch_id_padre
													,p_cantidad_padre);
		
		end if;
	    /**
	     * Genera el lote asociado en almacenes
	     *
	     */
	
    end if;	

	/*************************************************************************************
	 * BLOQUE 4: ACTUALIZACION DE LOTE EN ALMACENES EN CASO DE INFORMARCE ARTI_ID
	 * 
	 */
   
	if p_arti_id != 0 then --si se informa articulos del lote los inserto en alm_lotes, sino no
	    if (p_forzar_agregar='true') then
	
	    	RAISE INFO 'PRDCRLO - forzar agregar es true, agrego cantidad % al batch %',p_cantidad,v_batch_id;
	    	v_resultado = alm.agregar_lote_articulo(v_batch_id
													,p_cantidad);
		else
	    	RAISE INFO 'PRDCRLO - forzar agregar es false, ingreso cantidad % al batch %',p_cantidad,v_batch_id;
			
			v_cantidad = alm.obtener_existencia_batch(v_batch_id);
			
			/* Si existia lote, seguramente el lote fue grabado como PLANIFICADO
			 * Como debe haber un unico producto por lote
			 * elimino el lote almacen anterior asociado al actual batch_id
			 */
			if v_cantidad != 0 then
	    		v_resultado = alm.eliminar_lote_articulo(v_batch_id);
	    	end if;
	    
			v_resultado = alm.crear_lote_articulo(
									p_prov_id
									,p_arti_id 
									,v_depo_id
									,p_lote_id 
									,p_cantidad 
									,p_fec_vencimiento
									,p_empr_id 
									,v_batch_id );
		end if;						
	end if;

	RAISE INFO 'PRDCRLO - resultado ops almacen %',v_resultado;

	/*************************************************************************
	 * BLOQUE 5: ACTUALIZACION DE RECURSO DE TRABAJO EN CASO DE INFORMARSE
	 * 
	 */


	/** Si el actual lote tiene un recurso asociado lo asocio **/
    if p_recu_id is not null and p_recu_id != 0 then
    	
       begin
    		RAISE INFO 'PRDCRLO - p_recu_id = %', p_recu_id;

			/** Valido que el recursos  exista  **/
			select recu_id
			into strict v_recu_id
			from prd.recursos recu
			where recu.recu_id = p_recu_id;

			insert into prd.recursos_lotes(batch_id
											,recu_id
											,empr_id
											,cantidad
											,tipo)
					values (v_batch_id
							,p_recu_id
							,p_empr_id
							,p_cantidad
							,p_tipo_recurso);
						
		exception	   
		
			when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 10 - recurso no encontrado %', p_recu_id;
				v_mensaje = 'RECU_NO_ENCONTRADO';
		        raise exception 'RECU_NO_ENCONTRADO:%',p_recu_id;
		       
		end;	

	end if;

	return v_batch_id;


exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
	    raise warning 'crear_lote: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;

END; 
$$;
 �  DROP FUNCTION prd.crear_lote(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying, p_fec_vencimiento date, p_recu_id integer, p_tipo_recurso character varying, p_planificado character varying, p_batch_id bigint);
       prd          postgres    false    8            d           1255    24498 �   crear_lote_v2(character varying, integer, integer, bigint, double precision, double precision, character varying, integer, integer, character varying, integer, character varying, date, integer, character varying, character varying, bigint)    FUNCTION     a6  CREATE FUNCTION prd.crear_lote_v2(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying DEFAULT 'false'::character varying, p_fec_vencimiento date DEFAULT NULL::date, p_recu_id integer DEFAULT NULL::integer, p_tipo_recurso character varying DEFAULT NULL::character varying, p_planificado character varying DEFAULT 'false'::character varying, p_batch_id bigint DEFAULT NULL::bigint) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
/** Funcion para generar un nuevo lote
 *  Recibe como parametro un id de lote
 *  y un recipiente donde crear el batch.
 *  Si el recipiente esta ocupado, devuelve el error
 */
#print_strict_params on
DECLARE
 v_estado_recipiente prd.recipientes.estado%type; 
 v_batch_id prd.lotes.batch_id%type;
 v_batch_id_aux prd.lotes.batch_id%type;
 v_mensaje varchar;
 v_reci_id_padre prd.recipientes.reci_id%type;
 v_depo_id prd.recipientes.depo_id%type;
 v_lote_id prd.lotes.lote_id%type;
 v_arti_id alm.alm_lotes.arti_id%type;
 v_cantidad_padre alm.alm_lotes.cantidad%type;
 v_recu_id prd.recursos_lotes.recu_id%type;
 v_resultado varchar;
 v_estado varchar;
 v_cantidad float;
 v_cuenta integer;
 v_artDif boolean = false;
 v_lotDif boolean = false;
 v_lotartIgual boolean = false;
 v_countLotesRec integer = 0;
 v_info_error varchar;
 verificarRecipiente CURSOR (p_batch_id INTEGER
			   ,p_arti_id INTEGER
			   ,p_lote_id VARCHAR) for
				select lo.batch_id
				,al.arti_id
				,lo.lote_id
				from prd.lotes lo
				,alm.alm_lotes al
				where reci_id  = p_reci_id
				and (al.arti_id != p_arti_id or lo.lote_id != p_lote_id)
				and lo.batch_id = al.batch_id
				and lo.estado = 'En Curso';


BEGIN
		
		/* seteo el estado inicial dependiendo si se llama al procedure desde Guardar o desde Planificar estapa */
		if (p_planificado='true') then
			v_estado = 'PLANIFICADO';
		else
			v_estado = 'En Curso';
		end if;
		
		/**************************
		 * BLOQUE 1: VALIDO EL ESTADO DEL RECIPIENTE
		 */
		begin
		        
			RAISE INFO 'PRDCRLO - BL1 valido reci - ṕ_forzar_agregar = %, p_lote_id % ', p_forzar_agregar, p_lote_id;

			/** Valido que el recipiente exista y no tenga contenido **/
			select reci.estado
				   ,reci.depo_id
			into strict v_estado_recipiente
				,v_depo_id
			from PRD.RECIPIENTES reci
			where reci.reci_id = p_reci_id;

				       
	    		/*
		 	* 1 - si forzar_agregar = false, verifica si el recipiente esta vacio, si no esta vacio 
		 	*  a) verifica si en el recipiente esta el mismo articulo, sino retorna RECI_NO_VACIO_DIST_ART
		 	*  b) si es mismo articulo y distinto lote retorna RECI_NO_VACIO_DIST_LOTE_IGUAL_ART
		 	*  c) si es mismo arituclo y lote retorna RECI_NO_VACIO_MISMO_IGUAL_ART_LOTE
                	*/	
    
			if v_estado_recipiente != 'VACIO' then
				open verificarRecipiente(p_reci_id,p_arti_id,p_lote_id);
				loop
					fetch verificarRecipiente into v_batch_id_aux ,v_arti_id,v_lote_id;
					exit when NOT FOUND;
      
       				if v_arti_id != p_arti_id then 
       					RAISE DEBUG 'PRDCRLO - revisando recipientes batch v_arti_id p arti id % % %',v_batch_id_aux,v_arti_id,p_arti_id;
						v_artDif = true;
					elsif v_lote_id != p_lote_id then
       					RAISE DEBUG 'PRDCRLO - revisando recipientes batch v_lote_id p lote id % >%< >%<',v_batch_id_aux,v_lote_id,p_lote_id;
						v_lotDif = true;					        		
					else 
						v_lotartIgual = true;
					end if;
				end loop;
				close verificarRecipiente;
				RAISE INFO 'PRDCRLO - revisando recipientes banderas % % %',v_artDif,v_lotDif,v_lotartIgual;
			
				/* Corto la ejecución, hay que advertir al usuario que el recipiente no esta vacio y que decida que hacer **/
	    		if p_forzar_agregar!='true' and p_planificado = 'false' then
	
	    			v_info_error = 'reci_id='||p_reci_id||'-arti_id='||p_arti_id||'-lote_id='||p_lote_id;
					if v_artDif then
			            v_mensaje = 'RECI_NO_VACIO_DIST_ART'; /* caso a */
						raise exception 'RECI_NO_VACIO_DIST_ART-%',v_info_error;
					elsif v_lotDif then
			            v_mensaje = 'RECI_NO_VACIO_DIST_LOTE_IGUAL_ART'; /* caso b */
				    	raise exception 'RECI_NO_VACIO_DIST_LOTE_IGUAL_ART-%',v_info_error;
					else
			            v_mensaje = 'RECI_NO_VACIO_IGUAL_ART_LOTE'; /* caso c */
				    	raise exception 'RECI_NO_VACIO_IGUAL_ART_LOTE-%',v_info_error;
					end if;
				else	
					if v_lotartIgual then
						v_artDif = false;
						v_lotDif = false;
					end if;
				end if;	
	
			end if;
				  
		exception	   
			when too_many_rows then
		        RAISE INFO 'PRDCRLO - error 9 - recipiente duplicado %', p_reci_id;
				v_mensaje = 'RECI_DUPLICADO';
		        raise exception 'RECI_DUPLICADO:%',p_reci_id;

			when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 2 - recipiente no encontrado %', p_reci_id;
				v_mensaje = 'RECI_NO_ENCONTRADO';
		        raise exception 'RECI_NO_ENCONTRADO:%',p_reci_id;
		       
		end;	

   /*******************************************
    * BLOQUE 2 CREO O REUTILIZO LOTE
    * 
    */
	
   /**
    * Una vez validado el recipiente, creo el nuevo lote
    * si forzar agregar = true, entonces
    *  para el caso a) crea un nuevo lote con mismo reci_id (unifica recipientes)
    *  para el caso b) crea un nuevo lote con mismo reci_id (unifica recipientes)
    *  para el caso c) actualiza la existencia del lote con mismo arti y lote (unifica lote)
     **/

    RAISE INFO 'PRDCRLO - BL2  lote -  v_estado_recipiente % v_artDif % v_lotDif % ', v_estado_recipiente,v_artDif,v_lotDif;
		
    if ( p_planificado = 'true' or ( v_estado_recipiente = 'VACIO' or  v_artDif or  v_lotDif ) )then
   
	begin
	
    		if p_batch_id is not null and p_batch_id != 0 then
    		/* me informan un batch id existente, viene de un batch guardado pero no iniciado, no lo inserto*/
    			RAISE INFO 'PRDCRLO - reu lote -  v_estado = %, p_lote_id % y v_batch_id %: ', v_estado, p_lote_id, p_batch_id;

    			v_batch_id = p_batch_id;
    			
    			with updated_batch as (
	    			update prd.lotes 
	    			set lote_id = p_lote_id
	    				,estado = v_estado
	    				,num_orden_prod = p_num_orden_prod
	    				,reci_id = p_reci_id
	    			where batch_id = v_batch_id
	    			returning 1)
	    			
				select count(1)
				from updated_batch
				into strict v_cuenta;

				if v_cuenta = 0 then
			    	    RAISE INFO 'PRDCLO - no se encontro el batch id % cuenta % ', p_batch_id,v_cuenta;
			    	    raise 'BATCH_NO_ENCONTRADO-F';
			    end if;
    			
				    		
    		else
    		    RAISE INFO 'PRDCRLO - ins lote -  p_lote_id % ', p_lote_id;

				with inserted_batch as (
					insert into 
					prd.lotes (
					lote_id
					,estado
					,num_orden_prod
					,etap_id
					,usuario_app
					,reci_id
					,empr_id)	
					values (
					p_lote_id
					,v_estado
					,p_num_orden_prod
					,p_etap_id
					,p_usuario_app
					,p_reci_id
					,p_empr_id
					)
					returning batch_id
				)

				select batch_id
				into strict v_batch_id
				from inserted_batch;

				RAISE INFO 'PRDCRLO - ins lote -  v_batch_id % ', v_batch_id;

			end if;
		
			/** si estay grabando planificado no debo lockear el recipiente */
			if v_estado != 'PLANIFICADO' then		
			    
			    /** Actualizo el recipiente como lleno
			     */
			    update prd.recipientes 
			    set estado = 'LLENO'
			    where reci_id = p_reci_id;

			end if;
						
		
	   exception
		   when others then
		        RAISE INFO 'PRDCRLO - error 5 - error creando lote y recipiente  %:% ',sqlstate,sqlerrm;
			v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO-RF:%',sqlerrm;
		   end;
    else /** Existe un recipiente lleno con mismo arti_id y lote_id que el lote que queremos crear, no lo creo sino unifico **/
	begin
			RAISE INFO 'PRDCRLO - nada con lote -  p_forzar_agregar = %', p_forzar_agregar;

	        select lo.batch_id
	        into strict v_batch_id
	        from prd.lotes lo
	             ,alm.alm_lotes al
	        where reci_id  = p_reci_id
            and lo.lote_id = p_lote_id 
	        and al.arti_id = p_arti_id
			and lo.batch_id = al.batch_id
	        and lo.estado = 'En Curso';

	       	/** Venia de un lote planificado, que al unificarse con uno existente lo damos por finalizado */
	        if p_batch_id is not null and p_batch_id != '' then 
	        	update prd.lotes 
	        	set estado ='FINALIZADO'
	        	where batch_id = p_batch_id;
	        end if;

    exception
		   when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 20 - error buscando lote para unificar reci,lote,arti:%:%:% error %:% ',p_reci_id,p_lote_id,p_arti_id,sqlstate,sqlerrm;
			v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO-MF:%',sqlerrm;
		   end;
				  
    end if;

   
    /********************************************************************************
     * BLOQUE 3: PADRES
     * ASOCIACION CON LOTES PADRE Y ACTUALIZACION ESTADOS Y DE CANTIDADES
     * 
     */
	RAISE INFO 'PRDCRLO - BL3 -  padres -  estado % batch id padre %',v_estado,p_batch_id_padre;
   
    if v_estado != 'PLANIFICADO' then

    	/** Actualizo el arbol de batchs colocando el 
	     *  nuevo batch como hijo del p_batch_id_padre
	     * si el padre viene en 0 es un batch al inicio 
	     * del proceso productivo 
	     */
		insert into prd.lotes_hijos (
		batch_id
		,batch_id_padre
		,empr_id
		,cantidad
		,cantidad_padre)
		values
		(v_batch_id
		,case when p_batch_id_padre = 0 then null else p_batch_id_padre end
		,p_empr_id
		,p_cantidad
		,p_cantidad_padre);
		
		RAISE INFO 'PRDCRLO - Batch id % generado en recipiente %',v_batch_id,p_reci_id;
	
	    /**Cambiamos el estado del lote origen a FINALIZADO si ya no quedan existencias
		 * y vacio el recipiente
		 */
		if (p_batch_id_padre !=0 and p_cantidad_padre != 0) then
		
			--Obtengo la existencia actual del padre para entender si finalizar
			v_cantidad_padre = alm.obtener_existencia_batch(p_batch_id_padre);
			
			RAISE INFO 'PRDCRLO - cantidad padre existente:informada %.%',v_cantidad_padre,p_cantidad_padre;
	
			if v_cantidad_padre - p_cantidad_padre = 0 then
		
				RAISE INFO 'PRDCRLO - Finalizando lote % ',p_batch_id_padre;
	
				update prd.lotes
				set estado = 'FINALIZADO'
				where batch_id = p_batch_id_padre
				returning reci_id into v_reci_id_padre;
				
				select count(1)
				into strict v_countLotesRec
				from prd.lotes
				where reci_id = v_reci_id_padre
				and estado = 'En Curso';
				
				/** Si no hay mas lotes activos en el recipiente lo pongo como VACIO **/
				if (v_countLotesRec = 0) then
					update prd.recipientes
					set estado = 'VACIO'
					where reci_id = v_reci_id_padre;
				end if;
			end if;
		
	
			/**
			 * Actualizo la existencia del padre
			 */
	
			RAISE INFO 'PRDCRLO - actualizo existencia %:% ',p_batch_id_padre,p_cantidad_padre;
	
			v_resultado = alm.extraer_lote_articulo(p_batch_id_padre,p_cantidad_padre);
		
		end if;
	    /**
	     * Genera el lote asociado en almacenes
	     *
	     */
	
    end if;	

	/*************************************************************************************
	 * BLOQUE 4: ACTUALIZACION DE LOTE DEL PRODUCTO EN PRODUCCION
	 * EN ALMACENES EN CASO DE INFORMARSE ARTI_ID 
	 * 
	 */
	RAISE INFO 'PRDCRLO - BL4 -  lote producto - p_arti_id % v_estado %',p_arti_id,v_estado;
   
	if p_arti_id != 0 and v_estado != 'PLANIFICADO' then --si se informa articulos del lote los inserto en alm_lotes, sino no

		/** mismas condiciones que al insertar batch para insertar lote almacen o actualizar**/
		if v_estado_recipiente = 'VACIO' or  v_artDif or  v_lotDif then
	    		
				v_resultado = alm.crear_lote_articulo(
										p_prov_id
										,p_arti_id 
										,v_depo_id
										,p_lote_id 
										,p_cantidad 
										,p_fec_vencimiento
										,p_empr_id 
										,v_batch_id );
		else
			    RAISE INFO 'PRDCRLO - es un batch existente, agrego cantidad % al batch %',p_cantidad,v_batch_id;
	    		v_resultado = alm.agregar_lote_articulo(v_batch_id ,p_cantidad);

		end if;						
		RAISE INFO 'PRDCRLO - resultado ops almacen %',v_resultado;

	end if;


	/*************************************************************************
	 * BLOQUE 5: ACTUALIZACION DE RECURSO DE TRABAJO EN CASO DE INFORMARSE
	 * 
	 */
    RAISE INFO 'PRDCRLO - BL5 RECURSO TRABAJO - recu_id %',p_recu_id;


	/** Si el actual lote tiene un recurso asociado lo asocio **/
    if p_recu_id is not null and p_recu_id != 0 then
    	
       begin

	       RAISE INFO 'PRDCRLO - p_recu_id = %', p_recu_id;

			/** Valido que el recursos  exista  **/
			select recu_id
			into strict v_recu_id
			from prd.recursos recu
			where recu.recu_id = p_recu_id;

			/** Eliminio todo si fue grabado como planificado**/
			delete from prd.recursos_lotes
			where batch_id = v_batch_id
			and tipo=p_tipo_recurso;

			/* Inserto el recurso **/
			insert into prd.recursos_lotes(batch_id
											,recu_id
											,empr_id
											,cantidad
											,tipo)
					values (v_batch_id
							,p_recu_id
							,p_empr_id
							,p_cantidad
							,p_tipo_recurso);
						
		exception	   
		
			when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 10 - recurso no encontrado %', p_recu_id;
				v_mensaje = 'RECU_NO_ENCONTRADO';
		        raise exception 'RECU_NO_ENCONTRADO:%',p_recu_id;
		       
		end;	

	end if;

	return v_batch_id;


exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
	    raise warning 'crear_lote: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;

END; 
$$;
 �  DROP FUNCTION prd.crear_lote_v2(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying, p_fec_vencimiento date, p_recu_id integer, p_tipo_recurso character varying, p_planificado character varying, p_batch_id bigint);
       prd          postgres    false    8            ^           1255    21651    crear_prd_recipiente()    FUNCTION       CREATE FUNCTION prd.crear_prd_recipiente() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
    DECLARE
     idRecip int4;
    BEGIN
      /** funcion on insert para insertar recipiente nuevo al crear un contenedor 
      *
      */
      
      INSERT INTO prd.recipientes 
      (tipo, estado, nombre, depo_id, care_id) 
      values('TRANSPORTE', 'VACIO', new.codigo, 5000, 'cate_recipienteCONTENEDOR')
      returning reci_id into strict idRecip;
      
      new.reci_id = idRecip;
      
      return new;
    END;
  $$;
 *   DROP FUNCTION prd.crear_prd_recipiente();
       prd          postgres    false    8            [           1255    21652    crear_prd_recurso_trg()    FUNCTION     w  CREATE FUNCTION prd.crear_prd_recurso_trg() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
  DECLARE
  BEGIN
    /** funcion para utilizarse on insert para insertar el articulo como recurso
     * 
     */
    INSERT INTO prd.recursos
    (tipo
     ,arti_id
     ,empr_id
     )
    values
    ('MATERIAL'
     ,new.arti_id
     ,new.empr_id);

    return new;
    END;
$$;
 +   DROP FUNCTION prd.crear_prd_recurso_trg();
       prd          postgres    false    8            \           1255    21653    eliminar_prd_recurso_trg()    FUNCTION     -  CREATE FUNCTION prd.eliminar_prd_recurso_trg() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
  DECLARE
  BEGIN
    /** funcion para utilizarse on insert para insertar el articulo como recurso
     * 
     */
    delete from prd.recursos
    where arti_id = old.arti_id;
   
	return new;
    END;
$$;
 .   DROP FUNCTION prd.eliminar_prd_recurso_trg();
       prd          postgres    false    8            �            1259    21654    ajustes    TABLE     +  CREATE TABLE alm.ajustes (
    ajus_id integer NOT NULL,
    tipo_ajuste character varying,
    justificacion character varying,
    usuario_app character varying,
    empr_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE alm.ajustes;
       alm            postgres    false    6            �            1259    21662    ajustes_ajus_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.ajustes_ajus_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE alm.ajustes_ajus_id_seq;
       alm          postgres    false    204    6            �           0    0    ajustes_ajus_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE alm.ajustes_ajus_id_seq OWNED BY alm.ajustes.ajus_id;
          alm          postgres    false    205            �            1259    21664    alm_articulos    TABLE     C  CREATE TABLE alm.alm_articulos (
    arti_id integer NOT NULL,
    barcode character varying(50) NOT NULL,
    descripcion character varying(1000),
    costo numeric(14,2),
    es_caja boolean NOT NULL,
    cantidad_caja integer,
    punto_pedido integer,
    estado character varying(45) DEFAULT 'AC'::character varying,
    unidad_medida character varying(45) NOT NULL,
    empr_id integer NOT NULL,
    es_loteado boolean NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false NOT NULL,
    tipo character varying
);
    DROP TABLE alm.alm_articulos;
       alm            postgres    false    6            �           0    0    TABLE alm_articulos    COMMENT     .   COMMENT ON TABLE alm.alm_articulos IS '				';
          alm          postgres    false    206            �            1259    21673    alm_articulos_arti_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_articulos_arti_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE alm.alm_articulos_arti_id_seq;
       alm          postgres    false    6    206            �           0    0    alm_articulos_arti_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE alm.alm_articulos_arti_id_seq OWNED BY alm.alm_articulos.arti_id;
          alm          postgres    false    207            �            1259    21675    alm_depositos    TABLE     �  CREATE TABLE alm.alm_depositos (
    depo_id integer NOT NULL,
    descripcion character varying(255) DEFAULT NULL::character varying,
    direccion character varying(255) DEFAULT NULL::character varying,
    gps character varying(255) DEFAULT NULL::character varying,
    estado character varying(10),
    loca_id character varying(255) DEFAULT NULL::character varying,
    pais_id character varying(255) DEFAULT NULL::character varying,
    empr_id integer NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false NOT NULL,
    esta_id integer NOT NULL,
    reci_id integer,
    "row" integer,
    col integer
);
    DROP TABLE alm.alm_depositos;
       alm            postgres    false    6            �            1259    21688    alm_depositos_depo_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_depositos_depo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE alm.alm_depositos_depo_id_seq;
       alm          postgres    false    6    208            �           0    0    alm_depositos_depo_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE alm.alm_depositos_depo_id_seq OWNED BY alm.alm_depositos.depo_id;
          alm          postgres    false    209            �            1259    21690    alm_deta_entrega_materiales    TABLE     �  CREATE TABLE alm.alm_deta_entrega_materiales (
    deen_id integer NOT NULL,
    enma_id integer NOT NULL,
    cantidad integer NOT NULL,
    arti_id integer NOT NULL,
    prov_id integer,
    lote_id integer NOT NULL,
    depo_id integer,
    empr_id integer NOT NULL,
    precio double precision,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
 ,   DROP TABLE alm.alm_deta_entrega_materiales;
       alm            postgres    false    6            �            1259    21695 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq;
       alm          postgres    false    210    6            �           0    0 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq OWNED BY alm.alm_deta_entrega_materiales.deen_id;
          alm          postgres    false    211            �            1259    21697    alm_deta_pedidos_materiales    TABLE     O  CREATE TABLE alm.alm_deta_pedidos_materiales (
    depe_id integer NOT NULL,
    cantidad integer,
    resto integer,
    fecha_entrega date,
    fecha_entregado date,
    pema_id integer NOT NULL,
    arti_id integer NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
 ,   DROP TABLE alm.alm_deta_pedidos_materiales;
       alm            postgres    false    6            �            1259    21702 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq;
       alm          postgres    false    6    212            �           0    0 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq OWNED BY alm.alm_deta_pedidos_materiales.depe_id;
          alm          postgres    false    213            �            1259    21704    alm_deta_recepcion_materiales    TABLE     �  CREATE TABLE alm.alm_deta_recepcion_materiales (
    dere_id integer NOT NULL,
    cantidad double precision NOT NULL,
    precio double precision,
    empr_id integer NOT NULL,
    rema_id integer NOT NULL,
    lote_id integer NOT NULL,
    prov_id integer NOT NULL,
    arti_id integer NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
 .   DROP TABLE alm.alm_deta_recepcion_materiales;
       alm            postgres    false    6            �            1259    21709 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 =   DROP SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq;
       alm          postgres    false    214    6            �           0    0 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE OWNED BY     q   ALTER SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq OWNED BY alm.alm_deta_recepcion_materiales.dere_id;
          alm          postgres    false    215            �            1259    21711    alm_entrega_materiales    TABLE     �  CREATE TABLE alm.alm_entrega_materiales (
    enma_id integer NOT NULL,
    fecha date,
    solicitante character varying(100) DEFAULT NULL::character varying,
    dni character varying(45) DEFAULT NULL::character varying,
    comprobante character varying(50) DEFAULT NULL::character varying,
    empr_id integer NOT NULL,
    pema_id integer,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
 '   DROP TABLE alm.alm_entrega_materiales;
       alm            postgres    false    6            �            1259    21719 "   alm_entrega_materiales_enma_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_entrega_materiales_enma_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE alm.alm_entrega_materiales_enma_id_seq;
       alm          postgres    false    216    6            �           0    0 "   alm_entrega_materiales_enma_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE alm.alm_entrega_materiales_enma_id_seq OWNED BY alm.alm_entrega_materiales.enma_id;
          alm          postgres    false    217            �            1259    21721 	   alm_lotes    TABLE       CREATE TABLE alm.alm_lotes (
    lote_id integer NOT NULL,
    prov_id integer NOT NULL,
    arti_id integer NOT NULL,
    depo_id integer NOT NULL,
    codigo character varying(255) DEFAULT NULL::character varying,
    fec_vencimiento date,
    cantidad double precision,
    empr_id integer NOT NULL,
    user_id integer,
    estado character varying DEFAULT 'AC'::character varying,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false,
    batch_id bigint
);
    DROP TABLE alm.alm_lotes;
       alm            postgres    false    6            �            1259    21731    alm_lotes_lote_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_lotes_lote_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE alm.alm_lotes_lote_id_seq;
       alm          postgres    false    6    218            �           0    0    alm_lotes_lote_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE alm.alm_lotes_lote_id_seq OWNED BY alm.alm_lotes.lote_id;
          alm          postgres    false    219            �            1259    21733    alm_pedidos_materiales    TABLE     �  CREATE TABLE alm.alm_pedidos_materiales (
    pema_id integer NOT NULL,
    fecha date NOT NULL,
    motivo_rechazo character varying(500) DEFAULT NULL::character varying,
    justificacion character varying(300) DEFAULT NULL::character varying,
    case_id integer,
    ortr_id integer,
    estado character varying(45) DEFAULT NULL::character varying,
    empr_id integer,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false,
    batch_id integer
);
 '   DROP TABLE alm.alm_pedidos_materiales;
       alm            postgres    false    6            �            1259    21744 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_pedidos_materiales_pema_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE alm.alm_pedidos_materiales_pema_id_seq;
       alm          postgres    false    220    6            �           0    0 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE alm.alm_pedidos_materiales_pema_id_seq OWNED BY alm.alm_pedidos_materiales.pema_id;
          alm          postgres    false    221            �            1259    21746    alm_proveedores    TABLE       CREATE TABLE alm.alm_proveedores (
    prov_id integer NOT NULL,
    nombre character varying(255) DEFAULT NULL::character varying,
    cuit character varying(50) DEFAULT NULL::character varying,
    domicilio character varying(255) DEFAULT NULL::character varying,
    telefono character varying(50) DEFAULT NULL::character varying,
    email character varying(100) DEFAULT NULL::character varying,
    empr_id integer NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
     DROP TABLE alm.alm_proveedores;
       alm            postgres    false    6            �            1259    21759    alm_proveedores_articulos    TABLE     k   CREATE TABLE alm.alm_proveedores_articulos (
    prov_id integer NOT NULL,
    arti_id integer NOT NULL
);
 *   DROP TABLE alm.alm_proveedores_articulos;
       alm            postgres    false    6            �            1259    21762    alm_proveedores_prov_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_proveedores_prov_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE alm.alm_proveedores_prov_id_seq;
       alm          postgres    false    6    222            �           0    0    alm_proveedores_prov_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE alm.alm_proveedores_prov_id_seq OWNED BY alm.alm_proveedores.prov_id;
          alm          postgres    false    224            �            1259    21764    alm_recepcion_materiales    TABLE     h  CREATE TABLE alm.alm_recepcion_materiales (
    rema_id integer NOT NULL,
    fecha timestamp without time zone NOT NULL,
    comprobante character varying(255) NOT NULL,
    empr_id integer NOT NULL,
    prov_id integer NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false,
    batch_id integer
);
 )   DROP TABLE alm.alm_recepcion_materiales;
       alm            postgres    false    6            �            1259    21769 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_recepcion_materiales_rema_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 8   DROP SEQUENCE alm.alm_recepcion_materiales_rema_id_seq;
       alm          postgres    false    225    6            �           0    0 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE OWNED BY     g   ALTER SEQUENCE alm.alm_recepcion_materiales_rema_id_seq OWNED BY alm.alm_recepcion_materiales.rema_id;
          alm          postgres    false    226            �            1259    21771    deta_ajustes    TABLE       CREATE TABLE alm.deta_ajustes (
    deaj_id integer NOT NULL,
    cantidad double precision,
    empr_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER,
    lote_id integer,
    ajus_id integer NOT NULL
);
    DROP TABLE alm.deta_ajustes;
       alm            postgres    false    6            �            1259    21779    deta_ajustes_deaj_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.deta_ajustes_deaj_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE alm.deta_ajustes_deaj_id_seq;
       alm          postgres    false    227    6            �           0    0    deta_ajustes_deaj_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE alm.deta_ajustes_deaj_id_seq OWNED BY alm.deta_ajustes.deaj_id;
          alm          postgres    false    228            �            1259    21781    items    TABLE     G  CREATE TABLE alm.items (
    item_id integer NOT NULL,
    label character varying(45),
    name character varying(45),
    requerido smallint NOT NULL,
    tipo_dato character varying(45),
    valo_id character varying(45),
    orden integer,
    aux character varying(45),
    mostrar character varying(10),
    cond_mostrar character varying(50),
    deshabilitado character varying(10),
    cond_habilitado character varying(50),
    fec_alta timestamp without time zone DEFAULT now(),
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    form_id integer NOT NULL
);
    DROP TABLE alm.items;
       alm            postgres    false    6            �            1259    21789    items_item_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.items_item_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE alm.items_item_id_seq;
       alm          postgres    false    229    6            �           0    0    items_item_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE alm.items_item_id_seq OWNED BY alm.items.item_id;
          alm          postgres    false    230            �            1259    21791 
   utl_tablas    TABLE       CREATE TABLE alm.utl_tablas (
    tabl_id integer NOT NULL,
    tabla character varying(50),
    valor character varying(50),
    descripcion character varying(200),
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
    DROP TABLE alm.utl_tablas;
       alm            postgres    false    6            �            1259    21796    utl_tablas_tabl_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.utl_tablas_tabl_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE alm.utl_tablas_tabl_id_seq;
       alm          postgres    false    231    6            �           0    0    utl_tablas_tabl_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE alm.utl_tablas_tabl_id_seq OWNED BY alm.utl_tablas.tabl_id;
          alm          postgres    false    232            �            1259    21798    departamentos    TABLE     �   CREATE TABLE core.departamentos (
    depa_id integer NOT NULL,
    nombre character varying NOT NULL,
    descripcion character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE core.departamentos;
       core            postgres    false    10            �            1259    21806    departamentos_depa_id_seq    SEQUENCE     �   CREATE SEQUENCE core.departamentos_depa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE core.departamentos_depa_id_seq;
       core          postgres    false    10    233            �           0    0    departamentos_depa_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE core.departamentos_depa_id_seq OWNED BY core.departamentos.depa_id;
          core          postgres    false    234            �            1259    21808    empresas    TABLE     �  CREATE TABLE core.empresas (
    empr_id integer NOT NULL,
    descripcion character varying,
    cuit character varying,
    direccion character varying,
    telefono character varying,
    email character varying,
    imagepath character varying,
    loca_id integer,
    prov_id integer,
    pais_id integer,
    lat character varying,
    lng character varying,
    celular character varying,
    zona_id integer,
    clie_id integer
);
    DROP TABLE core.empresas;
       core            postgres    false    10            �            1259    21814    empresas_empr_id_seq    SEQUENCE     �   CREATE SEQUENCE core.empresas_empr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE core.empresas_empr_id_seq;
       core          postgres    false    10    235            �           0    0    empresas_empr_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE core.empresas_empr_id_seq OWNED BY core.empresas.empr_id;
          core          postgres    false    236            �            1259    21816    equipos    TABLE     �  CREATE TABLE core.equipos (
    equi_id integer NOT NULL,
    descripcion character varying(255) NOT NULL,
    marca character varying(255) NOT NULL,
    codigo character varying(255) NOT NULL,
    ubicacion character varying(100) NOT NULL,
    estado character varying(2) DEFAULT 'AC'::character varying NOT NULL,
    fecha_ultimalectura timestamp without time zone DEFAULT now() NOT NULL,
    ultima_lectura double precision DEFAULT 0 NOT NULL,
    tipo_horas character varying(10),
    valor_reposicion double precision,
    fecha_reposicion date,
    valor double precision,
    comprobante character varying(255),
    descrip_tecnica text,
    numero_serie double precision,
    adjunto character varying(255) DEFAULT NULL::character varying,
    meta_disponibilidad integer,
    fecha_ingreso date,
    fecha_baja date,
    fecha_garantia date,
    prov_id double precision,
    empr_id integer,
    sect_id integer,
    ubic_id double precision,
    grup_id integer,
    crit_id integer,
    unme_id integer,
    area_id integer,
    proc_id integer,
    tran_id integer,
    dominio character varying,
    imagen bytea,
    tara double precision,
    cont_id integer
);
    DROP TABLE core.equipos;
       core            postgres    false    10            �            1259    21826    equipos_equi_id_seq    SEQUENCE     �   CREATE SEQUENCE core.equipos_equi_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE core.equipos_equi_id_seq;
       core          postgres    false    237    10            �           0    0    equipos_equi_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE core.equipos_equi_id_seq OWNED BY core.equipos.equi_id;
          core          postgres    false    238            �            1259    21828    log    TABLE     S   CREATE TABLE core.log (
    msg character varying,
    fecha date DEFAULT now()
);
    DROP TABLE core.log;
       core            postgres    false    10            �            1259    21835 	   snapshots    TABLE     �   CREATE TABLE core.snapshots (
    id integer NOT NULL,
    snap_id character varying NOT NULL,
    data text,
    fec_alta date DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
    DROP TABLE core.snapshots;
       core            postgres    false    10            �            1259    21843    snapshots_id_seq    SEQUENCE     �   CREATE SEQUENCE core.snapshots_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE core.snapshots_id_seq;
       core          postgres    false    240    10            �           0    0    snapshots_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE core.snapshots_id_seq OWNED BY core.snapshots.id;
          core          postgres    false    241            �            1259    21845    tablas    TABLE     �  CREATE TABLE core.tablas (
    tabl_id character varying NOT NULL,
    tabla character varying,
    valor character varying,
    valor2 character varying,
    valor3 character varying,
    descripcion character varying,
    fec_alta timestamp without time zone DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    eliminado boolean DEFAULT false NOT NULL
);
    DROP TABLE core.tablas;
       core            postgres    false    10            =           1259    24500    tito    TABLE     S   CREATE TABLE core.tito (
    id integer NOT NULL,
    column1 character varying
);
    DROP TABLE core.tito;
       core            postgres    false    10            >           1259    24506    tito_id_seq    SEQUENCE     �   CREATE SEQUENCE core.tito_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
     DROP SEQUENCE core.tito_id_seq;
       core          postgres    false    10    317            �           0    0    tito_id_seq    SEQUENCE OWNED BY     7   ALTER SEQUENCE core.tito_id_seq OWNED BY core.tito.id;
          core          postgres    false    318            ?           1259    24508    transportistas    TABLE       CREATE TABLE core.transportistas (
    cuit character varying NOT NULL,
    razon_social character varying NOT NULL,
    direccion character varying(500) NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
     DROP TABLE core.transportistas;
       core            postgres    false    10            �            1259    21870    zonas    TABLE     r  CREATE TABLE core.zonas (
    zona_id integer NOT NULL,
    nombre character varying NOT NULL,
    descripcion character varying,
    imagen bytea,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    depa_id integer NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL
);
    DROP TABLE core.zonas;
       core            postgres    false    10            �            1259    21879    zonas_zona_id_seq    SEQUENCE     �   CREATE SEQUENCE core.zonas_zona_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE core.zonas_zona_id_seq;
       core          postgres    false    243    10            �           0    0    zonas_zona_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE core.zonas_zona_id_seq OWNED BY core.zonas.zona_id;
          core          postgres    false    244            �            1259    21881    actas_infraccion    TABLE     �  CREATE TABLE fis.actas_infraccion (
    acin_id integer NOT NULL,
    numero_acta integer,
    descripcion character varying(500) NOT NULL,
    tipo character varying NOT NULL,
    sotr_id integer NOT NULL,
    inspector_id integer NOT NULL,
    tran_id integer NOT NULL,
    destino character varying,
    fecha_creacion date DEFAULT now() NOT NULL,
    usuario_app character varying NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
 !   DROP TABLE fis.actas_infraccion;
       fis            postgres    false    12            �            1259    21890    acta_infraccion_acin_id_seq    SEQUENCE     �   CREATE SEQUENCE fis.acta_infraccion_acin_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE fis.acta_infraccion_acin_id_seq;
       fis          postgres    false    245    12            �           0    0    acta_infraccion_acin_id_seq    SEQUENCE OWNED BY     V   ALTER SEQUENCE fis.acta_infraccion_acin_id_seq OWNED BY fis.actas_infraccion.acin_id;
          fis          postgres    false    246            �            1259    21892    formularios    TABLE        CREATE TABLE frm.formularios (
    form_id integer NOT NULL,
    nombre character varying(45),
    descripcion character varying(300),
    eliminado smallint DEFAULT 0,
    fec_alta timestamp without time zone DEFAULT now(),
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE frm.formularios;
       frm            postgres    false    14            �            1259    21901    formularios_form_id_seq    SEQUENCE     �   CREATE SEQUENCE frm.formularios_form_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE frm.formularios_form_id_seq;
       frm          postgres    false    14    247            �           0    0    formularios_form_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE frm.formularios_form_id_seq OWNED BY frm.formularios.form_id;
          frm          postgres    false    248            �            1259    21903    instancias_items    TABLE     �  CREATE TABLE frm.instancias_items (
    init_id integer NOT NULL,
    label character varying(45),
    name character varying(45),
    valor character varying(500),
    requerido smallint,
    tida_id integer,
    valo_id character varying(45),
    info_id integer DEFAULT 0,
    form_id integer,
    orden integer,
    aux character varying(45),
    eliminado smallint DEFAULT 0,
    mostrar character varying(10),
    cond_mostrar character varying(50),
    deshabilitado character varying(10),
    cond_habilitado character varying(50),
    fec_alta timestamp without time zone DEFAULT now(),
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    item_id integer NOT NULL
);
 !   DROP TABLE frm.instancias_items;
       frm            postgres    false    14            �            1259    21913    instancias_items_init_id_seq    SEQUENCE     �   CREATE SEQUENCE frm.instancias_items_init_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE frm.instancias_items_init_id_seq;
       frm          postgres    false    249    14            �           0    0    instancias_items_init_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE frm.instancias_items_init_id_seq OWNED BY frm.instancias_items.init_id;
          frm          postgres    false    250            �            1259    21915    items    TABLE     G  CREATE TABLE frm.items (
    item_id integer NOT NULL,
    label character varying(45),
    name character varying(45),
    requerido smallint NOT NULL,
    tipo_dato character varying(45),
    valo_id character varying(45),
    orden integer,
    aux character varying(45),
    mostrar character varying(10),
    cond_mostrar character varying(50),
    deshabilitado character varying(10),
    cond_habilitado character varying(50),
    fec_alta timestamp without time zone DEFAULT now(),
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    form_id integer NOT NULL
);
    DROP TABLE frm.items;
       frm            postgres    false    14            �            1259    21923    items_item_id_seq    SEQUENCE     �   CREATE SEQUENCE frm.items_item_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE frm.items_item_id_seq;
       frm          postgres    false    251    14            �           0    0    items_item_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE frm.items_item_id_seq OWNED BY frm.items.item_id;
          frm          postgres    false    252            �            1259    21925    incidencias    TABLE     �  CREATE TABLE ins.incidencias (
    inci_id integer NOT NULL,
    descripcion character varying NOT NULL,
    fecha date NOT NULL,
    num_acta character varying,
    adjunto bytea,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    tiin_id character varying NOT NULL,
    tica_id character varying,
    difi_id character varying,
    ortr_id integer,
    eliminado smallint DEFAULT 0 NOT NULL,
    estado character varying DEFAULT 'EN_CURSO'::character varying NOT NULL,
    CONSTRAINT incidencias_check CHECK ((((estado)::text = 'EN_CURSO'::text) OR ((estado)::text = 'SOLUCIONADO'::text) OR ((estado)::text = 'CANCELADO'::text)))
);
    DROP TABLE ins.incidencias;
       ins            postgres    false    7            �            1259    21933    incidencias_inci_id_seq    SEQUENCE     �   CREATE SEQUENCE ins.incidencias_inci_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE ins.incidencias_inci_id_seq;
       ins          postgres    false    7    253            �           0    0    incidencias_inci_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE ins.incidencias_inci_id_seq OWNED BY ins.incidencias.inci_id;
          ins          postgres    false    254            �            1259    21935    choferes    TABLE     �  CREATE TABLE log.choferes (
    chof_id integer NOT NULL,
    nombre character varying NOT NULL,
    apellido character varying NOT NULL,
    documento character varying NOT NULL,
    fec_nacimiento date NOT NULL,
    direccion character varying NOT NULL,
    celular character varying,
    codigo character varying NOT NULL,
    carnet character varying NOT NULL,
    vencimiento date NOT NULL,
    habilitacion character varying,
    imagen bytea,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    tran_id integer NOT NULL,
    cach_id character varying NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    usuario_app character varying
);
    DROP TABLE log.choferes;
       log            postgres    false    15                        1259    21944    choferes_chof_id_seq    SEQUENCE     �   CREATE SEQUENCE log.choferes_chof_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE log.choferes_chof_id_seq;
       log          postgres    false    255    15            �           0    0    choferes_chof_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE log.choferes_chof_id_seq OWNED BY log.choferes.chof_id;
          log          postgres    false    256            @           1259    24516    cierre_sector_descarga    TABLE       CREATE TABLE log.cierre_sector_descarga (
    estado character varying NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    cisd_id character varying NOT NULL
);
 '   DROP TABLE log.cierre_sector_descarga;
       log            postgres    false    15                       1259    21946 	   circuitos    TABLE     �  CREATE TABLE log.circuitos (
    circ_id integer NOT NULL,
    codigo character varying,
    descripcion character varying,
    imagen bytea,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    chof_id integer,
    vehi_id integer,
    zona_id integer,
    eliminado smallint DEFAULT 0
);
    DROP TABLE log.circuitos;
       log            postgres    false    15                       1259    21955    circuitos_circu_id_seq    SEQUENCE     �   CREATE SEQUENCE log.circuitos_circu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE log.circuitos_circu_id_seq;
       log          postgres    false    257    15            �           0    0    circuitos_circu_id_seq    SEQUENCE OWNED BY     J   ALTER SEQUENCE log.circuitos_circu_id_seq OWNED BY log.circuitos.circ_id;
          log          postgres    false    258                       1259    21957    circuitos_puntos_criticos    TABLE     �   CREATE TABLE log.circuitos_puntos_criticos (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    circ_id integer NOT NULL,
    pucr_id integer NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL
);
 *   DROP TABLE log.circuitos_puntos_criticos;
       log            postgres    false    15                       1259    21966    contenedores    TABLE     ;  CREATE TABLE log.contenedores (
    cont_id integer NOT NULL,
    codigo bigint NOT NULL,
    descripcion character varying NOT NULL,
    capacidad double precision NOT NULL,
    tara double precision,
    habilitacion character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    esco_id character varying NOT NULL,
    reci_id integer,
    anio_elaboracion date DEFAULT now(),
    tran_id integer,
    eliminado smallint DEFAULT 0 NOT NULL,
    imagen bytea
);
    DROP TABLE log.contenedores;
       log            postgres    false    15                       1259    21976    containers_cont_id_seq    SEQUENCE     �   CREATE SEQUENCE log.containers_cont_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE log.containers_cont_id_seq;
       log          postgres    false    260    15            �           0    0    containers_cont_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE log.containers_cont_id_seq OWNED BY log.contenedores.cont_id;
          log          postgres    false    261                       1259    21978    contenedores_entregados    TABLE     �  CREATE TABLE log.contenedores_entregados (
    coen_id integer NOT NULL,
    porc_llenado real,
    mts_cubicos real,
    fec_entrega date,
    fec_retiro date,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    cont_id integer NOT NULL,
    soco_id integer NOT NULL,
    sore_id integer,
    ortr_id integer,
    tica_id character varying,
    depo_id integer,
    peso_neto real,
    difi_id character varying,
    equi_id integer,
    equi_id_entrega integer,
    batch_id integer,
    foto bytea,
    tiva_id character varying,
    observaciones_descarga character varying,
    fec_descarga date,
    fec_salida date
);
 (   DROP TABLE log.contenedores_entregados;
       log            postgres    false    15                       1259    21986 #   contenedores_entregados_coen_id_seq    SEQUENCE     �   CREATE SEQUENCE log.contenedores_entregados_coen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE log.contenedores_entregados_coen_id_seq;
       log          postgres    false    15    262            �           0    0 #   contenedores_entregados_coen_id_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE log.contenedores_entregados_coen_id_seq OWNED BY log.contenedores_entregados.coen_id;
          log          postgres    false    263                       1259    21988 $   contenedores_solicitados_coso_id_seq    SEQUENCE     �   CREATE SEQUENCE log.contenedores_solicitados_coso_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;
 8   DROP SEQUENCE log.contenedores_solicitados_coso_id_seq;
       log          postgres    false    15            	           1259    21990    contenedores_solicitados    TABLE        CREATE TABLE log.contenedores_solicitados (
    coso_id integer DEFAULT nextval('log.contenedores_solicitados_coso_id_seq'::regclass) NOT NULL,
    cantidad integer NOT NULL,
    otro character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    tica_id character varying NOT NULL,
    soco_id integer NOT NULL,
    reci_id integer,
    cantidad_acordada integer,
    motivo_rechazo character varying
);
 )   DROP TABLE log.contenedores_solicitados;
       log            postgres    false    264    15            
           1259    21999    ordenes_transporte    TABLE       CREATE TABLE log.ordenes_transporte (
    ortr_id integer NOT NULL,
    fec_retiro date NOT NULL,
    estado character varying NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    difi_id character varying NOT NULL,
    sotr_id integer NOT NULL,
    equi_id integer NOT NULL,
    chof_id character varying NOT NULL,
    case_id character varying,
    usuario_app character varying NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    tran_id integer,
    teot_id integer,
    CONSTRAINT ordenes_transporte_check CHECK ((((estado)::text = 'EN_TRANSITO'::text) OR ((estado)::text = 'INGRESADO'::text) OR ((estado)::text = 'DESCARGADO'::text) OR ((estado)::text = 'INFRACCION'::text) OR ((estado)::text = 'EGRESADO'::text)))
);
 #   DROP TABLE log.ordenes_transporte;
       log            postgres    false    15                       1259    22008    ordenes_transporte_ortr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.ordenes_transporte_ortr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE log.ordenes_transporte_ortr_id_seq;
       log          postgres    false    266    15            �           0    0    ordenes_transporte_ortr_id_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE log.ordenes_transporte_ortr_id_seq OWNED BY log.ordenes_transporte.ortr_id;
          log          postgres    false    267                       1259    22010    puntos_criticos    TABLE     �  CREATE TABLE log.puntos_criticos (
    pucr_id integer NOT NULL,
    nombre character varying NOT NULL,
    descripcion character varying,
    lat character varying,
    lng character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    zona_id integer,
    eliminado smallint DEFAULT 0 NOT NULL
);
     DROP TABLE log.puntos_criticos;
       log            postgres    false    15                       1259    22019    puntos_criticos_pucr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.puntos_criticos_pucr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE log.puntos_criticos_pucr_id_seq;
       log          postgres    false    268    15            �           0    0    puntos_criticos_pucr_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE log.puntos_criticos_pucr_id_seq OWNED BY log.puntos_criticos.pucr_id;
          log          postgres    false    269                       1259    22021    solicitantes_transporte    TABLE     �  CREATE TABLE log.solicitantes_transporte (
    sotr_id integer NOT NULL,
    razon_social character varying NOT NULL,
    cuit character varying NOT NULL,
    domicilio character varying NOT NULL,
    num_registro character varying,
    lat character varying,
    lng character varying,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario_app character varying NOT NULL,
    zona_id integer NOT NULL,
    rubr_id character varying NOT NULL,
    tist_id character varying NOT NULL,
    eliminado integer DEFAULT 0 NOT NULL,
    depa_id integer,
    prov_id integer,
    user_id character varying
);
 (   DROP TABLE log.solicitantes_transporte;
       log            postgres    false    15            �           0    0 &   COLUMN solicitantes_transporte.user_id    COMMENT     Y   COMMENT ON COLUMN log.solicitantes_transporte.user_id IS 'user_id es seg.email (DNATO)';
          log          postgres    false    270                       1259    22030 #   solicitantes_transporte_sotr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitantes_transporte_sotr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE log.solicitantes_transporte_sotr_id_seq;
       log          postgres    false    15    270            �           0    0 #   solicitantes_transporte_sotr_id_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE log.solicitantes_transporte_sotr_id_seq OWNED BY log.solicitantes_transporte.sotr_id;
          log          postgres    false    271                       1259    22032    solicitudes_contenedor    TABLE     �  CREATE TABLE log.solicitudes_contenedor (
    soco_id integer NOT NULL,
    estado character varying NOT NULL,
    observaciones character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    sotr_id integer NOT NULL,
    case_id character varying,
    eliminado smallint DEFAULT 0 NOT NULL,
    tran_id integer NOT NULL,
    CONSTRAINT solicitudes_contenedor_estado_check CHECK ((((estado)::text = 'SOLICITADA'::text) OR ((estado)::text = 'ENTREGA_ACORDADA'::text) OR ((estado)::text = 'RECHAZADA_TRANSPORTISTA'::text) OR ((estado)::text = 'RECHAZADA_SOLICITANTE'::text)))
);
 '   DROP TABLE log.solicitudes_contenedor;
       log            postgres    false    15                       1259    22042 $   solicitudes_contenedores_soco_id_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitudes_contenedores_soco_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 8   DROP SEQUENCE log.solicitudes_contenedores_soco_id_seq;
       log          postgres    false    15    272            �           0    0 $   solicitudes_contenedores_soco_id_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE log.solicitudes_contenedores_soco_id_seq OWNED BY log.solicitudes_contenedor.soco_id;
          log          postgres    false    273                       1259    22044    solicitudes_retiro_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitudes_retiro_seq
    START WITH 6
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;
 *   DROP SEQUENCE log.solicitudes_retiro_seq;
       log          postgres    false    15                       1259    22046    solicitudes_retiro    TABLE     �  CREATE TABLE log.solicitudes_retiro (
    sore_id integer DEFAULT nextval('log.solicitudes_retiro_seq'::regclass) NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    sotr_id integer NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    case_id character varying,
    estado character varying DEFAULT 'SOLICITADA'::character varying NOT NULL,
    CONSTRAINT solicitudes_retiro_check CHECK ((((estado)::text = 'SOLICITADA'::text) OR ((estado)::text = 'RETIRO_ASIGNADO_PARCIAL'::text) OR ((estado)::text = 'RETIRO_ASIGNADO_TOTAL'::text)))
);
 #   DROP TABLE log.solicitudes_retiro;
       log            postgres    false    274    15            <           1259    24447    templates_orden_transporte    TABLE       CREATE TABLE log.templates_orden_transporte (
    teot_id integer NOT NULL,
    observaciones character varying,
    eliminado smallint DEFAULT 0 NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    circ_id integer NOT NULL,
    equi_id integer NOT NULL,
    chof_id character varying NOT NULL,
    tica_id character varying NOT NULL,
    difi_id character varying NOT NULL,
    sotr_id integer NOT NULL
);
 +   DROP TABLE log.templates_orden_transporte;
       log            postgres    false    15            ;           1259    24445 &   templates_orden_transporte_teot_id_seq    SEQUENCE     �   CREATE SEQUENCE log.templates_orden_transporte_teot_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 :   DROP SEQUENCE log.templates_orden_transporte_teot_id_seq;
       log          postgres    false    316    15            �           0    0 &   templates_orden_transporte_teot_id_seq    SEQUENCE OWNED BY     k   ALTER SEQUENCE log.templates_orden_transporte_teot_id_seq OWNED BY log.templates_orden_transporte.teot_id;
          log          postgres    false    315                       1259    22056    tipos_carga_circuitos    TABLE     �   CREATE TABLE log.tipos_carga_circuitos (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    circ_id integer NOT NULL,
    tica_id character varying NOT NULL
);
 &   DROP TABLE log.tipos_carga_circuitos;
       log            postgres    false    15                       1259    22064    tipos_carga_contenedores    TABLE     �   CREATE TABLE log.tipos_carga_contenedores (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    cont_id integer NOT NULL,
    tica_id character varying NOT NULL,
    eliminado smallint DEFAULT 0
);
 )   DROP TABLE log.tipos_carga_contenedores;
       log            postgres    false    15            0           1259    23468    tipos_carga_generadores    TABLE     s   CREATE TABLE log.tipos_carga_generadores (
    tica_id character varying NOT NULL,
    sotr_id integer NOT NULL
);
 (   DROP TABLE log.tipos_carga_generadores;
       log            postgres    false    15                       1259    22073    tipos_carga_transportistas    TABLE     �   CREATE TABLE log.tipos_carga_transportistas (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    tran_id integer NOT NULL,
    tica_id character varying NOT NULL
);
 +   DROP TABLE log.tipos_carga_transportistas;
       log            postgres    false    15                       1259    22081    transportistas    TABLE     �  CREATE TABLE log.transportistas (
    tran_id integer NOT NULL,
    razon_social character varying NOT NULL,
    descripcion character varying NOT NULL,
    direccion character varying,
    telefono character varying,
    contacto character varying,
    resolucion character varying NOT NULL,
    registro character varying NOT NULL,
    fec_alta_efectiva date NOT NULL,
    fec_baja_efectiva date,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    cuit character varying(13) NOT NULL,
    user_id character varying
);
    DROP TABLE log.transportistas;
       log            postgres    false    15            �           0    0    COLUMN transportistas.user_id    COMMENT     b   COMMENT ON COLUMN log.transportistas.user_id IS 'id de usuario es el email de seg.users (DNATO)';
          log          postgres    false    279                       1259    22090    transportistas_tran_id_seq    SEQUENCE     �   CREATE SEQUENCE log.transportistas_tran_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE log.transportistas_tran_id_seq;
       log          postgres    false    279    15            �           0    0    transportistas_tran_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE log.transportistas_tran_id_seq OWNED BY log.transportistas.tran_id;
          log          postgres    false    280                       1259    22092    costos    TABLE       CREATE TABLE prd.costos (
    fec_vigencia date NOT NULL,
    valor money NOT NULL,
    umed character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    recu_id integer NOT NULL,
    empr_id integer
);
    DROP TABLE prd.costos;
       prd            postgres    false    8                       1259    22100    empaque    TABLE     N  CREATE TABLE prd.empaque (
    empa_id integer NOT NULL,
    nombre character varying NOT NULL,
    unidad_medida character varying NOT NULL,
    capacidad double precision NOT NULL,
    empr_id integer NOT NULL,
    usuario_app character varying NOT NULL,
    eliminado boolean NOT NULL,
    fech_alta date DEFAULT now() NOT NULL
);
    DROP TABLE prd.empaque;
       prd            postgres    false    8            �           0    0    COLUMN empaque.eliminado    COMMENT     4   COMMENT ON COLUMN prd.empaque.eliminado IS 'false';
          prd          postgres    false    282                       1259    22107    empaque_empa_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.empaque_empa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE prd.empaque_empa_id_seq;
       prd          postgres    false    282    8            �           0    0    empaque_empa_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE prd.empaque_empa_id_seq OWNED BY prd.empaque.empa_id;
          prd          postgres    false    283                       1259    22109    establecimientos    TABLE     r  CREATE TABLE prd.establecimientos (
    esta_id integer NOT NULL,
    nombre character varying NOT NULL,
    lng real,
    lat real,
    calle character varying,
    altura character varying,
    localidad character varying,
    estado character varying,
    pais character varying,
    fec_alta date DEFAULT now(),
    usuario character varying,
    empr_id integer
);
 !   DROP TABLE prd.establecimientos;
       prd            postgres    false    8                       1259    22116    establecimientos_esta_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.establecimientos_esta_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE prd.establecimientos_esta_id_seq;
       prd          postgres    false    8    284            �           0    0    establecimientos_esta_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE prd.establecimientos_esta_id_seq OWNED BY prd.establecimientos.esta_id;
          prd          postgres    false    285                       1259    22118    etapas    TABLE     �  CREATE TABLE prd.etapas (
    etap_id integer NOT NULL,
    nombre character varying NOT NULL,
    nom_recipiente character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    proc_id integer NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    empr_id integer,
    orden integer NOT NULL,
    link character varying(100)
);
    DROP TABLE prd.etapas;
       prd            postgres    false    8                       1259    22127    etapas_etap_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.etapas_etap_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE prd.etapas_etap_id_seq;
       prd          postgres    false    8    286            �           0    0    etapas_etap_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE prd.etapas_etap_id_seq OWNED BY prd.etapas.etap_id;
          prd          postgres    false    287                        1259    22129    etapas_materiales    TABLE     c   CREATE TABLE prd.etapas_materiales (
    etap_id integer NOT NULL,
    arti_id integer NOT NULL
);
 "   DROP TABLE prd.etapas_materiales;
       prd            postgres    false    8            !           1259    22132    etapas_productos    TABLE     b   CREATE TABLE prd.etapas_productos (
    etap_id integer NOT NULL,
    arti_id integer NOT NULL
);
 !   DROP TABLE prd.etapas_productos;
       prd            postgres    false    8            A           1259    24524    etapas_salidas    TABLE     `   CREATE TABLE prd.etapas_salidas (
    etap_id integer NOT NULL,
    arti_id integer NOT NULL
);
    DROP TABLE prd.etapas_salidas;
       prd            postgres    false    8            B           1259    24527    formulas    TABLE     �  CREATE TABLE prd.formulas (
    form_id integer NOT NULL,
    descripcion character varying NOT NULL,
    cantidad double precision NOT NULL,
    eliminado boolean DEFAULT false,
    aplicacion character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    unme_id character varying NOT NULL
);
    DROP TABLE prd.formulas;
       prd            postgres    false    8            C           1259    24536    formulas_articulos    TABLE       CREATE TABLE prd.formulas_articulos (
    cantidad double precision NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    unme_id character varying,
    form_id integer NOT NULL,
    arti_id integer NOT NULL
);
 #   DROP TABLE prd.formulas_articulos;
       prd            postgres    false    8            D           1259    24544    formulas_form_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.formulas_form_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE prd.formulas_form_id_seq;
       prd          postgres    false    8    322            �           0    0    formulas_form_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE prd.formulas_form_id_seq OWNED BY prd.formulas.form_id;
          prd          postgres    false    324            "           1259    22135    fraccionamientos    TABLE       CREATE TABLE prd.fraccionamientos (
    frac_id integer NOT NULL,
    recu_id integer NOT NULL,
    empa_id integer NOT NULL,
    cantidad double precision NOT NULL,
    fecha date DEFAULT now() NOT NULL,
    eliminado boolean DEFAULT false NOT NULL,
    empr_id integer NOT NULL
);
 !   DROP TABLE prd.fraccionamientos;
       prd            postgres    false    8            #           1259    22140    fraccionamientos_frac_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.fraccionamientos_frac_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE prd.fraccionamientos_frac_id_seq;
       prd          postgres    false    290    8            �           0    0    fraccionamientos_frac_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE prd.fraccionamientos_frac_id_seq OWNED BY prd.fraccionamientos.frac_id;
          prd          postgres    false    291            $           1259    22142    lotes    TABLE     �  CREATE TABLE prd.lotes (
    lote_id character varying,
    batch_id bigint NOT NULL,
    estado character varying NOT NULL,
    num_orden_prod character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    etap_id integer NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    nombre character varying,
    reci_id integer,
    empr_id integer,
    usuario_app character varying,
    arti_id integer
);
    DROP TABLE prd.lotes;
       prd            postgres    false    8            %           1259    22151    lotes_batch_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.lotes_batch_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE prd.lotes_batch_id_seq;
       prd          postgres    false    292    8            �           0    0    lotes_batch_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE prd.lotes_batch_id_seq OWNED BY prd.lotes.batch_id;
          prd          postgres    false    293            &           1259    22153    lotes_hijos    TABLE     Y  CREATE TABLE prd.lotes_hijos (
    batch_id integer NOT NULL,
    batch_id_padre integer,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    empr_id integer,
    cantidad double precision NOT NULL,
    cantidad_padre double precision NOT NULL
);
    DROP TABLE prd.lotes_hijos;
       prd            postgres    false    8            E           1259    24546    lotes_responsables    TABLE     �   CREATE TABLE prd.lotes_responsables (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    batch_id integer NOT NULL,
    user_id integer,
    turn_id character varying NOT NULL
);
 #   DROP TABLE prd.lotes_responsables;
       prd            postgres    false    8            '           1259    22162    movimientos_trasportes    TABLE     �  CREATE TABLE prd.movimientos_trasportes (
    motr_id bigint NOT NULL,
    boleta character varying,
    fecha_entrada date,
    patente character varying,
    acoplado character varying,
    conductor character varying,
    tipo character varying,
    bruto double precision,
    tara double precision,
    neto double precision,
    prov_id integer,
    esta_id integer,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false,
    estado character varying DEFAULT 'INICIADO'::character varying,
    reci_id integer,
    transportista character varying,
    cuit character varying,
    accion character varying
);
 '   DROP TABLE prd.movimientos_trasportes;
       prd            postgres    false    8            (           1259    22171 "   movimientos_trasportes_motr_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.movimientos_trasportes_motr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE prd.movimientos_trasportes_motr_id_seq;
       prd          postgres    false    8    295            �           0    0 "   movimientos_trasportes_motr_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE prd.movimientos_trasportes_motr_id_seq OWNED BY prd.movimientos_trasportes.motr_id;
          prd          postgres    false    296            )           1259    22173    procesos    TABLE     �   CREATE TABLE prd.procesos (
    proc_id integer NOT NULL,
    nombre character varying NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    empr_id integer
);
    DROP TABLE prd.procesos;
       prd            postgres    false    8            *           1259    22181    productos_prod_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.productos_prod_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE prd.productos_prod_id_seq;
       prd          postgres    false    297    8            �           0    0    productos_prod_id_seq    SEQUENCE OWNED BY     H   ALTER SEQUENCE prd.productos_prod_id_seq OWNED BY prd.procesos.proc_id;
          prd          postgres    false    298            +           1259    22183    recipientes    TABLE     I  CREATE TABLE prd.recipientes (
    reci_id integer NOT NULL,
    tipo character varying DEFAULT 0 NOT NULL,
    estado character varying DEFAULT 'VACIO'::character varying NOT NULL,
    nombre character varying NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    empr_id integer,
    depo_id integer NOT NULL,
    motr_id integer,
    "row" integer,
    col integer,
    care_id character varying DEFAULT 'cate_recipienteBOX'::character varying NOT NULL,
    CONSTRAINT recipientes_check CHECK ((((tipo)::text = 'PRODUCTIVO'::text) OR ((tipo)::text = 'DEPOSITO'::text) OR ((tipo)::text = 'TRANSPORTE'::text))),
    CONSTRAINT recipientes_check_estado CHECK ((((estado)::text = 'VACIO'::text) OR ((estado)::text = 'LLENO'::text)))
);
    DROP TABLE prd.recipientes;
       prd            postgres    false    8            ,           1259    22196    recipiente_reci_id_seq    SEQUENCE     |   CREATE SEQUENCE prd.recipiente_reci_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE prd.recipiente_reci_id_seq;
       prd          postgres    false    299    8            �           0    0    recipiente_reci_id_seq    SEQUENCE OWNED BY     L   ALTER SEQUENCE prd.recipiente_reci_id_seq OWNED BY prd.recipientes.reci_id;
          prd          postgres    false    300            -           1259    22198    recursos    TABLE     E  CREATE TABLE prd.recursos (
    recu_id integer NOT NULL,
    tipo character varying NOT NULL,
    cant_capacidad double precision,
    umed_capacidad character varying,
    cant_tiempo_capacidad character varying,
    umed_iempo_capacidad character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    arti_id integer,
    empr_id integer NOT NULL,
    equi_id integer,
    CONSTRAINT recursos_check CHECK (((tipo)::text = ANY (ARRAY[('MATERIAL'::character varying)::text, ('TRABAJO'::character varying)::text])))
);
    DROP TABLE prd.recursos;
       prd            postgres    false    8            .           1259    22207    recursos_lotes    TABLE     H  CREATE TABLE prd.recursos_lotes (
    batch_id integer NOT NULL,
    recu_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    empr_id integer,
    cantidad double precision NOT NULL,
    tipo character varying NOT NULL,
    empa_id integer,
    empa_cantidad double precision,
    CONSTRAINT recursos_lotes_check CHECK ((((tipo)::text = 'MATERIA_PRIMA'::text) OR ((tipo)::text = 'PRODUCTO'::text) OR ((tipo)::text = 'EQUIPO'::text) OR ((tipo)::text = 'HUMANO'::text) OR ((tipo)::text = 'CONSUMO'::text)))
);
    DROP TABLE prd.recursos_lotes;
       prd            postgres    false    8            /           1259    22216    recursos_recu_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.recursos_recu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE prd.recursos_recu_id_seq;
       prd          postgres    false    301    8            �           0    0    recursos_recu_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE prd.recursos_recu_id_seq OWNED BY prd.recursos.recu_id;
          prd          postgres    false    303            :           1259    24426    memberships_menues    TABLE     D  CREATE TABLE seg.memberships_menues (
    modulo character varying NOT NULL,
    opcion character varying NOT NULL,
    "group" character varying,
    role character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL
);
 #   DROP TABLE seg.memberships_menues;
       seg            postgres    false    11            8           1259    24393    memberships_users    TABLE     :  CREATE TABLE seg.memberships_users (
    "group" character varying NOT NULL,
    role character varying NOT NULL,
    fec_alta character varying DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    email character varying NOT NULL
);
 "   DROP TABLE seg.memberships_users;
       seg            postgres    false    11            9           1259    24408    menues    TABLE     �  CREATE TABLE seg.menues (
    modulo character varying(4) NOT NULL,
    opcion character varying NOT NULL,
    texto character varying NOT NULL,
    url character varying,
    javascript character varying,
    orden integer DEFAULT 0,
    url_icono character varying,
    texto_onmouseover character varying,
    eliminado smallint DEFAULT 0,
    fec_alta character varying DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    opcion_padre character varying,
    CONSTRAINT menues_check CHECK ((((modulo)::text = 'PRD'::text) OR ((modulo)::text = 'CORE'::text) OR ((modulo)::text = 'ALM'::text) OR ((modulo)::text = 'MAN'::text) OR ((modulo)::text = 'TAR'::text) OR ((modulo)::text = 'PAN'::text) OR ((modulo)::text = 'LOG'::text) OR ((modulo)::text = 'SEG'::text) OR ((modulo)::text = 'TRZ'::text) OR ((modulo)::text = 'PRO'::text) OR ((modulo)::text = 'FIS'::text)))
);
    DROP TABLE seg.menues;
       seg            postgres    false    11            1           1259    24359    roles    TABLE     �   CREATE TABLE seg.roles (
    rol_id integer NOT NULL,
    nombre character varying,
    descripcion character varying,
    fec_alta date,
    eliminado smallint DEFAULT 0 NOT NULL
);
    DROP TABLE seg.roles;
       seg            postgres    false    11            3           1259    24368    settings    TABLE     �   CREATE TABLE seg.settings (
    id integer NOT NULL,
    site_title character varying(50) NOT NULL,
    timezone character varying(100) NOT NULL,
    recaptcha character varying(5) NOT NULL,
    theme character varying(100) NOT NULL
);
    DROP TABLE seg.settings;
       seg            postgres    false    11            2           1259    24366    settings_id_seq    SEQUENCE     �   CREATE SEQUENCE seg.settings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE seg.settings_id_seq;
       seg          postgres    false    11    307            �           0    0    settings_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE seg.settings_id_seq OWNED BY seg.settings.id;
          seg          postgres    false    306            5           1259    24374    tokens    TABLE     �   CREATE TABLE seg.tokens (
    id integer NOT NULL,
    token character varying(255) NOT NULL,
    user_id bigint NOT NULL,
    created date NOT NULL
);
    DROP TABLE seg.tokens;
       seg            postgres    false    11            4           1259    24372    tokens_id_seq    SEQUENCE     �   CREATE SEQUENCE seg.tokens_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 !   DROP SEQUENCE seg.tokens_id_seq;
       seg          postgres    false    11    309            �           0    0    tokens_id_seq    SEQUENCE OWNED BY     9   ALTER SEQUENCE seg.tokens_id_seq OWNED BY seg.tokens.id;
          seg          postgres    false    308            7           1259    24382    users    TABLE     �  CREATE TABLE seg.users (
    id integer NOT NULL,
    email character varying(100),
    first_name character varying(100),
    last_name character varying(100),
    role character varying(10),
    password text,
    last_login character varying(100),
    status character varying(100),
    banned_users character varying(100),
    passmd5 text,
    telefono character varying,
    dni character varying,
    usernick character varying,
    depo_id integer
);
    DROP TABLE seg.users;
       seg            postgres    false    11            6           1259    24380    users_id_seq    SEQUENCE     �   CREATE SEQUENCE seg.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
     DROP SEQUENCE seg.users_id_seq;
       seg          postgres    false    11    311            �           0    0    users_id_seq    SEQUENCE OWNED BY     7   ALTER SEQUENCE seg.users_id_seq OWNED BY seg.users.id;
          seg          postgres    false    310            �           2604    24554    ajustes ajus_id    DEFAULT     l   ALTER TABLE ONLY alm.ajustes ALTER COLUMN ajus_id SET DEFAULT nextval('alm.ajustes_ajus_id_seq'::regclass);
 ;   ALTER TABLE alm.ajustes ALTER COLUMN ajus_id DROP DEFAULT;
       alm          postgres    false    205    204            �           2604    24555    alm_articulos arti_id    DEFAULT     x   ALTER TABLE ONLY alm.alm_articulos ALTER COLUMN arti_id SET DEFAULT nextval('alm.alm_articulos_arti_id_seq'::regclass);
 A   ALTER TABLE alm.alm_articulos ALTER COLUMN arti_id DROP DEFAULT;
       alm          postgres    false    207    206            �           2604    24556    alm_depositos depo_id    DEFAULT     x   ALTER TABLE ONLY alm.alm_depositos ALTER COLUMN depo_id SET DEFAULT nextval('alm.alm_depositos_depo_id_seq'::regclass);
 A   ALTER TABLE alm.alm_depositos ALTER COLUMN depo_id DROP DEFAULT;
       alm          postgres    false    209    208            �           2604    24557 #   alm_deta_entrega_materiales deen_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_entrega_materiales ALTER COLUMN deen_id SET DEFAULT nextval('alm.alm_deta_entrega_materiales_deen_id_seq'::regclass);
 O   ALTER TABLE alm.alm_deta_entrega_materiales ALTER COLUMN deen_id DROP DEFAULT;
       alm          postgres    false    211    210            �           2604    24558 #   alm_deta_pedidos_materiales depe_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales ALTER COLUMN depe_id SET DEFAULT nextval('alm.alm_deta_pedidos_materiales_depe_id_seq'::regclass);
 O   ALTER TABLE alm.alm_deta_pedidos_materiales ALTER COLUMN depe_id DROP DEFAULT;
       alm          postgres    false    213    212            �           2604    24559 %   alm_deta_recepcion_materiales dere_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales ALTER COLUMN dere_id SET DEFAULT nextval('alm.alm_deta_recepcion_materiales_dere_id_seq'::regclass);
 Q   ALTER TABLE alm.alm_deta_recepcion_materiales ALTER COLUMN dere_id DROP DEFAULT;
       alm          postgres    false    215    214            �           2604    24560    alm_entrega_materiales enma_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_entrega_materiales ALTER COLUMN enma_id SET DEFAULT nextval('alm.alm_entrega_materiales_enma_id_seq'::regclass);
 J   ALTER TABLE alm.alm_entrega_materiales ALTER COLUMN enma_id DROP DEFAULT;
       alm          postgres    false    217    216            �           2604    24561    alm_lotes lote_id    DEFAULT     p   ALTER TABLE ONLY alm.alm_lotes ALTER COLUMN lote_id SET DEFAULT nextval('alm.alm_lotes_lote_id_seq'::regclass);
 =   ALTER TABLE alm.alm_lotes ALTER COLUMN lote_id DROP DEFAULT;
       alm          postgres    false    219    218            �           2604    24562    alm_pedidos_materiales pema_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_pedidos_materiales ALTER COLUMN pema_id SET DEFAULT nextval('alm.alm_pedidos_materiales_pema_id_seq'::regclass);
 J   ALTER TABLE alm.alm_pedidos_materiales ALTER COLUMN pema_id DROP DEFAULT;
       alm          postgres    false    221    220            �           2604    24563    alm_proveedores prov_id    DEFAULT     |   ALTER TABLE ONLY alm.alm_proveedores ALTER COLUMN prov_id SET DEFAULT nextval('alm.alm_proveedores_prov_id_seq'::regclass);
 C   ALTER TABLE alm.alm_proveedores ALTER COLUMN prov_id DROP DEFAULT;
       alm          postgres    false    224    222            �           2604    24564     alm_recepcion_materiales rema_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_recepcion_materiales ALTER COLUMN rema_id SET DEFAULT nextval('alm.alm_recepcion_materiales_rema_id_seq'::regclass);
 L   ALTER TABLE alm.alm_recepcion_materiales ALTER COLUMN rema_id DROP DEFAULT;
       alm          postgres    false    226    225            �           2604    24565    deta_ajustes deaj_id    DEFAULT     v   ALTER TABLE ONLY alm.deta_ajustes ALTER COLUMN deaj_id SET DEFAULT nextval('alm.deta_ajustes_deaj_id_seq'::regclass);
 @   ALTER TABLE alm.deta_ajustes ALTER COLUMN deaj_id DROP DEFAULT;
       alm          postgres    false    228    227            �           2604    24566    items item_id    DEFAULT     h   ALTER TABLE ONLY alm.items ALTER COLUMN item_id SET DEFAULT nextval('alm.items_item_id_seq'::regclass);
 9   ALTER TABLE alm.items ALTER COLUMN item_id DROP DEFAULT;
       alm          postgres    false    230    229            �           2604    24567    utl_tablas tabl_id    DEFAULT     r   ALTER TABLE ONLY alm.utl_tablas ALTER COLUMN tabl_id SET DEFAULT nextval('alm.utl_tablas_tabl_id_seq'::regclass);
 >   ALTER TABLE alm.utl_tablas ALTER COLUMN tabl_id DROP DEFAULT;
       alm          postgres    false    232    231            �           2604    24568    departamentos depa_id    DEFAULT     z   ALTER TABLE ONLY core.departamentos ALTER COLUMN depa_id SET DEFAULT nextval('core.departamentos_depa_id_seq'::regclass);
 B   ALTER TABLE core.departamentos ALTER COLUMN depa_id DROP DEFAULT;
       core          postgres    false    234    233            �           2604    24569    empresas empr_id    DEFAULT     p   ALTER TABLE ONLY core.empresas ALTER COLUMN empr_id SET DEFAULT nextval('core.empresas_empr_id_seq'::regclass);
 =   ALTER TABLE core.empresas ALTER COLUMN empr_id DROP DEFAULT;
       core          postgres    false    236    235            �           2604    24570    equipos equi_id    DEFAULT     n   ALTER TABLE ONLY core.equipos ALTER COLUMN equi_id SET DEFAULT nextval('core.equipos_equi_id_seq'::regclass);
 <   ALTER TABLE core.equipos ALTER COLUMN equi_id DROP DEFAULT;
       core          postgres    false    238    237                        2604    24571    snapshots id    DEFAULT     h   ALTER TABLE ONLY core.snapshots ALTER COLUMN id SET DEFAULT nextval('core.snapshots_id_seq'::regclass);
 9   ALTER TABLE core.snapshots ALTER COLUMN id DROP DEFAULT;
       core          postgres    false    241    240            �           2604    24572    tito id    DEFAULT     ^   ALTER TABLE ONLY core.tito ALTER COLUMN id SET DEFAULT nextval('core.tito_id_seq'::regclass);
 4   ALTER TABLE core.tito ALTER COLUMN id DROP DEFAULT;
       core          postgres    false    318    317                       2604    24573    zonas zona_id    DEFAULT     j   ALTER TABLE ONLY core.zonas ALTER COLUMN zona_id SET DEFAULT nextval('core.zonas_zona_id_seq'::regclass);
 :   ALTER TABLE core.zonas ALTER COLUMN zona_id DROP DEFAULT;
       core          postgres    false    244    243                       2604    24574    actas_infraccion acin_id    DEFAULT     }   ALTER TABLE ONLY fis.actas_infraccion ALTER COLUMN acin_id SET DEFAULT nextval('fis.acta_infraccion_acin_id_seq'::regclass);
 D   ALTER TABLE fis.actas_infraccion ALTER COLUMN acin_id DROP DEFAULT;
       fis          postgres    false    246    245                       2604    24575    formularios form_id    DEFAULT     t   ALTER TABLE ONLY frm.formularios ALTER COLUMN form_id SET DEFAULT nextval('frm.formularios_form_id_seq'::regclass);
 ?   ALTER TABLE frm.formularios ALTER COLUMN form_id DROP DEFAULT;
       frm          postgres    false    248    247                       2604    24576    instancias_items init_id    DEFAULT     ~   ALTER TABLE ONLY frm.instancias_items ALTER COLUMN init_id SET DEFAULT nextval('frm.instancias_items_init_id_seq'::regclass);
 D   ALTER TABLE frm.instancias_items ALTER COLUMN init_id DROP DEFAULT;
       frm          postgres    false    250    249                       2604    24577    items item_id    DEFAULT     h   ALTER TABLE ONLY frm.items ALTER COLUMN item_id SET DEFAULT nextval('frm.items_item_id_seq'::regclass);
 9   ALTER TABLE frm.items ALTER COLUMN item_id DROP DEFAULT;
       frm          postgres    false    252    251                       2604    24578    incidencias inci_id    DEFAULT     t   ALTER TABLE ONLY ins.incidencias ALTER COLUMN inci_id SET DEFAULT nextval('ins.incidencias_inci_id_seq'::regclass);
 ?   ALTER TABLE ins.incidencias ALTER COLUMN inci_id DROP DEFAULT;
       ins          postgres    false    254    253            !           2604    24579    choferes chof_id    DEFAULT     n   ALTER TABLE ONLY log.choferes ALTER COLUMN chof_id SET DEFAULT nextval('log.choferes_chof_id_seq'::regclass);
 <   ALTER TABLE log.choferes ALTER COLUMN chof_id DROP DEFAULT;
       log          postgres    false    256    255            %           2604    24580    circuitos circ_id    DEFAULT     q   ALTER TABLE ONLY log.circuitos ALTER COLUMN circ_id SET DEFAULT nextval('log.circuitos_circu_id_seq'::regclass);
 =   ALTER TABLE log.circuitos ALTER COLUMN circ_id DROP DEFAULT;
       log          postgres    false    258    257            -           2604    24581    contenedores cont_id    DEFAULT     t   ALTER TABLE ONLY log.contenedores ALTER COLUMN cont_id SET DEFAULT nextval('log.containers_cont_id_seq'::regclass);
 @   ALTER TABLE log.contenedores ALTER COLUMN cont_id DROP DEFAULT;
       log          postgres    false    261    260            0           2604    24582    contenedores_entregados coen_id    DEFAULT     �   ALTER TABLE ONLY log.contenedores_entregados ALTER COLUMN coen_id SET DEFAULT nextval('log.contenedores_entregados_coen_id_seq'::regclass);
 K   ALTER TABLE log.contenedores_entregados ALTER COLUMN coen_id DROP DEFAULT;
       log          postgres    false    263    262            6           2604    24583    ordenes_transporte ortr_id    DEFAULT     �   ALTER TABLE ONLY log.ordenes_transporte ALTER COLUMN ortr_id SET DEFAULT nextval('log.ordenes_transporte_ortr_id_seq'::regclass);
 F   ALTER TABLE log.ordenes_transporte ALTER COLUMN ortr_id DROP DEFAULT;
       log          postgres    false    267    266            <           2604    24584    puntos_criticos pucr_id    DEFAULT     |   ALTER TABLE ONLY log.puntos_criticos ALTER COLUMN pucr_id SET DEFAULT nextval('log.puntos_criticos_pucr_id_seq'::regclass);
 C   ALTER TABLE log.puntos_criticos ALTER COLUMN pucr_id DROP DEFAULT;
       log          postgres    false    269    268            @           2604    24585    solicitantes_transporte sotr_id    DEFAULT     �   ALTER TABLE ONLY log.solicitantes_transporte ALTER COLUMN sotr_id SET DEFAULT nextval('log.solicitantes_transporte_sotr_id_seq'::regclass);
 K   ALTER TABLE log.solicitantes_transporte ALTER COLUMN sotr_id DROP DEFAULT;
       log          postgres    false    271    270            D           2604    24586    solicitudes_contenedor soco_id    DEFAULT     �   ALTER TABLE ONLY log.solicitudes_contenedor ALTER COLUMN soco_id SET DEFAULT nextval('log.solicitudes_contenedores_soco_id_seq'::regclass);
 J   ALTER TABLE log.solicitudes_contenedor ALTER COLUMN soco_id DROP DEFAULT;
       log          postgres    false    273    272            �           2604    24587 "   templates_orden_transporte teot_id    DEFAULT     �   ALTER TABLE ONLY log.templates_orden_transporte ALTER COLUMN teot_id SET DEFAULT nextval('log.templates_orden_transporte_teot_id_seq'::regclass);
 N   ALTER TABLE log.templates_orden_transporte ALTER COLUMN teot_id DROP DEFAULT;
       log          postgres    false    316    315    316            V           2604    24588    transportistas tran_id    DEFAULT     z   ALTER TABLE ONLY log.transportistas ALTER COLUMN tran_id SET DEFAULT nextval('log.transportistas_tran_id_seq'::regclass);
 B   ALTER TABLE log.transportistas ALTER COLUMN tran_id DROP DEFAULT;
       log          postgres    false    280    279            Z           2604    24589    empaque empa_id    DEFAULT     l   ALTER TABLE ONLY prd.empaque ALTER COLUMN empa_id SET DEFAULT nextval('prd.empaque_empa_id_seq'::regclass);
 ;   ALTER TABLE prd.empaque ALTER COLUMN empa_id DROP DEFAULT;
       prd          postgres    false    283    282            \           2604    24590    establecimientos esta_id    DEFAULT     ~   ALTER TABLE ONLY prd.establecimientos ALTER COLUMN esta_id SET DEFAULT nextval('prd.establecimientos_esta_id_seq'::regclass);
 D   ALTER TABLE prd.establecimientos ALTER COLUMN esta_id DROP DEFAULT;
       prd          postgres    false    285    284            `           2604    24591    etapas etap_id    DEFAULT     j   ALTER TABLE ONLY prd.etapas ALTER COLUMN etap_id SET DEFAULT nextval('prd.etapas_etap_id_seq'::regclass);
 :   ALTER TABLE prd.etapas ALTER COLUMN etap_id DROP DEFAULT;
       prd          postgres    false    287    286            �           2604    24592    formulas form_id    DEFAULT     n   ALTER TABLE ONLY prd.formulas ALTER COLUMN form_id SET DEFAULT nextval('prd.formulas_form_id_seq'::regclass);
 <   ALTER TABLE prd.formulas ALTER COLUMN form_id DROP DEFAULT;
       prd          postgres    false    324    322            c           2604    24593    fraccionamientos frac_id    DEFAULT     ~   ALTER TABLE ONLY prd.fraccionamientos ALTER COLUMN frac_id SET DEFAULT nextval('prd.fraccionamientos_frac_id_seq'::regclass);
 D   ALTER TABLE prd.fraccionamientos ALTER COLUMN frac_id DROP DEFAULT;
       prd          postgres    false    291    290            g           2604    24594    lotes batch_id    DEFAULT     j   ALTER TABLE ONLY prd.lotes ALTER COLUMN batch_id SET DEFAULT nextval('prd.lotes_batch_id_seq'::regclass);
 :   ALTER TABLE prd.lotes ALTER COLUMN batch_id DROP DEFAULT;
       prd          postgres    false    293    292            n           2604    24595    movimientos_trasportes motr_id    DEFAULT     �   ALTER TABLE ONLY prd.movimientos_trasportes ALTER COLUMN motr_id SET DEFAULT nextval('prd.movimientos_trasportes_motr_id_seq'::regclass);
 J   ALTER TABLE prd.movimientos_trasportes ALTER COLUMN motr_id DROP DEFAULT;
       prd          postgres    false    296    295            q           2604    24596    procesos proc_id    DEFAULT     o   ALTER TABLE ONLY prd.procesos ALTER COLUMN proc_id SET DEFAULT nextval('prd.productos_prod_id_seq'::regclass);
 <   ALTER TABLE prd.procesos ALTER COLUMN proc_id DROP DEFAULT;
       prd          postgres    false    298    297            w           2604    24597    recipientes reci_id    DEFAULT     s   ALTER TABLE ONLY prd.recipientes ALTER COLUMN reci_id SET DEFAULT nextval('prd.recipiente_reci_id_seq'::regclass);
 ?   ALTER TABLE prd.recipientes ALTER COLUMN reci_id DROP DEFAULT;
       prd          postgres    false    300    299            }           2604    24598    recursos recu_id    DEFAULT     n   ALTER TABLE ONLY prd.recursos ALTER COLUMN recu_id SET DEFAULT nextval('prd.recursos_recu_id_seq'::regclass);
 <   ALTER TABLE prd.recursos ALTER COLUMN recu_id DROP DEFAULT;
       prd          postgres    false    303    301            �           2604    24599    settings id    DEFAULT     d   ALTER TABLE ONLY seg.settings ALTER COLUMN id SET DEFAULT nextval('seg.settings_id_seq'::regclass);
 7   ALTER TABLE seg.settings ALTER COLUMN id DROP DEFAULT;
       seg          postgres    false    307    306    307            �           2604    24600 	   tokens id    DEFAULT     `   ALTER TABLE ONLY seg.tokens ALTER COLUMN id SET DEFAULT nextval('seg.tokens_id_seq'::regclass);
 5   ALTER TABLE seg.tokens ALTER COLUMN id DROP DEFAULT;
       seg          postgres    false    308    309    309            �           2604    24601    users id    DEFAULT     ^   ALTER TABLE ONLY seg.users ALTER COLUMN id SET DEFAULT nextval('seg.users_id_seq'::regclass);
 4   ALTER TABLE seg.users ALTER COLUMN id DROP DEFAULT;
       seg          postgres    false    311    310    311            ,          0    21654    ajustes 
   TABLE DATA           l   COPY alm.ajustes (ajus_id, tipo_ajuste, justificacion, usuario_app, empr_id, fec_alta, usuario) FROM stdin;
    alm          postgres    false    204            .          0    21664    alm_articulos 
   TABLE DATA           �   COPY alm.alm_articulos (arti_id, barcode, descripcion, costo, es_caja, cantidad_caja, punto_pedido, estado, unidad_medida, empr_id, es_loteado, fec_alta, eliminado, tipo) FROM stdin;
    alm          postgres    false    206            0          0    21675    alm_depositos 
   TABLE DATA           �   COPY alm.alm_depositos (depo_id, descripcion, direccion, gps, estado, loca_id, pais_id, empr_id, fec_alta, eliminado, esta_id, reci_id, "row", col) FROM stdin;
    alm          postgres    false    208            2          0    21690    alm_deta_entrega_materiales 
   TABLE DATA           �   COPY alm.alm_deta_entrega_materiales (deen_id, enma_id, cantidad, arti_id, prov_id, lote_id, depo_id, empr_id, precio, fec_alta, eliminado) FROM stdin;
    alm          postgres    false    210            4          0    21697    alm_deta_pedidos_materiales 
   TABLE DATA           �   COPY alm.alm_deta_pedidos_materiales (depe_id, cantidad, resto, fecha_entrega, fecha_entregado, pema_id, arti_id, fec_alta, eliminado) FROM stdin;
    alm          postgres    false    212            6          0    21704    alm_deta_recepcion_materiales 
   TABLE DATA           �   COPY alm.alm_deta_recepcion_materiales (dere_id, cantidad, precio, empr_id, rema_id, lote_id, prov_id, arti_id, fec_alta, eliminado) FROM stdin;
    alm          postgres    false    214            8          0    21711    alm_entrega_materiales 
   TABLE DATA           �   COPY alm.alm_entrega_materiales (enma_id, fecha, solicitante, dni, comprobante, empr_id, pema_id, fec_alta, eliminado) FROM stdin;
    alm          postgres    false    216            :          0    21721 	   alm_lotes 
   TABLE DATA           �   COPY alm.alm_lotes (lote_id, prov_id, arti_id, depo_id, codigo, fec_vencimiento, cantidad, empr_id, user_id, estado, fec_alta, eliminado, batch_id) FROM stdin;
    alm          postgres    false    218            <          0    21733    alm_pedidos_materiales 
   TABLE DATA           �   COPY alm.alm_pedidos_materiales (pema_id, fecha, motivo_rechazo, justificacion, case_id, ortr_id, estado, empr_id, fec_alta, eliminado, batch_id) FROM stdin;
    alm          postgres    false    220            >          0    21746    alm_proveedores 
   TABLE DATA           w   COPY alm.alm_proveedores (prov_id, nombre, cuit, domicilio, telefono, email, empr_id, fec_alta, eliminado) FROM stdin;
    alm          postgres    false    222            ?          0    21759    alm_proveedores_articulos 
   TABLE DATA           B   COPY alm.alm_proveedores_articulos (prov_id, arti_id) FROM stdin;
    alm          postgres    false    223            A          0    21764    alm_recepcion_materiales 
   TABLE DATA           }   COPY alm.alm_recepcion_materiales (rema_id, fecha, comprobante, empr_id, prov_id, fec_alta, eliminado, batch_id) FROM stdin;
    alm          postgres    false    225            C          0    21771    deta_ajustes 
   TABLE DATA           d   COPY alm.deta_ajustes (deaj_id, cantidad, empr_id, fec_alta, usuario, lote_id, ajus_id) FROM stdin;
    alm          postgres    false    227            E          0    21781    items 
   TABLE DATA           �   COPY alm.items (item_id, label, name, requerido, tipo_dato, valo_id, orden, aux, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, form_id) FROM stdin;
    alm          postgres    false    229            G          0    21791 
   utl_tablas 
   TABLE DATA           Z   COPY alm.utl_tablas (tabl_id, tabla, valor, descripcion, fec_alta, eliminado) FROM stdin;
    alm          postgres    false    231            I          0    21798    departamentos 
   TABLE DATA           V   COPY core.departamentos (depa_id, nombre, descripcion, fec_alta, usuario) FROM stdin;
    core          postgres    false    233            K          0    21808    empresas 
   TABLE DATA           �   COPY core.empresas (empr_id, descripcion, cuit, direccion, telefono, email, imagepath, loca_id, prov_id, pais_id, lat, lng, celular, zona_id, clie_id) FROM stdin;
    core          postgres    false    235            M          0    21816    equipos 
   TABLE DATA           �  COPY core.equipos (equi_id, descripcion, marca, codigo, ubicacion, estado, fecha_ultimalectura, ultima_lectura, tipo_horas, valor_reposicion, fecha_reposicion, valor, comprobante, descrip_tecnica, numero_serie, adjunto, meta_disponibilidad, fecha_ingreso, fecha_baja, fecha_garantia, prov_id, empr_id, sect_id, ubic_id, grup_id, crit_id, unme_id, area_id, proc_id, tran_id, dominio, imagen, tara, cont_id) FROM stdin;
    core          postgres    false    237            O          0    21828    log 
   TABLE DATA           '   COPY core.log (msg, fecha) FROM stdin;
    core          postgres    false    239            P          0    21835 	   snapshots 
   TABLE DATA           I   COPY core.snapshots (id, snap_id, data, fec_alta, eliminado) FROM stdin;
    core          postgres    false    240            R          0    21845    tablas 
   TABLE DATA           p   COPY core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) FROM stdin;
    core          postgres    false    242            �          0    24500    tito 
   TABLE DATA           )   COPY core.tito (id, column1) FROM stdin;
    core          postgres    false    317            �          0    24508    transportistas 
   TABLE DATA           Z   COPY core.transportistas (cuit, razon_social, direccion, fec_alta, eliminado) FROM stdin;
    core          postgres    false    319            S          0    21870    zonas 
   TABLE DATA           w   COPY core.zonas (zona_id, nombre, descripcion, imagen, fec_alta, usuario, usuario_app, depa_id, eliminado) FROM stdin;
    core          postgres    false    243            U          0    21881    actas_infraccion 
   TABLE DATA           �   COPY fis.actas_infraccion (acin_id, numero_acta, descripcion, tipo, sotr_id, inspector_id, tran_id, destino, fecha_creacion, usuario_app, eliminado, usuario) FROM stdin;
    fis          postgres    false    245            W          0    21892    formularios 
   TABLE DATA           ^   COPY frm.formularios (form_id, nombre, descripcion, eliminado, fec_alta, usuario) FROM stdin;
    frm          postgres    false    247            Y          0    21903    instancias_items 
   TABLE DATA           �   COPY frm.instancias_items (init_id, label, name, valor, requerido, tida_id, valo_id, info_id, form_id, orden, aux, eliminado, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, item_id) FROM stdin;
    frm          postgres    false    249            [          0    21915    items 
   TABLE DATA           �   COPY frm.items (item_id, label, name, requerido, tipo_dato, valo_id, orden, aux, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, form_id) FROM stdin;
    frm          postgres    false    251            ]          0    21925    incidencias 
   TABLE DATA           �   COPY ins.incidencias (inci_id, descripcion, fecha, num_acta, adjunto, fec_alta, usuario, usuario_app, tiin_id, tica_id, difi_id, ortr_id, eliminado, estado) FROM stdin;
    ins          postgres    false    253            _          0    21935    choferes 
   TABLE DATA           �   COPY log.choferes (chof_id, nombre, apellido, documento, fec_nacimiento, direccion, celular, codigo, carnet, vencimiento, habilitacion, imagen, fec_alta, usuario, tran_id, cach_id, eliminado, usuario_app) FROM stdin;
    log          postgres    false    255            �          0    24516    cierre_sector_descarga 
   TABLE DATA           ^   COPY log.cierre_sector_descarga (estado, fec_alta, usuario, usuario_app, cisd_id) FROM stdin;
    log          postgres    false    320            a          0    21946 	   circuitos 
   TABLE DATA           �   COPY log.circuitos (circ_id, codigo, descripcion, imagen, fec_alta, usuario, usuario_app, chof_id, vehi_id, zona_id, eliminado) FROM stdin;
    log          postgres    false    257            c          0    21957    circuitos_puntos_criticos 
   TABLE DATA           `   COPY log.circuitos_puntos_criticos (fec_alta, usuario, circ_id, pucr_id, eliminado) FROM stdin;
    log          postgres    false    259            d          0    21966    contenedores 
   TABLE DATA           �   COPY log.contenedores (cont_id, codigo, descripcion, capacidad, tara, habilitacion, fec_alta, usuario, usuario_app, esco_id, reci_id, anio_elaboracion, tran_id, eliminado, imagen) FROM stdin;
    log          postgres    false    260            f          0    21978    contenedores_entregados 
   TABLE DATA           :  COPY log.contenedores_entregados (coen_id, porc_llenado, mts_cubicos, fec_entrega, fec_retiro, fec_alta, usuario, usuario_app, cont_id, soco_id, sore_id, ortr_id, tica_id, depo_id, peso_neto, difi_id, equi_id, equi_id_entrega, batch_id, foto, tiva_id, observaciones_descarga, fec_descarga, fec_salida) FROM stdin;
    log          postgres    false    262            i          0    21990    contenedores_solicitados 
   TABLE DATA           �   COPY log.contenedores_solicitados (coso_id, cantidad, otro, fec_alta, usuario, usuario_app, tica_id, soco_id, reci_id, cantidad_acordada, motivo_rechazo) FROM stdin;
    log          postgres    false    265            j          0    21999    ordenes_transporte 
   TABLE DATA           �   COPY log.ordenes_transporte (ortr_id, fec_retiro, estado, fec_alta, usuario, difi_id, sotr_id, equi_id, chof_id, case_id, usuario_app, eliminado, tran_id, teot_id) FROM stdin;
    log          postgres    false    266            l          0    22010    puntos_criticos 
   TABLE DATA           �   COPY log.puntos_criticos (pucr_id, nombre, descripcion, lat, lng, fec_alta, usuario, usuario_app, zona_id, eliminado) FROM stdin;
    log          postgres    false    268            n          0    22021    solicitantes_transporte 
   TABLE DATA           �   COPY log.solicitantes_transporte (sotr_id, razon_social, cuit, domicilio, num_registro, lat, lng, usuario, fec_alta, usuario_app, zona_id, rubr_id, tist_id, eliminado, depa_id, prov_id, user_id) FROM stdin;
    log          postgres    false    270            p          0    22032    solicitudes_contenedor 
   TABLE DATA           �   COPY log.solicitudes_contenedor (soco_id, estado, observaciones, fec_alta, usuario, usuario_app, sotr_id, case_id, eliminado, tran_id) FROM stdin;
    log          postgres    false    272            s          0    22046    solicitudes_retiro 
   TABLE DATA           w   COPY log.solicitudes_retiro (sore_id, fec_alta, usuario, usuario_app, sotr_id, eliminado, case_id, estado) FROM stdin;
    log          postgres    false    275            �          0    24447    templates_orden_transporte 
   TABLE DATA           �   COPY log.templates_orden_transporte (teot_id, observaciones, eliminado, fec_alta, usuario, usuario_app, circ_id, equi_id, chof_id, tica_id, difi_id, sotr_id) FROM stdin;
    log          postgres    false    316            t          0    22056    tipos_carga_circuitos 
   TABLE DATA           Q   COPY log.tipos_carga_circuitos (fec_alta, usuario, circ_id, tica_id) FROM stdin;
    log          postgres    false    276            u          0    22064    tipos_carga_contenedores 
   TABLE DATA           _   COPY log.tipos_carga_contenedores (fec_alta, usuario, cont_id, tica_id, eliminado) FROM stdin;
    log          postgres    false    277            �          0    23468    tipos_carga_generadores 
   TABLE DATA           @   COPY log.tipos_carga_generadores (tica_id, sotr_id) FROM stdin;
    log          postgres    false    304            v          0    22073    tipos_carga_transportistas 
   TABLE DATA           V   COPY log.tipos_carga_transportistas (fec_alta, usuario, tran_id, tica_id) FROM stdin;
    log          postgres    false    278            w          0    22081    transportistas 
   TABLE DATA           �   COPY log.transportistas (tran_id, razon_social, descripcion, direccion, telefono, contacto, resolucion, registro, fec_alta_efectiva, fec_baja_efectiva, fec_alta, usuario, usuario_app, eliminado, cuit, user_id) FROM stdin;
    log          postgres    false    279            y          0    22092    costos 
   TABLE DATA           ]   COPY prd.costos (fec_vigencia, valor, umed, fec_alta, usuario, recu_id, empr_id) FROM stdin;
    prd          postgres    false    281            z          0    22100    empaque 
   TABLE DATA           u   COPY prd.empaque (empa_id, nombre, unidad_medida, capacidad, empr_id, usuario_app, eliminado, fech_alta) FROM stdin;
    prd          postgres    false    282            |          0    22109    establecimientos 
   TABLE DATA           �   COPY prd.establecimientos (esta_id, nombre, lng, lat, calle, altura, localidad, estado, pais, fec_alta, usuario, empr_id) FROM stdin;
    prd          postgres    false    284            ~          0    22118    etapas 
   TABLE DATA           {   COPY prd.etapas (etap_id, nombre, nom_recipiente, fec_alta, usuario, proc_id, eliminado, empr_id, orden, link) FROM stdin;
    prd          postgres    false    286            �          0    22129    etapas_materiales 
   TABLE DATA           :   COPY prd.etapas_materiales (etap_id, arti_id) FROM stdin;
    prd          postgres    false    288            �          0    22132    etapas_productos 
   TABLE DATA           9   COPY prd.etapas_productos (etap_id, arti_id) FROM stdin;
    prd          postgres    false    289            �          0    24524    etapas_salidas 
   TABLE DATA           7   COPY prd.etapas_salidas (etap_id, arti_id) FROM stdin;
    prd          postgres    false    321            �          0    24527    formulas 
   TABLE DATA              COPY prd.formulas (form_id, descripcion, cantidad, eliminado, aplicacion, fec_alta, usuario, usuario_app, unme_id) FROM stdin;
    prd          postgres    false    322            �          0    24536    formulas_articulos 
   TABLE DATA           a   COPY prd.formulas_articulos (cantidad, fec_alta, usuario, unme_id, form_id, arti_id) FROM stdin;
    prd          postgres    false    323            �          0    22135    fraccionamientos 
   TABLE DATA           g   COPY prd.fraccionamientos (frac_id, recu_id, empa_id, cantidad, fecha, eliminado, empr_id) FROM stdin;
    prd          postgres    false    290            �          0    22142    lotes 
   TABLE DATA           �   COPY prd.lotes (lote_id, batch_id, estado, num_orden_prod, fec_alta, usuario, etap_id, eliminado, nombre, reci_id, empr_id, usuario_app, arti_id) FROM stdin;
    prd          postgres    false    292            �          0    22153    lotes_hijos 
   TABLE DATA           }   COPY prd.lotes_hijos (batch_id, batch_id_padre, fec_alta, usuario, eliminado, empr_id, cantidad, cantidad_padre) FROM stdin;
    prd          postgres    false    294            �          0    24546    lotes_responsables 
   TABLE DATA           X   COPY prd.lotes_responsables (fec_alta, usuario, batch_id, user_id, turn_id) FROM stdin;
    prd          postgres    false    325            �          0    22162    movimientos_trasportes 
   TABLE DATA           �   COPY prd.movimientos_trasportes (motr_id, boleta, fecha_entrada, patente, acoplado, conductor, tipo, bruto, tara, neto, prov_id, esta_id, fec_alta, eliminado, estado, reci_id, transportista, cuit, accion) FROM stdin;
    prd          postgres    false    295            �          0    22173    procesos 
   TABLE DATA           L   COPY prd.procesos (proc_id, nombre, fec_alta, usuario, empr_id) FROM stdin;
    prd          postgres    false    297            �          0    22183    recipientes 
   TABLE DATA           �   COPY prd.recipientes (reci_id, tipo, estado, nombre, fec_alta, usuario, eliminado, empr_id, depo_id, motr_id, "row", col, care_id) FROM stdin;
    prd          postgres    false    299            �          0    22198    recursos 
   TABLE DATA           �   COPY prd.recursos (recu_id, tipo, cant_capacidad, umed_capacidad, cant_tiempo_capacidad, umed_iempo_capacidad, fec_alta, usuario, arti_id, empr_id, equi_id) FROM stdin;
    prd          postgres    false    301            �          0    22207    recursos_lotes 
   TABLE DATA           |   COPY prd.recursos_lotes (batch_id, recu_id, fec_alta, usuario, empr_id, cantidad, tipo, empa_id, empa_cantidad) FROM stdin;
    prd          postgres    false    302            �          0    24426    memberships_menues 
   TABLE DATA           h   COPY seg.memberships_menues (modulo, opcion, "group", role, fec_alta, usuario, usuario_app) FROM stdin;
    seg          postgres    false    314            �          0    24393    memberships_users 
   TABLE DATA           ^   COPY seg.memberships_users ("group", role, fec_alta, usuario, usuario_app, email) FROM stdin;
    seg          postgres    false    312            �          0    24408    menues 
   TABLE DATA           �   COPY seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) FROM stdin;
    seg          postgres    false    313            �          0    24359    roles 
   TABLE DATA           N   COPY seg.roles (rol_id, nombre, descripcion, fec_alta, eliminado) FROM stdin;
    seg          postgres    false    305            �          0    24368    settings 
   TABLE DATA           K   COPY seg.settings (id, site_title, timezone, recaptcha, theme) FROM stdin;
    seg          postgres    false    307            �          0    24374    tokens 
   TABLE DATA           :   COPY seg.tokens (id, token, user_id, created) FROM stdin;
    seg          postgres    false    309            �          0    24382    users 
   TABLE DATA           �   COPY seg.users (id, email, first_name, last_name, role, password, last_login, status, banned_users, passmd5, telefono, dni, usernick, depo_id) FROM stdin;
    seg          postgres    false    311            �           0    0    ajustes_ajus_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('alm.ajustes_ajus_id_seq', 44, true);
          alm          postgres    false    205            �           0    0    alm_articulos_arti_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('alm.alm_articulos_arti_id_seq', 69, true);
          alm          postgres    false    207            �           0    0    alm_depositos_depo_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('alm.alm_depositos_depo_id_seq', 7, true);
          alm          postgres    false    209            �           0    0 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE SET     R   SELECT pg_catalog.setval('alm.alm_deta_entrega_materiales_deen_id_seq', 9, true);
          alm          postgres    false    211            �           0    0 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE SET     T   SELECT pg_catalog.setval('alm.alm_deta_pedidos_materiales_depe_id_seq', 143, true);
          alm          postgres    false    213            �           0    0 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE SET     T   SELECT pg_catalog.setval('alm.alm_deta_recepcion_materiales_dere_id_seq', 4, true);
          alm          postgres    false    215            �           0    0 "   alm_entrega_materiales_enma_id_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('alm.alm_entrega_materiales_enma_id_seq', 1, true);
          alm          postgres    false    217            �           0    0    alm_lotes_lote_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('alm.alm_lotes_lote_id_seq', 75, true);
          alm          postgres    false    219            �           0    0 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('alm.alm_pedidos_materiales_pema_id_seq', 197, true);
          alm          postgres    false    221            �           0    0    alm_proveedores_prov_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('alm.alm_proveedores_prov_id_seq', 6, true);
          alm          postgres    false    224            �           0    0 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('alm.alm_recepcion_materiales_rema_id_seq', 2, true);
          alm          postgres    false    226            �           0    0    deta_ajustes_deaj_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('alm.deta_ajustes_deaj_id_seq', 27, true);
          alm          postgres    false    228            �           0    0    items_item_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('alm.items_item_id_seq', 1, false);
          alm          postgres    false    230            �           0    0    utl_tablas_tabl_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('alm.utl_tablas_tabl_id_seq', 17, true);
          alm          postgres    false    232            �           0    0    departamentos_depa_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('core.departamentos_depa_id_seq', 9, true);
          core          postgres    false    234            �           0    0    empresas_empr_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('core.empresas_empr_id_seq', 1, true);
          core          postgres    false    236            �           0    0    equipos_equi_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('core.equipos_equi_id_seq', 46, true);
          core          postgres    false    238            �           0    0    snapshots_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('core.snapshots_id_seq', 58, true);
          core          postgres    false    241            �           0    0    tito_id_seq    SEQUENCE SET     8   SELECT pg_catalog.setval('core.tito_id_seq', 1, false);
          core          postgres    false    318            �           0    0    zonas_zona_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('core.zonas_zona_id_seq', 127, true);
          core          postgres    false    244            �           0    0    acta_infraccion_acin_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('fis.acta_infraccion_acin_id_seq', 1, false);
          fis          postgres    false    246            �           0    0    formularios_form_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('frm.formularios_form_id_seq', 1, false);
          frm          postgres    false    248            �           0    0    instancias_items_init_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('frm.instancias_items_init_id_seq', 1, false);
          frm          postgres    false    250            �           0    0    items_item_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('frm.items_item_id_seq', 1, false);
          frm          postgres    false    252            �           0    0    incidencias_inci_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('ins.incidencias_inci_id_seq', 5, true);
          ins          postgres    false    254            �           0    0    choferes_chof_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('log.choferes_chof_id_seq', 51, true);
          log          postgres    false    256            �           0    0    circuitos_circu_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('log.circuitos_circu_id_seq', 160, true);
          log          postgres    false    258            �           0    0    containers_cont_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('log.containers_cont_id_seq', 119, true);
          log          postgres    false    261            �           0    0 #   contenedores_entregados_coen_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('log.contenedores_entregados_coen_id_seq', 6, true);
          log          postgres    false    263            �           0    0 $   contenedores_solicitados_coso_id_seq    SEQUENCE SET     Q   SELECT pg_catalog.setval('log.contenedores_solicitados_coso_id_seq', 143, true);
          log          postgres    false    264            �           0    0    ordenes_transporte_ortr_id_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('log.ordenes_transporte_ortr_id_seq', 21, true);
          log          postgres    false    267                        0    0    puntos_criticos_pucr_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('log.puntos_criticos_pucr_id_seq', 223, true);
          log          postgres    false    269                       0    0 #   solicitantes_transporte_sotr_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('log.solicitantes_transporte_sotr_id_seq', 53, true);
          log          postgres    false    271                       0    0 $   solicitudes_contenedores_soco_id_seq    SEQUENCE SET     P   SELECT pg_catalog.setval('log.solicitudes_contenedores_soco_id_seq', 78, true);
          log          postgres    false    273                       0    0    solicitudes_retiro_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('log.solicitudes_retiro_seq', 23, true);
          log          postgres    false    274                       0    0 &   templates_orden_transporte_teot_id_seq    SEQUENCE SET     R   SELECT pg_catalog.setval('log.templates_orden_transporte_teot_id_seq', 1, false);
          log          postgres    false    315                       0    0    transportistas_tran_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('log.transportistas_tran_id_seq', 54, true);
          log          postgres    false    280                       0    0    empaque_empa_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('prd.empaque_empa_id_seq', 5, true);
          prd          postgres    false    283                       0    0    establecimientos_esta_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('prd.establecimientos_esta_id_seq', 4, true);
          prd          postgres    false    285                       0    0    etapas_etap_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('prd.etapas_etap_id_seq', 1, true);
          prd          postgres    false    287            	           0    0    formulas_form_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('prd.formulas_form_id_seq', 1, false);
          prd          postgres    false    324            
           0    0    fraccionamientos_frac_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('prd.fraccionamientos_frac_id_seq', 3, true);
          prd          postgres    false    291                       0    0    lotes_batch_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('prd.lotes_batch_id_seq', 192, true);
          prd          postgres    false    293                       0    0 "   movimientos_trasportes_motr_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('prd.movimientos_trasportes_motr_id_seq', 31, true);
          prd          postgres    false    296                       0    0    productos_prod_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('prd.productos_prod_id_seq', 1, true);
          prd          postgres    false    298                       0    0    recipiente_reci_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('prd.recipiente_reci_id_seq', 179, true);
          prd          postgres    false    300                       0    0    recursos_recu_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('prd.recursos_recu_id_seq', 16, true);
          prd          postgres    false    303                       0    0    settings_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('seg.settings_id_seq', 1, false);
          seg          postgres    false    306                       0    0    tokens_id_seq    SEQUENCE SET     9   SELECT pg_catalog.setval('seg.tokens_id_seq', 1, false);
          seg          postgres    false    308                       0    0    users_id_seq    SEQUENCE SET     8   SELECT pg_catalog.setval('seg.users_id_seq', 1, false);
          seg          postgres    false    310            �           2606    22271    ajustes ajustes_pk 
   CONSTRAINT     R   ALTER TABLE ONLY alm.ajustes
    ADD CONSTRAINT ajustes_pk PRIMARY KEY (ajus_id);
 9   ALTER TABLE ONLY alm.ajustes DROP CONSTRAINT ajustes_pk;
       alm            postgres    false    204            �           2606    22273     alm_articulos alm_articulos_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY alm.alm_articulos
    ADD CONSTRAINT alm_articulos_pkey PRIMARY KEY (arti_id);
 G   ALTER TABLE ONLY alm.alm_articulos DROP CONSTRAINT alm_articulos_pkey;
       alm            postgres    false    206            �           2606    24603    alm_articulos alm_articulos_un 
   CONSTRAINT     Y   ALTER TABLE ONLY alm.alm_articulos
    ADD CONSTRAINT alm_articulos_un UNIQUE (barcode);
 E   ALTER TABLE ONLY alm.alm_articulos DROP CONSTRAINT alm_articulos_un;
       alm            postgres    false    206            �           2606    22275     alm_depositos alm_depositos_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY alm.alm_depositos
    ADD CONSTRAINT alm_depositos_pkey PRIMARY KEY (depo_id);
 G   ALTER TABLE ONLY alm.alm_depositos DROP CONSTRAINT alm_depositos_pkey;
       alm            postgres    false    208            �           2606    22277 <   alm_deta_entrega_materiales alm_deta_entrega_materiales_pkey 
   CONSTRAINT     |   ALTER TABLE ONLY alm.alm_deta_entrega_materiales
    ADD CONSTRAINT alm_deta_entrega_materiales_pkey PRIMARY KEY (deen_id);
 c   ALTER TABLE ONLY alm.alm_deta_entrega_materiales DROP CONSTRAINT alm_deta_entrega_materiales_pkey;
       alm            postgres    false    210            �           2606    22279 <   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_pkey 
   CONSTRAINT     |   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_pkey PRIMARY KEY (depe_id);
 c   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_pkey;
       alm            postgres    false    212            �           2606    22281 @   alm_deta_recepcion_materiales alm_deta_recepcion_materiales_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales
    ADD CONSTRAINT alm_deta_recepcion_materiales_pkey PRIMARY KEY (dere_id);
 g   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales DROP CONSTRAINT alm_deta_recepcion_materiales_pkey;
       alm            postgres    false    214            �           2606    22283 2   alm_entrega_materiales alm_entrega_materiales_pkey 
   CONSTRAINT     r   ALTER TABLE ONLY alm.alm_entrega_materiales
    ADD CONSTRAINT alm_entrega_materiales_pkey PRIMARY KEY (enma_id);
 Y   ALTER TABLE ONLY alm.alm_entrega_materiales DROP CONSTRAINT alm_entrega_materiales_pkey;
       alm            postgres    false    216            �           2606    22285    alm_lotes alm_lotes_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_pkey PRIMARY KEY (lote_id);
 ?   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_pkey;
       alm            postgres    false    218            �           2606    22287 2   alm_pedidos_materiales alm_pedidos_materiales_pkey 
   CONSTRAINT     r   ALTER TABLE ONLY alm.alm_pedidos_materiales
    ADD CONSTRAINT alm_pedidos_materiales_pkey PRIMARY KEY (pema_id);
 Y   ALTER TABLE ONLY alm.alm_pedidos_materiales DROP CONSTRAINT alm_pedidos_materiales_pkey;
       alm            postgres    false    220            �           2606    22289 8   alm_proveedores_articulos alm_proveedores_articulos_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_pkey PRIMARY KEY (prov_id, arti_id);
 _   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_pkey;
       alm            postgres    false    223    223            �           2606    22291 $   alm_proveedores alm_proveedores_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY alm.alm_proveedores
    ADD CONSTRAINT alm_proveedores_pkey PRIMARY KEY (prov_id);
 K   ALTER TABLE ONLY alm.alm_proveedores DROP CONSTRAINT alm_proveedores_pkey;
       alm            postgres    false    222            �           2606    22293 6   alm_recepcion_materiales alm_recepcion_materiales_pkey 
   CONSTRAINT     v   ALTER TABLE ONLY alm.alm_recepcion_materiales
    ADD CONSTRAINT alm_recepcion_materiales_pkey PRIMARY KEY (rema_id);
 ]   ALTER TABLE ONLY alm.alm_recepcion_materiales DROP CONSTRAINT alm_recepcion_materiales_pkey;
       alm            postgres    false    225            �           2606    22295    deta_ajustes deta_ajustes_pk 
   CONSTRAINT     \   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_pk PRIMARY KEY (deaj_id);
 C   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_pk;
       alm            postgres    false    227            �           2606    22297    items items_pk 
   CONSTRAINT     N   ALTER TABLE ONLY alm.items
    ADD CONSTRAINT items_pk PRIMARY KEY (item_id);
 5   ALTER TABLE ONLY alm.items DROP CONSTRAINT items_pk;
       alm            postgres    false    229            �           2606    22299    utl_tablas utl_tablas_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY alm.utl_tablas
    ADD CONSTRAINT utl_tablas_pkey PRIMARY KEY (tabl_id);
 A   ALTER TABLE ONLY alm.utl_tablas DROP CONSTRAINT utl_tablas_pkey;
       alm            postgres    false    231            �           2606    22301    departamentos departamentos_pk 
   CONSTRAINT     _   ALTER TABLE ONLY core.departamentos
    ADD CONSTRAINT departamentos_pk PRIMARY KEY (depa_id);
 F   ALTER TABLE ONLY core.departamentos DROP CONSTRAINT departamentos_pk;
       core            postgres    false    233            �           2606    22303    empresas empresas_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY core.empresas
    ADD CONSTRAINT empresas_pkey PRIMARY KEY (empr_id);
 >   ALTER TABLE ONLY core.empresas DROP CONSTRAINT empresas_pkey;
       core            postgres    false    235            �           2606    22305    equipos equipos_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY core.equipos
    ADD CONSTRAINT equipos_pkey PRIMARY KEY (equi_id);
 <   ALTER TABLE ONLY core.equipos DROP CONSTRAINT equipos_pkey;
       core            postgres    false    237            �           2606    24753    snapshots snapshots_pk 
   CONSTRAINT     W   ALTER TABLE ONLY core.snapshots
    ADD CONSTRAINT snapshots_pk PRIMARY KEY (snap_id);
 >   ALTER TABLE ONLY core.snapshots DROP CONSTRAINT snapshots_pk;
       core            postgres    false    240            �           2606    22307    tablas tablas_pk 
   CONSTRAINT     Q   ALTER TABLE ONLY core.tablas
    ADD CONSTRAINT tablas_pk PRIMARY KEY (tabl_id);
 8   ALTER TABLE ONLY core.tablas DROP CONSTRAINT tablas_pk;
       core            postgres    false    242            1           2606    24607    tito tito_pk 
   CONSTRAINT     H   ALTER TABLE ONLY core.tito
    ADD CONSTRAINT tito_pk PRIMARY KEY (id);
 4   ALTER TABLE ONLY core.tito DROP CONSTRAINT tito_pk;
       core            postgres    false    317            3           2606    24609     transportistas transportistas_pk 
   CONSTRAINT     ^   ALTER TABLE ONLY core.transportistas
    ADD CONSTRAINT transportistas_pk PRIMARY KEY (cuit);
 H   ALTER TABLE ONLY core.transportistas DROP CONSTRAINT transportistas_pk;
       core            postgres    false    319            �           2606    22311    zonas zonas_pk 
   CONSTRAINT     O   ALTER TABLE ONLY core.zonas
    ADD CONSTRAINT zonas_pk PRIMARY KEY (zona_id);
 6   ALTER TABLE ONLY core.zonas DROP CONSTRAINT zonas_pk;
       core            postgres    false    243            �           2606    22313 #   actas_infraccion acta_infraccion_pk 
   CONSTRAINT     c   ALTER TABLE ONLY fis.actas_infraccion
    ADD CONSTRAINT acta_infraccion_pk PRIMARY KEY (acin_id);
 J   ALTER TABLE ONLY fis.actas_infraccion DROP CONSTRAINT acta_infraccion_pk;
       fis            postgres    false    245            �           2606    22315    formularios formularios_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY frm.formularios
    ADD CONSTRAINT formularios_pk PRIMARY KEY (form_id);
 A   ALTER TABLE ONLY frm.formularios DROP CONSTRAINT formularios_pk;
       frm            postgres    false    247            �           2606    22317 $   instancias_items instancias_items_pk 
   CONSTRAINT     d   ALTER TABLE ONLY frm.instancias_items
    ADD CONSTRAINT instancias_items_pk PRIMARY KEY (init_id);
 K   ALTER TABLE ONLY frm.instancias_items DROP CONSTRAINT instancias_items_pk;
       frm            postgres    false    249            �           2606    22319    items items_pk 
   CONSTRAINT     N   ALTER TABLE ONLY frm.items
    ADD CONSTRAINT items_pk PRIMARY KEY (item_id);
 5   ALTER TABLE ONLY frm.items DROP CONSTRAINT items_pk;
       frm            postgres    false    251            �           2606    22321    incidencias incidencias_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY ins.incidencias
    ADD CONSTRAINT incidencias_pk PRIMARY KEY (inci_id);
 A   ALTER TABLE ONLY ins.incidencias DROP CONSTRAINT incidencias_pk;
       ins            postgres    false    253            �           2606    22323    choferes choferes_dni_un 
   CONSTRAINT     U   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_dni_un UNIQUE (documento);
 ?   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_dni_un;
       log            postgres    false    255            �           2606    22325    choferes choferes_pk 
   CONSTRAINT     T   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_pk PRIMARY KEY (chof_id);
 ;   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_pk;
       log            postgres    false    255            5           2606    24611 0   cierre_sector_descarga cierre_sector_descarga_pk 
   CONSTRAINT     z   ALTER TABLE ONLY log.cierre_sector_descarga
    ADD CONSTRAINT cierre_sector_descarga_pk PRIMARY KEY (fec_alta, cisd_id);
 W   ALTER TABLE ONLY log.cierre_sector_descarga DROP CONSTRAINT cierre_sector_descarga_pk;
       log            postgres    false    320    320            �           2606    22327    circuitos circuitos_pk 
   CONSTRAINT     V   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_pk PRIMARY KEY (circ_id);
 =   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_pk;
       log            postgres    false    257            �           2606    22329 6   circuitos_puntos_criticos circuitos_puntos_criticos_pk 
   CONSTRAINT        ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_pk PRIMARY KEY (circ_id, pucr_id);
 ]   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_pk;
       log            postgres    false    259    259            �           2606    22331    circuitos circuitos_un 
   CONSTRAINT     P   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_un UNIQUE (codigo);
 =   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_un;
       log            postgres    false    257            �           2606    22333 !   contenedores containers_codigo_un 
   CONSTRAINT     [   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_codigo_un UNIQUE (codigo);
 H   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_codigo_un;
       log            postgres    false    260            �           2606    22335    contenedores containers_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_pk PRIMARY KEY (cont_id);
 A   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_pk;
       log            postgres    false    260            �           2606    24613 2   contenedores_entregados contenedores_entregados_pk 
   CONSTRAINT     r   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_pk PRIMARY KEY (coen_id);
 Y   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_pk;
       log            postgres    false    262            �           2606    24615 2   contenedores_entregados contenedores_entregados_un 
   CONSTRAINT     v   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_un UNIQUE (cont_id, ortr_id);
 Y   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_un;
       log            postgres    false    262    262            �           2606    22337    contenedores contenedores_un 
   CONSTRAINT     W   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT contenedores_un UNIQUE (cont_id);
 C   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT contenedores_un;
       log            postgres    false    260            �           2606    22339 7   contenedores_solicitados deta_solicitudes_contenedor_pk 
   CONSTRAINT     w   ALTER TABLE ONLY log.contenedores_solicitados
    ADD CONSTRAINT deta_solicitudes_contenedor_pk PRIMARY KEY (coso_id);
 ^   ALTER TABLE ONLY log.contenedores_solicitados DROP CONSTRAINT deta_solicitudes_contenedor_pk;
       log            postgres    false    265            �           2606    22341 (   ordenes_transporte ordenes_transporte_pk 
   CONSTRAINT     h   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_pk PRIMARY KEY (ortr_id);
 O   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_pk;
       log            postgres    false    266            �           2606    22343 "   puntos_criticos puntos_criticos_pk 
   CONSTRAINT     b   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_pk PRIMARY KEY (pucr_id);
 I   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_pk;
       log            postgres    false    268            �           2606    22345 "   puntos_criticos puntos_criticos_un 
   CONSTRAINT     \   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_un UNIQUE (nombre);
 I   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_un;
       log            postgres    false    268            �           2606    22347 1   solicitantes_transporte solcitantes_transporte_pk 
   CONSTRAINT     q   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_pk PRIMARY KEY (sotr_id);
 X   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_pk;
       log            postgres    false    270            �           2606    22349 2   solicitantes_transporte solicitantes_transporte_un 
   CONSTRAINT     j   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solicitantes_transporte_un UNIQUE (cuit);
 Y   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solicitantes_transporte_un;
       log            postgres    false    270            �           2606    22351 2   solicitudes_contenedor solicitudes_contenedores_pk 
   CONSTRAINT     r   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedores_pk PRIMARY KEY (soco_id);
 Y   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedores_pk;
       log            postgres    false    272            �           2606    22353 (   solicitudes_retiro solicitudes_retiro_pk 
   CONSTRAINT     h   ALTER TABLE ONLY log.solicitudes_retiro
    ADD CONSTRAINT solicitudes_retiro_pk PRIMARY KEY (sore_id);
 O   ALTER TABLE ONLY log.solicitudes_retiro DROP CONSTRAINT solicitudes_retiro_pk;
       log            postgres    false    275            /           2606    24458 8   templates_orden_transporte templates_orden_transporte_un 
   CONSTRAINT     s   ALTER TABLE ONLY log.templates_orden_transporte
    ADD CONSTRAINT templates_orden_transporte_un UNIQUE (teot_id);
 _   ALTER TABLE ONLY log.templates_orden_transporte DROP CONSTRAINT templates_orden_transporte_un;
       log            postgres    false    316            �           2606    22355 .   tipos_carga_circuitos tipos_carga_circuitos_pk 
   CONSTRAINT     w   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_carga_circuitos_pk PRIMARY KEY (circ_id, tica_id);
 U   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_carga_circuitos_pk;
       log            postgres    false    276    276                       2606    22357 8   tipos_carga_transportistas tipos_carga_transportistas_pk 
   CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_pk PRIMARY KEY (tran_id, tica_id);
 _   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_pk;
       log            postgres    false    278    278                       2606    22359     transportistas transportistas_pk 
   CONSTRAINT     `   ALTER TABLE ONLY log.transportistas
    ADD CONSTRAINT transportistas_pk PRIMARY KEY (tran_id);
 G   ALTER TABLE ONLY log.transportistas DROP CONSTRAINT transportistas_pk;
       log            postgres    false    279                       2606    22361     transportistas transportistas_un 
   CONSTRAINT     `   ALTER TABLE ONLY log.transportistas
    ADD CONSTRAINT transportistas_un UNIQUE (razon_social);
 G   ALTER TABLE ONLY log.transportistas DROP CONSTRAINT transportistas_un;
       log            postgres    false    279                       2606    22363    costos costos_pk 
   CONSTRAINT     ^   ALTER TABLE ONLY prd.costos
    ADD CONSTRAINT costos_pk PRIMARY KEY (fec_vigencia, recu_id);
 7   ALTER TABLE ONLY prd.costos DROP CONSTRAINT costos_pk;
       prd            postgres    false    281    281            	           2606    22365    empaque empaque_pk 
   CONSTRAINT     R   ALTER TABLE ONLY prd.empaque
    ADD CONSTRAINT empaque_pk PRIMARY KEY (empa_id);
 9   ALTER TABLE ONLY prd.empaque DROP CONSTRAINT empaque_pk;
       prd            postgres    false    282                       2606    22367 $   establecimientos establecimientos_pk 
   CONSTRAINT     d   ALTER TABLE ONLY prd.establecimientos
    ADD CONSTRAINT establecimientos_pk PRIMARY KEY (esta_id);
 K   ALTER TABLE ONLY prd.establecimientos DROP CONSTRAINT establecimientos_pk;
       prd            postgres    false    284                       2606    22369 &   etapas_materiales etapas_materiales_un 
   CONSTRAINT     j   ALTER TABLE ONLY prd.etapas_materiales
    ADD CONSTRAINT etapas_materiales_un UNIQUE (etap_id, arti_id);
 M   ALTER TABLE ONLY prd.etapas_materiales DROP CONSTRAINT etapas_materiales_un;
       prd            postgres    false    288    288                       2606    22371    etapas etapas_pk 
   CONSTRAINT     P   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_pk PRIMARY KEY (etap_id);
 7   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_pk;
       prd            postgres    false    286                       2606    22373 $   etapas_productos etapas_productos_un 
   CONSTRAINT     h   ALTER TABLE ONLY prd.etapas_productos
    ADD CONSTRAINT etapas_productos_un UNIQUE (etap_id, arti_id);
 K   ALTER TABLE ONLY prd.etapas_productos DROP CONSTRAINT etapas_productos_un;
       prd            postgres    false    289    289            7           2606    24617     etapas_salidas etapas_salidas_un 
   CONSTRAINT     d   ALTER TABLE ONLY prd.etapas_salidas
    ADD CONSTRAINT etapas_salidas_un UNIQUE (etap_id, arti_id);
 G   ALTER TABLE ONLY prd.etapas_salidas DROP CONSTRAINT etapas_salidas_un;
       prd            postgres    false    321    321                       2606    22375    etapas etapas_un 
   CONSTRAINT     S   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_un UNIQUE (nombre, proc_id);
 7   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_un;
       prd            postgres    false    286    286                       2606    22377    etapas etapas_un_2 
   CONSTRAINT     T   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_un_2 UNIQUE (orden, proc_id);
 9   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_un_2;
       prd            postgres    false    286    286            9           2606    24619    formulas formulas_pk 
   CONSTRAINT     T   ALTER TABLE ONLY prd.formulas
    ADD CONSTRAINT formulas_pk PRIMARY KEY (form_id);
 ;   ALTER TABLE ONLY prd.formulas DROP CONSTRAINT formulas_pk;
       prd            postgres    false    322                       2606    22379    lotes lotes_un 
   CONSTRAINT     J   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_un UNIQUE (batch_id);
 5   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_un;
       prd            postgres    false    292                       2606    22381 0   movimientos_trasportes movimientos_trasportes_pk 
   CONSTRAINT     p   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_pk PRIMARY KEY (motr_id);
 W   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_pk;
       prd            postgres    false    295                       2606    22383    procesos productos_pk 
   CONSTRAINT     U   ALTER TABLE ONLY prd.procesos
    ADD CONSTRAINT productos_pk PRIMARY KEY (proc_id);
 <   ALTER TABLE ONLY prd.procesos DROP CONSTRAINT productos_pk;
       prd            postgres    false    297                       2606    22385    procesos productos_un 
   CONSTRAINT     O   ALTER TABLE ONLY prd.procesos
    ADD CONSTRAINT productos_un UNIQUE (nombre);
 <   ALTER TABLE ONLY prd.procesos DROP CONSTRAINT productos_un;
       prd            postgres    false    297                       2606    22387    recipientes recipientes_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_pk PRIMARY KEY (reci_id);
 A   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_pk;
       prd            postgres    false    299            !           2606    22389    recursos recursos_pk 
   CONSTRAINT     T   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_pk PRIMARY KEY (recu_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_pk;
       prd            postgres    false    301            #           2606    22391    recursos recursos_un 
   CONSTRAINT     O   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_un UNIQUE (arti_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_un;
       prd            postgres    false    301            +           2606    24402     memberships_users memberships_pk 
   CONSTRAINT     m   ALTER TABLE ONLY seg.memberships_users
    ADD CONSTRAINT memberships_pk PRIMARY KEY ("group", role, email);
 G   ALTER TABLE ONLY seg.memberships_users DROP CONSTRAINT memberships_pk;
       seg            postgres    false    312    312    312            -           2606    24420    menues menues_pk 
   CONSTRAINT     W   ALTER TABLE ONLY seg.menues
    ADD CONSTRAINT menues_pk PRIMARY KEY (modulo, opcion);
 7   ALTER TABLE ONLY seg.menues DROP CONSTRAINT menues_pk;
       seg            postgres    false    313    313            %           2606    24379    tokens tokens_pk 
   CONSTRAINT     K   ALTER TABLE ONLY seg.tokens
    ADD CONSTRAINT tokens_pk PRIMARY KEY (id);
 7   ALTER TABLE ONLY seg.tokens DROP CONSTRAINT tokens_pk;
       seg            postgres    false    309            '           2606    24390    users users_pk 
   CONSTRAINT     I   ALTER TABLE ONLY seg.users
    ADD CONSTRAINT users_pk PRIMARY KEY (id);
 5   ALTER TABLE ONLY seg.users DROP CONSTRAINT users_pk;
       seg            postgres    false    311            )           2606    24392    users users_un 
   CONSTRAINT     G   ALTER TABLE ONLY seg.users
    ADD CONSTRAINT users_un UNIQUE (email);
 5   ALTER TABLE ONLY seg.users DROP CONSTRAINT users_un;
       seg            postgres    false    311            �           1259    24238    equipos_dominio_idx    INDEX     O   CREATE UNIQUE INDEX equipos_dominio_idx ON core.equipos USING btree (dominio);
 %   DROP INDEX core.equipos_dominio_idx;
       core            postgres    false    237            �           1259    24620    tablas_tabla_idx    INDEX     B   CREATE INDEX tablas_tabla_idx ON core.tablas USING btree (tabla);
 "   DROP INDEX core.tablas_tabla_idx;
       core            postgres    false    242            �           1259    24621    tablas_valor_idx    INDEX     B   CREATE INDEX tablas_valor_idx ON core.tablas USING btree (valor);
 "   DROP INDEX core.tablas_valor_idx;
       core            postgres    false    242            �           1259    22392 "   solicitudes_contenedor_case_id_idx    INDEX     e   CREATE INDEX solicitudes_contenedor_case_id_idx ON log.solicitudes_contenedor USING btree (case_id);
 3   DROP INDEX log.solicitudes_contenedor_case_id_idx;
       log            postgres    false    272            �           2620    22393 0   alm_deta_entrega_materiales asociar_lote_hijo_ai    TRIGGER     �   CREATE TRIGGER asociar_lote_hijo_ai AFTER INSERT ON alm.alm_deta_entrega_materiales FOR EACH ROW EXECUTE PROCEDURE prd.asociar_lote_hijo_trg();
 F   DROP TRIGGER asociar_lote_hijo_ai ON alm.alm_deta_entrega_materiales;
       alm          postgres    false    345    210            �           2620    22394    alm_articulos crear_producto_ai    TRIGGER        CREATE TRIGGER crear_producto_ai AFTER INSERT ON alm.alm_articulos FOR EACH ROW EXECUTE PROCEDURE prd.crear_prd_recurso_trg();
 5   DROP TRIGGER crear_producto_ai ON alm.alm_articulos;
       alm          postgres    false    347    206            �           2620    22395 "   alm_articulos eliminar_producto_ad    TRIGGER     �   CREATE TRIGGER eliminar_producto_ad AFTER DELETE ON alm.alm_articulos FOR EACH ROW EXECUTE PROCEDURE prd.eliminar_prd_recurso_trg();
 8   DROP TRIGGER eliminar_producto_ad ON alm.alm_articulos;
       alm          postgres    false    206    348            �           2620    22396    tablas set_tabla_id_bui    TRIGGER        CREATE TRIGGER set_tabla_id_bui BEFORE INSERT OR UPDATE ON core.tablas FOR EACH ROW EXECUTE PROCEDURE core.set_tabla_id_trg();
 .   DROP TRIGGER set_tabla_id_bui ON core.tablas;
       core          postgres    false    327    242            �           2620    24626 &   contenedores_entregados crear_batch_bu    TRIGGER     �   CREATE TRIGGER crear_batch_bu BEFORE UPDATE ON log.contenedores_entregados FOR EACH ROW EXECUTE PROCEDURE log.crear_batch_contenedor_retirado_trg();
 <   DROP TRIGGER crear_batch_bu ON log.contenedores_entregados;
       log          postgres    false    351    262            �           2620    24627 *   solicitantes_transporte crear_proveedor_bi    TRIGGER     �   CREATE TRIGGER crear_proveedor_bi BEFORE INSERT ON log.solicitantes_transporte FOR EACH ROW EXECUTE PROCEDURE log.crear_proveedor_sotr_trg();
 @   DROP TRIGGER crear_proveedor_bi ON log.solicitantes_transporte;
       log          postgres    false    270    352            �           2620    22397    contenedores crear_recipiente    TRIGGER     }   CREATE TRIGGER crear_recipiente BEFORE INSERT ON log.contenedores FOR EACH ROW EXECUTE PROCEDURE prd.crear_prd_recipiente();
 3   DROP TRIGGER crear_recipiente ON log.contenedores;
       log          postgres    false    260    350            :           2606    22398    alm_articulos alm_articulos_fk    FK CONSTRAINT     {   ALTER TABLE ONLY alm.alm_articulos
    ADD CONSTRAINT alm_articulos_fk FOREIGN KEY (tipo) REFERENCES core.tablas(tabl_id);
 E   ALTER TABLE ONLY alm.alm_articulos DROP CONSTRAINT alm_articulos_fk;
       alm          postgres    false    206    242    4298            <           2606    22403 :   alm_deta_entrega_materiales alm_deta_entrega_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_entrega_materiales
    ADD CONSTRAINT alm_deta_entrega_materiales_fk FOREIGN KEY (enma_id) REFERENCES alm.alm_entrega_materiales(enma_id);
 a   ALTER TABLE ONLY alm.alm_deta_entrega_materiales DROP CONSTRAINT alm_deta_entrega_materiales_fk;
       alm          postgres    false    216    4271    210            =           2606    22408 :   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 a   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_fk;
       alm          postgres    false    212    206    4259            >           2606    22413 <   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_fk_1 FOREIGN KEY (pema_id) REFERENCES alm.alm_pedidos_materiales(pema_id);
 c   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_fk_1;
       alm          postgres    false    212    220    4275            ?           2606    24629 F   alm_deta_recepcion_materiales alm_deta_recepcion_materiales_rema_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales
    ADD CONSTRAINT alm_deta_recepcion_materiales_rema_id_fk FOREIGN KEY (rema_id) REFERENCES alm.alm_recepcion_materiales(rema_id);
 m   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales DROP CONSTRAINT alm_deta_recepcion_materiales_rema_id_fk;
       alm          postgres    false    214    4281    225            @           2606    22418 0   alm_entrega_materiales alm_entrega_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_entrega_materiales
    ADD CONSTRAINT alm_entrega_materiales_fk FOREIGN KEY (pema_id) REFERENCES alm.alm_pedidos_materiales(pema_id);
 W   ALTER TABLE ONLY alm.alm_entrega_materiales DROP CONSTRAINT alm_entrega_materiales_fk;
       alm          postgres    false    220    216    4275            ;           2606    22423 %   alm_depositos alm_establecimientos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_depositos
    ADD CONSTRAINT alm_establecimientos_fk FOREIGN KEY (esta_id) REFERENCES prd.establecimientos(esta_id);
 L   ALTER TABLE ONLY alm.alm_depositos DROP CONSTRAINT alm_establecimientos_fk;
       alm          postgres    false    284    4363    208            A           2606    22428    alm_lotes alm_lotes_fk    FK CONSTRAINT     |   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 =   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_fk;
       alm          postgres    false    206    218    4259            B           2606    22433    alm_lotes alm_lotes_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_fk_1 FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 ?   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_fk_1;
       alm          postgres    false    218    222    4277            D           2606    24634    alm_lotes alm_lotes_fk_7    FK CONSTRAINT     x   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_fk_7 FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 ?   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_fk_7;
       alm          postgres    false    218    4375    292            C           2606    22438    alm_lotes alm_lotes_lotes_fk    FK CONSTRAINT     |   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 C   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_lotes_fk;
       alm          postgres    false    4375    292    218            E           2606    24740 9   alm_pedidos_materiales alm_pedidos_materiales_batch_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_pedidos_materiales
    ADD CONSTRAINT alm_pedidos_materiales_batch_id_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 `   ALTER TABLE ONLY alm.alm_pedidos_materiales DROP CONSTRAINT alm_pedidos_materiales_batch_id_fk;
       alm          postgres    false    220    4375    292            F           2606    22443 6   alm_proveedores_articulos alm_proveedores_articulos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 ]   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_fk;
       alm          postgres    false    223    4259    206            G           2606    22448 8   alm_proveedores_articulos alm_proveedores_articulos_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_fk_1 FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 _   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_fk_1;
       alm          postgres    false    222    4277    223            H           2606    22453 4   alm_recepcion_materiales alm_recepcion_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_recepcion_materiales
    ADD CONSTRAINT alm_recepcion_materiales_fk FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 [   ALTER TABLE ONLY alm.alm_recepcion_materiales DROP CONSTRAINT alm_recepcion_materiales_fk;
       alm          postgres    false    222    4277    225            I           2606    22458 $   deta_ajustes deta_ajustes_ajustes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_ajustes_fk FOREIGN KEY (ajus_id) REFERENCES alm.ajustes(ajus_id);
 K   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_ajustes_fk;
       alm          postgres    false    204    227    4257            J           2606    22463 &   deta_ajustes deta_ajustes_alm_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_alm_lotes_fk FOREIGN KEY (lote_id) REFERENCES alm.alm_lotes(lote_id);
 M   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_alm_lotes_fk;
       alm          postgres    false    4273    218    227            L           2606    24249    equipos equipos_equi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY core.equipos
    ADD CONSTRAINT equipos_equi_id_fk FOREIGN KEY (cont_id) REFERENCES log.contenedores(cont_id);
 B   ALTER TABLE ONLY core.equipos DROP CONSTRAINT equipos_equi_id_fk;
       core          postgres    false    237    4326    260            K           2606    24239    equipos equipos_tran_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY core.equipos
    ADD CONSTRAINT equipos_tran_id_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 B   ALTER TABLE ONLY core.equipos DROP CONSTRAINT equipos_tran_id_fk;
       core          postgres    false    4355    237    279            M           2606    22468    zonas zonas_fk    FK CONSTRAINT     v   ALTER TABLE ONLY core.zonas
    ADD CONSTRAINT zonas_fk FOREIGN KEY (depa_id) REFERENCES core.departamentos(depa_id);
 6   ALTER TABLE ONLY core.zonas DROP CONSTRAINT zonas_fk;
       core          postgres    false    233    4289    243            N           2606    22473 +   actas_infraccion solicitantes_transporte_fk    FK CONSTRAINT     �   ALTER TABLE ONLY fis.actas_infraccion
    ADD CONSTRAINT solicitantes_transporte_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 R   ALTER TABLE ONLY fis.actas_infraccion DROP CONSTRAINT solicitantes_transporte_fk;
       fis          postgres    false    4342    270    245            O           2606    22478 "   actas_infraccion transportistas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY fis.actas_infraccion
    ADD CONSTRAINT transportistas_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 I   ALTER TABLE ONLY fis.actas_infraccion DROP CONSTRAINT transportistas_fk;
       fis          postgres    false    4355    245    279            P           2606    22483 "   incidencias incidencias_difi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY ins.incidencias
    ADD CONSTRAINT incidencias_difi_id_fk FOREIGN KEY (difi_id) REFERENCES core.tablas(tabl_id);
 I   ALTER TABLE ONLY ins.incidencias DROP CONSTRAINT incidencias_difi_id_fk;
       ins          postgres    false    4298    242    253            Q           2606    22488 "   incidencias incidencias_ortr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY ins.incidencias
    ADD CONSTRAINT incidencias_ortr_id_fk FOREIGN KEY (ortr_id) REFERENCES log.ordenes_transporte(ortr_id);
 I   ALTER TABLE ONLY ins.incidencias DROP CONSTRAINT incidencias_ortr_id_fk;
       ins          postgres    false    253    266    4336            S           2606    22906 "   incidencias incidencias_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY ins.incidencias
    ADD CONSTRAINT incidencias_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 I   ALTER TABLE ONLY ins.incidencias DROP CONSTRAINT incidencias_tica_id_fk;
       ins          postgres    false    242    4298    253            R           2606    22493 "   incidencias incidencias_tiin_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY ins.incidencias
    ADD CONSTRAINT incidencias_tiin_id_fk FOREIGN KEY (tiin_id) REFERENCES core.tablas(tabl_id);
 I   ALTER TABLE ONLY ins.incidencias DROP CONSTRAINT incidencias_tiin_id_fk;
       ins          postgres    false    242    253    4298            T           2606    22503    choferes choferes_cach_id_fk    FK CONSTRAINT     |   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_cach_id_fk FOREIGN KEY (cach_id) REFERENCES core.tablas(tabl_id);
 C   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_cach_id_fk;
       log          postgres    false    4298    242    255            U           2606    22508    choferes choferes_tran_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_tran_id_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 C   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_tran_id_fk;
       log          postgres    false    279    4355    255            �           2606    24644 8   cierre_sector_descarga cierre_sector_descarga_cisc_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.cierre_sector_descarga
    ADD CONSTRAINT cierre_sector_descarga_cisc_id_fk FOREIGN KEY (cisd_id) REFERENCES core.tablas(tabl_id);
 _   ALTER TABLE ONLY log.cierre_sector_descarga DROP CONSTRAINT cierre_sector_descarga_cisc_id_fk;
       log          postgres    false    4298    242    320            W           2606    22513 6   circuitos_puntos_criticos circuitos_puntos_criticos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_fk FOREIGN KEY (circ_id) REFERENCES log.circuitos(circ_id);
 ]   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_fk;
       log          postgres    false    259    257    4318            X           2606    22518 8   circuitos_puntos_criticos circuitos_puntos_criticos_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_fk_1 FOREIGN KEY (pucr_id) REFERENCES log.puntos_criticos(pucr_id);
 _   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_fk_1;
       log          postgres    false    4338    259    268            V           2606    22523    circuitos circuitos_zona_id_fk    FK CONSTRAINT     }   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 E   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_zona_id_fk;
       log          postgres    false    243    257    4302            Y           2606    22528    contenedores containers_fk    FK CONSTRAINT     z   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_fk FOREIGN KEY (esco_id) REFERENCES core.tablas(tabl_id);
 A   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_fk;
       log          postgres    false    4298    242    260            Z           2606    22533 "   contenedores containers_reci_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_reci_id_fk FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 I   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_reci_id_fk;
       log          postgres    false    260    299    4383            d           2606    24754 ;   contenedores_entregados contenedores_entregados_batch_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_batch_id_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 b   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_batch_id_fk;
       log          postgres    false    292    4375    262            \           2606    22538 :   contenedores_entregados contenedores_entregados_cont_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_cont_id_fk FOREIGN KEY (cont_id) REFERENCES log.contenedores(cont_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_cont_id_fk;
       log          postgres    false    260    262    4326            a           2606    24228 9   contenedores_entregados contenedores_entregados_depo_idfk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_depo_idfk FOREIGN KEY (depo_id) REFERENCES alm.alm_depositos(depo_id);
 `   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_depo_idfk;
       log          postgres    false    4263    208    262            c           2606    24244 B   contenedores_entregados contenedores_entregados_equi_id_entrega_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_equi_id_entrega_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 i   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_equi_id_entrega_fk;
       log          postgres    false    237    262    4294            b           2606    24233 :   contenedores_entregados contenedores_entregados_equi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_equi_id_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_equi_id_fk;
       log          postgres    false    4294    237    262            ]           2606    22543 :   contenedores_entregados contenedores_entregados_ortr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_ortr_id_fk FOREIGN KEY (ortr_id) REFERENCES log.ordenes_transporte(ortr_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_ortr_id_fk;
       log          postgres    false    262    4336    266            ^           2606    22548 :   contenedores_entregados contenedores_entregados_soco_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_soco_id_fk FOREIGN KEY (soco_id) REFERENCES log.solicitudes_contenedor(soco_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_soco_id_fk;
       log          postgres    false    272    4347    262            _           2606    22553 :   contenedores_entregados contenedores_entregados_sore_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_sore_id_fk FOREIGN KEY (sore_id) REFERENCES log.solicitudes_retiro(sore_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_sore_id_fk;
       log          postgres    false    275    4349    262            `           2606    22558 :   contenedores_entregados contenedores_entregados_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_tica_id_fk;
       log          postgres    false    4298    242    262            e           2606    24759 :   contenedores_entregados contenedores_entregados_tiva_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_tiva_id_fk FOREIGN KEY (tiva_id) REFERENCES core.tablas(tabl_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_tiva_id_fk;
       log          postgres    false    262    4298    242            [           2606    22563    contenedores contenedores_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT contenedores_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 C   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT contenedores_fk;
       log          postgres    false    260    4355    279            f           2606    22568 <   contenedores_solicitados contenedores_solicitados_soco_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_solicitados
    ADD CONSTRAINT contenedores_solicitados_soco_id_fk FOREIGN KEY (soco_id) REFERENCES log.solicitudes_contenedor(soco_id);
 c   ALTER TABLE ONLY log.contenedores_solicitados DROP CONSTRAINT contenedores_solicitados_soco_id_fk;
       log          postgres    false    272    4347    265            g           2606    22573 ?   contenedores_solicitados deta_solicitudes_contenedor_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_solicitados
    ADD CONSTRAINT deta_solicitudes_contenedor_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 f   ALTER TABLE ONLY log.contenedores_solicitados DROP CONSTRAINT deta_solicitudes_contenedor_tica_id_fk;
       log          postgres    false    242    265    4298            h           2606    22578 0   ordenes_transporte ordenes_transporte_chof_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_chof_id_fk FOREIGN KEY (chof_id) REFERENCES log.choferes(documento);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_chof_id_fk;
       log          postgres    false    4314    255    266            i           2606    22583 0   ordenes_transporte ordenes_transporte_difi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_difi_id_fk FOREIGN KEY (difi_id) REFERENCES core.tablas(tabl_id);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_difi_id_fk;
       log          postgres    false    4298    242    266            j           2606    22588 0   ordenes_transporte ordenes_transporte_equi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_equi_id_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_equi_id_fk;
       log          postgres    false    237    4294    266            l           2606    24792 (   ordenes_transporte ordenes_transporte_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 O   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_fk;
       log          postgres    false    266    279    4355            k           2606    22593 0   ordenes_transporte ordenes_transporte_sotr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_sotr_id_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_sotr_id_fk;
       log          postgres    false    270    4342    266            m           2606    24797 0   ordenes_transporte ordenes_transporte_teot_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_teot_id_fk FOREIGN KEY (teot_id) REFERENCES log.templates_orden_transporte(teot_id);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_teot_id_fk;
       log          postgres    false    4399    266    316            n           2606    22598 *   puntos_criticos puntos_criticos_zona_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 Q   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_zona_id_fk;
       log          postgres    false    243    268    4302            o           2606    22603 9   solicitantes_transporte solcitantes_transporte_rubr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_rubr_id_fk FOREIGN KEY (rubr_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_rubr_id_fk;
       log          postgres    false    4298    270    242            p           2606    22613 9   solicitantes_transporte solcitantes_transporte_tisr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_tisr_id_fk FOREIGN KEY (tist_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_tisr_id_fk;
       log          postgres    false    270    242    4298            q           2606    22618 9   solicitantes_transporte solcitantes_transporte_zona_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_zona_id_fk;
       log          postgres    false    243    270    4302            r           2606    22623 :   solicitantes_transporte solicitantes_transporte_depa_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solicitantes_transporte_depa_id_fk FOREIGN KEY (depa_id) REFERENCES core.departamentos(depa_id);
 a   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solicitantes_transporte_depa_id_fk;
       log          postgres    false    270    4289    233            s           2606    24765 2   solicitantes_transporte solicitantes_transporte_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solicitantes_transporte_fk FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 Y   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solicitantes_transporte_fk;
       log          postgres    false    222    270    4277            t           2606    24770 8   solicitantes_transporte solicitantes_transporte_users_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solicitantes_transporte_users_fk FOREIGN KEY (user_id) REFERENCES seg.users(email);
 _   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solicitantes_transporte_users_fk;
       log          postgres    false    270    4393    311            u           2606    22628 0   solicitudes_contenedor solicitudes_contenedor_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedor_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 W   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedor_fk;
       log          postgres    false    272    4342    270            v           2606    23463 8   solicitudes_contenedor solicitudes_contenedor_tran_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedor_tran_id_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 _   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedor_tran_id_fk;
       log          postgres    false    272    4355    279            w           2606    22913 0   solicitudes_retiro solicitudes_retiro_sotr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitudes_retiro
    ADD CONSTRAINT solicitudes_retiro_sotr_id_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 W   ALTER TABLE ONLY log.solicitudes_retiro DROP CONSTRAINT solicitudes_retiro_sotr_id_fk;
       log          postgres    false    270    275    4342            �           2606    24459 @   templates_orden_transporte templates_orden_transporte_chof_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.templates_orden_transporte
    ADD CONSTRAINT templates_orden_transporte_chof_id_fk FOREIGN KEY (chof_id) REFERENCES log.choferes(documento);
 g   ALTER TABLE ONLY log.templates_orden_transporte DROP CONSTRAINT templates_orden_transporte_chof_id_fk;
       log          postgres    false    316    255    4314            �           2606    24464 @   templates_orden_transporte templates_orden_transporte_circ_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.templates_orden_transporte
    ADD CONSTRAINT templates_orden_transporte_circ_id_fk FOREIGN KEY (circ_id) REFERENCES log.circuitos(circ_id);
 g   ALTER TABLE ONLY log.templates_orden_transporte DROP CONSTRAINT templates_orden_transporte_circ_id_fk;
       log          postgres    false    316    257    4318            �           2606    24469 @   templates_orden_transporte templates_orden_transporte_difi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.templates_orden_transporte
    ADD CONSTRAINT templates_orden_transporte_difi_id_fk FOREIGN KEY (difi_id) REFERENCES core.tablas(tabl_id);
 g   ALTER TABLE ONLY log.templates_orden_transporte DROP CONSTRAINT templates_orden_transporte_difi_id_fk;
       log          postgres    false    316    242    4298            �           2606    24474 @   templates_orden_transporte templates_orden_transporte_equi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.templates_orden_transporte
    ADD CONSTRAINT templates_orden_transporte_equi_id_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 g   ALTER TABLE ONLY log.templates_orden_transporte DROP CONSTRAINT templates_orden_transporte_equi_id_fk;
       log          postgres    false    4294    237    316            �           2606    24479 @   templates_orden_transporte templates_orden_transporte_sotr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.templates_orden_transporte
    ADD CONSTRAINT templates_orden_transporte_sotr_id_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 g   ALTER TABLE ONLY log.templates_orden_transporte DROP CONSTRAINT templates_orden_transporte_sotr_id_fk;
       log          postgres    false    4342    270    316            �           2606    24484 @   templates_orden_transporte templates_orden_transporte_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.templates_orden_transporte
    ADD CONSTRAINT templates_orden_transporte_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 g   ALTER TABLE ONLY log.templates_orden_transporte DROP CONSTRAINT templates_orden_transporte_tica_id_fk;
       log          postgres    false    4298    316    242            x           2606    22638 6   tipos_carga_circuitos tipos_carga_circuitos_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_carga_circuitos_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 ]   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_carga_circuitos_tica_id_fk;
       log          postgres    false    242    276    4298            z           2606    22643 <   tipos_carga_contenedores tipos_carga_contenedores_cont_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_contenedores
    ADD CONSTRAINT tipos_carga_contenedores_cont_id_fk FOREIGN KEY (cont_id) REFERENCES log.contenedores(cont_id);
 c   ALTER TABLE ONLY log.tipos_carga_contenedores DROP CONSTRAINT tipos_carga_contenedores_cont_id_fk;
       log          postgres    false    4326    277    260            �           2606    23474 :   tipos_carga_generadores tipos_carga_generadores_sotr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_generadores
    ADD CONSTRAINT tipos_carga_generadores_sotr_id_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 a   ALTER TABLE ONLY log.tipos_carga_generadores DROP CONSTRAINT tipos_carga_generadores_sotr_id_fk;
       log          postgres    false    270    4342    304            �           2606    23479 :   tipos_carga_generadores tipos_carga_generadores_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_generadores
    ADD CONSTRAINT tipos_carga_generadores_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 a   ALTER TABLE ONLY log.tipos_carga_generadores DROP CONSTRAINT tipos_carga_generadores_tica_id_fk;
       log          postgres    false    304    4298    242            {           2606    22648 8   tipos_carga_transportistas tipos_carga_transportistas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 _   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_fk;
       log          postgres    false    278    4355    279            |           2606    22653 @   tipos_carga_transportistas tipos_carga_transportistas_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 g   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_tica_id_fk;
       log          postgres    false    278    4298    242            y           2606    22658 0   tipos_carga_circuitos tipos_residuo_circuitos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_residuo_circuitos_fk FOREIGN KEY (circ_id) REFERENCES log.circuitos(circ_id);
 W   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_residuo_circuitos_fk;
       log          postgres    false    257    4318    276            }           2606    24775 &   transportistas transportistas_users_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.transportistas
    ADD CONSTRAINT transportistas_users_fk FOREIGN KEY (user_id) REFERENCES seg.users(email);
 M   ALTER TABLE ONLY log.transportistas DROP CONSTRAINT transportistas_users_fk;
       log          postgres    false    279    4393    311            ~           2606    22663    costos costos_recursos_fk    FK CONSTRAINT     z   ALTER TABLE ONLY prd.costos
    ADD CONSTRAINT costos_recursos_fk FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id);
 @   ALTER TABLE ONLY prd.costos DROP CONSTRAINT costos_recursos_fk;
       prd          postgres    false    4385    281    301            �           2606    22668    fraccionamientos empa_id    FK CONSTRAINT     x   ALTER TABLE ONLY prd.fraccionamientos
    ADD CONSTRAINT empa_id FOREIGN KEY (empa_id) REFERENCES prd.empaque(empa_id);
 ?   ALTER TABLE ONLY prd.fraccionamientos DROP CONSTRAINT empa_id;
       prd          postgres    false    282    290    4361            �           2606    22673 "   etapas_materiales etapa-arti_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_materiales
    ADD CONSTRAINT "etapa-arti_id_fk" FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 K   ALTER TABLE ONLY prd.etapas_materiales DROP CONSTRAINT "etapa-arti_id_fk";
       prd          postgres    false    288    4259    206            �           2606    24649 .   etapas_materiales etapas_materiales_arti_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_materiales
    ADD CONSTRAINT etapas_materiales_arti_id_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 U   ALTER TABLE ONLY prd.etapas_materiales DROP CONSTRAINT etapas_materiales_arti_id_fk;
       prd          postgres    false    288    206    4259            �           2606    24654 .   etapas_materiales etapas_materiales_etap_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_materiales
    ADD CONSTRAINT etapas_materiales_etap_id_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id);
 U   ALTER TABLE ONLY prd.etapas_materiales DROP CONSTRAINT etapas_materiales_etap_id_fk;
       prd          postgres    false    288    4365    286                       2606    22678    etapas etapas_procesos_fk    FK CONSTRAINT     z   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_procesos_fk FOREIGN KEY (proc_id) REFERENCES prd.procesos(proc_id);
 @   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_procesos_fk;
       prd          postgres    false    4379    297    286            �           2606    24659 ,   etapas_productos etapas_productos_arti_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_productos
    ADD CONSTRAINT etapas_productos_arti_id_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 S   ALTER TABLE ONLY prd.etapas_productos DROP CONSTRAINT etapas_productos_arti_id_fk;
       prd          postgres    false    206    289    4259            �           2606    24664 ,   etapas_productos etapas_productos_etap_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_productos
    ADD CONSTRAINT etapas_productos_etap_id_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id);
 S   ALTER TABLE ONLY prd.etapas_productos DROP CONSTRAINT etapas_productos_etap_id_fk;
       prd          postgres    false    286    289    4365            �           2606    24669 (   etapas_salidas etapas_salidas_etap_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_salidas
    ADD CONSTRAINT etapas_salidas_etap_id_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id);
 O   ALTER TABLE ONLY prd.etapas_salidas DROP CONSTRAINT etapas_salidas_etap_id_fk;
       prd          postgres    false    4365    321    286            �           2606    24674     etapas_salidas etapas_salidas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_salidas
    ADD CONSTRAINT etapas_salidas_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 G   ALTER TABLE ONLY prd.etapas_salidas DROP CONSTRAINT etapas_salidas_fk;
       prd          postgres    false    206    321    4259            �           2606    24679 1   formulas_articulos formulas_articulos__unme_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.formulas_articulos
    ADD CONSTRAINT formulas_articulos__unme_id_fk FOREIGN KEY (unme_id) REFERENCES core.tablas(tabl_id);
 X   ALTER TABLE ONLY prd.formulas_articulos DROP CONSTRAINT formulas_articulos__unme_id_fk;
       prd          postgres    false    323    242    4298            �           2606    24684 0   formulas_articulos formulas_articulos_arti_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.formulas_articulos
    ADD CONSTRAINT formulas_articulos_arti_id_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 W   ALTER TABLE ONLY prd.formulas_articulos DROP CONSTRAINT formulas_articulos_arti_id_fk;
       prd          postgres    false    206    323    4259            �           2606    24689 0   formulas_articulos formulas_articulos_form_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.formulas_articulos
    ADD CONSTRAINT formulas_articulos_form_id_fk FOREIGN KEY (form_id) REFERENCES prd.formulas(form_id);
 W   ALTER TABLE ONLY prd.formulas_articulos DROP CONSTRAINT formulas_articulos_form_id_fk;
       prd          postgres    false    4409    323    322            �           2606    24694    formulas formulas_unme_id_fk    FK CONSTRAINT     |   ALTER TABLE ONLY prd.formulas
    ADD CONSTRAINT formulas_unme_id_fk FOREIGN KEY (unme_id) REFERENCES core.tablas(tabl_id);
 C   ALTER TABLE ONLY prd.formulas DROP CONSTRAINT formulas_unme_id_fk;
       prd          postgres    false    4298    322    242            �           2606    24699    lotes lotes_alm_articulos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_alm_articulos_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 C   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_alm_articulos_fk;
       prd          postgres    false    4259    292    206            �           2606    22683    lotes lotes_etapas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_etapas_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id) ON DELETE RESTRICT;
 <   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_etapas_fk;
       prd          postgres    false    4365    286    292            �           2606    22688    lotes lotes_fk    FK CONSTRAINT     t   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 5   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_fk;
       prd          postgres    false    292    4259    206            �           2606    22693     lotes_hijos lotes_hijos_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_hijos
    ADD CONSTRAINT lotes_hijos_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 G   ALTER TABLE ONLY prd.lotes_hijos DROP CONSTRAINT lotes_hijos_lotes_fk;
       prd          postgres    false    292    294    4375            �           2606    22698 '   lotes_hijos lotes_hijos_lotes_padres_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_hijos
    ADD CONSTRAINT lotes_hijos_lotes_padres_fk FOREIGN KEY (batch_id_padre) REFERENCES prd.lotes(batch_id);
 N   ALTER TABLE ONLY prd.lotes_hijos DROP CONSTRAINT lotes_hijos_lotes_padres_fk;
       prd          postgres    false    294    292    4375            �           2606    22703    lotes lotes_recipientes_fk    FK CONSTRAINT     ~   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_recipientes_fk FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 A   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_recipientes_fk;
       prd          postgres    false    4383    299    292            �           2606    24704 1   lotes_responsables lotes_responsables_batch_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_responsables
    ADD CONSTRAINT lotes_responsables_batch_id_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 X   ALTER TABLE ONLY prd.lotes_responsables DROP CONSTRAINT lotes_responsables_batch_id_fk;
       prd          postgres    false    325    4375    292            �           2606    24709 0   lotes_responsables lotes_responsables_turn_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_responsables
    ADD CONSTRAINT lotes_responsables_turn_id_fk FOREIGN KEY (turn_id) REFERENCES core.tablas(tabl_id);
 W   ALTER TABLE ONLY prd.lotes_responsables DROP CONSTRAINT lotes_responsables_turn_id_fk;
       prd          postgres    false    325    4298    242            �           2606    24714 0   lotes_responsables lotes_responsables_user_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_responsables
    ADD CONSTRAINT lotes_responsables_user_id_fk FOREIGN KEY (user_id) REFERENCES seg.users(id);
 W   ALTER TABLE ONLY prd.lotes_responsables DROP CONSTRAINT lotes_responsables_user_id_fk;
       prd          postgres    false    325    311    4391            �           2606    24719 ?   movimientos_trasportes movimientos_trasportes__transportista_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes__transportista_fk FOREIGN KEY (cuit) REFERENCES core.transportistas(cuit);
 f   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes__transportista_fk;
       prd          postgres    false    295    4403    319            �           2606    22713 0   movimientos_trasportes movimientos_trasportes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 W   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk;
       prd          postgres    false    4277    222    295            �           2606    22718 2   movimientos_trasportes movimientos_trasportes_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk_1 FOREIGN KEY (esta_id) REFERENCES prd.establecimientos(esta_id);
 Y   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk_1;
       prd          postgres    false    4363    295    284            �           2606    22723 2   movimientos_trasportes movimientos_trasportes_fk_2    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk_2 FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 Y   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk_2;
       prd          postgres    false    4383    295    299            �           2606    22728 (   recipientes recipientes_alm_depositos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_alm_depositos_fk FOREIGN KEY (depo_id) REFERENCES alm.alm_depositos(depo_id);
 O   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_alm_depositos_fk;
       prd          postgres    false    208    4263    299            �           2606    24786 "   recipientes recipientes_care_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_care_id_fk FOREIGN KEY (care_id) REFERENCES core.tablas(tabl_id);
 I   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_care_id_fk;
       prd          postgres    false    242    4298    299            �           2606    22733    recipientes recipientes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_fk FOREIGN KEY (motr_id) REFERENCES prd.movimientos_trasportes(motr_id);
 A   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_fk;
       prd          postgres    false    295    4377    299            �           2606    22738    fraccionamientos recu_id    FK CONSTRAINT     y   ALTER TABLE ONLY prd.fraccionamientos
    ADD CONSTRAINT recu_id FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id);
 ?   ALTER TABLE ONLY prd.fraccionamientos DROP CONSTRAINT recu_id;
       prd          postgres    false    290    301    4385            �           2606    22743    recursos recursos_fk    FK CONSTRAINT     u   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_fk;
       prd          postgres    false    301    4294    237            �           2606    22748 &   recursos_lotes recursos_lotes_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recursos_lotes
    ADD CONSTRAINT recursos_lotes_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id) ON DELETE RESTRICT;
 M   ALTER TABLE ONLY prd.recursos_lotes DROP CONSTRAINT recursos_lotes_lotes_fk;
       prd          postgres    false    302    4375    292            �           2606    22753 )   recursos_lotes recursos_lotes_recursos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recursos_lotes
    ADD CONSTRAINT recursos_lotes_recursos_fk FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id) ON DELETE RESTRICT;
 P   ALTER TABLE ONLY prd.recursos_lotes DROP CONSTRAINT recursos_lotes_recursos_fk;
       prd          postgres    false    302    301    4385            �           2606    24434 6   memberships_menues memberships_menues_modulo_opcion_fk    FK CONSTRAINT     �   ALTER TABLE ONLY seg.memberships_menues
    ADD CONSTRAINT memberships_menues_modulo_opcion_fk FOREIGN KEY (modulo, opcion) REFERENCES seg.menues(modulo, opcion);
 ]   ALTER TABLE ONLY seg.memberships_menues DROP CONSTRAINT memberships_menues_modulo_opcion_fk;
       seg          postgres    false    313    314    313    4397    314            �           2606    24403 &   memberships_users memberships_users_fk    FK CONSTRAINT     �   ALTER TABLE ONLY seg.memberships_users
    ADD CONSTRAINT memberships_users_fk FOREIGN KEY (email) REFERENCES seg.users(email);
 M   ALTER TABLE ONLY seg.memberships_users DROP CONSTRAINT memberships_users_fk;
       seg          postgres    false    311    312    4393            �           2606    24421    menues menues_opcion_padre_fk    FK CONSTRAINT     �   ALTER TABLE ONLY seg.menues
    ADD CONSTRAINT menues_opcion_padre_fk FOREIGN KEY (modulo, opcion_padre) REFERENCES seg.menues(modulo, opcion);
 D   ALTER TABLE ONLY seg.menues DROP CONSTRAINT menues_opcion_padre_fk;
       seg          postgres    false    313    4397    313    313    313            ,   _   x�3�tq��	u����NUHI-+M�)K�S ��̔�b���Ԃ�|��������9��J3�89�-u�tL9�KҋR��L�l^� ��4�      .   �  x����N�Hǯ�S��V������ @A�,
�Z�z3$��x��S��Va_l�x�l���H+!pBr~��=�er{Fɭ[�EaWh����O���կ��������4Cg���l��»�M/_�]g(|��W�hV������u�~��x��]'^2B�#J�8E4͈Ʉ����g��*xO�;����)�x��1<��4�-%��O���J��%k�(�&��+k���?z�˪���㤰�̣��p�,����qS�e��,�s)%��u�1�xk���~��,#��"��5��'@rB�䫌(,�����|��#~i����9��gQ�"�c�
\��t����\��{dl�����s�_�Ǹ�H&6��F� ��\�=���)�3GW�*?D7ź�h��Z�EOK�� k����,��R�zh����x�m!�-���O�DfBa�D��VK.Λ����ޕs�X�����lm�W}�u)Z��"W>�j��v���.�JV;��MF	�F*�Z>�|��{;���#�/�Y>��������!z^?{t���_
���/�#<�,<�j�e7*���LB�r�IE������W9�d�c�� ]��(G$o|���e��0�N��ɖ��r�fuT�ܤ$<b�ڲ�|RXW�fG��G`����Kh�"3.1�T�.F29�}r|7�<��݂���M�>���e�oc� ��P(�`e�t��T�&�x��B=wU���*��sp�ѕ;#�j aJ��40 [��  ���j��1�����W�p�k�zс�D�q�S*X���ٕ�I�x���79�J�Ի���n����r&Xi�Ӷ~D��L�T��;�P)O�i�3y�a��|���#��4�0be*y[�F�����W�0�fc�$����̴sC��ag�-ζOh�e�N���-�E�@ߠ� ��S&8E�ҺM��#�[��b��ijJB3�TG����4��8�\8rQ�e
g϶��w�nXg�`u��aLJ�Ѷ�T�cv9?�����c��z:1i�p؉�����S��������,Ct��p��\(Յ�4l80��f�؜b-����{��8v8�@�wSE�n�l/����6B��*N4��b�ql!��uD�u���b/�Ö�Y�T;aUFT�����PkLk���'ꬽ-�h�.��$��f�	�2C�d���.lʭ�	\�J�3����ܐ(�]6G�6e�kl�ڳ]�[�-�j.n�Y�]:Lc�'�m���ڮFYӰn0W�����$>      0   �   x�}��
�0���S��'m��/��c/�F���ľ?�[�;�̐8�1?Ӕ���!�5�&��
�*6�$nb� �R��_�� �x�	��ZB���쨁��u��i��~�������q�C,��j�J�J�Ә�0���-�@kE��s�ڥ�J߲Z#�|JHf      2      x������ � �      4      x������ � �      6   V   x�m͹� D�xU���Q��,;"�俙UcM=���I$�^���(5{7<�ۇ}�r��؏�#t=�;3{蕉��v�      8      x������ � �      :      x������ � �      <      x������ � �      >   �   x��˱
�0 �������\�6٪qiK'A
V���~����G�L���$ ð��RP��Qb�6D�:'��� ���f5N����<�kDYj��д��,Wu{�T۲��ϝuJ$�H&Z��g���u7�Ǜ,��������t*$eX��6��:#6�����Bq      ?      x������ � �      A   A   x�3�420��54�50R00�#΢��Ԃ����NC DRbhdelbeh�glaę������� *@�      C      x������ � �      E      x������ � �      G   �  x���[n�0E��UpR9�&�[i��I�G���ll���@��n���X�V!$�`�@�{�șK ��V�2M�7���ٜ?�@��bRA�L��	�}df���v������5��p��6MK �A � U��1�^�*�덊3����*�U�*�U�Ք���B��M��g�tmWk��7��OM�������S�T,	%c�'�y[7Jۺq��c�����Һ������9NA�eV��8Y�hC_պ�N��8X��O�������?��Й�.�������ܷZ���`���A�F���1U��A�����Q(��l����#'��&�~і����c����<��6�5���v'c*�V�ڝ��+G��ִoyC����B��}����t��6e��6>��-(D*���P$1:���d�)��      I   t   x�3�tN,�,I��LI-(�WH���t�t�8�KҋR���8�3K�J�l*�9s��R��j�\l�-8��J|J�3��E����,KLI,��@𱩏���� /EH�      K      x�3�tL/�Wp����#q��qqq ��      M      x������ � �      O      x�����,�420��54�50����� D�      P      x������ � �      R   +  x����n�8ǯݧ���'��0#����Vڋ�����I���($�v%��9��o;�����y��xk
�<�@�_�n4j|�ʨ\5m�W�b�M	�1!�ı�E�D*�I���5�=5�Io�iʼ=���6����̿^��9�&��D�da�ۣ˽�T.)�$�0fa�O��T��)�ʁ�}�$#a��e��b{���y��yQ�7�q��E	=zQ�z�7�o��#�>"��8��E3�2���<���^I=��ǥ���O0wO\ore�jU������+}��2�5�,@��\Om�����(&�C�%�Ũdw����&$�����j�SU!�/gH%��Fi�yTj}(sxUSԛƨ�>i�?�
̧R��e�.��A>�b�{����ʮ��-�'Qʱ�6�6�dUl����c��'��~I�n�O�7{ ��u{*̱0�vǇzΡ
d'�2()�Ҍ����n�-�FTz��71��K�����kq����6`2<!���Oq�ď�C-8�N�.�n@�8���������Ы�U���ԟmy�ܜ^!qj�o꿤�h�vo�bF]{M��)f6>c��4{�
 /��V=���%�계uq0{]�����8�2�/O.���|3S�h���}ˉ~��䊷�]��&
������)0������a2�j���m	���=�j��3��}�Fd�.AF�8��1�>��d* ���+/�ܕ�}����{"�?2|��-�K��G������=B�Ŭ?�H0$�D>j�=�48��4&ZY�`x���� ǅ�>G����jr�0��M��hР?kd� �����}5{]��	����t(d(��7�r�R�SlZx��?V���O���@�#F	IFE���/���J��2�	I�������,�^���9Gux�l�����w6teg��^YOc[�`�RǢjt��QLM�h�R��u=�B<��d�R�`Ǝ僶ZC��嶀/u�V�:�쪈s 3;�a�%�\��ec
[�a����_�1!k�1�)M�mE�i�
�H����������      �      x������ � �      �      x������ � �      S      x��ˮeI�]��_��/_���I5}���Y$AHPCd�Eݨ�̈�콗?��Ǵ���?�o�k������������������O���,���kϹ?e��[�O^}��G=g��~�'<_��׾|������������"�����������������*�O���;����g>��3��?~m��,�t|�������?O����?I��{��^��)_m������Ι.Oན���T�����7D��w}|������_/����O�)��ʆ��~:���߿���}���ǟF�����8.|>���/%��)��3_L����R+�]_(�czӗr*-,�?��������M�-��Wr��q�񎯔����Rkjq��{�?�?�����O�_=�S~?O���\��x������~2x">�:�'���C���J��<��yy��a����'.o��=����+}<�;^�Z����U���čؽ�ƞ����߯<G��~w�Z8��M���I�_:�c�_����N��{��#�立�����|�8/���'�9��՟wmϙ�%�)�����3���燙�`����}_�ܿ�e�__��N��~������Ҝ�)���~/�����1���C��s�G{s��㯈�x��:v�U�.�[b�O5����}�ZV,�o����|%���};����~��yߏE�����~�7�Y����q}�7�+�q6f�a��i�GX'��m�b>o[iŝK^E��;��Y>ש}������F^+�Nm��	;�.�6ki{u�|���s�[���j�k�K�_.��o{��=f]u�h�i��U�u��Ɣ%�z��r��>V�;��Ք�����ŧZ��lڱ0~;p����tV����˷6�f��}����'7gǒY i�����W��O�o0���6��o�7��xwk<��Q_o�]�,q'?\�9ڷ[۸��95��X�w�]fl|�w�8�1KaWX������v������	x��`�S{��z���H_\o{6��Ծ8������r�X�)�+�y2^a���c0Vγ��a�e��&{��g[�}�y��<k����$ރwy��/R�]�zzL�������w\�����_G3�y��z��>f�  �b~�.�]�|�H_�Ӗ�X�=�lm���pXH�儕z	���O�X�
.�^����'�:x�����Z�e�̣����=���w(O��͑�Y�=�X�����
�������l6�\�8G]sm�lh9��_-�}����;p�ـīs9_\` #Ɂȃ��$.6�%�Vi_J�;2�u>���p��D���4��eu��Rv�i����q��O����)���jz���m�)��� ;��k�͢V���_`��WΛSv����xn}y�U�R�/&�h�ڇ��[L���1`5_!�J㑁*�k�֋G��oJ#W\ϡc�6�����׹�_�k�x�C�RIK�ï�`}��vx��3��p"�y�����_�@���Ngw`2x���\{�̣�9mEn��gbj�΋sYy��ǩc��ʳ��q���;�^r���1q�3{í���F� ~Fn@�Z�^w�CPq�k�+��G��3��0���4�L�J%}}쒮M��c_:p����X+l�y;Ҫ��~��V}��]�y��ۆJ��v�6g�ߜ�+o���M$�#?����������w��ꛃȇ�.�����:�Α�v�@�{��"����\+>k_b,�Xؼ�fa����l�(�?�_�sV�sgG�Tu���e��|�{�>q����7X��fAxw�-�|f����X��e�Yσ��`��)r�2r����9p=0�`��a��_��qc�0���ԍ�����p8��NO�{�~�����������x� �8��j���#���=�{\�� A���mY�-�'Î��C����n��|�Q;��y�m�O�Ap�ɑ�G���m��jyb5
V���&!���3��I�W�e�k�?.7/�,�%�`.V�>O����|��$kk�G)��2�gx΅��@�$�eIH�m>�hw`n��V�h����,� C}9��682x&�pK;ulV��zm�=�]�+X�ğp�[�Hq&��׀Clk�@���y����`��w��� 	�_^�K�#B)q�����7��dpc��8X[�̆��\�7�z�Z��,䚚���j��59��� 81�E<\$|�½밫�xs�]�x�X@���c���m�EAI,���y��y���؁$�e�g���{-L'��T���dv�����=Z�r�"C?���nć��� � �|�WP$�dy4_ )Vxq�#[�X�R�� ����o<ꋷHz+&�����]Ō=����》и~�i�>\�%�Zw	�XB�>����8�ʋV�	01!v�'�b��8�ĿAG�o本8�����^���"�1�����l� g�s���FE�V��pCP4�0V�-"~��_���?1՜Ս��{>,���˲�7����l8�i�0�rzx:��3�쒋���c?At~biu���S|�p:���=�3P1}ĝ!�O[K8���>�l�O
D�~aS��� _��=�rq�\Y~
���q� ������u��Z^���X*a�S��G�	��ѹ�����|���Fԃ�!~3v��ś�U�� ؜�@KS���=px<0-�<�q�9u�)6�8�R��k�{{��qN�-a|�~- xk�6|w<��4z^���D���%r� ���ڨ���{�.	����Z�=P�R�!�H��2�P��0$|�OsC ��䌃�I���\�7p���'B}��E�Z������Ӱ�|.^�s�+f	S�[�a���<��r�)ؗ
��^`���xP\t����/���ը��$`��P��8z4�ĸ`��P_��YXA�d�4(��=��=��m��� ~l~��v�n�~jܓ�7�÷A6��B��z@�p2����>�}�����ܜe�o���9� �GǾ}��g���jb������]����w��'�k�`. !�����`<.�=x�W�`�d ��i�����aۡ;<��>�+������#bC2�gLU��&�q�;'���׾q�˃���4�WN�*��9�b>�]l�hL��З�q�ӀOA�`b�"�p���g�	:)'j�P
D�$S�$s�p}��9�oĵi��|��C��y���a��^�� 68<�s�;<x�!p�m��;!B��'%i,d��~`���V�1ò��"�K�N���(>��]�f_���`�p�&����pkN<k2q%��y.1������^0�,>�3�X�l����� ��;��p�=Ќ2Or>��|����c$��Ѥ�O���s^!0nQ���:N��˽���½�G,4ѻ�e��cyOb74y�,�rey^�|��5��І����b0kf1��(P��}zb	��>��@7Շ��s ���ϧ�d%�#��sa�x� �{'���5����6L/�����a@`���N��8Q@<o���NX�1%B�
����go:�����8��`6c�W��=���]�p�=�D�RZ��5{P�=�<3X�'�ճDO&V��O��FN�ΐ� ��0n,��p����e�%��[����b�Q	��g}x!QtՉ�9��ޏ�I�T��>'l�	iXW\+س�Ob��;�̦���p ��G>#t ��u�.v���Y>n���oc������هJ�4��`"�:�p�0��XU��;tω�+��6U���8���}�ĵy:Y#�d [J&s���
���D�Y-���&y�/��0��_����u�|*�qko0�ӸH�"���n�4B���u 8���}�9H�9�Q�p� v��eW��j�r���m��8�� ؑZ�4\�>��) �ښ�-���>�o�%c48aQ:���_��]+�"b�ǩ��}e�T�S�lVƆېpL    �G�����@�t�m�T#��+��rف��H�Nț�s3V�s��|�b���b.	�ɼ%�6.�R�׋;���oF�Lt�"Hkm� ���=�p`��~�}�kͬ�!X�1.�g8�'�$�*,ۇ����>�-�'��]_p��3r�q8�� �S���t0ft���)�u��|�?����pQ���� �O2�}��2��a�y�`C2���������n���ȓ��̏�s�5�A���w~��I QӒ�`ض$�>N����u�������A���I���r߀]�x`�9�ƓKIwX.���=� �ǧ�s�q�;��(��LDVs����Q|�ֲ���wCD�����c\�iY���gc�/�W��Y,���Ů=�m��1	�{���P}u�#d|~�qc�2| ��4��q�?� 	~��k7*�a��l1k½� ��%�q|�c@�|���Xֶ� ������L�`@�����jxw]�k�W��o�@E�cCiAL���H�R8a��������X�H���,�3������~6�ڃ����yd�xk|�e&@c�e;�e�bf�"�B�?/�`��`�"�w�eM�96'�n��xº��� �{��aE3v�H����Q��ڼ��Av��6�
��'����C���t`�/����g�M��Ʈp���3�7���s����p��> �$	�s�/�K�s�E�9o��?���O��U��qN�h��e6�k���u`�`c5i	�3�a��S���<pG�h��Q1��M�ls�D��D�czD_�4Bdd��c��P�Y9C�@�8��C|,��ru̌5�����Vs���ʝ�<�ۂ��X���b�-\�S�kX`��aL	�ی�}�9��a�6{X}�V�o�b0 ���Z}����?���AQM׼��B=��9��3�U\�Q)9/I.��:.��V6쯛���b׸FA��ņ����ƁU�۸�\���5��u ��ލ�3ԉ��ހ2q]F� �X�	�I ����֜�w���������CL�=`F���xr�D+Dx� ]	����z6��y���sJcnҺ�<�J|�4w�
V��K�׆`q�?�lփ˪�����ʡ�� <3z���S�tn F�ذ@�FS�U���
��!�
rЃ�y`����ja���a���`@�!�4�Q�����B�b�>�����:^l������t�6|ν9}= K:���UB�&���=�.�m��͠����5!�?��A�){��2���mf*��`W�hq=e���5��1xvScaf ������b��/\�y�F���ﮱѰZ@�&۰�� �'Jމ�,:^�L&����\��J���7��o� 6����������bqZ���̦W �����!jj�q�@�����Jp��c�\	�
���K��f�h��v˿��p5�{�{i�qG�0���#�󾔑��|s�d�
x�d����MkX��d��s5~�s<�>,�ör�q�����uq^��13g~�H�ëFk�LW�8��tnb�D����zCnz������D�����1U e�O<>XP�f�"n��? ���nF��e��Ĭ��˳d1�͐��;��^W����}㘹��&�ˀ@c��c ����a!nxt@���zzOp� ��X0��bQ(l��e0�v�� �,��?�*r�> ˥y`�X�o@2$��]���ݹ�0$�����9��� �{|�+�ގO�9�Z̗�IF�X�����F7T���O�K_���b�vL�}rX�<��R�^������/��a�}aVw`C�lѳ �K8�!b��|��?�������@�fk	�������Ga��8ö.x��W�1�m��S� �e�k� �7�����_��f�9��]`�\e�k�˰̥�V�����b\`ػ��<��ߡ��^C���'7|j�~�U���n?�r�""6�����]MxB�+x��E?�Y~�� != �qp� .<'�.��qua���W�C'#l��
|W"iǴc�u`�b�ޓĦya?�3Y�T!�8�0���9ܱQq���W~�Dq�?|eb�^s>�x�HĨl�L����z���+?�P��Y1s�7e�[8u��u�k�5 ���</@x�wǧ������z���L���a�桛S,�Y���`���8�'���7��DL-F�4����`����.D�j�Z�Ȇ۸B�f�y��n�t���g͓T�w�{laA��\���֌VCt��2f0�ٕoZ1֞d���9y�	���qwB,p�Rz����Q�{�������.Z{Ռu�+�"�o�`�����^Y�)|,�0���~-�K"�<�L�u�Ua�(�g�� ��D�ub;A� �&6-֐�6�Sڬ��c�k������+��v��>���J%0�%V���Ó�E"\,.A2t^<Wآ��&��Y�Z�i���t,��Z$���5ei��Q��a���B�@r�Q�F����a��ʁ3u�ճ�E,���lp>�:��/�>�纘*Fm�.��=y���ֈ}�=-��)`W9Xh���%�p0>rb�S�@<x�*������,�
D�H8u̳����;��`���ZD���-���A(�a���d!A`U3^��Q-��յ&��N�-OG��#�'�q�^�����X�a��x-O�k�k����jZ�(U>��zP�;�	���~�ڢ	���`�,��
���\�z���p�1�KX�d|�����!Q��}�؉?�"��u5�f��,�sر���R&����U�Æ�U�Al`���F��bʟ�y�8����+�E��M_��*>����.���Y7w��z/q�}u�鸟��P.IhQ��\�C�p�aP961����7V��ǂ�w��Z���-�޹�Q����\1k<���ɖS�]��c�Ak�rJĬro#�f��\��z|�Y�*@��D�X��X�e���ǚ����
�����r���q ^�M�Ծ5�x3�=N%k�$J�}Y_ 3uӬ^�[���ŭf���a���e�o��
��_&���Pq�l-�a&+�iBߦ�7� y�#�}{oe��f�"���Ewi0��oCØ-Yڋ��������ӹ7u�CGpK*ㆉ��Ӡ�c�#]FB��Y��Ny)�`Ϋj�ʺ�kY���N���	6W�k��3@"#p��y�uX�V�|�cQH�)����V�x	�YXQr�A=z�������{�|��Ek��s,�ݼи�9��Y��m���C���ǮP�u���-}9̀��?5,�Eެ2NoZ�ܚ��|���̌	�:�f�_�'O�G���Ull">��i2����G������:��㱂�S�9�j��8�ee�!EZ��nBȍ��8%��,�e�1�ͪ0v���T�e^��q����'�����|9�&�p����xS���v�Ǭ(3yģky6�N\��4l���
�˭�zy=�>����6w8\�I�������~f�yHS70���lf�q���MrQ���β�'������,��`���С�K�*���[���<�a���%���b��z=��G���rj^o�	�l"H`3i�������Wݬ���%�:8�"�j�3����ľ�'����+AJp�l�ʃ�x��`!,/�pG^"{hJ����z9��
��� ��x�߽���^��j��Ŋ� �Ȱ�<��oS�^��3y�eO��  H�°n��O�w[D�k��W���2C����2!..%r��m-��l���-�����`��KP��#	�9�3�s�iO���2�:XY8��*�4�Ű/Y�1+�����X6� {7�
�{e������G��w�=X�rtN�r7�|{ bO�_J�5�6s\��k����܃���1uPl���1��3�`[���/$���bJ��5��Y�V�`��ۋ{��g    yr�qB���C���s���~�1N.�M���������� ];l�V����M�A��)XI,6�wf��0���C3ʗA�x�\�л��a�����������J��d�}��U�и�xB��lQL̣3���%��X;5x*����<�0ׂ�e)C����Ol�b���ݒt��)��F�mg .K���/��>�d�u�<39��� ~R3��9Y������y��Z�+�x������ö)����{��a�O�D���`G��(X��L;���1���������#rm_hf��<����b@Hs͂%��,��ڱ�����(YSy���+!��{n���/v�bMF��"�b����5&�m�`�o���}�F5�`���ď��x	�&>�=S����Z���K3M�4�St�.�.��q���^P!~��R�'6p�N
aeu�A���0��n9l��@��D�qb.���h�����I\�d�ی�j\���}¢٠a�d�?ai�vo�^br�����ͱ�0��-4j�Ӄ�/�t�64��Z��O?�4Mn~(��e��YB�-�]��Î/l����Pږ���-Cx^M�	����%�b�L���Ӹͯ�q8��H�L�>z�X"?+����Y�>:�ף�Y�������m<,$Ĭ�Գ����^�����b��5���c��M�Ȧ� ��mG����m��آdӊ��fK� ������A�]��&)�dFK[��a`$��#`�q�H��[���N9�n��®���Z�ŏ��?ՙA��<����&�?�!@��Y��;����h����z��/1U�V�h֍U���q|���XfJ�L�&hy���ݤIq��SӸ89q,��:?[�oʅ��r�8鬏�ƛ��+w�G�c�A����\��,��UFss�[3�u+����k��#Gk�����B���v�H�ά|ֵD[[5Cˑ�"�{x�ܡ7ؕuJ��3�Rm�E�K�=.�����rHx�i�H�	�q{3��@�@2ra���MluNǷo�������d^`��e&0ؖX���ٸWJ��>0?�Y�;�Є�OX�9J�����Q��2';�h)Y����$��oǶ.���_p~�F��wt!Ǵ��$7 ��e&��/&��Y��<���U��~4�q}�9s��Y\�>��Z�Wa���M��;���N��[�`&|>��c"�F�&�*�ӯ=�V�����u٥(��X�hc��gx�ql�¼�>-Z��ri��=ê��hL�@��a,�G��<,�-���#��#跟��پ��a�{XоL��-Mx�l9����q��|5'���z�L�X$[�aN^onO��荦�� 9�g_-�q�b[�z��;�_��qƏ8Wż7�{�����7�ƈ��,���@W���2?��,W߲�����9��{�����/���W�j�*��e������^j���+��\XH+����n��m�hϤp3��3I���:�т�f�d��3خ��=f�9>����`[���у��# ���� ���{-`�M�-�.��_KWL^�R# [���\��
,�&=��6�'|�37?ޥ�n��G�<��h�Ҿ��2ʶ�����n��|V=��%��8�x����x܆ ��vRN��폰7ɢ[����{�vy����c��ar��g�q�!ó��Q+>ÀГ0I��멜B���mK6<	+��0|]Z��M�3�Z�S� P؎� ]���g��8б̭=%KN�u ��L��$�!{lx3l�{a�w�����o��A�e|��h1O���Yr(*�P)�O������� 5c?�H��l;J��,@.��ǢP�U>6���<qT��s��z#̘�0-W��<mtv�=Znk���}a�5pƄa4��,]�X����!>��lȈ�f `�=ܠvC}�
�2��coox������j_�g���R7L����� v����:��W G>ӛ��l�sn������d�0{��G;���h���Y��ዟ�O�2�j�(��Z�i��R_"Z���juV)�~�d?(_(���mpjHþ2,<4�u~�_�hk.�e��g��̂ڢ	t���qģ@<ۃ�R=e!��* ��)]�� ��~MJ���w�����e�l�-�C� ���$�D<�;a:�5��+��3Z`,��m�ϕ{�Y�j.$�oM�`#���ϸ;ħ���Tb�7���f��1$�5]#�
w�Q~Fk��j~�|�v]��E��BnW��E�=>��i�6��a��H!��
pV�As���"�F~aG���=�K�4�&��*�e���dW��X��SJ���FNr�c�6�'�i���P��v��)�j��!����U��ko.t+p pA�.=u����\ةg<�W��l��n�+�5�H�ѐ�O;�M\*��e7ϲ�v|�D�]���f����9���V�tk*G�Af��$��l��c�C�	������n4���=Y!��,*��F	4�z C8�ϟ�U��J���ªm/�~�ז;.,|�>��@�a@~1��`��^T��5x=�Z]�h�V�����E$x�ZabH֤����s_֧㬸��?@J�E,�ozI��Z,��Ŋ f��?�.�{flQ{� b>Ti(?vۿ�@��B 8N��c�}�h��g��zY��(�ZNyB)m<�jS'�A�,�	�m�6��A��2�c��s�Lo��o7�&y�Kg;ۓ�@ +���;�F�	.��-�X�Z{͐
�BO�_?���l84z�eI���$�`�Zن��:��	G���Ƀ��:�"4�2�H9���&`�T�q9��0��Epg|��.��/��C�T�7�WB�;���K����f{6hY�WLp܏��<9#��p}5�l�%U��8�(���FQ�I?E}����ݖ�����q�X�e�q�6`p��Lظ�p�P��g��[�[��f�a�����'/K����Q�x��}+4�����d��G!H�6������XL�X.�tۖ#�p�=-��p�	5ˀ4o��u�I�k���+a6�u�'h�_�.*`��q7Yu,v�6"7���5�;X�X��������mE�m�p�>�x�i�4(�]� �L���t6S{`
�V��v&�[9��ܝ*���px_�Fں�C �f��&��8��f�Cwl̀	��b��"G�Q�,���?ce��JF��w9��+�/��Ӈa��c>`r)������y�j��|�2�e���9F�U��Z}Ԗ�8<�=fz+�{�*+W|�+�X�z���m
�c��ӧa1�m@������R�d��V���[��o���e��n�����(��av�s���y7�U~���%-&���KO�`x�n5�9�W��p;��0�˦z�n����ap�3Ί9��d v����Mp�M����N@u����jk�����m� ٥!7��5�V�����ÿ��Ug�#@�-\�|�ʪ�����IT݆���W�:ۺL0�������=k��e���x��y>\���7���*ⳤ>-�
R0pW �؏o��O9�0� 6��x��< uTR�I>{c����,���'喀o���c>�楜���j�&�8+�	���e86i٘��P����I�c�Ok\���\ @�W�ݓ%���K����o]��e���+ik﬷�2�t� P6V=+�>�d�s��@wA�ޱc�h�� �b��o�i�VHY|sTh�{�*�k���M���ڈ�`z� �^}x$��`��K8�b���Wc�jN�̮��-����f_U7,�N��=���u���"�CX��Y[Mp�죾�F��vf5�L���n�H�{�q��v���<	�Т�>�A�4�0�e��Li,��|-\�X�:k��
�)�����ȯK�
[o�(0�a����qy6p߄�ܜ𤼥1=�Q��hД��q�֕���3��2�����|�
ީ�i0�	��V!���1�e���    i|*K�n�Y֏[e'��`[��P?���`m`y�O܀��,�%h�fάw.	4b�A�g�	�m<?xM0���gն�E�i�E-����S����L�J���o�	?-���w{��+@�M�v[l��D�TykT��*��M�%7���쌒��B!W'�/(���-�`?�g��E;}�2I���_[<��w2����p&M��?�2�7��������-P��V�[)���>_���������BED���u��]��;C��%61�&�qP�;�!�P���zҠ���o�*lմBѶ���.�2.
�����T X�=}�R��1Jf%Mjv��f��w�?8o����4� �9`�8\k|�Ұ-�
�^î��BV�򕑼,�ۍ"ЍG�Z,�.��fFe*�3�y�4U�F��}�'�T]���k���*x*���닿�
��=rjH���.I�M���&�>�]����Եfi0��㸪�>��_Hw>��D�>vP�=I[ǳ�V�-�����l[�yë�X�c�Γ&Ϫs_�L;��{C5�u�m0��6@o|��l[�nw��mP�'��Y���u���7���x�qFr��s&˒��֥L���`��Fy>�m�n�@N��@
]�Ų�q�ȸ���~���ot/z�y��,�:��9 ��W> {���8ŧ��$nw��\�!��R���bMS��6��{L����ٲ_�.�^Q�c\9ٌs��4��m�V/۝�,��k�S�6*��:c���pAF����"L)?�t��d��[��+����o��p����\O�>.���Xwȴ`�c��Y�n��QmC!��f��-�vAM|[����Vk*�+�1��W��lk4����Mj�'n�Y*�^ws�*�u a��
S�,���ǣ��+&�����[��v��@���:<�z�_`�[���ԙ�b�����7�O�U!��a���0���At�k����mL\
Y�8����X���cٛ���"r�K�^���"���G�5M�pu����Lƍu�(@���g�/�6���t��`#�:��/�;���9��3����[�,րX���������z��f��S��Ί˯�x�
��&���<qfȷ��Q�<*��fI���kp'� �mXe�٧�0�+�XV*�����w6�~q1�H�؞d�����)�޾n�QS��Q}h�ݏ�l���X��`��p�*2�=9iPƷ�Z̡*y�;���ngX ﹬9����ඒ���b����x��M�1��O�k����x�4_;"ؠo�U�Jl`t N��C��0#�	c�x �+)�Yc���Z�p���ue4"�
��G4����o������2���'�"*(�@���*�ǅ��
IV�f<� GMp�xq/9w��?��VbmƷYEd�8�w���[������x*%-�.��	b�i�/%Nl�Wq�*��.t*Lig�e�(����Z����QGm��
�)�!���7��Т�ܬY�4�6�����\�c\Hu'{(��h�z�e����j��x�m-N���Sp[���7n����ن�x�f3��=��W���|��&Ҫ��W�q�'��`�ҕ�6S�����~g.�h,�&�e}`�=�J���
+��R5o��5%!}<�`�����;���:*ܛ�x9T�53 U�a��,���	E��l�o8*���ϔ�բy�`�^%b[��Җ��Cf�cKW���f��rbF$
�[���d��c#6	�Ll-��w\�Ͽh�>.�l�Ei-�k�	�p�����K.J�b򨧔�eQp4�k=j��c���T��DEA �S�l��r�.h����!6��
��)�,m��<�1�'Q`!Gl+o��LP[�	f��O�:i nfA��P��A��;�N/��b�\޳ ��ߪ� :,�*�d^cT�!p�D&��M����pǋ���/���9� L�Ņ��~�4J�o���X�q����P���F>���nF�ۀ�Q��7R���L�DeO�=����>�Yj�ζ``_���[��f	��	�n��-���R1-o�:��X�Ь��l6U��èvv���(G����;C�Q
/�I��{�b�PiP]Pc�N�i�v�!XY��H�ݺX�f7c�̽��5|^�5�X�h�1Y��z�E�\��r��g_��}q$XKL�U����0����*T��#��j�r'���Q�i?�0����c��ዜ�#�zH �N�09��X��Wq닛�*�d���ޮ�x3��U�T�s�ʽ[Lk�뎈`T��绥���p�*�58���Twns���M�ma�7@��%��W�"|i7D�Q��펎���1ӡ�^s���\U�)����ԦΓAJn�s�w�}Ͼ%��g��5�Q+�(ێ��#P�mVٺ�;y��q<��W~k�޷.���0Q���AoK��N]���P*��[l<BU����t5��v���a�*6��A<�}�*�&���)p��X��ۼ?�� 2T�Ț�iW!g���nۅ�&�$Y���T1!ݒ�Onn�d�9%�#�QU?� fUh��	��Ћj����{ڋ��VP���ou�H��	磪$�w'�X���E��_[E��.���p��G���5��t8g؇�k�&)��8����ꛗ_�(\��w��4�Dc	�k�1X�<���/�Zު�����-;s��8�5}6K��jZ��y�V��q�Jn\j�r,+��
OmX�j���L
�>I���0���4[����z��۩�����?�,i\ƛ���+gm����ЬŨ'"渴�U�c�Wᙝ��rm����}�o/�}�&���p3��U�X�)���VX�:YwU��D'Ѐo���&,{�,�Y���Z:=dp��jd+��Q��:��ᨳ�h�_Ruk0�~����;s���X@��:����G�t��^��~kW� �/��C�mc{Yj|��]��u �]; ��v"h_l�B���������t���>>��Շ1GN�.}p�ǆ���u��-h��0_��M��p*,�fe�����F�J,�;i�Up�PPtohB���txv��iVq$�wc��g�O�����Ij}�hU����n=/ʔY4},��MCX�|k��U��J��e�����65��+Pn�-�p��P�d,lI�{XD�-�3��v��8jl�M��O���.aM���9�E��Ͷ�cF�9e[)<	�
��X��>�O�}w����W�Q��+��v�����-ZJ������4�0�]�A�=@�kd����/�z�,A�sr*qls��[79�~�z����	��UC�yd3�	rf٧x;8*)*���a��Ɏ}5�S�-i�+���+0����9v �v��?Ka�>_n*3[�?ta#�O�u�ȦEm���UU��4]��j5���ntgK��H�Y�iDs�Q>t ��YyA��m�?Ә_��<��?��~��k���Ni��mS�V-{��92BG�e�����T��t��Qi�Ns��ͫ�me��
�گ�ڱ��������U�}��q���u#L���v*��O�n���j��ƥ���~��<��f��o�c���U*��U>S���7�|}��KUQі�O�dloU�Pe�=G_˲�Z1'�ͷ.�&!��+��g߸)�g��(8�kcN���\��F�)�*�w��k��� ;h�J�X�e�î������9�f� ��R�����^�E� )�cU��sk���c�]�vW�{�S���֘2�f��5��ρ�7f+m��H����0�q;6[_~�̔�J��%崯A ��7�{N�A4�'�[��KG�S��U2�m�f����s�04�o� ���`�8Pn�[=R`�*&�����7���-�M�.�,p�t�bp_�ŕ��)����i�X>��� p�+<6([�l��X���-�҃��tK���ֶ댞�<�q0������#�m�� �gJ��*z��9)R�,    ��F�����ks��w���jt�\ް8��,m-W���_<N�Z����7�N9� }sm�9�~��fu:�
��ov����1�n7�B=��#�����v�p\�zC���9�#�+l��2�2�X�+���5	�q�:/�͗�&Gl�/��_����U�����{Һ��|0s���*5xX����f�t�Jo�/�G�Y9i�%��M�z|��	N���8��k�8�r�G�I4���)�����If�:(��Ϛ�h��rr�cL��Y��sFL�E:i*1�|+*5Lòާ_�	&�d�ǹ����C�����r�L�ԛ��<�,��rz��#�������	���R�������n7���vTΨkn�}�^�#���XD��0��')�B����+��;��R�=��i�R��h����,s_���	"�*��](� �����yl��h�T)N7U��}2ǯ���� l��"�>��4:^�E�u���!K1��ˉ��;Ε�5�F�;ت �ްb���#��"�Z�|ka�QW˲��vmGW�i/gE��:{���q���˕�a�6�����׎���j�yKj�+>2���9��*y���_s��H���}�:��P�{�V��q��J�6�����Q�n�?�3Rm\��V�@V�H,��OV́s-�ד�uYvvҹ���� B3�Q5��:�ː�H��j�O�碾�N��)z\�G��"l�,�B;
�|���W�u5��&-30�u�p�	������$�e�o����vL�� 	#���iyٖ}���z ��g���;6ⱴF[�t� �3��x����U@k���?.26�%Ӷ6GJ9�7�A� q���}��?6�[9o��u�ұ>��2`dx.�Dˮ�s:�U��ȓ'�`�,;����Z��mZ(�2C޾["��e$C���ӕ�|����(�A�v�l�v�Z���X�l�D�v0�[��bFh\v䄁������L�n�"Z��9N̆X0É��X�t�̟����>��bp!�3�K�Y�x�A�P�U��Om��tT	pŅ����� Y-�z��t���O���M/x=;A�Ҥ����F�X �t�	,$��))������6 {G��0.%D�j�Tm�KVN,C�X�۬�?���~�
=��?�GD(� �qk�}< ���<�/��
p�Jf1�:g�1�ߧ<��Y֯��5�D�n+r7�r�8��C���+�y�0.��֥�m�|}-�U膫��2�����q1�[�{�����0-|���S�Hò��������O��M�9 V���d�¾B�5X��@lZ�a��Ta�N:UW ĉ,���2�{b$oMŧ�-�00�;H~çpR@�����t��xL�WK�=�|��f�'�P�>U��-U�=�U}����b����lb>�I���-��RƼn9p��	,ųw ���1`�w=|�g��#\�m���'���eD듴�R0+����`�Ed�����̍��]����a{-E5J3&��w��C�O,.��cX�68y�Ԋ���5�)�v\G~(���l}���Xu��E��k�4��y��`n��1T�����$:�x��&�K����`��O#pe(������?�ISU3��8�~�s�*������|-�������*S�|���T�W$�{f�҂��3Y�PΧIB����O��3�ޱ^p[x���S_M	7n�a��Gњ��7)���c�3>��i �R�W��ɦ8�̒����>wNF��C�oiw���EW�8[d���;w�p�Ҍ��0��m�Y��xƀU��s���uG%�-�z�>!<�2aDn�4�؝~�V��{��b�->��s�Crx���̠"|�w�<�i�!�<n�
��؀l��b=��FpD��CX���Ȇ�P���2�3gGI�y�����f=�l�l3'q��>��br PJ�lX�(#̪�*�!W���s�u,���;��$k�^{���ٶb��77�\�r4^�/	��f�X=�:a�Y|���+�yT�Vt�ɁX�VE��!���(.��Q�S@B��(����t�� u�T�Qp>��}�~�v*�~5��#�V�J��l4t��B�NR_�.�G�N�0�˞p�'�|����9��pN�F�m��Bo[�`��Y2��I�),���ii6�26�h-���Z~3[�o:n�`ң��c�-�|���-����Ϲ{sp�Mo��NmS��2p�G�Ǯ��c�U�ߝA�۪�<2���Q/h{`�N+����CNop��b����JD���!˺�=�����i���I7�[�M�Z�U��N�nG�e5V:a��M8�snO�#W�t'<���z���n�

��G���g�Y5P\�.�ԞJrJP��"�M�'S7O�o�y�3&�i�q���S��x��ήX�f�f.�,bX��+w~�е)��D��
�ͫ�`\��Hs����?Xv%��c�h�NbW�l\U�� L�yl�|������`��Ĝ��@�y���:Z�c���p0�t�m<�d�>����f�q����گ< ��� .Lˈ���T�� �,a�V�ݹ������o�wѿv��?�9���K�j���sOt�@��[J� �-A	�s.��-�u ٝ��r�m��q[�t��j���AVQ�#Q�g������Xq<.���|qdtѾl�q��}�+�د6�E����t�dt���g����f���a�JW��8O�*;��s:w����ڊ.wι�ʹ�<^�󢣳�������9��w[G��U�w��v�UqBh�Z�o��k��Sgq�0,����}�gq�뺪Ǡ�z�I�R{΂W�¡�6�
�o�����j�偢r�L��u���;=x��a�#�6P��t}�+�VG�{�@��.�J�d\����R�]ꌃ���S;B��7���2��<oc4�aȥ��k�u+��.����^�ӳ��^e� ��=������z���ƞ;�)�2�ǰ��guf�����h�;����;d�	o����Gɤ_��𝟓S\�=��nQ�4�\��=�ʜ/�Z�;��%W�Wu�6m���T��i��p���^l ə&�0�z�S���&L��āS��R,U�6�l|�m~@�I���N�([��'�oɑyP[��Du��Z\In�D4M"6��zǘ�U�]����ckȃ���P�?����g���D�m_��nK;e�ǩ�.ijI*��y;8�t�67���3�l��Z�:M@k�as�i���a0�p��!�=��q"��Sn\R��OB�;����!����{���a�^So�5^^��+Rv����E����٬Q����i�m(�B���F�a:yMVw�g@B%a�!)<8<'����)�+�̒Zٵ�c����]����El�/��j�f��)��[Me����}�����+c�YIG�$&W�]|�0��	�l�X��%i�j�h�X���2���K�:�Xuyԧ2�����y,�
K�แ�-|�Y�z���y�o�<��~�0�S�.?���|��!dZ?s��M'�Bd�M2��X����beY��rHKp�����;�Ͱ�QQ�Oh�"�+$^��a#ե�ES�*�=;ЂIW��J�N��b� �����ش��Y��6�n?�O��P�F��E��F{�Mp�h��q ϭ�4��74�an��q���KF�ow�qp���؍�^���5\ >��[~�,�/�g�F|�v/���� �36���U>E�f"�hf�/;+X��!M�OŢE����N`���������	�U���j�N���ǂ�_;�� [E����~�2���f���~��m���^rǆ�7iq���&+.Vփǈ�}᮳��^��rϪn<�>��`0�z�%��"ށ%�J�fİA�^�ڰ]�Y����Q��̸�����]
����Ն٩���(6M��X���6T�cγ̚��Ϗ9���������_�]Fl$��Dc���j�3:<%=7����#:�sY/��[��C��    �[%�y[!1f��NŃ�zdK���m�uF�T^�4��@�Mp��ӊ�<��x�1K��P��tr�C��j<P�	���i���(k?��ċc�8#�5���˱��5��o�iohˎ����Vۼ+[֮���i��cY�(��ıB}:J��j�歹	����❇��N��e��ə� �}����u��<�ۍ�|ŧ�:����T'+�ױ�"�2��'��jk1?[m�zT�c{E��E�wF��h�Y�V,C��0�
��P�O�oǧp�KLEq�E��G����[���[��ܘPUq�T�\�n� �~ߍ�z�04;����1�ﵶ��|�E?�#�U��헳ũ+뀣T�8;�E��p3R��3��B�*$��ފ�|U�ة9�k[���:5�yk19ۨ^�8�R5 �Vєf˰�r�r dT����U���^'�X�~���d*�:��X,�K�n������x/�F5�ը)5Z�fͮ58� -Z\ K��Q�ѪH��%8�Q�|e�-��,�r��ݟ*���7���Z�0��8B��G����e=�c�� I�_(:X�	`����`\ mc��޶@9�6�^}��bX#g��-�����pE�$��I��e�.돇�S>�N�E�.���	>W���"F��.`�-Qe���°�.kc�د�Y��̹Pj�>v�L�g�^����Z����fi�.�!����������t��ݜmP94�.U�H�?�VoG�x9�t:d2�����/��d���[�t5�t�]U�c�tܼ��R1ӧf��.Y��,���m�����e�����Z��)b���q��{��}Q��7�T��븪�תce0��6,��1��zp�mW��N/Y�x�|�V\4��3���4����*%�K��9��w<7g5��P�'($V��^j/���l�����Yj�än��h�?�7��5�j�$پ$l��C�{�f�B*a�a�V D��kr��;M::���J[�",��'P*��#Xo1��a�~�sx�39۵��F�cљm��tn�f���é���͆���QcL�YV/����:#����kۚ��"QWpW��<4g�n[��mMseR؂�q�l����yeG�w�|�bA"?κݢ����-�=�7hm3�3�r(���Ggnb������M�[p̟EJ8����kr��d)9(�ӡ@c�����GU�ɝ�ꧪ]B�,��m�߫ٮ��K��(���Ye�R�t�,���ê;��#\Taw-����+���jW2*�b�<9�JkzkY�'b��~xp�����van�g���M 4#b��w`�ڥ���j���������_f'��C�m0�9��h�&����L[)��^S���[Aj՛�R�����	��[�`���ҫ�UN�JƯ���U��<��264�������6��`Q�}��X�2[A�_�Ų������BP$P88���*�5�j"(���2:ϯ���I������	l�Cb�`J_���]a�'*.<f��x���y3��i�D��4N��daޟ#���8��k��>���P _�u,����*�j!XI��,��y��Ta`����0gc<��^��ԏ?��6�u����`C7re�E4$���VGl��Q��N�j�T�
�m���T��r�5��9��ԛ�����:��و1�N��o3kQ�U0��*�Q�f�Ug��+�8�ON�5U>fp�0A�+����z���_&*�dA�zoh��mS��N��n�t�"Fб��\��N�����s ��up�h�j{�L�*N�=�)#��
 _�ָ�~����I�<�^�毼�:�U�{����'�)5iiƥM�-�v���qb�P���F��������ǩ����V��ǋ��cT� �B���*�i2� ���_I���G;�U@HJ ��G��b`���V�o����Gp!F��>֋�LFY��s[��b�o,�R8�&�vU��UB�M��0r�l��WN�x��T~ɪ��ρ��F�� D3�sME���V��i�{z��+���zg3.� ���;cɦA˾q�[��Ci�or��.\�*�ڷ���z�(���&�4ۏ*g�"z�&���4A%�~1_ܞ�����c�V��b_q��"@P� ��ս)�b��~-P	t7�y���G'�w_�s��ݕ�8�2�Xe�\�&Xz5��1�÷H���U��
h5���oKwL�����qp�v���=��yƎW��g����X3���a_읐n%t�ה���_���}�`Z���c}�e,6��0PE��+vۍoW�fs��^4��C]%����f�/���(^�U�,�[9�R�����,Ǩ���"�䢮y�Xw��E}�ǅS���DC�;v�gk�oZU���	5�k�0��)�4�~mlj`�^��*�O�(�Vc��h�!.{x�o8��O@�V��鰋&9Z���D� �aN��bk9���55�j%-�L2I����ń��,�yM�����W����CE_��q�j
w~�� �i��m��k�:��ZR�:8Z�n��EL�mKA��1\��!�rx���+�	z���x����K[�Mu/��O��Nv�Y����R/�0y�Hd+��d�k�q��:>x�f=���In��9I���G�S	�j�l#HA��������r��2����Q�
-��n��m����л~}E�� t0��� �H�;垝��β'v.����	>N�c�����CtK�%>bYQ�R�}����'4$�@���i�1��Ҽ�����1�c(�_9a�Lx�$�����g�Y�:��㌘����aK�K5+8���arѐKW ��;`Sl��0��xS�c���e�q?m��hCt������dGlZ�u�rP\�_Y��
�lXl6�⼥�*��f���tw ��4�M�)Cߊ%}V�x��ŋ:36��@�׮@�~���r��ߔA��� �8�������\6j2N��*ֵ����6�p��s������vLT��o�������L��7���5g;ܩ8����줺=HJ^58��{���Zc)����a��_OcD�d���������D=�ѳ�;��6`xֶe<֑ss����<�o�s$�C$���,{:5�;Z��"8�s�B�d�Z�w�!��rCDo�q�u��J����#v!8����VUr�7m:b÷sz�zvC=�����#���l�w�cbD�:�;�c=Uy���X�p��@��gk����l�CU�c1�����m��u_)�ED���+: �9��(���ֲ�ˎnh�J�Y����Y����
~��wn��|Ѻ����̷���G�s; }��l�h���U��n�!0�Uqv)NprwJT��8c��(t���9b/��������OJjg������v��+�(=�
6����;@Y���v-+���FQ8��"�Q%���_jx ��(M�p87_��ٻ�ˍ�J�[B&\b9��_�>r4RhZ���i�R������k�y��ws�v <~m	Z�s�PIK�O赍2:�r.2���b�����:�
aڔ8��� J�Z�^"��3R	�G�^���UCF�|���B�k+�
�b0�>���߹u�;��+88r&���7�"?lNW?�@O�Ţ�!����݀m��?M.��;����N@) �Ǘ�2�˲�[�$>=~�M9�^�M�$%rz�N�����Z~̈�W�d�B�Q���#e
�5{��P�~8�����+���K��&�����ph�_Sb�"����#�t��.��ׇ2�%�6uQ���E ��7���9p���&���#}��G�� �,�,qZ�q�#Jݵ&H �t7��Y�
�c.ʟ��RU��ؠ\7x�6?ܜ26~҉m��;'��^�국���q�
-�1y5F�h�x��)��]S>��|ɾoy���B�F2 �<�J��>uf�TL����ޠ#���f��\g�Q0�s�8������d|"�$�D�l�Y�?T���&)�����lH}]�q�]Z[    �B����(yb<�gPQJ7�Ω��A�N�
��3؎[�7�Q�6<'��Ubu������P^h:���^*fJ{��9�0��f)[Sul_ٻvp���}���IeO��g���[�����r*���ិ7=pu�ձ�IIE���f'���^o;���/�Jef��/ws�\��AA�!�3�d�𼿅��ȠP�Ql��L����ע�#�LF��n}`�����D�i0M�|[�|+6LTr�ۦ�ytu�Ӹi�^������V�^����{O�NhK������4����뾛f����׸4�ҖP{I�JT��XxS��ݥ>i\����,)��C'�\��ʳS��%՝j-���[���Xh��w�ʊd~�v�����)���>g���S�/��S ��X�Ư���$u�9�\�K����ا����Б��R�M 8�!7��wm����<jђ��1�.�v"|A+m����,�h?� �}��s��TzsyVM�+����P���6rv{-k����4��u,0�ǧ�{J�,���������Z���X-_5J-o_m� U�H�H=�_�@T�,=��e}1K�p�GU���������t��F )_�\������qUFI��3�@��.?Af�]�`f�n��?&�I"I� v�¥ڒo��#��<�[,��a����m0Z�,����Nx�S�BO��	��ii�r[ϵN?q�Yב���,��A������K������Ra�\8��gj��<���^9?op���i���?,��e-�sߖ3>���"� ���r-N����yCa�_�a��߼���hR'^ux�0��q�oe�&��SB�?O���!�!�BN��D~���������=Q{��x�2壌3���U֔a��1Z�	޻�Į;��U�N�l7������m���%'��x���l��/@�����s��Jˌ��C%[���w2"`J",��:��\����m�I<�H 0Ga�B���'g�$���P�d�C�~"�j�B���*$��O�^Qޔ5^�����S�_�\7M��>��y���D*J��D_S��p�Ip���Eر�L띮����shd}C�9�?ee~��я���쪦�������X�9t��H+�(�Y���~���0k�10���fU�n�3�!#��Su��������8�ѣ�/�s�X��$%�bc /�ys��m�y{ˋi��[�z
p��j|�3����H9c��{	�XEnBo[��I&e
��?��I4,�%ex��Q��4�9�6J�n�*jC�%}���s&>�"�n���nߜ�#-��4o-����r#�U�H��Zu"�@ߦR$�����n���Q�z�4�P@{�=%���ܨ��`L�4Sh�̅JJ �m��8�cd-	�23���8T��.5ϛ��,�+��8R�y���ge���	D�Nۦ�\�,i��x�$7��,X�J�3O�xo�����0%�960sW���	��	Ӫ)i��x���U�5>7ۯ�_.RY���Y���B��J���hvM��5���s��-o�ǥ�@J�J�ʴf�Ɉ�Z7'��V&?:hS���9od�V}���{�4�%�rt��p�
��)�:��^z5�4]q�)j�8�
cK���HG��71�v@�J��f��^�E������L�/5�9%�)�ߡ-8���]d������ �V�����I�@=�������0������SI;ixI�f�^g*�|!�i'��L"�.�'i�!�.%ߗ����G�&���Y����l'N=1š��8���_����8K��L$"5�.=E����*��9�n��?
o��M'Np�&Z��Ӓ�$?jB��ɤ�1�ۛ����T9��O�"ܮKE��v_ �/%�\��gL�� ��:�[�Pa�X�$�d/U�b"�(�%�d��O/=m&��)L�����E�(L{	�~>�A�l�d��1�`�%"ʶozSb�'���\�r�Ao����(`�������'��?7�c;|���}�t>�����&����X�|��b����,��9�ۑ�Y�8)�i�'XB�)���)���t@Mf��o�w��@�ǧ&�j�k�S9���uN��)1Qn]�|�<��9_@��Gɂ#��D�<�S�[n.�ٮș���=��g�,wJQ�|ZʳuE��'Zҭϙbe�K| 2ֲ	M�M�K��%[pR�I7(���5ބ����h&˜�!��,D���o~�8Ƭ�I����^$��>�vT��gr�5D��h�b0"-�Q��ͺy�\*���/
2'�v�K���d@�{����R��s���u_6"�ײ�5�/oKO�K��N��Ԑ�/O�2�#JO��j��)��`�t=�5Cy��$�d+� �r���d-����!���ا����X_q	�p���_NF�_��0:E�F��:s&�}-�SG͠02�@��,Z�u�S=���%�+��"��K�џ�$��ъ^�(�vBOw�+R;K1�|�j�-+�ib)�QN�Mx��\N)������:Z����ݫ��9߅YA�4�(ɲVR�� �z��'Ɨ11(��ٜ�PJ��X23��5EgRX�I_���S�-fL����Ѕ`M���2����ۘ�K(9iE߳p�d&x���y�ۖ���=���B~����y-�%g���c��H�un6�{z�{"���J��H�Β���&3O�{ ����������+��Bõ��D�c�w;�S�^B�9���+ �_I6`�䴉UG�p��2 -g������$���㑠yk��ͫ1Byr5 ����#�����z�JA�)@U,�}�ٱ�&��%���`�9v-��L��ڊ��{xkŦ�,�W�Gꘙ��z��8�n�u���d;s�G����sNiʆ��̚��e��b�M��ο��G^ɷ	
bYj��H�]������G��%�w�K��aq�S���Y'�c=�'�Ԝ:�S/��Q9Gi��t����J�4��4��ӛp��	7���߹Ut����j����o�MF��2�>9oKځM�:���>�����o�t7ح{N����s"ӎ!���P������h&Q�/�8�&q��N�	h�o١�"8�o�!1�3�L��o�V��S�>��	���nOnvh��rS�Ch�K�7��R˳�K�����T#�Q�y�$K�M}#j���yp�O�6H��Ǐ�A\���u再�d������9].�9���D�#.>췸L��¤F}�QX+�n;�-��K�Խ��o���ӗ&]u�F�o��~tb8�.�����C��)m 4(B[KF:	�u�4L��sJ�q")�3 {ƃ�$O��J�EU{�<��ܶ��4��E+�b���v���O1�6%���Z��������B�f�a������]�K}�r�L\y�[ʭ�T�9<���a!�w҄?~�@%P��I�m�d�ϴ����_�Q�ʹ�h�%�ɅE��
�[`4I��'�����!HU�Hd{��$��'>�hP.98Z[�m@d��ݻn��Qr�^4�{4KȘ��N�[���%Ҿ���\Xz�=��H�8O�,�Hr��i�	��f���n0���s��IZ���L.u�I�ă��K�]1��������Y�^���d��r'��+V�=�W��%�D��Ek[�^��)���-7����if����~��=�"y�7p�f`vl�Ў��&��/)�B������CZ�%��������7(�Y���G�u�q��B�
�/�	�%��Ǩ'1���͇t�A��Ǫ��w+���l@)T?�7'����n�&q|
n]��Q^��'"H�$�v���(��8+��k�	��^����S6���'?�I�L`��;Ku��R�l��{g��,U�\2Kr�,�K���q�����u�v,�:zb��k�_��
�]_&�DS[��BE�.�sP牬�B�ET��&������l�q���:C�%��R�J���l凝���֙iZoOv�cOʸ�� VI�dRKғ�Z�������}'py,�eq�2��9��._����`2w<��-�1Q����g���S'CLS��S4>�M8wh��y��n6z
�ϥk����&�wbO��t'�4)S�]�~�y    ��UI�c��y����R-9��#�q���M�n�}4�C����l�����ʒy&?z�x��gB{���$G�����5Gؔy�TM�\�`4!���z�s��^�O �N�|#�]n-��2N�|�<҆�1O�I��#���`l�q9��4J���U�y-hܪ�h���o�4�F���&[�54��2q�q�i/����<���N)�t/�E�w2.��H@~Z��
�y��\Hj�A��s�7�!]G����Lr��Km�����z�UX��p�[]<�yu	f��9?�c�����@���4�(f�P��T��Q	n1N�Cn��VNH�kQ����}�ۨmԙ D�d�~'���a-_���6�=-'U�/���D涮0���E�À�l�������/m�7��ׄP}s6\��?�3�Y��)�@�d4��y'l�ωL9N4^.�$.[�M��1��<D*�e��wh��~�cc���Q}�mS�-�x�b�xKnwSY�tat�)5ߡjIR�/�����E��DFI/~������+��̵О�v�B@�DBd� ���G:��ɳ��V����zMr%�����Z�i����%��2��6x'G�)����	0IW�N����d$��΍�ir7ʩP52�$���\��yNs�J�ۭо~���e�ɕ��uɻ��(z�LX�c}������/b�h�wI���m@Ms�~5*m�j~�Eڌ�̕�Q>R�;R���B%b�c��Lk�L��6+��v���ZX�#V{�=	���K�/?�! 6Б�'>�"m
��6 Ȓ_�Щ��{>��l��=�K�D�)5���Y?Z�]��g��&o�!m�����s��_����t�)K���B�Q��j��-̙���M=C?� �ޡ$��Q!b�v��H��/�=�H536����s�����9 I?�a"i*+y�L�E����Y:��nn��e� G����7�M����D��Z���H;��s�,;�A�ϓ��I7����k{����_J�y�2ʵ�r���d x:`����y�w{H��u�
.	@��	�}�Gk������|UxX=�3��MA�%��q�,7���l4ԦFI�����Z��^+��JS�@Pm���w�m~�
y#�s�~�FyL�E��R�b͕�M8���)���W���N��t�x]��P:�{b^Ҵ�ۮ�x�7p��p�r����,��6?��`��2�th��d��:>���;������N��!�b:`� ���ڇ��mW��F?�X���щ��d�Y��{���tؼ)W�Ta�t�F�#� ���v���T(�^��+�E"�W��]�D����0ĉ����T#EF�)��X�>V�o�V.��gK�7'�?��15�+��TyO����0v��z�E|�ܷ��d�X�8M��CM�e\-�P�����S�����4��i��A�r<��
�1OTϒ�	���XK���!����UӀ�˟��|�@~�F_��[�3���7�w�N�}��:�i�$8���)ế�&���nILv#�x�wD�2��/5�����[��i>� i�.���d8I������L q�`�8ۤ�N@ u~��Xw��'����/�6#90��&��F{��c��oe�zY�6�#��Y�nJ}�W�.�د�7�(u�Ư�5�h�X<�P���(��nI ��XH�IL̹'C�/���mOz#���An�[�+H��Md�/˔-���>���������.%q��k7q�\Kuݿ��N&y<� �ޡ���ƽVŜN���6XH���%�Xy���؇R-Cs�n���Ӓ�}�6�gy8�#y�<@L'�9��`��~��Ҹa,������I#���XJ$,$-�9�p��V����Ѧ~#73Ph�v��M�{-CWK$� a3_8���[-�t,I�0�LL�r4���re~輽05����e'�UR�T+�F��s��3�R�;h���x�����K����ט�b�C4"Vk���U�;2!Rd��oK���H�Xvp���A7�^­���yh\�����9��-wj.���kSJ�آ%��2����k)��Zx��,W��9d.f'�N�9��%�O){����}_�V�y�p �|���5�H��'�TQ����Z�%�/�#t��n��|�4�	�ڷT�O
i��5�R%���e~������� ��#���Ӣl�rr��2�32���C���C�������J_(=��b���>�`9�H�z+��u���߭$
ӷ%*=�lM����Q%��j,��e���+��Аȳ��8J+q>�i��/��w�B��dr�x�d5I�&�;�V>%�C�� K�&��U~0���0ğ�H$�u0�������9M{=' $W%���/MQ�.?:�m�1��?8�K[I�&�0�	���L�z����Nl�GN�O<�"�xhR�J#�,uL�;�eO�d���m�p�S�A������ꨙc3n�~Ӑ�M���=iJK�rgt���y(Ϫ=M3�������{˻M?l��@M����$�厱ү�f��x� ��ؾ����cI�a��X���E�P5�1���x]57�C���%% �#91m�h$w����-E~,�ˑ\O(�{�n� w�{ ���X*�[:�{��e��F�^�3l
�J/3o��^,g��FZ��*%ޛ��tp�k"ޓԐ����Ɗ�N�y�C�3�����gE� ��G1E�&7d1�J�>�/j��C5�VO�)��,�y�y����kvݏ���I v:j��ｯ�m΅p^�ϛ��Ŗ�^l@����de-�'9}��Y��7K��PH��0�=�u�'���}��&3�<%�:n(r��) HXy(]a8A�x�2}�6����'L�<�o.�j�{���u}����sic沞��J1�r	M��ګ:m��&���H���H.���s�AaQ����Z��Hc3��E�c��~�<�;%nT�'���l1r ���kTJ:�s��S6��N*�2/�}�)<{:�4���)��L�p��*1����'�Lߥ���ڤOa���- z^�]����ZS��%T.|"�tx���S=�2��jN��m���п�׼$O�(R�`�͙����=���y0��u-�X:������e[�Z^bǦ_IM6�TxSf�D	�C_4��.(��Zp)`X~���}�,'F筷��dO�8�c:�R|o�/5�d��^l,t?���T�RW:1s�����|�$O��{�2�E��nEgJ�Lv�R���,4F1_�[-ӴL7bq��T�f4�=�}�F0��y��?}�����ȧ���Mfs���Nc�^U]LT�?�ש�7�Z;��Q��Fl�j�I�+s��I6�Hv��㨸]�f��e?�Xy��G�|p�9	�Ǚ���҈$5_S"�G���K�>�mK��sS�6��Oro��^����"�%���'�nq���ݿq�.�"ˌe�=�x�Z#���~�r�>*���v��$���),���c���8؈��bd��kR�$���=Ml�`������>�*iܙS�GW'��)��L�{��f~7�*m$����<2?�)ѓ��q; ׶�<��/_є�����Es-gh?�IMݶ�悱����+�<	4P�d�[���`�
��Ӎ#�=/կ�������������i
��-��u��9ڻ��Ф���C�H	^ÿ����,~�vMV�}R�8X��$0�W��)xL�g��>]�z���9�W�󱰜�K��+���@h����l�hy+�é2��x������(�%x��ލ�G\�kM�s���I�+m�;*C�5mnzZ3�$��&�'��4e�������ܛ`_g[����Pzx לC�j�b��
!p��J�����Gd�n]'�M�����3y����H,�Y��X��|�q���C<�娍L*e�|>чM6:?�~�V�y%��ڻ���jwȯ_m����ID��P���iM��W��8a��X�Q2y�M���|��s짃h����[Mu=�%�(5_�})FF����L��T�����ɒ��.�~`�z���,h+���@�~k
�����Z    �ߚ篿��_i���y��ˀq�������!R{�Vʃ�o�:�?�p#�!U�?&�y���13���+����Qǎ ����B�8Y�9�qO�})���{�r�n�WuR(�4Ύo9I��݁���j�N�&/��x1�<�����.�p{�nt�e��������X�#Ό gܵ��4�y~��0A�I�!�e���S�K�ߕj�i_�T��g3�O�ڗu�F��v���C㨝:ɭ���$_�U�Ml���2_��Q����c��"��0>��K`ߏ��r�I[��C-ܹI���n����~��]
��c�]�=̔�+��s���yA�B�T���ց�9���b"�o�k��lM�b�D���4cd�V��cZ7%?WI~��sU�MIR��5��h�Q7���O����#�Փ��z�j��1��������-�KS
P������D�{��X7��o��L��/��ˇ��pׇ�b�����-���k4��o���n�/?��|�X��	���y���Le{��ۿV�X��o�ս�3Ly�`��6;I�8��黡��.���[R��0�S<X�)$�򊞶��%2O��ō6|�.g�`����_�T���S��=\����#����z*�Ě3����)���#|�{�sH��󃐼�<׃&D��2�Lͼ ��7n����w����~*�I<���|�ޔ���8��<�j�.{����L��0�G9蝣d�Td��FR��f��l�'��ic�������R�1��ޘÞ�`T�/�����f���ٷ#���p=���(��"���i�]�9�	���zV�������h�Ւ��SrK��F�WxkO���z<���O�$�w���/�D�A�����oۇλ�p�%����N�%W�S�`g�`�����!*���m"B*�����v�d�+��6�3�M��� ��W�߳x�	���m������P4&c�2����1�Kj�x�_�o�J�;=��8�RQ�`F���p�יџ�T�����y������3���&y�:����Ѐ(�$��/��e ҩ���9���/hwJ�ۮ���Kg� E�D:U"���i^����Z۵2R�R��G�09��S~���55���$k�@�]���	�17њ��	��Mob��������xj��Ԝ�~7�M�@� B)>�b%��m+��=|����;π|ƛ@�� 2��[(o�{���ï��,L��1#[��Gp�����ߥc��"=���#�F�����Xsи��r뗫/�Ln�����
�}	S,IF|�`�kz�^�����y��.�WY{ߏ�$���1n3N`��R�,sT�@���)�i���tv���^��@�ye� �7kʸ�%����:2����jƸۖD�����kb��C�n~�4�ﰭO����4��]i��%X�ڙ��NR�h���g��`� 7��I�����	�m+x���m������E�e9�	�}{�LUJ�2d[~�5D�s�6�?�T��'�f�+w�g��~�Q@Oԟݽ���Z����G�su!ڑ�'9��dO��r��B��	���،_�q	�>�_;��;� "'�0�x^UGO?�sV`�����,�p�VJ�t��Y�}F���]>�o��
'���+��Mc���6m}���^�`"����	ܷGEav+y|_�	�����*	���÷����2����-?"|U*_'��9"��ga�6}����//C`�t�`���R�����.Ld����t���{����S�g�%}�Ɨ��?�ڛV������:�	�� Kim�5�1�I�!&@=��:��lrK�|O�cE����$��}��}�}x%hS��n�á�"$A$�q�{w�rfԮ��3�G�c�x�'IGLL<�i���:�9��wz@�@��gï�V��3�S۞��8p"�IZ�鑥��R��z[O/��\��n�Y*�E�*���a߀���1cC-D\J����W��
~���[���s��h�Y-a�恜���^^�uzW\�c��^8l*ә_%L.��'S��0�[L�J�5�B:��ٻ���Z��ևz�T]���uei�����X�f�]�[�q'�\��Y�Qi��t�E)�� �������B %��-��������Lw��4�IU�60-�a��峔>hClJ�����$��@���Ȼ���`fL�I�2"�U)���Q^S�n'���h��K鍥��,{j^��)۳���n.���T〭�j���&L�"���T�T:��i��n+���5j�M{{ᚳmK���\2��i�,�J���5���WR��_.Vg"���Zz��w�5��ctL��J_�>}�
��̵=hɟ�0To?���H�+O���}��`���W~w2���z�oc�r���It�������o�aL�2a(px���2}�Q�T�v̺���Z���+�z)�R2���{J3�6Y��!�;��؀~�o�V��Me�ig��i�v$��뤼���^X��Z�"���W����y���0�]��Dۛ$�C&	�����QC��t��"���S��*LM^%�?�!��M)��e4��u���^�P�~6d���t��
����X�¬&�*���D�������/��EߐqO����йtOR�����R`=�	4�ִ�'�t�g[&� �R�&�糯���uK��r�4���O.��5��f�z^?��t3$=>H�L�����疸�T�������&�]~N�V8������^������^�U��O�Hk�
dǓ4|����a<R��|sx>��iS�������N��*uMʻ9���}�����i��Dk
��
rv���ϰ��ml�'���[A�'���+s�N��Mԫ�.���0B~-jǙ,���G���ߎ\4�G.%��ły%���,#�Ӓ��3���L3���'��i�q�l��r�>����R��&y��ߒ�e��6��^p˧qa+���&ӑ��3fӜ�}Xra�HrAd�(���-%X~O�O>g��˭b-���-�ԩ��eN�fV�����?s���3I�)y-5LI��S��� ��D����1��]ʙt���1N�g�9�bu�HG\��r3eh���k�r�����#��$�&���Y3SE#��|ۋ�}\O��}�R��1������VT*X�jN�If��i_��D*���cd
h��~5Kt�?���QW)U/|�p1�F�.�V>��I dpt<N������~�Ċ)<U���|�2���95��Hސ�ѩ�g�Ӑ�O:�>�n+rV��5���pw�%^0����u=��7W�>��e�D��j�����JG9��oMK4�yJU�a�@�!_�I}�D[az�g����;��[�#�(�$����3��\���t�;qW��U�Y�+^V��f�t��2�Ή�ߵ?_���*ܠ�o�ls ��i*ɗ�zʃN�%6X�ތ�x����NRބ3�6��'ݑ�??���i%;�|���JW��>%~�$��#U����&x����#��6蒇,�E�+Wq)K;���v�EР�gy#�UsnX��2,�֋������l����Ef85�g[D�o?׍�p_��y�rO�u��h��h����EH�.
�_I�B��jG&�ӳ��V4v��(������P�t�Hd�K�?�7�$���P�>v��w�3�S�v���l6F��f�}.����P�Ł���ƴ���|��C��E+L��܏����\t���$s]������:(Iq�e�o=ϵP�[/l�`���5��g��gmc�����#N�Oqm�F�R7]��g� Լ����u�z���+�����	Q.{�l�v��D0�/)�1~MH��/F܉�M���9/9���誟;[���Pk[C�|���5/��0f]�⻦5ߘ�M�5f97 L�/1G<be�l��{2lBS�䊝0V�Ѥ�N�ɓ��C���rN5�i��
�B�)?�v��^~O_gJ�ޟ��P��Ȯ����T�gR�u:��i��ZH�}����PA|    ;�r�8��5�7�#�s�K^O9.�x>��i�� ���T���yoT'ӂ��S��Z�L�s�?��72"�D ��Th;�Mӷ��x�afIn����_�F���4�T��/�ϩA`�OЬ�����a�{��ʯ�̧���;����&��q<�j��M;:`:�)i/�h2V���b��ҘV썜�j���b��CN�u.�F��x¼ ��b ~B��TK�nt�h?����H���'�#B���#I�<�B#���|JB��e�ʙ�5K������o4�zk��#����I�`�E�<��FS��ev��@�n����,/�	H�l�g.��)e��l����\�?[���Iss?��f�m	�%4�S��j��a9��q>Qd�|I�O���o�4Qvt��K�S�[î%�����w��zq�R��6�c��v%k�5#&#l������ܴ�05�lﴰ�֦Y\�Q��*yD��ۋ��"�Õ >�o�3~�^>~��U7,rm1>COk�]JO��D��m��WX4�����Rc?���f���|O)�n팩R���8�nN
�>�2�ϳ�N�N���Á�0~�P�s��r5�1��|y�9����G����	^Z�-��)���e�gU{�f�Gm�������Wy�[�ä�ڗ;��wI���K�!s����}�`���l�`�,��l�p����.1��K�?�$�T�����H�B�N��;9�c����;(;�H���V��p�_^��#$rl��3>��.er��|ĝ���`03��5$w4��\�����#�V=vhH�`3�"���4��e59�e�Q{!�ӋZ?��E��a
c�'�]{����=}�w�V[����0�T�Bc�JsC��A���dN��p�W�!~�lg�k� �v�(�]0��ѽGJh7A���`�+r�P+.�<���ߧ�t���a�aa1太���&E'�P�fY��L��a-C����d���u}瓤�7�e�����2�|8}�Rb���H���i�U�*��Ǘ�KŐ�q�_&؏�D"�F0V��� A g����Z�7;l2S9\����grb��8;���)�)���^rO���(��"ݙ%%A�$�1�'{N<��
~����\���We"���>c�}%o=����R##Ł��U�K�}�7�����\�n��	��'�`���{&"�B���I8Y&n�w��hK�O��A��5�Z����,ē�K�m�z�+��-�@��C��l�J��W�>�%��Uo�t�hC�X�4V����J�t�J�W�l�cl{"�����x�bkWq'r���-�='&W0���:KEݴcd��M*�d�җ�/-K�-����t�י���|B�tA|L޴	T�W;*u��aQv�MUG4X-��][��Ov��))f��<'����2m^}�@�\��E�����	͕�� ��x�Z�V���PB�#�jW�~>�
��?9���~v��&(I$��p���c�<��pG�H푬�K��5d�h��][�rJHJY�;|L7e�714�%���-y��>i��I=-�^�+�?ާ������g��7rй�k��z�I�,���+��p�\�R�;�i!����%$x�Xi��cͰ�d������n;�jd�E��E<�r3	$��G��;R���Y5�Z��1%��M����]FhG�^��|�̜r��cG�6k5��!IŜ:�ͣH�a��/�S�!ͪW�ӳ~�Yٷ��H������Y&o�v����^[^�>��e���8��M�*���i���s?�s�<�! �h
��s��+;yJW�j-5��|��h;s���'\(��ZnIfc�
b a��F��7%q/R&�d�E���X��Q�L�[��@d	`���GI���I�J(I��J�7�ސ	��#i$e����5Q�Z�9���iI��~*������1;'4� ̺y�tGڽ��1��LiW*�d����L9u,�~������V�1��ҥ�t�wH��D��dt�3=�(�&�!���˖�ƢU�/�[���>�M��S��#�����9���U��6�q&��c/ <J��t�6aƢ$�l�ԝz2%h��)����{��3�����L'�����gIm���l?�[5Ab��������XU����s�I�o�����=��Ր.�TNϑqa{�4�*��Dǔ�i&�������Mk��U<��;3���P�I/�����g��}��\W����+9�{��˩/Ug=�$���jlQ�)��QM�\����~"j���0���\���B�&�-1J׋ٿ��d��6S47�ۤ�%��pO& �$�\�CD5�Fh��c:y���ʅ�]˧X<Tl��N���B�g2�H+�����N��7�%����}�ES��B�h��o:On�7-_f��4 ��8�zw	-1|�&�Fn Q��I�� �P�EJ�HßW���w/��%���|pp&*�de�6�-���	��K@����m�Xs�U8q��츧�na}Q��J�A9J�(�� "�A��0NS���cEl�Z�}����|�c횪���Љ��M,�$�9�5�
���t5�x/�-%�$��D_8�M�'s
d
;�j�7�Yԅ���@ �Ts�Ug+ƱW�P��u�E6Y���'���9�k>i"�zW��rLR�r�1'�1�(<4;���J3�ŃxۄNwN�r�������vN�w|㽞<r��n�a�(,ϗ«����\J���A�/�u	['%=�0I0m���q�Z΢�M��pĨZRp����'��������z^��� 6��_��)�sJ���yg��= j2���HtB�2���'��da��=_eE|�L#tJ�v)�%�o�}��r�L�&G񔈃ѝnpy�=�w�_Sʞ���l��%��f�u�I����4�v�͋�5H�(�������q��墠$C�dN���x���Nks�ǣ֪���V-y�*��Zj����P��s�|�����J�:��ڢ�$�'-C���<���t�3�Ç����nF��IIR�@��!/e�	����R�\O���i�q�w��r��buC]޹#2��60s&H�ٿQ��4�	�y���E:XG�E�bl�'�R�c͜�g����b�T�+�WΚD�P�ọ+�Q\FOmM�k.����>�am�Uߔ�N
�5��K� �w�W��sÃ�ާ0>�q��f��0v�he������a"E*c�]��46�.+Tӷ�����8ux�X�[R(�w!�����EɞD&cqt�Yϝ�9�VQ>oJ���u!gcΘ�j��eZnpt�nP1��&��9�0�I����s�z7��D��V�����C���bW�پ$D�y�|�9Y�F�W�v���H��{���ɀ_�dF}���z�vc�IM��w�'�FG��MS.m.����E��[E���&i��>yo-M%*:�̎SH�!�/,�z�k:��Yl�/rp�\�Fn��f7	�P���B̏F�[j>g�V���$<��Yl_�7Q2��g�q)�oK�e�c�����Q�00ʭ���C�ǚ��N��AN��-'�N���L�f5nɯaƓSJQn��O@˻M�K�4`�d]c�ŝ<�7����!�����(��E�5�d��$g3	��uo��vO$�D�"D�*�%��Dz���MQ�X�da�V���*�ҹM��0]X/�ʵ������+�n�
�o��)&ï��j;ߧļֲf$t�J�Ə�S��y�#� S����� WSg��q:ӑ�P���%Z���F\��@�$X\����Sٚi���L�A���^0a�����5Hcl�,�
�^wd�Vz��(z�Q'���*��`�t� &H�
WZ���%�+��hEWx� ���ɏk6{O�L ��yP�=v)ڒ��K�����JIj3JQc��Y��&�,����R�DՊ��hb�%�<�gɠ$_�4�!g��ˠ�uC7�0G���̔���{n]ڏ�F�y���$@��$Ԧ]I{���A"o@�p��fi��:K�i�G�Fv##/��q$n��×.i�g��73�&��jش$4�=�`�;���C+(�括_JX����    c�[n{/ɧ_�,�����	����o��H�!�9fr׺��"����9��x�g��H�O�L��Xd5Ձ-/Y/1,�6�'�
��?'���'-W�u^3����n���c.��|��eP��O����:DQ8���kb��ml��h��&j�ȸ@[�~H5��d7��iu�<lh�v6J�3����G˷��J��K0�ؙ�Y���.�Ǖ��>$���s�G�҇���܄��o�p�R�1��..ׇ�-��08��k��j���6Lꓤɣv�$��Z1]�3�d��v\���|D��cϧ����YH�O��΍K�h�Y�}�~z�����T'�
�Sr9X�}��:�M#����y�M�?���������X�1r����־Ui)�[�\`ʃOa3s���!.�[��椵�
Z�x�J�kb1�f�%��\�`����e�<{ʩ�s�{'�����m>�{�f�y�.�05�41�)p+rb�[�C_����SZ]��|7���R��t���N%���I����)��֔�fa��o{�}�/9��r��_ʂ[3m/{�}��[�� -�dMm�3g�s��g�z�|��ʇ&7)O�Q4C&���
��L7�i�.~#�'�����#�c�9UHhK�!�ui"ǣ��j��&G⢛��CN7���ד�V)zv��"����(�����a"��H�O
AJ>y�g�j-5�H��255'_���d��$w��`(�XgN_�*�Ϥ���
�qky����bzs=���ʽ���Tt��ôbn'���$Nfϩqr�rO���r/?�����j;�������)�a�*��0����Z�x�����}��[�#I�?��d7��q�뻤"��}�fL����mM�@�R=��ŰB�>ie��í�*t쟨��,��'�����J���b�7�OMF��wLL&���ըz8�o/�%{�teе���8�+�Ի���4u0曰7`����m9*	�)J�g7�LeA6�M
HI��ʸ��\����
הÚ�5����fn͊a%��b�" ��E�$�m�M���y�"�_ц,�W�V�V��3h,�TY�E[�׎QqÁ����]�(��sQ_s��<�J=��h*e1���*�h~�orzNy

LL4�+���6b�zb�I�j_�+�I��]}���&�,��H%I��)c�f�i�<f�q�75������c
�7�Nc��#�'�7�͛Ks�'�җj�¨k�+_�r)��x��N���^-�R��?����mD��
 r�0Pa��Ko��\��匝WP�Mb�"���0A��*`�Kf{�i���)�Sj"�U�$�X#���6�^S���F�B<
�Fm:�z2��m̕����}d�DYx���w���1.	�'eR����B�E�z@�q���O�&����F9W�|Y��Y�b���?�6�>�[J�b�
Uߥ$̟2�A}�M�eF�W��K�p[�x*����t漰�c�JOQ��,��tp���&�t�����c��*yDb$*�6n6dg�v��K�S��<lni��D���$+�=��i�β�9�@� �]�<�NX��J�0w�t�ʗ�%MPz�֔g=%֭_MkT�_B�7;�?P;���.�$����T�R�/S"xB�Q��;��ilœN�6��ř�kqY�s)�W0�NuWo�Y ֔�+���sy��o��ȥ������0�抠��n}�:��������KA�%��
��U�Q�|���4a6�� ��gF�*�b��H�L�|��	DXK��1���O+�6'i~N�ijU�L��I�/G��K�k�_%zJ��K!>�#�Wyʁ|�`�~S Z,�#o91E�[L���:S�1!�}��?O�k���y1Ф�0�/�u6S:=��R����o�����!�[��k	��B��1B�O��}��2����Ϝ� �7�7��M�#�L9B_"���>g����N'J�(qiP��'$H�&e �B�R�|�PZ�D�K޳:͟9�Ip�Ĝ:����*�0��h��,k��}��:h}D��O��z�=<HPA��sO"�^z/pn�V`Pj�m�i���x��o+�����0�-I�H@��1[�G���˃H%w����6s�$�L����+���I��4"�m��$Pj�~��^⥲Iy��[O17館��!���`�&u�L�	��Қ�*椏r��-�1(!��կ�˱�9ə�<�&����eؔcE�wKJM���]�*Vh=��v�i*)�[��9>??�UKq��V@��CG��<ګ���{h�|�ǿ{Gu�����?�_�E��D�A3�'�:1ĕ���hVRڹS�Ӄ�u�T^��x�����Y.{�����(������p�s�P-��W�5K�ٍ�󌸒B�� H77�<�hs��L-�m�w��z玼��1�(�{��D3YP�	��y�<͠��.�kO�}�"���.�����
����X�HǴ�u�58u�I�e�z�a�98S����#%�;�����^j�������k5QBM�	�#=�юC�A�Q��|&��]�y9<[nƂ��C~?.-%ޠAM�,=��a��zfǠ֪6��d�d�����^�i�����f��*\���ty�(^Ų +0OD'L�I�7z��/gu�����D?	��w�B������	��W��9 \{�z~��tݓ��Cd��| R���I�M�f�Fyv�Q��<�L��0�L��ы=Wɾ�����ί��G�s��R{��5��i��9��\��w�^8✕�����(��bO��.-���g*�4hߎ �Io��͔䦞�$�Y��Un��o�1i�փ�����"��aη�WZ�ܳ��t1�bӒ�����V��#��=�F%̫�O��BJ;_fӜ�L~�Iス�$)��V������W�'4�fF7�ׯ�N7i��Z�yO��z'�+I� ,O��Oq>��WBψ�[r�+�k�'5Ł���dL	{1(����U��=��H�-���,N�[��מ�r�6M�l�b�*^�Ô��(���=b� ���7Y����q�ϭ^#=E�=z�̒$�\+e)N!�T�A2 ���S�]tt����=��oď�!Eד�ת]��S�hA�a�J�.��K?h��T��)]s���K�WyC�璥����%Z�Ӥn��)�ߩ|�a��v�y;^B.���<�I(D�ٛAmRr��u<Z>|�e+�47��O��L>�	=_ m����9�I��n��И�/}
��5uEB�i}R�UI��ǵI'���~:�'�-gs#�tpJ�	�����	�r�51�=}x}�>�W��R��G�B���g��Xe��5Sii��Uk�cwN�ޣ�>���d��.�n%8�<�E ��'j�e{*C�w��ՑP4m���g��p8E��dRǳ�5�8Wʫ��S
��d�o��/}_~�>	�s�Vp�V'�m����Sq9�<qi�R���Ę��C�(�mOuT�۔/�?��}�<y�'m�Y�׾���?��_0������?<�&�����z����)f�?��o�׷����������ʷ�wcO�Y_���-�!-�G{�L`:S��JW�������C��b���H3��(�J�"=�:�z��n�ڽ�b���\]�Bz@��sX�Z�}���d,��;ɪ�4��&��c����EM
��
8�b	s2������x�Pb��9L;ָ�/����Ԟ����fR~����l#�}��gs�)���L�R�o�3Q�U��wk�|W�}S�Աs
�V�T����'P�I
C�\7��)3�i�Xz��G�����R��5���Jk����'�P�j�s�&RFak��g+N�e�����פ��_!�Og~�25�_����?����?��΃>�e��bi&��,�D�8�Q�Ŝ���_�k����2y��_��4Ho+Z��87ӗN�/���1u��� �dUB1?�E�Tڶ4���2�"Mߕ�73��ɲ��@V0����b�H��e�Wj�2����o.��y��ϳ�T���0K� y���{��J�J��ر��9n�����x_�2L�W���w�;����	�4�d��    ��統�4
z!_�K���E��%4��I���l!ڤ9��)�u2���_9���/����G�-ϣ$���b~�<�E�z�[?�t���M�G�7���`:�u,wkΜ�y%+��A���y4��"}�S=J��lC��J���I�Hz�~M�#�.����n�5Nڜ�)��4Bm\BK	J\�w���{.ޘE����C##�p�[������o�8��OCM'��xq����)�G�� �`p;.#P8o8槼�j�r�NAK�{�5�~���!��-�Ѽx�%�?K��θY����m�q��rl-��Xm&��丷�/��,9�y�y���O�	�d�(Y�Z��SB�%���g��y�I;�wC���:Eo��X�U4�=P-�(2e��;~�ș�^Z��akyl��m3����a�����y���Ѿ�r0�8�w�,)p�^+�D(&�4g�=]%�i��Fl�T��Q'r�<�V�WU��Po��(o>kӴ��t���{�stVJ��
[�>=��}��������KtOeqLw?.��)�cJA@�h�0N�	КȄ�KP���1gE��#�iu*�DF�T)���D��I�XSМL�Gy��|4�"���n���aζ%���H��~bJ5x��
i�@���ӧ6!0�%�������L⼻�0��'bp�8���#t�����>%E3���j�,�����;��G0?��ں��9���%JH��Ĕ\�.�r��wbB)<�����9���4�&���|�5N@���%jǵ����Mu��HÀ"Ⱥ��"%Y>��"N���Уl�H��3�]v�9��i׈��L^-�!E�B��>!�_����S��T�[��xOB�["	2t�������]�g剺ȕ���L��iAR�W���B-?wn�v������q�Ty��`Ϛ ~w$ׯ��9Љ�u��r���޿apx�}�����-C��V����PM�3R�͏�����%-������aU��:�y*{�y 1��j�=5�~PF%��2��+V��oß�д�*|[������y#t4)�����:��t�)R)׳��ܚ�mK�oGA}P�%����Fp�'�=�F���4�nV),(���@/o�Kפ���(@OW���}�C�*pP�1<�~j)X���X����7m���ӡ^��i��S��Ko��L�2;$7�7�f����u��y����⤝�����AN!�������G����S��HrP=H�ҹ�q������ds��p0�Rj�����u���&��e^�m�y��-Q�]����ʗΑ�4����Jԛ���=�T( ��y!��{I3XW{Yo�
����/<��<����ײΕ��0q �髠��."!7��SA��D��0�%�����Y`�=o�JzX��fN)Px䤥T����:��6)_w(P�"�=��g�?��������§�����?�ne!�A���^|9`��d�	~�UB��@t����Q��I�wB�7� ����?��O�&����؅��[u\�Ğ~.��$��}J�����������4����'��#W� �S���g�h[Y+���m�e�G"�Q�_���Ľu�v�Z��]�Oy��K���"y�B��&>�� �o���<�����Tn���E��zi��X9��`���:P�$�}	�4�)k9��b3���s"Q�-�|�&$�iUj�����́�a�i2vK����FWi��&�M����Kr�i�Hyu�5��;�'��ܨW�&]!��@��hn^N
�d�秖u�8D��wk~	B��[�/j�l	�.�W��d@�|�����ͫ���>�����uJѐ��w�˟��O��o�a�p�o��RȻ��k`�^�8z����0r�@�Z��گ��c���|͵�l��2<u:���L�Z��N�벽P���Z�����e0sO\�=V6���,:"��1rh�i̢����]�Ub�=�ݓJ<]�lH������w
�ty���7;�4�gb�.��Ў�)y0*��G��E=��a�*LŘf�a�=�7ӼY�> r ��$�+�)Iܖ�^�<����h�v.Ě���Z,�:�KY9(h��hy�_;T��e̋]0g�Ԕ�ϗ�9���N=��^�9r\?s�M�c]'��-���E��{	�-�s���X�I\ieC��?��@�6���D^�\�MݨV��0��f�ڐ���!�R�&JG��ba����N��#ᘖ��J���b�a�H�1�*?�����Ҙ4k��m�L����)��F���i�"�W�:�3�ؽ��F�Xo+�)G��\\H���H��-X�O��Ԅ������i�8C�ߖ�w��*�w��^z>Z:0/�M�6ܣ��QJ�K��SF�����ۡ�q,�Q�"�2��L m%A��������C����� B�>(]iE����wX�Wkw���@�&�Ќȑ|F�ќdŏ���N)Wn�I)dS�r�y�qC��<�{f�f�O�%��J�mt$���W��/B����_<����_�7�='.}�Ds.s�W�ׯvv=%�9Ӈ+u�%�#l�^��i
�@����/W��dn�/�hӻ��>�R��p�H�Ha��|}݄�_�%���g�`�f��)���8Cj�k�:ń=�ȴ8:������]�q���H=R�z�@ʣ褶��M�;'\���ƾ����	ML���=م�6T�~F�;տ��Dm�0�^r�v ���{N}���6�M�9�6�\Ӷ'=���s�ҵ
j7��}�p��&���bN���o�K�w� ���M��5k��b�F�� ��N^9�L��Dd/MO7�����LZff>%���;յ���
NT�7��kʓ`�C���6�	�˔P���V��0�a��d?�`e.���֤�٩i�ޅC敳�CF�%V_��d؏���pi{y.a�I}�q������Ι0�ADi�R;���Ic.�^1�*�12k������Il$9'^%8�$:^����G87�M��'��H�9$�d�^�ƴ�ޞ)l�~�,�9�r�*a�)���`"q�<ʙ�ƺ�J?�,�k@��{��br��V<��|�jm���垑��i&a�+g�)q�g<ɛ����B�>�:���?�>��r ��d�Q�Q!��A���m%��|X�+Y&u�P�l/�{څK^x	����ڹ�]�)��y8\6�˔��)�$؉}^j���gL���|�Y̛�ڗ6�\���D��>�]5kg�K[	$)9!�v�v�y�Gn��7��痺zMM�ߵ�.��<��Ik5�IbI�T
���_�W�����#��sYO��Hc#���d4S=l	�H�ֿ��z��0�	C벓.�����a t�%i���Y��ί���8V��mQ��� Rߔ���yN.�B5����R�L���Fp\���ĈQ��TK���� ��?F�j`���S�=��@rmW���\������0~�E`Y�Y6�<3���*�ۚ�У,�Y8�����>j߂h톾4�ҕ��� ���[��O�i�ٽv�%d����2�Sȵ���a�i��l�yJ�=ߗ��ʻm-3�����-�ڄK� q{��;�SB\��y���>t2iP�i�l�w��\ӳ��>�_��.)�^����
;~\z��-A�*�b ���9ϕFWs� �"\4#���J�}�`�ͥ�EZ9�h�9y$�L=�qs4�l���)��mz?��9p.�z~���ܼ@.�ͷ8�K�N0k��V�)N��]�)'���]���j�{z�|���S��5Ҕ�!�T	SW���ђ
9)�S��ƾ6��������6;BW����2ܖ�cI��$����0'58M�@�Uf�;`�:�]���Tz<H~���AϏst*Hd��B��=E@��~L��I������)��HSDyh\�6O;��h��G�E'shF#� ���C8h��،$	�ĶQ�-NV��X�b4��;
)�������a�JP�0��
�foMC	�i��kb�y����&Ͻ��N��tjjV#>$҈�B�w �ަ��    �z<)R�\jRm�?�v&�sͷ�z�1����n�dJ�c�����t��6�����v�ʾ��2J��x%��)�A��[�2(�w���D�~�d�0'��i|��?aF4>b�a���M(mH��ͮ��yb�|׹������W��y�� ��/FܽP�^S��ȵ9�0��~-Ѫ��F�3'�f
l�)y(���8�9)%��Sk��D}'q��*I.���
qqh�<�S/9�A{�,0�Dc�lR^����H�%�J���l�(v�e��ZXw�V��KD�[�"�n���H�*��#��͇�����J�)F�fhm�F�=��-�p8���G	#�Wq[0��%��d�?�mK�G�Z��2$�lW��:$S�F�a�S�|��w#y�[o��㙈�+�DLX�F�����f��e!�q%��O:��t��btU	�X��gņ2W�=Ź��1SޏZ!#=8JÆ�È�4����r��I«m��)�������]��5�6��<��gVJg���Ix$�,t��9��2�w���]tG����ݹ����G�}CT�f-d
��`��jz޹�;X�D⫴�Y�χY7��^O��,5�8>�x���RzF���>)VN�4�*�Q���Nr��p{�Ī��eB2%u��v��rN���]��6��-'Y�����nʿ�jt{;,�A�7�x�iBKʔ�O��e�����O��bBn��*��� �#���z�C>!�$�<����۾��Ϥ}h������?<f>�ue�G-���UN>
j�C����s ���Aߧϙ$��j���-���-�q%�_b;���0��{��� `����ULH��Jz���9���ٗ��oI�V���d��Zj��o%���5Aԋ~�g�޾��~�M�Ý9/|�/���v�h�BE(���r�}��'0�Cڀ�����s��]����7Jn�a�Ǐj�����������~��s]l�i�ńP?��<<�GO�퇁#��[��
cw6#���/�� ��+I�.�B�8j]-����a��mK"}��Ӂe�o�������	�o�馐�|���b�v�I[g����Р����TX�V�/Mzz�w����Ӱ��'@����F��������u�5f׽�s�$��q)�]R�I��\=�&������1���L	ʭ,7e�p�X-�h�������&Ɂ�b������l<��A�s�3u�G�*��S�%k�7ͬ��T��
3��i7\) 0y�nD��������
�&�ķ�]��FJ�@(����xn��������S	��MS������9��~��u�!Q�8�xZ�;i����k�'�nf?8M)�F�L�`��[���ѥ��JSg�XM5�`O�-�~%DU�%W����S���(X���u������='��O�|t�`z,(X��҂%mU+~�z��ʿN����Q�W������\�e>6Q��_�3�S`�s%����x���2���̧譥�D�s��ܩ4?�ꮲkN��M�
�з)'4gpK�*3���K$fIp�ͥR���a����1��a���?֗����!�*�#�n5�ք0�I=D�WV≳ۡ-I>���D2�7e�2����v8_O�Ȧ~�[��X����< kL���MW�����,��N�SB%���MM��vNE<�WS�.��C����ȕ%F��w@�������r���Eu�O�X�ݦ�)I��?���()�.�b�vRAO�N�&��� �������S�i��rc��iQ�zSMΎ��~7�ȗ-��$_�f=M�,XJ�ԗw����t��D�߮��)v�2%Vr]N}���ZO��zN:-W>�9�z�[��&R���6 �'���f����-�K��<GZՔ��eb�щ��\�@NÕPׯ��N���IWf-��b�ޜ֛L�c��\.�j;n>��|&��e��1rN�ձ��[�ƪŭ[�H�z��f�tK�G��z�4
��[��ZI���F~g���DD�����s���lr��"֒i=���Q���b�YOr�sZ�,�O�I�e�<kR�Sv9\�W4�ٍ�p�p-�W���2!�2b
PK�Y�X��Z�L������6^H����v�A�d�I��X������ҏ�����������93��/�aGY�$������2b9�)I.ҋ��5���J�M�p@̀d3.��
���jNc��3�6!==p

��d!� ��~2r��`#̟̌��7�ă�oB��m�1�{l9���ے��$+��yj$���r�RE*/@U��`�/E���N@_��%f �ΏP��EwH��dm����Y[����L/a1�Y�p�<�r3x�fL|�[�|�;�O:AS���?S��R�1�?f�9����Hb�=������O�̽�Im'���%W�+���l�n��;��*	��*�עEN�K��x*R�;�/%���L��� ���C�Nݚx�Μ���s�E��|M}9��Iah7�T�x&�.Q��4L9��3�&�`D~�qɃ4���r�E�=E����]��3�l��<���[��8ԯB=��\ƳG	�^�fR�^��k�����f5�%��0"����� �%�<�B��A�utF;Z�D���-d��5��In����Sh��	�⧐\3/k��B��"A�w<����;�vP��c�g���)��9�ӓ�^y{ο~҉,�4\B@��4�>J�O�U߫����yN�8-^ӷ0�˗�Ȣ0�y��n�z�D�lC���f�K,�^�{��
�<$��2�X����n��LU�t5����ד�a��꧅;���Emt�y�z�je8tTɖ4m1w$K�M9����W�52�<����	P��}�9o�*?�����bI��7���O@h�vއ�.��d��$���JS�K�ˤ��JShO0�LAq���L�t*���b2�u@.3o����h�����-@)� ��R
p)��aΰ��.�Z!{)�µ3��!�UH�,?��m-:�Kt$��O~t~Xc%��eg�}�+1�-Ƽ�b8� [�}���_(:���O�`���[�ɔ�� ���+=�����E_��R���ZS��s���z�?ѸTc6+|�{j���7�&�g�@f�0�n�d6=&h�)>7.�T��jH&� �6�Zִ�%�HL��K��z�����<�&:#�<	Ʉ��B��}D����V�ki�Z�'y��/F�86����A�z/�%uS��=��ą�r�E8�e�A=��k�>_qt ���_xF�˛#��w"���~f�͕v�۝H~S�+��i����F���cY�'D�Rxr?^�ڜ�$�m*��͚h�T�)Z�3�dPKͶ��W�& ��%�[8� oKZ�kR6&��m&6�4���eJ�n`z���9��Vi�|��4^ਇ���:�y��~w���/*�z���&�A�O�T.�(�t���,*�
�w;${l�����V��,<S�Z$����[,8����xk���s���%��2���&� �1oD�N�:�Ű3���z>`B�J(�M��XI�f��2�N0�����	U�!ЯI�yr��)K��~s��&B�-ѳv���O�ky��Y��YH����F�������4�'o�T�T��_�?��\!n��KBoJ.O�!���ga�^�����z �S�<I�_�c��J�-�ta�;��yq9��2~IA��?�sK��[ 0��5M�i�4��.
���[��.,��������.�l"UbN
i�'�,+�5��g��eCpܐ��n�x�T�����j��[��+���E����j��C���.��?�V�nGy�����U�\K�:��Dō>n����D��Z��M��s�.*S�Nr�I;�$����b~D 4Wt�Һ�eLʥ�� �<ڥ�E+�mx�	�T��P0���qYY�$�A���k��h&k�����^�B�/����Cs��Kn[io���]�+�K�I�(q,�W���­>i#��s���B^.-��j9ȉ���.&}w��O��hajJ��r3rcʷDU�m,�SD�+:�'����Y)�ُ    Ym���_5?�NC�bG�Ր�kWY0z��++���y���5��A`SE>�� 0����7߲�\��`>
5�e+{L���%���8�G����>���o��ɇ�D����2� 6��5��ǖ��ؘZ��8c ���VQ�b(9��d(������P6)Q%}�b��_^��eo�8���z0�����oq٤,��,-͠��߀���x�a���DHd���)���hCc\�;���z_�q��73o#�<�R�(f��n����,���eKC=�>+N����>�s�Ӯ�4�f��к��H3U,�D���Ja�����Q�z��K�r��9y��2�&/��dUÎ|�������(���0����)��Э*�����'��tc6F�a��DR���wwv@�m�	�Z�aQ��_�x���?�*�����ߒ��_J�s�rj
��-��%�4�w��n,�n<e|2���&R)��7��㇧XZ���m�#�|��3�}��\���`�1��!�z��K��j˕`���nin�.$�9m��'�һi`��@3H�N�B���:v �m(�ͺ��n��m �j,7���z"_rQj�E���MI܋CMJT��<|Hg%�.���F폛Qt�޾���F��`�c�tZ����}�m��xSOy9��r>�� ��bJ�64͡$�_���u2?
��[./�a#�ƣK� �!o�A� Y�����bΩ9���\��z�ݫ��)N{�;o��'�;�-e�"��L_-�ƌb��S�����`S�=9D���m+�i�<T6�tEX/��sSQ{�%.2���J��.>��B�(�N�JG�L�O�Tu9�N���`���UaW����)�M�eB{׫��@Hc��H�5�4��dŔ �o���|��'����'��Fʆ9����_Z����ү�������ȣ��ݿ�w�i�s�����˯M������xyW�KZ<
𛍇A�/
Q{����6QnI�O3�0<W�B���VIE{�ע'�(�H�ߧ�%��Z)�1��r^K�w��n�H�%>n�m_Kn�fi28��KT�b�6�#/��aߔ���m�{��s�����[�9�k��QS�9]	I]]dL�ޟ�s3a_��R�UL*��(\K�Q�M�����l�ڽ��	�k�?�RE�3�)�4q8�wc�D�>�#��Uj��o�^j����շ'���e���>ɀF�R�Lsc/���9�5i���RsF|����=5ZM0r
�WRl{0���$�獕Dw_������[|���j�w2��;*����$�U���tk���)%���g[�����|��{a9�u��7p������<�� ���͓�٠�7�7`�I�i} ��|�Y�8]�Η�ʪ8R��Q��m޸%T]X�������ش�co��Y?%�����O�,8xr�zmܒ��)	��mk�����pO�B�c &w�Z���R�M4����0,I�L�:���܎"�u��̦�<_k��L�>������q�ʃe�'.��c�\�d������_d,���k���b<�Z=�|L����Ғ��;�A�I��SM�[��n��g�+���C�1(��j�,�Fї?N�^���~�&ppK��	.4�r��^:G1����*}�͙v�Yx�?ҽř�nz��cF$A�̋n��{~ԛFdzo8`�����b]}��W�z�w�Z��Lj�fb�D*Ԍ�h)=�5����j�Rr3h5�K�>+l&�|����$O�����_a�4'��Xy�<���s��mInn#��VqCS��v��,T7,]뙈a��qq�W	;�;%��ao�]�Q�����DGvX���!v�n�~I��������K9�cY��D�D�Tk�(�Y7��Tߍ��J��&(���L���B���7�\��(����)c��V�.���J3X�^����%��^���*XJ�X�y�m��1�*�`�j�w�(��5�`]d��L�
���J�ޠ �d+���K'���M8�9����	�����`i9L?�<{�z
��R�;�z��VN���R7K��t��҈W�}��RZ'5�K1{��ə�I�i����)S@y%�?��<����A�JP��x��{����r��p���aoe͉u����@޳��%�6��#2Æ���K4�
�4�&)~ߓzW.M��$9�L_�h��AO4NE��l�d�������ӻY�Tܫ�&���,	��(�/�B����e(E�2�{�D�䛜ĭ�T��/	bi��0a��˿��c$qX=�^�Ŵ}M\���q,e}fj�ur�;�K�;}��0'��荔���yb�R����;�ZY�P�fF�E�:��K�q|ƴfl���E�:�虈������]�aQ��a㎻�>��;���NKy�3��ֆ�u��T��@N�I�S����)�^�W+��y3���w44@a��|�;��gڙ���Ѭ#��Z�,�S��jO��L#�(�h��w_��%���j+�[�OZ�؏�9�����iz���t�i���:�ma��1Vi��B�i/m�|���|sa�D7Fr��-�sȼ����U��z�g/�j�Mz}RB�9Q�H-�X6���]�c������R�&Om/ofΖ�C���I���\WQ���I �\�đ�I�}��L]��EIQ��X%9��QA[:��9Ig�5N�����g��'��DJ�����fr|��N����B�8��w�r��)?7NI�JQ:��z%�A㩓2�~�
B1"#��J�Ĥ�1{��#�8�Γ���S:>�N���k�9)SY��79yyߔ~�~�p�->�ql��)j����i�X�X��|o�u�M����t����u�M[>:N�0�]@�R����s�2��7������H����JRJ�I�sxcq�-_�� �̒�B����F����$W]В�}�����9L9{�U��^]�&�&/IJ��坾�>+w�R�Q�w��UH�$��YUNIj�sO6��hC�T-�h���;��S,��9k�;�o���5�gS���&�q�
)�j��]N:)��J�5e0>O?K��>j4�2o�^>�>�o�vf�'͐˙��.�4����'�h�]�xm+VބX+�qP~��F���
:�<-A��0,�o�1���(��Z��a=���?�([��[��3Ӵ�~���������D#�r$��L��F{�=>K���;�H�7YF��1'�D|v5��s�O��#��c���U�唵��ʕF��i^���Jr¢sZ�məM�1�>��t])4s���>��D��QS�p��n�n����n��R�X=��)�U;�|�g�焵�fnx���G�U�\Tzeɻi�Q���`;��X�~5О8����yZ��2c8��t)�s����F��IH'�|��b��N�Ulc!�S�	V~�5G]G�h)#��o����RU0m\Χ��Wb�����Vxf�6� �.4eI�G�
�F�Y>��v ~Ȇ��v��r3$��xDg�����K�k��c~Ύ�{0W*u�Wv�A�䜓_�7kP\�w���T�`	�9U5t���E�ؔ	�d�U����$�A@(���I�H��S8�:�K�q�L��L����0[�nw�w�ym�	�%R]m__a4���װ�Mm�u����I����<��V��,<W���O��'�]g5�_�W��P��ė3�i��ȵ�bt�}���R>��.���gJA��<���ͩ*��7��~���t_)�Ǖ�o����d`;N���ࡵtcs����覮x�d@�V9�œ���Y67�M?@d�of�r1ZW&����11�E�Is�6X�i�mr�\�Ǒ��C{�	���2���#���-�6%���N`����h袯����'��"$o��8��6����& ��v]��#�2���;��#�0>�T��Q&NP�T���n*�y�g.v
h�=���ĳ�"���VZ+{�O�~Tz픦�R-J<���̱��u�[��$�E�/���R���ă�͉z�3������H�������5��^K��=�D��ߞ�V�_���^�HC,��[ۣ���WJ�`��J��8G������    ���9s��:���A�2�y'|J���N�=��Ѝ��j(-��*g�	`f���p�?��E��OK�� G��'���11^!LAI�����2�#�=�Pv꽄��2�>Z�)�͉'%Nl�ۓ�����ʏ�0	5�D45�$��є@�Е���Ss,$*t��d�(x�D�PyS(99 ȺO=�\x�9:�i�sk��7�"kd�������n
B8�oN2ҫ�Y����N<mA'0~�+P#�~���e^
¸`�H1Z��% 0О��Xa��,�
n�[o�����l�^� !�ܗ�x,��h�Y��28�p^����F9#),�n��~���=o7��S��O�����_oήA�g1�xB�N7�v �#��dA��gKo����pٓ�e�|� �r���'&X�A1��9�<(~=�!�=�:I���D�m������]��'�f�8���)�rx���~��S��g�L&���ܯ��Oi����}kI@sZ���.������ndFC.MU���W{5�邙�*��:ށ\�r�c����Ĕ%�=ʳ���v�oW+U#�Oy%���ٸ�/��.M����c�T�m��VTÍ�ݓ{�p�N��%���'��ŕ��z{����݉%�'Ky�,���+�Pێf(�v{��r�¢=9�0ig�$��ޗ�� r��>�A`p���y��������v�%�sCM��O��g�]�W����M���s�=a�
���tsQs��^ ��G��[����w��W���_ܷ�o��t�z
������}
K��&!�3ˉK@�Uf॔�|�[
ɈZ���ֹO��8���=��L�L�Q3;�����B&����/tX�>/}����h�Q(�}�Vr�X�>͎��XCYߐb��=9Dȃ\�r:-)��\�!Aw��-q�Sz:�|��7n����g�1(�9u=I?��t���w���`��$�^�iyq����5w�#���֟Z�v�b��/"�G]�Q�ٔ�6�������͉qȄ��<�y�ٸ�;�<��/+���!Η�T%\3sF��O��$4c$��MCb�{�x����xj��4����A��A��/� ��`h L�Lq��p����Y&�= �*�<sJ��d����>������5�gɾ��7�	֝�\L��)�Z.��K�~3w�����%��{�Z����s����לHbiq���sgձ
ɏ����p2��C�׆
EYZ��	�;�;L�5[�Z'�Q��K��2^
��H���H�+OjL�N ��1�V�ip�lr�Ě%����rDT�9�Ym��fF�>�
}݄�NS��,���s��T�lN�� �T�Q̩_l��m��g�B"=ǰ���?��4Sο��r��Z��N���*���9�2K3z?<Q��QG��RJ.�hi"�+�2���4�����#�7VfC����:ٮ<����i{�X��'��\���on�����ꨙ)��w�i�y7���F�9&}:��t-v��~�I�ԑ�B�_o(]���L���XS�H����,1�4�-I9��Jg�����z����=�Ċ������Yۘ��Ś|��Ϭ�(�_�s��aJ�Nc{�l��Y����'�|	�X-
hA���܋���j+z0&�ʰ�校[��R'9~��He	�~�4/�QJ�?���q����)�r��p�$�H�F��qd����[7�b���� �����Sr��^�S�_۷N����?z�_3>�墘�b"uLγl�S�{	�Y�"$��y;�k7�8�!)�\�A=��J0P�d˙��^�(~~dN��hŧ����|�jޞ��^��1^����+�O�&����yd���*��G��Cr����q���G�}`�̩�7��#�[�Q�x�����P�ߓ/�
QN,Iu��]�	�켤�^�:M�6o���`[�Q��G�� .�#������kw�q��(�����P�%�y60v*��\�"Ӽ$��Կ:%kĜd�@)><E�o�I|���^��\��A�筭+����u�O-��P�/ut8��)2��RʦUK����9��I��:�����[LXM�����_8��Y��-�-����{�G����	�6b��ǅ�ae�0��&-ҥ��������S�fi^�_� ���q� 9�כ�����=��

GKZ�4�i��?�W���a��g��?��{���@�y:�y:����BfJ�J��JD>�w��C�ƺ+%q�rK��>��@&�e��9�V��Gz�,�!y��-imr����u����5@=���VIJ|�i�4(m�\��4��}�cO�+�T��RIY�� G�ӂ��>;�\�_w��ʓ�� ?Og��QBF�y�ԏ�M��w;]�|�g��W��c_2�u�K�HEg�o]%�/ݠA�cy��2ê�0�?-&%5�K�;,�x��������9��=΄BJV�K锤�}?"r���Li1Sh-m;)ԅhVr:��$�4�����ʳ�C":E�şT���Ȍ�-�TC�.�Z�i����t+�ۺ�S>b�c�Z�RiË���v��hn�]�]ZY�r�X�����B�s.�,�a6�M)֜Nwa���r���1|��m��\{{��py�T$��:��`c�瘯���/!���9���$�v�Q��V�U�kB�^,�M��3s��N�"�%�c��5ҕ,;e��|8���T�I����i ��x{6"l�4�[��S���)��s^h~��K��-ĥcaσ�۽�D�h��
H�B��9� �o��s����&�Z�)��ǝ{pރ��|��/_�B��0��l���P�F���K�E�-�mϷ.Ӷ@�)ȩX�~.�ա��"�4��VB�	�	2��1EЋ������߰�≚��R�����YD��W*�4N��׵\w�4�T왠v�DQ��>�6��4��w9�S��5�:6Ӄ^�ڂ���0�J�#�߯��k�0�������[N|mb��@����r3"i�'a�p��3��ܴ�xG��6=��=�Df� �6s�l_\��� ��@y3&�]��֏�6ma��f����8E�����x�l{�?p��t���E`�Ϛ6���9Aᚢ C��O�;١OC���%��0[(H�H:c��&R;��J'O�Zɩ�ObK�B2d�j���1Y�Hl��$�c+��>S�:W�D�V��;LG���\f�.���S���M��o��y����p��c�@��ƅ~Ő~6�,T/ܣ��	G��#
	�b�D>��(0Y]�}�n᭖�ؒ���(�JgqIF���H�x�"sEc����S�`��q��1��g�DWg����~�m�X���`+�+��r�%�^L�1�_�$
��@������MzO�]<S�x�9��7?�$c̸�r�K>_��ui.�!)"��R���IR��W��E ؁][�oAvq�f/�i9y� �(����MW[��E���+��8T45W�Ͷk�2>A�9�e_�������՟OS:�S)��|�)�&�w>@�zA(�4杛�q��ȗKy���6�y��[���uG�W�������⻑\�m��4x��O�v��	�ӓ�WJ8�:j8������#({>���C�O���5�����'���z$���]����|����dFS�~5�0�� ��X� �.K{L��C�� ��­X^]��ѣ}~*4CH)c�T���SX����Q���2��P6Q�I�V��GB�e��s2��NX��Mʦ�)׀�:���sS6�+�[�TT1s�כ�Ybf��s� �8��E	"�qpoy�~���F'���Qʍ$�{���1�����zƁM���4�BA0P�J��B��x<�Ș�;����%P����Yj��U�U��S����4c��8���&��n\��'El�ȁk�k
�(q�	vh6�|ge�t��V��JF⬭J�T�\�E"������Ik�s��,Y���v���8eIB�@�G�
9�u˧��F��֭��)�� 1�[�ռ�$ąS	��&s�'^ҏWa�(�ݔ���K���mP6�b r���    �gI
�_9U��>&'�'i���}ш���1M���Z�1�������a0�R��
���w�0ǣ�a�&�qr�>��r)vw�C�JE_a����NE7��d��� N=�n�u*ꎆ)�~��!���u��n �9�����d�3Ю�	L�T�F+D(X�v�C�ȹ]l�`��p���7}��6��įD�Z!���hc~1)�zW,��Z�X2�q
\gOZ��{��|�h+ŗ����z;Y���Cmtz��1p4����N>f�6#{�e��<4�q�rf*�IPJ���j9����6��SΓ�aR�|�� \o��9���t�����|�� �	=�B��n�D}=�U'�]�~)������A#:Թ�l"ӷ�=�Lp_~V�sX�c�I�&�g7H?�7WF��C��>̡eڦ��m2�����)�I�)�mU&P7���zx��;��H. j�R`��/f�;�-%Vݔ$�O��x/�q��vU��u��`}�f|�~��%�<�n�_��1�����|B� ei���y�^�s��ZIW�o���;���Q�r���c��~�pηh�ԗ�!PE˚���a�Oe(t�I�<���F�v^��{�pӣ[r�.#��y�(��AG�}/Xx	r�� {�ox�]	�%��8
q�!��<�*p�+5D�q
Ԝ�;m-j��S�����'�"�����"�6l���烲�S&�"�%J'�Z��c	��,!$�l;�BP���.X�֏@�B��O��3U�������p�-Њ���W�L�JŰ�j-;y�X��x�C5X�ݶ���'�Nfۄ|�6����:�r�ky�&6��
���U�6�È��0a�)�l�5JQi��Ч;?(�.���
���Vj���6� �jN�Z�ˋ���d;tEi˿`��s�V^��pNy@�Q>Җؘ݇?��ކ�eN:�Ms���]H�`��ݦ5�D���%�W/5��أ%��\�R����H�f=iO�(���#^(�V�J�-(cz����M������ƽ�rG�:~{����f%d-��V��f:��ܯ���:��&	v֕��O�)���6�}P�̊��������?�/�'|�wp�D��<�A��"��n�@נf�3m�dS��Ƥ%���V�m��a�A�Z�?�0e}�?��tz7Y���ml�8S��mʔW�2�:KV�!��(��c	��,��u�ʳ����1Ho�����Ӻ1�q��`/��&c��K=���a���W�E|����M*�w1&�p�'���g\���]��z�`z��.�m.�KS�s����������Sr9�|��A�� v+��M�*?�Jݿ�D�b�����sM���$�}[�o�~�+�r�3���/���ӊ]1���#��*VA���1����vr^$&J���@���-�j6Hp}����.��z�����\F���o�6!il�G6:z�m���h���MZ�k+��L�~k���ח>ꞷ�pr��N�s`>�1�Ì�=�v�Rf ����ִ��}`P^6�<:e?h@$�ܔ3�tIg��L���}�T�d��K+���ߜ��Z�4�@��	���p��ǧ�Hk<��˳%��"�a�����u(Ƣ1Hʣ4�Խӝ�g��}ʥ����rx��ǯ7��RnH���Z����e}��� ���� B4���)_�@��ҀJ�{����ى$�h}S�!&�) b��J�D�9�ߠhME��J��<���:�q� �:=����Nt��M�.U7�����Ķw��o���-r��Ǖg�Dq�(w��~i����]�/��$��ʪp�ło�xiy��7
]IËi���n��ԕ��ݞQ�mݲ�l��R�ϒ��|f/����=]�1W��O��[���I��n��}3�9z�z���	l����y��C��KY�	r<�YӰ��L����+%N\��q�����P=7s�و:�<i �t#�q�%N'4���[�
˰���L7�)��/��q�$]�/�$�Y���������B�v}/��������tQJy���D�޾��H�*�$�5�Dq���gIK���U2�Q쫻���&�֥�I���4at�/�.'���v��GIp�#3��(��t����,,�M�V�\k��I% m����M�H ���1���$p(%����E�����h�N͈�&{ZK�y�	Fc�,A�o�ͅKs~R��m�	K�t\�"I��Ǖp�^��h_:���|���i+K��� :y(~�`���%��y�Ư�o8ovX��m�Ӎ�w��t%�gd��z�R	��V�Zj�|���֨'�:��\����Μ{�`�L�B2���R=A�ˑ��YT��	����h�[�3�5�f�:����c
�S(ga5��.z�l�}z��pR#���y$��n(Ai���o��\A��+���hV �K��KA�#�Dٗ_<�E7N��Ka����_ku�M��m��H9<�]ד>:)�{�]n�a>�����:�����>���Ȅ�?�9a+Mwr$���iM�#�`unw����
��^\��Kc.QҜʗ�����CK��ؕ������|�PJS�'��{�.il���
7�=��1�x�u�Bvoc�Lr������g�F��\�u��[hhB�mT��g.S/�Z��CE�'����a����SF���|��$Κ��XӦ>��)QH��N� #@��B9����/���;K�_i�/^^ "09'�Vg�,����K�j�(�p��(��������R���P^�v_��9I[c�lw�~����'t�e����^4O���j~~-�[�@�J�DH�/�R�}^��L�uŌw;����yr�&>g<z;5�<<R~��N�)=`^I���(_<���|j'v.cr�;�~E��9�4 R$]%�qn���8�o:sc��ص��P.��'�V��$���O������<�/߬%P��s�V%kT��3܄�f�CL~��~�$uیrѨ<����4$���ļ����q��kqc�\f�GNd�\� ��ܕ���"��HsN��&y1�W����o@I��E�.�<K �)Y`�Z��S&�/ﻟ)�E)�y���\8e��K/��r��ٓ{���o�I-,�զu.�z�U�Od�Sp��q�ҙ�˒	�|���D��Xh��d��:��n��S)v/o�tI{�-Nr��z�[�P���'��P��6k�1k�~�y\��Z<� ڭ��'��Ґi��=�,�Y�x���3Lq«�D�:斛j���h���T�9���O��H#a7u#j%$1'�y�B8�٭�M�\�����ESi%�ی�ˍ�*�O�%�ܾq�Փ_��'��,���CCUdL�ڍ�z9�P�����ͩ*Ϋt+��{a9��y�&q�X`>�79�9��km��m^��W��ƴ�[���2A�ɴW���C��nv%�������KC#g���}$6{����&a�����|�����J�)(�h������?I>��N�ϯ�����V�m�D�q�T���������p����iJa@�Č�ѓ6{S(�[�����	��(��q�����S�0�L(���>$#�r�n�WHo��7�#� �#�įm7��up��G�M�O՟���Tw�<-�l4��b��̰&7!m	��2�;�uXyO�Y���|��mLdK?���k��=H4�NQ�8y&x_vH���=�!�O�¹��s����g�߼(h�$�b-��?�ޤ�IYS	a�����s�\���f��Eb5WȨN6s����g�4 �D}�/�7X<<�SV�LR��okq�����;�Mu8@��;��Y~f���+#k�r�-���Iz�"��ov*������������BC�������J1��DJ�qr`e���*�*�-�\Y:�4�i��tWpW{~s���������r�ݷI+~�,��R�L�Z�k&?3��@4�ѻq1��3:�/Wx��_9y?�H�[z���6{�s:���L� .��������9�{*�����)���U	F����8������s	���r`I�N�a��M�ܙJD!b��I%��7��dzl�"    ���L㮝dBʪ��ŲoK�_@��l�>{ꂤ��;#��ْ|KQ���s'���v��́zL��Z��a�%	B5ܹ�*�H&+�����d�`�I�df���;T�(m� .|�6dx3��'@h��ߢ,]��=��o�p���3Qsۓ�(�&x���S�6�_�K�n�͔8Guɭ�)�%Y5:e�n���p���ʚ�l7�xA���w~.�O�	�)�nd�	ڪ���F��tC_�H�3�=v4={"�f�z=�}�yI�A'g�J��꠹2YZuFf;f>�F[��z������p��Ŋ'����&�F}���v8{%�󏷓&)�_�V��ua�w�D�������l���E-��`%�����O�Y�y>���mΦNN���]�`ϱ�_�2�	��מ����7�>��י��X��VfzȌ�����
;%�N���Z7 �ϲ�j��,�x����L=��������,I�)�oޥ�7%k������J!�̱�^6�R!{*�ň#U�� 6΅J�ܠ�Y���]�bub��G
�fM�Q����䒵���D&�h���2�I��{�^'؂)XE }�;��tÛ
��f��+��p_�X���)��y�x��f�N5}s�&&�%]PJ��c�h��W�N��L,�g���5-����d����0H��t��L�U�����<woI�t����]E��2u� ��V9�UJ������{��̡�<��ݸ�Yb��E���w���r }S��Pp�~�������
Z��>sL� �O"��^~Ib/������'���lW��V<K)��r?k;dY~�G�pͧ�9`G�8�����|��{�6S ���$���PZЂy'��w�u�-L>����0���<��`WͧZu�m��0���!�^Z�O�u�0;�s܍�׻m�Hq�+3^��3X	�Xr���w��qrI|I��r���Z��$4ŏ��lO��R�Ky�e�a���w%���zUue��M>]"�n����\�W�|�K���y,��"�Lɖ$�{B|�:*�m+��/5�|�m۴�*O�Cʼ�Y��[�'�#�:�����L�~ރiO8c%�۔�!�ϋM��;\�.ד;ϯ�撕����>�S�z�K��w�7)��`Rrz-z��SI����!$SX'�͒%�|n�	��&�y\���\8x�^��k��qco��%����z�罪�����-�)�N	X�8���7`�ۓD_��8K����ؚ���qm:���igS�:�e3d�b`IH�s�\Kg�<��:{�'v��������������'v'�y^kr�@$�<���m?����nz�4�W�	j��Հ��-��d�S���ۊ6�f�7��4"��$ndi���?���-�PrW��V��	�3�aҕ��a���'_�[H�L�eD�>�۱���P��< ����nC�|�#�"�.)Yұ֚+=�V�CV�i��f	UFh�Թ��}�BTd_��R�k�a�����(��"WA����p�'�3�+�r�L(	�+�S�؜��C8��>w9J曼�����|������Y/TD������2�1�I�Lci���1d�^e�T��ġ��2�h�k�C�.U�ò�d�"��q~7U��e.��1��I�� =���@��KA�� �ǀ����� ü��R���ڪ]���AϬcO�Lc���ߥ^�����|RG�H!�5&�?����
���})�wJ�Q2A�	vߦ*��Øl�d��U��(�$Hz���ѝ�� ��ؐ�Xy�(!+Cן&�`U�;Ň඿��{:�,"mˁ���I�+!/%:���0��H+CBV´� �;��ü������<�$g	xw���oP�:�Z�&ȝ^��[s-14�G��1��5O�����^C�Y �M�4I0��ʟ2ፅJ�EΆ�GY��h��� �y	� ���1���s�
|���xk����l��#�\�'��IW;ܹ���	T��o�債g�Ö�ͽ�2�B3��n�����ԩigL7�a�5|�Ľ�<jYŋϐ�s�/S��.W��yZ�j6�[���Ng�6�j��Ͽ�w��?rUv��	�6�f�,�@/裒���V���a"ͪ��D��vri;����Z�
\vC'�n�����N���/Sˇɟ���i�)��_N�ġ����y�����}e��z@����4%9g��%#�Ƿ�O�o@��\Kc|$�s�ړ*!�;\���0iP?��,)�/�)�Q�FZ�g�X�'V�;L�>�)9%n�����Ļj��jH��c�(9W�������K�S�妺�}͇Hߖo0�{��&Sr�y�[$ؿ��l|q���G�IU��?ֲ�Z�9�(Z��{�)��i6�g%tb ��k����Š*MAQ7�^�F�_�k�-��H�V$��s���$�v�MZ�b��'0�4�f�ym����o�Z��=c��- a��?��g����+F���d.�������<��ܷ�K��]���5-����R�w���FM՜�>s�.m��}����=kD����$����X��������S�[4D�$�,�������������o�۠�7$Ƶ��@]��aOw2]c�U�A&�pDZ����Y#S���I�A6�!�7���f�lLK�D��`G�RP9Q,5[�MO�0�	���֯����Iқ�Ůb��s��#A.1�*�ćB�q�N��j�Go���J���]�T`�Bh�삥�#�l��꿍����?�܌����8U+[���1���D���[z��Np�2�͒��tz��c �t�b�)?��ȴU��In0%��I��0���q��<l�;�$�#�,m~z�ΚM��Cr�a�6M�j,}��Yd��[���I�Ήw��uد{ˌ=��(��GA��O�K>0���8��6��F�i~������?�)ڊ|�Zd����8#E7� K�c�͸�)�ӮO�R@'��H�W�.�X/�o�!��?���1����<����D�]��� ψT����ڙ����Z�N�-��ƻ���;�: �=y*�	���uIB��D�)�ޅ��9nK�w#U����cl��n¸R�KFn4�s(�R=�B�ſ��9bZ�-=5�
N(F�?�o���j�P3�"�<$��JT�T�yӖ3aR�r�qX�ǯiqLHo�a����)�ӣP`b�b�35�� �࿵dz��Ӛ7�Ҏ.���L>|2Q^�1���:5|��b�����_�kg��$�Q<�u?af����s/n}J��?8V�~z�4y�t3G*����G���oL���%ީ��\�w/��E��Ba�ih�i���� dM)�%�x�қ����8�����	�`O!ǂ՛f�+	�L�*Z��He�O[B��;�u��M$J�M�ȍV�'ʤ���ߔ��|�FS}��󻛁��
K~�4k.�,�۵�ͷ�|�{%)T讑����j�,����g��W6ٴ��d�5�P�f7}��� oڟ�iU��ǿ���$}�c�!����MQ���%�h�֦r��8J����m�S�C �����2q�.`nc	�K�~����g�΁����O�HK�:M�8 �g<�'O��ʙ[Ӥ�-"g����u?y�5�M7��ؕ¹P� ��h��E�Y����W)@y!���7�K����N<���t��k���|CB���������5����sL��!`NMȀ�����}�׷%�^8=�7>5�=��}�������'\�����(�7��l/��M���ʓ�L�X���S��٭N��y��1\���.:������TS5y�y/r�WI]�/�*����_��ga_�0����-%=��Qr�A����i��j�]�U'0?�t�#��T�H�����M���+���gْ����R��O�yHNi?��Y����N�6�-�gR-|�[\톭}��R�������9���z��LnY$��ul9�̴9�=�E��o9�$W~q�/�%��#�қ�? ��^P�C��};Tj~C�,�$�]Ěk��ؽ?�WF��?�������H    �Ņ]��>�x�2"��y<{9�O:��"(� �W)��6c{J<�y�ܩ�2�N'3Z��\Ie��փB�Hl��v�Ux=��X¼�����{�2y��eoq�kM���h����ʄ�����})x%�U��)���t�TjKj�|�9�m�����}���fҊ�'&k�G��T%��W^U=��sY��^P��E�G���Y�Z��/d�.txB#������+�@ȤM��8�ٚڷ���fe�w�.�~��L�qJ�V�<G�X	��V�u��~/��\׵~,4t~�F|�(���{)�Г�ĥ���+?<�)�~�܆]?�Oh�NIr�����O�rE�����'þE�䃓:���S�T���\_^9 ����'g$��	L�3Cn!cN��b�WD,4�|���I>�uF�)$T6Mm�v�)뵎��X¼���~�[n����|�Q�M�kn{��b����ʫ��Ƒ���a��I
�4�U9N�Q���&�v������tM�(&��yz�,ɶ�={�<H��P��^�
�DVi�� ꌱ$��Kbd���j.�Z讁�o�����^ "$p��h3�C-���.dM� �`2�,m�_jS��D�-�u?IGx�MQ�z���:����y�{^ej�#?���������	v�	���7([e2`�v��Qq�E=���OM�Vƕf��;��-R��|dUW9�*v 9���{���8.苣s堐6a��S��
���u�:;n�u�g��{ ��;s��H���N��YOBM9�9��[p���zm�s�A3I��.�~�j"�:�m�9o �w��k1O��A�QV8���~�ٓ�@B�,kl@�"�g�YR����iIC�J��+�+i�%%���{�Vy ���(?/'��<K�)��d�Hٓ7O�MLb��}.��թ;(Ҟ�Tt�rX�[k\p]P�y>y���ug#�FMQ�X���)�9��+k�ԭ�<w�c�<�?�푲jٹ��YIX�vJ�)�8�|Gm)�peJK��9�-��;{�No��g
N��\0�it����؆"�����-A�����fxv��s�/��6g<��������T(����]���[S�$�=P�O�~�6�s����R�x#��b%U�\-g.�õdk��~������"���$�HS���~t�a�)�d�D������)���J�m��v{����2uw:1w����~[�ȝ3�R�̹�t=t
%���'�ç��D$,�"r����YPz.kL&/cM5zW���_ß��Nhg�V.�L��� ��t��,o;�����@o�,�^;趖��۸N�G�^�J}m�D���?��]T�\��ٕH�'@X�����d��˿�1OIڰ	c�ӟ��r�Ǝ�j����y��Y��?gճ�͒�6�4�;�[�j��N�I@���p��u^�{��p�C8ӈc�N�4�z�o-��r�$�b ������\�ܷqa1f���u�`�z$O�:嵠iM_y_��,�JvC����S-3�T�O"-q8s����QT�"�g���>�5	�N"4��bt�EyO��KO�hx��QO[g�¸9o�ωēݛ.Ҿ�\f�8k��I/|V���{��fbɖ�,�l�$k�DE�J<�٤�}�V��H?�h�+��N��뾤U�T ��g.9e�D�R��Cg1����}�r\d<)k�g*��(�c��4��hޏz����A��D�:<�<���Q� &_F����mg��ffYrk/�N� ��-y�QC�:�"���65�A��J�M}HƤs��ڬɢO�4ӭt�$t�zo*&�:BZQ�C�?Z�wo_/���L�h�?� ��|�(i#��=�ҰِO� ����?���|�V���$�K"�-������rށ� �{ʼ�F,�҄�m)G煖N~Y#����H6���D?y��M��N�C��z���4�����.�d�Ї�g���&j�ȓ�5��c���､����w>�=�>#D�_�{Rǩ{���}GP��M����zܚ�A�DUV�/ړRx)��$�ɸlz�g���B�%�.\��W.zR�,y~�V&IK�pI�Lq8��?������~T���/�E�74�yjXn�(x;��p]z�C��=+�Η*[A�\�K��� ��Tn�8R���vF|NM�&'����z�`��}��y���V��~�TRF"�Z|��!fKU6���1�(�uF"�rಜۗz<E��1�M�b�]�(d�YT���9��Nܘ{I]���J#���d�I�6��i�5 �-w��ʕ�%J\IE�j]V!2�������)/B#�ZN��X����|�w��G����n�3��P������+jsDn�b �ҹ����w�2d��H�<l�>Ҧ�x9���N��W��F} &pB�o�gzL9�ן�#�Ί��a�PI��E�Nu�LJ�?#�� �x�~�'_;Tޛ:�Du~3*Q����}]}S�س�I.t&���Q�諤��&��3[R��d�<C֞-?��b�0b����}�K�`�ϛ1Ɣ��d�%/hyS�
(ɘy=S�1��5y �Ε\:�_���l�a0A;!4%
A֕j[*����=��U�6�������z��T'N�_!ˉ�@��91��O���\�Qb8�<=4�=���4X�@��o�4�݄ɂp�d{#L/J� _?�39iOųդ�'����.�+ڥ��N�)� +���Q�m���v��gI�]�8k�R_�$�X�~DI:�)1����
W�L�䞾�����������*B^e���`���Q����i�������&ymm;d�~���X��s�M���&):��y���s��γes�LT�/��G9S�/�n�aw
�3� edr6�)���p&aW�_��Qr��P�2��%�Q��1���H<�xֻ�e��:��!5W�!4��N�vfPO���D9?�{=�7��Zn\���ȴu:�ө�����[H�Rc��d��<���I����P}�t7p~��b �箾�eս�X��gMֆIO���M^���d	��j勐H=e��v�4�����bUj��Ò�i���d�'�����x�����Q�����Ÿ\��yI2@��M�?���L�.+{};���� �
��q���ț�@�o�ge����P@��ป�&��/��|K�G��Gb�lݰ4(��ȴv�7Q)w(?���&�c���(�v�)���B����ж, �����G�����[��z���W��m#���+<GkA#��&	� �K�TaE�?��u�_B=��)��D��а�����BC��Ȁ�.����\�3�%DI3�/ Y�f5U��j.�i3�$*�8��z [L`��͏��O>9���M�ڹ���f֜u���ϥp�=��,��'�������S�T.c�������T(�WcI}�򗦓Z���������ܣ��7�'9^�*�Bnm����*c����lH)�x�6��x�W@��7��c�z]_�~V�Lz��������Н���5�CH:�l�V;w��vM�y��@��K�@�=,*r�
+�z嬚c����)nsTR�!棍�j�X!����6�����7�|6}��h�B��$�).zW��E��H�L	����Bֽ-W���c��R�"���Q����/�����/FvE�C;k�g#A����J�a�ٸ��xD�ɩ=����������1y���^n�����+�L�b�>y#%y�+�0mGY5J߽��Li��#肿L����':���S[��ÿ���Ə�$�X	����^���6�M��sEj��?j[���+����|AbR�M���)�^����F33E�J�\KS�>q�R�����!�X��Ex��{>J���$n�ŬH�{��4�	�6��"!�QVq?.��h?��=�c�fy��T>|���k�m`jK�?(\�C�S���z'���IㅰP/���Y7���f���ƙ��gL����~�h,�0�f4uv�?/��ilX�|��	����`�^&�J-�	�A젦h�,��Q��7	4'�iN�^�[�o����v��    	�gN�x�+���Kp�Ϝ��&>�g7΃*�,�}M0����>*�`���ꭦN�X�\^k��EG�&����,ۏ�j��هږ�}.C�V2p���"����_���x�?�n"ÇSS�ina:%��>��R�#*��ͨ�J�\����XPrB�A8�;��;5�ۑ����*���r��%AD�k���M픖��TQd*&5�G�"n+j��}}߄�ʹ�L}cÛ*��H1}{i��6N%�\J���iM����V3��z���-����I��Z�%<�-�µO���㛨z���;�԰	-���s3�y���H �`m�v>/����-_;'���l�;���VEL|"J�C������R�@WR�^-�k�iaьI�L�Nk�d	���g�̸M>��q3�J:3xI��4[@��3��i_�� H��ىf&59z <���/�s�D C���[v�?X���������� �(�B�1^ٮ�*���%�ӂ�2�F?)NRײH.��{�@��7�UDM[�v-ѡ�-��'�Ks���B ���{$x.�r���VZ,,�>��'g�1��WB}/_�&	&G6W ?��\O�7;��~[w.-Y��y�4I\�E�ZR�dFy�iJw{}dQ,���PlBO)f���	[��.sf%N�����7yY��t�!��'�VLR9��xSn��-+k���tqʕ<�[���׷yZˁW����_L�	l�o�{����yL	�X�X�S�Zh"�3���
ب� ��on�E3����w�	��p�yL�q��=�u�N�v	B���J�ߛ��loq�����4E��v�'�@�Sy�˶�)/u[���G-�4"Flg�O����ǖ8Yx�����6tr�������V��h�rH�b�Im.�o?F#��l*K��9Nn󄛍��x{�+�!͖4�t�?�� /�r.ʧ�L�3_$�7Q���1��&]�3S�v�wH�h��S���$�[�	������r32x�*�Օ�bq�r�UO���%Jr��Rx^�dC��gs4%�MI�	X���0)Z>p�.���;�S����Y/����)	�<ihd̕��a=ܕ�;�p�L&�e��ܾ�77&'��h�e��~�<�T�1��:vR+�.���+�d)���}i�B:y���`��!�v6������6")1U�T���m	]�~{	P���brT*2ߴ�	��3�T�9S�|]�j���QK�9���N�D�6B�����4p�o�f��n�����4�~y�ҙ'�%7���Ů��s�EVz]dtS]$�Dw풍��KЊsL@+��R^�/	�KPK��߷MZSh N��fׁ'��C?��(*"�tEcb��O�S�f�#&�8�e��b�59�}8���u���
�q�ᙕ�b�4dFJ���Fj��p�e�h�;�'^���*��L�uY�t��(�Ă:�)q�I.FA>�	�;u�<.eVߜ�a��@�o�l�o��,?�?��A�~r��0�R�*,�x�Z��3��)�m��wV�E�$4O9�W��.�+�3Ů�=嫴9��x��9�T�+��O��=M��$�g�pNR4�ȷb�v��ʑ�WW�f-��J@�0��vZ�oTg��ӥ4Z�dy��Q�ߵQ�ݓ�x�$�@�\�N��;6k_���;Hy�H���!sP.��mؓ�򯅗�%n
OݪjS�&7��39�S^`�DYF����|��T�ǋd�3E=vh?_�U�˖ ?t�h�O+s��N����+n��\������i���P[���R���d���mw��>�z�O��D�n{�"�6�S#�T����9F�s>��W�d%�S'e���Rb�~�{b���m�p;�(�+9�U0�S��J�H\���
��[�q��P�sz4�$rr���7�e�)YJp7M�#��2��s5F�������ڑ�y�û�'3���X���m��άX���I����v������6r�3?��V�r�N���p�8#) Q�G�2��cX� =j�|h�{H �R&�0��G����&Sp_tT���נ(6��B��~�I�e\���?g��/��n���OP�JR?����C�2��A�T��ꑕ����w�����f״Ds^r�vۮ�׏Z[�h��sV�� �A�:8n�
�;k<�P����Dv�R�~���}�d����t����O��fI�$��,D����&!�hRiK���8�=Wtq�Ҳ��KN���{���yɝ��l˗�oɱ��Y����Z�g{�On{�17���J�q)���L�{��|�z)uM�-��.IA��zJ�8J)8����2D`4Q ��Ҧ�]U���,<t���iHn�{2��$HoD��Lg�D���B"y��Ka���M�q�UCΏ��K�o~�D_��,� ���Y�ZNL�G`����B��lay���J��"��:�-����L-�dZ���$��'Bɍ<�����E�-��;���I1��=!3��e(��h9�pq��ưo��<�s�� ��PZ�k�mj	�s�oN+�Uh{�`�,J{�Jy��|J �Pw'8�#�u���`�r9����f�!2`YO-u�~SW��IF��7˫�!�ز<ۨ$�\�B������I�`t�䵃o��D@�^��&"�G���:���<Dq��V��&.�[r��t�2ޱ��鯴?��L |a�u�i.��Ԗ�;��u�I�'e�_٥Sd����~璘Ymp��W��a�n�D��5��z@gMk	�6b��`p���#b�;;���J�WRX�:�d��s�=�*=�=�\�fLG0��1�<=���4B�
�iaKQ�D���岞e�UEﺅ�ܝ+y>��ݓ�\��$MqU�jh�e�>���Va]=�veW���y����\��72W`��-��R]�}���\瞔'[J#����g'�~��O�N!*_��������O������G�9=꺎�x&.�e'�͋,gܽ�M:�O��bƺ���!���xN!����9�&8�$�G��S��E*w����}S	���BT��1���,X�M��*b��̐�� +��/#�d��.)r���9q/���O���aP�A�����v�w�MQU�Si�skrr��;���7�H�f2��P�\ӡ����l�������H�P�y��:�tE	$�ϟ��5.��@���� ��S���iӸ���A~j-ɅV��u<����q�l��)��q�xgPch�$�R�5���$
��Hr��_8��:��nD!Y��;�
�a�`-�I݀ﶖ�d��+%��N����й�f���}���?���<�@��;'A.Y�FO�l��_��d��N�����TXj�QB�@� L~Zއ��V�� ]�I͏�Ύ�a�
���+Q>�ݻ��ھ�*�f��g7b��H"������'ɩ�G��uyr�������R���4C���:��9�Y�KIU2����;hR7�Ys��:fe�1Sj�]��gY 4X�U���G�/��t����V[�-���ƛk�n-��8f�%.�T������>K�S8ӂ��~MeFN��c͑�bNd�&_
6��+P�6�n �a�:zJMQ-�E��h"G;�K�?R{��H�]NQ��Q?�#a��D�D�s[f��t�)�)��Obh1��V>�k9��?07Ԯ/��r�"�/�<�6��d>�G�%��ɀYEd:=)tD'�u�&�_q&]���/3���3-��2�ɡaT�h�%Db�M�-_qNl��4�����LOG����)�])A1�/a��R��,)�$����]����'�Zpko��t4��cG	���L!��L�c'z `�
s�f#	�S��9��j���9�Z�I�P�Ç���G1=I�%��~0&x����^���- �������,[Ӫo���;&o�(��9�R>��byJ��x��ߑ���|�A��ɣEsHkt��H��t�W�7�Ѡ)|���߷:l*6�����{���Y��HY�bB�_sJ��PB�_J������V]�
0��nyo�]�&4�g?��S������Y�фߒ�� ���2��s�c��    �-H�W��4�K���.*��]F��~oR���m���h�'���X�Q)��D��rh���ʩ�xO(��Ouao��ӎў ����p�n4�S���V���)�$B=�fHLs���c�/�
o�P����	N�i�@��O1�[x�l�`�A��y&������k�r�ي?�]fd��*����79vKn�ː�*���* ��X�����Q�����5%�� 9σ����k�[z�'�)��J�H�R ��γ���^@B�w�5���[B������QRЦ2�yJS��pK.�9Z����'0v(�T�)�0��	��~�������_�$.�,��`��l��!�a/�����q�ab�!i��՘��	%��YF�A��,ƑCx<d�.�84��:i	���ȅ��Q>S�"��-Fc_IS�r8�5��;$fϿ�!��ZXH�&%�S*�k
��ǋ�YKWJ�Q����b'&�'o٭&��[ǿ��@�����.��v���dGs'G�����E0�s�Ѿ��]
�3�K���eP���;t��t��uI�+3Xr+����;3H�=:�iI���iJ=9%w'��[mlٞ�*���(��4EbK�}�Я2v
8�mч��餈��acJ�81��f��\�7�R(GJ9��8J�П\�b��J�����Į�?����diL�u�V^�ʠ�����oz�NO�}҂���$*4-"��cJ��K<y��O���g����^Ԥ��S����gK/c��>��D�rH��ն�����L��%�IOw�ؙ��e�7[�T{'�O�?�6�)#E4�	��=���0s��LI����r2�HZ�%�z��r����G�;�t�3�P��x?K��T�T�cz��jw��~��>8�~|�	��_|�(��X	�������~�|HW��GD(����p6�q2�d%�e�[���ާdb�b�TJ�t��:R<�F�9:��iy�~�H�����G��$IS��3���.���N@���c�$�}1l�[�ƞ�>y'&����W��6�q�y��cj��evA3�r����c��<�=��,ڀ ��:L����m~�����h��qJ�u��K�w�,bAg��<�q��a��2GpM×��[��������rI��G>9>[r�� ����16Z��$���{��Z~���ă����
e�^��+�G#���89�㤯/BO����{��C�u�W�J\��3��JdM��FO��_����H&���m�ۼ��L���S�&�@4�PH�k%�4�9�ct0ӟ��?��Jkۙu��|��hTR���[b�غz3d|:PN,#��q�c�2��ޑ�e��ŝ�����-EA��1���^�N�j&�_v��<�LD�9�%l�B{������H+g�������J��%n.���tp��3�}�48�=~�*Ev��<{�������k2(�W���<���5\b�[`�۽.k���kJX�Y�<��j�$�$#��c씡�X���Ũ�[#�c@�E{�K��n'�/Et����%)���t�N�:���-]�%i畖���gjai����
%�$R_�\f΢Z栈:�9=�\"$�����=	����y��d��l�j����%y3f�Wd�r�y��`�WMԋ<�]�����F��c�K��J�����{��(�MNV�G4��\В�p�/z�j��ǎ"?�5l�آ��R�K����PC�1��[cl��K���`�\�?CEn�Q�|~D?�Ҿ��uk&�VO�Q�n���#yl򑚄�7�����L�8�y+��Ɓ#�22h<�4��GD��0J��A�X�V��`�t籵Ɋ�7 %9�QQ��2�\ʣ0w�+)ԙ6j=[�r�ͣ���
<A��HY�� �''�<����R� o�b⟸�4|��}}O�Z�%q5$��f.��d�?�83��o���r ��@����Q����?�إ:�ԕ���}�vN}dX���TI/ok	�����x�y�[������*y��ŧ�.A�>L&�i�8$��� ��Bb�S߬l��β39-~*hK�O����w�)�|�Y����OU��(fz�]�<$�}��:2�\6���8�O��))F���S���)�=����+��V�yuˢ}{������Ɓ�=��QЏ7�wJ��0W|$˴�=L�d
��|��2mc�kKE�*[�t��)a��K�S%k��z�)��]W�M�8�ۅ��
��J�(w����N�-SO`.�q��紒�V��G���p�toYq[��+}�:Kߍ̦�RKۃ�_�E6R��z�崡��F"�ځ:�&$J1K`�K=͉�����(7�)��4נ3{�q/99<kʻ�$�?sF�˞��L��G�=o�?��r^�Fi:��nZrp�P���И���g >� �yk����7x�N��-�amC./��JC~)�.���xj�r����:��:l�h�����B��T	���ǌz��*a�n}�2�hn	��6�/"�䴘�Ћ�T�κ9�M��2D{���އ�ˋ�j���H��X�{&5�Ȼ}Ǧ��U�/S��cU�k����{,�﹋}����"Mp���x�A���<����ey<o�L�r }m�ߖ;�S�3ī��\E̳/���!f{�T�efR�~Ġk�<�w�}n��8�v.��%�����P:5��;��Z�.��9�4���h�v�* "�+r�n�o-}�m��Jv��եV��T��v��'ߕ��Qɋ���t><�s
GӆiASV���caSC�-�wM;�����5�G�r�v�ۊּ$���+���N������ǰ0���Nf����HHKC �th�o�FF��'��[>w
ܔ@����m��r���%�j�z�[O/�z�퀾x�_.ܔʎ�qjK��};w��N+�9����Xmkْ��S�����k%���FG�Nx?��Dq�M{Z���7��qd�dC��>ϼ�����α��)��ex�2c�+��ޘm��U�#S��U�;�2a5�h��ox�L����)��������������1�8݅aa���+�OH���bY��þ�M*l���)W��/��+o.����HYP��y|yr�G�^�4�;�?�.���x���#�iB��sO�@v-C^��K��	�����Y���*�Ň���K>��Q>g��l!�g��`.��i�@)}�w����������G������Z�%.�W�S],	��S���{��%"��L�w���jm�Bo)��Z��\�Ge�DB��2/c��s2�ǻi�QSRL̕�dR�wJ/�4ؤp�u�˷��Ɨ��Hj�}����+0���Q��]�C��$�u~�:-��L릸f�b��.T�5���A�љ�]f��u~D��ejw�[޼?&�MH%��S7#�|m�K�q�����Va1aL���T>������	���)'�T�28 U%e<h�NI�	���h)0�L��V�7�f5�[��x����������L>�cy��J�y0A��4ʌ7��W�t����pja��׻�C��C�v��҂�'K#̴��z|�"���S���9������{�Ny&Y�v%�����P�.���D�:HW��&Z�����J�mSY0��nV�UR��7Llke�T��w8����� ��Bt�W�����]~�fi!@���'LϪ��S#L�c̦��!�4�ij9���y��t��w*�
wh��9?)ዥVҼ�_h�}m|	9+���;� �67�\�OZL������L��B+��Ì��o8���sUS_�<y�����h��̏D�ѩK�퀎\�(R_i^�U[���Oυ�J=�ˈ(�A���r	��na�y�T����׆�8�*�o��SY���Ŝ4�s���2�0{;��X��/��3��Z��~��1�h��;wl�-W#ʄ񐮑? w�6�PԐ�$�ucbJ��VNі���Ysrՙq��'��$���wP���1�=c*$O��r4��ܸ#ɏ��$���%���߮Ăo������;�J1>��z�� �跆��J�    ]�������	m�����I�k:d�M��Tp���s�W��H��������x�CB�VN!�|��VZke�G���(?י�=�P��F��2�I�����>%����쑕��R$w[�1P�7D�����~mF6L�����ײ-;�\���9 x@|�~�ttp�S�&o:���^�ʒ^s�� ��r���>/�NR�0g:��c�S��T�L�b��,��\퇍c�e�GK�)��
�ôe𬪥Hү�t_ΩV����HN!���h�,p��c��3Llڟ�I!i.M#� ��4p<�\.c�P@�+qXkg��W")/=�\�=ͪ!�1�ۘF�D��Tae|	�5��;
�TG۔�xcm�d������|�ZJ'm6
(ߡT���;{L�����Sv��u�O�:��0�K�ĉ?��S�z�!�<NOش��=��29HMm���|�?g`J��(�yx��`d�;MGP�n�Ʋ�� ��i� ��@�#o�j˃�`ߵ̵���$�ҽ�+��Ӌ�q�`�� �����Qi�?��9n>�*zѥ̝M�+S��`WG����l:�HO����:`���7���%�)K�qӃ�
D��Sr!�4��5:>yC�l>�S{qs��X��s�<Z�ǜFʦ�V�i�ӿ�E�.+�׶`��D-JGj��>i��q�_Iw�T�=Z+E~�33�@  iz:d-S�1qsD�<%�܇���1��S%4^B�g�$��5�{6q�q36J���f!��s�O��?����R��jGF:�l�O�V'L����Q�0y��ے=�ڻ����7��)\DV�z�,�'i�Q����?�uK	PG��j��߷|���J�(��r�������)0!�Uw6�r�K��3�h�o�-��<ϛR|-��bB�\"|�V��#ƙ�eO+��ŃIu3��,\�W�S�o��SY�?����IO�ɽ ���`�
Q��,˺�v�0_>@��w��k)c`Ԗ7����c`�
\ٖ���J��G�rCh�S��4����z�p�"Λ�Ț���}�Nž[�����������\�`$"��v��|��V��b]3��̲�������ݟ9��O�o���??P����.��-?��V ���	f)�=}zy�_
\���s�ob+7���aIo�P��B�9��.�3h�4(��r���n�BQӷ�.yZ�43)�_]-[&�*jI:I�F��v9�qr�9�+u'��'s���U� �l|;���^�0��g���mbђtB�Zsp��249�=�&Ii��gz$x�g%_�p���=�%�Ր`@���Z�K�&��c>%2H�4�|}2��z��s6s�&A`E쿤����Bu���xs���s�9�ʍ6ME���R����  ��F�-�m�!���#k��Oգs�5�-/��Hk���H"?}���%�}Ͱ�G��A��&i��E����s.�!E��X(��D���!�R���V�ɓy��h2��r�8�F�7��]��a��ɗ��W���KE{`��Mͩ$C�y���8oR*��@������XV�(�A+(�%�B)���-)v��r�F��[���*	|f=�۞51bB!�H�sֳ^ �����˜��6��	/�g��RwM*z�:�f\(��3?��f�WN:�C���2�(�r��sKH�\e/�ӭO��95�Og����pS���;`���[��O��@�H��-��G������sL���a����L�B��A��I�s�i��T�z�75r��+�$��mQ"���%���S���!��v�H��Q����%�v>���@=�DԱ�OY¶{Ć�����1���T��Q�GaMr�P�_>�i6ȡrd�IoU��B�~�y?2ؖ'=���tS�	���5�IO.���6�j4X[��`b�A�-��[>iev���prn�M$}zK�	;��J|wϺ
��P 6Il�s�0>_��i��Ƌ�vbd*љ&������pF�9cB��Bk�.��I���L2�ș��~��>���^��:�ɑ��:hco(d�(H���G���":�1��H��M}�Kɶ]0�6@I�@|9���l��Hl��3�L�c(�U��(]A%1%+����8XN'er�]c����(R�VZ��{���ʙO�H[�$m��W �^9��Ors�|�N�S ��N����.%��/#܄9s(cpF'$�i#'���������}��]y�L��P�0{�����R����	ȔvJbi��O"N�S֝�
صp�Z�I��>sA�ח�bߟf�E��4�k��7F>�_�\^�������iX� ��g*?��~{g�/�,tӝ|���D(M�L�s"ΛJ�:�1�k�U�rO����L��p���H�@x���,&�k?��x%�����ߗ���|7'�c�H+Lx��K�)Û��HOi5�����ɉ���!�p�H��`��ݎ�aL
�t����Gg��*Y3�O�5bU����'�1�O��:���f��4%���m�佒k
x�6�ְ�\h�j�Hd���t;�+�e���&$RtL�[z��R�uH��<��Ѣ/c�d7�<�[�'+�ˡ����$�屗 Yl�T�3-�ۂ~2-=�eq�Vj��KZU��.�H�2����$g���k���+hg#�4�y����*��q��f���"x�T;)��3^����\�5rKR-���-1�P��+�������9��W��y��%�Bʹ�Lsm�Lͷ�o�s.?G�3E蘮�AW9E&��IZ,|�dH��7���D��E���ay�	�엡�	"3�(�a�e�2�뤴��w���r�`b'��5�e�=.��%8�2.h���H�nH���;���EW2]�yz�ڀ~��n_�Ш�!C���\j8��ʥ3DQ\$)���l��#g���:���^��e������A�J�؋��73QM���/�7��{���������5����a��o2�ռ����0j,9+�һ�1'��&.���)�2��6<rl�s�^�O�8� ~����>�Y�@r�>�r����>�7����k�XOX��2\�?�im&~�$���ɭ�:��-߫'7v���]�*�۟{)���{��=�5����p3�NK�lp6B�0�	h���3a�:A(��\o�0�-��Nj��߳#L��@�i��D8�oJ�BM�y޼�5g��U����>Z]�G��8�D+�����zN��[����,��ޘwi�6���M��4�ؤ#1IØWt�z�Ry���)Pر�7jn��ٞw�Lu���¤��Rx�P�E��s�7���7�b(�\�ӛ>^�R$�M�+�(
L��P}�,oo|�PA��Z!2�v�Ƚ���>e�{S Y�o����4���:H.�UY()�X�����oP� ����\��B'�M�2NI{4Ym"Lʞ���O�ٝ��Kl������<avR5�����Q1�v&_�*��ER�M�H̖����6��3Q3>k�{�d�Kt�a��>�����v��ZG�~I"�B7�Z��%՞*��U����D`���%�lZ6����H�M7I������ͳ��{i�֩
-��e���b�*Q�V��?�pN{\<m��%.�{�"Zm���m���%f�Ӆ5�"$V8��V��IGY�VF��M@�&�0[��G��!�7�����U7O����3�p�̆��%�`,	��9�-j
�t��d젛��cn��1�!&�S�&J���iZ��J�r�N���	�}�9���t ��(�|�Nq���Am&�NӼQUb�>ݍ$�����?c�c2�;=�{Y'ȏ��\�=�� �!#�F��O�$O�''���"���&�[BZm�@�����(�|�Il\�6n��뭳�8ɀ�w$��k��;�f<&��_�&�w��?�`r�<N�����3z(0��Ne]��*��#���,�������(��*iR�Db9�t^�����o"Y0D� RKj����\Fk�jN]B�V��-a֗�q|�H��b-svl�<��-M^�ڹ1>Z��@|c�>�6�Mg>Q[-᮹G�-�{8Y4\3��0��R¥J��(Ś��"�[�,�0�MO�    ���#�Ҽ��=#�i���:2�|ު6�1I8k��l�Ri35����WR[iL<��v����Q��;�{�K]�t$���aǱRD4�Ι�	�t<�)l��"2u�-R���
��W��Ϩ&ua��-%�~�ǖ.c.�k��=S�
qzF��pWz1*]�W�$����G������d[���9�tw���"��:T1�t��$r��%$��Geu��sp�{^Sx��g1I0��T�&� jp����0KIK]�C276-�k�u�4�tYT²�1-@uD�V�6�*y�3��nk?[�>���L�sa���ͦ��N��}s���JiU��5=�n���l:k��:5#���?�ǧk�M��~��	�'���x��"�wB-�d7�;(�v�Ԕ�/��4`&�.y�f�e����ށ��ז��/{'��$�3�����<ȼU[�-��iH+�2�J��Υ@H�M[��}�/$A�wi�A�l.ܮ�3[qt��%��8u�o������I���s��@63���r����{��(%��4SpВ��r�tP3�����S4A���}��9R4;�"�_��]ڮ�門c볕xQ>b��!y��ȣ�vq':p���[x�DH��X/�r�2wi9��x�dN��z���T^�L������,��=�MOp �\r��N0��^�(�X_���p~$W1v����T�5�Zȅ�s�K+� ���E�0�����p'�p"���W+r�}W� �)�u�a���r/�&:-i�P��/��֭��'�h./x$\���c/�o�[y_�F?�%P��۸u�7l�}]���u��@4 e�$�8: ��A]�I�����T�]�W�a�����HA�<~9 yG��%���J�p%S,`��9,�n278](�8�y�)$��5�6ց-���9G*�<����Ȼ.a
t ���WI"K��߱�;pمp��]X7�t�~���s*ڻ������K�[.�G��$��MX��%ѡK��ǋ}E1#���3�ɘ0Y�L�7ͼ��pS���?���^I���M��2�F�=M��KA}�5�Ʌ��|�c�&tY
�@A��h��)��>%�r }��'!����MrNx���ZȬ_�sW��m@D�j�w56A�z��JL�6'^.�R޳�$Ӹ�L�2zȌޒ ������[�Ǹۺ �Lz�A����%����2�B������dG)��&z��f[��=�K.j�7j��)ͤ�lM�I��.i~?u���@�`{�@���R��s��3>�d��5�Y�xggxMi �Q�֓��a0�KK�ʉ,ΟD�ۄ��D�aԊy}^�Ϭ"��4�`Ɍo?P�re���#7�L� w�s�?��,��a]�TCIb�2�9
2�_JG���y�M� '��G����rK����e��Rڰ��W�"-9�q%�bs،����tcR`T�O��\��	x�vn�e��6u:Z�%"�G"O�$v���$����#�}�%��W�oj�Խs�OPL\I}S>���m?R���n͗)z�L��^�*�w�Df��;{�\�Ż"%��J78Q.߂4�E%���+^m2Q�Nr��'�-��U�)ůG}��4�+�&՜����R�P�|�;�s�������߽��Ma�?"�*�-�2J�7.��3�[���6EA�">��]wbY���ܩ���	��u�u�$`QW,xi��M؋������'9��C?�kt�E�H���Lz�0'\���w~%O�6�Lﳿ�b�*W�o��-��SKՇ	A�l���bN[ ��_Lr��T����(`an�0_�|V]Ƈ��㱦LοT	���l:�P�i�S]/�HWZ�kJ�_󵕌�	y�4��������<�v��Y}ԶW_{�y#t�>���BH�&ĩ�	٠��ѣ�px�-Ձf������`�sm�we���Ŧ�� w�cG�K5�AMW��IPA\�<���_gmL����긳��R��̪껭6��y���$i���ٖy�;A��tS}�S��E�;	%+�&�]�諻Eɏ�L�ټԆ�����<|sT�T�\sy�Ga	�J�m�ʝ�Pdin��X���S����t��<d)�g'X(��G�uʐ�� )]����I-�C�%����������s�s�V��x���XI ƈ��fR8�ДJa�8��5aM��rTsbPI�v����
ɞ�p�OJ�|)��i8?�5,�����᳌6���J����/M�6@�wE�` ��?����&���-�cG�B;�wM�9K���X��U/?��|�'����K��L25'�"5װ�r�&R�t�Hx�U�ډ ��T�M�����;�):y���~+�����.��\bI�1-皳Y	���:�S�mK���ܮzj�,�@�����Oy8�--��՗tm��)�N�9r�[(á�{s|��;�6�2T�G�m��<À\=�C��N�9��Wj��4��=��I��]��Sv����B~���RM0J�2�ƓZ/�3���j��&2j��#g}�A�2�B��Zw[3K%l�il:=Ԯ܈��(p�j��u�IZKM�O���3w�ĘT�t9-,Sȿ�m*����\��3-닃|��乗�8u�5��^���Q<K���y
u.�u��RΙL)�km��fL�H#p^�}"�s��ͬ�*r�Ɍ[����{`��v����m�'����p�eϳ� ��(W�݀�Z��z?0�� 0���e�G�L�J�0�������=��E��D�Yk���N�D�q3�*��d{������ B���R���Z���Ϳ{��9r��:դi��3���C��n��xX6d�P�����M���U��B� ӳyT��A���[Y�⫕����G;��F��ɚ�	�8���ޒ](�)V���V��4'�4%kj����F�U�W���趸ǧV�Kל"w."���6��fs~�)�L�m���+�zl�t��Ӫ�[A�7���ąT�4iJo�c8� ��x���֎9�P��W_��(糚�(ħ�Ϭk�����'L56K���\&�M��^h�'vW�o���)�/K9��H�n�S}����:�f4t����9��s8'�\��'���i��Z�&�:���^�0�E[k����o_����"���9G��?�z�Z����sJ�D3��	ˮN�}�@��HVp�ԋS��r�X D��kĸ�i �
_ n/�!����{�O�xM�܆� �p�r9O�.�����S���{ʿuD�߄}�B)���xN��D� R�=j��4��<S:,h`Tb�\��f=�u^�`n�#���3�c�2�5MBI�(4�<X�H)kR�%!~O?��F�y�Bʳٓ��+3���M�ݖ�����)�G�L�oV���
���;[��n�u�S_��Nñ�aȿΪ�Y�Ob9�A�-%04C׎�s�M�e�*��~��ϦGKA=���x��|n���Wn	��h����y��\e����oȫ��c�[��x�����������V7��܊��}'��ڬ�&�b9Q��ڍ��������6of��N������=(�?Dћ�Lk�ڌ���5~b�)2a�i���N���y����{�䛂#U�C�j��f�"9��ɲ�y)i�F?Wq;�i���97G���H�Lu��'n9��s7�i��v�N�`����4��$���jK�3/�҅�OI�R��9:�Bs�':
#tF�*��sM�>�߫�n���zo��`��(I�2��Ac�JTi`�~��0��B�hb^m�߲3H��^�	��+�F?�]$�$UXN
����
̏��*��X�AÜ�q�)L�21t���h=1��;l|r���C���p3d����J�D���Z��O����|6Ђ�g���8ߔ���p�:�_�QQSl,!��R�e�j��#�|ʐY텬�ڢlS1w҄5�%�y�:t�^Z��|�?ߦ_o@�a����Ӡ����A �/�y�61��3��p�R�����x��e#S�jJ�:qƙ|���d*��B�+��    O�)�lQ�����)���4�I�@��{5�D���}p8d�
u$Q����zi*�����;�z��l�0Z}�I*�l�])�I�b�X�a�vm�u3��M�>5��tܹ�Ky���1�'�:���Q��Ő�(%Bـ���Yy�v��Bҟ�/D�4'py�e)�>��˄��z�����50�LW9���
�4�~p��l&�����o4�΃�������ze�{>����⣓���7�e�}ss��� ��M�����?��2j��=�T�'v�Hɢ���i]���:��J�j~�t������k5����ĩ�=�oB([��,�E� �R�K�h.@��M����ג��U
�k^�];�R�Z�q}a�$�?ޤ���AK6�%c������r����4j;^ㄖ~�2F)���V�]v/7TӖh�j� �z��j=[��Ě��Wp����U�k���(w�L�ce��ɇ�� ����6�b	��I�����x�.?P�����|}���8�����:�a��:	��u"�������z������nٹ��m2�~N���!׿�X�]��&�XI��)#(9U�
�0�[�G(���P����њo�k)��O���k�r��3����6��Nr�z�I��¥i���u�+)T�a�7����<�"R3��ͣ���ȓ�V!ji%�D[�L~�%��O�'S��#GG��{H-��|$����=Tɜ�uk �+N~l�DN���A�Y~��29X��,.Vh�����~eʜ/�9�bn�0��\,�i�)��T?IAג�������:(��%)e��@�e͘�70E�-5ϴޯ��fC�W�nt��(㺵�͓��`��;�ڙ�mg�t%�&z&P���d��?��R���!�s���˲���6�i���g�r���2|�E���
m���FX�����w��4ߴ�~=�(�%=�u�7=���i��� ��	-�@��ِ*n��lm�R1V_���K@��z����g���C���j�[����}}j�Y���&���L���+��UP�I}�	Tr�.�-�I3@�����	ε���MvJW��:�Y4Oo&Ϛjԝ��Ċ_���t�qZ���Wk^eM��?���➦_	�
U�� q@RS�����Ҁp�,�;����)ׁ�~��U�E�H{���뽌� Ҡ]��8;�� +�[����{�3y�>��<%R�{���-o$�ٰ�ڬr/Nn��O�-k�)���@}�\�a&lR�Q�� JE�d7�%�m����"�U�
��-SB�uJ�J.��!�~'�MY����)$���ǣ�Z�=).�8>u��釯���\�%��Mij)�ۑ#�"O�I�<|�n���Ʉ��y~P̟:�s"F�Vl_�%b�D$��&��c�x�Q"����B�
Nц�}�@qTE>(�^RX�΋���!5������֎\#�Tz�2o�dv�_[.[�����b� f7�~V"s�] �fR��\~�| ���x`�������W1(��]��d��D�2��{J`L���6Ie6�i�Ѭ��v�?@Z����r'��)Y]uA��8���5���4x[�	q��`�^���yQލ�<���)m�9I�.ؑ{9��&�cN|f��5�ܫe�m�N��o)
��Ɍ��o�/�f�2HŚ��6�kq��{�ad�D��i8.���O&��k(���rv#�;�%��k��`a�=U�^�U�>��X�, l�Ҹ��v��� R'�
�z0m_���f/岝Q�Lo���X����Be�/-�S`ܠ�F��V ����5��z��Y��ӑW���%�����#��vfp�jf�#�@����V�18��r�),w)\���n��h��C�\�ź⯤c�Ʊ��x�к�O���@wo)b��:�5
��K{��W/���I�.X��72��z�{*(��I���FL�-�M��ݬ���#8���չV}�]��=[-|�~ ��M��!�x����}5�Z���$���ԧ;9-�D%�֫�?�	,�o�\蓧<�$h.�kqR8�/�W�D̙�oS�R�e�v��	��R������-)hJ���`Gn-˱��517�N��p=��j���O��Iw!偿) �ypIY	��&�6�$iT�ɬ�l�Mx�4Y��nOP�,���.I��}�3�B)򏘶q�<O��]#e�<�R��Y���q����1��s'�s������:�QU
n9xY�xb��2��a!G��pg�*-�xV�`�@�?��kJ��q)܌�sp�lͷ�.������"�M���N��֫�Z�S�H���#}MF:=˝Z��:xE�\�w,�1!%U�
�Z
ϏaK�e�k (���B�|��oƛ
k|�����P3#�U�2��M&�_��l���y�iJ��1�}���~�u:6J%��+�����\�T���xM�4k��m�X
U/��C]��OZ�+׫iS{�y<��G�� ����T��o�����CP�`8Oτ)���f��ʳ8�����|����ѱ	�t��-����;@[����(2�]rkT�k8�s��%���M�M:#�*M?�7�w���A}IPC�}��&���5�~L���뚈]�@z~f��w��1�FkZ��y��~4���8�<@9��5��=�p^l)�Sb7��K�K�l�{57�eꔹ�>X"4�*���Kbɹ).�I1}V�7�e�1*k�@�[1�6O�ZI�!�{$�o��ar�՛|�d��̾�~�9�A�i�4����6�j�g�Q�2�`u��/����=/�O�S5�S�hZ���ެ?�H�j�_���O�Q?h�#]?V���H���-q��(�ǔ�\Y�>�������!,�|���uN�T">��r5�T��q)LYk�@�05�SK��ۓPJ0p#~SZ6�R�A7˖c+|§ӥE ���܄�֕�V�i�<�O��� �X�4�wJ��Zg@^S}�0
P��!y�f_nn� ~y�Eʱ˹܍C���L�!�Tp6�%ɜ���1��V?�Ju��M�i#��R��p''���{�߲��S���
�f�9�d�^6� �#�����T~�g��{�;��'w@�[Μ��;4��S��m)s�|g&G�9�r��$R���T^t�����덤9@�y%Z;s�ni���Zp���l�p�#�*�%�"��-�I[XsQ�NП�����Pc��Z��h"U��dn��;�K�9g�"4u]����L6����ưF�!�KS��e��4��|Sd�<�6E��]nZx@m��gf�J6_�e2Dx�fz��i=i����E�u��c�ѝ@�x��F���v.en����o���*
�!��&���<���=1#��z�e�"E���uM��\
����X�l��n+@L�W���v\e���^:��9,	�5�}8���ͭ�M�gǬ�Ԧ�9/���f԰�F��<$�|�����x��s�&�$�n+ZkNk�=�r�B[/�v�'R@��{�I)�R�%���J�X�\���31,�s����6hn�=���� <��������&���M�r�	r�a��[*s��)��r2�O�VmMYTfi<�=��O������<"ok?�������R��`�a��8Q��6�ci���������#���6oY _ʋ����c���>�w*�H�Ռ�UeL�l0q �)e�5�I�bD���_u���z}���Ѽ|zvH�:
���P��� F�ޔ~���߂����Hd�Klج��ͻX�& 2��������`�5���G�[�n�.����I�i��(M����z|�Uz	�|9/g��ާ� ��Y����'����]^X�N�Hf�c)`��7h�]�UK�	�,��8�<��[Q�?�4wAF�H��kKB>k�`�Ƶ0�K�lQ��=�ă�N#��4�x�ӟ~�0���F:��!~����"Q�|�T��]w����s.�>ڿ��B�����z���,_z>ˮ����b'����l�G�� ��I<���x���U�&qg�K����ͣB�f<�K�-8R#��># G�ƾ$#�8���ǫe��V����о    S�N:>";����VCEDT� B��g�9�xZȘ2�J	Il�$�~���B	�km'P�<�T�՝ao3y��W�e`�5�SN�u��ȇH�I������G:�D3�����-�c�h�Ks$���~A��sMY�u�,˼��Y�5����ż�����n���@�)�|��ſ��;,ȵZ7�K��\H6Y��F�e��y�-t�5B���cU��%����`��e�3��w>%��3�ڵ���]7�Aȑ�,I���^�����b6m�4��>[���x8�ߺ����F�s@�Q��K��*ulҨ%�@%�+�}�eM~3"��)e�$�勣�!�8m)���MqQ7���V9��X�����@��Sr�̲l�ҀG�d��HBgOD�iesP��l8��`�J��RPM��P4���g���n��J�)
G��No~�:n�
���A�J�D�C*}Go��ˉ�s�M�LmǢI�*���'Iٔ,i�1z>���i��_T�;�]���.[��'���g�o��M�&�^�O��گG���?�w�c��s��V?���*��5^���-�se]��03����TD�O�kO�ȡ��~JN�C� O����Wm�S���#ǲ3���9���Nu+�d"xKh����T���f����|�f�g߅����k	ԙal)E�L�^?Ռ�|5�����͓zr�O�[q���X�zȻʫ��z��� r˭a)�Լ��Z��9�wn���t�㸞�]���ZF�B��lE���?�+�ǌ�&o�Z
��@��?OL�*x
��Yޛ�Alj��f��K��ΤQu%wx�8x��o�}!��i���t��r!�� �A��Ꞿ4Ol����;4Sp6G� ��v�{���QNU1huB�5'�����Z���E?���o��M�#�ob���H�'/���),�1�%����ݓ�{��=�%Dt0����F�����S��e�6���B���9I	`Q��z|T���|A�<mbO?D�9�}_�:8�a�v�%G��lj���$��R�����tp�g��2�n䕌�^���\<w
��r	�C�m(;�K9��g��3Ø�;1�4�h��")#g�X{c}S*�@;I�W1a������%������6��HvKCc-G��& �t=[M�ir
�,�?:�j��|�CCUFX���vG�Zm���eғ�Gr�R9}�K=��c'&�Ք _V:smP~$�9繜�dC;{���qق�:���x �>ے�MO�otY"p.�ʽ���g�~Ȏ��Z$Ԩ��ε�	A9��g����,�L�����D�
f�ɳ�t&���D��7'"��y��D��Y��<A��O�-K㯓Qxɉ�)L��ي���y�0k�$�ib�rZ&�2�1X�d���m��r����Q�:xES��7�BY)b�w�(M����H�N��2K	u{���DNZ�"&͐e��?S~�FV~�j��it��|1�jA�iy�'KȒ=|r�����N��C'\S��nӞ��iJB�<q�9�Yj�X~�'K��3o�gI�� ���E�I!K�(g��U��{y/'�U�)53C�qh�R���Q�3��W���M��n��ܜ$=�����q�u�<�۝���vmZ�VX������0�;2�$T��� ���L�#=�<�T����]`�6��g���'␁�	ϝ��J}��r���"���.܆�Ycלkو��
侤���v-����5�c|e�"��j�?'����1�a�Q�����re,�_-Z�h���t;�Tv��i�1%;
���#K�%����(1�5ҟ-�L&�zh��^0o��Ҳ��l�b!���gs��t�U&���8�''#&8��y/Nߗ5�,��%. �V
���2g�=9J�^�Lf�y�d|�R�m)�:� �}ڟ�Q�5��+{�VZ�p�X��dT��%��K�mC�N�L�W�7'��}��^�{	�˧�'�����X�ꯦ�K���X��#�CH4ڻuĚD8��~[	�����2oDm��wv��Wmߍ�{�Wb��N'�%�K\�o�}M����W�u���������ύ�d�:5�i])��p��7dy$��G�~�U���M���^^#�]��S�UM��6P-I{���1G("�$u�$�w�Ҽvc]+ �%�q+W���
*�L�%P�R&�����R����!��*��D����Sެ�΃�8cn���Ön���c4��L�,Z��e"����2�� ���t���]��#z� �#J�Ԕ�d��=$��˗�~v���u�c�t�»˘���M��5�m����n�[�1c���%.j~������a��"�0�S�.�	��2}���ѱ|��!<��>��	�{'�CW;i@T[�H"�y���%�0J�`rV�hs �����H��!����2N5�<�F��#���O����QI�Q+�ĵ[Kc������͌%��m)����]wՒ#�G����I�'l����}�뼄Q��e����0��y�."��jIc����o�pz_��X_L7f$�bP�r q��P�`��a1�M��),���,�Hj� ó�?����G�����1�x����qLMj&���V �C�w�Qa�uM�1r�謗��k<?�2�G����e��::�3i%o��`������OB?���J��y�m,=H ��te�3���V ����ǯ���d��m+��䑵��%�)m��˦��W�Y�]�]�ג*9X���鐕ty��#I����Nz�V����sv����m9���W��їzXJ����.՞;�\/��5����U�X*5}K5Ĝ[Z�C�&e���oÅ�,�X!,�I�x��NI6N�P�w�A1�u��'�8C��&Ցk����ǽC4��q�fYδO+���!g�or�+���[b�t�8�.�"��mM��W��� Y��tp7XUQ�o�'�*�B��u2sz��9Qs[t�ozޏ�H���,Hϗ�A�I`9,�s���ݟ|r�R{4O���9�A7:��'��������pxo��M-�\�� ��$v�!aԒ�ׂ���RY�?���ci�O--/p&�j� �0;�5��	�-�J�3�]JOw��k�!P��Zo�{^��;����N�e6�4����<��.�/MڞK�ӝ�p�9�O��S:�w2�^�{�S� �U�����ճ-Sv��Nht3͍�Bc�y�����}� �|��[ %tӖ�f"a�I\���k2<��6&b��x%b"���*�~K�1M�˜�W	�A�ͳ�8W��7}JHKvF m�-4<��t�d����s�%G���3r>5&���3��6��{
���L��ȵ�=/��&����d�<��gɺ/2r~�-go;���luQ�66ñ��tϋ[s/���B��+�ϗ�jP�Xފ'��f�O���c��J����7���$:)�V[�"�Կ�b��.1;��O3��/4��4��ݴ�R�»-���g�G	}:��M��I�&��3�"�}�P�e��0 i�@J$K���U�B�dSֲS����#a�"?78�Li#�iꔵ[��|����K �WL>��M�H���̿���"_�פ��~�Dcd��U� ʚ�Ԃ�X]�8d��/翕��qđ�Y-���1��F�����714�%�,�a��pJj]r�O�e��i��k�L&r̷��M b$����
+����j�����iQn�cJ}�G9%��)�ϲ�h%�� X��y��u����j&��
�#�4�^3./GZ��v��i�{�w�U;Ň0Rʮ�"�B����$&����$|[�U����&�*ʓ���$��|�!&���4r��I��.���i�L��0��c����w���[?�����~���JyXzN�1�23�a��N��
Ww1qlk�K�gM ^֞�<� �l^��q}���T�B!��ų)�_՜=
��B-��h:���dZ>�K�+�y�j ���d�G>n�V&����
yE#�s�XԿk�E�Vāҫ��ʞ�<Τ�|���3���m~��_�&�d���=��|�9�g2�����    �����\�v��n�rfZĴ������5�h�r�s`��Ϧ\ �����l���p�3�R��R�'9��q�7?4�6�ٽ+�e�[�MRe���&�����=}���X��	*I�r3���ͣ��X����V (z/%Ĝr�t\�3&dA����8����r$�K�a��<SB)�_:��)��R����>ޑ��ՠ�� ���n]��+��@w�T����[I����M�{�G�ι��D'q�K�MTi�	��΃Z�<5�,��_�T�Ȳ�4ܕD!��vk��KA`����u��y���R���-�#^GL4�S�pT2��!�@Y4Q4	fJ��O�l.Rу5�L'��ƔZy,�n�)]��t�I�&�ͯ�2��He��ͱ�K�Eb �sgW^��jW�7"a34ο#��I~�%���ΗA���8L4��,��U
��}ʉ֊�# "ʱy��j��.����߭fR������t�Gߋ]��ڝP.�qJ�SY��}|lM	{*���gb"����|�>��
x�����	_��hM@A-�/�)/���K����ue,�so��ZaYR\!�,��\I����<`����L=�����?䫱e��\�\��yN�{���$� �)+���T:	[ W+��3z*��p��&��.e�Y�ѵ*����{j��O��4SU����wJ�Ed�Kk3�7��_H�<~����		:�J��X��Xn��Z$"\�<�� �@J��|m��F����<�|t�t�e<m6�OZ�6�5G"��R-��(���t2��P���l�N*Ek�5O�+�� <�A8;K,vL7��NP�c�x �?i���pd�J�e5��]�J�[�Y 􄛑�0��Ҋ�'zR�p�"�r����-e�y���a&1�G�#t�_S���&�,H�����}��Y�@#��R���\Ko"�Ƒ�������(�篤*D��<.K��J�8gw�E�ú@�R$�I�/)�9@��A�-D��,`�E��*uݼ�ߎ�I#t���e�P�#�qN(�0])��c�y@���S�(j����8�����zBo�����4ɍ�;�\H����e,~g	��׽�����9MT��u����vr����8g�Aw;M�4��v���Vl��}���g����[�od�^�!�\:D�7�h�t@(���Te��7�"���hi-��uzXm2��F$/i҃9s�4,�����M/�,��:Bʹྙ�P �CH��L���t8b��q=I1��8~�j��-�gJkeE�L���|����t�U��Z���#LҹY�B��D�#����J5(М�~�ɵv#���bZ�nI��ь�.�J����?M;��bֹU#.��\�p9�Q��PO�k ��@y?���r⢔��+]�-���P����	��jm�b��o��OS��̬0��$���H�H�w�U��x��j�g�{]U�Ā�nZT\)4�rK�q���SҺ�s�~N*��?�e��)Un[�Q¦dL��}�5u:�Xe׬�1��r%�Mi���������e�9�K!���y��27��?>Z�y�S���f�4��N�����G֤��+�ō�W:��z��a�i�,��v��L��r�5Hw7G�
U�A�nb��B����|�֡�9]+]ˑ���{�+u����6f����l�f��8���].j�|i��N梤3�q�wR	$6�=4[�Z��L�q���w�J	�	�����V����+%S����W�:K�S?l��`u�F�s;49�s�UF[}'�������IF�f��r��T"�!@��Xh���T�k�U�J5=۩��]�������[��̗��/��,�h�X���	T�O���'���7&CdF/"��B���I@�Aْ�qVL2���.��3@K��eZ}18�B�@�M&�9���YnI/��DB���D#�C�˕:3�f@m1���0&�w�
b\�t\�z��-PXJ���~�-��ټ
����:ep�܌��W\RV����b��&0������u�7%���QR�-���2I�����w��0���^f�cj �8\x(�#�M�ˇ�|NV5i%�ƕҐ��C�M����v�������63�N�r� M�"�.N�$�k;����a&�JK��w=��k��-�|�Y�
ҍ�=�f(C���-Y]��!4!%��v00>����[:����,�4o�75��FhI����&(T���(��-Ԡ�����S�������}�,(Ȓ;W����4�|O�b��� H�s@���L^���֞�p�8'��?��ҁ�W��C��,N:0�`~y��a7!�������w/��Ã5�}t�z�Ј�])�ҧ��3�솲)sp�0�}-����_�^ <�k�#�^܎�~�w�M���	�6�&��3v�2�P���&��oK����T��5(����;9U���Iq��ȭ"����Y��ǸJ.�M�0����D��/��K��Ϸh.�U1s��ڤ��>���~�p�Ѡ�:ڄl@�1e��S',�B?�}���3�a~A)��u���!�T�j�XBP���d�4��5.��r�W�HܭD�A�]B����!���ci��:8�t�yLe���i*��4�w��K�;䋎r
���^��l]K�.�"�<H*�Ui:��7rF)9��1b����	,�_������S��h­�+�W8yf�.I314�oW�DTШe�=֠���5���V��g�,O�!�i��|�ߴ�4i%���ƴ����%�@щ�,��[��i��z�/�y���ymdgXC�[�{I��6Õ�mI4#��M�n��69����2H���O�	��X�#��c���#A��3c������by��]�U����x��-q,�����NlHT�!S��f2���Qr�j`��H�C�Ƽ���ҵl���O
3�����T��~���3�q�l��X�$�gqJ��8�@+7鍜ϙ�7#�0�EHR`�|��.���|��k)�i��"$���w
����ɽ$lb����&�Qo���D��T�v$�R]0���LE�ЧA���cNR�փMԎ6��@����$%�G5�x�%\�d��)��L�#�9T�׻,�:H�&�-F�t�I*��˃���!a���l�K��ZW��U؁�u���"���1�8�����r� ��AyD�Be~K��S!�.դ���|*�]C5a-_0��%��������ַE���2�Q:9H�c���M�{[R-���s������D��7�,���q��j�3�F����k*L��s��}�5��O�ɀ�z��usc�:���D�q {^�ws�w�sj� ��CzFc;�:q��L��3���;,_�̆��9W�����'j��	/3t�m�����ǉ���y䝠��Q���Ӵ�x����R_�;��Ķ��oU�?��Or�-t�To�-���Rd��hGǺ��L���z�0�b $��m�)�,bKrR�"T��+�	�g��3�_"j�T�.k�S�c�C��s���O�r�{�X9�n�_����٨��D���k�+)������`�~iG�e/{�����΋���>���~�q��b��6C�{���pᦒ;]4�p N��S�K<	�7K�9}��P�|���m/���g���k%��Gf8�,+��n#EE���n�b�G��& [�y���P"T�-V�
���_��)|C��(��l�{�����N㸐�鱍rU!�AL�`���7}p��yJ=�yf2Z4K9n�H�@L������Q���%�<m՞�g�=��z�/�P��GJ���7��ur��W28lf�O�i
�v�ԊD^��"U����~/��Tn�i2ӹ ~$���K��h��D�3U�D��h�%|-��ն��0�����f޼8's�VF����b)Ҧ��z�de��|�L�d���|ԉ(��u4��z�b���FIz��P�/�w>�m?"����4�M
$,+?�w��[F�M�x��k	%�[@U+�'e���6�������l�~�    S�ä:	 %�������}^��6�Ҕ�J�.�����Iny��inzRT>�W��
��M)�2Pxzt�˱AUr��_���)B뾾�]m_��__F�4��-����lNk��X����B����M��e���hGG+�2h��2Moc���@�*!
���al戃Q/�T��K`��r�({��;���>� �ɑ�X�/�L��T4G��I�ܡI'	��nY�� �sL���ѓr�c���;��~QuVo�+��iƐH�7���Y�'H�VVK�츇�:=�<H��@���hsW%;�5<�+9��Ik��Q�*��/�	}�H2A���j�Nv-Y�2 ����F�0��1d�����s-!$dЉ:lUg�;b��v(�<�}��\�&�$������T�;ץnH��a22�XZ嵅F���P3*���ԑe�1��K8�P0���P��)�]ơz�yH��'π��8Og�n)КO�U���=���C����g�soY��Ci����-
}�T������I0=�s�� �ys��$���~NZ(��<����7J��aE��17/�H���3�m~�Z��"����ĝ|	�Q~W6��Փ�9����*�Q�H��
���ދ�:lZ��
���"�?��̄�V�}^�E4t;�I0�+B1e?Tjkߥ�&���l����rq��>Y��$�K ���k�M5���J�z�)�cp)��k\�W��:�~Qo�T�����3�LfG.��}��HFe٠��}藧䚪���®��j������L�`���鑳V�֤myX�$��v4i��9������g�HvV(hh����#�voTҍ����K�4����mv��8�SO)X�OP�P6%�muS�M�w�p�T^�[�w)�ғ(Ҿ&�3	��B�$gZ�0a�'�����	cz�s�k�;������A �f���Bb�����&d��-��� ?ħ
�9��R�?@�.�	�<��ٔJ�"n�#�3�fS�]�X��R�^~����VN��o2o��n���nҒ���>�����9E�Y���-�<�R�9�¯}		�)U���e�a{MK�AeO��;~����y�1�V��*��zdq����q�f-�ݖ$M7/����ɍB��;��*��Ji��fO�QE�|C��P����Ce_콝��8�m��^��@.�����q��~�t����O��~�����t�{��l��jA�Oe�Ѷ���-��OV��.�'�L���C����3���Un�8H#�&��;��9{r��໗]ԕ���a��{p�5v]IWj�S���˂侦J�B��n7�2cʁ�~sY�i:׆�hk��49y���9-��c���P7��R����/��LY��=�n��#����)Թl�FF#�a���9��H�\DX+y+ӕ� :�%Q�b��{S��q�y��+Q]c�B�"ȸ��4���S���9gHhH/�R���^G!ts���S*P�L{׉"p��x�ttǏ��Cj᪷�#�����Rt_��uU$�f)�X�>�C�������Z�$��;_%���!��&�T=MV�~Q���A�?Aa]h��1���o��ם���RJn�k8��Y�^L�\���-����|^� ���9��ma��c o�庰?�/�[�:�޸zO4J�$n�{�^�:*3��]atM {?�X��h.G�"Ք]����W|���~ӥK��^��9vL���n1�f����=�v�|�-���HY��#'0OF )�m_�O��T����%�Mp�!����xIR�5����Y�l�t��H��o,�ʶh3��TD�}�[=�m@�{�-��6#R�"�]J�d��f�HU|�^zJ����<g�#�_3���F`!uF�gY�����Fpr�L��sK$�(���"LD6�ԇc}K�^�$�f(gR�Ǐ,p��#_7�a�ة7!��N9>I��S�<#'0�>�ܢ[޷%��Ώ�Kn5����G�=��Y�u����ld"�l:�8p�>��N����㕛�	�n��uѝ~���im�f1��j�@]�,O��Q�I0��i`R\�a��g��*`�Ih�=�����%��i�UR����D$��JAs�����F�m����(��n�W���?��%Y��t.��l�RL��]��ʹ'�����4"����DB䎗)f��|��w��tr�P�_�+7 (Oڷee��֭41�������O�Z�k�1Me����l<���c;=�����zѡ���|^�lBH�����@x�s����f��������{	`�J��.h?K2�6i�0P�"��>K�[�\h�YPS-��P}<~!zO��
�(:��m�uy1пg�r�u�o.�.��_�&V2���^Pz��kS�ЪIMt�i�N<���߹�ά[���x�Q<�F�0�ךrݍnj4��<�qnIeE`�iZR���NM����ფH;�� D���2I��bS��B��2'N��b�0��1�<`���2�le0��/����/���r���Z��Ǉ%M^��{�_L�9j�ɼ+-^��dp�b_XX�T��sYh�����}����ۉ�c*b��~R�`Ab7t��d��vtV��
5��9�o#X��
�N����̂��X��d\i-w>�Sf�f�\?߼7B�?�zO��H|��u��� �*���'.�r5�9[�dŝ@���ؼ um�	�R/�ʻ�̭]Pl�Ú��M0���1��O�[r[��-G�i3IJ���x{���쒕�q����Ӑ_Ƙe�x���G!��.��@[[�p��$����?>O`د�e2.Q2���tL�b>�_ʩ)��m�-��T�.�\��RB'�ƝDq�r��S5�GALj�J�T��m���[��ό�<AZ<'�� �s�N�ϥ��E
���]f�t-0,�����~�3��j}�:��ح��v<jٌ��I>@�H;��z撫��`[���sϘ��h"&����MV91#�R��f��3t&os��=%9��|��=��f/�\����W[N���oO��Od�AW�!Y���Z5���l���)gm�$;7'�ӏyI�dB�:�R'Zd�ͪzY�,q�w��17M�4=��\h΄��rr�7>/C�2	*b`<�V���1ފ11��^�\ҹ�f�{��v��x��h�U�~d%ҝf)�+�=�+R��5�(xyO�x+i�d���'/����h�}�_y3�$��}s;�۝7�#?-�#��.�W{����7�Լt1:����bs�@I�'u^C���^���x4���+�
�')�1-�v� ���N��~�F�'O�=��T�kk7a�o"�z�93$�L����8I��~�a~t���<�v=x�ݮby$$@����f=M /���4��I�A+*�*���W�\pA�T͖o�h�\�]p��T�RD����V��`�_NvJ+���cs���s�sȟd�D����Юș��=i����R����ǆf�ch�\�h�6c��K� P��a�&�iP��fչ� ������ҳ0�~Jӌ8�Di���daK��B���#�gy��u�r�,�Mz��˄�ӗ��Z�{�L�:�pow�2��l)qZ�x��FU
���8ON� 6�0���n
��l�$��M�KL)��2���{m�aE"�!J�^�����S�9Lg�|kr�8�BI�9R�3dA���uJ��zw�E����Ϟ�!V�=eCON�m��q#^V)���-/a�����pw���(�/�,F�|�kȩ���n�K�]K��^|[j�/�'c����W���}���cJ	J50%󽏗T�����]~de����'�o��+��� �}����t�Wy�)'�+�M���j��� ����_�Τ�Cœ��=�ڡb7	+#�-e����፴��6f�Ԃ6["���l��>j�v�=I@����_��X������.qS��4Qi�[���}1��FN�B�%.J�%9�2KRݠd��ԇ�Is��w�f�=��=O�u闛����3��A�&~��/y�fUo����9���>3�#��8�    �˙gC7y?r6���/�`�A�A:���2d���&*æ�꞊�4�Ї-��<�&}c\�~��z��t��H8j�5�='p��)s���`Jo~�ρ��(��u�<��n�4���'e\j��Jrhu}���tfU^}:2d\]�3��&MBV
�σ:�ϭSJ�����z��{��鯣�� vt|�;��z�%�̐��O�M$�H�r+u�S�b-�p��.�+ˇZ�+�J,�>mN/R��k}`�.�C� �J�^�Bb���{YHn��v����E-k9��ߝo��%�u��0�'NWO��.}����`Rh���3��ωbp�c��,�y�4�\-�׿{��m���<���2�����i�������z�G��B���*���̝���b�N���>���<'ikZ0ބ��*t�@� �vl'��Ü�"�LA\�+3�J+CM����W�x�e9{N�`�t'���|o�:t��N����V��t\ߋ_q��w����򦧖���($b����yys�(�<�?l�����1ޏML1��2���_3������u���˚��?+ĳ�SB]4V�)�C��P 3����+ɋ2��U��I��159�ﵒ�Kc�y�̣��g&��ٝ���0��U���|Y�9h��2/��>Y0ތ�Q��m��=�m��r#]ՠ��^�h���[�Ѧ��e�{k�
��ȇ.�Zc�S��J�@��~�F�ML�J���Y��3���C!� ��3�^s?$ZJAPU�c��o�qE��yWľ�30+����V�?�L+�痫�h�=���eS��}�I%)�x��	s�R,�\��y7�mj���Ī��e��J�|F$i=Y~+�.��̋�Ġs2�|9{-��T�μOv|gi�!���Rk��b���=�/����/�qMm����S��ڃ�qw]n>�\%���NPA�E)�_J�$��\��'Q|*� ^
�p:�D��d�)E ˹���^?M0|T�N�[���+�=N��v��_����Ϟ�ii���m	�%!�H�� �g��9��?���8���{��Jv��߂+�����E��m��D1�jCH0�+ͨ�=��;�bn�Yn�$8�
�7�}F�1�R��e?>%��v>9ԗW���;[��uqO[O�T+�$;;Ņ��e��>�~$��t����GA�{F���XQ~xa�-9�&I�K>*C�A=�oin]����u��9�F��-wʜ�]�!���b��2�����H�Q���4�
����Ζ�#�u�S��9�� r_���4�\Cӟ��wB'���u����4˗�~<��9����\�
s��lꊑ�,5A�Bר��I�rS+��q�wZ�+IHw�]�D�G]=� ۣ(I0���i��/���(��6Z�7�'�|����l">����-!���{�n����L����Fΐ~q^�]�I/28U��YS�
V��؁��L��H	�ί1A%�7J��<bӼJQ��ĩ�ly	zZ�d�f8�g�=����&�����d ��Κz\�~��Q�D�&5L jy��p[���n(Y�ȫOL�fTݴ�yj{O-z�	�#t�^.lҎ�A"�}��qMe�t�f0o�-�Δ���� ��<0�Vù1sʿr� ����	�u<s[�䱭Pz�N_{�<�s��7�4���o�id������+4K?��B�=I� Y�|L������ar}[)�q�d'r�.o��v����,M� ���T�,�]����$7�%��ڔ�B��~,Orw���ZZ��m�ܗ�,���72�<��D.��z ��"w�k����xu2.q�ƽ����Zœ����r��yi��C��`ns��L��,͹_���c��EC~��fS�^�Hҏ��K,�o�5�&E��ym	� a��=�{o]�L�8o�F�>�.Wn�A���M3�*�̰t�_k���ek���p|Y��ĸւM��K������#����Ҟ����z[ �\��3�Ӑ�jM0�����.�f��쬅���D0�Q#�ڛ�Z>�OA"?�li���hۏ�P���I�A~�U��?���4�p�G��z�\�i7�:��;�p�(�0#@-o 9$���T�D����>*|/O�^�^�8��e�`�7$��(��7�;R��>��%8������/g�3�%d#�_�	��ִގ�0Oe�MZ��2�H�<�D�T+�j��K+3هV��0�ҳ}��z&��B��=^��[-���m	��X���M���i�9��Z[9^���$�������di%wM��%��y �.
09&�K<;�$��]d;�r���%XgӦI�u'���u%�c>	�P*}��5n0-���(������Qɢ�/8L�+���s����w��Wk��2&C߿s�&׽h�>�!)Mr��(�O�=�QKk�l��/��悛���ۭx��#�y
&��sP�%�[>bh�m%v��}������Կ�*L	s�DB2���ǈW�YG/�w5�4�g�L�$(I�4�7����03�����I�ח8�孤w'��)��|���h��P\�|Qt��7q�Iߘ��tw�ђM��%�%��>��5��L4�]N5ɹ�4�I�σMRZ�unA[�K�ָ�rbe?�b�rYB����7�NY���}�KDg�������H<i��$��$�}�@֗���z1E<s~Q%��w�Y~m�[��d��0���[���<S.�=�E�p8ԭ�j��a��j�����:"'wl%;���V������
Ԫ쟾�}����\[��l��H�� |����k��l��A����M.ŷm��6Mx�ZQhQР��Q��[�&��97v�"k)	���x�A�y�+��Os��D�ˇoޤIN.@r��j�	Ǝ��	�DGH�=��⾤Y���M�Chsv[>P���R��Y-`*u��w��t�Ä���HWcn��g�Q�)�}�����/Ʊe�=７�ۜT�����I�:�Z��&Ԓ�;o��41��ȹ;lX`uA�_�4j8+'���4)�ę�ϯ�4~��wy�? q�Ϥ�fE��s�i�����q�g?�#�����ZX���<\��C;W�P��^���~��28�RZ������g*� E7HD����p�פ��)u��y,#�:�1���W�yc�A�`�Wr����I�Ȟ�mi�����r/��N��HD^�m�r�o��'�|z�/���8�R=4����S��ءg������Y�B*��+��S���p Kź ��A���_?�t���$�r�.�YI���H�V�氧��%�c����\����mf����R}VFY_��>hqv�Jv�np���dc�}��W)"}B(��b����e�d����U���W|Ι�ɾ঑S{�j��V�R|�C�{A�h�ރ�����ң]e���~U���s	�5�L+�S�#�I���S�����T�� l'��a̋���.�o��Z:\ʶy���5?��O)f�e�\}���1.���K���}P"]yjɺV���U���ԋ��}d���nL>N;�#g�m� �����)C���yP/Ͳ�ٰ$�'ONE�4y�ט�ܬ�w��k���^����.�@�ұ�t49LD�I{�@�L+L�R窞���pw o��Ȁ�����H=-W�p.)�!T�̅���Vx��"�	?:V�����2����?笉aBNQ"��'q{TT�E]��$�=��?�7Åoˮ%����/M(L���$f��Z�,�:���#�e!7"}$�_K���+u'-�k��St0+�tF��ϸ�;�	�u�u}�-!ڔ;���o�������8XF�X>�r�^��7��.k[���()��4=������r����0{>��{�b���*�n���7f�l��"�����i�YB[>8wπE�������N1ռ����c�R���(M/�����;Oc�'�a�9�Q.�c�u��{K��XN@T�to.:Uh�ؒ�ގ�0�����-kw�KʗH��=NTK��|.X��z�3/����K�v-�c|鲍���   �cL���r�35&���������LH|-[����@5�?*�V�oɗi��3'9�i��3�K+E�f��no��S"�8ȫ�W�h�K����}Z����1�T\iA��R�B��$r捥:lP�O:<��0�<=��vZ�(��z4�{�X�����k�� �Ք?�o��hT�ģ5�-pB�H']�� ;�M����6p�'��9��al�q�`CL��E�uF����,dH=5�*5�P����0���JzOm��\�/�r>���s%�砚$�R��]e,�r�e���q��@�hy�粙2����L�rwZI^ Z�F�/R��k���e".�ȑj����"r�e������/����5�ؤ�h��:�ۖw�6��d	������y�=�(Ϛޔ��`]�t0A"9�eڷTpSN�ܵrUv>�����hQz�)��ʔ������,Q��۴0z��8��0d<M:n��d�|��_�>�$�*;�<�KΊ�K��夤O@�u�̔	W�b�;�$Y��^�Ց�;?ӕ�5Ur�7�jڦ�4s�=ۖSD�P8�(�y#��m����&5��;_^ω�oM��a.L��/�2�|����`�p�P�����O�/a���.�wR�7\����%��zfga��_yH�w+�rz�,_h�l���l�>t��2۩����ZjJ,�g݈s1C9K)�	��KM��c���N�����,y�E���%i)�ߏn"M���#�{m*쥤�tu���a-Ǌˮ9������Y�4=�Ę�Z��?X!I8�ؖ�n+v��Vg�m��q��Hw߬���#�b�IĪdx�l%��-��
-��J�IϷ����/ڝ�l�E^�"0�EE�밷��Rc!Vokz�D������_��)�S�\	���$�jw�Ř~#��4t� ��8uTC�%�aO)ux<��9Xݐ���r��C�4y�'��V//��7�{����&2#H.>J��U��-�t���]r+�tQ��
�8k4�a�6��@���p#�. �$��N!��m���+Iq'�.����،����B��!���/g��O�-o�5�ʱ�H�,a�������������O��t}��mnӎ�������������������������?�ß�|M�m��?������$�X*      U      x������ � �      W      x������ � �      Y      x������ � �      [      x������ � �      ]      x������ � �      _      x��[�-9ve��PI�Հ
��RA�G![�cp{Df�P@}Tf� �w���s����Zs��\9�i��?���_�i�����O!�7�?����?��c�ӿ��������_�����ƿ���o�O��oOH�I1������������O������������S|"���>�?��?�������1�h����y��u<e�����?�y���-o��Cx����?�7��M�6=�/�K����S����k��<�:����v�7��9�3��l��k+�g����w��#G�����O����}G~�W����_��s>�'���u�|��}~C��|��w�?Vҵ���?����Wte��?�O������x������~;��:+Ο+�����1�Qr�o�!��b*|1�Z��^W\o��M)�̵̉����\�_�)����oZ�9�T�ZFq�f�o�-N����Z�i�/|�<<���:��<���O��d:��?����3���|�?��'�'���Sx���:$�=�P��	/��s�q�/l�(G���PJ<���+�<f���6x����{�g�F��|cO�����W�f��~wҳz8��M����R�|�ǀ����������Ld<���ǫ��-'�9��'�|��V�k�w_�r^�~������0�?����}�>�/x���2��_���(��L�����kO��/��{��?��@:#��<�}�X�����+�Jx���>��Js�bM�?�������lu�z���X�4�[��^�o����w+��O�/�J�y�=�����g�S�s�z��N�t���٘��-��ǸgX'��7V���W^i�ZV���N~��u��c-l,v��Yև�ɧ����gWB�Z�{u|����wz�e��m}��F�#���2s��#]u�hż·U��+i��)����a)����x���~[.������S��y6�\�8tic�g>+p��W�6�f��1��������S-, ��V�Kˇ��蝧�7��pR��ڱb�;^a��;�9�+�9܅��y��%�fwfk;w�>��Xkg��K��痾�k|��+�������w�R����'��6X���m���Ծf~ӊ�٠>PӇ]�ƈ#���o���+�������`�R�:����o�؛���j��O�𬯲���'��K�����wi�)� ]0P/�/��:d����8�/�X�wԉ�� �Q��Á�o��.q�y�w�i��,������n��a!y�V5p�?Y�̢4p�y�R*�[O^m��#摿�{u��s����=��њv�Om+����O=3���>s��o對�cSc���ƽ�뛾�ַ6f6�����>`���;p�ـ̫s9_\` #Ɂ(���d.6�g�V�oΙ;��>|����F�������-�<��6��Z�~��##���0{�/���1�-?q�l�w*�g8����i����ǽ��q��U������Ecy���Fl�ꀔ�[ĄUY�t�wK���x�]��"���+�	R�<2P�sm�x4����<K��msY��}�������'���k^~�듾w'���<�q�*'b�g�i�i���	Ĺ�[��pgl	&�G��ϵ?�yv7��ĭ^�|��o�Źl����9Oe�Y\�8��vvvE��i)s�{í��&� �K܀�iiF��9A���sj<��/����oЀ3]�*=����k�6��ώ���Ql���c�����Ho��e_{��w���9�'����6g�ߜ�o���]$�?U��a|��u������D>t�>�l'�9���� ���Ê@��\+>k_S��Xؼ�fa����l㬘?���sVpgg�T���e����}�F��l��͂��Z[���:�F����g=�ۃ���-�<�,�A#8����X�qʋY~�ƍ����v�;ۃ����
p|9N��{:�~��ϕI���� ��NA���G`�Y�a�x��n����*��	ræwh�Z�>ܞ;,�n`3�Ň�G��'�[=��*�8�0���@� ������ʇըX��MB��$7gb��j�����\n^Z7X�K��
\0� �9��<>8��$kk�g����g�x΅��@�,�eIH�o>�h`nz����h������ C��Pu<�G����ؾ
z���|��W�^�?��̑�LL������<q�������/�B1q��� 	�_'^�j�#B)q���5�;�{@2������-vf�TC����z�Z��,��4�),/��O�r<��;@pb��x�H���{�a79���c���ر�����7ۂ����T?�����-}�$	.�F���o����\���j�9�����S�g\�Ue���܍��9zP�;GEbI�G3I���آŲ�W�%�&|�Q#�
 ���0l7f�&f��/\����M;����/�*�K0���	�����0�y4^��M�Ʉ�ip�8��p�ƙ�'�:�|3�d��܀�q��,՞8�	�\�us9;��Լ7*a�*��2��	���~�"����%H�S�Y�X���ò�yF���9��=�d7@�)��	�0���<=����.�H�a�8�� ��O,�����<)��k.��T��Bq'GD���ӶNaa�O%��ѹ_���!g�ߛy|`Oi�G�.W��¼�s.H0&)��pc�y�����sRK%��q*���Q<lvxn'xrxx>>��� #A���/�=���*�� l�
n�������?<��
�x�����'68����k+{{�ˏ�qN�-aW|�~- xk�7|w>��4y^���D���%r� ����l���{W�.	������=P���!�H��2�P��0$|�OwC ���&����'�o������O�c�"c�#`���8��t�#�����Y��c�g�k��&�e�`@
6rBa��4���n�9?��ey @�X�ؚl���;�B�> 1.��8A;��W�@�vV,p]
��h��	b�6p���\?����a���m?5�Iכ�÷A6��B�_= 8tvzq���sxn�2��7�{GH_��c`�^������q5�\�����.PC�Q\��Iy��Zd�HH���d,8��K�/��
"�����qځ*�����v��}�O�
�j�3�ǀ�Lؐ��YS�A�gD\@������'ǵo���ी�0���S�
ppΨ�r��8� ��c�4�S�0�X�/ܑ}y6A'�D��J���b�d��cX9���qm@Z|7�����
�<��)0�d�Bv
�̹���8�6O�����ϓ�4��Sb?�Ep�V�1ò��"�K�N���(>��]�_���`�p�&����pkN<k��J�E�\b0H=���c/��b�Y|�+f����TE���5 2��==v��F{�d��| �/�3�8�c$�}=��I	.����s�7�h��r����^_T�S�^C����]вqⱼ'����߸��/{ޅ{{;thj�Oiq{1����?p(M���Y�w�#/�M�1� ����i%Y���+�\�;*@���i�?r� /��F={8�uC�)�'
��m�X�	�{�D�R���������p���`�A: ��cL�
y�/��K�oX�v)-��=�ўr	��ɓ��E�'�Z��f'{gH� Lt���	8���n�2�O���@q�o��ڨT�>��(��Āќ��g���$�*��	�FCB:��
���S�X0���� f����p ��G>#t ��u�.v���Y>�Ŕwc������هJ~y���D�u���a�1������8����_�TM�0�p48؇�4��k�t�F>+� ��M�h��		���Z(�?nM�#��0��_����u�|*�qko0�ոH���a�4A���u 8���}�9H�9�I�p� vM��W    �5�`9p{��bEc �H�\.`�?��Am]��o��� C�NX�����/no��H؟�r��xo�p���z���
c�mH8>�GŽ���@/�t�mQ��f*�sW���EN$'	�����ƹ�U�ɭ��&��K�A
oɹ-����`g����v�p ���Z[+����D&���k���F3�wVg�����	0	�
��bl�"p��k����/8���{9�|T��)��	V�3:[-bJa�Ƿ\�-�,c?\�ÿ��2���}_6���rX�A��0�!V�����=�_�݀'?���k��f��o��LÓ@��%K��m�\}�>�p�I:"6/����vj��ݡ������s"�'���\�8M{�@��O�t�w��P*T#�����*/H#cO<����e98�7�lw��c\��E���gc�/�W��E,���Ů=��m��1	�{���P}u�#|�ic�
| ��4��q�?� 	~���0*�a��l1k½z��%�q|�ƀ�?��7F,k_��Bg��@i�]&C0 ��xWzu��.8��~��PQ���PZ�y 	[
',|^�א����u��d�hl������ 0h^ #�;�	��sَ{Y��E���D��멘�":خ����cY�A�ͅ�	�� 98��nl�5H��^y�nXт�<1l�x�;�6/7Ȏ#�Q�F]A���D0�A�<�KmN�\7�X�x8o��7v��6��a��}�n��k�d��c���� �� I�C>xy�_�`�.��y�����??x֯A��sG�(�� \3�?o &�I�`�iKĝ�Ƈ����;
G��p���abdØ&���'��#Zh�"8�"#�,��z����ϟ�cI&��{`f�龗�Oo��s���P��1��w ��_�n�b؜J\����`J@��f, ���/�;<���꛵2c��H}��+T��a�&
�겸��\��w��=�i��"O�J-eAHJ�?��y����a�ü��5
�F/6<� �֘&Vuo��r�'�4:�<?��z7��P'�����e4����`#7	`ܳ��!К���~M��QX��a).=�t��H쿈'��O�B��MЕ �
�g#;���>��a5��1�&��̃��GJs���`5|�a�d�pm����)f=���|��z��0�jx��3�G�qX>5\A�`4���a�0�o�a�����k =8���Z`�L�V��,Q��l��s%�4� &j����6�5�b�şM��g��p�ͩ�Y��q��7�4���pIl��l�EL|�����Ē�	�!#	�n��
v�	��S�dn@�r|�����3�El�@G�n�_��ߑ�����F�jٚl�r�;�l�(yg���x�3��g�r�+y��0ϸ��>���0�/��K��X��bz��8}�����W�AOZ,��(��3�J�U��]
T5�F��[�e�Ȅ�)܃��g�;���d�R�����䛃�%;�T�;���_=���e�N֏;7�g<ǣ��r>l+�gx1�K�w b�xg��9�cF�^3Z��`Ҹ�ǹ�gp�%Il@��כrp��m��'q߰��L�(Gy�����f0��p��pO03�@�!�Lb6L��_����o��>p����J3��L\����E\7\'� �Ͷp��qã���{�+(}� �#��-��&A�Y�mg�	����Cj"����\�6�ux� H�D5��+�7>؝�A�[�n����p�0:@��k�������!�|�dĉ5~MQ.\ktCeH�����{xO>)�{bǴާ����8 �0�-݀��@�8�	��fu'6��= ���"v����s/Hx��tk��@ \ ���aݰ�(���g�����7涍~s
! �b~������ﱗ_\���1��4���������:� s�9��#?t���/g��0@a�Pp��������*GVG�^y����F�&<!���<�ӓ�,?^t[�P���49v��cWTr�����2ǫ���6NX>�+��c�1�6���0�e�Ibӧ�pә�YnH�P����9ܱ�p���W~�DqK?|eb��9l<n$aT�i&�k��l��u��(�﬘9󝆲�-���Ⱥ���5 �y�x�������x�)|Ĭ� �o�ӂ=xpظy��'�,��`�}BO�S^��r�-�	S��ͮ�n�9���ɢڲ���6���Yg�/���%+s�Y�,���[X�ym;�9<�5������E�_0�ٕoZ1֟d���9y�	���qwB,p�Rz����Q�{�������.Z{Ռ�+�"�o�`�����^Y�)|,�0���~�,��"�2�L�u�Ua�(�k����$���v��0MlZj!cm
��[#����׺ 5�)��+��v��[�l��+C`���
�E"\,.A6t^=Wآ��&}������b��4��jk��&N,���i�G2�e�k�6 =�=F�,��N�L�-u�+��W�r����[<�O�y��a׹$c�.�y<��T)i�v	?��(���F��7���
v����� ��P"_ �#?Lx��o�VCe��d�1xA���Z�h	��y��S���:-0���`-�W��-���C(�a���d!A`U^���,����.��~8[���s�GNT��E�����X�a������5]��k��s��R=�э���`{�tm����`�,��
�������}��g�.a�o�63����vK�(XѾv���_��Xy�9�� Öt)TK��*ƀa��*� 6��zU#k�����C^
���/��R^�髃{z�q0��E6�=����kP�7��W�����=��� �ᒄn���}p��c1*g�&f�7��J؁��X��N�Y����;7j���|�+f�'�:�l=���}<����!נ&�*�6�`��*�������Xht�(`��a�L��Xs��u]�8�YN0�0�+�Ɂ�ڷ�o��ǩ�D�"���� ���4����D���lS"yZ��V�@�c�e-�g�ւ�lŚ`!зύ���F�����[gu����|z��]�t���0fK�������c:���x�n�u�0�w4�~�t��H�_k��g />�y5�_]�������L!�4Y�,���`s��F�9�$2g���Z�Un5�;9���ڪn!}۪/A5+J.<�G_?=�xﺏ��[ܡd����r��W`�����;���b�MuZ{�u8��U
����}����������%Z��*��>K�{7�Y.���1�֦�,������Q5�qA[�� �3���곦[}|YG�}��X�ȩ�wuSnẊՐ"-��0!������3p��br�*�]~!"Gg��ekj8��	���Ec���i"�yK( �7���~̊2�G<j�v�g���5ϸALÖ��p����j���a���g�������XgHO�>��7/�3+��C��)��g�f3�+~�n���5��,���qC1~V!��q��P��$�bi�-��v�1sż-�t�3���<���ʩy�ϐ�H�eA� ���H��E���|5��܌_����,�j�1�q�T'6Z��&rk,�)�-��V(F������p����0D�Д;ˁ�r8�T�[��;�_{9�VE��Z��Ŋ� �(���Y�?�xI>��Ȟ�S� ���a��-��0�q[D�k���W�M��2C��*�2!..%q��m-���%X	�	�[�Y^;vg�8���iGbsg
�"�ӞO�eu��p��U��3hFİ/Y�1+�����X6� {7�
̋2F`U�f����    �y���sf�o�D��I�K9�.ܦb��4ymx?��{�u4��m |r� ��zF��a��q��$\�~�WL	ն�0=���*��{q/[|-O�0Nh<�`Ayp��b.�����j.���?�;�oYе�Fn��=<�T��.����b����a���sX ^�>4�|�7+�k��V���NO(��
��*0�$��!�]��K�ǁ!�!/����<:�7s��k���O�s��ӉǞf�z��,������-TC�1�[��~=���H���e�# �"��� Jp[G ���C0�3���
�'�0#���ժ}</�]���Um0���\.X </8m;���a)~zt^��KԺ9vtɎ�%	ٴ��3@�z�͌<q�p��ם�k���3|p�oָ?B�;h,��dIn?Ўm����>��5�'���R��ϭ����C�زQ~���A0o�k�In�4�� ��[��=eDo�Q��ؤ%"��e
^{��Ov���n�����3��|&L��)���ha�b��� T�����I\��BXY�|�wa=���[[�9���&�e��;����'��;ڛ��|�nqW4}�6�:�}>��z�>a�lаC	2�����4V�wK/1��@S����T������腈=]�͢���f��O3M7�m���,��ܮl����W��B{^(oK� Oۖ!<�&��|���%�b�L���ӹ���8��p	�vY&ڞ=x,�����{ެ_�g�(Äl��}��8v{�	1+h����q0-����@��X6{M>����&
Ld�e �ڶ�#�[J9fS� �<�(ٴ�&�bi{��~��G|Wv��I�=��Җ	:�0�d�}�1���v+�:߉!g�mP�X�U�iX�������86Ͼ!�I��z�n�7+p{g
���m�Z��Y��%����fͺ�Ƴ@W0���K�G�L)�	�-�7��4)M���4.·ENr���ַ��r�!�;N:���8�����h|,=H��ޞk��ş����\�ލt�J�55�ǚ��(ɚ++縶�,�]9���3��u-ɖ����r��H�,wve��yF�̢T[Fl�x3x������FC��Y#RnBt���:�*��\Xf�[�����Ƣ{;S�+��8�����l�	�gV�[��l܂+�nc�}�ߝlh��',��%��|Pրդe�E���Z�����gZ�q�s[�kr��/���F��wt!�g�In �=@�L��;_L�3��<!{T-kV��h2�zEs��m�������_� ����7M��<Z�;	��ɂE��yq��D������d���~��j5�yM^�]�����L6F�y��f)L4�i�
<�K���/��Q�ƄtlƢz$-�3�����8�,�9�q� ��-������Ԏ�҅7ݦ�c�	.���7s�8�ǘ��E��������$j�b2M�� ��a^�j9���Z͛����?�\U�z��7��Q��o�=�+eYr׏�����d~:yY�"�el8ӳK�'`����=�_,�Q�j�*��e���������o�W�q���V��e�V��8JɞI�f0�g���[uR��R�n#g�_�g{2�ds|@#���`o��f 4���A&]w-`�M�-ܮ�裥+&/��-�����\�ldwB���
r�3>��6?>��n��G���Qч�}W[d:�m�U�x�m�y�8z��K�q��@���x܆ ����`~�?��$�n�Άo���l�-�X7�u�|�p?5dx�`~�#=[�gz2&it{=�S�����mɆ'a���wHk��I�+��- �c%@W75�Z=��,s�O-���@4�O1>ɴG����^���_Ĥ�v�[cc�z���-�i�|0�%��a�y��k�.��P3�Êt|϶c�֡������~�� ���Z�e3Y.�Go�1����7y��
����N�G�mxx,�Θ0������+�S;8�*ć2���� ̴��n��]T�
ۂ�a���/���|S�����W��r�=���?��a_�d��1�����s{�v~[�#`��u>f�^���D%Ŏ��3�$�m�~ t��k����Q���A\K7�YZ�K$�u�ЬΪ�د���Ղ�jټN��w�W�łg�����4M`�E޶̾��4�YP@[4�����F�(���TO�@�s��
�{J�-���_�a�흵�5��2L�Ԗީ} G�I�M��ŝ0��qg���-0g�6�G�s��z����Ɏ[(�yǀ=��w��4#x�T�������k8�[nI��L��� ���a�F�њ�贚&_�]׹bQ����5��k1Fτϲ�Eڶ�+oX��� R�-���?������"�N~aG���=�K�g�M(gUdd���d7��X��S���`#?r�c�6�'�iI��Ъ�v���)�j��!�k��U�\�7�8��b���A�Tu.��3��+���(�g���e-:R%A4�߫��&.�P�g�l�|�D�]���f����9���V�|k*g�A�~�I��� ��R�r�OgO��hx��{�B0v[YT�Mh(�� �p�?��r;:��=ªm/�~�h�>`�t�?��0!��t��qT�gn^� �V�%ٰ|#`�A�âV��5���Rv�y,�S�q6\�; ��"�w�$�Z-��bE ��دx��lQ�廐 b>Ti(?vۿ�@��B 8N��c�}�d��k��zY��(�ZN�R�x$�ͦN���Y.�=ۺmhɃr�e��.��V��^��n�M�K;۳�@ +���;�F�	.2����a-��fH��BϦ__���l84��˒��I���[���/du>C=���;��%0pu�Ehe��r<�PM��n�r��`���Epgz��.���/��C�T{t�WB�;���K����f{6hY�WLp܏��<9#�p}5�l�57��8�(���%Q�I?E}ʻ���ݗ����}�ޱ��b�m�.�����q7���N�o1l�ښU���n�;��,q�FRG�.�����̋�ˏ����瑄 y�@��NT�2gS�b1Q`���m[�l�����+��'8� ,Ҽ�[֭&)�C�W����=��e~���E��dձ��ڈ�m�����`b=���6�{Y�=����Խ,�y�4(�]� �L���t6S{`
�V��v&�[9��ܝ&���px�U#m��! G7�`��E��D3z��;6f���a�}G�#�(d��۟����v%#jv�ͻ�r�U��C��ôX�1�q)������y�j��|��2�e��38F�aa��j˟8��=fz+�n{�*�W|�+�Y�v��w��ǂ;>��O�b�/ـ����1��W-1�@K#=�Ps�N�����������D�q�5��{�'n~o��7�
t���1R��!=5�ᑺ�ȷ��o�N��lB�p.��1��gr�����5�	7� �ۋM�6�=6�?w���o��l��X�?ٖ�]r\X�a�ZPi�;�+xXu&?��µ�׮��z�흜D�m��~U�졳���I!����Y�,M����&���Ҧ�0�y=��U�%�yW������~Dx��-�y���bS��7�M|ࠎJn <	�ko��6�a���1W����QPPc~�y)'8�>��	+Ί)B���s�MZ6f?+��wp�����;W�+�EP&�l�Im���51�@�[תbY`G�Ε���k����|� P6V=+�^�d�s��@wA�ޱc�h�� �� &�>ӎ���������tT)�b��M��p�m�Ջ0E��d4��:%�����د��՘<��6�+{y����~_��j��T�f���������"�CX\�Y[]p�����F��vf5�L����n�H�ǘ�q��vi��<�Т���>� �8�%�O6���#X�m�p�ep���*��    ��67�N~]�U�z�E�� ��?{��`��M8��	��[Ӄ5�π]yK�h]َ�>�-S�9zE ��+*x����'�N[�PR��x�����,���fY_n��D��h�&�R	ĩ>~�7գ���򬟸��ZtK��͜Y�\3h�&�`����x~�

�`���תm���ѪZh/�c}O��2&0�(y[xP����;$���v���A� �f2q:l�5z�l~PQ$��6KS���K��m�%��B*�N�oP^��[��~n�2��Mv�$e���'�+��x���d�5�L��ƿ&e�o8+e'����[�ҏ�̷R.�}6�*ۣ���������z�3V�
4��baw��Klb�M�-�`w�C̩0f����A/˕��Uت�
E����
��l˸(���+��L�`�����Ҥ�Q2+ir��=w�6�ۯ��!x����Kq����:X�㗦m9W��v��o��(T���e��at�~*�xTh�ꪟ�fT>%t�=/���߈�`L�$��+�up-6�_� O%Pp}�7XA�GN�P�T�%鹉 ;zy��܇�6�S���-~�Wu��6��.G1�����*��"ik�xv����g�-<�f��j"����ɳ��\�^ӎ@�o�ƶ.�&W��'H ���.�՚��q'�q���Mqb!`n�5;�nQ7��s�يh��3R�m�3Y�-��.�{���ni���ڶ(���J�0�[,;Ǯ��k1����jz�F��WϘ�J� �NX�"�c�� }�~����@��S|�S���Й�!�IU�xK,�g
��܆���ڞÂ2[���e@�+�{�+g�q��p�Z��e��%�bpm�v��&��Tg�.�R�߭S�#]!9Eu��
��t���G�q�6���ǥ���� ,{�2�2�4>�m(�@�,v{��ޮ!����akW��jM��`%5��C�X(�FcP-\ �ڤF��f����u7G�b� ��б��0���|>�|T0�B��$��E���u��=M�����h��|��sl�RBRg�MV:<
ߨ?UyWE� *�)'W����[�!��q�V�1q)du�\�/Vb�=�:�7YE�t�\�j�E<6h����k8�n��
��0cM����Q�7���_�vm�T���F�u��^=v]�sVg^�+�[�րX����������Vg�R�)`L���o�x�*��&���<qfȷ��I�<*��f����kp'��L�mXe�٧�0B\,+UZy|�;`���)�f$elO�fa�Z_��]o���+r�>4���h6�XJ�pf�X[8{�.���P滫Z̡)y��qn�3,���\�����ඒ"bt�~|�c<q�.����O�k����x��E;"ؠw�U�Jl` N��C��0#�	�s�x �++��R���Z�p���ue4�
��G4�4��o������2��c�I��

<�Ŵ8�
�q!J�B��(�Q�%^�KΝ���뿕X�R�V�2N*�]Ao���A3s��=�J�@˸nq���z��K���U�EE��?��~
S��i�:�lC��G�պz|-�Ms��S>�2d������ZT��5˖淮�4Ֆ�|���d���ܮ����E�z{�������Az
n��p�& �����:۴�o�m�Q��s��o�Hj"��K�_puG�pb�
f+_Ih3x��q��O�̅���Bۄ��Ly$[�B��csAa�P��s��$��U�VԣP��}�W�_G�{3�C�Q3�`q1� R5>��eע�]_�H2�m��@�4v���ҸZԳ�/�W��V����j��Y���}p��Y��� ����G�:_6�ǱO��l&����;����?h�>.�l�Ei=�k��p�����K�J�b򨧔�(8��5��zǱҎ�m*�X�� �򂹼��c9^�[w}��q�y]���	�6Tj��qד(�P���y�{&�����3}�'A�5 7��Qv���� �֝�
��-��6��"�>��0�˳�<�W�Uu�:1�	�}S?8�2_��b�d��u�x#���Ggqa,��.���[{f�.�d�c)hBz �1����:��Q�6�rn�����#I�S{Ov|���j�Zt����h{#�+v��,al�0�Vn�2M�T!ӂ�Ѩ�~b�j�n��k��r�F���/G9Be=���
�Px�O��\T�}Z<hC�AuA�I;E��ہ�`e5t�v Qv�bu�݌Ep0�Nb���yq��c1�E��dEi�VQ�sU��
����O�ő`-1uV����Xؿk��Pa�?A,W7���~�L!�Q����*Y��>�:�ȹ=�]���� �l
�Cˏ��}�F܌U�� KF�������� R�}�Q*�n1�a�;"�eP5v����c��P�q�<;��,
6,Sܹ��3��9ms��-�FŊ��	^D�8�5�c�C7!��
.{���&�ST-�kW��i]�'���h��|�-<���[�_�z֘&���l;~�@�Ee�Z��ǋ��P�V����e�{ߺ��+`�0c��ޖ�+����ϡ(T6���x��~W.{�����ڑ�z���ش���U������a tc�6l�~M�P�#kZ�_�T��Bg�c�m
���d�SńK�^�����,�GU�r��M��&x�@/�%��z��^�$�g�����7|�3DB��H�=�J�zwR��(�^�m�<�*�0��pE�7��8���������i�G��p��d`�0�o^~Y�p�sٵ�Ҩ�%�њc��y��ѭ^��U/�	U[v�j�Ou\4�|6K���Z��y�V�}���ܸ��X$V%�;
OmX�j��ۗR}���5�`x�6mi��#�<;?����S�+j�/�����cro��+C9�d+�N�f-F�p"�a�K�\?v���.Y-�n�=������٧o�I��7�*^�m���B�8n������uW�}q�@r�F=�;h²����q�k<���)�c�`V�X�t�jVױ�G���&����[�1��f?�ݱ�;X�?`u��Tc���l\�{���C!����de��-���jûjk�@@�v ��Dо:؊�j	�2"��="-5M�._�|F��7�%����;[7T���R�Ì�ԛ�i�4X���fQmw),�}��u�Xw� ������Єf�����
��ӭ����N��5�(T9q������Ѫ�+��z^�)�d&�X��Y8�����[s�YE����[V�ߏ]lSS~�����r
Gq|J���=�q�h�e{&qԎ��'�ͱ���U��KX��x�4tN�k�q�m�QrN�V
O�ဂ��'V챏��`����c�ՁqT���F����U��'K	��s����w"�gP�F���8i�b��;'?%�m.�p�&��oR������d�Pxٌm��YD�*��ʊ�J�nq�-~�c_�lKZ�J*��
��5�w�������RXƱ�Ɨ��̖�O]����q�<�iQk^�FtU��֞��crB�&^~ۍ�lI��3�5k��a#�h~w��FH�yV^P��v[��g̯�B�D�/P��������S��z��a�U&��p���Q�F٭�¢a4�7�d|T�n�9N��U궲Pd�dWp�X|�Y��M�\
ת�>����Ⱥ�W�;]��H7�QU��l�R�t��*V���@C��L�7ұ���*f�*��i�s��N>��$ť��(�hK��B2��)���Ԟ���eY������[p���ȕd�5�o����(8�kcN��\��F�)�*�w��k��� ;h�J�X�e�î������:�f� �*R�����^M�E� )��RS��sk���c�]�vW�{�S���֘2If��5��/��7f+m��H����0�q;6[_�̔�J��e崯A ��7�{N�A4�'�[��KG?�&�I�d���(��os�ah(�2,@��i��q(��V�z���ULl<���o��[h��?\:Y�����ྸ�+ӃST�a    <j�6~�|bAu@�&@Wxl"P�4ۀ�Q�:=9) z�';��&;���Y�Z�3z��X��L���.^��=��i,(+J�����Hm��q�Z�+�hs��w���j�\bXzp�
���+ej�/'\-C����4��Z���6��n�	����9�
��ov����1�a7�B=��#�����v�t\�zC�W��9�#�+l��2�2�X�+���5	�q�:/�͗�fGl�7��߮���U�����{���|0s���*5xX����f��t��_�7�³r��Kl!�

���0�����q(#��q�/�0|m'� /.��CÃ'����Z_kړU
��=�0�gU+�1�褩Ĝʭ��0M�z�q�&��e��{`Ւf���Yr0��n6P�׮�L�@^���ˎ�R�����^|f��jK�F+�oV���m�w��Q9�9���A{� ��c0o��ڞ��
�_�*J4�K�<�C�aK>�ުβ�c9B`g'L����v���u���N���ۣQS�8ݧ�����9~��\� a3��Q?���("�tؖY�Ʌ^N����q�ܭ�lľÁ�
R�+�^��8��,Rh�ͷ�u�,۸��fqtŞ�2 qVr
���J+��wX���>�z�S��і�T�<oI-�a��B&�>g4[%o�����Ny�)�d��/P�� �
U�c���#,TR��ƾ�� ��u+�4�H�q� Z�Y#�?[1ε�_O��e��I�wcg��$GӜZ�`.C>"������Y?��ew§H���S<�8��`��f����Q�pZ��d��DE�Մr������-�Q&��h�c�����6,�1�vt$��b�?�˶��U�.����>{E��4����0�j�� ����^���l-�Z�6@��q��!�(�����:R�	�Y��c���������y=�E����cˀ5,��oA&zq���Y��t(F�<�sd��T������ 0l�B������.c "���k���.gZF�*�+�d۷���*8����{� Jm�q8�زe3A�#'L�e�|*�-�`����h�[���@`6ĂN��Ģ�g~tW���T�Y���X�:��P_*��@��|jK���J�sW���.T��e���j!�;�f������.!ٴ���	�&�_��M5Z�z �uXO`!	�NI	�x��ުW� ��¸����R��.[9��b=o���<6[���*����X���b p�˭�����#�@���8 ����b�u�2c8�Oy(s���0�k�;��A�V�
n��inǇ:<��WF�a\6M=�KSۨ(�-�U膫��2�����q5��r�k�xT_�,|���S�Hò���������O�:L�9 V�����z�}��[��3فص����ڝt��@�7Y��Ze��Hޚ�W�[�a9`$�p�4��O�����es�w�
ޯ��1z�=x��͑N��j��nY[��{���>���b����lb9�I���-�R��n9p��	,ųw �1�1`�w�=|�g��#\�m���'��yeDۓ��R0+����a�E�����̍U��C����a{-E5j7&��lw��C�O,.��cX�68y�Ԋ���5�*�v\'~(���l}���Xu��E��k�4��y��`n��9U�����$:�x��&�K����`��O#pe*������?�ISU���8�~�s�*�ɡ���-������3��*S�|���T��H��̥O%g����O��(���.y�TS�j̰z�z�m���οN}5%ܹ�)���l���Y��hK�Ul���|�O� �K�2�N6�A`�d��}#�a���d�8����~gz[[tŏ�E���޹s��f�6��]}+�Z�'�3�j�\���,(4�;)�l�T����(˄�9Ӡbw��[U�m�������=��-��3�����tl���dS��*��j��K6���g���Naa��z";�B	s�W���|�%�Q��K���܊�ݜ�m�zUS��@9߳ai����b�̇t,\�2���ֱ�r��	v�����E{���ٶb��77�\�r4^�/	���
�z�0t�����	XW��`���3���;l�^C�IQ\�<	�$���6�Qni����	�2�j��w��������SU��u������rVj�e���-"t��j�p�<�w�^����A���H!��s���-}oh��jkLw8�OF�1��5��c��:-�&=C��e2��Z�oK�M�mL~T�u�����՟����?r�9w�1��v���6}-Wzd����=X�=�3�x[U��Gf9��<�m��i�M�|h��MN�X�նX�$X�:dY�#ܳ'�>0�=-�zA�1�&|k�IU뿪�P��3�h����@'lں	g{���p�
��G�\�y#��-"QA��H㝹���"��ÁK�E��SIBN	
1Wd�)��i��I��u��1b`�D5-3.V��r��)�������E�E
��p��o��6哝H��A���*'X7�;��"bqE��]	���1����'�W�+9 �}�)�<8���=��}��@�y���:Z�c���p0�t�m<�d�>\���f�q����6�< ��� .|�)����N��Y�έ4�se{����߾�E��s~��(�����`�%���<�`ʻ�@�[���ιT'�pցdw�^
�E$`�=z�mUӅJ�`{YECzT�|DU��ˊg�Ǫ�qt��#����h�;��k])�q��,z� e���� �;-�>�%�mf���F�5����3�}�]� 8��a��s�q3��o������z1�K����߻�#��j�jw��v�UuBh�Y��n�}4�j���8a�_�o�>γ:�u]�c�D��$[�=g��a��T�b�ݷ���~Ly5��@Q�]&|ں���<Fȉ0�f�xv�� 
���Q��1x��R/�j�|�T;f�:� ���������YT�	��1�0�RH=���F�*�ƹK ���������������'ځ Xز����z��s�3e�@>�1����Y�٫���W4-��� ��Y~��)��A��G2�W�<����y��k`X�,��W���X��[~���A��J��Nۦm���*�8-n�����i������`u�)8�9p*{�]��J��hC�Ʒ�v�Tk�ԗ^��u+�����-92�jkT����WC��!]���p��1�r��+ѳCvly��}*���3��Y㧼j'�u�Wav��R�NE�q����K�Z�J����J:n��L^ޙb6^Z�ٜ&����˰9�4�u��
�	�g��F�8��S�\R��OB�;����!�����N`J�0���dM�)�Eʎ�~��h��>�5괱�7-�O�/T�S��� <Lgc#���a�H�f�/0$����Pus8E�p�YR+�VqLԱcܻk�ܼ�M��1T}�LW�"Sv��l3pԘ��7�;�ze̲(	⨔�������g
��!��M +м$}_��Kp"~U�\c~y7'�.o����/���ip��-xn�9e_x֪^*�`^����7�G{���1����ˏ��2��?G��/fp�I��`�M1:�+�m��EY��`��� �r���}3,zT��Z��i�
�1~�Hu�w�ԫ
d��`B�ղ�R���U1h ��tav쳩�[���������/.@5u����6�I�uwǁ<����o�������WG,Ѿ����a�c7Z��?)k� |��3��,�/�k�F|�v/���� �37���U^E�f"�hf�8+X�9 M�OŢE��׫��N`��������c&H�V�&V�uZ��>���)�*��^Ȇ��p�I5��g֑ۑ���	���f��U wl��Y��-O7Y�p��<F����w��Z�J�(����A���ۮ��X�;��sX�ۍv�ݝ�3�U�k] �1��:��`���@    Y?�K�sv��4;����jc�g�R�!_Æ*q|�YfMm��ǜ�l�`W��I��/�.�6��}�1}�j�����JJ����k��l������!�c厭������`����U=��%LW��6�h݂�.�^o5�yj���0�`�i���%Tg�9�ԡ|߲j>P�8?9ߟM;�Q��Kw/�����`?Ԕ{����*���x�MxC[vL���?���Cٲ~E�ML��˲f�U&������nޚ���~�/�yH9�ᄜ_6Κ�)�w�K�H�_�ȣ�݈�W|��Ӫ�/���d%�:��@�Xf�|z�\@�y@m-�g��V�*wl�H��YT|g�o��&���2�	c�`;�e}��v|
���\�a]?�x�a[p�����o��scBM����r��a�PP8ƍ�j���[~�1�ﵶ��|�E_�#�U��헳�i(뀣T��8�E��p3R�)_1t��1TH�-ފ�rU�ة;�k[���:5�yk19ۨ^�8�R5 �V��n˰�r�r dT����M������F�f�qye2�s���X,�K�Ln�����|y/�F3�WԨ�-Y�fͮ58_*Z�� �f;�d�U�(mKpf��� [l�1X��$?�?U$v�o�������u�Dv��*���z����]��$���`�&l�q�N�y��q*z�i���`�Տ�+�5rv��o�۹W�J⸮�t�,�v�~<<`��18w�-R7tl�\vH��T1r8dvA �hI*c`ܜ�%u�Xˈ�~��y̜�f�cG���l��q��T��Vb�,���1������n���3��|�7gTM�K+��O���ф+^���N�L���l�K��-[����7]+]�W����9n��	�H���S3��C���Iy���{�����׈�q�Ux|��Ĕ0^��8���=�㾨��n*�5:�j��XLb��e`B焥l;���K�1>�ͽ}���0�bye}?��h%aNT�΂��f�*���*���B�w���p����R"K�q�ԍ\b���g^���W���o˖$ۗ�M�~�x��LXHe!��8��
��?�V!��Ӥ�ӐL����*��I��>>��Ӟj��>9�W�:�3�][�mD9�ن\@L��h֫8���عِ��0j��9��e��Yg�؏����uw%Z�Cs���+��4gQf�-x��f����Wv����!$���-Z�y��B9B�Ak�9�9�C��>9s���(�o�xފc~-R��`]u�\�C�x&K�A9��Đ�%�>���H�"U?M�*�e�l���f���/=HDy�]�*����[f�TןV�A|�
�k)`�-�\-w`�V��IAG�X���T*�X�kX�� ?��Ã{H=�f/�sK9�T�o�� ���cW�.�d�'����� �o�*0(�ev";;��8G�����Z��)a+���k��@V+H�z�Y
�:85u��{���{@F����U����r�*W��W�F�����9\#*�m�OŎ۸=ƪ��
=�T��{g�'
A�@��X�;��]-���𫉠��>��<��N�'ՎǓ�s'�}��)}��w� ���l|�U2��G��fF����X��8�v��y������s���8����C�|�ױ�����l��Pa%y*򲬋硧S��	~�`�p����Jox�
S?�w����/g��)�ȕ-ɐT6��m�G����U��ʰTxl3w�7���E���Y�̱5��l,
{�B�l�g�n��ގݬ<D}�`2ؗU���X��>�W�q���r4U>���qa��]W���O���O�LT�ɂ���В�mS��N��n�t�"Fб��\��N���
��s ��up�h�f{�L�*~�{�SF�< &F�ּ�~����Y����_y%uH�`�@m��N�Uj��:�K��F����R1���.=�z�����E�1
�{��ǩ����V��ǋ��cT� �B���*�i2�(�������Ov*���� �����;���;����5�&0�g��BL���}�ϙ����ƋŔ�X�/�pnM�������<�a�2�N���$��{?嗬ʫ��kn�a@2c`9��Ut�mՊ�8O7�3�\��d�;�q)�)U��K6Z��K�j8L��Js~��p�ZW�׾�d����Fa��4��~T9���6��	*)��x�����Nvp��W�R���;|�RXƯ�MqSO�k�J����[��?:ɿ�%�w���]Y��+s�U��%n���W3��?|�$x^e���V�9��ưǤ8]���Gi�/p0�s1�g�xuk`�t��Iź5c����	�VB������oᗲ/Lk���s�o��ņ^����q�n�����l��Ջf6xh�$t�9����� ����5q�D˂�U�-��cB�_�r�j8�N.��n���N������b�Ե�h���.B�l���Ak
0�;�Ft-�v嚾���M�6�\%E���bl5�>��fⲇ������j���j����/%�xNs��[�9$M�Ԥ��m��2�$�q��r,V�:��'���M��<FK�^��F��q�jw~�� �i��m��k�sg-+y-v�`�"��RP�h9F��fȱ�>�xe<A��9<w4xB?|�i����W����Ɏ=˷�6Z+��ɳE�X�t 0�؀݂��_��Z�k7���OrK����xT�=��)��lV�m)H��S�9��_4p@��Sٻ;
S���m�M�U���Wd�
@X�	��T�S��� +�,�y2Pa�j)��O���;�����^m>İdY�c!��,��wZP�����[���Y�k}�4oo)oeoL��X��WN�>�,I���*�p�~��qF���}థ�����l	�T��L�hȏ�+T��)�R[�im�)n�1��迺ظ���g��!9�Quz{w�#6-��y9(�����HG�YM6,�~q�Ra�TR���f�; ��kڦ�\�oՒ>����O��%����l��k7����N�]�]�oʠ�f|���K�om���w.5��{�Z���h�n8B�����P��Mb��#ap�g��*���dlq��w��`��9;�m��G�n�ު���\
e�;�sZ���ן1"V2`MrWN�B������Y�����6`xֶe>֑ss����<�o�s$�C$���,{:-�;Z�/"8�s�B�l�Z�w�!��rCD1ێ���:� Tn��x�qH	���wx~�*���9b÷sz�zvS=�x��{�c�s��;��11�e�֝籞�����X�p��@��kk瞪��l�CU�c1�����mk�u_)�&D���+9 �9��(4�yײ�ˎn��J�Y�U��Y����
~�wn��|Ѻ����̷���G�s; }��7���r��	�X���0绯9)$RCJݔh���ȼ�d�I4�r��rr_��L��y�&	޹;�L��c��zڟ�9ʻ`ŕ�������hI1{xM�����#�:%�����@YÓ?�;J�r�r��<��p�A���R%������W�(!�bΝ������ x���<%�2���4L��ket�\d潫��5��Iu�´)qr�� �ε�;�D.�=f�J�p�hŉ���Z�v_����V��`�}JQw9�s��sw�E�Wp6p�L�wÅ/�o�E~؜�~�����E�C&:)/��n��\�Aw.#���8R@�/?/d6�e�/��I|z�$�rv����IJ0��R�2������կ4�����-G�Rk���r'�pBu���W|5���1M�?���+�����*��E3��5=F���i]���e Kl��9��@Fo�cs�|"wM��)F�h��<Y�Y��.�G��kM�@z��n�.-H�<\:�?�奪ܵ�A�n��m~�9/dl���wNr��&��k[UI�<Ztc�j�LѸ�
ZmR>?���|X��    �}���ԅ��d@>yt�H�}��.���[�սAG���͢�-��(��`��5p��8#c���D�I|��;.,�f�R���MR��3�O�ِ��㖻��:��=e�Q��x�Ϡ��n~�Sa�><��fC3f��`o��mxNdū���w������tX��T̔��s�a���R���ؾ�w�����#דʞ��xw+���ׯ�>�T���=ooz��J�cg����{Q�N:�?
��v��1_J���L�_�����;���Cg����y���A�>��XəH1I��E'G,��\�,���3���`�l��(�Vl���0�M���갧q���|k�9{9�r���E����.ЖP!Gˁ�i�9/��}7��ͱǯq	h>�-�������e��NϻK}Ҹ���YR*ŇN4�hM�g�J�K�;�Zb%�JU�?�Р��j9�����.!?!gSZ�7�}��S�X_$�, ��� �_�3�I�ps��������O?sM{�#e���� pJ	BnB#������yԢ%q�b�]�D��V�>+�Y��~��@��(m�nm���򬚸W�a)��m���Z��l�i0��X`^�Og��$�Yr1�%�@Y3�H���Z�j�Z�޾�:��J�z�5���&�7Xz"#��b8��̏��9���I3�桍@R����!㪌�
��gx��;]~�̜�4��$�&\�L��D����K�%�X�G�y��X�Q����O+���`�|Yԧ��A��j�҅���-����>嶞k�~�$��#�=53X����I/��Vu;���*��p����zgy���r~��Ճ�t'kXF7�Z�F�-?f|��E�cA�?�R��Z�5����ο*��.\;��y_	�$�N���&a�����*�M�ͧ��~�F��C�C|��>�)��փ�1H=��)`{��b?��e�Gg&40���)ö c�B�w��]w^i������n�fM)0��%��ۚ�[KN4M�Q'�%Wپ�^�`;*!�礋��)���J�+Q�dD��DX$�a�u6�o�+�,��y++�ʓx�@`��d��7J!O�	H���P�H�X�D��r�Z�'�UH*�{�K�����)k����{����n�M}��󒁹�T����1���N�91�"�������c��;]]+5�������s~���~#�_7�S�UM�);1��ձ`s�
]�V^Q��z-��5a>�Bc`2Q�ͪ���f�CFL#��j)�����1q"�Gk_>���IJ���@^�;���9�x�����]����$��4�Rg�ϻ�r�R'�;��܄޶���L�8����hX~K��D��<�i�s,m*�Z�TUԆ@K�</��L|tE��(��i�ݾ9mGZ��i�Zh?���F:���ŵ�D��M�H��_��n���Q�z�4�P@{�=%���ܨ��`L�4Sh�̅JJ �m��8�cd-	�23���8T��.5ϛ��,�+��8R�y���ge���	D�Nۦ�\�,i��x�$7��,X�J�3O�xo�����0%�960sW���	��	Ӫ)i��x���U�5>7ۯ�_.RY���Y���B��J���hvM��5���s��-o�ǥ�@J�J�ʴf�Ɉ�Z7'��V&?:hS���9od�V}���{�4�%�rt��p�
��)�:��^z5�4]q�)j�8�
cK���HG��71�v@�J��f��^�E������L�/5�9%�)�ߡ-8���]d������ �V�����I�@=�������0������SI;ixI�f�^g*�|!�i'��L"�.�'i�!�.%ߗ����G�&���Y����l'N=1š��8���_����8K��L$"5�.=E����*��9�n��?
o��M'Np�&Z��Ӓ�$?jB��ɤ�1�ۛ����T9��O�"ܮKE��v_ �/%�\��gL�� ��:�[�Pa�X�$�d/U�b"�(�%�d��O/=m&��)L�����E�(L{	�~>�A�l�d��1�`�%"ʶozSb�'���\�r�Ao����(`�������'��?7�c;|���}�t>�����&����X�|��b����,��9�ۑ�Y�8)�i�'XB�)���)���t@Mf��o�w��@�ǧ&�j�k�S9���uN��)1Qn]�|�<��9_@��Gɂ#��D�<�S�[n.�ٮș���=��g�,wJQ�|ZʳuE��'Zҭϙbe�K| 2ֲ	M�M�K��%[pR�I7(���5ބ����h&˜�!��,D���o~�8Ƭ�I����^$��>�vT��gr�5D��h�b0"-�Q��ͺy�\*���/
2'�v�K���d@�{����R��s���u_6"�ײ�5�/oKO�K��N��Ԑ�/O�2�#JO��j��)��`�t=�5Cy��$�d+� �r���d-����!���ا����X_q	�p���_NF�_��0:E�F��:s&�}-�SG͠02�@��,Z�u�S=���%�+��"��K�џ�$��ъ^�(�vBOw�+R;K1�|�j�-+�ib)�QN�Mx��\N)������:Z����ݫ��9߅YA�4�(ɲVR�� �z��'Ɨ11(��ٜ�PJ��X23��5EgRX�I_���S�-fL����Ѕ`M���2����ۘ�K(9iE߳p�d&x���y�ۖ���=���B~����y-�%g���c��H�un6�{z�{"���J��H�Β���&3O�{ ����������+��Bõ��D�c�w;�S�^B�9���+ �_I6`�䴉UG�p��2 -g������$���㑠yk��ͫ1Byr5 ����#�����z�JA�)@U,�}�ٱ�&��%���`�9v-��L��ڊ��{xkŦ�,�W�Gꘙ��z��8�n�u���d;s�G����sNiʆ��̚��e��b�M��ο��G^ɷ	
bYj��H�]������G��%�w�K��aq�S���Y'�c=�'�Ԝ:�S/��Q9Gi��t����J�4��4��ӛp��	7���߹Ut����j����o�MF��2�>9oKځM�:���>�����o�t7ح{N����s"ӎ!���P������h&Q�/�8�&q��N�	h�o١�"8�o�!1�3�L��o�V��S�>��	���nOnvh��rS�Ch�K�7��R˳�K�����T#�Q�y�$K�M}#j���yp�O�6H��Ǐ�A\���u再�d������9].�9���D�#.>췸L��¤F}�QX+�n;�-��K�Խ��o���ӗ&]u�F�o��~tb8�.�����C��)m 4(B[KF:	�u�4L��sJ�q")�3 {ƃ�$O��J�EU{�<��ܶ��4��E+�b���v���O1�6%���Z�?����㓅�C�T;�ZCm}���\����ș��Ʒ�[M�0s(x���-*�B,�	�T�J� œۀɚ�iEqI忰�X�se!��Kr��<-
��h�zYOF+2)})B6����
�ԡI2�O|�Ѡ\rp���ۀ�^��w����νh��h��1���r'�@��K�}e+����{ʱ�j�#q��	X�䶩�����t���`
��-2�$ד�(��:\�v����"�b��iwQ=8��������.��Nj�W�*{ί�)�K�m�t��&�$6�t[STt[n$�1J��2�����N%{�!E��o�`���ز�e)M��_2R>څƁaSa���K�EcI��Qo0,P,.��Y�2�:R�&���)_�K��9�QNb�x6��f�j��UW��V��؀R�~�oNd�7ϓ�FM��ܺۣ���OD�8I>�$3aQ�/�qV���.���c�'�l���;O~����r7�w��b�������4%Y� ��d��$Yr?���#��l=gm���XJu���PSצ���껾4L6򉦶��2�]���Yԅԋ�GMi-}�<�\�u��K\���"z����;��#�3Ӵޞ$�Ǟ�q����2���'=�� s);%;B��N�    �XJ��2�eD�s7x]�ݣ��d�xE[�c�F?4���1ͧN���&�h|8�p�� $� \��l���K�HoO�L<�Ğ�+�N�iR�t���r'0��P-8������&����Zr��G��T	ܹ�(��	�h,��U1��Z�'zm��%�L~����τ����I4�p?+��j��)�ਗ਼����hB&���$�f޽�0@R�*�F���Zʱe���y�'c���b�GJ����&�rn	i�p'fë��ZиU3�5��߬iN���3M��jhZ�e�����^ S/�y&?;<�R��^6���d\jC�������)�7���4���5(�>o�C�,� 9[��䌳��91�c�n���9�����x�����s~����;�����]�OIiHQ̶�\ǩ �	��b<�"��
;���<�ע��+~ѿ�ҷQڨ3A��ɴ�N2%��Z,��9�m�{$ZN��_�qÉ�m]a�Ǖ�<7�٨����6_��9n��	���l�.?�g.�HS�L�h<��N��!��r�h�\�I\�^���c��y�T��:�������4y]��hۦ�+[�5���&/���"4�����Sj�CՒ��_\7����^����^��U���W�ۙk�=9�����扄ȘAr�u�t�g5�t�oc���J�1V#'����Bm?CK��'-d\�m�N� SA�K`�<��55�H��/����n�S�jd�I��׹��怕`�[�}�����v�+y�w)Q�������
a7���_���,�,?H�ۀ��.�jT�������9 N�+}�|��w�����J�� ߙ���R�mV���3���F���{~����_~�C@l�#'O|VE��-l@�%7�\�S%�|���B�%{x�V�Sj��9Y���~����;�b;M�<4�C�t�ҁ��d�i�4{�9T�lS:�\׉�&�<����[�3�{�z�~RA�CIh�B�8���w��x�_|{���j0fl,����H5K��;s@�2~��D�TV�ʙ�/��{߯�t�S��Lˆ(�!��of5��;�U������H��v8���Y62v��Ο'e�=6�n\U7����{�返 �je�k?�\��� �t�@��=��r-���
1�\�7R���$H-�?�����zgl#���Kf��X*np%�S� h�M��RrG���ƫ)�V���́��n}��H��.��Fr�����@��ϥ�Ě+g�p.T��R��˯~�H!��5
�?��J%��t�ļ�i{�]�$�o�-��ʿ�cYr%,m~���@'e���^�+�̗u |���w�q=d����,0��CN�t��'@@]g�7Sۮ���~���-[1�/�������4j';��yS4����骍:|G�义�Ly]�P�7�'Wp�DЯ<!�6�
��1�Sa��OY��F���S���}�@�z	�\Hϖ
nN.N�cjHW����ZI�a�#��J��R�o��$�q��;��˸Z��j�}�	��;����i�?��#�=���x���c���%uf_ұ�����CBmy���+�?��	�j�������!�tgh5�n��<����`�up�4IptS�uaMlcO�0���F��&�e�i^jv�MM{����|,&A$Ҷ]�;�?�p�2�&s=ݽ�0@�.p��q�I?��@���ձ�2uOza11_TmFr`��M�������L���`���m�Gj_��ݔ�|�t]&�_�!n2�Q�b�_k��ʱ:x�4V%�Q"Kݒ@�)���擘�sO��_�5��۞�FVߟ������W�V���B_�)[ڧ�}vG�/�c��'\$J�8��n�������L�x�@��C[���{��9+����m����cKV�����Ǳ�8Z��"�����%��|m6L��prG�*(y��N$5r�M�R��:ɥq�X��ǃ�F~[���HX2HZ:�s*��ݭ�#B	ߣM�Fnf��6���S�.�Z���HA�f�pj���Z�E�X��a�{'��L�h�&�����y{aj�!.g�:N⫤�V�/�����g��dw�~�&��0����pǿ�1Ť�hD���ѥ��wdB�����6.�4׏�����0]��nd��[�c��и��룹s�8�C[��\f}�+$<֦�d�EK��e2 ӹ��R.��LY���r�\�N��bsKK��R��Y���������@l� +�k��O*������K�_�G����t��bi�Ƶo�Ɵ���kN�Jx����H�/�=a��vaG���E٨��-�3d�gda��.����:Ic-�'��6Pz����|�rx�<�V#&�*1�[I�oKTz'ؚn/ ���$JtO�X^	�4AeWT_�!�ge�q�0V�|J�t-_z��*�&س���V�j�nM�w:��|JJ�X���MS��`�_�
`�?�H��`��9x�s��zN@H�J.%��_��]~t
�&c��:p藶��eM�a
��?��6�ǽ���8��ڟx�E��2Ф̕F~Y꘨w�˞.�~o�Y�l�>�����=1���Q3�f����!C�����zҔ������E���P�U{�f.7!�&���w�~ؠ�#��j���I<X�c�_K�(���NY�}o96,1�ǒ�à����(�jNc��w�jn4��$�KJ pGrb��H�4=�Y[��X:�#��Pn�n���l�@��ѱT��tv��9�,5�j��g�l�^fޜ��X��o��d�TJ�7����~�D�'�!% S'��ϝ���gNoY#�P�ϊ@A �b��Mn�bΕ�85|j_��+�jb���RzIY��&;�</
@c5��U�� �t� ��{_ۜ���7=!�-����v����""�Z.Or�*���o2�\k��-a�{B�TOF1ȥ�SMfyJ"u�P��S@���P��p����e��l��mO�,y:2��\��F,�6_���!3����e=1H]�b����µW=t��M�H��>!G�\�]c�r�¢^i���?��f���2���y�wJܨ�'N����b� <:��ר�t"��lF��T.#d^���Sx�t�	i A�S(.r'H�66�BUb�a×O0��K����I��n��[ ��&r9�R)���jK�\�DJ��297�_�z8e �՜����O��׼$O�(R�`�͙����=���y0��u-�X:������e[�Z^bǦ_IM6�TxSf�D	�C_4��.(��Zp)`X~���}�,'F筷��dO�8�c:�R|o�/5�d��^l,t?���T�RW:1s�����|�$O��{�2�E��nEgJ�Lv�R���,4F1_�[-ӴL7bq��T�f4�=�}�F0��y��?}�����ȧ���Mfs���Nc�^U]LT�?�ש�7�Z;��Q��Fl�j�I�+s��I6�Hv��㨸]�f��e?�Xy��G�|p�9	�Ǚ���҈$5_S"�G���K�>�mK��sS�6��Oro��^����"�%���'�nq���ݿq�.�"ˌe�=�x�Z#���~�r�>*���v��$���),���c���8؈��bd��kR�$���=Ml�`������>�*iܙS�GW'��)��L�{��f~7�*m$����<2?�)ѓ��q; ׶�<��/_є�����Es-gh?�IMݶ�悱����+�<	4P�d�[���`�
��Ӎ#�=/կ�������������i
��-��u��9ڻ��Ф���C�H	^ÿ����,~�vMV�}R�8X��$0�W��)xL�g��>]�z���9�W�󱰜�K��+���@h����l�hy+�é2��x������(�%x��ލ�G\�kM�s���I�+m�;*C�5mnzZ3�$��&�'��4e�������ܛ`_g[����Pzx לC�j�b��
!p��J�����Gd�n]'�M�����3y����H,�Y��X��|�q���C<�娍L*e�|>чM6:?�~�V�y%��ڻ���jwȯ_m����ID��P���iM��W    ��8a��X�Q2y�M���|��s짃h����[Mu=�%�(5_�})FF����L��T�����ɒ��.�~`�z���,h+���@�~k
�����Z�ߚ�Ͽ��_i���y��ˀq�������!R{�Vʃ�o�:�?�p#�!U�?&�y���13���+����Qǎ ����B�8Y�9�qO�})���{�r�n�WuR(�4Ύo9I��݁���j�N�&/��x1�<�����.�p{�nt�e��������X�#Ό gܵ��4�y~��0A�I�!�e���S�K�ߕj�i_�T��g3�O�ڗu�F��v���C㨝:ɭ���$_�U�Ml���2_��Q����c��"��0>��K`ߏ��r�I[��C-ܹI���n����~��]
��c�]�=̔�+��s���yA�B�T���ց�9���b"�o�k��lM�b�D���4cd�V��cZ7%?WI~��sU�MIR��5��h�Q7���O����#�Փ��z�j��1��������-�KS
P������D�{��X7��o��L��/��ˇ��pׇ�b�����-���k4��o���n�/?���|�X��	���y���Le{��ۿV�X��o�ս�3Ly�`��6;I�8��黡��.���[R��0�S<X�)$�򊞶��%2O��ō6|�.g�`����_�T���S��=\����#����z*�Ě3����)���#|�{�sH��󃐼�<׃&D��2�Lͼ ��7n����w����~*�I<���|�ޔ���8��<�j�.{����L��0�G9蝣d�Td��FR��f��l�'��ic�������R�1��ޘÞ�`T�/�����f���ٷ#���p=���(��"���i�]�9�	���zV�������h�Ւ��SrK��F�WxkO���z<���O�$�w���/�D�A�����oۇλ�p�%����N�%W�S�`g�`�����!*���m"B*�����v�d�+��6�3�M��� ��W�߳x�	���m������P4&c�2����1�Kj�x�_�o�J�;=��8�RQ�`F���p�יџ�T�����y������3���&y�:����Ѐ(�$��/��e ҩ���9���/hwJ�ۮ���Kg� E�D:U"���i^����Z۵2R�R��G�09��S~���55���$k�@�]���	�17њ��	��Mob��������xj��Ԝ�~7�M�@� B)>�b%��m+��=|����;π|ƛ@�� 2��[(o�{���ï��,L��1#[��Gp�����ߥc��"=���#�F�����Xsи��r뗫/�Ln�����
�}	S,IF|�`�kz�^�����y��.�WY{ߏ�$���1n3N`��R�,sT�@���)�i���tv���^��@�ye� �7kʸ�%����:2����jƸۖD�����kb��C�n~�4�ﰭO����4��]i��%X�ڙ��NR�h���g��`� 7��I�����	�m+x���m������E�e9�	�}{�LUJ�2d[~�5D�s�6�?�T��'�f�+w�g��~�Q@Oԟݽ���Z����G�su!ڑ�'9��dO��r��B��	���،_�q	�>�_;��;� "'�0�x^UGO?�sV`�����,�p�VJ�t��Y�}F���]>�o��
'���+��Mc���6m}���^�`"����	ܷGEav+y|_�	�����*	���÷����2����-?"|U*_'��9"��ga�6}����//C`�t�`���R�����.Ld����t���{����S�g�%}�Ɨ��?�ڛV������:�	�� Kim�5�1�I�!&@=��:��lrK�|O�cE����$��}��}�}x%hS��n�á�"$A$�q�{w�rfԮ��3�G�c�x�'IGLL<�i���:�9��wz@�@��gï�V��3�S۞��8p"�IZ�鑥��R��z[O/��\��n�Y*�E�*���a߀���1cC-D\J����W��
~���[���s��h�Y-a�恜���^^�uzW\�c��^8l*ә_%L.��'S��0�[L�J�5�B:��ٻ���Z��ևz�T]���uei�����X�f�]�[�q'�\��Y�Qi��t�E)�� �������B %��-��������Lw��4�IU�60-�a��峔>hClJ�����$��@���Ȼ���`fL�I�2"�U)���Q^S�n'���h��K鍥��,{Ѽ`�S8�g9w��\ͩ�[)��E=��M��E/ѩ�t,m�h5"�V�+YjԂ����5gۖ��=:ҹdމ�(�Y��v����k0�����2�\��Dp��8V��k��������}��ba�k{В?�a��~z���
V�ڟ��0(<5�������d ;q�t��j������G���1�IߒØ�e�P�6��[�e�",^�ȩ�u�����W��*R��d�9=���f�m�f�C<w�����ʭ67����Μ��X�H&��Iy?s˽�$��E�?#%��qߕ�6�+a�4���7-H.><��L
��Y�����pQ��Ez���B7U���J�$C2�R4n�h���8���H'���l��S���{K���YM�%<Tb���;��[W!�_:���!�N93�s?���B���}��z*�h�5�i9'Nx�\϶L�ΥJM��g_S��떼���iru�\��k��̈́��~n��fHz|�$�җ7��S�-q!�(����7*L���έpH�=tS5^��y%��q��\�>�����JȎ'i�j�Q9�x�Jo���0|���
�RM=O�/Q�r�U�<�ws��3�^s-6�ޓ��x���8p��a�3n��$N)%���[N���W��3�ᛨW	R]���a��ZԎ3Y������Ͽ�h��\J��q��J���qYF&�%iOg��aՙf,@)|O<��d+�5؂[��}�)���yM��?�%E˜� m���2�O��V"E	M�#� g̦9���,��ؑ��8�Qz+�[J���<�|�fU�[�Z���[*��S(7d˜�ͬ2UK	!��7,�g��S�Zj��
�ק^@���^1gQ/b��A��3�6?[7b���Fs����	��� 1�f��"+�
D�8K���GL[I�MB�w�f��F��#��W����A�|��c���9"o9��T���4�*����ӾHӉT����N��j��^��R�^�B�b���]ʭ|Dѓ �:��x�q��Os���Rx����0e�{;�sj$����!/�S�S����!�t�}*�V�ԣk������K,�`{��}�z��o�}�K�˞�9#�2�˕�0r2~ߚ:�h󔪢/¸7�* C����R����^�:;)%w�ٷ4G�QIf=�gbU�����w�\9��ZW��F�̎��+e��ky��p���I�́�Z���$_w�):Q���`�sx3��R�K>�;Iy�|�|3�G�tG���������L�z+]E
(���	��JD$��U?������6J� s�۠K��	�\ť,�HZ����A�N��DW͹ae;�˰lZ/�6+�s�f�����q����m��\7��}͇瑗�=S��?��ˢ�&���!UD�(�~%}
���(OϺ�[��I��c��&'_@ҙO ��/}��߼��o�C��,��Vޅ�DO9w�Us�R��Q�Qz�����B��ӎ���K%��0��Gp?�6�s�e�ϓ�ub{sx&.��D�8$�9�)��<�B�o���e�s�l��^�����KH+��8�6H<ĵMaJ�t)��5�P���Q�I�n�Poǻ'D�칳��=���������5q ���Ep'6-~���\n0��~�l��pC�mi���!�S�׼��uv��
�|c��6��<��܀0y���eĲ�V��    �	eL�+v�X�G�z;&O���[�f��9��i2H*�
���D�1x�{�=}�(Q{bB! "���jR�I�y����c��j!�����K6C����]�,��Ļ�Ȏ���f,y=����9�X��9(�|�WPR]Vz�Q�L��/N]�jY2-�{����Ȉ���S�� 7M�[�-��%��v�����_��S��C��?��a?A���&v�I�M�+�j3�F"8R���GTr�HB��d�=�7���@�����Xm:S�_��'��rJcZ�7rj��g|Z��C�79�׹�-j�	��~싁�	�{S-��ѩ���_B"�7�N��0t�u�Î$��$M���K�)	mϗi+g��,�
w��~��Ǿ�(�En�d/��'�����M����ّOջuD����' 5z�	��PZO�����}ÓosP�l�{?$1����7֚I��%��s�(O嗪�ǆ�xL���D�]�%�>i��a��D��U�/}N�n��Px:�jߡFJ��5K�J��a'ە�Y�d������o��?�p���Ԅ���Z�fmp�+F]S���Bl/�g l�|W�<����a�z���W�Wݰȵ��i<��w)=I$��eT���_a�Hl��2�JJ�i���|�Q0��=�<��3�Ji��㠻9)pPt��˘>�:��9��n$�~���C��i��]�x�k��S���[�8�nX�!����&xie� �z�K�ϖM�U큚�y��u��[SW�^�M�om�R^h_���%ik�{.�����G���}�r�u�i�TڳA��^��Ĕw/��D��S)�#!
�;���<��;{6���~ ���[�~��~yidTr��ȱ����4���w�ʃ9��4.אP�ш�rۮ���[�ء!�V��T��w�ӄ����Ԗ�F��ZL/j���y�7p�)�q��w��6CK�����Q<[mqr�R�\S�
��*�ͧJ���95��1_��e@����mۥ�,w�<�G�)���n��G�\�QC��h��>/�R��K̏�Y��U��L���j�����r@�e�~2	c<���~�����-�O��ޔ��G��Jʘ>���uJ���K*#G�g��W��d�_.C.�E.|�`?��X�X�*�^H�����.Vj����L�p��W3�ɉ�o��l��W~O����b>z�=)���\fn�tg�<�}ԓ��t��Y8��*���c>�f�����$�D(P�.}���J�z���(��FF��u��#����o"(�����[�
C
mO.�&���LD,��e3�p�L�,��$ړіH�r'���kµ|�ӟY�'M���f�<#V��+Z�?�n�!�l��D�����}�Kx����цʱ�i.:�r	4c��4�
1�\��پ���*D�W�-���֮�N�X߃Z�{NL�`z��u�&��i��N��T�ɨ�/5_Z�[Rq'nM�ȯ3]'���<�����i���v,T���â��&��h�Z<�a%/&�����d�!RR�l�yN.��eڼ��5�p��iY��}�A���+o�h;�ح�e��$G�ծ~�|�^r.5��gMP�HjCḟ���y��Ꮄ	��#Y����kȼњ延������,w��n�@ob h�K>_[�އ}�FߓzZ-��W��O�g�=e��o�s�׺����%XVÃW@���l��;v�BV-�eKH�<��&%ǚa]�x��G�W��v."L���z��x��fH��:��w�\KG�j�$�cJl�����,�Ў�4i� �9���ǎ.m<�j�C��9u��G���l3_���C�U�§g�\��oKɑ�	 y-cóLޚ�:����2���}$��VqK#p��.U�Y���&���~�2y B
 ����#��V(v�<�Zj������v洩�O�P\��6���� �^o*J�^�L��H1�z�ױ0k�&�Ʒԟ���z����DK���P�|���o~�!xYG�H���0Ck�
9��}sJ��sYkӒj%�T��K�#-cv2N.h�A�u��鎴{O�cs�ҮT�S�l5FI]�r�X��z��4i���c��K?�X�`͉7���3gz�P�M�C|���-%�E� _(�$O%}������GrWA�s�F��~	m��L0��^ x�b�mEI��B�;�dJ�|�S$	+����gM'�I�N�U�-ϒ�*��~<�j.��t�9J	Qӕӱ�lg;���r���.��h�{Ώ�!]*���#'����i�U�c)=�L�����˛���x��wf�ӵ���^�E����T;b+��3����	:�Wr��"�Y��S)^��zZI*���آ�woSȳ�������/�D���5.fa��i�R%���?Mf[b���cɀ9m�h2n��I�K�/<�L �In�����j�����t�\ҕ���O�x�ظ�%�$�م~�dԑV �u#��b&0n~K4%!2/x�(�����7�����t���oZ����	i �)&q���Zb�v�L��� ����E����.�h��?���9��^��K������LT��$m&�'ZO��jϗ�6�g���(��.��p�>+�qO)����:Z���r�nQ��D|�&%,a��h9�5�Ǌش��q���������5U?�=�k�X�IsRk�v�c�:j��^�[�JnI�K��pʛ�O��v�ոn��e�o�@���<T��V�c�&���됋l�};O@3s��|�<D"7���	��8��\�cN�c.pQxhv�	r�f�8�	��V�$CIK����v���{=y��� èQX�/�W]�������s��_j��N�Jz�a,�`��7�����E�'	����Q����ٙ�O�y-������*��+Alȳ�F�S|��o���8^s{@�d�����de�7�7Nr;���#1z�ʊ� �F蔴�RZK��n����䙨M��)�;����{���=��#��oK����뢓,Uwmi���=%j�PQr�Ƀ	-q�_�EAH�8�ɜ��������&�欏G�UϟۭZ��)U յ�p�﹡Fm���ߝ�'��<u
-4�5�E3I�OZ$��.(�y��g�jgf�!%��݌l����<ʁ�%�C^�T@[+8�;��s�� ���.��<��>	*�ꆺ�sGd��m`�L�F��Ui����Z�t�������VO6��ǚ9��0{y�X��W��5�b�(ߘGW�����ښB�\����|��,��)<�kX#�.�f����C�Oa|,������a���@������.D�Tƴ���Mil>l]V��oe�5E�	p��Z�4��P��B�;�ˋ�=�L���賞;_s.��|ޔI��B�Ɯ1u��E�˴2��� ݠb4�M�s4�aΓk-e�|�n�ۉ`M�%���F��Ůt�}I���b�Zs�X�b����F)��K�����_��J����21�J��F��x�?�FO`5���˛2�\�\*9��Ϸ����MҀ9}��Z�JTtz���HC�^X��f�tL��ز?^��ܹb�����n��6I������|���v��Ix*�5�ؾ�o�4.d��Έ�R^ߖ��J�gy)���a`�[-K�.�5��	��T�[N�N��j�jܒ_Ì'����%���w�,��oi��ɺ�ҋ;yPo0�!ŋCj[���Q.�52�9j��",�I�f�+���ο�H"��E�H-T�Kf���8�כ�(�8��­�:zU��s�?`��^�k�	*c�W�%�t>�t�SL�_K=T�v�O�y�e�H贕:�1� ~��GRA�KU�#xA���Գ�t�#-�#K���+�����-I����c)0��5Ӹ����6%#�`��3Vu�k���|Y
����l���YQ���>N~�U<��:��L��8�� N}K�[W���(����A�|��l��\�@�1�F{�"R�%��R�%�����f���\���3Mj!X09L��=�ډ�;����K�y�ϒAI��i�C�"7�Ag�na�6���)S���ܺ�s�    n�.aI�4#I�M��� �-�Dހ��&���<iu��Ӛ��5��FF^�	��H�<k�/]&�^�d�of�L�)հiIh�{���wP��VP��Y���-���"d���^�O'�rY"��}�ϟ��L!�fC:s��u+�E�щ�sr��ϒ".�����B!��j�[^�^bX�mO(j�YN���OZ���f��/�f�x/4�\�/�,�;ˠj9��5Aiu�<�p6��ĺ���nW��'4L��q��"��j<k+�nD78L�.�y���l��gN�-��o='����`�3��"ԙ�]�+�I}H2by�猏6��I�	9<(����W��c8Q]\��-Z/apr�����~�m�:�'I�G�I���b�rg��Lk�V�7����ǞO��ɳ�`�������D��9�����_��˩N��c��r���x�u��F��������r�')%Yw��\c��AI�}��R��������f渳�C\�����Ik[���=����b.�VK؟�����+i#��y��S���N&�7���z�|��$f�2��]�	aj�ib�cS�,V��z�ڇ��5ۧ��p��n�ᩥ���;�۝ J2���00,ssgS��)A�?�����_r�;������;�f�^���~5����Z ɚ�<g����9����*����MnR� �h�L��N��n���]�F�Or7s�1�G�ǜs��ЖjCB��D�G�՜�M��E7C��2n����'�R���E��)<�Q;����'�D�)�����|�.���Zj$�,9@ejjN�����t'I�J��P$�Μ��U~�I���k90?�����=�ѧ���z��S��{I���?~�i��N��I�̞S�&>���p�X�^~��,���v��!��}=���5RR�U�a�n����9>u��|��$G�����n
�	��wIE$�'L�H͘��3��ۚ��:�z�9�a��}��@e�[�5T�&�?Q?;�Y��O֯�m_�%��6nJ3���T�Lv���Q�p��^�J���ʠk���p,�W��w�7��i�`�7an�<����rT�S4���nșʂl���2�2͕q���g���)�5�k&/eq�ܚ�J\L��;E@jߋI�%�<�=� �g9E��Y��\�ȭ^;$f�Xੲ�����Y�q�O��Q��K梾�
�[y��z$S�T�b��IU4��*;�������h�W8��m�F��P��վBW�o�J�� qM�Y<8D�J�:��S�0�n��y���ojTwiy[-�*�o����e��GjO<n̛7��O�/�Զ�Q�*W�J�R2��=�dK��Zt�t��'��ۈ>*� �a��@��ȫ���;%�<�<ʛĜ	D./'.a�.�%�U������`/1RP��D���IܱF!�mҽ�>N�	�@�x؍�t�d��ۘ+���e3	@��b���b�9��Tܛc\Oʤ�W{�Ƌ����>�%� M�����r�v��6�����.��.�m�7}����,L��KI�?eX�&���Lˌ��2͗�#8���T)?���$�ya�ǂ�����YtA��L�5M8�	��!'��-���U��H6Thm�l�θ�J�l�*�ky���J7�:���MIV {��ƝeYsd��ֻ�y��4�����a�h�*�/!K����	�)�zJ�[��֨����ov��v���\�I�=mS��$_�D��J�|�9w���؊'��m`�3�+�>�l�R^�`����� �)�W4-�	�� ��d��KC�ۙa��A1���u�0dg嵧�ϗ�hK�= 0���-���R��Gi� l�)�A�ό�U�Ec��N��p����������c%ݟ(V�KmN���H�Ԫ>ҙLo�(_�H'���v�J���74�B|XG�����$��@�X�G�rb����$'^�u��cB�����\���Y��b�I�a2_��l�tz��cU+H�<��=C��r��M�Pkc��ί���se0��u�9w�o�oz���Gޙr��D9K}δ��s�N��Q�Ҡ��OH�*M� ��ܥ������8��gu�?s""��ʉ9u�SAT�ax���GY�^w��6u�����_4������ A�f�=�0{�����Z�A����Ẻ�qƿ��7�OJô�$�#�#�l�F7�/"���_{��̽��(3-{(j���Jb $�ӈ�^�@9�]���R{���&�A�Xl=�ܼ��n���@z~?�=��E3�&�WKk���>�1*��Ơ� zW�.�-�6�$g����[��aS���-)5Afte�X�� �_�ɦ����n͂����PRT-�I*Zi���~�h�V74��}�������?n�T�}~�;9�l�����DxW��O�YIi�N�OBֹ+Ry�������7f��EVJ.�3�H���n4Í��#@��6^��,}�f7��3�J
�� ���X�͙"2�ȶY�=��;�f�D� ��A"�dA{$��U�4��»��=i��������~&�+�R
<�b9�#ӎ������'��)�A���LY��c����>p�H�ó{�y�{�S���D	a4q&��D;UYG����w�����l��;�����x�5���H;����Z�� �;\�ѓ���˲vxM��V��?��N�p�CJ[��e�m�x˂�<�<�0�&��������ngP�$\~ߩ���.��&h�_��O�p���I�-��uOW�Ճ��H��W'I71�1��MGY ^�X��3���2AzsL,D/�\I$����{;��kI�)�K푾�DB��~�8�s)F�Ebx�sV���rd��Cʋ=��/������,Ҡ};�$'��K�J4S��zn��gU�W��kh�eFĤ�ZZ����E*�9��^ir�:pf�a �l�MK��Z��[�4>�H�0�L>eP�)�|�}Ls�3�Y'��>��g[M�V��ϻRh_��T���^�N;aܤًj��=�?��$��<9,g?���H��^	=#^o�Qܯ���.��L�10%�Š,�k��<4T�7��#q�D7䓳8yPnU�_{��9|�4Y�-䋡�x�SZ�� ޓ���,>��d�~.���>�z��y��M�3K��r���8�tSi�o� D�bO}w���wt�6V��?�]OV_�v��O���U+պ<�/��Q�Sa2�t�Qn?�,A^���K�jr�G�h�cL��9���H��5N����a��x	��;S��&-�Mfo�I�y���hU�𹖭tk��دn<��3��H��i��O_ΑNj�t����t~�S�D��+"N듒�Jj?�M:yHW���!=�n9�q��S�gL�ݔ7��N��󬉁_��������
����>�j-�?��*�5��JKs%��bX3�so�e��4�m�$�t�p+�y�y.&>Q� /�S��c6@�H����i#�<���)"�&�:��������R^��R�'��|��~������K���}����:�m�e\�_�����+�O�J�ى>4�B��TGU�M���#?��ߗȓ�x�V��|������_��#���������i�o�����O?�b����~�?������o���W�}�{2��2�oqoi>�dәB8�V��#�e<4����<F���FY�PZ�1�9���pS���l������<��ê�����T�'c)��IV]���7�nc-<?/jR��V�QK�Ð��%D�d���;���a`ڱ�Mxy��-��L�<�`4����fy�==�N!�fB��������ο[K�����RG���S ����8�ǤD=�bvL�PZ�yN��N+�ҳ�<҄����R'����g�UZ�G>q��WS�#5�2
[#�<[q�-��]h���&\��	~:󋖩����g7��	^�,�5��vw��/��K3�e�'*ř��,�\Nv���X�=��|�������g�	@z[�z���)���t��^V���E,8 @$�������l,B�Ҷ��>��(i��<����PM��    ���mT�F�/,�RÔ��f�=�m}sqƸ�#�~�ͥ�\߇YBh�C�h~ߋ�V��P2�Ǝ͈4�qۨ/�ߜ��B�aʼJ]����mޞ�M�9&۝��>����t�Q�y�:^Z��,Z_/�Y�lL�e�&�i^@MA��1����q��}��E�8:ly%1u������-�כ����Ý�/h:?J�IU����c���Xs�\�+Y��lNϣ��K��Qeb�Tʵ�N�E�Ѓ�k� A�ty,}�}�p��q��,Oo��h�ZJP�b���[HL6�s��,���WɄk��Dw�Uw�d~�AO�8xj:ɘ����3��l&HA=*mA��q��y�1?�5U[6�;t
Zr�;��h(��4A<h����s/���YB��u�m���̅��5h�x`�k7�3`k���j3��'ǽ]|i�gɩ��λ^�leRN�� �G���ݿ��,�w=ӿ��N���B?��)x��:��!�j�F�)k���cF����z�[�c? l��������?/v^�;���������Ѡ�K�`aH9���Z�%B1!�9;���*�k HM+]6b`�����:�;幵�X��R��zk�Gy�AX�����;�-ߣ�����S�lT���t�����=��=WooX�{*�c��qN��S"F[�qL��D&�\�J�� �9+Z��iH�S�$2r�JYf޸'BO�H��B���d'<ʻ����o�Pv�<�#p�-9��(�@���S�!�#��<PH�����>�	�.q4���g��e����?��ę��4�g����]��))�����Tkg�l�G�ީdh>�������v�y�d�(QB�P,�\(b6��Ep�n�sW�J��}�n/΁�f��7�U��㕨q��-Q;�u���X�m���FA�5O�)���}q���e�F�8ןA�3̩lN��F�f�ja)��m�	Y�24�]Ԟ��R����{��I��S�=�v������=+O�E���e�L����:�j��sc��ޯ�`�����{���#�~��ρN\������m����;��o�Wm���g�߆
h*���o~\��-i��77�����8���S�{�{�L���T{����2*!䖐q�0\�jo~����%W��bWv�%����I1�$7����%�	�} ��L�J��e������o[J�|;��/Y���5��}8��7Z]&��t�JaA��%zyk\�&uLvF�z�����KW��!�i�SK��]����|��i[��ϟ���L����]Bx�@`Ngj�A�!����60LD�{-��S$tL'��h���,r
]%'&@<?��<���,�@����A
��u���<vG�&�۔�����R��]�����6�<(���n����h�����@T�W�t���L���P��\�d�y�B��ɗ�K
������z;U �/�x���>�4��pw����p�4���� �M_e�p�8��Ŀ�
�V'�L��/Ad�N~��y�W��Bu/5sJ��#'-�BLo7�q}�I���@�b���u<k��ߝ��/�	*|���_���V�$Az��e���M֟ �Y%�h
D��:Yx�I!�|'��x�	�i�h�����m��|1)�](��U��K���{Kb�ާ4����O��?�����o�Q�����\=vd  dL�NO���ele��#����e�tGU~]r�������kY�w�?啶/�J��1t�G���ރ��O�_�\�jD�S�5bhxJ�R�_c������@5�X��%�.��� ��c���vωDl�l�9��p`l�U��?�w�7������-�ϛ�]�,K��6����/�4���
 �Ց�ִ�S��zs�^ݛtQ��n2 �/z��y9)$�͟�Z֡���߭	S�%UNou����%|��6\q�F���y�S�R7�vf��T�?����)5DC����>,�K?	3������1���K!�:r��8{����&��ȥ��k9(�k��_��^3�5�F�]3�����:0qpjec;����Bբ��jQ�J�^���=qU�X٘Fʳ����N�LsʡMx�1�8��'w�W�M�4wO*�t=ܲ!Y�G?lX�)��1�"�����P��Y���C;���y��Οa��&��0c���3���L�f�� ȁ�|���$q[
�{a��b�-vعk2�nk�D�/e堠=�?���~�P-�C�1/vI���RS�?_��t��;��*f4x���q�H�]X7y;�u�\�˷�����%ط�/�NW�b!'q��E��8��$�y�r�6u�Zu��@K�-jC^,��㆘K��(Ί�E�SGC;r��cZ
��+=/���#��|���n��^Jc������2Y"2Ȼ��Y�>·�Ŋ n\9��`�v�vK`��ܦ�~rq!ٗ�#16�`�Yl<ES�r��bʧ��5[��	�pލ�J�w�z��\th��t��7!�p��G)�.��OQ$FS�7o�^�M�hF���˜�3��]ۛZ�۶���n����t��׏��a�_��	�����B3"G��Fs�?J�:�\�I'��M��	��u�����?e��D&+ѷёF�_�>�t��o�� ���2|e� ����q͹�i^�_�>����D\�L��94�(���z�c �)l1�ަ�\%v���վ`�M��o�����J�^�)#!#�y��u�~�0��c�y�e@P<�IB�t>6��������"���.@N6@���.w��s�#�H	��)�����7a�pscO�b&;'41}N�sT�d"@�P��5)�T�6~���${Ʌ��*��9��:���7��T��4s�M۞0������J�*��n�].�Y���c�J�9�ǃ�1�/�E��n7�{Ԭ%��5����:y�(2���}�4=ݼ�+�K3i���x���T�6�r+8Q�ߌ��)O���~�<' .SB��G[����W�Eד���e��h�v�gTX��g��{�W��-a�X=|qΧ�a?J��å��0��&��ǑW��7N8gR��a�UJ���;'����{�����8�yrj�gO'��|H\ lh�hx��d��x�*��n���6�+�ԛ#I琰��x���z{��������˕������₉�E�(g��v*�̳d���l�R ��Y|PV[����᪵9J��{F������m��I��$o�V���<�t�/�� ��p������G�G�L��?���\��e`�d�ԽC�����i.y�%@�?��j�vq�X���py�0/S�S�`�`'�y���^�1E\���Qg1oNk_�sٓ�I��$wլ��.m%��䄼��Yڵ�Qh����ߘ�~x�_��55Y~�f̺�V��'��T'�%�S)�j�~�_-3w�bÏ|n�e=�"m�������L��%<�j ��Y���aFÈS$��N��x�����閤��f��8�����XIv�E��H9|S���9��Մn��Ky2A�C�q��^R#F�oVP-���lr�����&cL	���[ ɵ]%6|�r)�B������e-g�40��\t����nk:@C���f�?�ޗn��}���� OHW�����_n͖>i�Id��u�|�O>r��N!���[�)�-��)-�T|_rN+ﶵ�XSߧx�˶�j.���R�L�N	qQ�W�L#hW/�,��X�A1�᳍��rQL���$~�7[�4�lz�
��+��q�u ����\���o:�<W]�u���pь�V~+��]���6��i�����p2�������&� ��������D��	$W�r�u�D7��.a:��![��T8�wq�����w��3�-������Nyԗ�HS�p{P%L]�C7$��bFK*��N�S���s� ?D��~����5\y2o�Lp[��%=������{����4�MW���	�w�/�sP�� �m���Z=?�ѩ4 �e.���N�1�Ro$Y0�~rNO���f�#M�q%�<��b�MR��̡u�� .��    c3�$\��FY�8YINb�>����(��;Z���36��1*I@I tC(䛽5%x�Y�w��Y�-s'�/�<��";�jVЩ�Y���H#F9� z�޿k
��`Hr�I�eP��Hڙt�5��/�v�8����e(e`�iF.NK�M;ۘ{���%B(����(����w�` �oUX SȠ��E?w�����§�i��d����I/��6�7��!�7��c牝��]�v��S��_y�lN�D2�q�B�{Mm�B#���@[|��D�f���8�:�)�I������x����O��S���a��$��R+�š9�0RL�L��er��H@��a�IyB�.#՗T*E�ó5��ŗe�rha��[9�/�o���O��
n"��于��7R�/0�*������m��Ϸ4���K%�4_�]l\�|�����$����8�!,I�h�Kː�]��L�!��~L1�E~ߍ�}n��V�g"2�1`a5����O��Ǘ�Dƕ�W?�4v�	�r��U%�b�w��\���RW��Ly?j�D���(N#�Ӝ��#�)�'	�f<�s4�f�7_�;2H^�vы״ۜ�p^�Y)�UL+�'�Ȳй&�\��|t��*v��2@R�~t�^�#�s��YQ����)H>�ag��y�N��`M���g�{<f�`��{=���X���r�Y��K�}z�V��X9M�(�$F쪒?:�%^
�����#�	ɔ�ه�IS��9����wIh���,���dd�֖��)�r�a����H���	��	-)S�>����o�??�^�	�}S��H~��|� N���������T�@ol�&S<��I��V��ʒ���|hו�<:W9�(�y���a�N�mG��N)�$���{��i�CA[
�)��(V��{����]�/�����F�}�>g�VT���� _5�met�o��+	��I��Q������at6��(�bBRn�V�럭@�a^�`_棿%UZ���[3�J-5��[�s��DuM���٪�/��?�&���`�p���ĿQr����~Tk����Q��|��7K=w��v��!\L�C���s|���~8Bɻ%�_�0vg3����b���a������!䎣����\�J��ڶ$ҷ�8�Q��V�I�.h!`�������n
I�'�i.l'��UqV�J�
�����M�uj��Ҥ��zW>�+
9�|t>|>nty��i{[{�Xg\cv�[>WK�߱���%��d9��3Nk�+�I�Ch�ϔ���rS����҉��J��^{�h�x,�9�J����#Hq�:�8S�yԮ�;��W�vQx���K�j�0Si�vÕ���F$	�Z<.ϫ��a�J|��e�j�$!n
�`��ȩJ�����nl�=�p*�4ը=�n��=��]]�~�Í����f���o���f��Ӕ�nT���֎����']���4uv[��T	�T�.��W"@Qu]re�>?|�Q���m�^w
�i)_��p�?q�$�G��ǂ�u�.-X�V��`��ѿ�����K
�{U�*����<P�ae	��99F;W�x�L���-�m�Y�|��ZJO�!_Y:��AɝJ󳩡�*����;�ԯ�	}�rBs��2�I�иAb�7�a�\*i��F�+,fz���`}9ni�Nr;�"8|�V3hMC��C�ye%�8�ڒ�3�(q�M$�S&.��.�m'����lj�'��uY�5x���[�"���k�t�no������D<%Tb8���d|m�Tē~5���>�[ۯ�\YbT^�pĸ�M���-�=]�Q������m@��t�Cm!������)fm'�t��$o�,�b/�\}?��:�)7��u��7���]��w#�|��iJ�i���̂��H}y�z/M�L���J��b'-Sb%����GZI��d���r�#�S�G���ha"�ʘi���p��9j�o?0a�"���s��PMYY&���z�U�4\	u�*?i���X�te�B�A(���i���?�P���©���s��g�/�Q&�!�#��X;�l�%n�Zܺe�4�'m j�H�dyL�WK��*��j����@�j�w�m��JD�y��<���&�M,b-��C���z�,��$W�;��b~�t��d_&`�ɳ�&U:e��åzE���H����z�Y�)�(#� �����h��ʤ�7[��߀��Bڿ7,����$�M����8�����4�~�НT��͟%gx�?�a���0}a;�2&�}8mvN���LIr�^�]�ٴ�WB�n��b$�qa�WܜUsSw�`�	��SP��'q@��'����0Ea�df�U��'d}��m��Q�c�i�~&��ݖ�$Y��<�S#1<e��ӗ*Ry�����})r�𘍐t�
`�m/19u~��m-�C�W'k�7w�ں���fz	�I�2���癖����5c����
��ޙ}�	�����"����Y�1���n(6�D+�!��W��d��Mj;��/��\1V�g#u���9,PVI��Vq/�-r�_���S�R�9�5x)Q�f����*t����v攵ĝ3-*��k2�ˉ0N
C��0���3�t�b�u�a�����6#�;�K�Q�v筌��-��)�̷�:���d���I�7��>ġ~�aG���2�=J���4����R�^S@~_�H4{��/���y^'] ��/��aR����3���%��l!S����X�0H�p�ՍϜB{GN(?��yYS��j	��95�E�1��j.�3=#��|N�nα������s���Nd��d��Qz}��^�$u�^ȃp��i񚾅I_��E����3^w�#%Zg��43]Z`����{�V �!���a8��Ő'�w+�Hg��X���P������lV?-ܱ�/j������T+á�J��i��#Y�+�m��� ��,������A��DM���m�3��ix��P�i�,�|�-K/����$~B���>Lto&�^�%��hNW���[
\&���W�B{�q>`
�k�f�S��v����� r�y���Ds�4��G�o�H��R��HY�s���t��
)�K��)E�=�B��e���ok��^�#�����+1�.;�H�[^و1�h1�]�)ز�eO/�B�)��>~Z3}n�2'M�tf�-_��v� (/�*}���4�֚R%���m�����ƥ�Y��Sc<���4y�;C2�Yu%���1AkM��q����W�@j0i`���Բ�-,�GbRN_���S�ؐm�_�Y4��X��HXH&D.*��#l����\K��Ґ<�3]~1jűqU��"8�{Yw-������	-%.���-�i/{��]������0�p��2�3z^�)�!-��3[l��c���D��_Yз�H��'7zp׽��˺<!*���b���%�oSɴm�D����OѢ�	'��Zj�퇽J49&�-!P��ax[Ҋ_��1&o3�� ��w�-S*u����!�Js���G=�4�ֹ��t��S�~Qa��V6iR~ʞ�r�E��;��fQ�V`��!�c+�|�4�ʅgᙚ�"1�$���z��d�񤄞�[S�䀜�5�.�o��7� �x#Bt2�֙/��y5����VBqp�o"��J�4��yt���U��/N���~M2ΓC�MY�}m���6�m���sL%�x"\˓�?��Z��B���?7*'���Uص��>y{����� l�������
q�6�]zSry� � ���?c��O����(���I*�#]WBm9�c�Ѭ�ȋ�ὕ�K
´�	�[rP���ї�iMk�a�v1PH$�ߺ�taA���$,�gu�f�sRH>�e�X�yD<��-�ㆴ0�X�uKƣ����@�VcE��J�_���/�g��xV��(�ҕ/w�|�	��w8��$^ϯB�Z��&*n�q�%4(�&B�dגp,lrޟu�S��w�S�L��%����#����֕.cR.��n���.�8/ZQ�h�[L�2m���DE���*'Q�<�\svE3Y��t�D���~T|Ԙ�[��_r�J#    x���@�:/�X�XRO�G�c��蟿n�I�O�{�l�riY�W�AN�4w1�3�|�tESS��̐��S�%��uhc�"�/\с?�L���Ji�~�js�V���ٜpB;j���]�ʂѫ�^Yi Ǽn���L��a��*�!��!>ܿ����ꐷ���Q���([�cr��g��-�@Ȝ��<��7���Ş~C�L>�'zXl퍗Y�٠_���1_?�< ����=���ﴊ���@�iV&C�<$n.xW��I�*��t��"U/,{;Oęo�(eЃ�����v���&e�4fii�T�D�|�#%�'B"��-NIF�2ߩ7����׍����yA�)�E1'v�5�g�e��.[���Yqj�=��A�+��vUn��4�,��-lE��ba$�uMV
���������� v_Җ�5�����6ix��$�v��%0,-�LFi�� ���חxM	��nUIM%ͤ�8<��1��g$�rML����mSOP���r������]~��U	��?l���\ح�R���SS e'th�.񦡾S�vc�t�)�(���6�6�J����`?<��¤�xlK���E����s�X��W�����s	Ճ-]�}V[�{�=/pKs��u!��i�_>i��M��A�tJ��!� mCaoֵ�t�~o�Tc���������P{-b��ghJ�^jR~��o��C:�(yu����7j܌�����lw6zx��s��Z��~�3mS�ěz�k��Ֆ�����S���i%q����ݼ7���Q��ry�37]��y�:��e��OsN�I�]�jT���^�L	p��y��?�޹�n)�ny(GDf�jI4fS'ݞ�5��d����!��m[yN�.ࡲ1w�+�zq���ړ/q����Wx�t����ZE�(u�P:g"}�����ٰw*�Ǐ [^��h�
�j���N��o�.ڻ^�dB3�D�����,$+��|��<=�?dw�8�=7R6��l�#����尶類~����v����F����5��O��[0��E>�\~m�T�5�˃��r]��Q���l<�Q�ړ�p��rK"~�ɇ�RJdE�J*���=�D	F�>,�V�J9�׍�����ZJ�{�v{D�o-�q�l3�Zr;�7K��A�\�b�l�yi�H���v�os�����Ӷ���ޒ�ȉ^������J(H��"cb�����	�z�l�B�bRytF�
XB�Rm��璘hgc�����K _;�Q�*:�qO������&���鶮R�?�~�P�R���(�n&��=!}�.��T�I4��g�{�$��ϙ�I�^���3�۽�n��j��S��b�bۃў.')<o�$�����g���S�]WW��5���P�H�Q�$�� ���-䀤�X��HUO)i�M<��ԗ�����������~��ϔ؅�q������mNn���=�y.�GL�L� I]��۸�J��t��UV����?��n��-����O�߾ L&Ʀ]{#���)-��m|bf����k�<�MI�tl[˥�$��{���D�0��rD��m��\���aIBfԙ���v�k�?g6����Z�|e��U��g��T,�=q���b&K��/��"cA�� ]��?7�1��)�c��U����fܩ  2O�'�j� ��\w#��<s]�����A�V�D`97���qR�JM���05��{X��Np����|��9����tU��oδS���x�����(�4w�S&3"	"f^t������4"�{��]�߇��ܽ:ի<��Պ��`R�4�$R�f,DK��9�<VK���A�!_"�Y	`3i�˔�7e'y�@�&���
˧9y-��#�AȥE�klKrsI$d������S�e���`��Z�Ds4���J�9�)�{#���R��'�&:���/e��pcp�K��E�HE6�_ʁ�"�$�'B�ZGy�*��~��n��VJ7A�tvg��'��Ԝ����Z��@ITm�O��:wi,T�������/����R$�V�R��t��l;~��U�`�V㾃G�=���"��d�T���Tj��$Xq}�G]:	���m����׿_L���K�a��x�����Pp�����q_ջ<�r
�t����X"�`�ؤCE�F��2�KO��:�1]���O�T��H�H��_lO���(q��_�ѿ�W���P�:���s��ۓ�&�C��3ȵ�{+kN�3o�%o�h򞅯��/�����6���^�T���5I���Իri�x�'ɱg��FC<z�q�(�d�%�|���P������:��^�7�dI �F	|���M/.C):���%�$��$n퀍��JgIK{��}�	��^�-��C ���Y��,��k�z�t�c)3�0SS��{��5X����9!�@o��'��Ö���T��.��B��b63�.Rչ�_���3�5cK�/zԙD�D�%��t��+_��w�u���ݱ\��tZ�k��޸�6,����2TrOڟB�%�O	��ZпZ�<͛������
�����a�=�Τ�ώf%��J�e���wT{���c�@F;����.�W[���|��R�~LΙ��(ߜ��H�]�L�55ՙmӨ���Jkt�M{i[�[%=��%��1�#�o�C�o�ݍ���h�K>{QWm��:̉�EjAĲ�,-��n�l�o'���6yj{y3s���$uL�溊���M��$�\L��;�e���-J�<�*�!��
��y��I:[�q
e�g�8��'8��'R���?�5����w%\O"��a4θX���N���qJ2U�ұ4�+�O��)���P��q�Wz'&��s�T9�iv���W���AwZ0��\k�I���B��������+����o��c�MQ� t��O����:5�{��;5hJ�X�Ǡ�<��Km���qp�Y�ڔҦ�ߟc8�Q�9�����E"U�W�R�M������kl�*?�g���-�``�\6��ϖ'�ꂖT�����̭�a���:����41�0yIR�,��U�	X�ۖ��r��{��B�$�?̪rJR+�{"�a�D�j�FF�P�	��`����X�p7�U�|�5��>���7ю#�VH�T���r�I!W��)��y�Y��Q���y�����|۷3<i�\Δ��xu1���^?	D�E����k[��&�Zy����]7����pT�����h	=�a�K��O}F	�������&��F�Z�ݒ���������|t�Ǯ�'ٗ#�}�Hg����3�3��Y�7G�) GZ��2b_��9&Ⳬ�ܜ[�x���)������/����W�4��M���o�U���rmK�lj�)�a$���J��������'��?��B����p�t;m��fw�����q�GH�z��9�?�<'�-7s���w=
�z��+K�M��
� �������ĉ,����"5��9��ӠH��+|t�50R�(MB:��=35vڮb��B L����9�:��CK��~K������i�r>����oȍ7����3� �,p�)K�<�T`�4�xP��Ŷ�C6D�H�ݖ�!�(�#r8ބ4^pp�X]Ô��svT݃�R�ؼ�C��H$眤��p�Y�⪥�KTN�K�ϩ����,��ŦL0%��R��>&�BI'�OrFڬ�b���)_"�d�(��d�G&�yزv��s�k�Nx/��j��
���'��u`nj��[��>N2�����1ݶ"Eg�B_=g~�?�:������r,'%��yO���D�����s�7��)��tQǍ0��u<S
ZM���LlNU�ݿ��Ӆ��J�>�|}�}�&�q"n�����E�<���F7uų'⼰�y�.���'Ͳ���l�"�}3K���к2��Uv����(Ru�H�˵��LӐo��h�b�?�4�3NH�\�t����>�n9�)97`�t]LGC}=$T<AU!y�-���n�q���51.��z���9�f��/�o�1��ѥ���2qZ�R/��d�vS	�#?s�S@C�L�&�-�4ַ�Zً�}���*�k�4��jQ�	�-e��48���w�$    q/��Mh�R�'�'�mN�Ы��//��G��n�� t<p����Zr��	%j'��ܵ���n���G�bY�������0�R�Wr��9����֎��ϙ��q�h�ڔ��;�;P2\Et�����n�.VCiYtV9KL �0��vX�����?�,�-|Z�<9��>Q6���
a
J�T��n��a)��)���S�%̽�Y��jLy�hN<)qbSߞ4ވ �]U~L�Ix�q� ��1%�$��:�퀮�7&����c!Q�Kl%�E�&:���ۘ�@��@�}�������IMC�[k%��Y8 唌e�dtS�Is��^=ϲ����t�i:��\�"���%.�P��D��J̀,������
�fiUp��z�ݞH�f��� ��	y���s`y|Es͒ܔ������6�Ia�u������͵@�y�����]
fg�;�zsv��?�Am�jw�����T%m>[z��7�˞�,��Е_�?1��)E���A��iY���I�4�x$Bl[�$϶��
%�<a6S<��u�>H��û���[Ȧ�b�<e2qN���~�Ì~Jt�_�[K���`v1u|�|�t#3ri��Dľګ�M̤U����:�+��%F&�,	��P�m&����иZ���{�+�����y7piJ�\7�
o�'��n���~�lp�,�(�]�8��H/�<��k����U& �Nd(�>Y�3�e`a�]	&��v4C�hİ�؃������I��H;�&yN���p��{��9h�S]����5��ߗg���.Q��h��}b�d<��z����'Om
L����	3W��w�k������i�=���ߚ���������r�ҿ�ҁ�)�c�Ӟ#? �),5p���L�,'.- �W���R>�io)@$#j	7X�[�>К��\Z
�\62�?2�F��0r�[����K���aU|���mv����,D�t��	[��c��4;��ceE|C�M���!r�鴤��ry�ݑK��ĭN��H���ܸ=��/7|�iǠ����$�4��~3��AC��^���F�({}ȧ�Ž�?��ܥ�����ZjQ���{���et�FQgS�?��?,Zr�6':�!�^�D�Ef�*��p�����48_zS�p��='7L<���Ќ�\��7����y.�e"Ӹ���Y�8b��"�PZ��A 0�B0�q*��Ng����p���)����oxN*�H�g�����%��R��'XwrVp1����j�`w/�����r#��R\P�HK��yj	��������_s"��ř�/ϝ!T�*$?�^R���K�^v(eiYb�&,�\�0��lUk��F��c,�"�x)�{"�z�#1� 0<�1�;�"��ZI��=���9k"��3
�Q=��>d�9�Y���+h�u�:Ma��<�/�ޫ�=�Ru�9Qp[�6P5G1�~���}B�QH����rb��F�HL9����
k��;�F��������X,����D]RG��K)�䣥�������������O����X��ӻZ�d��8��zx��)c�3���s�~���U���f�&ߑ���ݘ/�����lbҵ��2�ɋ&-�RGJ
�~m��tQDp�3=z�cM�F �2���|�,��$�<�+�=r'k��y>`�L��+�:2,��gmc~~k�]~>�V�<~���6�)�:�푲�f�v�r�,��%0b�(0��N�s/z���������lZ(�&���n�^Ky���7#�%`���D���F)��4�?v�yK��/�K��ˍ��Y�x_ ��Ƒ9p7Ծo�Ԋ9^R��@�s�GN���{�O�|ul�:1>�_���~��d̗�bBH���19����Np�%|fu���*��`�ݸ�臤�s����.+�@M�-g�gzA����9�S���g_��I�y{��"{�k��Hx)��t>5��J`6\�A�񻷫���ϫ���^N���_:����U3�
ެ��o-G��Ex��8"JB�~O��+8D91�$!ԁ:Bt!'����z)�4�ۼI���m5Fe~Q�����S�?�R����E���KBxGC�C!|�����ة��rŋL�t�S�ꔬs�qz e���y�e�L$�Qv�z9sa�V�����~ �g��>�ĖCپX��Y�h��Ȱ�J)�V-)��sH�`'��� �:�+o1a5Q.��Z�lX��g�R\����0.Ow��i��c{�$|ۈ�n
���ô�S��tH�6������O����yq��;>�A�h��^oꂿ�O���Hr+(-iu�ȧm����_���������q����?������������)�_*�*���5Ra��`�8Xı�,њ�����%?td��[I|>�� �G��%����ɹ�&�mf�7� �H�NZ%)�u��Ӡ�asE~Әo�A��q<i`� S�[�K%e�w�)N�r���r%;||�e��+O���c��<���G	��S?�7%V��t��u��_}HP@���}��/��E�/�#�aT��u�8#�t����%���ô���8�Ԅ.��4����; _z6g�|4~��8
)Y�/�S������%2��3��L��P���P�Y������p#�._+�*��i�_Ry"3r �`S���{h�%[;�ҭ,pn�2L��U܎�jhK�/vn��f3��]vwie��yce��EϹ������7�dXs:݅����;/���^�A�s���7�!�SI��Λ�lj��aܞc�><䞳���C~���G:�t۵F�w [�V9�		z!\�<7M6��y�;���:�������HW��a?���ӫS'ET��k�:�]���n��و���hnEN%n����c|�y�9�(X/%��~��=
n����52+ }
AN��4����)���kic�XG�w��yv �i_�|��r����AJgC}�3?/����=ߺL�	D� �b���<W�bb���t~[	�'0&��?� A/��΂�fÎ�'j:T��Ky�k��g�J^���8�w_�r��ӔS-�g�ڕE�n��L��t�Өgt���y<�O	j�t�?��LzUk2 ��l+M�H������ϟ��N6jn9��1�j��͈�������g���rӞ����d�4j���m����ͳ}q1��HF��0��wQ:[?�۴�E쇚ͳ�����t"N�5, �]�9��Qv�q�O��#<k�T���k����>���d�>9�c�x�k�,l�T �#��K�H��++�<�k%�6>�-�ɐy�5��d�#��ړ̎�ԃ�L��\�ATZ�O�0!��Sr���wOqK37Y�y���Vx���MtB~�5_ 9��5C����P�p�Ғ&�Ǝ($���ʢ�du������Z�bK�w~�\+��%�Jr"�Kॳ��e�=��5Oe��2�9>��ߟ�]�1̧�Ã��-c-���D�Vˁ>��{1���A�(�* I���7�=�wY�LIx��tL���䓌1�.�y/�|�#�i��D��� �J�K�&I�^^-`vm����=�������t��sl�6]m�A.:��_l�P�X� \�7ۮAv��A�h�}�k����V>M�N�H��w��G�th�� �� Ҙwnv�E�#_.�͇������?oIc��m^�z"[�s̊�Fr9�m��I63<y�A�%lNO~_)�$�����ކ�\�������>�~��P�ϧ���n>���wY�;z�̓~�IM��Ո�Tc��;`���,�19+q��
�b}xu�G�����!��eR9vvLa�.֟G%r>�NC�D�&�[�.	�!���x��:aM�7)�^��\�#��#��Me�4X��n9SQ�̑^o^4g��)���xz���%���������~���v3G)7���)w�#��>\*F�4�~"��
U�@u*e2�
��	��7"c︮�7�@E�S$g����NT�WaL]N�S��T�y��|,o��K�#�q-:�i��#�]d�)<2�H�I&ء٠W򝕁�=�[!�+����)QS�s����^�&���    )��d9��ہ�âC�%	}��*�$�-���њX��~l���$olitlV�F�N%<��̩�L xI?^���xwS���.�[*�A�D���q�{��%)$�T�������	���D#^���x4�n�k�P����oʇ�8K���*l0R����~��K������s˥|�1���[(}���·;m܄���8�T��֩�;� ��"�ܚj�i���P��s���9�@���&0S���`��M�"�v�U�y�P���_��A#�H�k�t����Ť��]�kQXb��)p�	<i���f�9��_�N���dŒ?���1�)����x|j:��I���q;�iZZ���)˙�t&A)I�⓪�vW���N9On�I��p�Q"�3��Ӊ"�ӊ�}���&���{�A��E�PW�Nt�k��d�{X޿����P�~��Lߒ� 2}@�}�Y9�a�=&՚��� ��\9R=�0��i����l[,J�g_x�$Z$���U�X4@��j��MV�#���MK�uS�'�jd���w��x��X9tS�4>q�⽨�i w�UQ�W�-�������}��Z�<�D8��o��H�:~:�	1���^�Ezq�	�K�j%]��E�2�8/kGA�1#P���
���9ߢyR_��@-k�^�;�%?���]&1j�$J���y����u�M�nɉW���c�9̣�����`�%�M.앿��v%�� 7�(�1�� �������S8�)Ps���gO��~��H��~��7�tVذ�z��ʚO�P���(�|j�S�%T�Գ�����Tvy@��L`Q[?A0��>���T����3�r���d@+���\�3�*�j����%_`=`{���`w��O���
8�m�M�D�{��\Xʱ�����X+L��V)ۤ#vfMX�\$���(E�٢B����H�(*wH+<�2Z��nd*��h�9�k�,/���В��aQ�-��IZϕ[yiܣ6�9y��F�H[vbc��S{"�9�$7�=��w!I��w�֌e�sT��_�԰&c��;s�K5�w ���=��@ܪ+�x��ZQ+�����ARV�7�OL���>�����ן�����H�[!@H[�霟s�&r��h��$�YW�j?��7���Aa3+S�;�����h��D������\�֋PV�a]���ϴ��MM. �� �p[ٷ�B��k-���� ��y?l��J,���M�d�.����L9v��)S^��4�,Y��d�R0�~�%0����^L׍*����?� ����GO�ƨ�Ag��[����/��~8�Q,_����.L�7���Ę��]�d�vn�q��nv1sP腂��O�����/M�ΥG#c��w�wjL���{�� ح\
o�7����+Qt�ZRM��X�J<��5��ҒP�m9��Y���Dx��(G��jxh�d�N6L+v�T:L���J�X}˟N��ZĄ����y��(���^��l�� ��a�һ̇�b��s9�'Vo\��ڄ��a���!�%��.�7i鮭4��0��J�__��{�^��Ic;΁�@��3����QJ��H�''K|Z��F\$��Ay���������sS�T�%��w0�f���SM���T,����s�Sk��4���&�S�A[��#��L�.ϖ�������?�mJ/�ԡ�� )�ҬR�Nw�^��S��)��b<:sP��M��ި��J�!�7wh>[��M�~ �.[0��K�|e�J*m略��f'���ME��������+�����5�Kx+�c�<ӷ��=p�����Nr�;�I ?d7��Tݼ��#�ޝ��%B����m/W��=��܉���8�/�v9�`��4+�s.����}��(Dt%I/�ͫ˻տ+RWZ�w{FAB�u�6��KKu>K�.�$n�6�t�:�\Q�>��ofj'mʺ-#����9���v'���v�}�m��.eQ?$�	�fMÊf3��'b��8q�0/�5��oOC���=g#���ҍ�ƕW�8���K��n�+,�^~�70��� ۾��ǡ�t�����g����sz8S4������4_�C�S��Em(�i��~az���"=�h �|ׄ�= �V�%-x�nV�P�G���z�Ϛ �Z��&�3҄ѝ����t�2��%����
��T.�	to���7QX�r�E�"$�������279#U��3��D�K��D�����_�}��+�ˢ�;5#��`�ih-E�y&H9���i��7.5��I���q&,u�qa@�$�nFW{x�2�}A�pF��!���,%K��������DK����
���M`�·�O7�>ܕgKЕP��Y��ABH%`@NZ�k���)RZ����VrI�c��:s�Ղ2�
�<�k�K�(.GFgQ!k'\O.��;n����ě����g�)TO����|��蕳�Q���N�I����/^��G����N���s�w�xb3\�Y,i�.���e_~��8%�/����|��e7��ͦ"��v]O����v����/D&zN�����C�<�B�" v��愭4�ɑ�[̦5}P�X�չ�����+ܯ{q�:/��DIs*_F�g�b�	p,%zbW��n~^
�IB)M����a���yH�+�8����8���
ٽ��3e���w�rVG�]��sA�e#�o��	)N�Q���_��L�47h����΃�a
"DTb�O���:��8k�&bM���\�D ��W:� -�TB�ֿ3���,Q~�Y�xy��䜬Z�m�8�\p.��ţd�!*��K��wD����J�;CyY7�}��$m�QT^�����c�й�)�r�sx�<��S���}��o�m*a!��pJ��y�23�7�3��l3k�����M�������$�`�H�14r�:uL��y%}�#�C�|�Sw�]�ع�ɱ��Mu�/�,ҀH�t���5�5���4��̍�[hc׊C��ӟ��[���_?Ѣ�ONz�\�|��@����Z��Q�~�p���1!��~�]��m36�E���k�Ӑhtl3��N�^PV>�yb�ōY�r��9�y�sQ���rW�֒��'�机�M
�b:��i�!&-߀�l��>�]�Ay� �S����ǧL�_�w?S��R���+�p�N˗^t��N��'��n��ZX*49�M�\�4���Ȅ���c���3��%��0	\E�"��?6�J�u@ݸ��R�^��1�(�~[�����$����OnS�$Jmֲc�|�*�R��x��[QCOȥ�!�,s{xY��^�0M�g��WωJu�-7�$E��`�?L��s SC�6��F�n�F�JHb>NT�2$�p��[}-�J�����%p%���J
~��5U��KB�}�N�'�(EO}Y���Ș��W�r��j�>���SU�W�V���rNM�&M�z��|~or.s&5>��\�ۼ��U�
�	�i۷B+�e6"��i�l�󇰍��J�#?C+$�ɗ�F�,~ݡ�Hl4�4���M���e�-?��C�0SP� ��Y����S�|LK��_mW}[��j��4T����Ii)u������;T�Ӕ��w�'m���P�)��!<f�9;��Qn}�d#ԙ�=�S��aܙP6M�/|HF&��&��ௐ�8	lo�G�G@�_�n��e��܉/�֛̟�?u���yZ�h���p��aMnB�F;e�w���� 5����ۘ*Ȗ~X�����{�h$P��q�L��8����{
C>�Ѕs[�rU-y�ȿyQ�&I��ZN]��I#�#����Lo��甹4\�3�4���j��Q�l�|%o���9i ���,_(o�xx���ڙ�R����mG��w���p�t�w���̦?��WFր�:p[z!3��&�E&x��T�9@�����1셆D	�1k-���b/�������b��U�-T�[��
�t�i
���8���� �����#��垻o�V��YBݥڙ����L~f�	�h�w�b@%�gt r_�𔟿r�~��h��4.    =m�|�t����D\:m��" ��s�;�T9{)Sė?ԫ
���qPk�������g���P�.>������3��B��s��J��oz���ضE�6��];Ʉ�UG��eߖ������N}��I��wF���%����%*o�N���&���� ?���s�.�K"�j�sAUP�LV6�{����"����|�w8�ZQ,��A\��m��fr�O�д��EY��{>?�> �"oGg��'�Q:M�2'��y�ZmԿx;�"�қ)q��[9S�K�jt�&��4��Ts-�5��n*����\��,||S���$.�U��� z�醾<�fg.{�hz�D��f�z����N��2�1�Ase����v�|*6��^�)��/-'q�!��'��O"qqoMD���w��p�J�o'MRp�n�~[�����	���%a9�	r�r���Z�	�J/�w�ɟ^;��|b��ۜM��b祻���cῦe|��=��o�}>�ӯ3#>%�������-�	38+v:Jb�xQ\�*n j�ei�n%Y.���m����z2���)��Y��S�߼K+�oJ�8NU��K��B2�c-�<l��B�T60�G���l����Ao����p���|��E͚>�8!Ã�%ko�߉L�>X	Meޓ G��N�S��� �R3v�7���v�W>�kᾖ�.)S��n����>�j���MLDK�(��\1����3�H)�ֿ�X��>�9�kZ�����j�K-��Ea���閛�H�81���y��>�j�EK��3�e��A23�r����I�#w��.ݙCuyb��q����\11��Juy�@&��á�8�J�h�H����b13|�>��h�D�c�q����^^�))�#&OM�ٮ�3ݭx�R:��~�vȲ��$�O�s���qD�p3���I�Bm�@h9}I�-�(���NB��[�|8׃5a:%�y4����O�>���4dEa&�0
jCܽ�\�4�av ���w��1���Wf�t�f�H��^��1�&�����?��ﵦ�Ih���ٞ�w�Ɨ�R-���9��J��;. 9�<���N-�|�D��8WSu�F5��!�>���*��X��EN��-?H���
uT��V��_j�5y�|ڶipU�t��y�V���N,�G0�u>	`s���<��Ӟp�J�{�)C����w��]�'w�_��%+%mY�'6|֧����k�oR
�����Z�XS��23ϿCH��N4x�%K�+�ܺYMF�R/��p�ܽ,�#�rM����Q�K0{���$;�{U�걥[�R���(q !�o�P�'��d��q��iJ-*�5-�����t����Φju��fȄ����|����Zy*Iu�&XO�/,ӏ+T5�9�9Ջ���O�N���:�HTy&)I�~�Y���i2�&
Ԝ�c5�5"�[&�G�§p��m>�l5nf	iD6=�I���f����[z��>|G���"g:ä+wi�:��O*�����ˈV}�c��'��d�y 8�qU+݆�G^E�]R��c�5Wzح�����h���Ю�s���,��Ⱦg���4��O)�יQr�E�� E�/<�$�O6xg�W�� 0
�=�P�W	�$��9ɇp��}�r��7yUk�@3�\-�����<^���5T/���e�cx�&��Ҟ�'c�4��ʶ�&!+�C��e�	о�20̇X)\�P�e�ɤE���n�&��\2]c.�q���zj�3����I� ����Ź�ywͥ.QٵU�N���YǞș�h-���K�Pσ���(����B�kL�-~fɩ����	�R0�ԣd��-�M7T���1ٮ�D=�)�|QTI������;KiA|o�!/(���QBV��?M��$9v�	�m1�t�YDږM3��4WB^JtJ�7�-9an�-�V��0��i��w#0�yI����y��I���:
���ߠ�u�HM�;�T)��Zbh&��f{c�k�������^�@J�Ni�`ƻ�?e����E�����R[5�A��rAOc$�\�� C��ְ�S���N	G,�@O>s�6�v�s��)��G�T�k���-�{Ie*�f��9�<�-y��S�Θn��v9j�F;�{�y�(��;�!���%_��-^]�t�$�l$�r߫��j'l8�0Ԃ�#��8��8��Nk�m,�Xށ^�G%�煭�M��D�U7Lk������vZo3�����N4h� ��1��8�}_���?u���hS>I����C�V=��E#@S1�O=��$��0��u�5�iJrή�	JFʏo�?ހ�K�����H��>��'UBZw,��aҠ~ȫYR�_DSܣt���Ͼ�XO�Jw�6.}�SrJܜ�$)��w��Ր ��:@Qr�Z��;D/����"��MuK����-�`.�4~'tM��p���0H�j��,�����<��*_�e�Rs�Q��}��St�l��J��@r�%�#㕋AU���n����(��X�r[�/ϑ��HH�y�(�IJ횛�����O`�i:�����������z��[@��?0J+�D��W�h���\+C�y���oŗ"Y�\��kZ��˥�S�@9����9�}�]�0��X	�{�,��9#I\}ұ���'<܃ie1�޷h(��I�X93o�;��/���U��(��A'nH�k�ہ�n'Þ�d��d�܃LRሴ /a˳F�,�#	�c�ރl�Cbon,��,٘�.��v�����r<�Xj����~a�J	��_9��M��7�]�(��T3G�\b8U։'�D��8��T��n)p_����.��ʅ�X�KoG�������#�ƹ����q�V�DS9t!b&�:�T�ͷ�f��� e
�1�%�M��ȟ�@0h��m��S~2C�i�46s��`J��9a�����	�y�Hw�I�G~Y���5�8���fÚm�Z�X�*ϳȎ����/�`��B'�_��{��Q��s����z�|`��q�Mm$����J�����>�S�����|���qF�n���ǲ�q12�S§]�إ�Nn�7�8�2]��^
�6�TC�$���cJO��%x���I����T5�A����1蟵3?H}-���Z:�w��9w�u N{�T`���뒄z��S��+�sܖ��F
�÷��؄�݄q�����hD�P:��z�-�ҋ="sĴ�[zj��P��R�J/[�¡f"�E�y$H�a1���6�-g¤���b�_?
�,☐ެ�RL�S��G������gj��A�A�k��F��5o
�]p7�|�d��bc���tj�
���z�+�!׿d���!dIƣx��~>��p����^���6<�p�$���i���f�T2Om��Iߘ�3�kK<�S�7&|���^D��B77��l��:�83)#�ȚRK��|�7gu-#qb%!fS��,B��7�~W�K��U�L=��П��(�w>���H�D����4�O�IE3�)}	�����@e�w7e����i�\^Y�%�k��o}���JR��]#W�\��Y*/�L�z'=�l�i!e�vk����n�D?%A޴?�Ӫ�?R�WuQI�v�CI������K0�T�M�t9q� %w�$�0� l�י�e��]���,�>�@�=�϶�Ws���F���u��q t�x�O��˕3��I�[�D�XG1�3�~�0k:�nd�+�s�XA��Y��P�+��R�<�B�'o���Y���x2�+���O��J5����(3
�+ꕵ��k$�p5瘚�C�� ���}ݵ����oKX�pzRo|jF{��68�P%Lu��O�8���;��Q<o��^���Z�'әT�5ꃧ8W�[��Y�F�c�4]�]t�I��U��j:���2^� �����_$U$nOg5�~��¾va����[Jz������n���Y�p���N`~���G&�)�F9�~�=����}W�7ϲ%[]���7�D��~&�`ϳ#�?l*[�ϤZ����&�[�������;XrB    ����ܲH����r��is,{ċ�f�r*I���_D!J�G�74�7� ,/8���!�ܷ�v�����Y'HB��5�
r�{���t��1��=��(8���}*�TeD,;�x�r|�t��EP|'" �5�R��m���xT�R�S�eĝNf�����<9���Ƒ�ړ���zR/��yK#�K����e�D����Hךr���.F[w�	]��=z��R�>J���KS�c�鞩�$�Դ��s.��[Y/��4���ͤlOL��4�JH鯼�zz��6ý��C�*�6���P�4o_�~]���F�/�3=Wv��I3��q��5�o%�1n���\��]�30����D���y�ܱ,e�����^C��k�Xh������Q湽�R.�'��K�)4&h/W~x�S��
��~��Ј���,�-X)�}�D�4"/�K��O�}���'uf�/�������r@���O�H޽�lg��BƜv��X��Xh~� K�|R댶SH�l�ڞ��S�k]o��yA����{�� U}g�$�(�>���$��p-G=�Wi��#_�:����~i&�r�T�r[�M����Y�險QL8#���#Y�ms{�
y���7����<;������S@�cIrٗ��N�i�\&��]�{�t= g�ӽ@DH�&4���f*��ZP�]Ț�A��dhY��Ԧ$�$$ZH�~��𲛢"� Gu<}-M�P����G.~*���my	���r\�)?nP��d���ѣ⤋z�g���2��+�81w��M[��9:�Ȫ�rV7T� r�P����;q\�G��A!l�T�|}��&uvܰ�Ϥ��@6w�4�����)�di)����rrsDS�&�&*$<����Z�f���S#\����D�u<۞s�@���3�b��/\�\��p:��	�0�'%1���'X�؀nE��䳤$1{�SUӒ�x��V�W�HKJ�e#��%��

@��Q~^N4�y�&Sҙ�䑲'o����d4�\>�+�SvP�=����専�ָຠ8�|��'����Fz�����3>�9S�%r<_W�&�[y�l�8y�~("P�#eղs�᳒���dSfqX���.Rp�ʔ�@�s�[1w��t#��(�VK�`�9��2_��!�;D*���[��u�-�#������_��l�xZ��?�1쿟�P
#׻�;ӷ�LI{�N���m2��X{Ս�L�0F��J��Z�\ڇk�֞����1��E�}˓Ij��(S��,�RS|�p�j+)��%�mSr���L�H9�����e2��tb����$�;?f:���s��z�*J��'�/��O?��HX.D:��0�/���\֘L^ƚj���ћ��?}��>�4�\��N!!����pSY�v�y�'��TYR�v�m-5�%�q�7�>�����*���M�2ٻ�,���+�<O��T/�q-ɪǗ3c���a+�֧?E�� �3�~+.��᳴�Ϊg��%#mPifw`��9�$q�ؓ�J��$J��b�;��:p�Ǥ�*i�i���Z<��*I�� dI!�'2%��o��b�pZ����L�H�ru�kAӚ��2?�Y�������Zf�T�DZ�p�\E�d���/DX�"��1�}�k��$Dh������𹗞0��L#4�4�����qs޼��'�7]�}���q���^���7N1�>��Ē-Y�ٞI�h���S�x�I7���N#,�~���W����}I��� x�\r�*������b'~O�����(xR���Tp�Q�ƺ�iPѼ��9�/�ى*uxy*ӝ�4AL��^�C'����̲��.^��A��[򬣆@t�E��mj܃�ѕ����I��Z�Y=�E�Ri�[�dI����TLBu�*�� ����޾^�/8ZU���8p����<Q�F<��S{�a�!��$io(>�N-7�ҭ���#I$�D�[��9s���y�X��	��R��-���FX呑l6��M�~�ލ��ŝ�p�����i��O-R-]H�<����?	'�MԀ�'Gk��ǔ6 ��{I�c�3��|�{�.2<}F��$���S��������ɛ:��a��5�8����_�'��R*UI&�q�����5��k�VK�]����\��*(7X����L��N��M��p<=^){��� ��]	F_j��oh�����|Q"�v�'�����2�{V*�/U�<��EC�>��%MA&����q������2���MN�G�����L?��:r�S�X�� �����D����C̖�lh��c|Q��D���e9�/�x���c���B��Q�0Z��.&n�s�5��1���B{��F���o�R�&mT��$�k@[��A��+�K�����պ�BdC����K^�F�!�������38���Ϗ��'
�ݠg$3�va�s=��W���4�@�sE���e�đ��y(��9}�M��rM�
%�Z'��@L��^�����r�)�?�Gʝ�k��
�2U����ꈙ�l3~F ������O�v��7u$�8��fT�NK)�)�����h�g!�\�Ln����WIkM lOg���_�,Ly��=[~X���a�P��5`�|��h�7c�)E�=ɀK^��tP�1�z�4cP5k�@
�+�t¿n	�9ؖ1�`�vBhJ��+նT*ϳ�{⑫2m�W�9� �\}�N� �B>��>9�sb ۟"�Q����pPxz�h�{J��i�������1i��	��B��F�^�.�A�~�grҞ�g�I-O����']&�3V�K-'���S<V�5*)�$۔;�P�h)ϒ���q�d���I�)��'���t*9Rb+�/�����=})4'�!���՟�-U����S3=�<2iK�*as���agɭ��M���vȨ�<�X鱶���Z9�5LRt���5�L�g��z��D_��r�J_���50��|g.A���l�R\:��L2®6��!��䯡4He>�KȣV+;b��Q�xb�w���m�u�'Cj��Ch&�O�v�̠��]u�r~��zjo.�&ܸ<;y�i�t��S��	�#�����nS�~{yLG�}�:E�ɡ�!�n����� �]}�˪{!<��Ϛ��� '��<����j+��!�z����`8h����Ū�$�%���2��Ok��I��W+��ӽ�-�q3�6�	�d8���";*�3\V��2vD-6�B#�d�柗3�7�	��ߚ��t߇�)��ڏ�q7�M�9�7_����\��M�����aiP�#��i'��o�R&�P~���M ��C�Q���S5�d1S��mY *i�A��_c���R/=�0O}�v�F���Wx�ւFD?MHA����8ʣ�̿�zjYS���%�a�1��Ʌ�͑�]5ч��g:K��f&t9^@��j���\��f>IT�qH-� ���������:|r������s���yͬ9��͟K��{�Yj[O�73���|�\���qaE5����P<�ƒ�D�/M'�+�?���y�9�G��oOr�<U��&��T��/U�xgeِR��m*V���i����o
��(���$�����$�'x�W��*k�9�;���k=*��t"���v�n9L)�>��5��J����@{XT�V6��Y5�x�+�7>S�樤�C�G�Ո�BLym�#*r�[�o�e�l�l������I�S:\���)ʋ�������˅�{[�^C�Ǭ��lE
�1�8��A9�_
 ���_���3,�v�4�F���A`/�,���q�-� �S{&��㩍3F���c��~/���/����W���R}�F0$J�4..�V�aڎ�j8��{�ݙҞ�=F������Ot�����чI��ID��Oս�+$�mΛRq�
�6#Զ�+�W~w����Ĥ�3�1	�S:��04>񓏍ff���2����F)|�j�˻�K�-B����0�L��|�r��I�0��Y����i2�ml�EB���~\�)�� ~.�#{��`��`)+�|�4�W�?ֲ��ԖP�0�z� u��N:=ϓ�a�^�A�n��3    �`k[�3ߧϘ�i�[��x�X<$`�)�h��^��I�ذ�$O�7
�g=���L �Z����AMцYA�T�ohN����r��ߦ����d-v+*�Ϝ��NWZ5�����9�oM|%�n�U�X���`<���}T��6�w	�[M��v���D����M�?/J�Y�f�~i��-��\�J�d�6�E2�S��6-?����D
(�������tJ8b]}�N�>GT���Q��T;�DQc}���&�܃p�w*wj$h�#!4�q!U�	#�d[K�� ׂ;����)-��]�,��TL&jT��;E�>V�"g���	��s'<ę�Ɔ7U���b��>҆�m,�Jz��@cgӚ O7�fW�X)�[��)t��
A��Kxn[�7�k�4�5L�7Q�b�u�w\�aZ0!��f:T󸁇�@d����|^�?[�vN��نwN�ŭ���D�:�,g59��n�����Z8����¢�4�ҝ���.���q�|L�'A�f֕t*f��i���{�g�1�Ӿ�3JA�I��L jr� x��_��t�@���/÷��1~��Ɂ��Q��{�Q4��c��]�UM�K6�%e��~R���e�\���,�J�o>����@�Z�C_[��O��9�˅ �g�<H�
\������XX�}��O�Vc����^�ML�l�@~&�3繞Hov�����\Z��;8��ri���J3��<Ɍ�HӔ��4�ȢX:A1��.�4�R�~���0�\��J�6�Ň�o�&��<:�B�O�!���r�i��8�>.� $[V�,3��$�+yԷB�!�o��z3����~�<�<�>��Y�V*��اF��D�g����Q-! ����`�f�E�3�9������:�&� /{��杦��z	��`�7�S�������Vi��	N��O�1������mYS^�(�#��Z&�iD��Τ��Aw!�-q��/��m��&m)��������n�j�6���\��~�F��T�6�s�<�4�	7�����gW�C�-i�!(�8!�A^��\�O3��g�H�-o�nICc�~M��g�x�~�v9.�vW��iI
 ��ĳ�7-�fd��5T��+����2��,Y�K�䲧��0�$�Ɇ>���hJ������Wa6R�|�(�]/'v�7�fAm�^ZasS4�y�(�Ș+%��z�+�w���L|˔ǹ}9onLN,O��ˮ�� fy���c`�u�Vj]p� WJ�R<�����<t�.���8�C�l&���ϛmDRb�����60�:\���*"���Td�i�'��!f��"s�����-	�6ṣ�4s�����=��m�4+lAW	i���,�re�8;ٗ�h~���E�3OPKn.K3��]%7j�Ƌ����覺�?Iډ��%'=L�&�瘀VbO���y_.����)�o���� ��ͮO���~L�QTDV���8�������GL�qt���<kr��pb+��$w�� �3+�!�^iȌ�4+d=�Դ-�����w��q=w�O����U�A�Z벀��Q�u�S�X�0\��|� w��y\���9w´)z�>���$�J�Y~
#~j7�����aR#��UX�� �~g=S�:<?����y-Hh�r�"�C]�W*g�]�{�WisT��:Ir�W4��h�{� %I��H���hn�o��h�C5�#g��0�"Z��!�.��`����:��$?�Ki�(�򢍣@�k���'��I4�������wl־�V�w���$��C�\t'�$�'��_/�K���U�Ԧ�Mn 7�%fr�9���������9��h/����Tg�z��~�l�ޗ-A~�Hш�V����P��VW܄�΅�%c��D'��t}�_�h�!�Ɍ����~�}������������E�m��FΩGa�s���|t�7���J��N�6Q!����,�ĸ�����v�Q�Wr��`d�`#�L����M���
��� ���hlI���o���R���n�G<�e���j�9&E'8_9		�#E� �w�5Nf���� ~�W�lӝY�0-d5���#Y� ����m�g~����(�t��qFR@�P'��e��ǰ�z�&>�д�� l�Lfa�)0���߻M��証/ ��AQl2_�>o�Ⓞ˸8j���0_���8_)4�&,����~j?7<��e��%����S�#+"���)z�2(l)S[�ͮi������]K/���t����x�Av��upܐ0Tw�xb�X)	x{��� ���'���HW��?�D-�ŵ�nC͒bIңY���MB�ѤҖ�5ǭq�{(���.\�e;�!����e�4��;�ٖ/�ߒcWO�b)C����������cnH���2�$R��$�����C� �R�<�[l%]�������q�Rpr���e��h� �q�M���4��Yx覫�� 4��h��&dЉI�ވ)ƙ*�4��q݅D���9�´���^㢫��9�P�t�������	X,}#���.��������,����(������	��Hv�-�� X��/���Ȣ��(3Ql�I��������R~,����iK����;�z��%Q>Jn�Q�����t�$����'�dvCf0�Y�P8��r$��2(2=��a��y�g�� ��PZ�k곭M	�s�oN+�Uh{�`�,J{�Jy��|J �fy��#$[�g�$��T�@��UR~�<����n��v�m<T�����D��h��U��z���(���*���e{K.sځU�;�R9���G_��	�/̹�1�%s@���y�?��3���L�!�t�l3���\�"�S�j�� ���h�5���[�i-��F�N��C�rDL�c���q\	�J
�]�l:�bN�gX�Ǳ'�k�ь��t1"Ɛ����F��X�?-l)J�(;Y�\ֳ�"���]�p��s%�'\r�{�뾓�)��W��̳�G�y�*����������*��:�99ݖkr�F�
� 7���_���>ݚ�ܓ�dKi`�����$ҏR�I�)D�k�p<�Arr��4Ԙ�2#��5�G]�Q��ĥ�센y������w��I��X�X���<d����)�����?g�g���<�(�t�W�H�.��=�o*��_Y��t;�s��+�iRA,����򜴞`%�e�c���%E��|#'�e�����#_6�<�448���N��)�J}*mxnMN�~}��B��I�L��
�k:�W�M_SR�	�5���ZǛ�(�d����Ş�(uY���u*Q�2�a�~���2�O�%�Њ����s1�0n�M�S<�<��jM�D[������D���I?��'V@'�ݍ($k�w�S�:���8i����Җ,X}��Y�)0V_:����z�϶T@�g���G�~�$�%+��)�-�˳�L<��ɞ�����
Km0J�S �� ��O����ު��K2���ّ=�]A}�x%ʧ�{��@�C�w�`Q��,���F�I�#U���?0c�$9��(ӵ.OΗ3�U�_�c�f�~W�W;�4���b)�JF=�#��r�A�F;kn]Ǭ�:fJm�����,��������_���%q��uc�2=�j˹�Ճ��xs׭ž�L��Eb��М�Az�g)�`
gZ�tٯ���)U�9�Q̉���K���z�J��@3 �SGO�)���M�h�z��GʠcoVɾ��)ꀜ;�G�a$�a��H�Hxn�l��N?�<���I-�����s-ǔ^������V��C���%�g4æ������Hýĕ#50��L�'��褳N܄����+Τ���e&8�w�e�V=94L�Jr ����H�����+Ή�~��A�5]{���( ��B21��K E#(��%��U�ty�%E �$v�!���KT�8�DSn��M���&yx�(A6Q�)�{�)u�D �RaN�l$az�?:���C��Q�8�T+;�
|�0�4�(�'���}�������K�=�� �u�S�ekZ��Qv���MŲC@:'T�gQS,Oiu0�;�>���o:(�<y�hi����_���J��>4��2q    ��V��B�f�{���sY9k�)�VLH��kN��J�Kɗp��Ԫ+�V�_��-��-��v�����y*������s:�?��[2@�6P��{�|����I����&uI�>�E�5�˨�ң��MJ]��ӝ�����B�#�9*E�h�P.��|<�C9�=���	�b���"�M�{�1�$���|�ҍ�~�����J��=%��D����i��<~�@��[��mJ�� ?B�8��5M��ؼ�)fr��M�7���2ϤpѴ�uR�<[�'�ˌ9^%������&�n��|��V�P�V�oYkS�<!�Q�������$�y���z�s�~Ko�d6�rSI��V
 5�y��a�Hh ��&�Q~KH[߷�[>J
�T�#5Oi
�n�%9G+�������J;�Oz���;�<�/��<����k�ĥ����윘�=>d1�����<�?�6L�:$�ݵ�7���0��;Hq��8r����e���^'-�B{��А�3�ǂajZDV��h�+�a�Q� Ǻ�_p�����4�y])�ģ�~J�wM!��x9k�Ji�=j3��c;B��d��-��$t}����ȓS�ۅ�n�ޒ��a���A�׹c�fsN�"�7ܶ �K�s�pI��=srֿ*�?�N���7�.)xeKn%�Uyg��Gg8-��;M�'���D�q��-�S]�u�V���Hl鵏�uA�N'��!���:��:lL�'��L����F\
�H)��G	��KS�C�_i|��ߕؕ���5�@ޘ,���.��+]�{�Y}�M���	�OZ��b�z|�d@��E�vsLɚ{�'������l���zދ�t^~����l�e��ܧ~�hW)��V^�3����y��5��.;�ڻ�#��f��c�$������<1e��F�1~�G�YfV�))�VW�AfIK�T/�_@��Ht�p��4�g�Г
�
|LO�W�.u�oT��Gӏ�5����O��+Vbt>���|گ��Jr��������=N����]��,�w��^���C�Y,�J��TG���x!GG�3�#�ԏ	�>��(؟$i�S�w�<��������	�ַ|�$�/��|K����'�Ĥ�s���6.�<��zL���a���.�a�P��#=��},6�'�'�⠘E@��T�i{~8��/4��q���aS6�Bi}��Z���E,"���ǐ"��� ls!\��i���c014��0�V.�Ϟ�H�'�gk@�= q�<<�F+ۚڣ\�x�y[�O���x0W��^�ԋ�p��h��\��X'�y���E�	!��0�~�@x(���
V��rpaF�\I�������K;��b����ռ��z�ӗ�cB^�~j�d��|
ir!����2��B`�f��r����#Vim;S���������A���CwK�y[�aCBo��O� ʉe�s2nxQ�R�;R���4��sY�9]���(�W7F|<����Yͤ��n}�'�(?粄�Rh���Rr�i�,�c�Q��Zi]��ͥ�"���׀�`F���f���]�Ȯ�=�go4З�pc �zM��E��Ԣ�܂'��K{�|��e�Z�yM	>��q\햄�d�uL���2TK:��skd�ah�h�~�>��dA���N����$%����N��@�Ӱ���$����_��L-,��7�`\�ĔDꋝ�l�YT�Q'1���K�$�u3�Ӡ'!w��=O�l�7��_�u��$o��l��LS7U����z����K��~��H�|Lu�Ҁ^)4�Փq��E���
�(�&�Z���E��Y���Q�ǽ��[�X^�s�]rAs�j��1��wk�Psa	��k=��g�ȭ�3� �Ϗ���]�Wۿn�����)7��-s�\ "w$�M>R�2�fp�y�����4oE��8p2�OBFM���fA��b���Fi�;(+�܊,��<�6Yq��$g�8
#jW_��Ky�nx�C"�:�FͣgkZ.�yԴqX�'H�4�)k�X��䤒GsC�vR��`�m�YL�����ӱ��)U+�$�����̥s�,�Gg�����;�V�>��<J�r��tA���՚��o�Ω�K�?�*��m-��><O3w+�A����]%ϓ �����%(ۧ��$0M�$8��RH�wꛕ{�YV`&�%�Om)�����N1��o��5��t���J��Lo�˒�ě���qBGBF���2��A��w�6e %`���yʔ�<e�g3^���j9�nY�o�����Z8�8��'t7
��&�N��F���b�����)�L�r���\�mLqm�HS�a˞��<%�w�`)s�d��Y�5�P�몱��w���\����TI����` ��i�e�	�E4�R��Vr�Jv�V�N��-+nK{�o��Rg黑ٴ_J�ci{0�K@���FJU�B��6tz��A�_;PgڄD)�b	,x���9��\Y���F9坝�tf?�%'�gMyח��g.�Hv�S��I��(������o_���h#MǷ�MK.��9 �����5o-�����	T<�E9�m��xZi�/��E6�O�[��"3^�1W����2�Uhޟ�"A2���QO�X%ҭ�BV��ͭ#z�զ�E$��sz1��j�Y� G��P^��h/���a���ryq��B-6�>��kzϤ�y�����J�e�� t�
t���PB ~ρ%�=w��Q���A�	N��o8М�QW�,�����]�����r���b�x^���y�s�<�lO�
<��L
"׏t-\�������g�΅�B�d3r��J��x�\V��W4��PB�ԎZ�Dd��vE.�-���ϻ�\ɮ7��Ԋ��
0�.��仲p�!*yqC�����ǁgwNA�h�0-h�*0�s,lj�@�e��i�t�����\�F��W��n{[њ��p�|��݉۠�wX��]���v�y	i`i��C����(���={��N��A��7�M�]_n:��$^WO�b��S���O�˅�R�1�!Nmir���`�.��i�2�A���>�m-[��{j��;s�_s���������g��(εI`O+�s��!�>��l(P��w��4���9㽳9����_falsV��m��
yd*���x�V&�FM��ϻ���?�r��Vں�ְ��`���a;&��0,�7��`e?�	�RX,k>�b���I����8���e�u����?�)Jv4�/O��(�k5���p�C��ӅQ�yOS�w�:M������ȮEcȋ��r)�2�TsT��"˲6�Z%����Tp��;����-���p��`�0��/������ּ��ut��p�a�3�� P���%��juʠ�%�VxJ �|/���O�����;X_��-@X�-E�_kЗK��H�^&�eL�}N��x7;jJ�����L*�N�����nt�����VIm�/��Кc&�>*s�˃r�V�����_a�E�xÀi�׌U��х���=�<H4:S�����"xa�Ώhw��L�nr˛��ļ	��Wy��f�ԁ��-{I>n>�>�t�*,&̃�V9��睞rz;A�>ђ"夓JQD����m�)	=!��-&��4�jc�۬&|��x\�:���0c�ށ�g�v#O�S)=&�{A�F����ʙ�w�N-�U�z�r��th�NZZ���di��v�C��U�v� u���A�`à!ǖד��|O�)�$خ�_����š�X��S�
V�D�[Y��8[)`�m*����ʵJJ���m�l��*z��癿��@�Y�N��0����O�,-�"��[���YuSyjd�ix��T�@�!Ė&4M-cw�4o�N��Ne^C���0�'%|��J�w"�-��m�/!�`Es��`��&��k�I���S3��wSh��7}�Q���1�~�j�+�'��1M�����H8:ui�Б�E�+�˼jK6p���0[�gs%>���P.�z�-�<����^[��P'QE��w�w*�������uNY?Y��fo����e�~&��@k��OQ=�q�-��j�B�0�5�������nLLi���)�R    ��}"k�B�:�#�����䕖�N *B�:�1ƽ'bL���_�� tZÃw$����Ĕ�đ�b�ەX��¢~~�V��t�S)��V�����P}_I���_��X0���~��9){M������
� ��z��*�ir�`q�գ1�HH��)D�O��Jk�������:S��'�|��è��q�V&1I�`���٧������c�=�2��B����nK5������1د�Ȇ)R���Z�eGU�K�~� ����!��w
���MG����SY�kn[Â��V��|�|����I*�L��r�}J{�J�i�SL����������qL�l�h	<E_Yx���U�I�����9�J�����)�{�����|��z&��M�s^v3)$ͥi��є�g�K�e,
z%�k��S�J$�g�˾�Y�!�<Fw�ȝ(��*��/��="Ga���Hb��o�-�,B���T��QK��F�;�
?sg�������{��������B�FC�u	�8��s]`JP�5�=���	�Vw���S&���?b����L	��3��!��s����m�X�~���9]4������w�m�Pmy�໖�v:�DU�7~xzQ2N �l� rA25*-���?��]E/����I~e*� A���C��_�M����T' ����fT��D6e�6nz�_���CcJ�!���x�F��'oh��'j/n�Q{N��GK���H��
2��c�׵(@�e������E�HMP��'��<��+��J�Gk��/vf��   MO��ej=&n��蒧���0US1��s���K��ľ�&{�&n;�c�FI��,�^y��	4����p[�_P��H��=���i_����b�8�&���|[��B{��0����>0���jSB����$��"�����n)�h�CM������7S��qR�~����{8&D=����SN|�s��u�E���yS�/��YL�<�K�����{�8���iR�x0�n&����+�
z*�M�u�/��'��4��0��V<�W#�ӚeYw��������.Wc-e��򦝣��sl lQ�+�r�RUIV�HPnm>w���f�}a__��N]�yY3���/�I��w+���ҟ?���UܘK�D�q�.8��/�����Al�k�0�Y��9�8;߸�3��I�-�����s^ Wr�E|��rw�
`R��?�,帧O�#/6�K�+�7��Ml�&=,�-j�\(0��҅p���Q[��~ڭP� j��s�%O˙f&��e�d�@E-I'��3��/�<N�8Gy�����d.��@��o���&`T���r��M,Z�N�SkNS�&'�'�$�#m�����L�O���K��>Xb�Ǘ��#��v[ky��D�p̧D)�F��O��O��8CO=~�fn�$H�����T�`Zx[��{>�a��zN3���@�ц��(�T��\��� $Q����7��x`dm���ztn�F���Q��Oc���I���4־D��V�� �8�>#�$�t�H��:z�%1�������R��7$^ʿ�*!y2#}M&�Yn'ߨ�߽K�",�=�2��*4�~�h�Y��9�d�;/���MJ�9h���y[�J�5hŲd]�"��ӽ%E��"�B��(�|���Y%��ì'}۳&FL(��}�z�D{��up�S?߆��@ ���l}_�I�O/Q�׌���a�����I�tY;Zf]��un	�����v��IT;�r���4vnjռzl��z+����	����(>R>9�v�I?�St!ly�����R(\�@?X>�{N�#�!C#��]��FNr�$�B�-J�=B�$5�z���7D6b�.���!������g�X�眈:�T�)K��b���p�!u�r1�6��@�*{:��(�b�IN
�ˇ>�9T���:I�j�\(#�>�G��g���nJ�>A6׼�F=��%А?�&W��k��L�3ȲEQ\p�'���.��N�M���O�`i=�o���Z���YW!5
�F�3���{��K�>ms�x1�N�L%:�D�������(�!gL��\�a��%>���B�IF�9�ѯ���Ã�kY�;9rZ� `��L���4]D�0F]�2����})ٶ��(	�/�;"��4��y�4���J��+�$�d%��{��Ln�k̻_��Ej�J��y��r]9�i˟��1�
��+�\�Inc.��ԩt
`�މT�ڥ�y�e��0�oe��$9m�dR��r��q��ϛ#��/ϜiS
BfO1�û�Wʶ�7;��NIl |P�I��uJºs_�v �\�;I�g.(��;B����l�����wM���ȧ�k��K>�:��<�;�:�L����o/�L�����n��oq����i�	sN��yS	[�B�!}ͻ�R�	��B0P���^��o�6�Ť|퇀x����[�^]���������D�pli�����|�6exs��)��p"?�5~;9���9������۱3�I!�.r�t��,Q�]%kF�ɵF���B�p��1&����Q'����,�����4���WrM��F�V��!Xm� �L<X�n�Sc�1V�քD��){K��Z
�)ՖG�<Z�eL���즐G{+�d�z94��`~�Ĺ<� ����q��z[�O��g�,����
CMy�vI�j��e�[ӾЁ�L��zM�_|m�l䝆?/���v�_%p4n5ߌ��[/�j'sƋ�ד�^�FnI��Uü�%� �vrE�B����9���󊾀2/z����B��6�i�������}���(z��U1�*�����<I����r�F����P���>,/4���24>Adf� ��U&u���>��]�^NL�d^��L���P��5�� ��u�}��q��J�k=O/VP������54d�W��Kg�\��b�(��$�=���y��s��B'}���^�츝�5:�Qi{1���f&����Q����xՖÐb�Sz��&a��4L��MƲ��<4��F�%g%^z�<��!���33S&�ІG�x�uË�	�@�/WC�Շ=khA���X��Q�G��P�Ab7vm���U���:���＀$�=�5T'x��{���N�Ry�+^Se|�s/����|ϑ�g����nf�i��F(�?�qSr&�R'ŕ��F��x��IM��{v��p�u#-v���M�">T��8ϛ�¼�,���Z��GˡK��UG��a��#r�Xω�b{��} �;}��.��Fp��I�&`W �t$&i󊎣\UO#\*�s�C2
;��F�P�;����[�t�_
/*��7xn��t���Zŕk��az��+Rj�Ĺ��a�E�����OY���o*�<[+D�������?1ç�xo
 k�4ܻC ���V��|�*%����?8�J`~���K^�d�I\�)i�&k�M�Iٓ���I\�"���s�͟���Ҙ'�.@�ƾ3�~ T#*����V%q�H
�	��r"2v"V�F�~&j�gm_`O�l~�n5LP�'���7����B�(�/I�R�X+����S���
�� ���}A2���MB�u�߽i<��&�9�����y�Ty/m�:U�E�����^,@^%J#�J<���n��i���ͺa��ŝp/W�A��y�c��Y^���,z���CUd��
'=�j�:�(������	H��f����#:���޼@� y�����Yx�tF��P~�$�%�3�EM�.�c��tS��-�5�4�$z��D�\١2M�s\�`V�۩P��9�o6�Vؘ$=��O�)���>�M�Ѥ�i�7�JB,ܧ���� �S�[��g�tLf}��|/k���З����<d�U�H�������$×�_d:�D}KH��(�4֒�����#������r�u'����$�!|�vs�Ռ�$#��c�D�nX���#L�ǩ!z�2vF� ���٩�K�R��z��������}y�E_Ze#MꔈB,���K�~u�M$�(BjI�a���#���h-PͩK��ꖷ%L    ���9�o)�RY�eΎM�g5����KV;7�Gk>VC�� �o�Ї�F���'j�%�5W �H�% }'��k���&^�@J��B��X�\s+����	����r�P��4�gĺb"��B}2�SG���[Ն<f!	g�ԑmS*m��v�7�Jj+���[�Δ�v_3�Yz�}�y)�럎�{y>�8V���9s9��G2#��}VD����E*��^X�]�
��դ.����A�/=���el��%�u�t�g��\!N��!��J/F���J�d=?����P����lk��2:矁��:#^$�\�B�*�ξ�b�D� ��$��1�裬nr��k
O?�,&	�`W�j�D���{f)�a�+vA�Ʀ%y��Λ�.�JX�;���h�J�V%�|F��m�g�@��5��	|.,v�C��4��iЂ�o��[��cB)�*x㷦g�-�9�M�`M� X�f�C�:�G���t-��;�o�?a�Ă[����SB���N�Ec��fs�a��n���%v��D �%��L�L����;P_���C�e��r��r[����j˵�?3i�S�]�A�ܹ	"�iK�O��$h�.-6(�҃�E��tf+�.Y����n�M���}P>�WuNs{�f�~]���ruOZ�䳖f
Z��XN�j�C@��x�&(w4�/�6G�f'^$�밹Kە8�pl}�/�GL�6$Zy��N#�Dn�yO�i��[�Z�.-Ǘ��I�^�z���ʫ�	s?����|��=�'��	�K���	����K����+5ZΏ�*�NZ����FX��s�vi�����H�54S��ND���jEN����;E��N:���Y��D��%ʷ��%�غ��������\{����u+���臷��~�N�����+�ֺN�����$G�  9��=	��ؠזʽk�J5����)H��/$�٣�UQ)�d�,S1g��3ÍBF��+��8O3�$=����:��e��>�HE�g����y�%L��ATV�� IdI�u�;vx.�.���Ɯ.:��c�wtNE{W6�P`awSt�#|˅��aڞ��9�	�!׸$:t�R�x��(f�վx�1S &k�)���ײn����x��+���)[��蹧��t)�O�f6��ߛ�|҄.kB((͑7��ۧ��T$�o��$$?���I�	�W1��A��k��b�jQ��X���&�B��T�)���˅�B�{6�d��!\F��[`Y=`C?�y��w[w��I�?�ׁ߸���5����A�R�_��XԒ�(%��D���a�>��w�EM��B->��TQ���9��<�%��N�(l�Ȣ7=�R��{X�s��LS�f{!����)�9�C`�z��5 2�}ai	�@9����Ȗc�p�=���"�Z1��k��U����,���*V��L�Cq�F��	��wN����E�;�K�=�j()@�_7GAB&��@��(4u2/��i���\T����=Tn��r\�l�oRJ����S�%g� ���Bl�1U�vv��`L
�JB�Ir�0�k �#�������Ѧ�AG˻$�@$�H�I��\��dÓW�z� ������MM��w.�	��+�o�gz���G�� �ڭ�2EO�I�RC��N��̸�agϒK��xW���C�'��[�&��D_�~ūM&��InU#�D�����A;����O�q�ۤ��>�w[�ʒ�~gz��}b�ڂ�\����V��)��G�_W�EW&B)�ƅ��bF�b���XCۦ(�W����N,K�?�;��<�U�.�.�,�*��/-��	{Q����$g��{�r�N�H�~�Io�+���Ώ��	�f��}��P,#�"C�j=�፲���j��0!(}��t��^�i ��k�I�_��3�v,̍��ê��P_~<֔���*��3��Mgj=p����JKxM��k����;!��F���[0]�]�G�.ws#�����k��/o�nR���7U��$�y6!�üt:z�����:��?^��L@>t�����3һ��?��|�(Pb���4���4	*�k�g��묍)���^w6�Y�5�YU}��Fv;�"���$M�>3�2��p'Hԟn���{�u`��z'�d��Dc��}u�(��)<���Pp���0�'�o��J��`.��(,ARɘ�\����,�M�˛Z}ʱ ���������!�����(s�N2� ���<�` 2�sh����]���c\^~�r��JO=}��+	�1�@�L
��R)�G�&�I9_�jN*I���N7�����S!�sn�A�I��/%q?�c���`tt�?|�Ѧ<��Z	2�~��������� ����4"6�b����u��%u�HUh��	;gi�����������s��_��=qpr�{�4�I����S��|W��DꝮ	�
T;����
�����4�>x':�B'���o%U�x���>�K,I1��\s6+����C'sJ�mi���UO��%� �aBע�|�)緥��ݻ����69�i5G.x� e8��bo����q���R�������gc���thY�i<G��J��F����"i߼˻�~���6P���]�	F�\��xR��v��y_B-p�DF-��#s�o5�^S���\�nkf���C0��M���ڕq�nQ�\�.8#Ik�I��Q��a����
�.��e
������VX�֗�~�e}q��P �<���� ��C�a���}<�g)4�8��C��%��~\�9�)�x�� ��/،�i��T�ODx�{��5Q�ON3�q�Z��zly����2��D0#�~���y6d��꼡�[+V]�f�U�����p���H�iY���7�ԕs��s���1k�Ss�	��7n�\e�b�;8w�D������]��]�Y���wϱ5G�0\��4-��ta柰t(�����&��j_�^��B6p�
�VHdz6�j�0H��z+k_|������h��H�6YS1A��"u�[��7�J�����*����d��dM������H�*@�*r~���Ԫ�v��C��E������lί;�i�-��]��y%T����2yZus+�@��F�t������&M�Mu�@p�5��1�J��
�ː�|V�����T��u-�=���f)����ĵ)�����
��M�|s�:�e)���m}�/"��r|@�����N�s1��_r�d��˗��$2�6-rQ�Y¤W��؋�b�hk�:����1>�_@�R�#�(���W�[p�P��~N)�hf�4a��ɱO����
��zqJ�Z����~��R#`\����8��vo���)�۰�� �^.�)�%Cߕ�q�7�~O��.�����oT(����ϩ~���@꼧Am��6�gJ��Jl�뜽Ӭg����m3`DԒ`ƠqL�C�F�I(�����2�)eM꽄"���gz�(8�[Hy6{��yEc�5rԠ)�۲�|��7E���]�	�ͪ`�Vayg�Q���|ꋀs�i8v6��Y�5+�I,'6����f���t.�i��@���Z���h)��q�1 o��ύ�[��-a����b�;O�����A��yU�y����WӖ�����8�����fT�[�װ��vC����Q,g#*5R�Q�{����������l�ى�w�ӹE��h"z��i��A���V��O�:E&,0�Q� �	��1o��_po�|Sp��BpHT-�]u��_$��<Yv1/%���*n�6-�!�;��H�?I�Ƀ�N����-��{�;��v�������@�9�F��D|PmIt��R�0��)�U��1GB�Yh��D�@a���(]��{��c�'@�{5�-�u_���q<��%	cU�|7h�^�*Lۏ��b4THM̫��[v����<a~�y��繋$��
�IA���C��1�\V��`5h�S3�4��{#cB&�y�q�' �=��O��}��#�`�b������]��ȹ�Pt�)<��b���Zp����[�W'�0*j��%$��VB*���^M�vD�O2���5_[�m*�N��f    �D�#O]��K�`ї������h�4w�z4�^>h@�� ��&Tw��Qj���5O��ldJ�CMiX'n�8��Z��LE�Q�%}s��i6�-�5P��2�vR�F?)��\���v�������LT��D#�14�S/M�24s_y�Y�`��͢F�/�"Iŕ�a"�+%:�X,�9�ӮM�Nb��v��Iӧ����;7�s)��99&���@g��?jw���D(Й��"+�#׮>"TH��|��Hу�.O�,�߇�{�t��PR�A��;����*��R_ႚ�s�.���dW����!����y��:=�?W���o�8��_|tR:�f���on.wZ���I4�v���TF2����Ď)Y�y�?��<X�_i[�/��sv��t�fu���8����M� ek�����U��`)��w����"�Z��J�u�K�k�xB�]kY#�/� ���Ǜt�|?h�ƼdL�X��_.�Q�Fm�k��ү^�(ř��ي����j�R$~Ao��Q�gKq�X�s�
����ymИ宜�p��Ӹ!�p� p6S��C,�\<ib�[Y�a�o���=�c?3rß�OWRg�yYg>�y_'��N�#2�w��}>Qo�1��=��";�ӽM���ɞ�=��������+���!e%�j[fz���Œ��JSwT8Z�-�b-p>�)�wmSNF�;�f��	Cn_��4��wP�4�_��v%��7�fS�|��VDj��b�yp�y2�*�A-��hK������I��b�T���y�ER���1��G�*��nDpE�ɏ͓�)1S<�b�#��X&K;���
<�7�ԯL��E@4 gR�m�ƃ���e4<�5��')�Z�����V�B����$����a�l�S��������5��l��
ҍ�Ve\���y2r�Vz'^;��̛���D��:ݑ��ǵ\���5�v�~�oYv�0��7ܞ���U��U�ϹHWWV�x�+��2�N1���ݯ��������'��5��v�8��H=�Bō����^*�J�3��`	ȵ�Z�9������=y(�<B�}K��Ò��O��!K�؄���i[Cb�sE��
j:���=�J._�ŷ�@9i?W}?��6�]���N�jz['|7ˁ�����YS���X�X��Ҝ�9N+�9��jͫ,���g��X���+!Q�
�$Hj*ђ�\ZN��x�֕0:�:��O�*���i�<��a��QD���g�;`�wK3��uOy&O�G��!���A�r�޳���8�^�U����y���e-8��Z��ϛ�<̄�CJ3�[�D����滤���~�[���WA��eJ���N�[�eR<��O�d�)�o�C14�#��T��xUk�'ť�ǧ��0��599y������)M-%s;r$Y�I6�#����~4�p�;ϯ ��S�|N$�h�����D̗�$�߄�y�O:J��6S_�Q�)ڐ�O(������K
���y:��:�f�^�����ڑ��bb$�JP�-��N�k�eKU�q�^b����Jd.���L������������g�*Et�k ��,��h_&syO	�i��&�̦<�=���n��Hkc=�^��<%��.(��0��vBs�o�9!�w,��\��p>/ʻ��'?#�0?�m1'	��;r/��c��ủ�,v^���{u����	��-E�7��أ�-���T�X�����|-.�yo�3����1ǅ�6���Dt~E��^�ndw��$�rmv,l��*�k��*��G�K���QW�ծp0@C�dS#R���C�|��\�3���m��] ��^���es
��3���
Ĕ^��&�U�R�t1K�2`:�JS5t�D���|d���._��lu�H��x��;�'tS�5��.�c���2��m�͟wh�˶XW��t,�8��Z���<��a@�^���-EL��Ug�F��ti�1��%»�Y9)���FF�_�/��vO�20I��܈���e�	tp��u\������:ת���v�{�g�����t�)CS=��!2�Z����_|����t'�����z���6�%���}�G�ͅ}-A
���=�ʒ�9��mc*S
����Y=v[�p=��!��r�%M����ȭe9���&�f�i����4c�|V�}���"7�.#�<�7�;.��/+�u�����$�
;�5���	oC�&�_��	��e^\~�%	�@�/w&^(EC��6Ο�iu�k�l�_��<�/�0.}~�4� �w�$���~Z�4�J�-� �O,5S�_6,��]���
��H�'1|M	};.���x�����1U ��R$�I�4މ|�z�VKr�IT�x���H�g�B�q^�(`�K����7&���AX�RK��1lI��ye:XH�����xSa�P����jf���jWfT������C�V����=�>Mi�2&�O7����N�F�D;y%��񰘙�A�* �`|O�I~�f�p�<��K���Ř�p����I�}�z�"mj�b/6O�'P��T�s��J���"s�t
���0�0�̕Zy��PWߚ�Acy�<:6A��S�ea��t�zHc�r��Cf�Kn��zgs�ֽ$����B�I'cR�i�'�f�n��<�/	j�o5�Đ�����o�	�cy]��H��ό���=>��hM˼<_Տ&����H ǖ��R��΋-%}J��}q)rI=��@�s���f�L�2��K��UC��?y�@,97�� 6)&���*�&�l8FCe-��wk#���IR+)3d�|�����5L�]�z�O~�lS�ٗ܏9G2�4c#���>�4��UM�7j�@�.}��ճ����t�F�xMK�ԛ�G�`Q����T�):�Mp��Ǫ>��	� ��e ��%��2��!+��y�z�:�=�E�������J�g?S�&��6.�)kMh��zj)�c{J	n�oJ��P�0�f�rl�O�t��d�|���ܺR�j?��g�	8���&��N��t^���k��F����7$O�����m��//�1�H9v9��q��5��>��j��$���!����']�.1���0m�Z���䒚|���[Vz��v��]���>G�,���w䖷Q��ʯu�L�tOu���v˙3�wb�[�r����-e�����4]Np�D*�qw��ʋ��}��4g �;/�Dkgn�-�#CP2R.�ہm��q�Z�!��V�S"�E5ik.��	���T�jpR+pM��J�\���^yg|i!4��[���k05��&����ֈ2$wiJ��r�&>�o���GަH�>����C�-^>���S��+�L����L��2�'-���ȵN_ul<����ި�a5���̭B�O#�����UEA1�7����g�w�'f��Vo��U��з�IߟK����_+�m��m��I�*֎��~���C�8�%A�f�GU�v��ձI��՘ڔ0�7Ռ���r���o���:OQ|��Ĝ��mEk�iMR��BR.Yh�����D
���s�a;��#�Pʱ���R���k���r&���|��V`���M�������ၒR�<�`����^��)Tn� A.?,uzKenV7��ZN����Ҫ-�)��,��g����s=�a8y�G��c�����]�3_ʖ��0��'���Fr,M�~����ӱ�qd����#�Ky�|V��<z,6�����N� ɶ�1���	�&�`;����5ɠZ�h��������]��_Р<3��/B�IVGa��� 
7X��ݛ����[0�P�lq����y+��Bf�{�|��װl^�ƒ�4��|+��%��=�<-�S�i0��V���J/!�/煣�,R��tD�O9k���֞�����݉�L|,�,{�͵�j	2�������Ǟ+
��c���.Ȩ�RumI�gm~R�Ը�v��-jz����4�xP�i��f�oq��o��V��H�}>į��_C$J9��J����w���G��T�t4��Y��~����    K�g��v��Z�d��ژm�H����c?��c�~﷓8�*s�$.�tI��W�yTh�ӌgu��Gj�}�g�H�ؗd$� ����x��=b�
�6�wJ�Ig�Gd'u�s���j���
D���L=7'OS&_)!��d��"�t^(�}m����G�ʰ�3��m&�7�*�,���|�����0��5)��;�C@�6�H���bƲV=��%{�-si����/hY�v��)���`���9���R���W�w2p�-�!h6啀�����x��V�f���b�P��&K]�ȵ��s:O���F�w��{��\���P�T�W��u���ǡ$�tfR�6���F<9�%�u_�˽��]�>X̦-���3�gK�u��[wv~7�sC>j�]��M�d��se��OS���oF��7�����|q;��#eP��).J �fݚ��*B~��K�X��h�sJ��Y��Q��H�lY�I�쉈=�l���~���`b�L[	t\
��~��6���� ��R�Ui=E�(���/[�MZᳲ0\)��vH���m;x9�}�����X�"	Q�����$)��%M?F���0>�?��J�A~��ճ�eK�ģqw�L�M����dݫ���\���(RP���y=rn�ъ�gR�C`Wep��K��t��t.���9f�w����������|�i9�w��O�itH ���>��r��}z�XV`��5=��ةn��Lo	퓔T�j�\�l�������ߌ�컰~?Yz-�:3�� ��`��Ir�맚񔯦�z�>�y�@O�����a+T�5+]yWy�9��BO���Cn�� ,���W�^+8T0�����ق�.c�3��6�Q�HB(^���T��y������_Ka�����牉\�O��;�{�>�M�q���ui�ؙ!����/�5�/�>m���ZX.� 1h�^�ӗ才���X}�f���h ~�{/��� ʩ*���A��ĳґX�2س��=��M|�)t$�ML����#�E�1��3Ɓ�����{Ru/���X����!�0Q���H|@r�Sbv{�9���f���ChR30'),��V��
�#3�/H��M��h3'��K�R8Lݮ�$�H #�M����6V*��#�.���Z��Í��q�K����N��R.a�o�egp)GS�,v�ofsq�"F�F�4W$e��Yko�oJ��c'��*&�4��>���!t��1���nich��(���ݖ��`���1MN!�e�GGVM��`{h��k]�u���T�-�ߵ�@z��H�U*��}���}��$����JgN��ʏ�7�<�S�lhgo7�w4.[�_g����g[r����.K���Q�W��l��1z_����ݹ�6!(G��l ������������W��/y��_��r��D�\:�(W��#�؝'��I�}��ei�u2
/9�4�i�:[��<��f�9�d>M�SNK�DV�4˖L������sQ����"7*X��h����fY(�"El�.�� P`��p	���Qf`)�n�Ԓ���I\Ĥ����gʯ�Ȫ��@M~C2�n�Ӄ/f�A-:-��d	Y��O�����߉�b�k*��mړ\;MIh�=�'nZ#G>K-˯�d)Vv����,���a1��1)d������9/��䚢�=�f�b�B2�^�4w5jy��3��S����r�M;����g���w:n����u��R���.�M��
+����&�w�BfՁ���֗@�Y��d�ǗG��q�����F��,�r��D2�;���[�O<_x�A�vׅ�P�5k�s-QPS�ܗ��zӮE��]�&��LBS�pW-��$��9&>�S#�7����A���E��E+M�b��n���.8?7�dGA�}d��D�r�R%�F��E��DV���捺^Z�]ם�m^,�p��l�W�����$�`9`G��d��Gu3����R���ն�@ъ@!�s�BF��L�'G��+ޖ�l8o���[�X�-%Yg��O��}"*�F]�|e��J+����
�ٹD�{ɱm��	������~���K{/��䣛9��K^�մ~)Q��8~Dy�F{��X�g~�o+a��w�S捨�_��N ������yo�J�s���D��t�K���ϣ�����ԡν�?�����1��]g�F0�+Ų�t����!�����o��uж)����k��+3�c�������%iOP�?{!�E䖤�Γ��T��n�k��$5n��zYA���C�JX���q{\8\*�4��a2$\Y��h���zʛ�y��g�m��r�ҍ}�y�����Ek�P�L�^T���qD��������rD�wD�!�����B�����v����.� ���v��Yx�cӷ��s�������͠qK�4f?���E�oR��3���>,US�F~j��2!�V���8:��>�����t�9r��q�S�j'�j�I4o��X�
Ӡ&� `em�62���L��H�I��!�TC�Sk�|0;"@Z��;������M\��4v�	���Z��X[ۖ"<Q=�EqW-9�{��گ�d}��j�KNۇ��KE�9\�	�n޻ 3꘧�"�{��4�j̀8��V	���]�5��tcFr+�A�)p7�	ef�cnڔH��b;��R��2<�N�3Oj�~���~�q_/����hi���fr_�k�g=�{��&^״#���z)����3)��q$���^V멣�<`�V�6H
�Z)˪�� ��A�D0���҃�zH�QV;�8*�`�8�~�J!ޫL��ܶ2:HY�IZr��։�l�Y{u��ܵ��{-���U:���YI�g�<��LO�n�Wl���<gg?�Oݖ�9�{U�}���T:�|��R��S���I[Ӌ�\����RӷTC̹e��9$hR�٩�6\�΂����g�h�d�uq70~��Q��|R��`0�lr P�6[y` ��|pܫ�1Dc/i��L���q*	rF��&�2��X�%6IǊS�r)2�{�֤�x��Xx �%NMw� Pe�f�y¨B+�O]'3����5�E������tMς�|����Ò:��Z���'g+�A��=_a�t�s�}B]��am�N��&�1���u�0Mb'!�F-)z-�j�/�E�Өh9������g���R��Q�s_s٘����d9�إ��p���6`���%�V���Y��Y��YfCJs��PYN���b��� ���9�i�S��k8�C�~'C-�5�8���QA��I�^=;в@1e7��F7���,4֝���q�����)��RB7m�i&�ˑ��)ʸ&�3��`ic"����Q"&2i����ﷴ�T���|��$1�<K�s�Mqӧ��dgЖ�B�c���M'K���K?Y�p�J�<3 �Scb��>�<ma�l��0m��t�\k��L�a�I�Mv�3O�Ny���"#�Z�r����]���V�lc3�	I���5�2�@�/TJ�R�|)�E��x�IjF����>�N�4
}�:N��b�k��+BI��)����C�[�4�{�B3�M���M-�,�ۂ:����s�>ڴ�4m"k?-��g	u]������7�D�����P�-�J6e-;��*:�*�cp��͔6R��NY��o���J�{���|��:/�ؤ΀�����ގ/�xM�k�H4FV�NQ���N-h�Օ�C�m�r�[Y.�G��Ղ�|�s�j�i���!{C3X��B!V�	���%'�$Z�������d"�|�H�B�!FbyN�񧮰�+?쭆�?�F��=���hp�S�.ЙR�,[��Vb�����G�]w��<�^�fBY� >N��5��r�Ձ_n真��'~�p^�S|#��:(�.T�0@{�Mb��y8�O·Xe],Lm⨢<��iK��GbNM#gހ�$���M�6Ȥ�s��:�o�Jy7�q���c�`j���G�;�P������,3CVK���p�qǶ潤z��e�I�3z ��o0�������L�-�[Z<���U��3�@�.�򭌦���N��3    ���g�B�`�N�z���kea���[lpQ��W4�<��E���1P�lE(�����y��L�Ϸ�_=�!������+��Ls��g�t�/=��L�r��3?p1s��+�^���MS�L�����~�㿦5�Sq,_�ٔ ~�s���R[�c��@�W
��$��;.��C�h��ݻ"X����$U6L�J`B�n9�NL���0�qȁ�:���d1/7s��M?�R}�v�A�{)!���ʝ1!���]��!te�#�^��OST�Jq�ҁХNY����d���|_�]���w�r>�_9����ݠ�6�G����J�%�o�ߓ>2_p��|&:�S_Ro�Jk�HH� �p�J��Ag1�>����D�u���$
1���[;M_
k��N�s��MW��oy��:b��/�R���q��ʢ��I0S
�|�fs���af:��4���c�htp[L�
���L�5�%h~%F�q�g@*3�n�e^��-p��8��j�U���	��q��|O�;,y��v��%�dHǱ`�ɞg���R ��SN�V|Q����WK�wA]}M�n5�B.ǟ�ȅ��<��^삔���r��P���ڍ��ckhJ�S�-6>	�����𩬗P�K��7M��]�Dk
j�}�OyI��^ڼH���+c��{+��
˒�
�sgѾ�J��4��/��5��Pd�A��e�!_�-KE��2m�sb?��XF&�NYyMd��I�ѸZ����S�P�|��7� �u)s�b��UY����SL�xr蠟���ޏ��Sz-"+\Z�����/4��B����L-Ĉ�M`HЁ�PR��M�rS�"����P�| Rz���kc�6R��q�{�-�i�q}���9�n�j	LF�f(����=��fdc�pR)ZW�yr\�%����Y�`�c�A�w�r���I�Ee�+ cT�/��F��T�����'܌<�����V<(=ѓ��(�;ɗ�t�\n)����t=3��=:���ژʥ�7qfA�n���S��Ͳ�u��%X _l��Z�x�6��մ��_�2�w�J*�b@���$����sv\d=�(ERޚ$����(�B�6^tz�R�͛����4Bw��^�) u!>�Rӕ�9?��Ę�?������ӻ쿘�'���+YkL���κ�����x�1P��w�p�~݋ȼ,��D5�]7@���(a'�q0
N��sft��DNùo���am�f9�W��=�8Y����@��e��e�Cԁzs��K��o�KU&?}�*�Ύ���NnY���&Ӫ|`D�&=�S1�Hò��j�x����2��#$�L�I�2n9���˴�(��K7�#֛ד��Ώ�'�Ƌ�Bz��VV���m�G ��}O�X5���j[!>��$���+�;H41:��i��T��	���\k7"P�k.��떄�������4iL��Ӵÿ.f�[5��	�e��e:�$�b���C�x�I!'.J�����2J^K~
U<�-ў����f,&��f[��4ż��
�YK�L.�$��y�]5ɍ���xƼ�U5IH�EŕB/���QN�?%�{;����9���[ٟR�E�%lJ�4���]S���Uv�
!�?(�Qb�Đ�7��jN:z_�3��Ϻ�W�`/s�����8��maN�Y�t�9]��pdM�M�\��|�#���GK���b�*iwH��+/gZ�tws��P�$�&f@�A.�y|�7�~i*�ӵҵ��.���g�R�^���ic�O�{_��fn������VH����d.J:�Ny'�@b�C��E}�T��m�y�;��@�pZ�	�m���R2E�aʘz%���?��V��P7k�<�C��:gY�a��w�ثz�\`�d��h��K-ON%R���fO���\UJ��Pӳ���+m�1i�Z�	��ei�|ɮ/����R�fm�}���@�����>y��_ ��d���E�";[H�_3	�=([�1ΊI�u��Ewh	��L�/�'[HZ��d=��#?�-���H~�1x�h�|�x�R�o&|��-&8��.Z�@�+���[ϻ���
K���ԏ��E�<�W!�^�=C����1ZB�K�
�v6�PL|��8^�<������$��=J��%��W&�V4{�N� 4���l}L�=�Oez�Iw�p���ɪ&�dڸR��{�٢	�"���6Q�\�f����\�s�)X�%�	"c�dzmG����o ̤�Yi)���G}z-�%��t!+ZA��'�e�]^�%�k=�&�������F�g��z�|K��ߖ� �����xS�-�w�Y���
�>�Բ��ױ9�wJ~s�b?��Yr�
"7 !�����)]��� ��q�"�W���ֻ��������b��Y:0�*�~�6��IG��/o;l�&$1C}_2����%6sx�洏C�1�+�W�T�~ƞ�P6e`N����U�Q�A�=������gQca-�b�ً�q�o�����	;8!�f<�d�~&��\&�s��S���m)��������qv'�jw�<)�3�U$��A57��w�Wɥ�)���Aݼ���Q�e�o��c�=]���e��/f�2U�4��9��_3�`4(��6!yLx��	ˬ�Oc�`;���b�_P
�z]�8u�3U��?��'�)6+M k�*����4w+�şu�`�С�v~��d��XZ�N4��bSY~�i���*��� ��E�����������m&[�Ҿ��H:���c�E������QJ��j�����>zgF�jkn�E��=�T++�p+��N�_�Y�K�L��{"`�ĕ'4jYx�5�g��vM�7�<�U���)�jHy��7��7�?MZ�k-��1-��3}I6Pt�,���z�_$�^�Koަl ~�E��D���^ҩ%��per�DE�)qӫ[��M��&2���=�Sl�����H��ع2�H�e��� �`����X+�_�i<�>g>^~lKK�v�>󄱁�}���D�ك�b*����6���1o)|j��ët-�-;�<��L/���9U���78���a��[� �f 	�C�<5�=��Mz#�s&��E` ��F��3m�K0�(�?�Z
h��I3����4�i{r/I�X�k�Is�ۄ��,Q�#.�I�Tn`+SQ/�i���F혓T��`�����+�=��I��Q�!�k	�>���mJ~ S��d���.�C����m�7�g��f��� ���eH�7�$��k���.lv`i=����9�~�7���lgs��?�����APQ���P�ߒ��TH<�K5�� /�Jb�PMX�ng����8>��i*G��mQ ��:�h�BD�N�;�#�d�ئkD|��ޖTK�"��? �g)n�M>KF��`\i��茲�v���
�x��,z�bM���h2 ��>C��ط�³5�wȞ���\��]��:��ᐆ^���N�N�g&�{���ó�˗���}ƕꄳ�)��vB���x�mn�}�q"+�ly'�u���4�*ޮ/?��Wn�θ1�m��[��Oj���i�(��zA�,�E�ٷ0�ѱ.G*&��u�^ �� 	�}�l�8�ؒ���U���s�������ȃ�4U��ǚ���X��P���h<�+j����R��d7����t�lTWt�ND������w�mvCgz�T���򲗽s��ہ~��|c{St�D���8���Nq�!ٽKLi�pSɝ.S8'����%��雥Ŝ��QT(t[>�k���s��I�ʵ��#3��?���~��"��UJV��W�ң�xR��
ȼ���p�*��T���t�����!�M�tNw�㈽KQk�d�q\����F��Ϡ��L��l��
�>�ނ�<���<3-��7S$W ��{��F�(Q�Z��j��3���c���y�{�#%�|�I�:�Fy�+6��'˅4h�[jE"/Ir_�*��vf��s�h*��4��\?�R�TL4|G"��*�g"׉~������j[GM����BN�
k3o^��9[+#�B��D�iS�V�k�2QK�u&X�ZB`    >�D�P�:�e�F1�B�N�$=�]���;�6�����gn���&�����;��-����&L<�����-���ۓ2���t���ic�yS�a?és�aR���O�� [h`��>��t�GiJA���Q���HJ�$��@�47=)*�+Jk�����v�<=���ؠ*9��/U���u_��.���/_�/#O�F����Cq6�5�H�o��s!����Ѧ]ֲ�M[�������z���������d�����06s�����*q�u�%0�M�\�=�����bc�`ɍ�HO�l��[{w�+I��x]�.�Gs_�=���������"  ZZH��\tw2�F�����3��P��'�r�&�$`
�u��K�1�f�FOʥO�y���P������z{��N3�D�|�H���;@r��Z2d�=T/��I�A���O	49	�6%P�CY��+��CM����[��2��R�Чz�$t�a��5Ou��7��:I o!��HU�s]��k&#�^K����5bZj���
?�!udw\��%�O(���D(��T�.�P=^�yH��'π�� ���r�hͧ�*��ɞ���!��~�3ӹ��\존��n��-
}�T������I0=�s�� �ys��$���~NZ(��<����7J��aE��17/�H���3�m~�Z��"����ĝ|	�Q~W6���I���Jh�(H� H�W�WX��]�lZ��
���"�?��̄�V�}^�E4t;�I0�����*

�����H�r�O�N�|���}��Rf��UF�5ɦd�g%~}�)�cp)�k�+�bx��7g���I�T�p&��#�H�>���u$�2�l�V��>��SrMU��~a�L�?5�S���[J�M�`���鑳V�֤myX�$��v4i��9������g�HvV(hh����W��ި���;��Di
�y���q�R�蟠x�lJ6����
�0��S��h���R��'Q�}MgNم&"Hδta�( O.q{��Ƽ���Y�Lwym)�� *�6���Ģ��q�M�N�[B' ~�Ow)L�4?K� �s��'�7�L
fS*�A��G�g��\L�v�c=�JE{��S7k�X9�o�ɼ᷺��n�qHK�zW���
��s�ҳ���[*�y:��<�s1�_+��S�&x�����vLKًʞrw�@u����c����U�����&=?��Z��-I�n^h�����n�w�U����:�J͞��������z�-]Y�}��v2^��t�v��{e��f
.�q�*��1�%��h�||�|�����_��]O7���/����Tvm?o!��Tw�?�g���j_0�Ǐ�Qm�F�A�g>h�p�F fM��wb+s����໗]ԕ���a����lk캒���~w���}M�0rI�ݸ�\�)2��e���\n���6���������ZtbC����K��R�B�\ƙ�:��"4�l��r&�P�~�u����O��D{t#!sa�D�LWV蔗DQ��o�=L!
�I����[�Du��
�� �:��,ξ�Nт'�D�!�!�PJ�f�;�B��2�ۧT����E����n������¨��#�����Rt_��uU$�f)�X�>�C�������Z�$��;_%���!��&�T=MV�~Q��v�º�^�c�_>6���%�;%�i���8�pBɳ���sq�>`H߷�n�9,A�:�r:1��|y�e���O���rp�8�tl��{��=�(uؓ����za����w��5����cM��)�TSv�7�_�-���M�.��{ٳ���*�#��b��*㙓{*4$<�p�R[�;� �#e�n���<�@�h�j~Rn�*�e,�m��f�L��0�K�R���ݐ6_�Je�����G�Lc�T�E�I��"��c�z�Sa�$���r�i3"*Rߥ4J�zj&�TŇ�'�T�x��s?B��1���n�k#��H�,+�T��C���_��)����	(
����"��X�R�נI�ʙT���ܻ )�畯��0I�ԛ!��N9>I��S�<WN`~}
�E��oK�?�1���j��]���{�?�FR=|��D�t�$p��}���BM9�+7��݀��<�;��%���x�b��jӅ��Y��㣦�`�3�����6�1º�ߞ)G��9'�e�\�6�
����[�-NTIE��>��7+ͫ̽L�4JGm#�����D��vÿ����9X&/�J�7�s��g�b���ʷo�=8ٸ�n'����_Go&"w�L1��;�S��x����
� ���\�ep��}[VF�9`�J������I[kr-=���w4��G��9{l��;��qW/:�^ڞ��M�X��q^�v�������*Ť7+�^س��ϒ��M�?��s�ϒ�V0�x�T�i5T�_�ޓ�x�7�N�|{]^��Y���.�ͥ�K��{�W����f2�J�C�bm�Z5��N`\2m߉g�����;Йu+�ԗo2�����_�ZS���M����t���=�-�̢4MK�^Щ���2{"|�ig60At?0A�-����El��R(ts���!�&7�' L����ދ�f��%�������^n4�Rkz����k�����9G�=�w�����E2�|�ֹ%�%�M��c��ǿ9;Q6`LCE��?oA�,H솮����a��΃Ίy�Y���8;��m+ѝS�)`�0�w�Y0�kҒ\#���Gc}ʌ=լ����F(�'Y�IV��W��ad#Pe������A��7gk����`�+��a q�k�O8��z�V�en�b;�ttl�ٽߌ1�x�ޒ�R7o9�O�I�P�\�'�ۛ�.��w�x�.Y�����?9�e�Y�W�?�*Dwڅ}����$�6�6�A������W�2�(�tq:&�K1��/��L����c*lhƳ����ɯqgQ�\��ͣ �
�T�Q��퇶�έ���ό�<AZ<'�� �s�N�ϥ��E
���]f�4�?y���|�ܙ�Y�>Cso�V�Z;�l���$�l���h=s�U�ؖj ��3�>)��ɬ�E�́&����x�IV���:���[ធRs>���N�s�}y�K�-����'��'��EW�!Y��c����^�6�r6S�����Ǽ$q�2�k��R'Zd�ͪzY�,q�w��17M�4=��\h΄��rr�7>/C�2	*b`<�V���1ފ11���}.�\b�y�=�n;�M<�M�z��Y�t�Y���Áj�㊔nc�x���K��4w�Q����Z\�\��>�˯��]��A󾹝��Λő��ӑpt���j/�4c�&���.�@��x^l��()�$��qi��~�kހ7��t%SA��$��?����.�����)��O������c��Jzm�&,�M��_o;g��	��'�w؏=̏����Үo��(�G2A��*�o���R��IS�����үR�����t����m-�A��xIe�*E���;�J�,���NIBb��:xl��_{�v�����є��J���nޓ��.�� !(5�k	~lh&;��ͥ��l3�k�4!� ŏ[4�M�
�7��� ���o�H�������S�f��'J���'%[BN��<�<������Cd�n�SW�N_f�������u����e%"�R�/t�=�U)���<8�t��G�)8򲙒d�_4�/1�H�@��c/�m�ن� Ȇ(�{�WH꧊N�o�0���)�
%��HEϐ��vv�)���A16j��?{҇X��=9嶕�ƍxYy�,����D��}�/�k�݅:F�x�D���œ��%��K��f,�w-��{i�m���T�����_����+^^SJP��)���zyA�9Z��/��GV��+��{~R�L��/Kb����iI�:���N91_��4&~W�����w}��q&�*�����c���$��h�d��e�iM�m�d�m�D��3���>j�v�=I@����_��X������    .qS��4Qi�[���}1��FN�B�%.J�%9�2KRݠd��ԇ�Is��7r�ڞ���'�:���M���͙�pЩ��=�K��Y����{�����L����)6�r�Y��Mޏ��Z��?� �E:���2d���&*æ�꞊�t?�[F�y*M�Ƹ:����3���9��pԘk�{N���S�$4p%/�����0�7`9Q2���y����d�;���q��z�+ɡ��}|�ҙUy��Ȑqu��4#��4	Y)�>�`?�N)�V�'c�"\��GgA����w���vKx�!#S���H����V�b���Z0ᖋ]�W���W��X�}ڜR��k}`�.�C� �J�^�Bb�W�����,q!�@k�ՋZ�r6��;���%�u��0�'NWO��.}�������B_%g��������Y��u���jI���;�n�ԝ�展�	���O��*�ݑN��J�g�yD^�/�+q��R
����y?/�@�y냰�@��s���C�M�H�B�$	P�a�vB{`Q<̉,���e�xae�Sie�I<q~��[���4]�����M]�NS�)������8���W��.�9�X����S��D���|�S6/o��|��M0c�R��a["����)��R��k���t�U�n�tY������l�@�Uq���Pi�`b�_�y� 9�!j��O
M���Y�J/�I�
D0_��?�0����\�t�i�G	(���e5��}W�˼|O�d�x3�[��l�������lw�!hT����{-�M
�o�G�v��x����*�v
 �k�+��,���h����h��	���N�%�>c�8r�_�^s��1�C��U�<6k��Wt;�wE�[?�R *�,l��̴�x~�J]M���qۢl�ּ�3�$��;an�.�)�z�U
⼛�65�d�`bUZ�2�R^�e�#���,��wvz� D31�,_�^K"Ř�ԙ�Ɏ�,�2Ģ���Wj�sQlP������\�T�7��͵�-s�Tn��`n�]��%W�Ʀ���TP��kQ
���'Ib&���I��-��%��>�8�+�yJ�r�(�y��O����.o�
�|��<���������sZZ���v		����i �3S��F�IIl�o ��8꿒�sA���0pp�v���k���m
��u�!$ەf��=��;�bn�Yn�$8�
�7�}F�1�R��e?>%��v>9ԗW���;[��uqO[O�T+�$;;Ņ��0
\r��?��p����� �=#Ea�(?�0ӖX�$�%�!̠�ڷ4��G�-�<>;�h��r��Iݵ�k�)�\ �o���܍��K�NW�y�s��rud�Ns��?�R@�˶�C��54�I�$t2m�S'.MMC�|y��x�S���Ε�0w)1ʦ����R$`� t�깞t)7������N�6��tܵL�~���=����@
�&��b�-}��
a��z8p���N����&⣏;ȴm	a$�ޓ�vS͵d��,$5r���z�:Oz������8Κ:U�ڮ��6gZ�GJ�t~�	*	׼Q>����U��L%N=d�K���J&k��A�y��sPJ��o2j�YI��K����%�.�ʖ(ݤ�	@-�^n�1�膒�\y��I֌���<Om�Eo6�t��U���M�8H��r\S"���[dK�3e��z�<�ǖƼ�j87fN�W��7 ��?��m�\��-yl+���מ3����Í=�q2�z��l3�
M���O�}OR�2H�&�C��>�r�\6L�o+�<����D����a��o����:���"�?�2d���U_�&y�9/I|�Ԧ|r��c�x��Sx���z�m;徴g�/���A�itI���ҹPP+rG�������N�%��uo�襮�C���&�ܫ-E�E-��3�(�ۜ�?A��q8Ks������+ѐ��c�m�ٔ��I��r���M��ߤ(�}"�-��$,���v��`�	����٧���M8輗:^�)bfP��N�kM�X�l�}�/K^��Z���_`)p-0������?0����ZLg�- D����i�W�&��=|&��!��[����cA`<��f1j�yC{s�]˧�)H�Ǚ-�q:�m�q`\Ё��9��8���?������gA8£x�Mw�L�մ�^:��;�p�(�0#@-o 9$���T�D����>*|/O�^�^�8��e�`�7$��(��7�;R��>��%8������/g�3�%d#/����i�-a�>�T���O�eJ�Vyj��V?��Vf��6�/�` �g�J��L���%{�R��ZNw��دc���N7U�^����朆k	l�x]�V'ɔ_~��o�����5U~̗���`rL/�*xv2
I6Od;F9�|���iӤ޺�wຒ�1��O(�>�ۿ�G�7��^��*������Qɢ�/8L�+���s����w��Wk��2&C߿s�&׽h�>�!)Mr��(�O�=�QKk�l��/��悛���ۭx��#�9�p�9(Z���-1�߶���f#)/n(���$�
S%��̾�|�1��}�����������I�� %ɗ��&�31�<f���=�9)v|���y1P�Jzw2^��b���������E��xw�d��hKw�-ل*\�Z�\�sL]��D���T��KN#���<�$�u^�6�%�4k�{n)'V��,�)�%�,p[�|�픕z�ڧ�Dt֮�n�[l�ē�~M���Oؗ�d}�(��S�3�U2��/>˯-�c˲㝬�`�?�~�R�gʅ¼��h����^m�7�\ ]͝�T�YG��^[�}ꠕ�#y�kfjU�O����zď{�-�I6��J�� |/��ï�k������j7�߶@ܗ�ij���ЊB������f��(5�Ϲ��YKI0w�J����^}��M&��\>�x�&Mrr���VSN0vd<M0(%j8�C2�I%�%�j>�U�۴:�6g���%�(%���R'�}��O�=Lxx�-�t5���L2J<���>8=w���8�����2{��j���{;�[�!QoB-����L�?����a����2͠Q�Y9a�Ӥg�?�����S������Y�>�^���U�}�{�l]�>�a�L�(U����¢�6��a�{`�<��0�Z)��#��	3��7�ep����%�y=̽�T�? �n�tIb�Ñ_��B���yT{�7�X��q�c>''����f����e���1��1��Б=��Ґ��j*˽t�;	VW Qy��ڗÀ}녰>��ӳP|y|@���AX��ц/w�����8�>�7�Gg�
�T����NUl��,�,�Er[ħ~�l��ʞ���M��g%Ep�?r#}4[���Þzj�0���f�s�s��?L��iZ��H�iXe}�������S(�q���ns��!���_9����	=�T���[BS��^k%�0��W|Ι�ɾp�ȩ=@5���B�|)>����U4l����ң�2�IO�*��A{���C���)���{��)��M�p�}*Ws ����e̋���.�o��Z:\ʶy���5?��O)f�e�\}���1.���K���}P"]yjɺV���U���ԋ��}d���nL>N;�#g�m� �����)C���yP/Ͳ�ٰ$�'ONE�4y�ט�ܬ�w��k��甎���
Q�{ �T�دt49LD�I{�@�L+L�R窞���p��@������ϑzZ�D�\R�C���%Wѭ���E~t�!�!8��e��_P���&�	9E�d샞�Q�QQ�u�Oړ�� ��l�4ߖ]KZ��_�P�vY�I����YVu*��#�e!7"}$ُ�f~�HA�I��Z6��J�!����3.��e�f�q]_xEK�6��.&�[��p�)�y ^,�_,{9e/�g����wz��-�SJ��Mn��On}��b�����2{>��{�b���*�n���7f�l��"�����i�YB[>8wπE�������N1ռ����c�R���(M�|� �  �o杧1ē�0��(��1�:Asֽ��_,' *S:�7�NZD;�$��#+Lm#'zs��]���%��n�D�ӂ�A8��c��8���v}U�M�����q}鲍����1&y�d����~{O�V��)_�V�y��9P��J���[�e�q���I�FnZ>�L��J��s��[v�6��z-�ҟf�Ǧu��%��|\[*���vz)o!Q{9��R6��'���~�o��yk;-yKR=�=I�S�a�N�5��f��j��7�]4�x�њ��B��N�bgvޛY1�'���2�ކ�Ǒ�1]^���3��,dH=5�*5�P����0���JzOm��s�r9�}K���9�&���srW�\y�x0G�C��u��?���s�L|�oh�m�;�$��n���T�����zm���&r������H��m�����c�����`^�F�tAMP��a��.��&���,���"�(�ș'�Ì��Mi�֥MG�p $��_�}�G7���]+We磙o=��מ�Q�L��ߑ�����Z�M�G����C�Ӥ��V��L��;�:�A%��P���)�X*pV�_�n�('%}�3�d�L�>�i�t8�dMK{�WG���L#�k��|o�մMi�Z{�-����pNQz�F:M��g�C�w���_�|y='6�5�ㇹ0=���˔�e��{r��½BI.׏�|�|	�wἓ
�a@d~��v� 
뙝��~�!��ޭ���]�|�	�]��5`���DD��l��_��;h�)�Ğu#���,���a$$//5�J�I_@;Y�������_e�����X?��4ώ������������+�]s2��������izj�k"j�f�`�$�(c[����]�[�������v#�y|��������O"V%�Cf+��l	�Th),�*}'=�zP��hwֲ9y�A`
�����aoY���B�����Jw�姿ȯ=Rԧz	���$�jw�Ř~#��4t� ��8uTC�%�aO)ux<��9Xݐ���r��C�4y�'��V//��7�{����&2#H.>J��U��-�t���]r+�tQ��
�8k4�a�6��@��XY�F� �$��N!��m���+Iq'�.����،����B��!���/g��O�-o�5�ʱ��"�TlP���������ϯ��_~�����mns��v��t��/�������߶��{����_�������?���������ۿ���?��o��/�����/�W�w,      �      x������ � �      a      x������ � �      c      x������ � �      d      x������ � �      f      x������ � �      i      x������ � �      j      x������ � �      l   D  x���Qr� ���Sp;���%r��8�	hE�N/�3�b]���C�Dp`�����Q�`R-�}yݫ�d�K��}*�u��ʁ�zt�E����QU0k�z��֜��tg"�?N��C����+���(6��Q!-�=����hl���͑�ǯ����A������w�q���9��HD{B��pmH~���;4!����{���\�
�%��z4��6���\�5�-�~�Q�etjY0�w��(`
#��zd�E5��y�D^��c�jg��{&W����W���6�$��Mpzd�r��v���jK�M�[!u��j�T���OI�| q�$N      n   �   x�M��
�@��ק�K](w�ߖBP�`� �L����V=E/��
��p�/O�ޟ�M��F��b=�Zq)�Tf��Pϸc5`���۠����F+<xe@�4ˋrYZ;��u�'�$)�*x��n�E������i�Y=,�~���|_�~�S���p9-	.I_�]7      p      x������ � �      s      x������ � �      �      x������ � �      t      x������ � �      u      x������ � �      �   !   x�+�,ȏON,JO����|NSc�=... ��o      v   5   x�3202�5��5��,�/.I/J-�45�,�,ȏON,JO����|�=... E��      w   �   x�E���0F�ۧ�C�mi������,�6��5}za0N�����,\^q�Bz��ɧ0�&$�ɇ��]�z�7��<2-���5��I���0D&�&�./�]8��s�>�J��Bku�X�A�
K������2�� ��"�*�k�Ut!�T�-6      y      x������ � �      z   T   x�3�t��+���,)�/�4400�4��(M��L�420��54�52�2�tN��������O/J��5Ū��0�����y1z\\\ �.�      |     x����j�0E��в](h�G��4����2q�+P$W����Sh
Yfu�{�� �W[[���鈵��"�1��4���x6%i�b�0%k5C�4I@BR`�Qp)O�&�$��:ty����4�Xf����
��ƇN�~u3ם�$B!�;U�,��|9/Wj����j�YoUyӿ�"Gy!$0#�xǊ:x��?�핂<�:�ҳW�����h�yVk���<k(�Ѝo�U|���j �\�K��Q{�P��������6Բ�x8������܏�(�Z��      ~   �   x�eͱ� ���x
_��a:6�M��QG�+�����>}ն�Ё@��C[���*�6G���x�c�0���V9@��K�l��yU6׶�[�"L�_�Y7w���}�W�Q��I�i��ep�$�Z?�URO�QE��*R��(�X��f!��h5�,�8�@�ux,�������7e[|      �      x�3�43�2�43\1z\\\ !�      �      x�3�4��2�43����� �
      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �   /   x�3�,(�ON-�7�420��54�52�,�/.I/J-������� �
A      �   �   x��л
�@�z�_"3���W�����E�hH��(J,�6a����2��>�c��r] ���X�)��}�í�= T;Ј��\}⥋u�6�>�U824�9�!Q��=Y� U�hm�ı�-��]J����4��S�{?��5|�X-�O뇭�      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �   j   x�=ʱ
�@����a���͵t�*H��7$�KD������=�ۖ�h�d��	���E	?��k'Mji����(t�0��G��l��8(x�h����v ��s9�/�U(�      �      x������ � �      �   �   x�-��
�@����)ڇvf4�Ye�DC�B�S#9�-�����_}���J��[E���MaSDYG#0�s�sW0Di0H�u9Ϊ`w���b�����k%�c��by,��_��,ﵒ��0��#G=�y�����I�m׼3��B5����ߙ�����q��� �N4�      B   �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    21631    tools_sema_t    DATABASE     ~   CREATE DATABASE tools_sema_t WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'en_US.UTF-8' LC_CTYPE = 'en_US.UTF-8';
    DROP DATABASE tools_sema_t;
                postgres    false                        2615    21632    alm    SCHEMA        CREATE SCHEMA alm;
    DROP SCHEMA alm;
                postgres    false            
            2615    21633    core    SCHEMA        CREATE SCHEMA core;
    DROP SCHEMA core;
                postgres    false                        2615    21634    fis    SCHEMA        CREATE SCHEMA fis;
    DROP SCHEMA fis;
                postgres    false                        2615    21635    frm    SCHEMA        CREATE SCHEMA frm;
    DROP SCHEMA frm;
                postgres    false                        2615    21636    ins    SCHEMA        CREATE SCHEMA ins;
    DROP SCHEMA ins;
                postgres    false                        2615    21637    log    SCHEMA        CREATE SCHEMA log;
    DROP SCHEMA log;
                postgres    false                        2615    21638    prd    SCHEMA        CREATE SCHEMA prd;
    DROP SCHEMA prd;
                postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
                postgres    false            �           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                   postgres    false    3                        2615    24301    seg    SCHEMA        CREATE SCHEMA seg;
    DROP SCHEMA seg;
                postgres    false            e           1255    21639 /   agregar_lote_articulo(bigint, double precision)    FUNCTION     a  CREATE FUNCTION alm.agregar_lote_articulo(p_batch_id bigint, p_cantidad double precision) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
/**
 * Función para actualizar un lote de almacen con p_batch_id
 * Si no encuentra el lote lanza excepcion BATCH_NO_EXISTE
 */
declare
	v_cuenta integer; 
	v_existencia alm.alm_lotes.cantidad%type;
begin
	with updated_lotes as (	
		update alm.alm_lotes
		set cantidad = cantidad + p_cantidad
		where batch_id = p_batch_id
		returning 1)
		
	select count(1)
	from updated_lotes
	into strict v_cuenta;

	if v_cuenta = 0 then
    	    RAISE INFO 'ALMEXLO - no se encontro el batch id % ', p_batch_id;
    	    raise 'BATCH_INEXISTENTE';
    end if;

   	RAISE INFO 'ALMEXLO - actualizando el batch id % con cantidad %', p_batch_id,p_cantidad;
    return 'CORRECTO';

exception
		when others then 
			raise;
end;
		
$$;
 Y   DROP FUNCTION alm.agregar_lote_articulo(p_batch_id bigint, p_cantidad double precision);
       alm          postgres    false    6            V           1255    21640 ;   ajuste_detalle_ingresar(integer, integer, double precision)    FUNCTION     �  CREATE FUNCTION alm.ajuste_detalle_ingresar(p_ajus_id integer, p_lote_id integer, p_cantidad double precision) RETURNS integer
    LANGUAGE plpgsql
    AS $$
#print_strict_params on

declare
	v_deaj_id alm.deta_ajustes.deaj_id%type;
	v_mensaje varchar;
	v_empr_id alm.ajustes.empr_id%type;
begin
  begin
	  	
	    RAISE INFO 'Obtengo empresa de tabla ajuste con ajus_id %',p_ajus_id;

	    select empr_id 
		into strict v_empr_id
		from alm.ajustes
		where ajus_id = p_ajus_id;
		     
	    RAISE INFO 'insertando en deta ajustes %,%,%',p_cantidad,v_empr_id,p_lote_id;

		insert into alm.deta_ajustes (
			   cantidad
	          ,empr_id
	          ,lote_id
	          ,ajus_id)
		values (
			p_cantidad
		    ,v_empr_id
		    ,p_lote_id
		    ,p_ajus_id)
		returning deaj_id into strict v_deaj_id;
		   
	    RAISE INFO 'actualizando alm_lotes % ',p_lote_id;
		   
		update alm.alm_lotes
		set cantidad = cantidad + p_cantidad
		where lote_id = p_lote_id;
	   
	   return v_deaj_id;
	
		
       	exception	   
			when NO_DATA_FOUND then
		        RAISE INFO ' ajus_id inexistente %', p_ajus_id;
				v_mensaje = 'AJUS_NO_ENCONTRADO';
		        raise exception 'AJUS_NO_ENCONTRADO:%',p_ajus_id;

       		when FOREIGN_KEY_VIOLATION then
		        RAISE INFO 'lote  inexistente %', p_lote_id;
				v_mensaje = 'LOTEALM_NO_ENCONTRADO';
		        raise exception 'LOTEALM_NO_ENCONTRADO:%',p_lote_id;
		       
		end;	

exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
		raise warning 'ajuste_detalle_lote: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;
END; 
$$;
 n   DROP FUNCTION alm.ajuste_detalle_ingresar(p_ajus_id integer, p_lote_id integer, p_cantidad double precision);
       alm          postgres    false    6            W           1255    21641 j   crear_lote_articulo(integer, integer, integer, character varying, double precision, date, integer, bigint)    FUNCTION       CREATE FUNCTION alm.crear_lote_articulo(p_prov_id integer, p_arti_id integer, p_depo_id integer, p_codigo character varying, p_cantidad double precision, p_fec_vencimiento date, p_empr_id integer, p_batch_id bigint) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
/**
 * Crea un nuevo lote para un articulo determinado en el deposito informado
 */
begin

	insert into alm.alm_lotes (
	prov_id
	,arti_id
	,depo_id
	,codigo
	,cantidad
	,fec_vencimiento
	,empr_id
	,estado
	,batch_id)
	VALUES( 
	p_prov_id
	,p_arti_id
	,p_depo_id
	,p_codigo
	,p_cantidad
	,p_fec_vencimiento
	,p_empr_id
	,'AC'
	,p_batch_id);

	return 'CORRECTO';

exception
	when unique_violation then 
		RAISE INFO 'error al insertar % : %',sqlerrm,sqlstate;
    	RAISE 'DUP_VAL_LOTALM';
    
    when others then 
		RAISE INFO 'error al insertar % : %',sqlerrm,sqlstate;
    	RAISE;
end;
	-- Enter function body here
$$;
 �   DROP FUNCTION alm.crear_lote_articulo(p_prov_id integer, p_arti_id integer, p_depo_id integer, p_codigo character varying, p_cantidad double precision, p_fec_vencimiento date, p_empr_id integer, p_batch_id bigint);
       alm          postgres    false    6            H           1255    24489    eliminar_lote_articulo(bigint)    FUNCTION     �  CREATE FUNCTION alm.eliminar_lote_articulo(p_batch_id bigint) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
/**
 * Elimina el lote creado anteriorimente
 */
begin

	delete from alm.alm_lotes 
	where batch_id = p_batch_id;

	return 'CORRECTO';

exception
    
    when others then 
		RAISE INFO 'error al eliminar % : %',sqlerrm,sqlstate;
    	RAISE;
end;
	-- Enter function body here
$$;
 =   DROP FUNCTION alm.eliminar_lote_articulo(p_batch_id bigint);
       alm          postgres    false    6            I           1255    21642 /   extraer_lote_articulo(bigint, double precision)    FUNCTION     �  CREATE FUNCTION alm.extraer_lote_articulo(p_batch_id bigint, p_cantidad double precision) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
/**
 * Función para actualizar un lote de almacen con p_batch_id
 * Si no encuentra el lote lanza excepcion BATCH_NO_EXISTE
 */
declare
	v_updated integer; 
	v_existencia alm.alm_lotes.cantidad%type;
begin
	
	select cantidad
	into strict v_existencia
	from alm.alm_lotes
	where batch_id = p_batch_id;

	if v_existencia >= p_cantidad then
		update alm.alm_lotes
		set cantidad = cantidad - p_cantidad
		where batch_id = p_batch_id;
	else 
    	    RAISE INFO 'ALMEXLO - la cantidad no puede ser negativa  existencia % ', v_existencia;
    	    raise 'CANT_MAYOR_EXISTENCIA';
    end if;

    return 'CORRECTO';

	exception
		when NO_DATA_FOUND then 
	 	  RAISE INFO 'ALMEXLO - batch no encontrado %', p_batch_id;
    	  raise 'BATCH_NO_EXISTE';
		when others then 
			raise;
end;
		
$$;
 Y   DROP FUNCTION alm.extraer_lote_articulo(p_batch_id bigint, p_cantidad double precision);
       alm          postgres    false    6            X           1255    21643     obtener_existencia_batch(bigint)    FUNCTION     t  CREATE FUNCTION alm.obtener_existencia_batch(p_batch_id bigint) RETURNS double precision
    LANGUAGE plpgsql
    AS $$
declare	
	v_cantidad alm.alm_lotes.cantidad%type =0;
begin
	select sum(cantidad)
	into strict v_cantidad
	from alm.alm_lotes
	where batch_id = p_batch_id;

	return v_cantidad;
exception
	when no_data_found then	
		raise 'BATCH_INEXISTENTE';

end;

$$;
 ?   DROP FUNCTION alm.obtener_existencia_batch(p_batch_id bigint);
       alm          postgres    false    6            F           1255    21644    log(character varying) 	   PROCEDURE     *  CREATE PROCEDURE core.log(p_msg character varying)
    LANGUAGE plpgsql
    AS $$
declare

begin
     INSERT INTO core.log ( msg)
	           VALUES ( p_msg);
		 commit;
	exception
		when others then	
			raise warning 'error loggeando % - %', sqlerrm,sqlstate;
end
	-- Enter function body here
$$;
 2   DROP PROCEDURE core.log(p_msg character varying);
       core          postgres    false    10            G           1255    21645    set_tabla_id_trg()    FUNCTION     �  CREATE FUNCTION core.set_tabla_id_trg() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
  declare
  	v_mensaje varchar;
  BEGIN
    /** calculo el id de tabla concatenando el nombre de tabla y el valor
     * 
     */
	new.tabl_id = new.tabla||new.valor;

	return new;

exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
	    raise warning 'SETTABLAID: error generando tabla _id %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;
end;

$$;
 '   DROP FUNCTION core.set_tabla_id_trg();
       core          postgres    false    10            _           1255    24490 %   crear_batch_contenedor_retirado_trg()    FUNCTION     e	  CREATE FUNCTION log.crear_batch_contenedor_retirado_trg() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
	DECLARE 	
		v_arti_id alm.alm_articulos.arti_id%TYPE;
		v_prov_id alm.alm_proveedores.prov_id%TYPE;
		v_reci_id prd.recipientes.reci_id%TYPE;
		v_batch_id prd.lotes.batch_id%TYPE;
	    v_step varchar = '0';
	BEGIN
		
		/* Ejecuto solo si se esta generando una orden de transporte
		 * por lo tanto se esta retirando el contenedor con contenido
		 */
	    raise info 'LOGCREABATCH: ortr_id : %',NEW.ortr_id;

		IF NEW.ortr_id IS NOT NULL AND OLD.ortr_id IS NULL THEN 

			raise info 'LOGCREABATCH: generando batch, tica % cont %',NEW.tica_id,NEW.cont_id;

			/* Selecciono el articulo de almacen correspondiente 
			 * al tipo de carga de residuos declarado*/
			SELECT aa.arti_id
			INTO STRICT v_arti_id
			FROM alm.alm_articulos aa 
				,core.tablas t 
			WHERE t.tabl_id = NEW.tica_id
			AND t.valor2 = aa.barcode ;

			v_step = '1';
			raise info 'LOGCREABATCH: articulo %',v_arti_id;

			/* Calculo el proveedor generado para el Solicitante de Transporte
			 * */
			SELECT st.prov_id
			INTO STRICT v_prov_id
			FROM  log.solicitantes_transporte st 
				  ,log.ordenes_transporte ot 
		    WHERE st.sotr_id = ot.sotr_id 
		    AND ot.ortr_id = NEW.ortr_id;

           v_step = '2';
		   raise info 'LOGCREABATCH: prov %',v_prov_id;

		    /* Obtengo el recipiente asociado al contenedor
		     * recibido
		     */
		   
		    SELECT reci_id
		    INTO STRICT v_reci_id
		    FROM log.contenedores c 
		    WHERE c.cont_id = NEW.cont_id;

			v_step = '3';

		    raise info 'LOGCREABATCH: reci %',v_reci_id;

			v_batch_id = prd.crear_lote_v2(NEW.ortr_id||'-'||NEW.cont_id
							  ,v_arti_id
							  ,v_prov_id
							  ,0
							  ,NEW.mts_cubicos
							  ,CAST(0 AS float)
							  ,CAST(NEW.ortr_id AS varchar)
							  ,v_reci_id
							  ,1000 
							  ,NEW.usuario_app
							  ,1
							  ,'false'
							  ,to_date('DD-MM-YYYY','01/01/3000')
							  ,0
							  ,CAST('' AS varchar)
							  ,'false'
							  ,0);
	
	       	   	raise info 'LOGCREABATCH: batch_id creado : %',v_batch_id;
		        v_step = '4';
 
       	   		NEW.batch_id = v_batch_id;
		   END IF;
       	   RETURN NEW;

   exception	
		when no_data_found then 
	        RAISE INFO 'LOGCREABATCH - error creando batch  %: %', sqlstate,sqlerrm;
	        raise exception 'DATOS_BATCH_NF %',v_step;


	END;
$$;
 9   DROP FUNCTION log.crear_batch_contenedor_retirado_trg();
       log          postgres    false    15            `           1255    24491    crear_proveedor_sotr_trg()    FUNCTION     k  CREATE FUNCTION log.crear_proveedor_sotr_trg() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
	DECLARE 
		v_prov_id alm.alm_proveedores.prov_id%TYPE;
	BEGIN
		/* Para un nuevo Solicitante de Transporte genera un nuevo proveedor en almacenes*/
		WITH proveedor_insertado AS (
			INSERT INTO alm.alm_proveedores (nombre,cuit,domicilio,empr_id)
			VALUES (NEW.razon_social,NEW.cuit,NEW.domicilio,1)
			RETURNING prov_id
		)
		
		select prov_id
		into strict v_prov_id
		from proveedor_insertado;

		/* guardo la relación entre el sotr y el proveedor de almacenes*/	
		NEW.prov_id = v_prov_id;
	
		RETURN NEW;
	
	END;
$$;
 .   DROP FUNCTION log.crear_proveedor_sotr_trg();
       log          postgres    false    15            Y           1255    21646    asociar_lote_hijo_trg()    FUNCTION     �
  CREATE FUNCTION prd.asociar_lote_hijo_trg() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
  declare
  v_batch_id_hijo prd.lotes.batch_id%type;
  v_cantidad_hijo alm.alm_deta_entrega_materiales.cantidad%type;
  v_batch_id alm.alm_lotes.batch_id%type;
  v_mensaje varchar;
  v_aux int4;
  BEGIN
    /** primero obtengo el batch_id hijo
     * 
     */
	BEGIN  
		select batch_id
		into strict v_batch_id_hijo
		from alm.alm_pedidos_materiales pema
		     ,alm.alm_entrega_materiales enma
		where pema.pema_id = enma.pema_id
	    and enma.enma_id = new.enma_id;
	   
	   	raise info 'TRASLOHI: batch_id_hijo : %',v_batch_id_hijo;

	exception	
		when no_data_found then 
	        RAISE INFO 'TRASLOHI - error  - Entrega o pedido no existente %', new.enma_id;
			v_mensaje = 'ENMA_NO_ENCONTRADO';
	        raise exception 'ENMA_NO_ENCONTRADO:%',new.enma_id;
	end;
	
	/** Obtengo el batch id del lote de la linea entregada actual **/
	begin
		select batch_id
		into v_batch_id
		from alm.alm_lotes
		where lote_id = new.lote_id;

		raise info 'TRASLOHI: batch id actual : %',v_batch_id;

	exception	
		when no_data_found then 
	        RAISE INFO 'TRASLOHI - error  - alm lote inexistente %', new.lote_id;
			v_mensaje = 'ALOT_NO_ENCONTRADO';
	        raise exception 'ALOT_NO_ENCONTRADO:%',new.lote_id;
		
	end;
	
	/** Verifico si ya se asocio un batch_padre al hijo, sino inserto un registro nuevo de lote hijo**/

	begin
		select 1
		into strict v_aux
		from prd.lotes_hijos
		where batch_id = v_batch_id_hijo
		and batch_id_padre is null;
	
		raise info 'TRASLOHI: hay hijos sin padre con batch id : %',v_batch_id_hijo;

	    update prd.lotes_hijos
	    set batch_id_padre = v_batch_id
	    where batch_id = v_batch_id_hijo
	    and batch_id_padre is null;
	    
	exception
		when no_data_found then 
			/** El lote hijo ya tiene un padre, creo una nueva linea padre para el articulo actual**/
			raise info 'TRASLOHI: NO hay hijos sin padre con batch id : %',v_batch_id_hijo;

			select distinct(cantidad)
			into strict v_cantidad_hijo
			from prd.lotes_hijos
			where batch_id = v_batch_id_hijo;
			
			raise info 'TRASLOHI: cantidad hijo : %',v_cantidad_hijo;
			insert into prd.lotes_hijos
			(batch_id
			 ,batch_id_padre
			 ,empr_id
			 ,cantidad
			 ,cantidad_padre)	
			values(
			v_batch_id_hijo
			,v_batch_id
			,new.empr_id
			,v_cantidad_hijo
			,new.cantidad);

	end;
    
    return new;


exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
	    raise warning 'TRASLOHI: error actualizando lotes hijos %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;
end;

$$;
 +   DROP FUNCTION prd.asociar_lote_hijo_trg();
       prd          postgres    false    8            ]           1255    21647 m   cambiar_recipiente(bigint, integer, integer, integer, character varying, character varying, double precision)    FUNCTION     J  CREATE FUNCTION prd.cambiar_recipiente(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision DEFAULT 0) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
#print_strict_params on

declare
	v_result_lote varchar;
	v_mensaje varchar;
	v_updated integer; 
	v_lote_id prd.lotes.lote_id%type;
	v_num_orden_prod prd.lotes.num_orden_prod%type;
    v_depo_id_destino alm.alm_depositos.depo_id%type;
    v_arti_id prd.lotes.arti_id%type;
    v_prov_id alm.alm_lotes.prov_id%type;
    v_fec_vencimiento alm.alm_lotes.fec_vencimiento%type;
    v_existencia alm.alm_lotes.cantidad%type;
begin

		begin
	        RAISE INFO 'seleccionando datos para lote = %, p_lote_id', p_batch_id_origen;

		   /** tomos los datos del lote de origen a copiar en el nuevo lote **/
		    select lo.lote_id
		    	,lo.num_orden_prod
		    	,al.arti_id
		    	,al.prov_id
		    	,al.fec_vencimiento
		    into strict v_lote_id
		    	 , v_num_orden_prod
		    	 , v_arti_id
		    	 , v_prov_id
		    	 , v_fec_vencimiento
		    from prd.lotes lo
		    	, alm.alm_lotes al
		    where lo.batch_id = p_batch_id_origen
		    and al.batch_id = lo.batch_id;
		   
	        RAISE INFO 'batch, lote, ord prod, arti_id ,prov_id, orden_prod= %, % , % , % , % , %', p_batch_id_origen,v_lote_id,v_num_orden_prod,v_arti_id,v_prov_id,v_fec_vencimiento;

       	exception	   
			when NO_DATA_FOUND then
		        RAISE INFO 'batch no existe %', p_batch_id_origen;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO:%',p_batch_id_origen;
		       
		end;	

	    begin
	        /** obtengo el deposito de destino del recipiente
	         * de destino
	         */
		    select reci.depo_id
		    into strict v_depo_id_destino
		    from prd.recipientes reci
		    where reci.reci_id = p_reci_id_destino;

	   exception	   
			when NO_DATA_FOUND then
		        RAISE INFO 'recipiente no existe %', p_reci_id_destino;
				v_mensaje = 'RECI_NO_ENCONTRADO';
		        raise exception 'RECI_NO_ENCONTRADO:%',p_reci_id_destino;
		       
		end;	
	
		/* Si la cantidad informada es 0, hay que vaciar el lote entero y llevarlo al nuevo recipiente,
		 * sino descuento parcial
		 */
	
		v_existencia = alm.obtener_existencia_batch(p_batch_id_origen);

	 	/* si la cantidad es mayor a la existencia abortamos, sino uso la variable v_existencia para descontar
	 	 * con el valor solicitado por parametro
	 	 */
		if p_cantidad != 0 then
			if p_cantidad > v_existencia then	
			    RAISE INFO 'cantidad mayor a existencia %:%',p_cantidad,v_existencia;
				v_mensaje = 'CANT_MAYOR_EXISTENCIA';
		        raise exception 'CANT_MAYOR_EXISTENCIA:%:%',p_cantidad,v_existencia;
		    else
				v_existencia = p_cantidad;
			end if;
		end if;
	
		/** Crea el batch
		 *  para el movimiento de destino
		 */	   
	   	v_result_lote =
		   	prd.crear_lote_v2(
		   	v_lote_id
		   	,v_arti_id
		   	,v_prov_id
		   	,p_batch_id_origen
		   	,v_existencia
		   	,v_existencia
		   	,v_num_orden_prod  
		   	,p_reci_id_destino 
		   	,p_etap_id_destino
		   	,p_usuario_app 
		   	,p_empre_id
		   	,p_forzar_agregar
		    ,v_fec_vencimiento);
	
	
		return 'CORRECTO';
exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
		raise warning 'cambiar_recipiente: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;
END; 
$$;
 �   DROP FUNCTION prd.cambiar_recipiente(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision);
       prd          postgres    false    8            a           1255    24492 w   cambiar_recipiente_no_return(bigint, integer, integer, integer, character varying, character varying, double precision)    FUNCTION     ?  CREATE FUNCTION prd.cambiar_recipiente_no_return(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision DEFAULT 0) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
#print_strict_params on

declare
	v_result_lote varchar;
	v_mensaje varchar;
	v_updated integer; 
	v_lote_id prd.lotes.lote_id%type;
	v_num_orden_prod prd.lotes.num_orden_prod%type;
    v_depo_id_destino alm.alm_depositos.depo_id%type;
    v_arti_id prd.lotes.arti_id%type;
    v_prov_id alm.alm_lotes.prov_id%type;
    v_fec_vencimiento alm.alm_lotes.fec_vencimiento%type;
    v_existencia alm.alm_lotes.cantidad%type;
begin

		begin
	        RAISE INFO 'seleccionando datos para lote = %, p_lote_id', p_batch_id_origen;

		   /** tomos los datos del lote de origen a copiar en el nuevo lote **/
		    select lo.lote_id
		    	,lo.num_orden_prod
		    	,al.arti_id
		    	,al.prov_id
		    	,al.fec_vencimiento
		    into strict v_lote_id
		    	 , v_num_orden_prod
		    	 , v_arti_id
		    	 , v_prov_id
		    	 , v_fec_vencimiento
		    from prd.lotes lo
		    	, alm.alm_lotes al
		    where lo.batch_id = p_batch_id_origen
		    and al.batch_id = lo.batch_id;
		   
	        RAISE INFO 'batch, lote, ord prod, arti_id ,prov_id, orden_prod= %, % , % , % , % , %', p_batch_id_origen,v_lote_id,v_num_orden_prod,v_arti_id,v_prov_id,v_fec_vencimiento;

       	exception	   
			when NO_DATA_FOUND then
		        RAISE INFO 'batch no existe %', p_batch_id_origen;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO:%',p_batch_id_origen;
		       
		end;	

	    begin
	        /** obtengo el deposito de destino del recipiente
	         * de destino
	         */
		    select reci.depo_id
		    into strict v_depo_id_destino
		    from prd.recipientes reci
		    where reci.reci_id = p_reci_id_destino;

	   exception	   
			when NO_DATA_FOUND then
		        RAISE INFO 'recipiente no existe %', p_reci_id_destino;
				v_mensaje = 'RECI_NO_ENCONTRADO';
		        raise exception 'RECI_NO_ENCONTRADO:%',p_reci_id_destino;
		       
		end;	
	
		/* Si la cantidad informada es 0, hay que vaciar el lote entero y llevarlo al nuevo recipiente,
		 * sino descuento parcial
		 */
	
		v_existencia = alm.obtener_existencia_batch(p_batch_id_origen);

	 	/* si la cantidad es mayor a la existencia abortamos, sino uso la variable v_existencia para descontar
	 	 * con el valor solicitado por parametro
	 	 */
		if p_cantidad != 0 then
			if p_cantidad > v_existencia then	
			    RAISE INFO 'cantidad mayor a existencia %:%',p_cantidad,v_existencia;
				v_mensaje = 'CANT_MAYOR_EXISTENCIA';
		        raise exception 'CANT_MAYOR_EXISTENCIA:%:%',p_cantidad,v_existencia;
		    else
				v_existencia = p_cantidad;
			end if;
		end if;
	
		/** Crea el batch
		 *  para el movimiento de destino
		 */	   
	   	v_result_lote =
		   	prd.crear_lote_v2(
		   	v_lote_id
		   	,v_arti_id
		   	,v_prov_id
		   	,p_batch_id_origen
		   	,v_existencia
		   	,v_existencia
		   	,v_num_orden_prod  
		   	,p_reci_id_destino 
		   	,p_etap_id_destino
		   	,p_usuario_app 
		   	,p_empre_id
		   	,p_forzar_agregar
		    ,v_fec_vencimiento);
	
	
exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
		raise warning 'cambiar_recipiente: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;
END; 
$$;
 �   DROP FUNCTION prd.cambiar_recipiente_no_return(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision);
       prd          postgres    false    8            b           1255    24494 r   cambiar_recipiente_proc(bigint, integer, integer, integer, character varying, character varying, double precision) 	   PROCEDURE     !  CREATE PROCEDURE prd.cambiar_recipiente_proc(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision DEFAULT 0)
    LANGUAGE plpgsql
    AS $$
#print_strict_params on

declare
	v_result_lote varchar;
	v_mensaje varchar;
	v_updated integer; 
	v_lote_id prd.lotes.lote_id%type;
	v_num_orden_prod prd.lotes.num_orden_prod%type;
    v_depo_id_destino alm.alm_depositos.depo_id%type;
    v_arti_id prd.lotes.arti_id%type;
    v_prov_id alm.alm_lotes.prov_id%type;
    v_fec_vencimiento alm.alm_lotes.fec_vencimiento%type;
    v_existencia alm.alm_lotes.cantidad%type;
begin

		begin
	        RAISE INFO 'seleccionando datos para lote = %, p_lote_id', p_batch_id_origen;

		   /** tomos los datos del lote de origen a copiar en el nuevo lote **/
		    select lo.lote_id
		    	,lo.num_orden_prod
		    	,al.arti_id
		    	,al.prov_id
		    	,al.fec_vencimiento
		    into strict v_lote_id
		    	 , v_num_orden_prod
		    	 , v_arti_id
		    	 , v_prov_id
		    	 , v_fec_vencimiento
		    from prd.lotes lo
		    	, alm.alm_lotes al
		    where lo.batch_id = p_batch_id_origen
		    and al.batch_id = lo.batch_id;
		   
	        RAISE INFO 'batch, lote, ord prod, arti_id ,prov_id, orden_prod= %, % , % , % , % , %', p_batch_id_origen,v_lote_id,v_num_orden_prod,v_arti_id,v_prov_id,v_fec_vencimiento;

       	exception	   
			when NO_DATA_FOUND then
		        RAISE INFO 'batch no existe %', p_batch_id_origen;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO:%',p_batch_id_origen;
		       
		end;	

	    begin
	        /** obtengo el deposito de destino del recipiente
	         * de destino
	         */
		    select reci.depo_id
		    into strict v_depo_id_destino
		    from prd.recipientes reci
		    where reci.reci_id = p_reci_id_destino;

	   exception	   
			when NO_DATA_FOUND then
		        RAISE INFO 'recipiente no existe %', p_reci_id_destino;
				v_mensaje = 'RECI_NO_ENCONTRADO';
		        raise exception 'RECI_NO_ENCONTRADO:%',p_reci_id_destino;
		       
		end;	
	
		/* Si la cantidad informada es 0, hay que vaciar el lote entero y llevarlo al nuevo recipiente,
		 * sino descuento parcial
		 */
	
		v_existencia = alm.obtener_existencia_batch(p_batch_id_origen);

	 	/* si la cantidad es mayor a la existencia abortamos, sino uso la variable v_existencia para descontar
	 	 * con el valor solicitado por parametro
	 	 */
		if p_cantidad != 0 then
			if p_cantidad > v_existencia then	
			    RAISE INFO 'cantidad mayor a existencia %:%',p_cantidad,v_existencia;
				v_mensaje = 'CANT_MAYOR_EXISTENCIA';
		        raise exception 'CANT_MAYOR_EXISTENCIA:%:%',p_cantidad,v_existencia;
		    else
				v_existencia = p_cantidad;
			end if;
		end if;
	
		/** Crea el batch
		 *  para el movimiento de destino
		 */	   
	   	v_result_lote =
		   	prd.crear_lote_v2(
		   	v_lote_id
		   	,v_arti_id
		   	,v_prov_id
		   	,p_batch_id_origen
		   	,v_existencia
		   	,v_existencia
		   	,v_num_orden_prod  
		   	,p_reci_id_destino 
		   	,p_etap_id_destino
		   	,p_usuario_app 
		   	,p_empre_id
		   	,p_forzar_agregar
		    ,v_fec_vencimiento);
	
	
exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
		raise warning 'cambiar_recipiente: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;
END; 
$$;
 �   DROP PROCEDURE prd.cambiar_recipiente_proc(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision);
       prd          postgres    false    8            Z           1255    21649 �   crear_lote(character varying, integer, integer, bigint, double precision, double precision, character varying, integer, integer, character varying, integer, character varying, date, integer, character varying)    FUNCTION     �  CREATE FUNCTION prd.crear_lote() RETURNS 
    LANGUAGE plpgsql
    AS $$
/** Funcion para generar un nuevo lote
 *  Recibe como parametro un id de lote
 *  y un recipiente donde crear el batch.
 *  Si el recipiente esta ocupado, devuelve el error
 */
#print_strict_params on
DECLARE
 v_estado_recipiente prd.recipientes.estado%type; 
 v_batch_id prd.lotes.batch_id%type;
 v_mensaje varchar;
 v_reci_id_padre prd.recipientes.reci_id%type;
 v_depo_id prd.recipientes.depo_id%type;
 v_lote_id prd.lotes.lote_id%type;
 v_arti_id alm.alm_lotes.arti_id%type;
 v_cantidad_padre alm.alm_lotes.cantidad%type;
 v_recu_id prd.recursos_lotes.recu_id%type;
 v_resultado varchar;
BEGIN


		begin
	        RAISE INFO 'PRDCRLO - ṕ_forzar_agregar = %, p_lote_id % y p_batch_id_padre %: ', p_forzar_agregar, p_lote_id, p_batch_id_padre;

			select reci.estado
				   ,reci.depo_id
			into strict v_estado_recipiente
				,v_depo_id
			from PRD.RECIPIENTES reci
			where reci.reci_id = p_reci_id;

			/** Valido que el recipiente exista y no tenga contenido **/
		    if (p_forzar_agregar!='true') then
				
				    if v_estado_recipiente != 'VACIO' then
		
				        RAISE INFO 'PRDCRLO - error 1 - recipiente lleno , estado = % ', v_estado_recipiente;
		                v_mensaje = 'RECI_NO_VACIO';
				    	raise exception 'RECI_NO_VACIO:%',p_reci_id;
				    end if;
				   
		    end if;
		exception	   
			when too_many_rows then
		        RAISE INFO 'PRDCRLO - error 9 - recipiente duplicado %', p_reci_id;
				v_mensaje = 'RECI_DUPLICADO';
		        raise exception 'RECI_DUPLICADO:%',p_reci_id;
		       

			when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 2 - recipiente no encontrado %', p_reci_id;
				v_mensaje = 'RECI_NO_ENCONTRADO';
		        raise exception 'RECI_NO_ENCONTRADO:%',p_reci_id;
		       
		end;	

   /**
	 * Una vez validado el recipiente, creo el nuevo lote
	 */		
		
    if (p_forzar_agregar='true') then
	    RAISE INFO 'PRDCRLO - 2 - ṕ_forzar_agregar = %, p_lote_id % y p_batch_id_padre %: ', p_forzar_agregar, p_lote_id, p_batch_id_padre;

        begin
	        select lo.batch_id
	        	   ,lo.lote_id
	        	   ,al.arti_id
	        into strict v_batch_id
	        	 ,v_lote_id
	        	 ,v_arti_id
	        from prd.lotes lo
	             ,alm.alm_lotes al
	        where reci_id  = p_reci_id
	        and lo.batch_id = al.batch_id
	        and lo.estado = 'En Curso';

	     /**
	      * Valido que si se quieren unir lotes, coincida el articulo y el nuemro de lote
	      */
	    if v_arti_id != p_arti_id or p_lote_id != v_lote_id then
		        RAISE INFO 'PRDCRLO - error 3 el articulo y lote destino %:% son != de los solicitados %,%',v_arti_id,v_lote_id,p_arti_id,p_lote_id;
				v_mensaje = 'ART_O_LOTE_DISTINTO';
				raise exception 'ART_O_LOTE_DISTINTO:%-%-%-%',v_arti_id,v_lote_id,p_arti_id,p_lote_id;
	    end if;
	       
	    exception
		   when TOO_MANY_ROWS then
		        RAISE INFO 'PRDCRLO - error 20 = %',sqlerrm;
				v_mensaje = 'RECI_DUPLICADO';
				raise exception 'RECI_DUPLICADO:%',p_reci_id;

	    	when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 4 = %',sqlerrm;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
				raise exception 'BATCH_NO_ENCONTRADO:%',sqlerrm;
        end;
	       
    else
		begin
    		RAISE INFO 'PRDCRLO - p_forzar_agregar = %, p_lote_id % y p_batch_id_padre %: ', p_forzar_agregar, p_lote_id, p_batch_id_padre;
	
		    /** Inserto en la tabla de batch, creando el batch_id
		     * de la secuencia de lotes
		     */
			with inserted_batch as (
				insert into 
				prd.lotes (
				lote_id
				,estado
				,num_orden_prod
				,etap_id
				,usuario_app
				,reci_id
				,empr_id)	
				values (
				p_lote_id
				,'En Curso'
				,p_num_orden_prod
				,p_etap_id
				,p_usuario_app
				,p_reci_id
				,p_empr_id
				)
				returning batch_id
			)
		
			select batch_id
			into strict v_batch_id
			from inserted_batch;
		    
		    /** Actualizo el recipiente como lleno
		     */
		    update prd.recipientes 
		    set estado = 'LLENO'
		    where reci_id = p_reci_id;

	   exception
		   when others then
		        RAISE INFO 'PRDCRLO - error 5 - error creando lote y recipiente  %:% ',sqlstate,sqlerrm;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO:%',sqlerrm;
		   end;
		  
    end if;
		
    /** Actualizo el arbol de batchs colocando el 
     *  nuevo batch como hijo del p_batch_id_padre
     * si el padre viene en 0 es un batch al inicio 
     * del proceso productivo 
     */
	insert into prd.lotes_hijos (
	batch_id
	,batch_id_padre
	,empr_id
	,cantidad
	,cantidad_padre)
	values
	(v_batch_id
	,case when p_batch_id_padre = 0 then null else p_batch_id_padre end
	,p_empr_id
	,p_cantidad
	,p_cantidad_padre);
	
	RAISE INFO 'PRDCRLO - Batch id % generado en recipiente %',v_batch_id,p_reci_id;

    /**Cambiamos el estado del lote origen a FINALIZADO si ya no quedan existencias
	 * y vacio el recipiente
	 */

	
	if (p_batch_id_padre !=0 and p_cantidad_padre != 0) then
	
		--Obtengo la exisstencia actual del padre para entender si finalizar
		v_cantidad_padre = alm.obtener_existencia_batch(p_batch_id_padre);
		
		RAISE INFO 'PRDCRLO - cantidad padre existente:informada %.%',v_cantidad_padre,p_cantidad_padre;

		if v_cantidad_padre - p_cantidad_padre = 0 then
	
			RAISE INFO 'PRDCRLO - Finalizando lote % ',p_batch_id_padre;

			update prd.lotes
			set estado = 'FINALIZADO'
			where batch_id = p_batch_id_padre
			returning reci_id into v_reci_id_padre;
	
			update prd.recipientes
			set estado = 'VACIO'
			where reci_id = v_reci_id_padre;
		end if;
	

		/**
		 * Actualizo la existencia del padre
		 */

		RAISE INFO 'PRDCRLO - actualizo existencia %:% ',p_batch_id_padre,p_cantidad_padre;

		v_resultado = alm.extraer_lote_articulo(p_batch_id_padre
												,p_cantidad_padre);
	
	end if;
    /**
     * Genera el lote asociado en almacenes
     *
     */
	if p_arti_id != 0 then --si se informa articulos del lote los inserto en alm_lotes, sino no
	    if (p_forzar_agregar='true') then
	
	    	RAISE INFO 'PRDCRLO - forzar agregar es true, agrego cantidad % al batch %',p_cantidad,v_batch_id;
	    	v_resultado = alm.agregar_lote_articulo(v_batch_id
													,p_cantidad);
		else
	    	RAISE INFO 'PRDCRLO - forzar agregar es false, ingreso cantidad % al batch %',p_cantidad,v_batch_id;
	 
			v_resultado = alm.crear_lote_articulo(
									p_prov_id
									,p_arti_id 
									,v_depo_id
									,p_lote_id 
									,p_cantidad 
									,p_fec_vencimiento
									,p_empr_id 
									,v_batch_id );
		end if;						
	end if;

	RAISE INFO 'PRDCRLO - resultado ops almacen %',v_resultado;

	/** Si el actual lote tiene un recurso asociado lo asocio **/
    if p_recu_id is not null and p_recu_id != 0 then
    	
       begin
    		RAISE INFO 'PRDCRLO - p_recu_id = %', p_recu_id;

			/** Valido que el recursos  exista  **/
			select recu_id
			into strict v_recu_id
			from prd.recursos recu
			where recu.recu_id = p_recu_id;

			insert into prd.recursos_lotes(batch_id
											,recu_id
											,empr_id
											,cantidad
											,tipo)
					values (v_batch_id
							,p_recu_id
							,p_empr_id
							,p_cantidad
							,p_tipo_recurso);
						
		exception	   
		
			when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 10 - recurso no encontrado %', p_recu_id;
				v_mensaje = 'RECU_NO_ENCONTRADO';
		        raise exception 'RECU_NO_ENCONTRADO:%',p_recu_id;
		       
		end;	

	end if;

	return v_batch_id;


exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
	    raise warning 'crear_lote: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;

END; 
$$;
     DROP FUNCTION prd.crear_lote();
       prd          postgres    false    8            c           1255    24496 �   crear_lote(character varying, integer, integer, bigint, double precision, double precision, character varying, integer, integer, character varying, integer, character varying, date, integer, character varying, character varying, bigint)    FUNCTION     �*  CREATE FUNCTION prd.crear_lote(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying DEFAULT 'false'::character varying, p_fec_vencimiento date DEFAULT NULL::date, p_recu_id integer DEFAULT NULL::integer, p_tipo_recurso character varying DEFAULT NULL::character varying, p_planificado character varying DEFAULT 'false'::character varying, p_batch_id bigint DEFAULT NULL::bigint) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
/** Funcion para generar un nuevo lote
 *  Recibe como parametro un id de lote
 *  y un recipiente donde crear el batch.
 *  Si el recipiente esta ocupado, devuelve el error
 */
#print_strict_params on
DECLARE
 v_estado_recipiente prd.recipientes.estado%type; 
 v_batch_id prd.lotes.batch_id%type;
 v_mensaje varchar;
 v_reci_id_padre prd.recipientes.reci_id%type;
 v_depo_id prd.recipientes.depo_id%type;
 v_lote_id prd.lotes.lote_id%type;
 v_arti_id alm.alm_lotes.arti_id%type;
 v_cantidad_padre alm.alm_lotes.cantidad%type;
 v_recu_id prd.recursos_lotes.recu_id%type;
 v_resultado varchar;
 v_estado varchar;
 v_cantidad float;
 v_cuenta integer;
BEGIN
		
	/* seteo el estado inicial dependiendo si se llama al procedure desde Guardar o desde Planificar estapa */
		if (p_planificado='true') then
			v_estado = 'PLANIFICADO';
		else
			v_estado = 'En Curso';
		end if;
		
		/**************************
		 * BLOQUE 1: VALIDO EL ESTADO DEL RECIPIENTE
		 */
		begin
		        
			RAISE INFO 'PRDCRLO - ṕ_forzar_agregar = %, p_lote_id % y p_batch_id_padre %: ', p_forzar_agregar, p_lote_id, p_batch_id_padre;

			select reci.estado
				   ,reci.depo_id
			into strict v_estado_recipiente
				,v_depo_id
			from PRD.RECIPIENTES reci
			where reci.reci_id = p_reci_id;

			/** Valido que el recipiente exista y no tenga contenido **/
		    if (p_forzar_agregar!='true') and p_planificado = 'false' then
				
				    if v_estado_recipiente != 'VACIO' then
		
				        RAISE INFO 'PRDCRLO - error 1 - recipiente lleno , estado = % ', v_estado_recipiente;
		                v_mensaje = 'RECI_NO_VACIO';
				    	raise exception 'RECI_NO_VACIO:%',p_reci_id;
				    end if;
				   
		    end if;
		exception	   
			when too_many_rows then
		        RAISE INFO 'PRDCRLO - error 9 - recipiente duplicado %', p_reci_id;
				v_mensaje = 'RECI_DUPLICADO';
		        raise exception 'RECI_DUPLICADO:%',p_reci_id;
		       

			when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 2 - recipiente no encontrado %', p_reci_id;
				v_mensaje = 'RECI_NO_ENCONTRADO';
		        raise exception 'RECI_NO_ENCONTRADO:%',p_reci_id;
		       
		end;	

   /*******************************************
    * BLOQUE 2 CREO O REUTILIZO LOTE
    * 
    */
	
   /**
	 * Una vez validado el recipiente, creo el nuevo lote
	 */		
		
    if (p_forzar_agregar='true') then
	    RAISE INFO 'PRDCRLO - 2 - ṕ_forzar_agregar = %, p_lote_id % y p_batch_id_padre %: ', p_forzar_agregar, p_lote_id, p_batch_id_padre;

        begin
	        select lo.batch_id
	        	   ,lo.lote_id
	        	   ,al.arti_id
	        into strict v_batch_id
	        	 ,v_lote_id
	        	 ,v_arti_id
	        from prd.lotes lo
	             ,alm.alm_lotes al
	        where reci_id  = p_reci_id
	        and lo.batch_id = al.batch_id
	        and lo.estado = 'En Curso';

	     /**
	      * Valido que si se quieren unir lotes, coincida el articulo y el nuemro de lote
	      */
	    if v_arti_id != p_arti_id or p_lote_id != v_lote_id then
		        RAISE INFO 'PRDCRLO - error 3 el articulo y lote destino %:% son != de los solicitados %,%',v_arti_id,v_lote_id,p_arti_id,p_lote_id;
				v_mensaje = 'ART_O_LOTE_DISTINTO';
				raise exception 'ART_O_LOTE_DISTINTO:%-%-%-%',v_arti_id,v_lote_id,p_arti_id,p_lote_id;
	    end if;
	       
	    exception
		   when TOO_MANY_ROWS then
		        RAISE INFO 'PRDCRLO - error 20 = %',sqlerrm;
				v_mensaje = 'RECI_DUPLICADO';
				raise exception 'RECI_DUPLICADO:%',p_reci_id;

	    	when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 4 = %',sqlerrm;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
				raise exception 'BATCH_NO_ENCONTRADO:%',sqlerrm;
        end;
	       
    else
		begin
    		RAISE INFO 'PRDCRLO - p_forzar_agregar = %, p_lote_id % y p_batch_id_padre %: ', p_forzar_agregar, p_lote_id, p_batch_id_padre;
	
		    /** Inserto en la tabla de batch, creando el batch_id
		     * de la secuencia de lotes
		     */
    		if p_batch_id is not null and p_batch_id != 0 then
    		/* me informan un batch id existente, viene de un batch guardado pero no iniciado, no lo inserto*/
    			v_batch_id = p_batch_id;
    			
    			with updated_batch as (
	    			update prd.lotes 
	    			set lote_id = p_lote_id
	    				,estado = v_estado
	    				,num_orden_prod = p_num_orden_prod
	    				,reci_id = p_reci_id
	    			where batch_id = v_batch_id
	    			returning 1)
	    			
				select count(1)
				from updated_batch
				into strict v_cuenta;

				if v_cuenta = 0 then
			    	    RAISE INFO 'PRDCLO - no se encontro el batch id % cuenta % ', p_batch_id,v_cuenta;
			    	    raise 'BATCH_NO_ENCONTRADO';
			    end if;
    		
    		
    		else
				with inserted_batch as (
					insert into 
					prd.lotes (
					lote_id
					,estado
					,num_orden_prod
					,etap_id
					,usuario_app
					,reci_id
					,empr_id)	
					values (
					p_lote_id
					,v_estado
					,p_num_orden_prod
					,p_etap_id
					,p_usuario_app
					,p_reci_id
					,p_empr_id
					)
					returning batch_id
				)

				select batch_id
				into strict v_batch_id
				from inserted_batch;

			end if;
		
			/** si estay grabando planificado no debo lockear el recipiente */
			if v_estado != 'En Curso' then		
			    
			    /** Actualizo el recipiente como lleno
			     */
			    update prd.recipientes 
			    set estado = 'LLENO'
			    where reci_id = p_reci_id;

			end if;
		
	   exception
		   when others then
		        RAISE INFO 'PRDCRLO - error 5 - error creando lote y recipiente  %:% ',sqlstate,sqlerrm;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO:%',sqlerrm;
		   end;
		  
    end if;
		
    /******************************************************************************
     * BLOQUE 3: ASOCIACION CON LOTES PADRE Y ACTUALIZACION ESTADOS Y  DE CANTIDADES
     * 
     */
   
    if v_estado != 'PLANIFICADO' then
	    /** Actualizo el arbol de batchs colocando el 
	     *  nuevo batch como hijo del p_batch_id_padre
	     * si el padre viene en 0 es un batch al inicio 
	     * del proceso productivo 
	     */
		insert into prd.lotes_hijos (
		batch_id
		,batch_id_padre
		,empr_id
		,cantidad
		,cantidad_padre)
		values
		(v_batch_id
		,case when p_batch_id_padre = 0 then null else p_batch_id_padre end
		,p_empr_id
		,p_cantidad
		,p_cantidad_padre);
		
		RAISE INFO 'PRDCRLO - Batch id % generado en recipiente %',v_batch_id,p_reci_id;
	
	    /**Cambiamos el estado del lote origen a FINALIZADO si ya no quedan existencias
		 * y vacio el recipiente
		 */
	
		
		if (p_batch_id_padre !=0 and p_cantidad_padre != 0) then
		
			--Obtengo la exisstencia actual del padre para entender si finalizar
			v_cantidad_padre = alm.obtener_existencia_batch(p_batch_id_padre);
			
			RAISE INFO 'PRDCRLO - cantidad padre existente:informada %.%',v_cantidad_padre,p_cantidad_padre;
	
			if v_cantidad_padre - p_cantidad_padre = 0 then
		
				RAISE INFO 'PRDCRLO - Finalizando lote % ',p_batch_id_padre;
	
				update prd.lotes
				set estado = 'FINALIZADO'
				where batch_id = p_batch_id_padre
				returning reci_id into v_reci_id_padre;
		
				update prd.recipientes
				set estado = 'VACIO'
				where reci_id = v_reci_id_padre;
			end if;
		
	
			/**
			 * Actualizo la existencia del padre
			 */
	
			RAISE INFO 'PRDCRLO - actualizo existencia %:% ',p_batch_id_padre,p_cantidad_padre;
	
			v_resultado = alm.extraer_lote_articulo(p_batch_id_padre
													,p_cantidad_padre);
		
		end if;
	    /**
	     * Genera el lote asociado en almacenes
	     *
	     */
	
    end if;	

	/*************************************************************************************
	 * BLOQUE 4: ACTUALIZACION DE LOTE EN ALMACENES EN CASO DE INFORMARCE ARTI_ID
	 * 
	 */
   
	if p_arti_id != 0 then --si se informa articulos del lote los inserto en alm_lotes, sino no
	    if (p_forzar_agregar='true') then
	
	    	RAISE INFO 'PRDCRLO - forzar agregar es true, agrego cantidad % al batch %',p_cantidad,v_batch_id;
	    	v_resultado = alm.agregar_lote_articulo(v_batch_id
													,p_cantidad);
		else
	    	RAISE INFO 'PRDCRLO - forzar agregar es false, ingreso cantidad % al batch %',p_cantidad,v_batch_id;
			
			v_cantidad = alm.obtener_existencia_batch(v_batch_id);
			
			/* Si existia lote, seguramente el lote fue grabado como PLANIFICADO
			 * Como debe haber un unico producto por lote
			 * elimino el lote almacen anterior asociado al actual batch_id
			 */
			if v_cantidad != 0 then
	    		v_resultado = alm.eliminar_lote_articulo(v_batch_id);
	    	end if;
	    
			v_resultado = alm.crear_lote_articulo(
									p_prov_id
									,p_arti_id 
									,v_depo_id
									,p_lote_id 
									,p_cantidad 
									,p_fec_vencimiento
									,p_empr_id 
									,v_batch_id );
		end if;						
	end if;

	RAISE INFO 'PRDCRLO - resultado ops almacen %',v_resultado;

	/*************************************************************************
	 * BLOQUE 5: ACTUALIZACION DE RECURSO DE TRABAJO EN CASO DE INFORMARSE
	 * 
	 */


	/** Si el actual lote tiene un recurso asociado lo asocio **/
    if p_recu_id is not null and p_recu_id != 0 then
    	
       begin
    		RAISE INFO 'PRDCRLO - p_recu_id = %', p_recu_id;

			/** Valido que el recursos  exista  **/
			select recu_id
			into strict v_recu_id
			from prd.recursos recu
			where recu.recu_id = p_recu_id;

			insert into prd.recursos_lotes(batch_id
											,recu_id
											,empr_id
											,cantidad
											,tipo)
					values (v_batch_id
							,p_recu_id
							,p_empr_id
							,p_cantidad
							,p_tipo_recurso);
						
		exception	   
		
			when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 10 - recurso no encontrado %', p_recu_id;
				v_mensaje = 'RECU_NO_ENCONTRADO';
		        raise exception 'RECU_NO_ENCONTRADO:%',p_recu_id;
		       
		end;	

	end if;

	return v_batch_id;


exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
	    raise warning 'crear_lote: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;

END; 
$$;
 �  DROP FUNCTION prd.crear_lote(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying, p_fec_vencimiento date, p_recu_id integer, p_tipo_recurso character varying, p_planificado character varying, p_batch_id bigint);
       prd          postgres    false    8            d           1255    24498 �   crear_lote_v2(character varying, integer, integer, bigint, double precision, double precision, character varying, integer, integer, character varying, integer, character varying, date, integer, character varying, character varying, bigint)    FUNCTION     a6  CREATE FUNCTION prd.crear_lote_v2(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying DEFAULT 'false'::character varying, p_fec_vencimiento date DEFAULT NULL::date, p_recu_id integer DEFAULT NULL::integer, p_tipo_recurso character varying DEFAULT NULL::character varying, p_planificado character varying DEFAULT 'false'::character varying, p_batch_id bigint DEFAULT NULL::bigint) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
/** Funcion para generar un nuevo lote
 *  Recibe como parametro un id de lote
 *  y un recipiente donde crear el batch.
 *  Si el recipiente esta ocupado, devuelve el error
 */
#print_strict_params on
DECLARE
 v_estado_recipiente prd.recipientes.estado%type; 
 v_batch_id prd.lotes.batch_id%type;
 v_batch_id_aux prd.lotes.batch_id%type;
 v_mensaje varchar;
 v_reci_id_padre prd.recipientes.reci_id%type;
 v_depo_id prd.recipientes.depo_id%type;
 v_lote_id prd.lotes.lote_id%type;
 v_arti_id alm.alm_lotes.arti_id%type;
 v_cantidad_padre alm.alm_lotes.cantidad%type;
 v_recu_id prd.recursos_lotes.recu_id%type;
 v_resultado varchar;
 v_estado varchar;
 v_cantidad float;
 v_cuenta integer;
 v_artDif boolean = false;
 v_lotDif boolean = false;
 v_lotartIgual boolean = false;
 v_countLotesRec integer = 0;
 v_info_error varchar;
 verificarRecipiente CURSOR (p_batch_id INTEGER
			   ,p_arti_id INTEGER
			   ,p_lote_id VARCHAR) for
				select lo.batch_id
				,al.arti_id
				,lo.lote_id
				from prd.lotes lo
				,alm.alm_lotes al
				where reci_id  = p_reci_id
				and (al.arti_id != p_arti_id or lo.lote_id != p_lote_id)
				and lo.batch_id = al.batch_id
				and lo.estado = 'En Curso';


BEGIN
		
		/* seteo el estado inicial dependiendo si se llama al procedure desde Guardar o desde Planificar estapa */
		if (p_planificado='true') then
			v_estado = 'PLANIFICADO';
		else
			v_estado = 'En Curso';
		end if;
		
		/**************************
		 * BLOQUE 1: VALIDO EL ESTADO DEL RECIPIENTE
		 */
		begin
		        
			RAISE INFO 'PRDCRLO - BL1 valido reci - ṕ_forzar_agregar = %, p_lote_id % ', p_forzar_agregar, p_lote_id;

			/** Valido que el recipiente exista y no tenga contenido **/
			select reci.estado
				   ,reci.depo_id
			into strict v_estado_recipiente
				,v_depo_id
			from PRD.RECIPIENTES reci
			where reci.reci_id = p_reci_id;

				       
	    		/*
		 	* 1 - si forzar_agregar = false, verifica si el recipiente esta vacio, si no esta vacio 
		 	*  a) verifica si en el recipiente esta el mismo articulo, sino retorna RECI_NO_VACIO_DIST_ART
		 	*  b) si es mismo articulo y distinto lote retorna RECI_NO_VACIO_DIST_LOTE_IGUAL_ART
		 	*  c) si es mismo arituclo y lote retorna RECI_NO_VACIO_MISMO_IGUAL_ART_LOTE
                	*/	
    
			if v_estado_recipiente != 'VACIO' then
				open verificarRecipiente(p_reci_id,p_arti_id,p_lote_id);
				loop
					fetch verificarRecipiente into v_batch_id_aux ,v_arti_id,v_lote_id;
					exit when NOT FOUND;
      
       				if v_arti_id != p_arti_id then 
       					RAISE DEBUG 'PRDCRLO - revisando recipientes batch v_arti_id p arti id % % %',v_batch_id_aux,v_arti_id,p_arti_id;
						v_artDif = true;
					elsif v_lote_id != p_lote_id then
       					RAISE DEBUG 'PRDCRLO - revisando recipientes batch v_lote_id p lote id % >%< >%<',v_batch_id_aux,v_lote_id,p_lote_id;
						v_lotDif = true;					        		
					else 
						v_lotartIgual = true;
					end if;
				end loop;
				close verificarRecipiente;
				RAISE INFO 'PRDCRLO - revisando recipientes banderas % % %',v_artDif,v_lotDif,v_lotartIgual;
			
				/* Corto la ejecución, hay que advertir al usuario que el recipiente no esta vacio y que decida que hacer **/
	    		if p_forzar_agregar!='true' and p_planificado = 'false' then
	
	    			v_info_error = 'reci_id='||p_reci_id||'-arti_id='||p_arti_id||'-lote_id='||p_lote_id;
					if v_artDif then
			            v_mensaje = 'RECI_NO_VACIO_DIST_ART'; /* caso a */
						raise exception 'RECI_NO_VACIO_DIST_ART-%',v_info_error;
					elsif v_lotDif then
			            v_mensaje = 'RECI_NO_VACIO_DIST_LOTE_IGUAL_ART'; /* caso b */
				    	raise exception 'RECI_NO_VACIO_DIST_LOTE_IGUAL_ART-%',v_info_error;
					else
			            v_mensaje = 'RECI_NO_VACIO_IGUAL_ART_LOTE'; /* caso c */
				    	raise exception 'RECI_NO_VACIO_IGUAL_ART_LOTE-%',v_info_error;
					end if;
				else	
					if v_lotartIgual then
						v_artDif = false;
						v_lotDif = false;
					end if;
				end if;	
	
			end if;
				  
		exception	   
			when too_many_rows then
		        RAISE INFO 'PRDCRLO - error 9 - recipiente duplicado %', p_reci_id;
				v_mensaje = 'RECI_DUPLICADO';
		        raise exception 'RECI_DUPLICADO:%',p_reci_id;

			when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 2 - recipiente no encontrado %', p_reci_id;
				v_mensaje = 'RECI_NO_ENCONTRADO';
		        raise exception 'RECI_NO_ENCONTRADO:%',p_reci_id;
		       
		end;	

   /*******************************************
    * BLOQUE 2 CREO O REUTILIZO LOTE
    * 
    */
	
   /**
    * Una vez validado el recipiente, creo el nuevo lote
    * si forzar agregar = true, entonces
    *  para el caso a) crea un nuevo lote con mismo reci_id (unifica recipientes)
    *  para el caso b) crea un nuevo lote con mismo reci_id (unifica recipientes)
    *  para el caso c) actualiza la existencia del lote con mismo arti y lote (unifica lote)
     **/

    RAISE INFO 'PRDCRLO - BL2  lote -  v_estado_recipiente % v_artDif % v_lotDif % ', v_estado_recipiente,v_artDif,v_lotDif;
		
    if ( p_planificado = 'true' or ( v_estado_recipiente = 'VACIO' or  v_artDif or  v_lotDif ) )then
   
	begin
	
    		if p_batch_id is not null and p_batch_id != 0 then
    		/* me informan un batch id existente, viene de un batch guardado pero no iniciado, no lo inserto*/
    			RAISE INFO 'PRDCRLO - reu lote -  v_estado = %, p_lote_id % y v_batch_id %: ', v_estado, p_lote_id, p_batch_id;

    			v_batch_id = p_batch_id;
    			
    			with updated_batch as (
	    			update prd.lotes 
	    			set lote_id = p_lote_id
	    				,estado = v_estado
	    				,num_orden_prod = p_num_orden_prod
	    				,reci_id = p_reci_id
	    			where batch_id = v_batch_id
	    			returning 1)
	    			
				select count(1)
				from updated_batch
				into strict v_cuenta;

				if v_cuenta = 0 then
			    	    RAISE INFO 'PRDCLO - no se encontro el batch id % cuenta % ', p_batch_id,v_cuenta;
			    	    raise 'BATCH_NO_ENCONTRADO-F';
			    end if;
    			
				    		
    		else
    		    RAISE INFO 'PRDCRLO - ins lote -  p_lote_id % ', p_lote_id;

				with inserted_batch as (
					insert into 
					prd.lotes (
					lote_id
					,estado
					,num_orden_prod
					,etap_id
					,usuario_app
					,reci_id
					,empr_id)	
					values (
					p_lote_id
					,v_estado
					,p_num_orden_prod
					,p_etap_id
					,p_usuario_app
					,p_reci_id
					,p_empr_id
					)
					returning batch_id
				)

				select batch_id
				into strict v_batch_id
				from inserted_batch;

				RAISE INFO 'PRDCRLO - ins lote -  v_batch_id % ', v_batch_id;

			end if;
		
			/** si estay grabando planificado no debo lockear el recipiente */
			if v_estado != 'PLANIFICADO' then		
			    
			    /** Actualizo el recipiente como lleno
			     */
			    update prd.recipientes 
			    set estado = 'LLENO'
			    where reci_id = p_reci_id;

			end if;
						
		
	   exception
		   when others then
		        RAISE INFO 'PRDCRLO - error 5 - error creando lote y recipiente  %:% ',sqlstate,sqlerrm;
			v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO-RF:%',sqlerrm;
		   end;
    else /** Existe un recipiente lleno con mismo arti_id y lote_id que el lote que queremos crear, no lo creo sino unifico **/
	begin
			RAISE INFO 'PRDCRLO - nada con lote -  p_forzar_agregar = %', p_forzar_agregar;

	        select lo.batch_id
	        into strict v_batch_id
	        from prd.lotes lo
	             ,alm.alm_lotes al
	        where reci_id  = p_reci_id
            and lo.lote_id = p_lote_id 
	        and al.arti_id = p_arti_id
			and lo.batch_id = al.batch_id
	        and lo.estado = 'En Curso';

	       	/** Venia de un lote planificado, que al unificarse con uno existente lo damos por finalizado */
	        if p_batch_id is not null and p_batch_id != '' then 
	        	update prd.lotes 
	        	set estado ='FINALIZADO'
	        	where batch_id = p_batch_id;
	        end if;

    exception
		   when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 20 - error buscando lote para unificar reci,lote,arti:%:%:% error %:% ',p_reci_id,p_lote_id,p_arti_id,sqlstate,sqlerrm;
			v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO-MF:%',sqlerrm;
		   end;
				  
    end if;

   
    /********************************************************************************
     * BLOQUE 3: PADRES
     * ASOCIACION CON LOTES PADRE Y ACTUALIZACION ESTADOS Y DE CANTIDADES
     * 
     */
	RAISE INFO 'PRDCRLO - BL3 -  padres -  estado % batch id padre %',v_estado,p_batch_id_padre;
   
    if v_estado != 'PLANIFICADO' then

    	/** Actualizo el arbol de batchs colocando el 
	     *  nuevo batch como hijo del p_batch_id_padre
	     * si el padre viene en 0 es un batch al inicio 
	     * del proceso productivo 
	     */
		insert into prd.lotes_hijos (
		batch_id
		,batch_id_padre
		,empr_id
		,cantidad
		,cantidad_padre)
		values
		(v_batch_id
		,case when p_batch_id_padre = 0 then null else p_batch_id_padre end
		,p_empr_id
		,p_cantidad
		,p_cantidad_padre);
		
		RAISE INFO 'PRDCRLO - Batch id % generado en recipiente %',v_batch_id,p_reci_id;
	
	    /**Cambiamos el estado del lote origen a FINALIZADO si ya no quedan existencias
		 * y vacio el recipiente
		 */
		if (p_batch_id_padre !=0 and p_cantidad_padre != 0) then
		
			--Obtengo la existencia actual del padre para entender si finalizar
			v_cantidad_padre = alm.obtener_existencia_batch(p_batch_id_padre);
			
			RAISE INFO 'PRDCRLO - cantidad padre existente:informada %.%',v_cantidad_padre,p_cantidad_padre;
	
			if v_cantidad_padre - p_cantidad_padre = 0 then
		
				RAISE INFO 'PRDCRLO - Finalizando lote % ',p_batch_id_padre;
	
				update prd.lotes
				set estado = 'FINALIZADO'
				where batch_id = p_batch_id_padre
				returning reci_id into v_reci_id_padre;
				
				select count(1)
				into strict v_countLotesRec
				from prd.lotes
				where reci_id = v_reci_id_padre
				and estado = 'En Curso';
				
				/** Si no hay mas lotes activos en el recipiente lo pongo como VACIO **/
				if (v_countLotesRec = 0) then
					update prd.recipientes
					set estado = 'VACIO'
					where reci_id = v_reci_id_padre;
				end if;
			end if;
		
	
			/**
			 * Actualizo la existencia del padre
			 */
	
			RAISE INFO 'PRDCRLO - actualizo existencia %:% ',p_batch_id_padre,p_cantidad_padre;
	
			v_resultado = alm.extraer_lote_articulo(p_batch_id_padre,p_cantidad_padre);
		
		end if;
	    /**
	     * Genera el lote asociado en almacenes
	     *
	     */
	
    end if;	

	/*************************************************************************************
	 * BLOQUE 4: ACTUALIZACION DE LOTE DEL PRODUCTO EN PRODUCCION
	 * EN ALMACENES EN CASO DE INFORMARSE ARTI_ID 
	 * 
	 */
	RAISE INFO 'PRDCRLO - BL4 -  lote producto - p_arti_id % v_estado %',p_arti_id,v_estado;
   
	if p_arti_id != 0 and v_estado != 'PLANIFICADO' then --si se informa articulos del lote los inserto en alm_lotes, sino no

		/** mismas condiciones que al insertar batch para insertar lote almacen o actualizar**/
		if v_estado_recipiente = 'VACIO' or  v_artDif or  v_lotDif then
	    		
				v_resultado = alm.crear_lote_articulo(
										p_prov_id
										,p_arti_id 
										,v_depo_id
										,p_lote_id 
										,p_cantidad 
										,p_fec_vencimiento
										,p_empr_id 
										,v_batch_id );
		else
			    RAISE INFO 'PRDCRLO - es un batch existente, agrego cantidad % al batch %',p_cantidad,v_batch_id;
	    		v_resultado = alm.agregar_lote_articulo(v_batch_id ,p_cantidad);

		end if;						
		RAISE INFO 'PRDCRLO - resultado ops almacen %',v_resultado;

	end if;


	/*************************************************************************
	 * BLOQUE 5: ACTUALIZACION DE RECURSO DE TRABAJO EN CASO DE INFORMARSE
	 * 
	 */
    RAISE INFO 'PRDCRLO - BL5 RECURSO TRABAJO - recu_id %',p_recu_id;


	/** Si el actual lote tiene un recurso asociado lo asocio **/
    if p_recu_id is not null and p_recu_id != 0 then
    	
       begin

	       RAISE INFO 'PRDCRLO - p_recu_id = %', p_recu_id;

			/** Valido que el recursos  exista  **/
			select recu_id
			into strict v_recu_id
			from prd.recursos recu
			where recu.recu_id = p_recu_id;

			/** Eliminio todo si fue grabado como planificado**/
			delete from prd.recursos_lotes
			where batch_id = v_batch_id
			and tipo=p_tipo_recurso;

			/* Inserto el recurso **/
			insert into prd.recursos_lotes(batch_id
											,recu_id
											,empr_id
											,cantidad
											,tipo)
					values (v_batch_id
							,p_recu_id
							,p_empr_id
							,p_cantidad
							,p_tipo_recurso);
						
		exception	   
		
			when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 10 - recurso no encontrado %', p_recu_id;
				v_mensaje = 'RECU_NO_ENCONTRADO';
		        raise exception 'RECU_NO_ENCONTRADO:%',p_recu_id;
		       
		end;	

	end if;

	return v_batch_id;


exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
	    raise warning 'crear_lote: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;

END; 
$$;
 �  DROP FUNCTION prd.crear_lote_v2(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying, p_fec_vencimiento date, p_recu_id integer, p_tipo_recurso character varying, p_planificado character varying, p_batch_id bigint);
       prd          postgres    false    8            ^           1255    21651    crear_prd_recipiente()    FUNCTION       CREATE FUNCTION prd.crear_prd_recipiente() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
    DECLARE
     idRecip int4;
    BEGIN
      /** funcion on insert para insertar recipiente nuevo al crear un contenedor 
      *
      */
      
      INSERT INTO prd.recipientes 
      (tipo, estado, nombre, depo_id, care_id) 
      values('TRANSPORTE', 'VACIO', new.codigo, 5000, 'cate_recipienteCONTENEDOR')
      returning reci_id into strict idRecip;
      
      new.reci_id = idRecip;
      
      return new;
    END;
  $$;
 *   DROP FUNCTION prd.crear_prd_recipiente();
       prd          postgres    false    8            [           1255    21652    crear_prd_recurso_trg()    FUNCTION     w  CREATE FUNCTION prd.crear_prd_recurso_trg() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
  DECLARE
  BEGIN
    /** funcion para utilizarse on insert para insertar el articulo como recurso
     * 
     */
    INSERT INTO prd.recursos
    (tipo
     ,arti_id
     ,empr_id
     )
    values
    ('MATERIAL'
     ,new.arti_id
     ,new.empr_id);

    return new;
    END;
$$;
 +   DROP FUNCTION prd.crear_prd_recurso_trg();
       prd          postgres    false    8            \           1255    21653    eliminar_prd_recurso_trg()    FUNCTION     -  CREATE FUNCTION prd.eliminar_prd_recurso_trg() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
  DECLARE
  BEGIN
    /** funcion para utilizarse on insert para insertar el articulo como recurso
     * 
     */
    delete from prd.recursos
    where arti_id = old.arti_id;
   
	return new;
    END;
$$;
 .   DROP FUNCTION prd.eliminar_prd_recurso_trg();
       prd          postgres    false    8            �            1259    21654    ajustes    TABLE     +  CREATE TABLE alm.ajustes (
    ajus_id integer NOT NULL,
    tipo_ajuste character varying,
    justificacion character varying,
    usuario_app character varying,
    empr_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE alm.ajustes;
       alm            postgres    false    6            �            1259    21662    ajustes_ajus_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.ajustes_ajus_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE alm.ajustes_ajus_id_seq;
       alm          postgres    false    204    6            �           0    0    ajustes_ajus_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE alm.ajustes_ajus_id_seq OWNED BY alm.ajustes.ajus_id;
          alm          postgres    false    205            �            1259    21664    alm_articulos    TABLE     C  CREATE TABLE alm.alm_articulos (
    arti_id integer NOT NULL,
    barcode character varying(50) NOT NULL,
    descripcion character varying(1000),
    costo numeric(14,2),
    es_caja boolean NOT NULL,
    cantidad_caja integer,
    punto_pedido integer,
    estado character varying(45) DEFAULT 'AC'::character varying,
    unidad_medida character varying(45) NOT NULL,
    empr_id integer NOT NULL,
    es_loteado boolean NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false NOT NULL,
    tipo character varying
);
    DROP TABLE alm.alm_articulos;
       alm            postgres    false    6            �           0    0    TABLE alm_articulos    COMMENT     .   COMMENT ON TABLE alm.alm_articulos IS '				';
          alm          postgres    false    206            �            1259    21673    alm_articulos_arti_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_articulos_arti_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE alm.alm_articulos_arti_id_seq;
       alm          postgres    false    6    206            �           0    0    alm_articulos_arti_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE alm.alm_articulos_arti_id_seq OWNED BY alm.alm_articulos.arti_id;
          alm          postgres    false    207            �            1259    21675    alm_depositos    TABLE     �  CREATE TABLE alm.alm_depositos (
    depo_id integer NOT NULL,
    descripcion character varying(255) DEFAULT NULL::character varying,
    direccion character varying(255) DEFAULT NULL::character varying,
    gps character varying(255) DEFAULT NULL::character varying,
    estado character varying(10),
    loca_id character varying(255) DEFAULT NULL::character varying,
    pais_id character varying(255) DEFAULT NULL::character varying,
    empr_id integer NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false NOT NULL,
    esta_id integer NOT NULL,
    reci_id integer,
    "row" integer,
    col integer
);
    DROP TABLE alm.alm_depositos;
       alm            postgres    false    6            �            1259    21688    alm_depositos_depo_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_depositos_depo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE alm.alm_depositos_depo_id_seq;
       alm          postgres    false    6    208            �           0    0    alm_depositos_depo_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE alm.alm_depositos_depo_id_seq OWNED BY alm.alm_depositos.depo_id;
          alm          postgres    false    209            �            1259    21690    alm_deta_entrega_materiales    TABLE     �  CREATE TABLE alm.alm_deta_entrega_materiales (
    deen_id integer NOT NULL,
    enma_id integer NOT NULL,
    cantidad integer NOT NULL,
    arti_id integer NOT NULL,
    prov_id integer,
    lote_id integer NOT NULL,
    depo_id integer,
    empr_id integer NOT NULL,
    precio double precision,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
 ,   DROP TABLE alm.alm_deta_entrega_materiales;
       alm            postgres    false    6            �            1259    21695 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq;
       alm          postgres    false    210    6            �           0    0 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq OWNED BY alm.alm_deta_entrega_materiales.deen_id;
          alm          postgres    false    211            �            1259    21697    alm_deta_pedidos_materiales    TABLE     O  CREATE TABLE alm.alm_deta_pedidos_materiales (
    depe_id integer NOT NULL,
    cantidad integer,
    resto integer,
    fecha_entrega date,
    fecha_entregado date,
    pema_id integer NOT NULL,
    arti_id integer NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
 ,   DROP TABLE alm.alm_deta_pedidos_materiales;
       alm            postgres    false    6            �            1259    21702 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq;
       alm          postgres    false    6    212            �           0    0 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq OWNED BY alm.alm_deta_pedidos_materiales.depe_id;
          alm          postgres    false    213            �            1259    21704    alm_deta_recepcion_materiales    TABLE     �  CREATE TABLE alm.alm_deta_recepcion_materiales (
    dere_id integer NOT NULL,
    cantidad double precision NOT NULL,
    precio double precision,
    empr_id integer NOT NULL,
    rema_id integer NOT NULL,
    lote_id integer NOT NULL,
    prov_id integer NOT NULL,
    arti_id integer NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
 .   DROP TABLE alm.alm_deta_recepcion_materiales;
       alm            postgres    false    6            �            1259    21709 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 =   DROP SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq;
       alm          postgres    false    214    6            �           0    0 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE OWNED BY     q   ALTER SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq OWNED BY alm.alm_deta_recepcion_materiales.dere_id;
          alm          postgres    false    215            �            1259    21711    alm_entrega_materiales    TABLE     �  CREATE TABLE alm.alm_entrega_materiales (
    enma_id integer NOT NULL,
    fecha date,
    solicitante character varying(100) DEFAULT NULL::character varying,
    dni character varying(45) DEFAULT NULL::character varying,
    comprobante character varying(50) DEFAULT NULL::character varying,
    empr_id integer NOT NULL,
    pema_id integer,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
 '   DROP TABLE alm.alm_entrega_materiales;
       alm            postgres    false    6            �            1259    21719 "   alm_entrega_materiales_enma_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_entrega_materiales_enma_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE alm.alm_entrega_materiales_enma_id_seq;
       alm          postgres    false    216    6            �           0    0 "   alm_entrega_materiales_enma_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE alm.alm_entrega_materiales_enma_id_seq OWNED BY alm.alm_entrega_materiales.enma_id;
          alm          postgres    false    217            �            1259    21721 	   alm_lotes    TABLE       CREATE TABLE alm.alm_lotes (
    lote_id integer NOT NULL,
    prov_id integer NOT NULL,
    arti_id integer NOT NULL,
    depo_id integer NOT NULL,
    codigo character varying(255) DEFAULT NULL::character varying,
    fec_vencimiento date,
    cantidad double precision,
    empr_id integer NOT NULL,
    user_id integer,
    estado character varying DEFAULT 'AC'::character varying,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false,
    batch_id bigint
);
    DROP TABLE alm.alm_lotes;
       alm            postgres    false    6            �            1259    21731    alm_lotes_lote_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_lotes_lote_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE alm.alm_lotes_lote_id_seq;
       alm          postgres    false    6    218            �           0    0    alm_lotes_lote_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE alm.alm_lotes_lote_id_seq OWNED BY alm.alm_lotes.lote_id;
          alm          postgres    false    219            �            1259    21733    alm_pedidos_materiales    TABLE     �  CREATE TABLE alm.alm_pedidos_materiales (
    pema_id integer NOT NULL,
    fecha date NOT NULL,
    motivo_rechazo character varying(500) DEFAULT NULL::character varying,
    justificacion character varying(300) DEFAULT NULL::character varying,
    case_id integer,
    ortr_id integer,
    estado character varying(45) DEFAULT NULL::character varying,
    empr_id integer,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false,
    batch_id integer
);
 '   DROP TABLE alm.alm_pedidos_materiales;
       alm            postgres    false    6            �            1259    21744 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_pedidos_materiales_pema_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE alm.alm_pedidos_materiales_pema_id_seq;
       alm          postgres    false    220    6            �           0    0 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE alm.alm_pedidos_materiales_pema_id_seq OWNED BY alm.alm_pedidos_materiales.pema_id;
          alm          postgres    false    221            �            1259    21746    alm_proveedores    TABLE       CREATE TABLE alm.alm_proveedores (
    prov_id integer NOT NULL,
    nombre character varying(255) DEFAULT NULL::character varying,
    cuit character varying(50) DEFAULT NULL::character varying,
    domicilio character varying(255) DEFAULT NULL::character varying,
    telefono character varying(50) DEFAULT NULL::character varying,
    email character varying(100) DEFAULT NULL::character varying,
    empr_id integer NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
     DROP TABLE alm.alm_proveedores;
       alm            postgres    false    6            �            1259    21759    alm_proveedores_articulos    TABLE     k   CREATE TABLE alm.alm_proveedores_articulos (
    prov_id integer NOT NULL,
    arti_id integer NOT NULL
);
 *   DROP TABLE alm.alm_proveedores_articulos;
       alm            postgres    false    6            �            1259    21762    alm_proveedores_prov_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_proveedores_prov_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE alm.alm_proveedores_prov_id_seq;
       alm          postgres    false    6    222            �           0    0    alm_proveedores_prov_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE alm.alm_proveedores_prov_id_seq OWNED BY alm.alm_proveedores.prov_id;
          alm          postgres    false    224            �            1259    21764    alm_recepcion_materiales    TABLE     h  CREATE TABLE alm.alm_recepcion_materiales (
    rema_id integer NOT NULL,
    fecha timestamp without time zone NOT NULL,
    comprobante character varying(255) NOT NULL,
    empr_id integer NOT NULL,
    prov_id integer NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false,
    batch_id integer
);
 )   DROP TABLE alm.alm_recepcion_materiales;
       alm            postgres    false    6            �            1259    21769 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_recepcion_materiales_rema_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 8   DROP SEQUENCE alm.alm_recepcion_materiales_rema_id_seq;
       alm          postgres    false    225    6            �           0    0 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE OWNED BY     g   ALTER SEQUENCE alm.alm_recepcion_materiales_rema_id_seq OWNED BY alm.alm_recepcion_materiales.rema_id;
          alm          postgres    false    226            �            1259    21771    deta_ajustes    TABLE       CREATE TABLE alm.deta_ajustes (
    deaj_id integer NOT NULL,
    cantidad double precision,
    empr_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER,
    lote_id integer,
    ajus_id integer NOT NULL
);
    DROP TABLE alm.deta_ajustes;
       alm            postgres    false    6            �            1259    21779    deta_ajustes_deaj_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.deta_ajustes_deaj_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE alm.deta_ajustes_deaj_id_seq;
       alm          postgres    false    227    6            �           0    0    deta_ajustes_deaj_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE alm.deta_ajustes_deaj_id_seq OWNED BY alm.deta_ajustes.deaj_id;
          alm          postgres    false    228            �            1259    21781    items    TABLE     G  CREATE TABLE alm.items (
    item_id integer NOT NULL,
    label character varying(45),
    name character varying(45),
    requerido smallint NOT NULL,
    tipo_dato character varying(45),
    valo_id character varying(45),
    orden integer,
    aux character varying(45),
    mostrar character varying(10),
    cond_mostrar character varying(50),
    deshabilitado character varying(10),
    cond_habilitado character varying(50),
    fec_alta timestamp without time zone DEFAULT now(),
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    form_id integer NOT NULL
);
    DROP TABLE alm.items;
       alm            postgres    false    6            �            1259    21789    items_item_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.items_item_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE alm.items_item_id_seq;
       alm          postgres    false    229    6            �           0    0    items_item_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE alm.items_item_id_seq OWNED BY alm.items.item_id;
          alm          postgres    false    230            �            1259    21791 
   utl_tablas    TABLE       CREATE TABLE alm.utl_tablas (
    tabl_id integer NOT NULL,
    tabla character varying(50),
    valor character varying(50),
    descripcion character varying(200),
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
    DROP TABLE alm.utl_tablas;
       alm            postgres    false    6            �            1259    21796    utl_tablas_tabl_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.utl_tablas_tabl_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE alm.utl_tablas_tabl_id_seq;
       alm          postgres    false    231    6            �           0    0    utl_tablas_tabl_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE alm.utl_tablas_tabl_id_seq OWNED BY alm.utl_tablas.tabl_id;
          alm          postgres    false    232            �            1259    21798    departamentos    TABLE     �   CREATE TABLE core.departamentos (
    depa_id integer NOT NULL,
    nombre character varying NOT NULL,
    descripcion character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE core.departamentos;
       core            postgres    false    10            �            1259    21806    departamentos_depa_id_seq    SEQUENCE     �   CREATE SEQUENCE core.departamentos_depa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE core.departamentos_depa_id_seq;
       core          postgres    false    10    233            �           0    0    departamentos_depa_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE core.departamentos_depa_id_seq OWNED BY core.departamentos.depa_id;
          core          postgres    false    234            �            1259    21808    empresas    TABLE     �  CREATE TABLE core.empresas (
    empr_id integer NOT NULL,
    descripcion character varying,
    cuit character varying,
    direccion character varying,
    telefono character varying,
    email character varying,
    imagepath character varying,
    loca_id integer,
    prov_id integer,
    pais_id integer,
    lat character varying,
    lng character varying,
    celular character varying,
    zona_id integer,
    clie_id integer
);
    DROP TABLE core.empresas;
       core            postgres    false    10            �            1259    21814    empresas_empr_id_seq    SEQUENCE     �   CREATE SEQUENCE core.empresas_empr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE core.empresas_empr_id_seq;
       core          postgres    false    10    235            �           0    0    empresas_empr_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE core.empresas_empr_id_seq OWNED BY core.empresas.empr_id;
          core          postgres    false    236            �            1259    21816    equipos    TABLE     �  CREATE TABLE core.equipos (
    equi_id integer NOT NULL,
    descripcion character varying(255) NOT NULL,
    marca character varying(255) NOT NULL,
    codigo character varying(255) NOT NULL,
    ubicacion character varying(100) NOT NULL,
    estado character varying(2) DEFAULT 'AC'::character varying NOT NULL,
    fecha_ultimalectura timestamp without time zone DEFAULT now() NOT NULL,
    ultima_lectura double precision DEFAULT 0 NOT NULL,
    tipo_horas character varying(10),
    valor_reposicion double precision,
    fecha_reposicion date,
    valor double precision,
    comprobante character varying(255),
    descrip_tecnica text,
    numero_serie double precision,
    adjunto character varying(255) DEFAULT NULL::character varying,
    meta_disponibilidad integer,
    fecha_ingreso date,
    fecha_baja date,
    fecha_garantia date,
    prov_id double precision,
    empr_id integer,
    sect_id integer,
    ubic_id double precision,
    grup_id integer,
    crit_id integer,
    unme_id integer,
    area_id integer,
    proc_id integer,
    tran_id integer,
    dominio character varying,
    imagen bytea,
    tara double precision,
    cont_id integer
);
    DROP TABLE core.equipos;
       core            postgres    false    10            �            1259    21826    equipos_equi_id_seq    SEQUENCE     �   CREATE SEQUENCE core.equipos_equi_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE core.equipos_equi_id_seq;
       core          postgres    false    237    10            �           0    0    equipos_equi_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE core.equipos_equi_id_seq OWNED BY core.equipos.equi_id;
          core          postgres    false    238            �            1259    21828    log    TABLE     S   CREATE TABLE core.log (
    msg character varying,
    fecha date DEFAULT now()
);
    DROP TABLE core.log;
       core            postgres    false    10            �            1259    21835 	   snapshots    TABLE     �   CREATE TABLE core.snapshots (
    id integer NOT NULL,
    snap_id character varying NOT NULL,
    data text,
    fec_alta date DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
    DROP TABLE core.snapshots;
       core            postgres    false    10            �            1259    21843    snapshots_id_seq    SEQUENCE     �   CREATE SEQUENCE core.snapshots_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE core.snapshots_id_seq;
       core          postgres    false    240    10            �           0    0    snapshots_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE core.snapshots_id_seq OWNED BY core.snapshots.id;
          core          postgres    false    241            �            1259    21845    tablas    TABLE     �  CREATE TABLE core.tablas (
    tabl_id character varying NOT NULL,
    tabla character varying,
    valor character varying,
    valor2 character varying,
    valor3 character varying,
    descripcion character varying,
    fec_alta timestamp without time zone DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    eliminado boolean DEFAULT false NOT NULL
);
    DROP TABLE core.tablas;
       core            postgres    false    10            =           1259    24500    tito    TABLE     S   CREATE TABLE core.tito (
    id integer NOT NULL,
    column1 character varying
);
    DROP TABLE core.tito;
       core            postgres    false    10            >           1259    24506    tito_id_seq    SEQUENCE     �   CREATE SEQUENCE core.tito_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
     DROP SEQUENCE core.tito_id_seq;
       core          postgres    false    10    317            �           0    0    tito_id_seq    SEQUENCE OWNED BY     7   ALTER SEQUENCE core.tito_id_seq OWNED BY core.tito.id;
          core          postgres    false    318            ?           1259    24508    transportistas    TABLE       CREATE TABLE core.transportistas (
    cuit character varying NOT NULL,
    razon_social character varying NOT NULL,
    direccion character varying(500) NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
     DROP TABLE core.transportistas;
       core            postgres    false    10            �            1259    21870    zonas    TABLE     r  CREATE TABLE core.zonas (
    zona_id integer NOT NULL,
    nombre character varying NOT NULL,
    descripcion character varying,
    imagen bytea,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    depa_id integer NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL
);
    DROP TABLE core.zonas;
       core            postgres    false    10            �            1259    21879    zonas_zona_id_seq    SEQUENCE     �   CREATE SEQUENCE core.zonas_zona_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE core.zonas_zona_id_seq;
       core          postgres    false    243    10            �           0    0    zonas_zona_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE core.zonas_zona_id_seq OWNED BY core.zonas.zona_id;
          core          postgres    false    244            �            1259    21881    actas_infraccion    TABLE     �  CREATE TABLE fis.actas_infraccion (
    acin_id integer NOT NULL,
    numero_acta integer,
    descripcion character varying(500) NOT NULL,
    tipo character varying NOT NULL,
    sotr_id integer NOT NULL,
    inspector_id integer NOT NULL,
    tran_id integer NOT NULL,
    destino character varying,
    fecha_creacion date DEFAULT now() NOT NULL,
    usuario_app character varying NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
 !   DROP TABLE fis.actas_infraccion;
       fis            postgres    false    12            �            1259    21890    acta_infraccion_acin_id_seq    SEQUENCE     �   CREATE SEQUENCE fis.acta_infraccion_acin_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE fis.acta_infraccion_acin_id_seq;
       fis          postgres    false    245    12            �           0    0    acta_infraccion_acin_id_seq    SEQUENCE OWNED BY     V   ALTER SEQUENCE fis.acta_infraccion_acin_id_seq OWNED BY fis.actas_infraccion.acin_id;
          fis          postgres    false    246            �            1259    21892    formularios    TABLE        CREATE TABLE frm.formularios (
    form_id integer NOT NULL,
    nombre character varying(45),
    descripcion character varying(300),
    eliminado smallint DEFAULT 0,
    fec_alta timestamp without time zone DEFAULT now(),
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE frm.formularios;
       frm            postgres    false    14            �            1259    21901    formularios_form_id_seq    SEQUENCE     �   CREATE SEQUENCE frm.formularios_form_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE frm.formularios_form_id_seq;
       frm          postgres    false    14    247            �           0    0    formularios_form_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE frm.formularios_form_id_seq OWNED BY frm.formularios.form_id;
          frm          postgres    false    248            �            1259    21903    instancias_items    TABLE     �  CREATE TABLE frm.instancias_items (
    init_id integer NOT NULL,
    label character varying(45),
    name character varying(45),
    valor character varying(500),
    requerido smallint,
    tida_id integer,
    valo_id character varying(45),
    info_id integer DEFAULT 0,
    form_id integer,
    orden integer,
    aux character varying(45),
    eliminado smallint DEFAULT 0,
    mostrar character varying(10),
    cond_mostrar character varying(50),
    deshabilitado character varying(10),
    cond_habilitado character varying(50),
    fec_alta timestamp without time zone DEFAULT now(),
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    item_id integer NOT NULL
);
 !   DROP TABLE frm.instancias_items;
       frm            postgres    false    14            �            1259    21913    instancias_items_init_id_seq    SEQUENCE     �   CREATE SEQUENCE frm.instancias_items_init_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE frm.instancias_items_init_id_seq;
       frm          postgres    false    249    14            �           0    0    instancias_items_init_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE frm.instancias_items_init_id_seq OWNED BY frm.instancias_items.init_id;
          frm          postgres    false    250            �            1259    21915    items    TABLE     G  CREATE TABLE frm.items (
    item_id integer NOT NULL,
    label character varying(45),
    name character varying(45),
    requerido smallint NOT NULL,
    tipo_dato character varying(45),
    valo_id character varying(45),
    orden integer,
    aux character varying(45),
    mostrar character varying(10),
    cond_mostrar character varying(50),
    deshabilitado character varying(10),
    cond_habilitado character varying(50),
    fec_alta timestamp without time zone DEFAULT now(),
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    form_id integer NOT NULL
);
    DROP TABLE frm.items;
       frm            postgres    false    14            �            1259    21923    items_item_id_seq    SEQUENCE     �   CREATE SEQUENCE frm.items_item_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE frm.items_item_id_seq;
       frm          postgres    false    251    14            �           0    0    items_item_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE frm.items_item_id_seq OWNED BY frm.items.item_id;
          frm          postgres    false    252            �            1259    21925    incidencias    TABLE     �  CREATE TABLE ins.incidencias (
    inci_id integer NOT NULL,
    descripcion character varying NOT NULL,
    fecha date NOT NULL,
    num_acta character varying,
    adjunto bytea,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    tiin_id character varying NOT NULL,
    tica_id character varying,
    difi_id character varying,
    ortr_id integer,
    eliminado smallint DEFAULT 0 NOT NULL,
    estado character varying DEFAULT 'EN_CURSO'::character varying NOT NULL,
    CONSTRAINT incidencias_check CHECK ((((estado)::text = 'EN_CURSO'::text) OR ((estado)::text = 'SOLUCIONADO'::text) OR ((estado)::text = 'CANCELADO'::text)))
);
    DROP TABLE ins.incidencias;
       ins            postgres    false    7            �            1259    21933    incidencias_inci_id_seq    SEQUENCE     �   CREATE SEQUENCE ins.incidencias_inci_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE ins.incidencias_inci_id_seq;
       ins          postgres    false    7    253            �           0    0    incidencias_inci_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE ins.incidencias_inci_id_seq OWNED BY ins.incidencias.inci_id;
          ins          postgres    false    254            �            1259    21935    choferes    TABLE     �  CREATE TABLE log.choferes (
    chof_id integer NOT NULL,
    nombre character varying NOT NULL,
    apellido character varying NOT NULL,
    documento character varying NOT NULL,
    fec_nacimiento date NOT NULL,
    direccion character varying NOT NULL,
    celular character varying,
    codigo character varying NOT NULL,
    carnet character varying NOT NULL,
    vencimiento date NOT NULL,
    habilitacion character varying,
    imagen bytea,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    tran_id integer NOT NULL,
    cach_id character varying NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    usuario_app character varying
);
    DROP TABLE log.choferes;
       log            postgres    false    15                        1259    21944    choferes_chof_id_seq    SEQUENCE     �   CREATE SEQUENCE log.choferes_chof_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE log.choferes_chof_id_seq;
       log          postgres    false    255    15            �           0    0    choferes_chof_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE log.choferes_chof_id_seq OWNED BY log.choferes.chof_id;
          log          postgres    false    256            @           1259    24516    cierre_sector_descarga    TABLE       CREATE TABLE log.cierre_sector_descarga (
    estado character varying NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    cisd_id character varying NOT NULL
);
 '   DROP TABLE log.cierre_sector_descarga;
       log            postgres    false    15                       1259    21946 	   circuitos    TABLE     �  CREATE TABLE log.circuitos (
    circ_id integer NOT NULL,
    codigo character varying,
    descripcion character varying,
    imagen bytea,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    chof_id integer,
    vehi_id integer,
    zona_id integer,
    eliminado smallint DEFAULT 0
);
    DROP TABLE log.circuitos;
       log            postgres    false    15                       1259    21955    circuitos_circu_id_seq    SEQUENCE     �   CREATE SEQUENCE log.circuitos_circu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE log.circuitos_circu_id_seq;
       log          postgres    false    257    15            �           0    0    circuitos_circu_id_seq    SEQUENCE OWNED BY     J   ALTER SEQUENCE log.circuitos_circu_id_seq OWNED BY log.circuitos.circ_id;
          log          postgres    false    258                       1259    21957    circuitos_puntos_criticos    TABLE     �   CREATE TABLE log.circuitos_puntos_criticos (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    circ_id integer NOT NULL,
    pucr_id integer NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL
);
 *   DROP TABLE log.circuitos_puntos_criticos;
       log            postgres    false    15                       1259    21966    contenedores    TABLE     ;  CREATE TABLE log.contenedores (
    cont_id integer NOT NULL,
    codigo bigint NOT NULL,
    descripcion character varying NOT NULL,
    capacidad double precision NOT NULL,
    tara double precision,
    habilitacion character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    esco_id character varying NOT NULL,
    reci_id integer,
    anio_elaboracion date DEFAULT now(),
    tran_id integer,
    eliminado smallint DEFAULT 0 NOT NULL,
    imagen bytea
);
    DROP TABLE log.contenedores;
       log            postgres    false    15                       1259    21976    containers_cont_id_seq    SEQUENCE     �   CREATE SEQUENCE log.containers_cont_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE log.containers_cont_id_seq;
       log          postgres    false    260    15            �           0    0    containers_cont_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE log.containers_cont_id_seq OWNED BY log.contenedores.cont_id;
          log          postgres    false    261                       1259    21978    contenedores_entregados    TABLE     �  CREATE TABLE log.contenedores_entregados (
    coen_id integer NOT NULL,
    porc_llenado real,
    mts_cubicos real,
    fec_entrega date,
    fec_retiro date,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    cont_id integer NOT NULL,
    soco_id integer NOT NULL,
    sore_id integer,
    ortr_id integer,
    tica_id character varying,
    depo_id integer,
    peso_neto real,
    difi_id character varying,
    equi_id integer,
    equi_id_entrega integer,
    batch_id integer,
    foto bytea,
    tiva_id character varying,
    observaciones_descarga character varying,
    fec_descarga date,
    fec_salida date
);
 (   DROP TABLE log.contenedores_entregados;
       log            postgres    false    15                       1259    21986 #   contenedores_entregados_coen_id_seq    SEQUENCE     �   CREATE SEQUENCE log.contenedores_entregados_coen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE log.contenedores_entregados_coen_id_seq;
       log          postgres    false    15    262            �           0    0 #   contenedores_entregados_coen_id_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE log.contenedores_entregados_coen_id_seq OWNED BY log.contenedores_entregados.coen_id;
          log          postgres    false    263                       1259    21988 $   contenedores_solicitados_coso_id_seq    SEQUENCE     �   CREATE SEQUENCE log.contenedores_solicitados_coso_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;
 8   DROP SEQUENCE log.contenedores_solicitados_coso_id_seq;
       log          postgres    false    15            	           1259    21990    contenedores_solicitados    TABLE        CREATE TABLE log.contenedores_solicitados (
    coso_id integer DEFAULT nextval('log.contenedores_solicitados_coso_id_seq'::regclass) NOT NULL,
    cantidad integer NOT NULL,
    otro character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    tica_id character varying NOT NULL,
    soco_id integer NOT NULL,
    reci_id integer,
    cantidad_acordada integer,
    motivo_rechazo character varying
);
 )   DROP TABLE log.contenedores_solicitados;
       log            postgres    false    264    15            
           1259    21999    ordenes_transporte    TABLE       CREATE TABLE log.ordenes_transporte (
    ortr_id integer NOT NULL,
    fec_retiro date NOT NULL,
    estado character varying NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    difi_id character varying NOT NULL,
    sotr_id integer NOT NULL,
    equi_id integer NOT NULL,
    chof_id character varying NOT NULL,
    case_id character varying,
    usuario_app character varying NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    tran_id integer,
    teot_id integer,
    CONSTRAINT ordenes_transporte_check CHECK ((((estado)::text = 'EN_TRANSITO'::text) OR ((estado)::text = 'INGRESADO'::text) OR ((estado)::text = 'DESCARGADO'::text) OR ((estado)::text = 'INFRACCION'::text) OR ((estado)::text = 'EGRESADO'::text)))
);
 #   DROP TABLE log.ordenes_transporte;
       log            postgres    false    15                       1259    22008    ordenes_transporte_ortr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.ordenes_transporte_ortr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE log.ordenes_transporte_ortr_id_seq;
       log          postgres    false    266    15            �           0    0    ordenes_transporte_ortr_id_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE log.ordenes_transporte_ortr_id_seq OWNED BY log.ordenes_transporte.ortr_id;
          log          postgres    false    267                       1259    22010    puntos_criticos    TABLE     �  CREATE TABLE log.puntos_criticos (
    pucr_id integer NOT NULL,
    nombre character varying NOT NULL,
    descripcion character varying,
    lat character varying,
    lng character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    zona_id integer,
    eliminado smallint DEFAULT 0 NOT NULL
);
     DROP TABLE log.puntos_criticos;
       log            postgres    false    15                       1259    22019    puntos_criticos_pucr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.puntos_criticos_pucr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE log.puntos_criticos_pucr_id_seq;
       log          postgres    false    268    15            �           0    0    puntos_criticos_pucr_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE log.puntos_criticos_pucr_id_seq OWNED BY log.puntos_criticos.pucr_id;
          log          postgres    false    269                       1259    22021    solicitantes_transporte    TABLE     �  CREATE TABLE log.solicitantes_transporte (
    sotr_id integer NOT NULL,
    razon_social character varying NOT NULL,
    cuit character varying NOT NULL,
    domicilio character varying NOT NULL,
    num_registro character varying,
    lat character varying,
    lng character varying,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario_app character varying NOT NULL,
    zona_id integer NOT NULL,
    rubr_id character varying NOT NULL,
    tist_id character varying NOT NULL,
    eliminado integer DEFAULT 0 NOT NULL,
    depa_id integer,
    prov_id integer,
    user_id character varying
);
 (   DROP TABLE log.solicitantes_transporte;
       log            postgres    false    15            �           0    0 &   COLUMN solicitantes_transporte.user_id    COMMENT     Y   COMMENT ON COLUMN log.solicitantes_transporte.user_id IS 'user_id es seg.email (DNATO)';
          log          postgres    false    270                       1259    22030 #   solicitantes_transporte_sotr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitantes_transporte_sotr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE log.solicitantes_transporte_sotr_id_seq;
       log          postgres    false    15    270            �           0    0 #   solicitantes_transporte_sotr_id_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE log.solicitantes_transporte_sotr_id_seq OWNED BY log.solicitantes_transporte.sotr_id;
          log          postgres    false    271                       1259    22032    solicitudes_contenedor    TABLE     �  CREATE TABLE log.solicitudes_contenedor (
    soco_id integer NOT NULL,
    estado character varying NOT NULL,
    observaciones character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    sotr_id integer NOT NULL,
    case_id character varying,
    eliminado smallint DEFAULT 0 NOT NULL,
    tran_id integer NOT NULL,
    CONSTRAINT solicitudes_contenedor_estado_check CHECK ((((estado)::text = 'SOLICITADA'::text) OR ((estado)::text = 'ENTREGA_ACORDADA'::text) OR ((estado)::text = 'RECHAZADA_TRANSPORTISTA'::text) OR ((estado)::text = 'RECHAZADA_SOLICITANTE'::text)))
);
 '   DROP TABLE log.solicitudes_contenedor;
       log            postgres    false    15                       1259    22042 $   solicitudes_contenedores_soco_id_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitudes_contenedores_soco_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 8   DROP SEQUENCE log.solicitudes_contenedores_soco_id_seq;
       log          postgres    false    15    272            �           0    0 $   solicitudes_contenedores_soco_id_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE log.solicitudes_contenedores_soco_id_seq OWNED BY log.solicitudes_contenedor.soco_id;
          log          postgres    false    273                       1259    22044    solicitudes_retiro_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitudes_retiro_seq
    START WITH 6
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;
 *   DROP SEQUENCE log.solicitudes_retiro_seq;
       log          postgres    false    15                       1259    22046    solicitudes_retiro    TABLE     �  CREATE TABLE log.solicitudes_retiro (
    sore_id integer DEFAULT nextval('log.solicitudes_retiro_seq'::regclass) NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    sotr_id integer NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    case_id character varying,
    estado character varying DEFAULT 'SOLICITADA'::character varying NOT NULL,
    CONSTRAINT solicitudes_retiro_check CHECK ((((estado)::text = 'SOLICITADA'::text) OR ((estado)::text = 'RETIRO_ASIGNADO_PARCIAL'::text) OR ((estado)::text = 'RETIRO_ASIGNADO_TOTAL'::text)))
);
 #   DROP TABLE log.solicitudes_retiro;
       log            postgres    false    274    15            <           1259    24447    templates_orden_transporte    TABLE       CREATE TABLE log.templates_orden_transporte (
    teot_id integer NOT NULL,
    observaciones character varying,
    eliminado smallint DEFAULT 0 NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    circ_id integer NOT NULL,
    equi_id integer NOT NULL,
    chof_id character varying NOT NULL,
    tica_id character varying NOT NULL,
    difi_id character varying NOT NULL,
    sotr_id integer NOT NULL
);
 +   DROP TABLE log.templates_orden_transporte;
       log            postgres    false    15            ;           1259    24445 &   templates_orden_transporte_teot_id_seq    SEQUENCE     �   CREATE SEQUENCE log.templates_orden_transporte_teot_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 :   DROP SEQUENCE log.templates_orden_transporte_teot_id_seq;
       log          postgres    false    316    15            �           0    0 &   templates_orden_transporte_teot_id_seq    SEQUENCE OWNED BY     k   ALTER SEQUENCE log.templates_orden_transporte_teot_id_seq OWNED BY log.templates_orden_transporte.teot_id;
          log          postgres    false    315                       1259    22056    tipos_carga_circuitos    TABLE     �   CREATE TABLE log.tipos_carga_circuitos (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    circ_id integer NOT NULL,
    tica_id character varying NOT NULL
);
 &   DROP TABLE log.tipos_carga_circuitos;
       log            postgres    false    15                       1259    22064    tipos_carga_contenedores    TABLE     �   CREATE TABLE log.tipos_carga_contenedores (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    cont_id integer NOT NULL,
    tica_id character varying NOT NULL,
    eliminado smallint DEFAULT 0
);
 )   DROP TABLE log.tipos_carga_contenedores;
       log            postgres    false    15            0           1259    23468    tipos_carga_generadores    TABLE     s   CREATE TABLE log.tipos_carga_generadores (
    tica_id character varying NOT NULL,
    sotr_id integer NOT NULL
);
 (   DROP TABLE log.tipos_carga_generadores;
       log            postgres    false    15                       1259    22073    tipos_carga_transportistas    TABLE     �   CREATE TABLE log.tipos_carga_transportistas (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    tran_id integer NOT NULL,
    tica_id character varying NOT NULL
);
 +   DROP TABLE log.tipos_carga_transportistas;
       log            postgres    false    15                       1259    22081    transportistas    TABLE     �  CREATE TABLE log.transportistas (
    tran_id integer NOT NULL,
    razon_social character varying NOT NULL,
    descripcion character varying NOT NULL,
    direccion character varying,
    telefono character varying,
    contacto character varying,
    resolucion character varying NOT NULL,
    registro character varying NOT NULL,
    fec_alta_efectiva date NOT NULL,
    fec_baja_efectiva date,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    cuit character varying(13) NOT NULL,
    user_id character varying
);
    DROP TABLE log.transportistas;
       log            postgres    false    15            �           0    0    COLUMN transportistas.user_id    COMMENT     b   COMMENT ON COLUMN log.transportistas.user_id IS 'id de usuario es el email de seg.users (DNATO)';
          log          postgres    false    279                       1259    22090    transportistas_tran_id_seq    SEQUENCE     �   CREATE SEQUENCE log.transportistas_tran_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE log.transportistas_tran_id_seq;
       log          postgres    false    279    15            �           0    0    transportistas_tran_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE log.transportistas_tran_id_seq OWNED BY log.transportistas.tran_id;
          log          postgres    false    280                       1259    22092    costos    TABLE       CREATE TABLE prd.costos (
    fec_vigencia date NOT NULL,
    valor money NOT NULL,
    umed character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    recu_id integer NOT NULL,
    empr_id integer
);
    DROP TABLE prd.costos;
       prd            postgres    false    8                       1259    22100    empaque    TABLE     N  CREATE TABLE prd.empaque (
    empa_id integer NOT NULL,
    nombre character varying NOT NULL,
    unidad_medida character varying NOT NULL,
    capacidad double precision NOT NULL,
    empr_id integer NOT NULL,
    usuario_app character varying NOT NULL,
    eliminado boolean NOT NULL,
    fech_alta date DEFAULT now() NOT NULL
);
    DROP TABLE prd.empaque;
       prd            postgres    false    8            �           0    0    COLUMN empaque.eliminado    COMMENT     4   COMMENT ON COLUMN prd.empaque.eliminado IS 'false';
          prd          postgres    false    282                       1259    22107    empaque_empa_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.empaque_empa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE prd.empaque_empa_id_seq;
       prd          postgres    false    282    8            �           0    0    empaque_empa_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE prd.empaque_empa_id_seq OWNED BY prd.empaque.empa_id;
          prd          postgres    false    283                       1259    22109    establecimientos    TABLE     r  CREATE TABLE prd.establecimientos (
    esta_id integer NOT NULL,
    nombre character varying NOT NULL,
    lng real,
    lat real,
    calle character varying,
    altura character varying,
    localidad character varying,
    estado character varying,
    pais character varying,
    fec_alta date DEFAULT now(),
    usuario character varying,
    empr_id integer
);
 !   DROP TABLE prd.establecimientos;
       prd            postgres    false    8                       1259    22116    establecimientos_esta_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.establecimientos_esta_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE prd.establecimientos_esta_id_seq;
       prd          postgres    false    8    284            �           0    0    establecimientos_esta_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE prd.establecimientos_esta_id_seq OWNED BY prd.establecimientos.esta_id;
          prd          postgres    false    285                       1259    22118    etapas    TABLE     �  CREATE TABLE prd.etapas (
    etap_id integer NOT NULL,
    nombre character varying NOT NULL,
    nom_recipiente character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    proc_id integer NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    empr_id integer,
    orden integer NOT NULL,
    link character varying(100)
);
    DROP TABLE prd.etapas;
       prd            postgres    false    8                       1259    22127    etapas_etap_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.etapas_etap_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE prd.etapas_etap_id_seq;
       prd          postgres    false    8    286            �           0    0    etapas_etap_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE prd.etapas_etap_id_seq OWNED BY prd.etapas.etap_id;
          prd          postgres    false    287                        1259    22129    etapas_materiales    TABLE     c   CREATE TABLE prd.etapas_materiales (
    etap_id integer NOT NULL,
    arti_id integer NOT NULL
);
 "   DROP TABLE prd.etapas_materiales;
       prd            postgres    false    8            !           1259    22132    etapas_productos    TABLE     b   CREATE TABLE prd.etapas_productos (
    etap_id integer NOT NULL,
    arti_id integer NOT NULL
);
 !   DROP TABLE prd.etapas_productos;
       prd            postgres    false    8            A           1259    24524    etapas_salidas    TABLE     `   CREATE TABLE prd.etapas_salidas (
    etap_id integer NOT NULL,
    arti_id integer NOT NULL
);
    DROP TABLE prd.etapas_salidas;
       prd            postgres    false    8            B           1259    24527    formulas    TABLE     �  CREATE TABLE prd.formulas (
    form_id integer NOT NULL,
    descripcion character varying NOT NULL,
    cantidad double precision NOT NULL,
    eliminado boolean DEFAULT false,
    aplicacion character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    unme_id character varying NOT NULL
);
    DROP TABLE prd.formulas;
       prd            postgres    false    8            C           1259    24536    formulas_articulos    TABLE       CREATE TABLE prd.formulas_articulos (
    cantidad double precision NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    unme_id character varying,
    form_id integer NOT NULL,
    arti_id integer NOT NULL
);
 #   DROP TABLE prd.formulas_articulos;
       prd            postgres    false    8            D           1259    24544    formulas_form_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.formulas_form_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE prd.formulas_form_id_seq;
       prd          postgres    false    8    322            �           0    0    formulas_form_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE prd.formulas_form_id_seq OWNED BY prd.formulas.form_id;
          prd          postgres    false    324            "           1259    22135    fraccionamientos    TABLE       CREATE TABLE prd.fraccionamientos (
    frac_id integer NOT NULL,
    recu_id integer NOT NULL,
    empa_id integer NOT NULL,
    cantidad double precision NOT NULL,
    fecha date DEFAULT now() NOT NULL,
    eliminado boolean DEFAULT false NOT NULL,
    empr_id integer NOT NULL
);
 !   DROP TABLE prd.fraccionamientos;
       prd            postgres    false    8            #           1259    22140    fraccionamientos_frac_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.fraccionamientos_frac_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE prd.fraccionamientos_frac_id_seq;
       prd          postgres    false    290    8            �           0    0    fraccionamientos_frac_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE prd.fraccionamientos_frac_id_seq OWNED BY prd.fraccionamientos.frac_id;
          prd          postgres    false    291            $           1259    22142    lotes    TABLE     �  CREATE TABLE prd.lotes (
    lote_id character varying,
    batch_id bigint NOT NULL,
    estado character varying NOT NULL,
    num_orden_prod character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    etap_id integer NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    nombre character varying,
    reci_id integer,
    empr_id integer,
    usuario_app character varying,
    arti_id integer
);
    DROP TABLE prd.lotes;
       prd            postgres    false    8            %           1259    22151    lotes_batch_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.lotes_batch_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE prd.lotes_batch_id_seq;
       prd          postgres    false    292    8            �           0    0    lotes_batch_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE prd.lotes_batch_id_seq OWNED BY prd.lotes.batch_id;
          prd          postgres    false    293            &           1259    22153    lotes_hijos    TABLE     Y  CREATE TABLE prd.lotes_hijos (
    batch_id integer NOT NULL,
    batch_id_padre integer,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    empr_id integer,
    cantidad double precision NOT NULL,
    cantidad_padre double precision NOT NULL
);
    DROP TABLE prd.lotes_hijos;
       prd            postgres    false    8            E           1259    24546    lotes_responsables    TABLE     �   CREATE TABLE prd.lotes_responsables (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    batch_id integer NOT NULL,
    user_id integer,
    turn_id character varying NOT NULL
);
 #   DROP TABLE prd.lotes_responsables;
       prd            postgres    false    8            '           1259    22162    movimientos_trasportes    TABLE     �  CREATE TABLE prd.movimientos_trasportes (
    motr_id bigint NOT NULL,
    boleta character varying,
    fecha_entrada date,
    patente character varying,
    acoplado character varying,
    conductor character varying,
    tipo character varying,
    bruto double precision,
    tara double precision,
    neto double precision,
    prov_id integer,
    esta_id integer,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false,
    estado character varying DEFAULT 'INICIADO'::character varying,
    reci_id integer,
    transportista character varying,
    cuit character varying,
    accion character varying
);
 '   DROP TABLE prd.movimientos_trasportes;
       prd            postgres    false    8            (           1259    22171 "   movimientos_trasportes_motr_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.movimientos_trasportes_motr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE prd.movimientos_trasportes_motr_id_seq;
       prd          postgres    false    8    295            �           0    0 "   movimientos_trasportes_motr_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE prd.movimientos_trasportes_motr_id_seq OWNED BY prd.movimientos_trasportes.motr_id;
          prd          postgres    false    296            )           1259    22173    procesos    TABLE     �   CREATE TABLE prd.procesos (
    proc_id integer NOT NULL,
    nombre character varying NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    empr_id integer
);
    DROP TABLE prd.procesos;
       prd            postgres    false    8            *           1259    22181    productos_prod_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.productos_prod_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE prd.productos_prod_id_seq;
       prd          postgres    false    297    8            �           0    0    productos_prod_id_seq    SEQUENCE OWNED BY     H   ALTER SEQUENCE prd.productos_prod_id_seq OWNED BY prd.procesos.proc_id;
          prd          postgres    false    298            +           1259    22183    recipientes    TABLE     I  CREATE TABLE prd.recipientes (
    reci_id integer NOT NULL,
    tipo character varying DEFAULT 0 NOT NULL,
    estado character varying DEFAULT 'VACIO'::character varying NOT NULL,
    nombre character varying NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL,
    empr_id integer,
    depo_id integer NOT NULL,
    motr_id integer,
    "row" integer,
    col integer,
    care_id character varying DEFAULT 'cate_recipienteBOX'::character varying NOT NULL,
    CONSTRAINT recipientes_check CHECK ((((tipo)::text = 'PRODUCTIVO'::text) OR ((tipo)::text = 'DEPOSITO'::text) OR ((tipo)::text = 'TRANSPORTE'::text))),
    CONSTRAINT recipientes_check_estado CHECK ((((estado)::text = 'VACIO'::text) OR ((estado)::text = 'LLENO'::text)))
);
    DROP TABLE prd.recipientes;
       prd            postgres    false    8            ,           1259    22196    recipiente_reci_id_seq    SEQUENCE     |   CREATE SEQUENCE prd.recipiente_reci_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE prd.recipiente_reci_id_seq;
       prd          postgres    false    299    8            �           0    0    recipiente_reci_id_seq    SEQUENCE OWNED BY     L   ALTER SEQUENCE prd.recipiente_reci_id_seq OWNED BY prd.recipientes.reci_id;
          prd          postgres    false    300            -           1259    22198    recursos    TABLE     E  CREATE TABLE prd.recursos (
    recu_id integer NOT NULL,
    tipo character varying NOT NULL,
    cant_capacidad double precision,
    umed_capacidad character varying,
    cant_tiempo_capacidad character varying,
    umed_iempo_capacidad character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    arti_id integer,
    empr_id integer NOT NULL,
    equi_id integer,
    CONSTRAINT recursos_check CHECK (((tipo)::text = ANY (ARRAY[('MATERIAL'::character varying)::text, ('TRABAJO'::character varying)::text])))
);
    DROP TABLE prd.recursos;
       prd            postgres    false    8            .           1259    22207    recursos_lotes    TABLE     H  CREATE TABLE prd.recursos_lotes (
    batch_id integer NOT NULL,
    recu_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    empr_id integer,
    cantidad double precision NOT NULL,
    tipo character varying NOT NULL,
    empa_id integer,
    empa_cantidad double precision,
    CONSTRAINT recursos_lotes_check CHECK ((((tipo)::text = 'MATERIA_PRIMA'::text) OR ((tipo)::text = 'PRODUCTO'::text) OR ((tipo)::text = 'EQUIPO'::text) OR ((tipo)::text = 'HUMANO'::text) OR ((tipo)::text = 'CONSUMO'::text)))
);
    DROP TABLE prd.recursos_lotes;
       prd            postgres    false    8            /           1259    22216    recursos_recu_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.recursos_recu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE prd.recursos_recu_id_seq;
       prd          postgres    false    301    8            �           0    0    recursos_recu_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE prd.recursos_recu_id_seq OWNED BY prd.recursos.recu_id;
          prd          postgres    false    303            :           1259    24426    memberships_menues    TABLE     D  CREATE TABLE seg.memberships_menues (
    modulo character varying NOT NULL,
    opcion character varying NOT NULL,
    "group" character varying,
    role character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL
);
 #   DROP TABLE seg.memberships_menues;
       seg            postgres    false    11            8           1259    24393    memberships_users    TABLE     :  CREATE TABLE seg.memberships_users (
    "group" character varying NOT NULL,
    role character varying NOT NULL,
    fec_alta character varying DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    email character varying NOT NULL
);
 "   DROP TABLE seg.memberships_users;
       seg            postgres    false    11            9           1259    24408    menues    TABLE     �  CREATE TABLE seg.menues (
    modulo character varying(4) NOT NULL,
    opcion character varying NOT NULL,
    texto character varying NOT NULL,
    url character varying,
    javascript character varying,
    orden integer DEFAULT 0,
    url_icono character varying,
    texto_onmouseover character varying,
    eliminado smallint DEFAULT 0,
    fec_alta character varying DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    opcion_padre character varying,
    CONSTRAINT menues_check CHECK ((((modulo)::text = 'PRD'::text) OR ((modulo)::text = 'CORE'::text) OR ((modulo)::text = 'ALM'::text) OR ((modulo)::text = 'MAN'::text) OR ((modulo)::text = 'TAR'::text) OR ((modulo)::text = 'PAN'::text) OR ((modulo)::text = 'LOG'::text) OR ((modulo)::text = 'SEG'::text) OR ((modulo)::text = 'TRZ'::text) OR ((modulo)::text = 'PRO'::text) OR ((modulo)::text = 'FIS'::text)))
);
    DROP TABLE seg.menues;
       seg            postgres    false    11            1           1259    24359    roles    TABLE     �   CREATE TABLE seg.roles (
    rol_id integer NOT NULL,
    nombre character varying,
    descripcion character varying,
    fec_alta date,
    eliminado smallint DEFAULT 0 NOT NULL
);
    DROP TABLE seg.roles;
       seg            postgres    false    11            3           1259    24368    settings    TABLE     �   CREATE TABLE seg.settings (
    id integer NOT NULL,
    site_title character varying(50) NOT NULL,
    timezone character varying(100) NOT NULL,
    recaptcha character varying(5) NOT NULL,
    theme character varying(100) NOT NULL
);
    DROP TABLE seg.settings;
       seg            postgres    false    11            2           1259    24366    settings_id_seq    SEQUENCE     �   CREATE SEQUENCE seg.settings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE seg.settings_id_seq;
       seg          postgres    false    11    307            �           0    0    settings_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE seg.settings_id_seq OWNED BY seg.settings.id;
          seg          postgres    false    306            5           1259    24374    tokens    TABLE     �   CREATE TABLE seg.tokens (
    id integer NOT NULL,
    token character varying(255) NOT NULL,
    user_id bigint NOT NULL,
    created date NOT NULL
);
    DROP TABLE seg.tokens;
       seg            postgres    false    11            4           1259    24372    tokens_id_seq    SEQUENCE     �   CREATE SEQUENCE seg.tokens_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 !   DROP SEQUENCE seg.tokens_id_seq;
       seg          postgres    false    11    309            �           0    0    tokens_id_seq    SEQUENCE OWNED BY     9   ALTER SEQUENCE seg.tokens_id_seq OWNED BY seg.tokens.id;
          seg          postgres    false    308            7           1259    24382    users    TABLE     �  CREATE TABLE seg.users (
    id integer NOT NULL,
    email character varying(100),
    first_name character varying(100),
    last_name character varying(100),
    role character varying(10),
    password text,
    last_login character varying(100),
    status character varying(100),
    banned_users character varying(100),
    passmd5 text,
    telefono character varying,
    dni character varying,
    usernick character varying,
    depo_id integer
);
    DROP TABLE seg.users;
       seg            postgres    false    11            6           1259    24380    users_id_seq    SEQUENCE     �   CREATE SEQUENCE seg.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
     DROP SEQUENCE seg.users_id_seq;
       seg          postgres    false    11    311            �           0    0    users_id_seq    SEQUENCE OWNED BY     7   ALTER SEQUENCE seg.users_id_seq OWNED BY seg.users.id;
          seg          postgres    false    310            �           2604    24554    ajustes ajus_id    DEFAULT     l   ALTER TABLE ONLY alm.ajustes ALTER COLUMN ajus_id SET DEFAULT nextval('alm.ajustes_ajus_id_seq'::regclass);
 ;   ALTER TABLE alm.ajustes ALTER COLUMN ajus_id DROP DEFAULT;
       alm          postgres    false    205    204            �           2604    24555    alm_articulos arti_id    DEFAULT     x   ALTER TABLE ONLY alm.alm_articulos ALTER COLUMN arti_id SET DEFAULT nextval('alm.alm_articulos_arti_id_seq'::regclass);
 A   ALTER TABLE alm.alm_articulos ALTER COLUMN arti_id DROP DEFAULT;
       alm          postgres    false    207    206            �           2604    24556    alm_depositos depo_id    DEFAULT     x   ALTER TABLE ONLY alm.alm_depositos ALTER COLUMN depo_id SET DEFAULT nextval('alm.alm_depositos_depo_id_seq'::regclass);
 A   ALTER TABLE alm.alm_depositos ALTER COLUMN depo_id DROP DEFAULT;
       alm          postgres    false    209    208            �           2604    24557 #   alm_deta_entrega_materiales deen_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_entrega_materiales ALTER COLUMN deen_id SET DEFAULT nextval('alm.alm_deta_entrega_materiales_deen_id_seq'::regclass);
 O   ALTER TABLE alm.alm_deta_entrega_materiales ALTER COLUMN deen_id DROP DEFAULT;
       alm          postgres    false    211    210            �           2604    24558 #   alm_deta_pedidos_materiales depe_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales ALTER COLUMN depe_id SET DEFAULT nextval('alm.alm_deta_pedidos_materiales_depe_id_seq'::regclass);
 O   ALTER TABLE alm.alm_deta_pedidos_materiales ALTER COLUMN depe_id DROP DEFAULT;
       alm          postgres    false    213    212            �           2604    24559 %   alm_deta_recepcion_materiales dere_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales ALTER COLUMN dere_id SET DEFAULT nextval('alm.alm_deta_recepcion_materiales_dere_id_seq'::regclass);
 Q   ALTER TABLE alm.alm_deta_recepcion_materiales ALTER COLUMN dere_id DROP DEFAULT;
       alm          postgres    false    215    214            �           2604    24560    alm_entrega_materiales enma_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_entrega_materiales ALTER COLUMN enma_id SET DEFAULT nextval('alm.alm_entrega_materiales_enma_id_seq'::regclass);
 J   ALTER TABLE alm.alm_entrega_materiales ALTER COLUMN enma_id DROP DEFAULT;
       alm          postgres    false    217    216            �           2604    24561    alm_lotes lote_id    DEFAULT     p   ALTER TABLE ONLY alm.alm_lotes ALTER COLUMN lote_id SET DEFAULT nextval('alm.alm_lotes_lote_id_seq'::regclass);
 =   ALTER TABLE alm.alm_lotes ALTER COLUMN lote_id DROP DEFAULT;
       alm          postgres    false    219    218            �           2604    24562    alm_pedidos_materiales pema_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_pedidos_materiales ALTER COLUMN pema_id SET DEFAULT nextval('alm.alm_pedidos_materiales_pema_id_seq'::regclass);
 J   ALTER TABLE alm.alm_pedidos_materiales ALTER COLUMN pema_id DROP DEFAULT;
       alm          postgres    false    221    220            �           2604    24563    alm_proveedores prov_id    DEFAULT     |   ALTER TABLE ONLY alm.alm_proveedores ALTER COLUMN prov_id SET DEFAULT nextval('alm.alm_proveedores_prov_id_seq'::regclass);
 C   ALTER TABLE alm.alm_proveedores ALTER COLUMN prov_id DROP DEFAULT;
       alm          postgres    false    224    222            �           2604    24564     alm_recepcion_materiales rema_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_recepcion_materiales ALTER COLUMN rema_id SET DEFAULT nextval('alm.alm_recepcion_materiales_rema_id_seq'::regclass);
 L   ALTER TABLE alm.alm_recepcion_materiales ALTER COLUMN rema_id DROP DEFAULT;
       alm          postgres    false    226    225            �           2604    24565    deta_ajustes deaj_id    DEFAULT     v   ALTER TABLE ONLY alm.deta_ajustes ALTER COLUMN deaj_id SET DEFAULT nextval('alm.deta_ajustes_deaj_id_seq'::regclass);
 @   ALTER TABLE alm.deta_ajustes ALTER COLUMN deaj_id DROP DEFAULT;
       alm          postgres    false    228    227            �           2604    24566    items item_id    DEFAULT     h   ALTER TABLE ONLY alm.items ALTER COLUMN item_id SET DEFAULT nextval('alm.items_item_id_seq'::regclass);
 9   ALTER TABLE alm.items ALTER COLUMN item_id DROP DEFAULT;
       alm          postgres    false    230    229            �           2604    24567    utl_tablas tabl_id    DEFAULT     r   ALTER TABLE ONLY alm.utl_tablas ALTER COLUMN tabl_id SET DEFAULT nextval('alm.utl_tablas_tabl_id_seq'::regclass);
 >   ALTER TABLE alm.utl_tablas ALTER COLUMN tabl_id DROP DEFAULT;
       alm          postgres    false    232    231            �           2604    24568    departamentos depa_id    DEFAULT     z   ALTER TABLE ONLY core.departamentos ALTER COLUMN depa_id SET DEFAULT nextval('core.departamentos_depa_id_seq'::regclass);
 B   ALTER TABLE core.departamentos ALTER COLUMN depa_id DROP DEFAULT;
       core          postgres    false    234    233            �           2604    24569    empresas empr_id    DEFAULT     p   ALTER TABLE ONLY core.empresas ALTER COLUMN empr_id SET DEFAULT nextval('core.empresas_empr_id_seq'::regclass);
 =   ALTER TABLE core.empresas ALTER COLUMN empr_id DROP DEFAULT;
       core          postgres    false    236    235            �           2604    24570    equipos equi_id    DEFAULT     n   ALTER TABLE ONLY core.equipos ALTER COLUMN equi_id SET DEFAULT nextval('core.equipos_equi_id_seq'::regclass);
 <   ALTER TABLE core.equipos ALTER COLUMN equi_id DROP DEFAULT;
       core          postgres    false    238    237                        2604    24571    snapshots id    DEFAULT     h   ALTER TABLE ONLY core.snapshots ALTER COLUMN id SET DEFAULT nextval('core.snapshots_id_seq'::regclass);
 9   ALTER TABLE core.snapshots ALTER COLUMN id DROP DEFAULT;
       core          postgres    false    241    240            �           2604    24572    tito id    DEFAULT     ^   ALTER TABLE ONLY core.tito ALTER COLUMN id SET DEFAULT nextval('core.tito_id_seq'::regclass);
 4   ALTER TABLE core.tito ALTER COLUMN id DROP DEFAULT;
       core          postgres    false    318    317                       2604    24573    zonas zona_id    DEFAULT     j   ALTER TABLE ONLY core.zonas ALTER COLUMN zona_id SET DEFAULT nextval('core.zonas_zona_id_seq'::regclass);
 :   ALTER TABLE core.zonas ALTER COLUMN zona_id DROP DEFAULT;
       core          postgres    false    244    243                       2604    24574    actas_infraccion acin_id    DEFAULT     }   ALTER TABLE ONLY fis.actas_infraccion ALTER COLUMN acin_id SET DEFAULT nextval('fis.acta_infraccion_acin_id_seq'::regclass);
 D   ALTER TABLE fis.actas_infraccion ALTER COLUMN acin_id DROP DEFAULT;
       fis          postgres    false    246    245                       2604    24575    formularios form_id    DEFAULT     t   ALTER TABLE ONLY frm.formularios ALTER COLUMN form_id SET DEFAULT nextval('frm.formularios_form_id_seq'::regclass);
 ?   ALTER TABLE frm.formularios ALTER COLUMN form_id DROP DEFAULT;
       frm          postgres    false    248    247                       2604    24576    instancias_items init_id    DEFAULT     ~   ALTER TABLE ONLY frm.instancias_items ALTER COLUMN init_id SET DEFAULT nextval('frm.instancias_items_init_id_seq'::regclass);
 D   ALTER TABLE frm.instancias_items ALTER COLUMN init_id DROP DEFAULT;
       frm          postgres    false    250    249                       2604    24577    items item_id    DEFAULT     h   ALTER TABLE ONLY frm.items ALTER COLUMN item_id SET DEFAULT nextval('frm.items_item_id_seq'::regclass);
 9   ALTER TABLE frm.items ALTER COLUMN item_id DROP DEFAULT;
       frm          postgres    false    252    251                       2604    24578    incidencias inci_id    DEFAULT     t   ALTER TABLE ONLY ins.incidencias ALTER COLUMN inci_id SET DEFAULT nextval('ins.incidencias_inci_id_seq'::regclass);
 ?   ALTER TABLE ins.incidencias ALTER COLUMN inci_id DROP DEFAULT;
       ins          postgres    false    254    253            !           2604    24579    choferes chof_id    DEFAULT     n   ALTER TABLE ONLY log.choferes ALTER COLUMN chof_id SET DEFAULT nextval('log.choferes_chof_id_seq'::regclass);
 <   ALTER TABLE log.choferes ALTER COLUMN chof_id DROP DEFAULT;
       log          postgres    false    256    255            %           2604    24580    circuitos circ_id    DEFAULT     q   ALTER TABLE ONLY log.circuitos ALTER COLUMN circ_id SET DEFAULT nextval('log.circuitos_circu_id_seq'::regclass);
 =   ALTER TABLE log.circuitos ALTER COLUMN circ_id DROP DEFAULT;
       log          postgres    false    258    257            -           2604    24581    contenedores cont_id    DEFAULT     t   ALTER TABLE ONLY log.contenedores ALTER COLUMN cont_id SET DEFAULT nextval('log.containers_cont_id_seq'::regclass);
 @   ALTER TABLE log.contenedores ALTER COLUMN cont_id DROP DEFAULT;
       log          postgres    false    261    260            0           2604    24582    contenedores_entregados coen_id    DEFAULT     �   ALTER TABLE ONLY log.contenedores_entregados ALTER COLUMN coen_id SET DEFAULT nextval('log.contenedores_entregados_coen_id_seq'::regclass);
 K   ALTER TABLE log.contenedores_entregados ALTER COLUMN coen_id DROP DEFAULT;
       log          postgres    false    263    262            6           2604    24583    ordenes_transporte ortr_id    DEFAULT     �   ALTER TABLE ONLY log.ordenes_transporte ALTER COLUMN ortr_id SET DEFAULT nextval('log.ordenes_transporte_ortr_id_seq'::regclass);
 F   ALTER TABLE log.ordenes_transporte ALTER COLUMN ortr_id DROP DEFAULT;
       log          postgres    false    267    266            <           2604    24584    puntos_criticos pucr_id    DEFAULT     |   ALTER TABLE ONLY log.puntos_criticos ALTER COLUMN pucr_id SET DEFAULT nextval('log.puntos_criticos_pucr_id_seq'::regclass);
 C   ALTER TABLE log.puntos_criticos ALTER COLUMN pucr_id DROP DEFAULT;
       log          postgres    false    269    268            @           2604    24585    solicitantes_transporte sotr_id    DEFAULT     �   ALTER TABLE ONLY log.solicitantes_transporte ALTER COLUMN sotr_id SET DEFAULT nextval('log.solicitantes_transporte_sotr_id_seq'::regclass);
 K   ALTER TABLE log.solicitantes_transporte ALTER COLUMN sotr_id DROP DEFAULT;
       log          postgres    false    271    270            D           2604    24586    solicitudes_contenedor soco_id    DEFAULT     �   ALTER TABLE ONLY log.solicitudes_contenedor ALTER COLUMN soco_id SET DEFAULT nextval('log.solicitudes_contenedores_soco_id_seq'::regclass);
 J   ALTER TABLE log.solicitudes_contenedor ALTER COLUMN soco_id DROP DEFAULT;
       log          postgres    false    273    272            �           2604    24587 "   templates_orden_transporte teot_id    DEFAULT     �   ALTER TABLE ONLY log.templates_orden_transporte ALTER COLUMN teot_id SET DEFAULT nextval('log.templates_orden_transporte_teot_id_seq'::regclass);
 N   ALTER TABLE log.templates_orden_transporte ALTER COLUMN teot_id DROP DEFAULT;
       log          postgres    false    316    315    316            V           2604    24588    transportistas tran_id    DEFAULT     z   ALTER TABLE ONLY log.transportistas ALTER COLUMN tran_id SET DEFAULT nextval('log.transportistas_tran_id_seq'::regclass);
 B   ALTER TABLE log.transportistas ALTER COLUMN tran_id DROP DEFAULT;
       log          postgres    false    280    279            Z           2604    24589    empaque empa_id    DEFAULT     l   ALTER TABLE ONLY prd.empaque ALTER COLUMN empa_id SET DEFAULT nextval('prd.empaque_empa_id_seq'::regclass);
 ;   ALTER TABLE prd.empaque ALTER COLUMN empa_id DROP DEFAULT;
       prd          postgres    false    283    282            \           2604    24590    establecimientos esta_id    DEFAULT     ~   ALTER TABLE ONLY prd.establecimientos ALTER COLUMN esta_id SET DEFAULT nextval('prd.establecimientos_esta_id_seq'::regclass);
 D   ALTER TABLE prd.establecimientos ALTER COLUMN esta_id DROP DEFAULT;
       prd          postgres    false    285    284            `           2604    24591    etapas etap_id    DEFAULT     j   ALTER TABLE ONLY prd.etapas ALTER COLUMN etap_id SET DEFAULT nextval('prd.etapas_etap_id_seq'::regclass);
 :   ALTER TABLE prd.etapas ALTER COLUMN etap_id DROP DEFAULT;
       prd          postgres    false    287    286            �           2604    24592    formulas form_id    DEFAULT     n   ALTER TABLE ONLY prd.formulas ALTER COLUMN form_id SET DEFAULT nextval('prd.formulas_form_id_seq'::regclass);
 <   ALTER TABLE prd.formulas ALTER COLUMN form_id DROP DEFAULT;
       prd          postgres    false    324    322            c           2604    24593    fraccionamientos frac_id    DEFAULT     ~   ALTER TABLE ONLY prd.fraccionamientos ALTER COLUMN frac_id SET DEFAULT nextval('prd.fraccionamientos_frac_id_seq'::regclass);
 D   ALTER TABLE prd.fraccionamientos ALTER COLUMN frac_id DROP DEFAULT;
       prd          postgres    false    291    290            g           2604    24594    lotes batch_id    DEFAULT     j   ALTER TABLE ONLY prd.lotes ALTER COLUMN batch_id SET DEFAULT nextval('prd.lotes_batch_id_seq'::regclass);
 :   ALTER TABLE prd.lotes ALTER COLUMN batch_id DROP DEFAULT;
       prd          postgres    false    293    292            n           2604    24595    movimientos_trasportes motr_id    DEFAULT     �   ALTER TABLE ONLY prd.movimientos_trasportes ALTER COLUMN motr_id SET DEFAULT nextval('prd.movimientos_trasportes_motr_id_seq'::regclass);
 J   ALTER TABLE prd.movimientos_trasportes ALTER COLUMN motr_id DROP DEFAULT;
       prd          postgres    false    296    295            q           2604    24596    procesos proc_id    DEFAULT     o   ALTER TABLE ONLY prd.procesos ALTER COLUMN proc_id SET DEFAULT nextval('prd.productos_prod_id_seq'::regclass);
 <   ALTER TABLE prd.procesos ALTER COLUMN proc_id DROP DEFAULT;
       prd          postgres    false    298    297            w           2604    24597    recipientes reci_id    DEFAULT     s   ALTER TABLE ONLY prd.recipientes ALTER COLUMN reci_id SET DEFAULT nextval('prd.recipiente_reci_id_seq'::regclass);
 ?   ALTER TABLE prd.recipientes ALTER COLUMN reci_id DROP DEFAULT;
       prd          postgres    false    300    299            }           2604    24598    recursos recu_id    DEFAULT     n   ALTER TABLE ONLY prd.recursos ALTER COLUMN recu_id SET DEFAULT nextval('prd.recursos_recu_id_seq'::regclass);
 <   ALTER TABLE prd.recursos ALTER COLUMN recu_id DROP DEFAULT;
       prd          postgres    false    303    301            �           2604    24599    settings id    DEFAULT     d   ALTER TABLE ONLY seg.settings ALTER COLUMN id SET DEFAULT nextval('seg.settings_id_seq'::regclass);
 7   ALTER TABLE seg.settings ALTER COLUMN id DROP DEFAULT;
       seg          postgres    false    307    306    307            �           2604    24600 	   tokens id    DEFAULT     `   ALTER TABLE ONLY seg.tokens ALTER COLUMN id SET DEFAULT nextval('seg.tokens_id_seq'::regclass);
 5   ALTER TABLE seg.tokens ALTER COLUMN id DROP DEFAULT;
       seg          postgres    false    308    309    309            �           2604    24601    users id    DEFAULT     ^   ALTER TABLE ONLY seg.users ALTER COLUMN id SET DEFAULT nextval('seg.users_id_seq'::regclass);
 4   ALTER TABLE seg.users ALTER COLUMN id DROP DEFAULT;
       seg          postgres    false    311    310    311            ,          0    21654    ajustes 
   TABLE DATA           l   COPY alm.ajustes (ajus_id, tipo_ajuste, justificacion, usuario_app, empr_id, fec_alta, usuario) FROM stdin;
    alm          postgres    false    204            .          0    21664    alm_articulos 
   TABLE DATA           �   COPY alm.alm_articulos (arti_id, barcode, descripcion, costo, es_caja, cantidad_caja, punto_pedido, estado, unidad_medida, empr_id, es_loteado, fec_alta, eliminado, tipo) FROM stdin;
    alm          postgres    false    206   i        0          0    21675    alm_depositos 
   TABLE DATA           �   COPY alm.alm_depositos (depo_id, descripcion, direccion, gps, estado, loca_id, pais_id, empr_id, fec_alta, eliminado, esta_id, reci_id, "row", col) FROM stdin;
    alm          postgres    false    208   �       2          0    21690    alm_deta_entrega_materiales 
   TABLE DATA           �   COPY alm.alm_deta_entrega_materiales (deen_id, enma_id, cantidad, arti_id, prov_id, lote_id, depo_id, empr_id, precio, fec_alta, eliminado) FROM stdin;
    alm          postgres    false    210   �        4          0    21697    alm_deta_pedidos_materiales 
   TABLE DATA           �   COPY alm.alm_deta_pedidos_materiales (depe_id, cantidad, resto, fecha_entrega, fecha_entregado, pema_id, arti_id, fec_alta, eliminado) FROM stdin;
    alm          postgres    false    212           6          0    21704    alm_deta_recepcion_materiales 
   TABLE DATA           �   COPY alm.alm_deta_recepcion_materiales (dere_id, cantidad, precio, empr_id, rema_id, lote_id, prov_id, arti_id, fec_alta, eliminado) FROM stdin;
    alm          postgres    false    214           8          0    21711    alm_entrega_materiales 
   TABLE DATA           �   COPY alm.alm_entrega_materiales (enma_id, fecha, solicitante, dni, comprobante, empr_id, pema_id, fec_alta, eliminado) FROM stdin;
    alm          postgres    false    216   `        :          0    21721 	   alm_lotes 
   TABLE DATA           �   COPY alm.alm_lotes (lote_id, prov_id, arti_id, depo_id, codigo, fec_vencimiento, cantidad, empr_id, user_id, estado, fec_alta, eliminado, batch_id) FROM stdin;
    alm          postgres    false    218           <          0    21733    alm_pedidos_materiales 
   TABLE DATA           �   COPY alm.alm_pedidos_materiales (pema_id, fecha, motivo_rechazo, justificacion, case_id, ortr_id, estado, empr_id, fec_alta, eliminado, batch_id) FROM stdin;
    alm          postgres    false    220           >          0    21746    alm_proveedores 
   TABLE DATA           w   COPY alm.alm_proveedores (prov_id, nombre, cuit, domicilio, telefono, email, empr_id, fec_alta, eliminado) FROM stdin;
    alm          postgres    false    222           ?          0    21759    alm_proveedores_articulos 
   TABLE DATA           B   COPY alm.alm_proveedores_articulos (prov_id, arti_id) FROM stdin;
    alm          postgres    false    223   �        A          0    21764    alm_recepcion_materiales 
   TABLE DATA           }   COPY alm.alm_recepcion_materiales (rema_id, fecha, comprobante, empr_id, prov_id, fec_alta, eliminado, batch_id) FROM stdin;
    alm          postgres    false    225           C          0    21771    deta_ajustes 
   TABLE DATA           d   COPY alm.deta_ajustes (deaj_id, cantidad, empr_id, fec_alta, usuario, lote_id, ajus_id) FROM stdin;
    alm          postgres    false    227   K        E          0    21781    items 
   TABLE DATA           �   COPY alm.items (item_id, label, name, requerido, tipo_dato, valo_id, orden, aux, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, form_id) FROM stdin;
    alm          postgres    false    229           G          0    21791 
   utl_tablas 
   TABLE DATA           Z   COPY alm.utl_tablas (tabl_id, tabla, valor, descripcion, fec_alta, eliminado) FROM stdin;
    alm          postgres    false    231           I          0    21798    departamentos 
   TABLE DATA           V   COPY core.departamentos (depa_id, nombre, descripcion, fec_alta, usuario) FROM stdin;
    core          postgres    false    233   �       K          0    21808    empresas 
   TABLE DATA           �   COPY core.empresas (empr_id, descripcion, cuit, direccion, telefono, email, imagepath, loca_id, prov_id, pais_id, lat, lng, celular, zona_id, clie_id) FROM stdin;
    core          postgres    false    235   ~        M          0    21816    equipos 
   TABLE DATA           �  COPY core.equipos (equi_id, descripcion, marca, codigo, ubicacion, estado, fecha_ultimalectura, ultima_lectura, tipo_horas, valor_reposicion, fecha_reposicion, valor, comprobante, descrip_tecnica, numero_serie, adjunto, meta_disponibilidad, fecha_ingreso, fecha_baja, fecha_garantia, prov_id, empr_id, sect_id, ubic_id, grup_id, crit_id, unme_id, area_id, proc_id, tran_id, dominio, imagen, tara, cont_id) FROM stdin;
    core          postgres    false    237   '        O          0    21828    log 
   TABLE DATA           '   COPY core.log (msg, fecha) FROM stdin;
    core          postgres    false    239           P          0    21835 	   snapshots 
   TABLE DATA           I   COPY core.snapshots (id, snap_id, data, fec_alta, eliminado) FROM stdin;
    core          postgres    false    240   (        R          0    21845    tablas 
   TABLE DATA           p   COPY core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) FROM stdin;
    core          postgres    false    242           �          0    24500    tito 
   TABLE DATA           )   COPY core.tito (id, column1) FROM stdin;
    core          postgres    false    317   5       �          0    24508    transportistas 
   TABLE DATA           Z   COPY core.transportistas (cuit, razon_social, direccion, fec_alta, eliminado) FROM stdin;
    core          postgres    false    319           S          0    21870    zonas 
   TABLE DATA           w   COPY core.zonas (zona_id, nombre, descripcion, imagen, fec_alta, usuario, usuario_app, depa_id, eliminado) FROM stdin;
    core          postgres    false    243           U          0    21881    actas_infraccion 
   TABLE DATA           �   COPY fis.actas_infraccion (acin_id, numero_acta, descripcion, tipo, sotr_id, inspector_id, tran_id, destino, fecha_creacion, usuario_app, eliminado, usuario) FROM stdin;
    fis          postgres    false    245          W          0    21892    formularios 
   TABLE DATA           ^   COPY frm.formularios (form_id, nombre, descripcion, eliminado, fec_alta, usuario) FROM stdin;
    frm          postgres    false    247           Y          0    21903    instancias_items 
   TABLE DATA           �   COPY frm.instancias_items (init_id, label, name, valor, requerido, tida_id, valo_id, info_id, form_id, orden, aux, eliminado, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, item_id) FROM stdin;
    frm          postgres    false    249           [          0    21915    items 
   TABLE DATA           �   COPY frm.items (item_id, label, name, requerido, tipo_dato, valo_id, orden, aux, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, form_id) FROM stdin;
    frm          postgres    false    251           ]          0    21925    incidencias 
   TABLE DATA           �   COPY ins.incidencias (inci_id, descripcion, fecha, num_acta, adjunto, fec_alta, usuario, usuario_app, tiin_id, tica_id, difi_id, ortr_id, eliminado, estado) FROM stdin;
    ins          postgres    false    253           _          0    21935    choferes 
   TABLE DATA           �   COPY log.choferes (chof_id, nombre, apellido, documento, fec_nacimiento, direccion, celular, codigo, carnet, vencimiento, habilitacion, imagen, fec_alta, usuario, tran_id, cach_id, eliminado, usuario_app) FROM stdin;
    log          postgres    false    255           �          0    24516    cierre_sector_descarga 
   TABLE DATA           ^   COPY log.cierre_sector_descarga (estado, fec_alta, usuario, usuario_app, cisd_id) FROM stdin;
    log          postgres    false    320   �       a          0    21946 	   circuitos 
   TABLE DATA           �   COPY log.circuitos (circ_id, codigo, descripcion, imagen, fec_alta, usuario, usuario_app, chof_id, vehi_id, zona_id, eliminado) FROM stdin;
    log          postgres    false    257           c          0    21957    circuitos_puntos_criticos 
   TABLE DATA           `   COPY log.circuitos_puntos_criticos (fec_alta, usuario, circ_id, pucr_id, eliminado) FROM stdin;
    log          postgres    false    259           d          0    21966    contenedores 
   TABLE DATA           �   COPY log.contenedores (cont_id, codigo, descripcion, capacidad, tara, habilitacion, fec_alta, usuario, usuario_app, esco_id, reci_id, anio_elaboracion, tran_id, eliminado, imagen) FROM stdin;
    log          postgres    false    260           f          0    21978    contenedores_entregados 
   TABLE DATA           :  COPY log.contenedores_entregados (coen_id, porc_llenado, mts_cubicos, fec_entrega, fec_retiro, fec_alta, usuario, usuario_app, cont_id, soco_id, sore_id, ortr_id, tica_id, depo_id, peso_neto, difi_id, equi_id, equi_id_entrega, batch_id, foto, tiva_id, observaciones_descarga, fec_descarga, fec_salida) FROM stdin;
    log          postgres    false    262           i          0    21990    contenedores_solicitados 
   TABLE DATA           �   COPY log.contenedores_solicitados (coso_id, cantidad, otro, fec_alta, usuario, usuario_app, tica_id, soco_id, reci_id, cantidad_acordada, motivo_rechazo) FROM stdin;
    log          postgres    false    265           j          0    21999    ordenes_transporte 
   TABLE DATA           �   COPY log.ordenes_transporte (ortr_id, fec_retiro, estado, fec_alta, usuario, difi_id, sotr_id, equi_id, chof_id, case_id, usuario_app, eliminado, tran_id, teot_id) FROM stdin;
    log          postgres    false    266           l          0    22010    puntos_criticos 
   TABLE DATA           �   COPY log.puntos_criticos (pucr_id, nombre, descripcion, lat, lng, fec_alta, usuario, usuario_app, zona_id, eliminado) FROM stdin;
    log          postgres    false    268           n          0    22021    solicitantes_transporte 
   TABLE DATA           �   COPY log.solicitantes_transporte (sotr_id, razon_social, cuit, domicilio, num_registro, lat, lng, usuario, fec_alta, usuario_app, zona_id, rubr_id, tist_id, eliminado, depa_id, prov_id, user_id) FROM stdin;
    log          postgres    false    270   N       p          0    22032    solicitudes_contenedor 
   TABLE DATA           �   COPY log.solicitudes_contenedor (soco_id, estado, observaciones, fec_alta, usuario, usuario_app, sotr_id, case_id, eliminado, tran_id) FROM stdin;
    log          postgres    false    272   �        s          0    22046    solicitudes_retiro 
   TABLE DATA           w   COPY log.solicitudes_retiro (sore_id, fec_alta, usuario, usuario_app, sotr_id, eliminado, case_id, estado) FROM stdin;
    log          postgres    false    275           �          0    24447    templates_orden_transporte 
   TABLE DATA           �   COPY log.templates_orden_transporte (teot_id, observaciones, eliminado, fec_alta, usuario, usuario_app, circ_id, equi_id, chof_id, tica_id, difi_id, sotr_id) FROM stdin;
    log          postgres    false    316           t          0    22056    tipos_carga_circuitos 
   TABLE DATA           Q   COPY log.tipos_carga_circuitos (fec_alta, usuario, circ_id, tica_id) FROM stdin;
    log          postgres    false    276           u          0    22064    tipos_carga_contenedores 
   TABLE DATA           _   COPY log.tipos_carga_contenedores (fec_alta, usuario, cont_id, tica_id, eliminado) FROM stdin;
    log          postgres    false    277           �          0    23468    tipos_carga_generadores 
   TABLE DATA           @   COPY log.tipos_carga_generadores (tica_id, sotr_id) FROM stdin;
    log          postgres    false    304           v          0    22073    tipos_carga_transportistas 
   TABLE DATA           V   COPY log.tipos_carga_transportistas (fec_alta, usuario, tran_id, tica_id) FROM stdin;
    log          postgres    false    278   +        w          0    22081    transportistas 
   TABLE DATA           �   COPY log.transportistas (tran_id, razon_social, descripcion, direccion, telefono, contacto, resolucion, registro, fec_alta_efectiva, fec_baja_efectiva, fec_alta, usuario, usuario_app, eliminado, cuit, user_id) FROM stdin;
    log          postgres    false    279   ?        y          0    22092    costos 
   TABLE DATA           ]   COPY prd.costos (fec_vigencia, valor, umed, fec_alta, usuario, recu_id, empr_id) FROM stdin;
    prd          postgres    false    281   �        z          0    22100    empaque 
   TABLE DATA           u   COPY prd.empaque (empa_id, nombre, unidad_medida, capacidad, empr_id, usuario_app, eliminado, fech_alta) FROM stdin;
    prd          postgres    false    282           |          0    22109    establecimientos 
   TABLE DATA           �   COPY prd.establecimientos (esta_id, nombre, lng, lat, calle, altura, localidad, estado, pais, fec_alta, usuario, empr_id) FROM stdin;
    prd          postgres    false    284   ^        ~          0    22118    etapas 
   TABLE DATA           {   COPY prd.etapas (etap_id, nombre, nom_recipiente, fec_alta, usuario, proc_id, eliminado, empr_id, orden, link) FROM stdin;
    prd          postgres    false    286   $       �          0    22129    etapas_materiales 
   TABLE DATA           :   COPY prd.etapas_materiales (etap_id, arti_id) FROM stdin;
    prd          postgres    false    288   �        �          0    22132    etapas_productos 
   TABLE DATA           9   COPY prd.etapas_productos (etap_id, arti_id) FROM stdin;
    prd          postgres    false    289   #        �          0    24524    etapas_salidas 
   TABLE DATA           7   COPY prd.etapas_salidas (etap_id, arti_id) FROM stdin;
    prd          postgres    false    321   !        �          0    24527    formulas 
   TABLE DATA              COPY prd.formulas (form_id, descripcion, cantidad, eliminado, aplicacion, fec_alta, usuario, usuario_app, unme_id) FROM stdin;
    prd          postgres    false    322           �          0    24536    formulas_articulos 
   TABLE DATA           a   COPY prd.formulas_articulos (cantidad, fec_alta, usuario, unme_id, form_id, arti_id) FROM stdin;
    prd          postgres    false    323           �          0    22135    fraccionamientos 
   TABLE DATA           g   COPY prd.fraccionamientos (frac_id, recu_id, empa_id, cantidad, fecha, eliminado, empr_id) FROM stdin;
    prd          postgres    false    290           �          0    22142    lotes 
   TABLE DATA           �   COPY prd.lotes (lote_id, batch_id, estado, num_orden_prod, fec_alta, usuario, etap_id, eliminado, nombre, reci_id, empr_id, usuario_app, arti_id) FROM stdin;
    prd          postgres    false    292           �          0    22153    lotes_hijos 
   TABLE DATA           }   COPY prd.lotes_hijos (batch_id, batch_id_padre, fec_alta, usuario, eliminado, empr_id, cantidad, cantidad_padre) FROM stdin;
    prd          postgres    false    294           �          0    24546    lotes_responsables 
   TABLE DATA           X   COPY prd.lotes_responsables (fec_alta, usuario, batch_id, user_id, turn_id) FROM stdin;
    prd          postgres    false    325           �          0    22162    movimientos_trasportes 
   TABLE DATA           �   COPY prd.movimientos_trasportes (motr_id, boleta, fecha_entrada, patente, acoplado, conductor, tipo, bruto, tara, neto, prov_id, esta_id, fec_alta, eliminado, estado, reci_id, transportista, cuit, accion) FROM stdin;
    prd          postgres    false    295           �          0    22173    procesos 
   TABLE DATA           L   COPY prd.procesos (proc_id, nombre, fec_alta, usuario, empr_id) FROM stdin;
    prd          postgres    false    297           �          0    22183    recipientes 
   TABLE DATA           �   COPY prd.recipientes (reci_id, tipo, estado, nombre, fec_alta, usuario, eliminado, empr_id, depo_id, motr_id, "row", col, care_id) FROM stdin;
    prd          postgres    false    299   9        �          0    22198    recursos 
   TABLE DATA           �   COPY prd.recursos (recu_id, tipo, cant_capacidad, umed_capacidad, cant_tiempo_capacidad, umed_iempo_capacidad, fec_alta, usuario, arti_id, empr_id, equi_id) FROM stdin;
    prd          postgres    false    301   �        �          0    22207    recursos_lotes 
   TABLE DATA           |   COPY prd.recursos_lotes (batch_id, recu_id, fec_alta, usuario, empr_id, cantidad, tipo, empa_id, empa_cantidad) FROM stdin;
    prd          postgres    false    302           �          0    24426    memberships_menues 
   TABLE DATA           h   COPY seg.memberships_menues (modulo, opcion, "group", role, fec_alta, usuario, usuario_app) FROM stdin;
    seg          postgres    false    314           �          0    24393    memberships_users 
   TABLE DATA           ^   COPY seg.memberships_users ("group", role, fec_alta, usuario, usuario_app, email) FROM stdin;
    seg          postgres    false    312           �          0    24408    menues 
   TABLE DATA           �   COPY seg.menues (modulo, opcion, texto, url, javascript, orden, url_icono, texto_onmouseover, eliminado, fec_alta, usuario, usuario_app, opcion_padre) FROM stdin;
    seg          postgres    false    313           �          0    24359    roles 
   TABLE DATA           N   COPY seg.roles (rol_id, nombre, descripcion, fec_alta, eliminado) FROM stdin;
    seg          postgres    false    305           �          0    24368    settings 
   TABLE DATA           K   COPY seg.settings (id, site_title, timezone, recaptcha, theme) FROM stdin;
    seg          postgres    false    307           �          0    24374    tokens 
   TABLE DATA           :   COPY seg.tokens (id, token, user_id, created) FROM stdin;
    seg          postgres    false    309   t        �          0    24382    users 
   TABLE DATA           �   COPY seg.users (id, email, first_name, last_name, role, password, last_login, status, banned_users, passmd5, telefono, dni, usernick, depo_id) FROM stdin;
    seg          postgres    false    311           �           0    0    ajustes_ajus_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('alm.ajustes_ajus_id_seq', 44, true);
          alm          postgres    false    205            �           0    0    alm_articulos_arti_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('alm.alm_articulos_arti_id_seq', 69, true);
          alm          postgres    false    207            �           0    0    alm_depositos_depo_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('alm.alm_depositos_depo_id_seq', 7, true);
          alm          postgres    false    209            �           0    0 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE SET     R   SELECT pg_catalog.setval('alm.alm_deta_entrega_materiales_deen_id_seq', 9, true);
          alm          postgres    false    211            �           0    0 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE SET     T   SELECT pg_catalog.setval('alm.alm_deta_pedidos_materiales_depe_id_seq', 143, true);
          alm          postgres    false    213            �           0    0 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE SET     T   SELECT pg_catalog.setval('alm.alm_deta_recepcion_materiales_dere_id_seq', 4, true);
          alm          postgres    false    215            �           0    0 "   alm_entrega_materiales_enma_id_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('alm.alm_entrega_materiales_enma_id_seq', 1, true);
          alm          postgres    false    217            �           0    0    alm_lotes_lote_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('alm.alm_lotes_lote_id_seq', 75, true);
          alm          postgres    false    219            �           0    0 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('alm.alm_pedidos_materiales_pema_id_seq', 197, true);
          alm          postgres    false    221            �           0    0    alm_proveedores_prov_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('alm.alm_proveedores_prov_id_seq', 6, true);
          alm          postgres    false    224            �           0    0 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('alm.alm_recepcion_materiales_rema_id_seq', 2, true);
          alm          postgres    false    226            �           0    0    deta_ajustes_deaj_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('alm.deta_ajustes_deaj_id_seq', 27, true);
          alm          postgres    false    228            �           0    0    items_item_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('alm.items_item_id_seq', 1, false);
          alm          postgres    false    230            �           0    0    utl_tablas_tabl_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('alm.utl_tablas_tabl_id_seq', 17, true);
          alm          postgres    false    232            �           0    0    departamentos_depa_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('core.departamentos_depa_id_seq', 9, true);
          core          postgres    false    234            �           0    0    empresas_empr_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('core.empresas_empr_id_seq', 1, true);
          core          postgres    false    236            �           0    0    equipos_equi_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('core.equipos_equi_id_seq', 46, true);
          core          postgres    false    238            �           0    0    snapshots_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('core.snapshots_id_seq', 58, true);
          core          postgres    false    241            �           0    0    tito_id_seq    SEQUENCE SET     8   SELECT pg_catalog.setval('core.tito_id_seq', 1, false);
          core          postgres    false    318            �           0    0    zonas_zona_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('core.zonas_zona_id_seq', 127, true);
          core          postgres    false    244            �           0    0    acta_infraccion_acin_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('fis.acta_infraccion_acin_id_seq', 1, false);
          fis          postgres    false    246            �           0    0    formularios_form_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('frm.formularios_form_id_seq', 1, false);
          frm          postgres    false    248            �           0    0    instancias_items_init_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('frm.instancias_items_init_id_seq', 1, false);
          frm          postgres    false    250            �           0    0    items_item_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('frm.items_item_id_seq', 1, false);
          frm          postgres    false    252            �           0    0    incidencias_inci_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('ins.incidencias_inci_id_seq', 5, true);
          ins          postgres    false    254            �           0    0    choferes_chof_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('log.choferes_chof_id_seq', 51, true);
          log          postgres    false    256            �           0    0    circuitos_circu_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('log.circuitos_circu_id_seq', 160, true);
          log          postgres    false    258            �           0    0    containers_cont_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('log.containers_cont_id_seq', 119, true);
          log          postgres    false    261            �           0    0 #   contenedores_entregados_coen_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('log.contenedores_entregados_coen_id_seq', 6, true);
          log          postgres    false    263            �           0    0 $   contenedores_solicitados_coso_id_seq    SEQUENCE SET     Q   SELECT pg_catalog.setval('log.contenedores_solicitados_coso_id_seq', 143, true);
          log          postgres    false    264            �           0    0    ordenes_transporte_ortr_id_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('log.ordenes_transporte_ortr_id_seq', 21, true);
          log          postgres    false    267                        0    0    puntos_criticos_pucr_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('log.puntos_criticos_pucr_id_seq', 223, true);
          log          postgres    false    269                       0    0 #   solicitantes_transporte_sotr_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('log.solicitantes_transporte_sotr_id_seq', 53, true);
          log          postgres    false    271                       0    0 $   solicitudes_contenedores_soco_id_seq    SEQUENCE SET     P   SELECT pg_catalog.setval('log.solicitudes_contenedores_soco_id_seq', 78, true);
          log          postgres    false    273                       0    0    solicitudes_retiro_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('log.solicitudes_retiro_seq', 23, true);
          log          postgres    false    274                       0    0 &   templates_orden_transporte_teot_id_seq    SEQUENCE SET     R   SELECT pg_catalog.setval('log.templates_orden_transporte_teot_id_seq', 1, false);
          log          postgres    false    315                       0    0    transportistas_tran_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('log.transportistas_tran_id_seq', 54, true);
          log          postgres    false    280                       0    0    empaque_empa_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('prd.empaque_empa_id_seq', 5, true);
          prd          postgres    false    283                       0    0    establecimientos_esta_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('prd.establecimientos_esta_id_seq', 4, true);
          prd          postgres    false    285                       0    0    etapas_etap_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('prd.etapas_etap_id_seq', 1, true);
          prd          postgres    false    287            	           0    0    formulas_form_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('prd.formulas_form_id_seq', 1, false);
          prd          postgres    false    324            
           0    0    fraccionamientos_frac_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('prd.fraccionamientos_frac_id_seq', 3, true);
          prd          postgres    false    291                       0    0    lotes_batch_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('prd.lotes_batch_id_seq', 192, true);
          prd          postgres    false    293                       0    0 "   movimientos_trasportes_motr_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('prd.movimientos_trasportes_motr_id_seq', 31, true);
          prd          postgres    false    296                       0    0    productos_prod_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('prd.productos_prod_id_seq', 1, true);
          prd          postgres    false    298                       0    0    recipiente_reci_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('prd.recipiente_reci_id_seq', 179, true);
          prd          postgres    false    300                       0    0    recursos_recu_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('prd.recursos_recu_id_seq', 16, true);
          prd          postgres    false    303                       0    0    settings_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('seg.settings_id_seq', 1, false);
          seg          postgres    false    306                       0    0    tokens_id_seq    SEQUENCE SET     9   SELECT pg_catalog.setval('seg.tokens_id_seq', 1, false);
          seg          postgres    false    308                       0    0    users_id_seq    SEQUENCE SET     8   SELECT pg_catalog.setval('seg.users_id_seq', 1, false);
          seg          postgres    false    310            �           2606    22271    ajustes ajustes_pk 
   CONSTRAINT     R   ALTER TABLE ONLY alm.ajustes
    ADD CONSTRAINT ajustes_pk PRIMARY KEY (ajus_id);
 9   ALTER TABLE ONLY alm.ajustes DROP CONSTRAINT ajustes_pk;
       alm            postgres    false    204            �           2606    22273     alm_articulos alm_articulos_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY alm.alm_articulos
    ADD CONSTRAINT alm_articulos_pkey PRIMARY KEY (arti_id);
 G   ALTER TABLE ONLY alm.alm_articulos DROP CONSTRAINT alm_articulos_pkey;
       alm            postgres    false    206            �           2606    24603    alm_articulos alm_articulos_un 
   CONSTRAINT     Y   ALTER TABLE ONLY alm.alm_articulos
    ADD CONSTRAINT alm_articulos_un UNIQUE (barcode);
 E   ALTER TABLE ONLY alm.alm_articulos DROP CONSTRAINT alm_articulos_un;
       alm            postgres    false    206            �           2606    22275     alm_depositos alm_depositos_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY alm.alm_depositos
    ADD CONSTRAINT alm_depositos_pkey PRIMARY KEY (depo_id);
 G   ALTER TABLE ONLY alm.alm_depositos DROP CONSTRAINT alm_depositos_pkey;
       alm            postgres    false    208            �           2606    22277 <   alm_deta_entrega_materiales alm_deta_entrega_materiales_pkey 
   CONSTRAINT     |   ALTER TABLE ONLY alm.alm_deta_entrega_materiales
    ADD CONSTRAINT alm_deta_entrega_materiales_pkey PRIMARY KEY (deen_id);
 c   ALTER TABLE ONLY alm.alm_deta_entrega_materiales DROP CONSTRAINT alm_deta_entrega_materiales_pkey;
       alm            postgres    false    210            �           2606    22279 <   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_pkey 
   CONSTRAINT     |   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_pkey PRIMARY KEY (depe_id);
 c   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_pkey;
       alm            postgres    false    212            �           2606    22281 @   alm_deta_recepcion_materiales alm_deta_recepcion_materiales_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales
    ADD CONSTRAINT alm_deta_recepcion_materiales_pkey PRIMARY KEY (dere_id);
 g   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales DROP CONSTRAINT alm_deta_recepcion_materiales_pkey;
       alm            postgres    false    214            �           2606    22283 2   alm_entrega_materiales alm_entrega_materiales_pkey 
   CONSTRAINT     r   ALTER TABLE ONLY alm.alm_entrega_materiales
    ADD CONSTRAINT alm_entrega_materiales_pkey PRIMARY KEY (enma_id);
 Y   ALTER TABLE ONLY alm.alm_entrega_materiales DROP CONSTRAINT alm_entrega_materiales_pkey;
       alm            postgres    false    216            �           2606    22285    alm_lotes alm_lotes_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_pkey PRIMARY KEY (lote_id);
 ?   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_pkey;
       alm            postgres    false    218            �           2606    22287 2   alm_pedidos_materiales alm_pedidos_materiales_pkey 
   CONSTRAINT     r   ALTER TABLE ONLY alm.alm_pedidos_materiales
    ADD CONSTRAINT alm_pedidos_materiales_pkey PRIMARY KEY (pema_id);
 Y   ALTER TABLE ONLY alm.alm_pedidos_materiales DROP CONSTRAINT alm_pedidos_materiales_pkey;
       alm            postgres    false    220            �           2606    22289 8   alm_proveedores_articulos alm_proveedores_articulos_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_pkey PRIMARY KEY (prov_id, arti_id);
 _   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_pkey;
       alm            postgres    false    223    223            �           2606    22291 $   alm_proveedores alm_proveedores_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY alm.alm_proveedores
    ADD CONSTRAINT alm_proveedores_pkey PRIMARY KEY (prov_id);
 K   ALTER TABLE ONLY alm.alm_proveedores DROP CONSTRAINT alm_proveedores_pkey;
       alm            postgres    false    222            �           2606    22293 6   alm_recepcion_materiales alm_recepcion_materiales_pkey 
   CONSTRAINT     v   ALTER TABLE ONLY alm.alm_recepcion_materiales
    ADD CONSTRAINT alm_recepcion_materiales_pkey PRIMARY KEY (rema_id);
 ]   ALTER TABLE ONLY alm.alm_recepcion_materiales DROP CONSTRAINT alm_recepcion_materiales_pkey;
       alm            postgres    false    225            �           2606    22295    deta_ajustes deta_ajustes_pk 
   CONSTRAINT     \   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_pk PRIMARY KEY (deaj_id);
 C   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_pk;
       alm            postgres    false    227            �           2606    22297    items items_pk 
   CONSTRAINT     N   ALTER TABLE ONLY alm.items
    ADD CONSTRAINT items_pk PRIMARY KEY (item_id);
 5   ALTER TABLE ONLY alm.items DROP CONSTRAINT items_pk;
       alm            postgres    false    229            �           2606    22299    utl_tablas utl_tablas_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY alm.utl_tablas
    ADD CONSTRAINT utl_tablas_pkey PRIMARY KEY (tabl_id);
 A   ALTER TABLE ONLY alm.utl_tablas DROP CONSTRAINT utl_tablas_pkey;
       alm            postgres    false    231            �           2606    22301    departamentos departamentos_pk 
   CONSTRAINT     _   ALTER TABLE ONLY core.departamentos
    ADD CONSTRAINT departamentos_pk PRIMARY KEY (depa_id);
 F   ALTER TABLE ONLY core.departamentos DROP CONSTRAINT departamentos_pk;
       core            postgres    false    233            �           2606    22303    empresas empresas_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY core.empresas
    ADD CONSTRAINT empresas_pkey PRIMARY KEY (empr_id);
 >   ALTER TABLE ONLY core.empresas DROP CONSTRAINT empresas_pkey;
       core            postgres    false    235            �           2606    22305    equipos equipos_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY core.equipos
    ADD CONSTRAINT equipos_pkey PRIMARY KEY (equi_id);
 <   ALTER TABLE ONLY core.equipos DROP CONSTRAINT equipos_pkey;
       core            postgres    false    237            �           2606    24753    snapshots snapshots_pk 
   CONSTRAINT     W   ALTER TABLE ONLY core.snapshots
    ADD CONSTRAINT snapshots_pk PRIMARY KEY (snap_id);
 >   ALTER TABLE ONLY core.snapshots DROP CONSTRAINT snapshots_pk;
       core            postgres    false    240            �           2606    22307    tablas tablas_pk 
   CONSTRAINT     Q   ALTER TABLE ONLY core.tablas
    ADD CONSTRAINT tablas_pk PRIMARY KEY (tabl_id);
 8   ALTER TABLE ONLY core.tablas DROP CONSTRAINT tablas_pk;
       core            postgres    false    242            1           2606    24607    tito tito_pk 
   CONSTRAINT     H   ALTER TABLE ONLY core.tito
    ADD CONSTRAINT tito_pk PRIMARY KEY (id);
 4   ALTER TABLE ONLY core.tito DROP CONSTRAINT tito_pk;
       core            postgres    false    317            3           2606    24609     transportistas transportistas_pk 
   CONSTRAINT     ^   ALTER TABLE ONLY core.transportistas
    ADD CONSTRAINT transportistas_pk PRIMARY KEY (cuit);
 H   ALTER TABLE ONLY core.transportistas DROP CONSTRAINT transportistas_pk;
       core            postgres    false    319            �           2606    22311    zonas zonas_pk 
   CONSTRAINT     O   ALTER TABLE ONLY core.zonas
    ADD CONSTRAINT zonas_pk PRIMARY KEY (zona_id);
 6   ALTER TABLE ONLY core.zonas DROP CONSTRAINT zonas_pk;
       core            postgres    false    243            �           2606    22313 #   actas_infraccion acta_infraccion_pk 
   CONSTRAINT     c   ALTER TABLE ONLY fis.actas_infraccion
    ADD CONSTRAINT acta_infraccion_pk PRIMARY KEY (acin_id);
 J   ALTER TABLE ONLY fis.actas_infraccion DROP CONSTRAINT acta_infraccion_pk;
       fis            postgres    false    245            �           2606    22315    formularios formularios_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY frm.formularios
    ADD CONSTRAINT formularios_pk PRIMARY KEY (form_id);
 A   ALTER TABLE ONLY frm.formularios DROP CONSTRAINT formularios_pk;
       frm            postgres    false    247            �           2606    22317 $   instancias_items instancias_items_pk 
   CONSTRAINT     d   ALTER TABLE ONLY frm.instancias_items
    ADD CONSTRAINT instancias_items_pk PRIMARY KEY (init_id);
 K   ALTER TABLE ONLY frm.instancias_items DROP CONSTRAINT instancias_items_pk;
       frm            postgres    false    249            �           2606    22319    items items_pk 
   CONSTRAINT     N   ALTER TABLE ONLY frm.items
    ADD CONSTRAINT items_pk PRIMARY KEY (item_id);
 5   ALTER TABLE ONLY frm.items DROP CONSTRAINT items_pk;
       frm            postgres    false    251            �           2606    22321    incidencias incidencias_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY ins.incidencias
    ADD CONSTRAINT incidencias_pk PRIMARY KEY (inci_id);
 A   ALTER TABLE ONLY ins.incidencias DROP CONSTRAINT incidencias_pk;
       ins            postgres    false    253            �           2606    22323    choferes choferes_dni_un 
   CONSTRAINT     U   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_dni_un UNIQUE (documento);
 ?   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_dni_un;
       log            postgres    false    255            �           2606    22325    choferes choferes_pk 
   CONSTRAINT     T   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_pk PRIMARY KEY (chof_id);
 ;   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_pk;
       log            postgres    false    255            5           2606    24611 0   cierre_sector_descarga cierre_sector_descarga_pk 
   CONSTRAINT     z   ALTER TABLE ONLY log.cierre_sector_descarga
    ADD CONSTRAINT cierre_sector_descarga_pk PRIMARY KEY (fec_alta, cisd_id);
 W   ALTER TABLE ONLY log.cierre_sector_descarga DROP CONSTRAINT cierre_sector_descarga_pk;
       log            postgres    false    320    320            �           2606    22327    circuitos circuitos_pk 
   CONSTRAINT     V   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_pk PRIMARY KEY (circ_id);
 =   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_pk;
       log            postgres    false    257            �           2606    22329 6   circuitos_puntos_criticos circuitos_puntos_criticos_pk 
   CONSTRAINT        ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_pk PRIMARY KEY (circ_id, pucr_id);
 ]   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_pk;
       log            postgres    false    259    259            �           2606    22331    circuitos circuitos_un 
   CONSTRAINT     P   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_un UNIQUE (codigo);
 =   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_un;
       log            postgres    false    257            �           2606    22333 !   contenedores containers_codigo_un 
   CONSTRAINT     [   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_codigo_un UNIQUE (codigo);
 H   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_codigo_un;
       log            postgres    false    260            �           2606    22335    contenedores containers_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_pk PRIMARY KEY (cont_id);
 A   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_pk;
       log            postgres    false    260            �           2606    24613 2   contenedores_entregados contenedores_entregados_pk 
   CONSTRAINT     r   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_pk PRIMARY KEY (coen_id);
 Y   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_pk;
       log            postgres    false    262            �           2606    24615 2   contenedores_entregados contenedores_entregados_un 
   CONSTRAINT     v   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_un UNIQUE (cont_id, ortr_id);
 Y   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_un;
       log            postgres    false    262    262            �           2606    22337    contenedores contenedores_un 
   CONSTRAINT     W   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT contenedores_un UNIQUE (cont_id);
 C   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT contenedores_un;
       log            postgres    false    260            �           2606    22339 7   contenedores_solicitados deta_solicitudes_contenedor_pk 
   CONSTRAINT     w   ALTER TABLE ONLY log.contenedores_solicitados
    ADD CONSTRAINT deta_solicitudes_contenedor_pk PRIMARY KEY (coso_id);
 ^   ALTER TABLE ONLY log.contenedores_solicitados DROP CONSTRAINT deta_solicitudes_contenedor_pk;
       log            postgres    false    265            �           2606    22341 (   ordenes_transporte ordenes_transporte_pk 
   CONSTRAINT     h   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_pk PRIMARY KEY (ortr_id);
 O   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_pk;
       log            postgres    false    266            �           2606    22343 "   puntos_criticos puntos_criticos_pk 
   CONSTRAINT     b   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_pk PRIMARY KEY (pucr_id);
 I   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_pk;
       log            postgres    false    268            �           2606    22345 "   puntos_criticos puntos_criticos_un 
   CONSTRAINT     \   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_un UNIQUE (nombre);
 I   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_un;
       log            postgres    false    268            �           2606    22347 1   solicitantes_transporte solcitantes_transporte_pk 
   CONSTRAINT     q   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_pk PRIMARY KEY (sotr_id);
 X   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_pk;
       log            postgres    false    270            �           2606    22349 2   solicitantes_transporte solicitantes_transporte_un 
   CONSTRAINT     j   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solicitantes_transporte_un UNIQUE (cuit);
 Y   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solicitantes_transporte_un;
       log            postgres    false    270            �           2606    22351 2   solicitudes_contenedor solicitudes_contenedores_pk 
   CONSTRAINT     r   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedores_pk PRIMARY KEY (soco_id);
 Y   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedores_pk;
       log            postgres    false    272            �           2606    22353 (   solicitudes_retiro solicitudes_retiro_pk 
   CONSTRAINT     h   ALTER TABLE ONLY log.solicitudes_retiro
    ADD CONSTRAINT solicitudes_retiro_pk PRIMARY KEY (sore_id);
 O   ALTER TABLE ONLY log.solicitudes_retiro DROP CONSTRAINT solicitudes_retiro_pk;
       log            postgres    false    275            /           2606    24458 8   templates_orden_transporte templates_orden_transporte_un 
   CONSTRAINT     s   ALTER TABLE ONLY log.templates_orden_transporte
    ADD CONSTRAINT templates_orden_transporte_un UNIQUE (teot_id);
 _   ALTER TABLE ONLY log.templates_orden_transporte DROP CONSTRAINT templates_orden_transporte_un;
       log            postgres    false    316            �           2606    22355 .   tipos_carga_circuitos tipos_carga_circuitos_pk 
   CONSTRAINT     w   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_carga_circuitos_pk PRIMARY KEY (circ_id, tica_id);
 U   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_carga_circuitos_pk;
       log            postgres    false    276    276                       2606    22357 8   tipos_carga_transportistas tipos_carga_transportistas_pk 
   CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_pk PRIMARY KEY (tran_id, tica_id);
 _   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_pk;
       log            postgres    false    278    278                       2606    22359     transportistas transportistas_pk 
   CONSTRAINT     `   ALTER TABLE ONLY log.transportistas
    ADD CONSTRAINT transportistas_pk PRIMARY KEY (tran_id);
 G   ALTER TABLE ONLY log.transportistas DROP CONSTRAINT transportistas_pk;
       log            postgres    false    279                       2606    22361     transportistas transportistas_un 
   CONSTRAINT     `   ALTER TABLE ONLY log.transportistas
    ADD CONSTRAINT transportistas_un UNIQUE (razon_social);
 G   ALTER TABLE ONLY log.transportistas DROP CONSTRAINT transportistas_un;
       log            postgres    false    279                       2606    22363    costos costos_pk 
   CONSTRAINT     ^   ALTER TABLE ONLY prd.costos
    ADD CONSTRAINT costos_pk PRIMARY KEY (fec_vigencia, recu_id);
 7   ALTER TABLE ONLY prd.costos DROP CONSTRAINT costos_pk;
       prd            postgres    false    281    281            	           2606    22365    empaque empaque_pk 
   CONSTRAINT     R   ALTER TABLE ONLY prd.empaque
    ADD CONSTRAINT empaque_pk PRIMARY KEY (empa_id);
 9   ALTER TABLE ONLY prd.empaque DROP CONSTRAINT empaque_pk;
       prd            postgres    false    282                       2606    22367 $   establecimientos establecimientos_pk 
   CONSTRAINT     d   ALTER TABLE ONLY prd.establecimientos
    ADD CONSTRAINT establecimientos_pk PRIMARY KEY (esta_id);
 K   ALTER TABLE ONLY prd.establecimientos DROP CONSTRAINT establecimientos_pk;
       prd            postgres    false    284                       2606    22369 &   etapas_materiales etapas_materiales_un 
   CONSTRAINT     j   ALTER TABLE ONLY prd.etapas_materiales
    ADD CONSTRAINT etapas_materiales_un UNIQUE (etap_id, arti_id);
 M   ALTER TABLE ONLY prd.etapas_materiales DROP CONSTRAINT etapas_materiales_un;
       prd            postgres    false    288    288                       2606    22371    etapas etapas_pk 
   CONSTRAINT     P   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_pk PRIMARY KEY (etap_id);
 7   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_pk;
       prd            postgres    false    286                       2606    22373 $   etapas_productos etapas_productos_un 
   CONSTRAINT     h   ALTER TABLE ONLY prd.etapas_productos
    ADD CONSTRAINT etapas_productos_un UNIQUE (etap_id, arti_id);
 K   ALTER TABLE ONLY prd.etapas_productos DROP CONSTRAINT etapas_productos_un;
       prd            postgres    false    289    289            7           2606    24617     etapas_salidas etapas_salidas_un 
   CONSTRAINT     d   ALTER TABLE ONLY prd.etapas_salidas
    ADD CONSTRAINT etapas_salidas_un UNIQUE (etap_id, arti_id);
 G   ALTER TABLE ONLY prd.etapas_salidas DROP CONSTRAINT etapas_salidas_un;
       prd            postgres    false    321    321                       2606    22375    etapas etapas_un 
   CONSTRAINT     S   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_un UNIQUE (nombre, proc_id);
 7   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_un;
       prd            postgres    false    286    286                       2606    22377    etapas etapas_un_2 
   CONSTRAINT     T   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_un_2 UNIQUE (orden, proc_id);
 9   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_un_2;
       prd            postgres    false    286    286            9           2606    24619    formulas formulas_pk 
   CONSTRAINT     T   ALTER TABLE ONLY prd.formulas
    ADD CONSTRAINT formulas_pk PRIMARY KEY (form_id);
 ;   ALTER TABLE ONLY prd.formulas DROP CONSTRAINT formulas_pk;
       prd            postgres    false    322                       2606    22379    lotes lotes_un 
   CONSTRAINT     J   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_un UNIQUE (batch_id);
 5   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_un;
       prd            postgres    false    292                       2606    22381 0   movimientos_trasportes movimientos_trasportes_pk 
   CONSTRAINT     p   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_pk PRIMARY KEY (motr_id);
 W   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_pk;
       prd            postgres    false    295                       2606    22383    procesos productos_pk 
   CONSTRAINT     U   ALTER TABLE ONLY prd.procesos
    ADD CONSTRAINT productos_pk PRIMARY KEY (proc_id);
 <   ALTER TABLE ONLY prd.procesos DROP CONSTRAINT productos_pk;
       prd            postgres    false    297                       2606    22385    procesos productos_un 
   CONSTRAINT     O   ALTER TABLE ONLY prd.procesos
    ADD CONSTRAINT productos_un UNIQUE (nombre);
 <   ALTER TABLE ONLY prd.procesos DROP CONSTRAINT productos_un;
       prd            postgres    false    297                       2606    22387    recipientes recipientes_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_pk PRIMARY KEY (reci_id);
 A   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_pk;
       prd            postgres    false    299            !           2606    22389    recursos recursos_pk 
   CONSTRAINT     T   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_pk PRIMARY KEY (recu_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_pk;
       prd            postgres    false    301            #           2606    22391    recursos recursos_un 
   CONSTRAINT     O   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_un UNIQUE (arti_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_un;
       prd            postgres    false    301            +           2606    24402     memberships_users memberships_pk 
   CONSTRAINT     m   ALTER TABLE ONLY seg.memberships_users
    ADD CONSTRAINT memberships_pk PRIMARY KEY ("group", role, email);
 G   ALTER TABLE ONLY seg.memberships_users DROP CONSTRAINT memberships_pk;
       seg            postgres    false    312    312    312            -           2606    24420    menues menues_pk 
   CONSTRAINT     W   ALTER TABLE ONLY seg.menues
    ADD CONSTRAINT menues_pk PRIMARY KEY (modulo, opcion);
 7   ALTER TABLE ONLY seg.menues DROP CONSTRAINT menues_pk;
       seg            postgres    false    313    313            %           2606    24379    tokens tokens_pk 
   CONSTRAINT     K   ALTER TABLE ONLY seg.tokens
    ADD CONSTRAINT tokens_pk PRIMARY KEY (id);
 7   ALTER TABLE ONLY seg.tokens DROP CONSTRAINT tokens_pk;
       seg            postgres    false    309            '           2606    24390    users users_pk 
   CONSTRAINT     I   ALTER TABLE ONLY seg.users
    ADD CONSTRAINT users_pk PRIMARY KEY (id);
 5   ALTER TABLE ONLY seg.users DROP CONSTRAINT users_pk;
       seg            postgres    false    311            )           2606    24392    users users_un 
   CONSTRAINT     G   ALTER TABLE ONLY seg.users
    ADD CONSTRAINT users_un UNIQUE (email);
 5   ALTER TABLE ONLY seg.users DROP CONSTRAINT users_un;
       seg            postgres    false    311            �           1259    24238    equipos_dominio_idx    INDEX     O   CREATE UNIQUE INDEX equipos_dominio_idx ON core.equipos USING btree (dominio);
 %   DROP INDEX core.equipos_dominio_idx;
       core            postgres    false    237            �           1259    24620    tablas_tabla_idx    INDEX     B   CREATE INDEX tablas_tabla_idx ON core.tablas USING btree (tabla);
 "   DROP INDEX core.tablas_tabla_idx;
       core            postgres    false    242            �           1259    24621    tablas_valor_idx    INDEX     B   CREATE INDEX tablas_valor_idx ON core.tablas USING btree (valor);
 "   DROP INDEX core.tablas_valor_idx;
       core            postgres    false    242            �           1259    22392 "   solicitudes_contenedor_case_id_idx    INDEX     e   CREATE INDEX solicitudes_contenedor_case_id_idx ON log.solicitudes_contenedor USING btree (case_id);
 3   DROP INDEX log.solicitudes_contenedor_case_id_idx;
       log            postgres    false    272            �           2620    22393 0   alm_deta_entrega_materiales asociar_lote_hijo_ai    TRIGGER     �   CREATE TRIGGER asociar_lote_hijo_ai AFTER INSERT ON alm.alm_deta_entrega_materiales FOR EACH ROW EXECUTE PROCEDURE prd.asociar_lote_hijo_trg();
 F   DROP TRIGGER asociar_lote_hijo_ai ON alm.alm_deta_entrega_materiales;
       alm          postgres    false    345    210            �           2620    22394    alm_articulos crear_producto_ai    TRIGGER        CREATE TRIGGER crear_producto_ai AFTER INSERT ON alm.alm_articulos FOR EACH ROW EXECUTE PROCEDURE prd.crear_prd_recurso_trg();
 5   DROP TRIGGER crear_producto_ai ON alm.alm_articulos;
       alm          postgres    false    347    206            �           2620    22395 "   alm_articulos eliminar_producto_ad    TRIGGER     �   CREATE TRIGGER eliminar_producto_ad AFTER DELETE ON alm.alm_articulos FOR EACH ROW EXECUTE PROCEDURE prd.eliminar_prd_recurso_trg();
 8   DROP TRIGGER eliminar_producto_ad ON alm.alm_articulos;
       alm          postgres    false    206    348            �           2620    22396    tablas set_tabla_id_bui    TRIGGER        CREATE TRIGGER set_tabla_id_bui BEFORE INSERT OR UPDATE ON core.tablas FOR EACH ROW EXECUTE PROCEDURE core.set_tabla_id_trg();
 .   DROP TRIGGER set_tabla_id_bui ON core.tablas;
       core          postgres    false    327    242            �           2620    24626 &   contenedores_entregados crear_batch_bu    TRIGGER     �   CREATE TRIGGER crear_batch_bu BEFORE UPDATE ON log.contenedores_entregados FOR EACH ROW EXECUTE PROCEDURE log.crear_batch_contenedor_retirado_trg();
 <   DROP TRIGGER crear_batch_bu ON log.contenedores_entregados;
       log          postgres    false    351    262            �           2620    24627 *   solicitantes_transporte crear_proveedor_bi    TRIGGER     �   CREATE TRIGGER crear_proveedor_bi BEFORE INSERT ON log.solicitantes_transporte FOR EACH ROW EXECUTE PROCEDURE log.crear_proveedor_sotr_trg();
 @   DROP TRIGGER crear_proveedor_bi ON log.solicitantes_transporte;
       log          postgres    false    270    352            �           2620    22397    contenedores crear_recipiente    TRIGGER     }   CREATE TRIGGER crear_recipiente BEFORE INSERT ON log.contenedores FOR EACH ROW EXECUTE PROCEDURE prd.crear_prd_recipiente();
 3   DROP TRIGGER crear_recipiente ON log.contenedores;
       log          postgres    false    260    350            :           2606    22398    alm_articulos alm_articulos_fk    FK CONSTRAINT     {   ALTER TABLE ONLY alm.alm_articulos
    ADD CONSTRAINT alm_articulos_fk FOREIGN KEY (tipo) REFERENCES core.tablas(tabl_id);
 E   ALTER TABLE ONLY alm.alm_articulos DROP CONSTRAINT alm_articulos_fk;
       alm          postgres    false    206    242    4298            <           2606    22403 :   alm_deta_entrega_materiales alm_deta_entrega_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_entrega_materiales
    ADD CONSTRAINT alm_deta_entrega_materiales_fk FOREIGN KEY (enma_id) REFERENCES alm.alm_entrega_materiales(enma_id);
 a   ALTER TABLE ONLY alm.alm_deta_entrega_materiales DROP CONSTRAINT alm_deta_entrega_materiales_fk;
       alm          postgres    false    216    4271    210            =           2606    22408 :   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 a   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_fk;
       alm          postgres    false    212    206    4259            >           2606    22413 <   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_fk_1 FOREIGN KEY (pema_id) REFERENCES alm.alm_pedidos_materiales(pema_id);
 c   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_fk_1;
       alm          postgres    false    212    220    4275            ?           2606    24629 F   alm_deta_recepcion_materiales alm_deta_recepcion_materiales_rema_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales
    ADD CONSTRAINT alm_deta_recepcion_materiales_rema_id_fk FOREIGN KEY (rema_id) REFERENCES alm.alm_recepcion_materiales(rema_id);
 m   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales DROP CONSTRAINT alm_deta_recepcion_materiales_rema_id_fk;
       alm          postgres    false    214    4281    225            @           2606    22418 0   alm_entrega_materiales alm_entrega_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_entrega_materiales
    ADD CONSTRAINT alm_entrega_materiales_fk FOREIGN KEY (pema_id) REFERENCES alm.alm_pedidos_materiales(pema_id);
 W   ALTER TABLE ONLY alm.alm_entrega_materiales DROP CONSTRAINT alm_entrega_materiales_fk;
       alm          postgres    false    220    216    4275            ;           2606    22423 %   alm_depositos alm_establecimientos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_depositos
    ADD CONSTRAINT alm_establecimientos_fk FOREIGN KEY (esta_id) REFERENCES prd.establecimientos(esta_id);
 L   ALTER TABLE ONLY alm.alm_depositos DROP CONSTRAINT alm_establecimientos_fk;
       alm          postgres    false    284    4363    208            A           2606    22428    alm_lotes alm_lotes_fk    FK CONSTRAINT     |   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 =   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_fk;
       alm          postgres    false    206    218    4259            B           2606    22433    alm_lotes alm_lotes_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_fk_1 FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 ?   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_fk_1;
       alm          postgres    false    218    222    4277            D           2606    24634    alm_lotes alm_lotes_fk_7    FK CONSTRAINT     x   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_fk_7 FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 ?   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_fk_7;
       alm          postgres    false    218    4375    292            C           2606    22438    alm_lotes alm_lotes_lotes_fk    FK CONSTRAINT     |   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 C   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_lotes_fk;
       alm          postgres    false    4375    292    218            E           2606    24740 9   alm_pedidos_materiales alm_pedidos_materiales_batch_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_pedidos_materiales
    ADD CONSTRAINT alm_pedidos_materiales_batch_id_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 `   ALTER TABLE ONLY alm.alm_pedidos_materiales DROP CONSTRAINT alm_pedidos_materiales_batch_id_fk;
       alm          postgres    false    220    4375    292            F           2606    22443 6   alm_proveedores_articulos alm_proveedores_articulos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 ]   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_fk;
       alm          postgres    false    223    4259    206            G           2606    22448 8   alm_proveedores_articulos alm_proveedores_articulos_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_fk_1 FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 _   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_fk_1;
       alm          postgres    false    222    4277    223            H           2606    22453 4   alm_recepcion_materiales alm_recepcion_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_recepcion_materiales
    ADD CONSTRAINT alm_recepcion_materiales_fk FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 [   ALTER TABLE ONLY alm.alm_recepcion_materiales DROP CONSTRAINT alm_recepcion_materiales_fk;
       alm          postgres    false    222    4277    225            I           2606    22458 $   deta_ajustes deta_ajustes_ajustes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_ajustes_fk FOREIGN KEY (ajus_id) REFERENCES alm.ajustes(ajus_id);
 K   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_ajustes_fk;
       alm          postgres    false    204    227    4257            J           2606    22463 &   deta_ajustes deta_ajustes_alm_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_alm_lotes_fk FOREIGN KEY (lote_id) REFERENCES alm.alm_lotes(lote_id);
 M   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_alm_lotes_fk;
       alm          postgres    false    4273    218    227            L           2606    24249    equipos equipos_equi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY core.equipos
    ADD CONSTRAINT equipos_equi_id_fk FOREIGN KEY (cont_id) REFERENCES log.contenedores(cont_id);
 B   ALTER TABLE ONLY core.equipos DROP CONSTRAINT equipos_equi_id_fk;
       core          postgres    false    237    4326    260            K           2606    24239    equipos equipos_tran_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY core.equipos
    ADD CONSTRAINT equipos_tran_id_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 B   ALTER TABLE ONLY core.equipos DROP CONSTRAINT equipos_tran_id_fk;
       core          postgres    false    4355    237    279            M           2606    22468    zonas zonas_fk    FK CONSTRAINT     v   ALTER TABLE ONLY core.zonas
    ADD CONSTRAINT zonas_fk FOREIGN KEY (depa_id) REFERENCES core.departamentos(depa_id);
 6   ALTER TABLE ONLY core.zonas DROP CONSTRAINT zonas_fk;
       core          postgres    false    233    4289    243            N           2606    22473 +   actas_infraccion solicitantes_transporte_fk    FK CONSTRAINT     �   ALTER TABLE ONLY fis.actas_infraccion
    ADD CONSTRAINT solicitantes_transporte_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 R   ALTER TABLE ONLY fis.actas_infraccion DROP CONSTRAINT solicitantes_transporte_fk;
       fis          postgres    false    4342    270    245            O           2606    22478 "   actas_infraccion transportistas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY fis.actas_infraccion
    ADD CONSTRAINT transportistas_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 I   ALTER TABLE ONLY fis.actas_infraccion DROP CONSTRAINT transportistas_fk;
       fis          postgres    false    4355    245    279            P           2606    22483 "   incidencias incidencias_difi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY ins.incidencias
    ADD CONSTRAINT incidencias_difi_id_fk FOREIGN KEY (difi_id) REFERENCES core.tablas(tabl_id);
 I   ALTER TABLE ONLY ins.incidencias DROP CONSTRAINT incidencias_difi_id_fk;
       ins          postgres    false    4298    242    253            Q           2606    22488 "   incidencias incidencias_ortr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY ins.incidencias
    ADD CONSTRAINT incidencias_ortr_id_fk FOREIGN KEY (ortr_id) REFERENCES log.ordenes_transporte(ortr_id);
 I   ALTER TABLE ONLY ins.incidencias DROP CONSTRAINT incidencias_ortr_id_fk;
       ins          postgres    false    253    266    4336            S           2606    22906 "   incidencias incidencias_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY ins.incidencias
    ADD CONSTRAINT incidencias_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 I   ALTER TABLE ONLY ins.incidencias DROP CONSTRAINT incidencias_tica_id_fk;
       ins          postgres    false    242    4298    253            R           2606    22493 "   incidencias incidencias_tiin_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY ins.incidencias
    ADD CONSTRAINT incidencias_tiin_id_fk FOREIGN KEY (tiin_id) REFERENCES core.tablas(tabl_id);
 I   ALTER TABLE ONLY ins.incidencias DROP CONSTRAINT incidencias_tiin_id_fk;
       ins          postgres    false    242    253    4298            T           2606    22503    choferes choferes_cach_id_fk    FK CONSTRAINT     |   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_cach_id_fk FOREIGN KEY (cach_id) REFERENCES core.tablas(tabl_id);
 C   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_cach_id_fk;
       log          postgres    false    4298    242    255            U           2606    22508    choferes choferes_tran_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_tran_id_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 C   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_tran_id_fk;
       log          postgres    false    279    4355    255            �           2606    24644 8   cierre_sector_descarga cierre_sector_descarga_cisc_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.cierre_sector_descarga
    ADD CONSTRAINT cierre_sector_descarga_cisc_id_fk FOREIGN KEY (cisd_id) REFERENCES core.tablas(tabl_id);
 _   ALTER TABLE ONLY log.cierre_sector_descarga DROP CONSTRAINT cierre_sector_descarga_cisc_id_fk;
       log          postgres    false    4298    242    320            W           2606    22513 6   circuitos_puntos_criticos circuitos_puntos_criticos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_fk FOREIGN KEY (circ_id) REFERENCES log.circuitos(circ_id);
 ]   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_fk;
       log          postgres    false    259    257    4318            X           2606    22518 8   circuitos_puntos_criticos circuitos_puntos_criticos_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_fk_1 FOREIGN KEY (pucr_id) REFERENCES log.puntos_criticos(pucr_id);
 _   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_fk_1;
       log          postgres    false    4338    259    268            V           2606    22523    circuitos circuitos_zona_id_fk    FK CONSTRAINT     }   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 E   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_zona_id_fk;
       log          postgres    false    243    257    4302            Y           2606    22528    contenedores containers_fk    FK CONSTRAINT     z   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_fk FOREIGN KEY (esco_id) REFERENCES core.tablas(tabl_id);
 A   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_fk;
       log          postgres    false    4298    242    260            Z           2606    22533 "   contenedores containers_reci_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_reci_id_fk FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 I   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_reci_id_fk;
       log          postgres    false    260    299    4383            d           2606    24754 ;   contenedores_entregados contenedores_entregados_batch_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_batch_id_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 b   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_batch_id_fk;
       log          postgres    false    292    4375    262            \           2606    22538 :   contenedores_entregados contenedores_entregados_cont_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_cont_id_fk FOREIGN KEY (cont_id) REFERENCES log.contenedores(cont_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_cont_id_fk;
       log          postgres    false    260    262    4326            a           2606    24228 9   contenedores_entregados contenedores_entregados_depo_idfk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_depo_idfk FOREIGN KEY (depo_id) REFERENCES alm.alm_depositos(depo_id);
 `   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_depo_idfk;
       log          postgres    false    4263    208    262            c           2606    24244 B   contenedores_entregados contenedores_entregados_equi_id_entrega_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_equi_id_entrega_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 i   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_equi_id_entrega_fk;
       log          postgres    false    237    262    4294            b           2606    24233 :   contenedores_entregados contenedores_entregados_equi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_equi_id_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_equi_id_fk;
       log          postgres    false    4294    237    262            ]           2606    22543 :   contenedores_entregados contenedores_entregados_ortr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_ortr_id_fk FOREIGN KEY (ortr_id) REFERENCES log.ordenes_transporte(ortr_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_ortr_id_fk;
       log          postgres    false    262    4336    266            ^           2606    22548 :   contenedores_entregados contenedores_entregados_soco_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_soco_id_fk FOREIGN KEY (soco_id) REFERENCES log.solicitudes_contenedor(soco_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_soco_id_fk;
       log          postgres    false    272    4347    262            _           2606    22553 :   contenedores_entregados contenedores_entregados_sore_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_sore_id_fk FOREIGN KEY (sore_id) REFERENCES log.solicitudes_retiro(sore_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_sore_id_fk;
       log          postgres    false    275    4349    262            `           2606    22558 :   contenedores_entregados contenedores_entregados_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_tica_id_fk;
       log          postgres    false    4298    242    262            e           2606    24759 :   contenedores_entregados contenedores_entregados_tiva_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_tiva_id_fk FOREIGN KEY (tiva_id) REFERENCES core.tablas(tabl_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_tiva_id_fk;
       log          postgres    false    262    4298    242            [           2606    22563    contenedores contenedores_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT contenedores_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 C   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT contenedores_fk;
       log          postgres    false    260    4355    279            f           2606    22568 <   contenedores_solicitados contenedores_solicitados_soco_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_solicitados
    ADD CONSTRAINT contenedores_solicitados_soco_id_fk FOREIGN KEY (soco_id) REFERENCES log.solicitudes_contenedor(soco_id);
 c   ALTER TABLE ONLY log.contenedores_solicitados DROP CONSTRAINT contenedores_solicitados_soco_id_fk;
       log          postgres    false    272    4347    265            g           2606    22573 ?   contenedores_solicitados deta_solicitudes_contenedor_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_solicitados
    ADD CONSTRAINT deta_solicitudes_contenedor_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 f   ALTER TABLE ONLY log.contenedores_solicitados DROP CONSTRAINT deta_solicitudes_contenedor_tica_id_fk;
       log          postgres    false    242    265    4298            h           2606    22578 0   ordenes_transporte ordenes_transporte_chof_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_chof_id_fk FOREIGN KEY (chof_id) REFERENCES log.choferes(documento);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_chof_id_fk;
       log          postgres    false    4314    255    266            i           2606    22583 0   ordenes_transporte ordenes_transporte_difi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_difi_id_fk FOREIGN KEY (difi_id) REFERENCES core.tablas(tabl_id);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_difi_id_fk;
       log          postgres    false    4298    242    266            j           2606    22588 0   ordenes_transporte ordenes_transporte_equi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_equi_id_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_equi_id_fk;
       log          postgres    false    237    4294    266            l           2606    24792 (   ordenes_transporte ordenes_transporte_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 O   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_fk;
       log          postgres    false    266    279    4355            k           2606    22593 0   ordenes_transporte ordenes_transporte_sotr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_sotr_id_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_sotr_id_fk;
       log          postgres    false    270    4342    266            m           2606    24797 0   ordenes_transporte ordenes_transporte_teot_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_teot_id_fk FOREIGN KEY (teot_id) REFERENCES log.templates_orden_transporte(teot_id);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_teot_id_fk;
       log          postgres    false    4399    266    316            n           2606    22598 *   puntos_criticos puntos_criticos_zona_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 Q   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_zona_id_fk;
       log          postgres    false    243    268    4302            o           2606    22603 9   solicitantes_transporte solcitantes_transporte_rubr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_rubr_id_fk FOREIGN KEY (rubr_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_rubr_id_fk;
       log          postgres    false    4298    270    242            p           2606    22613 9   solicitantes_transporte solcitantes_transporte_tisr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_tisr_id_fk FOREIGN KEY (tist_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_tisr_id_fk;
       log          postgres    false    270    242    4298            q           2606    22618 9   solicitantes_transporte solcitantes_transporte_zona_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_zona_id_fk;
       log          postgres    false    243    270    4302            r           2606    22623 :   solicitantes_transporte solicitantes_transporte_depa_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solicitantes_transporte_depa_id_fk FOREIGN KEY (depa_id) REFERENCES core.departamentos(depa_id);
 a   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solicitantes_transporte_depa_id_fk;
       log          postgres    false    270    4289    233            s           2606    24765 2   solicitantes_transporte solicitantes_transporte_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solicitantes_transporte_fk FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 Y   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solicitantes_transporte_fk;
       log          postgres    false    222    270    4277            t           2606    24770 8   solicitantes_transporte solicitantes_transporte_users_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solicitantes_transporte_users_fk FOREIGN KEY (user_id) REFERENCES seg.users(email);
 _   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solicitantes_transporte_users_fk;
       log          postgres    false    270    4393    311            u           2606    22628 0   solicitudes_contenedor solicitudes_contenedor_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedor_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 W   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedor_fk;
       log          postgres    false    272    4342    270            v           2606    23463 8   solicitudes_contenedor solicitudes_contenedor_tran_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedor_tran_id_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 _   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedor_tran_id_fk;
       log          postgres    false    272    4355    279            w           2606    22913 0   solicitudes_retiro solicitudes_retiro_sotr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitudes_retiro
    ADD CONSTRAINT solicitudes_retiro_sotr_id_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 W   ALTER TABLE ONLY log.solicitudes_retiro DROP CONSTRAINT solicitudes_retiro_sotr_id_fk;
       log          postgres    false    270    275    4342            �           2606    24459 @   templates_orden_transporte templates_orden_transporte_chof_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.templates_orden_transporte
    ADD CONSTRAINT templates_orden_transporte_chof_id_fk FOREIGN KEY (chof_id) REFERENCES log.choferes(documento);
 g   ALTER TABLE ONLY log.templates_orden_transporte DROP CONSTRAINT templates_orden_transporte_chof_id_fk;
       log          postgres    false    316    255    4314            �           2606    24464 @   templates_orden_transporte templates_orden_transporte_circ_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.templates_orden_transporte
    ADD CONSTRAINT templates_orden_transporte_circ_id_fk FOREIGN KEY (circ_id) REFERENCES log.circuitos(circ_id);
 g   ALTER TABLE ONLY log.templates_orden_transporte DROP CONSTRAINT templates_orden_transporte_circ_id_fk;
       log          postgres    false    316    257    4318            �           2606    24469 @   templates_orden_transporte templates_orden_transporte_difi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.templates_orden_transporte
    ADD CONSTRAINT templates_orden_transporte_difi_id_fk FOREIGN KEY (difi_id) REFERENCES core.tablas(tabl_id);
 g   ALTER TABLE ONLY log.templates_orden_transporte DROP CONSTRAINT templates_orden_transporte_difi_id_fk;
       log          postgres    false    316    242    4298            �           2606    24474 @   templates_orden_transporte templates_orden_transporte_equi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.templates_orden_transporte
    ADD CONSTRAINT templates_orden_transporte_equi_id_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 g   ALTER TABLE ONLY log.templates_orden_transporte DROP CONSTRAINT templates_orden_transporte_equi_id_fk;
       log          postgres    false    4294    237    316            �           2606    24479 @   templates_orden_transporte templates_orden_transporte_sotr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.templates_orden_transporte
    ADD CONSTRAINT templates_orden_transporte_sotr_id_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 g   ALTER TABLE ONLY log.templates_orden_transporte DROP CONSTRAINT templates_orden_transporte_sotr_id_fk;
       log          postgres    false    4342    270    316            �           2606    24484 @   templates_orden_transporte templates_orden_transporte_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.templates_orden_transporte
    ADD CONSTRAINT templates_orden_transporte_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 g   ALTER TABLE ONLY log.templates_orden_transporte DROP CONSTRAINT templates_orden_transporte_tica_id_fk;
       log          postgres    false    4298    316    242            x           2606    22638 6   tipos_carga_circuitos tipos_carga_circuitos_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_carga_circuitos_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 ]   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_carga_circuitos_tica_id_fk;
       log          postgres    false    242    276    4298            z           2606    22643 <   tipos_carga_contenedores tipos_carga_contenedores_cont_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_contenedores
    ADD CONSTRAINT tipos_carga_contenedores_cont_id_fk FOREIGN KEY (cont_id) REFERENCES log.contenedores(cont_id);
 c   ALTER TABLE ONLY log.tipos_carga_contenedores DROP CONSTRAINT tipos_carga_contenedores_cont_id_fk;
       log          postgres    false    4326    277    260            �           2606    23474 :   tipos_carga_generadores tipos_carga_generadores_sotr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_generadores
    ADD CONSTRAINT tipos_carga_generadores_sotr_id_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 a   ALTER TABLE ONLY log.tipos_carga_generadores DROP CONSTRAINT tipos_carga_generadores_sotr_id_fk;
       log          postgres    false    270    4342    304            �           2606    23479 :   tipos_carga_generadores tipos_carga_generadores_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_generadores
    ADD CONSTRAINT tipos_carga_generadores_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 a   ALTER TABLE ONLY log.tipos_carga_generadores DROP CONSTRAINT tipos_carga_generadores_tica_id_fk;
       log          postgres    false    304    4298    242            {           2606    22648 8   tipos_carga_transportistas tipos_carga_transportistas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 _   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_fk;
       log          postgres    false    278    4355    279            |           2606    22653 @   tipos_carga_transportistas tipos_carga_transportistas_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 g   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_tica_id_fk;
       log          postgres    false    278    4298    242            y           2606    22658 0   tipos_carga_circuitos tipos_residuo_circuitos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_residuo_circuitos_fk FOREIGN KEY (circ_id) REFERENCES log.circuitos(circ_id);
 W   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_residuo_circuitos_fk;
       log          postgres    false    257    4318    276            }           2606    24775 &   transportistas transportistas_users_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.transportistas
    ADD CONSTRAINT transportistas_users_fk FOREIGN KEY (user_id) REFERENCES seg.users(email);
 M   ALTER TABLE ONLY log.transportistas DROP CONSTRAINT transportistas_users_fk;
       log          postgres    false    279    4393    311            ~           2606    22663    costos costos_recursos_fk    FK CONSTRAINT     z   ALTER TABLE ONLY prd.costos
    ADD CONSTRAINT costos_recursos_fk FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id);
 @   ALTER TABLE ONLY prd.costos DROP CONSTRAINT costos_recursos_fk;
       prd          postgres    false    4385    281    301            �           2606    22668    fraccionamientos empa_id    FK CONSTRAINT     x   ALTER TABLE ONLY prd.fraccionamientos
    ADD CONSTRAINT empa_id FOREIGN KEY (empa_id) REFERENCES prd.empaque(empa_id);
 ?   ALTER TABLE ONLY prd.fraccionamientos DROP CONSTRAINT empa_id;
       prd          postgres    false    282    290    4361            �           2606    22673 "   etapas_materiales etapa-arti_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_materiales
    ADD CONSTRAINT "etapa-arti_id_fk" FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 K   ALTER TABLE ONLY prd.etapas_materiales DROP CONSTRAINT "etapa-arti_id_fk";
       prd          postgres    false    288    4259    206            �           2606    24649 .   etapas_materiales etapas_materiales_arti_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_materiales
    ADD CONSTRAINT etapas_materiales_arti_id_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 U   ALTER TABLE ONLY prd.etapas_materiales DROP CONSTRAINT etapas_materiales_arti_id_fk;
       prd          postgres    false    288    206    4259            �           2606    24654 .   etapas_materiales etapas_materiales_etap_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_materiales
    ADD CONSTRAINT etapas_materiales_etap_id_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id);
 U   ALTER TABLE ONLY prd.etapas_materiales DROP CONSTRAINT etapas_materiales_etap_id_fk;
       prd          postgres    false    288    4365    286                       2606    22678    etapas etapas_procesos_fk    FK CONSTRAINT     z   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_procesos_fk FOREIGN KEY (proc_id) REFERENCES prd.procesos(proc_id);
 @   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_procesos_fk;
       prd          postgres    false    4379    297    286            �           2606    24659 ,   etapas_productos etapas_productos_arti_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_productos
    ADD CONSTRAINT etapas_productos_arti_id_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 S   ALTER TABLE ONLY prd.etapas_productos DROP CONSTRAINT etapas_productos_arti_id_fk;
       prd          postgres    false    206    289    4259            �           2606    24664 ,   etapas_productos etapas_productos_etap_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_productos
    ADD CONSTRAINT etapas_productos_etap_id_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id);
 S   ALTER TABLE ONLY prd.etapas_productos DROP CONSTRAINT etapas_productos_etap_id_fk;
       prd          postgres    false    286    289    4365            �           2606    24669 (   etapas_salidas etapas_salidas_etap_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_salidas
    ADD CONSTRAINT etapas_salidas_etap_id_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id);
 O   ALTER TABLE ONLY prd.etapas_salidas DROP CONSTRAINT etapas_salidas_etap_id_fk;
       prd          postgres    false    4365    321    286            �           2606    24674     etapas_salidas etapas_salidas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_salidas
    ADD CONSTRAINT etapas_salidas_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 G   ALTER TABLE ONLY prd.etapas_salidas DROP CONSTRAINT etapas_salidas_fk;
       prd          postgres    false    206    321    4259            �           2606    24679 1   formulas_articulos formulas_articulos__unme_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.formulas_articulos
    ADD CONSTRAINT formulas_articulos__unme_id_fk FOREIGN KEY (unme_id) REFERENCES core.tablas(tabl_id);
 X   ALTER TABLE ONLY prd.formulas_articulos DROP CONSTRAINT formulas_articulos__unme_id_fk;
       prd          postgres    false    323    242    4298            �           2606    24684 0   formulas_articulos formulas_articulos_arti_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.formulas_articulos
    ADD CONSTRAINT formulas_articulos_arti_id_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 W   ALTER TABLE ONLY prd.formulas_articulos DROP CONSTRAINT formulas_articulos_arti_id_fk;
       prd          postgres    false    206    323    4259            �           2606    24689 0   formulas_articulos formulas_articulos_form_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.formulas_articulos
    ADD CONSTRAINT formulas_articulos_form_id_fk FOREIGN KEY (form_id) REFERENCES prd.formulas(form_id);
 W   ALTER TABLE ONLY prd.formulas_articulos DROP CONSTRAINT formulas_articulos_form_id_fk;
       prd          postgres    false    4409    323    322            �           2606    24694    formulas formulas_unme_id_fk    FK CONSTRAINT     |   ALTER TABLE ONLY prd.formulas
    ADD CONSTRAINT formulas_unme_id_fk FOREIGN KEY (unme_id) REFERENCES core.tablas(tabl_id);
 C   ALTER TABLE ONLY prd.formulas DROP CONSTRAINT formulas_unme_id_fk;
       prd          postgres    false    4298    322    242            �           2606    24699    lotes lotes_alm_articulos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_alm_articulos_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 C   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_alm_articulos_fk;
       prd          postgres    false    4259    292    206            �           2606    22683    lotes lotes_etapas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_etapas_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id) ON DELETE RESTRICT;
 <   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_etapas_fk;
       prd          postgres    false    4365    286    292            �           2606    22688    lotes lotes_fk    FK CONSTRAINT     t   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 5   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_fk;
       prd          postgres    false    292    4259    206            �           2606    22693     lotes_hijos lotes_hijos_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_hijos
    ADD CONSTRAINT lotes_hijos_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 G   ALTER TABLE ONLY prd.lotes_hijos DROP CONSTRAINT lotes_hijos_lotes_fk;
       prd          postgres    false    292    294    4375            �           2606    22698 '   lotes_hijos lotes_hijos_lotes_padres_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_hijos
    ADD CONSTRAINT lotes_hijos_lotes_padres_fk FOREIGN KEY (batch_id_padre) REFERENCES prd.lotes(batch_id);
 N   ALTER TABLE ONLY prd.lotes_hijos DROP CONSTRAINT lotes_hijos_lotes_padres_fk;
       prd          postgres    false    294    292    4375            �           2606    22703    lotes lotes_recipientes_fk    FK CONSTRAINT     ~   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_recipientes_fk FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 A   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_recipientes_fk;
       prd          postgres    false    4383    299    292            �           2606    24704 1   lotes_responsables lotes_responsables_batch_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_responsables
    ADD CONSTRAINT lotes_responsables_batch_id_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 X   ALTER TABLE ONLY prd.lotes_responsables DROP CONSTRAINT lotes_responsables_batch_id_fk;
       prd          postgres    false    325    4375    292            �           2606    24709 0   lotes_responsables lotes_responsables_turn_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_responsables
    ADD CONSTRAINT lotes_responsables_turn_id_fk FOREIGN KEY (turn_id) REFERENCES core.tablas(tabl_id);
 W   ALTER TABLE ONLY prd.lotes_responsables DROP CONSTRAINT lotes_responsables_turn_id_fk;
       prd          postgres    false    325    4298    242            �           2606    24714 0   lotes_responsables lotes_responsables_user_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_responsables
    ADD CONSTRAINT lotes_responsables_user_id_fk FOREIGN KEY (user_id) REFERENCES seg.users(id);
 W   ALTER TABLE ONLY prd.lotes_responsables DROP CONSTRAINT lotes_responsables_user_id_fk;
       prd          postgres    false    325    311    4391            �           2606    24719 ?   movimientos_trasportes movimientos_trasportes__transportista_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes__transportista_fk FOREIGN KEY (cuit) REFERENCES core.transportistas(cuit);
 f   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes__transportista_fk;
       prd          postgres    false    295    4403    319            �           2606    22713 0   movimientos_trasportes movimientos_trasportes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 W   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk;
       prd          postgres    false    4277    222    295            �           2606    22718 2   movimientos_trasportes movimientos_trasportes_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk_1 FOREIGN KEY (esta_id) REFERENCES prd.establecimientos(esta_id);
 Y   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk_1;
       prd          postgres    false    4363    295    284            �           2606    22723 2   movimientos_trasportes movimientos_trasportes_fk_2    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk_2 FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 Y   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk_2;
       prd          postgres    false    4383    295    299            �           2606    22728 (   recipientes recipientes_alm_depositos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_alm_depositos_fk FOREIGN KEY (depo_id) REFERENCES alm.alm_depositos(depo_id);
 O   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_alm_depositos_fk;
       prd          postgres    false    208    4263    299            �           2606    24786 "   recipientes recipientes_care_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_care_id_fk FOREIGN KEY (care_id) REFERENCES core.tablas(tabl_id);
 I   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_care_id_fk;
       prd          postgres    false    242    4298    299            �           2606    22733    recipientes recipientes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_fk FOREIGN KEY (motr_id) REFERENCES prd.movimientos_trasportes(motr_id);
 A   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_fk;
       prd          postgres    false    295    4377    299            �           2606    22738    fraccionamientos recu_id    FK CONSTRAINT     y   ALTER TABLE ONLY prd.fraccionamientos
    ADD CONSTRAINT recu_id FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id);
 ?   ALTER TABLE ONLY prd.fraccionamientos DROP CONSTRAINT recu_id;
       prd          postgres    false    290    301    4385            �           2606    22743    recursos recursos_fk    FK CONSTRAINT     u   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_fk;
       prd          postgres    false    301    4294    237            �           2606    22748 &   recursos_lotes recursos_lotes_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recursos_lotes
    ADD CONSTRAINT recursos_lotes_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id) ON DELETE RESTRICT;
 M   ALTER TABLE ONLY prd.recursos_lotes DROP CONSTRAINT recursos_lotes_lotes_fk;
       prd          postgres    false    302    4375    292            �           2606    22753 )   recursos_lotes recursos_lotes_recursos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recursos_lotes
    ADD CONSTRAINT recursos_lotes_recursos_fk FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id) ON DELETE RESTRICT;
 P   ALTER TABLE ONLY prd.recursos_lotes DROP CONSTRAINT recursos_lotes_recursos_fk;
       prd          postgres    false    302    301    4385            �           2606    24434 6   memberships_menues memberships_menues_modulo_opcion_fk    FK CONSTRAINT     �   ALTER TABLE ONLY seg.memberships_menues
    ADD CONSTRAINT memberships_menues_modulo_opcion_fk FOREIGN KEY (modulo, opcion) REFERENCES seg.menues(modulo, opcion);
 ]   ALTER TABLE ONLY seg.memberships_menues DROP CONSTRAINT memberships_menues_modulo_opcion_fk;
       seg          postgres    false    313    314    313    4397    314            �           2606    24403 &   memberships_users memberships_users_fk    FK CONSTRAINT     �   ALTER TABLE ONLY seg.memberships_users
    ADD CONSTRAINT memberships_users_fk FOREIGN KEY (email) REFERENCES seg.users(email);
 M   ALTER TABLE ONLY seg.memberships_users DROP CONSTRAINT memberships_users_fk;
       seg          postgres    false    311    312    4393            �           2606    24421    menues menues_opcion_padre_fk    FK CONSTRAINT     �   ALTER TABLE ONLY seg.menues
    ADD CONSTRAINT menues_opcion_padre_fk FOREIGN KEY (modulo, opcion_padre) REFERENCES seg.menues(modulo, opcion);
 D   ALTER TABLE ONLY seg.menues DROP CONSTRAINT menues_opcion_padre_fk;
       seg          postgres    false    313    4397    313    313    313           