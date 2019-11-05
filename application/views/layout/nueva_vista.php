<!--  Box 1-->
<div class="box box-primary animated fadeInLeft">
    <div class="box-body">
        <br>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="establecimiento" class="form-label">Establecimiento:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="establecimiento"
                        name="establecimiento" required>
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                                            foreach ($tipoResiduo as $i) {
                                                echo '<option>'.$i->nombre.'</option>';
                                            }
                                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="deposito" class="form-label">Deposito:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="deposito" name="deposito"
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
            <div class="col-md-2 col-xs-12">
                <div class="form-group">
                    <label for="addEstablecimiento" style="visibility:hidden;">Agregar:</label>
                    <button type="button" class="btn btn-primary form-control" id="addEstablecimiento"><span>Agregar
                        </span><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                </div>
                <div class="form-group">
                    <label for="addDeposito" style="visibility:hidden;">Agregar:</label>
                    <button type="button" id="addDeposito" class="btn btn-primary form-control"><span>Agregar
                        </span><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                </div>
            </div>
        </div>

        <br>
        <hr>


        <form autocomplete="off" id="formDatos" method="POST">
            <div class="row">
                <div class="box-header with-border">
                    <h3>Recipientes:</h3>
                </div>
                <br>
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="tipores" class="form-label">Tipo:</label>
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
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="nom" class="form-label">Nombre:</label>
                        <input type="number" id="nom" name="nom" class="form-control" required>
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
                                            aria-label="Rendering engine: activate to sort column descending">Acciones
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending">
                                            Tipo</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                            Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr role="row" class="even" id="primero">
                                        <td>residuo radioactivo</td>
                                        <td>3</td>
                                        <td>23</td>
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
        <div class="modal-footer">
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
            </div>
        </div>
    </div>
</div>

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