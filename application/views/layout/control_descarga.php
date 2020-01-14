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
                        <table id="tabla_control_descarga" class="table table-bordered table-striped">
                        <thead class="thead-dark" bgcolor="#eeeeee">

                            <th>Acciones</th>
                            <th>Nro</th>
                            <th>Patente</th>
                            <th>Tipo</th>
                            <th>Fecha y hora</th>
                            <th>Orden de transp</th>
                            <th>Valorizado</th>
                            

                        </thead>

                        <!--__________________BODY TABLA___________________________-->

                        <tbody>
                        <tr>
                            <td>
                            <button type="button" title="vuelco" class="btn btn-primary btn-circle btnvuelco"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></button>&nbsp
                            <button type="button"        title="adjuntar" class="btn btn-primary btn-circle btnadjuntar"><span aria-hidden="true"></span></button>
                            <button type="button"  title="Cerrar sector" class="btn btn-primary btn-circle btnadjuntar"><span class="glyphicon glyphicon-lock"aria-hidden="true"></span></button>
                            </td>
                            <td>8</td>
                            <td>dsa 213</td>
                            <td>Generador 4</td>
                            <td>4/10/2019</td>
                            <td>4/10/2019</td>
                            <td>4/10/2019</td>
                        </tr>

                        <tr>
                            <td>
                            <button type="button" title="vuelco" class="btn btn-primary btn-circle btnvuelco"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></button>&nbsp
                            <button type="button"  title="adjuntar" class="btn btn-primary btn-circle btnadjuntar"><span aria-hidden="true"></span></button>
                            <button type="button"  title="Cerrar sector" class="btn btn-primary btn-circle btnadjuntar"><span class="glyphicon glyphicon-lock"aria-hidden="true"></span></button>
                            </td>
                            <td>8</td>
                            <td>dsa 213</td>
                            <td>Generador 4</td>
                            <td>4/10/2019</td>
                            <td>4/10/2019</td>
                            <td>4/10/2019</td>
                        </tr>

                           
                        </tbody>
                    </table>
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
                    <label for="nro" class="form-label">Vehiculo:</label>
                    <input type="number" size="10" type="text" name="nro" id="nro" min="0" class="form-control" required
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
        <div class="col-md-12"><hr></div>

<!-- _____________ BOTONES ________________ -->

        <div class="col-md-12">
            <div class="col-md-4 col-xs-4 text-center">
                <div class="form-group">
                    <button type="submit" class="btn btn-default btn-circle" aria-label="Left Align">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button><br>
                    <small for="agregar" class="form-label">Incidencia</small>
                </div>
            </div>
            <div class="col-md-4 col-xs-4 text-center">
                <div class="form-group">
                    <button type="submit" class="btn btn-default btn-circle" aria-label="Left Align">
                        <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
                    </button><br>
                    <small for="agregar" class="form-label">Adjuntar imagen</small>
                </div>
            </div>
            
            <div class="col-md-4 col-xs-4 text-center">
                <div class="form-group">
                    <button type="submit" class="btn btn-default btn-circle" aria-label="Left Align">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    </button><br>
                    <small for="agregar" class="form-label">Certificado de vuelco</small>
                </div>
            </div>
        </div>


<!-- _____________ BOTONES ________________ -->

        <div class="col-md-12"><hr></div>

<!-- _____________ THUMBAILS________________ -->

<div class="row">

     <div class="col-md-12">
     
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

            <!-- _____________________________ -->

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
            <div class="modal-header bg-blue">
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
            <div class="modal-header bg-blue">
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

<!--_____________________________________________________________-->
 <!-- script Datatables -->
 <script>

    DataTable($('#tabla_control_descarga'))

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
        
        $(".btnvuelco").attr("disabled", "");
        $(".btnadjuntar").attr("disabled", "");
        $("#boxDatos").focus();
        $("#boxDatos").show();
    });
</script>