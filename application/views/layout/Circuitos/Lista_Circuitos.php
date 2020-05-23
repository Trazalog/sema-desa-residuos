

<!-- ______ TABLA PRINCIPAL DE PANTALLA ______ -->
	<table id="tabla_circuitos" class="table table-bordered table-striped">
		<thead class="thead-dark" bgcolor="#eeeeee">
				<th>Acciones</th>
				<th>Codigo</th>
				<th>Chofer</th>
				<th>Vehiculo</th>	
				<th>Descripcion</th>
		</thead>
		<tbody >
			<?php  
				if($circuitos)
				{
					foreach($circuitos as $fila)
					{
						echo "<tr data-json='".json_encode($fila)."'>";
						echo    '<td>';
						echo    '<button  type="button" title="Editar"  class="btn btn-primary btn-circle btnEditar" data-toggle="modal" 			data-target="#modalEdit" id="btnEditar"  ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
								<button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalEdit" ><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp 								
								<button  type="button" title="Asociar Zona"  class="btn btn-primary btn-circle btnAsociar" data-toggle="modal" data-target="#modalAsociar" id="btnAsociar"  ><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span></button>&nbsp
								<button type="button" title="Eliminar" class="btn btn-primary btn-circle btnEliminar" data-toggle="modal" data-target="#modalBorrar" id="btnBorrar"  ><span class="glyphicon glyphicon-trash" aria-hidden="true" ></span></button>&nbsp';
						echo "</td>";
						echo "<td>".$fila->codigo."</td>";
						echo "<td>".$fila->chofer."</td>";
						echo "<td>".$fila->dominio."</td>";					
						echo "<td>".$fila->descripcion."</td>";
						echo '</tr>';
					}
				}
			?>
		</tbody>
	</table>	
<!--_______ FIN TABLA PRINCIPAL DE PANTALLA ______-->

