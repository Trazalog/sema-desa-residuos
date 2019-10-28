<!--  Box 1-->
<div class="box box-primary animated fadeInLeft">
<div class="box-header with-border">
        <div class="box-tittle">
            <h3>orden de Transporte</h3>  
        </div>
    </div>
    <div class="box-body">
        <br>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="Nro" class="form-label">Nro:</label>
                    <input type="text" name="nro" id="Nro" value="<?php echo rand(1,30);?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="fecha" class="form-label">Fecha:</label>
                    <input type="date" id="fecha" value="<?php echo $fecha;?>" class="form-control">
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="Nro de solicitud" class="form-label">Nro de solicitud:</label>
                    <input type="text" name="nrosolicitud" id="Nro de solicitud" class="form-control">
                </div>
                <div class="form-group">
                    <label for="dispfinal" class="form-label">Disposicion final:</label>
                    <select class="form-control" id="dispfinal">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                                            foreach ($disposicionFinal as $i) {
                                                echo '<option>'.$i->nombre.'</option>';
                                            }
                                    ?>
                    </select>
                </div>
            </div>
        </div>

        <br>
        <hr>
        <br>

        <form autocomplete="off" id="formDatos" method="POST">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="tipores" class="form-label">Tipo residuo:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="tipores" name="tipo_residuo"
                            required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                                    foreach ($tipoResiduo as $i) {
                                                        echo '<option>'.$i->nombre.'</option>';
                                                    }
                                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="porcentajell" class="form-label">% de llenado:</label>
                        <input type="number" step="0.0001" id="porcentajell" name="porcent_llenado" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="contenedor" class="form-label">Contenedor:</label>
                        <input type="number" id="contenedor" name="contenedor" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="metroscubicos" class="form-label">Metros cubicos:</label>
                        <input type="number" step="0.0001" name="metroscubicos" class="form-control" id="metroscubicos"
                            min="0" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-10 col-lg-11 col-xs-12"></div>
                <div class="col-md-2 col-lg-1 col-xs-12 text-center">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-circle" aria-label="Left Align">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button><br>
                        <small for="agregar" class="form-label">Agregar</small>
                    </div>
                </div>
            </div>
        </form>

<!--SPARADOR-->
        <br>
        <hr>
        <br>
<!--SPARADOR-->
        
        <div class="row">
            <em class="fas fa-ad"></em>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-12">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 table-scroll">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
                                aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Tipo de
                                            residuo</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending">
                                            Contenedor</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Platform(s): activate to sort column ascending">% de
                                            llenado</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Engine version: activate to sort column ascending">
                                            Metros cubicos</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr role="row" class="even" id="primero">
                                        <td>residuo radioactivo</td>
                                        <td>3</td>
                                        <td>23</td>
                                        <td>1.5</td>
                                    </tr>

                                </tbody>

                            </table><br>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>

        <br>
        <hr>


        <div class="row">
            <div class="box-header with-border">
            <div class="box-header with-border">
        <div class="box-tittle">
            <h3>Registrar Generadores</h3> </div>
         </div>
            </div>
            <br>
            <div class="col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="razonsocial" class="form-label">Razon social:</label>
                    <input type="text" name="rsocial" id="razonsocial" readonly class="form-control">
                </div>
                <div class="form-group">
                    <label for="cuitdni" class="form-label">Cuit/dni:</label>
                    <input type="text" name="cuitdni" id="cuitdni" readonly class="form-control">
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="dep" class="form-label">Departamento:</label>
                    <input type="text" name="departamento" id="dep" readonly class="form-control">
                </div>
                <div class="form-group">
                    <label for="circuito" class="form-label">Circuito:</label>
                    <input type="text" name="circuito" id="circuito" readonly class="form-control">
                </div>
            </div>
        </div>

        <br>
        <hr>

        <div class="row">
            <div class="box-header with-border">
                <h3>Transportistas</h3>
            </div>
            <br>
            <div class="col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="selecemp" class="form-label">Empresa:</label>
                    <select multiple="" class="form-control" id="selecemp" name="empresa">
                            <?php
                                                    foreach ($empresa as $i) {
                                                        echo '<option class="emp" data-json=\''.json_encode($i).'\'>'.$i->nom->nom_emp.'</option>';
                                                    }
                                                ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="registron" class="form-label">Registro n°:</label>
                    <input type="text" name="registron" id="registron" readonly class="form-control">
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="selecmov">Movilidad:</label>
                    <select multiple="" class="form-control" id="selecmov">
                    </select>
                </div>
                <div class="form-group">
                    <label for="dominio" class="form-label">Dominio:</label>
                    <input type="text" name="dominio" id="dominio" readonly class="form-control">
                </div>
            </div>
        </div>

        <br>
        <hr>
        <br>

        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="chofer" class="form-label">Chofer:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="chofer">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fecha" class="form-label">Fecha de retiro:</label>
                    <input type="date" id="fecha" value="<?php echo $fecha;?>" class="form-control">
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="hora" class="form-label">Hora:</label>
                    <input type="number" id="hora" value="1" class="form-control" min="1">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para mostrar por empresa las movilidades y choferes disponibles y por movilidad su respectiva informacion -->
