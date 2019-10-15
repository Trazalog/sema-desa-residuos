<div class="box box-primary">
    <div class="box-header">
        <div class="box-tittle">
            <h3>Registrar Circuitos</h3>  
        </div>
    </div>
    <!--_____________________________________________-->
    <div class="box-body">
    <form class="formZonas" id="formZonas">
    <div class="col-md-6">
            <!--Codigo-->
                <div class="form-group">
                    <label for="Codigo" name="Codigo">Codigo:</label>
                    <input type="text" class="form-control" id="Codigo">
                </div>
            <!--_____________________________________________-->
    </div>        
    <div class="col-md-6">
            <!--Chofer-->
                <div class="form-group">
                    <label for="Chofer" name="Chofer">Chofer:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Chofer">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Chofer as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
            <!--_____________________________________________-->
    </div>
    <div class="col-md-12">
            <!--Descripcion-->
                <div class="form-group">
                    <label for="Descripcion" name="Descripcion">Descripcion:</label>
                    <input type="text" class="form-control" id="Descripcion">
                </div>
            <!--_____________________________________________-->
    </div>
    <div class="col-md-6">
            <!--Vehiculo-->
                <div class="form-group">
                    <label for="Vehiculo" name="Vehiculo">Vehiculo:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Vehiculo">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Vehiculo as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
            <!--_____________________________________________-->
    </div>
    <div class="col-md-6">
            <!--Tipo de residuo-->
                <div class="form-group">
                    <label for="Tiporesiduo" name="Tipo_residuo">Tipo de residuo:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Tiporesiduo">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Tiporesiduo as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
            <!--_____________________________________________-->
    </div>
    <div class="col-md-6">
            <!--Adjuntador de imagenes-->
                <br>
                <form action="cargar_archivo" method="post" enctype="multipart/form-data">
                    <input  type="file" name="upload">
                </form>
            <!--_____________________________________________-->
    </div>
    </div>
    </form>
</div>
<div class="box box-primary">
    <div class="box-header">
        <div class="box-tittle">
            <h3>Registrar Punto Critico</h3>  
        </div>
    </div>
    <!--_____________________________________________-->
<div class="box-body">
<form class="formZonas" id="formZonas">
    <div class="col-md-6">
            <!--Nombre-->
                <div class="form-group">
                    <label for="Nombre" name="Nombre">Nombre:</label>
                    <input type="text" class="form-control" id="Nombre">
                </div>
            <!--_____________________________________________-->
    </div>
    <div class="col-md-6">
            <!--Descripcion-->
                <div class="form-group">
                    <label for="Descripcion" name="Descripcion">Descripcion:</label>
                    <input type="text" class="form-control" id="Descripcion">
                </div>
            
            <!--_____________________________________________-->
    </div>
    <hr>
        <!--Tabla de informacion que devuelve los datos del Punto Critico-->    
        <div class="row">
            <em class="fas fa-ad"></em>
        </div>
        <div class="row">
        <div class="col-xs-12">
        <div class="box box-primary">
        <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
        <thead>
            <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Nombre</th><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Descripcion</th></tr>
        </thead>
        <!--_____________________________________________-->
        <tbody id="tabadd">
            <tr role="row" class="even" id="primero">
            <td>Roberto Basañes</td>
            <td>Desarrollador</td>
            <td class="sorting_1"><button type="button" title="ok" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>&nbsp<button type="button" title="editar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp<button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp<button type="button" title="buscar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></td>
            </tr>
        </tbody>
        </table></div></div><br><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div></div>
        </div>
        </div>
        </div>
        <!--_____________________________________________-->
                <!--Boton de guardado-->
                <br>
                <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
                <!--_____________________________________________-->
            <!--_____________________________________________-->
        </div>
    </form>
</div>



<!-- Script Agregar datos -->

<script>

function agregarDato(){

    $('#formCircuitos').on('submit', function(e){

    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);

    datos=$('#formCircuitos').serialize();
    
        //datos para mostrar a modo de ejemplo para DEMO---------------
        //Serialize the Form
        var values = {};
        $.each($("#formCircuitos").serializeArray(), function (i, field) {
            values[field.name] = field.value;
        });
        //Value Retrieval Function
        var getValue = function (valueName) {
            return values[valueName];
        };
        //Retrieve the Values
        var nombre = getValue("nombre");
        var descripcion = getValue("descripcion");
        //--------------------------------------------------------------
        
    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registrarcircuito/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        html = '<tr role="row" class="even"><td>'+nombre+'</td><td>'+descripcion+'</td><td class="sorting_1"><button type="button" title="ok" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>&nbsp<button type="button" title="editar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp<button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp<button type="button" title="buscar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></td></tr>';
                        $('#primero').after(html);
                        $('#formCircuitos')[0].reset();
                        $('#selecmov').find('option').remove();
                        $("#boxDatos").hide();
                        $("#botonAgregar").removeAttr("disabled");
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formCircuitos')[0].reset();
                        $('#selecmov').find('option').remove();
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