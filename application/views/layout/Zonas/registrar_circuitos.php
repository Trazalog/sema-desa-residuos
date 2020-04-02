<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Circuitos</h4>
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
        <div class="box-tools pull-right border ">
            <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                data-toggle="tooltip" title="" data-original-title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <!--_____________________________________________-->

    <div class="box-body">
        <form class="formCircuitos" id="formCircuitos">
            <!--_____________________________________________-->
            <!--Codigo-->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="Codigo">Codigo:</label>
                    <div class="input-group date">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                        <input type="number" class="form-control" name="codigo" id="codigo" required>
                    </div>
                </div>
            </div>
            <!--_____________________________________________-->
            <!--Tipo de residuo-->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="tipoResiduos">Tipo de residuo:</label>
                    <div class="input-group date">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                        <select class="form-control select3" multiple="multiple"  data-placeholder="Seleccione tipo residuo"  style="width: 100%;"  id="tica_id">
                            
                            <?php
                                foreach ($tipoResiduos as $i) {
                                    

                                    echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                }
                            ?>
                        </select>


              
            
                    </div>
                </div>
            </div>
            <!--_____________________________________________-->
            <!--Descripcion-->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="Descripcion">Descripcion:</label>
                    <textarea style="resize: none;" type="text" class="form-control" name="descripcion"
                        id="descripcion"></textarea>
                </div>
            </div>
            <!--_____________________________________________-->
            <!--vehiculo-->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="Vehiculo">Vehiculo:</label>
                    <div class="input-group date">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                        <select class="form-control select2 select2-hidden-accesible" name="vehi_id" id="vehi_id">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                foreach ($Vehiculo as $i) {
                                echo '<option  value="'.$i->equi_id.'">'.$i->dominio.'</option>';                         
                                
                                }
                        ?>
                        </select>
                    </div>
                </div>
            </div>
            <!--_____________________________________________-->

            <!--Chofer-->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="Chofer">Chofer:</label>
                    <div class="input-group date">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                        <select class="form-control select2 select2-hidden-accesible" name="chof_id" id="chof_id">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                        foreach ($Chofer as $i) {
                            echo '<option  value="'.$i->chof_id.'">'.$i->nombre." ".$i->apellido.'</option>';
                        }
                        ?>
                        
                        </select>

          
                    </div>
                </div>
            </div>
            <!--_____________________________________________-->

            <!--_________________SEPARADOR_________________-->

            <div class="col-md-12">
                <hr>
            </div>

            <!--_________________SEPARADOR_________________-->

            <!--Adjuntador de imagenes-->
            <div class="col-md-12">
                <div class="col-md-6 col-sm-6 col-xs-12">


                    <form action="cargar_archivo" method="post" enctype="multipart/form-data">
                        <input type="file" name="imagen">
                    </form>

                </div>




            </div>
        </form>



        <div class="col-md-12 col-sm-12 col-xs-12"> <br> <br></div>


        <!---//////////////////////////////////////--- REGISTRAR PUNTO CRITICO ---///////////////////////////////////////////////////////----->

        <div class="row">



            <div class="col-md-12 col-sm-12 col-xs-12">


                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h4>Registrar Punto Critico</h4>
                    </div>
                </div>
            </div>

        </div>





        <div class="col-md-12 col-sm-12 col-xs-12">

            <form class="formPuntos" id="formPuntos">

                <!--_____________________________________________-->
                <!--Descripcion-->

                <div class="col-md-5 col-sm-5 col-xs-12">
                    <div class="form-group">

                        <label for="Codigo">Nombre:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                            <input type="text" class="form-control" name="nombre" id="nombre" >
                        </div>
                    </div>
                </div>

                <!--_____________________________________________-->
                <!--Descripcion-->

                <div class="col-md-5 col-sm-5 col-xs-12">
                    <div class="form-group">

                        <label for="Codigo">Descripcion:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" >
                        </div>
                    </div>
                </div>

                <!--_____________________________________________-->
                <!--Descripcion-->

                <div class="col-md-5 col-sm-5 col-xs-12">
                    <div class="form-group">
                        <label for="Codigo">Latitud:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                            <input type="text" class="form-control" name="lat" id="lat" >
                        </div>
                    </div>
                </div>

                <!--_____________________________________________-->
                <!--Descripcion-->

                <div class="col-md-5 col-sm-5 col-xs-12">
                    <div class="form-group">

                        <label for="Codigo">Longitud:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                            <input type="text" class="form-control" name="lng" id="lng" >
                        </div>
                    </div>
                </div>



                <div class="col-md-2 col-sm-2 col-xs-12">

                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="form-group ">
                            <small for="agregar" class="form-label">MAPA</small>
                            <button type="button" class="btn btn-primary btn-circle" data-toggle="modal"
                                data-target="#modalmapa" aria-label="Left Align">
                                <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                            </button>
                        </div>

                    </div>

                </div>

            </form>

            <!--_________________SEPARADOR_________________-->

            <div class="col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>

            <!--_________________SEPARADOR_________________-->

            <div class="col-md-12">
                <button type="submit" class="btn btn-default pull-right" onclick="Agregar_punto()">AGREGAR</button>
            </div>

            <!--_________________SEPARADOR_________________-->

            <div class="col-md-12 col-sm-12 col-xs-12"> <br></div>

            <!--_________________SEPARADOR_________________-->


        </div>


        <div class="col-md-12 col-sm-12 col-xs-12"> <br></div>


        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box " id="puntos_criticos" style="display:none">
                <div class="box-body table-responsive">
                    <!--__________________HEADER TABLA___________________________-->
                    <table class="table table-striped" id="datos">
                        <thead class="thead-dark" bgcolor="#eeeeee">


                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Latitud</th>
                            <th>Longitud</th>


                        </thead>

                        <!--__________________BODY TABLA___________________________-->

                        <tbody>
                            
                        </tbody>
                    </table>

                    <!--__________________FIN TABLA___________________________-->
                </div>

            </div>

        </div>

        <!--_________________SEPARADOR_________________-->

        <div class="col-md-12 col-sm-12 col-xs-12">
            <hr>
        </div>

        <!--_________________SEPARADOR_________________-->


        <!--_________________ GUARDAR_________________-->

        <div class="col-md-12">
            <button type="submit" class="btn btn-primary pull-right" onclick="Guardar_Circuito()">GUARDAR</button>
        </div>




    </div>


