<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Template OT</title>
</head>
<body>
    
<!--  Box 1-->
    <div class="box">
            <div class="box-header with-border">
                <h3>Template de Orden de Transporte</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2 col-lg-1 col-xs-12">
                            <button type="button" class="btn btn-primary" aria-label="Left Align">
                                Agregar
                            </button><br>
                    </div>
                    <div class="col-md-10 col-lg-11 col-xs-12"></div>
                </div>
            </div>
    </div>
    <!--  Box 2-->
    <div class="box">
            <div class="box-header with-border">
                <h3>Informacion</h3>
            </div>
            <div class="box-body">
              <form id="formInfo" method="POST">
                <div class="row">
                    <div class="col-md-1 col-xs-12">
                         <label for="nro" class="form-label">Nro:</label>
                    </div>
                    <div class="col-md-2 col-xs-12">
                            <input size="10" type="text" name="nro" id="nro" required>
                    </div>
                    <div class="col-md-1 col-xs-12">
                            <label for="fecha" class="form-label">Fecha:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha;?>" class="form-control" required>
                    </div>
                    <div class="col-md-2 col-xs-12">
                         <label for="dispfinal" class="form-label">Disposicion final:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="dispfinal" name="dispfinal" required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php echo $disposicionFinal ?>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-1 col-xs-12">
                         <label for="zona" class="form-label">Zona:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="zona" name="zona" required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php echo $zona ?>
                        </select>
                    </div>
                    <div class="col-md-1 col-xs-12">
                        <label for="circuito" class="form-label">Circuito:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="circuito" name="circuito" required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php echo $circuito ?>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2 col-xs-12">
                        <label for="tiporesiduo" class="form-label">Tipo de residuo:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="tiporesiduo" name="tiporesiduo" required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php echo $tipoResiduo ?>
                        </select>
                    </div>
                    <div class="col-md-7"></div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-lg-11 col-xs-12"></div>
                    <div class="col-md-2 col-lg-1 col-xs-12 text-center">
                            <button type="submit"  onclick="agregarInfo()" class="btn btn-primary" aria-label="Left Align" id="btn_info">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button><br>
                            <label for="agregar" class="form-label">Agregar</label>
                    </div>
                </div>
              </form>
                <div class="row">
                    <em class="fas fa-ad"></em>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4>Transportistas</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form id="formTransp" method="POST">
                                <div class="row">
                                        <div class="col-md-2 col-xs-12">
                                            <label for="selecemp">Empresa:</label>
                                        </div>
                                        <select multiple="" class="col-md-3 col-xs-12" id="selecemp" name="empresa" required>
                                            <?php echo $empresas ?>
                                        </select>
                                        <!-- otro select -->
                                        <div class="col-md-2 col-xs-12">
                                            <label for="selecemp">Movilidad:</label>
                                        </div>
                                        <select multiple="" class="col-md-2 col-xs-12" id="selecmov" name="movilidad" required>
                                            
                                        </select>
                                        <div class="col-md-3"></div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-2 col-xs-12">
                                            <label for="registron" class="form-label">Registro n°:</label>
                                    </div>
                                    <div class="col-md-3 col-xs-12">
                                            <input type="text" name="registron" id="registron" name="numreg" required readonly>
                                    </div>
                                    <div class="col-md-2 col-xs-12">
                                            <label for="dominio" class="form-label">Dominio:</label>
                                    </div>
                                    <div class="col-md-3 col-xs-12">
                                            <input type="text" name="dominio" id="dominio" name="dominio" required readonly>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <br>
                                <div class="row">
                                           <div class="col-md-2 col-xs-12">
                                                <label for="chofer" class="form-label">Chofer:</label>
                                           </div>
                                           <div class="col-md-4 col-xs-12">
                                               <select class="form-control select2 select2-hidden-accesible" id="chofer" name="chofer" required>

                                               </select>
                                           </div>
                                           <div class="col-md-6"></div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-10 col-lg-11 col-xs-12"></div>
                                    <div class="col-md-2 col-lg-1 col-xs-12 text-center">
                                            <button type="submit" class="btn btn-primary" aria-label="Left Align" onclick="agregarTransp()">
                                                Guardar
                                            </button><br>
                                    </div>
                                </div>
                              </form>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>

            </div>
        </div>
    </div>
    <!--  Box 3-->
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
                    <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Acciones</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Zona</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Circuito</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Transportista</th><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Movilidad</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Chofer</th></tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="odd">
                    <td class="sorting_1"><button type="button" title="ok" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>&nbsp<button type="button" title="editar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp<button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp<button type="button" title="buscar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></td>
                    <td>Zona 1</td>
                    <td>Circuito 5</td>
                    <td>Transp 1</td>
                    <td>Asd 345</td>
                    <td>Hugo Gallardo</td>
                    </tr><tr role="row" class="even">
                    <td class="sorting_1"><button type="button" title="ok" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>&nbsp<button type="button" title="editar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp<button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp<button type="button" title="buscar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></td>
                    <td>Zona 5</td>
                    <td>Circuito 11</td>
                    <td>Transp 8</td>
                    <td>Asd 347</td>
                    <td>Fernando Leiva</td>
                    </tr></tbody>
                </table></div></div><br><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
</body>
</html>

<script>
    $(".emp").on('click', function() {
        
        //$dato = $(this).val();
        //alert($dato);

        var json = this.dataset.json;
        
        json = JSON.parse(json);
        //console.log(json);
        var html_mov = " ", html_chof = "";

        json.movilidades.movilidad.forEach(function(valor) {
           //console.log(valor.nombre);
           html_mov += "<option class='movilito' data-reg='"+valor.registro+"' data-dom='"+valor.dominio+"'>"+valor.nom_movil+"</option>"
        });

        json.choferes.chofer.forEach(function(valor){
            html_chof += "<option class='chof'>"+valor.nom_chofer+"</option>"
        });

        //console.log(html);
        $('#selecmov').html(html_mov);
        $("#chofer").html("<option value='' disabled selected>-Seleccione opcion-</option>"+html_chof);

        $("#registron").val("");
        $("#dominio").val("");
    });

    $("#selecmov").on('change', function() {

        var sel = $(this).find(":selected");
        $("#registron").val(sel.data('reg'));
        $("#dominio").val(sel.data('dom'));

    });
</script>

<!-- Script Agregar Informacion -->

<script>

function agregarInfo(){

    $('#formInfo').on('submit', function(e){

    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);

    datos=$('#formInfo').serialize();
    //console.log(datos);
    
    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Ordentrabajo/guardarInfo",
                success:function(r){
                    if(r == "ok"){
                        console.log(r);
                        $('#formInfo')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                },
                complete: function() {
                    me.data('requestRunning', false);
                }
            });
            
    });
    
}

</script>

<!-- Script Agregar Transportista -->

<script>

        function agregarTransp(){
        
        $('#formTransp').on('submit', function(e){
        
        e.preventDefault();    
        var me = $(this);  
        if ( me.data('requestRunning') ) {return;}
         me.data('requestRunning', true);
        
        datos=$('#formTransp').serialize();
        //console.log(datos);
        
        $.ajax({
                    type:"POST",
                    data: datos,
                    url: "ajax/Ordentrabajo/guardarTransp",
                    success:function(r){
                        //dato=jQuery.parseJSON(r)
                        if(r == "ok"){
                        console.log(r);
                        $('#formTransp')[0].reset();
                        $('#selecmov').find('option').remove();
                        alertify.success("Agregado con exito");
                      }
                    },
                    complete: function() {
                        me.data('requestRunning', false);
                    }
                });
                
        });
        }
        
</script>

