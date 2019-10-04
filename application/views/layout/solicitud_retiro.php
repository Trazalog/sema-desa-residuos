<!--  Box 1-->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h3>Template solicitud de retiro</h3>
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
<!-- box 2 -->
<div class="box box-primary animated bounceInDown" id="boxDatos" hidden>
    <div class="box-header with-border">
        <br>
        <div class="box-tools pull-right">
            <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                data-toggle="tooltip" title="" data-original-title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
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
            <div class="col-md-6 col-xs-12"></div>
        </div>

        <br>
        <hr>
        <br>

        <form autocomplete="off" id="formDatos" class="registerForm">
            <div class="row">
                <div class="col-md-4 col-xs-12">
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
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="contenedor" class="control-label">Contenedor:</label>
                        <input type="text" id="contenedor" name="contenedor" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="Nro" class="form-label">Otro:</label>
                        <input type="text" id="otro" name="otro" class="form-control">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-10 col-lg-11 col-xs-12"></div>
                <div class="col-md-2 col-lg-1 col-xs-12 text-center">
                    <div class="form-group">
                        <button id="btn-add" type="submit" class="btn btn-primary btn-circle" aria-label="Left Align">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button><br>
                        <small for="agregar" class="form-label">Agregar</small>
                    </div>
                </div>
            </div>
        </form>
        
        <div class="row">
            <div class="col-xs-12">
                <!-- /.box-header -->
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
                                aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Tipo de
                                            residuo</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending">Cantidad
                                            de contenedores</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ​
                                    <tr role="row" class="even" id="primero">
                                        <td>residuo radioactivo</td>
                                        <td>3</td>
                                    </tr>

                                </tbody>

                            </table><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1
                                to 10 of 57 entries</div>
                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                <ul class="pagination">
                                    <li class="paginate_button previous disabled" id="example2_previous"><a href="#"
                                            aria-controls="example2" data-dt-idx="0" tabindex="0">Previous</a></li>
                                    <li class="paginate_button active"><a href="#" aria-controls="example2"
                                            data-dt-idx="1" tabindex="0">1</a></li>
                                    <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="2"
                                            tabindex="0">2</a></li>
                                    <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="3"
                                            tabindex="0">3</a></li>
                                    <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="4"
                                            tabindex="0">4</a></li>
                                    <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="5"
                                            tabindex="0">5</a></li>
                                    <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="6"
                                            tabindex="0">6</a></li>
                                    <li class="paginate_button next" id="example2_next"><a href="#"
                                            aria-controls="example2" data-dt-idx="7" tabindex="0">Next</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <hr>

        <div class="row">
            <div class="box-header with-border">
                <h4>Transportistas</h4>
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
            </div>
            <div class="col-md-6"></div>
        </div>

        <br>
        <hr>
        <br>
        <div class="row">
            <div class="col-md-6 col-xs-12">
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
        <br>
        <div class="row">
                <div class="col-md-10 col-lg-11 col-xs-12"></div>
                <div class="col-md-2 col-lg-1 col-xs-12 text-center">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" aria-label="Left Align">
                            Guardar
                        </button><br>
                    </div>
                </div>
        </div>
    </div>
</div>
<!--  Box 3-->
<div class="row">
        <div class="col-xs-12">
            <div class="box box-primary animated fadeInLeft">
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
                                    aria-describedby="example2_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Rendering engine: activate to sort column descending">Nro de solicitud</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                                colspan="1" aria-label="Browser: activate to sort column ascending">Tipo de residuo
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                                colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                                Generador</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                                colspan="1" aria-label="Engine version: activate to sort column ascending">
                                                Fecha</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                                colspan="1" aria-label="Browser: activate to sort column ascending">Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabadd">
    
                                        <tr role="row" class="even" id="primero">
                                            <td>7</td>
                                            <td>Residuo solido urbano</td>
                                            <td>Generador 2</td>
                                            <td>4/10/2019</td>
                                            <td class="sorting_1"><button type="button"
                                                    title="rectificar" class="btn btn-primary btn-circle"><span
                                                        class="glyphicon glyphicon-pencil"
                                                        aria-hidden="true"></span></button>&nbsp<button type="button"
                                                    title="info" class="btn btn-primary btn-circle"><span
                                                        class="glyphicon glyphicon-info-sign"
                                                        aria-hidden="true"></span></button></td>
                                        </tr>
                                        <!--
                        <tr role="row" class="even">
                        <td class="sorting_1"><button type="button" title="ok" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>&nbsp<button type="button" title="editar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp<button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp<button type="button" title="buscar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></td>
                        <td>Zona 5</td>
                        <td>Circuito 11</td>
                        <td>Transp 8</td>
                        <td>Asd 347</td>
                        <td>Fernando Leiva</td>
                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1
                                    to 10 of 57 entries</div>
                            </div>
                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    <ul class="pagination">
                                        <li class="paginate_button previous disabled" id="example2_previous"><a href="#"
                                                aria-controls="example2" data-dt-idx="0" tabindex="0">Previous</a></li>
                                        <li class="paginate_button active"><a href="#" aria-controls="example2"
                                                data-dt-idx="1" tabindex="0">1</a></li>
                                        <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="2"
                                                tabindex="0">2</a></li>
                                        <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="3"
                                                tabindex="0">3</a></li>
                                        <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="4"
                                                tabindex="0">4</a></li>
                                        <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="5"
                                                tabindex="0">5</a></li>
                                        <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="6"
                                                tabindex="0">6</a></li>
                                        <li class="paginate_button next" id="example2_next"><a href="#"
                                                aria-controls="example2" data-dt-idx="7" tabindex="0">Next</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

<!-- script que cierra box con boton (x) -->

<script>
    $("#btnclose").on("click", function () {
            $("#boxDatos").hide(500);
            $("#botonAgregar").removeAttr("disabled");
            $('#formDatos').data('bootstrapValidator').resetForm();
            $("#formDatos")[0].reset();
            $('#chofer').find('option').remove();
    });
</script>

<!-- script bootstrap validator -->

<!-- script que muestra box de datos al dar click en boton agregar -->

<script>

    $("#botonAgregar").on("click", function () {

        $("#botonAgregar").attr("disabled", "");
        //$("#boxDatos").removeAttr("hidden");
        $("#boxDatos").show();

    });

</script>

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
                        message: 'la entrada debe ser un numero entero'
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
            }
        }
    }).on('success.form.bv', function (e) {
        e.preventDefault();
        guardar();
    });

</script>

<!-- script agregar dato -->

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
        //--------------------------------------------------------------
        if ($("#formDatos").data('bootstrapValidator').isValid()) {

            $.ajax({
                type: "POST",
                data: datos,
                url: "ajax/Ordentrabajo/guardarRes",
                success: function (r) {
                    if (r == "ok") {
                        //console.log(datos);
                        html = '<tr role="row" class="even"><td>' + tipo_residuo + '</td><td>' + contenedor + '</td>';
                        $('#primero').after(html);
                        $('#formDatos').data('bootstrapValidator').resetForm(true);
                        alertify.success("Agregado con exito");
                    }
                    else {
                        //console.log(r);
                        alertify.error("error al agregar");
                    }
                },
            });
        } else {

            console.log("la entrada no puede ser vacia");
        }
    };

</script>