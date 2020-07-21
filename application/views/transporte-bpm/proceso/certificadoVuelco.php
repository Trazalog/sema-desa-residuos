<h4>Certificado de Vuelco</h4>
<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
<!--_________________SEPARADOR_________________-->
<div class="col-md-12 ">
	<!--_____________ Camion _____________-->
    <div class="col-md-4">
		<div class="form-group">															
			<label for="Camion" class="col-sm-4 control-label">Camion:</label>
            
			<!-- <div class="col-sm-8"> -->
				<input type="text" class="form-control habilitar" name="Camion" value="<?php echo $infoOTransporte->dominio?>" id="camion_id" readonly> 
			<!-- </div>	 -->
		</div>
    </div>
	<!--__________________________-->
    <div class="col-md-4">
                <div class="form-group">
                        <label for="valorizado">Valorizado:</label>
                        <br>
                        <!-- <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>                     -->
                            <select class="form-control select2 select2-hidden-accesible" name="valorizado" id="valorizado_id">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($camion as $l) {
                                            echo '<option  value="'.$l->equi_id.'">'.$l->dominio.'</option>';
                                        }
                                    ?>
                            </select>
                        <!-- </div> -->
                 </div>
    </div>
</div>
<div class="col-md-12  ">
    <div class="col-md-4">
            <div class="form-group">
                <label for="obs">Observaciones:</label>
                    <!-- <div class="input-group date"> -->
                            <!-- <div class="input-group-addon"><i class="fa fa-calendar"></i></div> -->
                <input type="text" class="form-control"  name="obs" id="obs">
                    <!-- </div>			 -->
            </div>
    </div>
</div>
<div class="col-md-12  ">
    <div class="col-md-4">  
        <div class="form-group">
             <button type="button" title="Incidencia" calss="btn btn-primary btn-circle"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>                                     
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <button type="button" title="Adjuntar Imagen" calss="btn btn-primary btn-circle"><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span></button>
        </div>
    </div>

</div>

<?php
        $deposito = [];
        $col = $TamDeposito->col;
        $row = $TamDeposito->row;
        $aux = 0;
        $aux2 = 0;
        $array=["A","B","C","D","E","F","G","H","I","J","K","L","M","N","Ñ","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
       
           
            for($j=0; $j<$row; $j++)
            {
                $aux2=0;
                $aux=0;
                $idcol =0;
                foreach($Recipientes as $fila)
                {   
                    if($fila->row == $j+1 && $fila->row != null){
                        $aux = 1;
                        $deposito[] = $fila;
                    }
                }
                echo '<div class="row">';
                for($i=0; $i<$col; $i++)
                {   $idcol = $i+1;
                    $idcol = "BOX " . $array[$j] . $idcol  ;  
            
                        echo '<div class="col-xs-2" style="margin-right: -5rem; width: 15.666667%;">';
                                echo'<div class="thumbnail" style="margin-right: 3rem;">';
                                    echo'<div class="caption">';
                                            echo '<h5 style="font-size: 12px;">'.$idcol.'</h5>';
                                            if($aux == 1){
                                                for($t=0;$t<count($deposito);$t++)
                                                {
                                                    if($deposito[$t]->col == $i+1)
                                                    {   
                                                        if($deposito[$t]->estado == "VACIO"){
                                                            $aux2 = 1;
                                                        
                                                            echo"<button type='button' class='btn btn-default btnvolcar' style='font-size: 10px;' id='$idcol'>Volcar</button>";
                                                        }else{
                                                            $aux2= 1;
                                                            echo"<button type='button' class='btn btn-default btnMover' style='font-size: 10px;' id='$idcol'>Mover</button>";
                                                        }
                                                    }
                                                }
                                                if($aux2 == 0){
                                                    //  echo'<button type="button" class="btn btn-default"></button>';
                                                }
                                              
                                            }else{
                                                //  echo'<button type="button" class="btn btn-default"></button>';
                                            } 
                                            
                                            
                                                //  echo'<button type="button" class="btn btn-default">Volcar</button>';
                                            
                                            
                                        echo'</div>';
                                    echo'</div>';
                                echo'</div>';
        
                }
                echo '</div>';
                unset($deposito);
            }
        
?>

<div class="text-right">
	<button class="btn btn-primary" id="redirecciona"  onclick="ReDirecciona()">Re Direccionar</button>
	<button class="btn btn-primary" id="certificado" onclick="Certificado()" style="margin-left:20px;">Certificado de Vuelco</button>
</div>


<!-- Modlaes Re Direccionar y Mover -->
<!-- Modal redireccionar-->
<div class="modal fade" id="modalRedireccionar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Redireccionar</h5>
            </div>
            <form id="formRedireccionar" method="POST" autocomplete="off" class="registerForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nro" class="form-label">Vehiculo:</label>
                                <input size="10" type="text" name="vehiculored" id="vehiculored" min="0" class="form-control input-sm" value="<?php echo $infoOTransporte->dominio?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nro" class="form-label">OT:</label>
                                <input size="10" type="text" name="otred" id="otred" min="0" class="form-control input-sm" value="<?php echo $infoOTransporte->ortr_id?>">
                            </div>
                            <div class="form-group">
                                <label for="nro" class="form-label">Sector de inicio:</label>
                                <input size="10" type="text" name="sectoriniciored" id="sectoriniciored" min="0" class="form-control input-sm"
                                    required value="<?php echo $TamDeposito->establecimiento?>">
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="nro" class="form-label">Informacion:</label>
                                <input size="10" type="text" name="infored" id="infored" min="0" class="form-control input-sm"
                                >
                            </div>
                            <div class="form-group">
                                <label for="nro" class="form-label">Sector de fin:</label>
                                <input size="10" type="text" name="sectorfinred" id="sectorfinred" min="0" class="form-control input-sm"
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary" id="btnsavemodalred" onclick="GuardaReDirecciona()">Guardar</button>
                        <button type="button" class="btn btn-default" id="btnclosemodalred" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal mover-->
<div class="modal fade" id="modalMover" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Mover</h5>
            </div>
            <form id="formMover" method="POST" autocomplete="off" class="registerForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label for="residuo" class="form-label">Tipo de Residuo:</label>
                                <input size="10" type="text" name="residuo" id="residuomov" min="0" class="form-control input-sm"
                                    required value="<?php echo $infoOTransporteCont[0]->tipo_carga?>">
                            </div>
                            <div class="form-group">
                                <label for="nro" class="form-label">Vehiculo:</label>
                                <input size="10" type="text" name="vehiculomover" id="vehiculomover" min="0" class="form-control input-sm"
                                    required value="<?php echo $infoOTransporte->dominio?>">
                            </div>
                            <div class="form-group">
                                <label for="nro" class="form-label">Area de inicio:</label>
                                <input size="10" type="text" name="areainiciomover" id="areainiciomover" min="0" class="form-control input-sm"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="nro" class="form-label">Area de fin:</label>
                                <input size="10" type="text" name="areafinmover" id="areafinmover" min="0" class="form-control input-sm"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary" id="btnsavemodalmov">Guardar</button>
                        <button type="button" class="btn btn-default" id="btnclosemodalmov"
                            data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

function ReDirecciona()
{
    $("#modalRedireccionar").modal('show');
}
function GuardaReDirecciona()
{
    $("#modalRedireccionar").modal('hide');
}

$(".btnMover").click(function(){
   $("#modalMover").modal('show');
   var textfilacol = $(".btnMover").attr("id");
   console.table(textfilacol);
   
});

$(".btnvolcar").click(function(){
   var textfilacol = $(".btnvolcar").attr("id");
   console.table(textfilacol);
});

</script>