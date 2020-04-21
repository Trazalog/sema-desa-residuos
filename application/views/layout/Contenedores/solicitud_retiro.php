<!--HEADER-->
	<div class="box box-primary animated fadeInLeft">
			<div class="box-header with-border">
					<h4>Solicitud de Retiro Contenedor</h4>
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
<!--HEADER-->

<!--BOX FORMULARIO-->
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

			<div class="box-body">

					<form class="formPedidos" id="formPedidos" >	
						<div class="col-md-12">

								<div class="row">
												
										<!--Numero-->
										<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="form-group">                    
														<label for="Nro" class="form-label">Nro:</label>
														<div class="input-group date">
														<div class="input-group-addon">
																<i class="fa fa-"></i>
														</div>
														<input type="text" id="Nro" value="<?php echo $nuevo_sore_id;?>" disabled class="form-control">
														</div>
												</div>
										</div>
										<!--_______________________________-->

										<!--Fecha-->													
										<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="form-group">                    
														<label for="fecha" class="form-label">Fecha:</label>
														<div class="input-group date">
														<div class="input-group-addon">
																<i class="fa fa-calendar"></i>
														</div>
														<input type="date" class="form-control" id="Fecha">
														</div>
												</div>
										</div>
										<!--_____________________________________________-->

										<!--Transportistas-->	
										<div class="col-md-8 col-sm-8 col-xs-12">
										<div class="form-group">
												<label for="transportista">Transportista:</label>
												<select class="form-control select2 select2-hidden-accesible" id="transportista">
														<option value="" disabled selected>-Seleccione opcion-</option>                            
												<?php
														foreach ($transportista as $i) {
																echo '<option  value="'.$i->tran_id.'">'.$i->razon_social.'</option>';
														}
												?>   
												</select>
										</div>
										</div>					

										<!--Tipo de residuos-->
										<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
												<label for="Tipo de residuos">Tipo de residuos:</label>
												<div class="input-group date">
														<div class="input-group-addon">
																<i class="glyphicon glyphicon-check"></i>
														</div>
														<select class="form-control select2 select2-hidden-accesible" id="tica_id">	
														</select>
												</div>
										</div>
										</div>
										<!--_____________________________________________-->

										<!--Contenedores-->
										<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
												<label for="cont_ent">Contenedores:</label>
												<div class="input-group date">
														<div class="input-group-addon">
																<i class="glyphicon glyphicon-check"></i>
														</div>
														<select class="form-control select2 select2-hidden-accesible" name="cont_ent" id="cont_ent">
														</select>
												</div>
										</div>
										</div>
										<!--_____________________________________________-->							

										<!--Porcentaje llenado-->
										<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="form-group">                    
														<label for="porcentaje" class="form-label">% Llenado:</label>
														<div class="input-group date">
														<div class="input-group-addon">
																<i class="fa fa-"></i>
														</div>
														<input type="text" name="porcentaje" id="porcentaje" value="<?php //echo rand(1,30);?>" class="form-control">
														<!-- <input type="number" class="form-control"   name="numero" id="Numero"> -->
														</div>
												</div>
										</div>
										<!--_______________________________-->

										<!--Metros cubicos-->
										<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="form-group">                    
														<label for="metros_cub" class="form-label">mts3:</label>
														<div class="input-group date">
														<div class="input-group-addon">
																<i class="fa fa-"></i>
														</div>
														<input type="text" name="metros_cub" id="metros_cub" value="" class="form-control">
														<!-- <input type="number" class="form-control"   name="numero" id="Numero"> -->
														</div>
												</div>
										</div>						
										<!--_______________________________-->							

					</form>

					<div class="col-md-12"></div>

			</div>
	</div>							

	<!--_________________SEPARADOR_________________-->
		<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
	<!--_________________SEPARADOR_________________-->

	<!--_________________BTN AGREGAR_________________-->
	<div class="col-md-12">
			<button type="submit" class="btn btn-default pull-right" onclick="Agregar_contenedor()">AGREGAR</button> 
			<!-- <button type="submit" class="btn btn-default pull-right" onclick="">AGREGAR</button> -->
	</div>
	<!--_________________BTN AGREGAR_________________-->

	<!--_________________SEPARADOR_________________-->
	<div class="col-md-12 col-sm-12 col-xs-12"> <br></div>
	<!--_________________SEPARADOR_________________-->			

	<!--_________________Tabla para enviar_________________-->
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="box " id="contenedores" style="display:none">
		<!-- <div class="box " id="contenedores"> -->
				<div class="box-body table-responsive">
						<!--__________________HEADER TABLA___________________________-->
						<table class="table table-striped" id="tbl_cont">
								<thead class="thead-dark" bgcolor="#eeeeee">
										<th>Acciones</th>
										<th>Contenedor</th>
										<th>% de llenado</th>
										<th>Mts3</th>															
								</thead>
								<!--__________________BODY TABLA___________________________-->
								<tbody>
										
								</tbody>
						</table>
						<!--__________________FIN TABLA___________________________-->
				</div>
		</div>
	</div>											
	<!--_________________Tabla para enviar_________________-->					

	<!--________________________SEPARADOR_____________________________________-->
	<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
	<!--________________________SEPARADOR_____________________________________-->
					
	<!--_________________BTN GUARDAR_________________-->									
	<div class="col-md-12">
			<div class="form-group">
				<!-- <button type="submit" class="btn btn-primary pull-right" aria-label="Left Align">Guardar</button> -->
				<button type="submit" class="btn btn-primary pull-right" onclick="guardar()">GUARDAR</button>
			</div>
	</div>
	<!--_________________BTN GUARDAR_________________-->	
					
			</div>
	</div>
