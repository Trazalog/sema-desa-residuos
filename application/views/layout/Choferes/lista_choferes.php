<!--__________________HEADER TABLA__________________-->
	<table id="tabla_choferes" class="table table-bordered table-striped">
		<thead class="thead-dark" bgcolor="#eeeeee">
			<th>Acciones</th>
			<th>Nombre y Apellido</th>
			<th>Direccion</th>
			<th>Celular</th>
			<th>Codigo</th>
			<th>Empresa</th>
			<th>Carnet y Categoria</th>
			<th>Habiitación</th>
		</thead>

		<!--__________________BODY TABLA__________________-->

		<tbody>
			<?php
					if($choferes)
					{
							foreach($choferes as $fila)
							{
							//echo '<tr data-json:'.json_encode($fila).'>';
							echo "<tr data-json='".json_encode($fila)."'>";
							echo    '<td>';
							echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
							<button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp 
							<button type="button" title="eliminar" class="btn btn-primary btn-circle btnDelete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';

							echo   '</td>';
							echo    '<td>'.$fila->nombre. " " .$fila->apellido.'</td>';
							echo    '<td>'.$fila->direccion.'</td>';
							echo    '<td>'.$fila->celular.'</td>';
							echo    '<td>'.$fila->codigo.'</td>';
							echo    '<td>'.$fila->razon_social.'</td>';
							echo    '<td>'.$fila->carnet. " - ".$fila->categoria.'</td>';
							echo    '<td>'.$fila->habilitacion.'</td>';
							echo   '</tr>';
							}
					}
					?>
		</tbody>
	</table>

<!--__________________FIN TABLA__________________-->




