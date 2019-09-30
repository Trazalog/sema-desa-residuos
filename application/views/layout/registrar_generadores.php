<div class="box box-primary">
    <div class="box-header">
        <div class="box-tittle">

            <h3>Registrar Generadores</h3>
        </div>
    </div>
    <!--_____________________________________________-->
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <!--Nombre / Razon social-->
                <div class="form-group">
                    <label for="Nombre/Razon social">Nombre / Razon social:</label>
                    <input type="text" class="form-control" id="Nombre/Razon social">
                </div>
                <!--_____________________________________________-->
                <!--CUIT-->
                <div class="form-group">
                    <label for="CUIT">CUIT:</label>
                    <input type="text" class="form-control" id="CUIT">
                </div>
                <!--_____________________________________________-->
                <!--Zona-->
                <div class="form-group">
                    <label for="Zonag">Zona:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Zonag">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Zonag as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <!--_____________________________________________-->
                <!--Rubro-->
                <div class="form-group">
                    <label for="Rubro">Rubro:</label>
                    <input type="text" class="form-control" id="Rubro">
                </div>
                <!--_____________________________________________-->
                <!--Tipo-->
                <div class="form-group">
                    <label for="TipoG">Tipo:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="TipoG">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($TipoG as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <!--_____________________________________________-->
                <!--Domicilio-->
                <div class="form-group">
                    <label for="Domicilio">Domicilio:</label>
                    <input type="text" class="form-control" id="Domicilio">
                </div>
                <!--_____________________________________________-->
                <!--Departamento-->
                <div class="form-group">
                    <label for="Dpto">Departamento:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Dpto">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Dpto as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <!--_____________________________________________-->
                <!--Numero de registro-->
                <div class="form-group">
                    <label for="Numero de registro">Numero de registro:</label>
                    <input type="text" class="form-control" id="Numero de registro">
                </div>
                <!--_____________________________________________-->
                <!--Tipo de residuos-->
                <div class="form-group">
                    <label for="Tipo de residuos">Tipo de residuos:</label>
                    <input type="text" class="form-control" id="Tipo de residuos">
                </div>
                <!--_____________________________________________-->

                <!--Boton de guardado-->
                <button type="submit" class="btn btn-primary">Guardar</button>
                <!--_____________________________________________-->
            </div>
        </div>
    </div>
</div>