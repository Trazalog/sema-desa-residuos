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
                            <div class="col-sm-12 table-scroll">
                                <table id="example2" class="table table-condensed table-bordered table-hover dataTable" role="grid"
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
                                            <td class="sorting_1"><button type="button" id="btnrectificar" data-toggle="modal" data-target="#modalRectificar"
                                                    title="rectificar" class="btn btn-primary btn-circle"><span
                                                        class="glyphicon glyphicon-pencil"
                                                        aria-hidden="true"></span></button>&nbsp<button type="button" id="btninfo"
                                                    title="info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span
                                                        class="glyphicon glyphicon-info-sign"
                                                        aria-hidden="true"></span></button>&nbsp<button type="button" id="btnentrega"
                                                        title="entregar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEntrega"><span
                                                            class="glyphicon glyphicon-check"
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

    <!-- Modal rectificativa-->
	<div class="modal fade"  id="modalRectificar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title" id="exampleModalLabel">Rectificativa</h5>
				</div>
				<div class="modal-body">
					<form id="frmrect" method="POST" autocomplete="off" class="registerForm">
                        <!-- <input type="text" hidden="" id="idpersona" name="idpersona">  -->
                        
                        <div class="row" hidden>
                            <div class="text-center">
                                <button type="button" class="btn btn-sm btn-default active" id="btnadd">Agregar</button>
                                <button type="button" class="btn btn-sm btn-default" id="btnview">Ver cargadas</button>
                            </div>
                        </div>
                        <br>
                        <div id="formadd">
                                <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Numero</label>
                                                <input type="text" class="form-control input-sm" id="numero" name="numero" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">fecha</label>
                                                    <input type="date" class="form-control input-sm" value="<?php echo $fecha;?>" id="fecha" name="fecha" required>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Motivo</label>
                                                        <input type="text" class="form-control input-sm" id="motivo" name="motivo" required>
                                                    </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                                
                                                        <div class="form-group">
                                                            <label class="form-label">Descripcion</label>
                                                            <textarea type="text" class="form-control input-sm" rows="5" id="descripcion" name="descripcion" required></textarea>
                                                        </div>
                                                        
                                                
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <!--Adjuntador de imagenes-->
                                            <div class="form-group">
                                                <input type="file" class=" input-sm" id="file" name="file" accept=".docx, application/msword, application/pdf">
                                            </div>
                                        </div>
                                    </div>
                        </div>
                        
                        <br>
                        <div class="row">
                                <div class="col-sm-12 table-scroll">
                                        <table id="tablamodal" class="table table-condensed table-bordered table-hover" role="grid"
                                            aria-describedby="example2_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                                        colspan="1" aria-sort="ascending"
                                                        aria-label="Rendering engine: activate to sort column descending">Nro</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                                        colspan="1" aria-label="Browser: activate to sort column ascending">Fecha
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                                        Motivo</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                                        colspan="1" aria-label="Engine version: activate to sort column ascending">
                                                        Descripcion</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                                        colspan="1" aria-label="Engine version: activate to sort column ascending">
                                                        Archivo adjunto</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabadd">
            
                                                <tr role="row" class="even" id="primero">
                                                    <td>7</td>
                                                    <td>4/10/2019</td>
                                                    <td>Motivo 2</td>
                                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit, quis! Aut assumenda enim quisquam.</td>
                                                    <td></td>
                                                </tr>
                                                <tr role="row" class="even" id="primero">
                                                    <td>5</td>
                                                    <td>1/10/2019</td>
                                                    <td>Motivo 1</td>
                                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit, quis! Aut assumenda enim quisquam.</td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </div>
                        </div>
                        <div >
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
    
    <!-- Modal informacion-->
	<div class="modal fade"  id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
				</div>
				<div class="modal-body">

                </div>
                <div class="modal-footer">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
			</div>
		</div>
	</div>

        <!-- Modal Entrega-->
	<div class="modal fade"  id="modalEntrega" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="exampleModalLabel">Entrega de contenedor</h5>
                    </div>
                    <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">
                        <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nro" class="form-label label-sm">Nro de solicitud</label>
                                            <input type="text" id="nro" name="nro" class="form-control input-sm" required>
                                        </div>
                                    </div>
                                    <div class="col-md-8"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="generador" class="form-label label-sm">Generador</label>
                                            <input type="text" id="generador" name="generador" required class="form-control input-sm">
                                        </div>
                                        <div class="form-group">
                                            <label for="tipores" class="form-label label-sm">Tipo de residuo</label>
                                            <input type="text" id="tipores" name="tipores" required class="form-control input-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rectificatoria" class="form-label label-sm">Rectificatoria</label>
                                            <input type="text" id="rectificatoria" required name="rectificatoria" class="form-control input-sm">
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha" class="form-label label-sm">Fecha</label>
                                            <input type="date" id="fecha" name="fecha" required class="form-control input-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cont" class="form-label label-sm">Contenedor</label>
                                            <input type="text" id="cont" required name="contenedor" class="form-control input-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecharet" class="form-label label-sm">Fecha de retiro</label>
                                            <input type="date" id="fecharet" required name="fecharetiro" class="form-control input-sm">
                                        </div>
                                    </div>
                                </div>
                                <br>
                            <div class="row">
                                    <div class="col-sm-12 table-scroll">
                                            <table id="tablamodal" class="table table-condensed table-bordered table-hover" role="grid"
                                                aria-describedby="example2_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                                            colspan="1" aria-sort="ascending"
                                                            aria-label="Rendering engine: activate to sort column descending">Codigo</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                                            colspan="1" aria-label="Browser: activate to sort column ascending">Capacidad
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                                            colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                                            Tara</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tabadd">
                
                                                    <tr role="row" class="even" id="primero">
                                                        <td>7</td>
                                                        <td>20kg</td>
                                                        <td>tara 2</td>
                                                    </tr>
                                                    <tr role="row" class="even" id="primero">
                                                        <td>5</td>
                                                        <td>40kg</td>
                                                        <td>tara 1</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                    </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
                                <button class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<!--script close modal entrega -->
