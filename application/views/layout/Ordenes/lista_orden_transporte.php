<!-- __________________HEADER TABLA___________________________ -->

<table id="tabla_circuitos" class="table table-bordered table-striped">
    <thead class="thead-dark" bgcolor="#eeeeee">

        <th>N°</th>
        <th>Disposicion</th>
        <th>Tipo residuo</th>
        <th>Transportista</th>
        <th>Movilidad</th>

    </thead>

    <!-- __________________BODY TABLA___________________________ -->

    <tbody>
    <?php
                    if($ordenes)
                    {
                        foreach($circuitos as $fila)
                        {
                        echo '<tr data-json:'.json_encode($fila).'>';
                        echo    '<td>';
                        echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal"
                        data-target="#modalEdit"><span class="glyphicon glyphicon-pencil"
                            aria-hidden="true"></span></button>&nbsp
                    <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal"
                        data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign"
                            aria-hidden="true"></span></button>&nbsp
                    <button type="button" title="Asignar" class="btn btn-primary btn-circle" data-toggle="modal"
                        data-target="#modalZona"><span class="fa fa-map-o"
                            aria-hidden="true"></span></button>&nbsp
                    <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span
                            class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';
                            
                        echo   '</td>';
                        echo    '<td>'.$fila->codigo.'</td>';
                        echo    '<td>'.$fila->chof_id.'</td>';
                        echo    '<td>'.$fila->vehi_id.'</td>';
                        echo    '<td>'.$fila->descripcion.'</td>';
                        echo '</tr>';
                    }
                    }
                    ?>
    </tbody>
</table>

<!-- __________________FIN TABLAa___________________________ -->