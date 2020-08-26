<h4>Entrega Contenedor</h4>
<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12">
	<!--_____________ Generador _____________-->
		<div class="form-group">															
			<label for="Generador" class="col-sm-4 control-label">Generador:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control habilitar" name="Generador" value="<?php echo $infoSolicitud->razon_social?>" id="generador" readonly> 
			</div>
		</div>
	<!--__________________________-->
    <!--_____________ Nro Pedido _____________-->
		<div class="form-group">															
			<label for="NroPedido" class="col-sm-4 control-label">Nro Pedido:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control habilitar" name="NroPedido" value="<?php echo $infoSolicitud->sotr_id?>" id="nroPedido" readonly> 
			</div>	
		</div>
	<!--__________________________-->
      <!--_____________ Direccion _____________-->
		<div class="form-group">															
			<label for="Direcc" class="col-sm-4 control-label">Direccion:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control habilitar" name="Direcc" value="<?php echo $infoSolicitud->domicilio?>" id="Direccion" readonly> 
			</div>	
		</div>
	<!--__________________________-->
     <!--_____________ fecha de retiro_____________-->
		<div class="form-group">															
			<label for="Fecha_ret" class="col-sm-4 control-label">Fecha de retiro:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control habilitar" name="Fecha_ret" value="<?php echo $infoSolicitud->fec_alta?>" id="FechaRet" format="YYYY-MM-DD" readonly> 
			</div>	
		</div>
	<!--__________________________-->
</div>
<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
<!--_________________SEPARADOR_________________-->
<!--Camiones aca en este select se sacara el equi_id que luego va en el json para el servicio /contenedores/entregados/entregar-->
<div class="form-group camion">
                        <label for="camion">Camion:</label>
                        <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>                    
                            <select class="form-control select2 select2-hidden-accesible" name="camion" id="camion_id">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($camion as $l) {
                                            echo '<option  value="'.$l->equi_id.'">'.$l->dominio.'</option>';
                                        }
                                    ?>
                            </select>
                        </div>
    </div>
	 <div class="form-group fecEntrega">
		<label for="FechaEntrega">Fecha de Entrega:</label>
			<div class="input-group date">
															<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
																	<input type="date" class="form-control"  name="FechaEntrega" id="fec_entrega">
				</div>
				<input id="idSelCantPend" type="text" style="display:none;">
	</div>
