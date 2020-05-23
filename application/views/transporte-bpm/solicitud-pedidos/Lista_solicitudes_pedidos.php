                    <!--__________________HEADER TABLA___________________________-->
                    <table id="tabla_solicitudes" class="table table-bordered table-striped">
                        <thead class="thead-dark" bgcolor="#eeeeee">

                            <th>Acciones</th>
                            <th>Estado</th>
                            <th>observaciones</th>
                            <th>fec_alta</th>
                       
                       
                            

                        </thead>

                        <!--__________________BODY TABLA___________________________-->

                    <tbody>
                    <?php
                    if($solicitudes)
                    {
                        foreach($solicitudes as $fila)
                        {
                        echo "<tr data-json='".json_encode($fila)."'>";
                        echo    '<td>';
                        echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                <button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp'; 
 
                            
                        echo   '</td>';
                        echo    '<td>'.$fila->estado.'</td>';
                        echo    '<td>'.$fila->observaciones.'</td>';
                        echo    '<td>'.$fila->fec_alta.'</td>';
                        echo '</tr>';
                    }
                    }
                    ?>
                    </tbody>
                        </table>

                    <!--__________________FIN TABLA___________________________-->
                    <!---///////--- MODAL EDICION E INFORMACION ---///////---> 
	<div class="modal fade bs-example-modal-lg" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header bg-blue">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
						</button>
						<h5 class="modal-title" id="exampleModalLabel">Solicitud de Pedido de Contenedor</h5>
				</div>

				<div class="modal-body ">
					<div class="form-horizontal">
						<form class="frm_circuito_edit" id="frm_circuito_edit">
							<!--_____________ ID CIRCUITO, ID ZONA (HIDDEN) _____________-->
								<div class="hidden">							
									<div class="col-sm-8">
										<input type="text" class="form-control habilitar" name="zona_id" id="zona_id_edit">	
									</div>
								</div>
								<div class="hidden">							
									<div class="col-sm-8">
										<input type="text" class="form-control habilitar" name="circ_id" id="circ_id_edit">	
									</div>
								</div>
							<!--__________________________-->
							<div class="col-sm-6">
								<!--_____________ CODIGO _____________-->
									<div class="form-group">																
										<label for="estado" class="col-sm-4 control-label">Estado:</label>
										<div class="col-sm-8">
											<input type="text" class="form-control habilitar" name="estado" id="estado">	
										</div>
									</div> 
							
					
							
							
							</div>

							<div class="col-sm-6">
										
								<!--_____________ DESCRIPCION _____________-->                 
									<div class="form-group">
											<label for="observaciones" class="col-sm-4 control-label">Observaciones:</label>
											<div class="col-sm-8">
												<input type="text" class="form-control habilitar" name="observaciones" id="obs"> 
											</div>
									</div>
								<!--__________________________-->	
								
								

							</div>
						</form>	
						
							
					</div>
	                    <!--_________________SEPARADOR_________________-->
                        <div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
						<!--_________________SEPARADOR_________________-->
					<!--_____________ SECCION P. CRITICOS _____________-->	
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box box-primary">
											<div class="box-header with-border">
													<h4> Contenedores Solicitados </h4>
											</div>
									</div>
							</div>
						
						<div class="form-horizontal" id="form_editar_pto_critico">	
								<form class="formPedidosedit" id="formPedidosedit">
										<!--_____________ columna 1 _____________-->
										<div class="col-sm-6">
											<!--_____________ Nombre _____________-->
												<div class="form-group">															
                                                            <label for="transportista" class="form-label">transportista:</label>
                                                            <div class="input-group date">
                                                                <div class="input-group-addon">
                                                                    <i class="glyphicon glyphicon-check"></i>
                                                                </div>
                                                                <select class="form-control select2 select2-hidden-accesible" id="transportista" name="transportista"
                                                                    required onchange="obtenertipocarga()">
                               
                                                                    <?php
                                                                        foreach ($transportista as $i) {
                                                                        echo '<option value="'.$i->tran_id.'">'.$i->razon_social.'</option>';
                                                            
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
												</div>
											<!--__________________________-->
											
											<!--_____________ Latitud _____________-->
											<div class="form-group">															
                                                    <label for="tipores" class="form-label">Tipo residuo:</label>
                                                    <div class="input-group date">
                                                                <div class="input-group-addon">
                                                                    <i class="glyphicon glyphicon-check"></i>
                                                                </div>
                                                                <select class="form-control select2 select2-hidden-accesible" id="tipres" name="tipo_residuo" required>
                                                                    <option value="" disabled selected>-Seleccione opcion-</option>
																	
                                                
                                                                </select>
                                                    </div>                    
											</div>
										<!--__________________________-->
										</div>	
										<!--__________________________-->
                                        
										<!--_____________ columna 2 _____________-->
										<div class="col-sm-6">
											<!--_____________ Descripcion _____________-->
												<div class="form-group">															
                                                <label for="Dpto" >Cantidad de contenedor:</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="glyphicon glyphicon-check"></i>
                                                        </div>
                                                            <input type="number" class="form-control"   name="cantidad" id="Tipoderesiduos">
                                                    </div>          
												</div>
											<!--__________________________-->

										</div>		
										<!--__________________________-->
                                                                        <br>
										<!--_____________ Btn agregar _____________-->	
										<div class="col-md-12">
											<button type="submit" class="btn btn-default pull-right"id="btn_agregar_edit" onclick="Add_pedido()"">AGREGAR</button>
										</div>
										<!--__________________________-->
								</form> 
						</div>

						<!--_________________SEPARADOR_________________-->
							<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
						<!--_________________SEPARADOR_________________-->

						<!--_____________ TABLA EDITAR PUNTOS CRITICOS _____________-->							
							<div class="col-md-12">                                          
								
                            <div class="box " id="pedidos">
									<div class="box-body table-responsive">											
											<table class="table table-striped" id="tabla_contenedoresedit">
													<thead class="thead-dark" bgcolor="#eeeeee">
															<th>Tipo de Rsiduo</th>
															<th>Cantidad Solicitada</th>
													</thead>	
													<tbody>	</tbody>
											</table>										
									</div>
							</div>							      
																											
							</div> 
						<!--_____________ FIN TABLA EDITAR PUNTOS CRITICOS _____________-->
									
					</div>
					<!--____________ FIN SECCION P. CRITICOS ______________-->


				</div>			

				<div class="modal-footer">
					<div class="form-group text-right">
							<button type="submit" class="btn btn-primary" data-dismiss="modal" id="btnsave_edit" onclick="Guardar_pedidoContenedor()">Guardar</button>
							<button type="submit" class="btn btn-default" id="" data-dismiss="modal">Cerrar</button>
					</div>
				</div>

			</div>
		</div>
	</div>
<!---///////--- FIN MODAL EDICION E INFORMACION ---///////--->


  <!---///////--- MODAL EDICION E INFORMACION ---///////---> 
  <div class="modal fade bs-example-modal-lg" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header bg-blue">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
						</button>
						<h5 class="modal-title" id="exampleModalLabel">Informacion Solicitud de Pedido de Contenedor</h5>
				</div>

				<div class="modal-body ">
					<div class="form-horizontal">
						<form class="frm_circuito_edit" id="frm_circuito_edit">
							<!--_____________ ID CIRCUITO, ID ZONA (HIDDEN) _____________-->
								<div class="hidden">							
									<div class="col-sm-8">
										<input type="text" class="form-control habilitar" name="zona_id" id="zona_id_edit">	
									</div>
								</div>
								<div class="hidden">							
									<div class="col-sm-8">
										<input type="text" class="form-control habilitar" name="circ_id" id="circ_id_edit">	
									</div>
								</div>
							<!--__________________________-->
							<div class="col-sm-6">
								<!--_____________ CODIGO _____________-->
									<div class="form-group">																
										<label for="estado" class="col-sm-4 control-label">Estado:</label>
										<div class="col-sm-8">
											<input type="text" class="form-control habilitar" name="estado" id="estadoinfo" readonly="readonly">	
										</div>
									</div> 
							
					
							
							
							</div>

							<div class="col-sm-6">
										
								<!--_____________ DESCRIPCION _____________-->                 
									<div class="form-group">
											<label for="observaciones" class="col-sm-4 control-label">Observaciones:</label>
											<div class="col-sm-8">
												<input type="text" class="form-control habilitar" name="observaciones" id="obsinfo" readonly="readonly"> 
											</div>
									</div>
								<!--__________________________-->	
								
								

							</div>
						</form>	
						
							
					</div>
	                    <!--_________________SEPARADOR_________________-->
                        <div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
						<!--_________________SEPARADOR_________________-->
					<!--_____________ SECCION P. CRITICOS _____________-->	
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box box-primary">
											<div class="box-header with-border">
													<h4> Contenedores Solicitados </h4>
											</div>
									</div>
							</div>
						
						

						<!--_________________SEPARADOR_________________-->
							<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
						<!--_________________SEPARADOR_________________-->

						<!--_____________ TABLA EDITAR PUNTOS CRITICOS _____________-->							
							<div class="col-md-12">                                          
								
                            <div class="box " id="pedidos">
									<div class="box-body table-responsive">											
											<table class="table table-striped" id="tabla_contenedoresInfo">
													<thead class="thead-dark" bgcolor="#eeeeee">
															<th>Tipo de Rsiduo</th>
															<th>Cantidad Solicitada</th>
													</thead>	
													<tbody>	</tbody>
											</table>										
									</div>
							</div>							      
																											
							</div> 
						<!--_____________ FIN TABLA EDITAR PUNTOS CRITICOS _____________-->
									
					</div>
					<!--____________ FIN SECCION P. CRITICOS ______________-->


				</div>			

				<div class="modal-footer">
					<div class="form-group text-right">
							<button type="submit" class="btn btn-default" id="" data-dismiss="modal">Cerrar</button>
					</div>
				</div>

			</div>
		</div>
	</div>
<!---///////--- FIN MODAL VER INFO---///////--->


                    
<script>
function agregartipores(){
  
  $.ajax({
      type: "POST",
      data: {},
      url: "general/transporte-bpm/Solicitud_Pedido/obtenerTipoResTodos",
      success: function($r){
          var res = JSON.parse($r);
          console.table(res);
          if(res){

              $("#tipres").find('option').remove();
              for(var i=0; i <= res.length-1; i++){
              $("#tipres").append("<option value= '"+res[i].tabl_id+"' >" + res[i].valor + "</option>");
              }


          }
          else{
              alertify.error("error al traer tipo de carga");
          }

      },

  });
 

  
}

function Add_pedido() {
var data = new FormData($('#formPedidosedit')[0]);
data = formToObject(data);
var table = $('#tabla_contenedoresedit').DataTable();
var row =  `<tr data-json='${JSON.stringify(data)}'> 
            <td>${data.tipo_residuo}</td>
            <td>${data.cantidad}</td>          
    </tr>`;
table.row.add($(row)).draw();  
$('#formPedidosedit')[0].reset();          
}

$(".btnEditar").click(function(e){
var data = JSON.parse($(this).parents("tr").attr("data-json"));  
$('#tabla_contenedoresedit').find('td').remove();
//para seguimiento despues borrar
console.table(data);
console.table(data.contSolicitados);
$("#estado").val(data.estado);
$("#obs").val(data.observaciones);
agregartipores();


});

$(".btnInfo").click(function(e){
var data = JSON.parse($(this).parents("tr").attr("data-json"));  
$('#tabla_contenedoresInfo').find('td').remove();
$("#estadoinfo").val(data.estado);
$("#obsinfo").val(data.observaciones);



});



</script>

 <script>
      
    DataTable($('#tabla_solicitudes'));

      
 </script>     