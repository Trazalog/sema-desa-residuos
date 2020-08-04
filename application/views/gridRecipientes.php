<?php
    $deposito = [];
    // $col = $TamDeposito->col;
    // $row = $TamDeposito->row;
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
        {   
            $idcol = $i+1;
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
                                            }else{
                                                $aux2= 1;
                                            }
                                        }
                                    }
                                }                
                        echo'</div>';
                    echo'</div>';
            echo'</div>';
        }
        echo '</div>';
        unset($deposito);
    }  
?>