

<!-- ______ TABLA PRINCIPAL DE PANTALLA ______ -->
	<table id="tabla_circuitos" class="table table-bordered table-striped">
		<thead class="thead-dark" bgcolor="#eeeeee">
				<th>Acciones</th>
				<th>Codigo</th>
				<th>Chofer</th>
				<th>Vehiculo</th>
				<th>Tipo de residuo</th>
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
						echo "<td>".$fila->chof_id."</td>";
						echo "<td>".$fila->vehi_id."</td>";
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
	// remueve registro de lista temporal de puntos criticos
	$(document).on("click", ".fa-minus", function() {             
			$(this).parents("tr").remove();
	});
	//bloquea campos en modal
	function blockEdicion(){
		$(".habilitar").attr("readonly","readonly");
		$("#btn_agregar_edit").hide();
		$(".fa-minus").click(false);	
		$('#form_editar_pto_critico').hide();
	}
	//desbloquea campos en modal
	function habilitarEdicion(){
		$('.habilitar').removeAttr("readonly");//
		$("#btn_agregar_edit").show();
		$(".fa-minus").click(true);
		$('#form_editar_pto_critico').show();	
	}	
	//llena modal Editar
	function llenarModal(datajson){

		data = JSON.parse(datajson); 	
		// lena los inputs
		$("input#codigo_edit").val(data.codigo);			
		$("input#vehiculo_edit").val(data.dominio);
    $("input#chofer_edit").val(data.chofer);
		$("input#chof_id_edit").val(data.chof_id);
		$("input#descripcion_edit").val(data.descripcion);
		// lena input tipo RSU ademas de todas las opciones posibles
		$.ajax({
				type: "POST",		
				url: "general/Estructura/Transportista/obtener_RSU",
				success: function (result) {					
						$('#tica_edit').find('option').remove();							
						var tipos = JSON.parse(result);					
						var opcGuardadas = [];
						// recorro todos los tipos de carga 
						$.each(tipos, function(key,rsu){
								//agrega las opciones de RSU
								$('#tica_edit').append("<option value='" + rsu.tabl_id + "'>" +rsu.valor+"</option");		
								// recorro los tipos de carga asociados
								$.each(data.tiposCarga.carga, function(key,rsu_asociado){
									if (rsu_asociado.tica_id == rsu.tabl_id) {	
											opcGuardadas.push(rsu.tabl_id);										
									}									
								});								
						});
						// seteo as opciones predeterminadas
						$('#tica_edit').val(opcGuardadas);
				}
		});
		// llena tabal de ptos criticos para editar
		llenarTablaPuntosEdit(data.puntos.punto);

	}
	//agrega punto critico a la tabla para guardar  
	function llenarTablaPuntosEdit(data) {

		//$('#tabla_puntos_criticos_edit tbody tr').remove();

		// var selector = $("#tabla_puntos_criticos_edit tbody").DataTable();
		// selector.find('tr.row_edit').remove();

		//FIXME: ARREGLAR EL DUPLICADO DE REGISTROS

		var table = $('#tabla_puntos_criticos_edit').DataTable();	
	
		$.each(data,function(index,element){
			//console.info('nombre-> ' + element.nombre);
			var row =  "<tr class='row_edit' data-json=" +JSON.stringify(element)+ ">" +
					"<td> <i class='fa fa-fw fa-minus text-light-blue tablamateriasasignadas_borrar' style='cursor: pointer; margin-left: 15px;' title='Nuevo'></i> </td>" +
					"<td>"+ element.nombre +"</td>" +
					"<td>"+ element.descripcion +"</td>" +
					"<td>"+ element.lat +"</td>" +
					"<td>"+ element.lng +"</td>" +            
					"</tr>";
			table.row.add($(row)).draw();  
		});


			// var selector = $("#tica_id");
			// selector.find('option').remove();
			// selector.append('<option value="" disabled selected>-Seleccione opcion-</option>');
			// respuesta.forEach(function(e) {
			// 	selector.append("<option value='" + e.tica_id + "'>" + e.valor + "</option");					
			// });


		
		//$('#formPuntos')[0].reset();          
	}
	//agrega punto critico a la tabla para guardar  
	function Agregar_punto_edit() {

		var table = $('#tabla_puntos_criticos_edit').DataTable();	
		var data = new FormData($('#formPuntos_edit')[0]);
		data = formToObject(data);
		var row =  "<tr class='row_edit' data-json=" +JSON.stringify(data)+ ">" +
					"<td> <i class='fa fa-fw fa-minus text-light-blue tablamateriasasignadas_borrar' style='cursor: pointer; margin-left: 15px;' title='Nuevo'></i> </td>" +
					"<td>"+ data.nombre +"</td>" +
					"<td>"+ data.descripcion +"</td>" +
					"<td>"+ data.lat +"</td>" +
					"<td>"+ data.lng +"</td>" +            
					"</tr>";
			table.row.add($(row)).draw(); 
			$('#formPuntos_edit')[0].reset();  
	}

	// guarda Edicion completa		
	$("#btnsave_edit").on("click", function() {

		// tomo los datos de circuito editados
		var circuito_edit = new FormData($('#frm_circuito_edit')[0]);
    circuito_edit = formToObject(circuito_edit);
		// tipos de carga asociados
		var tipoCarga = $("#tica_edit").val();

		var tica_edit = JSON.stringify(tipoCarga);
		console.table('tipos carga: ' + tica_edit);


		// tomo la tabla de puntos criticos editados
		var ptos_criticos_edit = [];		
		var rows = $('#tabla_puntos_criticos_edit tbody tr');				
		rows.each(function(i,e) {  
				ptos_criticos_edit.push(getJson(e));
		});	

		$.ajax({
				type: 'POST',
				data:{ circuito_edit, tica_edit, ptos_criticos_edit},
				url: "general/Estructura/Circuito/actulizaCircuitos",
				success: function(result) {
							// if(result == ''){
									
							// }
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
								alertify.success("Hubo error en la Asociacion...");
							}
				},
				error: function(result){
									
				}
		});

	});
	// Levanta modal eliminar
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
	
	

	

	// inicializo datatable edicion
	DataTable('#tabla_puntos_criticos_edit');
  // script Datatables
  DataTable($('#tabla_circuitos'));	
  // Initialize Select2 Elements
  $('.select3').select2();

