<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Orden de Transporte</h4>
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

    <!--___________________BOX BODY__________________________-->

    <div class="box-body">

        <div class="col-md-12 col-sm-12 col-xs-12"><br></div>

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-primary animated fadeInLeft">
                            <div class="box-header with-border">
                                <h4>Transportistas</h4>
                            </div>
                        </div>
                    </div>

                    <form class="formTransportista" id="formTransportista">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        
                            <div class="col-md-6">
                                <!--_______________________-->
                                <!--Empresa-->
                                <div class="form-group">
                                    <label for="selecemp" class="form-label">Empresa:</label>
                                    <select multiple="" class="form-control" id="selecemp" name="empresa">
                                        <?php
                                        // foreach ($empresa as $i) {
                                        //     echo '<option class="emp" data-json=\''.json_encode($i).'\'>'.$i->nom->nom_emp.'</option>';
                                        // }
                                        ?>
                                    </select>
                                </div>
                                <!--_______________________-->
                                <!--Numero Registro-->
                                <div class="form-group">
                                    <label for="registron" class="form-label">Registro n°:</label>
                                    <input type="text" name="registron" id="registron" readonly class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!--_______________________-->
                                <!--movilidad-->
                                <div class="form-group">
                                    <label for="selecmov">Movilidad:</label>
                                    <select multiple="" class="form-control" id="selecmov">
                                    <?php
                                        // foreach ($vehiculo as $i) {
                                        //     echo '<option class="emp" data-json=\''.json_encode($i).'\'>'.$i->nom->nom_emp.'</option>';
                                        // }
                                        ?>
                                    </select>
                                </div>
                                <!--_______________________-->
                                <!--Dominio-->
                                <div class="form-group">
                                    <label for="dominio" class="form-label">Dominio:</label>
                                    <input type="text" name="dominio" id="dominio" readonly class="form-control">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <hr>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <!--_______________________-->
                                <!--Dominio-->

                                <div class="form-group">
                                    <label for="chofer" class="form-label">Chofer:</label>
                                    <select class="form-control select2 select2-hidden-accesible" id="chofer">
                                        <option value="" disabled selected>-Seleccione opcion-</option>
                                        <?php
                                        // foreach ($Chofer as $i) {
                                        //     echo '<option  value="'.$i->chof_id.'">'.$i->nombre.'</option>';
                                        // }
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">

                            
                                <div class="form-group">                            
                                <label for="">Fecha y Hora <strong style="color: #dd4b39"></strong>:</label>                        
                                
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    <input type="text" name="fecha" id="fecha" class="form-control" />
                                    </div> 
                                </div>
                            
                            </div>
                        </form>
                    </div>

                </div>

            </div>    
            
        <div class="col-md-12 col-sm-12 col-xs-12"><br></div>
           

            <!--**********************************************-->

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
            

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-primary animated fadeInLeft">
                            <div class="box-header with-border">
                                <h4>Datos</h4>
                            </div>
                        </div>
                    </div>

                    <form class="formOrden" id="formOrden" name="formOrden">

                        <div class="col-md-12 col-sm-12 col-xs-12">     
                            <!--_______________________-->
                            <!--Numero-->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="Nro" class="form-label">Nro:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="glyphicon glyphicon-check"></i>
                                        </div>
                                        <input type="text" name="nro" id="Nro" value="<?php //if($=='' ){echo 'value="'.$->.'"';}?>"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <!--_______________________-->
                            <!--Fecha-->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="fecha" class="form-label">Fecha:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="glyphicon glyphicon-check"></i>
                                        </div>
                                        <input type="date" id="fecha" value="<?php //echo $fecha;?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="col-md-6 col-sm-6 col-xs-12"></div>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <!--_______________________-->
                                <!--Disposicion Final-->
                                <div class="form-group">
                                    <label for="dispfinal" class="form-label">Disposicion final:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="glyphicon glyphicon-check"></i>
                                        </div>
                                        <select class="form-control" id="dispfinal">
                                            <option value="" disabled selected>-Seleccione opcion-</option>
                                            <?php
                                        // foreach ($disposicionFinal as $i) {
                                        //     echo '<option>'.$i->nombre.'</option>';
                                        // }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>

            <!--_______________________-->

            <div class="col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>

            <!--_______________________-->
            <div class="col-md-12 col-sm-12 col-xs-12">
            
                
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <!--_______________________-->
                        <!--Tipo residuo-->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="tipores" class="form-label">Tipo residuo:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-check"></i>
                                    </div>
                                    <select class="form-control select2 select2-hidden-accesible" id="tipores"
                                        name="tipo_residuo" required>
                                        <option value="" disabled selected>-Seleccione opcion-</option>
                                        <?php
                                        foreach ($Tiporesiduo as $i) {
                                            echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!--_______________________-->
                            <!--Porcentaje llenado-->
                            <div class="form-group">
                                <label for="porcentajell" class="form-label">% de llenado:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-check"></i>
                                    </div>
                                    <input type="number" step="0.0001" id="porcentajell" name="porcent_llenado"
                                        class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6  col-sm-6 col-xs-12">
                            <!--_______________________-->
                            <!--Contenedor-->
                            <div class="form-group">
                                <label for="contenedor" class="form-label">Contenedor:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-check"></i>
                                    </div>
                                    <input type="number" id="contenedor" name="contenedor" class="form-control" required>
                                </div>
                            </div>
                            <!--_______________________-->
                            <!--Metros cubicos-->
                            <div class="form-group">
                                <label for="metroscubicos" class="form-label">Metros cubicos:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-check"></i>
                                    </div>
                                    <input type="number" step="0.0001" name="metroscubicos" class="form-control"
                                        id="metroscubicos" min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--_______________________-->

            <div class="col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>

            <!--_______________________-->

            <div class="row">

                <!--_______________________-->
                <!--BOTON AGREGAR-->

                <div class="col-md-10 col-lg-11 col-xs-12"></div>
                <div class="col-md-2 col-lg-1 col-xs-12 text-center">
                    <div class="form-group">
                        <button class="btn btn-primary btn-circle" onclick="Agregar_Residuo()" aria-label="Left Align">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <small for="agregar" class="form-label">Agregar</small>
                    </div>

                </div>
            </div>

            <!--_______________________-->

            <div class="col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>

            <!--_______________________-->

            </form>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-primary pull-right"
                    onclick="Guardar_Orden_transporte()">Guardar</button>
            </div>
        </div>

        
        


            <!--____________________________TABLA RESIDUOS____________________________-->

            <div class="row">
                <div class="box box-primary" id="box-tabla" style="display:none">
                    <div class="box-body table-responsive">
                        <table class="table table-striped" id="contenedores">
                            <thead>
                                <th>Tipo residuo</th>
                                <th>Contenedor</th>
                                <th>% llenado</th>
                                <th>Metros cubicos</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            
         

        <!--____________________________-->
        <!--Boton de guardado-->

      
           


       
         
    </div>

    <!--___________________FIN BOX BODY__________________________-->



</div>


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




<!---//////////////////////////////////////--- SCRIPT---///////////////////////////////////////////////////////----->


<!--_____________________________________________________________-->
<!-- REGISTRAR Orden Transporte-->


<script>
function Agregar_Residuo() {

    $('#puntos_criticos').show();

    var data = new FormData($('#formPuntos')[0]);
    data = formToObject(data);

    $('#datos tbody').append(
        `<tr data-json='${JSON.stringify(data)}'>       
            <td>${data.nombre}</td>
            <td>${data.descripcion}</td>
            <td>${data.lat}</td>
            <td>${data.lng}</td>            
        </tr>`
    );

    $('#formPuntos')[0].reset();
    $('select').select2().trigger('change');
}


//<!--______________________________--> 
//<!-- SCRIPT GUARDAR CIRCUITO -->


$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/OrdenTransporte/lista_orden_transporte");

function Guardar_Orden() {

    // datos = $('#formCircuitos').serialize();

    var datos = new FormData($('#formCircuitos')[0]);
    datos = formToObject(datos);
    // datos.imagen = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN";
    datos.usuario_app = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario
    console.log(datos);




    //--------------------------------------------------------------

    if ($("#formCircuitos").data('bootstrapValidator').isValid()) {
        $.ajax({
            type: "POST",
            data: {
                datos
            },
            url: "general/Estructura/Zona/Guardar_Circuito",
            success: function(r) {
                console.log(r);
                if (r == "ok") {

                    $("#cargar_tabla").load(
                        "<?php echo base_url(); ?>index.php/general/Estructura/OrdenTransporte/lista_orden_transporte"
                    );
                    alertify.success("Agregado con exito");

                    $('#formCircuitos').data('bootstrapValidator').resetForm();
                    $("#formCircuitos")[0].reset();


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
<!-- Script para mostrar por empresa las movilidades y choferes disponibles y por movilidad su respectiva informacion -->
<script>
$(".emp").on('click', function() {

    var json = this.dataset.json;

    json = JSON.parse(json);

    var html_mov = " ",
        html_chof = "";

    json.movilidades.movilidad.forEach(function(valor) {
        html_mov += "<option class='movilito' data-reg='" + valor.registro + "' data-dom='" + valor
            .dominio + "'>" + valor.nom_movil + "</option>"
    });

    json.choferes.chofer.forEach(function(valor) {
        html_chof += "<option class='chof'>" + valor.nom_chofer + "</option>"
    });

    $('#selecmov').html(html_mov);
    $("#chofer").html("<option value='' disabled selected>-Seleccione opcion-</option>" + html_chof);

    $("#registron").val("");
    $("#dominio").val("");
});

$("#selecmov").on('change', function() {

    var sel = $(this).find(":selected");
    $("#registron").val(sel.data('reg'));
    $("#dominio").val(sel.data('dom'));

});
</script>

<!--_____________________________________________________________-->
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
                    regexp: /^[a-zA-Z0-9_]*$/,
                    message: 'la entrada no debe ser un numero entero'
                }
            }
        },
        descripcion: {
            message: 'la entrada no es valida',
            validators: {
                notEmpty: {
                    message: 'la entrada no puede ser vacia'
                },
            }
        },
        fec_alta: {
            message: 'la entrada no es valida',
            validators: {
                notEmpty: {
                    message: 'la entrada no puede ser vacia'
                },
            }
        },
        reci_id: {
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
        anio_elaboracion: {
            message: 'la entrada no es valida',
            validators: {
                notEmpty: {
                    message: 'la entrada no puede ser vacia'
                },

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
                },
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
                },
            }
        },
    }
}).on('success.form.bv', function(e) {
    e.preventDefault();
    //guardar();
});
</script>

