<!--__________________HEADER TABLA___________________________-->

<table id="tabla_contenedores" class="table table-bordered table-striped">
    <thead class="thead-dark" bgcolor="#eeeeee">

        <th>Acciones</th>
        <th>Codigo / Registro</th>
        <th>Estado</th>
        <th>Capacidad</th>
        <th>Habilitacion</th>


    </thead>

    <!--__________________BODY TABLA___________________________-->

    <tbody>
        <?php
                    if($contenedores)
                    {
                        foreach($contenedores as $fila)
                        {
                            echo '<tr data-json:'.json_encode($fila).'>';
                            echo    '<td>';
                            echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';
                                
                            echo   '</td>';
                            echo    '<td>'.$fila->codigo.'</td>';
                            echo    '<td>'.substr("$fila->esco_id",17).'</td>'; //funcion substr("cadena de caracteres,n° posición del carácter desde la cual se comenzará la extracción") 17 por que hay que obviar estado_contenedor (0-16)
                            echo    '<td>'.$fila->capacidad.'</td>';
                            echo    '<td>'.$fila->habilitacion.'</td>';
                            echo '</tr>';
                    }
                    }
                    ?>


    </tbody>
</table>

<!--__________________FIN TABLA___________________________-->



<!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->


<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Contenedor</h5>
            </div>


            <div class="modal-body">

                <!--__________________ FORMULARIO MODAL ___________________________-->

                <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">
                    <div class="modal-body">
                        <form class="formContenedores" id="formContenedores" method="POST" autocomplete="off" class="registerForm">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!--Codigo / Registro-->
                                        <div class="form-group">
                                            <label for="Codigo/Registro">Codigo / Registro:</label>
                                            <input type="text" class="form-control" name="" id="Codigo/Registro">
                                        </div>
                                        <!--_____________________________________________-->

                                        <!--Descripcion-->
                                        <div class="form-group">
                                            <label for="Descripcion">Descripcion:</label>
                                            <input type="text" class="form-control" name="" id="Descripcion">
                                        </div>
                                        <!--_____________________________________________-->

                                        <!--Capacidad-->
                                        <div class="form-group">
                                            <label for="Capacidad">Capacidad:</label>
                                            <input type="text" class="form-control" name="" id="Capacidad">
                                        </div>
                                        <!--_____________________________________________-->

                                        <!--Año de elaboracion-->
                                        <div class="form-group">
                                            <label for="Añoelab">Año de elaboracion:</label>
                                            <input type="text" class="form-control" name="" id="Añoelab">
                                        </div>
                                        <!--_____________________________________________-->

                                    </div>
                                    <div class="col-md-6">

                                        <!--Tara-->
                                        <div class="form-group">
                                            <label for="Tara">Tara:</label>
                                            <input type="text" class="form-control" name="" id="Tara">
                                        </div>
                                        <!--_____________________________________________-->

                                        <!--Estado-->
                                        <div class="form-group">
                                            <label for="Estados">Estado:</label>
                                            <select class="form-control select2 select2-hidden-accesible" name=""
                                                id="Estados">
                                                <option value="" disabled selected>-Seleccione opcion-</option>
                                                <?php
                                                    foreach ($Estados as $i) {
                                                        echo '<option>'.$i->nombre.'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <!--_____________________________________________-->

                                        <!--Habilitacion-->
                                        <div class="form-group">
                                            <label for="Habilitacion">Habilitacion:</label>
                                            <input type="text" class="form-control" name="" id="Habilitacion">
                                        </div>
                                        <!--_____________________________________________-->

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </form>
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

<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion Contenedor</h5>
            </div>

            <div class="modal-body">

                <!--__________________ FORMULARIO MODAL ___________________________-->

                <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">
                    <div class="modal-body">
                        <form class="formContenedores" id="formContenedores" method="POST" autocomplete="off" class="registerForm">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <!--Codigo / Registro-->
                                        <div class="form-group">
                                            <label for="Codigo/Registro">Codigo / Registro:</label>
                                            <input type="text" class="form-control" name="E_Codigo_registro"
                                                id="Codigo/Registro" readonly>
                                        </div>
                                        <!--_____________________________________________-->

                                        <!--Descripcion-->
                                        <div class="form-group">
                                            <label for="Descripcion">Descripcion:</label>
                                            <input type="text" class="form-control" name="E_Descripcion"
                                                id="Descripcion" readonly>
                                        </div>
                                        <!--_____________________________________________-->

                                        <!--Capacidad-->
                                        <div class="form-group">
                                            <label for="Capacidad">Capacidad:</label>
                                            <input type="text" class="form-control" name="E_Capacidad" id="Capacidad"
                                                readonly>
                                        </div>
                                        <!--_____________________________________________-->

                                        <!--Año de elaboracion-->
                                        <div class="form-group">
                                            <label for="Añoelab">Año de elaboracion:</label>
                                            <input type="text" class="form-control" name="E_Añoelab" id="Añoelab"
                                                readonly>
                                        </div>
                                        <!--_____________________________________________-->

                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <!--Tara-->
                                        <div class="form-group">
                                            <label for="Tara">Tara:</label>
                                            <input type="text" class="form-control" name="E_Tara" id="Tara" readonly>
                                        </div>
                                        <!--_____________________________________________-->

                                        <!--Estado-->
                                        <div class="form-group">
                                            <label for="Estados">Estado:</label>
                                            <input type="text" class="form-control" name="E_Estados" id="" readonly>
                                        </div>
                                        <!--_____________________________________________-->

                                        <!--Habilitacion-->
                                        <div class="form-group">
                                            <label for="Habilitacion">Habilitacion:</label>
                                            <input type="text" class="form-control" name="E_Habilitacion"
                                                id="Habilitacion" readonly>
                                        </div>
                                        <!--_____________________________________________-->
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12">
                            <hr>
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
DataTable($('#tabla_contenedores'))
</script>