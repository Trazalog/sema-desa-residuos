<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrar Generadores</title>
</head>
<body>
    
<!--  Box 1-->
    <div class="box">
            <div class="box-body">
                <div class="row">
                    <!--Formulario Registrar Generadores-->
                    <!--Nombre/Razon social-->
                    <div class="col-md-1 col-xs-12">
                            <label for="Nombre/Razon social" class="form-label">Nombre/Razon social:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="nombrerazon" id="Nombre/Razon social" value=<?php echo rand(1,30)?>>
                    </div>
                    <br>
                    <!--____________________________________________________________________________-->
                    <!--CUIT-->
                    <div class="col-md-1 col-xs-12">
                            <label for="CUIT" class="form-label">CUIT:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="cuit" id="CUIT" value=<?php echo rand(1,30)?>>
                    </div>
                    <br>
                    <!--____________________________________________________________________________-->
                    <!--Zona-->
                    <div class="col-md-2 col-xs-12">
                         <label for="Zona" class="form-label">Zona:</label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="Zona">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                    foreach ($disposicionFinal as $i) {
                                        echo '<option>'.$i->nombre.'</option>';
                                    }
                            ?>
                        </select>
                    </div>
                    <br>
                    <!--____________________________________________________________________________-->
                    <!--Rubro-->
                    <div class="col-md-1 col-xs-12">
                            <label for="Rubro" class="form-label">Rubro:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="rubro" id="Rubro" value=<?php echo rand(1,30)?>>
                    </div>
                    <br>
                    <!--____________________________________________________________________________-->
                    <!--Tipo-->
                    <div class="col-md-2 col-xs-12">
                         <label for="Tipo" class="form-label">Tipo:</label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="Tipo">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                    foreach ($disposicionFinal as $i) {
                                        echo '<option>'.$i->nombre.'</option>';
                                    }
                            ?>
                        </select>
                    </div>
                    <br>
                    <!--____________________________________________________________________________-->
                    <!--Domicilio-->
                    <div class="col-md-1 col-xs-12">
                            <label for="Domicilio" class="form-label">Domicilio:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="domicilio" id="Domicilio" value=<?php echo rand(1,30)?>>
                    </div>
                    <br>
                    <!--____________________________________________________________________________-->
                    <!--Departamento-->
                    <div class="col-md-2 col-xs-12">
                         <label for="Tipo" class="form-label">Tipo:</label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <select class="form-control select2 select2-hidden-accesible" id="Tipo">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                    foreach ($disposicionFinal as $i) {
                                        echo '<option>'.$i->nombre.'</option>';
                                    }
                            ?>
                        </select>
                    </div>
                    <br>
                    <!--____________________________________________________________________________-->
                    <!--Numero de registro-->
                    <div class="col-md-2 col-xs-12">
                            <label for="Nro de registro" class="form-label">Nro de registro:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="nroregistro" id="Nro de registro">
                    </div>
                    <br>
                    <!--____________________________________________________________________________-->
                    <!--Tipo de residuos-->
                    <div class="col-md-1 col-xs-12">
                            <label for="Tipo de residuos" class="form-label">Tipo de residuos:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="tiporesiduos" id="Tipo de residuos" value=<?php echo rand(1,30)?>>
                    </div>
                    <br>
                    <!--BOTON DE GUARDADO DEL FORMULARIO REGISTRAR GENERADORES-->
                    <div class="row">
                        <div class="col-md-10 col-lg-11 col-xs-12"></div>
                        <div class="col-md-2 col-lg-1 col-xs-12 text-center">
                            <button type="submit" class="btn btn-primary" aria-label="Left Align" onclick="agregarDato()">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button><br>
                            <label for="agregar" class="form-label">Guardar</label>
                        </div>
                    </div>
                    <!--____________________________________________________________________________-->
                    <!--Fin del formulario Registrar Generadores-->




                    <!--A partir de aqui todo el codigo a continuacion no formara parte de la 
                    view/layout/registrar_generadores.php-->
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
                                    foreach ($disposicionFinal as $i) {
                                        echo '<option>'.$i->nombre.'</option>';
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
              <form autocomplete="off" id="formDatos" method="POST">
                <div class="row">
                    <div class="col-md-2 col-xs-12">
                         <label for="tipores" class="form-label">Tipo residuo:</label>
                    </div>
                    <div class="col-md-4 col-xs-12">
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
                    <div class="col-md-4 col-xs-12">
                         <input type="number" id="contenedor" name="contenedor" class="form-control" min="1" required pattern="^(0|[1-9][0-9]*)$">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2 col-xs-12">
                         <label for="porcentajell" class="form-label">% de llenado:</label>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <input type="number" step="0.0001" id="porcentajell" name="porcent_llenado" class="form-control" min="0" max="100" required pattern="[+]?[0-9]*\.?[0-9]*">
                    </div>
                    <div class="col-md-2 col-xs-12">
                            <label for="metroscubicos" class="form-label">Metros cubicos:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="number" step="0.0001" name="metroscubicos" class="form-control" id="metroscubicos" min="0" required pattern="[+]?[0-9]*\.?[0-9]*">
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-10 col-lg-11 col-xs-12"></div>
                    <div class="col-md-2 col-lg-1 col-xs-12 text-center">
                            <button type="submit" class="btn btn-primary" aria-label="Left Align" onclick="agregarDato()">
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
                        <!-- /.box-header -->
                        <div class="box-body">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Tipo de residuo</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Contenedor</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">% de llenado</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Metros cubicos</th></tr>
                            </thead>
                            <tbody>

                            <tr role="row" class="even" id="primero">
                            <td>residuo radioactivo</td>
                            <td>3</td>
                            <td>23</td>
                            <td>1.5</td>
                            </tr>
                            
                            </tbody>
                            
                        </table><br></div></div><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div></div>
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
                            <input type="text" name="rsocial" id="razonsocial" readonly>
                    </div>
                    <div class="col-md-2 col-xs-12">
                            <label for="dep" class="form-label">Departamento:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="departamento" id="dep" readonly>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-1 col-xs-12">
                            <label for="cuitdni" class="form-label">Cuit/dni:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="cuitdni" id="cuitdni" readonly>
                    </div>
                    <div class="col-md-2 col-xs-12">
                            <label for="circuito" class="form-label">Circuito:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="circuito" id="circuito" readonly>
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
                    <select multiple="" class="col-md-3 col-xs-12" id="selecemp" name="empresa">
                        <?php
                            foreach ($empresa as $i) {
                                echo '<option class="emp" data-json=\''.json_encode($i).'\'>'.$i->nom->nom_emp.'</option>';
                            }
                        ?>
                    </select>
                    <!-- otro select -->
                    <div class="col-md-2 col-xs-12">
                        <label for="selecmov">Movilidad:</label>
                    </div>
                    <select multiple="" class="col-md-2 col-xs-12" id="selecmov">
                    </select>
                    <div class="col-md-3"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2 col-xs-12">
                            <label for="registron" class="form-label">Registro n°:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="registron" id="registron" readonly>
                    </div>
                    <div class="col-md-2 col-xs-12">
                            <label for="dominio" class="form-label">Dominio:</label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                            <input type="text" name="dominio" id="dominio" readonly>
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

<!-- Script para mostrar por empresa las movilidades y choferes disponibles y por movilidad su respectiva informacion -->
<script>
        $(".emp").on('click', function() {
    
            var json = this.dataset.json;
            
            json = JSON.parse(json);
    
            var html_mov = " ", html_chof = "";
    
            json.movilidades.movilidad.forEach(function(valor) {
               html_mov += "<option class='movilito' data-reg='"+valor.registro+"' data-dom='"+valor.dominio+"'>"+valor.nom_movil+"</option>"
            });
    
            json.choferes.chofer.forEach(function(valor){
                html_chof += "<option class='chof'>"+valor.nom_chofer+"</option>"
            });
    
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

<!-- Script Agregar datos -->

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
        var porcent_llenado = getValue("porcent_llenado");
        var metroscubicos = getValue("metroscubicos");
        //--------------------------------------------------------------
        
    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Ordentrabajo/guardarResiduo",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        html = '<tr role="row" class="even"><td>'+tipo_residuo+'</td><td>'+contenedor+'</td><td>'+porcent_llenado+'</td><td>'+metroscubicos+'</td></tr>';
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

    
    <!-- Script Agregar Residuo -->
    
    <script>

    function agregarResiduo(){
    
        $('#formResiduo').on('submit', function(e){
        //console.log("aloha madrefoca");
        e.preventDefault();
        var me = $(this);
        if ( me.data('requestRunning') ) {return;}
        me.data('requestRunning', true);
    
        datos=$('#formResiduo').serialize();
        $.ajax({
                    type:"POST",
                    data:datos,
                    url:"ajax/Ordentrabajo/guardarResiduo",
                    success:function(r){
                        if(r == "ok"){
                            console.log(r);
                            $('#formResiduo')[0].reset();
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