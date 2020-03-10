PGDMP                 	        x            tools    11.4    11.2 �   J           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            K           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false            L           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                       false            M           1262    57611    tools    DATABASE     �   CREATE DATABASE tools WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Spanish_Argentina.1252' LC_CTYPE = 'Spanish_Argentina.1252';
    DROP DATABASE tools;
             postgres    false                        2615    65782    alm    SCHEMA        CREATE SCHEMA alm;
    DROP SCHEMA alm;
             postgres    false                        2615    57746    core    SCHEMA        CREATE SCHEMA core;
    DROP SCHEMA core;
             postgres    false            
            2615    164239    fis    SCHEMA        CREATE SCHEMA fis;
    DROP SCHEMA fis;
             postgres    false                        2615    57752    frm    SCHEMA        CREATE SCHEMA frm;
    DROP SCHEMA frm;
             postgres    false                        2615    115082    log    SCHEMA        CREATE SCHEMA log;
    DROP SCHEMA log;
             postgres    false                        2615    57612    prd    SCHEMA        CREATE SCHEMA prd;
    DROP SCHEMA prd;
             postgres    false                        2615    115083    sma    SCHEMA        CREATE SCHEMA sma;
    DROP SCHEMA sma;
             postgres    false            >           1255    82210 /   agregar_lote_articulo(bigint, double precision)    FUNCTION     ~  CREATE FUNCTION alm.agregar_lote_articulo(p_batch_id bigint, p_cantidad double precision) RETURNS character varying
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
       alm       postgres    false    13            F           1255    106975 ;   ajuste_detalle_ingresar(integer, integer, double precision)    FUNCTION     �  CREATE FUNCTION alm.ajuste_detalle_ingresar(p_ajus_id integer, p_lote_id integer, p_cantidad double precision) RETURNS integer
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
       alm       postgres    false    13            /           1255    82203 j   crear_lote_articulo(integer, integer, integer, character varying, double precision, date, integer, bigint)    FUNCTION       CREATE FUNCTION alm.crear_lote_articulo(p_prov_id integer, p_arti_id integer, p_depo_id integer, p_codigo character varying, p_cantidad double precision, p_fec_vencimiento date, p_empr_id integer, p_batch_id bigint) RETURNS character varying
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
       alm       postgres    false    13            <           1255    82207 /   extraer_lote_articulo(bigint, double precision)    FUNCTION     �  CREATE FUNCTION alm.extraer_lote_articulo(p_batch_id bigint, p_cantidad double precision) RETURNS character varying
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
       alm       postgres    false    13            =           1255    82205     obtener_existencia_batch(bigint)    FUNCTION     t  CREATE FUNCTION alm.obtener_existencia_batch(p_batch_id bigint) RETURNS double precision
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
       alm       postgres    false    13            ?           1255    74922    log(character varying) 	   PROCEDURE     *  CREATE PROCEDURE core.log(p_msg character varying)
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
       core       postgres    false    8            D           1255    115122    set_tabla_id_trg()    FUNCTION     �  CREATE FUNCTION core.set_tabla_id_trg() RETURNS trigger
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
       core       postgres    false    8            @           1255    98704    asociar_lote_hijo_trg()    FUNCTION     �
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
       prd       postgres    false    11            E           1255    98706 m   cambiar_recipiente(bigint, integer, integer, integer, character varying, character varying, double precision)    FUNCTION     �  CREATE FUNCTION prd.cambiar_recipiente(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision DEFAULT 0) RETURNS character varying
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
       prd       postgres    false    11            C           1255    98670 �   crear_lote(character varying, integer, integer, bigint, double precision, double precision, character varying, integer, integer, character varying, integer, character varying, date, integer, character varying)    FUNCTION     �   CREATE FUNCTION prd.crear_lote(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying DEFAULT 'false'::character varying, p_fec_vencimiento date DEFAULT NULL::date, p_recu_id integer DEFAULT NULL::integer, p_tipo_recurso character varying DEFAULT NULL::character varying) RETURNS character varying
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
       prd       postgres    false    11            A           1255    82227    crear_prd_recurso_trg()    FUNCTION     w  CREATE FUNCTION prd.crear_prd_recurso_trg() RETURNS trigger
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
       prd       postgres    false    11            B           1255    82228    eliminar_prd_recurso_trg()    FUNCTION     -  CREATE FUNCTION prd.eliminar_prd_recurso_trg() RETURNS trigger
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
       prd       postgres    false    11                       1259    106906    ajustes    TABLE     +  CREATE TABLE alm.ajustes (
    ajus_id integer NOT NULL,
    tipo_ajuste character varying,
    justificacion character varying,
    usuario_app character varying,
    empr_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE alm.ajustes;
       alm         postgres    false    13                       1259    106904    ajustes_ajus_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.ajustes_ajus_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE alm.ajustes_ajus_id_seq;
       alm       postgres    false    13    261            N           0    0    ajustes_ajus_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE alm.ajustes_ajus_id_seq OWNED BY alm.ajustes.ajus_id;
            alm       postgres    false    260            �            1259    74435    alm_articulos    TABLE     X  CREATE TABLE alm.alm_articulos (
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
       alm         postgres    false    13            �            1259    74433    alm_articulos_arti_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_articulos_arti_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE alm.alm_articulos_arti_id_seq;
       alm       postgres    false    222    13            O           0    0    alm_articulos_arti_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE alm.alm_articulos_arti_id_seq OWNED BY alm.alm_articulos.arti_id;
            alm       postgres    false    221            �            1259    74446    alm_depositos    TABLE     g  CREATE TABLE alm.alm_depositos (
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
       alm         postgres    false    13            �            1259    74444    alm_depositos_depo_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_depositos_depo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE alm.alm_depositos_depo_id_seq;
       alm       postgres    false    13    224            P           0    0    alm_depositos_depo_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE alm.alm_depositos_depo_id_seq OWNED BY alm.alm_depositos.depo_id;
            alm       postgres    false    223            �            1259    74617    alm_deta_entrega_materiales    TABLE     �  CREATE TABLE alm.alm_deta_entrega_materiales (
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
       alm         postgres    false    13            �            1259    74615 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq;
       alm       postgres    false    243    13            Q           0    0 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq OWNED BY alm.alm_deta_entrega_materiales.deen_id;
            alm       postgres    false    242            �            1259    74524    alm_deta_pedidos_materiales    TABLE     O  CREATE TABLE alm.alm_deta_pedidos_materiales (
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
       alm         postgres    false    13            �            1259    74522 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq;
       alm       postgres    false    13    234            R           0    0 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq OWNED BY alm.alm_deta_pedidos_materiales.depe_id;
            alm       postgres    false    233            �            1259    74403    alm_deta_recepcion_materiales    TABLE     �  CREATE TABLE alm.alm_deta_recepcion_materiales (
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
       alm         postgres    false    13            �            1259    74401 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 =   DROP SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq;
       alm       postgres    false    220    13            S           0    0 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE OWNED BY     q   ALTER SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq OWNED BY alm.alm_deta_recepcion_materiales.dere_id;
            alm       postgres    false    219            �            1259    74544    alm_entrega_materiales    TABLE     �  CREATE TABLE alm.alm_entrega_materiales (
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
       alm         postgres    false    13            �            1259    74542 "   alm_entrega_materiales_enma_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_entrega_materiales_enma_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE alm.alm_entrega_materiales_enma_id_seq;
       alm       postgres    false    236    13            T           0    0 "   alm_entrega_materiales_enma_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE alm.alm_entrega_materiales_enma_id_seq OWNED BY alm.alm_entrega_materiales.enma_id;
            alm       postgres    false    235            �            1259    74562 	   alm_lotes    TABLE       CREATE TABLE alm.alm_lotes (
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
       alm         postgres    false    13            �            1259    74560    alm_lotes_lote_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_lotes_lote_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE alm.alm_lotes_lote_id_seq;
       alm       postgres    false    238    13            U           0    0    alm_lotes_lote_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE alm.alm_lotes_lote_id_seq OWNED BY alm.alm_lotes.lote_id;
            alm       postgres    false    237            �            1259    74465    alm_pedidos_materiales    TABLE     �  CREATE TABLE alm.alm_pedidos_materiales (
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
       alm         postgres    false    13            �            1259    74463 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_pedidos_materiales_pema_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE alm.alm_pedidos_materiales_pema_id_seq;
       alm       postgres    false    13    226            V           0    0 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE alm.alm_pedidos_materiales_pema_id_seq OWNED BY alm.alm_pedidos_materiales.pema_id;
            alm       postgres    false    225            �            1259    74483    alm_proveedores    TABLE       CREATE TABLE alm.alm_proveedores (
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
       alm         postgres    false    13            �            1259    74585    alm_proveedores_articulos    TABLE     k   CREATE TABLE alm.alm_proveedores_articulos (
    prov_id integer NOT NULL,
    arti_id integer NOT NULL
);
 *   DROP TABLE alm.alm_proveedores_articulos;
       alm         postgres    false    13            �            1259    74481    alm_proveedores_prov_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_proveedores_prov_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE alm.alm_proveedores_prov_id_seq;
       alm       postgres    false    228    13            W           0    0    alm_proveedores_prov_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE alm.alm_proveedores_prov_id_seq OWNED BY alm.alm_proveedores.prov_id;
            alm       postgres    false    227            �            1259    74602    alm_recepcion_materiales    TABLE     h  CREATE TABLE alm.alm_recepcion_materiales (
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
       alm         postgres    false    13            �            1259    74600 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_recepcion_materiales_rema_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 8   DROP SEQUENCE alm.alm_recepcion_materiales_rema_id_seq;
       alm       postgres    false    241    13            X           0    0 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE OWNED BY     g   ALTER SEQUENCE alm.alm_recepcion_materiales_rema_id_seq OWNED BY alm.alm_recepcion_materiales.rema_id;
            alm       postgres    false    240                       1259    106938    deta_ajustes    TABLE       CREATE TABLE alm.deta_ajustes (
    deaj_id integer NOT NULL,
    cantidad double precision,
    empr_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER,
    lote_id integer,
    ajus_id integer NOT NULL
);
    DROP TABLE alm.deta_ajustes;
       alm         postgres    false    13                       1259    106936    deta_ajustes_deaj_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.deta_ajustes_deaj_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE alm.deta_ajustes_deaj_id_seq;
       alm       postgres    false    263    13            Y           0    0    deta_ajustes_deaj_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE alm.deta_ajustes_deaj_id_seq OWNED BY alm.deta_ajustes.deaj_id;
            alm       postgres    false    262            �            1259    74501    items    TABLE     G  CREATE TABLE alm.items (
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
       alm         postgres    false    13            �            1259    74499    items_item_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.items_item_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE alm.items_item_id_seq;
       alm       postgres    false    230    13            Z           0    0    items_item_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE alm.items_item_id_seq OWNED BY alm.items.item_id;
            alm       postgres    false    229            �            1259    74514 
   utl_tablas    TABLE       CREATE TABLE alm.utl_tablas (
    tabl_id integer NOT NULL,
    tabla character varying(50),
    valor character varying(50),
    descripcion character varying(200),
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
    DROP TABLE alm.utl_tablas;
       alm         postgres    false    13            �            1259    74512    utl_tablas_tabl_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.utl_tablas_tabl_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE alm.utl_tablas_tabl_id_seq;
       alm       postgres    false    13    232            [           0    0    utl_tablas_tabl_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE alm.utl_tablas_tabl_id_seq OWNED BY alm.utl_tablas.tabl_id;
            alm       postgres    false    231                       1259    115211    departamentos    TABLE     �   CREATE TABLE core.departamentos (
    depa_id integer NOT NULL,
    nombre character varying NOT NULL,
    descripcion character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE core.departamentos;
       core         postgres    false    8                       1259    115209    departamentos_depa_id_seq    SEQUENCE     �   CREATE SEQUENCE core.departamentos_depa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE core.departamentos_depa_id_seq;
       core       postgres    false    8    270            \           0    0    departamentos_depa_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE core.departamentos_depa_id_seq OWNED BY core.departamentos.depa_id;
            core       postgres    false    269            �            1259    74708    empresas    TABLE     �  CREATE TABLE core.empresas (
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
       core       postgres    false    8    247            ]           0    0    empresas_empr_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE core.empresas_empr_id_seq OWNED BY core.empresas.empr_id;
            core       postgres    false    246            �            1259    98621    equipos    TABLE     X  CREATE TABLE core.equipos (
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
       core       postgres    false    8    254            ^           0    0    equipos_equi_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE core.equipos_equi_id_seq OWNED BY core.equipos.equi_id;
            core       postgres    false    253            �            1259    74914    log    TABLE     S   CREATE TABLE core.log (
    msg character varying,
    fecha date DEFAULT now()
);
    DROP TABLE core.log;
       core         postgres    false    8                       1259    123290 	   snapshots    TABLE     �   CREATE TABLE core.snapshots (
    id integer NOT NULL,
    snap_id character varying,
    data text,
    fec_alta date DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
    DROP TABLE core.snapshots;
       core         postgres    false    8                       1259    123288    snapshots_id_seq    SEQUENCE     �   CREATE SEQUENCE core.snapshots_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE core.snapshots_id_seq;
       core       postgres    false    287    8            _           0    0    snapshots_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE core.snapshots_id_seq OWNED BY core.snapshots.id;
            core       postgres    false    286                       1259    115109    tablas    TABLE     �  CREATE TABLE core.tablas (
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
       core         postgres    false    8                       1259    98651    transportistas    TABLE       CREATE TABLE core.transportistas (
    cuit character varying NOT NULL,
    razon_social character varying NOT NULL,
    direccion character varying(500) NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
     DROP TABLE core.transportistas;
       core         postgres    false    8                        1259    123300    transportistas_tipo_residuos    TABLE     �   CREATE TABLE core.transportistas_tipo_residuos (
    tran_id integer NOT NULL,
    tire_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
 .   DROP TABLE core.transportistas_tipo_residuos;
       core         postgres    false    8                       1259    115192    zonas    TABLE     r  CREATE TABLE core.zonas (
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
       core         postgres    false    8                       1259    115190    zonas_zona_id_seq    SEQUENCE     �   CREATE SEQUENCE core.zonas_zona_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE core.zonas_zona_id_seq;
       core       postgres    false    268    8            `           0    0    zonas_zona_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE core.zonas_zona_id_seq OWNED BY core.zonas.zona_id;
            core       postgres    false    267            .           1259    164242    actas_infraccion    TABLE     �  CREATE TABLE fis.actas_infraccion (
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
       fis         postgres    false    10            -           1259    164240    acta_infraccion_acin_id_seq    SEQUENCE     �   CREATE SEQUENCE fis.acta_infraccion_acin_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE fis.acta_infraccion_acin_id_seq;
       fis       postgres    false    10    302            a           0    0    acta_infraccion_acin_id_seq    SEQUENCE OWNED BY     V   ALTER SEQUENCE fis.acta_infraccion_acin_id_seq OWNED BY fis.actas_infraccion.acin_id;
            fis       postgres    false    301            �            1259    57782    formularios    TABLE        CREATE TABLE frm.formularios (
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
       frm       postgres    false    214    6            b           0    0    formularios_form_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE frm.formularios_form_id_seq OWNED BY frm.formularios.form_id;
            frm       postgres    false    213            �            1259    57799    instancias_items    TABLE     �  CREATE TABLE frm.instancias_items (
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
       frm       postgres    false    216    6            c           0    0    instancias_items_init_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE frm.instancias_items_init_id_seq OWNED BY frm.instancias_items.init_id;
            frm       postgres    false    215            �            1259    57818    items    TABLE     G  CREATE TABLE frm.items (
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
       frm       postgres    false    218    6            d           0    0    items_item_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE frm.items_item_id_seq OWNED BY frm.items.item_id;
            frm       postgres    false    217                       1259    115360    choferes    TABLE     �  CREATE TABLE log.choferes (
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
       log         postgres    false    5                       1259    115358    choferes_chof_id_seq    SEQUENCE     �   CREATE SEQUENCE log.choferes_chof_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE log.choferes_chof_id_seq;
       log       postgres    false    279    5            e           0    0    choferes_chof_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE log.choferes_chof_id_seq OWNED BY log.choferes.chof_id;
            log       postgres    false    278                       1259    115230 	   circuitos    TABLE     b  CREATE TABLE log.circuitos (
    circ_id integer NOT NULL,
    codigo character varying,
    descripcion character varying,
    imagen bytea,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    chof_id integer,
    vehi_id integer,
    zona_id integer
);
    DROP TABLE log.circuitos;
       log         postgres    false    5                       1259    115228    circuitos_circu_id_seq    SEQUENCE     �   CREATE SEQUENCE log.circuitos_circu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE log.circuitos_circu_id_seq;
       log       postgres    false    272    5            f           0    0    circuitos_circu_id_seq    SEQUENCE OWNED BY     J   ALTER SEQUENCE log.circuitos_circu_id_seq OWNED BY log.circuitos.circ_id;
            log       postgres    false    271                       1259    115416    circuitos_puntos_criticos    TABLE     �   CREATE TABLE log.circuitos_puntos_criticos (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    circ_id integer NOT NULL,
    pucr_id integer NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL
);
 *   DROP TABLE log.circuitos_puntos_criticos;
       log         postgres    false    5                       1259    115274    contenedores    TABLE     �  CREATE TABLE log.contenedores (
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
    reci_id integer NOT NULL,
    anio_elaboracion date DEFAULT now()
);
    DROP TABLE log.contenedores;
       log         postgres    false    5                       1259    115272    containers_cont_id_seq    SEQUENCE     �   CREATE SEQUENCE log.containers_cont_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE log.containers_cont_id_seq;
       log       postgres    false    5    274            g           0    0    containers_cont_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE log.containers_cont_id_seq OWNED BY log.contenedores.cont_id;
            log       postgres    false    273            '           1259    139700    contenedores_entregados    TABLE     �  CREATE TABLE log.contenedores_entregados (
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
    tica_id character varying
);
 (   DROP TABLE log.contenedores_entregados;
       log         postgres    false    5            &           1259    139698 #   contenedores_entregados_coen_id_seq    SEQUENCE     �   CREATE SEQUENCE log.contenedores_entregados_coen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE log.contenedores_entregados_coen_id_seq;
       log       postgres    false    295    5            h           0    0 #   contenedores_entregados_coen_id_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE log.contenedores_entregados_coen_id_seq OWNED BY log.contenedores_entregados.coen_id;
            log       postgres    false    294                       1259    115527    deta_solicitudes_contenedor    TABLE     0  CREATE TABLE log.deta_solicitudes_contenedor (
    desc_id integer NOT NULL,
    cantidad integer NOT NULL,
    otro character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying NOT NULL,
    usuario_app character varying NOT NULL,
    tica_id character varying NOT NULL
);
 ,   DROP TABLE log.deta_solicitudes_contenedor;
       log         postgres    false    5                       1259    115525 '   deta_solicitudes_contenedor_desc_id_seq    SEQUENCE     �   CREATE SEQUENCE log.deta_solicitudes_contenedor_desc_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE log.deta_solicitudes_contenedor_desc_id_seq;
       log       postgres    false    284    5            i           0    0 '   deta_solicitudes_contenedor_desc_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE log.deta_solicitudes_contenedor_desc_id_seq OWNED BY log.deta_solicitudes_contenedor.desc_id;
            log       postgres    false    283            )           1259    147852    incidencias    TABLE     ]   CREATE TABLE log.incidencias (
    inci_id integer NOT NULL,
    ortr_id integer NOT NULL
);
    DROP TABLE log.incidencias;
       log         postgres    false    5            (           1259    147850    incidencias_inci_id_seq    SEQUENCE     �   CREATE SEQUENCE log.incidencias_inci_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE log.incidencias_inci_id_seq;
       log       postgres    false    5    297            j           0    0    incidencias_inci_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE log.incidencias_inci_id_seq OWNED BY log.incidencias.inci_id;
            log       postgres    false    296            %           1259    139666    ordenes_transporte    TABLE     �  CREATE TABLE log.ordenes_transporte (
    ortr_id integer NOT NULL,
    fec_retiro date NOT NULL,
    estado character varying NOT NULL,
    caseid character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    difi_id character varying NOT NULL,
    sotr_id integer NOT NULL,
    equi_id integer NOT NULL,
    chof_id character varying NOT NULL,
    CONSTRAINT ordenes_transporte_check CHECK ((((estado)::text = 'EN_TRANSITO'::text) OR ((estado)::text = 'INGRESADO'::text) OR ((estado)::text = 'DESCARGADO'::text) OR ((estado)::text = 'INFRACCION'::text) OR ((estado)::text = 'EGRESADO'::text)))
);
 #   DROP TABLE log.ordenes_transporte;
       log         postgres    false    5            $           1259    139664    ordenes_transporte_ortr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.ordenes_transporte_ortr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE log.ordenes_transporte_ortr_id_seq;
       log       postgres    false    5    293            k           0    0    ordenes_transporte_ortr_id_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE log.ordenes_transporte_ortr_id_seq OWNED BY log.ordenes_transporte.ortr_id;
            log       postgres    false    292                       1259    115325    puntos_criticos    TABLE     �  CREATE TABLE log.puntos_criticos (
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
       log         postgres    false    5                       1259    115323    puntos_criticos_pucr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.puntos_criticos_pucr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE log.puntos_criticos_pucr_id_seq;
       log       postgres    false    5    277            l           0    0    puntos_criticos_pucr_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE log.puntos_criticos_pucr_id_seq OWNED BY log.puntos_criticos.pucr_id;
            log       postgres    false    276                       1259    115453    solicitantes_transporte    TABLE     n  CREATE TABLE log.solicitantes_transporte (
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
    eliminado integer DEFAULT 0 NOT NULL,
    depa_id integer
);
 (   DROP TABLE log.solicitantes_transporte;
       log         postgres    false    5                       1259    115451 #   solicitantes_transporte_sotr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitantes_transporte_sotr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE log.solicitantes_transporte_sotr_id_seq;
       log       postgres    false    5    282            m           0    0 #   solicitantes_transporte_sotr_id_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE log.solicitantes_transporte_sotr_id_seq OWNED BY log.solicitantes_transporte.sotr_id;
            log       postgres    false    281            #           1259    139660    solicitudes_contenedores    TABLE     L   CREATE TABLE log.solicitudes_contenedores (
    soco_id integer NOT NULL
);
 )   DROP TABLE log.solicitudes_contenedores;
       log         postgres    false    5            "           1259    139658 $   solicitudes_contenedores_soco_id_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitudes_contenedores_soco_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 8   DROP SEQUENCE log.solicitudes_contenedores_soco_id_seq;
       log       postgres    false    291    5            n           0    0 $   solicitudes_contenedores_soco_id_seq    SEQUENCE OWNED BY     g   ALTER SEQUENCE log.solicitudes_contenedores_soco_id_seq OWNED BY log.solicitudes_contenedores.soco_id;
            log       postgres    false    290            *           1259    147858    solicitudes_retiro_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitudes_retiro_seq
    START WITH 6
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;
 *   DROP SEQUENCE log.solicitudes_retiro_seq;
       log       postgres    false    5                       1259    115548    solicitudes_retiro    TABLE     /  CREATE TABLE log.solicitudes_retiro (
    sore_id integer DEFAULT nextval('log.solicitudes_retiro_seq'::regclass) NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    sotr_id integer NOT NULL
);
 #   DROP TABLE log.solicitudes_retiro;
       log         postgres    false    298    5                       1259    115299    tipos_carga_circuitos    TABLE     �   CREATE TABLE log.tipos_carga_circuitos (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    circ_id integer NOT NULL,
    tica_id character varying NOT NULL
);
 &   DROP TABLE log.tipos_carga_circuitos;
       log         postgres    false    5            !           1259    123308    tipos_carga_transportistas    TABLE     �   CREATE TABLE log.tipos_carga_transportistas (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    tran_id integer NOT NULL,
    tica_id character varying NOT NULL
);
 +   DROP TABLE log.tipos_carga_transportistas;
       log         postgres    false    5            
           1259    115162    transportistas    TABLE     o  CREATE TABLE log.transportistas (
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
    cuit character varying(13)
);
    DROP TABLE log.transportistas;
       log         postgres    false    5            	           1259    115160    transportistas_tran_id_seq    SEQUENCE     �   CREATE SEQUENCE log.transportistas_tran_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE log.transportistas_tran_id_seq;
       log       postgres    false    266    5            o           0    0    transportistas_tran_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE log.transportistas_tran_id_seq OWNED BY log.transportistas.tran_id;
            log       postgres    false    265            �            1259    57723    costos    TABLE       CREATE TABLE prd.costos (
    fec_vigencia date NOT NULL,
    valor money NOT NULL,
    umed character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    recu_id integer NOT NULL,
    empr_id integer
);
    DROP TABLE prd.costos;
       prd         postgres    false    11            �            1259    98636    empaque    TABLE     N  CREATE TABLE prd.empaque (
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
       prd         postgres    false    11            p           0    0    COLUMN empaque.eliminado    COMMENT     4   COMMENT ON COLUMN prd.empaque.eliminado IS 'false';
            prd       postgres    false    255                        1259    98639    empaque_empa_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.empaque_empa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE prd.empaque_empa_id_seq;
       prd       postgres    false    255    11            q           0    0    empaque_empa_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE prd.empaque_empa_id_seq OWNED BY prd.empaque.empa_id;
            prd       postgres    false    256            �            1259    74635    establecimientos    TABLE     r  CREATE TABLE prd.establecimientos (
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
       prd         postgres    false    11            �            1259    74633    establecimientos_esta_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.establecimientos_esta_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE prd.establecimientos_esta_id_seq;
       prd       postgres    false    11    245            r           0    0    establecimientos_esta_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE prd.establecimientos_esta_id_seq OWNED BY prd.establecimientos.esta_id;
            prd       postgres    false    244            �            1259    57630    etapas    TABLE     �  CREATE TABLE prd.etapas (
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
       prd         postgres    false    11            �            1259    57628    etapas_etap_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.etapas_etap_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE prd.etapas_etap_id_seq;
       prd       postgres    false    205    11            s           0    0    etapas_etap_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE prd.etapas_etap_id_seq OWNED BY prd.etapas.etap_id;
            prd       postgres    false    204            +           1259    147874    etapas_materiales    TABLE     c   CREATE TABLE prd.etapas_materiales (
    etap_id integer NOT NULL,
    arti_id integer NOT NULL
);
 "   DROP TABLE prd.etapas_materiales;
       prd         postgres    false    11            ,           1259    147885    etapas_productos    TABLE     b   CREATE TABLE prd.etapas_productos (
    etap_id integer NOT NULL,
    arti_id integer NOT NULL
);
 !   DROP TABLE prd.etapas_productos;
       prd         postgres    false    11                       1259    98674    fraccionamientos    TABLE       CREATE TABLE prd.fraccionamientos (
    frac_id integer NOT NULL,
    recu_id integer NOT NULL,
    empa_id integer NOT NULL,
    cantidad double precision NOT NULL,
    fecha date DEFAULT now() NOT NULL,
    eliminado boolean DEFAULT false NOT NULL,
    empr_id integer NOT NULL
);
 !   DROP TABLE prd.fraccionamientos;
       prd         postgres    false    11                       1259    98672    fraccionamientos_frac_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.fraccionamientos_frac_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE prd.fraccionamientos_frac_id_seq;
       prd       postgres    false    11    259            t           0    0    fraccionamientos_frac_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE prd.fraccionamientos_frac_id_seq OWNED BY prd.fraccionamientos.frac_id;
            prd       postgres    false    258            �            1259    57652    lotes    TABLE     �  CREATE TABLE prd.lotes (
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
       prd         postgres    false    11            �            1259    57650    lotes_batch_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.lotes_batch_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE prd.lotes_batch_id_seq;
       prd       postgres    false    11    207            u           0    0    lotes_batch_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE prd.lotes_batch_id_seq OWNED BY prd.lotes.batch_id;
            prd       postgres    false    206            �            1259    57700    lotes_hijos    TABLE     Y  CREATE TABLE prd.lotes_hijos (
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
       prd         postgres    false    11            �            1259    74786    movimientos_trasportes    TABLE     �  CREATE TABLE prd.movimientos_trasportes (
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
       prd         postgres    false    11            �            1259    74784 "   movimientos_trasportes_motr_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.movimientos_trasportes_motr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE prd.movimientos_trasportes_motr_id_seq;
       prd       postgres    false    250    11            v           0    0 "   movimientos_trasportes_motr_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE prd.movimientos_trasportes_motr_id_seq OWNED BY prd.movimientos_trasportes.motr_id;
            prd       postgres    false    249            �            1259    57615    procesos    TABLE     �   CREATE TABLE prd.procesos (
    proc_id integer NOT NULL,
    nombre character varying NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    empr_id integer
);
    DROP TABLE prd.procesos;
       prd         postgres    false    11            �            1259    57613    productos_prod_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.productos_prod_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE prd.productos_prod_id_seq;
       prd       postgres    false    11    203            w           0    0    productos_prod_id_seq    SEQUENCE OWNED BY     H   ALTER SEQUENCE prd.productos_prod_id_seq OWNED BY prd.procesos.proc_id;
            prd       postgres    false    202            �            1259    74759    recipientes    TABLE     �  CREATE TABLE prd.recipientes (
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
       prd         postgres    false    11            �            1259    74867    recipiente_reci_id_seq    SEQUENCE     |   CREATE SEQUENCE prd.recipiente_reci_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE prd.recipiente_reci_id_seq;
       prd       postgres    false    11    248            x           0    0    recipiente_reci_id_seq    SEQUENCE OWNED BY     L   ALTER SEQUENCE prd.recipiente_reci_id_seq OWNED BY prd.recipientes.reci_id;
            prd       postgres    false    251            �            1259    57670    recursos    TABLE     E  CREATE TABLE prd.recursos (
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
       prd         postgres    false    11            �            1259    57682    recursos_lotes    TABLE     H  CREATE TABLE prd.recursos_lotes (
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
       prd         postgres    false    11            �            1259    57668    recursos_recu_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.recursos_recu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE prd.recursos_recu_id_seq;
       prd       postgres    false    11    209            y           0    0    recursos_recu_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE prd.recursos_recu_id_seq OWNED BY prd.recursos.recu_id;
            prd       postgres    false    208            i           2604    106909    ajustes ajus_id    DEFAULT     l   ALTER TABLE ONLY alm.ajustes ALTER COLUMN ajus_id SET DEFAULT nextval('alm.ajustes_ajus_id_seq'::regclass);
 ;   ALTER TABLE alm.ajustes ALTER COLUMN ajus_id DROP DEFAULT;
       alm       postgres    false    260    261    261                       2604    74438    alm_articulos arti_id    DEFAULT     x   ALTER TABLE ONLY alm.alm_articulos ALTER COLUMN arti_id SET DEFAULT nextval('alm.alm_articulos_arti_id_seq'::regclass);
 A   ALTER TABLE alm.alm_articulos ALTER COLUMN arti_id DROP DEFAULT;
       alm       postgres    false    222    221    222                       2604    74449    alm_depositos depo_id    DEFAULT     x   ALTER TABLE ONLY alm.alm_depositos ALTER COLUMN depo_id SET DEFAULT nextval('alm.alm_depositos_depo_id_seq'::regclass);
 A   ALTER TABLE alm.alm_depositos ALTER COLUMN depo_id DROP DEFAULT;
       alm       postgres    false    223    224    224            J           2604    74620 #   alm_deta_entrega_materiales deen_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_entrega_materiales ALTER COLUMN deen_id SET DEFAULT nextval('alm.alm_deta_entrega_materiales_deen_id_seq'::regclass);
 O   ALTER TABLE alm.alm_deta_entrega_materiales ALTER COLUMN deen_id DROP DEFAULT;
       alm       postgres    false    243    242    243            9           2604    74527 #   alm_deta_pedidos_materiales depe_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales ALTER COLUMN depe_id SET DEFAULT nextval('alm.alm_deta_pedidos_materiales_depe_id_seq'::regclass);
 O   ALTER TABLE alm.alm_deta_pedidos_materiales ALTER COLUMN depe_id DROP DEFAULT;
       alm       postgres    false    234    233    234                       2604    74406 %   alm_deta_recepcion_materiales dere_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales ALTER COLUMN dere_id SET DEFAULT nextval('alm.alm_deta_recepcion_materiales_dere_id_seq'::regclass);
 Q   ALTER TABLE alm.alm_deta_recepcion_materiales ALTER COLUMN dere_id DROP DEFAULT;
       alm       postgres    false    219    220    220            <           2604    74547    alm_entrega_materiales enma_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_entrega_materiales ALTER COLUMN enma_id SET DEFAULT nextval('alm.alm_entrega_materiales_enma_id_seq'::regclass);
 J   ALTER TABLE alm.alm_entrega_materiales ALTER COLUMN enma_id DROP DEFAULT;
       alm       postgres    false    236    235    236            B           2604    74565    alm_lotes lote_id    DEFAULT     p   ALTER TABLE ONLY alm.alm_lotes ALTER COLUMN lote_id SET DEFAULT nextval('alm.alm_lotes_lote_id_seq'::regclass);
 =   ALTER TABLE alm.alm_lotes ALTER COLUMN lote_id DROP DEFAULT;
       alm       postgres    false    237    238    238            %           2604    74468    alm_pedidos_materiales pema_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_pedidos_materiales ALTER COLUMN pema_id SET DEFAULT nextval('alm.alm_pedidos_materiales_pema_id_seq'::regclass);
 J   ALTER TABLE alm.alm_pedidos_materiales ALTER COLUMN pema_id DROP DEFAULT;
       alm       postgres    false    226    225    226            +           2604    74486    alm_proveedores prov_id    DEFAULT     |   ALTER TABLE ONLY alm.alm_proveedores ALTER COLUMN prov_id SET DEFAULT nextval('alm.alm_proveedores_prov_id_seq'::regclass);
 C   ALTER TABLE alm.alm_proveedores ALTER COLUMN prov_id DROP DEFAULT;
       alm       postgres    false    227    228    228            G           2604    74605     alm_recepcion_materiales rema_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_recepcion_materiales ALTER COLUMN rema_id SET DEFAULT nextval('alm.alm_recepcion_materiales_rema_id_seq'::regclass);
 L   ALTER TABLE alm.alm_recepcion_materiales ALTER COLUMN rema_id DROP DEFAULT;
       alm       postgres    false    241    240    241            l           2604    106941    deta_ajustes deaj_id    DEFAULT     v   ALTER TABLE ONLY alm.deta_ajustes ALTER COLUMN deaj_id SET DEFAULT nextval('alm.deta_ajustes_deaj_id_seq'::regclass);
 @   ALTER TABLE alm.deta_ajustes ALTER COLUMN deaj_id DROP DEFAULT;
       alm       postgres    false    262    263    263            3           2604    74504    items item_id    DEFAULT     h   ALTER TABLE ONLY alm.items ALTER COLUMN item_id SET DEFAULT nextval('alm.items_item_id_seq'::regclass);
 9   ALTER TABLE alm.items ALTER COLUMN item_id DROP DEFAULT;
       alm       postgres    false    230    229    230            6           2604    74517    utl_tablas tabl_id    DEFAULT     r   ALTER TABLE ONLY alm.utl_tablas ALTER COLUMN tabl_id SET DEFAULT nextval('alm.utl_tablas_tabl_id_seq'::regclass);
 >   ALTER TABLE alm.utl_tablas ALTER COLUMN tabl_id DROP DEFAULT;
       alm       postgres    false    232    231    232            z           2604    115214    departamentos depa_id    DEFAULT     z   ALTER TABLE ONLY core.departamentos ALTER COLUMN depa_id SET DEFAULT nextval('core.departamentos_depa_id_seq'::regclass);
 B   ALTER TABLE core.departamentos ALTER COLUMN depa_id DROP DEFAULT;
       core       postgres    false    270    269    270            O           2604    74711    empresas empr_id    DEFAULT     p   ALTER TABLE ONLY core.empresas ALTER COLUMN empr_id SET DEFAULT nextval('core.empresas_empr_id_seq'::regclass);
 =   ALTER TABLE core.empresas ALTER COLUMN empr_id DROP DEFAULT;
       core       postgres    false    247    246    247            ]           2604    98624    equipos equi_id    DEFAULT     n   ALTER TABLE ONLY core.equipos ALTER COLUMN equi_id SET DEFAULT nextval('core.equipos_equi_id_seq'::regclass);
 <   ALTER TABLE core.equipos ALTER COLUMN equi_id DROP DEFAULT;
       core       postgres    false    254    253    254            �           2604    123293    snapshots id    DEFAULT     h   ALTER TABLE ONLY core.snapshots ALTER COLUMN id SET DEFAULT nextval('core.snapshots_id_seq'::regclass);
 9   ALTER TABLE core.snapshots ALTER COLUMN id DROP DEFAULT;
       core       postgres    false    287    286    287            v           2604    115195    zonas zona_id    DEFAULT     j   ALTER TABLE ONLY core.zonas ALTER COLUMN zona_id SET DEFAULT nextval('core.zonas_zona_id_seq'::regclass);
 :   ALTER TABLE core.zonas ALTER COLUMN zona_id DROP DEFAULT;
       core       postgres    false    268    267    268            �           2604    164245    actas_infraccion acin_id    DEFAULT     }   ALTER TABLE ONLY fis.actas_infraccion ALTER COLUMN acin_id SET DEFAULT nextval('fis.acta_infraccion_acin_id_seq'::regclass);
 D   ALTER TABLE fis.actas_infraccion ALTER COLUMN acin_id DROP DEFAULT;
       fis       postgres    false    302    301    302            
           2604    57785    formularios form_id    DEFAULT     t   ALTER TABLE ONLY frm.formularios ALTER COLUMN form_id SET DEFAULT nextval('frm.formularios_form_id_seq'::regclass);
 ?   ALTER TABLE frm.formularios ALTER COLUMN form_id DROP DEFAULT;
       frm       postgres    false    214    213    214                       2604    57802    instancias_items init_id    DEFAULT     ~   ALTER TABLE ONLY frm.instancias_items ALTER COLUMN init_id SET DEFAULT nextval('frm.instancias_items_init_id_seq'::regclass);
 D   ALTER TABLE frm.instancias_items ALTER COLUMN init_id DROP DEFAULT;
       frm       postgres    false    215    216    216                       2604    57821    items item_id    DEFAULT     h   ALTER TABLE ONLY frm.items ALTER COLUMN item_id SET DEFAULT nextval('frm.items_item_id_seq'::regclass);
 9   ALTER TABLE frm.items ALTER COLUMN item_id DROP DEFAULT;
       frm       postgres    false    218    217    218            �           2604    115363    choferes chof_id    DEFAULT     n   ALTER TABLE ONLY log.choferes ALTER COLUMN chof_id SET DEFAULT nextval('log.choferes_chof_id_seq'::regclass);
 <   ALTER TABLE log.choferes ALTER COLUMN chof_id DROP DEFAULT;
       log       postgres    false    278    279    279            }           2604    115233    circuitos circ_id    DEFAULT     q   ALTER TABLE ONLY log.circuitos ALTER COLUMN circ_id SET DEFAULT nextval('log.circuitos_circu_id_seq'::regclass);
 =   ALTER TABLE log.circuitos ALTER COLUMN circ_id DROP DEFAULT;
       log       postgres    false    272    271    272            �           2604    115277    contenedores cont_id    DEFAULT     t   ALTER TABLE ONLY log.contenedores ALTER COLUMN cont_id SET DEFAULT nextval('log.containers_cont_id_seq'::regclass);
 @   ALTER TABLE log.contenedores ALTER COLUMN cont_id DROP DEFAULT;
       log       postgres    false    273    274    274            �           2604    139703    contenedores_entregados coen_id    DEFAULT     �   ALTER TABLE ONLY log.contenedores_entregados ALTER COLUMN coen_id SET DEFAULT nextval('log.contenedores_entregados_coen_id_seq'::regclass);
 K   ALTER TABLE log.contenedores_entregados ALTER COLUMN coen_id DROP DEFAULT;
       log       postgres    false    295    294    295            �           2604    115530 #   deta_solicitudes_contenedor desc_id    DEFAULT     �   ALTER TABLE ONLY log.deta_solicitudes_contenedor ALTER COLUMN desc_id SET DEFAULT nextval('log.deta_solicitudes_contenedor_desc_id_seq'::regclass);
 O   ALTER TABLE log.deta_solicitudes_contenedor ALTER COLUMN desc_id DROP DEFAULT;
       log       postgres    false    284    283    284            �           2604    147855    incidencias inci_id    DEFAULT     t   ALTER TABLE ONLY log.incidencias ALTER COLUMN inci_id SET DEFAULT nextval('log.incidencias_inci_id_seq'::regclass);
 ?   ALTER TABLE log.incidencias ALTER COLUMN inci_id DROP DEFAULT;
       log       postgres    false    296    297    297            �           2604    139669    ordenes_transporte ortr_id    DEFAULT     �   ALTER TABLE ONLY log.ordenes_transporte ALTER COLUMN ortr_id SET DEFAULT nextval('log.ordenes_transporte_ortr_id_seq'::regclass);
 F   ALTER TABLE log.ordenes_transporte ALTER COLUMN ortr_id DROP DEFAULT;
       log       postgres    false    293    292    293            �           2604    115328    puntos_criticos pucr_id    DEFAULT     |   ALTER TABLE ONLY log.puntos_criticos ALTER COLUMN pucr_id SET DEFAULT nextval('log.puntos_criticos_pucr_id_seq'::regclass);
 C   ALTER TABLE log.puntos_criticos ALTER COLUMN pucr_id DROP DEFAULT;
       log       postgres    false    277    276    277            �           2604    115456    solicitantes_transporte sotr_id    DEFAULT     �   ALTER TABLE ONLY log.solicitantes_transporte ALTER COLUMN sotr_id SET DEFAULT nextval('log.solicitantes_transporte_sotr_id_seq'::regclass);
 K   ALTER TABLE log.solicitantes_transporte ALTER COLUMN sotr_id DROP DEFAULT;
       log       postgres    false    282    281    282            �           2604    139663     solicitudes_contenedores soco_id    DEFAULT     �   ALTER TABLE ONLY log.solicitudes_contenedores ALTER COLUMN soco_id SET DEFAULT nextval('log.solicitudes_contenedores_soco_id_seq'::regclass);
 L   ALTER TABLE log.solicitudes_contenedores ALTER COLUMN soco_id DROP DEFAULT;
       log       postgres    false    291    290    291            r           2604    115165    transportistas tran_id    DEFAULT     z   ALTER TABLE ONLY log.transportistas ALTER COLUMN tran_id SET DEFAULT nextval('log.transportistas_tran_id_seq'::regclass);
 B   ALTER TABLE log.transportistas ALTER COLUMN tran_id DROP DEFAULT;
       log       postgres    false    265    266    266            b           2604    98641    empaque empa_id    DEFAULT     l   ALTER TABLE ONLY prd.empaque ALTER COLUMN empa_id SET DEFAULT nextval('prd.empaque_empa_id_seq'::regclass);
 ;   ALTER TABLE prd.empaque ALTER COLUMN empa_id DROP DEFAULT;
       prd       postgres    false    256    255            M           2604    74638    establecimientos esta_id    DEFAULT     ~   ALTER TABLE ONLY prd.establecimientos ALTER COLUMN esta_id SET DEFAULT nextval('prd.establecimientos_esta_id_seq'::regclass);
 D   ALTER TABLE prd.establecimientos ALTER COLUMN esta_id DROP DEFAULT;
       prd       postgres    false    245    244    245            �           2604    57633    etapas etap_id    DEFAULT     j   ALTER TABLE ONLY prd.etapas ALTER COLUMN etap_id SET DEFAULT nextval('prd.etapas_etap_id_seq'::regclass);
 :   ALTER TABLE prd.etapas ALTER COLUMN etap_id DROP DEFAULT;
       prd       postgres    false    205    204    205            f           2604    98677    fraccionamientos frac_id    DEFAULT     ~   ALTER TABLE ONLY prd.fraccionamientos ALTER COLUMN frac_id SET DEFAULT nextval('prd.fraccionamientos_frac_id_seq'::regclass);
 D   ALTER TABLE prd.fraccionamientos ALTER COLUMN frac_id DROP DEFAULT;
       prd       postgres    false    259    258    259            �           2604    74731    lotes batch_id    DEFAULT     j   ALTER TABLE ONLY prd.lotes ALTER COLUMN batch_id SET DEFAULT nextval('prd.lotes_batch_id_seq'::regclass);
 :   ALTER TABLE prd.lotes ALTER COLUMN batch_id DROP DEFAULT;
       prd       postgres    false    206    207    207            X           2604    74789    movimientos_trasportes motr_id    DEFAULT     �   ALTER TABLE ONLY prd.movimientos_trasportes ALTER COLUMN motr_id SET DEFAULT nextval('prd.movimientos_trasportes_motr_id_seq'::regclass);
 J   ALTER TABLE prd.movimientos_trasportes ALTER COLUMN motr_id DROP DEFAULT;
       prd       postgres    false    250    249    250            �           2604    57618    procesos proc_id    DEFAULT     o   ALTER TABLE ONLY prd.procesos ALTER COLUMN proc_id SET DEFAULT nextval('prd.productos_prod_id_seq'::regclass);
 <   ALTER TABLE prd.procesos ALTER COLUMN proc_id DROP DEFAULT;
       prd       postgres    false    203    202    203            P           2604    74869    recipientes reci_id    DEFAULT     s   ALTER TABLE ONLY prd.recipientes ALTER COLUMN reci_id SET DEFAULT nextval('prd.recipiente_reci_id_seq'::regclass);
 ?   ALTER TABLE prd.recipientes ALTER COLUMN reci_id DROP DEFAULT;
       prd       postgres    false    251    248            �           2604    57673    recursos recu_id    DEFAULT     n   ALTER TABLE ONLY prd.recursos ALTER COLUMN recu_id SET DEFAULT nextval('prd.recursos_recu_id_seq'::regclass);
 <   ALTER TABLE prd.recursos ALTER COLUMN recu_id DROP DEFAULT;
       prd       postgres    false    209    208    209                      0    106906    ajustes 
   TABLE DATA               l   COPY alm.ajustes (ajus_id, tipo_ajuste, justificacion, usuario_app, empr_id, fec_alta, usuario) FROM stdin;
    alm       postgres    false    261            �          0    74435    alm_articulos 
   TABLE DATA               �   COPY alm.alm_articulos (arti_id, barcode, descripcion, costo, es_caja, cantidad_caja, punto_pedido, estado, unidad_medida, empr_id, es_loteado, fec_alta, eliminado, batch_id, tipo) FROM stdin;
    alm       postgres    false    222            �          0    74446    alm_depositos 
   TABLE DATA               �   COPY alm.alm_depositos (depo_id, descripcion, direccion, gps, estado, loca_id, pais_id, empr_id, fec_alta, eliminado, esta_id) FROM stdin;
    alm       postgres    false    224                      0    74617    alm_deta_entrega_materiales 
   TABLE DATA               �   COPY alm.alm_deta_entrega_materiales (deen_id, enma_id, cantidad, arti_id, prov_id, lote_id, depo_id, empr_id, precio, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    243                      0    74524    alm_deta_pedidos_materiales 
   TABLE DATA               �   COPY alm.alm_deta_pedidos_materiales (depe_id, cantidad, resto, fecha_entrega, fecha_entregado, pema_id, arti_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    234            �          0    74403    alm_deta_recepcion_materiales 
   TABLE DATA               �   COPY alm.alm_deta_recepcion_materiales (dere_id, cantidad, precio, empr_id, rema_id, lote_id, prov_id, arti_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    220                      0    74544    alm_entrega_materiales 
   TABLE DATA               �   COPY alm.alm_entrega_materiales (enma_id, fecha, solicitante, dni, comprobante, empr_id, pema_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    236                      0    74562 	   alm_lotes 
   TABLE DATA               �   COPY alm.alm_lotes (lote_id, prov_id, arti_id, depo_id, codigo, fec_vencimiento, cantidad, empr_id, user_id, estado, fec_alta, eliminado, batch_id) FROM stdin;
    alm       postgres    false    238            �          0    74465    alm_pedidos_materiales 
   TABLE DATA               �   COPY alm.alm_pedidos_materiales (pema_id, fecha, motivo_rechazo, justificacion, case_id, ortr_id, estado, empr_id, fec_alta, eliminado, batch_id) FROM stdin;
    alm       postgres    false    226            �          0    74483    alm_proveedores 
   TABLE DATA               w   COPY alm.alm_proveedores (prov_id, nombre, cuit, domicilio, telefono, email, empr_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    228                      0    74585    alm_proveedores_articulos 
   TABLE DATA               B   COPY alm.alm_proveedores_articulos (prov_id, arti_id) FROM stdin;
    alm       postgres    false    239            
          0    74602    alm_recepcion_materiales 
   TABLE DATA               }   COPY alm.alm_recepcion_materiales (rema_id, fecha, comprobante, empr_id, prov_id, fec_alta, eliminado, batch_id) FROM stdin;
    alm       postgres    false    241                       0    106938    deta_ajustes 
   TABLE DATA               d   COPY alm.deta_ajustes (deaj_id, cantidad, empr_id, fec_alta, usuario, lote_id, ajus_id) FROM stdin;
    alm       postgres    false    263            �          0    74501    items 
   TABLE DATA               �   COPY alm.items (item_id, label, name, requerido, tipo_dato, valo_id, orden, aux, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, form_id) FROM stdin;
    alm       postgres    false    230                      0    74514 
   utl_tablas 
   TABLE DATA               Z   COPY alm.utl_tablas (tabl_id, tabla, valor, descripcion, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    232            '          0    115211    departamentos 
   TABLE DATA               V   COPY core.departamentos (depa_id, nombre, descripcion, fec_alta, usuario) FROM stdin;
    core       postgres    false    270                      0    74708    empresas 
   TABLE DATA               �   COPY core.empresas (empr_id, descripcion, cuit, direccion, telefono, email, imagepath, loca_id, prov_id, pais_id, lat, lng, celular, zona_id, clie_id) FROM stdin;
    core       postgres    false    247                      0    98621    equipos 
   TABLE DATA               �  COPY core.equipos (equi_id, descripcion, marca, codigo, ubicacion, estado, fecha_ultimalectura, ultima_lectura, tipo_horas, valor_reposicion, fecha_reposicion, valor, comprobante, descrip_tecnica, numero_serie, adjunto, meta_disponibilidad, fecha_ingreso, fecha_baja, fecha_garantia, prov_id, empr_id, sect_id, ubic_id, grup_id, crit_id, unme_id, area_id, proc_id, tran_id, dominio) FROM stdin;
    core       postgres    false    254                      0    74914    log 
   TABLE DATA               '   COPY core.log (msg, fecha) FROM stdin;
    core       postgres    false    252            8          0    123290 	   snapshots 
   TABLE DATA               I   COPY core.snapshots (id, snap_id, data, fec_alta, eliminado) FROM stdin;
    core       postgres    false    287            !          0    115109    tablas 
   TABLE DATA               p   COPY core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) FROM stdin;
    core       postgres    false    264                      0    98651    transportistas 
   TABLE DATA               Z   COPY core.transportistas (cuit, razon_social, direccion, fec_alta, eliminado) FROM stdin;
    core       postgres    false    257            9          0    123300    transportistas_tipo_residuos 
   TABLE DATA               Y   COPY core.transportistas_tipo_residuos (tran_id, tire_id, fec_alta, usuario) FROM stdin;
    core       postgres    false    288            %          0    115192    zonas 
   TABLE DATA               w   COPY core.zonas (zona_id, nombre, descripcion, imagen, fec_alta, usuario, usuario_app, depa_id, eliminado) FROM stdin;
    core       postgres    false    268            G          0    164242    actas_infraccion 
   TABLE DATA               �   COPY fis.actas_infraccion (acin_id, numero_acta, descripcion, tipo, sotr_id, inspector_id, tran_id, destino, fecha_creacion, usuario_app, eliminado, usuario) FROM stdin;
    fis       postgres    false    302            �          0    57782    formularios 
   TABLE DATA               ^   COPY frm.formularios (form_id, nombre, descripcion, eliminado, fec_alta, usuario) FROM stdin;
    frm       postgres    false    214            �          0    57799    instancias_items 
   TABLE DATA               �   COPY frm.instancias_items (init_id, label, name, valor, requerido, tida_id, valo_id, info_id, form_id, orden, aux, eliminado, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, item_id) FROM stdin;
    frm       postgres    false    216            �          0    57818    items 
   TABLE DATA               �   COPY frm.items (item_id, label, name, requerido, tipo_dato, valo_id, orden, aux, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, form_id) FROM stdin;
    frm       postgres    false    218            0          0    115360    choferes 
   TABLE DATA               �   COPY log.choferes (chof_id, nombre, apellido, documento, fec_nacimiento, direccion, celular, codigo, carnet, vencimiento, habilitacion, imagen, fec_alta, usuario, tran_id, cach_id, eliminado) FROM stdin;
    log       postgres    false    279            )          0    115230 	   circuitos 
   TABLE DATA               �   COPY log.circuitos (circ_id, codigo, descripcion, imagen, fec_alta, usuario, usuario_app, chof_id, vehi_id, zona_id) FROM stdin;
    log       postgres    false    272            1          0    115416    circuitos_puntos_criticos 
   TABLE DATA               `   COPY log.circuitos_puntos_criticos (fec_alta, usuario, circ_id, pucr_id, eliminado) FROM stdin;
    log       postgres    false    280            +          0    115274    contenedores 
   TABLE DATA               �   COPY log.contenedores (cont_id, codigo, descripcion, capacidad, tara, habilitacion, fec_alta, usuario, usuario_app, esco_id, reci_id, anio_elaboracion) FROM stdin;
    log       postgres    false    274            @          0    139700    contenedores_entregados 
   TABLE DATA               �   COPY log.contenedores_entregados (coen_id, porc_llenado, mts_cubicos, fec_entrega, fec_retiro, fec_alta, usuario, usuario_app, cont_id, soco_id, sore_id, ortr_id, tica_id) FROM stdin;
    log       postgres    false    295            5          0    115527    deta_solicitudes_contenedor 
   TABLE DATA               t   COPY log.deta_solicitudes_contenedor (desc_id, cantidad, otro, fec_alta, usuario, usuario_app, tica_id) FROM stdin;
    log       postgres    false    284            B          0    147852    incidencias 
   TABLE DATA               4   COPY log.incidencias (inci_id, ortr_id) FROM stdin;
    log       postgres    false    297            >          0    139666    ordenes_transporte 
   TABLE DATA               �   COPY log.ordenes_transporte (ortr_id, fec_retiro, estado, caseid, fec_alta, usuario, difi_id, sotr_id, equi_id, chof_id) FROM stdin;
    log       postgres    false    293            .          0    115325    puntos_criticos 
   TABLE DATA               �   COPY log.puntos_criticos (pucr_id, nombre, descripcion, lat, lng, fec_alta, usuario, usuario_app, zona_id, eliminado) FROM stdin;
    log       postgres    false    277            3          0    115453    solicitantes_transporte 
   TABLE DATA               �   COPY log.solicitantes_transporte (sotr_id, razon_social, cuit, domicilio, num_registro, lat, lng, usuario, fec_alta, usuario_app, zona_id, rubr_id, tist_id, tica_id, eliminado, depa_id) FROM stdin;
    log       postgres    false    282            <          0    139660    solicitudes_contenedores 
   TABLE DATA               8   COPY log.solicitudes_contenedores (soco_id) FROM stdin;
    log       postgres    false    291            6          0    115548    solicitudes_retiro 
   TABLE DATA               [   COPY log.solicitudes_retiro (sore_id, fec_alta, usuario, usuario_app, sotr_id) FROM stdin;
    log       postgres    false    285            ,          0    115299    tipos_carga_circuitos 
   TABLE DATA               Q   COPY log.tipos_carga_circuitos (fec_alta, usuario, circ_id, tica_id) FROM stdin;
    log       postgres    false    275            :          0    123308    tipos_carga_transportistas 
   TABLE DATA               V   COPY log.tipos_carga_transportistas (fec_alta, usuario, tran_id, tica_id) FROM stdin;
    log       postgres    false    289            #          0    115162    transportistas 
   TABLE DATA               �   COPY log.transportistas (tran_id, razon_social, descripcion, direccion, telefono, contacto, resolucion, registro, fec_alta_efectiva, fec_baja_efectiva, fec_alta, usuario, usuario_app, eliminado, cuit) FROM stdin;
    log       postgres    false    266            �          0    57723    costos 
   TABLE DATA               ]   COPY prd.costos (fec_vigencia, valor, umed, fec_alta, usuario, recu_id, empr_id) FROM stdin;
    prd       postgres    false    212                      0    98636    empaque 
   TABLE DATA               u   COPY prd.empaque (empa_id, nombre, unidad_medida, capacidad, empr_id, usuario_app, eliminado, fech_alta) FROM stdin;
    prd       postgres    false    255                      0    74635    establecimientos 
   TABLE DATA               �   COPY prd.establecimientos (esta_id, nombre, lng, lat, calle, altura, localidad, estado, pais, fec_alta, usuario, empr_id) FROM stdin;
    prd       postgres    false    245            �          0    57630    etapas 
   TABLE DATA               {   COPY prd.etapas (etap_id, nombre, nom_recipiente, fec_alta, usuario, proc_id, eliminado, empr_id, orden, link) FROM stdin;
    prd       postgres    false    205            D          0    147874    etapas_materiales 
   TABLE DATA               :   COPY prd.etapas_materiales (etap_id, arti_id) FROM stdin;
    prd       postgres    false    299            E          0    147885    etapas_productos 
   TABLE DATA               9   COPY prd.etapas_productos (etap_id, arti_id) FROM stdin;
    prd       postgres    false    300                      0    98674    fraccionamientos 
   TABLE DATA               g   COPY prd.fraccionamientos (frac_id, recu_id, empa_id, cantidad, fecha, eliminado, empr_id) FROM stdin;
    prd       postgres    false    259            �          0    57652    lotes 
   TABLE DATA               �   COPY prd.lotes (lote_id, batch_id, estado, num_orden_prod, fec_alta, usuario, etap_id, eliminado, nombre, reci_id, empr_id, usuario_app, arti_id) FROM stdin;
    prd       postgres    false    207            �          0    57700    lotes_hijos 
   TABLE DATA               }   COPY prd.lotes_hijos (batch_id, batch_id_padre, fec_alta, usuario, eliminado, empr_id, cantidad, cantidad_padre) FROM stdin;
    prd       postgres    false    211                      0    74786    movimientos_trasportes 
   TABLE DATA               �   COPY prd.movimientos_trasportes (motr_id, boleta, fecha_entrada, patente, acoplado, conductor, tipo, bruto, tara, neto, prov_id, esta_id, fec_alta, eliminado, estado, reci_id, transportista, cuit, accion) FROM stdin;
    prd       postgres    false    250            �          0    57615    procesos 
   TABLE DATA               L   COPY prd.procesos (proc_id, nombre, fec_alta, usuario, empr_id) FROM stdin;
    prd       postgres    false    203                      0    74759    recipientes 
   TABLE DATA               z   COPY prd.recipientes (reci_id, tipo, estado, nombre, fec_alta, usuario, eliminado, empr_id, depo_id, motr_id) FROM stdin;
    prd       postgres    false    248            �          0    57670    recursos 
   TABLE DATA               �   COPY prd.recursos (recu_id, tipo, cant_capacidad, umed_capacidad, cant_tiempo_capacidad, umed_iempo_capacidad, fec_alta, usuario, arti_id, empr_id, equi_id) FROM stdin;
    prd       postgres    false    209            �          0    57682    recursos_lotes 
   TABLE DATA               |   COPY prd.recursos_lotes (batch_id, recu_id, fec_alta, usuario, empr_id, cantidad, tipo, empa_id, empa_cantidad) FROM stdin;
    prd       postgres    false    210            z           0    0    ajustes_ajus_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('alm.ajustes_ajus_id_seq', 44, true);
            alm       postgres    false    260            {           0    0    alm_articulos_arti_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('alm.alm_articulos_arti_id_seq', 69, true);
            alm       postgres    false    221            |           0    0    alm_depositos_depo_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('alm.alm_depositos_depo_id_seq', 7, true);
            alm       postgres    false    223            }           0    0 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE SET     R   SELECT pg_catalog.setval('alm.alm_deta_entrega_materiales_deen_id_seq', 9, true);
            alm       postgres    false    242            ~           0    0 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE SET     T   SELECT pg_catalog.setval('alm.alm_deta_pedidos_materiales_depe_id_seq', 143, true);
            alm       postgres    false    233                       0    0 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE SET     T   SELECT pg_catalog.setval('alm.alm_deta_recepcion_materiales_dere_id_seq', 4, true);
            alm       postgres    false    219            �           0    0 "   alm_entrega_materiales_enma_id_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('alm.alm_entrega_materiales_enma_id_seq', 1, true);
            alm       postgres    false    235            �           0    0    alm_lotes_lote_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('alm.alm_lotes_lote_id_seq', 75, true);
            alm       postgres    false    237            �           0    0 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('alm.alm_pedidos_materiales_pema_id_seq', 197, true);
            alm       postgres    false    225            �           0    0    alm_proveedores_prov_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('alm.alm_proveedores_prov_id_seq', 6, true);
            alm       postgres    false    227            �           0    0 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('alm.alm_recepcion_materiales_rema_id_seq', 2, true);
            alm       postgres    false    240            �           0    0    deta_ajustes_deaj_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('alm.deta_ajustes_deaj_id_seq', 27, true);
            alm       postgres    false    262            �           0    0    items_item_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('alm.items_item_id_seq', 1, false);
            alm       postgres    false    229            �           0    0    utl_tablas_tabl_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('alm.utl_tablas_tabl_id_seq', 17, true);
            alm       postgres    false    231            �           0    0    departamentos_depa_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('core.departamentos_depa_id_seq', 4, true);
            core       postgres    false    269            �           0    0    empresas_empr_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('core.empresas_empr_id_seq', 1, true);
            core       postgres    false    246            �           0    0    equipos_equi_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('core.equipos_equi_id_seq', 23, true);
            core       postgres    false    253            �           0    0    snapshots_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('core.snapshots_id_seq', 58, true);
            core       postgres    false    286            �           0    0    zonas_zona_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('core.zonas_zona_id_seq', 87, true);
            core       postgres    false    267            �           0    0    acta_infraccion_acin_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('fis.acta_infraccion_acin_id_seq', 1, false);
            fis       postgres    false    301            �           0    0    formularios_form_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('frm.formularios_form_id_seq', 1, false);
            frm       postgres    false    213            �           0    0    instancias_items_init_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('frm.instancias_items_init_id_seq', 1, false);
            frm       postgres    false    215            �           0    0    items_item_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('frm.items_item_id_seq', 1, false);
            frm       postgres    false    217            �           0    0    choferes_chof_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('log.choferes_chof_id_seq', 6, true);
            log       postgres    false    278            �           0    0    circuitos_circu_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('log.circuitos_circu_id_seq', 54, true);
            log       postgres    false    271            �           0    0    containers_cont_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('log.containers_cont_id_seq', 26, true);
            log       postgres    false    273            �           0    0 #   contenedores_entregados_coen_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('log.contenedores_entregados_coen_id_seq', 1, true);
            log       postgres    false    294            �           0    0 '   deta_solicitudes_contenedor_desc_id_seq    SEQUENCE SET     S   SELECT pg_catalog.setval('log.deta_solicitudes_contenedor_desc_id_seq', 1, false);
            log       postgres    false    283            �           0    0    incidencias_inci_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('log.incidencias_inci_id_seq', 1, false);
            log       postgres    false    296            �           0    0    ordenes_transporte_ortr_id_seq    SEQUENCE SET     I   SELECT pg_catalog.setval('log.ordenes_transporte_ortr_id_seq', 5, true);
            log       postgres    false    292            �           0    0    puntos_criticos_pucr_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('log.puntos_criticos_pucr_id_seq', 66, true);
            log       postgres    false    276            �           0    0 #   solicitantes_transporte_sotr_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('log.solicitantes_transporte_sotr_id_seq', 19, true);
            log       postgres    false    281            �           0    0 $   solicitudes_contenedores_soco_id_seq    SEQUENCE SET     P   SELECT pg_catalog.setval('log.solicitudes_contenedores_soco_id_seq', 1, false);
            log       postgres    false    290            �           0    0    solicitudes_retiro_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('log.solicitudes_retiro_seq', 6, true);
            log       postgres    false    298            �           0    0    transportistas_tran_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('log.transportistas_tran_id_seq', 27, true);
            log       postgres    false    265            �           0    0    empaque_empa_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('prd.empaque_empa_id_seq', 5, true);
            prd       postgres    false    256            �           0    0    establecimientos_esta_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('prd.establecimientos_esta_id_seq', 3, true);
            prd       postgres    false    244            �           0    0    etapas_etap_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('prd.etapas_etap_id_seq', 1, true);
            prd       postgres    false    204            �           0    0    fraccionamientos_frac_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('prd.fraccionamientos_frac_id_seq', 3, true);
            prd       postgres    false    258            �           0    0    lotes_batch_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('prd.lotes_batch_id_seq', 192, true);
            prd       postgres    false    206            �           0    0 "   movimientos_trasportes_motr_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('prd.movimientos_trasportes_motr_id_seq', 31, true);
            prd       postgres    false    249            �           0    0    productos_prod_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('prd.productos_prod_id_seq', 1, true);
            prd       postgres    false    202            �           0    0    recipiente_reci_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('prd.recipiente_reci_id_seq', 108, true);
            prd       postgres    false    251            �           0    0    recursos_recu_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('prd.recursos_recu_id_seq', 16, true);
            prd       postgres    false    208            �           2606    106917    ajustes ajustes_pk 
   CONSTRAINT     R   ALTER TABLE ONLY alm.ajustes
    ADD CONSTRAINT ajustes_pk PRIMARY KEY (ajus_id);
 9   ALTER TABLE ONLY alm.ajustes DROP CONSTRAINT ajustes_pk;
       alm         postgres    false    261            �           2606    74443     alm_articulos alm_articulos_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY alm.alm_articulos
    ADD CONSTRAINT alm_articulos_pkey PRIMARY KEY (arti_id);
 G   ALTER TABLE ONLY alm.alm_articulos DROP CONSTRAINT alm_articulos_pkey;
       alm         postgres    false    222            �           2606    74462     alm_depositos alm_depositos_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY alm.alm_depositos
    ADD CONSTRAINT alm_depositos_pkey PRIMARY KEY (depo_id);
 G   ALTER TABLE ONLY alm.alm_depositos DROP CONSTRAINT alm_depositos_pkey;
       alm         postgres    false    224            �           2606    74624 <   alm_deta_entrega_materiales alm_deta_entrega_materiales_pkey 
   CONSTRAINT     |   ALTER TABLE ONLY alm.alm_deta_entrega_materiales
    ADD CONSTRAINT alm_deta_entrega_materiales_pkey PRIMARY KEY (deen_id);
 c   ALTER TABLE ONLY alm.alm_deta_entrega_materiales DROP CONSTRAINT alm_deta_entrega_materiales_pkey;
       alm         postgres    false    243            �           2606    74531 <   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_pkey 
   CONSTRAINT     |   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_pkey PRIMARY KEY (depe_id);
 c   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_pkey;
       alm         postgres    false    234            �           2606    74410 @   alm_deta_recepcion_materiales alm_deta_recepcion_materiales_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales
    ADD CONSTRAINT alm_deta_recepcion_materiales_pkey PRIMARY KEY (dere_id);
 g   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales DROP CONSTRAINT alm_deta_recepcion_materiales_pkey;
       alm         postgres    false    220            �           2606    74554 2   alm_entrega_materiales alm_entrega_materiales_pkey 
   CONSTRAINT     r   ALTER TABLE ONLY alm.alm_entrega_materiales
    ADD CONSTRAINT alm_entrega_materiales_pkey PRIMARY KEY (enma_id);
 Y   ALTER TABLE ONLY alm.alm_entrega_materiales DROP CONSTRAINT alm_entrega_materiales_pkey;
       alm         postgres    false    236            �           2606    74574    alm_lotes alm_lotes_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_pkey PRIMARY KEY (lote_id);
 ?   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_pkey;
       alm         postgres    false    238            �           2606    74478 2   alm_pedidos_materiales alm_pedidos_materiales_pkey 
   CONSTRAINT     r   ALTER TABLE ONLY alm.alm_pedidos_materiales
    ADD CONSTRAINT alm_pedidos_materiales_pkey PRIMARY KEY (pema_id);
 Y   ALTER TABLE ONLY alm.alm_pedidos_materiales DROP CONSTRAINT alm_pedidos_materiales_pkey;
       alm         postgres    false    226            �           2606    74589 8   alm_proveedores_articulos alm_proveedores_articulos_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_pkey PRIMARY KEY (prov_id, arti_id);
 _   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_pkey;
       alm         postgres    false    239    239            �           2606    74498 $   alm_proveedores alm_proveedores_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY alm.alm_proveedores
    ADD CONSTRAINT alm_proveedores_pkey PRIMARY KEY (prov_id);
 K   ALTER TABLE ONLY alm.alm_proveedores DROP CONSTRAINT alm_proveedores_pkey;
       alm         postgres    false    228            �           2606    74609 6   alm_recepcion_materiales alm_recepcion_materiales_pkey 
   CONSTRAINT     v   ALTER TABLE ONLY alm.alm_recepcion_materiales
    ADD CONSTRAINT alm_recepcion_materiales_pkey PRIMARY KEY (rema_id);
 ]   ALTER TABLE ONLY alm.alm_recepcion_materiales DROP CONSTRAINT alm_recepcion_materiales_pkey;
       alm         postgres    false    241            �           2606    106955    deta_ajustes deta_ajustes_pk 
   CONSTRAINT     \   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_pk PRIMARY KEY (deaj_id);
 C   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_pk;
       alm         postgres    false    263            �           2606    74511    items items_pk 
   CONSTRAINT     N   ALTER TABLE ONLY alm.items
    ADD CONSTRAINT items_pk PRIMARY KEY (item_id);
 5   ALTER TABLE ONLY alm.items DROP CONSTRAINT items_pk;
       alm         postgres    false    230            �           2606    74521    utl_tablas utl_tablas_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY alm.utl_tablas
    ADD CONSTRAINT utl_tablas_pkey PRIMARY KEY (tabl_id);
 A   ALTER TABLE ONLY alm.utl_tablas DROP CONSTRAINT utl_tablas_pkey;
       alm         postgres    false    232            �           2606    115221    departamentos departamentos_pk 
   CONSTRAINT     _   ALTER TABLE ONLY core.departamentos
    ADD CONSTRAINT departamentos_pk PRIMARY KEY (depa_id);
 F   ALTER TABLE ONLY core.departamentos DROP CONSTRAINT departamentos_pk;
       core         postgres    false    270            �           2606    74713    empresas empresas_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY core.empresas
    ADD CONSTRAINT empresas_pkey PRIMARY KEY (empr_id);
 >   ALTER TABLE ONLY core.empresas DROP CONSTRAINT empresas_pkey;
       core         postgres    false    247            �           2606    98630    equipos equipos_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY core.equipos
    ADD CONSTRAINT equipos_pkey PRIMARY KEY (equi_id);
 <   ALTER TABLE ONLY core.equipos DROP CONSTRAINT equipos_pkey;
       core         postgres    false    254            �           2606    115119    tablas tablas_pk 
   CONSTRAINT     Q   ALTER TABLE ONLY core.tablas
    ADD CONSTRAINT tablas_pk PRIMARY KEY (tabl_id);
 8   ALTER TABLE ONLY core.tablas DROP CONSTRAINT tablas_pk;
       core         postgres    false    264            �           2606    98660     transportistas transportistas_pk 
   CONSTRAINT     ^   ALTER TABLE ONLY core.transportistas
    ADD CONSTRAINT transportistas_pk PRIMARY KEY (cuit);
 H   ALTER TABLE ONLY core.transportistas DROP CONSTRAINT transportistas_pk;
       core         postgres    false    257            �           2606    115384    zonas zonas_pk 
   CONSTRAINT     O   ALTER TABLE ONLY core.zonas
    ADD CONSTRAINT zonas_pk PRIMARY KEY (zona_id);
 6   ALTER TABLE ONLY core.zonas DROP CONSTRAINT zonas_pk;
       core         postgres    false    268            '           2606    164253 #   actas_infraccion acta_infraccion_pk 
   CONSTRAINT     c   ALTER TABLE ONLY fis.actas_infraccion
    ADD CONSTRAINT acta_infraccion_pk PRIMARY KEY (acin_id);
 J   ALTER TABLE ONLY fis.actas_infraccion DROP CONSTRAINT acta_infraccion_pk;
       fis         postgres    false    302            �           2606    57793    formularios formularios_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY frm.formularios
    ADD CONSTRAINT formularios_pk PRIMARY KEY (form_id);
 A   ALTER TABLE ONLY frm.formularios DROP CONSTRAINT formularios_pk;
       frm         postgres    false    214            �           2606    57811 $   instancias_items instancias_items_pk 
   CONSTRAINT     d   ALTER TABLE ONLY frm.instancias_items
    ADD CONSTRAINT instancias_items_pk PRIMARY KEY (init_id);
 K   ALTER TABLE ONLY frm.instancias_items DROP CONSTRAINT instancias_items_pk;
       frm         postgres    false    216            �           2606    57828    items items_pk 
   CONSTRAINT     N   ALTER TABLE ONLY frm.items
    ADD CONSTRAINT items_pk PRIMARY KEY (item_id);
 5   ALTER TABLE ONLY frm.items DROP CONSTRAINT items_pk;
       frm         postgres    false    218                       2606    115372    choferes choferes_dni_un 
   CONSTRAINT     U   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_dni_un UNIQUE (documento);
 ?   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_dni_un;
       log         postgres    false    279                       2606    115370    choferes choferes_pk 
   CONSTRAINT     T   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_pk PRIMARY KEY (chof_id);
 ;   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_pk;
       log         postgres    false    279            �           2606    115308    circuitos circuitos_pk 
   CONSTRAINT     V   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_pk PRIMARY KEY (circ_id);
 =   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_pk;
       log         postgres    false    272                       2606    115440 6   circuitos_puntos_criticos circuitos_puntos_criticos_pk 
   CONSTRAINT        ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_pk PRIMARY KEY (circ_id, pucr_id);
 ]   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_pk;
       log         postgres    false    280    280            �           2606    115310    circuitos circuitos_un 
   CONSTRAINT     P   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_un UNIQUE (codigo);
 =   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_un;
       log         postgres    false    272                       2606    115286 !   contenedores containers_codigo_un 
   CONSTRAINT     [   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_codigo_un UNIQUE (codigo);
 H   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_codigo_un;
       log         postgres    false    274                       2606    115284    contenedores containers_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_pk PRIMARY KEY (cont_id);
 A   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_pk;
       log         postgres    false    274                       2606    115288 "   contenedores containers_reci_id_un 
   CONSTRAINT     ]   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_reci_id_un UNIQUE (reci_id);
 I   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_reci_id_un;
       log         postgres    false    274                       2606    115541 :   deta_solicitudes_contenedor deta_solicitudes_contenedor_pk 
   CONSTRAINT     z   ALTER TABLE ONLY log.deta_solicitudes_contenedor
    ADD CONSTRAINT deta_solicitudes_contenedor_pk PRIMARY KEY (desc_id);
 a   ALTER TABLE ONLY log.deta_solicitudes_contenedor DROP CONSTRAINT deta_solicitudes_contenedor_pk;
       log         postgres    false    284            !           2606    147857    incidencias incidencias_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY log.incidencias
    ADD CONSTRAINT incidencias_pk PRIMARY KEY (inci_id);
 A   ALTER TABLE ONLY log.incidencias DROP CONSTRAINT incidencias_pk;
       log         postgres    false    297                       2606    139677 (   ordenes_transporte ordenes_transporte_pk 
   CONSTRAINT     h   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_pk PRIMARY KEY (ortr_id);
 O   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_pk;
       log         postgres    false    293            	           2606    115335 "   puntos_criticos puntos_criticos_pk 
   CONSTRAINT     b   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_pk PRIMARY KEY (pucr_id);
 I   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_pk;
       log         postgres    false    277                       2606    115337 "   puntos_criticos puntos_criticos_un 
   CONSTRAINT     \   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_un UNIQUE (nombre);
 I   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_un;
       log         postgres    false    277                       2606    115463 1   solicitantes_transporte solcitantes_transporte_pk 
   CONSTRAINT     q   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_pk PRIMARY KEY (sotr_id);
 X   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_pk;
       log         postgres    false    282                       2606    115465 1   solicitantes_transporte solcitantes_transporte_un 
   CONSTRAINT     i   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_un UNIQUE (cuit);
 X   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_un;
       log         postgres    false    282                       2606    139717 4   solicitudes_contenedores solicitudes_contenedores_pk 
   CONSTRAINT     t   ALTER TABLE ONLY log.solicitudes_contenedores
    ADD CONSTRAINT solicitudes_contenedores_pk PRIMARY KEY (soco_id);
 [   ALTER TABLE ONLY log.solicitudes_contenedores DROP CONSTRAINT solicitudes_contenedores_pk;
       log         postgres    false    291                       2606    139734 (   solicitudes_retiro solicitudes_retiro_pk 
   CONSTRAINT     h   ALTER TABLE ONLY log.solicitudes_retiro
    ADD CONSTRAINT solicitudes_retiro_pk PRIMARY KEY (sore_id);
 O   ALTER TABLE ONLY log.solicitudes_retiro DROP CONSTRAINT solicitudes_retiro_pk;
       log         postgres    false    285                       2606    115400 .   tipos_carga_circuitos tipos_carga_circuitos_pk 
   CONSTRAINT     w   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_carga_circuitos_pk PRIMARY KEY (circ_id, tica_id);
 U   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_carga_circuitos_pk;
       log         postgres    false    275    275                       2606    123317 8   tipos_carga_transportistas tipos_carga_transportistas_pk 
   CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_pk PRIMARY KEY (tran_id, tica_id);
 _   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_pk;
       log         postgres    false    289    289            �           2606    115172     transportistas transportistas_pk 
   CONSTRAINT     `   ALTER TABLE ONLY log.transportistas
    ADD CONSTRAINT transportistas_pk PRIMARY KEY (tran_id);
 G   ALTER TABLE ONLY log.transportistas DROP CONSTRAINT transportistas_pk;
       log         postgres    false    266            �           2606    115174     transportistas transportistas_un 
   CONSTRAINT     `   ALTER TABLE ONLY log.transportistas
    ADD CONSTRAINT transportistas_un UNIQUE (razon_social);
 G   ALTER TABLE ONLY log.transportistas DROP CONSTRAINT transportistas_un;
       log         postgres    false    266            �           2606    57737    costos costos_pk 
   CONSTRAINT     ^   ALTER TABLE ONLY prd.costos
    ADD CONSTRAINT costos_pk PRIMARY KEY (fec_vigencia, recu_id);
 7   ALTER TABLE ONLY prd.costos DROP CONSTRAINT costos_pk;
       prd         postgres    false    212    212            �           2606    98646    empaque empaque_pk 
   CONSTRAINT     R   ALTER TABLE ONLY prd.empaque
    ADD CONSTRAINT empaque_pk PRIMARY KEY (empa_id);
 9   ALTER TABLE ONLY prd.empaque DROP CONSTRAINT empaque_pk;
       prd         postgres    false    255            �           2606    74643 $   establecimientos establecimientos_pk 
   CONSTRAINT     d   ALTER TABLE ONLY prd.establecimientos
    ADD CONSTRAINT establecimientos_pk PRIMARY KEY (esta_id);
 K   ALTER TABLE ONLY prd.establecimientos DROP CONSTRAINT establecimientos_pk;
       prd         postgres    false    245            #           2606    156049 &   etapas_materiales etapas_materiales_un 
   CONSTRAINT     j   ALTER TABLE ONLY prd.etapas_materiales
    ADD CONSTRAINT etapas_materiales_un UNIQUE (etap_id, arti_id);
 M   ALTER TABLE ONLY prd.etapas_materiales DROP CONSTRAINT etapas_materiales_un;
       prd         postgres    false    299    299            �           2606    57640    etapas etapas_pk 
   CONSTRAINT     P   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_pk PRIMARY KEY (etap_id);
 7   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_pk;
       prd         postgres    false    205            %           2606    156047 $   etapas_productos etapas_productos_un 
   CONSTRAINT     h   ALTER TABLE ONLY prd.etapas_productos
    ADD CONSTRAINT etapas_productos_un UNIQUE (etap_id, arti_id);
 K   ALTER TABLE ONLY prd.etapas_productos DROP CONSTRAINT etapas_productos_un;
       prd         postgres    false    300    300            �           2606    98616    etapas etapas_un 
   CONSTRAINT     S   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_un UNIQUE (nombre, proc_id);
 7   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_un;
       prd         postgres    false    205    205            �           2606    98614    etapas etapas_un_2 
   CONSTRAINT     T   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_un_2 UNIQUE (orden, proc_id);
 9   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_un_2;
       prd         postgres    false    205    205            �           2606    74733    lotes lotes_un 
   CONSTRAINT     J   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_un UNIQUE (batch_id);
 5   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_un;
       prd         postgres    false    207            �           2606    74795 0   movimientos_trasportes movimientos_trasportes_pk 
   CONSTRAINT     p   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_pk PRIMARY KEY (motr_id);
 W   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_pk;
       prd         postgres    false    250            �           2606    57625    procesos productos_pk 
   CONSTRAINT     U   ALTER TABLE ONLY prd.procesos
    ADD CONSTRAINT productos_pk PRIMARY KEY (proc_id);
 <   ALTER TABLE ONLY prd.procesos DROP CONSTRAINT productos_pk;
       prd         postgres    false    203            �           2606    57627    procesos productos_un 
   CONSTRAINT     O   ALTER TABLE ONLY prd.procesos
    ADD CONSTRAINT productos_un UNIQUE (nombre);
 <   ALTER TABLE ONLY prd.procesos DROP CONSTRAINT productos_un;
       prd         postgres    false    203            �           2606    74771    recipientes recipientes_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_pk PRIMARY KEY (reci_id);
 A   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_pk;
       prd         postgres    false    248            �           2606    57679    recursos recursos_pk 
   CONSTRAINT     T   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_pk PRIMARY KEY (recu_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_pk;
       prd         postgres    false    209            �           2606    82232    recursos recursos_un 
   CONSTRAINT     O   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_un UNIQUE (arti_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_un;
       prd         postgres    false    209            h           2620    98705 0   alm_deta_entrega_materiales asociar_lote_hijo_ai    TRIGGER     �   CREATE TRIGGER asociar_lote_hijo_ai AFTER INSERT ON alm.alm_deta_entrega_materiales FOR EACH ROW EXECUTE PROCEDURE prd.asociar_lote_hijo_trg();
 F   DROP TRIGGER asociar_lote_hijo_ai ON alm.alm_deta_entrega_materiales;
       alm       postgres    false    243    320            f           2620    82229    alm_articulos crear_producto_ai    TRIGGER        CREATE TRIGGER crear_producto_ai AFTER INSERT ON alm.alm_articulos FOR EACH ROW EXECUTE PROCEDURE prd.crear_prd_recurso_trg();
 5   DROP TRIGGER crear_producto_ai ON alm.alm_articulos;
       alm       postgres    false    222    321            g           2620    82230 "   alm_articulos eliminar_producto_ad    TRIGGER     �   CREATE TRIGGER eliminar_producto_ad AFTER DELETE ON alm.alm_articulos FOR EACH ROW EXECUTE PROCEDURE prd.eliminar_prd_recurso_trg();
 8   DROP TRIGGER eliminar_producto_ad ON alm.alm_articulos;
       alm       postgres    false    322    222            i           2620    115124    tablas set_tabla_id_bui    TRIGGER        CREATE TRIGGER set_tabla_id_bui BEFORE INSERT OR UPDATE ON core.tablas FOR EACH ROW EXECUTE PROCEDURE core.set_tabla_id_trg();
 .   DROP TRIGGER set_tabla_id_bui ON core.tablas;
       core       postgres    false    324    264            2           2606    115378    alm_articulos alm_articulos_fk    FK CONSTRAINT     {   ALTER TABLE ONLY alm.alm_articulos
    ADD CONSTRAINT alm_articulos_fk FOREIGN KEY (tipo) REFERENCES core.tablas(tabl_id);
 E   ALTER TABLE ONLY alm.alm_articulos DROP CONSTRAINT alm_articulos_fk;
       alm       postgres    false    222    264    3315            =           2606    74625 :   alm_deta_entrega_materiales alm_deta_entrega_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_entrega_materiales
    ADD CONSTRAINT alm_deta_entrega_materiales_fk FOREIGN KEY (enma_id) REFERENCES alm.alm_entrega_materiales(enma_id);
 a   ALTER TABLE ONLY alm.alm_deta_entrega_materiales DROP CONSTRAINT alm_deta_entrega_materiales_fk;
       alm       postgres    false    236    243    3287            4           2606    74532 :   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 a   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_fk;
       alm       postgres    false    222    3273    234            5           2606    74537 <   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_fk_1 FOREIGN KEY (pema_id) REFERENCES alm.alm_pedidos_materiales(pema_id);
 c   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_fk_1;
       alm       postgres    false    226    3277    234            6           2606    74555 0   alm_entrega_materiales alm_entrega_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_entrega_materiales
    ADD CONSTRAINT alm_entrega_materiales_fk FOREIGN KEY (pema_id) REFERENCES alm.alm_pedidos_materiales(pema_id);
 W   ALTER TABLE ONLY alm.alm_entrega_materiales DROP CONSTRAINT alm_entrega_materiales_fk;
       alm       postgres    false    226    236    3277            3           2606    74777 %   alm_depositos alm_establecimientos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_depositos
    ADD CONSTRAINT alm_establecimientos_fk FOREIGN KEY (esta_id) REFERENCES prd.establecimientos(esta_id);
 L   ALTER TABLE ONLY alm.alm_depositos DROP CONSTRAINT alm_establecimientos_fk;
       alm       postgres    false    245    224    3297            7           2606    74575    alm_lotes alm_lotes_fk    FK CONSTRAINT     |   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 =   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_fk;
       alm       postgres    false    238    222    3273            8           2606    74580    alm_lotes alm_lotes_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_fk_1 FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 ?   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_fk_1;
       alm       postgres    false    228    238    3279            9           2606    74880    alm_lotes alm_lotes_lotes_fk    FK CONSTRAINT     |   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 C   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_lotes_fk;
       alm       postgres    false    3257    207    238            :           2606    74590 6   alm_proveedores_articulos alm_proveedores_articulos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 ]   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_fk;
       alm       postgres    false    3273    222    239            ;           2606    74595 8   alm_proveedores_articulos alm_proveedores_articulos_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_fk_1 FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 _   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_fk_1;
       alm       postgres    false    228    3279    239            <           2606    74610 4   alm_recepcion_materiales alm_recepcion_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_recepcion_materiales
    ADD CONSTRAINT alm_recepcion_materiales_fk FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 [   ALTER TABLE ONLY alm.alm_recepcion_materiales DROP CONSTRAINT alm_recepcion_materiales_fk;
       alm       postgres    false    241    3279    228            G           2606    106964 $   deta_ajustes deta_ajustes_ajustes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_ajustes_fk FOREIGN KEY (ajus_id) REFERENCES alm.ajustes(ajus_id);
 K   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_ajustes_fk;
       alm       postgres    false    263    261    3311            F           2606    106956 &   deta_ajustes deta_ajustes_alm_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_alm_lotes_fk FOREIGN KEY (lote_id) REFERENCES alm.alm_lotes(lote_id);
 M   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_alm_lotes_fk;
       alm       postgres    false    3289    263    238            H           2606    115223    zonas zonas_fk    FK CONSTRAINT     v   ALTER TABLE ONLY core.zonas
    ADD CONSTRAINT zonas_fk FOREIGN KEY (depa_id) REFERENCES core.departamentos(depa_id);
 6   ALTER TABLE ONLY core.zonas DROP CONSTRAINT zonas_fk;
       core       postgres    false    268    270    3323            d           2606    164254 +   actas_infraccion solicitantes_transporte_fk    FK CONSTRAINT     �   ALTER TABLE ONLY fis.actas_infraccion
    ADD CONSTRAINT solicitantes_transporte_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 R   ALTER TABLE ONLY fis.actas_infraccion DROP CONSTRAINT solicitantes_transporte_fk;
       fis       postgres    false    302    3347    282            e           2606    164259 "   actas_infraccion transportistas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY fis.actas_infraccion
    ADD CONSTRAINT transportistas_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 I   ALTER TABLE ONLY fis.actas_infraccion DROP CONSTRAINT transportistas_fk;
       fis       postgres    false    266    302    3317            O           2606    115373    choferes choferes_fk    FK CONSTRAINT     {   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 ;   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_fk;
       log       postgres    false    3317    279    266            P           2606    115441 6   circuitos_puntos_criticos circuitos_puntos_criticos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_fk FOREIGN KEY (circ_id) REFERENCES log.circuitos(circ_id);
 ]   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_fk;
       log       postgres    false    3325    280    272            Q           2606    115446 8   circuitos_puntos_criticos circuitos_puntos_criticos_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_fk_1 FOREIGN KEY (pucr_id) REFERENCES log.puntos_criticos(pucr_id);
 _   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_fk_1;
       log       postgres    false    3337    277    280            I           2606    123390    circuitos circuitos_zona_id_fk    FK CONSTRAINT     }   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 E   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_zona_id_fk;
       log       postgres    false    3321    268    272            K           2606    115294    contenedores containers_fk    FK CONSTRAINT     z   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_fk FOREIGN KEY (esco_id) REFERENCES core.tablas(tabl_id);
 A   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_fk;
       log       postgres    false    274    264    3315            J           2606    115289 "   contenedores containers_reci_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_reci_id_fk FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 I   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_reci_id_fk;
       log       postgres    false    3301    248    274            `           2606    139723 :   contenedores_entregados contenedores_entregados_ortr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_ortr_id_fk FOREIGN KEY (ortr_id) REFERENCES log.ordenes_transporte(ortr_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_ortr_id_fk;
       log       postgres    false    3359    295    293            _           2606    139718 :   contenedores_entregados contenedores_entregados_soco_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_soco_id_fk FOREIGN KEY (soco_id) REFERENCES log.solicitudes_contenedores(soco_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_soco_id_fk;
       log       postgres    false    291    3357    295            b           2606    139735 :   contenedores_entregados contenedores_entregados_sore_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_sore_id_fk FOREIGN KEY (sore_id) REFERENCES log.solicitudes_retiro(sore_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_sore_id_fk;
       log       postgres    false    3353    285    295            a           2606    139728 :   contenedores_entregados contenedores_entregados_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_tica_id_fk;
       log       postgres    false    264    295    3315            W           2606    115535 B   deta_solicitudes_contenedor deta_solicitudes_contenedor_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.deta_solicitudes_contenedor
    ADD CONSTRAINT deta_solicitudes_contenedor_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 i   ALTER TABLE ONLY log.deta_solicitudes_contenedor DROP CONSTRAINT deta_solicitudes_contenedor_tica_id_fk;
       log       postgres    false    284    264    3315            ]           2606    139688 0   ordenes_transporte ordenes_transporte_chof_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_chof_id_fk FOREIGN KEY (chof_id) REFERENCES log.choferes(documento);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_chof_id_fk;
       log       postgres    false    293    3341    279            [           2606    139678 0   ordenes_transporte ordenes_transporte_difi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_difi_id_fk FOREIGN KEY (difi_id) REFERENCES core.tablas(tabl_id);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_difi_id_fk;
       log       postgres    false    293    3315    264            ^           2606    139693 0   ordenes_transporte ordenes_transporte_equi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_equi_id_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_equi_id_fk;
       log       postgres    false    293    3305    254            \           2606    139683 0   ordenes_transporte ordenes_transporte_sotr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_sotr_id_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_sotr_id_fk;
       log       postgres    false    293    3347    282            N           2606    115411 *   puntos_criticos puntos_criticos_zona_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 Q   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_zona_id_fk;
       log       postgres    false    268    277    3321            R           2606    115466 9   solicitantes_transporte solcitantes_transporte_rubr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_rubr_id_fk FOREIGN KEY (rubr_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_rubr_id_fk;
       log       postgres    false    282    264    3315            T           2606    115476 9   solicitantes_transporte solcitantes_transporte_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_tica_id_fk;
       log       postgres    false    282    264    3315            S           2606    115471 9   solicitantes_transporte solcitantes_transporte_tisr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_tisr_id_fk FOREIGN KEY (tist_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_tisr_id_fk;
       log       postgres    false    282    264    3315            U           2606    115481 9   solicitantes_transporte solcitantes_transporte_zona_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_zona_id_fk;
       log       postgres    false    282    268    3321            V           2606    164234 :   solicitantes_transporte solicitantes_transporte_depa_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solicitantes_transporte_depa_id_fk FOREIGN KEY (depa_id) REFERENCES core.departamentos(depa_id);
 a   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solicitantes_transporte_depa_id_fk;
       log       postgres    false    282    3323    270            X           2606    139745 (   solicitudes_retiro solicitudes_retiro_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitudes_retiro
    ADD CONSTRAINT solicitudes_retiro_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 O   ALTER TABLE ONLY log.solicitudes_retiro DROP CONSTRAINT solicitudes_retiro_fk;
       log       postgres    false    3347    282    285            M           2606    115401 6   tipos_carga_circuitos tipos_carga_circuitos_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_carga_circuitos_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 ]   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_carga_circuitos_tica_id_fk;
       log       postgres    false    275    264    3315            Z           2606    123323 8   tipos_carga_transportistas tipos_carga_transportistas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 _   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_fk;
       log       postgres    false    289    3317    266            Y           2606    123318 @   tipos_carga_transportistas tipos_carga_transportistas_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 g   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_tica_id_fk;
       log       postgres    false    289    3315    264            L           2606    115313 0   tipos_carga_circuitos tipos_residuo_circuitos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_residuo_circuitos_fk FOREIGN KEY (circ_id) REFERENCES log.circuitos(circ_id);
 W   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_residuo_circuitos_fk;
       log       postgres    false    275    272    3325            1           2606    57731    costos costos_recursos_fk    FK CONSTRAINT     z   ALTER TABLE ONLY prd.costos
    ADD CONSTRAINT costos_recursos_fk FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id);
 @   ALTER TABLE ONLY prd.costos DROP CONSTRAINT costos_recursos_fk;
       prd       postgres    false    209    212    3259            D           2606    98685    fraccionamientos empa_id    FK CONSTRAINT     x   ALTER TABLE ONLY prd.fraccionamientos
    ADD CONSTRAINT empa_id FOREIGN KEY (empa_id) REFERENCES prd.empaque(empa_id);
 ?   ALTER TABLE ONLY prd.fraccionamientos DROP CONSTRAINT empa_id;
       prd       postgres    false    3307    255    259            c           2606    147880 "   etapas_materiales etapa-arti_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_materiales
    ADD CONSTRAINT "etapa-arti_id_fk" FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 K   ALTER TABLE ONLY prd.etapas_materiales DROP CONSTRAINT "etapa-arti_id_fk";
       prd       postgres    false    3273    299    222            (           2606    57747    etapas etapas_procesos_fk    FK CONSTRAINT     z   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_procesos_fk FOREIGN KEY (proc_id) REFERENCES prd.procesos(proc_id);
 @   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_procesos_fk;
       prd       postgres    false    203    205    3247            )           2606    57663    lotes lotes_etapas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_etapas_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id) ON DELETE RESTRICT;
 <   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_etapas_fk;
       prd       postgres    false    205    3251    207            +           2606    82169    lotes lotes_fk    FK CONSTRAINT     t   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 5   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_fk;
       prd       postgres    false    222    207    3273            0           2606    74739     lotes_hijos lotes_hijos_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_hijos
    ADD CONSTRAINT lotes_hijos_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 G   ALTER TABLE ONLY prd.lotes_hijos DROP CONSTRAINT lotes_hijos_lotes_fk;
       prd       postgres    false    211    3257    207            /           2606    74734 '   lotes_hijos lotes_hijos_lotes_padres_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_hijos
    ADD CONSTRAINT lotes_hijos_lotes_padres_fk FOREIGN KEY (batch_id_padre) REFERENCES prd.lotes(batch_id);
 N   ALTER TABLE ONLY prd.lotes_hijos DROP CONSTRAINT lotes_hijos_lotes_padres_fk;
       prd       postgres    false    207    3257    211            *           2606    74772    lotes lotes_recipientes_fk    FK CONSTRAINT     ~   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_recipientes_fk FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 A   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_recipientes_fk;
       prd       postgres    false    207    248    3301            C           2606    98661 ?   movimientos_trasportes movimientos_trasportes__transportista_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes__transportista_fk FOREIGN KEY (cuit) REFERENCES core.transportistas(cuit);
 f   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes__transportista_fk;
       prd       postgres    false    250    257    3309            @           2606    74796 0   movimientos_trasportes movimientos_trasportes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 W   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk;
       prd       postgres    false    3279    250    228            A           2606    74801 2   movimientos_trasportes movimientos_trasportes_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk_1 FOREIGN KEY (esta_id) REFERENCES prd.establecimientos(esta_id);
 Y   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk_1;
       prd       postgres    false    3297    245    250            B           2606    74870 2   movimientos_trasportes movimientos_trasportes_fk_2    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk_2 FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 Y   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk_2;
       prd       postgres    false    3301    248    250            >           2606    74818 (   recipientes recipientes_alm_depositos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_alm_depositos_fk FOREIGN KEY (depo_id) REFERENCES alm.alm_depositos(depo_id);
 O   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_alm_depositos_fk;
       prd       postgres    false    3275    248    224            ?           2606    74875    recipientes recipientes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_fk FOREIGN KEY (motr_id) REFERENCES prd.movimientos_trasportes(motr_id);
 A   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_fk;
       prd       postgres    false    3303    250    248            E           2606    98690    fraccionamientos recu_id    FK CONSTRAINT     y   ALTER TABLE ONLY prd.fraccionamientos
    ADD CONSTRAINT recu_id FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id);
 ?   ALTER TABLE ONLY prd.fraccionamientos DROP CONSTRAINT recu_id;
       prd       postgres    false    259    3259    209            ,           2606    98631    recursos recursos_fk    FK CONSTRAINT     u   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_fk;
       prd       postgres    false    3305    254    209            .           2606    74744 &   recursos_lotes recursos_lotes_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recursos_lotes
    ADD CONSTRAINT recursos_lotes_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id) ON DELETE RESTRICT;
 M   ALTER TABLE ONLY prd.recursos_lotes DROP CONSTRAINT recursos_lotes_lotes_fk;
       prd       postgres    false    3257    207    210            -           2606    57695 )   recursos_lotes recursos_lotes_recursos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recursos_lotes
    ADD CONSTRAINT recursos_lotes_recursos_fk FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id) ON DELETE RESTRICT;
 P   ALTER TABLE ONLY prd.recursos_lotes DROP CONSTRAINT recursos_lotes_recursos_fk;
       prd       postgres    false    209    3259    210               _   x�3�tq��	u����NUHI-+M�)K�S ��̔�b���Ԃ�|��������9��J3�89�-u�tL9�KҋR��L�l^� ��4�      �   �  x����N�8���U�p+���vrDˢ�T�UOL�@��x6��Jok/aol?ǅ$C�M;�J2Ì������\&�'��\�eQ�v��a+���^�����O��3t�^��V_,�������e��תb����n�'.����$����2���Pr�)�iFL&NO����p��E�B���m�@��[�����E�ļ/>��OҠ3*qj(�������j\+��G���jz5�rT�*��-]���=)W�_M��2�1�RR�IQQ�������v�	e��H�H/:�P�"$'dG	*#
�)���D	�IBT��e�����ET�H����� HizH#=`�n}P��?����]X�B�� 0�I�c�����H �@�M�P�Y��M]죫r�x4�m�r '�� }�$�,��Rv�h+����5=�F�X4ǳ��̄�45�
�����:������t��zW��.C���u�������K����Mu����fL��(��HEU'�G	��շv�?�3F@BxY���Fh"��~���q���m�����#�/�=<�Q����Q]i&�o�Фu�����WE�d�c�� �6�Q�H��z}k�P��Ď���V��j��&�|ls1q�Ծ�l�b�R���F������wu��ȌK�$��)��Fǟ���O�Gנ�-��~U�O��}��~�z, ~�2��{HE0L_�-Bݞ��)��#���}�-��eHp��c�����.�.�!τ}t��w���+���������R�z3T��i��0��/}��^��-|���n��8�J�v�$��jަ-L癇�y��z�졀����k�l9aO�f<X��wU"i��!6��,��{0�|JΤ��a�)3��HQ�E��B�w���XƠ���x,��0F�G�f�ֈQZwI�<�dKr�[[��~4em�hƙ��D�������U#�kT`��鵫z���[��7pOQ���J�I��Z��2ۨ�NX A-2 iݏ���4�=�������,�v���h~�!:Oy8|i.���Դx8f�g��b-��>z�;��4|8ހ�<GE#�l'���� k�=_P��(�	/���
f�ƣ��D�Nx5/3�g�R��hUT����PzLk��t�%����=4�Lۻ��Q�W�.�2CB��X�����0Y{׍#��Uv�".I��E	��0cR�/d�.��>�U��l+�˵WB�N�^jL�O��r������5�&�Uo�~�{{{�ߚWj      �   o   x�}ͻ
�@F�z�)�v���l-�	�Rڤ�`!���q��0pڏ���e�~K �K x�D��:�jKbJ#�!"��>�_i8�e��V�q{.��q�E<��U�:T�)��N9$�         b   x��ͱ!��Tq�ǒ�1����_�ADR�u�����i.�ARh�/��E_��tʿ嵉P��mƥ�S�#���č�Q�m�ݏs1�1��O[k��+�         �  x�}�۱!��q�3��"RA��	���v�3���V����߿>MD	�7���� �'�4N^U=?�{ف��03�����J��DPn �3�V� � سr�#5<\0��2�Q$���"����Ѭu����󍾻����%8 ���@��j�]_����;ЙchW��gp���KI����i�������"��=�Z��c�rTine�!�]�����K��ۏ��`<4M�U�CNG$=Uy;�x䕏�P۫�����\afJ�_��[��8
h��:ˀ�p?��5 `>�L�ִ�^v=&��� ��8'�T�� �?�,M'�K �	���Ղ��%��^@��z�p,�h����rl^���-D����0{���^��1�����h���2D3�>}�R�@�#����v.�CM�\Ll �	�&�U�`Ⱥ.(�Ѐ�3B�-m�qc�D�³���Np$��+u	�!�",8�	�'8#L����~��ꃭ�4 �`�B��{@2�W������f�<8�Zn��A��{����5P��^r��T���R� �ܙ>`/�3��<� '�Gw�M"C� �bzB�D{"l����m���Uh�\�r��'�k�:�<��s� �$'BbS�L�[�Y�6��DxG|�U4B�{�9�>���I�����m��3��܀N���j��D=�6	b�vTZDK1�6t�3cw�A�o�Q�dlo�3�Y��ݕ!|�����l7�?F�'T*/&������^+���+����(�f���?{�\��-M�aɺ1l?�v��� Ջ!��.�	l?-��1�N`��4_,<�X�eut����j��C=|K��]�~�;�H��mC-w��	�+`����K]�%��?K�o��m�=�}�]m�ի�5��V��nؚ�����_��_�)��      �   V   x�m͹� D�xU���Q��,;"�俙UcM=���I$�^���(5{7<�ۇ}�r��؏�#t=�;3{蕉��v�         >   x�3�420��54�5��,�,��42626"N6�4BR�`hiehdel�ghlnƙ����� �;�         �  x���MoG�Ϛ_�[N�!gfo����p�E�ć \����Yٻ��XM]�X>��K
i!��
W?�^�
r)� �Y�������d��@?k(���Ǩ/|[�ғ��^`�:$��#� {n��0OH<&-�"u@>�(BtX& 9ҥX��}䌕$�BO�U����q�@|��ar
h��.]��o�ĥYu�:J>q[v�[����MIZ��K�\I����$)�I+9/�Ck��C�LT3D�f�4���f�a{���6����5������g�h����\�A�([9 � -�� Ci�DG��hZu�)�bbG�}zMi43hd�
h-$%5���0q�{�i��^$ֆ��"��^y�0,�K�	}�}Ҳ�8�����������_)/�������Y�Q�^���5�4����*$V&mr吽��ЙY��:S"��$�zu�>0sd���i�|��so��Pߚ8c�ךm��L�%��>2�k���
�C�(�������^�n��>�]߉~ٻ��#3��������L*)�Z�t��|�B�*��)Jk(�<jOD�憗�J	
�=��i������l�l����-����ư�5�.�U!��3�d��k,����΀�'����&�f�a�v"{D�0����t��JC����?X*m�'4c����,L��*5�*�k6�A�����ͩ&B3��V�Uy���6A'�nvC���6��
���(����ǣ�Ew�G��}����^��R�f U���K�� ��X7��3�n^R�� �+Q�YM"��l��	Mr���=�c��q.a��bT88�S!yP�����j7-��6f;xT�Q�,�R	8�T�����ϧ�wW�¢�l�XХ��{XE�c0�^Qހ��k�7��1���M�ҁ���VU/&U
5��[؉r��r�=�2
k�,�aq�b����:B���`���S�R�I(u�#8�ܶ��':]I�ͭ���$J���+���݈**���W���Ǉ��Ay�}H:�^7[�8J������@�ڇu����N&ъ���ǿu~����ά^:EG��T��+G��q;���Qu�>���EE���Wb}��ڮ��w�m����4c��l�*��kj_��vM��5u��W�<����z�u�	\��;�����^      �   o  x���K��6��笢6P���ótϳ��$2M�� $%���._����J�~�?)�+�� �+�~��?���	��8x e6y���7'H��J`'%J"�G�R�l�_�I<H�"u:�3d?���R_�J���̐S���ڜ��@l� ��ci}�.`m���*d:��QΠ|@-��B%��\�4�$i���4#%E�`\h\Kt����ud �%RL_��\(ƵDv�UKS�|1�%E��7�и�萪�/2��1�%E񀮧|�Ƶ��<��O8�%�X�j=�8���8������U���oDK��P��2Ĉ�.T��,,�U#b:Q�&�>׹���.�4��G�"b�P9dl+SDL:,D���EU�9jDL'JxT�K���)}'Gʨ�� �Y�2j����LE1i�B��͈IQ����ΈI#���X`FJ�F������F6ó����x4�=߸�@펅�N+s\I��?��p\I�������q%9���`O8.%E�9½�q)-�ʨˌJ\J�ћ
�,q1-Tc�V����+{�q1-�K��9�Q����5�&EQ��Q3j�%�}�$�&C���pFM0m��έ�Q�f9=t�=t���Q���2�F�Qd�f	�͕�&P�����L�(��ýL-R�]hS���pWc�Bn�+6�:፶��]���	��LMܗ�H�F��s�:��]��3d��	<C�`z\M�u`US�G��	L���Z��&|@�'<��L4�ǯ��I��oTr����y�-�zZ_�c{����6;�,���9�$+�9);j�e�[�I6�Z�m�����������K�����0��8%q�u/���̇i���z���X�h�e�Z����f�i]Z�os,r�@���-T2��xON���?��N�|Oɰô�^�H}ϖ`������3�Ghk�[g��92���ۙ�K5�*�+��|C��[����p\XxX��`{�f�¸�м
Y�jѫ��qiY��h-!6zۑ���;��|dV8.�պӒ�;5M��K]��yQߚ�qy�.PZ#�u�J�F�eG�ݍ{J�5F~,Z���LEq��uP��t�]Uq���5Z��sU��r\f���*�vo^v��uF�_�.�C~W�A\hކD,@ޜ�4�+M�u�/�w�ĥ&��B��c]�q���[P�y�UkךX�i�{��*5�KM,.h�]�0���$ݯφ�ޞ�t7���D�Qޔ6���⨘�^�?J���Z�Z�l���9LO����2/Z2����>���bf%ͯW۰���ݮ�}�� �8�������v=ؽ�Gk��FwC��=��SM��|���p��l��3�p'��Q�ְ�n�D.�3�4��WC5��$h1���[���B-����z���U,��>�CB�mT��Mn�@��C�4HklҀN3CO[uh��Jѹ�q�|`Yt5wH��!A[�N+'ZW6��Θ��N�����q�x����[%�C� ��{C�B?K7�����X�֔&\tK��?�Z�5���+�F�c�#����g��N�h�9��U�M�}\iA Lw]p�lH]��^�#8|��q�/��Y,�P֔$��u�3�����rX�0�nx�Go�;�lDW*����0�	�$�!���ukY�`�r�IV=�e�ZJ`�)P9��e��֥��y<�'2����[�L����[�*bj)t*�ֽ�V����6o�� ,VN ^Ӟa-eW,����b5�s��uݴޮ�Fݺ��/6�nm�Y�MF<�٭��l�?60_g���%�Ih�8�f��K���z�k丼�m�7�v�&����w�e5��f�:#�v�W�gI�w���5����YB�2<���6�퉇���H�E��F;��*Y���l�a_s�(>4��l³_X�u�hm�A�G~���7B����>Xw`����-8�of%���}�l��!�GF_NT}����ug��8�'�J>�j��瑟��~s��b����W~$p��Ќ볈���nAX����u�f�<�S��o��n�F������N��O�ʟ�+?1����:��E�>$4�a�����7��߼ʕu�>!A��?/��7
azڇgcxTշV�%p���
�g�}?�_���ǋ�S����?���������'�#$�o���~�����ξ�      �   �   x��˱
�0 �������\�6٪qiK'A
V���~����G�L���$ ð��RP��Qb�6D�:'��� ���f5N����<�kDYj��д��,Wu{�T۲��ϝuJ$�H&Z��g���u7�Ǜ,��������t*$eX��6��:#6�����Bq            x������ � �      
   A   x�3�420��54�50R00�#΢��Ԃ����NC DRbhdelbeh�glaę������� *@�          0   x�3�4B#CK]C#]S΂�����bNccNc.��&@�=... ��Q      �      x������ � �         �  x���[n�0E��UpR9�&�[i��I�G���ll���@��n���X�V!$�`�@�{�șK ��V�2M�7���ٜ?�@��bRA�L��	�}df���v������5��p��6MK �A � U��1�^�*�덊3����*�U�*�U�Ք���B��M��g�tmWk��7��OM�������S�T,	%c�'�y[7Jۺq��c�����Һ������9NA�eV��8Y�hC_պ�N��8X��O�������?��Й�.�������ܷZ���`���A�F���1U��A�����Q(��l����#'��&�~і����c����<��6�5���v'c*�V�ڝ��+G��ִoyC����B��}����t��6e��6>��-(D*���P$1:���d�)��      '   x   x�3�tN,�,I��LI-HL���-u�t-93J��]���8�3K�9]�ʊJsS�J��bH��KҋR���9��J|J�3A��ʑE��1�t�IJ,J9�9��Ǧ>F��� �<R            x�3�tL/�Wp����#q��qqq ��           x���=n�0����� �@�釪ti�e1�A�\[5��U�ЋՍ�(K��m~?��p��j��ҿ?�B��������
�y�y�Xq�}�~�`ezm��GS���K���_��ԝn��:}�W�t9�.x�?����t���#�R!����fp5L��Z���=����UJ!�a�wv����8HJB���6hGN5�E�GLP�IVp3.�Ͱ���&�!C��8��·/����E�-4ae��RU�<N���HB���I��mL�qI�i            x�����,�420��54�50����� D�      8   F  x�՗MO�0��鯈r�����?`����&Y$v�/�]�߱� PC[gҴ�����Z�LC�dE��r"��)�58��Z�l�3���Yrgz�;��e.k.bju��[��q����Pa�t�dyƅԑ2��%��4Յ��խ��xs(�dJ�)	��I40ˀ�&�g�{Չ-�M	�f/)�j�68����'��?��GIEGI Q�VT�(��L�[*jE��˴o��<W;�6�K���}�OP���'(j71����(P��1Vw�F�:�S�Z�1��S`�4�B�:�1��S��;,��v/��s��h�:lۀ=o�a��5�[��Z�X��־-���1����0�������s�?si���O9�@R��BGa�*ջ�9qO�oO�N�[�ї\w�nK�pԩK���%x�����X&Z�O����U����k�ꗆE�b�q&J�B�UDW68-"=�V�<aB}�[� -���}�����]�� j�{ҤV� z ���
���EC��D�舢!��R�/Mn����>s�0��uJP��+!���]���� 1��ѯ:7IB���&���d2y���      !   Y  x����n�0���S�Bp%�)�C�MnF�]�h�T��C[Q�Qnېf���23���ׇ���Ǘg_����o�x�����.�o�F�����[*W4U$Q��\f���{[:�����l��U��ښmSTߊ:�o��#�+�JPLi'?֮9���q�*�f��>i_�J�ֶ:�|�[Ԡ9�k|�j}�/�+̅�x�aZ�(�xGz�8]p�29���0w���
��}�0DSI�(ǒp1f<ֿ�[u��޶��e��e����D�W�6��{��tն1n�R�9�}U�z����Xa���4��"'4�����X���]!�I%�ryU�վ�:��ጩ�J0�����3���S�}�6��ڝ���SS��T�8}��h��p���0]�a���e����D�3AFQ"oS@����.�G�ŘOaq���.�G	0ָ�g��`Ά�h�7k6{�X���ٜJ{,m@#8�*P\��r�������P�����*��r�e��~�/V[�.���&LNV4Q27�IB�Pu�0S�g~#PNI�������jA+EC},�"����Q��9+"�B���7�.=�;`��n��Q��C3rK�-�!>�����@��cS�K�����S��AR�ܿ-⎢�	�-�L2��a
��3��83��K)�d�]N�i/Wf�gK!Q|f3�����{����'å ������:���7�Ѝ�_��Ĉ�5rK �(]�>{kf�gs��$X:"��$wUd^ɹ��ᜨ6'e�<�ς|��h�s�B�0G�0*p�p��
�XL����C�!��e�4Ѫzmz`=vO�\��ip�	QM�� !��4؂�j��F>l9ᛛ������         [   x�m�;� �z9���@�݂ǰ#��h����`ꁱ�̴��h����d4��q��ˈ*$:��<�R�\&9)����:�:�����/0��      9      x������ � �      %   �	  x��˒�����S�&������I�pyW)m�:CgLLH���[��Ne��+�?͑�T��*&�r �F���w��w��a�r[����m?�������� l����D�4��1�d�ב6�rP�t������i=�����{�_��ݢ���������鯇Ks߮�s�ָ����/-�U��S�mi�Œu��ae,��N{���g����=��9}9v��-�	P�]�J�ϒ�e�9�ye(`;:�5�ȼF�	k�ew��G�E�}�!�@��R�Є\�#+@�Ő4���{�|~A��,�W�_���۳�S>���|f����"q��r�s�����0G��9X�L��R��Z�l#k�P��6uA�g�D�U잩=5e2����Z���z���G`�{FI�Y��P
kؚ"�p�0L�p����Ѣf��ֺȲ����˶u4,�W#d����4\sާ�p�F,$nÙ�]
|>4��"�C�h=$�.8
)�+�:k��=">�~�i֓�e��>�� 6��B�
v�}D_@Lb��=	f6�<�.��B���R��K�h�ll#�)Pvpt"�*�{HRP"P���u��^]�s��B�O^jG ��4	ޫ`L�G<�6���AG�p�0�c �V z�
mk�4,Q7`��I�P��ոo��Z��xr	��x�c��(��c�8".r��oP���	�!�|�(�(x�H�4�R@G�|� _��ԟf� d��A9yL�uG���o;�t��b1����?<Ӌ !
�d�%q�![�1j@\ ��3P�8YC
l��2� 4Ak&j"ϖ�~�_yڮ9�q6�q���BFD��͠C��~�<�	��K菨ˠ���/�u���9�L��\D�W�@`���+��u?���1���<v�c>��8_������6$mHڐ�!i��0m�<\��ϓ�_��s���~=��e\V��g�>f��B����\t�%��0w��V`�@�Z����
�R��#)���%a��)��:�"���j���)�a����:�+�Q��f�nz�]�'��&!wE�L1K��$���4��ܮFԈe���9��O�s4}l1����VC��],T4�����U_�j)��a�VLj���<⺁%-"�ESCn Q��d,IG�T�%�02\�to���g]�K����ydO_l�� �{[��9Y9C�*E��56dI_�R��N��A�NH��%��n���b�5��Ո�jo�I�4:����Zq-!���z��D��E�����*_¨1ez���	����tp�G;K�j$�a�v�z1�1�ytt�z%�ʮ@�`���;"u�əj��Q��L-�D�8��R�i�1��ę9�$�<%껱����*0Q::�b�!D@�l�v2.[��}�� #9��!g9>p$��*5h���T�+�`75:��s� 34*E��E�/�(!kX/&�r��*L�&$e����PyN��M�V!��Y�J�D(oz��@W�8e��D���u��e�;\�Y���H��9Pʨ;���2�=����}�*��;!�*A��JP����߯�����JH%�Rm�T����P֥u��<	�O[��sa������S�F[��t��e�N�^�%�j	�6B-�Ԋ�q-�x^��O�����RB)��P��
W�Vi�ۜN'���闆��S��,�����$x<	�O��_�y�����~�}�ߩ�� J%�Dm	QF.�N'��������8	�N�-��	�N'����4o�{���I�$p���ȉ������-�(ϻ��PB���_!TX~���m��VA� J%����|/�y��?��7y~X`%�X�VZ����OK>�9��M�&a�ؤ_H�����i�{�ڛ�|�Op%�\	���+=GV��}���������,�T	�U[A��̒��#g���I�$t��̕��]�}���R]n��R��@�^B�y�����I�$p8�NW�&/�8	�N[�-���Q�A��)�J	�6E�y*�sz'���icp�C�(p8	�N[����\�$p8mNA-����9?�쓀J@%�P� T�<E<A���ǵ����G�v��;�B,!�kS�2�ۇ���������'� K�%�������s���I�58�є��\�$p8mN�� /18	�N[��9�r���w�{yOpnYH%�R	�n@*��܀
�7yW��9p����Y��Y��-"+.k?ac.w�|�}��B*!��JHuR]y�]H�u�K?������PB(!�V�wѣ��2KD	�Q��M!�Q��Ns�	QV%�F	���(3�^�(� J �@��<��[��1���w'��`J0%����<��1˗:N'��m�dr�痷��ϻ�����q]�}���|���-��@�&�JWFTtyL�5����R	��TB���j��m�'���ikp�a��_�y��h�f      G      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      0   ;  x��͎\���姨�$J"���E��l�0�t�I�4�����-#���"H�|�֭KQ���:���>���۟�����Mb������(O�nϟ�~�����{�-�b�z��27	�q}y
���u�}^�/o�����_^�n��7+}�^�j6N��z��G�{�s�!Đ{�ܲ^1����v#����!3����}�5,���Z��%,F;�(Q~��]b��k<�]�-����$��S�L��eH�H�'��u�v�}݈�����szk#G]m�TeMɑ�F]!�Hh��:tD���IAVf�5�L�!m�a�D��}��V��W��W�g�8:�k^a�і�Nib#��4�3�4-}��{Ƽ�*��2Ү]:	Mô��5�WA��س������qkX?�a15��SF�Se�(S݄1m�N�:�S�b*��L��ȫ�<�	{�.5��p�
okiv���vf�'ȞW�b#���S*����*v��kֲ�T�#��~v7�����Cσ�,����S���]g���2H�����+j���$��'�XO��T��HZ2W�,m�X��4����̨�BU έ"�ZO�/e� �jf5��!��V�9�OmS���d:�JQG���{�,�yV�{Z�����,Z�;.�u���<�d"�R(+ʚ)YU��@R�eo����)�T+-Q�m�c4&���nJ���T�NKie�(������@�n��)~w�����}z}��r��~v���Z�ѻ�_.O1<I���??�����30ߢO)��;ԯ���a���7��&{�d��B�R�Y���}��>&DOn�>??�t��˾������O?������~����׾����;��������G������θRצ>�9��|QKC��IKR�x
e��gvmb�D�I�a�"W#�ǻ�3#c/f<=f!�e�zG\�0�F�j�8�F�;�w�s������\ ����W5���j�H��}x����NO1����7s�����|����wq�>�>��\�v�߾"��;�-�n$^�t~ 4��M�X2���vj�hr�D��fK�4[�}����A޻�ڕ6&�p����N͉�o�4�F��c(�O\k����;/�s�+�ׄ眽mrulŰc��͊��$�(`�f�k�
�.�\��Ƅxm׬��J���Od�W�x�u�3��b���+%cy{4�gC�=�������mM��^M�� � l�.e�ɻ �����@>����6e�1v�#�0��e���8U�{��pn�J�{���^O�Gk��sJx��ų������;Dn�JDb�v�AE/��=O�ؚ�"�0�9 cX胓̰�N�=f���fxf?�z��M��O�E�����Q7�P����t���I����9)�-a_�"����$1J^Ԯ���V��_/`�Ks���L�zÑt���d;^�aH������z)�ʥ9�Ku��<���e�*�v�"A'�5�̮ܕ�	��NE���M]�aDq�[֯ܭ���ɞ3��#Lr��'���y�	�N|��*��/�S��_���3���a:̅�%� p@��=��_����Շ�W^�      )   e  x����n�0Eף��(ɡh.�f������d�e����ȏ&�hؠn��<���2}��1%]�h�����+��Yβ\�޺�j�Ck_~�@&b���q~�v�%� �`"?Cx���ڕ錁���	P\� Ƒ#׸�L�3��4;Sn����k��J@�L�d\ *��9Ӊ��L�5e�{��>MRS��t�������}�,�Y��DI��rI��\�8ӶU$��%$@��
aҫ)��6���i}�]Y����"QdP8�(�(��]� �(��*�0�)����~��}�F��)�-�]�r�d�y:��&/R��%$�ǽ�'A������<��Q��R�E���>0A�| S#t�"�,�q�v]e������D�eV�v�(�^��^��`���}3�ҐQ�(���������O] ����`*�Rɛ�4�a�7��͸{CP�_��/,�Pi��+�0?H������P�heX���`��/>�XT_"E�
�P��Erf��
4Z�V(U��_�P�quQ_e�Íz����jXZ�o\�I�B_mk�o��e!ͪD5��ǁf*��7#q��$�?�&�      1   @   x�3202�50�50��(M�w	�4B.#��1H� ��$�(�����!�1N3�2�@�=... �      +   
  x���An� E��S��` ���Ⱦ�J�(v��ʦ9Ǥ�!�"]�h@���pR�����\���|f:np�h�q<�Ѻ1LIȸ��������8|���	����x	�YKJƮ�J�j;m`�쐎mX>RO��`��bM�Y�3����XSĜ*�5��d���trc�^�4 ��J,£���&g#����xx]�F\w�q�s���Z��/��G�jI�ԋ5�d�n��%�>d��L	U��v��BT��=h���s�sSU�'�v��      @   X   x�3�45�31 CSNC#=SN##]#]C�?8���� ��$�(��3�4=ߥ�Ӝ���$� ?>9�(=���2��b���� ��      5      x������ � �      B      x������ � �      >   F   x�3�4202�50�50���srvt��4000D��(M�w	�L�L�q��rZXX�[r��qqq ?�f      .   �  x����n�0���S�RX%����P`;���^c �;з%َ���j0m�M��-���?{��;v�N<�[�[%H��3�,`!��ĭ*�����Ў�����	�1�Vݹ�� 8~�v�V4�X��ձ#�t��yq����NY���4��f�i�uu/����s�G��`\�S�	����C����W�4�Ҩ@!���J�Pw8�����&B	�Hc��(�:�P�)l<���d�]ZS�J[�$Y$��e��q�i�z'&�r�ͫ�Z�]7��\��h�ܗ@*!��{�&i*{�$��yz��~�rN�Sz�� ��l��)�\w<��5�Ĥ��������z�wn���g��
���"��B��c���,sd���q���t��W�U*�dC���k W625��
��]Tl�g:�6�DZ	Mu[h�/�4�$���	I�D�xa]�B9'/Y�_V^&Z�Z�\(�qR4��3���Y�*��'>F���i牟�I��a�M��<t}<H��}ݞ���BNg�;��5mҳ�7�t����$�:�A�Ί�Y����)y6_�JFy�(�$V��&Jz�ll���G'�J����އ�b�-�L02_.�)��QK���=�üQ�����f���&      3   �  x���Mo�@��ï������c�XUi�ؽE�ְ![a�,��֮C�:r����̰<z�
w��eo�p.���q��� �a�+�9�Txcg��:1P�E� ���i�Ck:WY��#�"��c_��X��X|�Z[�:Nc��3�.���S��Y�t��N���[me���<B�Uј�T�0�����䀳o��V�q�`�L���h�,��`��5�J5����U�*�S�����K�O�����M����ՈR�x"�=�߱D\��ni�p�z�[|�p���`�Lә���Y#�P������nB,i�O
b.�$;j�(��)O?\��;��4������N��x4��]�E9T�j��R{D��y@����;	]avx���hz�x�_�
�cH��F_��	�u!J�����؈(�1!$b �x�Ӳ	?�>���E��q���l_8c�}�A>��݌�,�$ǅ�x���t���8��M-���,�_;sɅ      <      x�3����� Z �      6   $   x�3�4202�50�50���(M�w	�4����� O�i      ,   n   x�3202�50�54�,�/.I/J-�4�,�,ȏON,JO����|.#
]���s���*�u�T��UC��g���+$�����G�e��ed��%xT"����� �H;      :   N   x�3202�50�50�,�/.I/J-�4�,�,ȏON,JOt-N��M*�/�2"�2(�83�4�X! �$?'?=3�)F��� ��      #   <  x���_r�0Ɵק�p�d9��h��i��Ֆ�2��܆#p.�Ji�:��x�v�oZm>��G+;�;(r%�Q:��[@�J��R���)�Jٶ�4V�D�+IO��႕����W���J�U��5dPn NY3sz$����Ƽ�
��GɄ�!fo�$�ȅ3��	�"��ee�շ�Y��z!�e��Ѭq���׏�j%\+g�q�Rdd���)����f���Z~R��XU��}U�'�Z�dRmjPr�#2�@���Ә�}��C��R�Amמg6_��)K��������ۋR���!�W<텒#B���U�tA�s�r�@<�Nk�`�o?���_?�w���@$<���4�q�a.�4ױb����ވ[JD�C��jɴ�'��eU�N�&�a-|υ�?�yjV��8�V���d����<?���(�a5�0�5	�1Y\򦂋O/�J��.�[-�R��j��N��׆��V��th
λlM�gߙ�0~3�Y�~��Z+Ob�E*�,��g?�#7������3!�n�d��T���佖�lv�D2���K�/vx��YK�.J�FG(�i3�%�?��-=��H#�4����s�G�,�֨��pF�h�g��j?u�t�c����5v��p/^�x�豫x��T�܍-�iA�+�!aڜ6��2��$�$8M����bY>���c�z˜ۧ�4M"RZ�)N�P�j5�_൱V;�q�!��eP����=r�Y�C�:]�eȩ�9B��&�| �$�]tv^�̛7�b�ͱF�ܞrx7|��c��?t��9o�Q�gt��      �      x������ � �         T   x�3�t��+���,)�/�4400�4��(M��L�420��54�52�2�tN��������O/J��5Ū��0�����y1z\\\ �.�         �   x����
�0���+�)�$�vY�>@�h��h��%���օaV3�sa�������	�w���	��(�M:JG �qd��aJu]qD��)(��@)��_���)X�U�y�?�w�j@���/T��m�
��c�3�C)%�{�MV�t�^���.+�������V����9�m�yv
ծ���URH|�:�ʈ1v�Q�      �   �   x�eͱ� ���x
_��a:6�M��QG�+�����>}ն�Ё@��C[���*�6G���x�c�0���V9@��K�l��yU6׶�[�"L�_�Y7w���}�W�Q��I�i��ep�$�Z?�URO�QE��*R��(�X��f!��h5�,�8�@�ux,�������7e[|      D      x�3�43�2�43\1z\\\ !�      E      x�3�4��2�43����� �
         7   x�eʱ�0��ڷK��#��Kj�����YN�n�Ρ#7Vpw�/쿹�먪�qy      �   �  x����n�8��ݧ�2��p�$�a���$[�h��m��ڴT$�j����!	&��U���|�}l��0����(|���b��4M)����6A�v�\d[DF?g�AE��~�a"����v5� JΡ�m�E:�M���"~��IDh�]��/L�d��j�����`��a0�Q� �\ � l�ҧ���.�7ۃ|�cU�S�Q���6�6��W��nw�gjUƸ�-x.�t�yݿ	l�����Cu�v^���qQ4��Q/�du+��/`x  ��LGl-���� #w��΄ʎ�Rhu�/���%� �0�.����a�0��	��>	3�eĦb̀� sIB(&I�]���c�L�*��l3�N�q�u9Lq���. no'��7I�<vQ�%{O+�t�f������/	г�
�A�-	ڇv}�}���>�ڣ�5~'�����������$6�.�����.���ӑ����(���iwx.����R(n̴N�[W��'�R�*?��6n�D�8���G���T��!�x����ʩ��EAsc�n��#H|fY���6�C��}�^���^�����Η4�^�`�����A��̡[��'�bElI�5i��Q_Y�.>�dq	r�-N�q�*hE���]^F7�7M,Qb�Α��ǣ��M]���	�P�[��j'	b�8'���	�e�5�8 B��a�5��g8\&!⦹�T���?��`A
��g&�B���m�@1�~���6k��chZ箦���s�H���?&r�35���6���h��!@%��WK�*������%�&ʯ(Ȣ����P���o���Z�S0��Ҷ�i<YyRY���Qv��vŬ��!��3��m8��Iz!y�J����@�)���vk�/[�j��Wk��I	vj�M>c�c��n	��u�Ϩ�n�Xl�&�*ÕY�Xyr�����ֽ���L�?0�W1��y��ɜ���J��z��F��
g�<�!�Hu���H޿<���J�;_Mƣ��W���_V�����0VE��{��"̱�5O��Al��h����8	��(�wQ8k�+E�x�N<�:�}ɣJkk�9>�����&�R b1r�i:	c��y��R����|��hy�G���]�	� ;.H�mʗ�\-���������ӕ'j:�ƈ]�I��	��%P����fK���� ^;Z�^�Y���.��e:�G-��ꨫ�2����;��OO�y�;r����ϳ��qO��O]A�y����zwqp�.�U񩁙w�;���%X���f�����q0��e�#��D�z/��|񡗯���tm�ꥶ�oS�=Q�%�@�@�$'�7��n��h��e�M���`M��%���tE�l��4�:�H�A� �N�K��j��~Z��Ǆ��|���nnn�3��(      �   �  x���]N�0���.C��}	N�W�#�q�ĩX�։�˴��o��n1L� ���|~<�߿��ϖூ`Kd��:�B�I~&�')�T�x���x�i]�7��^��o	!��V�Td]Eju$��P⟵ ��w�SI��I��9	�+��jH]��:��PX�oU�2�7��f94v*�L84�NM��	�:�ND�FP��LP��7�=�'Ƴ!���bbU�[�|�R��_AAC2al\0\g�iW�lT���%�T�|�"?,�WLҌ��9TS�G@�H��9�������$��׺�h�%w�ClPT�6vu��+����bW*�� E%��e�ʋCoI5��.ga|�C:6~��"vllφ�3gSh(w�������@��ebb�¸�>#�Q9EYU�rzV[���x�|�
�� �_)�Y�KiSRپ������ ��Z�2j*�Y����>v���˶m?)�I         �  x����n�0���S�X3�㛡�.�*�^V�*���Jm�j���!)��Z��`1���{t
�۷�u�H	4R����N��BՎ�r�����-l��A���`x̃cʼ.|��q��+,�&�ֿ�M��L҆�Hg߅��-*L/�;i�������O	01eYBUUW��i�D5'���&��r��SY�fs���	G�D#�֧��������=������瀒�~Eؘ���6S����ד���V�d����ݓ`��>�_����y�u^o�uJ[#��M]�S%�.4���[/Vq���±48q蔍�)�G�
wu����-��uL��x�ي����'�����z�9_"�W,���=:���_4q�Э�����74�oz,��l6���4N�f����=<�B��N����H�(3��G#N��)}TQ}6��      �   /   x�3�,(�ON-�7�420��54�52�,�/.I/J-������� �
A         �  x���Q��0��˯�xi��H����O���q�&�Ӹ��?p�u����%��~L�|�tT�l��6k�ؒ=�Ee�t:e�=�������zj�g�	�9�"Ȳ�\]�+��i1��1fA�٬\�Me�?���m��'��=)��*P)m�)[7f�-l�t�g���D��a0��Ӝ��e6eQ�ݗ&��j�.s�TŶ���ON������E<y�_o��6ۏ�v{��	�""��g�ƋC�����Y��$�B/��?)�1�2&rD_$�	��=݊��|��u<����sgH/�<~䶵���^/oE6�d:�;?�������D<lt>%HIw��KH���ER@�{0��h|��棠�R�!�h�u���镎���ǈ-���E7�e� uv��ǃ-�H<�,"Z�x\�Ѳ�pD_b�/1ї��K��Q�#��}I��$D_�/	ї��KB�E}QD_�E�E}I�Nxj_��p1zRHg��� Zs��>��zwzi]Kx׆9��+��޴/��)L���N�6~�!�:\g��:���2�Z?����G�~.p�Z8��w�����l(�D��`F��-����������*��
h�������������rbˍ�,���#S ��¬l�*g�	�rSͶf�y�n�������e���U^,�5H�ͽ�Y�/;oʯp�ۘ���߂ �Z#.      �   g   x�3��uq�t���C #CK]CC]C΂�����bN33NC���	z̡zI�c�c������U��BPؐ�Д�ДD-f\�f$j1����� ��J      �   �   x��ұ
�0����.��k.i�b:T��&���vP��j��2��}�=2R`�<!JH`{:ow���ֶ�+�0of�j���z�}��Da�o���天�ͼ��b 	}�f�C�il�����V�b�CJ���V�T�C�@�+�M�_�C����!����B��7��߉�Xu�C��v8�aH���'�	rB\�;}�N���y�=�_�܍��H)� >dF�      �   J           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            K           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false            L           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                       false            M           1262    57611    tools    DATABASE     �   CREATE DATABASE tools WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Spanish_Argentina.1252' LC_CTYPE = 'Spanish_Argentina.1252';
    DROP DATABASE tools;
             postgres    false                        2615    65782    alm    SCHEMA        CREATE SCHEMA alm;
    DROP SCHEMA alm;
             postgres    false                        2615    57746    core    SCHEMA        CREATE SCHEMA core;
    DROP SCHEMA core;
             postgres    false            
            2615    164239    fis    SCHEMA        CREATE SCHEMA fis;
    DROP SCHEMA fis;
             postgres    false                        2615    57752    frm    SCHEMA        CREATE SCHEMA frm;
    DROP SCHEMA frm;
             postgres    false                        2615    115082    log    SCHEMA        CREATE SCHEMA log;
    DROP SCHEMA log;
             postgres    false                        2615    57612    prd    SCHEMA        CREATE SCHEMA prd;
    DROP SCHEMA prd;
             postgres    false                        2615    115083    sma    SCHEMA        CREATE SCHEMA sma;
    DROP SCHEMA sma;
             postgres    false            >           1255    82210 /   agregar_lote_articulo(bigint, double precision)    FUNCTION     ~  CREATE FUNCTION alm.agregar_lote_articulo(p_batch_id bigint, p_cantidad double precision) RETURNS character varying
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
       alm       postgres    false    13            F           1255    106975 ;   ajuste_detalle_ingresar(integer, integer, double precision)    FUNCTION     �  CREATE FUNCTION alm.ajuste_detalle_ingresar(p_ajus_id integer, p_lote_id integer, p_cantidad double precision) RETURNS integer
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
       alm       postgres    false    13            /           1255    82203 j   crear_lote_articulo(integer, integer, integer, character varying, double precision, date, integer, bigint)    FUNCTION       CREATE FUNCTION alm.crear_lote_articulo(p_prov_id integer, p_arti_id integer, p_depo_id integer, p_codigo character varying, p_cantidad double precision, p_fec_vencimiento date, p_empr_id integer, p_batch_id bigint) RETURNS character varying
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
       alm       postgres    false    13            <           1255    82207 /   extraer_lote_articulo(bigint, double precision)    FUNCTION     �  CREATE FUNCTION alm.extraer_lote_articulo(p_batch_id bigint, p_cantidad double precision) RETURNS character varying
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
       alm       postgres    false    13            =           1255    82205     obtener_existencia_batch(bigint)    FUNCTION     t  CREATE FUNCTION alm.obtener_existencia_batch(p_batch_id bigint) RETURNS double precision
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
       alm       postgres    false    13            ?           1255    74922    log(character varying) 	   PROCEDURE     *  CREATE PROCEDURE core.log(p_msg character varying)
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
       core       postgres    false    8            D           1255    115122    set_tabla_id_trg()    FUNCTION     �  CREATE FUNCTION core.set_tabla_id_trg() RETURNS trigger
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
       core       postgres    false    8            @           1255    98704    asociar_lote_hijo_trg()    FUNCTION     �
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
       prd       postgres    false    11            E           1255    98706 m   cambiar_recipiente(bigint, integer, integer, integer, character varying, character varying, double precision)    FUNCTION     �  CREATE FUNCTION prd.cambiar_recipiente(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision DEFAULT 0) RETURNS character varying
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
       prd       postgres    false    11            C           1255    98670 �   crear_lote(character varying, integer, integer, bigint, double precision, double precision, character varying, integer, integer, character varying, integer, character varying, date, integer, character varying)    FUNCTION     �   CREATE FUNCTION prd.crear_lote(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying DEFAULT 'false'::character varying, p_fec_vencimiento date DEFAULT NULL::date, p_recu_id integer DEFAULT NULL::integer, p_tipo_recurso character varying DEFAULT NULL::character varying) RETURNS character varying
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
       prd       postgres    false    11            A           1255    82227    crear_prd_recurso_trg()    FUNCTION     w  CREATE FUNCTION prd.crear_prd_recurso_trg() RETURNS trigger
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
       prd       postgres    false    11            B           1255    82228    eliminar_prd_recurso_trg()    FUNCTION     -  CREATE FUNCTION prd.eliminar_prd_recurso_trg() RETURNS trigger
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
       prd       postgres    false    11                       1259    106906    ajustes    TABLE     +  CREATE TABLE alm.ajustes (
    ajus_id integer NOT NULL,
    tipo_ajuste character varying,
    justificacion character varying,
    usuario_app character varying,
    empr_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE alm.ajustes;
       alm         postgres    false    13                       1259    106904    ajustes_ajus_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.ajustes_ajus_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE alm.ajustes_ajus_id_seq;
       alm       postgres    false    13    261            N           0    0    ajustes_ajus_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE alm.ajustes_ajus_id_seq OWNED BY alm.ajustes.ajus_id;
            alm       postgres    false    260            �            1259    74435    alm_articulos    TABLE     X  CREATE TABLE alm.alm_articulos (
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
       alm         postgres    false    13            �            1259    74433    alm_articulos_arti_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_articulos_arti_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE alm.alm_articulos_arti_id_seq;
       alm       postgres    false    222    13            O           0    0    alm_articulos_arti_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE alm.alm_articulos_arti_id_seq OWNED BY alm.alm_articulos.arti_id;
            alm       postgres    false    221            �            1259    74446    alm_depositos    TABLE     g  CREATE TABLE alm.alm_depositos (
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
       alm         postgres    false    13            �            1259    74444    alm_depositos_depo_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_depositos_depo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE alm.alm_depositos_depo_id_seq;
       alm       postgres    false    13    224            P           0    0    alm_depositos_depo_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE alm.alm_depositos_depo_id_seq OWNED BY alm.alm_depositos.depo_id;
            alm       postgres    false    223            �            1259    74617    alm_deta_entrega_materiales    TABLE     �  CREATE TABLE alm.alm_deta_entrega_materiales (
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
       alm         postgres    false    13            �            1259    74615 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq;
       alm       postgres    false    243    13            Q           0    0 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE alm.alm_deta_entrega_materiales_deen_id_seq OWNED BY alm.alm_deta_entrega_materiales.deen_id;
            alm       postgres    false    242            �            1259    74524    alm_deta_pedidos_materiales    TABLE     O  CREATE TABLE alm.alm_deta_pedidos_materiales (
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
       alm         postgres    false    13            �            1259    74522 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq;
       alm       postgres    false    13    234            R           0    0 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE alm.alm_deta_pedidos_materiales_depe_id_seq OWNED BY alm.alm_deta_pedidos_materiales.depe_id;
            alm       postgres    false    233            �            1259    74403    alm_deta_recepcion_materiales    TABLE     �  CREATE TABLE alm.alm_deta_recepcion_materiales (
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
       alm         postgres    false    13            �            1259    74401 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 =   DROP SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq;
       alm       postgres    false    220    13            S           0    0 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE OWNED BY     q   ALTER SEQUENCE alm.alm_deta_recepcion_materiales_dere_id_seq OWNED BY alm.alm_deta_recepcion_materiales.dere_id;
            alm       postgres    false    219            �            1259    74544    alm_entrega_materiales    TABLE     �  CREATE TABLE alm.alm_entrega_materiales (
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
       alm         postgres    false    13            �            1259    74542 "   alm_entrega_materiales_enma_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_entrega_materiales_enma_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE alm.alm_entrega_materiales_enma_id_seq;
       alm       postgres    false    236    13            T           0    0 "   alm_entrega_materiales_enma_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE alm.alm_entrega_materiales_enma_id_seq OWNED BY alm.alm_entrega_materiales.enma_id;
            alm       postgres    false    235            �            1259    74562 	   alm_lotes    TABLE       CREATE TABLE alm.alm_lotes (
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
       alm         postgres    false    13            �            1259    74560    alm_lotes_lote_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_lotes_lote_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE alm.alm_lotes_lote_id_seq;
       alm       postgres    false    238    13            U           0    0    alm_lotes_lote_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE alm.alm_lotes_lote_id_seq OWNED BY alm.alm_lotes.lote_id;
            alm       postgres    false    237            �            1259    74465    alm_pedidos_materiales    TABLE     �  CREATE TABLE alm.alm_pedidos_materiales (
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
       alm         postgres    false    13            �            1259    74463 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_pedidos_materiales_pema_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE alm.alm_pedidos_materiales_pema_id_seq;
       alm       postgres    false    13    226            V           0    0 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE alm.alm_pedidos_materiales_pema_id_seq OWNED BY alm.alm_pedidos_materiales.pema_id;
            alm       postgres    false    225            �            1259    74483    alm_proveedores    TABLE       CREATE TABLE alm.alm_proveedores (
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
       alm         postgres    false    13            �            1259    74585    alm_proveedores_articulos    TABLE     k   CREATE TABLE alm.alm_proveedores_articulos (
    prov_id integer NOT NULL,
    arti_id integer NOT NULL
);
 *   DROP TABLE alm.alm_proveedores_articulos;
       alm         postgres    false    13            �            1259    74481    alm_proveedores_prov_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_proveedores_prov_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE alm.alm_proveedores_prov_id_seq;
       alm       postgres    false    228    13            W           0    0    alm_proveedores_prov_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE alm.alm_proveedores_prov_id_seq OWNED BY alm.alm_proveedores.prov_id;
            alm       postgres    false    227            �            1259    74602    alm_recepcion_materiales    TABLE     h  CREATE TABLE alm.alm_recepcion_materiales (
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
       alm         postgres    false    13            �            1259    74600 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.alm_recepcion_materiales_rema_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 8   DROP SEQUENCE alm.alm_recepcion_materiales_rema_id_seq;
       alm       postgres    false    241    13            X           0    0 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE OWNED BY     g   ALTER SEQUENCE alm.alm_recepcion_materiales_rema_id_seq OWNED BY alm.alm_recepcion_materiales.rema_id;
            alm       postgres    false    240                       1259    106938    deta_ajustes    TABLE       CREATE TABLE alm.deta_ajustes (
    deaj_id integer NOT NULL,
    cantidad double precision,
    empr_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER,
    lote_id integer,
    ajus_id integer NOT NULL
);
    DROP TABLE alm.deta_ajustes;
       alm         postgres    false    13                       1259    106936    deta_ajustes_deaj_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.deta_ajustes_deaj_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE alm.deta_ajustes_deaj_id_seq;
       alm       postgres    false    263    13            Y           0    0    deta_ajustes_deaj_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE alm.deta_ajustes_deaj_id_seq OWNED BY alm.deta_ajustes.deaj_id;
            alm       postgres    false    262            �            1259    74501    items    TABLE     G  CREATE TABLE alm.items (
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
       alm         postgres    false    13            �            1259    74499    items_item_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.items_item_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE alm.items_item_id_seq;
       alm       postgres    false    230    13            Z           0    0    items_item_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE alm.items_item_id_seq OWNED BY alm.items.item_id;
            alm       postgres    false    229            �            1259    74514 
   utl_tablas    TABLE       CREATE TABLE alm.utl_tablas (
    tabl_id integer NOT NULL,
    tabla character varying(50),
    valor character varying(50),
    descripcion character varying(200),
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
    DROP TABLE alm.utl_tablas;
       alm         postgres    false    13            �            1259    74512    utl_tablas_tabl_id_seq    SEQUENCE     �   CREATE SEQUENCE alm.utl_tablas_tabl_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE alm.utl_tablas_tabl_id_seq;
       alm       postgres    false    13    232            [           0    0    utl_tablas_tabl_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE alm.utl_tablas_tabl_id_seq OWNED BY alm.utl_tablas.tabl_id;
            alm       postgres    false    231                       1259    115211    departamentos    TABLE     �   CREATE TABLE core.departamentos (
    depa_id integer NOT NULL,
    nombre character varying NOT NULL,
    descripcion character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
    DROP TABLE core.departamentos;
       core         postgres    false    8                       1259    115209    departamentos_depa_id_seq    SEQUENCE     �   CREATE SEQUENCE core.departamentos_depa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE core.departamentos_depa_id_seq;
       core       postgres    false    8    270            \           0    0    departamentos_depa_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE core.departamentos_depa_id_seq OWNED BY core.departamentos.depa_id;
            core       postgres    false    269            �            1259    74708    empresas    TABLE     �  CREATE TABLE core.empresas (
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
       core       postgres    false    8    247            ]           0    0    empresas_empr_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE core.empresas_empr_id_seq OWNED BY core.empresas.empr_id;
            core       postgres    false    246            �            1259    98621    equipos    TABLE     X  CREATE TABLE core.equipos (
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
       core       postgres    false    8    254            ^           0    0    equipos_equi_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE core.equipos_equi_id_seq OWNED BY core.equipos.equi_id;
            core       postgres    false    253            �            1259    74914    log    TABLE     S   CREATE TABLE core.log (
    msg character varying,
    fecha date DEFAULT now()
);
    DROP TABLE core.log;
       core         postgres    false    8                       1259    123290 	   snapshots    TABLE     �   CREATE TABLE core.snapshots (
    id integer NOT NULL,
    snap_id character varying,
    data text,
    fec_alta date DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
    DROP TABLE core.snapshots;
       core         postgres    false    8                       1259    123288    snapshots_id_seq    SEQUENCE     �   CREATE SEQUENCE core.snapshots_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE core.snapshots_id_seq;
       core       postgres    false    287    8            _           0    0    snapshots_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE core.snapshots_id_seq OWNED BY core.snapshots.id;
            core       postgres    false    286                       1259    115109    tablas    TABLE     �  CREATE TABLE core.tablas (
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
       core         postgres    false    8                       1259    98651    transportistas    TABLE       CREATE TABLE core.transportistas (
    cuit character varying NOT NULL,
    razon_social character varying NOT NULL,
    direccion character varying(500) NOT NULL,
    fec_alta timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    eliminado boolean DEFAULT false
);
     DROP TABLE core.transportistas;
       core         postgres    false    8                        1259    123300    transportistas_tipo_residuos    TABLE     �   CREATE TABLE core.transportistas_tipo_residuos (
    tran_id integer NOT NULL,
    tire_id integer NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL
);
 .   DROP TABLE core.transportistas_tipo_residuos;
       core         postgres    false    8                       1259    115192    zonas    TABLE     r  CREATE TABLE core.zonas (
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
       core         postgres    false    8                       1259    115190    zonas_zona_id_seq    SEQUENCE     �   CREATE SEQUENCE core.zonas_zona_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE core.zonas_zona_id_seq;
       core       postgres    false    268    8            `           0    0    zonas_zona_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE core.zonas_zona_id_seq OWNED BY core.zonas.zona_id;
            core       postgres    false    267            .           1259    164242    actas_infraccion    TABLE     �  CREATE TABLE fis.actas_infraccion (
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
       fis         postgres    false    10            -           1259    164240    acta_infraccion_acin_id_seq    SEQUENCE     �   CREATE SEQUENCE fis.acta_infraccion_acin_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE fis.acta_infraccion_acin_id_seq;
       fis       postgres    false    10    302            a           0    0    acta_infraccion_acin_id_seq    SEQUENCE OWNED BY     V   ALTER SEQUENCE fis.acta_infraccion_acin_id_seq OWNED BY fis.actas_infraccion.acin_id;
            fis       postgres    false    301            �            1259    57782    formularios    TABLE        CREATE TABLE frm.formularios (
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
       frm       postgres    false    214    6            b           0    0    formularios_form_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE frm.formularios_form_id_seq OWNED BY frm.formularios.form_id;
            frm       postgres    false    213            �            1259    57799    instancias_items    TABLE     �  CREATE TABLE frm.instancias_items (
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
       frm       postgres    false    216    6            c           0    0    instancias_items_init_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE frm.instancias_items_init_id_seq OWNED BY frm.instancias_items.init_id;
            frm       postgres    false    215            �            1259    57818    items    TABLE     G  CREATE TABLE frm.items (
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
       frm       postgres    false    218    6            d           0    0    items_item_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE frm.items_item_id_seq OWNED BY frm.items.item_id;
            frm       postgres    false    217                       1259    115360    choferes    TABLE     �  CREATE TABLE log.choferes (
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
       log         postgres    false    5                       1259    115358    choferes_chof_id_seq    SEQUENCE     �   CREATE SEQUENCE log.choferes_chof_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE log.choferes_chof_id_seq;
       log       postgres    false    279    5            e           0    0    choferes_chof_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE log.choferes_chof_id_seq OWNED BY log.choferes.chof_id;
            log       postgres    false    278                       1259    115230 	   circuitos    TABLE     b  CREATE TABLE log.circuitos (
    circ_id integer NOT NULL,
    codigo character varying,
    descripcion character varying,
    imagen bytea,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    chof_id integer,
    vehi_id integer,
    zona_id integer
);
    DROP TABLE log.circuitos;
       log         postgres    false    5                       1259    115228    circuitos_circu_id_seq    SEQUENCE     �   CREATE SEQUENCE log.circuitos_circu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE log.circuitos_circu_id_seq;
       log       postgres    false    272    5            f           0    0    circuitos_circu_id_seq    SEQUENCE OWNED BY     J   ALTER SEQUENCE log.circuitos_circu_id_seq OWNED BY log.circuitos.circ_id;
            log       postgres    false    271                       1259    115416    circuitos_puntos_criticos    TABLE     �   CREATE TABLE log.circuitos_puntos_criticos (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    circ_id integer NOT NULL,
    pucr_id integer NOT NULL,
    eliminado smallint DEFAULT 0 NOT NULL
);
 *   DROP TABLE log.circuitos_puntos_criticos;
       log         postgres    false    5                       1259    115274    contenedores    TABLE     �  CREATE TABLE log.contenedores (
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
    reci_id integer NOT NULL,
    anio_elaboracion date DEFAULT now()
);
    DROP TABLE log.contenedores;
       log         postgres    false    5                       1259    115272    containers_cont_id_seq    SEQUENCE     �   CREATE SEQUENCE log.containers_cont_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE log.containers_cont_id_seq;
       log       postgres    false    5    274            g           0    0    containers_cont_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE log.containers_cont_id_seq OWNED BY log.contenedores.cont_id;
            log       postgres    false    273            '           1259    139700    contenedores_entregados    TABLE     �  CREATE TABLE log.contenedores_entregados (
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
    tica_id character varying
);
 (   DROP TABLE log.contenedores_entregados;
       log         postgres    false    5            &           1259    139698 #   contenedores_entregados_coen_id_seq    SEQUENCE     �   CREATE SEQUENCE log.contenedores_entregados_coen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE log.contenedores_entregados_coen_id_seq;
       log       postgres    false    295    5            h           0    0 #   contenedores_entregados_coen_id_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE log.contenedores_entregados_coen_id_seq OWNED BY log.contenedores_entregados.coen_id;
            log       postgres    false    294                       1259    115527    deta_solicitudes_contenedor    TABLE     0  CREATE TABLE log.deta_solicitudes_contenedor (
    desc_id integer NOT NULL,
    cantidad integer NOT NULL,
    otro character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying NOT NULL,
    usuario_app character varying NOT NULL,
    tica_id character varying NOT NULL
);
 ,   DROP TABLE log.deta_solicitudes_contenedor;
       log         postgres    false    5                       1259    115525 '   deta_solicitudes_contenedor_desc_id_seq    SEQUENCE     �   CREATE SEQUENCE log.deta_solicitudes_contenedor_desc_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE log.deta_solicitudes_contenedor_desc_id_seq;
       log       postgres    false    284    5            i           0    0 '   deta_solicitudes_contenedor_desc_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE log.deta_solicitudes_contenedor_desc_id_seq OWNED BY log.deta_solicitudes_contenedor.desc_id;
            log       postgres    false    283            )           1259    147852    incidencias    TABLE     ]   CREATE TABLE log.incidencias (
    inci_id integer NOT NULL,
    ortr_id integer NOT NULL
);
    DROP TABLE log.incidencias;
       log         postgres    false    5            (           1259    147850    incidencias_inci_id_seq    SEQUENCE     �   CREATE SEQUENCE log.incidencias_inci_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE log.incidencias_inci_id_seq;
       log       postgres    false    5    297            j           0    0    incidencias_inci_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE log.incidencias_inci_id_seq OWNED BY log.incidencias.inci_id;
            log       postgres    false    296            %           1259    139666    ordenes_transporte    TABLE     �  CREATE TABLE log.ordenes_transporte (
    ortr_id integer NOT NULL,
    fec_retiro date NOT NULL,
    estado character varying NOT NULL,
    caseid character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    difi_id character varying NOT NULL,
    sotr_id integer NOT NULL,
    equi_id integer NOT NULL,
    chof_id character varying NOT NULL,
    CONSTRAINT ordenes_transporte_check CHECK ((((estado)::text = 'EN_TRANSITO'::text) OR ((estado)::text = 'INGRESADO'::text) OR ((estado)::text = 'DESCARGADO'::text) OR ((estado)::text = 'INFRACCION'::text) OR ((estado)::text = 'EGRESADO'::text)))
);
 #   DROP TABLE log.ordenes_transporte;
       log         postgres    false    5            $           1259    139664    ordenes_transporte_ortr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.ordenes_transporte_ortr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE log.ordenes_transporte_ortr_id_seq;
       log       postgres    false    5    293            k           0    0    ordenes_transporte_ortr_id_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE log.ordenes_transporte_ortr_id_seq OWNED BY log.ordenes_transporte.ortr_id;
            log       postgres    false    292                       1259    115325    puntos_criticos    TABLE     �  CREATE TABLE log.puntos_criticos (
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
       log         postgres    false    5                       1259    115323    puntos_criticos_pucr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.puntos_criticos_pucr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE log.puntos_criticos_pucr_id_seq;
       log       postgres    false    5    277            l           0    0    puntos_criticos_pucr_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE log.puntos_criticos_pucr_id_seq OWNED BY log.puntos_criticos.pucr_id;
            log       postgres    false    276                       1259    115453    solicitantes_transporte    TABLE     n  CREATE TABLE log.solicitantes_transporte (
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
    eliminado integer DEFAULT 0 NOT NULL,
    depa_id integer
);
 (   DROP TABLE log.solicitantes_transporte;
       log         postgres    false    5                       1259    115451 #   solicitantes_transporte_sotr_id_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitantes_transporte_sotr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE log.solicitantes_transporte_sotr_id_seq;
       log       postgres    false    5    282            m           0    0 #   solicitantes_transporte_sotr_id_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE log.solicitantes_transporte_sotr_id_seq OWNED BY log.solicitantes_transporte.sotr_id;
            log       postgres    false    281            #           1259    139660    solicitudes_contenedores    TABLE     L   CREATE TABLE log.solicitudes_contenedores (
    soco_id integer NOT NULL
);
 )   DROP TABLE log.solicitudes_contenedores;
       log         postgres    false    5            "           1259    139658 $   solicitudes_contenedores_soco_id_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitudes_contenedores_soco_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 8   DROP SEQUENCE log.solicitudes_contenedores_soco_id_seq;
       log       postgres    false    291    5            n           0    0 $   solicitudes_contenedores_soco_id_seq    SEQUENCE OWNED BY     g   ALTER SEQUENCE log.solicitudes_contenedores_soco_id_seq OWNED BY log.solicitudes_contenedores.soco_id;
            log       postgres    false    290            *           1259    147858    solicitudes_retiro_seq    SEQUENCE     �   CREATE SEQUENCE log.solicitudes_retiro_seq
    START WITH 6
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;
 *   DROP SEQUENCE log.solicitudes_retiro_seq;
       log       postgres    false    5                       1259    115548    solicitudes_retiro    TABLE     /  CREATE TABLE log.solicitudes_retiro (
    sore_id integer DEFAULT nextval('log.solicitudes_retiro_seq'::regclass) NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    usuario_app character varying NOT NULL,
    sotr_id integer NOT NULL
);
 #   DROP TABLE log.solicitudes_retiro;
       log         postgres    false    298    5                       1259    115299    tipos_carga_circuitos    TABLE     �   CREATE TABLE log.tipos_carga_circuitos (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    circ_id integer NOT NULL,
    tica_id character varying NOT NULL
);
 &   DROP TABLE log.tipos_carga_circuitos;
       log         postgres    false    5            !           1259    123308    tipos_carga_transportistas    TABLE     �   CREATE TABLE log.tipos_carga_transportistas (
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    tran_id integer NOT NULL,
    tica_id character varying NOT NULL
);
 +   DROP TABLE log.tipos_carga_transportistas;
       log         postgres    false    5            
           1259    115162    transportistas    TABLE     o  CREATE TABLE log.transportistas (
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
    cuit character varying(13)
);
    DROP TABLE log.transportistas;
       log         postgres    false    5            	           1259    115160    transportistas_tran_id_seq    SEQUENCE     �   CREATE SEQUENCE log.transportistas_tran_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE log.transportistas_tran_id_seq;
       log       postgres    false    266    5            o           0    0    transportistas_tran_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE log.transportistas_tran_id_seq OWNED BY log.transportistas.tran_id;
            log       postgres    false    265            �            1259    57723    costos    TABLE       CREATE TABLE prd.costos (
    fec_vigencia date NOT NULL,
    valor money NOT NULL,
    umed character varying,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    recu_id integer NOT NULL,
    empr_id integer
);
    DROP TABLE prd.costos;
       prd         postgres    false    11            �            1259    98636    empaque    TABLE     N  CREATE TABLE prd.empaque (
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
       prd         postgres    false    11            p           0    0    COLUMN empaque.eliminado    COMMENT     4   COMMENT ON COLUMN prd.empaque.eliminado IS 'false';
            prd       postgres    false    255                        1259    98639    empaque_empa_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.empaque_empa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE prd.empaque_empa_id_seq;
       prd       postgres    false    255    11            q           0    0    empaque_empa_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE prd.empaque_empa_id_seq OWNED BY prd.empaque.empa_id;
            prd       postgres    false    256            �            1259    74635    establecimientos    TABLE     r  CREATE TABLE prd.establecimientos (
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
       prd         postgres    false    11            �            1259    74633    establecimientos_esta_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.establecimientos_esta_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE prd.establecimientos_esta_id_seq;
       prd       postgres    false    11    245            r           0    0    establecimientos_esta_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE prd.establecimientos_esta_id_seq OWNED BY prd.establecimientos.esta_id;
            prd       postgres    false    244            �            1259    57630    etapas    TABLE     �  CREATE TABLE prd.etapas (
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
       prd         postgres    false    11            �            1259    57628    etapas_etap_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.etapas_etap_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE prd.etapas_etap_id_seq;
       prd       postgres    false    205    11            s           0    0    etapas_etap_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE prd.etapas_etap_id_seq OWNED BY prd.etapas.etap_id;
            prd       postgres    false    204            +           1259    147874    etapas_materiales    TABLE     c   CREATE TABLE prd.etapas_materiales (
    etap_id integer NOT NULL,
    arti_id integer NOT NULL
);
 "   DROP TABLE prd.etapas_materiales;
       prd         postgres    false    11            ,           1259    147885    etapas_productos    TABLE     b   CREATE TABLE prd.etapas_productos (
    etap_id integer NOT NULL,
    arti_id integer NOT NULL
);
 !   DROP TABLE prd.etapas_productos;
       prd         postgres    false    11                       1259    98674    fraccionamientos    TABLE       CREATE TABLE prd.fraccionamientos (
    frac_id integer NOT NULL,
    recu_id integer NOT NULL,
    empa_id integer NOT NULL,
    cantidad double precision NOT NULL,
    fecha date DEFAULT now() NOT NULL,
    eliminado boolean DEFAULT false NOT NULL,
    empr_id integer NOT NULL
);
 !   DROP TABLE prd.fraccionamientos;
       prd         postgres    false    11                       1259    98672    fraccionamientos_frac_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.fraccionamientos_frac_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE prd.fraccionamientos_frac_id_seq;
       prd       postgres    false    11    259            t           0    0    fraccionamientos_frac_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE prd.fraccionamientos_frac_id_seq OWNED BY prd.fraccionamientos.frac_id;
            prd       postgres    false    258            �            1259    57652    lotes    TABLE     �  CREATE TABLE prd.lotes (
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
       prd         postgres    false    11            �            1259    57650    lotes_batch_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.lotes_batch_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE prd.lotes_batch_id_seq;
       prd       postgres    false    11    207            u           0    0    lotes_batch_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE prd.lotes_batch_id_seq OWNED BY prd.lotes.batch_id;
            prd       postgres    false    206            �            1259    57700    lotes_hijos    TABLE     Y  CREATE TABLE prd.lotes_hijos (
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
       prd         postgres    false    11            �            1259    74786    movimientos_trasportes    TABLE     �  CREATE TABLE prd.movimientos_trasportes (
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
       prd         postgres    false    11            �            1259    74784 "   movimientos_trasportes_motr_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.movimientos_trasportes_motr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE prd.movimientos_trasportes_motr_id_seq;
       prd       postgres    false    250    11            v           0    0 "   movimientos_trasportes_motr_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE prd.movimientos_trasportes_motr_id_seq OWNED BY prd.movimientos_trasportes.motr_id;
            prd       postgres    false    249            �            1259    57615    procesos    TABLE     �   CREATE TABLE prd.procesos (
    proc_id integer NOT NULL,
    nombre character varying NOT NULL,
    fec_alta date DEFAULT now() NOT NULL,
    usuario character varying DEFAULT CURRENT_USER NOT NULL,
    empr_id integer
);
    DROP TABLE prd.procesos;
       prd         postgres    false    11            �            1259    57613    productos_prod_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.productos_prod_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE prd.productos_prod_id_seq;
       prd       postgres    false    11    203            w           0    0    productos_prod_id_seq    SEQUENCE OWNED BY     H   ALTER SEQUENCE prd.productos_prod_id_seq OWNED BY prd.procesos.proc_id;
            prd       postgres    false    202            �            1259    74759    recipientes    TABLE     �  CREATE TABLE prd.recipientes (
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
       prd         postgres    false    11            �            1259    74867    recipiente_reci_id_seq    SEQUENCE     |   CREATE SEQUENCE prd.recipiente_reci_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE prd.recipiente_reci_id_seq;
       prd       postgres    false    11    248            x           0    0    recipiente_reci_id_seq    SEQUENCE OWNED BY     L   ALTER SEQUENCE prd.recipiente_reci_id_seq OWNED BY prd.recipientes.reci_id;
            prd       postgres    false    251            �            1259    57670    recursos    TABLE     E  CREATE TABLE prd.recursos (
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
       prd         postgres    false    11            �            1259    57682    recursos_lotes    TABLE     H  CREATE TABLE prd.recursos_lotes (
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
       prd         postgres    false    11            �            1259    57668    recursos_recu_id_seq    SEQUENCE     �   CREATE SEQUENCE prd.recursos_recu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE prd.recursos_recu_id_seq;
       prd       postgres    false    11    209            y           0    0    recursos_recu_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE prd.recursos_recu_id_seq OWNED BY prd.recursos.recu_id;
            prd       postgres    false    208            i           2604    106909    ajustes ajus_id    DEFAULT     l   ALTER TABLE ONLY alm.ajustes ALTER COLUMN ajus_id SET DEFAULT nextval('alm.ajustes_ajus_id_seq'::regclass);
 ;   ALTER TABLE alm.ajustes ALTER COLUMN ajus_id DROP DEFAULT;
       alm       postgres    false    260    261    261                       2604    74438    alm_articulos arti_id    DEFAULT     x   ALTER TABLE ONLY alm.alm_articulos ALTER COLUMN arti_id SET DEFAULT nextval('alm.alm_articulos_arti_id_seq'::regclass);
 A   ALTER TABLE alm.alm_articulos ALTER COLUMN arti_id DROP DEFAULT;
       alm       postgres    false    222    221    222                       2604    74449    alm_depositos depo_id    DEFAULT     x   ALTER TABLE ONLY alm.alm_depositos ALTER COLUMN depo_id SET DEFAULT nextval('alm.alm_depositos_depo_id_seq'::regclass);
 A   ALTER TABLE alm.alm_depositos ALTER COLUMN depo_id DROP DEFAULT;
       alm       postgres    false    223    224    224            J           2604    74620 #   alm_deta_entrega_materiales deen_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_entrega_materiales ALTER COLUMN deen_id SET DEFAULT nextval('alm.alm_deta_entrega_materiales_deen_id_seq'::regclass);
 O   ALTER TABLE alm.alm_deta_entrega_materiales ALTER COLUMN deen_id DROP DEFAULT;
       alm       postgres    false    243    242    243            9           2604    74527 #   alm_deta_pedidos_materiales depe_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales ALTER COLUMN depe_id SET DEFAULT nextval('alm.alm_deta_pedidos_materiales_depe_id_seq'::regclass);
 O   ALTER TABLE alm.alm_deta_pedidos_materiales ALTER COLUMN depe_id DROP DEFAULT;
       alm       postgres    false    234    233    234                       2604    74406 %   alm_deta_recepcion_materiales dere_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales ALTER COLUMN dere_id SET DEFAULT nextval('alm.alm_deta_recepcion_materiales_dere_id_seq'::regclass);
 Q   ALTER TABLE alm.alm_deta_recepcion_materiales ALTER COLUMN dere_id DROP DEFAULT;
       alm       postgres    false    219    220    220            <           2604    74547    alm_entrega_materiales enma_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_entrega_materiales ALTER COLUMN enma_id SET DEFAULT nextval('alm.alm_entrega_materiales_enma_id_seq'::regclass);
 J   ALTER TABLE alm.alm_entrega_materiales ALTER COLUMN enma_id DROP DEFAULT;
       alm       postgres    false    236    235    236            B           2604    74565    alm_lotes lote_id    DEFAULT     p   ALTER TABLE ONLY alm.alm_lotes ALTER COLUMN lote_id SET DEFAULT nextval('alm.alm_lotes_lote_id_seq'::regclass);
 =   ALTER TABLE alm.alm_lotes ALTER COLUMN lote_id DROP DEFAULT;
       alm       postgres    false    237    238    238            %           2604    74468    alm_pedidos_materiales pema_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_pedidos_materiales ALTER COLUMN pema_id SET DEFAULT nextval('alm.alm_pedidos_materiales_pema_id_seq'::regclass);
 J   ALTER TABLE alm.alm_pedidos_materiales ALTER COLUMN pema_id DROP DEFAULT;
       alm       postgres    false    226    225    226            +           2604    74486    alm_proveedores prov_id    DEFAULT     |   ALTER TABLE ONLY alm.alm_proveedores ALTER COLUMN prov_id SET DEFAULT nextval('alm.alm_proveedores_prov_id_seq'::regclass);
 C   ALTER TABLE alm.alm_proveedores ALTER COLUMN prov_id DROP DEFAULT;
       alm       postgres    false    227    228    228            G           2604    74605     alm_recepcion_materiales rema_id    DEFAULT     �   ALTER TABLE ONLY alm.alm_recepcion_materiales ALTER COLUMN rema_id SET DEFAULT nextval('alm.alm_recepcion_materiales_rema_id_seq'::regclass);
 L   ALTER TABLE alm.alm_recepcion_materiales ALTER COLUMN rema_id DROP DEFAULT;
       alm       postgres    false    241    240    241            l           2604    106941    deta_ajustes deaj_id    DEFAULT     v   ALTER TABLE ONLY alm.deta_ajustes ALTER COLUMN deaj_id SET DEFAULT nextval('alm.deta_ajustes_deaj_id_seq'::regclass);
 @   ALTER TABLE alm.deta_ajustes ALTER COLUMN deaj_id DROP DEFAULT;
       alm       postgres    false    262    263    263            3           2604    74504    items item_id    DEFAULT     h   ALTER TABLE ONLY alm.items ALTER COLUMN item_id SET DEFAULT nextval('alm.items_item_id_seq'::regclass);
 9   ALTER TABLE alm.items ALTER COLUMN item_id DROP DEFAULT;
       alm       postgres    false    230    229    230            6           2604    74517    utl_tablas tabl_id    DEFAULT     r   ALTER TABLE ONLY alm.utl_tablas ALTER COLUMN tabl_id SET DEFAULT nextval('alm.utl_tablas_tabl_id_seq'::regclass);
 >   ALTER TABLE alm.utl_tablas ALTER COLUMN tabl_id DROP DEFAULT;
       alm       postgres    false    232    231    232            z           2604    115214    departamentos depa_id    DEFAULT     z   ALTER TABLE ONLY core.departamentos ALTER COLUMN depa_id SET DEFAULT nextval('core.departamentos_depa_id_seq'::regclass);
 B   ALTER TABLE core.departamentos ALTER COLUMN depa_id DROP DEFAULT;
       core       postgres    false    270    269    270            O           2604    74711    empresas empr_id    DEFAULT     p   ALTER TABLE ONLY core.empresas ALTER COLUMN empr_id SET DEFAULT nextval('core.empresas_empr_id_seq'::regclass);
 =   ALTER TABLE core.empresas ALTER COLUMN empr_id DROP DEFAULT;
       core       postgres    false    247    246    247            ]           2604    98624    equipos equi_id    DEFAULT     n   ALTER TABLE ONLY core.equipos ALTER COLUMN equi_id SET DEFAULT nextval('core.equipos_equi_id_seq'::regclass);
 <   ALTER TABLE core.equipos ALTER COLUMN equi_id DROP DEFAULT;
       core       postgres    false    254    253    254            �           2604    123293    snapshots id    DEFAULT     h   ALTER TABLE ONLY core.snapshots ALTER COLUMN id SET DEFAULT nextval('core.snapshots_id_seq'::regclass);
 9   ALTER TABLE core.snapshots ALTER COLUMN id DROP DEFAULT;
       core       postgres    false    287    286    287            v           2604    115195    zonas zona_id    DEFAULT     j   ALTER TABLE ONLY core.zonas ALTER COLUMN zona_id SET DEFAULT nextval('core.zonas_zona_id_seq'::regclass);
 :   ALTER TABLE core.zonas ALTER COLUMN zona_id DROP DEFAULT;
       core       postgres    false    268    267    268            �           2604    164245    actas_infraccion acin_id    DEFAULT     }   ALTER TABLE ONLY fis.actas_infraccion ALTER COLUMN acin_id SET DEFAULT nextval('fis.acta_infraccion_acin_id_seq'::regclass);
 D   ALTER TABLE fis.actas_infraccion ALTER COLUMN acin_id DROP DEFAULT;
       fis       postgres    false    302    301    302            
           2604    57785    formularios form_id    DEFAULT     t   ALTER TABLE ONLY frm.formularios ALTER COLUMN form_id SET DEFAULT nextval('frm.formularios_form_id_seq'::regclass);
 ?   ALTER TABLE frm.formularios ALTER COLUMN form_id DROP DEFAULT;
       frm       postgres    false    214    213    214                       2604    57802    instancias_items init_id    DEFAULT     ~   ALTER TABLE ONLY frm.instancias_items ALTER COLUMN init_id SET DEFAULT nextval('frm.instancias_items_init_id_seq'::regclass);
 D   ALTER TABLE frm.instancias_items ALTER COLUMN init_id DROP DEFAULT;
       frm       postgres    false    215    216    216                       2604    57821    items item_id    DEFAULT     h   ALTER TABLE ONLY frm.items ALTER COLUMN item_id SET DEFAULT nextval('frm.items_item_id_seq'::regclass);
 9   ALTER TABLE frm.items ALTER COLUMN item_id DROP DEFAULT;
       frm       postgres    false    218    217    218            �           2604    115363    choferes chof_id    DEFAULT     n   ALTER TABLE ONLY log.choferes ALTER COLUMN chof_id SET DEFAULT nextval('log.choferes_chof_id_seq'::regclass);
 <   ALTER TABLE log.choferes ALTER COLUMN chof_id DROP DEFAULT;
       log       postgres    false    278    279    279            }           2604    115233    circuitos circ_id    DEFAULT     q   ALTER TABLE ONLY log.circuitos ALTER COLUMN circ_id SET DEFAULT nextval('log.circuitos_circu_id_seq'::regclass);
 =   ALTER TABLE log.circuitos ALTER COLUMN circ_id DROP DEFAULT;
       log       postgres    false    272    271    272            �           2604    115277    contenedores cont_id    DEFAULT     t   ALTER TABLE ONLY log.contenedores ALTER COLUMN cont_id SET DEFAULT nextval('log.containers_cont_id_seq'::regclass);
 @   ALTER TABLE log.contenedores ALTER COLUMN cont_id DROP DEFAULT;
       log       postgres    false    273    274    274            �           2604    139703    contenedores_entregados coen_id    DEFAULT     �   ALTER TABLE ONLY log.contenedores_entregados ALTER COLUMN coen_id SET DEFAULT nextval('log.contenedores_entregados_coen_id_seq'::regclass);
 K   ALTER TABLE log.contenedores_entregados ALTER COLUMN coen_id DROP DEFAULT;
       log       postgres    false    295    294    295            �           2604    115530 #   deta_solicitudes_contenedor desc_id    DEFAULT     �   ALTER TABLE ONLY log.deta_solicitudes_contenedor ALTER COLUMN desc_id SET DEFAULT nextval('log.deta_solicitudes_contenedor_desc_id_seq'::regclass);
 O   ALTER TABLE log.deta_solicitudes_contenedor ALTER COLUMN desc_id DROP DEFAULT;
       log       postgres    false    284    283    284            �           2604    147855    incidencias inci_id    DEFAULT     t   ALTER TABLE ONLY log.incidencias ALTER COLUMN inci_id SET DEFAULT nextval('log.incidencias_inci_id_seq'::regclass);
 ?   ALTER TABLE log.incidencias ALTER COLUMN inci_id DROP DEFAULT;
       log       postgres    false    296    297    297            �           2604    139669    ordenes_transporte ortr_id    DEFAULT     �   ALTER TABLE ONLY log.ordenes_transporte ALTER COLUMN ortr_id SET DEFAULT nextval('log.ordenes_transporte_ortr_id_seq'::regclass);
 F   ALTER TABLE log.ordenes_transporte ALTER COLUMN ortr_id DROP DEFAULT;
       log       postgres    false    293    292    293            �           2604    115328    puntos_criticos pucr_id    DEFAULT     |   ALTER TABLE ONLY log.puntos_criticos ALTER COLUMN pucr_id SET DEFAULT nextval('log.puntos_criticos_pucr_id_seq'::regclass);
 C   ALTER TABLE log.puntos_criticos ALTER COLUMN pucr_id DROP DEFAULT;
       log       postgres    false    277    276    277            �           2604    115456    solicitantes_transporte sotr_id    DEFAULT     �   ALTER TABLE ONLY log.solicitantes_transporte ALTER COLUMN sotr_id SET DEFAULT nextval('log.solicitantes_transporte_sotr_id_seq'::regclass);
 K   ALTER TABLE log.solicitantes_transporte ALTER COLUMN sotr_id DROP DEFAULT;
       log       postgres    false    282    281    282            �           2604    139663     solicitudes_contenedores soco_id    DEFAULT     �   ALTER TABLE ONLY log.solicitudes_contenedores ALTER COLUMN soco_id SET DEFAULT nextval('log.solicitudes_contenedores_soco_id_seq'::regclass);
 L   ALTER TABLE log.solicitudes_contenedores ALTER COLUMN soco_id DROP DEFAULT;
       log       postgres    false    291    290    291            r           2604    115165    transportistas tran_id    DEFAULT     z   ALTER TABLE ONLY log.transportistas ALTER COLUMN tran_id SET DEFAULT nextval('log.transportistas_tran_id_seq'::regclass);
 B   ALTER TABLE log.transportistas ALTER COLUMN tran_id DROP DEFAULT;
       log       postgres    false    265    266    266            b           2604    98641    empaque empa_id    DEFAULT     l   ALTER TABLE ONLY prd.empaque ALTER COLUMN empa_id SET DEFAULT nextval('prd.empaque_empa_id_seq'::regclass);
 ;   ALTER TABLE prd.empaque ALTER COLUMN empa_id DROP DEFAULT;
       prd       postgres    false    256    255            M           2604    74638    establecimientos esta_id    DEFAULT     ~   ALTER TABLE ONLY prd.establecimientos ALTER COLUMN esta_id SET DEFAULT nextval('prd.establecimientos_esta_id_seq'::regclass);
 D   ALTER TABLE prd.establecimientos ALTER COLUMN esta_id DROP DEFAULT;
       prd       postgres    false    245    244    245            �           2604    57633    etapas etap_id    DEFAULT     j   ALTER TABLE ONLY prd.etapas ALTER COLUMN etap_id SET DEFAULT nextval('prd.etapas_etap_id_seq'::regclass);
 :   ALTER TABLE prd.etapas ALTER COLUMN etap_id DROP DEFAULT;
       prd       postgres    false    205    204    205            f           2604    98677    fraccionamientos frac_id    DEFAULT     ~   ALTER TABLE ONLY prd.fraccionamientos ALTER COLUMN frac_id SET DEFAULT nextval('prd.fraccionamientos_frac_id_seq'::regclass);
 D   ALTER TABLE prd.fraccionamientos ALTER COLUMN frac_id DROP DEFAULT;
       prd       postgres    false    259    258    259            �           2604    74731    lotes batch_id    DEFAULT     j   ALTER TABLE ONLY prd.lotes ALTER COLUMN batch_id SET DEFAULT nextval('prd.lotes_batch_id_seq'::regclass);
 :   ALTER TABLE prd.lotes ALTER COLUMN batch_id DROP DEFAULT;
       prd       postgres    false    206    207    207            X           2604    74789    movimientos_trasportes motr_id    DEFAULT     �   ALTER TABLE ONLY prd.movimientos_trasportes ALTER COLUMN motr_id SET DEFAULT nextval('prd.movimientos_trasportes_motr_id_seq'::regclass);
 J   ALTER TABLE prd.movimientos_trasportes ALTER COLUMN motr_id DROP DEFAULT;
       prd       postgres    false    250    249    250            �           2604    57618    procesos proc_id    DEFAULT     o   ALTER TABLE ONLY prd.procesos ALTER COLUMN proc_id SET DEFAULT nextval('prd.productos_prod_id_seq'::regclass);
 <   ALTER TABLE prd.procesos ALTER COLUMN proc_id DROP DEFAULT;
       prd       postgres    false    203    202    203            P           2604    74869    recipientes reci_id    DEFAULT     s   ALTER TABLE ONLY prd.recipientes ALTER COLUMN reci_id SET DEFAULT nextval('prd.recipiente_reci_id_seq'::regclass);
 ?   ALTER TABLE prd.recipientes ALTER COLUMN reci_id DROP DEFAULT;
       prd       postgres    false    251    248            �           2604    57673    recursos recu_id    DEFAULT     n   ALTER TABLE ONLY prd.recursos ALTER COLUMN recu_id SET DEFAULT nextval('prd.recursos_recu_id_seq'::regclass);
 <   ALTER TABLE prd.recursos ALTER COLUMN recu_id DROP DEFAULT;
       prd       postgres    false    209    208    209                      0    106906    ajustes 
   TABLE DATA               l   COPY alm.ajustes (ajus_id, tipo_ajuste, justificacion, usuario_app, empr_id, fec_alta, usuario) FROM stdin;
    alm       postgres    false    261   i        �          0    74435    alm_articulos 
   TABLE DATA               �   COPY alm.alm_articulos (arti_id, barcode, descripcion, costo, es_caja, cantidad_caja, punto_pedido, estado, unidad_medida, empr_id, es_loteado, fec_alta, eliminado, batch_id, tipo) FROM stdin;
    alm       postgres    false    222   �        �          0    74446    alm_depositos 
   TABLE DATA               �   COPY alm.alm_depositos (depo_id, descripcion, direccion, gps, estado, loca_id, pais_id, empr_id, fec_alta, eliminado, esta_id) FROM stdin;
    alm       postgres    false    224   �                 0    74617    alm_deta_entrega_materiales 
   TABLE DATA               �   COPY alm.alm_deta_entrega_materiales (deen_id, enma_id, cantidad, arti_id, prov_id, lote_id, depo_id, empr_id, precio, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    243   c                 0    74524    alm_deta_pedidos_materiales 
   TABLE DATA               �   COPY alm.alm_deta_pedidos_materiales (depe_id, cantidad, resto, fecha_entrega, fecha_entregado, pema_id, arti_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    234   �       �          0    74403    alm_deta_recepcion_materiales 
   TABLE DATA               �   COPY alm.alm_deta_recepcion_materiales (dere_id, cantidad, precio, empr_id, rema_id, lote_id, prov_id, arti_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    220   �
                 0    74544    alm_entrega_materiales 
   TABLE DATA               �   COPY alm.alm_entrega_materiales (enma_id, fecha, solicitante, dni, comprobante, empr_id, pema_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    236                     0    74562 	   alm_lotes 
   TABLE DATA               �   COPY alm.alm_lotes (lote_id, prov_id, arti_id, depo_id, codigo, fec_vencimiento, cantidad, empr_id, user_id, estado, fec_alta, eliminado, batch_id) FROM stdin;
    alm       postgres    false    238   N       �          0    74465    alm_pedidos_materiales 
   TABLE DATA               �   COPY alm.alm_pedidos_materiales (pema_id, fecha, motivo_rechazo, justificacion, case_id, ortr_id, estado, empr_id, fec_alta, eliminado, batch_id) FROM stdin;
    alm       postgres    false    226   �       �          0    74483    alm_proveedores 
   TABLE DATA               w   COPY alm.alm_proveedores (prov_id, nombre, cuit, domicilio, telefono, email, empr_id, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    228   v                 0    74585    alm_proveedores_articulos 
   TABLE DATA               B   COPY alm.alm_proveedores_articulos (prov_id, arti_id) FROM stdin;
    alm       postgres    false    239   -	       
          0    74602    alm_recepcion_materiales 
   TABLE DATA               }   COPY alm.alm_recepcion_materiales (rema_id, fecha, comprobante, empr_id, prov_id, fec_alta, eliminado, batch_id) FROM stdin;
    alm       postgres    false    241   J	                  0    106938    deta_ajustes 
   TABLE DATA               d   COPY alm.deta_ajustes (deaj_id, cantidad, empr_id, fec_alta, usuario, lote_id, ajus_id) FROM stdin;
    alm       postgres    false    263   �	       �          0    74501    items 
   TABLE DATA               �   COPY alm.items (item_id, label, name, requerido, tipo_dato, valo_id, orden, aux, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, form_id) FROM stdin;
    alm       postgres    false    230   �	                 0    74514 
   utl_tablas 
   TABLE DATA               Z   COPY alm.utl_tablas (tabl_id, tabla, valor, descripcion, fec_alta, eliminado) FROM stdin;
    alm       postgres    false    232   �	       '          0    115211    departamentos 
   TABLE DATA               V   COPY core.departamentos (depa_id, nombre, descripcion, fec_alta, usuario) FROM stdin;
    core       postgres    false    270   �                 0    74708    empresas 
   TABLE DATA               �   COPY core.empresas (empr_id, descripcion, cuit, direccion, telefono, email, imagepath, loca_id, prov_id, pais_id, lat, lng, celular, zona_id, clie_id) FROM stdin;
    core       postgres    false    247   K                 0    98621    equipos 
   TABLE DATA               �  COPY core.equipos (equi_id, descripcion, marca, codigo, ubicacion, estado, fecha_ultimalectura, ultima_lectura, tipo_horas, valor_reposicion, fecha_reposicion, valor, comprobante, descrip_tecnica, numero_serie, adjunto, meta_disponibilidad, fecha_ingreso, fecha_baja, fecha_garantia, prov_id, empr_id, sect_id, ubic_id, grup_id, crit_id, unme_id, area_id, proc_id, tran_id, dominio) FROM stdin;
    core       postgres    false    254   x                 0    74914    log 
   TABLE DATA               '   COPY core.log (msg, fecha) FROM stdin;
    core       postgres    false    252   �       8          0    123290 	   snapshots 
   TABLE DATA               I   COPY core.snapshots (id, snap_id, data, fec_alta, eliminado) FROM stdin;
    core       postgres    false    287   �       !          0    115109    tablas 
   TABLE DATA               p   COPY core.tablas (tabl_id, tabla, valor, valor2, valor3, descripcion, fec_alta, usuario, eliminado) FROM stdin;
    core       postgres    false    264                     0    98651    transportistas 
   TABLE DATA               Z   COPY core.transportistas (cuit, razon_social, direccion, fec_alta, eliminado) FROM stdin;
    core       postgres    false    257   �       9          0    123300    transportistas_tipo_residuos 
   TABLE DATA               Y   COPY core.transportistas_tipo_residuos (tran_id, tire_id, fec_alta, usuario) FROM stdin;
    core       postgres    false    288   �       %          0    115192    zonas 
   TABLE DATA               w   COPY core.zonas (zona_id, nombre, descripcion, imagen, fec_alta, usuario, usuario_app, depa_id, eliminado) FROM stdin;
    core       postgres    false    268          G          0    164242    actas_infraccion 
   TABLE DATA               �   COPY fis.actas_infraccion (acin_id, numero_acta, descripcion, tipo, sotr_id, inspector_id, tran_id, destino, fecha_creacion, usuario_app, eliminado, usuario) FROM stdin;
    fis       postgres    false    302   �       �          0    57782    formularios 
   TABLE DATA               ^   COPY frm.formularios (form_id, nombre, descripcion, eliminado, fec_alta, usuario) FROM stdin;
    frm       postgres    false    214          �          0    57799    instancias_items 
   TABLE DATA               �   COPY frm.instancias_items (init_id, label, name, valor, requerido, tida_id, valo_id, info_id, form_id, orden, aux, eliminado, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, item_id) FROM stdin;
    frm       postgres    false    216   9       �          0    57818    items 
   TABLE DATA               �   COPY frm.items (item_id, label, name, requerido, tipo_dato, valo_id, orden, aux, mostrar, cond_mostrar, deshabilitado, cond_habilitado, fec_alta, usuario, form_id) FROM stdin;
    frm       postgres    false    218   V       0          0    115360    choferes 
   TABLE DATA               �   COPY log.choferes (chof_id, nombre, apellido, documento, fec_nacimiento, direccion, celular, codigo, carnet, vencimiento, habilitacion, imagen, fec_alta, usuario, tran_id, cach_id, eliminado) FROM stdin;
    log       postgres    false    279   s       )          0    115230 	   circuitos 
   TABLE DATA               �   COPY log.circuitos (circ_id, codigo, descripcion, imagen, fec_alta, usuario, usuario_app, chof_id, vehi_id, zona_id) FROM stdin;
    log       postgres    false    272   �       1          0    115416    circuitos_puntos_criticos 
   TABLE DATA               `   COPY log.circuitos_puntos_criticos (fec_alta, usuario, circ_id, pucr_id, eliminado) FROM stdin;
    log       postgres    false    280   3       +          0    115274    contenedores 
   TABLE DATA               �   COPY log.contenedores (cont_id, codigo, descripcion, capacidad, tara, habilitacion, fec_alta, usuario, usuario_app, esco_id, reci_id, anio_elaboracion) FROM stdin;
    log       postgres    false    274   �       @          0    139700    contenedores_entregados 
   TABLE DATA               �   COPY log.contenedores_entregados (coen_id, porc_llenado, mts_cubicos, fec_entrega, fec_retiro, fec_alta, usuario, usuario_app, cont_id, soco_id, sore_id, ortr_id, tica_id) FROM stdin;
    log       postgres    false    295   �       5          0    115527    deta_solicitudes_contenedor 
   TABLE DATA               t   COPY log.deta_solicitudes_contenedor (desc_id, cantidad, otro, fec_alta, usuario, usuario_app, tica_id) FROM stdin;
    log       postgres    false    284   	       B          0    147852    incidencias 
   TABLE DATA               4   COPY log.incidencias (inci_id, ortr_id) FROM stdin;
    log       postgres    false    297   "	       >          0    139666    ordenes_transporte 
   TABLE DATA               �   COPY log.ordenes_transporte (ortr_id, fec_retiro, estado, caseid, fec_alta, usuario, difi_id, sotr_id, equi_id, chof_id) FROM stdin;
    log       postgres    false    293   ?	       .          0    115325    puntos_criticos 
   TABLE DATA               �   COPY log.puntos_criticos (pucr_id, nombre, descripcion, lat, lng, fec_alta, usuario, usuario_app, zona_id, eliminado) FROM stdin;
    log       postgres    false    277   �	       3          0    115453    solicitantes_transporte 
   TABLE DATA               �   COPY log.solicitantes_transporte (sotr_id, razon_social, cuit, domicilio, num_registro, lat, lng, usuario, fec_alta, usuario_app, zona_id, rubr_id, tist_id, tica_id, eliminado, depa_id) FROM stdin;
    log       postgres    false    282   7       <          0    139660    solicitudes_contenedores 
   TABLE DATA               8   COPY log.solicitudes_contenedores (soco_id) FROM stdin;
    log       postgres    false    291   7       6          0    115548    solicitudes_retiro 
   TABLE DATA               [   COPY log.solicitudes_retiro (sore_id, fec_alta, usuario, usuario_app, sotr_id) FROM stdin;
    log       postgres    false    285   V       ,          0    115299    tipos_carga_circuitos 
   TABLE DATA               Q   COPY log.tipos_carga_circuitos (fec_alta, usuario, circ_id, tica_id) FROM stdin;
    log       postgres    false    275   �       :          0    123308    tipos_carga_transportistas 
   TABLE DATA               V   COPY log.tipos_carga_transportistas (fec_alta, usuario, tran_id, tica_id) FROM stdin;
    log       postgres    false    289          #          0    115162    transportistas 
   TABLE DATA               �   COPY log.transportistas (tran_id, razon_social, descripcion, direccion, telefono, contacto, resolucion, registro, fec_alta_efectiva, fec_baja_efectiva, fec_alta, usuario, usuario_app, eliminado, cuit) FROM stdin;
    log       postgres    false    266   f       �          0    57723    costos 
   TABLE DATA               ]   COPY prd.costos (fec_vigencia, valor, umed, fec_alta, usuario, recu_id, empr_id) FROM stdin;
    prd       postgres    false    212   �                 0    98636    empaque 
   TABLE DATA               u   COPY prd.empaque (empa_id, nombre, unidad_medida, capacidad, empr_id, usuario_app, eliminado, fech_alta) FROM stdin;
    prd       postgres    false    255   �                 0    74635    establecimientos 
   TABLE DATA               �   COPY prd.establecimientos (esta_id, nombre, lng, lat, calle, altura, localidad, estado, pais, fec_alta, usuario, empr_id) FROM stdin;
    prd       postgres    false    245   3       �          0    57630    etapas 
   TABLE DATA               {   COPY prd.etapas (etap_id, nombre, nom_recipiente, fec_alta, usuario, proc_id, eliminado, empr_id, orden, link) FROM stdin;
    prd       postgres    false    205          D          0    147874    etapas_materiales 
   TABLE DATA               :   COPY prd.etapas_materiales (etap_id, arti_id) FROM stdin;
    prd       postgres    false    299   �       E          0    147885    etapas_productos 
   TABLE DATA               9   COPY prd.etapas_productos (etap_id, arti_id) FROM stdin;
    prd       postgres    false    300   �                 0    98674    fraccionamientos 
   TABLE DATA               g   COPY prd.fraccionamientos (frac_id, recu_id, empa_id, cantidad, fecha, eliminado, empr_id) FROM stdin;
    prd       postgres    false    259   !       �          0    57652    lotes 
   TABLE DATA               �   COPY prd.lotes (lote_id, batch_id, estado, num_orden_prod, fec_alta, usuario, etap_id, eliminado, nombre, reci_id, empr_id, usuario_app, arti_id) FROM stdin;
    prd       postgres    false    207   h       �          0    57700    lotes_hijos 
   TABLE DATA               }   COPY prd.lotes_hijos (batch_id, batch_id_padre, fec_alta, usuario, eliminado, empr_id, cantidad, cantidad_padre) FROM stdin;
    prd       postgres    false    211                    0    74786    movimientos_trasportes 
   TABLE DATA               �   COPY prd.movimientos_trasportes (motr_id, boleta, fecha_entrada, patente, acoplado, conductor, tipo, bruto, tara, neto, prov_id, esta_id, fec_alta, eliminado, estado, reci_id, transportista, cuit, accion) FROM stdin;
    prd       postgres    false    250   �       �          0    57615    procesos 
   TABLE DATA               L   COPY prd.procesos (proc_id, nombre, fec_alta, usuario, empr_id) FROM stdin;
    prd       postgres    false    203   �                 0    74759    recipientes 
   TABLE DATA               z   COPY prd.recipientes (reci_id, tipo, estado, nombre, fec_alta, usuario, eliminado, empr_id, depo_id, motr_id) FROM stdin;
    prd       postgres    false    248   �       �          0    57670    recursos 
   TABLE DATA               �   COPY prd.recursos (recu_id, tipo, cant_capacidad, umed_capacidad, cant_tiempo_capacidad, umed_iempo_capacidad, fec_alta, usuario, arti_id, empr_id, equi_id) FROM stdin;
    prd       postgres    false    209   �       �          0    57682    recursos_lotes 
   TABLE DATA               |   COPY prd.recursos_lotes (batch_id, recu_id, fec_alta, usuario, empr_id, cantidad, tipo, empa_id, empa_cantidad) FROM stdin;
    prd       postgres    false    210   7       z           0    0    ajustes_ajus_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('alm.ajustes_ajus_id_seq', 44, true);
            alm       postgres    false    260            {           0    0    alm_articulos_arti_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('alm.alm_articulos_arti_id_seq', 69, true);
            alm       postgres    false    221            |           0    0    alm_depositos_depo_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('alm.alm_depositos_depo_id_seq', 7, true);
            alm       postgres    false    223            }           0    0 '   alm_deta_entrega_materiales_deen_id_seq    SEQUENCE SET     R   SELECT pg_catalog.setval('alm.alm_deta_entrega_materiales_deen_id_seq', 9, true);
            alm       postgres    false    242            ~           0    0 '   alm_deta_pedidos_materiales_depe_id_seq    SEQUENCE SET     T   SELECT pg_catalog.setval('alm.alm_deta_pedidos_materiales_depe_id_seq', 143, true);
            alm       postgres    false    233                       0    0 )   alm_deta_recepcion_materiales_dere_id_seq    SEQUENCE SET     T   SELECT pg_catalog.setval('alm.alm_deta_recepcion_materiales_dere_id_seq', 4, true);
            alm       postgres    false    219            �           0    0 "   alm_entrega_materiales_enma_id_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('alm.alm_entrega_materiales_enma_id_seq', 1, true);
            alm       postgres    false    235            �           0    0    alm_lotes_lote_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('alm.alm_lotes_lote_id_seq', 75, true);
            alm       postgres    false    237            �           0    0 "   alm_pedidos_materiales_pema_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('alm.alm_pedidos_materiales_pema_id_seq', 197, true);
            alm       postgres    false    225            �           0    0    alm_proveedores_prov_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('alm.alm_proveedores_prov_id_seq', 6, true);
            alm       postgres    false    227            �           0    0 $   alm_recepcion_materiales_rema_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('alm.alm_recepcion_materiales_rema_id_seq', 2, true);
            alm       postgres    false    240            �           0    0    deta_ajustes_deaj_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('alm.deta_ajustes_deaj_id_seq', 27, true);
            alm       postgres    false    262            �           0    0    items_item_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('alm.items_item_id_seq', 1, false);
            alm       postgres    false    229            �           0    0    utl_tablas_tabl_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('alm.utl_tablas_tabl_id_seq', 17, true);
            alm       postgres    false    231            �           0    0    departamentos_depa_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('core.departamentos_depa_id_seq', 4, true);
            core       postgres    false    269            �           0    0    empresas_empr_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('core.empresas_empr_id_seq', 1, true);
            core       postgres    false    246            �           0    0    equipos_equi_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('core.equipos_equi_id_seq', 23, true);
            core       postgres    false    253            �           0    0    snapshots_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('core.snapshots_id_seq', 58, true);
            core       postgres    false    286            �           0    0    zonas_zona_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('core.zonas_zona_id_seq', 87, true);
            core       postgres    false    267            �           0    0    acta_infraccion_acin_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('fis.acta_infraccion_acin_id_seq', 1, false);
            fis       postgres    false    301            �           0    0    formularios_form_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('frm.formularios_form_id_seq', 1, false);
            frm       postgres    false    213            �           0    0    instancias_items_init_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('frm.instancias_items_init_id_seq', 1, false);
            frm       postgres    false    215            �           0    0    items_item_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('frm.items_item_id_seq', 1, false);
            frm       postgres    false    217            �           0    0    choferes_chof_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('log.choferes_chof_id_seq', 6, true);
            log       postgres    false    278            �           0    0    circuitos_circu_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('log.circuitos_circu_id_seq', 54, true);
            log       postgres    false    271            �           0    0    containers_cont_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('log.containers_cont_id_seq', 26, true);
            log       postgres    false    273            �           0    0 #   contenedores_entregados_coen_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('log.contenedores_entregados_coen_id_seq', 1, true);
            log       postgres    false    294            �           0    0 '   deta_solicitudes_contenedor_desc_id_seq    SEQUENCE SET     S   SELECT pg_catalog.setval('log.deta_solicitudes_contenedor_desc_id_seq', 1, false);
            log       postgres    false    283            �           0    0    incidencias_inci_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('log.incidencias_inci_id_seq', 1, false);
            log       postgres    false    296            �           0    0    ordenes_transporte_ortr_id_seq    SEQUENCE SET     I   SELECT pg_catalog.setval('log.ordenes_transporte_ortr_id_seq', 5, true);
            log       postgres    false    292            �           0    0    puntos_criticos_pucr_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('log.puntos_criticos_pucr_id_seq', 66, true);
            log       postgres    false    276            �           0    0 #   solicitantes_transporte_sotr_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('log.solicitantes_transporte_sotr_id_seq', 19, true);
            log       postgres    false    281            �           0    0 $   solicitudes_contenedores_soco_id_seq    SEQUENCE SET     P   SELECT pg_catalog.setval('log.solicitudes_contenedores_soco_id_seq', 1, false);
            log       postgres    false    290            �           0    0    solicitudes_retiro_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('log.solicitudes_retiro_seq', 6, true);
            log       postgres    false    298            �           0    0    transportistas_tran_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('log.transportistas_tran_id_seq', 27, true);
            log       postgres    false    265            �           0    0    empaque_empa_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('prd.empaque_empa_id_seq', 5, true);
            prd       postgres    false    256            �           0    0    establecimientos_esta_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('prd.establecimientos_esta_id_seq', 3, true);
            prd       postgres    false    244            �           0    0    etapas_etap_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('prd.etapas_etap_id_seq', 1, true);
            prd       postgres    false    204            �           0    0    fraccionamientos_frac_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('prd.fraccionamientos_frac_id_seq', 3, true);
            prd       postgres    false    258            �           0    0    lotes_batch_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('prd.lotes_batch_id_seq', 192, true);
            prd       postgres    false    206            �           0    0 "   movimientos_trasportes_motr_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('prd.movimientos_trasportes_motr_id_seq', 31, true);
            prd       postgres    false    249            �           0    0    productos_prod_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('prd.productos_prod_id_seq', 1, true);
            prd       postgres    false    202            �           0    0    recipiente_reci_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('prd.recipiente_reci_id_seq', 108, true);
            prd       postgres    false    251            �           0    0    recursos_recu_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('prd.recursos_recu_id_seq', 16, true);
            prd       postgres    false    208            �           2606    106917    ajustes ajustes_pk 
   CONSTRAINT     R   ALTER TABLE ONLY alm.ajustes
    ADD CONSTRAINT ajustes_pk PRIMARY KEY (ajus_id);
 9   ALTER TABLE ONLY alm.ajustes DROP CONSTRAINT ajustes_pk;
       alm         postgres    false    261            �           2606    74443     alm_articulos alm_articulos_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY alm.alm_articulos
    ADD CONSTRAINT alm_articulos_pkey PRIMARY KEY (arti_id);
 G   ALTER TABLE ONLY alm.alm_articulos DROP CONSTRAINT alm_articulos_pkey;
       alm         postgres    false    222            �           2606    74462     alm_depositos alm_depositos_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY alm.alm_depositos
    ADD CONSTRAINT alm_depositos_pkey PRIMARY KEY (depo_id);
 G   ALTER TABLE ONLY alm.alm_depositos DROP CONSTRAINT alm_depositos_pkey;
       alm         postgres    false    224            �           2606    74624 <   alm_deta_entrega_materiales alm_deta_entrega_materiales_pkey 
   CONSTRAINT     |   ALTER TABLE ONLY alm.alm_deta_entrega_materiales
    ADD CONSTRAINT alm_deta_entrega_materiales_pkey PRIMARY KEY (deen_id);
 c   ALTER TABLE ONLY alm.alm_deta_entrega_materiales DROP CONSTRAINT alm_deta_entrega_materiales_pkey;
       alm         postgres    false    243            �           2606    74531 <   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_pkey 
   CONSTRAINT     |   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_pkey PRIMARY KEY (depe_id);
 c   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_pkey;
       alm         postgres    false    234            �           2606    74410 @   alm_deta_recepcion_materiales alm_deta_recepcion_materiales_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales
    ADD CONSTRAINT alm_deta_recepcion_materiales_pkey PRIMARY KEY (dere_id);
 g   ALTER TABLE ONLY alm.alm_deta_recepcion_materiales DROP CONSTRAINT alm_deta_recepcion_materiales_pkey;
       alm         postgres    false    220            �           2606    74554 2   alm_entrega_materiales alm_entrega_materiales_pkey 
   CONSTRAINT     r   ALTER TABLE ONLY alm.alm_entrega_materiales
    ADD CONSTRAINT alm_entrega_materiales_pkey PRIMARY KEY (enma_id);
 Y   ALTER TABLE ONLY alm.alm_entrega_materiales DROP CONSTRAINT alm_entrega_materiales_pkey;
       alm         postgres    false    236            �           2606    74574    alm_lotes alm_lotes_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_pkey PRIMARY KEY (lote_id);
 ?   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_pkey;
       alm         postgres    false    238            �           2606    74478 2   alm_pedidos_materiales alm_pedidos_materiales_pkey 
   CONSTRAINT     r   ALTER TABLE ONLY alm.alm_pedidos_materiales
    ADD CONSTRAINT alm_pedidos_materiales_pkey PRIMARY KEY (pema_id);
 Y   ALTER TABLE ONLY alm.alm_pedidos_materiales DROP CONSTRAINT alm_pedidos_materiales_pkey;
       alm         postgres    false    226            �           2606    74589 8   alm_proveedores_articulos alm_proveedores_articulos_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_pkey PRIMARY KEY (prov_id, arti_id);
 _   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_pkey;
       alm         postgres    false    239    239            �           2606    74498 $   alm_proveedores alm_proveedores_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY alm.alm_proveedores
    ADD CONSTRAINT alm_proveedores_pkey PRIMARY KEY (prov_id);
 K   ALTER TABLE ONLY alm.alm_proveedores DROP CONSTRAINT alm_proveedores_pkey;
       alm         postgres    false    228            �           2606    74609 6   alm_recepcion_materiales alm_recepcion_materiales_pkey 
   CONSTRAINT     v   ALTER TABLE ONLY alm.alm_recepcion_materiales
    ADD CONSTRAINT alm_recepcion_materiales_pkey PRIMARY KEY (rema_id);
 ]   ALTER TABLE ONLY alm.alm_recepcion_materiales DROP CONSTRAINT alm_recepcion_materiales_pkey;
       alm         postgres    false    241            �           2606    106955    deta_ajustes deta_ajustes_pk 
   CONSTRAINT     \   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_pk PRIMARY KEY (deaj_id);
 C   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_pk;
       alm         postgres    false    263            �           2606    74511    items items_pk 
   CONSTRAINT     N   ALTER TABLE ONLY alm.items
    ADD CONSTRAINT items_pk PRIMARY KEY (item_id);
 5   ALTER TABLE ONLY alm.items DROP CONSTRAINT items_pk;
       alm         postgres    false    230            �           2606    74521    utl_tablas utl_tablas_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY alm.utl_tablas
    ADD CONSTRAINT utl_tablas_pkey PRIMARY KEY (tabl_id);
 A   ALTER TABLE ONLY alm.utl_tablas DROP CONSTRAINT utl_tablas_pkey;
       alm         postgres    false    232            �           2606    115221    departamentos departamentos_pk 
   CONSTRAINT     _   ALTER TABLE ONLY core.departamentos
    ADD CONSTRAINT departamentos_pk PRIMARY KEY (depa_id);
 F   ALTER TABLE ONLY core.departamentos DROP CONSTRAINT departamentos_pk;
       core         postgres    false    270            �           2606    74713    empresas empresas_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY core.empresas
    ADD CONSTRAINT empresas_pkey PRIMARY KEY (empr_id);
 >   ALTER TABLE ONLY core.empresas DROP CONSTRAINT empresas_pkey;
       core         postgres    false    247            �           2606    98630    equipos equipos_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY core.equipos
    ADD CONSTRAINT equipos_pkey PRIMARY KEY (equi_id);
 <   ALTER TABLE ONLY core.equipos DROP CONSTRAINT equipos_pkey;
       core         postgres    false    254            �           2606    115119    tablas tablas_pk 
   CONSTRAINT     Q   ALTER TABLE ONLY core.tablas
    ADD CONSTRAINT tablas_pk PRIMARY KEY (tabl_id);
 8   ALTER TABLE ONLY core.tablas DROP CONSTRAINT tablas_pk;
       core         postgres    false    264            �           2606    98660     transportistas transportistas_pk 
   CONSTRAINT     ^   ALTER TABLE ONLY core.transportistas
    ADD CONSTRAINT transportistas_pk PRIMARY KEY (cuit);
 H   ALTER TABLE ONLY core.transportistas DROP CONSTRAINT transportistas_pk;
       core         postgres    false    257            �           2606    115384    zonas zonas_pk 
   CONSTRAINT     O   ALTER TABLE ONLY core.zonas
    ADD CONSTRAINT zonas_pk PRIMARY KEY (zona_id);
 6   ALTER TABLE ONLY core.zonas DROP CONSTRAINT zonas_pk;
       core         postgres    false    268            '           2606    164253 #   actas_infraccion acta_infraccion_pk 
   CONSTRAINT     c   ALTER TABLE ONLY fis.actas_infraccion
    ADD CONSTRAINT acta_infraccion_pk PRIMARY KEY (acin_id);
 J   ALTER TABLE ONLY fis.actas_infraccion DROP CONSTRAINT acta_infraccion_pk;
       fis         postgres    false    302            �           2606    57793    formularios formularios_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY frm.formularios
    ADD CONSTRAINT formularios_pk PRIMARY KEY (form_id);
 A   ALTER TABLE ONLY frm.formularios DROP CONSTRAINT formularios_pk;
       frm         postgres    false    214            �           2606    57811 $   instancias_items instancias_items_pk 
   CONSTRAINT     d   ALTER TABLE ONLY frm.instancias_items
    ADD CONSTRAINT instancias_items_pk PRIMARY KEY (init_id);
 K   ALTER TABLE ONLY frm.instancias_items DROP CONSTRAINT instancias_items_pk;
       frm         postgres    false    216            �           2606    57828    items items_pk 
   CONSTRAINT     N   ALTER TABLE ONLY frm.items
    ADD CONSTRAINT items_pk PRIMARY KEY (item_id);
 5   ALTER TABLE ONLY frm.items DROP CONSTRAINT items_pk;
       frm         postgres    false    218                       2606    115372    choferes choferes_dni_un 
   CONSTRAINT     U   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_dni_un UNIQUE (documento);
 ?   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_dni_un;
       log         postgres    false    279                       2606    115370    choferes choferes_pk 
   CONSTRAINT     T   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_pk PRIMARY KEY (chof_id);
 ;   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_pk;
       log         postgres    false    279            �           2606    115308    circuitos circuitos_pk 
   CONSTRAINT     V   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_pk PRIMARY KEY (circ_id);
 =   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_pk;
       log         postgres    false    272                       2606    115440 6   circuitos_puntos_criticos circuitos_puntos_criticos_pk 
   CONSTRAINT        ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_pk PRIMARY KEY (circ_id, pucr_id);
 ]   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_pk;
       log         postgres    false    280    280            �           2606    115310    circuitos circuitos_un 
   CONSTRAINT     P   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_un UNIQUE (codigo);
 =   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_un;
       log         postgres    false    272                       2606    115286 !   contenedores containers_codigo_un 
   CONSTRAINT     [   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_codigo_un UNIQUE (codigo);
 H   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_codigo_un;
       log         postgres    false    274                       2606    115284    contenedores containers_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_pk PRIMARY KEY (cont_id);
 A   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_pk;
       log         postgres    false    274                       2606    115288 "   contenedores containers_reci_id_un 
   CONSTRAINT     ]   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_reci_id_un UNIQUE (reci_id);
 I   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_reci_id_un;
       log         postgres    false    274                       2606    115541 :   deta_solicitudes_contenedor deta_solicitudes_contenedor_pk 
   CONSTRAINT     z   ALTER TABLE ONLY log.deta_solicitudes_contenedor
    ADD CONSTRAINT deta_solicitudes_contenedor_pk PRIMARY KEY (desc_id);
 a   ALTER TABLE ONLY log.deta_solicitudes_contenedor DROP CONSTRAINT deta_solicitudes_contenedor_pk;
       log         postgres    false    284            !           2606    147857    incidencias incidencias_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY log.incidencias
    ADD CONSTRAINT incidencias_pk PRIMARY KEY (inci_id);
 A   ALTER TABLE ONLY log.incidencias DROP CONSTRAINT incidencias_pk;
       log         postgres    false    297                       2606    139677 (   ordenes_transporte ordenes_transporte_pk 
   CONSTRAINT     h   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_pk PRIMARY KEY (ortr_id);
 O   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_pk;
       log         postgres    false    293            	           2606    115335 "   puntos_criticos puntos_criticos_pk 
   CONSTRAINT     b   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_pk PRIMARY KEY (pucr_id);
 I   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_pk;
       log         postgres    false    277                       2606    115337 "   puntos_criticos puntos_criticos_un 
   CONSTRAINT     \   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_un UNIQUE (nombre);
 I   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_un;
       log         postgres    false    277                       2606    115463 1   solicitantes_transporte solcitantes_transporte_pk 
   CONSTRAINT     q   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_pk PRIMARY KEY (sotr_id);
 X   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_pk;
       log         postgres    false    282                       2606    115465 1   solicitantes_transporte solcitantes_transporte_un 
   CONSTRAINT     i   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_un UNIQUE (cuit);
 X   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_un;
       log         postgres    false    282                       2606    139717 4   solicitudes_contenedores solicitudes_contenedores_pk 
   CONSTRAINT     t   ALTER TABLE ONLY log.solicitudes_contenedores
    ADD CONSTRAINT solicitudes_contenedores_pk PRIMARY KEY (soco_id);
 [   ALTER TABLE ONLY log.solicitudes_contenedores DROP CONSTRAINT solicitudes_contenedores_pk;
       log         postgres    false    291                       2606    139734 (   solicitudes_retiro solicitudes_retiro_pk 
   CONSTRAINT     h   ALTER TABLE ONLY log.solicitudes_retiro
    ADD CONSTRAINT solicitudes_retiro_pk PRIMARY KEY (sore_id);
 O   ALTER TABLE ONLY log.solicitudes_retiro DROP CONSTRAINT solicitudes_retiro_pk;
       log         postgres    false    285                       2606    115400 .   tipos_carga_circuitos tipos_carga_circuitos_pk 
   CONSTRAINT     w   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_carga_circuitos_pk PRIMARY KEY (circ_id, tica_id);
 U   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_carga_circuitos_pk;
       log         postgres    false    275    275                       2606    123317 8   tipos_carga_transportistas tipos_carga_transportistas_pk 
   CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_pk PRIMARY KEY (tran_id, tica_id);
 _   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_pk;
       log         postgres    false    289    289            �           2606    115172     transportistas transportistas_pk 
   CONSTRAINT     `   ALTER TABLE ONLY log.transportistas
    ADD CONSTRAINT transportistas_pk PRIMARY KEY (tran_id);
 G   ALTER TABLE ONLY log.transportistas DROP CONSTRAINT transportistas_pk;
       log         postgres    false    266            �           2606    115174     transportistas transportistas_un 
   CONSTRAINT     `   ALTER TABLE ONLY log.transportistas
    ADD CONSTRAINT transportistas_un UNIQUE (razon_social);
 G   ALTER TABLE ONLY log.transportistas DROP CONSTRAINT transportistas_un;
       log         postgres    false    266            �           2606    57737    costos costos_pk 
   CONSTRAINT     ^   ALTER TABLE ONLY prd.costos
    ADD CONSTRAINT costos_pk PRIMARY KEY (fec_vigencia, recu_id);
 7   ALTER TABLE ONLY prd.costos DROP CONSTRAINT costos_pk;
       prd         postgres    false    212    212            �           2606    98646    empaque empaque_pk 
   CONSTRAINT     R   ALTER TABLE ONLY prd.empaque
    ADD CONSTRAINT empaque_pk PRIMARY KEY (empa_id);
 9   ALTER TABLE ONLY prd.empaque DROP CONSTRAINT empaque_pk;
       prd         postgres    false    255            �           2606    74643 $   establecimientos establecimientos_pk 
   CONSTRAINT     d   ALTER TABLE ONLY prd.establecimientos
    ADD CONSTRAINT establecimientos_pk PRIMARY KEY (esta_id);
 K   ALTER TABLE ONLY prd.establecimientos DROP CONSTRAINT establecimientos_pk;
       prd         postgres    false    245            #           2606    156049 &   etapas_materiales etapas_materiales_un 
   CONSTRAINT     j   ALTER TABLE ONLY prd.etapas_materiales
    ADD CONSTRAINT etapas_materiales_un UNIQUE (etap_id, arti_id);
 M   ALTER TABLE ONLY prd.etapas_materiales DROP CONSTRAINT etapas_materiales_un;
       prd         postgres    false    299    299            �           2606    57640    etapas etapas_pk 
   CONSTRAINT     P   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_pk PRIMARY KEY (etap_id);
 7   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_pk;
       prd         postgres    false    205            %           2606    156047 $   etapas_productos etapas_productos_un 
   CONSTRAINT     h   ALTER TABLE ONLY prd.etapas_productos
    ADD CONSTRAINT etapas_productos_un UNIQUE (etap_id, arti_id);
 K   ALTER TABLE ONLY prd.etapas_productos DROP CONSTRAINT etapas_productos_un;
       prd         postgres    false    300    300            �           2606    98616    etapas etapas_un 
   CONSTRAINT     S   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_un UNIQUE (nombre, proc_id);
 7   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_un;
       prd         postgres    false    205    205            �           2606    98614    etapas etapas_un_2 
   CONSTRAINT     T   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_un_2 UNIQUE (orden, proc_id);
 9   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_un_2;
       prd         postgres    false    205    205            �           2606    74733    lotes lotes_un 
   CONSTRAINT     J   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_un UNIQUE (batch_id);
 5   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_un;
       prd         postgres    false    207            �           2606    74795 0   movimientos_trasportes movimientos_trasportes_pk 
   CONSTRAINT     p   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_pk PRIMARY KEY (motr_id);
 W   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_pk;
       prd         postgres    false    250            �           2606    57625    procesos productos_pk 
   CONSTRAINT     U   ALTER TABLE ONLY prd.procesos
    ADD CONSTRAINT productos_pk PRIMARY KEY (proc_id);
 <   ALTER TABLE ONLY prd.procesos DROP CONSTRAINT productos_pk;
       prd         postgres    false    203            �           2606    57627    procesos productos_un 
   CONSTRAINT     O   ALTER TABLE ONLY prd.procesos
    ADD CONSTRAINT productos_un UNIQUE (nombre);
 <   ALTER TABLE ONLY prd.procesos DROP CONSTRAINT productos_un;
       prd         postgres    false    203            �           2606    74771    recipientes recipientes_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_pk PRIMARY KEY (reci_id);
 A   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_pk;
       prd         postgres    false    248            �           2606    57679    recursos recursos_pk 
   CONSTRAINT     T   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_pk PRIMARY KEY (recu_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_pk;
       prd         postgres    false    209            �           2606    82232    recursos recursos_un 
   CONSTRAINT     O   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_un UNIQUE (arti_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_un;
       prd         postgres    false    209            h           2620    98705 0   alm_deta_entrega_materiales asociar_lote_hijo_ai    TRIGGER     �   CREATE TRIGGER asociar_lote_hijo_ai AFTER INSERT ON alm.alm_deta_entrega_materiales FOR EACH ROW EXECUTE PROCEDURE prd.asociar_lote_hijo_trg();
 F   DROP TRIGGER asociar_lote_hijo_ai ON alm.alm_deta_entrega_materiales;
       alm       postgres    false    243    320            f           2620    82229    alm_articulos crear_producto_ai    TRIGGER        CREATE TRIGGER crear_producto_ai AFTER INSERT ON alm.alm_articulos FOR EACH ROW EXECUTE PROCEDURE prd.crear_prd_recurso_trg();
 5   DROP TRIGGER crear_producto_ai ON alm.alm_articulos;
       alm       postgres    false    222    321            g           2620    82230 "   alm_articulos eliminar_producto_ad    TRIGGER     �   CREATE TRIGGER eliminar_producto_ad AFTER DELETE ON alm.alm_articulos FOR EACH ROW EXECUTE PROCEDURE prd.eliminar_prd_recurso_trg();
 8   DROP TRIGGER eliminar_producto_ad ON alm.alm_articulos;
       alm       postgres    false    322    222            i           2620    115124    tablas set_tabla_id_bui    TRIGGER        CREATE TRIGGER set_tabla_id_bui BEFORE INSERT OR UPDATE ON core.tablas FOR EACH ROW EXECUTE PROCEDURE core.set_tabla_id_trg();
 .   DROP TRIGGER set_tabla_id_bui ON core.tablas;
       core       postgres    false    324    264            2           2606    115378    alm_articulos alm_articulos_fk    FK CONSTRAINT     {   ALTER TABLE ONLY alm.alm_articulos
    ADD CONSTRAINT alm_articulos_fk FOREIGN KEY (tipo) REFERENCES core.tablas(tabl_id);
 E   ALTER TABLE ONLY alm.alm_articulos DROP CONSTRAINT alm_articulos_fk;
       alm       postgres    false    222    264    3315            =           2606    74625 :   alm_deta_entrega_materiales alm_deta_entrega_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_entrega_materiales
    ADD CONSTRAINT alm_deta_entrega_materiales_fk FOREIGN KEY (enma_id) REFERENCES alm.alm_entrega_materiales(enma_id);
 a   ALTER TABLE ONLY alm.alm_deta_entrega_materiales DROP CONSTRAINT alm_deta_entrega_materiales_fk;
       alm       postgres    false    236    243    3287            4           2606    74532 :   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 a   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_fk;
       alm       postgres    false    222    3273    234            5           2606    74537 <   alm_deta_pedidos_materiales alm_deta_pedidos_materiales_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales
    ADD CONSTRAINT alm_deta_pedidos_materiales_fk_1 FOREIGN KEY (pema_id) REFERENCES alm.alm_pedidos_materiales(pema_id);
 c   ALTER TABLE ONLY alm.alm_deta_pedidos_materiales DROP CONSTRAINT alm_deta_pedidos_materiales_fk_1;
       alm       postgres    false    226    3277    234            6           2606    74555 0   alm_entrega_materiales alm_entrega_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_entrega_materiales
    ADD CONSTRAINT alm_entrega_materiales_fk FOREIGN KEY (pema_id) REFERENCES alm.alm_pedidos_materiales(pema_id);
 W   ALTER TABLE ONLY alm.alm_entrega_materiales DROP CONSTRAINT alm_entrega_materiales_fk;
       alm       postgres    false    226    236    3277            3           2606    74777 %   alm_depositos alm_establecimientos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_depositos
    ADD CONSTRAINT alm_establecimientos_fk FOREIGN KEY (esta_id) REFERENCES prd.establecimientos(esta_id);
 L   ALTER TABLE ONLY alm.alm_depositos DROP CONSTRAINT alm_establecimientos_fk;
       alm       postgres    false    245    224    3297            7           2606    74575    alm_lotes alm_lotes_fk    FK CONSTRAINT     |   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 =   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_fk;
       alm       postgres    false    238    222    3273            8           2606    74580    alm_lotes alm_lotes_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_fk_1 FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 ?   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_fk_1;
       alm       postgres    false    228    238    3279            9           2606    74880    alm_lotes alm_lotes_lotes_fk    FK CONSTRAINT     |   ALTER TABLE ONLY alm.alm_lotes
    ADD CONSTRAINT alm_lotes_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 C   ALTER TABLE ONLY alm.alm_lotes DROP CONSTRAINT alm_lotes_lotes_fk;
       alm       postgres    false    3257    207    238            :           2606    74590 6   alm_proveedores_articulos alm_proveedores_articulos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 ]   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_fk;
       alm       postgres    false    3273    222    239            ;           2606    74595 8   alm_proveedores_articulos alm_proveedores_articulos_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_proveedores_articulos
    ADD CONSTRAINT alm_proveedores_articulos_fk_1 FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 _   ALTER TABLE ONLY alm.alm_proveedores_articulos DROP CONSTRAINT alm_proveedores_articulos_fk_1;
       alm       postgres    false    228    3279    239            <           2606    74610 4   alm_recepcion_materiales alm_recepcion_materiales_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.alm_recepcion_materiales
    ADD CONSTRAINT alm_recepcion_materiales_fk FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 [   ALTER TABLE ONLY alm.alm_recepcion_materiales DROP CONSTRAINT alm_recepcion_materiales_fk;
       alm       postgres    false    241    3279    228            G           2606    106964 $   deta_ajustes deta_ajustes_ajustes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_ajustes_fk FOREIGN KEY (ajus_id) REFERENCES alm.ajustes(ajus_id);
 K   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_ajustes_fk;
       alm       postgres    false    263    261    3311            F           2606    106956 &   deta_ajustes deta_ajustes_alm_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY alm.deta_ajustes
    ADD CONSTRAINT deta_ajustes_alm_lotes_fk FOREIGN KEY (lote_id) REFERENCES alm.alm_lotes(lote_id);
 M   ALTER TABLE ONLY alm.deta_ajustes DROP CONSTRAINT deta_ajustes_alm_lotes_fk;
       alm       postgres    false    3289    263    238            H           2606    115223    zonas zonas_fk    FK CONSTRAINT     v   ALTER TABLE ONLY core.zonas
    ADD CONSTRAINT zonas_fk FOREIGN KEY (depa_id) REFERENCES core.departamentos(depa_id);
 6   ALTER TABLE ONLY core.zonas DROP CONSTRAINT zonas_fk;
       core       postgres    false    268    270    3323            d           2606    164254 +   actas_infraccion solicitantes_transporte_fk    FK CONSTRAINT     �   ALTER TABLE ONLY fis.actas_infraccion
    ADD CONSTRAINT solicitantes_transporte_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 R   ALTER TABLE ONLY fis.actas_infraccion DROP CONSTRAINT solicitantes_transporte_fk;
       fis       postgres    false    302    3347    282            e           2606    164259 "   actas_infraccion transportistas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY fis.actas_infraccion
    ADD CONSTRAINT transportistas_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 I   ALTER TABLE ONLY fis.actas_infraccion DROP CONSTRAINT transportistas_fk;
       fis       postgres    false    266    302    3317            O           2606    115373    choferes choferes_fk    FK CONSTRAINT     {   ALTER TABLE ONLY log.choferes
    ADD CONSTRAINT choferes_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 ;   ALTER TABLE ONLY log.choferes DROP CONSTRAINT choferes_fk;
       log       postgres    false    3317    279    266            P           2606    115441 6   circuitos_puntos_criticos circuitos_puntos_criticos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_fk FOREIGN KEY (circ_id) REFERENCES log.circuitos(circ_id);
 ]   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_fk;
       log       postgres    false    3325    280    272            Q           2606    115446 8   circuitos_puntos_criticos circuitos_puntos_criticos_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY log.circuitos_puntos_criticos
    ADD CONSTRAINT circuitos_puntos_criticos_fk_1 FOREIGN KEY (pucr_id) REFERENCES log.puntos_criticos(pucr_id);
 _   ALTER TABLE ONLY log.circuitos_puntos_criticos DROP CONSTRAINT circuitos_puntos_criticos_fk_1;
       log       postgres    false    3337    277    280            I           2606    123390    circuitos circuitos_zona_id_fk    FK CONSTRAINT     }   ALTER TABLE ONLY log.circuitos
    ADD CONSTRAINT circuitos_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 E   ALTER TABLE ONLY log.circuitos DROP CONSTRAINT circuitos_zona_id_fk;
       log       postgres    false    3321    268    272            K           2606    115294    contenedores containers_fk    FK CONSTRAINT     z   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_fk FOREIGN KEY (esco_id) REFERENCES core.tablas(tabl_id);
 A   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_fk;
       log       postgres    false    274    264    3315            J           2606    115289 "   contenedores containers_reci_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores
    ADD CONSTRAINT containers_reci_id_fk FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 I   ALTER TABLE ONLY log.contenedores DROP CONSTRAINT containers_reci_id_fk;
       log       postgres    false    3301    248    274            `           2606    139723 :   contenedores_entregados contenedores_entregados_ortr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_ortr_id_fk FOREIGN KEY (ortr_id) REFERENCES log.ordenes_transporte(ortr_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_ortr_id_fk;
       log       postgres    false    3359    295    293            _           2606    139718 :   contenedores_entregados contenedores_entregados_soco_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_soco_id_fk FOREIGN KEY (soco_id) REFERENCES log.solicitudes_contenedores(soco_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_soco_id_fk;
       log       postgres    false    291    3357    295            b           2606    139735 :   contenedores_entregados contenedores_entregados_sore_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_sore_id_fk FOREIGN KEY (sore_id) REFERENCES log.solicitudes_retiro(sore_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_sore_id_fk;
       log       postgres    false    3353    285    295            a           2606    139728 :   contenedores_entregados contenedores_entregados_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.contenedores_entregados
    ADD CONSTRAINT contenedores_entregados_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 a   ALTER TABLE ONLY log.contenedores_entregados DROP CONSTRAINT contenedores_entregados_tica_id_fk;
       log       postgres    false    264    295    3315            W           2606    115535 B   deta_solicitudes_contenedor deta_solicitudes_contenedor_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.deta_solicitudes_contenedor
    ADD CONSTRAINT deta_solicitudes_contenedor_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 i   ALTER TABLE ONLY log.deta_solicitudes_contenedor DROP CONSTRAINT deta_solicitudes_contenedor_tica_id_fk;
       log       postgres    false    284    264    3315            ]           2606    139688 0   ordenes_transporte ordenes_transporte_chof_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_chof_id_fk FOREIGN KEY (chof_id) REFERENCES log.choferes(documento);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_chof_id_fk;
       log       postgres    false    293    3341    279            [           2606    139678 0   ordenes_transporte ordenes_transporte_difi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_difi_id_fk FOREIGN KEY (difi_id) REFERENCES core.tablas(tabl_id);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_difi_id_fk;
       log       postgres    false    293    3315    264            ^           2606    139693 0   ordenes_transporte ordenes_transporte_equi_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_equi_id_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_equi_id_fk;
       log       postgres    false    293    3305    254            \           2606    139683 0   ordenes_transporte ordenes_transporte_sotr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.ordenes_transporte
    ADD CONSTRAINT ordenes_transporte_sotr_id_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 W   ALTER TABLE ONLY log.ordenes_transporte DROP CONSTRAINT ordenes_transporte_sotr_id_fk;
       log       postgres    false    293    3347    282            N           2606    115411 *   puntos_criticos puntos_criticos_zona_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.puntos_criticos
    ADD CONSTRAINT puntos_criticos_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 Q   ALTER TABLE ONLY log.puntos_criticos DROP CONSTRAINT puntos_criticos_zona_id_fk;
       log       postgres    false    268    277    3321            R           2606    115466 9   solicitantes_transporte solcitantes_transporte_rubr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_rubr_id_fk FOREIGN KEY (rubr_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_rubr_id_fk;
       log       postgres    false    282    264    3315            T           2606    115476 9   solicitantes_transporte solcitantes_transporte_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_tica_id_fk;
       log       postgres    false    282    264    3315            S           2606    115471 9   solicitantes_transporte solcitantes_transporte_tisr_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_tisr_id_fk FOREIGN KEY (tist_id) REFERENCES core.tablas(tabl_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_tisr_id_fk;
       log       postgres    false    282    264    3315            U           2606    115481 9   solicitantes_transporte solcitantes_transporte_zona_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solcitantes_transporte_zona_id_fk FOREIGN KEY (zona_id) REFERENCES core.zonas(zona_id);
 `   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solcitantes_transporte_zona_id_fk;
       log       postgres    false    282    268    3321            V           2606    164234 :   solicitantes_transporte solicitantes_transporte_depa_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitantes_transporte
    ADD CONSTRAINT solicitantes_transporte_depa_id_fk FOREIGN KEY (depa_id) REFERENCES core.departamentos(depa_id);
 a   ALTER TABLE ONLY log.solicitantes_transporte DROP CONSTRAINT solicitantes_transporte_depa_id_fk;
       log       postgres    false    282    3323    270            X           2606    139745 (   solicitudes_retiro solicitudes_retiro_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.solicitudes_retiro
    ADD CONSTRAINT solicitudes_retiro_fk FOREIGN KEY (sotr_id) REFERENCES log.solicitantes_transporte(sotr_id);
 O   ALTER TABLE ONLY log.solicitudes_retiro DROP CONSTRAINT solicitudes_retiro_fk;
       log       postgres    false    3347    282    285            M           2606    115401 6   tipos_carga_circuitos tipos_carga_circuitos_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_carga_circuitos_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 ]   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_carga_circuitos_tica_id_fk;
       log       postgres    false    275    264    3315            Z           2606    123323 8   tipos_carga_transportistas tipos_carga_transportistas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_fk FOREIGN KEY (tran_id) REFERENCES log.transportistas(tran_id);
 _   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_fk;
       log       postgres    false    289    3317    266            Y           2606    123318 @   tipos_carga_transportistas tipos_carga_transportistas_tica_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_transportistas
    ADD CONSTRAINT tipos_carga_transportistas_tica_id_fk FOREIGN KEY (tica_id) REFERENCES core.tablas(tabl_id);
 g   ALTER TABLE ONLY log.tipos_carga_transportistas DROP CONSTRAINT tipos_carga_transportistas_tica_id_fk;
       log       postgres    false    289    3315    264            L           2606    115313 0   tipos_carga_circuitos tipos_residuo_circuitos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY log.tipos_carga_circuitos
    ADD CONSTRAINT tipos_residuo_circuitos_fk FOREIGN KEY (circ_id) REFERENCES log.circuitos(circ_id);
 W   ALTER TABLE ONLY log.tipos_carga_circuitos DROP CONSTRAINT tipos_residuo_circuitos_fk;
       log       postgres    false    275    272    3325            1           2606    57731    costos costos_recursos_fk    FK CONSTRAINT     z   ALTER TABLE ONLY prd.costos
    ADD CONSTRAINT costos_recursos_fk FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id);
 @   ALTER TABLE ONLY prd.costos DROP CONSTRAINT costos_recursos_fk;
       prd       postgres    false    209    212    3259            D           2606    98685    fraccionamientos empa_id    FK CONSTRAINT     x   ALTER TABLE ONLY prd.fraccionamientos
    ADD CONSTRAINT empa_id FOREIGN KEY (empa_id) REFERENCES prd.empaque(empa_id);
 ?   ALTER TABLE ONLY prd.fraccionamientos DROP CONSTRAINT empa_id;
       prd       postgres    false    3307    255    259            c           2606    147880 "   etapas_materiales etapa-arti_id_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.etapas_materiales
    ADD CONSTRAINT "etapa-arti_id_fk" FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 K   ALTER TABLE ONLY prd.etapas_materiales DROP CONSTRAINT "etapa-arti_id_fk";
       prd       postgres    false    3273    299    222            (           2606    57747    etapas etapas_procesos_fk    FK CONSTRAINT     z   ALTER TABLE ONLY prd.etapas
    ADD CONSTRAINT etapas_procesos_fk FOREIGN KEY (proc_id) REFERENCES prd.procesos(proc_id);
 @   ALTER TABLE ONLY prd.etapas DROP CONSTRAINT etapas_procesos_fk;
       prd       postgres    false    203    205    3247            )           2606    57663    lotes lotes_etapas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_etapas_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id) ON DELETE RESTRICT;
 <   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_etapas_fk;
       prd       postgres    false    205    3251    207            +           2606    82169    lotes lotes_fk    FK CONSTRAINT     t   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
 5   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_fk;
       prd       postgres    false    222    207    3273            0           2606    74739     lotes_hijos lotes_hijos_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_hijos
    ADD CONSTRAINT lotes_hijos_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
 G   ALTER TABLE ONLY prd.lotes_hijos DROP CONSTRAINT lotes_hijos_lotes_fk;
       prd       postgres    false    211    3257    207            /           2606    74734 '   lotes_hijos lotes_hijos_lotes_padres_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.lotes_hijos
    ADD CONSTRAINT lotes_hijos_lotes_padres_fk FOREIGN KEY (batch_id_padre) REFERENCES prd.lotes(batch_id);
 N   ALTER TABLE ONLY prd.lotes_hijos DROP CONSTRAINT lotes_hijos_lotes_padres_fk;
       prd       postgres    false    207    3257    211            *           2606    74772    lotes lotes_recipientes_fk    FK CONSTRAINT     ~   ALTER TABLE ONLY prd.lotes
    ADD CONSTRAINT lotes_recipientes_fk FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 A   ALTER TABLE ONLY prd.lotes DROP CONSTRAINT lotes_recipientes_fk;
       prd       postgres    false    207    248    3301            C           2606    98661 ?   movimientos_trasportes movimientos_trasportes__transportista_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes__transportista_fk FOREIGN KEY (cuit) REFERENCES core.transportistas(cuit);
 f   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes__transportista_fk;
       prd       postgres    false    250    257    3309            @           2606    74796 0   movimientos_trasportes movimientos_trasportes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk FOREIGN KEY (prov_id) REFERENCES alm.alm_proveedores(prov_id);
 W   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk;
       prd       postgres    false    3279    250    228            A           2606    74801 2   movimientos_trasportes movimientos_trasportes_fk_1    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk_1 FOREIGN KEY (esta_id) REFERENCES prd.establecimientos(esta_id);
 Y   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk_1;
       prd       postgres    false    3297    245    250            B           2606    74870 2   movimientos_trasportes movimientos_trasportes_fk_2    FK CONSTRAINT     �   ALTER TABLE ONLY prd.movimientos_trasportes
    ADD CONSTRAINT movimientos_trasportes_fk_2 FOREIGN KEY (reci_id) REFERENCES prd.recipientes(reci_id);
 Y   ALTER TABLE ONLY prd.movimientos_trasportes DROP CONSTRAINT movimientos_trasportes_fk_2;
       prd       postgres    false    3301    248    250            >           2606    74818 (   recipientes recipientes_alm_depositos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_alm_depositos_fk FOREIGN KEY (depo_id) REFERENCES alm.alm_depositos(depo_id);
 O   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_alm_depositos_fk;
       prd       postgres    false    3275    248    224            ?           2606    74875    recipientes recipientes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recipientes
    ADD CONSTRAINT recipientes_fk FOREIGN KEY (motr_id) REFERENCES prd.movimientos_trasportes(motr_id);
 A   ALTER TABLE ONLY prd.recipientes DROP CONSTRAINT recipientes_fk;
       prd       postgres    false    3303    250    248            E           2606    98690    fraccionamientos recu_id    FK CONSTRAINT     y   ALTER TABLE ONLY prd.fraccionamientos
    ADD CONSTRAINT recu_id FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id);
 ?   ALTER TABLE ONLY prd.fraccionamientos DROP CONSTRAINT recu_id;
       prd       postgres    false    259    3259    209            ,           2606    98631    recursos recursos_fk    FK CONSTRAINT     u   ALTER TABLE ONLY prd.recursos
    ADD CONSTRAINT recursos_fk FOREIGN KEY (equi_id) REFERENCES core.equipos(equi_id);
 ;   ALTER TABLE ONLY prd.recursos DROP CONSTRAINT recursos_fk;
       prd       postgres    false    3305    254    209            .           2606    74744 &   recursos_lotes recursos_lotes_lotes_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recursos_lotes
    ADD CONSTRAINT recursos_lotes_lotes_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id) ON DELETE RESTRICT;
 M   ALTER TABLE ONLY prd.recursos_lotes DROP CONSTRAINT recursos_lotes_lotes_fk;
       prd       postgres    false    3257    207    210            -           2606    57695 )   recursos_lotes recursos_lotes_recursos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY prd.recursos_lotes
    ADD CONSTRAINT recursos_lotes_recursos_fk FOREIGN KEY (recu_id) REFERENCES prd.recursos(recu_id) ON DELETE RESTRICT;
 P   ALTER TABLE ONLY prd.recursos_lotes DROP CONSTRAINT recursos_lotes_recursos_fk;
       prd       postgres    false    209    3259    210           