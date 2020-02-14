<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Solicitud de Contenedor</h4>
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





<!---//////////////////////////////////////--- BOX FORMULARIO ---///////////////////////////////////////////////////////----->



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

    <form class="formPedidos" id="formPedidos" >

        <div class="row">           
            <div class="col-md-12">

                    <!--_______________________________-->
                    <!--Numero-->

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">                    
                            <label for="Nro" class="form-label">Nro:</label>
                            <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-"></i>
                            </div>
                            <input type="text" name="numero" id="Numero" value="<?php echo rand(1,30);?>" class="form-control"readonly>
                            <!-- <input type="number" class="form-control"   name="numero" id="Numero"> -->
                            </div>
                        </div>
                    </div>

                    <!--_______________________________-->
                    <!--Fecha-->
                    
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

            </div>

        

                <!--________________________SEPARADOR_____________________________________-->

                    <div class="col-md-12"><hr></div>

                <!--________________________SEPARADOR_____________________________________-->

            <div class="col-md-12">
            
                <!--_______________________________-->
                <!--Tipo residuo-->

                <div class="col-md-6 col-sm-6 col-xs-12">            
                
                    <div class="form-group">
                    <label for="tipores" class="form-label">Tipo residuo:</label>
                    <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                            <select class="form-control select2 select2-hidden-accesible" id="Tiporesiduo" name="tipo_residuo"
                            required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                        foreach ($tiporesiduos as $i) {
                                            echo '<option  value="'.$i->depa_id.'">'.$i->nombre.'</option>';

                                            
                                        }
                                ?>
                        </select>
                        </div>
                    </div>

                </div>
                

                <!--_______________________________-->
                <!--cantidad-->

                <div class="col-md-6 col-sm-6 col-xs-12">   

                    <div class="form-group">
                        <label for="Dpto" >Cantidad:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                        <input type="number" class="form-control"   name="cantidad" id="Cabtidad">
                        </div>
                    </div>
                </div>


            </div>

                <!--________________________SEPARADOR_____________________________________-->

                    <div class="col-md-12 col-sm-12 col-xs-12"><hr></div>

                <!--________________________SEPARADOR_____________________________________-->

            

            

                <!--_____________________________________________________________-->
                <!--BOTON AGREGAR-->

            <div class="col-md-12">
                <div class="form-group">

                <button  type="submit" class="btn btn-primary pull-right"   aria-label="Left Align" onclick="Agregar()">Agregar</button>
                 <!-- <button class="btn btn-primary pull-right"  onclick="Agregar() aria-label="Left Align">Agregar</button> -->
                </div>
            </div>

          

                <!--________________________SEPARADOR_____________________________________-->

                <div class="col-md-12 col-sm-12 col-xs-12"><hr><br><br></div>

                <!--________________________SEPARADOR_____________________________________-->




                                        
            <div class="col-md-12">

                <div class="row">

                    <div class="col-md-12 table-scroll">

                        <!--__________________HEADER TABLA___________________________-->

                        <table id="tabla_residuos" class="table table-bordered table-striped">
                            <thead class="thead-dark" bgcolor="#eeeeee">

                                <th>Tipo de residuo</th>
                                <th>Cantidad de contenedores</th>                           
                            
                                

                            </thead>

                            <!--__________________BODY TABLA___________________________-->

                            <tbody>

                            <?

                        //     if($residuos)
                        // {
                        //     foreach($residuos as $fila)
                        //     {
                        //     echo '<tr data-json:'.json_encode($fila).'>';
                        
                        //     echo    '<td>'.$fila->residuo.'</td>';                        
                        //     echo    '<td>'.$fila->cantidad.'</td>';
                        //     echo '</tr>';
                        // }
                        // }
                        ?>
                            
                            
                            </tbody>
                        </table>

                        <!--__________________FIN TABLA___________________________-->

                    </div>

                </div>
            </div>



            <!---//////////////////////////////////////--- FIN BOX FORMULARIO ---///////////////////////////////////////////////////////----->

            <!---//////////////////////////////////////--- BOX TRANSPORTISTA ---///////////////////////////////////////////////////////----->

                
            <div class="col-md-12"><br></div>

            <div class="col-md-12">

                <div class="box box-primary animated fadeInLeft">
                    <div class="box-header with-border">
                        <h4>Transportistas</h4>
                    </div>
                </div>


                <!--_______________________________-->
                <!--Empresa-->
            
            
            <div class="col-md-12">

                <div class="form-group">
                    <label for="selecemp" class="form-label">Empresa:</label>
                    <select multiple="" class="form-control" id="selecemp" name="empresa">
                        <?php
                            foreach ($Empresas as $i) {
                            echo '<option class="emp" data-json=\''.json_encode($i).'\'>'.$i->nom->nom_emp.'</option>';
                            }
                    ?>  
                    </select>
                </div>

            </div>

           

            <div class="col-md-12 col-sm-12 col-xs-12"><hr></div>

            <!--_______________________________-->
            <!--BOTON GUARDAR-->

            
            <div class="col-md-12">
                <div class="form-group">
                <button type="submit" class="btn btn-primary pull-right" aria-label="Left Align">Guardar</button>
            </div>




        </div>
    </form>

        
