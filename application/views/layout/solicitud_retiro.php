        <div class="box box-primary animated fadeInLeft">
            <div class="box-header with-border">
                <h3>Solicitud de retiro</h3>
            </div>
            <br>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-1 col-xs-12">
                            <label for="Nro" class="form-label">Nro:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="nro" id="Nro" value=<?php echo rand(1,30)?>>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-1 col-xs-12">
                            <label for="fecha" class="form-label">Fecha:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="date" id="fecha" value="<?php echo $fecha;?>" class="form-control">
                    </div>
                </div>
                <br>
                <hr>
                <br>
                <form autocomplete="off" id="formDatos" method="POST">
                <div class="row">
                    <div class="col-md-2 col-xs-12">
                         <label for="tipores" class="form-label">Tipo residuo:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="tipores" name="tipo_residuo" required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                    foreach ($tipoResiduo as $i) {
                                        echo '<option>'.$i->nombre.'</option>';
                                    }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 col-xs-12">
                         <label for="contenedor" class="form-label">Contenedor:</label>
                    </div>
                    <div class="col-md-2 col-xs-12">
                         <input type="number" id="contenedor" name="contenedor" class="form-control" min="1" required pattern="^(0|[1-9][0-9]*)$">
                    </div>
                    <div class="col-md-1 col-xs-12">
                            <label for="Nro" class="form-label">Otro:</label>
                    </div>
                    <div class="col-md-2 col-xs-12">
                         <input type="text" id="otro" name="otro" class="form-control">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-10 col-lg-11 col-xs-12"></div>
                    <div class="col-md-2 col-lg-1 col-xs-12 text-center">
                            <button type="submit" class="btn btn-primary btn-circle" aria-label="Left Align" onclick="agregarDato()">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button><br>
                            <small for="agregar" class="form-label">Agregar</small>
                    </div>
                </div>
              </form>
              <br>
                <div class="row">
                    <div class="col-xs-12">
                        <!-- /.box-header -->
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Tipo de residuo</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Cantidad de contenedores</th></tr>
                            </thead>
                            <tbody>
​
                            <tr role="row" class="even" id="primero">
                            <td>residuo radioactivo</td>
                            <td>3</td>
                            </tr>
                            
                            </tbody>
                            
                        </table><br></div></div><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div></div>
                        </div>
                </div>
                <br>
                <hr>
                
                    <div class="row">
                        <div class="box-header with-border">
                            <h3>Transportistas</h3>
                        </div>
                        <br>
                        <div class="col-md-2 col-xs-12">
                            <label for="selecemp">Empresa:</label>
                        </div>
                        <select multiple="" class="col-md-3 col-xs-12" id="selecemp" name="empresa">
                            <?php
                                foreach ($empresa as $i) {
                                    echo '<option class="emp" data-json=\''.json_encode($i).'\'>'.$i->nom->nom_emp.'</option>';
                                }
                            ?>
                        </select>
                        <!-- otro select -->
                        <div class="col-md-7"></div>
                    </div>
                    <br>
                    <hr>
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
        

<script>
    function agregarDato(){
        $('#formDatos').on('submit', function(e){

            e.preventDefault();
            var me = $(this);
            if ( me.data('requestRunning') ) {return;}
            me.data('requestRunning', true);

            datos=$('#formDatos').serialize();

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

            $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Ordentrabajo/guardarRes",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        html = '<tr role="row" class="even"><td>'+tipo_residuo+'</td><td>'+contenedor+'</td>';
                        $('#primero').after(html);
                        $('#formDatos')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formDatos')[0].reset();
                        alertify.error("error al agregar");
                    }
                },
                complete: function() {
                    me.data('requestRunning', false);
                }
            });
        });
    }
</script>