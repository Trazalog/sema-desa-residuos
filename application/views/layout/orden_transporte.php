<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orden de transporte</title>
</head>
<body>
    
<!--  Box 1-->
    <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-1 col-xs-12">
                            <label for="Nro" class="form-label">Nro:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="nro" id="Nro" value=<?php echo rand(1,30)?>>
                    </div>
                    <div class="col-md-2 col-xs-12">
                            <label for="Nro de solicitud" class="form-label">Nro de solicitud:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="nrosolicitud" id="Nro de solicitud">
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-1 col-xs-12">
                            <label for="fecha" class="form-label">Fecha:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="date" id="fecha" value="<?php echo $fecha;?>" class="form-control">
                    </div>
                    <div class="col-md-2 col-xs-12">
                         <label for="dispfinal" class="form-label">Disposicion final:</label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="dispfinal">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                            foreach($establecimientos as $fila)
                            {
                                echo '<option value="'.$fila->id.'" >'.$fila->titulo.'</option>';
                            } 
                            ?>
                        </select>
                    </div>
                </div>
            </div>
      </div>
    </div>
    <!--  Box 2-->
    <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2 col-xs-12">
                         <label for="tipores" class="form-label">Tipo residuo:</label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="tipores">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                            foreach($establecimientos as $fila)
                            {
                                echo '<option value="'.$fila->id.'" >'.$fila->titulo.'</option>';
                            } 
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 col-xs-12">
                         <label for="contenedor" class="form-label">Contenedor:</label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="contenedor">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                            foreach($establecimientos as $fila)
                            {
                                echo '<option value="'.$fila->id.'" >'.$fila->titulo.'</option>';
                            } 
                            ?>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2 col-xs-12">
                         <label for="porcentajell" class="form-label">% de llenado:</label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="porcentajell">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                            foreach($establecimientos as $fila)
                            {
                                echo '<option value="'.$fila->id.'" >'.$fila->titulo.'</option>';
                            } 
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 col-xs-12">
                            <label for="metroscubicos" class="form-label">Metros cubicos:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="nrosolicitud" id="metroscubicos">
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-10 col-lg-11 col-xs-12"></div>
                    <div class="col-md-2 col-lg-1 col-xs-12 text-center">
                            <button type="button" class="btn btn-primary" aria-label="Left Align">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button><br>
                            <label for="agregar" class="form-label">Agregar</label>
                    </div>
                </div>
                <div class="row">
                    <em class="fas fa-ad"></em>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Tipo de residuo</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Contenedor</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">% de llenado</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Metros cubicos</th></tr>
                            </thead>
                            <tbody>
                            <tr role="row" class="odd">
                            <td class="sorting_1">Gecko</td>
                            <td>Netscape 7.2</td>
                            <td>Win 95+ / Mac OS 8.6-9.2</td>
                            <td>1.7</td>
                            </tr><tr role="row" class="even">
                            <td class="sorting_1">Gecko</td>
                            <td>Netscape Browser 8</td>
                            <td>Win 98SE+</td>
                            <td>1.7</td>
                            </tr><tr role="row" class="odd">
                            <td class="sorting_1">Gecko</td>
                            <td>Netscape Navigator 9</td>
                            <td>Win 98+ / OSX.2+</td>
                            <td>1.8</td>
                            </tr><tr role="row" class="even">
                            <td class="sorting_1">Gecko</td>
                            <td>Mozilla 1.0</td>
                            <td>Win 95+ / OSX.1+</td>
                            <td>1</td>
                            </tr></tbody>
                            <tfoot>
                            <tr><th rowspan="1" colspan="1">Tipo de residuo</th><th rowspan="1" colspan="1">Contenedor</th><th rowspan="1" colspan="1">% de llenado</th><th rowspan="1" colspan="1">Metros cubicos</th></tr>
                            </tfoot>
                        </table></div></div><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div></div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>
    </div>
    <!--  Box 3-->
    <div class="box">
            <div class="box-header with-border">
                <h3>Generador</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-1 col-xs-12">
                            <label for="razonsocial" class="form-label">Razon social:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="rsocial" id="razonsocial">
                    </div>
                    <div class="col-md-2 col-xs-12">
                            <label for="dep" class="form-label">Departamento:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="departamento" id="dep">
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-1 col-xs-12">
                            <label for="cuitdni" class="form-label">Cuit/dni:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="cuitdni" id="cuitdni">
                    </div>
                    <div class="col-md-2 col-xs-12">
                            <label for="circuito" class="form-label">Circuito:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="circuito" id="circuito">
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
      </div>
    </div>
    <!--  Box 4-->
    <div class="box">
            <div class="box-header with-border">
                <h3>Transportistas</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2 col-xs-12">
                        <label for="selecemp">Empresa:</label>
                    </div>
                    <select multiple="" class="col-md-3 col-xs-12" id="selecemp">
                        <?php echo $empresas ?>
                    </select>
                    <!-- otro select -->
                    <div class="col-md-2 col-xs-12">
                        <label for="selecemp">Movilidad:</label>
                    </div>
                    <select multiple="" class="col-md-2 col-xs-12" id="selecemp">
                        <?php echo $movilidad ?>
                    </select>
                    <div class="col-md-3"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2 col-xs-12">
                            <label for="registron" class="form-label">Registro n°:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="registron" id="registron">
                    </div>
                    <div class="col-md-2 col-xs-12">
                            <label for="dominio" class="form-label">Dominio:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="dominio" id="dominio">
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
      </div>
    </div>
    <!--  Box 5-->
    <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2 col-xs-12">
                         <label for="chofer" class="form-label">Chofer:</label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="chofer">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php echo $chofer?>
                        </select>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2 col-xs-12">
                            <label for="fecha" class="form-label">Fecha de retiro:</label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                            <input type="date" id="fecha" value="<?php echo $fecha;?>" class="form-control">
                    </div>
                    <div class="col-md-1 col-xs-12">
                         <label for="hora" class="form-label">Hora:</label>
                    </div>
                    <div class="col-md-2 col-xs-12">
                            <input type="number" id="hora" value="1" class="form-control" min="1">
                    </div>
                </div>
            </div>
      </div>
    </div>
</body>
</html>