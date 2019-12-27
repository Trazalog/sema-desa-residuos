                    }
<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Circuitos</h4>
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
        <div class="box-tools pull-right border ">
            <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                data-toggle="tooltip" title="" data-original-title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
        
    </div>
    <!--_____________________________________________-->

    <div class="box-body">
    <form class="formCircuitos" id="formCircuitos">
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
                    <textarea style="resize: none;" type="text" class="form-control" id="Descripcion"></textarea>
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
                    <label for="tipoResiduos" name="tipoResiduos">Tipo de residuo:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="tipoResiduos">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($tipoResiduos as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
            <!--_____________________________________________-->

    </div>

    <div class="col-md-12"> <hr></div>

    <div class="col-md-6">

            <!--Adjuntador de imagenes-->
                <br>
                <form action="cargar_archivo" method="post" enctype="multipart/form-data">
                    <input  type="file" name="upload">
                </form>
            <!--_____________________________________________-->

    </div>

    <div class="col-md-12"> <hr></div>
    <div class="col-md-12">
    <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Agregar</button>
    </div>


    <!--__________________SEPARADOR___________________________-->

    <div class="col-md-12"> <br></div>

    <!--________________SEPARADOR_____________________________-->

    <div class="col-md-12">
    <div class="box-header bg-blue">
                <h5>Registrar Punto Critico</h5>
            </div>
        </div>

        <!--__________________SEPARADOR___________________________-->

        <div class="col-md-12"> <br></div>

        <!--________________SEPARADOR_____________________________-->
        <div class="col-md-12">
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

    </div>
    </div>

    <div class="col-md-12"> <hr></div>
    <!--_____________________________________________-->    
    <!--Boton de guardado-->
    <div class="col-md-12">
    <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Agregar</button>
    </div>
    
    
    </div>

    
    </form>
</div>




<!---//////////////////////////////////////--- FIN BOX 1---///////////////////////////////////////////////////////----->



<!---//////////////////////////////////////---BOX 2---///////////////////////////////////////////////////////----->




 
<div class="box box-primary animated fadeInLeft">
    

    <!--__________________TABLA___________________________-->
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
                                            aria-label="Rendering engine: activate to sort column descending">Acciones</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending">Codigo
                                        </th>                                        
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Engine version: activate to sort column ascending">
                                            Chofer</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Vehiculo
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending">Tipo de residuo
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tabadd">
                                    <tr role="row" class="even" id="primero" hidden>
                                        <td class="sorting_1"><button type="button" title="ok" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>&nbsp<button type="button" title="editar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp<button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp<button type="button" title="buscar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></td>
                                        <td>Circuito 5</td>
                                        <td>Transp 1</td>
                                        <td>Asd 345</td>
                                        <td>Hugo Gallardo</td>
                                        
                                    </tr>
                                    
                    <tr role="row" class="even">
                    <td class="sorting_1">
                    <button type="button" title="editar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                    <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp</td>
                    <td>Zona 5</td>
                    <td>Circuito 11</td>
                    <td>Transp 8</td>
                    <td>Asd 347</td>
                    
                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><br>
                    
                </div>
            </div>
            





            
<!---//////////////////////////////////////--- FIN BOX 2---///////////////////////////////////////////////////////----->


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

<!-- Script Data-Tables-->

<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'autoFill'    : true,
      'buttons'     :true,
      'fixedHeader': true,
        dom: 'Bfrtip',
        buttons: [
             'excel', 'pdf', 'print'
        ]
    })
  })
</script>

