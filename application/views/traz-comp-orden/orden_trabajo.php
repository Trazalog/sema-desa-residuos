<input type="hidden" id="permission" value="<?php echo $permission; ?>">

<input type="text" class="hidden" id="task" value="<?php echo $idTarBonita ?>">

<?php
$userdata = $this->session->userdata('user_data');
$usrId = $userdata[0]['usrId'];     // guarda usuario logueado 
$usrName =  $userdata[0]['usrName'];
$usrLastName = $userdata[0]["usrLastName"];
echo "<input type='text' class='hidden' id='empresa_id' value='" . $userdata[0]['id_empresa'] . "'>";
echo "<input type='text' class='hidden' id='usrName' value='$usrName' >";
echo "<input type='text' class='hidden' id='usrLastName' value='$usrLastName' >";
echo "<input type='text' class='hidden' id='case' value='" . $TareaBPM['caseId'] . "'>";
echo "<input type='text' class='hidden' id='id_OT' value='" . $id_OT . "'>";
echo "<input type='text' class='hidden' id='estadoTarea' value=''>";
?>
<!--------------------------------------- ESTILOS --------------------------------------->
<!-- <style>
    .cronometro {
        /* width: 200px !important;
        height: 100px !important; */
        top: 50% !important;
        left: 50% !important;
        /* position: absolute !important; */
        /* margin-top: -50px !important;
        margin-left: -100px !important; */
        text-align: center !important;
    }

    .contador {
        /* height: 68px !important;
        padding: 5px 0 !important; */
        font-size: 1.9em !important;
        color: #000 !important;
        font-family: arial !important;
    }
</style> -->

