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

    <!--_____________________________________________-->
    <div class="box-body">
        <form class="formContenedores" id="formContenedores" method="POST" autocomplete="off" class="registerForm">

            <div class="col-md-6">
                <!--Codigo / Registro-->
                <div class="form-group">
                    <label for="Codigo/Registro">Codigo / Registro:</label>
                    <input type="text" class="form-control"  name="Codigo_registro" id="Codigo/Registro">
                </div>
                <!--_____________________________________________-->
                <!--Descripcion-->
                <div class="form-group">
                    <label for="Descripcion" >Descripcion:</label>
                    <input type="text" class="form-control" name="Descripcion" id="Descripcion">
                </div>
                <!--_____________________________________________-->
                <!--Capacidad-->
                <div class="form-group">
                    <label for="Capacidad" >Capacidad:</label>
                    <input type="text" class="form-control" name="Capacidad" id="Capacidad">
                </div>
                <!--_____________________________________________-->
                <!--Año de elaboracion-->
                <div class="form-group">
                    <label for="Añoelab">Año de elaboracion:</label>
                    <input type="text" class="form-control"  name="Añoelab" id="Añoelab">
                </div>
                <!--_____________________________________________-->
            </div>
            <div class="col-md-6">
                <!--Tara-->
                <div class="form-group">
                    <label for="Tara" >Tara:</label>
                    <input type="text" class="form-control"  name="Tara" id="Tara">
                </div>
                <!--_____________________________________________-->
                <!--Estado-->
                <div class="form-group">
                    <label for="Estados" >Estado:</label>
                    <select class="form-control select2 select2-hidden-accesible" name="Estados" id="Estados">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Estados as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <!--_____________________________________________-->
                <!--Habilitacion-->
                <div class="form-group">
                    <label for="Habilitacion" >Habilitacion:</label>
                    <input type="text" class="form-control" name="Habilitacion"id="Habilitacion">
                </div>

                <!--_____________________________________________-->
                <!--Adjuntador de imagenes-->  

                <div class="col-md-6">
                

                <button type="file" name="upload" class="btn btn-default btn-circle" aria-label="Left Align">
                    <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
                </button>
                <small for="agregar" class="form-label">Adjuntar imagen</small>
        
                </div>             
               
              

                


                <!--_____________________________________________-->
            </div>

            <div class="col-md-12">
                <hr>
            </div>

            <!--_____________________________________________-->
            <!--Boton de guardado-->
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary pull-right" onclick="Agregar_Contenedor()">Guardar</button>
            </div>
            <!--_____________________________________________-->
        </form>
    </div>
</div>


