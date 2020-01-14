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

            <!--_____________________________________________-->
            <!--Codigo-->

            <div class="col-md-6">
                <div class="form-group">
                    <label for="Codigo">Codigo:</label>
                    <input type="text" class="form-control"  name="Codigo" id="Codigo">
                </div>
            </div>

            <!--_____________________________________________--> 
             <!--Chofer-->

            <div class="col-md-6">
                 <div class="form-group">
                    <label for="Chofer" >Chofer:</label>
                    <select class="form-control select2 select2-hidden-accesible" name="Chofer" id="Chofer">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Chofer as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!--_____________________________________________-->
            <!--Descripcion-->

            <div class="col-md-12">
                <div class="form-group">
                    <label for="Descripcion" >Descripcion:</label>
                    <textarea style="resize: none;" type="text" class="form-control" name="Descripcion" id="Descripcion"></textarea>
                </div>
            </div>

            <!--_____________________________________________-->
            <!--vehiculo-->

            <div class="col-md-6">          
                <div class="form-group">
                    <label for="Vehiculo">Vehiculo:</label>
                    <select class="form-control select2 select2-hidden-accesible"  name="Vehiculo" id="Vehiculo">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Vehiculo as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!--_____________________________________________-->
            <!--Tipo de residuo-->

            <div class="col-md-6">            
                <div class="form-group">
                    <label for="tipoResiduos" >Tipo de residuo:</label>
                    <select class="form-control select2 select2-hidden-accesible" name="tipoResiduos" id="tipoResiduos">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($tipoResiduos as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!--_________________SEPARADOR_________________-->

            <div class="col-md-12"> <hr></div>

            <!--_________________SEPARADOR_________________-->

            <!--_____________________________________________-->
            <!--Adjuntador de imagenes-->

            <div class="col-md-6">     

                <form action="cargar_archivo" method="post" enctype="multipart/form-data">

                    <button type="file" name="upload" class="btn btn-default btn-circle" aria-label="Left Align">
                        <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
                    </button>
                    <small for="agregar" class="form-label">Adjuntar imagen</small>

                </form>
            </div>

            <!--_________________SEPARADOR_________________-->

            <div class="col-md-12"> <hr></div>

            <!--_________________SEPARADOR_________________-->

                <div class="col-md-12">
                <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Agregar</button>
                </div>

        </div>
    </form>
</div>

  <!--____________________________________________________________________________________________-->

    <!-- <div class="col-md-12">

        <div class="box box-primary animated fadeInLeft">
            <div class="box-header with-border">
                    <h5>Registrar Punto Critico</h5>
                </div>
            </div>
        </div>

        
        <div class="col-md-12">

            <!--_____________________________________________--> 
            <!--Nombre-->

            <!-- <div class="col-md-6">
                <div class="form-group">
                    <label for="Nombre" name="Nombre">Nombre:</label>
                    <input type="text" class="form-control" id="Nombre">
                </div>
            </div> -->

            <!--_____________________________________________-->
            <!--Descripcion--> 
     
            <!-- <div class="col-md-6">            
                <div class="form-group">
                    <label for="Descripcion" name="Descripcion">Descripcion:</label>
                    <input type="text" class="form-control" id="Descripcion">
                </div>     

            </div>
        </div> -->

        <!--_________________SEPARADOR_________________-->

          <!-- <div class="col-md-12"> <hr></div> -->

        <!--_________________SEPARADOR_________________-->


            <!--_____________________________________________-->    
            <!--Boton de guardado-->
            
            <!-- <div class="col-md-12">
                <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Agregar</button>
            </div>

    </div> -->

    
  <!--____________________________________________________________________________________________-->




<!---//////////////////////////////////////--- FIN BOX 1---///////////////////////////////////////////////////////----->



<!---//////////////////////////////////////---BOX TABLA---///////////////////////////////////////////////////////----->

 
<div class="box box-primary ">
    

    <!--__________________TABLA___________________________-->
    <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 table-scroll">
                             <!--__________________HEADER TABLA___________________________-->
                    <table id="tabla_circuitos" class="table table-bordered table-striped">
                        <thead class="thead-dark" bgcolor="#eeeeee">

                            <th>Acciones</th>
                            <th>Codigo</th>
                            <th>Chofer</th>
                            <th>Vehiculo</th>
                            <th>Tipo de residuo</th>

                        </thead>

                        <!--__________________BODY TABLA___________________________-->

                        <tbody>
                        <tr>
                            <td>
                            <button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                            <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
                            <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalPunto"><span class="glyphicon glyphicon-record" aria-hidden="true"></span></button>&nbsp
                            <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp

                            </td>
                            <td>DATO</td>
                            <td>DATO</td>
                            <td>DATO</td>
                            <td>DATO</td>
                        </tr>

                        </tbody>
                    </table>

                    <!--__________________FIN TABLAa___________________________-->
                    </div>
                    </div><br>

                </div>
            </div>

<!---//////////////////////////////////////--- FIN BOX TABLA---///////////////////////////////////////////////////////----->

    <!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Circuito</h5>
            </div>

            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">

                <div class="modal-body">

                        <!--_____________________________________________-->
                        <!--Codigo-->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Codigo" name="Codigo">Codigo:</label>
                                        <input type="text" class="form-control" id="Codigo">
                                    </div>
                                </div>                        
                            </div>

                    <div class="row">

                        <div class="col-md-6">
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
                         </div>

                        <!--_____________________________________________-->
                        <!--Vehiculo-->

                        <div class="col-md-6">
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
                        </div>
                    </div>

                        <!--_____________________________________________-->
                        <!--Descripcion-->

                        <div class="row">                        
                            <div class="col-md-12">
                                <label for="Descripcion" name="Descripcion">Descripcion:</label>
                                <textarea style="resize: none;" type="text" class="form-control" id="Descripcion"></textarea>

                            </div>         
                        </div>
                    </div>
                </form>

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!---//////////////////////////////////////--- FIN MODAL EDITAR ---///////////////////////////////////////////////////////----->

    <!---//////////////////////////////////////--- MODAL INFORMACION ---///////////////////////////////////////////////////////----->

    <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion Circuito</h5>
            </div>

            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">

                <div class="modal-body">

                        <!--_____________________________________________-->
                        <!--Codigo-->

                            <div class="row">
                                <div class="col-md-6">

                                <!--_____________________________________________-->
                                <!--Codigo-->

                                    <div class="form-group">
                                        <label for="Codigo" name="Codigo">Codigo:</label>
                                        <input type="text" class="form-control" id="Codigo" readonly>
                                    </div>
                                </div> 

                                <!--_____________________________________________-->
                                <!--Vehiculo-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Vehiculo" name="Vehiculo">Vehiculo:</label>
                                        <input type="text" class="form-control" id="Vehiculo" readonly>                                
                                    </div>
                                </div>                       
                            </div>

                    <div class="row">

                        <div class="col-md-6">

                                <!--_____________________________________________-->
                                <!--Chofer-->

                                    <div class="form-group">
                                        <label for="Chofer" name="Chofer">Chofer:</label>
                                        <input type="text" class="form-control" id="Chofer" readonly>
                                    </div>

                        </div>

                                <!--_____________________________________________-->
                                <!--Tipo de residuo-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipoResiduos" name="tipoResiduos">Tipo de residuo:</label>
                                        <input type="text" class="form-control" id="tipoResiduos" readonly>                               
                                    </div>
                                </div>
                            </div>

                                <!--_____________________________________________-->
                                <!--Descripcion-->

                                <div class="row">                        
                                    <div class="col-md-12">
                                        <label for="Descripcion" name="Descripcion">Descripcion:</label>
                                        <textarea style="resize: none;" type="text" class="form-control" id="Descripcion" readonly></textarea>
                                    </div>         
                                </div>

                    <!--_______________________SEPARADOR______________________-->    

                    <div class="col-md-12"><br><hr><br></div>

                    <!--_______________________SEPARADOR______________________-->   

                    <div class="row"> 

                         <div class="col-md-12">

                            <div class="box-header bg-blue">
                                <h5>Punto Critico</h5>
                            </div>

                        </div>

                    </div>

                    <!--_______________________SEPARADOR______________________-->    

                    <div class="col-md-12"><br></div>

                    <!--_______________________SEPARADOR______________________--> 

                   <!--*******************************************-->

                    <div class="row">

                        <div class="col-md-12">

                            <div class="row"> 

                                <div class="col-md-6">

                                    <!--_____________________________________________-->
                                    <!--Nombre-->

                                    <div class="form-group">
                                        <label for="Nombre" name="Nombre">Nombre:</label>
                                        <input type="text" class="form-control" id="Nombre"readonly>
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <!--_____________________________________________-->
                                    <!--Descripcion-->

                                    <div class="form-group">
                                        <label for="Descripcion" name="Descripcion">Descripcion:</label>
                                        <input type="text" class="form-control" id="Descripcion" readonly>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12"><br><hr><br></div>

                            <div class="row">                        
                                <div class="col-md-12">

                                     <!--__________________HEADER TABLA___________________________-->

                                    <table id="tabla_puntos_criticos" class="table table-bordered table-striped">
                                        <thead class="thead-dark" bgcolor="#eeeeee">

                                            <th>Nombre</th>
                                            <th>Descripcion</th>
                                            <th>Ubicacion</th>

                                        </thead>

                                        <!--__________________BODY TABLA___________________________-->

                                        <tbody>
                                        <tr>

                                            <td>DATO</td>
                                            <td> DATO</td>
                                            <td>DATO</td>

                                        </tr>

                                        </tbody>
                                    </table>

                                     <!--__________________FIN TABLA___________________________-->
                                </div>         
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <!-- <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button> -->
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!---//////////////////////////////////////--- FIN MODAL INFORMACION ---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- MODAL PUNTO CRITICO ---///////////////////////////////////////////////////////----->

<div class="modal fade" id="modalPunto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Registrar punto critico</h5>
            </div>

            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="" class="registerForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 "> 
                            <div class="col-md-6 col-sm-6">

                                <!--_____________________________________________-->
                                <!--Nombre-->

                                <div class="form-group">
                                    <label for="Nombre" name="Nombre">Nombre:</label>
                                     <input type="text" class="form-control" id="Nombre">
                                </div>                            

                            </div>

                            <!--**************************************************-->

                            <div class="col-md-6 col-sm-6">

                                <!--_____________________________________________-->
                                <!--Descripcion-->

                                <div class="form-group">
                                    <label for="Descripcion" name="Descripcion">Descripcion:</label>
                                     <input type="text" class="form-control" id="Descripcion">
                                </div>                                          

                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!---//////////////////////////////////////--- FIN MODAL PUNTO CRITICO ---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- SCRIPTS ---///////////////////////////////////////////////////////----->

<!--_____________________________________________--> 
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

<!--_____________________________________________--> 
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

<!--_____________________________________________--> 
<!-- Script Data-Tables-->

<script>
DataTable($('#tabla_circuitos'))

DataTable($('#tabla_puntos_criticos'))
</script>