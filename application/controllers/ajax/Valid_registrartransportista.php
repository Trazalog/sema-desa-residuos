<script>

    /* Hecha por Jose Roberto el mas vergas */
        function guardar(){
 
            datos=$('#formTransportistas').serialize();
 
            if($("#formTransportistas").data('bootstrapValidator').isValid()){
 
                $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Valid_registrartransportista/guardardato",
                success:function(r){
                    if(r == "ok"){
               	$('#formTransportistas').data('bootstrapValidator').resetForm(true);
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