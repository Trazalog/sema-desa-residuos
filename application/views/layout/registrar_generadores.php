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

        <form class="formGeneradores" id="formGeneradores"method="POST" autocomplete="off" >

            <div class="col-md-6 col-sm-6 col-xs-12">
                <!--Nombre / Razon social-->
                <div class="form-group">
                    <label for="Nombre/Razon social"> Nombre / Razon social:</label>
                    <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                    <input type="text" class="form-control" name="Nombre_razon" id="Nombre/Razon social">
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
                    <input type="text" class="form-control"  name="Cuit" id="CUIT">
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
                    <select class="form-control select2 select2-hidden-accesible"  name="Zona" id="Zonag">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Zonagenerador as $i) {
                            echo '<option>'.$i->nombre.'</option>';
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
                    <input type="text" class="form-control"  name="Rubro" id="Rubro">
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
                    <select class="form-control select2 select2-hidden-accesible"name="Tipo" id="TipoG">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Tipogenerador as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                    </div>
                </div>
            </div>

            <!--_____________________________________________-->
            
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">                
                    <label for="Domicilio" >Domicilio:</label>
                    <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                    <input type="text" class="form-control"  name="Domicilio" id="Domicilio">
                    </div>
                </div>
                <!--_____________________________________________-->
                <!--Departamento-->
                <div class="form-group">
                    <label for="Dpto" >Departamento:</label>
                    <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                    <select class="form-control select2 select2-hidden-accesible" name="Departamento" id="Dpto">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Departamento as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
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
                    <input type="text" class="form-control" name="Numero_registro" id="Numero de registro">
                    </div>
                </div>
                <!--_____________________________________________-->
                <!--Tipo de residuos-->
                <div class="form-group">
                    <label for="Tipo de residuos">Tipo de residuos:</label>
                    <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                            <select class="form-control select2 select2-hidden-accesible" name="Tipo_Residuo" id="Tipo de residuos">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                foreach ($Tiporesiduo as $i) {
                                    echo '<option>'.$i->nombre.'</option>';
                                }
                                ?>
                            </select>
                    <input type="text" class="form-control"   name="Tipo_Residuo" id="Tipo de residuos">
                    </div>
                </div>
                <!--_____________________________________________-->
                <!--Boton de guardado-->


                <!--_____________________________________________-->
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>
            <br>
            <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
        </form>
    </div>
</div>
</div>




<!---//////////////////////////////////////--- TABLA ---///////////////////////////////////////////////////////----->



<div class="box box-primary">

    <!--__________________TABLA___________________________-->


    <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
            <div class="row">
                <div class="col-sm-12 table-scroll">
                <!--__________________HEADER TABLA___________________________-->

                    <!--__________________HEADER TABLA___________________________-->
                    <table id="tabla_generadores" class="table table-bordered table-striped">
                        <thead class="thead-dark" bgcolor="#eeeeee">
                            <th>Acciones</th>
                            <th>Nombre / Razon social</th>
                            <th>Zona</th>
                            <th>Departamento</th>
                            <th>Tipo</th>
                        </thead>
                        <!--__________________BODY TABLA___________________________-->
                        <tbody>
                        <tr>
                            <td>
                            <button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                            <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
                            <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                            </td>
                            <td>DATO</td>
                            <td> DATO</td>
                            <td>DATO</td>
                            <td>DATO</td>
                        </tr>
                        </tbody>
                    </table>

                    <!--__________________FIN TABLA___________________________-->
                </div>
            </div>
        </div>
    </div>

    <!---//////////////////////////////////////--- FIN TABLA---///////////////////////////////////////////////////////----->

    <!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Generador</h5>
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
                                <label for="Nombre/Razon social">Nombre / Razon social:</label>
                                <input type="text" class="form-control" id="E_Nombre/Razon social" name="e_nombre_razon">
                            </div>
                        </div>                        
                    </div>
                <!--_____________________________________________-->

                <!--Registro-->
                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="CUIT">CUIT:</label>
                                <input type="text" class="form-control" id="E_CUIT" name="e_cuit">
                            </div>
                <!--_____________________________________________-->

                <!--Tipo de residuo-->
                            <div class="form-group">
                            <label for="Dpto" >Departamento:</label>
                            <select class="form-control select2 select2-hidden-accesible" id="E_Dpto" name="e_departamento">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                foreach ($Dpto as $i) {
                                    echo '<option>'.$i->nombre.'</option>';
                                }
                                ?>
                            </select>
                            </div>
                         </div>
                <!--_____________________________________________-->

                <!--Descripcion-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Domicilio" >Domicilio:</label>
                                <input type="text" class="form-control" id="E_Domicilio" name="e_omicilio">
                            </div>
                <!--_____________________________________________-->

                <!--Resolucion-->
                            <div class="form-group">
                                <label for="Zonag" >Zona:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="E_Zonag" name="e_zonag">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                    foreach ($Zonag as $i) {
                                        echo '<option>'.$i->nombre.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                </div>
                <!--_____________________________________________-->

                <!--Fecha de Alta-->
                <div class="row">                        
                    <div class="col-md-6">
                        <label for="Numero de registro" >Numero de registro:</label>
                        <input type="text" class="form-control" id="E_Numero de registro" name="e_numero_registro">  
                        </div>
                        <div class="col-md-6">
                            <label for="Rubro" >Rubro:</label>
                            <input type="text" class="form-control" id="E_Rubro" name="e_rubro">
                        </div>
                <!--_____________________________________________-->

                <!--Fecha de Baja-->
                        <div class="col-md-6">
                            <label for="TipoG" >Tipo:</label>
                            <select class="form-control select2 select2-hidden-accesible" id="E_TipoG"name="e_tipo">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                foreach ($TipoG as $i) {
                                    echo '<option>'.$i->nombre.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="Tipo de residuos" >Tipo de residuos:</label>
                            <input type="text" class="form-control" id="E_Tipo de residuos" name="e_tipo_Residuo">
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


<!---//////////////////////////////////////--- FIN MODAL EDITAR ---///////////////////////////////////////////////////////----->



<!---//////////////////////////////////////--- MODAL INFORMACION ---///////////////////////////////////////////////////////----->

    
    <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion Generador</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="GET" autocomplete="off" id="formGeneradoresInfo" class="registerForm">


                <div class="modal-body">

                <!--_____________________________________________-->
                <!--Nombre/Razon social-->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Nombre/Razon social" >Nombre / Razon social:</label>
                                <input type="text" class="form-control" id="I_Nombre/Razon social" name="i_nombre_razon" readonly>
                            </div>
                        </div>                        
                    </div>

                <!--_____________________________________________-->
                <!--Registro-->

                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="CUIT" name="Cuit">CUIT:</label>
                                <input type="text" class="form-control" id="CUIT" name="Cuit" readonly>
                            </div>
                <!--_____________________________________________-->
                <!--Tipo de residuo-->

                            <div class="form-group">
                            <label for="Dpto" name="Departamento">Departamento:</label>
                            <input type="text" class="form-control" id="Dpto" readonly>
                            </div>
                         </div>

                <!--_____________________________________________-->
                <!--Descripcion-->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Domicilio" name="Domicilio">Domicilio:</label>
                                <input type="text" class="form-control" id="Domicilio" readonly>
                            </div>

                <!--_____________________________________________-->
                <!--Resolucion-->

                            <div class="form-group">
                                <label for="Zonag" name="Zona">Zona:</label>
                                <input type="text" class="form-control" id="zonaG" readonly>
                            </div>
                        </div>
                </div>

                <!--_____________________________________________-->
                

                <div class="row"> 

                        <!--_____________________________________________-->
                        <!--Numero de registro-->

                        <div class="col-md-6">
                            <label for="Numero de registro" name="Numero_registro">Numero de registro:</label>
                            <input type="text" class="form-control" id="Numero de registro" readonly>                            
                        </div>

                        <!--_____________________________________________-->
                        <!--Rubro-->

                        <div class="col-md-6">
                            <label for="Rubro" name="Rubro">Rubro:</label>
                            <input type="text" class="form-control" id="Rubro" readonly>
                        </div>                

                        <!--_____________________________________________-->
                        <!--Tipo-->

                        <div class="col-md-6">
                            <label for="TipoG" name="Tipo">Tipo:</label>
                            <input type="text" class="form-control" id="TipoG" readonly>
                        </div>

                        <!--_____________________________________________-->
                        <!--Tipo de residuos-->

                        <div class="col-md-6">
                            <label for="Tipo de residuos" name="Tipo_Residuo">Tipo de residuos:</label>
                            <input type="text" class="form-control" id="Tipo de residuos"readonly >
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


<!---//////////////////////////////////////--- FIN MODAL INFORMACION ---///////////////////////////////////////////////////////----->



  
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

$("#btnadd").on("click", function() {
    $("#btnadd").addClass("active");
    $("#btnview").removeClass("active");
    $("#formadd").show();
    $("#tablamodal").hide();
    $("#btnsave").show();
});
</script>

<!---/////////////////////////--- FUNCIONES - AJAX ---/////////////////////////----->

<!--_____________________________________________________________-->
<!-- Script Agregar datos de registrar_generadores-->

            <script>
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

<!---/////////////////////////--- FIN FUNCIONES - AJAX ---/////////////////////////----->

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

<!--_____________________________________________________________-->
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




<!---/////////////////////////--- FIN BOOTSRAP VALIDATOR---/////////////////////////----->


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
            </script>


            <script>
            $("#btnclose").on("click", function() {
                $("#boxDatos").hide(500);
                $("#botonAgregar").removeAttr("disabled");
                $('#formDatos').data('bootstrapValidator').resetForm();
                $("#formDatos")[0].reset();
                $('#selecmov').find('option').remove();
                $('#chofer').find('option').remove();
            });
            </script>

 
 <!--_____________________________________________________________-->
 <!-- script Datatables -->
 <script>

    DataTable($('#tabla_generadores'))

</script>

 
