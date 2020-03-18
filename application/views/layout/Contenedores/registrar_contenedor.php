<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

    <div class="box box-primary animated fadeInLeft">
        <div class="box-header with-border">
            <h4>Registrar Contenedor</h4>
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

<!---//////////////////////////////////////---BOX 1---///////////////////////////////////////////////////////----->

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

    <!--__________________________________________________________________________________________-->

    <div class="box-body">
        <form class="formContenedores" id="formContenedores" method="POST" autocomplete="off" class="registerForm">
            <div class="col-md-6 col-sm-6 col-xs-12">

                <!--Codigo / Registro-->
                    <div class="form-group">
                        <label for="Codigo/Registro" >Codigo / Registro:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                <input type="text" class="form-control" name="codigo" id="codigo">
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->

                <!--Descripcion-->
                    <div class="form-group">
                        <label for="Descripcion" >Descripcion:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                <input type="text" class="form-control" name="descripcion" id="descripcion">
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->

                <!--Capacidad-->
                    <div class="form-group">
                        <label for="Capacidad" >Capacidad:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                <input type="number" class="form-control" name="capacidad" id="capacidad">
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->

                <!--Año de elaboracion-->
                    <div class="form-group">
                        <label for="Añoelab">Año de elaboracion:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" class="form-control"  name="anio_elaboracion" id="anio_elaboracion">
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->

                <!--Asociar Recipiente-->
                    <div class="form-group">
                        <label for="Recipiente">Asociar Recipiente:</label>
                        <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                            <select class="form-control select2 select2-hidden-accesible" name="reci_id" id="reci_id">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($Recipiente as $i) {
                                            echo '<option  value="'.$i->reci_id.'">'.$i->nombre.'</option>';
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->

            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">

                <!--Tara-->
                    <div class="form-group">
                        <label for="Tara" >Tara:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                <input type="number" class="form-control" name="tara" id="tara">
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->

                <!--Estado-->
                    <div class="form-group">
                        <label for="Estados">Estado:</label>
                        <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>                    
                            <select class="form-control select2 select2-hidden-accesible" name="esco_id" id="esco_id">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($Estados as $i) {
                                            echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->

                <!--Habilitacion-->
                    <div class="form-group">
                        <label for="Habilitacion" >Habilitacion:</label>
                        <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                            <select class="form-control select2 select2-hidden-accesible" name="habilitacion" id="habilitacion">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($Habilitacion as $i) {
                                            echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->

                <!--Año de elaboracion-->
                    <div class="form-group">
                        <label for="Añoelab">Fecha alta:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" class="form-control"  name="fec_alta" id="fec_alta">
                        </div>
                    </div>      
                <!--__________________________________________________________________________________________-->

            </div>
            <div class="col-md-12 col-sm-12 col-xs-12"><hr></div>

                <!--Adjuntar imagen-->
                    <!-- <div class="col-md-6">
                        <form action="cargar_archivo" method="post" enctype="multipart/form-data">
                            <input type="file" name="imagen">
                        </form>
                    </div>-->
                <!--__________________________________________________________________________________________-->

            <div class="col-md-12 col-sm-12 col-xs-12"><hr></div>

                <!--Boton de guardado-->
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right" onclick="Guardar_Contenedor()">Guardar</button>
                    </div>            
                <!--__________________________________________________________________________________________-->

        </form>
    </div>
</div>

<!---//////////////////////////////////////---FIN BOX 1---///////////////////////////////////////////////////////----->

    <!---//////////////////////////////////////--- TABLA ---///////////////////////////////////////////////////////----->

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
    </div>

    <!---//////////////////////////////////////--- FIN TABLA---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- SCRIPTS ---///////////////////////////////////////////////////////----->

<!--__________________________________________________________________________________________-->

<!-- Script Boton Agregar-->
<script>
    //Script Boton Agregar
    $("#botonAgregar").on("click", function() {
        //crea un valor aleatorio entre 1 y 100 y se asigna al input nro
        var aleatorio = Math.round(Math.random() * (100 - 1) + 1);
        $("#nro").val(aleatorio);
        $("#botonAgregar").attr("disabled", "");
        //$("#boxDatos").removeAttr("hidden");
        $("#boxDatos").focus();
        $("#boxDatos").show();
    });

    // Script Boton Cerrar
    $("#btnclose").on("click", function() {
        $("#boxDatos").hide(500);
        $("#botonAgregar").removeAttr("disabled");
        $('#formDatos').data('bootstrapValidator').resetForm();
        $("#formDatos")[0].reset();
        $('#selecmov').find('option').remove();
    });
</script>
<!--__________________________________________________________________________________________-->

<!-- Registrar Contenedores-->
<script>
    $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Contenedor/Listar_Contenedor");
    function Guardar_Contenedor() {

        // datos = $('#formContenedores').serialize();

        var datos = new FormData($('#formContenedores')[0]);
        datos = formToObject(datos);
        // datos.imagen = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN";
        datos.usuario_app = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario         
        console.table(datos);

        //--------------------------------------------------------------

        if ($("#formContenedores").data('bootstrapValidator').isValid()) {
            $.ajax({
                type: "POST",
                data: {datos},
                url: "general/Estructura/Contenedor/Guardar_Contenedor",
                success: function (r) {
                    console.table(r);
                    if (r == "ok") {

                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Contenedor/Listar_Contenedor");
                        alertify.success("Agregado con exito");

                        $('#formContenedores').data('bootstrapValidator').resetForm();
                        $("#formContenedores")[0].reset();

                        $("#boxDatos").hide(500);
                        $("#botonAgregar").removeAttr("disabled");

                    } else {
                        //console.table(r);
                        alertify.error("error al agregar");
                    }
                }
            });
        }
    }
</script>
<!--__________________________________________________________________________________________-->

<!--Script Bootstrap Validacion.-->
<script>
    $('#formContenedores').bootstrapValidator({
        message: 'This value is not valid',
        /*feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        //excluded: ':disabled',
        fields: {
            codigo: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/ ,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            descripcion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            fec_alta: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }        
                }
            },
            reci_id: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            anio_elaboracion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                    
                }
            },
            tara: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /^[+-]?((\d+(\.\d+)?)|(\.\d+))$/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            esco_id: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            capacidad: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /^[+-]?((\d+(\.\d+)?)|(\.\d+))$/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            habilitacion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
        }
    }).on('success.form.bv', function(e){
        e.preventDefault();
        //guardar();
    });
</script>
<!--__________________________________________________________________________________________-->

<!--
'<div class="text-center">
<button type="button" title="Editar"  onclick="clickedit('+aux+')" class="btn btn-primary btn-circle"  data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
<button type="button" title="Info" onclick="clickinfo('+aux+')" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
<button type="button" title="eliminar" onclick="borrar('+aux+')" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
</div>',
-->