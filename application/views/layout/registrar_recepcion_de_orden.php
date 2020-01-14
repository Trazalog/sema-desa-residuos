<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h3>Registrar recepción de orden</h3>
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






<!--  Box 1-->
<div class="box box-primary animated animated bounceInDown" id="boxDatos" hidden>
    <div class="box-header with-border">
       
    </div>


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
        <form id="formRecepcion" method="POST" autocomplete="off" class="registerForm">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nrodom" class="form-label">Numero de dom:</label>
                            <input type="text" name="nrodom" id="nrodom" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>

<!-- _____________GRUPO FORMULARIO________________ -->


            <div class="row">
                <div class="col-md-12">

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="nroot" class="">Nro OT:</label>
                        <input type="text" readonly id="nroot" name="nroot" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="chofer" class="form-label">Chofer:</label>
                        <input type="text" name="chofer" id="chofer" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="fechaini" class="form-label">Fecha de inicio:</label>
                        <input type="date" size="10" type="text" name="fechaini" id="fechaini" min="0"
                            class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="generador" class="form-label">Generador:</label>
                        <input type="text" name="generador" id="generador" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="transportista" class="form-label">Transportista:</label>
                        <input type="text" name="transportista" id="transportista" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="cantcont" class="form-label">Cant contenedores:</label>
                        <input type="text" size="10" type="text" name="cantcont" id="cantcont" class="form-control"
                            readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tipores" class="form-label">Tipo de residuo:</label>
                        <input type="text" name="tipores" id="tipores" class="form-control" readonly>
                    </div>
                </div>
                </div>
            </div>


<!-- _____________ FIN FORMULARIO________________ -->


            <hr>


<!-- _____________ IMAGENES ________________ -->

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="imgchof" class="form-label">Chofer:</label>
                            <img src="<?php base_url() ?>files/" id="imgchof" height="60" width="60">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="imgmovil" class="form-label">Vehiculo:</label>
                            <img src="<?php //base_url() ?>files/" id="imgmovil" height="60" width="60">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cont" class="form-label">Contenedor:</label>
                            <img src="<?php //base_url() ?>files/" id="imgmovil" height="60" width="60">
                        </div>
                    </div>
                </div>
            </div>

<!-- _____________ IMAGENES ________________ -->


            <hr>

<!-- _____________ GRUPO FORMULARIO ________________ -->

        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="peso" class="form-label">Peso:</label>
                        <input type="number" step="0.0001" id="peso" name="peso" class="form-control" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="conten2" class="form-label">Contenedor:</label>
                        <input type="number" size="10" type="text" name="conten2" id="conten2" min="0"
                            class="form-control" required readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tara" class="form-label">Tara:</label>
                        <input type="text" name="tara" id="tara" class="form-control" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="sectdesc" class="form-label">Sector de descarga:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="sectdesc" name="sectdesc"
                            required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                            foreach ($zonaDescarga as $i) {
                                echo '<option>'.$i->nombre.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="neto" class="form-label">Neto:</label>
                        <input type="number" step="0.0001" id="neto" name="neto" class="form-control" required readonly>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group text-center">
                        <label> Incidencia:</label>
                        <button type="button" class="btn btn-primary btn-circle" aria-label="Left Align"
                            data-toggle="modal" data-target="#modalIncidencia">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                         
                        </button>

                       
                        </div> 
                    </div>
                </div>
            </div>
        </div>

<!-- _____________ FIN  FORMULARIO ________________ -->

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="observ" class="form-label">Observaciones:</label>
                        <textarea style="resize: none;" type="text" class="form-control input-sm" rows="5" id="observ"
                            name="observ" required></textarea>
                    </div>
                </div>
            </div>

            <div class="col-md-12 "><hr></div>
            

            <div class="row">                
                <div class="col-md-12 ">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right" aria-label="Left Align">
                            Guardar
                        </button><br>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal incidencia-->
<div class="modal fade" id="modalIncidencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Registrar incidencia</h5>
            </div>
            <div class="modal-body">
                <form id="formIncidencia" method="POST" autocomplete="off" class="registerForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="numorden" class="form-label">Numero de orden:</label>
                                <input type="number" size="10" type="text" name="numorden" id="numorden" min="0"
                                    class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="tiporesid" class="form-label">Tipo residuo:</label>
                                <input type="text" name="tiporesid" id="tiporesid" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fechaa" class="form-label">Fecha:</label>
                                <input type="date" name="fechaa" id="fechaa" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="dfinal" class="form-label">D. final:</label>
                                <input type="text" name="dfinal" id="dfinal" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="desc" class="form-label">Descripcion:</label>
                                <input type="text" name="desc" id="desc" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="tipincid" class="form-label">Tipo incidencia:</label>
                                <input type="text" name="tipincid" id="tipincid" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="fechahora" class="form-label">Fecha y hora:</label>
                                <input type="datetime-local" name="fechahora" id="fechahora" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inspector" class="form-label">Inspector:</label>
                                <input type="text" name="inspector" id="inspector" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="numacta" class="form-label">Nro acta:</label>
                                <input size="10" type="text" name="numacta" id="numacta" min="0" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="conten2" class="form-label">Adjuntar:</label>
                                <input class="form-control" type="file" class=" input-sm" id="file" name="file"
                                    accept=".docx, application/msword, application/pdf">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
                            <button type="button" class="btn btn-default" id="btnclose" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- script bootstrap validator recepcion de orden -->
<script>
    $('#formRecepcion').bootstrapValidator({
        message: 'This value is not valid',
        /*feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        excluded: ':disabled',
        fields: {
            nrodom: {
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
            cont: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            },
            peso: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            },
            neto: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            },
            tara: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            },
            sectdesc: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'seleccione una opcion'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            },
            conten2: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'seleccione una opcion'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            },
            observ: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            }
        }
    }).on('success.form.bv', function (e) {
        e.preventDefault();
        guardarRecepcion();
    });
</script>

<!-- script bootstrap validator modal incidencia -->
<script>
        $('#formIncidencia').bootstrapValidator({
            message: 'This value is not valid',
            /*feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },*/
            excluded: ':disabled',
            fields: {
                numorden: {
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
                tiporesid: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        }
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    }
                },
                fechaa: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        }
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    }
                },
                dfinal: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        }
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    }
                },
                desc: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        }
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    }
                },
                tipincid: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'seleccione una opcion'
                        }
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    }
                },
                fechahora: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'seleccione una opcion'
                        }
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    }
                },
                inspector: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        }
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    }
                },
                numacta: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        }
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            e.preventDefault();
            guardarIncidencia();
        });
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
            </script>

<!--_____________________________________________________________-->
<!-- script close box de datos al dar click en cerrar -->

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