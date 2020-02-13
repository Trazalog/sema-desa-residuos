<script>

        function guardar(){
 
            datos=$('#formGeneradores').serialize();
 
            if($("#formGeneradores").data('bootstrapValidator').isValid()){
 
                $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Valid_registrargenerador/guardardato",
                success:function(r){
                    if(r == "ok"){
               	$('#formGeneradores').data('bootstrapValidator').resetForm(true);
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