<h4>Notificación de no aceptación de pedido</h4>

<!--_________________SEPARADOR_________________-->
<!-- <div class="col-md-12 col-sm-12 col-xs-12"><br></div> -->
<!--_________________SEPARADOR_________________-->

<!--_____________ motivo de rechazo _____________-->
<div class="col-md-12 col-sm-12 col-xs-12">
	<!--_____________ Descripcion _____________-->
		<div class="form-group">
			<!-- <label for="motivo" class="col-sm-4 control-label">Motivo rechazo:</label> -->
			<label for="motivo" class="disabledTextInput">Motivo rechazo:</label>
			<!-- <div class="col-sm-8">
				<input type="text" class="form-control habilitar" name="descripcion" id="motivo" placeholder="Si rechaza la solicitud, ingrese motivo por favor...">
			</div> -->
			<textarea class="form-control" id="motivo" rows="3">
        <?php echo $motivo_rechazo ?>
      </textarea>
		</div>
	<!--__________________________-->
</div>

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
<!--_________________SEPARADOR_________________-->


<script>

	function recargaBandejaEntrada()
	{
		linkTo('<?php echo BPM ?>Proceso/index');
	}
	// Datatable
	DataTable($('#tbl_contenedores'));	
</script>