<script>
    $("#modalEntrega").on("hidden.bs.modal", function (e) {
        //console.log("se cerro el modal");
        $("#frmentrega").data('bootstrapValidator').resetForm(true);
        $("#frmentrega")[0].reset();
    });
</script>

<!--script close modal rectificativa -->
<script>
        $("#modalRectificar").on("hidden.bs.modal", function (e) {
            //console.log("se cerro el modal");
            $("#frmrect").data('bootstrapValidator').resetForm(true);
            $("#frmrect")[0].reset();
        });
</script>
<!-- script modal -->
<script>
    $("#btnview").on("click", function(){
        $("#btnadd").removeClass("active");
        $("#btnview").addClass("active");
        $("#tablamodal").show();
        $("#formadd").hide();
        $("#btnsave").hide();
    });

    $("#btnadd").on("click", function(){
        $("#btnadd").addClass("active");
        $("#btnview").removeClass("active");
        $("#formadd").show();
        $("#tablamodal").hide();
        $("#btnsave").show();
    });

</script>

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
<script>

        $('#frmentrega').bootstrapValidator({
            message: 'This value is not valid',
            /*feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },*/
            excluded: [':disabled'],
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
                fecha: {
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
                generador: {
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
                    }
                },
                tipores: {
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
                rectificatoria: {
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
                contenedor: {
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
                fecharetiro: {
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
            guardarmodalentrega();
        });
    
    </script>

<!-- script bootstrap validator -->
<script>

        $('#frmrect').bootstrapValidator({
            message: 'This value is not valid',
            /*feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },*/
            excluded: [':disabled'],
            fields: {
                numero: {
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
                fecha: {
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
                motivo: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z]+$/,
                            message: 'la entrada solo debe contener letras'
                        }
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    }
                },
                descripcion: {
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
                file: {
                        extension: 'doc,pdf',
                        type: 'application/msword,application/pdf',
                        //maxSize: 2048 * 1024,
                        message: 'The selected file is not valid'
                }
            }
        }).on('success.form.bv', function (e) {
            e.preventDefault();
            guardarmodalrectificativa();
        });
    
    </script>

<!-- script que muestra box de datos al dar click en boton agregar -->
<script>

    $("#botonAgregar").on("click", function () {

        $("#botonAgregar").attr("disabled", "");
        //$("#boxDatos").removeAttr("hidden");
        $("#boxDatos").show();

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