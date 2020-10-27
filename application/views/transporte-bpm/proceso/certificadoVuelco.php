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
				<input type="text" class="form-control habilitar" style="width: 35rem;" name="Camion" value="<?php echo $infoOTransporte->dominio?>" id="camion_id" readonly> 
                <input type="text" style="display:none" id="dato_cont_id" value="<?php echo $infoOTransporteCont[0]->cont_id?>">
                <input type="text" style="display:none" id="reci_id">
                <input type="text" style="display:none" id="id_reci_mov">
			<!-- </div>	 -->
		</div>
    </div>
	<!--__________________________-->
    <div class="col-md-4">
                <div class="form-group">
                        <label for="valorizado" style="margin-left: 11rem;">Valorizado:</label>
                        <br>
                        <!-- <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>                     -->
                            <select class="form-control select2 select2-hidden-accesible" style="margin-left: 11rem; width:35rem;" name="valorizado" id="valorizado_id">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($tipoValorizado as $l) {
                                            echo '<option  value="'.$l->tabl_id.'">'.$l->valor.'</option>';
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
                <input type="text" style="width: 72rem;" class="form-control"  name="obs" id="obs">
                    <!-- </div>			 -->
            </div>
    </div>
</div>
<div class="col-md-12" style="margin-left: 14rem;">
    <div class="col-md-4">  
        <div class="form-group">
             <button type="button" title="Incidencia" calss="btn btn-primary btn-circle" id="incidencia" style="background: #3c8dbc; border-radius: 6rem; border: unset; color: beige; width: 4rem; height: 4rem;"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>                                     
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <button type="button" title="Adjuntar Imagen" calss="btn btn-primary btn-circle" id="adjimg" style="background: #3c8dbc; border-radius: 6rem; border: unset; color: beige; width: 4rem; height: 4rem; margin-left: -8rem;"><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span></button>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <button type="button" title="Certificado de Vuelco" calss="btn btn-primary btn-circle" id="adjimg" style="background: #3c8dbc; border-radius: 6rem; border: unset; color: beige; width: 4rem; height: 4rem; margin-left: -15rem;" onclick="Certificado()"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
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
                    $idcol = "BOX" . $array[$j] . $idcol  ;  
            
                        echo '<div class="col-xs-2" style="margin-right: -5rem; width: 15.666667%;">';
                                echo'<div class="thumbnail" style="margin-right: 3rem;">';
                                    echo'<div class="caption">';
                                            echo '<h5 style="font-size: 12px; margin-left: 1rem;">'.$idcol.'</h5>';
                                            if($aux == 1){
                                                for($t=0;$t<count($deposito);$t++)
                                                {
                                                    if($deposito[$t]->col == $i+1)
                                                    {   $sumai = $i+1;
                                                        $sumaj = $j+1;
                                                        $ij = $sumaj.$sumai;
                                                        $suma = $sumaj."/".$sumai."@".$idcol;
                                                        if($deposito[$t]->estado == "VACIO"){
                                                            $aux2 = 1;                                                  
                                                            echo "<input class='btnvolcar btnMatriz $ij' type='button' name='Volcar' id='$suma'  data-json=".json_encode($deposito[$t])."  value='Volcar' onclick='btnVolcar(this)' style='border-radius: 41rem; width: 5rem; color:#77d86b; border: unset; height: 5rem; '/>";
                                                            // echo"<button type='button' class='btn btn-default btnvolcar' style='font-size: 10px;' id='$idcol'>Volcar</button>";
                                                        }else{
                                                            $aux2= 1;
                                                            echo "<input class='btnmover btnMatriz $ij'  type='button' name='Mover' id='$suma' value='Mover' onclick='btnMover(this)' style='border-radius: 41rem; width: 5rem; color:#f57474; border: unset; height: 5rem;  '/>";
                                                            // echo"<button type='button' class='btn btn-default btnMover' style='font-size: 10px;' id='$idcol'>Mover</button>";
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
<div class="col-md-4">
        <div class="form-group">
            <button type="button" title="Cancelar seleccion volcar" calss="btn btn-primary btn-circle" id="cancelarsel" style="background: #3c8dbc; border-radius: 6rem; border: unset; color: beige; width: 3rem; height: 3rem;"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span></button>
             <input type="text" style="display:none;" id="idBox">
             <input type="text" style="display:none;" id="idRecDestino">                           
        </div>
</div>
<div class="text-right">
	<button class="btn btn-primary" id="redirecciona"  onclick="ReDirecciona()">Re Direccionar</button>
	<!-- <button class="btn btn-primary" id="certificado" onclick="Certificado()" style="margin-left:20px;">Certificado de Vuelco</button> -->
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
                                <input size="10" type="text" name="vehiculored" id="vehiculored" min="0" class="form-control input-sm" value="<?php echo $infoOTransporte->dominio?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nro" class="form-label">OT:</label>
                                <input size="10" type="text" name="otred" id="otred" min="0" class="form-control input-sm" value="<?php echo $infoOTransporte->ortr_id?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nro" class="form-label">Sector de inicio:</label>
                                <input size="10" type="text" name="sectoriniciored" id="sectoriniciored" min="0" class="form-control input-sm"
                                    required value="<?php echo $TamDeposito->establecimiento?>" readonly>
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
                                <select class="form-control select2 select2-hidden-accesible" name="depositos" id="deposito_id">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($depositos as $j) {
                                            echo '<option  value="'.$j->depo_id.'">'.$j->descripcion.'</option>';
                                        }
                                    ?>
                                </select>
                                <input type="text" id="SiRedirecciona" style="display:none">
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
                                 value="<?php echo $infoOTransporteCont[0]->tipo_carga?>">
                                 <input type="text" id="batch_id" style="display:none" value="<?php echo $infoOTransporteCont[0]->batch_id?>">
                                 <input type="text" id="reci_id_destino_mover" style="display:none">
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
                                    <button class="btn btn-primary" id="btnrecidestino">Seleccionar Area fin a mover</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary" id="btnsavemodalmov">Guardar</button>
                        <button type="button" class="btn btn-default" id="btncloseModalReciDest"
                            data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal incidencia-->
<div class="modal fade" id="modalIncidencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Registrar incidencia</h5>
            </div>
            <form id="formIncidencia" method="POST" autocomplete="off" class="registerForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
									<label for="ortr_id" class="form-label">Numero de orden:</label>
									<input type="number" size="10" type="text" name="ortr_id" id="ortr_id" min="0"
										class="form-control" value="<?php echo $infoOT->ortr_id ; ?>" readonly>
                                    <input type="text" id="tieneInci" style="display:none">    
                            </div>
							<div class="form-group">																
									<label for="tica_id" class="form-label">Tipo residuo:</label>
									<select class="form-control select2 select2-hidden-accesible" id="tica_id" name="tica_id" required>
									<option value="" disabled selected>-Seleccione opcion-</option>
											<?php
											foreach ($tipoCarga as $carga) {
											echo '<option value="'.$carga->tabl_id.'">'.$carga->valor.'</option>';
											}
											?>
									</select>
							</div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
								<label for="fechaa" class="form-label">Fecha:</label>
								<input type="date" name="" id="fechaa" class="form-control" value="<?php echo $infoOT->fec_alta ; ?>" readonly>
							</div>
							<div class="form-group">
								<label for="dfinal" class="form-label">D. final:</label>
								<input type="text" name="" id="dfinal" class="form-control" value="<?php echo $infoOT->difi_nombre ; ?>" readonly>
								<!-- id de disposicion final -->				
								<input type="text" name="difi_id" id="difi_id" class="form-control hidden" value="<?php echo $infoOT->difi_id ; ?>" readonly>																				 
							</div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
								<label for="descripcion" class="form-label">Descripcion:</label>
								<input type="text" name="descripcion" id="descripcion" class="form-control" required>
							</div>
							<div class="form-group">																	
								<label for="tiin_id" class="form-label">Tipo incidencia:</label>
								<select class="form-control select2 select2-hidden-accesible" id="tiin_id" name="tiin_id" required>
								<option value="" disabled selected>-Seleccione opcion-</option>
											<?php
											foreach ($tipoIncidencia as $tipo) {
											echo '<option value="'.$tipo->tabl_id.'">'.$tipo->valor.'</option>';
											}
											?>
								</select>				
            				</div>
							<div class="form-group">
								<label for="fecha" class="form-label">Fecha y hora:</label>
								<!-- <input type="datetime-local" name="fecha" id="fecha" class="form-control" required> -->
			    				<input type="date" name="fecha" id="fecha" class="form-control" required>
							</div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
								<label for="num_acta" class="form-label">Nro acta:</label>
								<input size="10" type="text" name="num_acta" id="num_acta" min="0" class="form-control"
														required>
							</div>
							<!--Adjuntar imagen--> 
							<div class="col-md-12">
							    <form action="cargar_archivo" method="post" enctype="multipart/form-data">
                                <input class="form-control" type="file" class=" input-sm" id="img_FileB" onchange="convertB()" 
                                accept=".jpg, .jpeg, .png" style="font-size: smaller;" id="files"  style="color:transparent;">
                                <input type="text" id="input_aux_img65" style="display:none" >
                                <input type="text" id="input_aux_zonaID" style="display:none" > 
							    </form>
						    	<img src="" alt="no hay imagen! cargue una" id="img_base2" width="" height="" style="margin-top: 20px;border-radius: 8px;">
                               
							</div>
							<!--Adjuntar imagen-->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary" id="btnsaveIncidencia">Guardar</button>
                        <button type="button" class="btn btn-default" id="btnclose" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal modalAdjImagen-->
<div class="modal fade" id="modalAdjImagen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Adjuntar imagen</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group text-center">
                            <input class="form-control" type="file" class=" input-sm" id="img_File" onchange="convertA()" name=img
                                accept=".jpg, .jpeg, .png" style="font-size: smaller;" id="files"  style="color:transparent;">
                            <input type="text" id="input_aux_img64" style="display:none" >
                            <input type="text" id="input_aux_zonaID" style="display:none" > 
                            <br>                                
                            <img src="" alt="no hay imagen! cargue una" id="img_base" width="" height="">
                        </div>
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="button" class="btn btn-default" id="btnclose" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Seleccionar recipiente destino -->
<div class="modal fade" id="modalReciDestino" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Selecciona Box Destino</h5>
            </div>
            <div class="modal-body">
                <!-- <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6"> -->
                        <!-- <div class="form-group text-center"> -->
                          <!--aca va el php que pinta la matriz de recipientes -->
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
                                        $idcol = "BOX" . $array[$j] . $idcol  ;  
                                
                                            echo '<div class="col-xs-2" style="margin-right: -5rem; width: 23.666667%;">';
                                                    echo'<div class="thumbnail" style="margin-right: 3rem;">';
                                                        echo'<div class="caption">';
                                                                echo '<h5 style="font-size: 12px;">'.$idcol.'</h5>';
                                                                if($aux == 1){
                                                                    for($t=0;$t<count($deposito);$t++)
                                                                    {
                                                                        if($deposito[$t]->col == $i+1)
                                                                        {   $sumai = $i+1;
                                                                            $sumaj = $j+1;
                                                                            $ij = $sumaj.$sumai;
                                                                            $suma = $sumaj."/".$sumai."@".$idcol;
                                                                            if($deposito[$t]->estado == "VACIO"){
                                                                                $aux2 = 1;                                                  
                                                                                echo "<input class='btnvolcar btnMatrizSelreci $ij' type='button' name='Volcar' id='$suma'  data-json=".json_encode($deposito[$t])."  value='Volcar' onclick='btnVolcarRecidest(this)' style='border-radius: 15px; color: #040cff; '/>";
                                                                                // echo"<button type='button' class='btn btn-default btnvolcar' style='font-size: 10px;' id='$idcol'>Volcar</button>";
                                                                            }else{
                                                                                $aux2= 1;
                                                                                // echo "<input class='btnmover btnMatriz $ij'  type='button' name='Mover' id='$suma' value='Mover' onclick='btnMover(this)' style='border-radius: 15px; color: red; '/>";
                                                                                // echo"<button type='button' class='btn btn-default btnMover' style='font-size: 10px;' id='$idcol'>Mover</button>";
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
                        <!-- </div>
                    </div>
                    <div class="col-md-3">
                    </div>
                </div> -->
            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="button" class="btn btn-default" id="btnclose" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
//deshabilita los botones originales de la notificacion estandar						
$(document).ready(function(){
			$('.btnNotifEstandar').hide();
	});

function ReDirecciona()
{
    $("#modalRedireccionar").modal('show');
}
TODO://complete descomentar el cerrarTarea para terminar y cont_id
function GuardaReDirecciona()
{
    
    var auxRed = 1;
    $("#SiRedirecciona").val(auxRed);
    var redirecc = new FormData();
    redirecc = formToObject(redirecc);
    redirecc.depo_id =  $("#deposito_id").val();
    redirecc.observaciones_descarga = $("#infored").val(); 
    redirecc.ortr_id =  $("#otred").val();
    redirecc.cont_id =  $("#dato_cont_id").val();
    // redirecc.cont_id =  106;
    console.table(redirecc);
    $.ajax({
				type: 'POST',
				data:{ redirecc},
				 url: 'general/transporte-bpm/EntregaContDescarga/RedireccionarRecipiente',
				success: function(result) {
					
								
								},
        error: function(error) {
            
        },
        complete:function() {
            $("#modalRedireccionar").modal('hide');
            // cerrarTarea();
        }
				
		});


}

// $(".btnMover").click(function(){
//    $("#modalMover").modal('show');
//    var textfilacol = $(".btnMover").attr("id");
//    console.table(textfilacol);
   
// });

// $(".btnvolcar").click(function(){
//    var textfilacol = $(".btnvolcar").attr("id");
//    console.table(textfilacol);
// });
function btnMover (comp)
{
    $("#modalMover").modal('show');
    let id = comp.id;
    var idfinal = "";
    // for(var i=0; i<id.length;i++)
    // {

    //     idfinal = idfinal + id[i];
    //     if(id[i]=="@")
    //     {
    //         i=id.length;
    //     }
        
    // }

    // obtiene el id del boton que se selecciono
    for(var i=0; i<id.length;i++)
        {
            if(id[i]!="/"){
                if(id[i]!="@")
                {
                    idfinal = idfinal + id[i];
                }
            
            }
        
            if(id[i]=="@")
            {
                i=id.length;
            }
        }
    // Obtengo el nombre del box para asignarle en el modal al input areainiciomover 
    var aux=0;
    var idnom = "";
    for(var j=0; j<id.length; j++)
    {
        if(aux == 1)
        {
            idnom = idnom + id[j];
        }
        if(id[j]=="@")
        {
            aux = 1;
        }
       
    }
    console.table("btnMover");
    console.table(id.length);
    $("#areainiciomover").val(idnom);
    $("#id_reci_mov").val(idfinal);

    
}

// --------------------------------------------------------

function btnVolcar (comp)
{
    let id = comp.id;
    console.table("btnVolcar");
    var idfinal = "";

    // obtiene el id del boton que se selecciono
    for(var i=0; i<id.length;i++)
    {
        if(id[i]!="/"){
            if(id[i]!="@")
            {
                idfinal = idfinal + id[i];
            }
        
        }
      
        if(id[i]=="@")
        {
            i=id.length;
        }
    }
  
    
     $("#idBox").val(idfinal); // Guarda el id en un input que esta oculto
     $("."+idfinal).attr("style","background: #c1f9b7; border-radius: 41rem; width: 5rem; color: #3c8dbc; border: unset; height: 5rem;"); // cambio el color de fondo del boton
     $(".btnMatriz").attr("disabled", ""); // a todos lo demas botones que de hecho todos tienen la misma clase btnMatriz se los desactiva
     datareci = JSON.parse($("."+idfinal).attr("data-json")); // aca obtenego todos los datos de ese recipiente
     console.table(datareci);
     $("#reci_id").val(datareci.reci_id); // en este input guardo el id del recipiente que luego usare 
     console.table($("#reci_id").val());

    //  var a = idfinal;
    //  $("."+id).removeAttr("disabled");
    
}
$("#incidencia").click(function(e){
    $("#modalIncidencia").modal("show");
});
$("#adjimg").click(function(e){
    $("#modalAdjImagen").modal("show");
});

$("#cancelarsel").click(function(e){
   var idf =  $("#idBox").val();
   $("."+idf).removeAttr("style");
   $("."+idf).attr("style","border-radius: 41rem; width: 5rem; color:#77d86b; border: unset; height: 5rem; ");
     $(".btnMatriz").removeAttr("disabled", "");
});
</script>

<!-- Code Imagen -->
<script>

//Convertir a base64 el archivo Imagen
function GetFile(file){
		var reader = new FileReader();
		return new Promise((resolve, reject) => {
			reader.onerror = () => {
				reader.abort();
				reject(new Error("Error parsing file"));
			}
			reader.onload = function() {
				//This will result in an array that will be recognized by C#.NET WebApi as a byte[]
				let bytes = Array.from(new Uint8Array(this.result));
				//if you want the base64encoded file you would use the below line:
				let base64StringFile = btoa(bytes.map((item) => String.fromCharCode(item)).join(""));
				//Resolve the promise with your custom file structure
				resolve({
					bytes: bytes,
					base64StringFile: base64StringFile,
					fileName: file.name,
					fileType: file.type
				});
			}
			reader.readAsArrayBuffer(file);
		});
	}
    function GetFileIncidencia(file){
		var reader = new FileReader();
		return new Promise((resolve, reject) => {
			reader.onerror = () => {
				reader.abort();
				reject(new Error("Error parsing file"));
			}
			reader.onload = function() {
				//This will result in an array that will be recognized by C#.NET WebApi as a byte[]
				let bytes = Array.from(new Uint8Array(this.result));
				//if you want the base64encoded file you would use the below line:
				let base64StringFile = btoa(bytes.map((item) => String.fromCharCode(item)).join(""));
				//Resolve the promise with your custom file structure
				resolve({
					bytes: bytes,
					base64StringFile: base64StringFile,
					fileName: file.name,
					fileType: file.type
				});
			}
			reader.readAsArrayBuffer(file);
		});
	}

async function convertA(){
       
       
       var file = document.getElementById('img_File').files[0];
       console.table(document.getElementById('img_File').files[0]);
           if (file) {
               var archivo = await GetFile(file);
               console.table(archivo);
               if(archivo.fileType == "image/jpeg"){
                  var cod = "data:image/jpeg;base64,"+archivo.base64StringFile;
                  //var cod = "data:image/png;base64,"+archivo.base64StringFile;
                    $("#input_aux_img64").val(cod);
                    $("#img_base").attr("src",$("#input_aux_img64").val());
                    $("#img_base").attr("width",100);
                    $("#img_base").attr("height",100);
               }else{
                   if(archivo.fileType == "application/pdf"){
                      var cod = "data:application/pdf;base64,"+archivo.base64StringFile;
                   }
                 
               }
               
              
                console.table($("#input_aux_img64").val());
                
               
           }
          
           
           
   }
//    para cargar imagen en reg incidencia 
   async function convertB(){
       
       
       var file = document.getElementById('img_FileB').files[0];
       console.table(document.getElementById('img_FileB').files[0]);
           if (file) {
               var archivo = await GetFileIncidencia(file);
               console.table(archivo);
               if(archivo.fileType == "image/jpeg"){
                  var cod = "data:image/jpeg;base64,"+archivo.base64StringFile;
                  //var cod = "data:image/png;base64,"+archivo.base64StringFile;
                    $("#input_aux_img65").val(cod);
                    $("#img_base2").attr("src",$("#input_aux_img65").val());
                    $("#img_base2").attr("width",100);
                    $("#img_base2").attr("height",100);
               }else{
                   if(archivo.fileType == "application/pdf"){
                      var cod = "data:application/pdf;base64,"+archivo.base64StringFile;
                   }
                 
               }
               
              
                console.table($("#input_aux_img65").val());
                
               
           }
          
           
           
   }



</script>
<!-- Funcion btn Cretificado de Vuelco -->
<script>
function Certificado()
{
    var contEntDesc = new FormData();
    contEntDesc = formToObject(contEntDesc);
    contEntDesc.foto = $("#input_aux_img64").val();
    contEntDesc.tiva_id = $("#valorizado_id").val();
    contEntDesc.observaciones_descarga = $("#obs").val();
    contEntDesc.ortr_id = $("#otred").val();
    contEntDesc.cont_id = $("#dato_cont_id").val();
    var contEntReci = new FormData();
    contEntReci = formToObject(contEntReci);
    contEntReci.reci_id_destino = $("#reci_id").val();
    contEntReci.ortr_id =$("#otred").val();
    contEntReci.cont_id =$("#dato_cont_id").val();

    $.ajax({
        type: "POST",
        data: {contEntDesc, contEntReci },
        url: "general/transporte-bpm/EntregaContDescarga/certificadoVuelco",
        success: function (response) {


            // TODO: REVISAR DE ACUERDO AL RESULTADO DEL SERVICIO
            alert("Operacion realizada con exito");
            cerrarTarea();// CIERRA TAREA EN BPM NO CONFNDIR CON LA DE VISTA BAND DE ENTRADA
        },
        error: function(error) {

        },
        complete:function() {

        }
    });

}



</script>

<!-- funciones para el Mover -->
<script>
$("#btnrecidestino").click(function(e){
    $("#modalReciDestino").modal('show');
    $("#areafinmover").val("");
});

//funcion que llama al seleccionar el reci destino
function btnVolcarRecidest(comp)
{
    
    //obtengo el id del recipiente que se selecciono como destino para poder acceder y cambiar luego sus atributos
    let id = comp.id;
    console.table("btnVolcar");
    var idfinale = "";
    for(var i=0; i<id.length;i++)
    {
        if(id[i]!="/"){
            if(id[i]!="@")
            {
                idfinale = idfinale + id[i];
            }
        
        }
      
        if(id[i]=="@")
        {
            i=id.length;
        }
    }
    $("#idRecDestino").val(idfinale); // guardo el id del reci destino que selecciono para colocar lo movido
    $("."+idfinale).attr("value","Mover"); // le cambio al reci destino su nombre a mover
    $("."+idfinale).attr("onclick","btnMover(this)"); // cambio a la funcion que llama de volcar a mover 
    var idreciinicio =  $("#id_reci_mov").val(); //obtengo el id del recipiente inicio (el que inicio el modal mover)
    $("."+idreciinicio).attr("value","Volcar"); // al reci inicio le cambio de mover a volcar 
    $("."+idreciinicio).attr("onclick","btnVolcar(this)"); // cambio la funcion a la que llama el reci inicio de btnmover a btnvolcar

    //obtengo el nombre del box que se selecciono como destino para mover
    var aux=0;
    var idnomb = "";
    for(var j=0; j<id.length; j++)
    {
        if(aux == 1)
        {
            idnomb = idnomb + id[j];
        }
        if(id[j]=="@")
        {
            aux = 1;
        }
       
    }
    datareci = JSON.parse($("."+idfinale).attr("data-json"));
    $("#reci_id_destino_mover").val(datareci.reci_id);
    $("#areafinmover").val(idnomb); // asigno el nombre al input de area fin que obtuve anteriormente
    $("#modalReciDestino").modal('hide');
}

$("#btncloseModalReciDest").click(function(e){
    $("#areafinmover").val("");
    var IDFinal = $("#idRecDestino").val();
    var IDOrigen =  $("#id_reci_mov").val();
    $("."+IDOrigen).attr("value","Mover");  
    $("."+IDOrigen).attr("onclick","btnMover(this)");
    $("."+IDFinal).attr("value","Volcar");  
    $("."+IDFinal).attr("onclick","btnVolcar(this)");
     $("#modalMover").modal('hide');
});

function cerrarTarea()
{
    if($("#tieneInci").val()==1)
    {   var opcion = "true";
        var ResPeligrosos = {opcion: opcion};	
    }else{
        var opcion = "false";
        var ResPeligrosos = {opcion: opcion};	
    }

    if($("#SiRedirecciona").val()==1)
    {
        var op = "true";
        var redirecciona = {opcion: op};
    }else{
        var op ="false";
        var redirecciona = {opcion: op};
    }
    var taskId = $('#taskId').val();

    $.ajax({
				type: 'POST',
				data:{ ResPeligrosos, redirecciona},
                dataType: "json",
				url: 'traz-comp-bpm/Proceso/cerrarTarea/' + taskId,
				success: function(result) {
									wc();
									if(result.status){
										alertify.success("Contenedor descargado...");
										recargaBandejaEntrada();
									}else{
										alertify.error('Error en descargar contenedor...');
									}
								},
				error: function(result){
									wc();
							 },
				complete: function(){
									wc();

								}
		});
}

$("#btnsaveIncidencia").click(function(e){
    var aux = 1;
    $("tieneInci").val(aux);
    var incidencia = new FormData($('#formIncidencia')[0]);
			incidencia = formToObject(incidencia);
            incidencia.adjunto = $("#input_aux_img65").val();		
			console.table(incidencia);

			$.ajax({
					type: 'POST',
					data:{ incidencia },
				    url: "general/Estructura/Incidencia/guardarIncidencia",
					success: function(result) {		
						
								if(result == 'ok'){
									$("#modalIncidencia").modal('hide');
									alertify.success("Incidencia agregada con exito...");
								}
					},
					error: function(result){
								$("#modalIncidencia").modal('hide');
								alertify.error('Error agregando incidencia...');
					},
					complete: function(){
									
					}
			});

});

TODO:
$("#btnsavemodalmov").click(function(){

    var recipmov = new FormData();
    recipmov = formToObject(recipmov);
    recipmov.batch_id = $("#batch_id").val();
    recipmov.reci_id_destino = $("#reci_id_destino_mover").val();
    recipmov.usuario_app = "hugoDs";
    $.ajax({
				type: 'POST',
				data:{ recipmov},
				url: 'general/transporte-bpm/EntregaContDescarga/MoverRecipiente',
				success: function(result) {
								
								}
		});
});

// recarga la bandeja de entrada
function recargaBandejaEntrada()
{
  linkTo('<?php echo BPM ?>Proceso/index');
}
</script>