</script>





<script>

	// Funcion Filtrar zonas por departamento

	// $("#selectDepto").change(function(){    
	// 		var idDepto = $("#selectDepto").val();  
	// 		$.ajax({
	// 						type: 'POST',        
	// 						data: {idDepto: idDepto}, 
	// 						url: 'general/Estructura/Zona/obtenerDeptoPorZona',
	// 						dataType: 'json',
	// 						success: function(result) {
	// 								console.table(result);               
	// 								for (let index = 0; index < result.length; index++)
	// 								{                                              
	// 										$('#selectZona').append("<option value='" + result[index].zona_id + "'>" +result[index].zona_nom +"</option");  
	// 								}
	// 						},            
	// 						error: function() {
	// 								alert('Error');
	// 						}
	// 		});
	// });


	// function insertCircuitoZona(){
	//     ban = true;
	//     idDepto = $('#selectDepto').val();
	//     idZona = $('#selectZona').val();
	//     if (idDepto == null) {
	//       ban= false;
	//       alert("Seleccione Departamento...");
	//     } 
	//     if (idZona == null) {
	//       ban= false;
	//       alert("Seleccione Zona...");
	//     } 

	//     if(ban){
	//       $.ajax({
	//             type: 'POST',
	//             data: {id_censo: id_censo,
	//                   id_area: id_area },
	//             url: 'Censo/insertAreaCenso',
	//             dataType: 'json',
	//             success: function(result) { 
	//                       alert('resultado: ' + result);
	//                   if (result == 500) {
	//                     alert("La zona ya se encuentra asignada a este Circuito");
	//                   }else{
	//                     $("#modalZona").modal('hide');
	//                     buscaCensos();
	//                   } 
	//             },
	//             error: function() {
	//                   alert('Error en Asignacion de zona...');
	//             }
	//       });
	//     }  

	// }
</script>