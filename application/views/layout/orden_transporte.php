<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
<!--  Box 1-->
    <div class="box">
        <div class="box-header with-border">
        </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-1 col-xs-12">
                            <label for="Nro" class="form-label">Nro:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="nro" id="Nro">
                    </div>
                    <div class="col-md-2 col-xs-12">
                            <label for="Nro de solicitud" class="form-label">Nro de solicitud:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="nrosolicitud" id="Nro de solicitud">
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row">
                    <div class="col-md-1 col-xs-12">
                            <label for="fecha" class="form-label">Fecha:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="date" id="fecha" value="2019-09-04" class="form-control">
                    </div>
                    <div class="col-md-2 col-xs-12">
                         <label for="dispfinal" class="form-label">Disposicion final:</label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="dispfinal">
                            <option value="" disabled selected>-Seleccione tipo-</option>
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
        <div class="box-header with-border">
        </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2 col-xs-12">
                         <label for="tipores" class="form-label">Tipo residuo:</label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="tipores">
                            <option value="" disabled selected>-Seleccione tipo-</option>
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
                            <option value="" disabled selected>-Seleccione tipo-</option>
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
                            <option value="" disabled selected>-Seleccione tipo-</option>
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
                <div class="row">
                    <div class="col-md-10 col-xs-12"></div>
                    <div class="col-md-2 col-xs-12 text-center">
                            <button type="button" class="btn btn-primary" aria-label="Left Align">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button><br>
                            <label for="agregar" class="form-label">Agregar</label>
                        </div>
                </div>
                <div class="row">
                    <i class="fas fa-ad"></i>
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
    <!--  Box 3-->
    <div class="box">
        <div class="box-header with-border">
        </div>
            <div class="box-header">
                <h3>Generador</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-1 col-xs-12">
                            <label for="Nro" class="form-label">Nro:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="nro" id="Nro">
                    </div>
                    <div class="col-md-2 col-xs-12">
                            <label for="Nro de solicitud" class="form-label">Nro de solicitud:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="nrosolicitud" id="Nro de solicitud">
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row">
                    <div class="col-md-1 col-xs-12">
                            <label for="fecha" class="form-label">Fecha:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="date" id="fecha" value="2019-09-04" class="form-control">
                    </div>
                    <div class="col-md-2 col-xs-12">
                         <label for="dispfinal" class="form-label">Disposicion final:</label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="dispfinal">
                            <option value="" disabled selected>-Seleccione tipo-</option>
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
    <!--  Box 4-->
    <div class="box">
        <div class="box-header with-border">
        </div>
            <div class="box-header">
                <h3>Transportistas</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-1 col-xs-12">
                            <label for="Nro" class="form-label">Nro:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="nro" id="Nro">
                    </div>
                    <div class="col-md-2 col-xs-12">
                            <label for="Nro de solicitud" class="form-label">Nro de solicitud:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="nrosolicitud" id="Nro de solicitud">
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row">
                    <div class="col-md-1 col-xs-12">
                            <label for="fecha" class="form-label">Fecha:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="date" id="fecha" value="2019-09-04" class="form-control">
                    </div>
                    <div class="col-md-2 col-xs-12">
                         <label for="dispfinal" class="form-label">Disposicion final:</label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="dispfinal">
                            <option value="" disabled selected>-Seleccione tipo-</option>
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
</body>
</html>