<script>
	
	// llena modal solo lectura
		$(".btnInfo").on("click", function(e){
			datajson = $(this).parents("tr").attr("data-json");
			llenarModal(datajson);	
			blockEdicion();
		});
	// llena modal para edicion
		$(".btnEditar").on("click", function(e) {
			datajson = $(this).parents("tr").attr("data-json");
			llenarModal(datajson);
			habilitarEdicion();
		});
	// remueve registro de taba temporal 
		$(document).on("click",".fa-minus",function() {
			$('#tabla_puntos_criticos_edit').DataTable().row( $(this).closest('tr') ).remove().draw();
		});
	// bloquea campos en modal
		function blockEdicion(){
			$(".habilitar").attr("readonly","readonly");
			$(".selec_habilitar").attr('disabled', 'disabled');
			$("#tica_edit").prop("disabled", true); 
			$("#btn_agregar_edit").hide();
			$(".fa-minus").click(false);	
			$('#form_editar_pto_critico').hide();
			$("#img_file").attr("disabled", "disabled");
		}
	// desbloquea campos en modal
		function habilitarEdicion(){
			$('.habilitar').removeAttr("readonly");//
			$(".selec_habilitar").removeAttr("disabled");
			$("#tica_edit").prop("disabled", false); 
			$("#btn_agregar_edit").show();
			$(".fa-minus").click(true);
			$('#form_editar_pto_critico').show();	
			$("#img_file").removeAttr("disabled");
		}	
	// llena modal Editar
		function llenarModal(datajson){

			data = JSON.parse(datajson); 	
			// lena los inputs
			$("#zona_id_edit").val(data.zona_id);
			$("#circ_id_edit").val(data.circ_id);
			$("input#codigo_edit").val(data.codigo);	
			$("input#descripcion_edit").val(data.descripcion);
			$("#vehi_id_edit option[value="+ data.vehi_id +"]").attr("selected",true);
			$("#chof_id_edit option[value="+ data.chof_id +"]").attr("selected",true);

			// lena input tipo RSU 
			llenarSelectRsu(data.tiposCarga.carga);
			// llena tabal de ptos criticos para editar
			llenarTablaPuntosEdit(data.puntos.punto);
			// trae imagen si hay aguna guardada
			llenarImagen(data.circ_id);
		}	
	// lena select multiple con RSU y selcciona los guardados
		function llenarSelectRsu(tipos){	
				
			var opcGuardadas = [];		
			// recorro los tipos de carga asociados		
			$.each(tipos, function(key,rsu_asociado){				
				opcGuardadas.push(rsu_asociado.tica_id);		
			});					
			// seteo as opciones predeterminadas
			$('#tica_edit').val(opcGuardadas);
			$('#tica_edit').trigger('change');	
		}	
	// agrega puntos criticos guardados a la tabla para guardar 
	function llenarTablaPuntosEdit(data) {	

		 var table = $('#tabla_puntos_criticos_edit').DataTable();	
		 //$('#tabla_puntos_criticos_edit').DataTable().columns.adjust();
		 table.clear().draw();

		$.each(data,function(index,element){	

			console.info('nombre-> ' + element.nombre);
			if(element.nombre){
				var row =  "<tr class='row_edit row_borrar' data-json='" +JSON.stringify(element)+ "'>" +
					"<td> <i class='fa fa-fw fa-minus text-light-blue' style='cursor: pointer; margin-left: 15px;' title='Nuevo'></i> </td>" +
					"<td>"+ element.nombre +"</td>" +
					"<td>"+ element.descripcion +"</td>" +
					"<td>"+ element.lat +"</td>" +
					"<td>"+ element.lng +"</td>" +            
					"</tr>";
				table.row.add($(row)).draw();  
			}			
		});		

	}

	// agrega datos de un punto critico a la tabla temporal para editar
	function Agregar_punto_edit() {

		var table_edit = $('#tabla_puntos_criticos_edit').DataTable();	
		var data_edit = new FormData($('#formPuntos_edit')[0]);
		data_edit = formToObject(data_edit);
		var row =  "<tr class='row_edit row_borrar' data-json=" +JSON.stringify(data_edit)+ ">" +
					"<td> <i class='fa fa-fw fa-minus text-light-blue' style='cursor: pointer; margin-left: 15px;' title='Nuevo'></i> </td>" +
					"<td>"+ data_edit.nombre +"</td>" +
					"<td>"+ data_edit.descripcion +"</td>" +
					"<td>"+ data_edit.lat +"</td>" +
					"<td>"+ data_edit.lng +"</td>" +            
					"</tr>";
		table_edit.row.add($(row)).draw(); 
		$('#formPuntos_edit')[0].reset();  
	}	

	// guarda Edicion completa		
	$("#btnsave_edit").on("click", function() {

		// tomo los datos de circuito editados
		var circuito_edit = new FormData($('#frm_circuito_edit')[0]);
    circuito_edit = formToObject(circuito_edit);		
		circuito_edit.imagen = $("#input_aux_img64").val(); 
		
		// tipos de carga asociados
		var tipoCarga = $("#tica_edit").val();
		var tica_edit = JSON.stringify(tipoCarga);
		// tomo la tabla de puntos criticos editados
		var ptos_criticos_edit = [];		
		var rows = $('#tabla_puntos_criticos_edit tbody tr');				
		rows.each(function(i,e) {  
				ptos_criticos_edit.push(getJson(e));
		});	

		console.table('ptos criticos' + rows);

		$.ajax({
				type: 'POST',
				data:{ circuito_edit, tica_edit, ptos_criticos_edit},
				url: "general/Estructura/Circuito/actulizaCircuitos",
				success: function(result) {
							if(result == 'ok'){
								$("#cargar_tabla").load(
												"<?php echo base_url(); ?>index.php/general/Estructura/Circuito/Listar_Circuitos"
										);
								alertify.success("Circuito editado con exito...");
							}else{
								alertify.error("Error al editar Circuito...");
							}
				},
				error: function(result){
									
				}
		});

	});
	// trae array con departamentos y lena el select depAsociar
	$(".btnAsociar").on("click", function() {
		
		//guardo id de circuito en modal para usar en asociacion
		datajson = $(this).parents("tr").attr("data-json");
		data = JSON.parse(datajson);
		$('#circ_id_asociar').val(data.circ_id);
		
		$.ajax({
				type: 'POST',
				//data:{: },
				url: "general/Estructura/Circuito/obtener_Departamentos",
				success: function(result) {
							if(result){
									console.table( ' resultado: ' + result);
									$.each(JSON.parse(result), function(key,dep){									
										$('#depAsociar').append("<option value='" + dep.depa_id + "'>" +dep.nombre+"</option");	
									});
							}
				},
				error: function(result){
									
				}
		});	
	});
	// llena select de zonas por id de depto
	$('#depAsociar').change(function(e){
		e.preventDefault();
    var depa_id = $('#depAsociar option:selected').val();
		console.info('depa_id : ' + depa_id);
		$.ajax({
				type: 'POST',
				data:{depa_id: depa_id},
				url: "general/Estructura/Circuito/obtener_Zona_departamento",
				success: function(result) {
					if(result){
									console.table( ' resultado: ' + result);
									$.each(JSON.parse(result), function(key,zona){
										$('#zonaAsociar').append("<option value='" + zona.zona_id + "'>" +zona.zona_nom+"</option");	
									});
							}
				},
				error: function(result){
									
				}
		});
	});
	// Asocia zona a circuito
	$("#btnsaveAsociacion").on("click", function() {
	
		var idcircuito	= $('#circ_id_asociar').val();	
		var idzona = $('#zonaAsociar option:selected').val();
		
		var circ_zona = new Object();
		circ_zona.circ_id = idcircuito;
		circ_zona.zona_id = idzona;	

		console.table('array objeto no se: ' + circ_zona);

		$.ajax({
				type: 'POST',
				data:{circ_zona},
				url: "general/Estructura/Circuito/Asignar_Zona",
				success: function(result) {					
							if(result == 'ok'){
								alertify.success("Zona asociada con exito...");
							}else{
								alertify.error("Hubo error en la Asociacion...");
							}
				},
				error: function(result){
									
				}
		});

	});
	// Levanta modal prevencion eliminar circuito
	$(".btnEliminar").on("click", function() {
		datajson = $(this).parents("tr").attr("data-json");
		data = JSON.parse(datajson);
		var circ_id = data.circ_id;	
		// guardo circ_id en modal para usar en funcion eliminar
		$("#circuito_delete").val(circ_id);
		//levanto modal	
		$("#modalaviso").modal('show');	
	});
	// Elimina circuito 
	function eliminar(){

		var circ_id = $("#circuito_delete").val();
		$.ajax({
				type: 'POST',
				data:{circ_id: circ_id},
				url: "general/Estructura/Circuito/borrar_Circuito",
				success: function(result) {
							if(result == "ok"){
								$("#modalaviso").modal('hide');
								$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Circuito/Listar_Circuitos");	
							}else{
								$("#modalaviso").modal('hide');	
							}
				},
				error: function(result){
					$("#modalaviso").modal('hide');			
				}
		});

	}	


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
	function llenarImagen(circ_id){
		
		$('#input_aux_img64').attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==');
		$('#img_base').attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==');  // This will change the src to a 1x1 pixel

		$.ajax({
					type: "POST",
					data: {circ_id: circ_id},
					url: "general/Estructura/Circuito/obtener_Imagen",
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

  // script Datatables
  DataTable($('#tabla_circuitos'));	
  // Initialize Select2 Elements
  $('.select3').select2();

</script>