<!--_____________ Tabla info soliccitaodos _____________-->
<div class="box-body table-scroll">		
			<table id="tbl_contenedores" class="table table-bordered table-striped">
				<thead class="thead-dark" bgcolor="#eeeeee">				
						<tr>
								<th>Entregar</th> 
								<th>Tipo Residuo</th>
								<th>Cantidad Acordada</th>
								<th>Cantidad Pendiente</th>
                                                       
						</tr>
				</thead>
				<tbody>
						<?php
							echo "<div id='divdato' dato-infoContenedores='".json_encode($infoContenedores)."' dato-ContEntregados='".json_encode($infoContenedoresEntregados)."'>";
							echo '</div>';
							if($infoContenedores)
							{
								$id = 0;
								foreach($infoContenedores as $fila)
								{
									echo "<tr ide='$id' data-json='".json_encode($fila)."'>";
									    
										if($infoContenedoresEntregados)
										{   
											foreach($infoContenedoresEntregados as $a)
											{
												if($fila->valor == $a->valor )
												{   
													if($fila->cantidad_acordada - $a->cant_entregados == 0)
													{echo '<td><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span></td>';}
													else{
													 echo    '<td>';
													 echo    '<button  type="button" title="Entregar"  class="btn btn-primary btn-circle btnEntregar" data-toggle="modal"  id="btnEntregar"  ><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>&nbsp';	
													 echo 	 "</td>";
													}
												}else{
													
												  if(count($infoContenedores) != count($infoContenedoresEntregados))
												  {
													echo    '<td>';
													echo    '<button  type="button" title="Entregar"  class="btn btn-primary btn-circle btnEntregar" data-toggle="modal"  id="btnEntregar"  ><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>&nbsp';	
													echo 	 "</td>";

												  }
												}
												
											}
										}else{
											echo    '<td>';
											echo    '<button  type="button" title="Entregar"  class="btn btn-primary btn-circle btnEntregar" data-toggle="modal"  id="btnEntregar"  ><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>&nbsp';	
											echo 	 "</td>";
										}
										
										echo "<td>".$fila->valor."</td>";
										echo "<td>".$fila->cantidad_acordada."</td>";	
										if($infoContenedoresEntregados)
										{   
											foreach($infoContenedoresEntregados as $a)
											{
												if($fila->valor == $a->valor )
												{	
													$aux = $fila->cantidad_acordada - $a->cant_entregados; 
													if($aux == 0)
													{echo "<td id='$id'>0</td>";}
													else{
													 echo "<td id='$id'>".$aux."</td>";
													}
												}else{
													
													if(count($infoContenedores) != count($infoContenedoresEntregados))
													{
														echo "<td id='$id'>".$fila->cantidad_acordada."</td>";
													}	
												}
											}

										}else{
											echo "<td id='$id'>".$fila->cantidad_acordada."</td>"; //cantidad pendiente la tendre que calcular con la tabla o los elementos que vienen en contenedoresEntregados Ademas deberia calcular que al tener todas las cantidades pendientes en cero no se deberia poder asiganr
										}

                                        // echo "<td id='contenedores'><select  id='cont_id'><option  value='' disabled selected >seleccione</option>";
										// foreach($contenedores as $k){echo '<option  value="'.$k->cont_id.'">'.$k->codigo.'</option>';};
										// echo "</select></td>"; // aca van los contenedores en este caso es un selct el cual se selecciona el contenedor done ira a parar los residuos este no se setea se deja a disposicion para que el usuario seleccione
                                        // // echo "<td> <input id='' style='border:none;' placeholder='Ingrese cantidad'> </td>";
									echo '</tr>';
									$id = $id + 1;
								}
							}
						?>
				</tbody>
		</table>
</div>
<!--_____________ Fin taba _____________-->

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"></div>
<!--_________________SEPARADOR_________________-->
    
    <!--__________________________________________________________________________________________-->
    <!-- en el boton agregar al clikear debe agregar en la tabla de entrega contenedores la nueva entrega junto con las entrega anteriores  -->
    <!-- <div class="text-right"> 
	<button class="btn btn-success estadoTarea" id="agregar" onclick="agregar()">Agregar</button>
	</div> -->
    <!--_________________SEPARADOR_________________-->
    <div class="col-md-12 col-sm-12 col-xs-12"></div>
    <!--_________________SEPARADOR_________________-->

<!--_____________ Entrega Anteriores aca los datos son del servicio contenedoresEntregados/$soco_id con estos debo calcular la cantidad pendiente_____________-->
<div class="box-body table-scroll">		
			<table id="tbl_contenedoresagregados" class="table table-bordered table-striped" style="display:none">
				<thead class="thead-dark" bgcolor="#eeeeee">				
						<tr>
								<th style="display:none">Tipo de Residuos</th>
								<th>Tipo de Carga</th>
								<th style="display:none">Camion</th>
								<th>Camion Dominio</th>
								<th>Contenedor</th>
						</tr>
				</thead>
				<tbody>
						<?php
							// if($infoContenedoresEntregados)
							// {
							// 	foreach($infoContenedoresEntregados as $fila)
							// 	{
							// 		echo "<tr dataa-json='".json_encode($fila)."'>";
							// 		//echo "<tr data-json= >";
										
							// 			echo "<td>".$fila->tica_id."</td>";
							// 			echo "<td>".$fila->cantidad."</td>";										
                            //             echo "<td>".$fila->cantidad_acordada."</td>";
                            //             // echo "<td> <input id='' style='border:none;' placeholder='Ingrese cantidad'> </td>";
							// 		echo '</tr>';
							// 	}
							// }
							// else
							// {
							// 			echo "<td>---</td>";
							// 			echo "<td>---</td>";
							// 			echo "<td>---</td>";
							// }
						?>
				</tbody>
		</table>
