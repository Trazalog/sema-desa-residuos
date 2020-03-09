    <!--__________________HEADER TABLA___________________________-->
    <table id="tabla_vehiculos" class="table table-bordered table-striped">
        <thead class="thead-dark" bgcolor="#eeeeee">
        <th>Acciones</th>
        <th>Dominio</th>
        <th>Condicion</th>
        <th>Capacidad</th>
        <th>Tara</th>
        <th>Habilitacion</th>
        <th>Registro</th>
        </thead>

        <!--__________________BODY TABLA___________________________-->

        <tbody>
        <?php
        if($vehiculos)
        {
            foreach($vehiculos as $fila)
            {
            echo '<tr data-json:'.json_encode($fila).'>';
            echo    '<td>';
            echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                    <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp 
                    <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';
                
            echo   '</td>';
            echo    '<td>'.$fila->Dominio.'</td>';
            echo    '<td>'.$fila->condicion.'</td>';                       
            echo    '<td>'.$fila->Capacidad.'</td>';                        
            echo    '<td>'.$fila->Tara.'</td>';
            echo    '<td>'.$fila->Habilitacion.'</td>';                       
            echo    '<td>'.$fila->Registro.'</td>';
            echo   '</tr>';
        }
        }
        ?>
        </tbody>
    </table>

    <!--__________________FIN TABLA___________________________-->

<script>
    DataTable($('#tabla_vehiculos'))
</script>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 