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
                <!--Zona-->
                <div class="form-group">
                    <label for="Zonag">Zona:</label>
                    <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                            <select class="form-control select2 select2-hidden-accesible" name="zona_id" id="zona_id">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                            foreach ($Zonagenerador as $i) {
                                echo '<option  value="'.$i->zona_id.'">'.$i->nombre.'</option>';

                                
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
            
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">                
                    <label for="Domicilio" >Domicilio:</label>
                    <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                    <input type="text" class="form-control"  name="domicilio" id="domicilio">
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
                            <select class="form-control select2 select2-hidden-accesible" name="depa_id" id="depa_id">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                            foreach ($Departamentos as $i) {
                                echo '<option  value="'.$i->depa_id.'">'.$i->nombre.'</option>';                                
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
                    <input type="text" class="form-control" name="num_registro" id="num_registro">
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
                            <select class="form-control select2 select2-hidden-accesible" name="tica_id" id="tica_id">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                foreach ($Tiporesiduo as $i) {
                                    echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                }
                                ?>
                            </select>
                    
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
            <button type="submit" class="btn btn-primary pull-right" onclick="Guardar_Generador()">Guardar</button>
        </form>
    </div>
</div>
</div>




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

$("#btnadd").on("click", function() {
    $("#btnadd").addClass("active");
    $("#btnview").removeClass("active");
    $("#formadd").show();
    $("#tablamodal").hide();
    $("#btnsave").show();
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
                                regexp: /\b(20|23|24|27|30|33|34)(\D)?[0-9]{8}(\D)?[0-9]/,
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
                                regexp: /^\d+$/ ,
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


<!--_____________________________________________________________-->
<!-- Funcion GUARDAR CIRCUITO -->
            



<script>
    $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Generador/Listar_Generador");

    function Guardar_Generador() {

        // datos = $('#form').serialize();

        var datos = new FormData($('#formGeneradores')[0]);
        datos = formToObject(datos);
        // datos.imagen = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN";
        datos.usuario_app = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario
        datos.lat = "110";
        datos.lng = "220";
        console.table(datos);
        
        
        

        //--------------------------------------------------------------

        if ($("#formGeneradores").data('bootstrapValidator').isValid()) {
            $.ajax({
                type: "POST",
                data: {datos},
                url: "general/Estructura/Generador/Guardar_Generador",
                success: function (r) {
                    console.log(r);
                    if (r == "ok") {
                        
                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Generador/Listar_Generador");
                        alertify.success("Agregado con exito");

                        $('#formGeneradores').data('bootstrapValidator').resetForm();
                        $("#formGeneradores")[0].reset();
                       
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

 