<!---//////////////////////////////////////---FIN BOX 1---///////////////////////////////////////////////////////----->



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
                <table id="tabla_contenedores" class="table table-bordered table-striped">
                    <thead class="thead-dark" bgcolor="#eeeeee">

                        <th>Acciones</th>
                        <th>Codigo / Registro</th>
                        <th>Estado</th>
                        <th>Capacidad</th>
                        <th>Habilitacion</th>
                        

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
                <h5 class="modal-title" id="exampleModalLabel">Editar Contenedor</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                <div class="modal-body">



            <form class="formContenedores" id="formContenedores" method="POST" autocomplete="off" class="registerForm">

            <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <!--Codigo / Registro-->
                    <div class="form-group">
                        <label for="Codigo/Registro" name="Codigo_registro">Codigo / Registro:</label>
                        <input type="text" class="form-control" id="Codigo/Registro">
                    </div>
                    <!--_____________________________________________-->
                    <!--Descripcion-->
                    <div class="form-group">
                        <label for="Descripcion" name="Descripcion">Descripcion:</label>
                        <input type="text" class="form-control" id="Descripcion">
                    </div>
                    <!--_____________________________________________-->
                    <!--Capacidad-->
                    <div class="form-group">
                        <label for="Capacidad" name="Capacidad">Capacidad:</label>
                        <input type="text" class="form-control" id="Capacidad">
                    </div>
                    <!--_____________________________________________-->
                    <!--Año de elaboracion-->
                    <div class="form-group">
                        <label for="Añoelab" name="Añoelab">Año de elaboracion:</label>
                        <input type="text" class="form-control" id="Añoelab">
                    </div>

                </div>
                
                <div class="col-md-6">
                    <!--_____________________________________________--> 
                    <!--Tara-->
                    <div class="form-group">
                        <label for="Tara" name="Tara">Tara:</label>
                        <input type="text" class="form-control" id="Tara">
                    </div>
                    <!--_____________________________________________-->
                    <!--Estado-->
                    
                    <div class="form-group">
                        <label for="Estados" name="Estados">Estado:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="Estados">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                            foreach ($Estados as $i) {
                                echo '<option>'.$i->nombre.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <!--_____________________________________________-->
                    <!--Habilitacion-->
                    <div class="form-group">
                        <label for="Habilitacion" name="Habilitacion">Habilitacion:</label>
                        <input type="text" class="form-control" id="Habilitacion">
                    </div>
                </div>

                </div>    
                
            </div>
            <div class="col-md-12">
                <hr>
            </div>

            
        </form>

                
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
                <h5 class="modal-title" id="exampleModalLabel">Informacion Contenedor</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                <div class="modal-body">



            <form class="formContenedores" id="formContenedores" method="POST" autocomplete="off" class="registerForm">

            <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <!--Codigo / Registro-->
                    <div class="form-group">
                        <label for="Codigo/Registro" name="Codigo_registro">Codigo / Registro:</label>
                        <input type="text" class="form-control" id="Codigo/Registro" readonly>
                    </div>
                    <!--_____________________________________________-->
                    <!--Descripcion-->
                    <div class="form-group">
                        <label for="Descripcion" name="Descripcion">Descripcion:</label>
                        <input type="text" class="form-control" id="Descripcion" readonly>
                    </div>
                    <!--_____________________________________________-->
                    <!--Capacidad-->
                    <div class="form-group">
                        <label for="Capacidad" name="Capacidad">Capacidad:</label>
                        <input type="text" class="form-control" id="Capacidad" readonly>
                    </div>
                    <!--_____________________________________________-->
                    <!--Año de elaboracion-->
                    <div class="form-group">
                        <label for="Añoelab" name="Añoelab">Año de elaboracion:</label>
                        <input type="text" class="form-control" id="Añoelab" readonly>
                    </div>

                </div>
                
                <div class="col-md-6">
                    <!--_____________________________________________--> 
                    <!--Tara-->
                    <div class="form-group">
                        <label for="Tara" name="Tara">Tara:</label>
                        <input type="text" class="form-control" id="Tara" readonly>
                    </div>
                    <!--_____________________________________________-->
                    <!--Estado-->
                    
                    <div class="form-group">
                        <label for="Estados" name="Estados">Estado:</label>
                        <input type="text" class="form-control" id="" readonly>
                    </div>
                    <!--_____________________________________________-->
                    <!--Habilitacion-->
                    <div class="form-group">
                        <label for="Habilitacion" name="Habilitacion">Habilitacion:</label>
                        <input type="text" class="form-control" id="Habilitacion" readonly>
                    </div>
                </div>

                </div>    
                
            </div>
            <div class="col-md-12">
                <hr>
            </div>

            
        </form>

                
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

 <!---//////////////////////////////////////--- FUNCIONES ---///////////////////////////////////////////////////////----->


<!--________________________________________ AGREGAR EN TABLA ________________________________________-->

<script>

function Agregar_Contenedor()

{

    // Variables de datos de los campos a listar

    var data = {};
    data.codigo = $('#Codigo/Registro').val();
    data.descripcion = $('#Descripcion').val();
    data.capacidad = $('#Capacidad').val();
    data.elaboracion = $('#Añoelab').val();
    data.tara = $('#Tara').val();
    data.capacidad = $('#Capacidad').val();
    data.estados = $('#Estados').find('option:selected').html();
    data.habilitacion = $('#Habilitacion').val();
    

    //console.log(data);
    
    tr="";
    tr+="<tr data-json='"+JSON.stringify(data)+"' data-contenedores=''>";
    tr+="<td><i class='fa fa-fw fa-minus text-light-blue manzanas_asignadas_borrar' style='cursor: pointer; margin-left: 15px;' title='Eliminar'></i>";
    tr+="<i class='fa fa-fw fa-plus text-light-blue manzanas_asignadas_calle' style='cursor: pointer; margin-left: 15px;' title='Asignar Calles'></i>";
    tr+="<i class='fa fa-fw fa-search text-light-blue manzanas_asignadas_ver' style='cursor: pointer; margin-left: 15px;' title='Ver Calles'></i></td>";
    tr+="<td>"+data.area+"</td><td>"+data.departamento+"</td></tr>";
    manzanasAsignadas.row.add($(tr)).draw();

    // Limpiar Campos

    data.codigo = $('#Codigo/Registro').val('');
    data.descripcion = $('#Descripcion').val('');
    data.capacidad = $('#Capacidad').val('');
    data.elaboracion = $('#Añoelab').val('');
    data.tara = $('#Tara').val('');
    data.capacidad = $('#Capacidad').val('');
    data.estados = $('#Estados').find('option:selected').html('');
    data.habilitacion = $('#Habilitacion').val('');



   
}



</script>

 <!---//////////////////////////////////////--- SCRIPTS ---///////////////////////////////////////////////////////----->


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
        <!-- Script Agregar datos de registrar_generadores-->

        <script>
        function agregarDato() {
            console.log("entro a agregar datos");
            $('#formContenedores').on('submit', function(e) {

                e.preventDefault();
                var me = $(this);
                if (me.data('requestRunning')) {
                    return;
                }
                me.data('requestRunning', true);

                datos = $('#formContenedores').serialize();
                console.log(datos);


                //--------------------------------------------------------------


                $.ajax({
                    type: "POST",
                    data: datos,
                    url: "ajax/Registrargenerador/guardarDato",
                    success: function(r) {
                        if (r == "ok") {
                            //console.log(datos);
                            $('#formContenedores')[0].reset();
                            alertify.success("Agregado con exito");
                        } else {
                            console.log(r);
                            $('#formContenedores')[0].reset();
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

        <!--_____________________________________________________________-->
        <!-- Script Boostrap Validator-->

        <script>
        $('#formContenedores').bootstrapValidator({
            message: 'This value is not valid',
            /*feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },*/
            fields: {
                Codigo_registro: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        },
                        regexp: {
                            regexp: /[A-Za-z]/,
                            message: 'la entrada debe ser un numero entero'
                        }
                    }
                },
                Descripcion: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        },
                        regexp: {
                            regexp: /[A-Za-z]/,
                            message: 'la entrada debe ser un numero entero'
                        }
                    }
                },
                Capacidad: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        },
                        regexp: {
                            regexp: /[A-Za-z]/,
                            message: 'la entrada debe ser un numero entero'
                        }
                    }
                },
                Añoelab: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        },
                        regexp: {
                            regexp: /[A-Za-z]/,
                            message: 'la entrada debe ser un numero entero'
                        }
                    }
                };
                Tara: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        },
                        regexp: {
                            regexp: /[A-Za-z]/,
                            message: 'la entrada debe ser un numero entero'
                        }
                    }
                };
                Estados: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        },
                        regexp: {
                            regexp: /[A-Za-z]/,
                            message: 'la entrada debe ser un numero entero'
                        }
                    }
                };
                Habilitacion: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        },
                        regexp: {
                            regexp: /[A-Za-z]/,
                            message: 'la entrada debe ser un numero entero'
                        }
                    }
                }
            }
        }).on('success.form.bv', function(e) {
            e.preventDefault();
            // guardar();
        });
        </script>




<!--_____________________________________________________________-->
 <!-- script Datatables -->
 <script>

DataTable($('#tabla_contenedores'))

</script>