<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Orden de Trabajo</h4>
    </div>
    <div class="box-body">
        <!-- <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <button type="button" id="start" class="btn btn-block btn-success btn-lg start" title="Iniciar" onclick="start(this)"><i class="fa fa-fw fa-play fa-2x" value="start"></i></button>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <button type="button" id="stop" class="btn btn-block btn-danger btn-lg stop" title="Detener" onclick="stop(this)"><i class="fa fa-fw fa-stop fa-2x" value="stop"></i> </i> </button> 
                </div>
                <!-- <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="row crono-width">
                                <div class="start-btn col-md-6 text-center btn-crono">
                                    <div class="start">Iniciar</div>
                                </div>
                                <div class="stop-btn col-md-6 text-center btn-crono">
                                    <div class="stop">Detener</div>
                                </div>
                            </div>
                </div> -->
        <!-- <div class="col-md-5 col-sm-5 col-xs-12 contador">
                    <div class="hour-time time text-center col-md-4">
                        <span id="hour">00</span> <i>horas</i>
                    </div>
                    <div class="minute-time time text-center col-md-4">
                        <span id="minute">00</span> <i>minutos</i>
                    </div>
                    <div class="second-time time text-center col-md-4">
                        <span id="second">00</span> <i>segundos</i>
                    </div>

                    
                </div>


            </div>
            <br>
            
        </div> -->
        <?php cargarCabecera($id_OT, $id_SS, $id_EQ); ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div role="tabpanel" class="tab-pane">
                                    <div class="form-group">

                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Tareas</a></li>
                                            <li role="presentation"><a href="#info2" aria-controls="info2" role="tab" data-toggle="tab">Info </a></li>
                                            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Comentarios</a></li>
                                            <li <?php echo ($device == 'android' ? 'class= "hidden"' : 'class= ""') ?>role="presentation">
                                                <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Trazabildad
                                                </a></li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">

                                            <div role="tabpanel" class="tab-pane active" id="home">
                                                <!-- <h4 class="panel-heading">Tarea</h4> -->

                                                <div class="panel-body">

                                                    <!-- botones Tomar y soltar tareas -->
                                                    <?php
                                                    echo '<div class="row">';
                                                    // BTN Tomar y soltar Tarea
                                                    echo '<div class="col-md-4">';
                                                    echo "<button class='btn btn-block btn-success' id='btontomar' style='width: 100px; margin-top: 10px ;display: inline-block;' onclick='tomarTarea()'>Tomar tarea</button>";
                                                    echo "&nbsp";
                                                    echo "&nbsp";
                                                    echo "&nbsp";
                                                    echo "<button class='btn btn-block btn-danger grupNoasignado' id='btonsoltr' style='width: 100px; margin-top: 10px; display: inline-block;' onclick='soltarTarea()'>Soltar tarea</button>";
                                                    echo '</div>';
                                                    // BTN Iniciar Tarea 
                                                    echo '<div class="col-md-4 col-md-offset-4 oculto" id="llave">';
                                                    echo '<button type="button" class="btn btn-success" id="iniciarTarea"><i class="fa fa-play"> </i> Iniciar Tarea</button>';
                                                    echo '<button type="button" class="btn btn-success disabled" id="tareaIniciada"><i class="fa fa-play"> </i> Tarea Iniciada</button>';
                                                    echo '</div>';

                                                    echo '</div>';
                                                    echo "</br>";
                                                    ?>

                                                    <input type="text" class="form-control hidden" id="asignado" value="<?php echo $TareaBPM["assigned_id"] ?>">

                                                    <h4> <b>Tarea: </b><?php echo  $TareaBPM['displayName'] ?></h3>

                                                        <?php
                                                        if ($subtareas !== NULL) {
                                                            echo ' <div class="panel panel-default">';
                                                            // echo 'entre en subtareas'	;
                                                            // dump($subtareas , 'subtareas en vista:');			
                                                            echo '<table id="subtask" class="table table-hover">';
                                                            echo '<thead>';
                                                            echo    '<tr>';
                                                            echo    '<th width="2%">Estado</th>';
                                                            echo    '<th width="10%">Subtarea</th>';
                                                            echo    '<th width="10%">Duración</th>';
                                                            echo    '<th width="10%">Formulario</th>';
                                                            echo '</tr>';
                                                            echo '</thead>';
                                                            echo '<tbody>';

                                                            //dump($subtareas, 'subtareas');
                                                            foreach ($subtareas as $subt) {
                                                                echo '<tr>';
                                                                echo '<td>';
                                                                if ($subt["estado"] != 'T')
                                                                    echo '<input class="check" type="checkbox" name="estado" value="" id="' . $subt["id_listarea"] . '">';
                                                                else
                                                                    echo '<input class="check" type="checkbox" name="estado" value="" id="' . $subt["id_listarea"] . '" checked>';
                                                                echo '</td>';

                                                                if ($subt['tareadescrip'] != null) {
                                                                    echo '<td>' . $subt['tareadescrip'] . '</td>';
                                                                } else {
                                                                    echo '<td>' . $subt['subtareadescrip'] . '</td>';
                                                                }
                                                                echo '<td>' . $subt['duracion_prog'] . '</td>';

                                                                if ($subt['subtareadescrip'] != null) {
                                                                    echo '<td class="frm-open" data-info="' . $subt["info_id"] . '"><i class="fa fa-paperclip text-light-blue " style="cursor: pointer; margin-left: 15px;" aria-hidden="true" id="' . $subt["id_listarea"] . '" ></i></td>';
                                                                }

                                                                echo '</tr>';
                                                            }

                                                            echo '</tbody>';
                                                            echo '</table></div>';
                                                        }
                                                        ?>

                                                </div>


                                                <br>

                                                <div id="nota_pedido">

                                                    <?php
                                                    $this->load->view(ALM . '/notapedido/list');

                                                    ?>
                                                </div>
                                            </div>

                                            <!-- Info Tarea-->
                                            <div role="tabpanel" class="tab-pane" id="info2">
                                                <div class="panel-body">

                                                    <form>
                                                        <div class="panel panel-default">
                                                            <!-- <h4 class="panel-heading">INFORMACION:</h4> -->
                                                            <div class="panel-heading">INFORMACION:</div>

                                                            <div class="form-group">
                                                                <div class="col-sm-6 col-md-6">
                                                                    <label for="tarea">Tarea</label>
                                                                    <input type="text" class="form-control" id="tarea" value="<?php echo $TareaBPM['displayName'] ?>" disabled><!-- id de listarea -->
                                                                    <input type="text" class="hidden" id="tbl_listarea" value="<?php echo $datos[0]['id_listarea'] ?>">
                                                                    <input type="text" class="hidden" id="idform" value="<?php echo $idForm ?>">
                                                                    <!-- id de task en bonita -->
                                                                    <input type="text" class="hidden" id="idTarBonita" value="<?php echo $idTarBonita ?>">
                                                                    <input type="text" class="hidden" id="esTareaStd" value="<?php echo $infoTarea['visible'] ?>">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-sm-6 col-md-6">
                                                                    <label for="fecha">Fecha de Creación</label>
                                                                    <input type="text" class="form-control" id="fecha" placeholder="" value="<?php echo $TareaBPM['last_update_date'] ?>" disabled>
                                                                </div>
                                                            </div><br>

                                                            <div class="form-group ">
                                                                <div class="col-sm-6 col-md-6 ">
                                                                    <label for="ot ">Orden de Trabajo:</label>
                                                                    <input type="text " class="form-control " id="ot" placeholder=" " value="<?php echo $id_OT ?>" disabled />
                                                                </div>
                                                            </div><br>

                                                            <div class="form-group">
                                                                <div class="col-sm-6 col-md-6">
                                                                    <label for="duracion_std">Duracion Estandar
                                                                        (minutos):</label>
                                                                    <input type="text" class="form-control" id="duracion_std" placeholder="" value="<?php echo $datos[0]['duracion_std']  ?>" disabled>
                                                                </div></br>
                                                            </div>

                                                            <br>

                                                            <div class="form-group">
                                                                <div class="col-sm-12 col-md-12">
                                                                    <label for="detalle">Detalle</label>
                                                                    <textarea class="form-control" id="detalle" rows="3" disabled><?php echo $TareaBPM['displayDescription'] ?></textarea>
                                                                </div>
                                                            </div><br> <br> <br> <br> <br>


                                                            <div class="form-group">
                                                                <div class="col-sm-12 col-md-12">
                                                                    <!-- Modal formulario tarea -->
                                                                    <?php if ($idForm != 0) {
                                                                        echo '<button type="button" id="formulario" class="btn btn-primary" data-toggle="modal"data-target=".bs-example-modal-lg" onclick="getformulario()">Completar Formulario </button>';
                                                                    } ?>
                                                                </div>
                                                            </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                        <div role="tabpanel" class="tab-pane" id="profile">
                                            <div class="panel-body">
                                                <!-- COMENTARIOS -->
                                                <?php echo $comentarios ?>
                                            </div>
                                        </div>

                                        <div role="tabpanel" <?php echo ($device == 'android' ? 'class= "hidden"' : 'class= "tab-pane"') ?> id="messages">

                                            <div class="panel-body">

                                                <?php
                                                timeline($timeline);
                                                ?>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="cerrar" class="btn btn-primary">Cerrar</button>
                                <button type="button" class="btn btn-success" id="hecho" onclick="validarSubtareas()">Terminar Tarea</button>
                            </div> <!-- /.modal footer -->
                        </div>
                    </div>
                </div><!-- /.row -->



            </div><!-- /.box body -->
        </div> <!-- /.box  -->
    </div><!-- /.col -->
