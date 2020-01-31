<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Gestion de seguimiento</h4>
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
        <div class="box-tools pull-right">
            <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                data-toggle="tooltip" title="" data-original-title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>

    <!--____________________________________________________________________-->

    <div class="box-body">
        <form class="formGestionSeguimiento" id="formGestionSeguimiento" method="POST" autocomplete="off">
            <div class="col-md-6 col-sm-6 col-xs-12">

                <!--Estado-->
                <div class="form-group">
                    <label for="Estado">Estado:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                            <select class="form-control select2 select2-hidden-accesible"  name="Estado" id="Estado">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                foreach ($Estado as $i) {
                                    echo '<option value="'.$i->depa_id.'">'.$i->nombre.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                </div>
                <!--____________________________________________________________________-->

            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">

                <!--Buscador-->
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                </div>
                <!--____________________________________________________________________-->

            </div>
        </form>
    </div>

    <!---//////////////////////////////////////--- TABLA ---///////////////////////////////////////////////////////----->

    <div class="box box-primary">

        <!--__________________TABLA___________________________-->

        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <!--<div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>-->
                </div>
                <div class="row">
                    <div class="col-sm-12 table-scroll">

                        <!--__________________HEADER TABLA___________________________-->

                        <table id="tabla_generadores" class="table table-bordered table-striped">

                        <!--_____________________________________________________________-->

                            <thead class="thead-dark" bgcolor="#eeeeee">
                                <th>Numero de OT</th>
                                <th>Chofer</th>
                                <th>Transportista</th>
                                <th>Circuito</th>
                                <th>Vehículo</th>
                                <th>Estado</th>
                                <th>Generador</th>
                                <th>Zona</th>
                                <th>Tipo de residuo</th>
                                <th>Disposición final</th>
                            </thead>

                            <!--__________________BODY TABLA___________________________-->

                            <tbody>
                            <tr>
                                <td>
                                <button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
                                <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <td>DATO</td>
                                <td>DATO</td>
                                <td>DATO</td>
                                <td>DATO</td>
                                <td>DATO</td>
                                <td>DATO</td>
                                <td>DATO</td>
                                <td>DATO</td>
                                <td>DATO</td>
                                <td>DATO</td>
                            </tr>
                            </tbody>

                        <!--____________________________________________________________________-->

                        </table>

                        <!--__________________FIN TABLA___________________________-->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!---//////////////////////////////////////--- FIN TABLA---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- FIN MODAL INFORMACION ---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- SCRIPTS---///////////////////////////////////////////////////////----->

<!--____________________________________________________________________-->

<!-- script modal -->
<script>
    $("#btnview").on("click", function() {
        $("#btnadd").removeClass("active");
        $("#btnview").addClass("active");
        $("#tablamodal").show();
        $("#formadd").hide();
        $("#btnsave").hide();
    });
</script>

<!--____________________________________________________________________-->

<script>
    $("#btnadd").on("click", function() {
        $("#btnadd").addClass("active");
        $("#btnview").removeClass("active");
        $("#formadd").show();
        $("#tablamodal").hide();
        $("#btnsave").show();
    });
</script>

<!--____________________________________________________________________-->