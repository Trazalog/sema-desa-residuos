<script>

        function guardar(){
 
            datos=$('#formVehiculo').serialize();
 
            if($("#formVehiculo").data('bootstrapValidator').isValid()){
 
                $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Valid_registrarvehiculo/guardardato",
                success:function(r){
                    if(r == "ok"){
               	$('#formVehiculo').data('bootstrapValidator').resetForm(true);
                     alertify.success("Agregado con exito");
                    }
                    else{
               	alertify.error("error al agregar");
                    }
                },
            });
            }else{
                console.log("la entrada no puede ser vacia");
            }
        }
</script>
<!--_____________________________________________________________-->