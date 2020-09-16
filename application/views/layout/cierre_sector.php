
<!---//////////////////////////////////////--- BOX 1 ---///////////////////////////////////////////////////////----->

<div class="box box-primary animated bounceInDown" id="boxDatos">
    <div class="box-header with-border">
        <div class="box-tittle">
        <h5>Cierre de Sector</h5>  
        </div>
        <div class="box-tools pull-right" style="display:none;">
            <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                data-toggle="tooltip" title="" data-original-title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>

    <!--_____________________________________________-->

    <div class="box-body">
                <div>
                    <h3>Sector de descarga</h3>
                    <input type="text" id="sector" readonly style="margin-right: 3rem;" value="<?=$sector?>">  
                    <input type="text" id="estado" readonly value="activo">
                </div>
                <br>
                <div>
                    <!-- RECIPIENTES LLENO-VACIOS DEL SECTOR  -->
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
                                                                        echo "<input class='btnvolcar btnMatriz $ij' type='button' name='Volcar' id='$suma'  data-json=".json_encode($deposito[$t])."  value='Volcar' onclick='btnVolcar(this)' style='border-radius: 15px; color: #040cff; '/>";
                                                                        // echo"<button type='button' class='btn btn-default btnvolcar' style='font-size: 10px;' id='$idcol'>Volcar</button>";
                                                                    }else{
                                                                        $aux2= 1;
                                                                        echo "<input readonly class='btnmover btnMatriz $ij'  type='button' name='Mover' id='$suma' value='Mover' onclick='btnMover(this)' style='border-radius: 15px; color: red; '/>";
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
                        <!-- FIN RECIPIENTES DEL SECTOR -->
                    </div>
       
        
                    <br>
                    <div>
                        <button type="submit" class="btn btn-primary pull-right" id="btnCloseSec" onclick="Cerrar_Sector()">Cerrar Sector</button>
                        <button type="submit" class="btn btn-primary pull-right" id="btnHabilitar" onclick="Habilitar_Sector()" style="margin-right: 1rem;">Habilitar Sector</button>
                    </div>
       
        
    </div>
    
</div>
<script>
$(document).ready(function(){

    $("#estado").attr("style","border-radius: 29rem; width: 11rem; height: 4rem; border-color: #b5c7b8; background: #58c56a; text-align: center; font-size: large; font-weight: bold;");
    // $("#estado").attr("style","border-radius: 29rem; width: 11rem; height: 4rem; border-color: #b5c7b8; background: #f35757; text-align: center; font-size: large; font-weight: bold;");
});	

function Cerrar_Sector()
{
     $("#estado").attr("style","border-radius: 29rem; width: 11rem; height: 4rem; border-color: #b5c7b8; background: #f35757; text-align: center; font-size: large; font-weight: bold;");
     $("#estado").val("cerrado");
     $("#btnCloseSec").attr("style","display: none;");
}

function Habilitar_Sector()
{
    $("#estado").attr("style","border-radius: 29rem; width: 11rem; height: 4rem; border-color: #b5c7b8; background: #58c56a; text-align: center; font-size: large; font-weight: bold;");
    $("#estado").val("activo");
    $("#btnCloseSec").removeAttr("style");
}



</script>