<!--BOX FORMULARIO-->


<!--TABLA LISTADO TODAS LAS SOLICITUDES-->
<div class="box box-primary">

		<div class="box-header with-border">
        <h5>Listado de retiro Contenedores</h5>
    </div>

		<div class="box-body">
				<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
						<div class="row">
								<div class="col-sm-6"></div>
								<div class="col-sm-6"></div>
						</div>
						<div class="row">

								<div class="col-sm-12 table-scroll">		

									<!--__________________TABLA___________________________-->
										<table id="tabla_solicitudes" class="table table-bordered table-striped">
												<thead class="thead-dark" bgcolor="#eeeeee">
														<th>Acciones</th>
														<th>N° solicitud</th>
														<th>Fecha</th>
														<th>Transportista</th>
												</thead>										

												<tbody>
													<tr>
															<td>
															<button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
															<button type="button" title="Contenedores" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalContenedor"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
															<button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
															
															</td>
															<td>DATO</td>
															<td> DATO</td>
															<td>DATO</td>
														
													</tr>												
												</tbody>
										</table>
										
									<!--__________________FIN TABLA___________________________-->
								</div>
						</div>

				</div>
		</div>
<!--TABLA LISTADO TODAS LAS SOLICITUDES-->
		<div class="box-body">
			<div class="row">
				<div class="col-sm-12 table-scroll" id="tbl_listado_contenedores"></div>
			</div>
		</div>	

<!--MODAL EDITAR -->    
  <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Solicitud Contenedor</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="formGeneradoresEdit" class="registerForm">


                <div class="modal-body">

                <!--_____________________________________________-->
                <!--Nombre/Razon social-->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Nombre/Razon social">N° Solicitud:</label>
                                <input type="text" class="form-control" id="E_" name="e_" readonly>
                            </div>
                        </div>                        
                    </div>

                <!--_____________________________________________-->
                <!--Registro-->

                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="CUIT">Label:</label>
                                <input type="text" class="form-control" id="E_" name="e_">
                            </div>
                <!--_____________________________________________-->
                <!--Tipo de residuo-->

                            <div class="form-group">
                            <label for="Dpto" >Label:</label>
                            <select class="form-control select2 select2-hidden-accesible" id="E_" name="e_">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                // foreach ($Dpto as $i) {
                                //     echo '<option>'.$i->nombre.'</option>';
                                // }
                                ?>
                            </select>
                            </div>
                         </div>

                <!--_____________________________________________-->
                <!--Descripcion-->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Domicilio" >Label:</label>
                                <input type="text" class="form-control" id="E_" name="e_">
                            </div>

                <!--_____________________________________________-->
                <!--Resolucion-->

                            <div class="form-group">
                                <label for="Zonag" >Label:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="E_" name="e_">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                    // foreach ($Zonag as $i) {
                                    //     echo '<option>'.$i->nombre.'</option>';
                                    // }
                                    ?>
                                </select>
                            </div>
                        </div>
                </div>

                <!--_____________________________________________-->
                <!--Fecha de Alta-->

                <div class="row">                        
                    <div class="col-md-6">
                        <label for="Numero de registro" >Label:</label>
                        <input type="text" class="form-control" id="E_" name="e_">
                            
                        </div>

                        <div class="col-md-6">
                            <label for="Rubro" >Label:</label>
                            <input type="text" class="form-control" id="E_" name="e_">
                        </div>

                <!--_____________________________________________-->
                <!--Fecha de Baja-->


                        <div class="col-md-6">
                            <label for="TipoG" >Label:</label>
                            <select class="form-control select2 select2-hidden-accesible" id="E_"name="e_">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                // foreach ($TipoG as $i) {
                                //     echo '<option>'.$i->nombre.'</option>';
                                // }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="Tipo de residuos" >Label:</label>
                            <input type="text" class="form-control" id="E_" name="e_">
                        </div>
                    </div>
                    
                    
                </div>
                
            </form>

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
	</div>