<script>

	////// funciones imagen EDICION
		//cada vez que carga una imagen	
		async function convert_Edit(){       
			
			var file = document.getElementById('img_file').files[0];
			
			if (file) {
					
					var archivo = await getFile(file);			
					if(archivo.fileType == "image/jpeg"){
							var cod = "data:image/jpeg;base64,"+archivo.base64StringFile;
							//var cod = "data:image/png;base64,"+archivo.base64StringFile;
					}else{
							if(archivo.fileType == "application/pdf"){
									var cod = "data:application/pdf;base64,"+archivo.base64StringFile;
							}				
					}             
					console.table(archivo.fileType);				
					console.table(cod);
					$("#input_aux_img64").val(cod);
					console.table($("#input_aux_img64").val());
					$("#img_base").attr("src",$("#input_aux_img64").val());
					$("#img_base").attr("width",100);
					$("#img_base").attr("height",100);			
			}      
		}	
		// trae imagen guardada a vista previa
		function llenarImagen(chof_id){
			
			$('#input_aux_img64').attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==');
			$('#img_base').attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==');  // This will change the src to a 1x1 pixel

			$.ajax({
						type: "POST",
						data: {chof_id: chof_id},
						url: "general/Estructura/Chofer/obtener_Imagen",
						success: function ($dato) {		
										var imagen = JSON.parse($dato);	
										//console.info('imagen en llenar imagen: ' + imagen);						
										var img_b64 = imagen;									
										if(img_b64[4]=='a'){
										pdf(img_b64);
										}else{
												if(img_b64[4]=='i'){jpg(img_b64);}
										}								
										//console.table("Como queda src final en llenar imagen: "+img_b64);
						}
				});
			}
		// carga la imagen en imagen base	
		function cargarImg(){   
				var val = $("#input_aux_img64").val();
				console.table(val);
				$("#img_base").attr("src",val);   
				return;   
			}	
		//3
		function pdf($img_b64){
				var aux_link = "";
				for(var i=25; i <= $img_b64.length-1; i++){
						aux_link = aux_link + $img_b64[i];
				}
				img = "data:application/pdf;base64,"+aux_link;
			
				var ref = img;
				ref= ref+"G";
				$("#input_aux_img64").val(ref);
				console.table("aca con la G agregada"+ref);
				$("#pdf").attr("href",ref);
				$("#img_base").attr("src",$("#input_aux_img64").val());
				$("#img_base").attr("width",100);
				$("#img_base").attr("height",100);
		}
		//2
		function jpg($img_b64){
				var aux_link = "/";
				for(var i=21; i <= $img_b64.length-1; i++){
						aux_link = aux_link + $img_b64[i];
				}
				img = "data:image/jpeg;base64,"+aux_link;
				$("#input_aux_img64").val(img);
				$("#img_base").attr("src",$("#input_aux_img64").val());
				$("#img_base").attr("width",100);
				$("#img_base").attr("height",100);
				var ref = $("#input_aux_img64").val();
				$("#pdf").attr("href",ref);
		}	
		//Convertir a base64 el archivo Imagen
		function getFile(file){
			var reader = new FileReader();
			return new Promise((resolve, reject) => {
				reader.onerror = () => {
					reader.abort();
					reject(new Error("Error parsing file"));
				}
				reader.onload = function() {
					//This will result in an array that will be recognized by C#.NET WebApi as a byte[]
					let bytes = Array.from(new Uint8Array(this.result));
					//if you want the base64encoded file you would use the below line:
					let base64StringFile = btoa(bytes.map((item) => String.fromCharCode(item)).join(""));
					//Resolve the promise with your custom file structure
					resolve({
						bytes: bytes,
						base64StringFile: base64StringFile,
						fileName: file.name,
						fileType: file.type
					});
				}
				reader.readAsArrayBuffer(file);
			});
		}
		
	////// fin funciones imagen EDICION


	// llena modal solo lectura
		$(".btnInfo").on("click", function() {
			datajson = $(this).parents("tr").attr("data-json");
			llenarModal(datajson);
			blockEdicion();
		});

	// llena modal para edicion
		$(".btnEditar").on("click", function() {
			datajson = $(this).parents("tr").attr("data-json");
			llenarModal(datajson);
			habilitarEdicion();
		});

	//bloquea campos en modal
		function blockEdicion() {

			$(".habilitar").attr("readonly", "readonly");
			$(".selec_habilitar").attr('disabled', 'disabled');
			$('#img_file').attr('disabled', 'disabled');
			$('#btnsave').hide();
		}
		
	//desbloquea campos en modal
		function habilitarEdicion() {

			$('.habilitar').removeAttr("readonly"); //
			$(".selec_habilitar").removeAttr("disabled");
			$('#img_file').removeAttr('disabled');
			$('#btnsave').show();
		}

	//llena modal Editar
		function llenarModal(datajson) {

			data = JSON.parse(datajson);		
			
			$("input#chof_id_edit").val(data.chof_id);
			$("input#nombre_edit").val(data.nombre);
			$("input#apellido_edit").val(data.apellido);
			$("input#dni_edit").val(data.documento);
			$("input#direccion_edit").val(data.direccion);
			$("input#celular_edit").val(data.celular);
			$("input#codigo_edit").val(data.codigo);
			$("select#tran_id_edit option[value=" + data.tran_id + "]").attr("selected", true);
			$("select#carnet_edit option[value=" + data.carn_id + "]").attr("selected", true);//
			$("select#cach_id_edit option[value=" + data.cach_id + "]").attr("selected", true);
			$("input#habilitacion_edit").val(data.habilitacion);

			// formateo fecha en input tipo date
			var fec_nacimiento = data.fec_nacimiento.slice(0, 10) // saco hs y minutos		
			Date.prototype.toDateInputValue = (function() {
				var local = new Date(fec_nacimiento);
				// local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
				return local.toJSON().slice(0, 10);
			});
			$('input#fec_nacimiento_edit').val(new Date().toDateInputValue());

			// formateo fecha en input tipo date
			var vencimiento = data.vencimiento.slice(0, 10) // saco hs y minutos
			Date.prototype.toDateInputValue = (function() {
				var local = new Date(vencimiento);
				// local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
				return local.toJSON().slice(0, 10);
			});
			$('input#vencimiento_edit').val(new Date().toDateInputValue());
			
			// trae imagen si hay aguna guardada
			llenarImagen(data.chof_id);			
		}

	//boton guardar edicion
		$("#btnsave").on("click", function() {
			//tomo datos del form y hago objeto
			var chofer = new FormData($('#frm_chofer_edit')[0]);
			chofer = formToObject(chofer);
			chofer.imagen = $("#input_aux_img64").val(); 
	
			// if ($("#frm_chofer_edit").data('bootstrapValidator').isValid()) {
				$.ajax({
					type: "POST",
					data: {	chofer },
					url: "general/Estructura/Chofer/Modificar_Chofer",
					success: function(result) {
						if (result == "error") {
							alertify.error("Hubo un error a modificar Chofer");
						} else {
							$("#cargar_tabla").load(
								"<?php echo base_url(); ?>index.php/general/Estructura/Chofer/Listar_Chofer");
							alertify.success("Datos de Chofer modificados con exito...");
						}
					}
				});
		//	}
		});

	//levanta modal y guarda tran_id
		$(".btnDelete").on("click", function() {
		
			datajson = $(this).parents("tr").attr("data-json");
			data = JSON.parse(datajson);
			var chof_id = data.chof_id;		
			// guardo tran_id en modal para usar en funcion eliminar
			$("#chof_delete").val(chof_id);
			//levanto modal
			$("#modalaviso").modal('show');
		});

	//elimina chof y recarga la tabla
		function eliminar() {

			var chof_id = $("#chof_delete").val();		

			$.ajax({
				type: "POST",
				data: {	chof_id: chof_id },
				url: "general/Estructura/Chofer/Borrar_Chofer",
				success: function(result) {
					$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Chofer/Listar_Chofer");
					$("#modalaviso").modal('hide');
				},
				error: function(result) {
					$("#modalaviso").modal('hide');
				}
			});
		}

	// Script validacion
		$('#frm_chofer_edit').bootstrapValidator({
			message: 'This value is not valid',
			/*feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
			},*/
			//excluded: ':disabled',
			fields: {
				nombre: {
					message: 'la entrada no es valida',
					validators: {
						notEmpty: {
							message: 'la entrada no puede ser vacia'
						},
						/*stringLength: {
								min: 6,
								max: 30,
								message: 'The username must be more than 6 and less than 30 characters long'
						},*/
						regexp: {
							regexp: /[A-Za-z]/,
							message: 'la entrada no debe ser un numero entero'
						}
					}
				},
				apellido: {
					message: 'la entrada no es valida',
					validators: {
						notEmpty: {
							message: 'la entrada no puede ser vacia'
						},
						/*stringLength: {
								min: 6,
								max: 30,
								message: 'The username must be more than 6 and less than 30 characters long'
						},*/
						regexp: {
							regexp: /[A-Za-z]/,
							message: 'la entrada no debe ser un numero entero'
						}
					}
				},
				documento: {
					message: 'la entrada no es valida',
					validators: {
						notEmpty: {
							message: 'la entrada no puede ser vacia'
						},
						/*stringLength: {
								min: 6,
								max: 30,
								message: 'The username must be more than 6 and less than 30 characters long'
						},*/
						regexp: {
							regexp: /^(0|[1-9][0-9]*)$/,
							message: 'la entrada debe ser un numero entero'
						}
					}
				},
				fec_nacimiento: {
					message: 'la entrada no es valida',
					validators: {
						notEmpty: {
							message: 'la entrada no puede ser vacia'
						},
					}
				},
				direccion: {
					message: 'la entrada no es valida',
					validators: {
						notEmpty: {
							message: 'la entrada no puede ser vacia'
						},
						/*stringLength: {
								min: 6,
								max: 30,
								message: 'The username must be more than 6 and less than 30 characters long'
						},*/
						regexp: {
							regexp: /[A-Za-z]/,
							message: 'la entrada no debe ser un numero entero'
						}
					}
				},
				celular: {
					message: 'la entrada no es valida',
					validators: {
						notEmpty: {
							message: 'la entrada no puede ser vacia'
						},
						/*stringLength: {
								min: 6,
								max: 30,
								message: 'The username must be more than 6 and less than 30 characters long'
						},*/
						regexp: {
							regexp: /^(0|[1-9][0-9]*)$/,
							message: 'la entrada no debe ser un numero entero'
						}
					}
				},
				codigo: {
					message: 'la entrada no es valida',
					validators: {
						notEmpty: {
							message: 'la entrada no puede ser vacia'
						}
					}
				},
				tran_id: {
					message: 'la entrada no es valida',
					validators: {
						notEmpty: {
							message: 'la entrada no puede ser vacia'
						}
					}
				},
				carnet: {
					message: 'la entrada no es valida',
					validators: {
						notEmpty: {
							message: 'la entrada no puede ser vacia'
						}
					}
				},
				cach_id: {
					message: 'la entrada no es valida',
					validators: {
						notEmpty: {
							message: 'la entrada no puede ser vacia'
						},
						/*stringLength: {
								min: 6,
								max: 30,
								message: 'The username must be more than 6 and less than 30 characters long'
						},*/
						regexp: {
							regexp: /[A-Za-z]/,
							message: 'la entrada no debe ser un numero entero'
						}
					}
				},
				vencimiento: {
					message: 'la entrada no es valida',
					validators: {
						notEmpty: {
							message: 'la entrada no puede ser vacia'
						},
					}
				},
				habilitacion: {
					message: 'la entrada no es valida',
					validators: {
						notEmpty: {
							message: 'la entrada no puede ser vacia'
						},
						/*stringLength: {
								min: 6,
								max: 30,
								message: 'The username must be more than 6 and less than 30 characters long'
						},*/
						regexp: {
							regexp: /[A-Za-z]/,
							message: 'la entrada no debe ser un numero entero'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
			e.preventDefault();
			//guardar();
		});

	
	// este script me permite limpiar la validacion una vez cerrado el modal
		$("#modalEdit").on("hidden.bs.modal", function(e) {
			$("#frm_chofer_edit").data('bootstrapValidator').resetForm();
		});

	//Initialize Select2 Elements
		$('.select4').select2();

	// inicializo tabla
		DataTable($('#tabla_choferes'))
</script>