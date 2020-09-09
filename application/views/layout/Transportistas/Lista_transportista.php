<!--__________________TABLA___________________________-->
	<table id="tabla_transportistas" class="table table-bordered table-striped">
		<thead class="thead-dark" bgcolor="#eeeeee">
				<th>Acciones</th>
				<th>Nombre / Razon social</th>
				<th>e-Mail</th>
				<th>Descripcion</th>
				<th>Registro</th>
		</thead>
		<tbody>
			<?php
				if($transportistas)
				{
					foreach($transportistas as $fila)
					{					
						echo "<tr data-json='".json_encode($fila)."' id='".$fila->tran_id."'>";
						echo    '<td>';
						echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modalEdit" id="btnEditar"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp					
										<button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
										
										<button type="button" title="eliminar" class="btn btn-primary btn-circle btnDelete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';
						echo   '</td>';
						echo    '<td>'.$fila->razon_social.'</td>';
						echo    '<td>'.$fila->user_id.'</td>';
						echo    '<td>'.$fila->descripcion.'</td>';
						echo    '<td>'.$fila->registro.'</td>';                       
						echo '</tr>';
					}
				}
			?>
		</tbody>
	</table>
<!--__________________FIN TABLA___________________________-->



<!--- SCRIPTS --->
<script>	
	// llena modal solo lectura
		$(".btnInfo").on("click", function() {
			datajson = $(this).parents("tr").attr("data-json");
			$(".titulo").text('Informacion Transportista');
			$(".oculta_info").removeAttr("style");
			$(".oculta_edit").attr("style","display:none");
			$(".esconder").attr("style","left: -2rem; top: -2rem; "); 
			llenarModal(datajson);	
			blockEdicion();
			
			
		});

	// llena modal para edicion
		$(".btnEditar").on("click", function() {
			datajson = $(this).parents("tr").attr("data-json");
			$(".titulo").text('Editar Transportista');
			$(".oculta_info").attr("style","display:none");
			$(".oculta_edit").removeAttr("style");
			$(".esconder").attr("style","display:none");
			llenarModal(datajson);
			habilitarEdicion();
		});

	//bloquea campos en modal
		function blockEdicion(){	

			$(".habilitar").attr("readonly","readonly");	
			$('#btnsave').hide();
		}

	//desbloquea campos en modal
		function habilitarEdicion(){

			$('.habilitar').removeAttr("readonly");//
			$('#btnsave').show();	
		}

	//llena modal Editar
		function llenarModal(datajson){

			data = JSON.parse(datajson);
			$("input#tran_id").val(data.tran_id);			
			$("input#razon_social_edit").val(data.razon_social);			
			$("input#direccion_edit").val(data.direccion);
			$("input#telefono_edit").val(data.telefono);
			$("input#descripcion_edit").val(data.descripcion);
			$("input#contacto_edit").val(data.contacto);
			$("input#registro_edit").val(data.registro);	
			$("input#cuit_edit").val(data.cuit);
			$("input#resolucion_edit").val(data.resolucion);	
			// formateo fecha en input tipo date
			var fecha_alta = data.fec_alta.slice(0, 10)	// saco hs y minutos
			Date.prototype.toDateInputValue = (function() {
				var local = new Date(fecha_alta);
				// local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
				return local.toJSON().slice(0, 10);
			});
			$('input#fec_alta_edit').val(new Date().toDateInputValue());
			// formateo fecha en input tipo date
			var fecha_baja = data.fec_baja_efectiva.slice(0, 10)	// saco hs y minutos
			Date.prototype.toDateInputValue = (function() {
				var local = new Date(fecha_baja);
				// local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
				return local.toJSON().slice(0, 10);
			});
			$('input#fec_baja_efectiva').val(new Date().toDateInputValue());
		
			$.ajax({
					type: "POST",		
					url: "general/Estructura/Transportista/obtener_RSU",
					success: function (result) {					
							$('.select4').find('option').remove();							
							var tipos = JSON.parse(result);		
							var opcGuardadas = [];
							// recorro todos los tipos de carga 
							$.each(tipos, function(key,rsu){
									//agrega las opciones de RSU
									$('select#tica_edit').append("<option value='" + rsu.tabl_id + "'>" +rsu.valor+"</option");		
									// recorro los tipos de carga asociados
									$.each(data.tiposCarga.cargas, function(key,rsu_asociado){
										if (rsu_asociado.tica_id == rsu.tabl_id) {	
												opcGuardadas.push(rsu.tabl_id);										
										}									
									});								
							});
							// seteo as opciones predeterminadas
							$('select#tica_edit').val(opcGuardadas);
					}
			});
		}

	

	//levanta modal y guarda tran_id
		$(".btnDelete").on("click", function() {
			datajson = $(this).parents("tr").attr("data-json");
			data = JSON.parse(datajson);
			var tran_id = data.tran_id;
			// guardo tran_id en modal para usar en funcion eliminar
			$("#transp_delete").val(tran_id);
			//levanto modal	
			$("#modalaviso").modal('show');		
		});

	

	// //Script Bootstrap Validacion.
	// 	$('#frm_transportista').bootstrapValidator({
	// 				message: 'This value is not valid',
	// 				fields: {
	// 						razon_social: {
	// 								message: 'la entrada no es valida',
	// 								validators: {
	// 										notEmpty: {
	// 												message: 'la entrada no puede ser vacia'
	// 										},
	// 										regexp: {
	// 												regexp: /[A-Za-z-z0-9]/,
	// 												message: 'la entrada no debe ser solo numeros'
	// 										}
	// 								}
	// 						},            
	// 						direccion: {
	// 								message: 'la entrada no es valida',
	// 								validators: {
	// 										notEmpty: {
	// 												message: 'la entrada no puede ser vacia'
	// 										},
	// 										regexp: {
	// 												regexp: /[A-Za-z-z0-9]/,
	// 												message: 'la entrada no debe ser un numero entero'
	// 										}
	// 								}
	// 						},
	// 						telefono: {
	// 								message: 'la entrada no es valida',
	// 								validators: {                    
	// 										regexp: {
	// 												regexp: /^(0|[1-9][0-9]*)$/,
	// 												message: 'la entrada debe ser un numero entero'
	// 										}
	// 								}
	// 						},
	// 						descripcion: {
	// 							message: 'la entrada no es valida',
	// 							validators: {
	// 									notEmpty: {
	// 											message: 'la entrada no puede ser vacia'
	// 									},
	// 									regexp: {
	// 											regexp: /[A-Za-z]/,
	// 											message: 'la entrada no debe ser un numero entero'
	// 									}
	// 							}
	// 						},
	// 						contacto: {
	// 								message: 'la entrada no es valida',
	// 								validators: {
	// 										regexp: {
	// 												regexp: /^(0|[1-9][0-9]*)$/,
	// 												message: 'la entrada no debe ser un numero entero'
	// 										}
	// 								}
	// 						},
	// 						registro: {
	// 							message: 'la entrada no es valida',
	// 							validators: {
	// 									notEmpty: {
	// 											message: 'la entrada no puede ser vacia'
	// 									},
	// 									regexp: {
	// 											regexp: /[A-Za-z-z0-9]/,
	// 											message: 'la entrada no debe ser un numero entero'
	// 									}
	// 							}
	// 						},
	// 						cuit: {
	// 								message: 'la entrada no es valida',
	// 								validators: {
	// 										notEmpty: {
	// 												message: 'la entrada no puede ser vacia'
	// 										},
	// 										regexp: {
	// 												regexp: /^(0|[1-9][0-9]*)$/,
	// 												message: 'la entrada no debe ser un numero entero'
	// 										}
	// 								}
	// 						},            
	// 						resolucion: {
	// 								message: 'la entrada no es valida',
	// 								validators: {
	// 										notEmpty: {
	// 												message: 'la entrada no puede ser vacia'
	// 										},
	// 										regexp: {
	// 												regexp: /[A-Za-z]/,
	// 												message: 'la entrada no debe ser un numero entero'
	// 										}
	// 								}
	// 						},            
	// 						fec_alta: {
	// 								message: 'la entrada no es valida',
	// 								validators: {
	// 										notEmpty: {
	// 												message: 'la entrada no puede ser vacia'
	// 										},
	// 								}
	// 						},
	// 						fec_baja: {
	// 								message: 'la entrada no es valida',
	// 								validators: {
	// 										notEmpty: {
	// 												message: 'la entrada no puede ser vacia'
	// 										},
	// 								}
	// 						}
	// 				}
	// 	}).on('success.form.bv', function(e) {
	// 			e.preventDefault();
	// 			//guardar();
	// 	});	

	// // este script me permite limpiar la validacion una vez cerrado el modal
	// 	$("#modalEdit").on("hidden.bs.modal", function (e) {
    //     $("#frm_transportista").data('bootstrapValidator').resetForm();
    // });
	
	//Initialize Select2 Elements
		$('.select4').select2();

	// inicializo tabla
		DataTable($('#tabla_transportistas'));

</script>
           