<!-- Script Agregar datos -->

<script>
function guardar() {

    datos = $('#formDatos').serialize();

    //datos para mostrar a modo de ejemplo para DEMO---------------
    //Serialize the Form
    var values = {};
    $.each($("#formDatos").serializeArray(), function(i, field) {
        values[field.name] = field.value;
    });
    //Value Retrieval Function
    var getValue = function(valueName) {
        return values[valueName];
    };
    //Retrieve the Values
    var tipo_residuo = getValue("tipo_residuo");
    var contenedor = getValue("contenedor");
    var porcent_llenado = getValue("porcent_llenado");
    var metroscubicos = getValue("metroscubicos");
    //--------------------------------------------------------------

    if ($("#formDatos").data('bootstrapValidator').isValid()) {

        $.ajax({
            type: "POST",
            data: datos,
            url: "ajax/Ordentrabajo/guardarResiduo",
            success: function(r) {
                if (r == "ok") {
                    //console.log(datos);
                    html = '<tr role="row" class="even"><td>' + tipo_residuo + '</td><td>' + contenedor +
                        '</td><td>' + porcent_llenado + '</td><td>' + metroscubicos + '</td></tr>';
                    $('#primero').after(html);
                    $('#formDatos').data('bootstrapValidator').resetForm(true);
                    alertify.success("Agregado con exito");
                } else {
                    //console.log(r);
                    alertify.error("error al agregar");
                }
            }
        });
    }
}
</script>


