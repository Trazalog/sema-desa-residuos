<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Generadores</h4>
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
        <div class="box-tools pull-right">
            <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                data-toggle="tooltip" title="" data-original-title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>

    <!--_____________________________________________-->

    <div class="box-body">
        <form class="formGeneradores" id="formGeneradores"method="POST" autocomplete="off">
            <div class="col-md-6 col-sm-6 col-xs-12">

                <!--Nombre / Razon social-->
                <div class="form-group">
                    <label for="Nombre/Razon social"> Nombre / Razon social:</label>
                    <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                    <input type="text" class="form-control" name="razon_social" id="razon_social">
                    </div>
                </div>
                <!--_____________________________________________-->

                <!--CUIT-->
                <div class="form-group">
                    <label for="CUIT">CUIT:</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="glyphicon glyphicon-check"></i>
                        </div>                    
                    <input type="text" class="form-control"  name="cuit" id="cuit">
                    </div>  
                </div>
                <!--_____________________________________________-->

                <!--Departamento-->
                <div class="form-group">
                    <label for="Dpto">Departamento:</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="glyphicon glyphicon-check"></i>
                        </div>
                        <select class="form-control select2 select2-hidden-accesible" name="depa_id" id="depa_id">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                foreach ($departamentos as $dep) {
                                    echo '<option  value="'.$dep->depa_id.'">'.$dep->nombre.'</option>';             
                                }
                            ?>
                        </select>
                    </div>
                </div>
                
                <!--_____________________________________________-->

                <!--Rubro-->
                <div class="form-group">
                    <label for="Rubro" >Rubro:</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="glyphicon glyphicon-check"></i>
                        </div>
                        <select class="form-control select2 select2-hidden-accesible" name="rubr_id" id="rubr_id">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                            foreach ($Rubro as $i) {
                                echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!--_____________________________________________-->

                <!--Tipo-->
                <div class="form-group">
                    <label for="TipoG" name="Tipo">Tipo:</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="glyphicon glyphicon-check"></i>
                        </div>
                        <select class="form-control select2 select2-hidden-accesible" name="tist_id" id="tist_id">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                            foreach ($Tipogenerador as $i) {
                                echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <!--_____________________________________________-->
            
            <!--Domicilio-->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">                
                    <label for="Domicilio">Domicilio:</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="glyphicon glyphicon-check"></i>
                        </div>
                    <input type="text" class="form-control"  name="domicilio" id="domicilio">
                    </div>
                </div>
                <!--_____________________________________________-->

                <!--Zona-->
                <div class="form-group">
                    <label for="Zonag">Zona:</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="glyphicon glyphicon-check"></i>
                        </div>
                        <select class="form-control select2 select2-hidden-accesible" name="zona_id" id="zona_id">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            
                        </select>
                    </div>  
                </div>
                <!--_____________________________________________-->

                <!--Numero de registro-->
                <div class="form-group">
                    <label for="Numero de registro">Numero de registro:</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="glyphicon glyphicon-check"></i>
                        </div>
                    <input type="text" class="form-control" name="num_registro" id="num_registro">
                    </div>
                </div>
                <!--_____________________________________________--> 

								<!--Tipo de residuo-->								
								<div class="form-group">
										<label for="tipoResiduos">Tipo de residuo:</label>
										<div class="input-group date">
												<div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
												<select class="form-control select3" multiple="multiple"  data-placeholder="Seleccione tipo residuo"  style="width: 100%;"  id="tica_id" name="tica_id">															
														<?php
																foreach ($Tiporesiduo as $residuo) {		
																		echo '<option  value="'.$residuo->tabl_id.'">'.$residuo->valor.'</option>';
																}
														?>
												</select>
										</div>
								</div>
                <!--_____________________________________________-->

            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>
            <br>
            <button type="submit" class="btn btn-primary pull-right" onclick="Guardar_Generador()">Guardar</button>
        </form>
    </div>
</div>

</div>
<!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->

    
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title titulo" id="exampleModalLabel">Editar Generador</h5>
            </div>

            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL __________________-->

            <form method="POST" autocomplete="off" id="formGeneradoresEdit" class="registerForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="col-md-6 col-sm-6">
                            
                                <div class="form-group">
                                    <label for="e_nombre_razon">Nombre / Razon social:</label>
                                    <br>
                                    <input type="text" class="form-control habilitar" id="E_Nombre_Razon_social" name="e_nombre_razon">
                                </div>
                                
                                <div class="form-group">
                                    <label for="e_cuit">CUIT:</label>
                                    <br>
                                    <input type="text" class="form-control habilitar" id="E_CUIT" name="e_cuit">
                                </div>
                               
                                
                               

                            </div>
                            <!-- ___________________________________________________________________________________________ -->
                            <div class="col-md-6 col-sm-6">
                           
                            <div class="form-group">
                                    <label for="TipoG" >Tipo de generador:</label>
                                    <br>
                                         <select class="form-control select2 select2-hidden-accesible habilitar ocultar" id="E_TipoG"name="e_tipo">
                                            <option value="" disabled selected>-seleccione opcion-</option>
                                            <?php
                                            foreach ($Tipogenerador as $c) {
                                                echo '<option  value="'.$c->tabl_id.'">'.$c->valor.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <input type="text" class="form-control mostrar" id="text_generador" name="" style="display:none">
                                </div>							

                                <div class="form-group">
                                        <label for="Domicilio" >Domicilio:</label>
                                        <input type="text" class="form-control habilitar" id="E_Domicilio" name="e_omicilio">
                                </div>
                               
                                
                                    <input type="text" class="form-control habilitar" id="id_gen"  style="display:none">
                            

                            </div>
                        </div>
                    </div>
                           <!-- ____________________________________________________________________________________________ -->
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                        <label for="e_numero_registro">Numero de registro:</label>
                                        <input type="text" class="form-control habilitar" id="E_Numero_registro" name="e_numero_registro">  
                                </div> 

                                <div class="form-group">
                                    <label for="Zonag" >Zona:</label>
                                    <br>
                                        <select class="form-control select2 select2-hidden-accesible habilitar ocultar" id="E_Zonag" name="e_zonag">
                                            <option value="" disabled selected>-seleccione opcion-</option>
                                                <?php
                                                foreach ($Zonagenerador as $j) {
                                                    echo '<option  value="'.$j->zona_id.'">'.$j->nombre.'</option>';
                                                }
                                                ?>
                                            </select>
                                            <input type="text" class="form-control mostrar" id="text_zona" name="" style="display:none">
                                </div>                                
                            </div>
                            <div class="col-md-6 col-sm-6">
                            
                               
                                <div class="form-group">
                                    <label for="TipoG" >Tipo de rubro:</label>
                                    <br>
                                         <select class="form-control select2 select2-hidden-accesible ocultar" id="E_TipoR"name="e_tipoR">
                                            <option value="" disabled selected></option>
                                            <?php
                                            foreach ($Rubro as $e) {
                                                echo '<option  value="'.$e->tabl_id.'">'.$e->valor.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <input type="text" class="form-control mostrar" id="text_rubro" name="" style="display:none">

                                </div>
                                <div class="form-group">
																		<label for="tipoResiduos">Tipo de residuo:</label>
																		<div class="input-group date">
																				<div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
																				<select class="form-control select3" multiple="multiple"  data-placeholder="Seleccione tipo residuo"  style="width: 100%;"  id="tica_edit" name="e_tica_edit">															
																						<?php
																								foreach ($Tiporesiduo as $residuo) {		
																										echo '<option  value="'.$residuo->tabl_id.'">'.$residuo->valor.'</option>';
																								}
																						?>
																				</select>
																		</div>
																</div>
                               
                            </div>

                        </div>
                    </div>
                </div>
            </form>

            <!--__________________ FIN FORMULARIO MODAL __________________-->

            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btnsave_e">Guardar</button>
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!---//////////////////////////////////////--- FIN MODAL EDITAR ---///////////////////////////////////////////////////////----->
<!---//////////////////////////////////////--- MODAL BORRAR ---///////////////////////////////////////////////////////----->
    
<div class="modal fade" id="modalBorrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel"> Eliminar Generador</h5>
            </div>
            <input type="text" id="id_generador" style="display:none">
            <div class="modal-body">
            <center>
					<h4>
						<p>¿DESEA ELIMINAR EL GENERADOR?</p>
					</h4>
			</center>
           

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            <div class="modal-footer">
                <center>
                    <button type="submit" class="btn btn-primary" id="btndelete" onclick="deletegenerador()">SI</button>
                    <button type="submit" class="btn btn-default" id="btncancelar" data-dismiss="modal" id="cerrar">NO</button>
                </center>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL BORRAR ---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////---BOX TABLA ---///////////////////////////////////////////////////////----->

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

<!---//////////////////////////////////////--- FIN BOX TABLA ---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- SCRIPTS---///////////////////////////////////////////////////////----->

<!--_____________________________________________________________-->

<!-- script modal -->
<script>
$("#btnview").on("click", function() {
    $("#btnadd").removeClass("active");
    $("#btnview").addClass("active");
    $("#tablamodal").show();
    $("#formadd").hide();
    $("#btnsave").hide();
});

$(".close").on("click", function() {
    $('#tica_edit').select2('val', 'All');
    $('#formGeneradoresEdit').data('bootstrapValidator').resetForm();
});


$("#btnadd").on("click", function() {
    $("#btnadd").addClass("active");
    $("#btnview").removeClass("active");
    $("#formadd").show();
    $("#tablamodal").hide();
    $("#btnsave").show();
});

$('#depa_id').change(function(e){
			e.preventDefault();
			var depa_id = $('#depa_id option:selected').val();
            console.info('depa_id : ' + depa_id);
            $('#zona_id').empty();
			$.ajax({
					type: 'POST',
					data:{depa_id: depa_id},
                    url: "general/Estructura/Generador/obtener_Zona_departamento",
					success: function(result) {
						// var sel = document.getElementById("zonaAsociar");
  						// sel.remove(sel.selectedIndex);
						if(result){
										console.table( ' resultado: ' + result);
										$.each(JSON.parse(result), function(key,zona){
											$('#zona_id').append("<option value='" + zona.zona_id + "'>" +zona.zona_nom+"</option");	
										});
								}
					},
					error: function(result){
										
					}
			});
		});

</script>

<!---/////////////////////////--- BOOTSRAP VALIDATOR---/////////////////////////----->

<!--_____________________________________________________________-->

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
            cuit: {
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
            zona_id: {
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
            rubr_id: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            domicilio: {
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
            depa_id: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            num_registro: {
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
            tist_id: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            tica_id: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            }
        }
    }).on('success.form.bv', function(e) {
        e.preventDefault();
        //guardar();
    });
</script>

<!---/////////////////////////--- FIN BOOTSRAP VALIDATOR---/////////////////////////----->
<script>
//validadores From editar generadores
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
            e_tipo: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            e_tipoR: {
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
                    }
                }
            },
           
           
            e_numero_registro: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
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
            e_tica_edit: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            }
        }
    }).on('success.form.bv', function(e) {
        e.preventDefault();
        //guardar();
    });



