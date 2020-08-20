<!--- HEADER --->
	<div class="box box-primary animated fadeInLeft">
			<div class="box-header with-border">
					<h4>Registrar Transportista</h4>
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
<!--- FIN HEADER --->

<!--- BOX 1 --->
	<div class="box box-primary animated bounceInDown" id="boxDatos" hidden>
    <div class="box-header with-border">
        <div class="box-tittle">
        <h5>Informacion</h5>  
        </div>
        <div class="box-tools pull-right">
            <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                data-toggle="tooltip" title="" data-original-title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>

    <!--_____________________________________________-->

    <div class="box-body">
        <form class="formTransportistas" id="formTransportistas">
            <div class="col-md-6 col-sm-6 col-xs-12">
							<!--Nombre / Razon social-->
								<div class="form-group">
										<label for="Nombre/Razon social" >Nombre / Razon social:</label>
										<div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
										<input type="text" class="form-control" name="razon_social" id="razon_social">
										</div>
								</div>
							<!--_____________________________________________-->

							<!--Descripcion-->
								<div class="form-group">
										<label for="Descripcion" >Descripcion:</label>
										<div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
										<input type="text" class="form-control"  name="descripcion" id="descripcion">
										</div>
								</div>
							<!--_____________________________________________-->

							<!--Direccion-->
								<div class="form-group">
										<label for="Direccion">Direccion:</label>
										<div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
										<input type="text" class="form-control"   name="direccion" id="direccion">
										</div>
								</div>
							<!--_____________________________________________-->

							<!--Telefono-->
								<div class="form-group">
										<label for="Telefono" >Telefono:</label>
										<div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
										<input type="text" class="form-control"  name="telefono" id="telefono">
										</div>
								</div>
							<!--_____________________________________________-->

							<!--contacto-->
								<div class="form-group">
										<label for="Contacto" >Contacto:</label>
										<div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
										<input type="text" class="form-control" name="contacto" id="contacto">
										</div>
								</div>
							<!--_____________________________________________-->

							<!--cuit-->
								<div class="form-group">
										<label for="Contacto" >Cuit:</label>
										<div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
										<input type="text" class="form-control" name="cuit" id="cuit" size="11">

										</div>
								</div>
							<!--_____________________________________________-->
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">             
                <!--Resolucion-->
									<div class="form-group">
											<label for="Resolucion" >Resolucion:</label>
											<div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
											<input type="text" class="form-control"  name="resolucion" id="resolucion">
											</div>
									</div>
                <!--_____________________________________________-->

                <!--Registro-->
									<div class="form-group">
											<label for="Registro" >Registro:</label>
											<div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
											<input type="text" class="form-control" name="registro" id="registro">
											</div>
									</div>
								<!--_____________________________________________-->								

								<!--Tipo de residuo-->							
										<div class="form-group">
												<label for="tipoResiduos">Tipos de residuo:</label>
												<div class="input-group date">
														<div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
														<select class="form-control select3" multiple="multiple"  data-placeholder="Seleccione tipo residuo"  style="width: 100%;"  id="tica_id" name="tica_edit">                            
																<?php
																		foreach ($Rsu as $i) {     
																				echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
																		}
																?>
														</select>            
												</div>
										</div>				
								<!--_____________________________________________-->

                <!--Fecha de alta-->
									<div class="form-group">
											<label for="Fechalta"class="form-label label-sm">Fecha de alta:</label>                                              
											<div class="input-group date">
													<div class="input-group-addon">
															<i class="fa fa-calendar"></i>
													</div>
													<input type="date" class="form-control pull-right"  name="fec_alta_efectiva"  id="fec_alta_efectiva">
											</div>  
									</div>
                <!--_____________________________________________-->

                <!--Fecha de baja-->
									<div class="form-group">
											<label for="Fechabaja" >Fecha de baja:</label>
											<div class="input-group date">
													<div class="input-group-addon">
															<i class="fa fa-calendar"></i>
													</div>
													<input type="date" class="form-control pull-right" name="fec_baja_efectiva" id="fec_baja_efectiva">
											</div>
									</div>
                <!--_____________________________________________-->  
            </div>          

            <div class="col-md-12 col-sm-12 col-xs-12"><hr></div>

            <!--___________________BOTON GUARDAR__________________________-->
							<br>
							<button type="submit" class="btn btn-primary pull-right" onclick="Guardar_Transportista()">Guardar</button>
							<br>
						<!--___________________FIN BOTON GUARDAR__________________________-->
        </form>
    </div>
	</div>
	</div>
