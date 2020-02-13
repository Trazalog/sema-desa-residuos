                    <!--__________________HEADER TABLA___________________________-->
                    
                    <table id="tabla_transportistas" class="table table-bordered table-striped">
                        <thead class="thead-dark" bgcolor="#eeeeee">
                            <th>Acciones</th>
                            <th>Nombre / Razon Social</th>
                            <th>Zona</th>
                            <th>Departamento</th>
                            <th>Tipo</th>
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
                        echo    '<td>'.$fila->Nombre_razon.'</td>';
                        //echo    '<td>'.$fila->.'</td>';
                        echo    '<td>'.$fila->depa_nom.'</td>';
                        echo    '<td>'.$fila->Rsu.'</td>';
                        echo '</tr>';
                    }
                    }
                    ?>
                    </tbody>
                        </table>

                    <!--__________________FIN TABLA___________________________-->

<script>
    DataTable($('#tabla_transportistas'))
</script>