</script>


<!-- Funcion GUARDAR Generador -->
<script>
    $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Generador/Listar_Generador");

        function Guardar_Generador() {

            // datos = $('#form').serialize();
						//FIXME: AGREGAR CAMPOS LAT Y LONG
            var datos = new FormData($('#formGeneradores')[0]);
            datos = formToObject(datos);
            datos.usuario_app = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario
            datos.lat = "110";
            datos.lng = "220";
            console.table(datos);
           
						var datos_tipo_carga = $("#tica_id").val();

            if ($("#formGeneradores").data('bootstrapValidator').isValid()) { 
                $.ajax({
                    type: "POST",
                    data: {datos, datos_tipo_carga},
                    url: "general/Estructura/Generador/Guardar_Generador",
                    success: function (r) {
                        console.log(r);
                        if (r == "ok") {

                            $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Generador/Listar_Generador");
                            alertify.success("Generador Agregado con exito");
                            $('#tica_id').select2('val', 'All');
                            $('#formGeneradores').data('bootstrapValidator').resetForm();
                            $("#formGeneradores")[0].reset();

                            $("#boxDatos").hide(500);
                            $("#botonAgregar").removeAttr("disabled");
                           

                        } else {
                          
                            alertify.error("Error al Agregar Generador");
                            $('#tica_id').select2('val', 'All');
                            $('#formGeneradores').data('bootstrapValidator').resetForm();
                            $("#formGeneradores")[0].reset();
                        }
                    }
                });
            }else{
                alert("ATENCION!!! Hay campos sin Completar o Mal Ingresados");
            }
        }

