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

							<!--contacto-->
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
														<select class="form-control select3" multiple="multiple"  data-placeholder="Seleccione tipo residuo"  style="width: 100%;"  id="tica_id">                            
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

<!--- SCRIPTS --->
<script>
	// script habilitar panel de formulario agregar 
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
            $.ajax({
                type: "POST",
                data: {datos, tipocarga},
                url: "general/Estructura/Transportista/Guardar_Transportista",
                success: function (r) {
                    console.log(r);
                    if (r == "ok") {

                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Transportista/Listar_Transportista");
                        alertify.success("Agregado con exito");
                        $('#formTransportistas').data('bootstrapValidator').resetForm();
                        $("#formTransportistas")[0].reset();                       
                        $("#boxDatos").hide(500);
                        $("#botonAgregar").removeAttr("disabled");
                    } else {
                        //console.log(r);
                        alertify.error("error al agregar");
                    }
                }
            });
        }
    }

	//script que muestra box de datos al dar click en boton agregar	
    $("#botonAgregar").on("click", function() {
        //crea un valor aleatorio entre 1 y 100 y se asigna al input nro
        var aleatorio = Math.round(Math.random() * (100 - 1) + 1);
        $("#nro").val(aleatorio);

        $("#botonAgregar").attr("disabled", "");
        //$("#boxDatos").removeAttr("hidden");
        $("#boxDatos").focus();
        $("#boxDatos").show();

    });

	//cierra box de datos
    $("#btnclose").on("click", function() {
        $("#boxDatos").hide(500);
        $("#botonAgregar").removeAttr("disabled");
        $('#formDatos').data('bootstrapValidator').resetForm();
        $("#formDatos")[0].reset();
        $('#selecmov').find('option').remove();
        $('#chofer').find('option').remove();
    });

	//Script Bootstrap Validacion.-->

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