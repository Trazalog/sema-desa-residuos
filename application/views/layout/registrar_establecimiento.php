<!-- Hecha por Jose Roberto el mas vergas -->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header">
        <div class="box-tittle">
            <h3>Establecimiento</h3>
        </div>
    </div>

    <!--_____________________________________________-->

    <div class="box-body">
        <form class="formContenedores" id="formContenedores">
        
        <div class="col-md-6">

            <!--Nombre-->
            <div class="form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" class="form-control" id="Nombre" name="Nombre">
            </div>
            <!--_____________________________________________-->

            <!--Ubicacion-->
            <div class="form-group">
                <label for="Ubicacion">Ubicacion:</label>
                <br>
                <div class="col-md-6">
                <input type="text" class="form-control" id="Ubicacion" name="Ubicacion">
                </div>
                <div class="col-md-6">
                <input type="text" class="form-control" id="Ubicacion" name="Ubicacion">
                </div>
            </div>
            <!--_____________________________________________-->

            <!--Pais-->
            <br><br>
            <div class="form-group">
                <label for="Pais">Pais:</label>
                <input type="text" class="form-control" id="Pais" name="Pais">
            </div>
            <!--_____________________________________________-->

            <!--Fecha de alta-->
            <div class="form-group">
                <label for="Fechalta">Fecha de alta:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="Fecha_de_alta">
                </div>
                <!-- /.input group -->
            </div>
            <!--_____________________________________________-->

            <!--Pais-->
            <div class="form-group">
                <label for="Pais">Pais:</label>
                <input type="text" class="form-control" id="Pais" name="Pais">
            </div>
            <!--_____________________________________________-->

            <!--Usuario-->
            <div class="form-group">
                <label for="Usuario">Usuario:</label>
                <input type="text" class="form-control" id="Usuario" name="Usuario">
            </div>
            <!--_____________________________________________-->

        </div>
        <div class="col-md-6">

            <!--Calles-->
            <div class="form-group">
                <label for="Calles">Calles:</label>
                <input type="text" class="form-control" id="Calles" name="Calles">
            </div>
            <!--_____________________________________________-->

            <!--Altura-->
            <div class="form-group">
                <label for="Altura">Altura:</label>
                <input type="text" class="form-control" id="Altura" name="Altura">
            </div>
            <!--_____________________________________________-->

            <!--Localidad-->
            <div class="form-group">
                <label for="Localidad">Localidad:</label>
                <input type="text" class="form-control" id="Localidad" name="Localidad">
            </div>
            <!--_____________________________________________-->

            <!--Estado-->
            <div class="form-group">
                <label for="Estado">Estado:</label>
                <input type="text" class="form-control" id="Estado" name="Estado">
            </div>
            <!--_____________________________________________-->

            <!--Boton de guardado-->
            <hr>
            <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
            <!--_____________________________________________-->
        </div>
        </form>
    </div>
</div>