<script>
    $(".emp").on('click', function () {

        var json = this.dataset.json;

        json = JSON.parse(json);

        var html_mov = " ", html_chof = "";

        json.movilidades.movilidad.forEach(function (valor) {
            html_mov += "<option class='movilito' data-reg='" + valor.registro + "' data-dom='" + valor.dominio + "'>" + valor.nom_movil + "</option>"
        });

        json.choferes.chofer.forEach(function (valor) {
            html_chof += "<option class='chof'>" + valor.nom_chofer + "</option>"
        });

        $('#selecmov').html(html_mov);
        $("#chofer").html("<option value='' disabled selected>-Seleccione opcion-</option>" + html_chof);

        $("#registron").val("");
        $("#dominio").val("");
    });

    $("#selecmov").on('change', function () {

        var sel = $(this).find(":selected");
        $("#registron").val(sel.data('reg'));
        $("#dominio").val(sel.data('dom'));

    });
</script>

<!-- script bootstrap validator -->

<script>

    $('#formDatos').bootstrapValidator({
        message: 'This value is not valid',
        /*feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        fields: {
            contenedor: {
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
                        message: 'la entrada debe ser un numero natural'
                    }
                }
            },
            tipo_residuo: {
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
            porcent_llenado: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[+]?[0-9]*\.?[0-9]*/,
                        message: 'la entrada debe ser un numero entero o flotante'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            },
            metroscubicos: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[+]?[0-9]*\.?[0-9]*/,
                        message: 'la entrada debe ser un numero entero o flotante'
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
        guardar();
    });

</script>

<!-- Script Agregar datos -->

<script>

    function guardar() {

        datos = $('#formDatos').serialize();

        //datos para mostrar a modo de ejemplo para DEMO---------------
        //Serialize the Form
        var values = {};
        $.each($("#formDatos").serializeArray(), function (i, field) {
            values[field.name] = field.value;
        });
        //Value Retrieval Function
        var getValue = function (valueName) {
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
                success: function (r) {
                    if (r == "ok") {
                        //console.log(datos);
                        html = '<tr role="row" class="even"><td>' + tipo_residuo + '</td><td>' + contenedor + '</td><td>' + porcent_llenado + '</td><td>' + metroscubicos + '</td></tr>';
                        $('#primero').after(html);
                        $('#formDatos').data('bootstrapValidator').resetForm(true);
                        alertify.success("Agregado con exito");
                    }
                    else {
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

        $('#formResiduo').on('submit', function (e) {
            //console.log("aloha madrefoca");
            e.preventDefault();
            var me = $(this);
            if (me.data('requestRunning')) { return; }
            me.data('requestRunning', true);

            datos = $('#formResiduo').serialize();
            $.ajax({
                type: "POST",
                data: datos,
                url: "ajax/Ordentrabajo/guardarResiduo",
                success: function (r) {
                    if (r == "ok") {
                        console.log(r);
                        $('#formResiduo')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                },
                complete: function () {
                    me.data('requestRunning', false);
                }
            });

        });

    }
</script>

 <script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'autoFill'    : true,
      'buttons'     :true,
      'fixedHeader': true,
        dom: 'Bfrtip',
        buttons: [
             'excel', 'pdf', 'print'
        ]
    })
  })
</script>