<!--- FIN BOX 1 --->

<!--- BOX TABLA --->
	<div class="box box-primary">
			<div class="box-body">
					<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
							<div class="row">
									<div class="col-sm-6"></div>
									<div class="col-sm-6"></div>
							</div>   
							<!--__________________TABLA___________________________-->
							<div class="row"><div class="col-sm-12 table-scroll" id="cargar_tabla"></div>
							<!--__________________TABLA___________________________-->
        </div>
  </div>
<!--- FIN BOX TABLA --->

<!---///////--- MODAL EDITAR ---///////--->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
						<div class="modal-header bg-blue">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
								</button>
								<h5 class="modal-title titulo" id="exampleModalLabel">Editar Transportista</h5>
						</div>

						<div class="modal-body col-md-12 col-sm-12 col-xs-12">
							<!--__________________ FORMULARIO MODAL ___________________________-->
								<form method="POST" autocomplete="off" id="frm_transportista" class="registerForm">	

									<!-- Id de transportista y Usuario-->
										<div class="form-group">                                
											<input type="text" class="form-control habilitar" id="tran_id" name="tran_id" style="display:none;">
											<input type="text" class="form-control habilitar" id="usuario_app_edit" name="usuario_app" style="display:none;">
										</div>
									<!--______________________________-->

									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">

											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
												<!--Nombre/Razon social-->
														<div class="form-group">
															<label for="razon_social_edit" name="razon_social_edit">Razon social:</label>
															<input type="text" class="form-control habilitar" id="razon_social_edit" name="razon_social" size="30%">
														</div>
												<!--___________________-->
											</div>
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<!--Registro-->
														<div class="form-group">
															<label for="registro_edit" name="registro_edit">Registro:</label>
															<input type="text" class="form-control habilitar" id="registro_edit" name="registro" size="20%">
														</div>
													<!--____________________-->
											</div>

									</div>
									
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!--Direccion-->
											<div class="form-group">
												<label for="direccion_edit" name="direccion_edit">Direccion:</label>
												<input type="text" class="form-control habilitar" id="direccion_edit" name="direccion" size="40%">
											</div>
											<!--_________________-->
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!--Telefono-->
											<div class="form-group">
												<label for="telefono_edit" name="telefono_edit">Telefono:</label>
												<input type="text" class="form-control habilitar" id="telefono_edit" name="telefono" size="40%">
											</div>											
											<!--________-->
										</div>	
									</div>

									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!--Fecha de alta-->
											<div class="form-group">
												<label for="fec_alta_edit" name="fec_alta_edit" class="form-label label-sm">Fecha de alta:</label>                                              
												<div class="input-group date">
														<div class="input-group-addon">
																<i class="fa fa-calendar"></i>
														</div>
														<input type="date" class="form-control habilitar pull-right" name="fec_alta" id="fec_alta_edit">
												</div>																
											</div>											
											<!--_________-->
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!--Descripcion-->
											<div class="form-group">
												<label for="descripcion_edit" name="descripcion_edit">Descripcion:</label>
												<input type="text" class="form-control habilitar" id="descripcion_edit" name="descripcion">
											</div>													
											<!--__________-->
										</div>
									</div>	

									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!--Contacto-->
											<div class="form-group">
												<label for="contacto_edit" name="contacto_edit">Contacto:</label>
												<input type="text" class="form-control habilitar" id="contacto_edit" name="contacto" >
											</div>	
											<!--________-->
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!--Fecha baja-->
											<div class="form-group">
												<label for="fec_baja_efectiva" name="fec_baja_efectiva">Fecha de baja:</label>
												<div class="input-group date">
														<div class="input-group-addon">
																<i class="fa fa-calendar"></i>
														</div>
														<input type="date" class="form-control habilitar pull-right" name="fec_baja_efectiva" id="fec_baja_efectiva">
												</div>
											</div>														
											<!--_________-->
										</div>
									</div>	

									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!--Resolucion-->
											<div class="form-group">
												<label for="resolucion_edit" name="resolucion_edit">Resolucion:</label>
												<input type="text" class="form-control habilitar" id="resolucion_edit" name="resolucion">
											</div>
										<!--__________-->
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!-- Cuit -->
											<div class="form-group">
												<label for="cuit_edit" name="cuit_edit">Cuit:</label>
												<input type="text" class="form-control habilitar" id="cuit_edit" name="cuit">
											</div>											
											<!--______-->
										</div>
									</div>										
									
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
									
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<!-- Tipo de Residuos -->
												<div class="form-group oculta_edit">
													<label for="tica_edit">Tipos de residuo:</label>		
													<select class="form-control habilitar select4" multiple="multiple"  data-placeholder="Seleccione tipo residuo" id="tica_edit" style="width: 100%; !important" name="ticaedit">
														<?php
																		foreach ($Rsu as $i) {     
																				echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
																		}
																?>
													</select>
												</div>
												<div class="form-group oculta_info" style="display:none">
													<label for="tica_edit">Tipos de residuo:</label>		
													<select class="form-control habilitar select4" multiple="multiple" disabled  data-placeholder="Seleccione tipo residuo" id="tica_edit" style="width: 100%; !important">
														<?php
																		foreach ($Rsu as $a) {     
																				echo '<option  value="'.$a->tabl_id.'">'.$a->valor.'</option>';
																		}
																?>
													</select>
												</div>																
											<!--______-->
										</div>
									</div>
																		
								</form>
							<!--__________________ FIN FORMULARIO MODAL ___________________________-->
						</div>
						<div class="modal-footer">
								<div class="form-group text-right">
										<button type="submit" class="btn btn-primary" data-dismiss="modal" id="btnsave">Guardar</button>
										<button type="submit" class="btn btn-default" id="" data-dismiss="modal">Cerrar</button>
								</div>
						</div>
				</div>
		</div>
	</div>
