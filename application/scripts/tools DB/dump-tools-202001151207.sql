PGDMP                          x            tools    11.4    11.2 �   �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false                        0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                       false                       1262    57611    tools    DATABASE     �   CREATE DATABASE tools WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Spanish_Argentina.1252' LC_CTYPE = 'Spanish_Argentina.1252';
    DROP DATABASE tools;
             postgres    false                        2615    65782    alm    SCHEMA        CREATE SCHEMA alm;
    DROP SCHEMA alm;
             postgres    false                        2615    57746    core    SCHEMA        CREATE SCHEMA core;
    DROP SCHEMA core;
             postgres    false                        2615    57752    frm    SCHEMA        CREATE SCHEMA frm;
    DROP SCHEMA frm;
             postgres    false                        2615    115082    log    SCHEMA        CREATE SCHEMA log;
    DROP SCHEMA log;
             postgres    false            
            2615    57612    prd    SCHEMA        CREATE SCHEMA prd;
    DROP SCHEMA prd;
             postgres    false                        2615    115083    sma    SCHEMA        CREATE SCHEMA sma;
    DROP SCHEMA sma;
             postgres    false            4           1255    82210 /   agregar_lote_articulo(bigint, double precision)    FUNCTION     ~  CREATE FUNCTION alm.agregar_lote_articulo(p_batch_id bigint, p_cantidad double precision) RETURNS character varying
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
		returning 1,cantidad)
		
	select count(1)
	from updated_lotes
	into strict v_cuenta
				,v_existencia;

	if v_cuenta = 0 then
    	    RAISE INFO 'ALMEXLO - no se encontro el batch id % ', p_batch_id;
    	    raise 'BATCH_INEXISTENTE';
    end if;

   	RAISE INFO 'ALMEXLO - actualizando el batch id % con cantidad %', p_batch_id,v_existencia;
    return 'CORRECTO';

exception
		when others then 
			raise;
end;
		
