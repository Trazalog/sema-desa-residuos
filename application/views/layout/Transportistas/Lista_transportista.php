<!--__________________HEADER TABLA___________________________-->


<table id="tabla_transportistas" class="table table-bordered table-striped">
    <thead class="thead-dark" bgcolor="#eeeeee">

    <th>Acciones</th>
    <th>Nombre / Razon social</th>
    <th>Descripcion</th>
    <th>Registro</th>
    <!-- <th>Tipo</th> -->


    </thead>

    <!--__________________BODY TABLA___________________________-->

    <tbody>
    <?php
                    if($transportistas)
                    {
                        foreach($transportistas as $fila)
                        {
                        echo '<tr data-json:'.json_encode($fila).'>';
                        echo    '<td>';
                        echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
                                <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';                            
                        echo   '</td>';
                        echo    '<td>'.$fila->razon_social.'</td>';
                        echo    '<td>'.$fila->descripcion.'</td>';
                        echo    '<td>'.$fila->registro.'</td>';                       
                        echo '</tr>';
                    }
                    }
                    ?>
    </tbody>
</table>

<!--__________________FIN TABLAa___________________________-->

<!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->

    
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Transportista</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                <div class="modal-body">

                

                    <div class="row">
                        <div class="col-md-6">

                            <!--_____________________________________________-->
                             <!--Nombre/Razon social-->

                            <div class="form-group">
                                <label for="Nombre/Razon social" name="Nombre_razon">Nombre / Razon social:</label>
                                <input type="text" class="form-control" id="Nombre/Razon social">
                            </div>
                        </div>

                        <div class="col-md-6">

                            <!--_____________________________________________-->
                             <!--Registro-->

                            <div class="form-group">
                                <label for="Registro" name="Registro">Registro:</label>
                                <input type="text" class="form-control" id="Registro">
                            </div>
                        </div>                         
                    </div>

                

                <div class="row">

                        <div class="col-md-6">

                            <!--_____________________________________________-->
                            <!--Direccion-->

                            <div class="form-group">
                                <label for="Direccion" name="Direccion">Direccion:</label>
                                <input type="text" class="form-control" id="Direccion">
                            </div>

                            <!--_____________________________________________-->
                            <!--Telefono-->

                            <div class="form-group">
                                 <label for="Telefono" name="Telefono">Telefono:</label>
                                 <input type="text" class="form-control" id="Telefono">
                            </div>
                         </div>

                

                        <div class="col-md-6">

                            <!--_____________________________________________-->
                            <!--Zona-->

                            <div class="form-group">
                            <label for="Zonag" name="Zona">Zona:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="Zonag">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                    // foreach ($Zonag as $i) {
                                    //     echo '<option>'.$i->nombre.'</option>';
                                    // }
                                    ?>
                                </select>
                            </div>

                            <!--_____________________________________________-->
                            <!--Fecha de alta-->                

                            <div class="form-group">
                                <label for="Fechalta" name="Fecha_de_alta" class="form-label label-sm">Fecha de alta:</label>                                              
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control pull-right" id="fecha-alta">
                                </div>
                                
                            </div>
                        </div>
                </div>

                

                <div class="row">

                    <div class="col-md-6"> 
                        <!--_____________________________________________-->
                        <!--Descripcion-->

                            <div class="form-group">
                                <label for="Descripcion" name="Descripcion">Descripcion:</label>
                                <input type="text" class="form-control" id="Descripcion">                                                               
                            </div>

                        <!--_____________________________________________-->
                        <!--Contacto-->

                            <div class="form-group">
                                <label for="Contacto" name="Contacto">Contacto:</label>
                                <input type="text" class="form-control" id="Contacto">
                                
                            </div>
                    </div>

                    <div class="col-md-6"> 

                            <!--_____________________________________________-->
                            <!--Fecha baja-->

                            <div class="form-group">
                                <label for="Fechabaja" name="Fecha_de_baja">Fecha de baja:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control pull-right" id="fecha-baja">
                                </div>
                            </div>

                            <!--_____________________________________________-->
                            <!--Tipo RSU autorizado-->

                            <div class="form-group">
                                <label for="Rsu" name="Rsu">Tipo de RSU autorizado:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="Rsu">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        // foreach ($Rsu as $i) {
                                        //     echo '<option>'.$i->nombre.'</option>';
                                        // }
                                    ?>
                                    </select>
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


<!---//////////////////////////////////////--- FIN MODAL EDITAR ---///////////////////////////////////////////////////////----->
<!---//////////////////////////////////////--- MODAL INFORMACION ---///////////////////////////////////////////////////////----->

    
<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion Transportista</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                <div class="modal-body">

                
                <div class="row">
                        <div class="col-md-6">

                            <!--_____________________________________________-->
                             <!--Nombre/Razon social-->

                            <div class="form-group">
                                <label for="Nombre/Razon social" name="Nombre_razon">Nombre / Razon social:</label>
                                <input type="text" class="form-control pull-right" id="" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <!--_____________________________________________-->
                             <!--Registro-->

                            <div class="form-group">
                                <label for="Registro" name="Registro">Registro:</label>
                                <input type="text" class="form-control pull-right" id="" readonly>
                            </div>
                        </div>                         
                    </div>

                

                <div class="row">

                        <div class="col-md-6">

                            <!--_____________________________________________-->
                            <!--Direccion-->

                            <div class="form-group">
                                <label for="Direccion" name="Direccion">Direccion:</label>
                                <input type="text" class="form-control pull-right" id="" readonly>
                            </div>

                            <!--_____________________________________________-->
                            <!--Telefono-->

                            <div class="form-group">
                                 <label for="Telefono" name="Telefono">Telefono:</label>
                                 <input type="text" class="form-control pull-right" id="" readonly>
                            </div>
                         </div>

                

                        <div class="col-md-6">

                            <!--_____________________________________________-->
                            <!--Zona-->

                            <div class="form-group">
                                <label for="Zonag" name="Zona">Zona:</label>
                                <input type="text" class="form-control pull-right" id="" readonly>
                            </div>

                            <!--_____________________________________________-->
                            <!--Fecha de alta-->                

                            <div class="form-group">
                                <label for="Fechalta" name="Fecha_de_alta" class="form-label label-sm">Fecha de alta:</label>                                              
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="" readonly>
                                </div>
                                
                            </div>
                        </div>
                </div>

                

                <div class="row">

                    <div class="col-md-6"> 
                        <!--_____________________________________________-->
                        <!--Descripcion-->

                            <div class="form-group">
                                <label for="Descripcion" name="Descripcion">Descripcion:</label>
                                <input type="text" class="form-control pull-right" id="" readonly>                                                              
                            </div>

                        <!--_____________________________________________-->
                        <!--Contacto-->

                            <div class="form-group">
                                <label for="Contacto" name="Contacto">Contacto:</label>
                                <input type="text" class="form-control pull-right" id="" readonly>                                
                            </div>
                    </div>

                    <div class="col-md-6"> 

                            <!--_____________________________________________-->
                            <!--Fecha baja-->

                            <div class="form-group">
                                <label for="Fechabaja" name="Fecha_de_baja">Fecha de baja:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="" readonly>
                                </div>
                            </div>

                            <!--_____________________________________________-->
                            <!--Tipo RSU autorizado-->

                            <div class="form-group">
                                <label for="Rsu" name="Rsu">Tipo de RSU autorizado:</label>
                                <input type="text" class="form-control pull-right" id="" readonly>
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

<script>

DataTable($('#tabla_transportistas'));

// DataTable($('#tabla_'));


</script>
           
