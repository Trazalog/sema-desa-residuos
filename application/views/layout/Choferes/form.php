<form class="formChofer" id="formChofer" method="POST" autocomplete="off" class="registerForm">
    <div class="col-md-6">

        <!--Nombre-->
        <div class="form-group">
            <label for="Nombre">Nombre:</label>
            <input type="text" <?php echo req() ?> class="form-control" id="nombre" name="nombre">
        </div> ​
        <!--_____________________________________________________________-->

        <!--Apellido-->
        <div class="form-group">
            <label for="Apellido">Apellido:</label>
            <input type="text" <?php echo req() ?> class="form-control" id="apellido" name="apellido">
        </div> ​
        <!--_____________________________________________________________-->

        <!--DNI-->
        <div class="form-group">
            <label for="DNI">DNI:</label>
            <input type="number" <?php echo req() ?> class="form-control" id="documento" name="documento">
        </div> ​
        <!--_____________________________________________________________-->

        <!--Fecha de nacimiento-->
        <div class="form-group">
            <label for="FechaNacimiento">Fecha de nacimiento:</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" <?php echo req() ?> class="form-control" id="fec_nacimiento" name="fec_nacimiento">
            </div>
        </div> ​
        <!--_____________________________________________________________-->

        <!--Direccion-->
        <div class="form-group">
            <label for="Direccion">Direccion:</label>
            <input type="text" <?php echo req() ?> class="form-control" id="direccion" name="direccion">
        </div> ​
        <!--_____________________________________________________________-->

        <!--Celular-->
        <div class="form-group">
            <label for="Celular">Celular:</label>
            <input type="number" <?php echo req() ?> class="form-control" id="celular" name="celular">
        </div>
        <!--_____________________________________________________________-->
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <!--Codigo-->
        <div class="form-group">
            <label for="Codigo">Codigo:</label>
            <input type="text" <?php echo req() ?> class="form-control" id="codigo" name="codigo">
        </div> ​
        <!--_____________________________________________________________-->

        <!--Empresa-->
        <div class="form-group">
            <label for="Empresa">Empresa:</label>
            <select <?php echo req() ?> class="form-control select2 select2-hidden-accesible" id="tran_id" name="tran_id">
                <option value="" disabled selected>-Seleccione opcion-</option>
                <?php
										foreach ($empresa as $empre) {
												echo '<option value="'.$empre->tran_id.'">'.$empre->razon_social.'</option>';
										}
								?>
            </select>
        </div> ​
        <!--_____________________________________________________________-->

        <!--Carnet-->
        <div class="form-group">
            <label for="Carnet">Carnet:</label>
            <select <?php echo req() ?> class="form-control select2 select2-hidden-accesible" id="carnet" name="carnet">
                <option value="" disabled selected>-Seleccione opcion-</option>
                <?php
										foreach ($carnet as $car) {
												echo '<option value="'.$car->tabl_id.'">'.$car->valor.'</option>';
										}
								?>
            </select>
        </div> ​
        <!--_____________________________________________________________-->

        <!--Categoria-->
        <div class="form-group">
            <label for="Categoria">Categoria:</label>
            <select <?php echo req() ?> class="form-control select2 select2-hidden-accesible" id="cach_id" name="cach_id">
                <option value="" disabled selected>-Seleccione opcion-</option>
                <?php
										foreach ($categoria as $categ) {
												echo '<option value="'.$categ->tabl_id.'">'.$categ->valor.'</option>';
										}
								?>
            </select>
        </div> ​
        <!--_____________________________________________________________-->

        <!--Vencimiento-->
        <div class="form-group">
            <label for="Vencimiento">Vencimiento:</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" <?php echo req() ?> class="form-control pull-right" id="vencimiento" name="vencimiento">
            </div>
            <!-- /.input group -->
        </div> ​
        <!--_____________________________________________________________-->

        <!--Habilitacion-->
        <div class="form-group">
            <label for="Habilitacion">Habilitacion:</label>
            <input type="text" <?php echo req() ?> class="form-control" id="habilitacion" name="habilitacion">
        </div> ​
        <!--_____________________________________________________________-->

    </div>
</form>