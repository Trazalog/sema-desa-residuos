<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Solicitud de Pedido de Contenedor</h4>
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

        <form class="formPedidos" id="formPedidos"method="POST" autocomplete="off" >

        <div class="col-md-12">

        <div class="formulario">
            <div class="col-md-12">
                <!-- Entrada de Nro -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="form-group">                    
                        <label for="Nro" class="form-label">Nro:</label>
                         <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-"></i>
                        </div>
                        <input type="text" name="nro" id="Nro" value="<?php echo rand(1,100);?>" class="form-control"readonly>
                        <!-- <input type="number" class="form-control"   name="numero" id="Numero"> -->
                        </div>
                    </div>
                </div>
                <!-- __________________________________________________________________________________________ -->
                <!-- Entrada de fecha -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="form-group">                    
                        <label for="fecha" class="form-label">Fecha:</label>
                        <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control"   name="fecha" id="Fecha">
                        </div>
                    </div>
                </div>
                 <!-- __________________________________________________________________________________________ -->
                 <!-- selcetor transportista -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="form-group">                    
                        <label for="transportista" class="form-label">transportista:</label>
                        <div class="input-group date">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-check"></i>
                        </div>
                            <select class="form-control select2 select2-hidden-accesible" id="transportista" name="transportista"
                                required onchange="obtenertipocarga()">
                               
                                <?php
                                            foreach ($transportista as $i) {
                                                echo '<option value="'.$i->tran_id.'">'.$i->razon_social.'</option>';
                                                
                                            }
                                    ?>
                            </select>
                        </div>
                    </div>
                </div>
                 <!-- __________________________________________________________________________________________ -->
                </div>
                <!--Fin col-md-12-->
                <div class="col-md-12">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="tipores" class="form-label">Tipo residuo:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-check"></i>
                                    </div>
                                        <select class="form-control select2 select2-hidden-accesible" id="tipores" name="tipo_residuo" required>
                                            <option value="" disabled selected>-Seleccione opcion-</option>
                                                
                                        </select>
                                </div>                    
                        </div>  

                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                                 <label for="Dpto" >Cantidad de contenedor:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                            <input type="number" class="form-control"   name="Tipo_Residuo" id="Tipo de residuos">
                        </div>                                 
                        </div>  

                    </div>
                </div>
            </div>
        </div>
        <!-- fin clase formulario -->           
        <!-- __________________________________________________________________________________________ -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary pull-right" aria-label="Left Align">
                     Agregar
                </button>
            </div>
             <!-- __________________________________________________________________________________________ -->
            <div class="col-md-12 col-sm-12 col-xs-12"><hr><br><br></div>

            <!-- __________________________________________________________________________________________ -->
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 table-scroll">

                        <!--__________________HEADER TABLA___________________________-->
                        <table id="tabla_contenedores" class="table table-bordered table-striped">
                        <thead class="thead-dark" bgcolor="#eeeeee">

                                        <th>Acciones</th>
                                        <th>Tipo de residuo</th>
                                        <th>Cantidad de contenedores</th>     
                            

                        </thead>

                        <!--__________________BODY TABLA___________________________-->

                        <tbody>
                        <tr>
                            <td>
                            <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                            </td>
                            <td>DATO</td>
                            <td>DATO</td>
                        </tr>
                        </tbody>
                    </table>

                        <!--__________________FIN TABLA___________________________-->
                    </div>
                </div>
            </div>

            <!--_____________________________________________-->
            
            <div class="col-md-12"><br></div>


        <!---//////////////////////////////////////--- BOX ACORDION ---///////////////////////////////////////////////////////----->

<div class="col-md-12">

        <div class="accordion" id="">   



        <!--_______________header ACORDION 1_______________-->



        <div class="card z-depth-0 bordered">

        <div class="card-header  " id="headingOne2" data-toggle="collapse" data-target="#collapseOne2" >
         

            

        </div>

        <!--_______________BODY ACORDION 1_______________-->

        <div id="collapseOne2" class="collapse" aria-labelledby="headingOne2" data-parent="#accordionExample275">

            <div class="card-body">

            
            
    </div>

    
    

</div>




<!--_______________header ACORDION 2_______________-->



    <div class="card z-depth-0 bordered">

        <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo2" data-parent="#accordionExample275">

        <div class="card-body">
             <div class="col-md-12">
             </div>

            <div class="col-md-12"><hr></div>

        </div>

    </div>
    </div>
    </div>
</div>

            <div class="col-md-12">
                <div class="col-md-3">            
                    <div class="form-group">
                    <label for="observaciones" >Observaciones:</label>
                        <div class="input-group date">
                            
                            <textarea name="observaciones" id="observaciones" cols="30" rows="2"></textarea>
                            <!-- <input type="text" class="form-control pull-right" id="observaciones" name="observaciones"> -->
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-right" aria-label="Left Align">
                        Guardar
                    </button>
                </div>
            </div>
</div>  



</div>
<!---//////////////////////////////////////--- FIN BOX ACORDION ---///////////////////////////////////////////////////////----->

            

        </div>

        
            
        </form>

        
    </div>

    
</div>
</div>




<!---//////////////////////////////////////--- TABLA ---///////////////////////////////////////////////////////----->



<div class="box box-primary">

<div class="box-header with-border">
        <h5>Listado de solicitudes</h5>
    </div>

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
                    <table id="tabla_pedidos" class="table table-bordered table-striped">
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

function obtenertipocarga(){
    var id_transportista = $("#transportista").val();
    console.table(id_transportista);
    $.ajax({
        type: "POST",
        data: {id_transportista},
        url: "general/Estructura/Solicitud_Pedido/obtenerTipoRes",
        success: function($r){
            var res = JSON.parse($r);
            console.table(res);
            if(res){

                $("#tipores").find('option').remove();
                for(var i=0; i <= res.length-1; i++){
                $("#tipores").append("<option value= '"+res[i].tica_id+"' >" + res[i].valor + "</option>");
                }


            }
            else{
                alertify.error("error al traer tipo de carga");
            }

        },

    });
}
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

    DataTable($('#tabla_contenedores'));

    DataTable($('#tabla_pedidos'));

    
    

</script>



 
