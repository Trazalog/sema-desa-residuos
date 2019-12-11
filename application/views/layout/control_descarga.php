<!-- Hecha por Fer Guardia-->
<!--  Box 1 tabla-->
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary animated fadeInLeft">
            <div class="box-header with-border">
                <h3>Control de descarga</h3>
            </div>
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 table-scroll">
                            <table id="example2" class="table table-condensed table-bordered table-hover dataTable"
                                role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Acciones
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending">Nro
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                            Patente</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Engine version: activate to sort column ascending">
                                            Tipo</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending">Fecha y
                                            hora
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending">Orden de
                                            transp
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending">
                                            Valorizado
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tabadd">

                                    <tr role="row" class="even">
                                        <td>
                                            <button type="button" title="vuelco"
                                                class="btn btn-primary btn-circle btnvuelco" data="0"><span class="glyphicon glyphicon-log-in"
                                                    aria-hidden="true"></span></button>&nbsp<button type="button"
                                                title="adjuntar" class="btn btn-primary btn-circle btnadjuntar"
                                                ><span class="glyphicon glyphicon-paperclip"
                                                    aria-hidden="true"></span></button></td>
                                        <td>7</td>
                                        <td id="patente0">asd 234</td>
                                        <td>Generador 2</td>
                                        <td>4/10/2019</td>
                                        <td>4/10/2019</td>
                                        <td>4/10/2019</td>
                                    </tr>
                                    <tr role="row" class="even">
                                        <td>
                                            <button type="button" title="vuelco"
                                                class="btn btn-primary btn-circle btnvuelco" data="1"><span class="glyphicon glyphicon-log-in"
                                                    aria-hidden="true"></span></button>&nbsp<button type="button"
                                                title="adjuntar" class="btn btn-primary btn-circle btnadjuntar"><span
                                                    class="glyphicon glyphicon-paperclip"
                                                    aria-hidden="true"></span></button></td>
                                        <td>8</td>
                                        <td id="patente1">dsa 213</td>
                                        <td>Generador 4</td>
                                        <td>4/10/2019</td>
                                        <td>4/10/2019</td>
                                        <td>4/10/2019</td>
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
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<!--  Box 2 accion click boton vuelco-->
<div class="box box-primary animated bounceInDown" id="boxDatos" hidden>
    <div class="box-header with-border">
        <h4>Certificado de vuelco</h4>
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
                    <label for="vehiculoform" class="form-label">Vehiculo:</label>
                    <input size="10" type="text" name="vehiculoform" id="vehiculoform" min="0" class="form-control"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="nro" class="form-label">Deposito:</label>
                    <input type="number" size="10" type="text" name="nro" id="nro" min="0" class="form-control"
                        required>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="nro" class="form-label">Valorizado:</label>
                    <input type="number" size="10" type="text" name="nro" id="nro" min="0" class="form-control"
                        required>
                </div>
                <div class="form-group">
                    <label for="nro" class="form-label">Observacion:</label>
                    <input type="number" size="10" type="text" name="nro" id="nro" min="0" class="form-control"
                        required>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3 div-xs-12 text-center">
                <div class="form-group">
                    <button type="submit" class="btn btn-default btn-circle" aria-label="Left Align">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button><br>
                    <small for="agregar" class="form-label">Incidencia</small>
                </div>
            </div>
            <div class="col-md-3 div-xs-12 text-center">
                <div class="form-group">
                    <button type="submit" class="btn btn-default btn-circle" aria-label="Left Align">
                        <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
                    </button><br>
                    <small for="agregar" class="form-label">Adjuntar imagen</small>
                </div>
            </div>
            <div class="col-md-3 div-xs-12 text-center">
                <div class="form-group">
                    <button type="submit" class="btn btn-default btn-circle" aria-label="Left Align">
                        <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                    </button><br>
                    <small for="agregar" class="form-label">Cerrar sector</small>
                </div>
            </div>
            <div class="col-md-3 div-xs-12 text-center">
                <div class="form-group">
                    <button type="submit" class="btn btn-default btn-circle" aria-label="Left Align">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    </button><br>
                    <small for="agregar" class="form-label">Certificado de vuelco</small>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <div class="thumbnail">
                    <div class="caption">
                        <h3>JB-098-01</h3>
                        <p>OT: 345</p>
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Tareas <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a role="button">Volcar</a></li>
                                <li><a role="button" onclick="modalMover()">Mover</a></li>
                                <!-- <li role="separator" class="divider"></li> -->
                                <li><a role="button" onclick="modalRedireccionar()">Redireccionar</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="thumbnail">
                    <div class="caption">
                        <h3>BT-090-11</h3>
                        <p>OT: 346</p>
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Tareas <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a role="button">Volcar</a></li>
                                <li><a role="button" onclick="modalMover()">Mover</a></li>
                                <!-- <li role="separator" class="divider"></li> -->
                                <li><a role="button" onclick="modalRedireccionar()">Redireccionar</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="thumbnail">
                    <div class="caption">
                        <h3>TT-038-01</h3>
                        <p>OT: 346</p>
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Tareas <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a role="button">Volcar</a></li>
                                <li><a role="button" onclick="modalMover()">Mover</a></li>
                                <!-- <li role="separator" class="divider"></li> -->
                                <li><a role="button" onclick="modalRedireccionar()">Redireccionar</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="thumbnail">
                    <div class="caption">
                        <h3>CC-028-10</h3>
                        <p>OT: 347</p>
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Tareas <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a role="button">Volcar</a></li>
                                <li><a role="button" onclick="modalMover()">Mover</a></li>
                                <!-- <li role="separator" class="divider"></li> -->
                                <li><a role="button" onclick="modalRedireccionar()">Redireccionar</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal mover-->