<!--FIN MODAL EDITAR-->


<!--MODAL CONTENEDORES -->
    
  <div class="modal fade" id="modalContenedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion Contenedores</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                <div class="modal-body">

                        <!--_____________________________________________-->
                        <!--Codigo-->

                            <div class="row">
                                <div class="col-md-6">

                                <!--_____________________________________________-->
                                <!--Codigo-->

                                    <div class="form-group">
                                        <label for="Codigo" name="Codigo">N°:</label>
                                        <input type="text" class="form-control" id="numero" name="Numero" readonly>
                                    </div>
                                </div> 

                                <!--_____________________________________________-->
                                <!--Vehiculo-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Vehiculo" name="Vehiculo">Fecha:</label>
                                        <input type="text" class="form-control" id="fecha" name="Fecha" readonly>                                
                                    </div>
                                </div>                       
                            </div>

                        

                    

                        <!--_____________________________________________-->
                        <!--Descripcion-->

                    

                    <!--_______________________SEPARADOR______________________-->    

                    <div class="col-md-12"><br><br></div>

                    <!--_______________________SEPARADOR______________________-->   

                    <div class="row"> 

                         <div class="col-md-12">

                            <div class="box-header bg-blue">
                                <h5>Estado Contenedores</h5>
                            </div>
                        
                        </div>

                    </div>

                    <!--_______________________SEPARADOR______________________-->    

                    <div class="col-md-12"><br></div>

                    <!--_______________________SEPARADOR______________________--> 
                    

                   <!--*******************************************-->

                    <div class="row">

                        <div class="col-md-12">

                            

                            <div class="col-md-12"><br><hr><br></div>

                            <div class="row">                        
                                <div class="col-md-12">

                                     

                                    <table id="tabla_contenedores" class="table table-bordered table-striped">
                                        <thead class="thead-dark" bgcolor="#eeeeee">

                                            
                                            <th>Tipo resido</th>
                                            <th>Contenedor</th>
                                            <th>Transportista</th>
                                            <th>Estado</th>
                                            
                                            

                                        </thead>

                                        

                                        <tbody>
                                        <tr>
                                            
                                            <td>DATO</td>
                                            <td>DATO</td>
                                            <td>DATO</td>
                                            <td>DATO</td>
                                            

                                        </tr>
                                        <tr>
                                            
                                            <td>DATO</td>
                                            <td>DATO</td>
                                            <td>DATO</td>
                                            <td>DATO</td>
                                            

                                        </tr>
                                        
                                        
                                        </tbody>
                                    </table>

                                     
                                </div>         
                            </div>

                        </div>

                    </div>
                    
                    
                </div>
                
            </form>

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <!-- <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button> -->
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
          </div>
      </div>
  </div>
<!--FIN MODAL CONTENEDORES-->