$$;
 Y   DROP FUNCTION alm.agregar_lote_articulo(p_batch_id bigint, p_cantidad double precision);
       alm       postgres    false    12            <           1255    106975 ;   ajuste_detalle_ingresar(integer, integer, double precision)    FUNCTION     �  CREATE FUNCTION alm.ajuste_detalle_ingresar(p_ajus_id integer, p_lote_id integer, p_cantidad double precision) RETURNS integer
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
       alm       postgres    false    12            %           1255    82203 j   crear_lote_articulo(integer, integer, integer, character varying, double precision, date, integer, bigint)    FUNCTION       CREATE FUNCTION alm.crear_lote_articulo(p_prov_id integer, p_arti_id integer, p_depo_id integer, p_codigo character varying, p_cantidad double precision, p_fec_vencimiento date, p_empr_id integer, p_batch_id bigint) RETURNS character varying
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
       alm       postgres    false    12            2           1255    82207 /   extraer_lote_articulo(bigint, double precision)    FUNCTION     �  CREATE FUNCTION alm.extraer_lote_articulo(p_batch_id bigint, p_cantidad double precision) RETURNS character varying
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
       alm       postgres    false    12            3           1255    82205     obtener_existencia_batch(bigint)    FUNCTION     t  CREATE FUNCTION alm.obtener_existencia_batch(p_batch_id bigint) RETURNS double precision
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
       alm       postgres    false    12            5           1255    74922    log(character varying) 	   PROCEDURE     *  CREATE PROCEDURE core.log(p_msg character varying)
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
       core       postgres    false    8            :           1255    115122    set_tabla_id_trg()    FUNCTION     �  CREATE FUNCTION core.set_tabla_id_trg() RETURNS trigger
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
       core       postgres    false    8            6           1255    98704    asociar_lote_hijo_trg()    FUNCTION     �
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
       prd       postgres    false    10            ;           1255    98706 m   cambiar_recipiente(bigint, integer, integer, integer, character varying, character varying, double precision)    FUNCTION     �  CREATE FUNCTION prd.cambiar_recipiente(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision DEFAULT 0) RETURNS character varying
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
		    	,lo.arti_id
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
		   
	        RAISE INFO 'batch, lote y ord prod = %, % , %', p_batch_id_origen,v_lote_id,v_num_orden_prod;

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
		   	prd.crear_lote(
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
       prd       postgres    false    10            9           1255    98670 �   crear_lote(character varying, integer, integer, bigint, double precision, double precision, character varying, integer, integer, character varying, integer, character varying, date, integer, character varying)    FUNCTION     �   CREATE FUNCTION prd.crear_lote(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying DEFAULT 'false'::character varying, p_fec_vencimiento date DEFAULT NULL::date, p_recu_id integer DEFAULT NULL::integer, p_tipo_recurso character varying DEFAULT NULL::character varying) RETURNS character varying
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
 �  DROP FUNCTION prd.crear_lote(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying, p_fec_vencimiento date, p_recu_id integer, p_tipo_recurso character varying);
       prd       postgres    false    10            7           1255    82227    crear_prd_recurso_trg()    FUNCTION     w  CREATE FUNCTION prd.crear_prd_recurso_trg() RETURNS trigger
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
       prd       postgres    false    10            8           1255    82228    eliminar_prd_recurso_trg()    FUNCTION     -  CREATE FUNCTION prd.eliminar_prd_recurso_trg() RETURNS trigger
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
       prd       postgres    false    10                       1259    106906    ajustes    TABLE     +  CREATE TABLE alm.ajustes (
    ajus_id integer NOT NULL,
    tipo_ajuste character varying,
    justificacion character varying,
    usuario_app character varying,
    empr_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE alm.ajustes;
       alm         postgres    false    12                       1259    106904    ajustes_ajus_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.ajustes_ajus_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE alm.ajustes_ajus_id_seq;
       alm       postgres    false    12    260                       0    0    ajustes_ajus_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE alm.ajustes_ajus_id_seq OWNED BY alm.ajustes.ajus_id;
            alm       postgres    false    259            �            1259    74435    alm_articulos    TABLE     X  CREATE TABLE alm.alm_articulos (
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
    batch_id bigint,
    tipo character varying
);
    DROP TABLE alm.alm_articulos;
       alm         postgres    false    12            �            1259    74433    alm_articulos_arti_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_articulos_arti_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE alm.alm_articulos_arti_id_seq;
       alm       postgres    false    221    12                       0    0    alm_articulos_arti_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE alm.alm_articulos_arti_id_seq OWNED BY alm.alm_articulos.arti_id;
            alm       postgres    false    220            �            1259    74446    alm_depositos    TABLE     g  CREATE TABLE alm.alm_depositos (
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
    esta_id integer NOT NULL
);
    DROP TABLE alm.alm_depositos;
       alm         postgres    false    12            �            1259    74444    alm_depositos_depo_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_depositos_depo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE alm.alm_depositos_depo_id_seq;
       alm       postgres    false    223    12                       0    0    alm_depositos_depo_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE alm.alm_depositos_depo_id_seq OWNED BY alm.alm_depositos.depo_id;
            alm       postgres    false    222            �            1259    74617    alm_deta_entrega_materiales    TABLE     �  CREATE TABLE alm.alm_deta_entrega_materiales (
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
       alm         postgres    false    12            �            1259    74615 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq;
       alm       postgres    false    12    242                       0    0 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq OWNED BY alm.alm_deta_entrega_materiales.deen_id;
            alm       postgres    false    241            �            1259    74524    alm_deta_pedidos_materiales    TABLE     O  CREATE TABLE alm.alm_deta_pedidos_materiales (
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
       alm         postgres    false    12            �            1259    74522 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq;
       alm       postgres    false    233    12                       0    0 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq OWNED BY alm.alm_deta_pedidos_materiales.depe_id;
            alm       postgres    false    232            �            1259    74403    alm_deta_recepcion_materiales    TABLE     �  CREATE TABLE alm.alm_deta_recepcion_materiales (
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
       alm         postgres    false    12            �            1259    74401 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 =   DROP SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq;
       alm       postgres    false    12    219                       0    0 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE OWNED BY     q   ALTER SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq OWNED BY alm.alm_deta_recepcion_materiales.dere_id;
            alm       postgres    false    218            �            1259    74544    alm_entrega_materiales    TABLE     �  CREATE TABLE alm.alm_entrega_materiales (
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
       alm         postgres    false    12            �            1259    74542 "   alm_entrega_materiales_enma_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_entrega_materiales_enma_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE alm.alm_entrega_materiales_enma_id_seq;
       alm       postgres    false    12    235                       0    0 "   alm_entrega_materiales_enma_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE alm.alm_entrega_materiales_enma_id_seq OWNED BY alm.alm_entrega_materiales.enma_id;
            alm       postgres    false    234            �            1259    74562 	   alm_lotes    TABLE       CREATE TABLE alm.alm_lotes (
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
       alm         postgres    false    12            �            1259    74560    alm_lotes_lote_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_lotes_lote_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE alm.alm_lotes_lote_id_seq;
       alm       postgres    false    12    237            	           0    0    alm_lotes_lote_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE alm.alm_lotes_lote_id_seq OWNED BY alm.alm_lotes.lote_id;
            alm       postgres    false    236            �            1259    74465    alm_pedidos_materiales    TABLE     �  CREATE TABLE alm.alm_pedidos_materiales (
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
       alm         postgres    false    12            �            1259    74463 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_pedidos_materiales_pema_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE alm.alm_pedidos_materiales_pema_id_seq;
       alm       postgres    false    225    12            
           0    0 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE alm.alm_pedidos_materiales_pema_id_seq OWNED BY alm.alm_pedidos_materiales.pema_id;
            alm       postgres    false    224            �            1259    74483    alm_proveedores    TABLE       CREATE TABLE alm.alm_proveedores (
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
       alm         postgres    false    12            �            1259    74585    alm_proveedores_articulos    TABLE     k   CREATE TABLE alm.alm_proveedores_articulos (
    prov_id integer NOT NULL,
    arti_id integer NOT NULL
);
 *   DROP TABLE alm.alm_proveedores_articulos;
       alm         postgres    false    12            �            1259    74481    alm_proveedores_prov_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_proveedores_prov_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE alm.alm_proveedores_prov_id_seq;
       alm       postgres    false    12    227                       0    0    alm_proveedores_prov_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE alm.alm_proveedores_prov_id_seq OWNED BY alm.alm_proveedores.prov_id;
            alm       postgres    false    226            �            1259    74602    alm_recepcion_materiales    TABLE     h  CREATE TABLE alm.alm_recepcion_materiales (
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
       alm         postgres    false    12            �            1259    74600 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_recepcion_materiales_rema_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 8   DROP SEQUENCE alm.alm_recepcion_materiales_rema_id_seq;
       alm       postgres    false    240    12                       0    0 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE OWNED BY     g   ALTER SEQUENCE alm.alm_recepcion_materiales_rema_id_seq OWNED BY alm.alm_recepcion_materiales.rema_id;
            alm       postgres    false    239                       1259    106938    deta_ajustes    TABLE       CREATE TABLE alm.deta_ajustes (
    deaj_id integer NOT NULL,
    cantidad double precision,
    empr_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER,
    lote_id integer,
    ajus_id integer NOT NULL
);
    DROP TABLE alm.deta_ajustes;
       alm         postgres    false    12                       1259    106936    deta_ajustes_deaj_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.deta_ajustes_deaj_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE alm.deta_ajustes_deaj_id_seq;
       alm       postgres    false    262    12                       0    0    deta_ajustes_deaj_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE alm.deta_ajustes_deaj_id_seq OWNED BY alm.deta_ajustes.deaj_id;
            alm       postgres    false    261            �            1259    74501    items    TABLE     G  CREATE TABLE alm.items (
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
       alm         postgres    false    12            �            1259    74499    items_item_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.items_item_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE alm.items_item_id_seq;
       alm       postgres    false    12    229                       0    0    items_item_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE alm.items_item_id_seq OWNED BY alm.items.item_id;
            alm       postgres    false    228            �            1259    74514 
   utl_tablas    TABLE       CREATE TABLE alm.utl_tablas (
    tabl_id integer NOT NULL,
    tabla character varying(50),
    valor character varying(50),
    descripcion character varying(200),
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
    DROP TABLE alm.utl_tablas;
       alm         postgres    false    12            �            1259    74512    utl_tablas_tabl_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.utl_tablas_tabl_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE alm.utl_tablas_tabl_id_seq;
       alm       postgres    false    12    231                       0    0    utl_tablas_tabl_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE alm.utl_tablas_tabl_id_seq OWNED BY alm.utl_tablas.tabl_id;
            alm       postgres    false    230                       1259    115211    departamentos    TABLE     �   CREATE TABLE core.departamentos (
    depa_id integer NOT NULL,
    nombre character varying NOT NULL,
    descripcion character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE core.departamentos;
       core         postgres    false    8                       1259    115209    departamentos_depa_id_seq    SEQUENCE     �   CREATE SEQUENCE core.departamentos_depa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE core.departamentos_depa_id_seq;
       core       postgres    false    269    8                       0    0    departamentos_depa_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE core.departamentos_depa_id_seq OWNED BY core.departamentos.depa_id;
            core       postgres    false    268            �            1259    74708    empresas    TABLE     �  CREATE TABLE core.empresas (
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
       core         postgres    false    8            �            1259    74706    empresas_empr_id_seq    SEQUENCE     �   CREATE SEQUENCE core.empresas_empr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE core.empresas_empr_id_seq;
       core       postgres    false    8    246                       0    0    empresas_empr_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE core.empresas_empr_id_seq OWNED BY core.empresas.empr_id;
            core       postgres    false    245            �            1259    98621    equipos    TABLE     X  CREATE TABLE core.equipos (
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
    dominio character varying
);
    DROP TABLE core.equipos;
       core         postgres    false    8            �            1259    98619    equipos_equi_id_seq    SEQUENCE     �   CREATE SEQUENCE core.equipos_equi_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE core.equipos_equi_id_seq;
       core       postgres    false    253    8                       0    0    equipos_equi_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE core.equipos_equi_id_seq OWNED BY core.equipos.equi_id;
            core       postgres    false    252            �            1259    74914    log    TABLE     S   CREATE TABLE core.log (
    msg character varying,
    fecha date DEFAULT now()
);
    DROP TABLE core.log;
       core         postgres    false    8            "           1259    123290 	   snapshots    TABLE     �   CREATE TABLE core.snapshots (
    id integer NOT NULL,
    snap_id character varying,
    data text,
    fec_alta date DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
    DROP TABLE core.snapshots;
       core         postgres    false    8            !           1259    123288    snapshots_id_seq    SEQUENCE     �   CREATE SEQUENCE core.snapshots_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE core.snapshots_id_seq;
       core       postgres    false    290    8                       0    0    snapshots_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE core.snapshots_id_seq OWNED BY core.snapshots.id;
            core       postgres    false    289                       1259    115109    tablas    TABLE     �  CREATE TABLE core.tablas (
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
       core         postgres    false    8                        1259    98651    transportistas    TABLE       CREATE TABLE core.transportistas (
    cuit character varying NOT NULL,
    razon_social character varying NOT NULL,
    direccion character varying(500) NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
     DROP TABLE core.transportistas;
       core         postgres    false    8            #           1259    123300    transportistas_tipo_residuos    TABLE     �   CREATE TABLE core.transportistas_tipo_residuos (
    tran_id integer NOT NULL,
    tire_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
 .   DROP TABLE core.transportistas_tipo_residuos;
       core         postgres    false    8                       1259    115192    zonas    TABLE     r  CREATE TABLE core.zonas (
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
       core         postgres    false    8            
           1259    115190    zonas_zona_id_seq    SEQUENCE     �   CREATE SEQUENCE core.zonas_zona_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE core.zonas_zona_id_seq;
       core       postgres    false    8    267                       0    0    zonas_zona_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE core.zonas_zona_id_seq OWNED BY core.zonas.zona_id;
            core       postgres    false    266            �            1259    57782    formularios    TABLE        CREATE TABLE frm.formularios (
    form_id integer NOT NULL,
    nombre character varying(45),
    descripcion character varying(300),
    eliminado smallint DEFAULT 0,
    fec_alta timestamp without time zone DEFAULT now(),
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE frm.formularios;
       frm         postgres    false    6            �            1259    57780    formularios_form_id_seq    SEQUENCE     �   CREATE SEQUENCE frm.formularios_form_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE frm.formularios_form_id_seq;
       frm       postgres    false    6    213                       0    0    formularios_form_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE frm.formularios_form_id_seq OWNED BY frm.formularios.form_id;
            frm       postgres    false    212            �            1259    57799    instancias_items    TABLE     �  CREATE TABLE frm.instancias_items (
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
       frm         postgres    false    6            �            1259    57797    instancias_items_init_id_seq    SEQUENCE     �   CREATE SEQUENCE frm.instancias_items_init_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE frm.instancias_items_init_id_seq;
       frm       postgres    false    6    215                       0    0    instancias_items_init_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE frm.instancias_items_init_id_seq OWNED BY frm.instancias_items.init_id;
            frm       postgres    false    214            �            1259    57818    items    TABLE     G  CREATE TABLE frm.items (
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
       frm         postgres    false    6            �            1259    57816    items_item_id_seq    SEQUENCE     �   CREATE SEQUENCE frm.items_item_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE frm.items_item_id_seq;
       frm       postgres    false    6    217                       0    0    items_item_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE frm.items_item_id_seq OWNED BY frm.items.item_id;
            frm       postgres    false    216                       1259    115360    choferes    TABLE     �  CREATE TABLE log.choferes (
    chof_id integer NOT NULL,
    nombre character varying NOT NULL,
    apellido character varying NOT NULL,
    documento character varying NOT NULL,
    fec_nacimiento date NOT NULL,
    direccion character varying NOT NULL,
    celular integer,
    codigo bigint NOT NULL,
    carnet character varying NOT NULL,
    vencimiento date NOT NULL,
    habilitacion character varying,
    imagen bytea,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    tran_id integer NOT NULL,
    cach_id character varying NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL
);
    DROP TABLE log.choferes;
       log         postgres    false    5                       1259    115358    choferes_chof_id_seq    SEQUENCE     �   CREATE SEQUENCE log.choferes_chof_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE log.choferes_chof_id_seq;
       log       postgres    false    278    5                       0    0    choferes_chof_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE log.choferes_chof_id_seq OWNED BY log.choferes.chof_id;
            log       postgres    false    277                       1259    115230 	   circuitos    TABLE     k  CREATE TABLE log.circuitos (
    circ_id integer NOT NULL,
    codigo character varying,
    descripcion character varying,
    imagen bytea,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    chof_id integer,
    vehi_id integer,
    zona_id integer NOT NULL
);
    DROP TABLE log.circuitos;
       log         postgres    false    5                       1259    115228    circuitos_circu_id_seq    SEQUENCE     �   CREATE SEQUENCE log.circuitos_circu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE log.circuitos_circu_id_seq;
       log       postgres    false    271    5                       0    0    circuitos_circu_id_seq    SEQUENCE OWNED BY     J   ALTER SEQUENCE log.circuitos_circu_id_seq OWNED BY log.circuitos.circ_id;
            log       postgres    false    270                       1259    115416    circuitos_puntos_criticos    TABLE     �   CREATE TABLE log.circuitos_puntos_criticos (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying NOT NULL,
    circ_id integer NOT NULL,
    pucr_id integer NOT NULL
);
 *   DROP TABLE log.circuitos_puntos_criticos;
       log         postgres    false    5                       1259    115274    contenedores    TABLE     �  CREATE TABLE log.contenedores (
    cont_id integer NOT NULL,
    codigo bigint NOT NULL,
    descripcion character varying NOT NULL,
    capacidad double precision NOT NULL,
    anio_elaboracion integer,
    tara double precision,
    habilitacion character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    esco_id character varying NOT NULL,
    reci_id integer NOT NULL
);
    DROP TABLE log.contenedores;
       log         postgres    false    5                       1259    115272    containers_cont_id_seq    SEQUENCE     �   CREATE SEQUENCE log.containers_cont_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE log.containers_cont_id_seq;
       log       postgres    false    5    273                       0    0    containers_cont_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE log.containers_cont_id_seq OWNED BY log.contenedores.cont_id;
            log       postgres    false    272                       1259    115527    deta_solicitudes_contenedor    TABLE     0  CREATE TABLE log.deta_solicitudes_contenedor (
    desc_id integer NOT NULL,
    cantidad integer NOT NULL,
    otro character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying NOT NULL,
    usuario_app character varying NOT NULL,
    tica_id character varying NOT NULL
);
 ,   DROP TABLE log.deta_solicitudes_contenedor;
       log         postgres    false    5                       1259    115525 '   deta_solicitudes_contenedor_desc_id_seq    SEQUENCE     �   CREATE SEQUENCE log.deta_solicitudes_contenedor_desc_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE log.deta_solicitudes_contenedor_desc_id_seq;
       log       postgres    false    285    5                       0    0 '   deta_solicitudes_contenedor_desc_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE log.deta_solicitudes_contenedor_desc_id_seq OWNED BY log.deta_solicitudes_contenedor.desc_id;
            log       postgres    false    284                       1259    115544    entregas_contenedor    TABLE     G   CREATE TABLE log.entregas_contenedor (
    enco_id integer NOT NULL
);
 $   DROP TABLE log.entregas_contenedor;
       log         postgres    false    5                       1259    115542    entregas_contenedor_enco_id_seq    SEQUENCE     �   CREATE SEQUENCE log.entregas_contenedor_enco_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 3   DROP SEQUENCE log.entregas_contenedor_enco_id_seq;
       log       postgres    false    5    287                       0    0    entregas_contenedor_enco_id_seq    SEQUENCE OWNED BY     ]   ALTER SEQUENCE log.entregas_contenedor_enco_id_seq OWNED BY log.entregas_contenedor.enco_id;
            log       postgres    false    286                       1259    115325    puntos_criticos    TABLE     �  CREATE TABLE log.puntos_criticos (
    pucr_id integer NOT NULL,
    nombre character varying NOT NULL,
    descripcion character varying,
    lat character varying,
    lng character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    zona_id integer NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL
);
     DROP TABLE log.puntos_criticos;
       log         postgres    false    5                       1259    115323    puntos_criticos_pucr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.puntos_criticos_pucr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE log.puntos_criticos_pucr_id_seq;
       log       postgres    false    5    276                       0    0    puntos_criticos_pucr_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE log.puntos_criticos_pucr_id_seq OWNED BY log.puntos_criticos.pucr_id;
            log       postgres    false    275                       1259    115453    solicitantes_transporte    TABLE     Y  CREATE TABLE log.solicitantes_transporte (
    sotr_id integer NOT NULL,
    razon_social character varying,
    cuit character varying,
    domicilio character varying,
    num_registro character varying,
    lat character varying,
    lng character varying,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario_app character varying NOT NULL,
    zona_id integer NOT NULL,
    rubr_id character varying NOT NULL,
    tist_id character varying NOT NULL,
    tica_id character varying NOT NULL,
    eliminado integer DEFAULT 0 NOT NULL
);
 (   DROP TABLE log.solicitantes_transporte;
       log         postgres    false    5                       1259    115451 #   solicitantes_transporte_sotr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitantes_transporte_sotr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE log.solicitantes_transporte_sotr_id_seq;
       log       postgres    false    5    281                       0    0 #   solicitantes_transporte_sotr_id_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE log.solicitantes_transporte_sotr_id_seq OWNED BY log.solicitantes_transporte.sotr_id;
            log       postgres    false    280                       1259    115489    solicitudes_contenedor    TABLE     |  CREATE TABLE log.solicitudes_contenedor (
    soco_id integer NOT NULL,
    num_orden bigint NOT NULL,
    fec_orden date NOT NULL,
    fec_retiro date NOT NULL,
    fec_alta character varying DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    sotr_id integer NOT NULL,
    tran_id integer NOT NULL,
    essc_id character varying NOT NULL
);
 '   DROP TABLE log.solicitudes_contenedor;
       log         postgres    false    5                       1259    115487 "   solicitudes_contenedor_soco_id_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitudes_contenedor_soco_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE log.solicitudes_contenedor_soco_id_seq;
       log       postgres    false    5    283                       0    0 "   solicitudes_contenedor_soco_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE log.solicitudes_contenedor_soco_id_seq OWNED BY log.solicitudes_contenedor.soco_id;
            log       postgres    false    282                        1259    115548    solicitudes_retiro    TABLE     F   CREATE TABLE log.solicitudes_retiro (
    sore_id integer NOT NULL
);
 #   DROP TABLE log.solicitudes_retiro;
       log         postgres    false    5                       1259    115299    tipos_carga_circuitos    TABLE     �   CREATE TABLE log.tipos_carga_circuitos (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    circ_id integer NOT NULL,
    tica_id character varying NOT NULL
);
 &   DROP TABLE log.tipos_carga_circuitos;
       log         postgres    false    5            $           1259    123308    tipos_carga_transportistas    TABLE     �   CREATE TABLE log.tipos_carga_transportistas (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    tran_id integer NOT NULL,
    tica_id character varying NOT NULL
);
 +   DROP TABLE log.tipos_carga_transportistas;
       log         postgres    false    5            	           1259    115162    transportistas    TABLE     O  CREATE TABLE log.transportistas (
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
    eliminado smallint DEFAULT 0 NOT NULL
);
    DROP TABLE log.transportistas;
       log         postgres    false    5                       1259    115160    transportistas_tran_id_seq    SEQUENCE     �   CREATE SEQUENCE log.transportistas_tran_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE log.transportistas_tran_id_seq;
       log       postgres    false    265    5                        0    0    transportistas_tran_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE log.transportistas_tran_id_seq OWNED BY log.transportistas.tran_id;
            log       postgres    false    264            �            1259    57723    costos    TABLE       CREATE TABLE prd.costos (
    fec_vigencia date NOT NULL,
    valor money NOT NULL,
    umed character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    recu_id integer NOT NULL,
    empr_id integer
);
    DROP TABLE prd.costos;
       prd         postgres    false    10            �            1259    98636    empaque    TABLE     N  CREATE TABLE prd.empaque (
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
       prd         postgres    false    10            !           0    0    COLUMN empaque.eliminado    COMMENT     4   COMMENT ON COLUMN prd.empaque.eliminado IS 'false';
            prd       postgres    false    254            �            1259    98639    empaque_empa_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.empaque_empa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE prd.empaque_empa_id_seq;
       prd       postgres    false    254    10            "           0    0    empaque_empa_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE prd.empaque_empa_id_seq OWNED BY prd.empaque.empa_id;
            prd       postgres    false    255            �            1259    74635    establecimientos    TABLE     r  CREATE TABLE prd.establecimientos (
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
       prd         postgres    false    10            �            1259    74633    establecimientos_esta_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.establecimientos_esta_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE prd.establecimientos_esta_id_seq;
       prd       postgres    false    10    244            #           0    0    establecimientos_esta_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE prd.establecimientos_esta_id_seq OWNED BY prd.establecimientos.esta_id;
            prd       postgres    false    243            �            1259    57630    etapas    TABLE     �  CREATE TABLE prd.etapas (
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
       prd         postgres    false    10            �            1259    57628    etapas_etap_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.etapas_etap_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE prd.etapas_etap_id_seq;
       prd       postgres    false    204    10            $           0    0    etapas_etap_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE prd.etapas_etap_id_seq OWNED BY prd.etapas.etap_id;
            prd       postgres    false    203                       1259    98674    fraccionamientos    TABLE       CREATE TABLE prd.fraccionamientos (
    frac_id integer NOT NULL,
    recu_id integer NOT NULL,
    empa_id integer NOT NULL,
    cantidad double precision NOT NULL,
    fecha date DEFAULT now() NOT NULL,
    eliminado boolean DEFAULT false NOT NULL,
    empr_id integer NOT NULL
);
 !   DROP TABLE prd.fraccionamientos;
       prd         postgres    false    10                       1259    98672    fraccionamientos_frac_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.fraccionamientos_frac_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE prd.fraccionamientos_frac_id_seq;
       prd       postgres    false    10    258            %           0    0    fraccionamientos_frac_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE prd.fraccionamientos_frac_id_seq OWNED BY prd.fraccionamientos.frac_id;
            prd       postgres    false    257            �            1259    57652    lotes    TABLE     �  CREATE TABLE prd.lotes (
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
       prd         postgres    false    10            �            1259    57650    lotes_batch_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.lotes_batch_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE prd.lotes_batch_id_seq;
       prd       postgres    false    206    10            &           0    0    lotes_batch_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE prd.lotes_batch_id_seq OWNED BY prd.lotes.batch_id;
            prd       postgres    false    205            �            1259    57700    lotes_hijos    TABLE     Y  CREATE TABLE prd.lotes_hijos (
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
       prd         postgres    false    10            �            1259    74786    movimientos_trasportes    TABLE     �  CREATE TABLE prd.movimientos_trasportes (
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
       prd         postgres    false    10            �            1259    74784 "   movimientos_trasportes_motr_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.movimientos_trasportes_motr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE prd.movimientos_trasportes_motr_id_seq;
       prd       postgres    false    10    249            '           0    0 "   movimientos_trasportes_motr_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE prd.movimientos_trasportes_motr_id_seq OWNED BY prd.movimientos_trasportes.motr_id;
            prd       postgres    false    248            �            1259    57615    procesos    TABLE     �   CREATE TABLE prd.procesos (
    proc_id integer NOT NULL,
    nombre character varying NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    empr_id integer
);
    DROP TABLE prd.procesos;
       prd         postgres    false    10            �            1259    57613    productos_prod_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.productos_prod_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE prd.productos_prod_id_seq;
       prd       postgres    false    10    202            (           0    0    productos_prod_id_seq    SEQUENCE OWNED BY     H   ALTER SEQUENCE prd.productos_prod_id_seq OWNED BY prd.procesos.proc_id;
            prd       postgres    false    201            �            1259    74759    recipientes    TABLE     �  CREATE TABLE prd.recipientes (
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
    CONSTRAINT recipientes_check CHECK ((((tipo)::text = 'PRODUCTIVO'::text) OR ((tipo)::text = 'DEPOSITO'::text) OR ((tipo)::text = 'TRANSPORTE'::text))),
    CONSTRAINT recipientes_check_estado CHECK ((((estado)::text = 'VACIO'::text) OR ((estado)::text = 'LLENO'::text)))
);
    DROP TABLE prd.recipientes;
       prd         postgres    false    10            �            1259    74867    recipiente_reci_id_seq    SEQUENCE     |   CREATE SEQUENCE prd.recipiente_reci_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE prd.recipiente_reci_id_seq;
       prd       postgres    false    10    247            )           0    0    recipiente_reci_id_seq    SEQUENCE OWNED BY     L   ALTER SEQUENCE prd.recipiente_reci_id_seq OWNED BY prd.recipientes.reci_id;
            prd       postgres    false    250            �            1259    57670    recursos    TABLE     E  CREATE TABLE prd.recursos (
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
       prd         postgres    false    10            �            1259    57682    recursos_lotes    TABLE     H  CREATE TABLE prd.recursos_lotes (
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
       prd         postgres    false    10            �            1259    57668    recursos_recu_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.recursos_recu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE prd.recursos_recu_id_seq;
       prd       postgres    false    10    208            *           0    0    recursos_recu_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE prd.recursos_recu_id_seq OWNED BY prd.recursos.recu_id;
            prd       postgres    false    207            I           2604    106909    ajustes ajus_id    DEFAULT     l   ALTER TABLE ONLY alm.ajustes ALTER COLUMN ajus_id SET DEFAULT nextval('alm.ajustes_ajus_id_seq'::regclass);
 ;   ALTER TABLE alm.ajustes ALTER COLUMN ajus_id DROP DEFAULT;
       alm       postgres    false    260    259    260            �           2604    74438    alm_articulos arti_id    DEFAULT     x   ALTER TABLE ONLY alm.alm_articulos ALTER COLUMN arti_id SET DEFAULT nextval('alm.alm_articulos_arti_id_seq'::regclass);
 A   ALTER TABLE alm.alm_articulos ALTER COLUMN arti_id DROP DEFAULT;
       alm       postgres    false    220    221    221            �           2604    74449    alm_depositos depo_id    DEFAULT     x   ALTER TABLE ONLY alm.alm_depositos ALTER COLUMN depo_id SET DEFAULT nextval('alm.alm_depositos_depo_id_seq'::regclass);
 A   ALTER TABLE alm.alm_depositos ALTER COLUMN depo_id DROP DEFAULT;
       alm       postgres    false    223    222    223            *           2604    74620 #   alm_deta_entrega_materiales deen_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_entrega_materiales ALTER COLUMN deen_id SET DEFAULT nextval('alm.alm_deta_entrega_materiales_deen_id_seq'::regclass);
 O   ALTER TABLE alm.alm_deta_entrega_materiales ALTER COLUMN deen_id DROP DEFAULT;
       alm       postgres    false    241    242    242                       2604    74527 #   alm_deta_pedidos_materiales depe_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales ALTER COLUMN depe_id SET DEFAULT nextval('alm.alm_deta_pedidos_materiales_depe_id_seq'::regclass);
 O   ALTER TABLE alm.alm_deta_pedidos_materiales ALTER COLUMN depe_id DROP DEFAULT;
       alm       postgres    false    232    233    233            �           2604    74406 %   alm_deta_recepcion_materiales dere_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales ALTER COLUMN dere_id SET DEFAULT nextval('alm.alm_deta_recepcion_materiales_dere_id_seq'::regclass);
 Q   ALTER TABLE alm.alm_deta_recepcion_materiales ALTER COLUMN dere_id DROP DEFAULT;
       alm       postgres    false    218    219    219                       2604    74547    alm_entrega_materiales enma_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_entrega_materiales ALTER COLUMN enma_id SET DEFAULT nextval('alm.alm_entrega_materiales_enma_id_seq'::regclass);
 J   ALTER TABLE alm.alm_entrega_materiales ALTER COLUMN enma_id DROP DEFAULT;
       alm       postgres    false    234    235    235            "           2604    74565    alm_lotes lote_id    DEFAULT     p   ALTER TABLE ONLY alm.alm_lotes ALTER COLUMN lote_id SET DEFAULT nextval('alm.alm_lotes_lote_id_seq'::regclass);
 =   ALTER TABLE alm.alm_lotes ALTER COLUMN lote_id DROP DEFAULT;
       alm       postgres    false    236    237    237                       2604    74468    alm_pedidos_materiales pema_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_pedidos_materiales ALTER COLUMN pema_id SET DEFAULT nextval('alm.alm_pedidos_materiales_pema_id_seq'::regclass);
 J   ALTER TABLE alm.alm_pedidos_materiales ALTER COLUMN pema_id DROP DEFAULT;
       alm       postgres    false    224    225    225                       2604    74486    alm_proveedores prov_id    DEFAULT     |   ALTER TABLE ONLY alm.alm_proveedores ALTER COLUMN prov_id SET DEFAULT nextval('alm.alm_proveedores_prov_id_seq'::regclass);
 C   ALTER TABLE alm.alm_proveedores ALTER COLUMN prov_id DROP DEFAULT;
       alm       postgres    false    227    226    227            '           2604    74605     alm_recepcion_materiales rema_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_recepcion_materiales ALTER COLUMN rema_id SET DEFAULT nextval('alm.alm_recepcion_materiales_rema_id_seq'::regclass);
 L   ALTER TABLE alm.alm_recepcion_materiales ALTER COLUMN rema_id DROP DEFAULT;
       alm       postgres    false    239    240    240            L           2604    106941    deta_ajustes deaj_id    DEFAULT     v   ALTER TABLE ONLY alm.deta_ajustes ALTER COLUMN deaj_id SET DEFAULT nextval('alm.deta_ajustes_deaj_id_seq'::regclass);
 @   ALTER TABLE alm.deta_ajustes ALTER COLUMN deaj_id DROP DEFAULT;
       alm       postgres    false    261    262    262                       2604    74504    items item_id    DEFAULT     h   ALTER TABLE ONLY alm.items ALTER COLUMN item_id SET DEFAULT nextval('alm.items_item_id_seq'::regclass);
 9   ALTER TABLE alm.items ALTER COLUMN item_id DROP DEFAULT;
       alm       postgres    false    229    228    229                       2604    74517    utl_tablas tabl_id    DEFAULT     r   ALTER TABLE ONLY alm.utl_tablas ALTER COLUMN tabl_id SET DEFAULT nextval('alm.utl_tablas_tabl_id_seq'::regclass);
 >   ALTER TABLE alm.utl_tablas ALTER COLUMN tabl_id DROP DEFAULT;
       alm       postgres    false    230    231    231            Z           2604    115214    departamentos depa_id    DEFAULT     z   ALTER TABLE ONLY core.departamentos ALTER COLUMN depa_id SET DEFAULT nextval('core.departamentos_depa_id_seq'::regclass);
 B   ALTER TABLE core.departamentos ALTER COLUMN depa_id DROP DEFAULT;
       core       postgres    false    269    268    269            /           2604    74711    empresas empr_id    DEFAULT     p   ALTER TABLE ONLY core.empresas ALTER COLUMN empr_id SET DEFAULT nextval('core.empresas_empr_id_seq'::regclass);
 =   ALTER TABLE core.empresas ALTER COLUMN empr_id DROP DEFAULT;
       core       postgres    false    246    245    246            =           2604    98624    equipos equi_id    DEFAULT     n   ALTER TABLE ONLY core.equipos ALTER COLUMN equi_id SET DEFAULT nextval('core.equipos_equi_id_seq'::regclass);
 <   ALTER TABLE core.equipos ALTER COLUMN equi_id DROP DEFAULT;
       core       postgres    false    252    253    253            x           2604    123293    snapshots id    DEFAULT     h   ALTER TABLE ONLY core.snapshots ALTER COLUMN id SET DEFAULT nextval('core.snapshots_id_seq'::regclass);
 9   ALTER TABLE core.snapshots ALTER COLUMN id DROP DEFAULT;
       core       postgres    false    290    289    290            V           2604    115195    zonas zona_id    DEFAULT     j   ALTER TABLE ONLY core.zonas ALTER COLUMN zona_id SET DEFAULT nextval('core.zonas_zona_id_seq'::regclass);
 :   ALTER TABLE core.zonas ALTER COLUMN zona_id DROP DEFAULT;
       core       postgres    false    266    267    267            �           2604    57785    formularios form_id    DEFAULT     t   ALTER TABLE ONLY frm.formularios ALTER COLUMN form_id SET DEFAULT nextval('frm.formularios_form_id_seq'::regclass);
 ?   ALTER TABLE frm.formularios ALTER COLUMN form_id DROP DEFAULT;
       frm       postgres    false    213    212    213            �           2604    57802    instancias_items init_id    DEFAULT     ~   ALTER TABLE ONLY frm.instancias_items ALTER COLUMN init_id SET DEFAULT nextval('frm.instancias_items_init_id_seq'::regclass);
 D   ALTER TABLE frm.instancias_items ALTER COLUMN init_id DROP DEFAULT;
       frm       postgres    false    214    215    215            �           2604    57821    items item_id    DEFAULT     h   ALTER TABLE ONLY frm.items ALTER COLUMN item_id SET DEFAULT nextval('frm.items_item_id_seq'::regclass);
 9   ALTER TABLE frm.items ALTER COLUMN item_id DROP DEFAULT;
       frm       postgres    false    217    216    217            i           2604    115363    choferes chof_id    DEFAULT     n   ALTER TABLE ONLY log.choferes ALTER COLUMN chof_id SET DEFAULT nextval('log.choferes_chof_id_seq'::regclass);
 <   ALTER TABLE log.choferes ALTER COLUMN chof_id DROP DEFAULT;
       log       postgres    false    278    277    278            ]           2604    115233    circuitos circ_id    DEFAULT     q   ALTER TABLE ONLY log.circuitos ALTER COLUMN circ_id SET DEFAULT nextval('log.circuitos_circu_id_seq'::regclass);
 =   ALTER TABLE log.circuitos ALTER COLUMN circ_id DROP DEFAULT;
       log       postgres    false    270    271    271            `           2604    115277    contenedores cont_id    DEFAULT     t   ALTER TABLE ONLY log.contenedores ALTER COLUMN cont_id SET DEFAULT nextval('log.containers_cont_id_seq'::regclass);
 @   ALTER TABLE log.contenedores ALTER COLUMN cont_id DROP DEFAULT;
       log       postgres    false    273    272    273            u           2604    115530 #   deta_solicitudes_contenedor desc_id    DEFAULT     �   ALTER TABLE ONLY log.deta_solicitudes_contenedor ALTER COLUMN desc_id SET DEFAULT nextval('log.deta_solicitudes_contenedor_desc_id_seq'::regclass);
 O   ALTER TABLE log.deta_solicitudes_contenedor ALTER COLUMN desc_id DROP DEFAULT;
       log       postgres    false    285    284    285            w           2604    115547    entregas_contenedor enco_id    DEFAULT     �   ALTER TABLE ONLY log.entregas_contenedor ALTER COLUMN enco_id SET DEFAULT nextval('log.entregas_contenedor_enco_id_seq'::regclass);
 G   ALTER TABLE log.entregas_contenedor ALTER COLUMN enco_id DROP DEFAULT;
       log       postgres    false    287    286    287            e           2604    115328    puntos_criticos pucr_id    DEFAULT     |   ALTER TABLE ONLY log.puntos_criticos ALTER COLUMN pucr_id SET DEFAULT nextval('log.puntos_criticos_pucr_id_seq'::regclass);
 C   ALTER TABLE log.puntos_criticos ALTER COLUMN pucr_id DROP DEFAULT;
       log       postgres    false    276    275    276            o           2604    115456    solicitantes_transporte sotr_id    DEFAULT     �   ALTER TABLE ONLY log.solicitantes_transporte ALTER COLUMN sotr_id SET DEFAULT nextval('log.solicitantes_transporte_sotr_id_seq'::regclass);
 K   ALTER TABLE log.solicitantes_transporte ALTER COLUMN sotr_id DROP DEFAULT;
       log       postgres    false    281    280    281            r           2604    115492    solicitudes_contenedor soco_id    DEFAULT     �   ALTER TABLE ONLY log.solicitudes_contenedor ALTER COLUMN soco_id SET DEFAULT nextval('log.solicitudes_contenedor_soco_id_seq'::regclass);
 J   ALTER TABLE log.solicitudes_contenedor ALTER COLUMN soco_id DROP DEFAULT;
       log       postgres    false    282    283    283            R           2604    115165    transportistas tran_id    DEFAULT     z   ALTER TABLE ONLY log.transportistas ALTER COLUMN tran_id SET DEFAULT nextval('log.transportistas_tran_id_seq'::regclass);
 B   ALTER TABLE log.transportistas ALTER COLUMN tran_id DROP DEFAULT;
       log       postgres    false    264    265    265            B           2604    98641    empaque empa_id    DEFAULT     l   ALTER TABLE ONLY prd.empaque ALTER COLUMN empa_id SET DEFAULT nextval('prd.empaque_empa_id_seq'::regclass);
 ;   ALTER TABLE prd.empaque ALTER COLUMN empa_id DROP DEFAULT;
       prd       postgres    false    255    254            -           2604    74638    establecimientos esta_id    DEFAULT     ~   ALTER TABLE ONLY prd.establecimientos ALTER COLUMN esta_id SET DEFAULT nextval('prd.establecimientos_esta_id_seq'::regclass);
 D   ALTER TABLE prd.establecimientos ALTER COLUMN esta_id DROP DEFAULT;
       prd       postgres    false    244    243    244            �           2604    57633    etapas etap_id    DEFAULT     j   ALTER TABLE ONLY prd.etapas ALTER COLUMN etap_id SET DEFAULT nextval('prd.etapas_etap_id_seq'::regclass);
 :   ALTER TABLE prd.etapas ALTER COLUMN etap_id DROP DEFAULT;
       prd       postgres    false    203    204    204            F           2604    98677    fraccionamientos frac_id    DEFAULT     ~   ALTER TABLE ONLY prd.fraccionamientos ALTER COLUMN frac_id SET DEFAULT nextval('prd.fraccionamientos_frac_id_seq'::regclass);
 D   ALTER TABLE prd.fraccionamientos ALTER COLUMN frac_id DROP DEFAULT;
       prd       postgres    false    257    258    258            �           2604    74731    lotes batch_id    DEFAULT     j   ALTER TABLE ONLY prd.lotes ALTER COLUMN batch_id SET DEFAULT nextval('prd.lotes_batch_id_seq'::regclass);
 :   ALTER TABLE prd.lotes ALTER COLUMN batch_id DROP DEFAULT;
       prd       postgres    false    205    206    206            8           2604    74789    movimientos_trasportes motr_id    DEFAULT     �   ALTER TABLE ONLY prd.movimientos_trasportes ALTER COLUMN motr_id SET DEFAULT nextval('prd.movimientos_trasportes_motr_id_seq'::regclass);
 J   ALTER TABLE prd.movimientos_trasportes ALTER COLUMN motr_id DROP DEFAULT;
       prd       postgres    false    248    249    249            �           2604    57618    procesos proc_id    DEFAULT     o   ALTER TABLE ONLY prd.procesos ALTER COLUMN proc_id SET DEFAULT nextval('prd.productos_prod_id_seq'::regclass);
 <   ALTER TABLE prd.procesos ALTER COLUMN proc_id DROP DEFAULT;
       prd       postgres    false    202    201    202            0           2604    74869    recipientes reci_id    DEFAULT     s   ALTER TABLE ONLY prd.recipientes ALTER COLUMN reci_id SET DEFAULT nextval('prd.recipiente_reci_id_seq'::regclass);
 ?   ALTER TABLE prd.recipientes ALTER COLUMN reci_id DROP DEFAULT;
       prd       postgres    false    250    247            �           2604    57673    recursos recu_id    DEFAULT     n   ALTER TABLE ONLY prd.recursos ALTER COLUMN recu_id SET DEFAULT nextval('prd.recursos_recu_id_seq'::regclass);
 <   ALTER TABLE prd.recursos ALTER COLUMN recu_id DROP DEFAULT;
       prd       postgres    false    207    208    208            �          0    106906    ajustes 
   TABLE DATA               l   COPY alm.ajustes (ajus_id, tipo_ajuste, justificacion, usuario_app, empr_id, fec_alta, usuario) FROM stdin;
    alm       postgres    false    260            �          0    74435    alm_articulos 
   TABLE DATA               �   COPY alm.alm_articulos (arti_id, barcode, descripcion, costo, es_caja, cantidad_caja, punto_pedido, estado, unidad_medida, empr_id, es_loteado, fec_alta, eliminado, batch_id, tipo) FROM stdin;
    alm       postgres    false    221            �          0    74446    alm_depositos 
   TABLE DATA               �   COPY alm.alm_depositos (depo_id, descripcion, direccion, gps, estado, loca_id, pais_id, empr_id, fec_alta, eliminado, esta_id) FROM stdin;
    alm       postgres    false    223            �          0    74617    alm_deta_entrega_materiales 
   TABLE DATA               �   COPY alm.alm_deta_entrega_materiales (deen_id, enma_id, cantidad, arti_id, prov_id, lote_id, depo_id, empr_id, precio, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    242            �          0    74524    alm_deta_pedidos_materiales 
   TABLE DATA               �   COPY alm.alm_deta_pedidos_materiales (depe_id, cantidad, resto, fecha_entrega, fecha_entregado, pema_id, arti_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    233            �          0    74403    alm_deta_recepcion_materiales 
   TABLE DATA               �   COPY alm.alm_deta_recepcion_materiales (dere_id, cantidad, precio, empr_id, rema_id, lote_id, prov_id, arti_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    219            �          0    74544    alm_entrega_materiales 
   TABLE DATA               �   COPY alm.alm_entrega_materiales (enma_id, fecha, solicitante, dni, comprobante, empr_id, pema_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    235            �          0    74562 	   alm_lotes 
   TABLE DATA               �   COPY alm.alm_lotes (lote_id, prov_id, arti_id, depo_id, codigo, fec_vencimiento, cantidad, empr_id, user_id, estado, fec_alta, eliminado, batch_id) FROM stdin;
    alm       postgres    false    237            �          0    74465    alm_pedidos_materiales 
   TABLE DATA               �   COPY alm.alm_pedidos_materiales (pema_id, fecha, motivo_rechazo, justificacion, case_id, ortr_id, estado, empr_id, fec_alta, eliminado, batch_id) FROM stdin;
    alm       postgres    false    225            �          0    74483    alm_proveedores 
   TABLE DATA               w   COPY alm.alm_proveedores (prov_id, nombre, cuit, domicilio, telefono, email, empr_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    227            �          0    74585    alm_proveedores_articulos 
   TABLE DATA               B   COPY alm.alm_proveedores_articulos (prov_id, arti_id) FROM stdin;
    alm       postgres    false    238            �          0    74602    alm_recepcion_materiales 
   TABLE DATA               }   COPY alm.alm_recepcion_materiales (rema_id, fecha, comprobante, empr_id, prov_id, fec_alta, eliminado, batch_id) FROM stdin;
    alm       postgres    false    240            �          0    106938    deta_ajustes 
   TABLE DATA               d   COPY alm.deta_ajustes (deaj_id, cantidad, empr_id, fec_alta, usuario, lote_id, ajus_id) FROM stdin;
    alm       postgres    false    262            �          0    74501    items 
   TABLE DATA               �   COPY alm.items (item_id, label, name, requerido, tipo_dato, valo_id, orden, aux, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, form_id) FROM stdin;
    alm       postgres    false    229            �          0    74514 
   utl_tablas 
   TABLE DATA               Z   COPY alm.utl_tablas (tabl_id, tabla, valor, descripcion, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    231            �          0    115211    departamentos 
   TABLE DATA               V   COPY core.departamentos (depa_id, nombre, descripcion, fec_alta, usuario) FROM stdin;
    core       postgres    false    269            �          0    74708    empresas 
   TABLE DATA               �   COPY core.empresas (empr_id, descripcion, cuit, direccion, telefono, email, imagepath, loca_id, prov_id, pais_id, lat, lng, celular, zona_id, clie_id) FROM stdin;
    core       postgres    false    246            �          0    98621    equipos 
   TABLE DATA               �  COPY core.equipos (equi_id, descripcion, marca, codigo, ubicacion, estado, fecha_ultimalectura, ultima_lectura, tipo_horas, valor_reposicion, fecha_reposicion, valor, comprobante, descrip_tecnica, numero_serie, adjunto, meta_disponibilidad, fecha_ingreso, fecha_baja, fecha_garantia, prov_id, empr_id, sect_id, ubic_id, grup_id, crit_id, unme_id, area_id, proc_id, tran_id, dominio) FROM stdin;
    core       postgres    false    253            �          0    74914    log 
   TABLE DATA               '   COPY core.log (msg, fecha) FROM stdin;
    core       postgres    false    251            �          0    123290 	   snapshots 
   TABLE DATA               I   COPY core.snapshots (id, snap_id, data, fec_alta, eliminado) FROM stdin;
    core       postgres    false    290            �          0    115109    tablas 
   TABLE DATA               p   COPY core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) FROM stdin;
    core       postgres    false    263            �          0    98651    transportistas 
   TABLE DATA               Z   COPY core.transportistas (cuit, razon_social, direccion, fec_alta, eliminado) FROM stdin;
    core       postgres    false    256            �          0    123300    transportistas_tipo_residuos 
   TABLE DATA               Y   COPY core.transportistas_tipo_residuos (tran_id, tire_id, fec_alta, usuario) FROM stdin;
    core       postgres    false    291            �          0    115192    zonas 
   TABLE DATA               w   COPY core.zonas (zona_id, nombre, descripcion, imagen, fec_alta, usuario, usuario_app, depa_id, eliminado) FROM stdin;
    core       postgres    false    267            �          0    57782    formularios 
   TABLE DATA               ^   COPY frm.formularios (form_id, nombre, descripcion, eliminado, fec_alta, usuario) FROM stdin;
    frm       postgres    false    213            �          0    57799    instancias_items 
   TABLE DATA               �   COPY frm.instancias_items (init_id, label, name, valor, requerido, tida_id, valo_id, info_id, form_id, orden, aux, eliminado, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, item_id) FROM stdin;
    frm       postgres    false    215            �          0    57818    items 
   TABLE DATA               �   COPY frm.items (item_id, label, name, requerido, tipo_dato, valo_id, orden, aux, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, form_id) FROM stdin;
    frm       postgres    false    217            �          0    115360    choferes 
   TABLE DATA               �   COPY log.choferes (chof_id, nombre, apellido, documento, fec_nacimiento, direccion, celular, codigo, carnet, vencimiento, habilitacion, imagen, fec_alta, usuario, tran_id, cach_id, eliminado) FROM stdin;
    log       postgres    false    278            �          0    115230 	   circuitos 
   TABLE DATA               �   COPY log.circuitos (circ_id, codigo, descripcion, imagen, fec_alta, usuario, usuario_app, chof_id, vehi_id, zona_id) FROM stdin;
    log       postgres    false    271            �          0    115416    circuitos_puntos_criticos 
   TABLE DATA               U   COPY log.circuitos_puntos_criticos (fec_alta, usuario, circ_id, pucr_id) FROM stdin;
    log       postgres    false    279            �          0    115274    contenedores 
   TABLE DATA               �   COPY log.contenedores (cont_id, codigo, descripcion, capacidad, anio_elaboracion, tara, habilitacion, fec_alta, usuario, usuario_app, esco_id, reci_id) FROM stdin;
    log       postgres    false    273            �          0    115527    deta_solicitudes_contenedor 
   TABLE DATA               t   COPY log.deta_solicitudes_contenedor (desc_id, cantidad, otro, fec_alta, usuario, usuario_app, tica_id) FROM stdin;
    log       postgres    false    285            �          0    115544    entregas_contenedor 
   TABLE DATA               3   COPY log.entregas_contenedor (enco_id) FROM stdin;
    log       postgres    false    287            �          0    115325    puntos_criticos 
   TABLE DATA               �   COPY log.puntos_criticos (pucr_id, nombre, descripcion, lat, lng, fec_alta, usuario, usuario_app, zona_id, eliminado) FROM stdin;
    log       postgres    false    276            �          0    115453    solicitantes_transporte 
   TABLE DATA               �   COPY log.solicitantes_transporte (sotr_id, razon_social, cuit, domicilio, num_registro, lat, lng, usuario, fec_alta, usuario_app, zona_id, rubr_id, tist_id, tica_id, eliminado) FROM stdin;
    log       postgres    false    281            �          0    115489    solicitudes_contenedor 
   TABLE DATA               �   COPY log.solicitudes_contenedor (soco_id, num_orden, fec_orden, fec_retiro, fec_alta, usuario, sotr_id, tran_id, essc_id) FROM stdin;
    log       postgres    false    283            �          0    115548    solicitudes_retiro 
   TABLE DATA               2   COPY log.solicitudes_retiro (sore_id) FROM stdin;
    log       postgres    false    288            �          0    115299    tipos_carga_circuitos 
   TABLE DATA               Q   COPY log.tipos_carga_circuitos (fec_alta, usuario, circ_id, tica_id) FROM stdin;
    log       postgres    false    274            �          0    123308    tipos_carga_transportistas 
   TABLE DATA               V   COPY log.tipos_carga_transportistas (fec_alta, usuario, tran_id, tica_id) FROM stdin;
    log       postgres    false    292            �          0    115162    transportistas 
   TABLE DATA               �   COPY log.transportistas (tran_id, razon_social, descripcion, direccion, telefono, contacto, resolucion, registro, fec_alta_efectiva, fec_baja_efectiva, fec_alta, usuario, usuario_app, eliminado) FROM stdin;
    log       postgres    false    265            �          0    57723    costos 
   TABLE DATA               ]   COPY prd.costos (fec_vigencia, valor, umed, fec_alta, usuario, recu_id, empr_id) FROM stdin;
    prd       postgres    false    211            �          0    98636    empaque 
   TABLE DATA               u   COPY prd.empaque (empa_id, nombre, unidad_medida, capacidad, empr_id, usuario_app, eliminado, fech_alta) FROM stdin;
    prd       postgres    false    254            �          0    74635    establecimientos 
   TABLE DATA               �   COPY prd.establecimientos (esta_id, nombre, lng, lat, calle, altura, localidad, estado, pais, fec_alta, usuario, empr_id) FROM stdin;
    prd       postgres    false    244            �          0    57630    etapas 
   TABLE DATA               {   COPY prd.etapas (etap_id, nombre, nom_recipiente, fec_alta, usuario, proc_id, eliminado, empr_id, orden, link) FROM stdin;
    prd       postgres    false    204            �          0    98674    fraccionamientos 
   TABLE DATA               g   COPY prd.fraccionamientos (frac_id, recu_id, empa_id, cantidad, fecha, eliminado, empr_id) FROM stdin;
    prd       postgres    false    258            �          0    57652    lotes 
   TABLE DATA               �   COPY prd.lotes (lote_id, batch_id, estado, num_orden_prod, fec_alta, usuario, etap_id, eliminado, nombre, reci_id, empr_id, usuario_app, arti_id) FROM stdin;
    prd       postgres    false    206            �          0    57700    lotes_hijos 
   TABLE DATA               }   COPY prd.lotes_hijos (batch_id, batch_id_padre, fec_alta, usuario, eliminado, empr_id, cantidad, cantidad_padre) FROM stdin;
    prd       postgres    false    210            �          0    74786    movimientos_trasportes 
   TABLE DATA               �   COPY prd.movimientos_trasportes (motr_id, boleta, fecha_entrada, patente, acoplado, conductor, tipo, bruto, tara, neto, prov_id, esta_id, fec_alta, eliminado, estado, reci_id, transportista, cuit, accion) FROM stdin;
    prd       postgres    false    249            �          0    57615    procesos 
   TABLE DATA               L   COPY prd.procesos (proc_id, nombre, fec_alta, usuario, empr_id) FROM stdin;
    prd       postgres    false    202            �          0    74759    recipientes 
   TABLE DATA               z   COPY prd.recipientes (reci_id, tipo, estado, nombre, fec_alta, usuario, eliminado, empr_id, depo_id, motr_id) FROM stdin;
    prd       postgres    false    247            �          0    57670    recursos 
   TABLE DATA               �   COPY prd.recursos (recu_id, tipo, cant_capacidad, umed_capacidad, cant_tiempo_capacidad, umed_iempo_capacidad, fec_alta, usuario, arti_id, empr_id, equi_id) FROM stdin;
    prd       postgres    false    208            �          0    57682    recursos_lotes 
   TABLE DATA               |   COPY prd.recursos_lotes (batch_id, recu_id, fec_alta, usuario, empr_id, cantidad, tipo, empa_id, empa_cantidad) FROM stdin;
    prd       postgres    false    209            +           0    0    ajustes_ajus_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('alm.ajustes_ajus_id_seq', 44, true);
            alm       postgres    false    259            ,           0    0    alm_articulos_arti_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('alm.alm_articulos_arti_id_seq', 68, true);
            alm       postgres    false    220            -           0    0    alm_depositos_depo_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('alm.alm_depositos_depo_id_seq', 7, true);
            alm       postgres    false    222            .           0    0 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE SET     R   SELECT pg_catalog.setval('alm.alm_deta_entrega_materiales_deen_id_seq', 9, true);
            alm       postgres    false    241            /           0    0 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE SET     T   SELECT pg_catalog.setval('alm.alm_deta_pedidos_materiales_depe_id_seq', 137, true);
            alm       postgres    false    232            0           0    0 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE SET     T   SELECT pg_catalog.setval('alm.alm_deta_recepcion_materiales_dere_id_seq', 4, true);
            alm       postgres    false    218            1           0    0 "   alm_entrega_materiales_enma_id_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('alm.alm_entrega_materiales_enma_id_seq', 1, true);
            alm       postgres    false    234            2           0    0    alm_lotes_lote_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('alm.alm_lotes_lote_id_seq', 74, true);
            alm       postgres    false    236            3           0    0 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('alm.alm_pedidos_materiales_pema_id_seq', 192, true);
            alm       postgres    false    224            4           0    0    alm_proveedores_prov_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('alm.alm_proveedores_prov_id_seq', 6, true);
            alm       postgres    false    226            5           0    0 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('alm.alm_recepcion_materiales_rema_id_seq', 2, true);
            alm       postgres    false    239            6           0    0    deta_ajustes_deaj_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('alm.deta_ajustes_deaj_id_seq', 27, true);
            alm       postgres    false    261            7           0    0    items_item_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('alm.items_item_id_seq', 1, false);
            alm       postgres    false    228            8           0    0    utl_tablas_tabl_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('alm.utl_tablas_tabl_id_seq', 17, true);
            alm       postgres    false    230            9           0    0    departamentos_depa_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('core.departamentos_depa_id_seq', 4, true);
            core       postgres    false    268            :           0    0    empresas_empr_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('core.empresas_empr_id_seq', 1, true);
            core       postgres    false    245            ;           0    0    equipos_equi_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('core.equipos_equi_id_seq', 23, true);
            core       postgres    false    252            <           0    0    snapshots_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('core.snapshots_id_seq', 58, true);
            core       postgres    false    289            =           0    0    zonas_zona_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('core.zonas_zona_id_seq', 8, true);
            core       postgres    false    266            >           0    0    formularios_form_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('frm.formularios_form_id_seq', 1, false);
            frm       postgres    false    212            ?           0    0    instancias_items_init_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('frm.instancias_items_init_id_seq', 1, false);
            frm       postgres    false    214            @           0    0    items_item_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('frm.items_item_id_seq', 1, false);
            frm       postgres    false    216            A           0    0    choferes_chof_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('log.choferes_chof_id_seq', 6, true);
            log       postgres    false    277            B           0    0    circuitos_circu_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('log.circuitos_circu_id_seq', 5, true);
            log       postgres    false    270            C           0    0    containers_cont_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('log.containers_cont_id_seq', 8, true);
            log       postgres    false    272            D           0    0 '   deta_solicitudes_contenedor_desc_id_seq    SEQUENCE SET     S   SELECT pg_catalog.setval('log.deta_solicitudes_contenedor_desc_id_seq', 1, false);
            log       postgres    false    284            E           0    0    entregas_contenedor_enco_id_seq    SEQUENCE SET     K   SELECT pg_catalog.setval('log.entregas_contenedor_enco_id_seq', 1, false);
            log       postgres    false    286            F           0    0    puntos_criticos_pucr_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('log.puntos_criticos_pucr_id_seq', 4, true);
            log       postgres    false    275            G           0    0 #   solicitantes_transporte_sotr_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('log.solicitantes_transporte_sotr_id_seq', 1, true);
            log       postgres    false    280            H           0    0 "   solicitudes_contenedor_soco_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('log.solicitudes_contenedor_soco_id_seq', 1, false);
            log       postgres    false    282            I           0    0    transportistas_tran_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('log.transportistas_tran_id_seq', 3, true);
            log       postgres    false    264            J           0    0    empaque_empa_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('prd.empaque_empa_id_seq', 5, true);
            prd       postgres    false    255            K           0    0    establecimientos_esta_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('prd.establecimientos_esta_id_seq', 3, true);
            prd       postgres    false    243            L           0    0    etapas_etap_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('prd.etapas_etap_id_seq', 1, true);
            prd       postgres    false    203            M           0    0    fraccionamientos_frac_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('prd.fraccionamientos_frac_id_seq', 3, true);
            prd       postgres    false    257            N           0    0    lotes_batch_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('prd.lotes_batch_id_seq', 191, true);
            prd       postgres    false    205            O           0    0 "   movimientos_trasportes_motr_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('prd.movimientos_trasportes_motr_id_seq', 30, true);
            prd       postgres    false    248            P           0    0    productos_prod_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('prd.productos_prod_id_seq', 1, true);
            prd       postgres    false    201            Q           0    0    recipiente_reci_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('prd.recipiente_reci_id_seq', 106, true);
            prd       postgres    false    250            R           0    0    recursos_recu_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('prd.recursos_recu_id_seq', 16, true);
            prd       postgres    false    207            �           2606    106917    ajustes ajustes_pk 
   CONSTRAINT     R   ALTER TABLE ONLY alm.ajustes
    ADD CONSTRAINT ajustes_pk PRIMARY KEY (ajus_id);
 9   ALTER TABLE ONLY alm.ajustes DROP CONSTRAINT ajustes_pk;
       alm         postgres    false    260            �           2606    74443     alm_articulos alm_articulos_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY alm.alm_articulos
    ADD CONSTRAINT alm_articulos_pkey PRIMARY KEY (arti_id);
 G   ALTER TABLE ONLY alm.alm_articulos DROP CONSTRAINT alm_articulos_pkey;
       alm         postgres    false    221            �           2606    74462     alm_depositos alm_depositos_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY alm.alm_depositos
    ADD CONSTRAINT alm_depositos_pkey PRIMARY KEY (depo_id);
 G   ALTER TABLE ONLY alm.alm_depositos DROP CONSTRAINT alm_depositos_pkey;
       alm         postgres    false    223            �           2606    74624 <   alm_deta_entrega_materiales alm_deta_entrega_materiales_pkey 
   CONSTRAINT     |   ALTER TABLE ONLY alm.alm_deta_entrega_materiales
    ADD CONSTRAINT alm_deta_entrega_materiales_pkey PRIMARY KEY (deen_id);
 c   ALTER TABLE ONLY alm.alm_deta_entrega_materiales DROP CONSTRAINT alm_deta_entrega_materiales_pkey;
       alm         postgres    false    242            �           2606    74531 <   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_pkey 
   CONSTRAINT     |   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_pkey PRIMARY KEY (depe_id);
 c   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_pkey;
       alm         postgres    false    233            �           2606    74410 @   alm_deta_recepcion_materiales alm_deta_recepcion_materiales_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales
    ADD CONSTRAINT alm_deta_recepcion_materiales_pkey PRIMARY KEY (dere_id);
 g   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales DROP CONSTRAINT alm_deta_recepcion_materiales_pkey;
       alm         postgres    false    219            �           2606    74554 2   alm_entrega_materiales alm_entrega_materiales_pkey 
   CONSTRAINT     r   ALTER TABLE ONLY alm.alm_entrega_materiales
    ADD CONSTRAINT alm_entrega_materiales_pkey PRIMARY KEY (enma_id);
 Y   ALTER TABLE ONLY alm.alm_entrega_materiales DROP CONSTRAINT alm_entrega_materiales_pkey;
       alm         postgres    false    235            �           2606    74574    alm_lotes alm_lotes_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_pkey PRIMARY KEY (lote_id);
 ?   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_pkey;
       alm         postgres    false    237            �           2606    74478 2   alm_pedidos_materiales alm_pedidos_materiales_pkey 
   CONSTRAINT     r   ALTER TABLE ONLY alm.alm_pedidos_materiales
    ADD CONSTRAINT alm_pedidos_materiales_pkey PRIMARY KEY (pema_id);
 Y   ALTER TABLE ONLY alm.alm_pedidos_materiales DROP CONSTRAINT alm_pedidos_materiales_pkey;
       alm         postgres    false    225            �           2606    74589 8   alm_proveedores_articulos alm_proveedores_articulos_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_pkey PRIMARY KEY (prov_id, arti_id);
 _   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_pkey;
       alm         postgres    false    238    238            �           2606    74498 $   alm_proveedores alm_proveedores_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY alm.alm_proveedores
    ADD CONSTRAINT alm_proveedores_pkey PRIMARY KEY (prov_id);
 K   ALTER TABLE ONLY alm.alm_proveedores DROP CONSTRAINT alm_proveedores_pkey;
       alm         postgres    false    227            �           2606    74609 6   alm_recepcion_materiales alm_recepcion_materiales_pkey 
   CONSTRAINT     v   ALTER TABLE ONLY alm.alm_recepcion_materiales
    ADD CONSTRAINT alm_recepcion_materiales_pkey PRIMARY KEY (rema_id);
 ]   ALTER TABLE ONLY alm.alm_recepcion_materiales DROP CONSTRAINT alm_recepcion_materiales_pkey;
       alm         postgres    false    240            �           2606    106955    deta_ajustes deta_ajustes_pk 
   CONSTRAINT     \   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_pk PRIMARY KEY (deaj_id);
 C   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_pk;
       alm         postgres    false    262            �           2606    74511    items items_pk 
   CONSTRAINT     N   ALTER TABLE ONLY alm.items
    ADD CONSTRAINT items_pk PRIMARY KEY (item_id);
 5   ALTER TABLE ONLY alm.items DROP CONSTRAINT items_pk;
       alm         postgres    false    229            �           2606    74521    utl_tablas utl_tablas_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY alm.utl_tablas
    ADD CONSTRAINT utl_tablas_pkey PRIMARY KEY (tabl_id);
 A   ALTER TABLE ONLY alm.utl_tablas DROP CONSTRAINT utl_tablas_pkey;
       alm         postgres    false    231            �           2606    115221    departamentos departamentos_pk 
   CONSTRAINT     _   ALTER TABLE ONLY core.departamentos
    ADD CONSTRAINT departamentos_pk PRIMARY KEY (depa_id);
 F   ALTER TABLE ONLY core.departamentos DROP CONSTRAINT departamentos_pk;
       core         postgres    false    269            �           2606    74713    empresas empresas_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY core.empresas
    ADD CONSTRAINT empresas_pkey PRIMARY KEY (empr_id);
 >   ALTER TABLE ONLY core.empresas DROP CONSTRAINT empresas_pkey;
       core         postgres    false    246            �           2606    98630    equipos equipos_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY core.equipos
    ADD CONSTRAINT equipos_pkey PRIMARY KEY (equi_id);
 <   ALTER TABLE ONLY core.equipos DROP CONSTRAINT equipos_pkey;
       core         postgres    false    253            �           2606    115119    tablas tablas_pk 
   CONSTRAINT     Q   ALTER TABLE ONLY core.tablas
    ADD CONSTRAINT tablas_pk PRIMARY KEY (tabl_id);
 8   ALTER TABLE ONLY core.tablas DROP CONSTRAINT tablas_pk;
       core         postgres    false    263            �           2606    98660     transportistas transportistas_pk 
   CONSTRAINT     ^   ALTER TABLE ONLY core.transportistas
    ADD CONSTRAINT transportistas_pk PRIMARY KEY (cuit);
 H   ALTER TABLE ONLY core.transportistas DROP CONSTRAINT transportistas_pk;
       core         postgres    false    256            �           2606    115384    zonas zonas_pk 
   CONSTRAINT     O   ALTER TABLE ONLY core.zonas
    ADD CONSTRAINT zonas_pk PRIMARY KEY (zona_id);
 6   ALTER TABLE ONLY core.zonas DROP CONSTRAINT zonas_pk;
       core         postgres    false    267            �           2606    57793    formularios formularios_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY frm.formularios
    ADD CONSTRAINT formularios_pk PRIMARY KEY (form_id);
 A   ALTER TABLE ONLY frm.formularios DROP CONSTRAINT formularios_pk;
       frm         postgres    false    213            �           2606    57811 $   instancias_items instancias_items_pk 
   CONSTRAINT     d   ALTER TABLE ONLY frm.instancias_items
    ADD CONSTRAINT instancias_items_pk PRIMARY KEY (init_id);
 K   ALTER TABLE ONLY frm.instancias_items DROP CONSTRAINT instancias_items_pk;
       frm         postgres    false    215            �           2606    57828    items items_pk 
   CONSTRAINT     N   ALTER TABLE ONLY frm.items
    ADD CONSTRAINT items_pk PRIMARY KEY (item_id);
 5   ALTER TABLE ONLY frm.items DROP CONSTRAINT items_pk;
       frm         postgres    false    217            �           2606    115372    choferes choferes_dni_un 
   CONSTRAINT     U   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_dni_un UNIQUE (documento);
 ?   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_dni_un;
       log         postgres    false    278            �           2606    115370    choferes choferes_pk 
   CONSTRAINT     T   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_pk PRIMARY KEY (chof_id);
 ;   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_pk;
       log         postgres    false    278            �           2606    115308    circuitos circuitos_pk 
   CONSTRAINT     V   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_pk PRIMARY KEY (circ_id);
 =   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_pk;
       log         postgres    false    271            �           2606    115440 6   circuitos_puntos_criticos circuitos_puntos_criticos_pk 
   CONSTRAINT        ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_pk PRIMARY KEY (circ_id, pucr_id);
 ]   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_pk;
       log         postgres    false    279    279            �           2606    115310    circuitos circuitos_un 
   CONSTRAINT     P   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_un UNIQUE (codigo);
 =   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_un;
       log         postgres    false    271            �           2606    115286 !   contenedores containers_codigo_un 
   CONSTRAINT     [   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_codigo_un UNIQUE (codigo);
 H   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_codigo_un;
       log         postgres    false    273            �           2606    115284    contenedores containers_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_pk PRIMARY KEY (cont_id);
 A   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_pk;
       log         postgres    false    273            �           2606    115288 "   contenedores containers_reci_id_un 
   CONSTRAINT     ]   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_reci_id_un UNIQUE (reci_id);
 I   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_reci_id_un;
       log         postgres    false    273            �           2606    115541 :   deta_solicitudes_contenedor deta_solicitudes_contenedor_pk 
   CONSTRAINT     z   ALTER TABLE ONLY log.deta_solicitudes_contenedor
    ADD CONSTRAINT deta_solicitudes_contenedor_pk PRIMARY KEY (desc_id);
 a   ALTER TABLE ONLY log.deta_solicitudes_contenedor DROP CONSTRAINT deta_solicitudes_contenedor_pk;
       log         postgres    false    285            �           2606    115335 "   puntos_criticos puntos_criticos_pk 
   CONSTRAINT     b   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_pk PRIMARY KEY (pucr_id);
 I   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_pk;
       log         postgres    false    276            �           2606    115337 "   puntos_criticos puntos_criticos_un 
   CONSTRAINT     \   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_un UNIQUE (nombre);
 I   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_un;
       log         postgres    false    276            �           2606    115463 1   solicitantes_transporte solcitantes_transporte_pk 
   CONSTRAINT     q   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_pk PRIMARY KEY (sotr_id);
 X   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_pk;
       log         postgres    false    281            �           2606    115465 1   solicitantes_transporte solcitantes_transporte_un 
   CONSTRAINT     i   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_un UNIQUE (cuit);
 X   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_un;
       log         postgres    false    281            �           2606    115499 0   solicitudes_contenedor solicitudes_contenedor_pk 
   CONSTRAINT     p   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedor_pk PRIMARY KEY (soco_id);
 W   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedor_pk;
       log         postgres    false    283            �           2606    115501 0   solicitudes_contenedor solicitudes_contenedor_un 
   CONSTRAINT     m   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedor_un UNIQUE (num_orden);
 W   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedor_un;
       log         postgres    false    283            �           2606    115400 .   tipos_carga_circuitos tipos_carga_circuitos_pk 
   CONSTRAINT     w   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_carga_circuitos_pk PRIMARY KEY (circ_id, tica_id);
 U   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_carga_circuitos_pk;
       log         postgres    false    274    274            �           2606    123317 8   tipos_carga_transportistas tipos_carga_transportistas_pk 
   CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_pk PRIMARY KEY (tran_id, tica_id);
 _   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_pk;
       log         postgres    false    292    292            �           2606    115172     transportistas transportistas_pk 
   CONSTRAINT     `   ALTER TABLE ONLY log.transportistas
    ADD CONSTRAINT transportistas_pk PRIMARY KEY (tran_id);
 G   ALTER TABLE ONLY log.transportistas DROP CONSTRAINT transportistas_pk;
       log         postgres    false    265            �           2606    115174     transportistas transportistas_un 
   CONSTRAINT     `   ALTER TABLE ONLY log.transportistas
    ADD CONSTRAINT transportistas_un UNIQUE (razon_social);
 G   ALTER TABLE ONLY log.transportistas DROP CONSTRAINT transportistas_un;
       log         postgres    false    265            �           2606    57737    costos costos_pk 
   CONSTRAINT     ^   ALTER TABLE ONLY prd.costos
    ADD CONSTRAINT costos_pk PRIMARY KEY (fec_vigencia, recu_id);
 7   ALTER TABLE ONLY prd.costos DROP CONSTRAINT costos_pk;
       prd         postgres    false    211    211            �           2606    98646    empaque empaque_pk 
   CONSTRAINT     R   ALTER TABLE ONLY prd.empaque
    ADD CONSTRAINT empaque_pk PRIMARY KEY (empa_id);
 9   ALTER TABLE ONLY prd.empaque DROP CONSTRAINT empaque_pk;
       prd         postgres    false    254            �           2606    74643 $   establecimientos establecimientos_pk 
   CONSTRAINT     d   ALTER TABLE ONLY prd.establecimientos
    ADD CONSTRAINT establecimientos_pk PRIMARY KEY (esta_id);
 K   ALTER TABLE ONLY prd.establecimientos DROP CONSTRAINT establecimientos_pk;
       prd         postgres    false    244            �           2606    57640    etapas etapas_pk 
   CONSTRAINT     P   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_pk PRIMARY KEY (etap_id);
 7   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_pk;
       prd         postgres    false    204            �           2606    98616    etapas etapas_un 
   CONSTRAINT     S   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_un UNIQUE (nombre, proc_id);
 7   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_un;
       prd         postgres    false    204    204            �           2606    98614    etapas etapas_un_2 
   CONSTRAINT     T   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_un_2 UNIQUE (orden, proc_id);
 9   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_un_2;
       prd         postgres    false    204    204            �           2606    74733    lotes lotes_un 
   CONSTRAINT     J   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_un UNIQUE (batch_id);
 5   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_un;
       prd         postgres    false    206            �           2606    74795 0   movimientos_trasportes movimientos_trasportes_pk 
   CONSTRAINT     p   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_pk PRIMARY KEY (motr_id);
 W   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_pk;
       prd         postgres    false    249            �           2606    57625    procesos productos_pk 
   CONSTRAINT     U   ALTER TABLE ONLY prd.procesos
    ADD CONSTRAINT productos_pk PRIMARY KEY (proc_id);
 <   ALTER TABLE ONLY prd.procesos DROP CONSTRAINT productos_pk;
       prd         postgres    false    202            �           2606    57627    procesos productos_un 
   CONSTRAINT     O   ALTER TABLE ONLY prd.procesos
    ADD CONSTRAINT productos_un UNIQUE (nombre);
 <   ALTER TABLE ONLY prd.procesos DROP CONSTRAINT productos_un;
       prd         postgres    false    202            �           2606    74771    recipientes recipientes_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_pk PRIMARY KEY (reci_id);
 A   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_pk;
       prd         postgres    false    247            �           2606    57679    recursos recursos_pk 
   CONSTRAINT     T   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_pk PRIMARY KEY (recu_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_pk;
       prd         postgres    false    208            �           2606    82232    recursos recursos_un 
   CONSTRAINT     O   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_un UNIQUE (arti_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_un;
       prd         postgres    false    208            %           2620    98705 0   alm_deta_entrega_materiales asociar_lote_hijo_ai    TRIGGER     �   CREATE TRIGGER asociar_lote_hijo_ai AFTER INSERT ON alm.alm_deta_entrega_materiales FOR EACH ROW EXECUTE PROCEDURE prd.asociar_lote_hijo_trg();
 F   DROP TRIGGER asociar_lote_hijo_ai ON alm.alm_deta_entrega_materiales;
       alm       postgres    false    310    242            #           2620    82229    alm_articulos crear_producto_ai    TRIGGER        CREATE TRIGGER crear_producto_ai AFTER INSERT ON alm.alm_articulos FOR EACH ROW EXECUTE PROCEDURE prd.crear_prd_recurso_trg();
 5   DROP TRIGGER crear_producto_ai ON alm.alm_articulos;
       alm       postgres    false    311    221            $           2620    82230 "   alm_articulos eliminar_producto_ad    TRIGGER     �   CREATE TRIGGER eliminar_producto_ad AFTER DELETE ON alm.alm_articulos FOR EACH ROW EXECUTE PROCEDURE prd.eliminar_prd_recurso_trg();
 8   DROP TRIGGER eliminar_producto_ad ON alm.alm_articulos;
       alm       postgres    false    312    221            &           2620    115124    tablas set_tabla_id_bui    TRIGGER        CREATE TRIGGER set_tabla_id_bui BEFORE INSERT OR UPDATE ON core.tablas FOR EACH ROW EXECUTE PROCEDURE core.set_tabla_id_trg();
 .   DROP TRIGGER set_tabla_id_bui ON core.tablas;
       core       postgres    false    314    263            �           2606    115378    alm_articulos alm_articulos_fk    FK CONSTRAINT     {   ALTER TABLE ONLY alm.alm_articulos
    ADD CONSTRAINT alm_articulos_fk FOREIGN KEY (tipo) REFERENCES core.tablas(tabl_id);
 E   ALTER TABLE ONLY alm.alm_articulos DROP CONSTRAINT alm_articulos_fk;
       alm       postgres    false    221    263    3268                       2606    74625 :   alm_deta_entrega_materiales alm_deta_entrega_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_entrega_materiales
    ADD CONSTRAINT alm_deta_entrega_materiales_fk FOREIGN KEY (enma_id) REFERENCES alm.alm_entrega_materiales(enma_id);
 a   ALTER TABLE ONLY alm.alm_deta_entrega_materiales DROP CONSTRAINT alm_deta_entrega_materiales_fk;
       alm       postgres    false    3240    242    235            �           2606    74532 :   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 a   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_fk;
       alm       postgres    false    3226    221    233            �           2606    74537 <   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_fk_1 FOREIGN KEY (pema_id) REFERENCES alm.alm_pedidos_materiales(pema_id);
 c   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_fk_1;
       alm       postgres    false    233    225    3230            �           2606    74555 0   alm_entrega_materiales alm_entrega_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_entrega_materiales
    ADD CONSTRAINT alm_entrega_materiales_fk FOREIGN KEY (pema_id) REFERENCES alm.alm_pedidos_materiales(pema_id);
 W   ALTER TABLE ONLY alm.alm_entrega_materiales DROP CONSTRAINT alm_entrega_materiales_fk;
       alm       postgres    false    235    225    3230            �           2606    74777 %   alm_depositos alm_establecimientos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_depositos
    ADD CONSTRAINT alm_establecimientos_fk FOREIGN KEY (esta_id) REFERENCES prd.establecimientos(esta_id);
 L   ALTER TABLE ONLY alm.alm_depositos DROP CONSTRAINT alm_establecimientos_fk;
       alm       postgres    false    244    3250    223            �           2606    74575    alm_lotes alm_lotes_fk    FK CONSTRAINT     |   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 =   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_fk;
       alm       postgres    false    221    237    3226            �           2606    74580    alm_lotes alm_lotes_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_fk_1 FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 ?   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_fk_1;
       alm       postgres    false    227    237    3232                        2606    74880    alm_lotes alm_lotes_lotes_fk    FK CONSTRAINT     |   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 C   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_lotes_fk;
       alm       postgres    false    3210    206    237                       2606    74590 6   alm_proveedores_articulos alm_proveedores_articulos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 ]   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_fk;
       alm       postgres    false    3226    221    238                       2606    74595 8   alm_proveedores_articulos alm_proveedores_articulos_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_fk_1 FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 _   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_fk_1;
       alm       postgres    false    3232    238    227                       2606    74610 4   alm_recepcion_materiales alm_recepcion_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_recepcion_materiales
    ADD CONSTRAINT alm_recepcion_materiales_fk FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 [   ALTER TABLE ONLY alm.alm_recepcion_materiales DROP CONSTRAINT alm_recepcion_materiales_fk;
       alm       postgres    false    227    240    3232                       2606    106964 $   deta_ajustes deta_ajustes_ajustes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_ajustes_fk FOREIGN KEY (ajus_id) REFERENCES alm.ajustes(ajus_id);
 K   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_ajustes_fk;
       alm       postgres    false    262    3264    260                       2606    106956 &   deta_ajustes deta_ajustes_alm_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_alm_lotes_fk FOREIGN KEY (lote_id) REFERENCES alm.alm_lotes(lote_id);
 M   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_alm_lotes_fk;
       alm       postgres    false    3242    237    262                       2606    115223    zonas zonas_fk    FK CONSTRAINT     v   ALTER TABLE ONLY core.zonas
    ADD CONSTRAINT zonas_fk FOREIGN KEY (depa_id) REFERENCES core.departamentos(depa_id);
 6   ALTER TABLE ONLY core.zonas DROP CONSTRAINT zonas_fk;
       core       postgres    false    269    267    3276                       2606    115373    choferes choferes_fk    FK CONSTRAINT     {   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 ;   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_fk;
       log       postgres    false    278    265    3270                       2606    115441 6   circuitos_puntos_criticos circuitos_puntos_criticos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_fk FOREIGN KEY (circ_id) REFERENCES log.circuitos(circ_id);
 ]   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_fk;
       log       postgres    false    279    3278    271                       2606    115446 8   circuitos_puntos_criticos circuitos_puntos_criticos_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_fk_1 FOREIGN KEY (pucr_id) REFERENCES log.puntos_criticos(pucr_id);
 _   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_fk_1;
       log       postgres    false    3290    279    276                       2606    123390    circuitos circuitos_zona_id_fk    FK CONSTRAINT     }   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 E   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_zona_id_fk;
       log       postgres    false    3274    271    267                       2606    115294    contenedores containers_fk    FK CONSTRAINT     z   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_fk FOREIGN KEY (esco_id) REFERENCES core.tablas(tabl_id);
 A   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_fk;
       log       postgres    false    3268    263    273                       2606    115289 "   contenedores containers_reci_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_reci_id_fk FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 I   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_reci_id_fk;
       log       postgres    false    273    247    3254                        2606    115535 B   deta_solicitudes_contenedor deta_solicitudes_contenedor_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.deta_solicitudes_contenedor
    ADD CONSTRAINT deta_solicitudes_contenedor_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 i   ALTER TABLE ONLY log.deta_solicitudes_contenedor DROP CONSTRAINT deta_solicitudes_contenedor_tica_id_fk;
       log       postgres    false    3268    285    263                       2606    115411 *   puntos_criticos puntos_criticos_zona_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 Q   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_zona_id_fk;
       log       postgres    false    267    276    3274                       2606    115466 9   solicitantes_transporte solcitantes_transporte_rubr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_rubr_id_fk FOREIGN KEY (rubr_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_rubr_id_fk;
       log       postgres    false    3268    281    263                       2606    115476 9   solicitantes_transporte solcitantes_transporte_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_tica_id_fk;
       log       postgres    false    3268    263    281                       2606    115471 9   solicitantes_transporte solcitantes_transporte_tisr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_tisr_id_fk FOREIGN KEY (tist_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_tisr_id_fk;
       log       postgres    false    281    3268    263                       2606    115481 9   solicitantes_transporte solcitantes_transporte_zona_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_zona_id_fk;
       log       postgres    false    3274    267    281                       2606    115520 8   solicitudes_contenedor solicitudes_contenedor_essc_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedor_essc_id_fk FOREIGN KEY (essc_id) REFERENCES core.tablas(tabl_id);
 _   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedor_essc_id_fk;
       log       postgres    false    3268    283    263                       2606    115502 8   solicitudes_contenedor solicitudes_contenedor_sotr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedor_sotr_id_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 _   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedor_sotr_id_fk;
       log       postgres    false    3300    281    283                       2606    115507 8   solicitudes_contenedor solicitudes_contenedor_tran_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedor_tran_id_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 _   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedor_tran_id_fk;
       log       postgres    false    265    283    3270                       2606    115401 6   tipos_carga_circuitos tipos_carga_circuitos_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_carga_circuitos_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 ]   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_carga_circuitos_tica_id_fk;
       log       postgres    false    274    3268    263            "           2606    123323 8   tipos_carga_transportistas tipos_carga_transportistas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 _   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_fk;
       log       postgres    false    3270    292    265            !           2606    123318 @   tipos_carga_transportistas tipos_carga_transportistas_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 g   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_tica_id_fk;
       log       postgres    false    3268    292    263                       2606    115313 0   tipos_carga_circuitos tipos_residuo_circuitos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_residuo_circuitos_fk FOREIGN KEY (circ_id) REFERENCES log.circuitos(circ_id);
 W   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_residuo_circuitos_fk;
       log       postgres    false    271    3278    274            �           2606    57731    costos costos_recursos_fk    FK CONSTRAINT     z   ALTER TABLE ONLY prd.costos
    ADD CONSTRAINT costos_recursos_fk FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id);
 @   ALTER TABLE ONLY prd.costos DROP CONSTRAINT costos_recursos_fk;
       prd       postgres    false    208    211    3212                       2606    98685    fraccionamientos empa_id    FK CONSTRAINT     x   ALTER TABLE ONLY prd.fraccionamientos
    ADD CONSTRAINT empa_id FOREIGN KEY (empa_id) REFERENCES prd.empaque(empa_id);
 ?   ALTER TABLE ONLY prd.fraccionamientos DROP CONSTRAINT empa_id;
       prd       postgres    false    258    254    3260            �           2606    57747    etapas etapas_procesos_fk    FK CONSTRAINT     z   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_procesos_fk FOREIGN KEY (proc_id) REFERENCES prd.procesos(proc_id);
 @   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_procesos_fk;
       prd       postgres    false    204    3200    202            �           2606    57663    lotes lotes_etapas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_etapas_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id) ON DELETE RESTRICT;
 <   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_etapas_fk;
       prd       postgres    false    3204    206    204            �           2606    82169    lotes lotes_fk    FK CONSTRAINT     t   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 5   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_fk;
       prd       postgres    false    221    3226    206            �           2606    74739     lotes_hijos lotes_hijos_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_hijos
    ADD CONSTRAINT lotes_hijos_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 G   ALTER TABLE ONLY prd.lotes_hijos DROP CONSTRAINT lotes_hijos_lotes_fk;
       prd       postgres    false    3210    210    206            �           2606    74734 '   lotes_hijos lotes_hijos_lotes_padres_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_hijos
    ADD CONSTRAINT lotes_hijos_lotes_padres_fk FOREIGN KEY (batch_id_padre) REFERENCES prd.lotes(batch_id);
 N   ALTER TABLE ONLY prd.lotes_hijos DROP CONSTRAINT lotes_hijos_lotes_padres_fk;
       prd       postgres    false    3210    206    210            �           2606    74772    lotes lotes_recipientes_fk    FK CONSTRAINT     ~   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_recipientes_fk FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 A   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_recipientes_fk;
       prd       postgres    false    206    3254    247            
           2606    98661 ?   movimientos_trasportes movimientos_trasportes__transportista_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes__transportista_fk FOREIGN KEY (cuit) REFERENCES core.transportistas(cuit);
 f   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes__transportista_fk;
       prd       postgres    false    249    256    3262                       2606    74796 0   movimientos_trasportes movimientos_trasportes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 W   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk;
       prd       postgres    false    249    227    3232                       2606    74801 2   movimientos_trasportes movimientos_trasportes_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk_1 FOREIGN KEY (esta_id) REFERENCES prd.establecimientos(esta_id);
 Y   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk_1;
       prd       postgres    false    249    244    3250            	           2606    74870 2   movimientos_trasportes movimientos_trasportes_fk_2    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk_2 FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 Y   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk_2;
       prd       postgres    false    247    3254    249                       2606    74818 (   recipientes recipientes_alm_depositos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_alm_depositos_fk FOREIGN KEY (depo_id) REFERENCES alm.alm_depositos(depo_id);
 O   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_alm_depositos_fk;
       prd       postgres    false    247    3228    223                       2606    74875    recipientes recipientes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_fk FOREIGN KEY (motr_id) REFERENCES prd.movimientos_trasportes(motr_id);
 A   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_fk;
       prd       postgres    false    247    3256    249                       2606    98690    fraccionamientos recu_id    FK CONSTRAINT     y   ALTER TABLE ONLY prd.fraccionamientos
    ADD CONSTRAINT recu_id FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id);
 ?   ALTER TABLE ONLY prd.fraccionamientos DROP CONSTRAINT recu_id;
       prd       postgres    false    3212    208    258            �           2606    98631    recursos recursos_fk    FK CONSTRAINT     u   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_fk;
       prd       postgres    false    3258    253    208            �           2606    74744 &   recursos_lotes recursos_lotes_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recursos_lotes
    ADD CONSTRAINT recursos_lotes_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id) ON DELETE RESTRICT;
 M   ALTER TABLE ONLY prd.recursos_lotes DROP CONSTRAINT recursos_lotes_lotes_fk;
       prd       postgres    false    206    209    3210            �           2606    57695 )   recursos_lotes recursos_lotes_recursos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recursos_lotes
    ADD CONSTRAINT recursos_lotes_recursos_fk FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id) ON DELETE RESTRICT;
 P   ALTER TABLE ONLY prd.recursos_lotes DROP CONSTRAINT recursos_lotes_recursos_fk;
       prd       postgres    false    208    3212    209            �   _   x�3�tq��	u����NUHI-+M�)K�S ��̔�b���Ԃ�|��������9��J3�89�-u�tL9�KҋR��L�l^� ��4�      �   �  x����N�8���U�p+���vrDˢ�T�UOL�@��x6��Jok/aol?ǅ$C�M;�J2Ì������\&�'��\�eQ�v��a+���^�����O��3t�^��V_,�������e��תb����n�'.����$����2���Pr�)�iFL&NO����p��E�B���m�@��[�����E�ļ/>��OҠ3*qj(�������j\+��G���jz5�rT�*��-]���=)W�_M��2�1�RR�IQQ�������v�	e��H�H/:�P�"$'dG	*#
�)���D	�IBT��e�����ET�H����� HizH#=`�n}P��?����]X�B�� 0�I�c�����H �@�M�P�Y��M]죫r�x4�m�r '�� }�$�,��Rv�h+����5=�F�X4ǳ��̄�45�
�����:������t��zW��.C���u�������K����Mu����fL��(��HEU'�G	��շv�?�3F@BxY���Fh"��~���q���m�����#�/�=<�Q����Q]i&�o�Фu�����WE�d�c�� �6�Q�H��z}k�P��Ď���V��j��&�|ls1q�Ծ�l�b�R���F������wu��ȌK�$��)��Fǟ���O�Gנ�-��~U�O��}��~�z, ~�2��{HE0L_�-Bݞ��)��#���}�-��eHp��c�����.�.�!τ}t��w���+���������R�z3T��i��0��/}��^��-|���n��8�J�v�$��jަ-L癇�y��z�졀����k�l9aO�f<X��wU"i��!6��,��{0�|JΤ��a�)3��HQ�E��B�w���XƠ���x,��0F�G�f�ֈQZwI�<�dKr�[[��~4em�hƙ��D�������U#�kT`��鵫z���[��7pOQ���J�I��Z��2ۨ�NX A-2 iݏ���4�=�������,�v���h~�!:Oy8|i.���Դx8f�g��b-��>z�;��4|8ހ�<GE#�l'���� k�=_P��(�	/���
f�ƣ��D�Nx5/3�g�R��hUT����PzLk��t�%����=4�Lۻ��Q�W�.�2CB��X�����0Y{׍#��Uv�".I��E	��0cR�/d�.��>�U��l+�˵WB�N�^jL�O��r������5�&�Uo�~�{{{�ߚWj      �   o   x�}ͻ
�@F�z�)�v���l-�	�Rڤ�`!���q��0pڏ���e�~K �K x�D��:�jKbJ#�!"��>�_i8�e��V�q{.��q�E<��U�:T�)��N9$�      �   b   x��ͱ!��Tq�ǒ�1����_�ADR�u�����i.�ARh�/��E_��tʿ嵉P��mƥ�S�#���č�Q�m�ݏs1�1��O[k��+�      �   V  x�}�ˑ,)Eה�@�F�o��7a$�&
�9Q��{�������?�4-D�/�o��	⿊2��}u-���Uod�& a"V����h���= 2�*���� �hU�EH���Lc6����t��g�i�~}�����"c��������F�贀^h��l��>A�!�
�=�q�GQ��@����F��6�������]�����_mG�ز\'�IZG��Pl�á��>����G� ?�f�(��HU��QI�h�Wރa����Q����^�V�TB�س�@?���Q��d9����� �C��fMG��뱸G�{�
�4E$�� ? Q�U�.�
K����� 6�U3�2H��p�Fv𤽰\GL�Qr�!���a��zI�`����X6�+�Mъ�V�1j��Jh����q�� K�,6 Z�d��1�^��PhB�;B%�6丱q!~��l�� 8�HǕ��?��!l���	y&�",`8���~Ϳ����h�#�X�.��πT֘�ح'`πV0^ �@o���Ơ�	�g����5P��^���V����H�$zߙ�`o?3�n�/A���t�o�XC~@*��������e��;����W�/O���c<~R\[��a0�SZm���X�D�@|k�������ݗ��H���F�Z�] �:�>��O8��>S�0Y/���H�|v��-�8N;*]�(���t�w�����q���������l�E*-C��X�'����1Ң���bұ�'0���2bl�a�����	�Φm��?���]�M������;���oFx7�S���u1��>�^��y{�      �   V   x�m͹� D�xU���Q��,;"�俙UcM=���I$�^���(5{7<�ۇ}�r��؏�#t=�;3{蕉��v�      �   >   x�3�420��54�5��,�,��42626"N6�4BR�`hiehdel�ghlnƙ����� �;�      �   {  x���Mo�8����'�O��y�tS ��4�S�`�M�Ci��wH*�$K���bC|<�w�1�
B+�����y)�M {V��q��r�=Ya���g���Q�����@p�=	+�� ƨC�;��'�F�ӄ$c����!���<�!q�B�,	+I���XI!�܁�T�����B�؝��IH� �u}��n�ٝ~
W@騻ɴK>GJ��IOJFҬ����r<��@:D/D5C��4+�@#ؑ�N�۞�{=�ృ�A����H��3�h��c�� r��� J�h]P�!�밣i�4S}L����Q~-��FS�4�l,%�9���q���-��4]�ʵ ):���oC	D�XVL��IK�q���͇�����øbZbY=�O����(c�a�?S՚�P���
*DE&+r�Pyu�2��e�Le*G5�ػ��+�l��?n��<�gq�[�`��k�6p	&�����̕�RI�Ъ�����c��ދ�������;�/!X��Ld���\�gŊ�f)�*_<�l^�СY%ybmes@F�i������� �2R���<�����;���A�\.��U�����t��F�63⤻��1�ll�mf@rғT_�t�I3בr�2�#B�	;I����"������?Xfm�G3��R���Y;1/�QZX֨2�lv�pIJI�ҧ�� ���`�`.�`.�0��t�ɇ��0v^������6��S%��~����V��U���y��������z �ء\.�p��:	�c�7���%<V���d�D�,�R^LNi������_��zH�u	�G3�j��i�
M��g���T��i,e�1F+�ԤRp*������ߏOo�v�q�gl�X�h�I���TM��5��T�2�S�j��t{�i���QH�8yKPUZ�՟t����)�psm:���Y����M'�ˠ�qi�k�ru�	�h��*�mk2��ͤBr����O��vi'�m���ӡs��N�ojAm�qT*��)6���_
�����18k1[L�uJ��y'���~;���Q�<���@���m���}��ڮ��wl���a�a��W�L_������Ζ��`��Ms"S�Zl��(���s����      �     x���=�$+���U���~�0g����g�KIQ��Β�)/�+�HW"�;�� �;|���_p~�	~��x^ m�|��^\ E�.M���,�p_�ZR�~�L�Er17�+�Q!���pmrVH{UjcQ��B.[�6�	��2�t
�Ʀc�.`U�R��Rru>(WP��7s�RA�nz�(I�m:Ϡ)��&�F�Z�M������0{�Fk����7--��ż�]~ހ�F�Z�K����
Ƽ�����7�ג���.�3጖<b������6�Y���n��W;�g�-=�ECi��3ZzP�����W͈�F�����2bzP�P��9ʈ�A��Pw���tz���1(#�7M��1�(��=glIPEL�g�����&���d�������LE1Y�B�|���P������"����`EJ�E���\��Ev�s�[��D4�3߼��쎇�A;s^I��?��p^I�������y%j��p&�����N��,p^J�6�6���D���')K^L�|!y1�G�M�p^L��ao�T��f�xF���P��*gԊ�`K�9���Q3�|&\Q,_�yr�T�dY����珨�Z|Yf#��
T=A��iY��Z]D�x�eR*��a�2i��{P5�f��Tc�Bn�;6�9�j5�.v^τGUW�-D����x�QW53`�4O�y5AdH|�ȫ	��fJϨy5�K¢?�S+��	?��~r:����"����j�i>�V�H�3��(�����Ȳ����*�r����X��՘���{������?����R���8�p? 7NE=�A?�6����0Kb]�^Ϸ��,{����,�D�dy-H�a��.�4�5�-��R�:�Nx�X@ϟ��S�^K*�tms�?�_K,�>1r��k��}��a��,�f��^D;Sl�V�uG�"Y/�/�4��v�����{���w
��B�*�U�G/E����N�7�:zBTz�����;^�bd68/�ݺ��>:5*��e�b���W58//:�*��u����m�0�:��k��Xh�kf"����;(�Uz��a*������a�jxW9/3��x��G4/���:#˯�
�!�� /�hC"6�h�S�f��;�ȇI�R�P�y!F߱aZ���$�-h�Q���&^�X���I�R��d���4�+mF'��kǳi��oO��p��D�Q�)m~��/���6FǛ�V|������'K��7�izE?�Ɩ��R�㌨~��h/��J�_�a� {��
{� �8����Lw����[k������{��^�-0����Z}�
���z����Q���fn�D�+�r�4vC-��hq���۽��B���kw;� ��&�G_�!!�6�Z�Mn�&w�i���d�V�^�꠻�Jѹ�q�|�Yt7wȖ��@{��*'�W6d��X��O��-��q�x��`�qx%�S� ÜDò¸K7�7��Z�b�[SZ��Z��ޭ�g�#McT2V�<ǜg��^iZ,:��u��V�Wpt�����4=l���!}nz�o��7��!��2�`KI=߀��_?m���sz`��3<�>�<j�_=�Lf��(7����d��[�:��`*Y��Ғ��S�v/�V����M�y9��'2��K?�zZ�L���5C|����ֽ�6�f��6���	X��@|���0z����=�v��@0�I(��u�z�����N�q���0�������d�ۜ���������L���$>iKw�yyI�[�������F�{�g�����n�]a�M��Y���[;�':���{�C�5���-!A���{��5#�h�.�$ۍx�?T�R<M��ӿ�Q�Єǻ	�qa1���5&}?�W/�y���������G�n�1,��������|?�a��D�G�y9�Wp�!�Z�)>��]��V>���N����,���\b�g���X�?��h�*��m�Y7n���#ժ��m��,�m?8m�p�|��]�L[���/����?.Z���^������      �   �   x��˽�  ��x
^������1NM\l�&|~Ld��[?�i�^���v}�s� �H2�%:���X�⮝���9�­���a<ȿF4�F�S-��.�>���j.��uj4�H6:oB���l�Ro��3�      �      x������ � �      �   A   x�3�420��54�50R00�#΢��Ԃ����NC DRbhdelbeh�glaę������� *@�      �   0   x�3�4B#CK]C#]S΂�����bNccNc.��&@�=... ��Q      �      x������ � �      �   �  x���[n�0E��UpR9�&�[i��I�G���ll���@��n���X�V!$�`�@�{�șK ��V�2M�7���ٜ?�@��bRA�L��	�}df���v������5��p��6MK �A � U��1�^�*�덊3����*�U�*�U�Ք���B��M��g�tmWk��7��OM�������S�T,	%c�'�y[7Jۺq��c�����Һ������9NA�eV��8Y�hC_պ�N��8X��O�������?��Й�.�������ܷZ���`���A�F���1U��A�����Q(��l����#'��&�~і����c����<��6�5���v'c*�V�ڝ��+G��ִoyC����B��}����t��6e��6>��-(D*���P$1:���d�)��      �   y   x�3�tN,�,I��LI-HL���-u�t-93J��]���8�3K�9]�ʊJsS�J��bH��KҋR���9��J|J�3A��ʑE��1�t�IJ,Jy�oT� 61z\\\ ��><      �      x�3�tL/�Wp����#q��qqq ��      �     x���=n�0����� �@�釪ti�e1�A�\[5��U�ЋՍ�(K��m~?��p��j��ҿ?�B��������
�y�y�Xq�}�~�`ezm��GS���K���_��ԝn��:}�W�t9�.x�?����t���#�R!����fp5L��Z���=����UJ!�a�wv����8HJB���6hGN5�E�GLP�IVp3.�Ͱ���&�!C��8��·/����E�-4ae��RU�<N���HB���I��mL�qI�i      �      x�����,�420��54�50����� D�      �   F  x�՗MO�0��鯈r�����?`����&Y$v�/�]�߱� PC[gҴ�����Z�LC�dE��r"��)�58��Z�l�3���Yrgz�;��e.k.bju��[��q����Pa�t�dyƅԑ2��%��4Յ��խ��xs(�dJ�)	��I40ˀ�&�g�{Չ-�M	�f/)�j�68����'��?��GIEGI Q�VT�(��L�[*jE��˴o��<W;�6�K���}�OP���'(j71����(P��1Vw�F�:�S�Z�1��S`�4�B�:�1��S��;,��v/��s��h�:lۀ=o�a��5�[��Z�X��־-���1����0�������s�?si���O9�@R��BGa�*ջ�9qO�oO�N�[�ї\w�nK�pԩK���%x�����X&Z�O����U����k�ꗆE�b�q&J�B�UDW68-"=�V�<aB}�[� -���}�����]�� j�{ҤV� z ���
���EC��D�舢!��R�/Mn����>s�0��uJP��+!���]���� 1��ѯ:7IB���&���d2y���      �   A  x����n�0���S�����u���u�]%d��,;��=���Q��I��s��ǧzy�|y|ݾ>G����E�2�饒��G	��&8[�\ .xiVd�q!���*�����F�'WywhU����K��{����5��2�0ĸ�'omh�1�NR� T�"D�O2jo��#�0���%�w|3V�F�s�s�mllz,�t����<�Q��l@�A�G��K�_�0H�"x)0��l����roN&�COD&yi�D���9b�����(_t0�օ��V֝��(�U��8˔��6���\ 9.�:�t,���+L�L0s�ݵ����s��9K.�E^NX�;�v�Fv�K�~jm
7Ɓ�2�Y7�fI_@N��pZ�m+��e��t�	X�F]�u�N��������G�Ş����_�L����i�0q)�o��펉���϶Ѿ�^u�Q���4P�� X�d����}7������t���Svn���M�Տ�s�_b7L�֘�N.���i�&M�:=i�f~g�	�C61Ǘ��͂^����HyG��5��璜�dݘ/�/��V��1Ǐ      �   [   x�m�;� �z9���@�݂ǰ#��h����`ꁱ�̴��h����d4��q��ˈ*$:��<�R�\&9)����:�:�����/0��      �      x������ � �      �     x��͎d���5O1/`C�$RZ���IV�l����ݍ�1���:�"�W��[��
����[u/E����*�?�~|����}������>�>�>|����,i���K���\�7E��Y�l��nb�"��n/�o��{�o�o~����?��-���W�Os�̏����}�?<�~ھ��1>�����ߢ�{E�%i�2夦��c�%�x��{5��?�������,�������eY>�[�,��c����S�������]��9������j-���j6�;��U2�l��z�s��ɀ�S):}���<s�~�a�~\��)��q^���O���ޮ������N�K7�W)��a�+�0��R�کѲ�%ѡ�l�f�/�1T�w&������+�ASI��'ހ��ʛVr�>�w���5�8��9��g�s�>�\=�b�I�c��$�԰Q�U��a2<��r)�"\h�G+���'��;z>Ѻ�T��\xK���*��������r��t�a[�J�p��w��p��<�O��X�� �DV�N�0��e��`�*��=�N87}'�D2�0��')��sJ����Q��zz��"�k'2�R��*ڨxqo`wg<)9b�i���1�B���^i��F�N��9���6=�����3����!�n�wA����<�v����9)�-	葕 >��\�9J^Ԯ_E����^���.��./d�����o7&��E�<��f����z)�),�Ks���.�'x�x��3T��E�NNk�Ȯܕ�	`+j�ڴ8<w�[�/�Vv��Ơ��c�&������\����ć��ҏ�:e_�EI�>������0� ��:��Ӭ��̊���V:r_�j6N��z��G�{�s�B�!�6��O��?�BN�Ԑ������������B�jQ���a�+�T�;-v�qr���v=[bq�#����S�J�!�oP�%��y�v�}߈�`�_���/{C�����!c�QWH)���Q�n#\C6X�=��dD�ZCڊè�Ƚ�U�wU����G�[c�+�9ڲ�)Ml侖�p�B�}2G�=�ƺ
#���k�}I�e�%b�1����ٳ.Fe9����H`����RԤ�2Z�4}j�2�M�ֈ�Ԫs/b
�Y�S��v[#��T�'�ѻ�z�1�I(�93;~ؙ�� {^��Fn�f��5]��f*a�8�!p�Y�Ϧ�d������ 5K-����T�R����or�e��H������j]��3@���S�L�|�+�~K2W�,mM�blI�HTfT�"F�s�c�'�/e� ���n�O��6�ޜɧ������\2�W�	�.���� 8G�)��D�k}m��z��.�u��A9�d"Y�](+ʚ)0)s�$$�^�F���'KΩL{D>n���x�muSr-��GDZJ+�[���R�o_���K��������O��������|~����8�>N�����;<�������������q�}�o��Ϸ�|���Od�      �      x������ � �      �      x������ � �      �      x������ � �      �   ;  x��͎\���姨�$J"���E��l�0�t�I�4�����-#���"H�|�֭KQ���:���>���۟�����Mb������(O�nϟ�~�����{�-�b�z��27	�q}y
���u�}^�/o�����_^�n��7+}�^�j6N��z��G�{�s�!Đ{�ܲ^1����v#����!3����}�5,���Z��%,F;�(Q~��]b��k<�]�-����$��S�L��eH�H�'��u�v�}݈�����szk#G]m�TeMɑ�F]!�Hh��:tD���IAVf�5�L�!m�a�D��}��V��W��W�g�8:�k^a�і�Nib#��4�3�4-}��{Ƽ�*��2Ү]:	Mô��5�WA��س������qkX?�a15��SF�Se�(S݄1m�N�:�S�b*��L��ȫ�<�	{�.5��p�
okiv���vf�'ȞW�b#���S*����*v��kֲ�T�#��~v7�����Cσ�,����S���]g���2H�����+j���$��'�XO��T��HZ2W�,m�X��4����̨�BU έ"�ZO�/e� �jf5��!��V�9�OmS���d:�JQG���{�,�yV�{Z�����,Z�;.�u���<�d"�R(+ʚ)YU��@R�eo����)�T+-Q�m�c4&���nJ���T�NKie�(������@�n��)~w�����}z}��r��~v���Z�ѻ�_.O1<I���??�����30ߢO)��;ԯ���a���7��&{�d��B�R�Y���}��>&DOn�>??�t��˾������O?������~����׾����;��������G������θRצ>�9��|QKC��IKR�x
e��gvmb�D�I�a�"W#�ǻ�3#c/f<=f!�e�zG\�0�F�j�8�F�;�w�s������\ ����W5���j�H��}x����NO1����7s�����|����wq�>�>��\�v�߾"��;�-�n$^�t~ 4��M�X2���vj�hr�D��fK�4[�}����A޻�ڕ6&�p����N͉�o�4�F��c(�O\k����;/�s�+�ׄ眽mrulŰc��͊��$�(`�f�k�
�.�\��Ƅxm׬��J���Od�W�x�u�3��b���+%cy{4�gC�=�������mM��^M�� � l�.e�ɻ �����@>����6e�1v�#�0��e���8U�{��pn�J�{���^O�Gk��sJx��ų������;Dn�JDb�v�AE/��=O�ؚ�"�0�9 cX胓̰�N�=f���fxf?�z��M��O�E�����Q7�P����t���I����9)�-a_�"����$1J^Ԯ���V��_/`�Ks���L�zÑt���d;^�aH������z)�ʥ9�Ku��<���e�*�v�"A'�5�̮ܕ�	��NE���M]�aDq�[֯ܭ���ɞ3��#Lr��'���y�	�N|��*��/�S��_���3���a:̅�%� p@��=��_����Շ�W^�      �   }   x�3�t�,JVp�54�L2K3K�r���9c�8��tu�9�KҋR�93J��]�9�8�9M��!8E�!H�/**!d�1'P�	�)�	���)���
0c8cb*��rB� W75      �      x������ � �      �   �   x�m��
�0���S�Z�j��(x������V�E�����C���������0���sMsx�8�Hȡ�SϏ\��y��6S#IÓK�T���|a�)��f �*��m���o�H&t�/�"Q��'P~�V�ӄ�v�ӟ@T7��� 5<      �      x������ � �      �      x������ � �      �   �   x����
�0F盧�/1&�g,�Qh�.1P�$��ot,��o:�9|�m^	/`��gB��9��K�)]��R�
�\4\\�P\��"\���7А3�\.&�~��P��3��wњ0���}�����î������y�U��ό���Ͽ�xd��7�^N"      �   �   x�=NK�0\�����
(K.�pgbjmjM�G���%b��d2�d�*�ǌ���.�]� �[�T ���K�h�S�64/��M^���+owL�����^�s���ù����xOQA4K��i�pQ�[�	}T��{2��I����thQ�2rM	!h=j      �      x������ � �      �      x������ � �      �      x������ � �      �   N   x�3202�50�50�,�/.I/J-�4�,�,ȏON,JOt-N��M*�/�2"�2(�83�4�X! �$?'?=3�)F��� ��      �   �   x����N�0��~ V5]��#nHcG.&��JY9�ކg���&��>Y�-��oa�4�(�o�͔�O�jر�1�Q&̧�1eK!0:��d=�i�`V�/����\}ʮ��`攡m̰0��m~h�������4�򌘊1�H��WIl��J��@�Xs�M?4��[]����/��x����@��$a>�Y����^��N`z��?�����T�uUU����{      �      x������ � �      �   T   x�3�t��+���,)�/�4400�4��(M��L�420��54�52�2�tN��������O/J��5Ū��0�����y1z\\\ �.�      �   �   x����
�0���+�)�$M�e���>�fY� E��X�_х�aV�r� l�pv�p�C7����՟0����ILL���5�a�����+��!gB��[���=�0��m������
�п���lp��6����Z�|#��C~�٪���r�W�>�&������b?���Gh#B���Db      �   �   x�e��
�0���S�Φ�a��좢�d]'�Y��iO?u"�B ���C�9���h��nspd���1���|o�>�X��`k��U���r��I7�i5<,�UROZ�0R�&��HC�WFYz'�r�0���<	�6�O��Y�h7KR��а��T�׺�	E�+�Y۝c_N�[�      �   7   x�eʱ�0��ڷK��#��Kj�����YN�n�Ρ#7Vpw�/쿹�먪�qy      �      x���mo�H�_o>��@�}���8L\tU���D%qd@��O�Y����xi����vv�3;���Q��t��:EI�PD1�o	�e}���2[�A}�_e�����F(k��[3ݚ J���:K��������o�ƖD�&��O�)��/3��Ky<�g6E���h�����k�v^�%ϋ�/�4]�w�sz0�o�� �E��
X:ݤ�)3�l0$G�L�s�&�z��W�7�����`���j��}S���5�4p�XP�_�K��+0��?���"�����m�E`������i8�"�XI�=������j�
�q{��� ���3 �&�:�2���ȵɪ�CD�MZAq��UJ)�i���<�1	c1k�O���?��C>"aS��	����C�2(��F��I�7��!aY��i"i#U%ui��XUf��R�@��UG��.�C�F"�x i#�J�#i#�ww��zHڨ$/�)���9Y�)�=�w���{̝�{����Y�w��-"vM³�g��j|�Qq�{���+iS�U�Y8�K��b�A?D6��w����y��<��a�Y��Qu��W&�FW�ڎ�ck�{A���-�?Q���X�#�����`8�V��.:�Z�g�āD���>k�:?�@_B����6��( :��É��ϓ���.p�T�M�q���Z���#��Y��,R�z��x��2�]����eouB����RKu�J���,q���+�6>#�&�ɣx���%2�g�-�U4J˾�mi"�]uі�'�(l�V�2Jv�g2�L�ڨX��3E�r�_΁׆���L������c��d>n�$����Kz}$k��>����`dV���<�W LH~m?��n��^�[EY[Z0K�e1�RC���`�
�ѭ+�k��
��n���������64��4��=N��p|H�"qm�x��S��D�(�����2+s�g��)� S^�9��ag0���e]Mgj^m�"<����q��GQ;�5ހ��R/V[�	G�8�]�|�q� l_�I�r�m._L&ݠ;�V�a��.gu�n��p������ӹ2��N"��ܯ�K<��8��1����ʟ_g�h��e�X�zq���Qp?GJnR2> �鞻cO?��	�HM�R�^�t���f�S�hi�:��-�w���DJ��34Pc�SYx��0�����'����y}�y��T��`c�<z����ߌG�<��A�h��)Ϩ�2�5�^�S��2O^��]�g�!�y������w����$\�������7o�      �   �  x���]n� �gr�N��2��	�:�qӺ�k�Z!�Aڔ�*��1��!;,���q�~�z�9pX��ᯂ`cr��		ၐR	ⓔsB&�f�vf�<�-�+B2"�GB�6���|hȬ��]jAr�
�fbgh0�d�����I��D�!s6XI���p�Ci`MԿMA8ː{���噠��Sf"���.艠��3C'����W}&�̷���?/'&�!�pn	�&����|s�v�}\A�B�a|^0Rg�ig�.T}�b%e�I��Q����-ԔyNӴ��2Z�Dv�"o"�u
+Iqٵ�QvuȻ�&6(jk��:I��t�v�rW*�� U��J����CoI-��.ga~XC:46y��"wl<�;�G4����ҡ�A�K�2�	!j��N�q!cRF����T�}��S��{V�����lf���e6�}��Ru��̙�+h��Yחm�~ ��	      �   s  x����n�0���S��I��[`���S7$T�r�@�_s*>���I���c'R�z�=�Ͱ��GD��oi���Ay;ČJf"�s�@�U/u1i@������!���D)B���g1�f�
ی�l�o��������w9C���!%F�&�Be��h�z��К�F��#Wue��ekp��݅f��%�+^^�e�_�(@n��s��J�љ�Z�K��E�}6�|څ�uQo�YZ86��K4S�	�K�->��v�
:��!�Ae(����'��?/�v�Vh02ю;�C�h��
��v�}1b5}�Ú�S�x�+��8ϙa&��D�w���������CY�`�}R�����:C%�EF���J<�RA�n���      �   /   x�3�,(�ON-�7�420��54�52�,�/.I/J-������� �
A      �   �  x����n�0���)x��l�>�$"=��f�4�j����@7���k*��Dc<_���bu�lv۲�3���y���9�\���?v>�^��q&���3)�8��+�lS�d�.>�c/�l�m�]^�����˱��;��#)����m��V�I���^��K�q|�Xl�Ŝ^�p"��Yei��>,}����:��<m�����C�~w���x�$^o��6ۍ�v;��	�"���h���^�tх�@�8b��$rľː�}�D_$������6�Ņ�����c�XZ�@4�y��k�:_��v�����h���Χ�?�Ήp<�\64PH�[��P� n;M���`0�^�e�h(�JJ�����0�.�Ҳ�����ph,ڹ�E��i�v��^��"R�E�Cc����E�#�}	��(�/
�G�E}QD_�E�E}QD_�M�E}�D_4�M�%&����j��8M_����}��m{�w��~��x�T[�k���t�R�ߩ��o;�P/�1�rS�S1`�h�޺��G?8i��T���]u?Qj7��
"a0��e�����i����*`�
�����*`��a̸�n������wVg�z�j��k����í�m�i���M�(+��v��)w�O����Oy��y�_��      �   g   x�3��uq�t���C #CK]CC]C΂�����bN33NC���	z̡zI�c�c������U��BPؐ�Д�ДD-f\�f$j1����� ��J      �   �   x��Աn�0����.Aw���Q��@Aݐ*Tu�0���� >K��2Y��[��$X��!j��p�=|�����x���f������#}��+�T���n�ޯ��m�ZwH��یt)!�%���W���,!#����M�9#��T��̟J�Jf��ɻ-
U�#IC���v�:�ءA�qb1�X�͔n��!J�D>0�_�;���\�P�g�^do���fK�f���*7��Y�/�1�*��      �   �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false                        0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                       false                       1262    57611    tools    DATABASE     �   CREATE DATABASE tools WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Spanish_Argentina.1252' LC_CTYPE = 'Spanish_Argentina.1252';
    DROP DATABASE tools;
             postgres    false                        2615    65782    alm    SCHEMA        CREATE SCHEMA alm;
    DROP SCHEMA alm;
             postgres    false                        2615    57746    core    SCHEMA        CREATE SCHEMA core;
    DROP SCHEMA core;
             postgres    false                        2615    57752    frm    SCHEMA        CREATE SCHEMA frm;
    DROP SCHEMA frm;
             postgres    false                        2615    115082    log    SCHEMA        CREATE SCHEMA log;
    DROP SCHEMA log;
             postgres    false            
            2615    57612    prd    SCHEMA        CREATE SCHEMA prd;
    DROP SCHEMA prd;
             postgres    false                        2615    115083    sma    SCHEMA        CREATE SCHEMA sma;
    DROP SCHEMA sma;
             postgres    false            4           1255    82210 /   agregar_lote_articulo(bigint, double precision)    FUNCTION     ~  CREATE FUNCTION alm.agregar_lote_articulo(p_batch_id bigint, p_cantidad double precision) RETURNS character varying
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
		returning 1,cantidad)
		
	select count(1)
	from updated_lotes
	into strict v_cuenta
				,v_existencia;

	if v_cuenta = 0 then
    	    RAISE INFO 'ALMEXLO - no se encontro el batch id % ', p_batch_id;
    	    raise 'BATCH_INEXISTENTE';
    end if;

   	RAISE INFO 'ALMEXLO - actualizando el batch id % con cantidad %', p_batch_id,v_existencia;
    return 'CORRECTO';

exception
		when others then 
			raise;
end;
		
$$;
 Y   DROP FUNCTION alm.agregar_lote_articulo(p_batch_id bigint, p_cantidad double precision);
       alm       postgres    false    12            <           1255    106975 ;   ajuste_detalle_ingresar(integer, integer, double precision)    FUNCTION     �  CREATE FUNCTION alm.ajuste_detalle_ingresar(p_ajus_id integer, p_lote_id integer, p_cantidad double precision) RETURNS integer
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
       alm       postgres    false    12            %           1255    82203 j   crear_lote_articulo(integer, integer, integer, character varying, double precision, date, integer, bigint)    FUNCTION       CREATE FUNCTION alm.crear_lote_articulo(p_prov_id integer, p_arti_id integer, p_depo_id integer, p_codigo character varying, p_cantidad double precision, p_fec_vencimiento date, p_empr_id integer, p_batch_id bigint) RETURNS character varying
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
       alm       postgres    false    12            2           1255    82207 /   extraer_lote_articulo(bigint, double precision)    FUNCTION     �  CREATE FUNCTION alm.extraer_lote_articulo(p_batch_id bigint, p_cantidad double precision) RETURNS character varying
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
       alm       postgres    false    12            3           1255    82205     obtener_existencia_batch(bigint)    FUNCTION     t  CREATE FUNCTION alm.obtener_existencia_batch(p_batch_id bigint) RETURNS double precision
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
       alm       postgres    false    12            5           1255    74922    log(character varying) 	   PROCEDURE     *  CREATE PROCEDURE core.log(p_msg character varying)
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
       core       postgres    false    8            :           1255    115122    set_tabla_id_trg()    FUNCTION     �  CREATE FUNCTION core.set_tabla_id_trg() RETURNS trigger
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
       core       postgres    false    8            6           1255    98704    asociar_lote_hijo_trg()    FUNCTION     �
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
       prd       postgres    false    10            ;           1255    98706 m   cambiar_recipiente(bigint, integer, integer, integer, character varying, character varying, double precision)    FUNCTION     �  CREATE FUNCTION prd.cambiar_recipiente(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision DEFAULT 0) RETURNS character varying
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
		    	,lo.arti_id
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
		   
	        RAISE INFO 'batch, lote y ord prod = %, % , %', p_batch_id_origen,v_lote_id,v_num_orden_prod;

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
		   	prd.crear_lote(
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
       prd       postgres    false    10            9           1255    98670 �   crear_lote(character varying, integer, integer, bigint, double precision, double precision, character varying, integer, integer, character varying, integer, character varying, date, integer, character varying)    FUNCTION     �   CREATE FUNCTION prd.crear_lote(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying DEFAULT 'false'::character varying, p_fec_vencimiento date DEFAULT NULL::date, p_recu_id integer DEFAULT NULL::integer, p_tipo_recurso character varying DEFAULT NULL::character varying) RETURNS character varying
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
 �  DROP FUNCTION prd.crear_lote(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying, p_fec_vencimiento date, p_recu_id integer, p_tipo_recurso character varying);
       prd       postgres    false    10            7           1255    82227    crear_prd_recurso_trg()    FUNCTION     w  CREATE FUNCTION prd.crear_prd_recurso_trg() RETURNS trigger
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
       prd       postgres    false    10            8           1255    82228    eliminar_prd_recurso_trg()    FUNCTION     -  CREATE FUNCTION prd.eliminar_prd_recurso_trg() RETURNS trigger
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
       prd       postgres    false    10                       1259    106906    ajustes    TABLE     +  CREATE TABLE alm.ajustes (
    ajus_id integer NOT NULL,
    tipo_ajuste character varying,
    justificacion character varying,
    usuario_app character varying,
    empr_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE alm.ajustes;
       alm         postgres    false    12                       1259    106904    ajustes_ajus_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.ajustes_ajus_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE alm.ajustes_ajus_id_seq;
       alm       postgres    false    12    260                       0    0    ajustes_ajus_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE alm.ajustes_ajus_id_seq OWNED BY alm.ajustes.ajus_id;
            alm       postgres    false    259            �            1259    74435    alm_articulos    TABLE     X  CREATE TABLE alm.alm_articulos (
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
    batch_id bigint,
    tipo character varying
);
    DROP TABLE alm.alm_articulos;
       alm         postgres    false    12            �            1259    74433    alm_articulos_arti_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_articulos_arti_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE alm.alm_articulos_arti_id_seq;
       alm       postgres    false    221    12                       0    0    alm_articulos_arti_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE alm.alm_articulos_arti_id_seq OWNED BY alm.alm_articulos.arti_id;
            alm       postgres    false    220            �            1259    74446    alm_depositos    TABLE     g  CREATE TABLE alm.alm_depositos (
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
    esta_id integer NOT NULL
);
    DROP TABLE alm.alm_depositos;
       alm         postgres    false    12            �            1259    74444    alm_depositos_depo_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_depositos_depo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE alm.alm_depositos_depo_id_seq;
       alm       postgres    false    223    12                       0    0    alm_depositos_depo_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE alm.alm_depositos_depo_id_seq OWNED BY alm.alm_depositos.depo_id;
            alm       postgres    false    222            �            1259    74617    alm_deta_entrega_materiales    TABLE     �  CREATE TABLE alm.alm_deta_entrega_materiales (
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
       alm         postgres    false    12            �            1259    74615 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq;
       alm       postgres    false    12    242                       0    0 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq OWNED BY alm.alm_deta_entrega_materiales.deen_id;
            alm       postgres    false    241            �            1259    74524    alm_deta_pedidos_materiales    TABLE     O  CREATE TABLE alm.alm_deta_pedidos_materiales (
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
       alm         postgres    false    12            �            1259    74522 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq;
       alm       postgres    false    233    12                       0    0 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq OWNED BY alm.alm_deta_pedidos_materiales.depe_id;
            alm       postgres    false    232            �            1259    74403    alm_deta_recepcion_materiales    TABLE     �  CREATE TABLE alm.alm_deta_recepcion_materiales (
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
       alm         postgres    false    12            �            1259    74401 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 =   DROP SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq;
       alm       postgres    false    12    219                       0    0 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE OWNED BY     q   ALTER SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq OWNED BY alm.alm_deta_recepcion_materiales.dere_id;
            alm       postgres    false    218            �            1259    74544    alm_entrega_materiales    TABLE     �  CREATE TABLE alm.alm_entrega_materiales (
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
       alm         postgres    false    12            �            1259    74542 "   alm_entrega_materiales_enma_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_entrega_materiales_enma_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE alm.alm_entrega_materiales_enma_id_seq;
       alm       postgres    false    12    235                       0    0 "   alm_entrega_materiales_enma_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE alm.alm_entrega_materiales_enma_id_seq OWNED BY alm.alm_entrega_materiales.enma_id;
            alm       postgres    false    234            �            1259    74562 	   alm_lotes    TABLE       CREATE TABLE alm.alm_lotes (
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
       alm         postgres    false    12            �            1259    74560    alm_lotes_lote_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_lotes_lote_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE alm.alm_lotes_lote_id_seq;
       alm       postgres    false    12    237            	           0    0    alm_lotes_lote_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE alm.alm_lotes_lote_id_seq OWNED BY alm.alm_lotes.lote_id;
            alm       postgres    false    236            �            1259    74465    alm_pedidos_materiales    TABLE     �  CREATE TABLE alm.alm_pedidos_materiales (
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
       alm         postgres    false    12            �            1259    74463 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_pedidos_materiales_pema_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE alm.alm_pedidos_materiales_pema_id_seq;
       alm       postgres    false    225    12            
           0    0 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE alm.alm_pedidos_materiales_pema_id_seq OWNED BY alm.alm_pedidos_materiales.pema_id;
            alm       postgres    false    224            �            1259    74483    alm_proveedores    TABLE       CREATE TABLE alm.alm_proveedores (
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
       alm         postgres    false    12            �            1259    74585    alm_proveedores_articulos    TABLE     k   CREATE TABLE alm.alm_proveedores_articulos (
    prov_id integer NOT NULL,
    arti_id integer NOT NULL
);
 *   DROP TABLE alm.alm_proveedores_articulos;
       alm         postgres    false    12            �            1259    74481    alm_proveedores_prov_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_proveedores_prov_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE alm.alm_proveedores_prov_id_seq;
       alm       postgres    false    12    227                       0    0    alm_proveedores_prov_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE alm.alm_proveedores_prov_id_seq OWNED BY alm.alm_proveedores.prov_id;
            alm       postgres    false    226            �            1259    74602    alm_recepcion_materiales    TABLE     h  CREATE TABLE alm.alm_recepcion_materiales (
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
       alm         postgres    false    12            �            1259    74600 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_recepcion_materiales_rema_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 8   DROP SEQUENCE alm.alm_recepcion_materiales_rema_id_seq;
       alm       postgres    false    240    12                       0    0 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE OWNED BY     g   ALTER SEQUENCE alm.alm_recepcion_materiales_rema_id_seq OWNED BY alm.alm_recepcion_materiales.rema_id;
            alm       postgres    false    239                       1259    106938    deta_ajustes    TABLE       CREATE TABLE alm.deta_ajustes (
    deaj_id integer NOT NULL,
    cantidad double precision,
    empr_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER,
    lote_id integer,
    ajus_id integer NOT NULL
);
    DROP TABLE alm.deta_ajustes;
       alm         postgres    false    12                       1259    106936    deta_ajustes_deaj_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.deta_ajustes_deaj_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE alm.deta_ajustes_deaj_id_seq;
       alm       postgres    false    262    12                       0    0    deta_ajustes_deaj_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE alm.deta_ajustes_deaj_id_seq OWNED BY alm.deta_ajustes.deaj_id;
            alm       postgres    false    261            �            1259    74501    items    TABLE     G  CREATE TABLE alm.items (
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
       alm         postgres    false    12            �            1259    74499    items_item_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.items_item_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE alm.items_item_id_seq;
       alm       postgres    false    12    229                       0    0    items_item_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE alm.items_item_id_seq OWNED BY alm.items.item_id;
            alm       postgres    false    228            �            1259    74514 
   utl_tablas    TABLE       CREATE TABLE alm.utl_tablas (
    tabl_id integer NOT NULL,
    tabla character varying(50),
    valor character varying(50),
    descripcion character varying(200),
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
    DROP TABLE alm.utl_tablas;
       alm         postgres    false    12            �            1259    74512    utl_tablas_tabl_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.utl_tablas_tabl_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE alm.utl_tablas_tabl_id_seq;
       alm       postgres    false    12    231                       0    0    utl_tablas_tabl_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE alm.utl_tablas_tabl_id_seq OWNED BY alm.utl_tablas.tabl_id;
            alm       postgres    false    230                       1259    115211    departamentos    TABLE     �   CREATE TABLE core.departamentos (
    depa_id integer NOT NULL,
    nombre character varying NOT NULL,
    descripcion character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE core.departamentos;
       core         postgres    false    8                       1259    115209    departamentos_depa_id_seq    SEQUENCE     �   CREATE SEQUENCE core.departamentos_depa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE core.departamentos_depa_id_seq;
       core       postgres    false    269    8                       0    0    departamentos_depa_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE core.departamentos_depa_id_seq OWNED BY core.departamentos.depa_id;
            core       postgres    false    268            �            1259    74708    empresas    TABLE     �  CREATE TABLE core.empresas (
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
       core         postgres    false    8            �            1259    74706    empresas_empr_id_seq    SEQUENCE     �   CREATE SEQUENCE core.empresas_empr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE core.empresas_empr_id_seq;
       core       postgres    false    8    246                       0    0    empresas_empr_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE core.empresas_empr_id_seq OWNED BY core.empresas.empr_id;
            core       postgres    false    245            �            1259    98621    equipos    TABLE     X  CREATE TABLE core.equipos (
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
    dominio character varying
);
    DROP TABLE core.equipos;
       core         postgres    false    8            �            1259    98619    equipos_equi_id_seq    SEQUENCE     �   CREATE SEQUENCE core.equipos_equi_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE core.equipos_equi_id_seq;
       core       postgres    false    253    8                       0    0    equipos_equi_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE core.equipos_equi_id_seq OWNED BY core.equipos.equi_id;
            core       postgres    false    252            �            1259    74914    log    TABLE     S   CREATE TABLE core.log (
    msg character varying,
    fecha date DEFAULT now()
);
    DROP TABLE core.log;
       core         postgres    false    8            "           1259    123290 	   snapshots    TABLE     �   CREATE TABLE core.snapshots (
    id integer NOT NULL,
    snap_id character varying,
    data text,
    fec_alta date DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
    DROP TABLE core.snapshots;
       core         postgres    false    8            !           1259    123288    snapshots_id_seq    SEQUENCE     �   CREATE SEQUENCE core.snapshots_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE core.snapshots_id_seq;
       core       postgres    false    290    8                       0    0    snapshots_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE core.snapshots_id_seq OWNED BY core.snapshots.id;
            core       postgres    false    289                       1259    115109    tablas    TABLE     �  CREATE TABLE core.tablas (
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
       core         postgres    false    8                        1259    98651    transportistas    TABLE       CREATE TABLE core.transportistas (
    cuit character varying NOT NULL,
    razon_social character varying NOT NULL,
    direccion character varying(500) NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
     DROP TABLE core.transportistas;
       core         postgres    false    8            #           1259    123300    transportistas_tipo_residuos    TABLE     �   CREATE TABLE core.transportistas_tipo_residuos (
    tran_id integer NOT NULL,
    tire_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
 .   DROP TABLE core.transportistas_tipo_residuos;
       core         postgres    false    8                       1259    115192    zonas    TABLE     r  CREATE TABLE core.zonas (
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
       core         postgres    false    8            
           1259    115190    zonas_zona_id_seq    SEQUENCE     �   CREATE SEQUENCE core.zonas_zona_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE core.zonas_zona_id_seq;
       core       postgres    false    8    267                       0    0    zonas_zona_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE core.zonas_zona_id_seq OWNED BY core.zonas.zona_id;
            core       postgres    false    266            �            1259    57782    formularios    TABLE        CREATE TABLE frm.formularios (
    form_id integer NOT NULL,
    nombre character varying(45),
    descripcion character varying(300),
    eliminado smallint DEFAULT 0,
    fec_alta timestamp without time zone DEFAULT now(),
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE frm.formularios;
       frm         postgres    false    6            �            1259    57780    formularios_form_id_seq    SEQUENCE     �   CREATE SEQUENCE frm.formularios_form_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE frm.formularios_form_id_seq;
       frm       postgres    false    6    213                       0    0    formularios_form_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE frm.formularios_form_id_seq OWNED BY frm.formularios.form_id;
            frm       postgres    false    212            �            1259    57799    instancias_items    TABLE     �  CREATE TABLE frm.instancias_items (
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
       frm         postgres    false    6            �            1259    57797    instancias_items_init_id_seq    SEQUENCE     �   CREATE SEQUENCE frm.instancias_items_init_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE frm.instancias_items_init_id_seq;
       frm       postgres    false    6    215                       0    0    instancias_items_init_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE frm.instancias_items_init_id_seq OWNED BY frm.instancias_items.init_id;
            frm       postgres    false    214            �            1259    57818    items    TABLE     G  CREATE TABLE frm.items (
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
       frm         postgres    false    6            �            1259    57816    items_item_id_seq    SEQUENCE     �   CREATE SEQUENCE frm.items_item_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE frm.items_item_id_seq;
       frm       postgres    false    6    217                       0    0    items_item_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE frm.items_item_id_seq OWNED BY frm.items.item_id;
            frm       postgres    false    216                       1259    115360    choferes    TABLE     �  CREATE TABLE log.choferes (
    chof_id integer NOT NULL,
    nombre character varying NOT NULL,
    apellido character varying NOT NULL,
    documento character varying NOT NULL,
    fec_nacimiento date NOT NULL,
    direccion character varying NOT NULL,
    celular integer,
    codigo bigint NOT NULL,
    carnet character varying NOT NULL,
    vencimiento date NOT NULL,
    habilitacion character varying,
    imagen bytea,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    tran_id integer NOT NULL,
    cach_id character varying NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL
);
    DROP TABLE log.choferes;
       log         postgres    false    5                       1259    115358    choferes_chof_id_seq    SEQUENCE     �   CREATE SEQUENCE log.choferes_chof_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE log.choferes_chof_id_seq;
       log       postgres    false    278    5                       0    0    choferes_chof_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE log.choferes_chof_id_seq OWNED BY log.choferes.chof_id;
            log       postgres    false    277                       1259    115230 	   circuitos    TABLE     k  CREATE TABLE log.circuitos (
    circ_id integer NOT NULL,
    codigo character varying,
    descripcion character varying,
    imagen bytea,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    chof_id integer,
    vehi_id integer,
    zona_id integer NOT NULL
);
    DROP TABLE log.circuitos;
       log         postgres    false    5                       1259    115228    circuitos_circu_id_seq    SEQUENCE     �   CREATE SEQUENCE log.circuitos_circu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE log.circuitos_circu_id_seq;
       log       postgres    false    271    5                       0    0    circuitos_circu_id_seq    SEQUENCE OWNED BY     J   ALTER SEQUENCE log.circuitos_circu_id_seq OWNED BY log.circuitos.circ_id;
            log       postgres    false    270                       1259    115416    circuitos_puntos_criticos    TABLE     �   CREATE TABLE log.circuitos_puntos_criticos (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying NOT NULL,
    circ_id integer NOT NULL,
    pucr_id integer NOT NULL
);
 *   DROP TABLE log.circuitos_puntos_criticos;
       log         postgres    false    5                       1259    115274    contenedores    TABLE     �  CREATE TABLE log.contenedores (
    cont_id integer NOT NULL,
    codigo bigint NOT NULL,
    descripcion character varying NOT NULL,
    capacidad double precision NOT NULL,
    anio_elaboracion integer,
    tara double precision,
    habilitacion character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    esco_id character varying NOT NULL,
    reci_id integer NOT NULL
);
    DROP TABLE log.contenedores;
       log         postgres    false    5                       1259    115272    containers_cont_id_seq    SEQUENCE     �   CREATE SEQUENCE log.containers_cont_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE log.containers_cont_id_seq;
       log       postgres    false    5    273                       0    0    containers_cont_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE log.containers_cont_id_seq OWNED BY log.contenedores.cont_id;
            log       postgres    false    272                       1259    115527    deta_solicitudes_contenedor    TABLE     0  CREATE TABLE log.deta_solicitudes_contenedor (
    desc_id integer NOT NULL,
    cantidad integer NOT NULL,
    otro character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying NOT NULL,
    usuario_app character varying NOT NULL,
    tica_id character varying NOT NULL
);
 ,   DROP TABLE log.deta_solicitudes_contenedor;
       log         postgres    false    5                       1259    115525 '   deta_solicitudes_contenedor_desc_id_seq    SEQUENCE     �   CREATE SEQUENCE log.deta_solicitudes_contenedor_desc_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE log.deta_solicitudes_contenedor_desc_id_seq;
       log       postgres    false    285    5                       0    0 '   deta_solicitudes_contenedor_desc_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE log.deta_solicitudes_contenedor_desc_id_seq OWNED BY log.deta_solicitudes_contenedor.desc_id;
            log       postgres    false    284                       1259    115544    entregas_contenedor    TABLE     G   CREATE TABLE log.entregas_contenedor (
    enco_id integer NOT NULL
);
 $   DROP TABLE log.entregas_contenedor;
       log         postgres    false    5                       1259    115542    entregas_contenedor_enco_id_seq    SEQUENCE     �   CREATE SEQUENCE log.entregas_contenedor_enco_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 3   DROP SEQUENCE log.entregas_contenedor_enco_id_seq;
       log       postgres    false    5    287                       0    0    entregas_contenedor_enco_id_seq    SEQUENCE OWNED BY     ]   ALTER SEQUENCE log.entregas_contenedor_enco_id_seq OWNED BY log.entregas_contenedor.enco_id;
            log       postgres    false    286                       1259    115325    puntos_criticos    TABLE     �  CREATE TABLE log.puntos_criticos (
    pucr_id integer NOT NULL,
    nombre character varying NOT NULL,
    descripcion character varying,
    lat character varying,
    lng character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    zona_id integer NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL
);
     DROP TABLE log.puntos_criticos;
       log         postgres    false    5                       1259    115323    puntos_criticos_pucr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.puntos_criticos_pucr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE log.puntos_criticos_pucr_id_seq;
       log       postgres    false    5    276                       0    0    puntos_criticos_pucr_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE log.puntos_criticos_pucr_id_seq OWNED BY log.puntos_criticos.pucr_id;
            log       postgres    false    275                       1259    115453    solicitantes_transporte    TABLE     Y  CREATE TABLE log.solicitantes_transporte (
    sotr_id integer NOT NULL,
    razon_social character varying,
    cuit character varying,
    domicilio character varying,
    num_registro character varying,
    lat character varying,
    lng character varying,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario_app character varying NOT NULL,
    zona_id integer NOT NULL,
    rubr_id character varying NOT NULL,
    tist_id character varying NOT NULL,
    tica_id character varying NOT NULL,
    eliminado integer DEFAULT 0 NOT NULL
);
 (   DROP TABLE log.solicitantes_transporte;
       log         postgres    false    5                       1259    115451 #   solicitantes_transporte_sotr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitantes_transporte_sotr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE log.solicitantes_transporte_sotr_id_seq;
       log       postgres    false    5    281                       0    0 #   solicitantes_transporte_sotr_id_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE log.solicitantes_transporte_sotr_id_seq OWNED BY log.solicitantes_transporte.sotr_id;
            log       postgres    false    280                       1259    115489    solicitudes_contenedor    TABLE     |  CREATE TABLE log.solicitudes_contenedor (
    soco_id integer NOT NULL,
    num_orden bigint NOT NULL,
    fec_orden date NOT NULL,
    fec_retiro date NOT NULL,
    fec_alta character varying DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    sotr_id integer NOT NULL,
    tran_id integer NOT NULL,
    essc_id character varying NOT NULL
);
 '   DROP TABLE log.solicitudes_contenedor;
       log         postgres    false    5                       1259    115487 "   solicitudes_contenedor_soco_id_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitudes_contenedor_soco_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE log.solicitudes_contenedor_soco_id_seq;
       log       postgres    false    5    283                       0    0 "   solicitudes_contenedor_soco_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE log.solicitudes_contenedor_soco_id_seq OWNED BY log.solicitudes_contenedor.soco_id;
            log       postgres    false    282                        1259    115548    solicitudes_retiro    TABLE     F   CREATE TABLE log.solicitudes_retiro (
    sore_id integer NOT NULL
);
 #   DROP TABLE log.solicitudes_retiro;
       log         postgres    false    5                       1259    115299    tipos_carga_circuitos    TABLE     �   CREATE TABLE log.tipos_carga_circuitos (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    circ_id integer NOT NULL,
    tica_id character varying NOT NULL
);
 &   DROP TABLE log.tipos_carga_circuitos;
       log         postgres    false    5            $           1259    123308    tipos_carga_transportistas    TABLE     �   CREATE TABLE log.tipos_carga_transportistas (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    tran_id integer NOT NULL,
    tica_id character varying NOT NULL
);
 +   DROP TABLE log.tipos_carga_transportistas;
       log         postgres    false    5            	           1259    115162    transportistas    TABLE     O  CREATE TABLE log.transportistas (
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
    eliminado smallint DEFAULT 0 NOT NULL
);
    DROP TABLE log.transportistas;
       log         postgres    false    5                       1259    115160    transportistas_tran_id_seq    SEQUENCE     �   CREATE SEQUENCE log.transportistas_tran_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE log.transportistas_tran_id_seq;
       log       postgres    false    265    5                        0    0    transportistas_tran_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE log.transportistas_tran_id_seq OWNED BY log.transportistas.tran_id;
            log       postgres    false    264            �            1259    57723    costos    TABLE       CREATE TABLE prd.costos (
    fec_vigencia date NOT NULL,
    valor money NOT NULL,
    umed character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    recu_id integer NOT NULL,
    empr_id integer
);
    DROP TABLE prd.costos;
       prd         postgres    false    10            �            1259    98636    empaque    TABLE     N  CREATE TABLE prd.empaque (
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
       prd         postgres    false    10            !           0    0    COLUMN empaque.eliminado    COMMENT     4   COMMENT ON COLUMN prd.empaque.eliminado IS 'false';
            prd       postgres    false    254            �            1259    98639    empaque_empa_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.empaque_empa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE prd.empaque_empa_id_seq;
       prd       postgres    false    254    10            "           0    0    empaque_empa_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE prd.empaque_empa_id_seq OWNED BY prd.empaque.empa_id;
            prd       postgres    false    255            �            1259    74635    establecimientos    TABLE     r  CREATE TABLE prd.establecimientos (
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
       prd         postgres    false    10            �            1259    74633    establecimientos_esta_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.establecimientos_esta_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE prd.establecimientos_esta_id_seq;
       prd       postgres    false    10    244            #           0    0    establecimientos_esta_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE prd.establecimientos_esta_id_seq OWNED BY prd.establecimientos.esta_id;
            prd       postgres    false    243            �            1259    57630    etapas    TABLE     �  CREATE TABLE prd.etapas (
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
       prd         postgres    false    10            �            1259    57628    etapas_etap_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.etapas_etap_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE prd.etapas_etap_id_seq;
       prd       postgres    false    204    10            $           0    0    etapas_etap_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE prd.etapas_etap_id_seq OWNED BY prd.etapas.etap_id;
            prd       postgres    false    203                       1259    98674    fraccionamientos    TABLE       CREATE TABLE prd.fraccionamientos (
    frac_id integer NOT NULL,
    recu_id integer NOT NULL,
    empa_id integer NOT NULL,
    cantidad double precision NOT NULL,
    fecha date DEFAULT now() NOT NULL,
    eliminado boolean DEFAULT false NOT NULL,
    empr_id integer NOT NULL
);
 !   DROP TABLE prd.fraccionamientos;
       prd         postgres    false    10                       1259    98672    fraccionamientos_frac_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.fraccionamientos_frac_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE prd.fraccionamientos_frac_id_seq;
       prd       postgres    false    10    258            %           0    0    fraccionamientos_frac_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE prd.fraccionamientos_frac_id_seq OWNED BY prd.fraccionamientos.frac_id;
            prd       postgres    false    257            �            1259    57652    lotes    TABLE     �  CREATE TABLE prd.lotes (
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
       prd         postgres    false    10            �            1259    57650    lotes_batch_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.lotes_batch_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE prd.lotes_batch_id_seq;
       prd       postgres    false    206    10            &           0    0    lotes_batch_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE prd.lotes_batch_id_seq OWNED BY prd.lotes.batch_id;
            prd       postgres    false    205            �            1259    57700    lotes_hijos    TABLE     Y  CREATE TABLE prd.lotes_hijos (
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
       prd         postgres    false    10            �            1259    74786    movimientos_trasportes    TABLE     �  CREATE TABLE prd.movimientos_trasportes (
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
       prd         postgres    false    10            �            1259    74784 "   movimientos_trasportes_motr_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.movimientos_trasportes_motr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE prd.movimientos_trasportes_motr_id_seq;
       prd       postgres    false    10    249            '           0    0 "   movimientos_trasportes_motr_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE prd.movimientos_trasportes_motr_id_seq OWNED BY prd.movimientos_trasportes.motr_id;
            prd       postgres    false    248            �            1259    57615    procesos    TABLE     �   CREATE TABLE prd.procesos (
    proc_id integer NOT NULL,
    nombre character varying NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    empr_id integer
);
    DROP TABLE prd.procesos;
       prd         postgres    false    10            �            1259    57613    productos_prod_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.productos_prod_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE prd.productos_prod_id_seq;
       prd       postgres    false    10    202            (           0    0    productos_prod_id_seq    SEQUENCE OWNED BY     H   ALTER SEQUENCE prd.productos_prod_id_seq OWNED BY prd.procesos.proc_id;
            prd       postgres    false    201            �            1259    74759    recipientes    TABLE     �  CREATE TABLE prd.recipientes (
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
    CONSTRAINT recipientes_check CHECK ((((tipo)::text = 'PRODUCTIVO'::text) OR ((tipo)::text = 'DEPOSITO'::text) OR ((tipo)::text = 'TRANSPORTE'::text))),
    CONSTRAINT recipientes_check_estado CHECK ((((estado)::text = 'VACIO'::text) OR ((estado)::text = 'LLENO'::text)))
);
    DROP TABLE prd.recipientes;
       prd         postgres    false    10            �            1259    74867    recipiente_reci_id_seq    SEQUENCE     |   CREATE SEQUENCE prd.recipiente_reci_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE prd.recipiente_reci_id_seq;
       prd       postgres    false    10    247            )           0    0    recipiente_reci_id_seq    SEQUENCE OWNED BY     L   ALTER SEQUENCE prd.recipiente_reci_id_seq OWNED BY prd.recipientes.reci_id;
            prd       postgres    false    250            �            1259    57670    recursos    TABLE     E  CREATE TABLE prd.recursos (
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
       prd         postgres    false    10            �            1259    57682    recursos_lotes    TABLE     H  CREATE TABLE prd.recursos_lotes (
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
       prd         postgres    false    10            �            1259    57668    recursos_recu_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.recursos_recu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE prd.recursos_recu_id_seq;
       prd       postgres    false    10    208            *           0    0    recursos_recu_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE prd.recursos_recu_id_seq OWNED BY prd.recursos.recu_id;
            prd       postgres    false    207            I           2604    106909    ajustes ajus_id    DEFAULT     l   ALTER TABLE ONLY alm.ajustes ALTER COLUMN ajus_id SET DEFAULT nextval('alm.ajustes_ajus_id_seq'::regclass);
 ;   ALTER TABLE alm.ajustes ALTER COLUMN ajus_id DROP DEFAULT;
       alm       postgres    false    260    259    260            �           2604    74438    alm_articulos arti_id    DEFAULT     x   ALTER TABLE ONLY alm.alm_articulos ALTER COLUMN arti_id SET DEFAULT nextval('alm.alm_articulos_arti_id_seq'::regclass);
 A   ALTER TABLE alm.alm_articulos ALTER COLUMN arti_id DROP DEFAULT;
       alm       postgres    false    220    221    221            �           2604    74449    alm_depositos depo_id    DEFAULT     x   ALTER TABLE ONLY alm.alm_depositos ALTER COLUMN depo_id SET DEFAULT nextval('alm.alm_depositos_depo_id_seq'::regclass);
 A   ALTER TABLE alm.alm_depositos ALTER COLUMN depo_id DROP DEFAULT;
       alm       postgres    false    223    222    223            *           2604    74620 #   alm_deta_entrega_materiales deen_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_entrega_materiales ALTER COLUMN deen_id SET DEFAULT nextval('alm.alm_deta_entrega_materiales_deen_id_seq'::regclass);
 O   ALTER TABLE alm.alm_deta_entrega_materiales ALTER COLUMN deen_id DROP DEFAULT;
       alm       postgres    false    241    242    242                       2604    74527 #   alm_deta_pedidos_materiales depe_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales ALTER COLUMN depe_id SET DEFAULT nextval('alm.alm_deta_pedidos_materiales_depe_id_seq'::regclass);
 O   ALTER TABLE alm.alm_deta_pedidos_materiales ALTER COLUMN depe_id DROP DEFAULT;
       alm       postgres    false    232    233    233            �           2604    74406 %   alm_deta_recepcion_materiales dere_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales ALTER COLUMN dere_id SET DEFAULT nextval('alm.alm_deta_recepcion_materiales_dere_id_seq'::regclass);
 Q   ALTER TABLE alm.alm_deta_recepcion_materiales ALTER COLUMN dere_id DROP DEFAULT;
       alm       postgres    false    218    219    219                       2604    74547    alm_entrega_materiales enma_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_entrega_materiales ALTER COLUMN enma_id SET DEFAULT nextval('alm.alm_entrega_materiales_enma_id_seq'::regclass);
 J   ALTER TABLE alm.alm_entrega_materiales ALTER COLUMN enma_id DROP DEFAULT;
       alm       postgres    false    234    235    235            "           2604    74565    alm_lotes lote_id    DEFAULT     p   ALTER TABLE ONLY alm.alm_lotes ALTER COLUMN lote_id SET DEFAULT nextval('alm.alm_lotes_lote_id_seq'::regclass);
 =   ALTER TABLE alm.alm_lotes ALTER COLUMN lote_id DROP DEFAULT;
       alm       postgres    false    236    237    237                       2604    74468    alm_pedidos_materiales pema_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_pedidos_materiales ALTER COLUMN pema_id SET DEFAULT nextval('alm.alm_pedidos_materiales_pema_id_seq'::regclass);
 J   ALTER TABLE alm.alm_pedidos_materiales ALTER COLUMN pema_id DROP DEFAULT;
       alm       postgres    false    224    225    225                       2604    74486    alm_proveedores prov_id    DEFAULT     |   ALTER TABLE ONLY alm.alm_proveedores ALTER COLUMN prov_id SET DEFAULT nextval('alm.alm_proveedores_prov_id_seq'::regclass);
 C   ALTER TABLE alm.alm_proveedores ALTER COLUMN prov_id DROP DEFAULT;
       alm       postgres    false    227    226    227            '           2604    74605     alm_recepcion_materiales rema_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_recepcion_materiales ALTER COLUMN rema_id SET DEFAULT nextval('alm.alm_recepcion_materiales_rema_id_seq'::regclass);
 L   ALTER TABLE alm.alm_recepcion_materiales ALTER COLUMN rema_id DROP DEFAULT;
       alm       postgres    false    239    240    240            L           2604    106941    deta_ajustes deaj_id    DEFAULT     v   ALTER TABLE ONLY alm.deta_ajustes ALTER COLUMN deaj_id SET DEFAULT nextval('alm.deta_ajustes_deaj_id_seq'::regclass);
 @   ALTER TABLE alm.deta_ajustes ALTER COLUMN deaj_id DROP DEFAULT;
       alm       postgres    false    261    262    262                       2604    74504    items item_id    DEFAULT     h   ALTER TABLE ONLY alm.items ALTER COLUMN item_id SET DEFAULT nextval('alm.items_item_id_seq'::regclass);
 9   ALTER TABLE alm.items ALTER COLUMN item_id DROP DEFAULT;
       alm       postgres    false    229    228    229                       2604    74517    utl_tablas tabl_id    DEFAULT     r   ALTER TABLE ONLY alm.utl_tablas ALTER COLUMN tabl_id SET DEFAULT nextval('alm.utl_tablas_tabl_id_seq'::regclass);
 >   ALTER TABLE alm.utl_tablas ALTER COLUMN tabl_id DROP DEFAULT;
       alm       postgres    false    230    231    231            Z           2604    115214    departamentos depa_id    DEFAULT     z   ALTER TABLE ONLY core.departamentos ALTER COLUMN depa_id SET DEFAULT nextval('core.departamentos_depa_id_seq'::regclass);
 B   ALTER TABLE core.departamentos ALTER COLUMN depa_id DROP DEFAULT;
       core       postgres    false    269    268    269            /           2604    74711    empresas empr_id    DEFAULT     p   ALTER TABLE ONLY core.empresas ALTER COLUMN empr_id SET DEFAULT nextval('core.empresas_empr_id_seq'::regclass);
 =   ALTER TABLE core.empresas ALTER COLUMN empr_id DROP DEFAULT;
       core       postgres    false    246    245    246            =           2604    98624    equipos equi_id    DEFAULT     n   ALTER TABLE ONLY core.equipos ALTER COLUMN equi_id SET DEFAULT nextval('core.equipos_equi_id_seq'::regclass);
 <   ALTER TABLE core.equipos ALTER COLUMN equi_id DROP DEFAULT;
       core       postgres    false    252    253    253            x           2604    123293    snapshots id    DEFAULT     h   ALTER TABLE ONLY core.snapshots ALTER COLUMN id SET DEFAULT nextval('core.snapshots_id_seq'::regclass);
 9   ALTER TABLE core.snapshots ALTER COLUMN id DROP DEFAULT;
       core       postgres    false    290    289    290            V           2604    115195    zonas zona_id    DEFAULT     j   ALTER TABLE ONLY core.zonas ALTER COLUMN zona_id SET DEFAULT nextval('core.zonas_zona_id_seq'::regclass);
 :   ALTER TABLE core.zonas ALTER COLUMN zona_id DROP DEFAULT;
       core       postgres    false    266    267    267            �           2604    57785    formularios form_id    DEFAULT     t   ALTER TABLE ONLY frm.formularios ALTER COLUMN form_id SET DEFAULT nextval('frm.formularios_form_id_seq'::regclass);
 ?   ALTER TABLE frm.formularios ALTER COLUMN form_id DROP DEFAULT;
       frm       postgres    false    213    212    213            �           2604    57802    instancias_items init_id    DEFAULT     ~   ALTER TABLE ONLY frm.instancias_items ALTER COLUMN init_id SET DEFAULT nextval('frm.instancias_items_init_id_seq'::regclass);
 D   ALTER TABLE frm.instancias_items ALTER COLUMN init_id DROP DEFAULT;
       frm       postgres    false    214    215    215            �           2604    57821    items item_id    DEFAULT     h   ALTER TABLE ONLY frm.items ALTER COLUMN item_id SET DEFAULT nextval('frm.items_item_id_seq'::regclass);
 9   ALTER TABLE frm.items ALTER COLUMN item_id DROP DEFAULT;
       frm       postgres    false    217    216    217            i           2604    115363    choferes chof_id    DEFAULT     n   ALTER TABLE ONLY log.choferes ALTER COLUMN chof_id SET DEFAULT nextval('log.choferes_chof_id_seq'::regclass);
 <   ALTER TABLE log.choferes ALTER COLUMN chof_id DROP DEFAULT;
       log       postgres    false    278    277    278            ]           2604    115233    circuitos circ_id    DEFAULT     q   ALTER TABLE ONLY log.circuitos ALTER COLUMN circ_id SET DEFAULT nextval('log.circuitos_circu_id_seq'::regclass);
 =   ALTER TABLE log.circuitos ALTER COLUMN circ_id DROP DEFAULT;
       log       postgres    false    270    271    271            `           2604    115277    contenedores cont_id    DEFAULT     t   ALTER TABLE ONLY log.contenedores ALTER COLUMN cont_id SET DEFAULT nextval('log.containers_cont_id_seq'::regclass);
 @   ALTER TABLE log.contenedores ALTER COLUMN cont_id DROP DEFAULT;
       log       postgres    false    273    272    273            u           2604    115530 #   deta_solicitudes_contenedor desc_id    DEFAULT     �   ALTER TABLE ONLY log.deta_solicitudes_contenedor ALTER COLUMN desc_id SET DEFAULT nextval('log.deta_solicitudes_contenedor_desc_id_seq'::regclass);
 O   ALTER TABLE log.deta_solicitudes_contenedor ALTER COLUMN desc_id DROP DEFAULT;
       log       postgres    false    285    284    285            w           2604    115547    entregas_contenedor enco_id    DEFAULT     �   ALTER TABLE ONLY log.entregas_contenedor ALTER COLUMN enco_id SET DEFAULT nextval('log.entregas_contenedor_enco_id_seq'::regclass);
 G   ALTER TABLE log.entregas_contenedor ALTER COLUMN enco_id DROP DEFAULT;
       log       postgres    false    287    286    287            e           2604    115328    puntos_criticos pucr_id    DEFAULT     |   ALTER TABLE ONLY log.puntos_criticos ALTER COLUMN pucr_id SET DEFAULT nextval('log.puntos_criticos_pucr_id_seq'::regclass);
 C   ALTER TABLE log.puntos_criticos ALTER COLUMN pucr_id DROP DEFAULT;
       log       postgres    false    276    275    276            o           2604    115456    solicitantes_transporte sotr_id    DEFAULT     �   ALTER TABLE ONLY log.solicitantes_transporte ALTER COLUMN sotr_id SET DEFAULT nextval('log.solicitantes_transporte_sotr_id_seq'::regclass);
 K   ALTER TABLE log.solicitantes_transporte ALTER COLUMN sotr_id DROP DEFAULT;
       log       postgres    false    281    280    281            r           2604    115492    solicitudes_contenedor soco_id    DEFAULT     �   ALTER TABLE ONLY log.solicitudes_contenedor ALTER COLUMN soco_id SET DEFAULT nextval('log.solicitudes_contenedor_soco_id_seq'::regclass);
 J   ALTER TABLE log.solicitudes_contenedor ALTER COLUMN soco_id DROP DEFAULT;
       log       postgres    false    282    283    283            R           2604    115165    transportistas tran_id    DEFAULT     z   ALTER TABLE ONLY log.transportistas ALTER COLUMN tran_id SET DEFAULT nextval('log.transportistas_tran_id_seq'::regclass);
 B   ALTER TABLE log.transportistas ALTER COLUMN tran_id DROP DEFAULT;
       log       postgres    false    264    265    265            B           2604    98641    empaque empa_id    DEFAULT     l   ALTER TABLE ONLY prd.empaque ALTER COLUMN empa_id SET DEFAULT nextval('prd.empaque_empa_id_seq'::regclass);
 ;   ALTER TABLE prd.empaque ALTER COLUMN empa_id DROP DEFAULT;
       prd       postgres    false    255    254            -           2604    74638    establecimientos esta_id    DEFAULT     ~   ALTER TABLE ONLY prd.establecimientos ALTER COLUMN esta_id SET DEFAULT nextval('prd.establecimientos_esta_id_seq'::regclass);
 D   ALTER TABLE prd.establecimientos ALTER COLUMN esta_id DROP DEFAULT;
       prd       postgres    false    244    243    244            �           2604    57633    etapas etap_id    DEFAULT     j   ALTER TABLE ONLY prd.etapas ALTER COLUMN etap_id SET DEFAULT nextval('prd.etapas_etap_id_seq'::regclass);
 :   ALTER TABLE prd.etapas ALTER COLUMN etap_id DROP DEFAULT;
       prd       postgres    false    203    204    204            F           2604    98677    fraccionamientos frac_id    DEFAULT     ~   ALTER TABLE ONLY prd.fraccionamientos ALTER COLUMN frac_id SET DEFAULT nextval('prd.fraccionamientos_frac_id_seq'::regclass);
 D   ALTER TABLE prd.fraccionamientos ALTER COLUMN frac_id DROP DEFAULT;
       prd       postgres    false    257    258    258            �           2604    74731    lotes batch_id    DEFAULT     j   ALTER TABLE ONLY prd.lotes ALTER COLUMN batch_id SET DEFAULT nextval('prd.lotes_batch_id_seq'::regclass);
 :   ALTER TABLE prd.lotes ALTER COLUMN batch_id DROP DEFAULT;
       prd       postgres    false    205    206    206            8           2604    74789    movimientos_trasportes motr_id    DEFAULT     �   ALTER TABLE ONLY prd.movimientos_trasportes ALTER COLUMN motr_id SET DEFAULT nextval('prd.movimientos_trasportes_motr_id_seq'::regclass);
 J   ALTER TABLE prd.movimientos_trasportes ALTER COLUMN motr_id DROP DEFAULT;
       prd       postgres    false    248    249    249            �           2604    57618    procesos proc_id    DEFAULT     o   ALTER TABLE ONLY prd.procesos ALTER COLUMN proc_id SET DEFAULT nextval('prd.productos_prod_id_seq'::regclass);
 <   ALTER TABLE prd.procesos ALTER COLUMN proc_id DROP DEFAULT;
       prd       postgres    false    202    201    202            0           2604    74869    recipientes reci_id    DEFAULT     s   ALTER TABLE ONLY prd.recipientes ALTER COLUMN reci_id SET DEFAULT nextval('prd.recipiente_reci_id_seq'::regclass);
 ?   ALTER TABLE prd.recipientes ALTER COLUMN reci_id DROP DEFAULT;
       prd       postgres    false    250    247            �           2604    57673    recursos recu_id    DEFAULT     n   ALTER TABLE ONLY prd.recursos ALTER COLUMN recu_id SET DEFAULT nextval('prd.recursos_recu_id_seq'::regclass);
 <   ALTER TABLE prd.recursos ALTER COLUMN recu_id DROP DEFAULT;
       prd       postgres    false    207    208    208            �          0    106906    ajustes 
   TABLE DATA               l   COPY alm.ajustes (ajus_id, tipo_ajuste, justificacion, usuario_app, empr_id, fec_alta, usuario) FROM stdin;
    alm       postgres    false    260   �       �          0    74435    alm_articulos 
   TABLE DATA               �   COPY alm.alm_articulos (arti_id, barcode, descripcion, costo, es_caja, cantidad_caja, punto_pedido, estado, unidad_medida, empr_id, es_loteado, fec_alta, eliminado, batch_id, tipo) FROM stdin;
    alm       postgres    false    221   	       �          0    74446    alm_depositos 
   TABLE DATA               �   COPY alm.alm_depositos (depo_id, descripcion, direccion, gps, estado, loca_id, pais_id, empr_id, fec_alta, eliminado, esta_id) FROM stdin;
    alm       postgres    false    223          �          0    74617    alm_deta_entrega_materiales 
   TABLE DATA               �   COPY alm.alm_deta_entrega_materiales (deen_id, enma_id, cantidad, arti_id, prov_id, lote_id, depo_id, empr_id, precio, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    242   �       �          0    74524    alm_deta_pedidos_materiales 
   TABLE DATA               �   COPY alm.alm_deta_pedidos_materiales (depe_id, cantidad, resto, fecha_entrega, fecha_entregado, pema_id, arti_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    233          �          0    74403    alm_deta_recepcion_materiales 
   TABLE DATA               �   COPY alm.alm_deta_recepcion_materiales (dere_id, cantidad, precio, empr_id, rema_id, lote_id, prov_id, arti_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    219   j       �          0    74544    alm_entrega_materiales 
   TABLE DATA               �   COPY alm.alm_entrega_materiales (enma_id, fecha, solicitante, dni, comprobante, empr_id, pema_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    235   �       �          0    74562 	   alm_lotes 
   TABLE DATA               �   COPY alm.alm_lotes (lote_id, prov_id, arti_id, depo_id, codigo, fec_vencimiento, cantidad, empr_id, user_id, estado, fec_alta, eliminado, batch_id) FROM stdin;
    alm       postgres    false    237          �          0    74465    alm_pedidos_materiales 
   TABLE DATA               �   COPY alm.alm_pedidos_materiales (pema_id, fecha, motivo_rechazo, justificacion, case_id, ortr_id, estado, empr_id, fec_alta, eliminado, batch_id) FROM stdin;
    alm       postgres    false    225   �       �          0    74483    alm_proveedores 
   TABLE DATA               w   COPY alm.alm_proveedores (prov_id, nombre, cuit, domicilio, telefono, email, empr_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    227   �       �          0    74585    alm_proveedores_articulos 
   TABLE DATA               B   COPY alm.alm_proveedores_articulos (prov_id, arti_id) FROM stdin;
    alm       postgres    false    238   X        �          0    74602    alm_recepcion_materiales 
   TABLE DATA               }   COPY alm.alm_recepcion_materiales (rema_id, fecha, comprobante, empr_id, prov_id, fec_alta, eliminado, batch_id) FROM stdin;
    alm       postgres    false    240   u        �          0    106938    deta_ajustes 
   TABLE DATA               d   COPY alm.deta_ajustes (deaj_id, cantidad, empr_id, fec_alta, usuario, lote_id, ajus_id) FROM stdin;
    alm       postgres    false    262   �        �          0    74501    items 
   TABLE DATA               �   COPY alm.items (item_id, label, name, requerido, tipo_dato, valo_id, orden, aux, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, form_id) FROM stdin;
    alm       postgres    false    229          �          0    74514 
   utl_tablas 
   TABLE DATA               Z   COPY alm.utl_tablas (tabl_id, tabla, valor, descripcion, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    231   #       �          0    115211    departamentos 
   TABLE DATA               V   COPY core.departamentos (depa_id, nombre, descripcion, fec_alta, usuario) FROM stdin;
    core       postgres    false    269   �       �          0    74708    empresas 
   TABLE DATA               �   COPY core.empresas (empr_id, descripcion, cuit, direccion, telefono, email, imagepath, loca_id, prov_id, pais_id, lat, lng, celular, zona_id, clie_id) FROM stdin;
    core       postgres    false    246   w       �          0    98621    equipos 
   TABLE DATA               �  COPY core.equipos (equi_id, descripcion, marca, codigo, ubicacion, estado, fecha_ultimalectura, ultima_lectura, tipo_horas, valor_reposicion, fecha_reposicion, valor, comprobante, descrip_tecnica, numero_serie, adjunto, meta_disponibilidad, fecha_ingreso, fecha_baja, fecha_garantia, prov_id, empr_id, sect_id, ubic_id, grup_id, crit_id, unme_id, area_id, proc_id, tran_id, dominio) FROM stdin;
    core       postgres    false    253   �       �          0    74914    log 
   TABLE DATA               '   COPY core.log (msg, fecha) FROM stdin;
    core       postgres    false    251   �       �          0    123290 	   snapshots 
   TABLE DATA               I   COPY core.snapshots (id, snap_id, data, fec_alta, eliminado) FROM stdin;
    core       postgres    false    290   �       �          0    115109    tablas 
   TABLE DATA               p   COPY core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) FROM stdin;
    core       postgres    false    263   H       �          0    98651    transportistas 
   TABLE DATA               Z   COPY core.transportistas (cuit, razon_social, direccion, fec_alta, eliminado) FROM stdin;
    core       postgres    false    256   �	       �          0    123300    transportistas_tipo_residuos 
   TABLE DATA               Y   COPY core.transportistas_tipo_residuos (tran_id, tire_id, fec_alta, usuario) FROM stdin;
    core       postgres    false    291   
       �          0    115192    zonas 
   TABLE DATA               w   COPY core.zonas (zona_id, nombre, descripcion, imagen, fec_alta, usuario, usuario_app, depa_id, eliminado) FROM stdin;
    core       postgres    false    267   !
       �          0    57782    formularios 
   TABLE DATA               ^   COPY frm.formularios (form_id, nombre, descripcion, eliminado, fec_alta, usuario) FROM stdin;
    frm       postgres    false    213   4        �          0    57799    instancias_items 
   TABLE DATA               �   COPY frm.instancias_items (init_id, label, name, valor, requerido, tida_id, valo_id, info_id, form_id, orden, aux, eliminado, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, item_id) FROM stdin;
    frm       postgres    false    215   Q        �          0    57818    items 
   TABLE DATA               �   COPY frm.items (item_id, label, name, requerido, tipo_dato, valo_id, orden, aux, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, form_id) FROM stdin;
    frm       postgres    false    217   n        �          0    115360    choferes 
   TABLE DATA               �   COPY log.choferes (chof_id, nombre, apellido, documento, fec_nacimiento, direccion, celular, codigo, carnet, vencimiento, habilitacion, imagen, fec_alta, usuario, tran_id, cach_id, eliminado) FROM stdin;
    log       postgres    false    278   �        �          0    115230 	   circuitos 
   TABLE DATA               �   COPY log.circuitos (circ_id, codigo, descripcion, imagen, fec_alta, usuario, usuario_app, chof_id, vehi_id, zona_id) FROM stdin;
    log       postgres    false    271   �       �          0    115416    circuitos_puntos_criticos 
   TABLE DATA               U   COPY log.circuitos_puntos_criticos (fec_alta, usuario, circ_id, pucr_id) FROM stdin;
    log       postgres    false    279   c       �          0    115274    contenedores 
   TABLE DATA               �   COPY log.contenedores (cont_id, codigo, descripcion, capacidad, anio_elaboracion, tara, habilitacion, fec_alta, usuario, usuario_app, esco_id, reci_id) FROM stdin;
    log       postgres    false    273   �       �          0    115527    deta_solicitudes_contenedor 
   TABLE DATA               t   COPY log.deta_solicitudes_contenedor (desc_id, cantidad, otro, fec_alta, usuario, usuario_app, tica_id) FROM stdin;
    log       postgres    false    285   #       �          0    115544    entregas_contenedor 
   TABLE DATA               3   COPY log.entregas_contenedor (enco_id) FROM stdin;
    log       postgres    false    287   @       �          0    115325    puntos_criticos 
   TABLE DATA               �   COPY log.puntos_criticos (pucr_id, nombre, descripcion, lat, lng, fec_alta, usuario, usuario_app, zona_id, eliminado) FROM stdin;
    log       postgres    false    276   ]       �          0    115453    solicitantes_transporte 
   TABLE DATA               �   COPY log.solicitantes_transporte (sotr_id, razon_social, cuit, domicilio, num_registro, lat, lng, usuario, fec_alta, usuario_app, zona_id, rubr_id, tist_id, tica_id, eliminado) FROM stdin;
    log       postgres    false    281   	       �          0    115489    solicitudes_contenedor 
   TABLE DATA               �   COPY log.solicitudes_contenedor (soco_id, num_orden, fec_orden, fec_retiro, fec_alta, usuario, sotr_id, tran_id, essc_id) FROM stdin;
    log       postgres    false    283   �	       �          0    115548    solicitudes_retiro 
   TABLE DATA               2   COPY log.solicitudes_retiro (sore_id) FROM stdin;
    log       postgres    false    288   �	       �          0    115299    tipos_carga_circuitos 
   TABLE DATA               Q   COPY log.tipos_carga_circuitos (fec_alta, usuario, circ_id, tica_id) FROM stdin;
    log       postgres    false    274   �	       �          0    123308    tipos_carga_transportistas 
   TABLE DATA               V   COPY log.tipos_carga_transportistas (fec_alta, usuario, tran_id, tica_id) FROM stdin;
    log       postgres    false    292   
       �          0    115162    transportistas 
   TABLE DATA               �   COPY log.transportistas (tran_id, razon_social, descripcion, direccion, telefono, contacto, resolucion, registro, fec_alta_efectiva, fec_baja_efectiva, fec_alta, usuario, usuario_app, eliminado) FROM stdin;
    log       postgres    false    265   t
       �          0    57723    costos 
   TABLE DATA               ]   COPY prd.costos (fec_vigencia, valor, umed, fec_alta, usuario, recu_id, empr_id) FROM stdin;
    prd       postgres    false    211   l       �          0    98636    empaque 
   TABLE DATA               u   COPY prd.empaque (empa_id, nombre, unidad_medida, capacidad, empr_id, usuario_app, eliminado, fech_alta) FROM stdin;
    prd       postgres    false    254   �       �          0    74635    establecimientos 
   TABLE DATA               �   COPY prd.establecimientos (esta_id, nombre, lng, lat, calle, altura, localidad, estado, pais, fec_alta, usuario, empr_id) FROM stdin;
    prd       postgres    false    244   �       �          0    57630    etapas 
   TABLE DATA               {   COPY prd.etapas (etap_id, nombre, nom_recipiente, fec_alta, usuario, proc_id, eliminado, empr_id, orden, link) FROM stdin;
    prd       postgres    false    204   �       �          0    98674    fraccionamientos 
   TABLE DATA               g   COPY prd.fraccionamientos (frac_id, recu_id, empa_id, cantidad, fecha, eliminado, empr_id) FROM stdin;
    prd       postgres    false    258   v       �          0    57652    lotes 
   TABLE DATA               �   COPY prd.lotes (lote_id, batch_id, estado, num_orden_prod, fec_alta, usuario, etap_id, eliminado, nombre, reci_id, empr_id, usuario_app, arti_id) FROM stdin;
    prd       postgres    false    206   �       �          0    57700    lotes_hijos 
   TABLE DATA               }   COPY prd.lotes_hijos (batch_id, batch_id_padre, fec_alta, usuario, eliminado, empr_id, cantidad, cantidad_padre) FROM stdin;
    prd       postgres    false    210   �       �          0    74786    movimientos_trasportes 
   TABLE DATA               �   COPY prd.movimientos_trasportes (motr_id, boleta, fecha_entrada, patente, acoplado, conductor, tipo, bruto, tara, neto, prov_id, esta_id, fec_alta, eliminado, estado, reci_id, transportista, cuit, accion) FROM stdin;
    prd       postgres    false    249   �       �          0    57615    procesos 
   TABLE DATA               L   COPY prd.procesos (proc_id, nombre, fec_alta, usuario, empr_id) FROM stdin;
    prd       postgres    false    202   N       �          0    74759    recipientes 
   TABLE DATA               z   COPY prd.recipientes (reci_id, tipo, estado, nombre, fec_alta, usuario, eliminado, empr_id, depo_id, motr_id) FROM stdin;
    prd       postgres    false    247   �       �          0    57670    recursos 
   TABLE DATA               �   COPY prd.recursos (recu_id, tipo, cant_capacidad, umed_capacidad, cant_tiempo_capacidad, umed_iempo_capacidad, fec_alta, usuario, arti_id, empr_id, equi_id) FROM stdin;
    prd       postgres    false    208   >	       �          0    57682    recursos_lotes 
   TABLE DATA               |   COPY prd.recursos_lotes (batch_id, recu_id, fec_alta, usuario, empr_id, cantidad, tipo, empa_id, empa_cantidad) FROM stdin;
    prd       postgres    false    209   �	       +           0    0    ajustes_ajus_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('alm.ajustes_ajus_id_seq', 44, true);
            alm       postgres    false    259            ,           0    0    alm_articulos_arti_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('alm.alm_articulos_arti_id_seq', 68, true);
            alm       postgres    false    220            -           0    0    alm_depositos_depo_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('alm.alm_depositos_depo_id_seq', 7, true);
            alm       postgres    false    222            .           0    0 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE SET     R   SELECT pg_catalog.setval('alm.alm_deta_entrega_materiales_deen_id_seq', 9, true);
            alm       postgres    false    241            /           0    0 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE SET     T   SELECT pg_catalog.setval('alm.alm_deta_pedidos_materiales_depe_id_seq', 137, true);
            alm       postgres    false    232            0           0    0 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE SET     T   SELECT pg_catalog.setval('alm.alm_deta_recepcion_materiales_dere_id_seq', 4, true);
            alm       postgres    false    218            1           0    0 "   alm_entrega_materiales_enma_id_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('alm.alm_entrega_materiales_enma_id_seq', 1, true);
            alm       postgres    false    234            2           0    0    alm_lotes_lote_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('alm.alm_lotes_lote_id_seq', 74, true);
            alm       postgres    false    236            3           0    0 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('alm.alm_pedidos_materiales_pema_id_seq', 192, true);
            alm       postgres    false    224            4           0    0    alm_proveedores_prov_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('alm.alm_proveedores_prov_id_seq', 6, true);
            alm       postgres    false    226            5           0    0 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('alm.alm_recepcion_materiales_rema_id_seq', 2, true);
            alm       postgres    false    239            6           0    0    deta_ajustes_deaj_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('alm.deta_ajustes_deaj_id_seq', 27, true);
            alm       postgres    false    261            7           0    0    items_item_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('alm.items_item_id_seq', 1, false);
            alm       postgres    false    228            8           0    0    utl_tablas_tabl_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('alm.utl_tablas_tabl_id_seq', 17, true);
            alm       postgres    false    230            9           0    0    departamentos_depa_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('core.departamentos_depa_id_seq', 4, true);
            core       postgres    false    268            :           0    0    empresas_empr_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('core.empresas_empr_id_seq', 1, true);
            core       postgres    false    245            ;           0    0    equipos_equi_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('core.equipos_equi_id_seq', 23, true);
            core       postgres    false    252            <           0    0    snapshots_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('core.snapshots_id_seq', 58, true);
            core       postgres    false    289            =           0    0    zonas_zona_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('core.zonas_zona_id_seq', 8, true);
            core       postgres    false    266            >           0    0    formularios_form_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('frm.formularios_form_id_seq', 1, false);
            frm       postgres    false    212            ?           0    0    instancias_items_init_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('frm.instancias_items_init_id_seq', 1, false);
            frm       postgres    false    214            @           0    0    items_item_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('frm.items_item_id_seq', 1, false);
            frm       postgres    false    216            A           0    0    choferes_chof_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('log.choferes_chof_id_seq', 6, true);
            log       postgres    false    277            B           0    0    circuitos_circu_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('log.circuitos_circu_id_seq', 5, true);
            log       postgres    false    270            C           0    0    containers_cont_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('log.containers_cont_id_seq', 8, true);
            log       postgres    false    272            D           0    0 '   deta_solicitudes_contenedor_desc_id_seq    SEQUENCE SET     S   SELECT pg_catalog.setval('log.deta_solicitudes_contenedor_desc_id_seq', 1, false);
            log       postgres    false    284            E           0    0    entregas_contenedor_enco_id_seq    SEQUENCE SET     K   SELECT pg_catalog.setval('log.entregas_contenedor_enco_id_seq', 1, false);
            log       postgres    false    286            F           0    0    puntos_criticos_pucr_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('log.puntos_criticos_pucr_id_seq', 4, true);
            log       postgres    false    275            G           0    0 #   solicitantes_transporte_sotr_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('log.solicitantes_transporte_sotr_id_seq', 1, true);
            log       postgres    false    280            H           0    0 "   solicitudes_contenedor_soco_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('log.solicitudes_contenedor_soco_id_seq', 1, false);
            log       postgres    false    282            I           0    0    transportistas_tran_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('log.transportistas_tran_id_seq', 3, true);
            log       postgres    false    264            J           0    0    empaque_empa_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('prd.empaque_empa_id_seq', 5, true);
            prd       postgres    false    255            K           0    0    establecimientos_esta_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('prd.establecimientos_esta_id_seq', 3, true);
            prd       postgres    false    243            L           0    0    etapas_etap_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('prd.etapas_etap_id_seq', 1, true);
            prd       postgres    false    203            M           0    0    fraccionamientos_frac_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('prd.fraccionamientos_frac_id_seq', 3, true);
            prd       postgres    false    257            N           0    0    lotes_batch_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('prd.lotes_batch_id_seq', 191, true);
            prd       postgres    false    205            O           0    0 "   movimientos_trasportes_motr_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('prd.movimientos_trasportes_motr_id_seq', 30, true);
            prd       postgres    false    248            P           0    0    productos_prod_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('prd.productos_prod_id_seq', 1, true);
            prd       postgres    false    201            Q           0    0    recipiente_reci_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('prd.recipiente_reci_id_seq', 106, true);
            prd       postgres    false    250            R           0    0    recursos_recu_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('prd.recursos_recu_id_seq', 16, true);
            prd       postgres    false    207            �           2606    106917    ajustes ajustes_pk 
   CONSTRAINT     R   ALTER TABLE ONLY alm.ajustes
    ADD CONSTRAINT ajustes_pk PRIMARY KEY (ajus_id);
 9   ALTER TABLE ONLY alm.ajustes DROP CONSTRAINT ajustes_pk;
       alm         postgres    false    260            �           2606    74443     alm_articulos alm_articulos_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY alm.alm_articulos
    ADD CONSTRAINT alm_articulos_pkey PRIMARY KEY (arti_id);
 G   ALTER TABLE ONLY alm.alm_articulos DROP CONSTRAINT alm_articulos_pkey;
       alm         postgres    false    221            �           2606    74462     alm_depositos alm_depositos_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY alm.alm_depositos
    ADD CONSTRAINT alm_depositos_pkey PRIMARY KEY (depo_id);
 G   ALTER TABLE ONLY alm.alm_depositos DROP CONSTRAINT alm_depositos_pkey;
       alm         postgres    false    223            �           2606    74624 <   alm_deta_entrega_materiales alm_deta_entrega_materiales_pkey 
   CONSTRAINT     |   ALTER TABLE ONLY alm.alm_deta_entrega_materiales
    ADD CONSTRAINT alm_deta_entrega_materiales_pkey PRIMARY KEY (deen_id);
 c   ALTER TABLE ONLY alm.alm_deta_entrega_materiales DROP CONSTRAINT alm_deta_entrega_materiales_pkey;
       alm         postgres    false    242            �           2606    74531 <   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_pkey 
   CONSTRAINT     |   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_pkey PRIMARY KEY (depe_id);
 c   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_pkey;
       alm         postgres    false    233            �           2606    74410 @   alm_deta_recepcion_materiales alm_deta_recepcion_materiales_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales
    ADD CONSTRAINT alm_deta_recepcion_materiales_pkey PRIMARY KEY (dere_id);
 g   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales DROP CONSTRAINT alm_deta_recepcion_materiales_pkey;
       alm         postgres    false    219            �           2606    74554 2   alm_entrega_materiales alm_entrega_materiales_pkey 
   CONSTRAINT     r   ALTER TABLE ONLY alm.alm_entrega_materiales
    ADD CONSTRAINT alm_entrega_materiales_pkey PRIMARY KEY (enma_id);
 Y   ALTER TABLE ONLY alm.alm_entrega_materiales DROP CONSTRAINT alm_entrega_materiales_pkey;
       alm         postgres    false    235            �           2606    74574    alm_lotes alm_lotes_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_pkey PRIMARY KEY (lote_id);
 ?   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_pkey;
       alm         postgres    false    237            �           2606    74478 2   alm_pedidos_materiales alm_pedidos_materiales_pkey 
   CONSTRAINT     r   ALTER TABLE ONLY alm.alm_pedidos_materiales
    ADD CONSTRAINT alm_pedidos_materiales_pkey PRIMARY KEY (pema_id);
 Y   ALTER TABLE ONLY alm.alm_pedidos_materiales DROP CONSTRAINT alm_pedidos_materiales_pkey;
       alm         postgres    false    225            �           2606    74589 8   alm_proveedores_articulos alm_proveedores_articulos_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_pkey PRIMARY KEY (prov_id, arti_id);
 _   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_pkey;
       alm         postgres    false    238    238            �           2606    74498 $   alm_proveedores alm_proveedores_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY alm.alm_proveedores
    ADD CONSTRAINT alm_proveedores_pkey PRIMARY KEY (prov_id);
 K   ALTER TABLE ONLY alm.alm_proveedores DROP CONSTRAINT alm_proveedores_pkey;
       alm         postgres    false    227            �           2606    74609 6   alm_recepcion_materiales alm_recepcion_materiales_pkey 
   CONSTRAINT     v   ALTER TABLE ONLY alm.alm_recepcion_materiales
    ADD CONSTRAINT alm_recepcion_materiales_pkey PRIMARY KEY (rema_id);
 ]   ALTER TABLE ONLY alm.alm_recepcion_materiales DROP CONSTRAINT alm_recepcion_materiales_pkey;
       alm         postgres    false    240            �           2606    106955    deta_ajustes deta_ajustes_pk 
   CONSTRAINT     \   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_pk PRIMARY KEY (deaj_id);
 C   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_pk;
       alm         postgres    false    262            �           2606    74511    items items_pk 
   CONSTRAINT     N   ALTER TABLE ONLY alm.items
    ADD CONSTRAINT items_pk PRIMARY KEY (item_id);
 5   ALTER TABLE ONLY alm.items DROP CONSTRAINT items_pk;
       alm         postgres    false    229            �           2606    74521    utl_tablas utl_tablas_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY alm.utl_tablas
    ADD CONSTRAINT utl_tablas_pkey PRIMARY KEY (tabl_id);
 A   ALTER TABLE ONLY alm.utl_tablas DROP CONSTRAINT utl_tablas_pkey;
       alm         postgres    false    231            �           2606    115221    departamentos departamentos_pk 
   CONSTRAINT     _   ALTER TABLE ONLY core.departamentos
    ADD CONSTRAINT departamentos_pk PRIMARY KEY (depa_id);
 F   ALTER TABLE ONLY core.departamentos DROP CONSTRAINT departamentos_pk;
       core         postgres    false    269            �           2606    74713    empresas empresas_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY core.empresas
    ADD CONSTRAINT empresas_pkey PRIMARY KEY (empr_id);
 >   ALTER TABLE ONLY core.empresas DROP CONSTRAINT empresas_pkey;
       core         postgres    false    246            �           2606    98630    equipos equipos_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY core.equipos
    ADD CONSTRAINT equipos_pkey PRIMARY KEY (equi_id);
 <   ALTER TABLE ONLY core.equipos DROP CONSTRAINT equipos_pkey;
       core         postgres    false    253            �           2606    115119    tablas tablas_pk 
   CONSTRAINT     Q   ALTER TABLE ONLY core.tablas
    ADD CONSTRAINT tablas_pk PRIMARY KEY (tabl_id);
 8   ALTER TABLE ONLY core.tablas DROP CONSTRAINT tablas_pk;
       core         postgres    false    263            �           2606    98660     transportistas transportistas_pk 
   CONSTRAINT     ^   ALTER TABLE ONLY core.transportistas
    ADD CONSTRAINT transportistas_pk PRIMARY KEY (cuit);
 H   ALTER TABLE ONLY core.transportistas DROP CONSTRAINT transportistas_pk;
       core         postgres    false    256            �           2606    115384    zonas zonas_pk 
   CONSTRAINT     O   ALTER TABLE ONLY core.zonas
    ADD CONSTRAINT zonas_pk PRIMARY KEY (zona_id);
 6   ALTER TABLE ONLY core.zonas DROP CONSTRAINT zonas_pk;
       core         postgres    false    267            �           2606    57793    formularios formularios_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY frm.formularios
    ADD CONSTRAINT formularios_pk PRIMARY KEY (form_id);
 A   ALTER TABLE ONLY frm.formularios DROP CONSTRAINT formularios_pk;
       frm         postgres    false    213            �           2606    57811 $   instancias_items instancias_items_pk 
   CONSTRAINT     d   ALTER TABLE ONLY frm.instancias_items
    ADD CONSTRAINT instancias_items_pk PRIMARY KEY (init_id);
 K   ALTER TABLE ONLY frm.instancias_items DROP CONSTRAINT instancias_items_pk;
       frm         postgres    false    215            �           2606    57828    items items_pk 
   CONSTRAINT     N   ALTER TABLE ONLY frm.items
    ADD CONSTRAINT items_pk PRIMARY KEY (item_id);
 5   ALTER TABLE ONLY frm.items DROP CONSTRAINT items_pk;
       frm         postgres    false    217            �           2606    115372    choferes choferes_dni_un 
   CONSTRAINT     U   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_dni_un UNIQUE (documento);
 ?   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_dni_un;
       log         postgres    false    278            �           2606    115370    choferes choferes_pk 
   CONSTRAINT     T   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_pk PRIMARY KEY (chof_id);
 ;   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_pk;
       log         postgres    false    278            �           2606    115308    circuitos circuitos_pk 
   CONSTRAINT     V   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_pk PRIMARY KEY (circ_id);
 =   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_pk;
       log         postgres    false    271            �           2606    115440 6   circuitos_puntos_criticos circuitos_puntos_criticos_pk 
   CONSTRAINT        ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_pk PRIMARY KEY (circ_id, pucr_id);
 ]   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_pk;
       log         postgres    false    279    279            �           2606    115310    circuitos circuitos_un 
   CONSTRAINT     P   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_un UNIQUE (codigo);
 =   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_un;
       log         postgres    false    271            �           2606    115286 !   contenedores containers_codigo_un 
   CONSTRAINT     [   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_codigo_un UNIQUE (codigo);
 H   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_codigo_un;
       log         postgres    false    273            �           2606    115284    contenedores containers_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_pk PRIMARY KEY (cont_id);
 A   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_pk;
       log         postgres    false    273            �           2606    115288 "   contenedores containers_reci_id_un 
   CONSTRAINT     ]   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_reci_id_un UNIQUE (reci_id);
 I   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_reci_id_un;
       log         postgres    false    273            �           2606    115541 :   deta_solicitudes_contenedor deta_solicitudes_contenedor_pk 
   CONSTRAINT     z   ALTER TABLE ONLY log.deta_solicitudes_contenedor
    ADD CONSTRAINT deta_solicitudes_contenedor_pk PRIMARY KEY (desc_id);
 a   ALTER TABLE ONLY log.deta_solicitudes_contenedor DROP CONSTRAINT deta_solicitudes_contenedor_pk;
       log         postgres    false    285            �           2606    115335 "   puntos_criticos puntos_criticos_pk 
   CONSTRAINT     b   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_pk PRIMARY KEY (pucr_id);
 I   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_pk;
       log         postgres    false    276            �           2606    115337 "   puntos_criticos puntos_criticos_un 
   CONSTRAINT     \   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_un UNIQUE (nombre);
 I   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_un;
       log         postgres    false    276            �           2606    115463 1   solicitantes_transporte solcitantes_transporte_pk 
   CONSTRAINT     q   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_pk PRIMARY KEY (sotr_id);
 X   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_pk;
       log         postgres    false    281            �           2606    115465 1   solicitantes_transporte solcitantes_transporte_un 
   CONSTRAINT     i   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_un UNIQUE (cuit);
 X   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_un;
       log         postgres    false    281            �           2606    115499 0   solicitudes_contenedor solicitudes_contenedor_pk 
   CONSTRAINT     p   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedor_pk PRIMARY KEY (soco_id);
 W   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedor_pk;
       log         postgres    false    283            �           2606    115501 0   solicitudes_contenedor solicitudes_contenedor_un 
   CONSTRAINT     m   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedor_un UNIQUE (num_orden);
 W   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedor_un;
       log         postgres    false    283            �           2606    115400 .   tipos_carga_circuitos tipos_carga_circuitos_pk 
   CONSTRAINT     w   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_carga_circuitos_pk PRIMARY KEY (circ_id, tica_id);
 U   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_carga_circuitos_pk;
       log         postgres    false    274    274            �           2606    123317 8   tipos_carga_transportistas tipos_carga_transportistas_pk 
   CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_pk PRIMARY KEY (tran_id, tica_id);
 _   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_pk;
       log         postgres    false    292    292            �           2606    115172     transportistas transportistas_pk 
   CONSTRAINT     `   ALTER TABLE ONLY log.transportistas
    ADD CONSTRAINT transportistas_pk PRIMARY KEY (tran_id);
 G   ALTER TABLE ONLY log.transportistas DROP CONSTRAINT transportistas_pk;
       log         postgres    false    265            �           2606    115174     transportistas transportistas_un 
   CONSTRAINT     `   ALTER TABLE ONLY log.transportistas
    ADD CONSTRAINT transportistas_un UNIQUE (razon_social);
 G   ALTER TABLE ONLY log.transportistas DROP CONSTRAINT transportistas_un;
       log         postgres    false    265            �           2606    57737    costos costos_pk 
   CONSTRAINT     ^   ALTER TABLE ONLY prd.costos
    ADD CONSTRAINT costos_pk PRIMARY KEY (fec_vigencia, recu_id);
 7   ALTER TABLE ONLY prd.costos DROP CONSTRAINT costos_pk;
       prd         postgres    false    211    211            �           2606    98646    empaque empaque_pk 
   CONSTRAINT     R   ALTER TABLE ONLY prd.empaque
    ADD CONSTRAINT empaque_pk PRIMARY KEY (empa_id);
 9   ALTER TABLE ONLY prd.empaque DROP CONSTRAINT empaque_pk;
       prd         postgres    false    254            �           2606    74643 $   establecimientos establecimientos_pk 
   CONSTRAINT     d   ALTER TABLE ONLY prd.establecimientos
    ADD CONSTRAINT establecimientos_pk PRIMARY KEY (esta_id);
 K   ALTER TABLE ONLY prd.establecimientos DROP CONSTRAINT establecimientos_pk;
       prd         postgres    false    244            �           2606    57640    etapas etapas_pk 
   CONSTRAINT     P   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_pk PRIMARY KEY (etap_id);
 7   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_pk;
       prd         postgres    false    204            �           2606    98616    etapas etapas_un 
   CONSTRAINT     S   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_un UNIQUE (nombre, proc_id);
 7   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_un;
       prd         postgres    false    204    204            �           2606    98614    etapas etapas_un_2 
   CONSTRAINT     T   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_un_2 UNIQUE (orden, proc_id);
 9   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_un_2;
       prd         postgres    false    204    204            �           2606    74733    lotes lotes_un 
   CONSTRAINT     J   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_un UNIQUE (batch_id);
 5   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_un;
       prd         postgres    false    206            �           2606    74795 0   movimientos_trasportes movimientos_trasportes_pk 
   CONSTRAINT     p   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_pk PRIMARY KEY (motr_id);
 W   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_pk;
       prd         postgres    false    249            �           2606    57625    procesos productos_pk 
   CONSTRAINT     U   ALTER TABLE ONLY prd.procesos
    ADD CONSTRAINT productos_pk PRIMARY KEY (proc_id);
 <   ALTER TABLE ONLY prd.procesos DROP CONSTRAINT productos_pk;
       prd         postgres    false    202            �           2606    57627    procesos productos_un 
   CONSTRAINT     O   ALTER TABLE ONLY prd.procesos
    ADD CONSTRAINT productos_un UNIQUE (nombre);
 <   ALTER TABLE ONLY prd.procesos DROP CONSTRAINT productos_un;
       prd         postgres    false    202            �           2606    74771    recipientes recipientes_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_pk PRIMARY KEY (reci_id);
 A   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_pk;
       prd         postgres    false    247            �           2606    57679    recursos recursos_pk 
   CONSTRAINT     T   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_pk PRIMARY KEY (recu_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_pk;
       prd         postgres    false    208            �           2606    82232    recursos recursos_un 
   CONSTRAINT     O   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_un UNIQUE (arti_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_un;
       prd         postgres    false    208            %           2620    98705 0   alm_deta_entrega_materiales asociar_lote_hijo_ai    TRIGGER     �   CREATE TRIGGER asociar_lote_hijo_ai AFTER INSERT ON alm.alm_deta_entrega_materiales FOR EACH ROW EXECUTE PROCEDURE prd.asociar_lote_hijo_trg();
 F   DROP TRIGGER asociar_lote_hijo_ai ON alm.alm_deta_entrega_materiales;
       alm       postgres    false    310    242            #           2620    82229    alm_articulos crear_producto_ai    TRIGGER        CREATE TRIGGER crear_producto_ai AFTER INSERT ON alm.alm_articulos FOR EACH ROW EXECUTE PROCEDURE prd.crear_prd_recurso_trg();
 5   DROP TRIGGER crear_producto_ai ON alm.alm_articulos;
       alm       postgres    false    311    221            $           2620    82230 "   alm_articulos eliminar_producto_ad    TRIGGER     �   CREATE TRIGGER eliminar_producto_ad AFTER DELETE ON alm.alm_articulos FOR EACH ROW EXECUTE PROCEDURE prd.eliminar_prd_recurso_trg();
 8   DROP TRIGGER eliminar_producto_ad ON alm.alm_articulos;
       alm       postgres    false    312    221            &           2620    115124    tablas set_tabla_id_bui    TRIGGER        CREATE TRIGGER set_tabla_id_bui BEFORE INSERT OR UPDATE ON core.tablas FOR EACH ROW EXECUTE PROCEDURE core.set_tabla_id_trg();
 .   DROP TRIGGER set_tabla_id_bui ON core.tablas;
       core       postgres    false    314    263            �           2606    115378    alm_articulos alm_articulos_fk    FK CONSTRAINT     {   ALTER TABLE ONLY alm.alm_articulos
    ADD CONSTRAINT alm_articulos_fk FOREIGN KEY (tipo) REFERENCES core.tablas(tabl_id);
 E   ALTER TABLE ONLY alm.alm_articulos DROP CONSTRAINT alm_articulos_fk;
       alm       postgres    false    221    263    3268                       2606    74625 :   alm_deta_entrega_materiales alm_deta_entrega_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_entrega_materiales
    ADD CONSTRAINT alm_deta_entrega_materiales_fk FOREIGN KEY (enma_id) REFERENCES alm.alm_entrega_materiales(enma_id);
 a   ALTER TABLE ONLY alm.alm_deta_entrega_materiales DROP CONSTRAINT alm_deta_entrega_materiales_fk;
       alm       postgres    false    3240    242    235            �           2606    74532 :   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 a   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_fk;
       alm       postgres    false    3226    221    233            �           2606    74537 <   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_fk_1 FOREIGN KEY (pema_id) REFERENCES alm.alm_pedidos_materiales(pema_id);
 c   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_fk_1;
       alm       postgres    false    233    225    3230            �           2606    74555 0   alm_entrega_materiales alm_entrega_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_entrega_materiales
    ADD CONSTRAINT alm_entrega_materiales_fk FOREIGN KEY (pema_id) REFERENCES alm.alm_pedidos_materiales(pema_id);
 W   ALTER TABLE ONLY alm.alm_entrega_materiales DROP CONSTRAINT alm_entrega_materiales_fk;
       alm       postgres    false    235    225    3230            �           2606    74777 %   alm_depositos alm_establecimientos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_depositos
    ADD CONSTRAINT alm_establecimientos_fk FOREIGN KEY (esta_id) REFERENCES prd.establecimientos(esta_id);
 L   ALTER TABLE ONLY alm.alm_depositos DROP CONSTRAINT alm_establecimientos_fk;
       alm       postgres    false    244    3250    223            �           2606    74575    alm_lotes alm_lotes_fk    FK CONSTRAINT     |   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 =   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_fk;
       alm       postgres    false    221    237    3226            �           2606    74580    alm_lotes alm_lotes_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_fk_1 FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 ?   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_fk_1;
       alm       postgres    false    227    237    3232                        2606    74880    alm_lotes alm_lotes_lotes_fk    FK CONSTRAINT     |   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 C   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_lotes_fk;
       alm       postgres    false    3210    206    237                       2606    74590 6   alm_proveedores_articulos alm_proveedores_articulos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 ]   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_fk;
       alm       postgres    false    3226    221    238                       2606    74595 8   alm_proveedores_articulos alm_proveedores_articulos_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_fk_1 FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 _   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_fk_1;
       alm       postgres    false    3232    238    227                       2606    74610 4   alm_recepcion_materiales alm_recepcion_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_recepcion_materiales
    ADD CONSTRAINT alm_recepcion_materiales_fk FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 [   ALTER TABLE ONLY alm.alm_recepcion_materiales DROP CONSTRAINT alm_recepcion_materiales_fk;
       alm       postgres    false    227    240    3232                       2606    106964 $   deta_ajustes deta_ajustes_ajustes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_ajustes_fk FOREIGN KEY (ajus_id) REFERENCES alm.ajustes(ajus_id);
 K   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_ajustes_fk;
       alm       postgres    false    262    3264    260                       2606    106956 &   deta_ajustes deta_ajustes_alm_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_alm_lotes_fk FOREIGN KEY (lote_id) REFERENCES alm.alm_lotes(lote_id);
 M   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_alm_lotes_fk;
       alm       postgres    false    3242    237    262                       2606    115223    zonas zonas_fk    FK CONSTRAINT     v   ALTER TABLE ONLY core.zonas
    ADD CONSTRAINT zonas_fk FOREIGN KEY (depa_id) REFERENCES core.departamentos(depa_id);
 6   ALTER TABLE ONLY core.zonas DROP CONSTRAINT zonas_fk;
       core       postgres    false    269    267    3276                       2606    115373    choferes choferes_fk    FK CONSTRAINT     {   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 ;   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_fk;
       log       postgres    false    278    265    3270                       2606    115441 6   circuitos_puntos_criticos circuitos_puntos_criticos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_fk FOREIGN KEY (circ_id) REFERENCES log.circuitos(circ_id);
 ]   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_fk;
       log       postgres    false    279    3278    271                       2606    115446 8   circuitos_puntos_criticos circuitos_puntos_criticos_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_fk_1 FOREIGN KEY (pucr_id) REFERENCES log.puntos_criticos(pucr_id);
 _   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_fk_1;
       log       postgres    false    3290    279    276                       2606    123390    circuitos circuitos_zona_id_fk    FK CONSTRAINT     }   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 E   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_zona_id_fk;
       log       postgres    false    3274    271    267                       2606    115294    contenedores containers_fk    FK CONSTRAINT     z   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_fk FOREIGN KEY (esco_id) REFERENCES core.tablas(tabl_id);
 A   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_fk;
       log       postgres    false    3268    263    273                       2606    115289 "   contenedores containers_reci_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_reci_id_fk FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 I   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_reci_id_fk;
       log       postgres    false    273    247    3254                        2606    115535 B   deta_solicitudes_contenedor deta_solicitudes_contenedor_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.deta_solicitudes_contenedor
    ADD CONSTRAINT deta_solicitudes_contenedor_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 i   ALTER TABLE ONLY log.deta_solicitudes_contenedor DROP CONSTRAINT deta_solicitudes_contenedor_tica_id_fk;
       log       postgres    false    3268    285    263                       2606    115411 *   puntos_criticos puntos_criticos_zona_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 Q   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_zona_id_fk;
       log       postgres    false    267    276    3274                       2606    115466 9   solicitantes_transporte solcitantes_transporte_rubr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_rubr_id_fk FOREIGN KEY (rubr_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_rubr_id_fk;
       log       postgres    false    3268    281    263                       2606    115476 9   solicitantes_transporte solcitantes_transporte_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_tica_id_fk;
       log       postgres    false    3268    263    281                       2606    115471 9   solicitantes_transporte solcitantes_transporte_tisr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_tisr_id_fk FOREIGN KEY (tist_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_tisr_id_fk;
       log       postgres    false    281    3268    263                       2606    115481 9   solicitantes_transporte solcitantes_transporte_zona_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_zona_id_fk;
       log       postgres    false    3274    267    281                       2606    115520 8   solicitudes_contenedor solicitudes_contenedor_essc_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedor_essc_id_fk FOREIGN KEY (essc_id) REFERENCES core.tablas(tabl_id);
 _   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedor_essc_id_fk;
       log       postgres    false    3268    283    263                       2606    115502 8   solicitudes_contenedor solicitudes_contenedor_sotr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedor_sotr_id_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 _   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedor_sotr_id_fk;
       log       postgres    false    3300    281    283                       2606    115507 8   solicitudes_contenedor solicitudes_contenedor_tran_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitudes_contenedor
    ADD CONSTRAINT solicitudes_contenedor_tran_id_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 _   ALTER TABLE ONLY log.solicitudes_contenedor DROP CONSTRAINT solicitudes_contenedor_tran_id_fk;
       log       postgres    false    265    283    3270                       2606    115401 6   tipos_carga_circuitos tipos_carga_circuitos_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_carga_circuitos_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 ]   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_carga_circuitos_tica_id_fk;
       log       postgres    false    274    3268    263            "           2606    123323 8   tipos_carga_transportistas tipos_carga_transportistas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 _   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_fk;
       log       postgres    false    3270    292    265            !           2606    123318 @   tipos_carga_transportistas tipos_carga_transportistas_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 g   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_tica_id_fk;
       log       postgres    false    3268    292    263                       2606    115313 0   tipos_carga_circuitos tipos_residuo_circuitos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_residuo_circuitos_fk FOREIGN KEY (circ_id) REFERENCES log.circuitos(circ_id);
 W   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_residuo_circuitos_fk;
       log       postgres    false    271    3278    274            �           2606    57731    costos costos_recursos_fk    FK CONSTRAINT     z   ALTER TABLE ONLY prd.costos
    ADD CONSTRAINT costos_recursos_fk FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id);
 @   ALTER TABLE ONLY prd.costos DROP CONSTRAINT costos_recursos_fk;
       prd       postgres    false    208    211    3212                       2606    98685    fraccionamientos empa_id    FK CONSTRAINT     x   ALTER TABLE ONLY prd.fraccionamientos
    ADD CONSTRAINT empa_id FOREIGN KEY (empa_id) REFERENCES prd.empaque(empa_id);
 ?   ALTER TABLE ONLY prd.fraccionamientos DROP CONSTRAINT empa_id;
       prd       postgres    false    258    254    3260            �           2606    57747    etapas etapas_procesos_fk    FK CONSTRAINT     z   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_procesos_fk FOREIGN KEY (proc_id) REFERENCES prd.procesos(proc_id);
 @   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_procesos_fk;
       prd       postgres    false    204    3200    202            �           2606    57663    lotes lotes_etapas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_etapas_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id) ON DELETE RESTRICT;
 <   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_etapas_fk;
       prd       postgres    false    3204    206    204            �           2606    82169    lotes lotes_fk    FK CONSTRAINT     t   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 5   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_fk;
       prd       postgres    false    221    3226    206            �           2606    74739     lotes_hijos lotes_hijos_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_hijos
    ADD CONSTRAINT lotes_hijos_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 G   ALTER TABLE ONLY prd.lotes_hijos DROP CONSTRAINT lotes_hijos_lotes_fk;
       prd       postgres    false    3210    210    206            �           2606    74734 '   lotes_hijos lotes_hijos_lotes_padres_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_hijos
    ADD CONSTRAINT lotes_hijos_lotes_padres_fk FOREIGN KEY (batch_id_padre) REFERENCES prd.lotes(batch_id);
 N   ALTER TABLE ONLY prd.lotes_hijos DROP CONSTRAINT lotes_hijos_lotes_padres_fk;
       prd       postgres    false    3210    206    210            �           2606    74772    lotes lotes_recipientes_fk    FK CONSTRAINT     ~   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_recipientes_fk FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 A   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_recipientes_fk;
       prd       postgres    false    206    3254    247            
           2606    98661 ?   movimientos_trasportes movimientos_trasportes__transportista_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes__transportista_fk FOREIGN KEY (cuit) REFERENCES core.transportistas(cuit);
 f   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes__transportista_fk;
       prd       postgres    false    249    256    3262                       2606    74796 0   movimientos_trasportes movimientos_trasportes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 W   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk;
       prd       postgres    false    249    227    3232                       2606    74801 2   movimientos_trasportes movimientos_trasportes_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk_1 FOREIGN KEY (esta_id) REFERENCES prd.establecimientos(esta_id);
 Y   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk_1;
       prd       postgres    false    249    244    3250            	           2606    74870 2   movimientos_trasportes movimientos_trasportes_fk_2    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk_2 FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 Y   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk_2;
       prd       postgres    false    247    3254    249                       2606    74818 (   recipientes recipientes_alm_depositos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_alm_depositos_fk FOREIGN KEY (depo_id) REFERENCES alm.alm_depositos(depo_id);
 O   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_alm_depositos_fk;
       prd       postgres    false    247    3228    223                       2606    74875    recipientes recipientes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_fk FOREIGN KEY (motr_id) REFERENCES prd.movimientos_trasportes(motr_id);
 A   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_fk;
       prd       postgres    false    247    3256    249                       2606    98690    fraccionamientos recu_id    FK CONSTRAINT     y   ALTER TABLE ONLY prd.fraccionamientos
    ADD CONSTRAINT recu_id FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id);
 ?   ALTER TABLE ONLY prd.fraccionamientos DROP CONSTRAINT recu_id;
       prd       postgres    false    3212    208    258            �           2606    98631    recursos recursos_fk    FK CONSTRAINT     u   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_fk;
       prd       postgres    false    3258    253    208            �           2606    74744 &   recursos_lotes recursos_lotes_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recursos_lotes
    ADD CONSTRAINT recursos_lotes_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id) ON DELETE RESTRICT;
 M   ALTER TABLE ONLY prd.recursos_lotes DROP CONSTRAINT recursos_lotes_lotes_fk;
       prd       postgres    false    206    209    3210            �           2606    57695 )   recursos_lotes recursos_lotes_recursos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recursos_lotes
    ADD CONSTRAINT recursos_lotes_recursos_fk FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id) ON DELETE RESTRICT;
 P   ALTER TABLE ONLY prd.recursos_lotes DROP CONSTRAINT recursos_lotes_recursos_fk;
       prd       postgres    false    208    3212    209           