    <!--__________________HEADER TABLA__________________-->
    <table id="tabla_choferes" class="table table-bordered table-striped">
        <thead class="thead-dark" bgcolor="#eeeeee">
            <th>Acciones</th>
            <th>Nombre y Apellido</th>
            <th>Direccion</th>
            <th>Celular</th>
            <th>Codigo</th>
            <th>Empresa</th>
            <th>Carnet y Categoria</th>
            <th>Estado</th>
        </thead>

        <!--__________________BODY TABLA__________________-->

        <tbody>
            <?php
            if($choferes)
            {
                foreach($choferes as $fila)
                {
                //echo '<tr data-json:'.json_encode($fila).'>';
                echo "<tr data-json='".json_encode($fila)."'>";
                echo    '<td>';
                echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                        <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp 
                        <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';

                echo   '</td>';
                echo    '<td>'.$fila->nombre. " " .$fila->apellido.'</td>';
                echo    '<td>'.$fila->direccion.'</td>';
                echo    '<td>'.$fila->celular.'</td>';
                echo    '<td>'.$fila->codigo.'</td>';
                echo    '<td>'.$fila->tran_id.'</td>';
                echo    '<td>'.$fila->carnet. " - ".$fila->cach_id.'</td>';
                echo    '<td>'.$fila->habilitacion.'</td>';
                echo   '</tr>';
                }
            }
            ?>
        </tbody>
    </table>

<!--__________________FIN TABLA__________________-->

