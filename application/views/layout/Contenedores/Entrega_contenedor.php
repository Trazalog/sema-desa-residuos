<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Gestion solicitudes contenedores</h4>

    </div>


    <!-- /// ----------------------------------- HEADER ----------------------------------- /// -->



    <div class="box-body">

        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">

                <!--_____________________________________________-->
                <!--N° Solicitud-->

                <div class="col-md-6 col-sm-6 col-xs-12">

                    <div class="form-group">
                        <label for="Dpto">N° Solicitud:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                            <input type="number" class="form-control" name="numero" id="Numero" readonly>
                        </div>
                    </div>

                </div>

                <!--_____________________________________________-->
                <!--Fecha-->

                <div class="col-md-6 col-sm-6 col-xs-12">

                    <div class="form-group">
                        <label for="Dpto">Fecha:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                            <input type="date" class="form-control" name="fecha" id="Fecha" readonly>
                        </div>
                    </div>

                </div>

            </div>

        </div>


        <div class="row">


            <!--_____________________TABLA________________________-->


            <div class="col-sm-12 table-scroll" id="cargar_tabla"></div>

            <!--_____________________TABLA________________________-->



            <div class="col-md-12 col-sm-12 col-xs-12"><hr></div>

            <!--_____________________________________________-->
            <!--Boton GUARDAR-->

            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-right" aria-label="Left Align">Guardar</button>
                </div>



            </div>

        </div>

    </div>

</div>


        <!-- /// ----------------------------------- HEADER ----------------------------------- /// -->








        <script>
        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Contenedor/Listar_entregas");
        </script>





<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Entrega de contenedor</h4>

    </div>


<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->



    <div class="box-body">

        


        <div class="row">


            <!--_____________________TABLA________________________-->


            <div class="col-md-12">

<div class="row">

    <div class="col-md-12 table-scroll">

        <!--__________________HEADER TABLA___________________________-->
        <table id="tabla_contenedores" class="table table-bordered table-striped">
            <thead class="thead-dark" bgcolor="#eeeeee">

                <th>Acciones</th>
                <th>Numero solicitud</th>
                <th>Codigo ontenedor</th>
                <th>Tipo residuo</th>
                <th>Cantidad</th>
                <th>Estado</th>
                

            </thead>

            <!--__________________BODY TABLA___________________________-->

            <tbody>
            <tr>
                <td>
                <!-- <button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp -->
                <button type="button" title="Entregar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalContenedor"><span class="glyphicon glyphicon-share" aria-hidden="true"></span></button>&nbsp
                
                </td>
                <td>DATO</td>
                <td>DATO</td>
                <td> DATO</td>
                <td>DATO</td>
                <td>DATO</td>
            </tr>

            
            </tbody>
        </table>

        <!--__________________FIN TABLA___________________________-->

    </div>

</div>
</div>

            <!--_____________________TABLA________________________-->



            <div class="col-md-12 col-sm-12 col-xs-12"><hr></div>

            <!--_____________________________________________-->
            <!--Boton GUARDAR-->

            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-right" aria-label="Left Align">Guardar</button>
                </div>



            </div>

        </div>

    </div>

</div>



<script>



    DataTable($('#tabla_contenedores'))

   
</script>