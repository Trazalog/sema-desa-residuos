    <!--__________________HEADER TABLA___________________________-->
    <table id="tabla_choferes" class="table table-bordered table-striped">
        <thead class="thead-dark" bgcolor="#eeeeee">
            <th>Acciones</th>
            <th>Nombre y Apellido</th>
            <th>Direccion</th>
            <th>Celular</th>
            <th>Codigo</th>
            <th>Empresa</th>
            <th>Carnet y Categoria</th>
            <th>Estado</th>
        </thead>

        <!--__________________BODY TABLA___________________________-->

        <tbody>
            <?php
            if($choferes)
            {
                foreach($choferes as $fila)
                {
                echo '<tr data-json:'.json_encode($fila).'>';
                echo    '<td>';
                echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                        <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp 
                        <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';

                echo   '</td>';
                echo    '<td>'.$fila->nombre. " " .$fila->apellido.'</td>';
                echo    '<td>'.$fila->direccion.'</td>';
                echo    '<td>'.$fila->celular.'</td>';
                echo    '<td>'.$fila->codigo.'</td>';
                echo    '<td>'.$fila->tran_id.'</td>';
                echo    '<td>'.$fila->carnet. " - ".$fila->cach_id.'</td>';
                echo    '<td>'.$fila->habilitacion.'</td>';
                echo   '</tr>';
                }
            }
            ?>
        </tbody>
    </table>

<!--__________________FIN TABLA___________________________-->

<!---///////--- MODAL EDITAR ---///////--->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                        <h5 class="modal-title" id="exampleModalLabel">Editar Transportista</h5>
                </div>
                <div class="modal-body col-md-12 col-sm-12 col-xs-12">

                    <!--__________________ FORMULARIO MODAL ___________________________-->
                    <form method="POST" autocomplete="off" id="frm_chofer" class="registerForm">	

                        <!-- Id de transportista y Usuario-->
                            <div class="form-group">
                                <input type="text" class="form-control habilitar" id="chof_id" name="chof_id" style="display:none;">
                                <input type="text" class="form-control habilitar" id="usuario_app_edit" name="usuario_app" style="display:none;">
                            </div>
                        <!--______________________________-->

                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <!--Nombre-->
                                <div class="form-group">
                                    <label for="Nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre">
                                </div>
                            ​    <!--_____________________________________________________________-->

                            <!--Apellido-->
                                <div class="form-group">
                                    <label for="Apellido">Apellido:</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido">
                                </div>
                            ​    <!--_____________________________________________________________-->

                            <!--DNI-->
                                <div class="form-group">
                                    <label for="DNI">DNI:</label>
                                    <input type="text" class="form-control" id="dni" name="dni">
                                </div>
                            ​    <!--_____________________________________________________________-->

                            <!--Fecha de nacimiento-->
                                <div class="form-group">
                                    <label for="FechaNacimiento">Fecha de nacimiento:</label>
                                    <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control" id="fec_nacimiento" name="fec_nacimiento"></div>
                                </div>
                            ​    <!--_____________________________________________________________-->

                            <!--Direccion-->
                                <div class="form-group">
                                    <label for="Direccion">Direccion:</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion">
                                </div>
                            ​    <!--_____________________________________________________________-->

                                <!--Celular-->
                                    <div class="form-group">
                                        <label for="Celular">Celular:</label>
                                        <input type="text" class="form-control" id="celular" name="celular">
                                    </div>
                                <!--_____________________________________________________________-->

                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <!--Codigo-->
                                    <div class="form-group">
                                        <label for="Codigo">Codigo:</label>
                                        <input type="text" class="form-control" id="codigo" name="codigo">
                                    </div>
                            ​    <!--_____________________________________________________________-->

                                <!--Empresa-->
                                    <div class="form-group">
                                        <label for="Empresa">Empresa:</label>
                                        <input type="text" class="form-control" id="tran_id" name="tran_id">
                                    </div>
                            ​    <!--_____________________________________________________________-->

                                <!--Carnet-->
                                    <div class="form-group">
                                        <label for="Carnet" >Carnet:</label>
                                        <select class="form-control select2 select2-hidden-accesible" id="carnet" name="carnet">
                                            <option value="" disabled selected>-Seleccione opcion-</option>
                                            <?php
                                            foreach ($carnet as $i) {
                                                echo '<option>'.$i->nombre.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                            ​    <!--_____________________________________________________________-->

                                <!--Categoria-->
                                    <div class="form-group">
                                        <label for="Categoria">Categoria:</label>
                                        <select class="form-control select2 select2-hidden-accesible" id="cach_id" name="cach_id">
                                            <option value="" disabled selected>-Seleccione opcion-</option>
                                            <?php
                                            foreach ($categoria as $i) {
                                                echo '<option>'.$i->nombre.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                            ​    <!--_____________________________________________________________-->

                                <!--Vencimiento-->
                                    <div class="form-group">
                                        <label for="Vencimiento" >Vencimiento:</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="date" class="form-control pull-right" id="vencimiento" name="vencimiento">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                            ​    <!--_____________________________________________________________-->

                                <!--Habilitacion-->
                                    <div class="form-group">
                                        <label for="Habilitacion">Habilitacion:</label>
                                        <input type="text" class="form-control" id="habilitacion" name="habilitacion">
                                    </div>
                                ​<!--_____________________________________________________________-->


<script>
    DataTable($('#tabla_choferes'))
</script>