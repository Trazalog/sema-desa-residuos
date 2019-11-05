<!-- Hecha por Jose Roberto el mas vergas -->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header">
        <div class="box-tittle">
            <h3>Proceso Productivo</h3> 
        </div>
    </div>


    <!--_____________________________________________-->

    <div class="box-body">
        <form class="formProcesoProductivo" id="formProcesoProductivo">
            <div class="col-md-6">

                <!--Nombre-->
                <div class="form-group">
                    <label for="Nombre">Nombre:</label>
                    <input type="text" class="form-control" id="Nombre" name="Nombre">
                </div>
                <!--_____________________________________________-->

                <!--Etapa del proceso-->
                <div class="form-group">
                    <label for="EtapaProceso">Etapa del proceso:</label>
                    <input type="text" class="form-control" id="EtapaProceso" name="EtapaProceso">
                </div>
                <!--_____________________________________________-->

                <!--Nombre del Recipiente-->
                <div class="form-group">
                    <label for="NombreRecipiente">Nombre del Recipiente:</label>
                    <input type="text" class="form-control" id="NombreRecipiente" name="NombreRecipiente">
                </div>
                <!--_____________________________________________-->

                <!--Boton de guardado-->
                <br>
                <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
                <!--_____________________________________________-->

            </div>
        </form>
    </div>
</div>
<!--_____________________________________________________________-->

<!-- Script Agregar datos de registrar_zona-->
<script>
function agregarDato(){
    console.log("entro a agregar datos");
    $('#formProcesoProductivo').on('submit', function(e){
    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);
    datos=$('#formProcesoProductivo').serialize();
    console.log(datos);
    
        //--------------------------------------------------------------

    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registrarzona/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formProcesoProductivo')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formProcesoProductivo')[0].reset();
                        alertify.error("error al agregar");
                    }
                },
                complete: function() {
                    me.data('requestRunning', false);
                }
            });
    });
}
</script>
<!--_____________________________________________________________-->