<div class="box box-primary">
    <div class="box-header">
        <div class="box-tittle">
            <h3>Registrar Inspector</h3>
        </div>
    </div>
    <!--_____________________________________________-->
    <div class="box-body">
        <form class="formInspectores" id="formInspectores">
        <div class="col-md-6">
            <!--Nombre-->
                <div class="form-group">
                    <label for="Nombre" name="Nombre">Nombre:</label>
                    <input type="text" class="form-control" id="Nombre">
                </div>
            <!--_____________________________________________-->
            <!--Apellido-->
                <div class="form-group">
                    <label for="Apellido" name="Apellido">Apellido:</label>
                    <input type="text" class="form-control" id="Apellido">
                </div>
            <!--_____________________________________________-->
            <!--Direccion-->
                <div class="form-group">
                    <label for="Direccion" name="Direccion">Direccion:</label>
                    <input type="text" class="form-control" id="Direccion">
                </div>
            <!--_____________________________________________-->
            <!--Email-->
                <div class="form-group">
                    <label for="Email" name="Email">Email:</label>
                    <input type="text" class="form-control" id="Email">
                </div>
            <!--_____________________________________________-->
        </div>
        <div class="col-md-6">
            <!--DNI-->
                <div class="form-group">
                    <label for="DNI" name="DNI">DNI:</label>
                    <input type="text" class="form-control" id="DNI">
                </div>
            <!--_____________________________________________-->
            <!--Departamento-->
                <div class="form-group">
                    <label for="Departamento" name="Departamento">Departamento:</label>
                    <input type="text" class="form-control" id="Departamento">
                </div>
            <!--_____________________________________________-->
            <!--Movilidad Asignada-->
                <div class="form-group">
                    <label for="MovAsignada" name="MovAsignada">Movilidad Asignada:</label>
                    <input type="text" class="form-control" id="MovAsignada">
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

<!-- Script Agregar datos de registrar_inspector-->

<script>
function agregarDato(){
    console.log("entro a agregar datos");
    $('#formInspectores').on('submit', function(e){

    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);

    datos=$('#formInspectores').serialize();
    console.log(datos);
        //--------------------------------------------------------------


    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registrarinspector/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formInspectores')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formInspectores')[0].reset();
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