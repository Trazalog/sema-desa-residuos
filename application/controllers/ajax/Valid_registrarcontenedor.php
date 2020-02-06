<script>

        function guardar(){
 
            datos=$('#formContenedores').serialize();
 
            if($("#formContenedores").data('bootstrapValidator').isValid()){
 
                $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Valid_registrarcontenedor/guardardato",
                success:function(r){
                    if(r == "ok"){
               	$('#formContenedores').data('bootstrapValidator').resetForm(true);
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