</div>
<!--_____________ Fin taba _____________-->

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"></div>
    <!--_________________SEPARADOR_________________-->
    <!-- aca realiza la entrega y envia o inserta con el servicio /contenedores/entregados/entregar -->
    <div class="text-right">
	<button class="btn btn-success estadoTarea" style="display:none" id="entrega" onclick="RealizarEntrega()">Realizar Entrega</button>
</div>
<div class="text-right">
	<button class="btn btn-success" style="display:none" id="botonCerrar" onclick="CerrarTarea()">Cerrar Tarea</button>
</div>

<!---///////--- MODAL EDICION E INFORMACION ---///////---> 
<div class="modal fade" id="modalEntregar">		
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-blue">
				<h5 class="modal-title" ><span class="fa fa-fw fa-times-circle" style="color:#A4A4A4"></span>Seleccion de Contenedor</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" >&times;</span>
				</button>
			</div>
			<input id="circuito_delete" style="display: none;">
			<div class="modal-body">
				<center>
				<h3><p>Seleccione un Contenedor</p></h3>
				<label for="cont">Contenedor:</label>
                        <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>                    
                            <select class="form-control select2 select2-hidden-accesible" name="cont" id="cont_id">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($contenedores as $k) {
                                            echo '<option  value="'.$k->cont_id.'">'.$k->codigo.'</option>';
                                        }
                                    ?>
                            </select>
                        </div>			
				</center>
				<input type="text" style="display:none" id="tica_id">
				<input type="text" style="display:none" id="tica_valor">
				<input type="text" style="display:none" id="soco_id">
				
			</div>
			<div class="modal-footer">
				<center>
				<button type="button" class="btn btn-primary" onclick="OK()">OK</button>
				</center>
			</div>
		</div>
	</div>
</div>

<script>

//deshabilita los botones originales de la notificacion estandar						
$(document).ready(function(){
			$('.btnNotifEstandar').hide();
			dataCont = JSON.parse($("#divdato").attr("dato-infoContenedores"));
			dataEnt = JSON.parse($("#divdato").attr("dato-ContEntregados"));
			console.table(dataCont);
			console.table(dataEnt);
			var cantCont = dataCont.length;
			var aux = 0;
			for(var i=0; i<dataCont.length; i++)
			{
				if(dataEnt != null)
				{
					for(var j=0; j<dataEnt.length; j++)
					{
						if(dataCont[i].valor == dataEnt[j].valor)
						{
							if(dataCont[i].cantidad_acordada == dataEnt[j].cant_entregados)
							{
								aux = aux + 1;
							}
						}
					}
				}
				 
			}
			
			if(aux == cantCont)
			{
				$("#botonCerrar").removeAttr("style");
				$(".camion").attr("style","display:none;");
				$(".fecEntrega").attr("style","display:none;");
			}
			
	});	

$(".btnEntregar").on("click", function(e) {

	datajson = JSON.parse($(this).parents("tr").attr("data-json"));
	ided = $(this).parents("tr").attr("ide");
	$("#idSelCantPend").val(ided); // aca voy a guardar el id 
	var cantPend = document.getElementById(ided).innerHTML 
	if (cantPend != 0)
	{
		console.table(cantPend);
		console.table(datajson);
		$("#tica_id").val(datajson.tica_id);
		$("#tica_valor").val(datajson.valor);
		$("#soco_id").val(datajson.soco_id);
		$("#entrega").removeAttr("style");
		$("#tbl_contenedoresagregados").removeAttr("style");
		$("#modalEntregar").modal('show');
		
	}else{
		alert("ATENCION!!! ya entrogo todos los contenedores");
	}
});