<!---///////--- FIN MODAL EDITAR ---///////--->

<!---///////--- MODAL AVISO ---///////--->
	<div class="modal fade" id="modalaviso">		
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bg-blue">
					
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" >&times;</span>
					</button>
					<h5 class="modal-title" id="exampleModalLabel"> Eliminar Transportista</h5>
				</div>
				<input id="transp_delete" style="display: none;">
				<div class="modal-body">
					<center>
					<h4><p>¿ DESEA ELIMINAR EL TRANSPORTISTA ?</p></h4>
					</center>
				</div>
				<div class="modal-footer">
					<center>
					<button type="button" class="btn btn-primary" onclick="eliminar()">SI</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
					</center>
				</div>
			</div>
		</div>
	</div>
<!---///////--- FIN MODAL AVISO ---///////--->

<!--- SCRIPTS --->
<script>
	// script habilitar panel de formulario agregar 
	$(".close").on("click", function() {
		$('#tica_edit').select2('val', 'All');
                        			$('#frm_transportista').data('bootstrapValidator').resetForm();
		});

	
																		
		$("#btnview").on("click", function() {
				$("#btnadd").removeClass("active");
				$("#btnview").addClass("active");
				$("#tablamodal").show();
				$("#formadd").hide();
				$("#btnsave").hide();
		});

		$("#btnadd").on("click", function() {
				$("#btnadd").addClass("active");
				$("#btnview").removeClass("active");
				$("#formadd").show();
				$("#tablamodal").hide();
				$("#btnsave").show();
		});
	
    $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Transportista/Listar_Transportista");
		
		//guardar transportista	
    function Guardar_Transportista() {        
        var datos = new FormData($('#formTransportistas')[0]);
        datos = formToObject(datos);
        
        datos.usuario_app = "nachete"; //FIXME: - falta asignar funcion que asigne tipo usuario
        console.table(datos);
				var tipocarga = $("#tica_id").val();
      
        if ($("#formTransportistas").data('bootstrapValidator').isValid()) {
			wo();
            $.ajax({
                type: "POST",
                data: {datos, tipocarga},
                url: "general/Estructura/Transportista/Guardar_Transportista",
                success: function (r) {
                    console.log(r);
                    if (r == "ok") {
						wc();
                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Transportista/Listar_Transportista");
						alertify.success("Transportista Agregado con exito");
						$('#tica_id').select2('val', 'All');
                        $('#formTransportistas').data('bootstrapValidator').resetForm();
                        $("#formTransportistas")[0].reset();                       
                        $("#boxDatos").hide(500);
                        $("#botonAgregar").removeAttr("disabled");
                    } else {
                        //console.log(r);
						wc();
                        alertify.error("Error al Agregar Transportista");
                    }
                }
            });
        }else{
			alert("ATENCION!!! Hay campos Vacios o Mal Ingresados");
		}
    }

	//boton guardar
	$("#btnsave").on("click", function() {
			//tomo datos del form y hago objeto
			
			var transportista = new FormData($('#frm_transportista')[0]);
			console.table( transportista);
			transportista = formToObject(transportista); 
			   //codigo judas se hizo a las apuradas pero hay que optimizarlo XD
			   var aux =0;
				if(transportista.contacto != "")
				{
					if(transportista.cuit != "")
					{
						if(transportista.descripcion != "")
						{
							if(transportista.direccion != "")
							{
								if(transportista.fec_alta != "")
								{
									if( transportista.fec_baja_efectiva != "")
									{
										if(transportista.razon_social != "")
										{
											if(transportista.registro != "")
											{
												if( transportista.resolucion != "")
												{
													if(transportista.telefono != "")
													{
														if(transportista.tran_id != "")
														{
															if($("#tica_edit").val() != "")
															{
																aux = 1;
															}
															
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
				//fin codigo judas

			var tipo_carga = $("#tica_edit").val();		
			if (aux != 0) {
				$("#frm_transportista")[0].reset();
					wo();
					$.ajax({
							type: "POST",
							data: {transportista, tipo_carga},
							url: "general/Estructura/Transportista/Modificar_Transportista",
							success: function (result) {
								if(result == "error_transportista"){
									wc();
									alertify.error("Error al Actualizar Transportista");
								
									
                        			       
								}else{
									wc();
									$('#tica_edit').select2('val', 'All');
									
									$('#frm_transportista').data('bootstrapValidator').resetForm();
									$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Transportista/Listar_Transportista");
									alertify.success("Transportista Actualizado con exito");
									
								
									                      
                        			$("#modalEdit").hide(500);
								}	
							}
					});
			}else{
				alert("ATENCION!!! Hay campos vacios o Mal ingresados");
				$('#tica_edit').select2('val', 'All');
									$('#frm_transportista').data('bootstrapValidator').resetForm();
			}		
		});	

		//elimina transp y recarga la tabla
		function eliminar(){
			var tran_id = $("#transp_delete").val();
			wo();
			$.ajax({
					type: "POST",
					data: {tran_id:tran_id},
					url: "general/Estructura/Transportista/Borrar_Transportista",
					success: function(result) {
						wc();
						$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Transportista/Listar_Transportista");	
						$("#modalaviso").modal('hide');
						alertify.success("Transportista Eliminado con exito");
					},
					error: function(result){
						wc();
						$("#modalaviso").modal('hide');
						alertify.success("Error al Eliminar Transportista");
					}
			});
		}

	//script que muestra box de datos al dar click en boton agregar	
    $("#botonAgregar").on("click", function() {      

        $("#botonAgregar").attr("disabled", "");
        //$("#boxDatos").removeAttr("hidden");
        $("#boxDatos").focus();
        $("#boxDatos").show();

    });

	//cierra box de datos
    $("#btnclose").on("click", function() {
		$('#tica_id').select2('val', 'All');
        $('#formTransportistas').data('bootstrapValidator').resetForm();
        $("#formTransportistas")[0].reset();                       
        $("#boxDatos").hide(500);
        $("#botonAgregar").removeAttr("disabled");
        $('#formDatos').data('bootstrapValidator').resetForm();
        $("#formDatos")[0].reset();
        $('#selecmov').find('option').remove();
        $('#chofer').find('option').remove();
    });

	//Script Bootstrap Validacion.

    $('#formTransportistas').bootstrapValidator({
        message: 'This value is not valid',
        /*feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        //excluded: ':disabled',
        fields: {
            razon_social: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            descripcion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            direccion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            telefono: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            contacto: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            cuit: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            Domicilio: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            resolucion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            registro: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            fec_alta_efectiva: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            fec_baja_efectiva: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            Rsu: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
			},
			tica_edit: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            }
        }
    }).on('success.form.bv', function(e) {
        e.preventDefault();
        //guardar();
    });

	$('#frm_transportista').bootstrapValidator({
        message: 'This value is not valid',
        /*feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        //excluded: ':disabled',
        fields: {
            razon_social: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            descripcion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            direccion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            telefono: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            contacto: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            cuit: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            resolucion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    
                }
            },
           
            registro: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            fec_alta: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            fec_baja_efectiva: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
           
			ticaedit: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            }
        }
    }).on('success.form.bv', function(e) {
        e.preventDefault();
        //guardar();
    });
	
	// este script me permite limpiar la validacion una vez cerrado el modal
    $("#modalEdit").on("hidden.bs.modal", function (e) {
        $("#formEditDatos").data('bootstrapValidator').resetForm();
    });

	// script Datatables 
		DataTable($('#tabla_transportistas'));	

	// Initialize Select2 Elements
		$('.select3').select2();

</script>


