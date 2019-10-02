<div class="box box-primary">
    <div class="box-header">
        <div class="box-tittle">
            <h3>Registrar Transportista</h3>  
        </div>
    </div>

<!--_________________________________________________-->
    
    <div class="box-body">
<div class="col-md-6">
    <!--Nombre / Razon social-->
    <div class="form-group">
        <label for="Nombre/Razon social" name="Nombre_razon">Nombre / Razon social:</label>
        <input type="text" class="form-control" id="Nombre/Razon social">
    </div>
    <!--_____________________________________________-->
    <!--Descripcion-->
    <div class="form-group">
        <label for="Descripcion" name="Descripcion">Descripcion:</label>
        <input type="text" class="form-control" id="Descripcion">
    </div>
    <!--_____________________________________________-->
    <!--Direccion-->
    <div class="form-group">
        <label for="Direccion" name="Direccion">Direccion:</label>
        <input type="text" class="form-control" id="Direccion">
    </div>
    <!--_____________________________________________-->
    <!--Telefono-->
    <div class="form-group">
        <label for="Direccion" name="Direccion">Direccion:</label>
        <input type="text" class="form-control" id="Direccion">
    </div>
    <!--_____________________________________________-->
    <!--Contacto-->
        <div class="form-group">
        <label for="Direccion" name="Direccion">Direccion:</label>
        <input type="text" class="form-control" id="Direccion">
    </div>
    <!--_____________________________________________-->
</div>
<div class="col-md-6">
    <!--Resolucion-->
        <div class="form-group">
        <label for="Direccion" name="Direccion">Direccion:</label>
        <input type="text" class="form-control" id="Direccion">
    </div>
    <!--_____________________________________________-->

    <!--Registro-->
        <div class="form-group">
        <label for="Direccion" name="Direccion">Direccion:</label>
        <input type="text" class="form-control" id="Direccion">
    </div>
    <!--_____________________________________________-->
    <!--Fecha de alta-->
    <div class="form-group">
                <label for="Fechalta" name="Fecha_de_alta">Fecha de alta:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker">
                </div>
                <!-- /.input group -->
              </div>

    <!--_____________________________________________-->
    <!--Fecha de alta-->
    <div class="form-group">
                <label for="Fechabaja" name="Fecha_de_baja">Fecha de baja:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker">
                </div>
                <!-- /.input group -->
              </div>
    <!--_____________________________________________-->
    <!--Tipo de RSU autorizado-->
    <div class="form-group">
    <label for="Rsu" name="Rsu">Tipo de RSU autorizado:</label>
        <select class="form-control select2 select2-hidden-accesible" id="Rsu">
            <option value="" disabled selected>-Seleccione opcion-</option>
                <?php
                    foreach ($Rsu as $i) {
                        echo '<option>'.$i->nombre.'</option>';
                    }
                ?>
        </select>
    </div>
    <!--_____________________________________________-->


    <!--Boton de guardado-->
    <br>

    <button type="submit" class="btn btn-primary pull-right">Guardar</button>
    <!--_____________________________________________-->
</div>
    <br>






    </div>
</div>