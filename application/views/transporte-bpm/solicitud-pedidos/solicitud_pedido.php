<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
			<div class="box-header with-border">
					<h4>Solicitud de Pedido de Contenedor</h4>
			</div>
			<div class="box-body">
					<div class="row">
							<div class="col-md-2 col-lg-1 col-xs-12">
									<button type="button" id="botonAgregar" class="btn btn-primary" aria-label="Left Align">
											Agregar
									</button><br>
							</div>
							<div class="col-md-10 col-lg-11 col-xs-12"></div>
					</div>
			</div>
	</div>
<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<!---//////////////////////////////////////--- BOX 1 ---///////////////////////////////////////////////////////----->
	<div class="box box-primary animated bounceInDown" id="boxDatos" hidden>
			<div class="box-header with-border">
					<div class="box-tittle">
							<h5>Informacion</h5>
					</div>
					<div class="box-tools pull-right border ">
							<button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
									data-toggle="tooltip" title="" data-original-title="Remove">
									<i class="fa fa-times"></i>
							</button>
					</div>
			</div>
			<!--_____________________________________________-->

			<div class="box-body">

					<form class="formCircuitos" id="formCircuitos">
							<!--_____________________________________________-->
							<!--NRO-->
							<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
											   <label for="Nro" class="form-label">Nro:</label>
											<div class="input-group date">
													<div class="input-group-addon"> <i class="fa fa-"></i></div>
													<input type="text" name="nro" id="Nro" value="<?php echo rand(1,100);?>" class="form-control"readonly>
											</div>
									</div>
							</div>
							<!--_____________________________________________-->
							<!--FECHA RETIRO-->
							<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
                                        <label for="fecha" class="form-label">Fecha de Retiro:</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" class="form-control"   name="fecha" id="Fecha">
                                            </div>
									</div>
							</div>
							<!--_____________________________________________-->
							<!--TRANSPORTISTA-->
							<div class="col-md-6 col-sm-6 col-xs-12">
											    <div class="form-group">

													<label for="transportista" class="form-label">transportista:</label>
                                                            <div class="input-group date">
                                                                <div class="input-group-addon">
                                                                    <i class="glyphicon glyphicon-check"></i>
                                                                </div>
                                                                <select class="form-control select2 select2-hidden-accesible" id="transportista_id" name="transportista"
                                                                    required onchange="obtenertipocarga()">
                               
                                                                    <?php
                                                                        foreach ($transportista as $i) {
                                                                        echo '<option value="'.$i->tran_id.'">'.$i->razon_social.'</option>';
                                                            
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
											    </div>
									</div>
									<!--_____________________________________________-->

							<!--_________________SEPARADOR_________________-->
							<div class="col-md-12">
									<hr>
							</div>
						
					</form>		
					
							
				<!--_____________________________________________-->					
					
					<!--_____________ SEPARADOR _____________-->
					<div class="col-md-12 col-sm-12 col-xs-12"> <br> <br></div>
					<!--__________________________-->

					<!---//////////////////////////////////////--- REGISTRAR PEDIDOS ---///////////////////////////////////////////////////////----->

					<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box box-primary">
											<div class="box-header with-border">
													<h4>Registrar Pedido de contendor</h4>
											</div>
									</div>
							</div>
					</div>

					<div class="col-md-12 col-sm-12 col-xs-12">

							<form class="formPedidos" id="formPedidos">
					
									<!--TRANSPORTISTA-->
									<!-- <div class="col-md-5 col-sm-5 col-xs-12">
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
									</div> -->
									<!--_____________________________________________-->
									
									<!--TIPO RESIDUOS-->
									<div class="col-md-5 col-sm-5 col-xs-12">
											<div class="form-group">
                                                    <label for="tipores" class="form-label">Tipo residuo:</label>
                                                    <div class="input-group date">
                                                                <div class="input-group-addon">
                                                                    <i class="glyphicon glyphicon-check"></i>
                                                                </div>
                                                                <select class="form-control select2 select2-hidden-accesible" id="tipores" name="tipo_residuo" required>
                                                                    <option value="" disabled selected>-Seleccione opcion-</option>
																	
                                                
                                                                </select>
                                                    </div>                    
											</div>
									</div>
									<!--_____________________________________________-->
									
									<!--CANTIDAD-->
									<div class="col-md-5 col-sm-5 col-xs-12">
											<div class="form-group">
                                                <label for="Dpto" >Cantidad de contenedor:</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="glyphicon glyphicon-check"></i>
                                                        </div>
                                                            <input type="number" class="form-control cant"   name="cantidad" id="Tipo de residuos">
                                                    </div>          
											</div>
									</div>
									<!--_____________________________________________-->
									
									
									

									
									

							</form>

							<!--_________________SEPARADOR_________________-->
							<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
							<!--_________________SEPARADOR_________________-->

							<!--_____________ Boton agregar _____________-->	
							<div class="col-md-12">
									<button type="submit" class="btn btn-default pull-right" onclick="Agregar_pedido()">AGREGAR</button>
							</div>
							<!--__________________________-->

							<!--_________________SEPARADOR_________________-->
							<div class="col-md-12 col-sm-12 col-xs-12"> <br></div>
							<!--_________________SEPARADOR_________________-->


					</div>

					<!--_____________ SEPARADOR _____________-->
					<div class="col-md-12 col-sm-12 col-xs-12"> <br></div>
					<!--_____________ SEPARADOR _____________-->

					<!--_____________ Tabla Punto Critico _____________-->
					<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="box " id="pedidos" style="display:none">
									<div class="box-body table-responsive">											
											<table class="table table-striped" id="tabla_contenedores">
													<thead class="thead-dark" bgcolor="#eeeeee">
															<th>Cantidad Solicitada</th>
															<th>otro</th>
															<th>usuario_app</th>
															<th>tica_id</th>
															
															
															
													</thead>	
													<tbody>	</tbody>
											</table>										
									</div>
							</div>
					</div>
					<!--_____________________________________________-->

					<!--_________________SEPARADOR_________________-->
					<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
					<!--_________________SEPARADOR_________________-->
                    <div class="col-md-5 col-sm-5 col-xs-12">
							<div class="form-group">
                                    <label for="observaciones" >Observaciones:</label>
                                        <div class="input-group date">
                                            <textarea name="observaciones" id="observaciones" cols="30" rows="2"></textarea>
                                         </div>   
							</div>
					</div>                                                  
                                                                        
					<!--_________________ GUARDAR_________________-->
					<div class="col-md-12">
							<button type="submit" class="btn btn-primary pull-right" onclick="Guardar_pedidoContenedor()">GUARDAR</button>
					</div>
					<!--__________________________________-->

			</div>


	</div>
<!---//////////////////////////////////////--- FIN BOX 1---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////---BOX 2 DATATBLE ---///////////////////////////////////////////////////////----->
<div class="box box-primary">
		<div class="box-body">
				<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
						
					<div class="row">
								<div class="col-sm-6"></div>
								<div class="col-sm-6"></div>
						</div>

						<div class="row">
								<div class="col-sm-12 table-scroll" id="cargar_tabla">

								</div>
						</div>
						
				</div>
		</div>
	</div>
<!---//////////////////////////////////////--- FIN BOX 2 DATATABLE---///////////////////////////////////////////////////////----->

  
 <!---//////////////////////////////////////--- SCRIPTS---///////////////////////////////////////////////////////----->

 <!--_____________________________________________________________-->
<!-- script modal -->

<script>

$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/transporte-bpm/Solicitud_Pedido/Listar_SolicitudesPedido");

// FUNCION PARA OBTENER TIPOS DE CARGA DEPENDIENDO DEL TRANSPORTISARA QUE SE SELECCIONO
// function obtenertipocarga(){
//     var id_transportista = $("#transportista").val();
//     console.table(id_transportista);
//     $.ajax({
//         type: "POST",
//         data: {id_transportista},
//         url: "general/transporte-bpm/Solicitud_Pedido/obtenerTipoRes",
//         success: function($r){
//             var res = JSON.parse($r);
//             console.table(res);
//             if(res){

//                 $("#tipores").find('option').remove();
//                 for(var i=0; i <= res.length-1; i++){
//                 $("#tipores").append("<option value= '"+res[i].tica_id+"' >" + res[i].valor + "</option>");
//                 }


//             }
//             else{
//                 alertify.error("error al traer tipo de carga");
//             }

//         },

//     });

    
// }

$("#botonAgregar").click(function(e){
    var id_transportista = $("#transportista").val();
    console.table(id_transportista);
    $.ajax({
        type: "POST",
        data: {},
        url: "general/transporte-bpm/Solicitud_Pedido/obtenerTipoResTodos",
        success: function($r){
            var res = JSON.parse($r);
            console.table(res);
            if(res){

                $("#tipores").find('option').remove();
                for(var i=0; i <= res.length-1; i++){
                $("#tipores").append("<option value= '"+res[i].tabl_id+"' >" + res[i].valor + "</option>");
                }


            }
            else{
                alertify.error("error al traer tipo de carga");
            }

        },

    });

    
});


//agrega pedido de contedor a la tabla para guardar  
function Agregar_pedido() {
console.table($("#tipores").val());
$('#pedidos').show();
var data = new FormData();
data = formToObject(data);
data.usuario_app = "hugoDS";
data.otro ="";
data.tica_id = $("#tipores").val();
data.cantidad = $(".cant").val();
var table = $('#tabla_contenedores').DataTable();
var row =  `<tr data-json='${JSON.stringify(data)}'> 
				<td>${data.cantidad}</td>
				<td>${data.otro}</td>  
				<td>${data.usuario_app}</td>
				<td>${data.tica_id}</td>
            
			
			         
    </tr>`;
table.row.add($(row)).draw();  
$('#formPedidos')[0].reset();          
}



</script>


<script>
// funcion para obtener sotrid, no funciona por que hay dos servicios con el mismo nombre ej: /solicitantesTransporte/hugoDS y  /solicitantesTransporte/{soco_id}
function obtenersotrid(){
	var user = "hugoDS"; // harkodeado cuando userNick este funcionando bien comentar en el controller la funcion que llama 
	var res;
	$.ajax({
		type: "POST",
		data: {user},
		url: "general/transporte-bpm/Solicitud_Pedido/obtenersolitransp",
		success: function(r) {
								debugger;
								console.log(r);
								if (r != "error") {
									var data = JSON.parse(r);
									console.table(data);
									res = data; 
										
										


								} else {
										console.log(r);
										alertify.error("error");
								}
						}
	});
	return res; 
}
function Guardar_pedidoContenedor(){
	debugger;
	var sotrid = obtenersotrid();
	var datos = new FormData();
    datos = formToObject(datos);
	datos.observaciones = $("#observaciones").val();
	datos.usuario_app = "HugoDS";
    datos.sotr_id = 38;
  	datos.tran_id = $("#transportista_id").val();
    // recorre tabla guardando los contenedores pedidos en array
		var datos_contenedores = [];		
		var rows = $('#tabla_contenedores tbody tr');				
		rows.each(function(i,e) {  
				datos_contenedores.push(getJson(e));
				// datos_contenedores.push("usuarioAp:");
				// datos_contenedores.push("otro:");
		});	
	datos.contenedores = datos_contenedores;
		
	$.ajax({
						type: "POST",
						data: {datos},							
						url: "general/transporte-bpm/Solicitud_Pedido/registrarSolicitud",
						success: function(r) {
								console.log(r);
								if (r != "error") {
									var data = JSON.parse(r);
									console.table(data);

										
										alertify.success("Agregado con exito");

										
										$("#formPedidos")[0].reset();

										$("#boxDatos").hide(500);
										$("#botonAgregar").removeAttr("disabled");

								} else {
										console.log(r);
										alertify.error("error al agregar");
								}
						}
				});	


}


</script>



<!---/////////////////////////--- FIN BOOTSRAP VALIDATOR---/////////////////////////----->


<!--_____________________________________________________________-->
<!-- script que muestra box de datos al dar click en boton agregar -->
            

<script>
    $("#botonAgregar").on("click", function() {
    $("#botonAgregar").attr("disabled", "");
    $("#boxDatos").focus();
    $("#boxDatos").show();
});   


$("#btnclose").on("click", function() {
    $("#boxDatos").hide(500);
    $("#botonAgregar").removeAttr("disabled");
    $("#formDatos")[0].reset();
    $('#selecmov').find('option').remove();

});

</script>

 
 <!--_____________________________________________________________-->
 <!-- script Datatables -->
 <script>

    DataTable($('#tabla_contenedores'));

   

    
    

</script>



 