</div>









</div>



</div>



<!---//////////////////////////////////////--- FIN BOX 1---///////////////////////////////////////////////////////----->



<!---//////////////////////////////////////---BOX 2 DATATBLE ---///////////////////////////////////////////////////////----->



    <div class="box box-primary">


    <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>

            <!--__________________TABLA___________________________-->

            <div class="row">
                <div class="col-sm-12 table-scroll" id="cargar_tabla"></div>

                <!--__________________TABLA___________________________-->



            </div>
        </div>
    </div>

    <!---//////////////////////////////////////--- FIN BOX 2 DATATABLE---///////////////////////////////////////////////////////----->

    <!---//////////////////////////////////////--- MODAL MAPA ---///////////////////////////////////////////////////////----->


    <div class="modal fade" id="modalmapa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLabel">MAPA - Puntos criticos</h5>
                </div>


                <div class="modal-body">

                    <!--__________________ FORMULARIO MODAL ___________________________-->

                    <form method="POST" autocomplete="off" id="" class="registerForm">


                        <div class="modal-body">



                            <div class="row">

                                <div class="col-md-12 ">






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


    <!---//////////////////////////////////////--- FIN MODAL MAPA ---///////////////////////////////////////////////////////----->






    <!---//////////////////////////////////////--- SCRIPTS ---///////////////////////////////////////////////////////----->

    
    
    <!--______________________________-->
    <!-- SCRIPT AGREGAR PUNTO CRITICO -->

 




    <script>
    function Agregar_punto() {

        $('#puntos_criticos').show();

        var data = new FormData($('#formPuntos')[0]);
        data = formToObject(data);

        var table = $('#datos').DataTable();

        var row =  `<tr data-json='${JSON.stringify(data)}'> 
             <td>${data.nombre}</td>
             <td>${data.descripcion}</td>
             <td>${data.lat}</td>
             <td>${data.lng}</td>            
         </tr>`;
 
        table.row.add($(row)).draw();       
		
        $('#formPuntos')[0].reset();
        
        
        
    }