</div><!-- /.row -->
</div>
</div>

<!--__________________________________________________________________________________________-->
<!-- /// ----------------------------------- BODY ----------------------------------- /// -->

<script>
    clearInterval(running_time);
    var tiempo = {
        hora: 0,
        minuto: 0,
        segundo: 0
    };

    var running_time = null;
    $('#start').click();

    function start(e) {
        // $(".start").click(click,function() {
        if ($(e).find('i').val() == 'start') {
            $(e).find('i').removeClass('fa-play');
            $(e).find('i').addClass('fa-pause');
            $(e).find('i').val('pause');
            $(e).attr('title', 'Pausar');

            running_time = setInterval(function() {
                // Segundos
                tiempo.segundo++;
                if (tiempo.segundo >= 60) {
                    tiempo.segundo = 0;
                    tiempo.minuto++;
                }

                // Minutos
                if (tiempo.minuto >= 60) {
                    tiempo.minuto = 0;
                    tiempo.hora++;
                }

                $("#hour").text(tiempo.hora < 10 ? '0' + tiempo.hora : tiempo.hora);
                $("#minute").text(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);
                $("#second").text(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);
            }, 0.5);
        } else {
            $(e).find('i').removeClass('fa-pause');
            $(e).find('i').val('start');
            $(e).find('i').addClass('fa-play');
            $(e).attr('title', 'Reanudar');
            clearInterval(running_time);
        }
        // });
    }

    function stop() {
        var hora = tiempo.hora < 10 ? '0' + tiempo.hora : tiempo.hora;
        var minuto = tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto;
        var segundo = tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo;

        tiempo = {
            hora: hora,
            minuto: minuto,
            segundo: segundo
        };
        tiempo2 = [
            hora => hora,
            minuto => minuto,
            segundo => segundo
        ];
        // alert("Su tiempo es de: " + tiempo.hora + ":" + tiempo.minuto + ":" + tiempo.segundo);
        // clearInterval(running_time);
        // tiempo = {
        //     hora: 0,
        //     minuto: 0,
        //     segundo: 0
        // };
        // $('.start').find('i').removeClass('fa-pause');
        // $('.start').find('i').val('start');
        // $('.start').find('i').addClass('fa-play');
        // $("#hour").text('0' + tiempo.hora);
        // $("#minute").text('0' + tiempo.minuto);
        // $("#second").text('0' + tiempo.segundo);
        // tiempo = JSON.parse(tiempo);
        // showFD(tiempo);
        // data = formToObject(tiempo2);
        console.log(tiempo);
        data = tiempo;
        // console.log(data);
        // console.log("Tiempo JSON: " + tiempo);
        // alert("Tiempo JSON: " + tiempo);
        $.ajax({
            type: "POST",
            dataType: 'JSON',
            data: data,
            url: "traz-comp-orden/Orden_Trabajo/guardarTiempo",
            success: function(r) {
                r = JSON.parse(r);
                alert('minuto: ' + r.minuto);
                // if (r == "ok") {
                //     //console.log(datos);
                //     $('#formChofer')[0].reset();
                //     alertify.success("Agregado con exito");
                // } else {
                //     console.log(r);
                //     $('#formChofer')[0].reset();
                //     alertify.error("error al agregar");
                // }
                // clearInterval(running_time);
                // tiempo = {
                //     hora: 0,
                //     minuto: 0,
                //     segundo: 0
                // };
                // $('.start').find('i').removeClass('fa-pause');
                // $('.start').find('i').val('start');
                // $('.start').find('i').addClass('fa-play');
                // $("#hour").text('0' + tiempo.hora);
                // $("#minute").text('0' + tiempo.minuto);
                // $("#second").text('0' + tiempo.segundo);
            },
            error: function(r) {
                alert('error: ' + r);
            },
            complete: function() {
                // me.data('requestRunning', false);
            }
        });


    }
</script>