<!-- Script Agregar Residuo -->

<script>
function agregarResiduo() {

    $('#formResiduo').on('submit', function(e) {
        //console.log("aloha madrefoca");
        e.preventDefault();
        var me = $(this);
        if (me.data('requestRunning')) {
            return;
        }
        me.data('requestRunning', true);

        datos = $('#formResiduo').serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "ajax/Ordentrabajo/guardarResiduo",
            success: function(r) {
                if (r == "ok") {
                    console.log(r);
                    $('#formResiduo')[0].reset();
                    alertify.success("Agregado con exito");
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
 <!-- script Fecha-->

 <script>
$('#fecha').daterangepicker({
    "autoApply": true,
    "singleDatePicker": true,
    "timePicker": true,
    "toggleActive":false,
    "todayHighlight":false,    
    "locale": {
              "format":'YYYY/MM/DD h:mm:ss',
              "applyLabel": "Aplicar",
              "cancelLabel": "Cancelar"
              //format: 'MM/DD/YYYY h:mm:ss'
            }
    }, function(start, end, label) {
      console.log('New date range selected: ' + start.format('YYYY-MM-DD hh:mm:ss') + ' to ' + end.format('YYYY-MM-DD hh:mm:ss') + ' (predefined range: ' + label + ')');
});

</script>