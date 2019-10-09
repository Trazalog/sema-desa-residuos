<div class="box box-primary">
    <div class="box-header">
        <div class="box-tittle">
           <h3>Registrar Generadores</h3>  
        </div>
    </div>
    <!--_____________________________________________-->
    <div class="box-body">
        <form class="formGeneradores" id="formGeneradores">
        
        <div class="col-md-6">
            <!--Nombre / Razon social-->
                <div class="form-group">
                    <label for="Codigo/Registro" name="Codigo_registro">Codigo / Registro:</label>
                    <input type="text" class="form-control" id="Codigo/Registro">
                </div>
            <!--_____________________________________________-->
            <!--Descripcion-->
                <div class="form-group">
                    <label for="Descripcion" name="Descripcion">Descripcion:</label>
                    <input type="text" class="form-control" id="Descripcion">
                </div>
            <!--_____________________________________________-->
            <!--Capacidad-->
                <div class="form-group">
                    <label for="Capacidad" name="Capacidad">Capacidad:</label>
                    <input type="text" class="form-control" id="Capacidad">
                </div>
            <!--_____________________________________________-->
            <!--Año de elaboracion-->
                <div class="form-group">
                    <label for="Añoelab" name="Añoelab">Año de elaboracion:</label>
                    <input type="text" class="form-control" id="Añoelab">
                </div>
            <!--_____________________________________________-->
        </div>
        <div class="col-md-6">
            <!--Tara-->
                <div class="form-group">
                    <label for="Tara" name="Tara">Tara:</label>
                    <input type="text" class="form-control" id="Tara">
                </div>
            <!--_____________________________________________-->
                <!--Estado-->
                <div class="form-group">
                    <label for="Estado" name="Estado">Estado:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Estado">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Estado as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <!--_____________________________________________-->
            <!--Habilitacion-->
                <div class="form-group">
                    <label for="Habilitacion" name="Habilitacion">Habilitacion:</label>
                    <input type="text" class="form-control" id="Habilitacion">
                </div>
            <!--_____________________________________________-->
            <!--Boton de guardado-->
                <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
            <!--_____________________________________________-->
        </div>
        
        </form>
    </div>
</div>