<h4>Analiza Solicitud de Contenedores</h4>

<!--_____________ Formulario informacion _____________-->
<form class="formNombre1" id="IDnombre">  
    <div class="col-md-12">

        <div class="col-md-6">
            <div class="form-group">
                <label for="generador" name="">Generador:</label>
                <input type="text" class="form-control" id="generador" value="<?php echo $infoSolicitud->razon_social; ?>">
            </div>
        </div>
        <!--_____________________________________________-->
				
        <div class="col-md-6">
            <div class="form-group">
                <label for="pedido" name=""> Nº Pedido:</label>
                <input type="text" class="form-control" id="pedido" value="<?php echo $infoSolicitud->soco_id; ?>">
            </div>
        </div>
        <!--_____________________________________________-->

        <div class="col-md-6">
          <div class="form-group">
              <label for="domicilio" name="">Direccion:</label>
              <input type="text" class="form-control" id="domicilio" value="<?php echo $infoSolicitud->domicilio; ?>">
          </div>
        </div>
        <!--_____________________________________________-->

        <div class="col-md-6">
            <div class="form-group">
                <label for="fec_alta" name="">Fecha Retiro:</label>
                <input type="text" class="form-control" id="fec_alta" value="<?php echo $infoSolicitud->fec_alta; ?>">
            </div>
        </div>
      <!--_____________________________________________-->
        
    </div>
</form>
<!--_____________ fin forulario _____________-->

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
<!--_________________SEPARADOR_________________-->

<!--_____________ Tabla info soliccitaodos _____________-->
<div class="box-body table-scroll">		
			<table id="tbl_contenedores" class="table table-bordered table-striped">
				<thead class="thead-dark" bgcolor="#eeeeee">				
						<tr>
								<th>Tipo Residuo</th>
								<th>Cantidad Solicitada</th>
								<th>Cantidad Propuesta</th>                    
						</tr>
				</thead>
				<tbody>
						<?php
							if($infoContenedores)
							{
								foreach($infoContenedores as $fila)
								{
									echo "<tr data-json='".json_encode($fila)."'>";
									//echo "<tr data-json= >";
										echo "<td>".$fila->valor."</td>";
										echo "<td>".$fila->cantidad."</td>";										
										echo "<td> <input id='' style='border:none;' placeholder='Ingrese cantidad'> </td>";
									echo '</tr>';
								}
							}
						?>
						<!-- <tr>
								<td>Trident</td>
								<td>Internet Explorer 4.0</td>
								<td>Win 95+</td>
						</tr>
						<tr>
								<td>Trident</td>
								<td>Internet Explorer 5.0</td>
								<td>Win 95+</td>								
						</tr>
						<tr>
								<td>Trident</td>
								<td>Internet Explorer 5.5</td>
								<td>Win 95+</td>							
						</tr> -->
				</tbody>
		</table>
</div>
<!--_____________ Fin taba _____________-->

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"></div>
<!--_________________SEPARADOR_________________-->


<!--_____________ motivo de rechazo _____________-->
<div class="col-md-12 col-sm-12 col-xs-12">
	<!--_____________ Descripcion _____________-->
		<div class="form-group">															
			<label for="descripcion_edit_punto" class="col-sm-4 control-label">Motivo rechazo:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control habilitar" name="descripcion" id="descripcion_edit_punto"> 
			</div>	
		</div>
	<!--__________________________-->
</div>

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
<!--_________________SEPARADOR_________________-->




<script>


	function juntar(){
		// tabla = $('#tbl_contenedores').DataTable();
		// var data = tabla.row();

		// data.each(function(i,e) { 
			
		// 	var valor= $(this).find("td").eq(1).html();
		// 		console.log('valor: ' + valor);
		// 		var cantidad = $(this).find("td").eq(2).text();
		// 		console.log('valor: ' + cantidad);
		
		// //console.info(rows);
			
		// })


		// console.table(tabla);

		var rows = $('#tbl_contenedores tbody tr');				
		rows.each(function(i,e) {  
				//ptos_criticos_edit.push(getJson(e));
				var valor= $(this).find("td").eq(1).html();
				console.log('valor: ' + valor);
				var cantidad= $(this).find("td").eq(2).text();
				console.log('valor: ' + cantidad);
		
		//console.info(rows);
			
		});
		console.log('aca tabla para abajo: ');
		console.table(tabla);

	}


	// Datatable	
	DataTable($('#tbl_contenedores'));	
</script>




<?php

		// var_dump($infoSolicitud);

		// var_dump($infoContenedores);

?>