</div>

  

<!---//////////////////////////////////////--- FIN TRANSPORTISTA ---///////////////////////////////////////////////////////----->

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
                <table id="tabla_solicitudes" class="table table-bordered table-striped">
                    <thead class="thead-dark" bgcolor="#eeeeee">

                        <th>Acciones</th>
                        <th>Numero solicitud</th>
                        <th>Tipo residuo</th>
                        <th>Cantidad</th>
                        <th>Estado solicitud</th>
                        

                    </thead>

                    <!--__________________BODY TABLA___________________________-->

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
                                foreach ($TipoG as $i) {
                                    echo '<option>'.$i->nombre.'</option>';
                                }
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


<!---//////////////////////////////////////--- FIN MODAL EDITAR ---///////////////////////////////////////////////////////----->



<!---//////////////////////////////////////--- MODAL CONTENEDORES ---///////////////////////////////////////////////////////----->

    
    <div class="modal fade" id="modalContenedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion Solicitud</h5>
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
                                        <label for="Codigo" name="Codigo">N° Solicitud:</label>
                                        <input type="text" class="form-control" id="numero" name="Numero" readonly>
                                    </div>
                                </div> 

                                <!--_____________________________________________-->
                                <!--Vehiculo-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Vehiculo" name="Vehiculo">Fecha:</label>
                                        <input type="text" class="form-control" id="fecha" name="Fecha" value="???" readonly="">                                
                                    </div>
                                </div> 

                                 <div class="col-md-6">

                                <!--_____________________________________________-->
                                <!--Codigo-->

                                    <div class="form-group">
                                        <label for="Codigo" name="Codigo">Estado:</label>
                                        <input type="text" class="form-control" id="numero" name="Numero" readonly>
                                    </div>
                                </div> 

                                <!--_____________________________________________-->
                                <!--Vehiculo-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Vehiculo" name="Vehiculo">Transportista:</label>
                                        <input type="text" class="form-control" id="fecha" name="Fecha" value="???" readonly="">                                
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

                            

                            <div class="col-md-12"><br></div>

                            <div class="row">                        
                                <div class="col-md-12">

                                     

                                    <table id="tabla_contenedores" class="table table-bordered table-striped">
                                        <thead class="thead-dark" bgcolor="#eeeeee">

                                            
                                            <th>Tipo resido</th>
                                            <th>codigo Contenedor</th>
                                            <th>fecha</th>
                                           
                                            <th>Estado contenedor</th>
                                            
                                            

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


<!---//////////////////////////////////////--- FIN MODAL CONTENEDORES ---///////////////////////////////////////////////////////----->



  
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


<!--_____________________________________________________________-->
<!-- Agregar residuos-->


<script>
function Agregar() {
    $('#tabla_residuos').show();

    var data = new FormData($('#formPedidos')[0]);
    data = formToObject(data);

    $('#datos tbody').append(
        `<tr data-json='${JSON.stringify(data)}'>
            <td><button class="btn btn-link" onclick="$(this).closest('tr').remove();"><i class="fa fa-times"></i></button></td>
            <td>${$('option[value="'+data.recu_id+'"]').html()}</td>
            <td>${$('option[value="'+data.arti_id+'"]').html()}</td>
            <td>${data.cantidad}</td>
            <td>${data.lote}</td>
            <td>${$('option[value="'+data.destino+'"]').html()}</td>
        </tr>`
    );

    $('#formPedidos')[0].reset();
   
   
    $('select').select2().trigger('change');
}

</script>


<!---/////////////////////////--- FUNCIONES - AJAX ---/////////////////////////----->
<!--_____________________________________________________________-->
<!-- Script Agregar datos de registrar_generadores-->

            <script>
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

    DataTable($('#tabla_residuos'))

    DataTable($('#tabla_contenedores'))

    DataTable($('#tabla_solicitudes'))

    DataTable($('#tabla_transportistas'))

</script>

 
