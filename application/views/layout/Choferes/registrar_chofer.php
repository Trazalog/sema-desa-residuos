<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Chofer</h4>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-2 col-lg-1 col-xs-12">
                <button type="button" id="botonAgregar" class="btn btn-primary" aria-label="Left Align">
                    Agregar
                </button><br>
            </div>
            <div class="col-md-10 col-lg-11 col-xs-12"></div>
        </div>
    </div>
</div>

<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<!---//////////////////////////////////////--- BOX 1 ---///////////////////////////////////////////////////////----->

<div class="box box-primary animated bounceInDown" id="boxDatos" hidden>
    <div class="box-header with-border">
        <div class="box-tittle">
        <h5>Informacion</h5>  
        </div>
        <div class="box-tools pull-right">
            <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                data-toggle="tooltip" title="" data-original-title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>

​    <!--_____________________________________________________________-->

        <div class="box-body">
            <form class="formChofer" id="formChofer"  method="POST" autocomplete="off" class="registerForm">
                <div class="col-md-6 col-sm-6 col-xs-12">
        
                    <!--Nombre-->
                        <div class="form-group">
                            <label for="Nombre">Nombre:</label>
                            <input type="text" class="form-control" id="Nombre" name="nombre">
                        </div>
                ​    <!--_____________________________________________________________-->

                    <!--Apellido-->
                        <div class="form-group">
                            <label for="Apellido">Apellido:</label>
                            <input type="text" class="form-control" id="Apellido" name="apellido">
                        </div>
                ​    <!--_____________________________________________________________-->

                    <!--DNI-->
                        <div class="form-group">
                            <label for="DNI">DNI:</label>
                            <input type="text" class="form-control" id="DNI" name="dni">
                        </div>
                ​    <!--_____________________________________________________________-->

                    <!--Fecha de nacimiento-->
                        <div class="form-group">
                            <label for="FechaNacimiento">Fecha de nacimiento:</label>
                                <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="date" class="form-control" id="FechaNacimiento" name="fecha_nacimiento"></div>
                        </div>
                ​    <!--_____________________________________________________________-->

                    <!--Direccion-->
                        <div class="form-group">
                            <label for="Direccion">Direccion:</label>
                            <input type="text" class="form-control" id="Direccion" name="direccion">
                        </div>
                ​    <!--_____________________________________________________________-->

                    <!--Celular-->
                        <div class="form-group">
                            <label for="Celular">Celular:</label>
                            <input type="text" class="form-control" id="Celular" name="celular">
                        </div>
                    <!--_____________________________________________________________-->

                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <!--Codigo-->
                        <div class="form-group">
                            <label for="Codigo">Codigo:</label>
                            <input type="text" class="form-control" id="Codigo" name="codigo">
                        </div>
        ​            <!--_____________________________________________________________-->

                    <!--Empresa-->
                        <div class="form-group">
                            <label for="Empresa">Empresa:</label>
                            <select class="form-control select2 select2-hidden-accesible" id="Empresa" name="empresa">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                    foreach ($empresa as $i) {
                                        echo '<option value="'.$i->descripcion.'">'.$i->razon_social.'</option>';
                                    }
                                ?>
                            </select>
                        </div>


                        <!-- <div class="form-group">
                            <label for="Empresa">Empresa:</label>
                            <input type="text" class="form-control" id="Empresa" name="empresa">
                        </div> -->
                ​    <!--_____________________________________________________________-->

                    <!--Carnet-->
                        <div class="form-group">
                            <label for="Carnet">Carnet:</label>
                            <select class="form-control select2 select2-hidden-accesible" id="Carnet" name="carnet">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                    foreach ($carnet as $i) {
                                        echo '<option value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                ​    <!--_____________________________________________________________-->

                    <!--Categoria-->
                        <div class="form-group">
                            <label for="Categoria">Categoria:</label>
                            <select class="form-control select2 select2-hidden-accesible" id="Categoria" name="categoria">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                    foreach ($categoria as $i) {
                                        echo '<option value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                ​    <!--_____________________________________________________________-->

                    <!--Vencimiento-->
                        <div class="form-group">
                            <label for="Vencimiento">Vencimiento:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="date" class="form-control pull-right" id="datepicker" name="vencimiento">
                            </div>
                            <!-- /.input group -->
                        </div>
                ​    <!--_____________________________________________________________-->

                    <!--Habilitacion-->
                        <div class="form-group">
                            <label for="Habilitacion">Habilitacion:</label>
                            <input type="text" class="form-control" id="Habilitacion" name="habilitacion">
                        </div>
                ​    <!--_____________________________________________________________-->
                    
                    <!--Adjuntador de imagenes-->
                        <!--
                        <form action="cargar_archivo" method="post" enctype="multipart/form-data">
                        <input type="file" id="imgarch" name="upload" data-required="true">
                        </form>
                        -->
                ​    <!--_____________________________________________________________-->

                </div>

                    <!--_______________________SEPARADOR______________________________________-->            

                <div class="col-md-12"><hr></div>

                    <!--_______________________SEPARADOR______________________________________-->

                <div class="col-md-6">

                        <!--
                        <button type="file" name="upload" class="btn btn-default btn-circle" id="file" name="file" accept=".jpg, .jpeg, .png" aria-label="Left Align">
                            <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
                        </button>
                        -->

                        <button type="file" class=" btn btn-default btn-circle pull-left" id="file" name="file" accept=".jpg, .jpeg, .png" >
                            <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
                        </button>
                        <small for="agregar" class="form-label">Adjuntar imagen</small>

                    <!--_____________________________________________________________-->

                </div>

                    <!--Boton de guardado-->
                        <div class="col-md-12"><hr></div><br>
                        <button type="submit" class="btn btn-primary pull-right" onclick="Guardar_Chofer()">Guardar</button>
                    <!--_____________________________________________________________--> 

            </form>
        </div>
    </div>
</div>

<!---//////////////////////////////////////--- FIN BOX---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- TABLA ---///////////////////////////////////////////////////////----->

<div class="box box-primary">
    <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
            <div class="row"><div class="col-sm-12 table-scroll" id="cargar_tabla">
            </div>
        </div>


    <!--__________________TABLA___________________________-->
    <!--
    <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
            <div class="row">
                <div class="col-sm-12 table-scroll">

                    <!--__________________HEADER TABLA___________________________-->

                        <!--__________________HEADER TABLA___________________________-->
                        <!--<table id="tabla_choferes" class="table table-bordered table-striped">
                            <thead class="thead-dark" bgcolor="#eeeeee">
                                <th>Acciones</th>
                                <th>Dominio</th>
                                <th>Condicion</th>
                                <th>Capacidad</th>
                                <th>Tara</th>
                                <th>habilitacion</th>
                                <th>Registro</th>
                            </thead>-->
                            <!--__________________BODY TABLA___________________________-->
                            <!--<tbody>
                            <tr>
                                <td>
                                <button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
                                <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <td>DATO</td>
                                <td>DATO</td>
                                <td>DATO</td>
                                <td>DATO</td>
                                <td>DATO</td>
                                <td>DATO</td>
                            </tr>
                            </tbody>
                        </table>-->
                    <!--__________________FIN TABLA___________________________-->

    <!--                </div>
            </div>
        </div>
    </div>-->

    <!---//////////////////////////////////////--- FIN TABLA---///////////////////////////////////////////////////////----->

    <!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Chofer</h5>
            </div>

            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

                <form class="formChoferEdit" id="formChoferEdit"  method="POST" autocomplete="off" class="registerForm">
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <!--Nombre-->
                            <div class="form-group">
                                <label for="Nombre">Nombre:</label>
                                <input type="text" class="form-control" id="" name="e_nombre">
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Apellido-->
                            <div class="form-group">
                                <label for="Apellido">Apellido:</label>
                                <input type="text" class="form-control" id="" name="e_apellido">
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--DNI-->
                            <div class="form-group">
                                <label for="DNI">DNI:</label>
                                <input type="text" class="form-control" id="" name="e_dni">
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Fecha de nacimiento-->
                            <div class="form-group">
                                <label for="FechaNacimiento">Fecha de nacimiento:</label>
                                <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="date" class="form-control" id="" name="e_fecha_nacimiento"></div>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Direccion-->
                            <div class="form-group">
                                <label for="Direccion">Direccion:</label>
                                <input type="text" class="form-control" id="" name="e_direccion">
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Celular-->
                            <div class="form-group">
                                <label for="Celular">Celular:</label>
                                <input type="text" class="form-control" id="" name="e_celular">
                            </div>
                        <!--_____________________________________________________________-->

                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <!--Codigo-->
                            <div class="form-group">
                                <label for="Codigo">Codigo:</label>
                                <input type="text" class="form-control" id="" name="e_codigo">
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Empresa-->
                            <div class="form-group">
                                <label for="Empresa">Empresa:</label>
                                <input type="text" class="form-control" id="" name="e_empresa">
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Carnet-->
                            <div class="form-group">
                                <label for="carnet" >Carnet:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="" name="e_carnet">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                    foreach ($carnet as $i) {
                                        echo '<option>'.$i->nombre.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Categoria-->
                            <div class="form-group">
                                <label for="Categoria">Categoria:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="" name="Categoria">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                    foreach ($categoria as $i) {
                                        echo '<option>'.$i->nombre.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Vencimiento-->
                            <div class="form-group">
                                <label for="Vencimiento" >Vencimiento:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control pull-right" id="" name="e_vencimiento">
                                </div>
                                <!-- /.input group -->
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Habilitacion-->
                            <div class="form-group">
                                <label for="Habilitacion">Habilitacion:</label>
                                <input type="text" class="form-control" id="" name="e_habilitacion">
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Adjuntador de imagenes-->
                            <!--
                            <form action="cargar_archivo" method="post" enctype="multipart/form-data" >
                            <input  type="file"  id="imgarch" name="upload" data-required="true">
                            </form>
                            -->
                    ​    <!--_____________________________________________________________-->

                    </div> 
                </form>

        <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            <div class="col-md-12"><hr></div>

            <div class="modal-footer">
                <div class="col-md-12">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary" id="btnsaveEdit">Guardar</button>                    
                        <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL EDITAR ---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- MODAL INFORMACION ---///////////////////////////////////////////////////////----->

<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion Chofer</h5>
            </div>

            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

                <form class="formChofer" id="formChofer"  method="POST" autocomplete="off" class="registerForm">
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <!--Nombre-->
                            <div class="form-group">
                                <label for="Nombre">Nombre:</label>
                                <input type="text" class="form-control" id="Nombre" name="nombre" readonly>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Apellido-->
                            <div class="form-group">
                                <label for="Apellido">Apellido:</label>
                                <input type="text" class="form-control" id="Apellido" name="apellido" readonly>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--DNI-->
                            <div class="form-group">
                                <label for="DNI">DNI:</label>
                                <input type="text" class="form-control" id="DNI" name="dni" readonly>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Fecha de nacimiento-->
                            <div class="form-group">
                                <label for="FechaNacimiento">Fecha de nacimiento:</label>
                                <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="date" class="form-control" id="FechaNacimiento" name="fecha_nacimiento" readonly></div>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Direccion-->
                            <div class="form-group">
                                <label for="Direccion">Direccion:</label>
                                <input type="text" class="form-control" id="Direccion" name="direccion" readonly>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Celular-->
                            <div class="form-group">
                                <label for="Celular">Celular:</label>
                                <input type="text" class="form-control" id="Celular" name="celular" readonly>
                            </div>
                        <!--_____________________________________________________________-->

                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <!--Codigo-->
                            <div class="form-group">
                                <label for="Codigo">Codigo:</label>
                                <input type="text" class="form-control" id="Codigo" name="codigo" readonly>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Empresa-->
                            <div class="form-group">
                                <label for="Empresa">Empresa:</label>
                                <input type="text" class="form-control" id="Empresa" name="empresa" readonly>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Carnet-->
                            <div class="form-group">
                                <label for="carnet">Carnet:</label>
                                <input type="text" class="form-control" id="carnet" name="carnet" readonly>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Categoria-->
                            <div class="form-group">
                                <label for="Categoria">Categoria:</label>
                                <input type="text" class="form-control" id="Categoria" name="categoria" readonly>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Vencimiento-->
                            <div class="form-group" >
                                <label for="Vencimiento">Vencimiento:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control pull-right" id="datepicker" name="vencimiento" readonly>
                                </div>
                                <!-- /.input group -->
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Habilitacion-->
                            <div class="form-group">
                                <label for="Habilitacion">Habilitacion:</label>
                                <input type="text" class="form-control" id="Habilitacion" name="habilitacion"readonly>
                            </div>
                    ​    <!--_____________________________________________________________-->

                        <!--Adjuntador de imagenes-->
                            <!-- <form action="cargar_archivo" method="post" enctype="multipart/form-data" >
                                <input  type="file"  id="imgarch" name="upload" data-required="true">
                            </form> -->
                    ​    <!--_____________________________________________________________-->

                    </div>  
                </form>

                <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            <div class="col-md-12"><hr></div>

            <div class="modal-footer">
                <div class="col-md-12">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL INFORMACION ---///////////////////////////////////////////////////////----->

<!--_____________________________________________________________-->

<!-- script que muestra box de datos al dar click en boton agregar -->
<script>
    $("#botonAgregar").on("click", function() {
        //crea un valor aleatorio entre 1 y 100 y se asigna al input nro
        var aleatorio = Math.round(Math.random() * (100 - 1) + 1);
        $("#nro").val(aleatorio);
        $("#botonAgregar").attr("disabled", "");
        //$("#boxDatos").removeAttr("hidden");
        $("#boxDatos").focus();
        $("#boxDatos").show();
    });
</script>
​<!--_____________________________________________________________-->

<!-- Script Data-Tables-->
<script>
    $("#btnclose").on("click", function() {
    $("#boxDatos").hide(500);
    $("#botonAgregar").removeAttr("disabled");
    $('#formChofer').data('bootstrapValidator').resetForm();
    $("#formChofer")[0].reset();
    $('#selecmov').find('option').remove();
    $('#chofer').find('option').remove();
    });
</script>
​<!--_____________________________________________________________-->

<!-- script que muestra box de datos al dar click en boton agregar -->
<script>
    $("#botonAgregar").on("click", function() {
        //crea un valor aleatorio entre 1 y 100 y se asigna al input nro
        var aleatorio = Math.round(Math.random() * (100 - 1) + 1);
        $("#nro").val(aleatorio);
        $("#botonAgregar").attr("disabled", "");
        //$("#boxDatos").removeAttr("hidden");
        $("#boxDatos").focus();
        $("#boxDatos").show();
    });
</script>
​<!--_____________________________________________________________-->

<!--Script para cargar el listado-->
<script>
    $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Camion/Listar_Chofer");
    function Guardar_Chofer() {

        // datos = $('#formZonas').serialize();

        var datos = new FormData($('#formChoferes')[0]);
        datos = formToObject(datos);
        datos.imagen = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN";
        datos.usuario_app = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario
        console.log(datos);

        //--------------------------------------------------------------

        if ($("#formChoferes").data('bootstrapValidator').isValid()) {
            $.ajax({
                type: "POST",
                data: {datos},
                url: "general/Estructura/Chofer/Guardar_Chofer",
                success: function (r) {
                    console.log(r);
                    if (r == "ok") {
                        // esta porcion de codigo me permite agregar una nueva fila a dataTable asignando al final un id unico a la fila agregada para luego identificarla
                        // var t = $('#tabla_infracciones').DataTable();
                        // var fila = t.row.add([
                        //     N° Acta,
                        //     Tipo de infraccion,
                        //     Inspector,
                        //     Destino,

                        //     //agrega los iconos correspondientes
                        //     '<div class="text-center"><button type="button" title="ok" class="btn btn-primary btn-circle btn-sm"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>&nbsp<button type="button" title="editar" onclick="clickedit('+aux+')" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp<button type="button" title="eliminar" onclick="borrar('+aux+')" id="delete" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp<button type="button" title="buscar" class="btn btn-primary btn-circle info" onclick="clickinfo('+aux+')" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></div>'
                        // ]).node().id = aux; //esta linea de codigo permite agregar un id a la fila recien insertada para identificarla luego
                        // t.draw(false);

                        // aux = aux + 1;//incrementa en 1 la variable auxiliar, la cual indica el id de las filas que se agregan a la tabla
                        // localStorage.setItem('aux', aux);//actualiza la variable local aux para la proxima insercion

                        // $('#FormInfraccion').data('bootstrapValidator').resetForm();
                        // $("#FormInfraccion")[0].reset();
                        // $('#selecmov').find('option').remove();
                        // $('#chofer').find('option').remove();
                        // $("#chofer").html("<option value='' disabled selected>-Seleccione opcion-</option>");
                        // $("#boxDatos").hide(500);
                        // $("#botonAgregar").removeAttr("disabled");
                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Camion/Listar_Chofer");
                        alertify.success("Agregado con exito");

                        $('#formChoferes').data('bootstrapValidator').resetForm();
                        $("#formChoferes")[0].reset();

                        $("#boxDatos").hide(500);
                        $("#botonAgregar").removeAttr("disabled");

                    } else {
                        //console.log(r);
                        alertify.error("error al agregar");
                    }
                }
            });
        }
    }
</script>
<!--_____________________________________________________________-->

<!-- Script Agregar datos de registrar_generadores-->
<script>
    function agregarDato(){
        console.log("entro a agregar datos");
        $('#formChofer').on('submit', function(e){
        e.preventDefault();
        var me = $(this);
        if ( me.data('requestRunning') ) {return;}
        me.data('requestRunning', true);
        datos=$('#formChofer').serialize();
        console.log(datos);

            //--------------------------------------------------------------

        $.ajax({
                    type:"POST",
                    data:datos,
                    url:"ajax/Registrarchofer/guardarDato",
                    success:function(r){
                        if(r == "ok"){
                            //console.log(datos);
                            $('#formChofer')[0].reset();
                            alertify.success("Agregado con exito");
                        }
                        else{
                            console.log(r);
                            $('#formChofer')[0].reset();
                            alertify.error("error al agregar");
                        }
                    },
                    complete: function() {
                        me.data('requestRunning', false);
                    }
                });
        });
    }
</script>
​<!--_____________________________________________________________-->

<!--Script Bootstrap Validacion.-->
<script>
    $('#formChofer').bootstrapValidator({
        message: 'This value is not valid',
        /*feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        //excluded: ':disabled',
        fields: {
            nombre: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            apellido: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            dni: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            fecha_nacimiento: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            direccion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            celular: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            codigo: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            empresa: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            carnet: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            categoria: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            vencimiento: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            habilitacion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            }
        }
    }).on('success.form.bv', function (e) {
        e.preventDefault();
        //guardar();
    });
</script>
<!--_____________________________________________________________-->

<!--Script Bootstrap Validacion.MODAL EDITAR-->
<script>
    $('#formChoferEdit').bootstrapValidator({
        message: 'This value is not valid',
        /*feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        //excluded: ':disabled',
        fields: {
            e_nombre: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            e_apellido: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            e_dni: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            e_fecha_nacimiento: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            e_direccion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            e_celular: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            e_codigo: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            e_empresa: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            carnet: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            e_categoria: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            e_vencimiento: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            e_habilitacion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                        /*stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },*/
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            }
        }
    }).on('success.form.bv', function (e) {
        e.preventDefault();
        //guardar();
    });
</script>
<!--_____________________________________________________________-->

<!-- script Datatables -->
<script>
    DataTable($('#tabla_choferes'))
</script>
<!--_____________________________________________________________-->