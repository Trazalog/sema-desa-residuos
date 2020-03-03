    <!--__________________HEADER TABLA___________________________-->
    <table id="tabla_choferes" class="table table-bordered table-striped">
        <thead class="thead-dark" bgcolor="#eeeeee">
            <th>Acciones</th>
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Empresa</th>
            <th>Carnet</th>
            <th>Categoria</th>
            <th>Habilitacion</th>
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
            echo    '<td>'.$fila->nombre.'</td>';
            echo    '<td>'.$fila->direccion.'</td>';
            echo    '<td>'.$fila->empresa.'</td>';
            echo    '<td>'.$fila->carnet.'</td>';
            echo    '<td>'.$fila->categoria.'</td>';
            echo    '<td>'.$fila->habilitacion.'</td>';
            echo   '</tr>';
        }
        }
        ?>
        </tbody>
    </table>

    <!--__________________FIN TABLA___________________________-->

<script>
    DataTable($('#tabla_choferes'))
</script>