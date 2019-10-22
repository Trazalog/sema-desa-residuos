<!-- Hecha por Fer Guardia el mascapito -->
<!--  Box 1-->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h3>Template de Orden de Transporte</h3>
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
<!--  Box 2-->
<div class="box box-primary animated bounceInDown" id="boxDatos" hidden>
    <div class="box-header with-border">
        <h4>Informacion</h4>
        <div class="box-tools pull-right">
            <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                data-toggle="tooltip" title="" data-original-title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <form id="formDatos" method="POST" autocomplete="off" class="registerForm">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="nro" class="form-label">Nro:</label>
                        <input type="number" size="10" type="text" name="nro" id="nro" min="0" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="zona" class="form-label">Zona:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="zona" name="zona" required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                        foreach ($zona as $i) {
                                            echo '<option>'.$i->nombre.'</option>';
                                        }
                                        ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tiporesiduo" class="form-label">Tipo de residuo:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="tiporesiduo"
                            name="tiporesiduo" required>
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
                        <label for="fecha" class="form-label">Fecha:</label>
                        <input type="date" id="fecha" name="fecha" value="<?php echo $fecha;?>" class="form-control"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="dispfinal" class="form-label">Disposicion final:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="dispfinal" name="dispfinal"
                            required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                        foreach ($disposicionFinal as $i) {
                                            echo '<option>'.$i->nombre.'</option>';
                                            }
                                        ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="circuito" class="form-label">Circuito:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="circuito" name="circuito"
                            required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                            foreach ($circuito as $i) {
                                                echo '<option>'.$i->nombre.'</option>';
                                            }
                                    ?>
                        </select>
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
                        <select size="3" class="form-control" id="selecemp" name="empresa" required>
                            <?php
                            foreach ($empresa as $i) {
                                echo '<option class="emp" data-json=\''.json_encode($i).'\'>'.$i->nom->nom_emp.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="registron" class="form-label">Registro n°:</label>
                        <input type="text" class="form-control" id="registron" name="numreg" readonly>
                    </div>
                    <div class="form-group">
                        <label for="chofer" class="form-label">Chofer:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="chofer" name="chofer"
                            required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="selecmov" class="form-label">Movilidad:</label>
                        <select size="3" class="form-control" id="selecmov" name="movilidad" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dominio" class="form-label">Dominio:</label>
                        <input type="text" class="form-control" name="dominio" id="dominio" name="dominio" readonly>
                    </div>
                </div>
            </div>
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
        </form>
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
                        <div class="col-sm-12 table-scroll">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
                                aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Zona</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending">Circuito
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                            Transportista</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Engine version: activate to sort column ascending">
                                            Movilidad</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Chofer
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending">Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tabadd">
                                    <tr role="row" class="even" id="primero" hidden>
                                        <td>Zona 1</td>
                                        <td>Circuito 5</td>
                                        <td>Transp 1</td>
                                        <td>Asd 345</td>
                                        <td>Hugo Gallardo</td>
                                        <td class="sorting_1"><button type="button" title="ok"
                                                class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-ok"
                                                    aria-hidden="true"></span></button>&nbsp<button type="button"
                                                title="editar" class="btn btn-primary btn-circle" data-toggle="modal"
                                                data-target="#modalEdit"><span class="glyphicon glyphicon-pencil"
                                                    aria-hidden="true"></span></button>&nbsp<button type="button"
                                                title="eliminar" class="btn btn-primary btn-circle delete"><span
                                                    class="glyphicon glyphicon-trash"
                                                    aria-hidden="true"></span></button>&nbsp<button type="button"
                                                title="buscar" class="btn btn-primary btn-circle info"
                                                data-toggle="modal" data-target="#modalInfo"><span
                                                    class="glyphicon glyphicon-search"
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
<!-- Modal editar-->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabell">Editar datos</h5>
            </div>
            <div class="modal-body">
                <form id="formEditDatos" method="POST" autocomplete="off" class="registerForm">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="nroo" class="form-label">Nro:</label>
                                <input type="number" size="10" type="text" name="nro" id="nroo" min="0"
                                    class="form-control" auto required pattern="^(0|[1-9][0-9]*)$">
                            </div>
                            <div class="form-group">
                                <label for="zonaa" class="form-label">Zona:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="zonaa" name="zona"
                                    required>
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                                            foreach ($zona as $i) {
                                                                echo '<option>'.$i->nombre.'</option>';
                                                            }
                                                            ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tiporesiduoo" class="form-label">Tipo de residuo:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="tiporesiduoo"
                                    name="tiporesiduo" required>
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
                                <label for="fechaa" class="form-label">Fecha:</label>
                                <input type="date" id="fechaa" name="fecha" value="<?php echo $fecha;?>"
                                    class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="dispfinall" class="form-label">Disposicion final:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="dispfinall"
                                    name="dispfinal" required>
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                                            foreach ($disposicionFinal as $i) {
                                                                echo '<option>'.$i->nombre.'</option>';
                                                                }
                                                            ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="circuitoo" class="form-label">Circuito:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="circuitoo"
                                    name="circuito" required>
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                                                foreach ($circuito as $i) {
                                                                    echo '<option>'.$i->nombre.'</option>';
                                                                }
                                                        ?>
                                </select>
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
                                <label for="selecempp" class="form-label">Empresa:</label>
                                <select size="3" class="form-control" id="selecempp" name="empresa" required>
                                    <?php                                               
                                                foreach ($empresa as $i) {
                                                    echo '<option value="'.$i->nom->nom_emp.'" class="emp" data-json=\''.json_encode($i).'\'>'.$i->nom->nom_emp.'</option>';
                                                    
                                                }
                                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="registronn" class="form-label">Registro n°:</label>
                                <input type="text" class="form-control" id="registronn" name="numreg" readonly>
                            </div>
                            <div class="form-group">
                                <label for="choferr" class="form-label">Chofer:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="choferr" name="chofer"
                                    required>
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="selecmovv" class="form-label">Movilidad:</label>
                                <select size="3" class="form-control" id="selecmovv" name="movilidad" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dominioo" class="form-label">Dominio:</label>
                                <input type="text" class="form-control" name="dominio" id="dominioo" name="dominio"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
                            <button class="btn btn-default" id="btnclose" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal info-->
<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nro" class="form-label">Nro:</label>
                            <input type="text" id="num" class="form-control input-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="fechita" class="form-label">Fecha:</label>
                            <input type="text" id="fechita" class="form-control input-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="zonita" class="form-label">Zona:</label>
                            <input type="text" id="zonita" class="form-control input-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="dispofinal" class="form-label">Disposicion final</label>
                            <input type="text" id="dispofinal" class="form-control input-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tipores" class="form-label">Tipo de residuo:</label>
                            <input type="text" id="tipores" class="form-control input-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="circuit" class="form-label">Circuito:</label>
                            <input type="text" id="circuit" class="form-control input-sm" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="empresita" class="form-label">Empresa:</label>
                            <input type="text" id="empresita" class="form-control input-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="movi" class="form-label">Movilidad:</label>
                            <input type="text" id="movi" class="form-control input-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="reg" class="form-label">Registro n°:</label>
                            <input type="text" id="reg" class="form-control input-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="dom" class="form-label">Dominio:</label>
                            <input type="text" id="dom" class="form-control input-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="chof" class="form-label">Chofer:</label>
                            <input type="text" id="chof" class="form-control input-sm" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- script que muestra datos en modal edit -->
<script>
function clickedit(aux) {
    //limpia los select para cargar datos especificos
    $("#selecempp").prop('selectedIndex', 0);
    $('#selecmovv').find('option').remove();
    $('#choferr').find('option').remove();
    //se obtiene el valor de la empresa seleccionada
    var emp = localStorage.getItem('empresa' + aux);
    //se carga parte del formulario con los datos previamente cargados
    $("#nroo").val(localStorage.getItem('num' + aux));
    $("#fechaa").val(localStorage.getItem('fecha' + aux));
    $("#zonaa").val(localStorage.getItem('zona' + aux));
    $("#dispfinall").val(localStorage.getItem('dispfinal' + aux));
    $("#tiporesiduoo").val(localStorage.getItem('tiporesiduo' + aux));
    $("#circuitoo").val(localStorage.getItem('circuito' + aux));
    $("#registronn").val(localStorage.getItem('numreg' + aux));
    $("#dominioo").val(localStorage.getItem('dominio' + aux));
    //se le asigna el valor especifico previamente cargado y se lo selecciona
    $('#selecempp').val(emp).trigger('click');
    //se trae el json de la opcion seleccionada
    var json = $('#selecempp').find(':selected').data('json');
    //json = JSON.parse(json);
    //se inicializa las variables
    var html_mov = " ",
        html_chof = "";
    //carga la variable html_mov con las movilidades disponibles de la empresa seleccionada
    json.movilidades.movilidad.forEach(function(valor) {
        html_mov += "<option class='movilito' data-reg='" + valor.registro + "' data-dom='" + valor
            .dominio + "'>" + valor.nom_movil + "</option>"
    });
    //idem anterior pero con los choferes de la empresa
    json.choferes.chofer.forEach(function(valor) {
        html_chof += "<option class='chof'>" + valor.nom_chofer + "</option>"
    });
    //se asigna las variables antes mencionadas a sus select correspondientes
    $('#selecmovv').html(html_mov);
    $("#choferr").html("<option value='' disabled selected>-Seleccione opcion-</option>" + html_chof);
    //se termina de cargar el formulario con los datos previamente cargados
    $("#selecmovv").val(localStorage.getItem('movilidad' + aux));
    $("#choferr").val(localStorage.getItem('chofer' + aux));
    //se guarda localmente una nueva variable auxedit que indica el id de la fila seleccionada para luego saber en que id guardar los datos a actualizar
    localStorage.setItem('auxedit', aux);
}
</script>
<!--script close modal edit -->
<script>
//este script me permite limpiar la validacion una vez cerrado el modal
$("#modalEdit").on("hidden.bs.modal", function(e) {
    $("#formEditDatos").data('bootstrapValidator').resetForm();
});
</script>
<!-- script muestra datos modal info -->
<script>
function clickinfo(aux) {
    //console.log(localStorage.getItem('num'));
    $("#num").val(localStorage.getItem('num' + aux));
    $("#fechita").val(localStorage.getItem('fecha' + aux));
    $("#zonita").val(localStorage.getItem('zona' + aux));
    $("#dispofinal").val(localStorage.getItem('dispfinal' + aux));
    $("#tipores").val(localStorage.getItem('tiporesiduo' + aux));
    $("#circuit").val(localStorage.getItem('circuito' + aux));
    $("#empresita").val(localStorage.getItem('empresa' + aux));
    $("#movi").val(localStorage.getItem('movilidad' + aux));
    $("#reg").val(localStorage.getItem('numreg' + aux));
    $("#dom").val(localStorage.getItem('dominio' + aux));
    $("#chof").val(localStorage.getItem('chofer' + aux));
}
</script>
<!-- script delete con sweet alert 2 -->
<script>
function borrar(aux) {
    swal({
            title: "Esta seguro que desea eliminar el elemento?",
            text: "Una vez completada la accion no se podra revertir el cambio!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "No, cancelar",
            closeOnConfirm: false,
            //closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                swal({
                    title: "Eliminado!",
                    text: "La accion fue completada con exito",
                    type: "success",
                    timer: 1800,
                    showConfirmButton: false
                });
                
                //oculta la fila eliminada
                $("#" + aux).hide(500);
            } else {

            }
        });
}
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
    excluded: ':disabled',
    fields: {
        nro: {
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
        dispfinal: {
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
        zona: {
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
        circuito: {
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
        tiporesiduo: {
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
        empresa: {
            message: 'la entrada no es valida',
            validators: {
                notEmpty: {
                    message: 'seleccione una opcion'
                }
                /*stringLength: {
                    min: 6,
                    max: 30,
                    message: 'The username must be more than 6 and less than 30 characters long'
                },*/
            }
        },
        movilidad: {
            message: 'la entrada no es valida',
            validators: {
                notEmpty: {
                    message: 'seleccione una opcion'
                }
                /*stringLength: {
                    min: 6,
                    max: 30,
                    message: 'The username must be more than 6 and less than 30 characters long'
                },*/
            }
        },
        chofer: {
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
}).on('success.form.bv', function(e) {
    e.preventDefault();
    guardar();
});
</script>
<!-- script bootstrap validator -->
<script>
$('#formEditDatos').bootstrapValidator({
    message: 'This value is not valid',
    /*feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },*/
    excluded: ':disabled',
    fields: {
        empresa: {
            message: 'la entrada no es valida',
            validators: {
                notEmpty: {
                    message: 'seleccione una opcion'
                }
                /*stringLength: {
                    min: 6,
                    max: 30,
                    message: 'The username must be more than 6 and less than 30 characters long'
                },*/
            }
        },
        movilidad: {
            message: 'la entrada no es valida',
            validators: {
                notEmpty: {
                    message: 'seleccione una opcion'
                }
                /*stringLength: {
                    min: 6,
                    max: 30,
                    message: 'The username must be more than 6 and less than 30 characters long'
                },*/
            }
        }
    }
}).on('success.form.bv', function(e) {
    e.preventDefault();
    //se invoca a la funcion actualizar con el parametro auxedit que contiene el id de la fila seleccionada, a la que le vamos a actualizar los datos
    actualizar(localStorage.getItem('auxedit'));
});
</script>
<!-- script actualiza datos -->
<script>
function actualizar(aux) {
    //datos para mostrar a modo de ejemplo para DEMO---------------
    //Serialize the Form
    var values = {};
    $.each($("#formEditDatos").serializeArray(), function(i, field) {
        values[field.name] = field.value;
    });
    //Value Retrieval Function
    var getValue = function(valueName) {
        return values[valueName];
    };
    //Retrieve the Values
    var empresa = getValue("empresa");
    var zona = getValue("zona");
    var circuito = getValue("circuito");
    var movilidad = getValue("movilidad");
    var numreg = getValue("numreg");
    var dominio = getValue("dominio");
    var chofer = getValue("chofer");
    var fecha = getValue("fecha");
    var dispfinal = getValue("dispfinal");
    var tiporesiduo = getValue("tiporesiduo");
    var num = getValue("nro");
    //se actualizan los datos en localStorage
    localStorage.setItem('num' + aux, num);
    localStorage.setItem('tiporesiduo' + aux, tiporesiduo);
    localStorage.setItem('dispfinal' + aux, dispfinal);
    localStorage.setItem('fecha' + aux, fecha);
    localStorage.setItem('chofer' + aux, chofer);
    localStorage.setItem('dominio' + aux, dominio);
    localStorage.setItem('numreg' + aux, numreg);
    localStorage.setItem('movilidad' + aux, movilidad);
    localStorage.setItem('circuito' + aux, circuito);
    localStorage.setItem('zona' + aux, zona);
    localStorage.setItem('empresa' + aux, empresa);
    //se actualizan los datos de la fila correspondiente de la tabla
    $("#" + aux + " .Zona").text(zona);
    $("#" + aux + " .Circuito").text(circuito);
    $("#" + aux + " .Empresa").text(empresa);
    $("#" + aux + " .Movilidad").text(movilidad);
    $("#" + aux + " .Chofer").text(chofer);
    //se cierra el modal y se indica que los datos se actualizaron con exito
    $('#modalEdit').modal('toggle');
    alertify.success("Actualizacion realizada con exito");
}
</script>
<!-- script que cierra box con boton (x) -->
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
<!-- Script modal para mostrar por empresa las movilidades y choferes disponibles y por movilidad su respectiva informacion -->
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
    $('#selecmovv').html(html_mov);
    $("#choferr").html("<option value='' disabled selected>-Seleccione opcion-</option>" + html_chof);
    $("#registronn").val("");
    $("#dominioo").val("");
});
$("#selecmovv").on('change', function() {
    var sel = $(this).find(":selected");
    $("#registronn").val(sel.data('reg'));
    $("#dominioo").val(sel.data('dom'));
});
</script>
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
<!-- Script inicia variable auxiliar gloabal -->
<script>
$(document).ready(function() {
    localStorage.setItem('aux', 0);
    /*var val = localStorage.getItem('aux');
    var aux = parseInt(val);
    aux = aux + 1;
    console.log(aux);*/
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
    var empresa = getValue("empresa");
    var zona = getValue("zona");
    var circuito = getValue("circuito");
    var movilidad = getValue("movilidad");
    var numreg = getValue("numreg");
    var dominio = getValue("dominio");
    var chofer = getValue("chofer");
    var fecha = getValue("fecha");
    var dispfinal = getValue("dispfinal");
    var tiporesiduo = getValue("tiporesiduo");
    var num = getValue("nro");
    var aux = parseInt(localStorage.getItem('aux'));
    localStorage.setItem('num' + aux, num);
    localStorage.setItem('tiporesiduo' + aux, tiporesiduo);
    localStorage.setItem('dispfinal' + aux, dispfinal);
    localStorage.setItem('fecha' + aux, fecha);
    localStorage.setItem('chofer' + aux, chofer);
    localStorage.setItem('dominio' + aux, dominio);
    localStorage.setItem('numreg' + aux, numreg);
    localStorage.setItem('movilidad' + aux, movilidad);
    localStorage.setItem('circuito' + aux, circuito);
    localStorage.setItem('zona' + aux, zona);
    localStorage.setItem('empresa' + aux, empresa);
    //--------------------------------------------------------------
    if ($("#formDatos").data('bootstrapValidator').isValid()) {
        $.ajax({
            type: "POST",
            data: datos,
            url: "ajax/Ordentrabajo/guardarDato",
            success: function(r) {
                if (r == "ok") {
                    //console.log(datos);
                    html = '<tr id="' + aux + '" role="row" class="even"><td class="Zona">' + zona +
                        '</td><td class="Circuito">' + circuito + '</td><td class="Empresa">' + empresa +
                        '</td><td class="Movilidad">' + movilidad + '</td><td class="Chofer">' + chofer +
                        '</td><td class="sorting_1"><button type="button" title="ok" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>&nbsp<button type="button" title="editar" onclick="clickedit(' +
                        aux +
                        ')" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp<button type="button" title="eliminar" onclick="borrar(' +
                        aux +
                        ')" id="delete" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp<button type="button" title="buscar" class="btn btn-primary btn-circle info" onclick="clickinfo(' +
                        aux +
                        ')" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></td></tr>';
                    aux = aux + 1;
                    localStorage.setItem('aux', aux);
                    $('#primero').after(html);
                    $('#formDatos').data('bootstrapValidator').resetForm();
                    $("#formDatos")[0].reset();
                    $('#selecmov').find('option').remove();
                    $('#chofer').find('option').remove();
                    $("#chofer").html("<option value='' disabled selected>-Seleccione opcion-</option>");
                    $("#boxDatos").hide(500);
                    $("#botonAgregar").removeAttr("disabled");
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