<!---///////--- MODAL EDITAR ---///////--->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                        <h5 class="modal-title" id="exampleModalLabel">Editar Transportista</h5>
                </div>
                <div class="modal-body col-md-12 col-sm-12 col-xs-12">

                    <!--__________________ FORMULARIO MODAL __________________-->
                    <form method="POST" autocomplete="off" id="frm_chofer" class="registerForm">	

                        <!-- Id de transportista y Usuario-->
                            <div class="form-group">
                                <input type="text" class="form-control habilitar" id="chof_id" name="chof_id" style="display:none;">
                                <input type="text" class="form-control habilitar" id="usuario_app_edit" name="usuario_app" style="display:none;">
                            </div>
                        <!--______________________________-->

                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <!--Nombre-->
                                <div class="form-group">
                                    <label for="Nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre_edit" name="nombre">
                                </div>
                            ​    <!--_____________________________________________________________-->

                            <!--Apellido-->
                                <div class="form-group">
                                    <label for="Apellido">Apellido:</label>
                                    <input type="text" class="form-control" id="apellido_edit" name="apellido">
                                </div>
                            ​    <!--_____________________________________________________________-->

                            <!--DNI-->
                                <div class="form-group">
                                    <label for="DNI">DNI:</label>
                                    <input type="text" class="form-control" id="dni_edit" name="dni">
                                </div>
                            ​    <!--_____________________________________________________________-->

                            <!--Fecha de nacimiento-->
                                <div class="form-group">
                                    <label for="FechaNacimiento">Fecha de nacimiento:</label>
                                    <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control" id="fec_nacimiento_edit" name="fec_nacimiento"></div>
                                </div>
                            ​    <!--_____________________________________________________________-->

                            <!--Direccion-->
                                <div class="form-group">
                                    <label for="Direccion">Direccion:</label>
                                    <input type="text" class="form-control" id="direccion_edit" name="direccion">
                                </div>
                            ​    <!--_____________________________________________________________-->

                                <!--Celular-->
                                    <div class="form-group">
                                        <label for="Celular">Celular:</label>
                                        <input type="text" class="form-control" id="celular_edit" name="celular">
                                    </div>
                                <!--_____________________________________________________________-->

                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <!--Codigo-->
                                    <div class="form-group">
                                        <label for="Codigo">Codigo:</label>
                                        <input type="text" class="form-control" id="codigo_edit" name="codigo">
                                    </div>
                            ​    <!--_____________________________________________________________-->

                                <!--Empresa-->
                                <div class="form-group">
                                    <label for="Empresa">Empresa:</label>
                                    <select class="form-control select2 select2-hidden-accesible" id="tran_id_edit" name="tran_id">
                                        <option value="" disabled selected>-Seleccione opcion-</option>
                                        <?php
                                            foreach ($empresa as $emp) {
                                                echo '<option value="'.$emp->tran_id.'">'.$emp->razon_social.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            ​    <!--_____________________________________________________________-->

                                <!--Carnet-->
                                    <div class="form-group">
                                        <label for="Carnet" >Carnet:</label>
                                        <select class="form-control select2 select2-hidden-accesible" id="carnet_edit" name="carnet">
                                            <option value="" disabled selected>-Seleccione opcion-</option>
                                            <?php
                                                foreach ($carnet as $carn) {
                                                    echo '<option value="'.$carn->tabl_id.'">'.$carn->valor.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                            ​    <!--_____________________________________________________________-->

                                <!--Categoria-->
                                    <div class="form-group">
                                        <label for="Categoria">Categoria:</label>
                                        <select class="form-control select2 select2-hidden-accesible" id="cach_id_edit" name="cach_id">
                                            <option value="" disabled selected>-Seleccione opcion-</option>
                                            <?php
                                                foreach ($categoria as $cate) {
                                                    echo '<option value="'.$cate->tabl_id.'">'.$cate->valor.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                            ​    <!--_____________________________________________________________-->

                                <!--Vencimiento-->
                                    <div class="form-group">
                                        <label for="Vencimiento">Vencimiento:</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="date" class="form-control pull-right" id="vencimiento_edit" name="vencimiento">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                            ​    <!--_____________________________________________________________-->

                                <!--Habilitacion-->
                                    <div class="form-group">
                                        <label for="Habilitacion">Habilitacion:</label>
                                        <input type="text" class="form-control" id="habilitacion_edit" name="habilitacion">
                                    </div>
                                ​<!--_____________________________________________________________-->
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
					<h5 class="modal-title" ><span class="fa fa-fw fa-times-circle" style="color:#A4A4A4"></span>Eliminar</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" >&times;</span>
					</button>
				</div>
				<input id="transp_delete" style="display: none;">
				<div class="modal-body">
					<center>
					<h4><p>¿Desea eliminar el chofer?</p></h4>
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






<script>
	// llena modal solo lectura
	$(".btnInfo").on("click", function() {
		datajson = $(this).parents("tr").attr("data-json");
		llenarModal(datajson);	
		blockEdicion();
	});

	// llena modal para edicion
	$(".btnEditar").on("click", function() {
		datajson = $(this).parents("tr").attr("data-json");
		llenarModal(datajson);
		habilitarEdicion();
	});

	//bloquea campos en modal
	function blockEdicion(){	

		$(".habilitar").attr("readonly","readonly");	
		$('#btnsave').hide();
	}

	//desbloquea campos en modal
	function habilitarEdicion(){

		$('.habilitar').removeAttr("readonly");//
		$('#btnsave').show();	
	}

	//llena modal Editar
	function llenarModal(datajson){

    

    data = JSON.parse(datajson);

    console.table('json: ' + data);        


    $("input#nombre_edit").val(data.nombre);			
    $("input#apellido_edit").val(data.apellido);			
    $("input#dni_edit").val(data.documento);
    $("input#fec_nacimiento_edit").val(data.fec_nacimiento);
    $("input#direccion_edit").val(data.direccion);
    $("input#celular_edit").val(data.celular);
    $("input#codigo_edit").val(data.codigo);	
    $("select#tran_id_edit option[value="+ data.tran_id+"]").attr("selected",true);
    $("select#carnet_edit option[value="+ data.carnet+"]").attr("selected",true);
    $("select#cach_id_edit option[value="+ data.cach_id+"]").attr("selected",true);
    $("input#vencimiento_edit").val(data.vencimiento);
    $("input#habilitacion_edit").val(data.habilitacion);

    // formateo fecha en input tipo date
    var fec_nacimiento = data.fec_nacimiento.slice(0, 10)	// saco hs y minutos
    Date.prototype.toDateInputValue = (function() {
        var local = new Date(fec_nacimiento);
        // local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0, 10);
    });
    $('input#fec_nacimiento_edit').val(new Date().toDateInputValue());

    // formateo fecha en input tipo date
    var vencimiento = data.vencimiento.slice(0, 10)	// saco hs y minutos
    Date.prototype.toDateInputValue = (function() {
        var local = new Date(vencimiento);
        // local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0, 10);
    });
    $('input#vencimiento_edit').val(new Date().toDateInputValue());


}

	//boton guardar
	$("#btnsave").on("click", function() {
		//tomo datos del form y hago objeto
    var chofer = new FormData($('#frm_chofer')[0]);
    chofer = formToObject(chofer);
		var tipo_carga = $("#tica_edit").val();
		if ($("#frm_chofer").data('bootstrapValidator').isValid()) {
				$.ajax({
						type: "POST",
						data: {chofer, tipo_carga},
						url: "general/Estructura/Camion/Modificar_Chofer",
						success: function (result) {
							if(result == "error_chofer"){
								alertify.error("Hubo un error a modificar Chofer");
							}else{
								$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Chofer/Listar_Chofer");
								//alertify.success("Transportista modificado con exito...");
							}
						}
				});
		}
	});

	//levanta modal y guarda tran_id
	$(".btnDelete").on("click", function() {
		datajson = $(this).parents("tr").attr("data-json");
		data = JSON.parse(datajson);
		var chof_id = data.chof_id;
		// guardo tran_id en modal para usar en funcion eliminar
		$("#chof_delete").val(tran_id);
		//levanto modal
		$("#modalaviso").modal('show');
	});

	//elimina chof y recarga la tabla
	function eliminar(){
		var chof_id = $("#chof_delete").val();
		$.ajax({
				type: "POST",
				data: {chof_id:chof_id},
				url: "general/Estructura/Camion/Borrar_Chofer",
				success: function(result) {

					$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Camion/Listar_Camion");
					$("#modalaviso").modal('hide');
				},
				error: function(result){
					$("#modalaviso").modal('hide');
				}
		});
	}

    // Script validacion
    $('#formChofer').bootstrapValidator({
        message: 'This value is not valid',
        /*feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        //excluded: ':disabled',
        fields: {
            nombre: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            apellido: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            documento: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            fec_nacimiento: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            direccion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            celular: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            codigo: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            tran_id: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            carnet: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            cach_id: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            vencimiento: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            habilitacion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            }
        }
    }).on('success.form.bv', function (e) {
        e.preventDefault();
        //guardar();
    });

    // este script me permite limpiar la validacion una vez cerrado el modal
	$("#modalEdit").on("hidden.bs.modal", function (e) {
        $("#formEditDatos").data('bootstrapValidator').resetForm();
    });

	//Initialize Select2 Elements
	$('.select4').select2();





    // inicializo tabla
    DataTable($('#tabla_choferes'))
</script>