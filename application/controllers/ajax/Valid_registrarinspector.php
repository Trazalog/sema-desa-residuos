<script>

        function guardar(){
 
            datos=$('#formInspectores').serialize();
 
            if($("#formInspectores").data('bootstrapValidator').isValid()){
 
                $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Valid_registrarinspector/guardardato",
                success:function(r){
                    if(r == "ok"){
               	$('#formInspectores').data('bootstrapValidator').resetForm(true);
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