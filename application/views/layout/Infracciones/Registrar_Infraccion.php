<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Acta de Infraccion</h4>
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


 <!---//////////////////////////////////////--- BOX 1---///////////////////////////////////////////////////////----->


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

        <form class="formInfracciones" id="formInfracciones">

        <div class="col-md-6">

            <!--_____________________________________________-->
            <!--Numero-->

                <div class="form-group">
                    <label for="Nombre">N° :</label>
                    <input type="text" class="form-control" id="numero_acta" name="numero_acta" >
                </div>
            <!--_____________________________________________-->
            <!--Descripcion-->

                <div class="form-group">
                    <label for="Apellido">Descripcion:</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion">
                </div>
            <!--_____________________________________________-->
            <!--Generador-->

                <div class="form-group">
                        <label for="TipoInfraccion" >Generador:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="sotr_id" name="sotr_id">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                            foreach ($generador as $i) {
                                echo '<option  value="'.$i->sotr_id.'">'.$i->razon_social.'</option>';
                            }
                        ?>   
                        </select>
                </div>
            
            <!--_____________________________________________--> 
            <!--Transportista-->

            <div class="form-group">
                        <label for="TipoInfraccion">Transportista:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="tran_id" name="tran_id">
                            <option value="" disabled selected>-Seleccione opcion-</option>                            
                        <?php
                            foreach ($transportista as $i) {
                                echo '<option  value="'.$i->tran_id.'">'.$i->razon_social.'</option>';
                            }
                        ?>                      

                            
                        </select>
            </div>
        </div>


        <!--**********************************************-->

        <div class="col-md-6">

            <!--_____________________________________________-->
            <!--Tipo de Infraccion-->
            
                <div class="form-group">
                        <label for="TipoInfraccion">Tipo de Infraccion:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="tipo"  name="tipo">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                            // foreach ($tipoinfraccion as $i) {
                            //     echo '<option  value="'.$i->.'">'.$i->.'</option>';
                            // }
                        ?>   
                        </select>
                </div>
            <!--_____________________________________________-->
            <!--N° Acta-->

                <div class="form-group">
                    <label for="Direccion">N° Acta:</label>
                    <input type="text" class="form-control" id="numero_acta" name="numero_acta">
                </div>
            <!--_____________________________________________-->
            <!--Inspector-->

                <div class="form-group">
                <label for="TipoInfraccion" >Inspector:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="inspector_id" name="inspector_id">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                            // foreach ($inspector as $i) {
                            //     echo '<option  value="'.$i->.'">'.$i->.'</option>';
                            // }
                        ?>   
                        </select>
                </div>

            <!--_____________________________________________--> 
            <!--Destino de acta-->

                <div class="form-group">
                <label for="TipoInfraccion" >Destino de acta:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="destino" name="destino">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                            // foreach ($destino as $i) {
                            //     echo '<option  value="'.$i->.'">'.$i->.'</option>';
                            // }
                        ?>   
                        </select>
                </div>
            

            
            

        </div>

        <!--___________________SEPARADOR__________________________-->

        <div class="col-md-12"><hr> </div>

<!--___________________SEPARADOR__________________________-->

        <!--_____________________________________________-->
        <!--Boton de guardado-->
        <div class="col-md-12">
        <button type="submit" class="btn btn-primary pull-right" onclick="Guardar_Infraccion()">Guardar</button>
        </div>
        </form>
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



            <div class="row"><div class="col-sm-12 table-scroll" id="cargar_tabla">



                </div>
            </div>

<!---//////////////////////////////////////--- FIN BOX 2 DATATABLE---///////////////////////////////////////////////////////----->



 



 


<!---//////////////////////////////////////--- SCRIPTS---///////////////////////////////////////////////////////----->

<!--______________________________--> 
<!--  GUARDAR CIRCUITO -->

<script>

$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Infraccion/Listar_infraccion");

function Guardar_Circuito() {

    var datos = new FormData($('#formInfracciones')[0]);
        datos = formToObject(datos);
        
        // console.table(datos);
        
    

    if ($("#formInfracciones").data('bootstrapValidator').isValid()) {
       
        $.ajax({
            type: "POST",
            data: {
               datos
            },

           
            url: "general/Estructura/Infraccion/Guardar_infraccion",
            success: function(r) {
                console.log(r);
                if (r == "ok") {

                    $("#cargar_tabla").load(
                        "<?php echo base_url(); ?>index.php/general/Estructura/Infraccion/Listar_infraccion");
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
<!--Script Bootstrap Validacion.-->

<script>
      $('#formInfracciones').bootstrapValidator({
      message: 'This value is not valid',
      /*feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },*/
      fields: {
            numero_acta: {
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
            descripcion: {
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
            sotr_id: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            tran_id: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            tipo: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            numero_acta: {
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
            inspector_id: {
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
            destino: {
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
        }
  }).on('success.form.bv', function(e){
      e.preventDefault();
    //   guardar();
  });
</script>





<!--_____________________________________________--> 
<!-- Script Data-Tables-->



<script>
DataTable($('#tabla_infracciones'))
</script>



