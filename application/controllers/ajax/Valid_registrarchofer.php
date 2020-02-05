

<script>

        function guardar(){
 
            datos=$('#formChofer').serialize();
 
            if($("#formChofer").data('bootstrapValidator').isValid()){
 
                $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Valid_registrarchofer/guardardato",
                success:function(r){
                    if(r == "ok"){
               	$('#formChofer').data('bootstrapValidator').resetForm(true);
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