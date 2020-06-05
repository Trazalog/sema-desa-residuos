<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Incidencia</h4>
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
        <div>
    
            <button class='btn btn-primary' id="btn_buscar_orden">
                <i class="glyphicon glyphicon-search"></i> Bucar Orden
            </button>

        </div>
        <form class="formIncidencias" id="formIncidencias" method="POST" autocomplete="off" class="registerForm">

            <div class="col-md-6">
                <div class="form-group">
                    <label style="margin-left:10px" for="">Numero de Orden:</label>
                    <div class=" input-group">
                         <input type="text" class="form-control" id="numero_orden" placeholder="Ingrese nro de orden a buscar">
                         
                    </div>
                </div>
                <!--_____________________________________________-->
           
                <div class="form-group">
                    <label for="transportista" >Tipo Residuos:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="in_tica_id" name="tica_id" >
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                    foreach ($residuos as $i) {
                                        echo '<option value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                    }
                                ?>
                        </select>
                </div>
             
            </div>

            <div class="col-md-6">
                    <div class="form-group">
                        <label for="Fecha" name="Fecha">Fecha:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="Fecha">
                        </div>

                    </div>           

                    <div class="form-group">
                            <label for="disp" >Disposicion Final:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="in_disp_final" name="disp" >
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($dispfinal as $j) {
                                            echo '<option value="'.$j->tabl_id.'">'.$j->valor.'</option>';
                                        }
                                    ?>
                                </select>
                    </div>
            
            </div>

            <div class="col-md-12">
                <hr>
            </div>
            <!-- *************** BOX 1.1 *************** -->
            <div class="row">
                <div class="col-md-12">
                </div>
            </div>

             <br>

            <div class="col-md-12">
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="Descripcion" name="Descripcion">Descripcion:</label>
                        <input type="text" class="form-control" id="in_descripcion">
                    </div>

                   
                    <div class="form-group">
                        <label for="Descripcion" name="Descripcion">Fecha:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa  fa-calendar"></i>
                            </div>
                            <input type="date" class="form-control" id="in_fecha">
                        </div>
                    </div>
 
    
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="incidencia" >Tipo Incidencia:</label>
                            <select class="form-control select2 select2-hidden-accesible" id="in_tipoincidencia" name="incidencia" >
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                    foreach ($incidencia as $a) {
                                        echo '<option value="'.$a->tabl_id.'">'.$a->valor.'</option>';
                                    }
                                ?>
                            </select>
                    </div>
                    <div class="form-group">
                        <label for="Descripcion" name="Descripcion">N° Acta:</label>
                        <input type="text" class="form-control" id="in_acta">
                    </div>
    
                </div>
            </div>
            
        </form>
        <div class="col-md-12">
                <hr>
                <button type="submit" class="btn btn-primary pull-right" onclick="GuardarIncidencia()">Guardar</button>
        </div>
       

</div>
</div>
</div>

<!-- *************** FIN BOX 1.1 *************** -->





<!---//////////////////////////////////////---FIN BOX 1---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////---COMIENZO TABLA Y MODAL EDIT ---///////////////////////////////////////////////////////----->

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



    <!---//////////////////////////////////////--- MODAL EDITAR ---//////////////////////////////////////----->

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title titulo" id="exampleModalLabel">Editar Vehiculo</h5>
            </div>

            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL __________________-->

            <form class="formVehiculoEdit" id="formVehiculoEdit"  method="POST" autocomplete="off" class="registerForm">
                <div class="modal-body">
                    <div class="col-md-6 col-sm-6 col-xs-12">
        
                        <!--Descripcion-->
                            <div class="form-group">
                                <label for="descripcion" >Descripcion:</label>
                                <br>
                                <input type="text" class="form-control habilitar" id="e_descripcion" name="descripcion">
                            </div>

                            <div class="form-group"  style="display:none">
                                <input type="text" class="form-control habilitar" id="e_equi_id" >
                            </div>
            ​            <!--_____________________________________________________________-->

                        <!--Dominio-->
                            <div class="form-group">
                                <label for="dominio">Dominio:</label>
                                <br>
                                <input type="text" class="form-control habilitar" id="e_dominio" name="dominio">
                            </div>
            ​            <!--_____________________________________________________________-->

                        <!--Marca-->
                            <div class="form-group">
                                <label for="marca" >Marca:</label>
                                <br>
                                <input type="text" class="form-control habilitar" id="e_marca" name="marca">
                            </div>
            ​            <!--_____________________________________________________________-->

                        <!--Condicion-->
                            <!-- <div class="form-group">
                                <label for="condicion" >Condicion:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="" name="e_condicion" >
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                    // foreach ($condicion as $i) {
                                    //     echo '<option>'.$i->nombre.'</option>';
                                    // }
                                    ?>
                                </select>
                            </div> -->
            ​            <!--_____________________________________________________________-->

                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <!--Ubicacion-->
                        <div class="form-group">
                                <label for="ubicacion">Ubicacion:</label>
                                <input type="text" class="form-control habilitar" id="e_ubicacion" name="ubicacion" >
                            </div>
                        <!--_____________________________________________________________-->   
                        <!--Registro-->
                        <div class="form-group">
                            <label for="codigo" >Codigo:</label>
                            <br>
                            <input type="text" class="form-control habilitar" id="e_codigo" name="codigo" >
                        </div>
            ​           <!--_____________________________________________________________--> 

                         <div class="form-group ocultaTransedit">
                            <label for="tran_id" >Transportista:</label>
                            <select class="form-control select2 select2-hidden-accesible" id="e_tran_id" name="tran_id" >
                                <option value=""  disabled selected  >-seleccione opcion-</option>
                                <?php 
                                                            // foreach ($transportista as $j) { 
                                                            //     echo '<option  value="'.$j->tran_id.'">'.$j->razon_social.'</option>'; 
                                                            // } 
                                ?> 
                            </select>
                        </div> 
                        <div class="form-group textTransinfo" style="display:none"> 
                            <label for="tran_id_info">Transportista:</label> 
                            <br> 
                            <input type="text"  class="form-control" id="tran_id_info"> 
                        </div>
                     

                        <!--Fecha de habilitacion-->
                            <div class="form-group" >
                                <label for="FechaIngreso" >Fecha de Ingreso:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control habilitar" name="" id="id_fecha_ingreso">
                                    <!-- <input type="date" class="form-control pull-right habilitar" id="e_fechaingreso" name="FechaIngreso"> -->
                                </div>
                             
                            </div>
            ​            <!--_____________________________________________________________-->


                    </div>  
                </div>
            </form>

            <!--__________________ FIN FORMULARIO MODAL __________________-->

            </div>
            <div class="col-md-12"><hr></div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btnsave_e">Guardar</button>
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!---//////////////////////////////////////--- FIN MODAL EDITAR ---//////////////////////////////////////----->
<!---//////////////////////////////////////--- MODAL BORRAR ---///////////////////////////////////////////////////////----->
    
<div class="modal fade" id="modalBorrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel"> Eliminar Vehiculo</h5>
            </div>
            <div class="modal-body">

           <input type="text" id="id_vehiculo" style="display:none">

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btndelete" onclick="deletevehiculo()">Aceptar</button>
                    <button type="submit" class="btn btn-default" id="btncancelar" data-dismiss="modal" id="cerrar">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL BORRAR ---///////////////////////////////////////////////////////----->





<!---//////////////////////////////////////---COMIENZO REPORTE---///////////////////////////////////////////////////////----->



<div class="box box-primary">


<div class="box-header with-border">
        <div class="box-tittle">
            <h5>Reporte de Incidencias</h5>
        </div>
</div>
   


<div class="box-body">


            <div class="col-md-12">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="Tipo_incidencia" name="Tipo incidencia">Tipo de incidencia:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="tipo_incidencia">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-4">
                
                    <div class="form-group">
                        <label for="Transportista" name="Transportista">Transportista:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="Transportista">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="Generador" name="Generador">Generador:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                        </select>
                    </div>
                </div>

            </div>


            <div class="col-md-12"><hr></div>
   

 <!--__________________TABLA___________________________-->


        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

        

            <div class="row">


                <!--__________________BOTONES EXPORTACION___________________________-->

                <div class="col-md-12">

                        <div class="dt-buttons btn-group  pull-right">
                            <button class="btn btn-default  buttons-excel buttons-html5" tabindex="0"
                                aria-controls="example2" type="button " aria-label="Left Align"><span>Excel</span></button>
                            <button class="btn btn-default buttons-pdf buttons-html5" tabindex="0" aria-controls="example2"
                                type="button"><span>PDF</span></button>
                            <button class="btn btn-default buttons-print" tabindex="0" aria-controls="example2"
                                type="button"><span>Print</span></button> 
                        </div>

                </div>

                <!--__________________BOTONES EXPORTACION___________________________-->

                <div class="col-md-12"><br></div>

                

                <!--__________________HEADER TABLA___________________________-->

                <div class="col-md-12 table-scroll">

                  

                    <table id="tabla_reportes_incidencia" class="table table-bordered table-striped">
                        
                        <thead class="thead-dark" bgcolor="#eeeeee">

                            
                            <th>Descripcion</th>
                            <th>Tipo de incidencia</th>
                            <th>fecha y hora</th>
                            <th>Inspector</th>
                            <th>Generador</th>
                            <th>Transportista</th>
                            <th>N° Acta</th>
                            

                        
                        </thead>

                        <!--__________________BODY TABLA___________________________-->


                        <tbody id="tablaIncidencia">
                            <tr role="row" class="even" id="primero" hidden>
                             
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                             
                            </tr>

                           
                        </tbody>
                    </table>

                    <!--__________________FIN TABLA___________________________-->

                </div>
            </div>




        </div>  
            <!---//////////////////////////////////////--- FIN BOX 2---///////////////////////////////////////////////////////----->









<!---//////////////////////////////////////--- SCRIPTS ---///////////////////////////////////////////////////////----->

<!--_____________________________________________________________-->
<!-- script modal -->

<script>

// $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Incidencia/ListarIncidencias");

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



<script>


// FUNCION GUARDAR NUEVA INCIDENCIA
        function GuardarIncidencia() {
            var incidencia = new FormData();
            incidencia = formToObject(incidencia);
            incidencia.descripcion = $("#in_descripcion").val();
            incidencia.fecha = $("#in_fecha").val();
            incidencia.num_acta = $("#in_acta").val();
            incidencia.adjunto = "";
            incidencia.usuario_app = "almacen.tools";
            incidencia.tiin_id = $("#in_tipoincidencia").val();
            incidencia.tire_id = $("#in_tica_id").val();
            incidencia.difi_id = $("#in_disp_final").val();
            incidencia.ortr_id = $("#numero_orden").val();
            console.log("datos de incidencia");
            console.log(incidencia);



                $.ajax({
                    type: "POST",
                    data: {incidencia},
                    url: "general/Estructura/Incidencia/guardarIncidencia",
                    success: function(r) {
                        if (r == "ok") {
                            //console.log(datos);
                            $('#formIncidencias')[0].reset();
                            alertify.success("Agregado con exito");
                        } else {
                            console.log(r);
                            $('#formIncidencias')[0].reset();
                            alertify.error("error al agregar");
                        }
                    }
                    
                });

            // });

        }
        </script>

        <!--_____________________________________________________________-->
        <!-- Script Boostrap Validator-->

        <script>
        // $('#formContenedores').bootstrapValidator({
        //     message: 'This value is not valid',
        //     /*feedbackIcons: {
        //         valid: 'glyphicon glyphicon-ok',
        //         invalid: 'glyphicon glyphicon-remove',
        //         validating: 'glyphicon glyphicon-refresh'
        //     },*/
        //     fields: {
        //         Codigo_registro: {
        //             message: 'la entrada no es valida',
        //             validators: {
        //                 notEmpty: {
        //                     message: 'la entrada no puede ser vacia'
        //                 },
        //                 regexp: {
        //                     regexp: /[A-Za-z]/,
        //                     message: 'la entrada debe ser un numero entero'
        //                 }
        //             }
        //         },
        //         Descripcion: {
        //             message: 'la entrada no es valida',
        //             validators: {
        //                 notEmpty: {
        //                     message: 'la entrada no puede ser vacia'
        //                 },
        //                 regexp: {
        //                     regexp: /[A-Za-z]/,
        //                     message: 'la entrada debe ser un numero entero'
        //                 }
        //             }
        //         },
        //         Capacidad: {
        //             message: 'la entrada no es valida',
        //             validators: {
        //                 notEmpty: {
        //                     message: 'la entrada no puede ser vacia'
        //                 }
        //             }
        //         },
        //         Descripcion: {
        //             message: 'la entrada no es valida',
        //             validators: {
        //                 notEmpty: {
        //                     message: 'la entrada no puede ser vacia'
        //                 }
        //             }
        //         };
        //         Añoelab: {
        //             message: 'la entrada no es valida',
        //             validators: {
        //                 notEmpty: {
        //                     message: 'la entrada no puede ser vacia'
        //                 }
        //             }
        //         };
        //         Tara: {
        //             message: 'la entrada no es valida',
        //             validators: {
        //                 notEmpty: {
        //                     message: 'la entrada no puede ser vacia'
        //                 }
        //             }
        //         };
        //         Estados: {
        //             message: 'la entrada no es valida',
        //             validators: {
        //                 notEmpty: {
        //                     message: 'la entrada no puede ser vacia'
        //                 }
        //             }
        //         };
        //         Habilitacion: {
        //             message: 'la entrada no es valida',
        //             validators: {
        //                 notEmpty: {
        //                     message: 'la entrada no puede ser vacia'
        //                 }
        //             }
        //         }
        //     }
        // }).on('success.form.bv', function(e) {
        //     e.preventDefault();
        //      guardar();
        // });
        </script>

<script>
$("#btn_buscar_orden").click(function(e){

alert("click en buscar");
var nroOrden = $("#numero_orden").val();
console.table(nroOrden);
$("#disposicion_final").val("adifhafhadkf");
$.ajax({
                    type: "POST",
                    data: {nroOrden},
                    url: "general/Estructura/Incidencia/obtenerOt",
                    success: function($dato) {
                        console.log($dato);
                       
                        if($dato != '{"orden":null}'){
                            console.log(JSON.parse($dato));
                            console.log(JSON.parse($dato).orden[0].chof_id);
                            var res = JSON.parse($dato);
                            console.table("correcto");
                            alertify.success("Orden de Trabajo encotrada");
                            $("#Fecha").val(res.orden[0].fec_retiro);
                        
                        }else{
                          
                            alertify.error("Error! No existe la orden de trabajo");
                        }
                       
                        
                    }
                    
                });

});

</script>

<!--_____________________________________________________________-->
<!-- script Datatables -->


<script>
    
    DataTable($('#tabla_incidencias'))

    DataTable($('#tabla_reportes_incidencia'))

    

</script>

        <!---//////////////////////////////////////---DATA TABLES SCRIPT---///////////////////////////////////////////////////////----->






        <!-- <script>
            $(document).ready(function() {
                var table = $('#example1').DataTable({
                    fixedHeader: true,
                    colReorder: true
                });
            });
            </script>

            <script>
            $(document).ready(function() {
                $('#example1').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'print',
                            text: 'Print all',
                            exportOptions: {
                                modifier: {
                                    selected: null
                                }
                            }
                        },
                        {
                            extend: 'print',
                            text: 'Print selected'
                        }
                    ],
                    select: true
                });
            });
            </script> -->

        <!---//////////////////////////////////////---DATA TABLES SCRIPT---///////////////////////////////////////////////////////----->