<div class="modal fade" id="modalMover" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Mover</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="form-group">
                            <label for="nro" class="form-label">Vehiculo:</label>
                            <input type="number" size="10" type="text" name="nro" id="nro" min="0"
                                class="form-control input-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="nro" class="form-label">Area de inicio:</label>
                            <input type="number" size="10" type="text" name="nro" id="nro" min="0"
                                class="form-control input-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="nro" class="form-label">Area de fin:</label>
                            <input type="number" size="10" type="text" name="nro" id="nro" min="0"
                                class="form-control input-sm" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btnsavemodalmov">Guardar</button>
                    <button type="button" class="btn btn-default" id="btnclosemodalmov"
                        data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal redireccionar-->
<div class="modal fade" id="modalRedireccionar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Redireccionar</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="form-group">
                            <label for="nro" class="form-label">Vehiculo:</label>
                            <input type="number" size="10" type="text" name="nro" id="nro" min="0"
                                class="form-control input-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="nro" class="form-label">OT:</label>
                            <input type="number" size="10" type="text" name="nro" id="nro" min="0"
                                class="form-control input-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="nro" class="form-label">Informacion:</label>
                            <input type="number" size="10" type="text" name="nro" id="nro" min="0"
                                class="form-control input-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="nro" class="form-label">Sector de inicio:</label>
                            <input type="number" size="10" type="text" name="nro" id="nro" min="0"
                                class="form-control input-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="nro" class="form-label">Sector de fin:</label>
                            <input type="number" size="10" type="text" name="nro" id="nro" min="0"
                                class="form-control input-sm" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btnsavemodalred">Guardar</button>
                    <button type="button" class="btn btn-default" id="btnclosemodalred"
                        data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function modalMover() {
        $("#modalMover").modal("show");
    }
</script>
<script>
    function modalRedireccionar() {
        $("#modalRedireccionar").modal("show");
    }
</script>

<script>
    $(function () {
        $('#example1').DataTable()
        $('#example2').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true
        })
    })
</script>

<!-- script que cierra box con boton (x) -->

<script>
    $("#btnclose").on("click", function () {
        $("#boxDatos").hide(500);
        $(".btnvuelco").removeAttr("disabled");
        $(".btnadjuntar").removeAttr("disabled");
        /*$('#formDatos').data('bootstrapValidator').resetForm();
        $("#formDatos")[0].reset();
        $('#selecmov').find('option').remove();
        $('#chofer').find('option').remove();*/
    });
</script>

<!-- script que muestra box de datos al dar click en boton volcar del dataTable -->

<script>
    $(".btnvuelco").on("click", function () {
        //ejemplo de carga de patente en input vehiculo
        vehiculo = "patente"+$(this).attr("data");
        $("#vehiculoform").val($("#"+vehiculo).text());
        $(".btnvuelco").attr("disabled", "");
        $(".btnadjuntar").attr("disabled", "");
        $("#boxDatos").focus();
        $("#boxDatos").show();
    });
</script>