</script>
<script>

		
    //<!--______________________________--> 
    //<!--  GUARDAR CIRCUITO -->


    $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Zona/Listar_Circuitos");

    function Guardar_Circuito() {

    //---------------------- Tipo de Carga----------------------------------------------

     var datos_tipo_carga= $('#tica_id').val();   
       
       

    //---------------------- Formulario Circuito ----------------------------------------


        var datos_circuito = new FormData($('#formCircuitos')[0]);
        datos_circuito = formToObject(datos_circuito);

       
    //---------------------- Formulario Puntos Criticos ----------------------------------------

        var datos_puntos_criticos = [];
        
        var rows = $('#datos tbody tr');
        
        // $('#datos').each(function() {
            rows.each(function(i,e) {    
                
                
                datos_puntos_criticos.push(getJson(e));
            });

            console.table(datos_puntos_criticos);

            if (datos_puntos_criticos.lenght==0) {
                alert('Sin Datos para Registrar.');
                return;
            }


        
        //--------------------------------------------------------------
        

        

        if ($("#formCircuitos").data('bootstrapValidator').isValid()) {
           
            $.ajax({
                type: "POST",
                data: {
                    datos_circuito, datos_puntos_criticos,datos_tipo_carga
                },

               
                url: "general/Estructura/Zona/Guardar_Circuito",
                success: function(r) {
                    console.log(r);
                    if (r == "ok") {

                        $("#cargar_tabla").load(
                            "<?php echo base_url(); ?>index.php/general/Estructura/Zona/Lista_Circuitos"
                        );
                        alertify.success("Agregado con exito");

                        $('#formCircuitos').data('bootstrapValidator').resetForm();
                        $("#formCircuitos")[0].reset();


                        $("#boxDatos").hide(500);
                        $("#botonAgregar").removeAttr("disabled");

                    } else {
                        console.log(r);
                        alertify.error("error al agregar");
                    }
                }
            });





        }
    }
    </script>


    <!--_____________________________________________-->
    <!-- script que muestra box de datos al dar click en boton agregar -->

    <script>
    $("#botonAgregar").on("click", function() {
        
        $("#botonAgregar").attr("disabled", "");
        //$("#boxDatos").removeAttr("hidden");
        $("#boxDatos").focus();
        $("#boxDatos").show();

    });
   
    $("#btnclose").on("click", function() {
        $("#boxDatos").hide(500);
        $("#botonAgregar").removeAttr("disabled");
        // $('#formDatos').data('bootstrapValidator').resetForm();
        $("#formDatos")[0].reset();
        

    });
    </script>


    <!--_____________________________________________-->
    <!-- Validator Circuitos.-->
    <script>
    $('#formCircuitos').bootstrapValidator({
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
            },
            descripcion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }

                }
            },
            vehi_id: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            chof_id: {
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
        guardar();
    });
    </script>


    <!--_____________________________________________-->
    <!--Validator Puntos criticos.-->
    <script>
    $('#formPuntos').bootstrapValidator({
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
            lat: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            lng: {
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
        guardar();
    });
    </script>


    <!--_____________________________________________-->


    <script>
    //Initialize DATATABLE
    DataTable($('#datos'))

    </script>

    <!--_____________________________________________-->

    <script>
  
    //Initialize Select multiple
    $('.select3').select2();

    </script>


     <!--_____________________________________________-->