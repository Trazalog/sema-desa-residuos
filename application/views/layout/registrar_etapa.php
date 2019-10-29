<!-- Hecha por Jose Roberto el mas vergas -->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header">
        <div class="box-tittle">
            <h3>Etapa</h3>
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

        </div>
        <div class="col-md-6">
        
            <!--Nombre Recipiente-->
            <div class="form-group">
                <label for="NombreRecipiente">Nombre Recipiente:</label>
                <input type="text" class="form-control" id="NombreRecipiente" name="NombreRecipiente">
            </div>
            <!--_____________________________________________-->
                    
            <!--Usuario-->
            <div class="form-group">
                <label for="Usuario">Usuario:</label>
                <input type="text" class="form-control" id="Usuario" name="Usuario">
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