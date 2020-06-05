<table id="tabla_vehiculos" class="table table-bordered table-striped">
        <thead class="thead-dark" bgcolor="#eeeeee">
        <th>Acciones</th>
        <th>Nro OT</th>
        <th>Nro de acta</th>
        <th>fecha</th>
        <th>Incidencia</th>
        </thead>

        <!--__________________BODY TABLA___________________________-->

        <!-- <tbody> -->
        <?php
        // if($incidencia)
        // {
        //     foreach($incidencia as $fila)
        //     {
        //     echo "<tr data-json='".json_encode($fila)."'>";
        //     echo    '<td>';
        //     echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
        //             <button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp 
        //             <button type="button" title="eliminar" class="btn btn-primary btn-circle btnEliminar" data-toggle="modal" data-target="#modalBorrar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';
                
        //     echo   '</td>';
        //     echo    '<td>DATO</td>';   
        //     echo    '<td>DATO</td>';
        //     echo    '<td>DATO</td>';                       
        //     echo    '<td>DATO</td>';                        
        //     echo   '</tr>';
        // }
        // }
        ?>
        <!-- </tbody> -->
        <tbody>
        <tr>
          <td>
            <button type="button" title="Editar" class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
            <button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp 
            <button type="button" title="eliminar" class="btn btn-primary btn-circle btnEliminar" data-toggle="modal" data-target="#modalBorrar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
          </td>
          <td>DATO</td>
          <td>DATO</td>
          <td>DATO</td>
          <td>DATO</td>
        
        </tr>
       
      </tbody>
    </table>