<!-- Script Agregar datos de registrar_generadores-->

  <script>
			// FIXME: EIMINAR PENSSADO PARA GUARDAR DE UN REGISTRO A LA VEZ
		$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Contenedor/Listar_SolicitudesPedido");
		function agregarDato() {
      console.log("entro a agregar datos");
			$('#formGeneradores').on('submit', function(e) {

					e.preventDefault();
					var me = $(this);
					if (me.data('requestRunning')) {
							return;
					}
					me.data('requestRunning', true);

					datos = $('#formGeneradores').serialize();
					console.log(datos);
					//--------------------------------------------------------------


					$.ajax({
							type: "POST",
							data: datos,
							url: "ajax/Registrargenerador/guardarDato",
							success: function(r) {
									if (r == "ok") {
											//console.log(datos);
											$('#formGeneradores')[0].reset();
											alertify.success("Agregado con exito");
									} else {
											console.log(r);
											$('#formGeneradores')[0].reset();
											alertify.error("error al agregar");
									}
							},
							complete: function() {
									me.data('requestRunning', false);
							}
					});

			});

    }
  </script>

<!--Script Bootstrap Validacion.FORMULARIO GENERAL -->            
  <script>
      $('#formGeneradores').bootstrapValidator({
          message: 'This value is not valid',
          /*feedbackIcons: {
              valid: 'glyphicon glyphicon-ok',
              invalid: 'glyphicon glyphicon-remove',
              validating: 'glyphicon glyphicon-refresh'
          },*/
          //excluded: ':disabled',
          fields: {
              Nombre_razon: {
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

              Cuit: {
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

              Zona: {
                  message: 'la entrada no es valida',
                  validators: {
                      notEmpty: {
                          message: 'la entrada no puede ser vacia'
                      }
                  }
              },

              Rubro: {
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

              Tipo: {
                  message: 'la entrada no es valida',
                  validators: {
                      notEmpty: {
                          message: 'la entrada no puede ser vacia'
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

              Departamento: {
                  message: 'la entrada no es valida',
                  validators: {
                      notEmpty: {
                          message: 'la entrada no puede ser vacia'
                      }
                  }
              },

              Numero_registro: {
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

              Tipo_Residuo: {
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
              }
          }
      }).on('success.form.bv', function(e) {
          e.preventDefault();
          //guardar();
      });
  </script>

<!--Script Bootstrap Validacion.FORMULARIO MODAL EDITAR -->            
  <script>
              $('#formGeneradoresEdit').bootstrapValidator({
                  message: 'This value is not valid',
                  /*feedbackIcons: {
                      valid: 'glyphicon glyphicon-ok',
                      invalid: 'glyphicon glyphicon-remove',
                      validating: 'glyphicon glyphicon-refresh'
                  },*/
                  //excluded: ':disabled',
                  fields: {
                      e_nombre_razon: {
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

                      e_cuit: {
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

                      e_zonag: {
                          message: 'la entrada no es valida',
                          validators: {
                              notEmpty: {
                                  message: 'la entrada no puede ser vacia'
                              }
                          }
                      },

                      e_rubro: {
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

                      e_tipo: {
                          message: 'la entrada no es valida',
                          validators: {
                              notEmpty: {
                                  message: 'la entrada no puede ser vacia'
                              }
                          }
                      },

                      e_omicilio: {
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

                      e_departamento: {
                          message: 'la entrada no es valida',
                          validators: {
                              notEmpty: {
                                  message: 'la entrada no puede ser vacia'
                              }
                          }
                      },

                      e_numero_registro: {
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

                      e_tipo_Residuo: {
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
                      }
                  }
              }).on('success.form.bv', function(e) {
                  e.preventDefault();
                  //guardar();
              });
  </script>

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
        $('#formDatos').data('bootstrapValidator').resetForm();
        $("#formDatos")[0].reset();
        $('#selecmov').find('option').remove();
        $('#chofer').find('option').remove();
    });
  </script>
<!-- script que muestra box de datos al dar click en boton agregar -->    
 

<!-- Datatables -->
  <script>
    DataTable($('#tabla_residuos'));
    DataTable($('#tabla_contenedores'));
    DataTable($('#tabla_solicitudes'));
    DataTable($('#tabla_transportistas'));
		DataTable($('#tbl_cont'));
  </script>
<!-- Datatables -->
 

<!-- Tabla listado de solicitudes de retiro -->
  <script>
      $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Contenedor/Listar_SolicitudesRetiro");
	</script>
<!-- Tabla listado de solicitudes de retiro -->

<!-- Funciones que devuelven tipo de RSU y contenedores asociados al mismo -->
	<script>

		// carga tipo de RSU dependiendo de Transportista
			$('#transportista').change(function(){
				//alert(this.value);
				var tran_id = this.value;
				//FIXME: DESHARDCODEAR ACA!!!!
				tran_id= 3;

				$.ajax({
						type: "POST",
						data: {tran_id: tran_id},
						dataType : 'json',
						url: "general/Estructura/Contenedor/obtener_Tipo_residuo",
						success: function(respuesta) {			

							var selector = $("#tica_id");
							selector.find('option').remove();
							selector.append('<option value="" disabled selected>-Seleccione opcion-</option>');
							respuesta.forEach(function(e) {
								selector.append("<option value='" + e.tica_id + "'>" + e.valor + "</option");					
							});
						},
						error: function() {
							var selector = $("#tica_id");
							selector.find('option').remove();
							selector.append('<option value="" disabled selected>-Error-</option>');
						},
						complete: function() {
								
						}
					});
			});

		// carga contenedores dependiendo de RSU	
			$("#tica_id").change(function(){
			
				var tica_id = this.value;			
				alert(tica_id);
			
				$.ajax({
						type: "POST",
						data: {tica_id: tica_id},
						dataType : 'json',
						url: "general/Estructura/Contenedor/",
						success: function(respuesta) {	

							var selector_cont = $("#cont_ent");
							selector_cont.find('option').remove();
							selector_cont.append('<option value="" disabled selected>-Seleccione opcion-</option>');
							respuesta.forEach(function(e) {
								selector_cont.append("<option value='" + e.cont_id + "'>" + e.codigo + "</option");					
							});
						},
						error: function() {
							var selector_cont = $("#cont_ent");
							selector_cont.find('option').remove();
							selector_cont.append('<option value="" disabled selected>-Sin contenedores de este RSU-</option>');
						},
						complete: function() {
								
						}
				});
			
			});

	</script>

<!-- Funciones que devuelven tipo de RSU y contenedores asociados al mismo -->

<!-- funcion agregar contenedores a tabla -->
	
<script>	
	
	function Agregar_contenedor() {

			$('#contenedores').show();

			var data = new FormData($('#formPedidos')[0]);
			data = formToObject(data);

			var table = $('#tbl_cont').DataTable();		

			var row =  `<tr data-json='${JSON.stringify(data)}'>  
					<td><i class="fa fa-fw fa-minus text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Borrar"></i></td>
					<td>${data.cont_ent}</td>
					<td>${data.porcentaje}</td>
					<td>${data.metros_cub}</td>		
			</tr>`;

			table.row.add($(row)).draw();       

			$('#formPedidos')[0].reset();
			
		}

		// remueve registro de lista temporal de contenedres a agregar
		$(document).on("click", ".fa-minus", function() {             
      $(this).parents("tr").remove();
    });


		function guardar(){

			var datos_contenedor = [];        
      var rows_cont = $('#tbl_cont tbody tr');  
			rows_cont.each(function(i,e) {                   
					datos_contenedor.push(getJson(e));
			});

			console.table(datos_contenedor);

			if (datos_contenedor.lenght==0) {
					alert('Sin Datos para Registrar.');
					return;
			}

			//if ($("#formCircuitos").data('bootstrapValidator').isValid()) {
           
					 $.ajax({
							 type: "POST",
							 data: {datos_contenedor},							
							 url: "general/Estructura/Contenedor/Guardar_SolicitudRetiro",
							 success: function(respuesta) {
									 console.log(respuesta);
									 if (respuesta == "ok") {

											 $("#tbl_listado_contenedores").load(
													 "<?php echo base_url(); ?>index.php/general/Estructura/Contenedor/Listar_SolicitudesRetiro"
											 );
											 alertify.success("Agregado con exito");

											//  $('#formCircuitos').data('bootstrapValidator').resetForm();
											//  $("#formCircuitos")[0].reset();


											//  $("#boxDatos").hide(500);
											//  $("#botonAgregar").removeAttr("disabled");

									 } else {
											 console.log(respuesta);
											 alertify.error("error al agregar");
									 }
							 }
					 });





			// }





		}

</script>