// Funcion Guardar lo que se edito del modal Edit
        $("#btnsave_e").click(function(e){
        var generador = new FormData();
        generador = formToObject(generador);
        generador.sotr_id = $("#id_gen").val();
        generador.razon_social =  $("#E_Nombre_Razon_social").val();
        generador.cuit =  $("#E_CUIT").val();
        generador.domicilio =  $("#E_Domicilio").val();
        generador.num_registro =  $("#E_Numero_registro").val();
        generador.lat =  120; //para futuro uso degeolocalizacion
        generador.lng = 120; //para futuro uso degeolocalizacion
        generador.usuario_app = "hugoDS";
        generador.zona_id =  $("#E_Zonag").val();
        generador.rubr_id =  $("#E_TipoR").val();
        generador.tist_id =  $("#E_TipoG").val(); // este es el tipo de generador
        //generador.tica_id =  $("#E_TipoResiduo").val();
        console.table(generador);

        //codigo judas se hizo a las apuradas pero hay que optimizarlo XD
        var aux =0;
        if($("#E_Nombre_Razon_social").val() != "")
        {
            if($("#E_CUIT").val() != "")
            {
                if($("#E_TipoR").val() != "")
                {
                    if($("#E_Domicilio").val() != "")
                    {
                        if($("#E_Numero_registro").val() != "")
                        {
                            if( $("#E_Zonag").val() != "")
                            {
                                if($("#E_TipoG").val() != "")
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
        //fin codigo judas

				var datos_tipo_carga = $("#tica_edit").val();
        if (aux != 0){
        $.ajax({
                type: "POST",
                data: {generador, datos_tipo_carga},
                url: "general/Estructura/Generador/Actualizar_Generador",
                success: function (r) {
                    
                    console.table(r);
                    if (r == "ok") {
                         $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Generador/Listar_Generador");
                        alertify.success("Generador Actualizado con exito");
                        $("#modalEdit").modal('hide');      
                        $('#tica_edit').select2('val', 'All');
                        $('#formGeneradoresEdit').data('bootstrapValidator').resetForm();
                                     

                    } else {
                        
                        alertify.error("Error al Actualizar Generador");
                        $('#tica_edit').select2('val', 'All');
                        $('#formGeneradoresEdit').data('bootstrapValidator').resetForm();
                    }
                }
            });
        }else{
            alert("ATENCION!!! Hay campos Vacios o Mal Ingresados");
        }

    });

//Funcion para elimiar generador 
function deletegenerador (){
    var elimina = new FormData();
        elimina = formToObject(elimina);
        elimina.sotr_id = $("#id_generador").val();
        elimina.eliminado = 1;
        console.table(elimina);
        $.ajax({
                type: "POST",
                data: {elimina},
                url: "general/Estructura/Generador/Eliminar_Generador",
                success: function (r) {
                    console.table(r);
                    if(r == "ok") {
                        $('#btndelete').hide();
                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Generador/Listar_Generador");
                         alertify.success("Generador Eliminado con exito");
                         $("#modalBorrar").modal('hide');
                    } else {                        
                        alertify.error("Error al Eliminar Generador");
                        
                    }
                }
            });



}


</script>
<!--_____________________________________________________________-->

<!-- script que muestra box de datos al dar click en boton agregar -->
<script>
    $("#botonAgregar").on("click", function() {
        //crea un valor aleatorio entre 1 y 100 y se asigna al input nro
        var aleatorio = Math.round(Math.random() * (100 - 1) + 1);
        $("#nro").val(aleatorio);

        $("#botonAgregar").attr("disabled", "");
        //$("#boxDatos").removeAttr("hidden");
        $("#boxDatos").focus();
        $("#boxDatos").show();
    });
    $("#btnclose").on("click", function() {
        $('#tica_edit').select2('val', 'All');
                        $('#formGeneradoresEdit').data('bootstrapValidator').resetForm();
        $('#tica_id').select2('val', 'All');
        $("#boxDatos").hide(500);
        $("#botonAgregar").removeAttr("disabled");
        $('#formGeneradores').data('bootstrapValidator').resetForm();
        $("#formGeneradores")[0].reset();
        $('#formDatos').data('bootstrapValidator').resetForm();
        $("#formDatos")[0].reset();
        $('#selecmov').find('option').remove();
        $('#chofer').find('option').remove();
    });
</script>



<!--_____________________________________________________________-->

<!-- script Datatables -->
<script>
//Initialize Select2 Elements
$('.select3').select2();
    DataTable($('#tabla_generadores'))
</script>

 