// en modal contenedores guarda datos en tabla temporal y demas operaciones para enviar
function OK()
{
	$("#modalEntregar").modal('hide');
	var camion = $("#camion_id").val(); 
	if( camion == null)
	{
		
		alert("ATENCION! debe seleccionar un Camion");

	}else{

		var entregaCont = new FormData();
		entregaCont = formToObject(entregaCont);
		entregaCont.tica_id = $("#tica_id").val();
		entregaCont.valor = $("#tica_valor").val();
		entregaCont.camion = $("#camion_id").val();
		entregaCont.cont = $("#cont_id").val();
		var dominio = $("#camion_id option:selected" ).text();
		var table = $('#tbl_contenedoresagregados').DataTable();
				var row =  `<tr data-json='${JSON.stringify(entregaCont)}'> 
							<td style='display:none;'>${entregaCont.tica_id}</td>
							<td>${entregaCont.valor}</td>
							<td style='display:none;'>${entregaCont.camion}</td>
							<td>${dominio}</td> 
							<td>${entregaCont.cont}</td>            
					</tr>`;
			table.row.add($(row)).draw();  
			var sel = document.getElementById("cont_id");
  			sel.remove(sel.selectedIndex);
		var ide = $(idSelCantPend).val();
		var cantPend = document.getElementById(ide).innerHTML
		cantPend = cantPend - 1;
		document.getElementById(ided).innerHTML = cantPend;
	}
	
}

function recargaBandejaEntrada()
{
  linkTo('<?php echo BPM ?>Proceso/index');
}

function RealizarEntrega()
{
			wo();
			var contEnt = new FormData();
			contEnt = formToObject(contEnt);
			var datos_contenedores_entregados= [];
			var cont_entregados_listo = [];		
					var rows = $('#tbl_contenedoresagregados tbody tr');	
						
					rows.each(function(i,e) { 
						datos_contenedores_entregados.push(getJson(e));	
					});
					console.table(datos_contenedores_entregados);
					if(datos_contenedores_entregados == "")
					{
						alert("ATENCION Se han entregado todos los contenedores debe Finalizar Tarea haciendo click en Hecho");

					}else{

						for(var j=0; j<datos_contenedores_entregados.length; j++){
						//llenarlo afuera del each y aca solo armar el arreglo con el push(getJson(e)) por lo tanto usar dos arreglos uno dentro dep each para obtener bien los datos de la tabla y luego afuera recorrerlo ir armando el modelos e ir insertando en otro arreglo que es el que se enviara como final 
						contEnt.fec_entrega = $("#fec_entrega").val();
						contEnt.cont_id = datos_contenedores_entregados[j].cont;
						contEnt.soco_id = $("#soco_id").val();
						contEnt.tica_id = datos_contenedores_entregados[j].tica_id;
						contEnt.equi_id_entrega = datos_contenedores_entregados[j].camion;
						cont_entregados_listo.push(contEnt);
						var contEnt = new FormData();
						contEnt = formToObject(contEnt);
						}
						console.table(cont_entregados_listo);
						if( $("#fec_entrega").val()=="")
						{
							alert("ATENCION! no selecciono fecha de entrega...");
						}else{

							$.ajax({
							type: "POST",
							data: {cont_entregados_listo},							
							url: "general/transporte-bpm/EntregaContenedor/GuardaContEntregado",
							success: function(respuesta) {
								wc();
								if(respuesta == 1){
									alertify.success("Contenedoes entregados exitosamente...");
									recargaBandejaEntrada();
								}else{
									alertify.error('Error en completar la Tarea...');
								}
					

							},
							complete: function(){
								wc();
							}
						});
						}
						
					}
	
}

function CerrarTarea()
{
	var opcion = 'acepta';
	var taskId = $('#taskId').val();
	var elegido = {opcion: opcion};	
	$.ajax({
				type: 'POST',
				data:{ elegido },
				url: 'traz-comp-bpm/Proceso/cerrarTarea/' + taskId,
				success: function(result) {

									wc();
									if(result == '{"status":true,"msj":"OK","data":false}'){
										alertify.success("Tarea completada exitosamente...");
										recargaBandejaEntrada();
									}else{
										alertify.error('Error en completar la Tarea...');
										
									}
								},
				error: function(result){
									wc();
							 },
				complete: function(){
									wc();

									}
		});
}

</script>
