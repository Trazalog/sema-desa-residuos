<!-- HEADER  -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Chofer</h4>
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

<!-- FIN HEADER -->

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

    ​    <!--_____________________________________________________________-->

            <div class="box-body">
                <form class="formChofer" id="formChofer"  method="POST" autocomplete="off" class="registerForm">
                    <div class="col-md-6 col-sm-6 col-xs-12">
            
                        <!--Nombre-->
                            <div class="form-group">
                                <label for="Nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Apellido-->
                            <div class="form-group">
                                <label for="Apellido">Apellido:</label>
                                <input type="text" class="form-control" id="apellido" name="apellido">
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--DNI-->
                            <div class="form-group">
                                <label for="DNI">DNI:</label>
                                <input type="text" class="form-control" id="documento" name="documento">
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Fecha de nacimiento-->
                            <div class="form-group">
                                <label for="FechaNacimiento">Fecha de nacimiento:</label>
                                    <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="date" class="form-control" id="fec_nacimiento" name="fec_nacimiento"></div>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Direccion-->
                            <div class="form-group">
                                <label for="Direccion">Direccion:</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Celular-->
                            <div class="form-group">
                                <label for="Celular">Celular:</label>
                                <input type="text" class="form-control" id="celular" name="celular">
                            </div>
                        <!--_____________________________________________________________-->

                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <!--Codigo-->
                            <div class="form-group">
                                <label for="Codigo">Codigo:</label>
                                <input type="text" class="form-control" id="codigo" name="codigo">
                            </div>
            ​            <!--_____________________________________________________________-->

                        <!--Empresa-->
                            <div class="form-group">
                                <label for="Empresa">Empresa:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="tran_id" name="tran_id">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($empresa as $i) {
                                            echo '<option value="'.$i->tran_id.'">'.$i->razon_social.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Carnet-->
                            <div class="form-group">
                                <label for="Carnet">Carnet:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="carnet" name="carnet">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($carnet as $i) {
                                            echo '<option value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Categoria-->
                            <div class="form-group">
                                <label for="Categoria">Categoria:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="cach_id" name="cach_id">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($categoria as $i) {
                                            echo '<option value="'.$i->tabl_id.'">'.$i->valor.'</option>';
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
                                    <input type="date" class="form-control pull-right" id="vencimiento" name="vencimiento">
                                </div>
                                <!-- /.input group -->
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Estado-->
                            <div class="form-group">
                                <label for="Habilitacion">Estado:</label>
                                <input type="text" class="form-control" id="habilitacion" name="habilitacion">
                            </div>
                    ​    <!--_____________________________________________________________-->

                    </div>

                        <!--_______________________SEPARADOR______________________________________-->            

                    <div class="col-md-12"><hr></div>

                        <!--_______________________SEPARADOR______________________________________-->

                    <div class="col-md-6">


                </form>
            </div>

                        <!--Boton de guardado-->
                            <div class="col-md-12"><hr></div><br>
                            <button type="submit" class="btn btn-primary pull-right" onclick="Guardar_Chofer()">Guardar</button>
                        <!--_____________________________________________________________--> 

            </div>
        </div>
    </div>

<!---//////////////////////////////////////--- FIN BOX---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- TABLA ---///////////////////////////////////////////////////////----->

<div class="box box-primary">
    <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
            <div class="row"><div class="col-sm-12 table-scroll" id="cargar_tabla">
            </div>
        </div>

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
        $("#boxDatos").hide(500);
        $("#botonAgregar").removeAttr("disabled");
        $('#formChofer').data('bootstrapValidator').resetForm();
        $("#formChofer")[0].reset();
    });

    $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Camion/Listar_Chofer");

    //guardar chofer	
    function Guardar_Chofer() {

        var datos = new FormData($('#formChofer')[0]);
        datos = formToObject(datos);
        datos.imagen = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN";
        datos.usuario_app = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario
        console.table(datos);

        //--------------------------------------------------------------

        if ($("#formChofer").data('bootstrapValidator').isValid()) {
            $.ajax({
                type: "POST",
                data: {datos},
                url: "general/Estructura/Camion/Guardar_Chofer",
                success: function (r) {
                    console.table(r);
                    if (r == "ok") {

                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Camion/Listar_Chofer");
                        alertify.success("Agregado con exito");

                        $('#formChofer').data('bootstrapValidator').resetForm();
                        $("#formChofer")[0].reset();

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

    // Datatable tabla_choferes
    DataTable($('#tabla_choferes'))
</script>
<!--_____________________________________________________________-->

