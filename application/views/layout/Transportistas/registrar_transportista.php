<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Transportista</h4>
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
    <!--_____________________________________________-->

    <div class="box-body">
        <form class="formTransportistas" id="formTransportistas">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <!--_____________________________________________-->

                <!--Nombre / Razon social-->
                <div class="form-group">
                    <label for="Nombre/Razon social" >Nombre / Razon social:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="text" class="form-control" name="Nombre_razon" id="Nombre/Razon social">
                    </div>                    
                </div>
                <!--_____________________________________________-->

                <!--Descripcion-->
                <div class="form-group">
                    <label for="Descripcion" >Descripcion:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="text" class="form-control"  name="Descripcion" id="Descripcion">
                    </div>
                </div>
                <!--_____________________________________________-->

                <!--Direccion-->
                <div class="form-group">
                    <label for="Direccion">Direccion:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="text" class="form-control"   name="Direccion" id="Direccion">
                    </div>
                </div>
                <!--_____________________________________________-->

                <!--Telefono-->
                <div class="form-group">
                    <label for="Telefono" >Telefono:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="text" class="form-control"  name="Telefono" id="Telefono">
                    </div>
                </div>
                <!--_____________________________________________-->

                <!--Contacto-->
                <div class="form-group">
                    <label for="Contacto" >Contacto:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="text" class="form-control" name="Contacto" id="Contacto">
                    </div>
                </div>
                <!--_____________________________________________-->

            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">

                <!--Resolucion-->
                <div class="form-group">
                    <label for="Resolucion" >Resolucion:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="text" class="form-control"  name="Resolucion" id="Resolucion">
                    </div>
                </div>
                <!--_____________________________________________-->

                <!--Registro-->
                <div class="form-group">
                    <label for="Registro" >Registro:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="text" class="form-control" name="Registro" id="Registro">
                    </div>
                </div>
                <!--_____________________________________________-->

                <!--Fecha de alta-->
                <div class="form-group">
                    <label for="Fechalta"class="form-label label-sm">Fecha de alta:</label>                                              
                    <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right"  name="Fecha_de_alta"  id="fecha-alta">
                    </div>  
                </div>
                <!--_____________________________________________-->

                <!--Fecha de baja-->
                <div class="form-group">
                    <label for="Fechabaja" >Fecha de baja:</label>
                    <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" name="Fecha_de_baja" id="fecha-baja">
                    </div>
                </div>
                <!--_____________________________________________-->

                <!--Tipo de RSU autorizado-->
                <div class="form-group">
                    <label for="Rsu" >Tipo de RSU autorizado:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <select class="form-control select2 select2-hidden-accesible" name="Rsu" id="Rsu">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($tiporesiduo as $i) {
                            echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                        }
                        ?>
                        </select>
                        </div>
                    </div>
                </div>
                <!--_____________________________________________-->

            <div class="col-md-12 col-sm-12 col-xs-12"><hr></div>

            <!--__________________________BOTON GUARDAR__________________________-->
            <br>
            <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
            <br>
            <!--_____________________________________________-->

            </form>
        </div>
    </div>
</div>

<!---//////////////////////////////////////--- FIN BOX 1 ---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////---BOX 2---///////////////////////////////////////////////////////----->

<div class="box box-primary">

<!--___________________________TABLA___________________________-->
    <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
            <div class="row">
                <div class="col-sm-12 table-scroll">

                <!--___________________________HEADER TABLA___________________________-->
                    <table id="tabla_transportistas" class="table table-bordered table-striped">
                        <thead class="thead-dark" bgcolor="#eeeeee">
                            <th>Acciones</th>
                            <th>Nombre / Razon social</th>
                            <th>Zona</th>
                            <th>Departamento</th>
                            <th>Tipo</th>
                        </thead>
                    <!--___________________________FIN HEADER TABLA___________________________-->

                    <!--___________________________BODY TABLA___________________________-->
                        <tbody>
                        <tr>
                            <td>
                            <button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                            <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
                            <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                            </td>
                            <td>DATO2</td>
                            <td>DATO</td>
                            <td>DATO</td>
                            <td>DATO</td>
                        </tr>
                        </tbody>
                    </table>
                <!--___________________________FIN TABLA___________________________-->

                </div>
            </div>
        </div>
    </div>

<!---//////////////////////////////////////--- FIN BOX 2---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Transportista</h5>
            </div>
            <div class="modal-body">

        <!--___________________________FORMULARIO MODAL___________________________-->
            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-6">

                        <!--Nombre/Razon social-->
                            <div class="form-group">
                                <label for="Nombre/Razon social" name="Nombre_razon">Nombre / Razon social:</label>
                                <input type="text" class="form-control" id="Nombre/Razon social">
                            </div>
                        <!--_____________________________________________-->

                    </div>
                    <div class="col-md-6">

                        <!--Registro-->
                            <div class="form-group">
                                <label for="Registro" name="Registro">Registro:</label>
                                <input type="text" class="form-control" id="Registro">
                            </div>
                        <!--_____________________________________________-->

                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">

                        <!--Direccion-->
                            <div class="form-group">
                                <label for="Direccion" name="Direccion">Direccion:</label>
                                <input type="text" class="form-control" id="Direccion">
                            </div>
                        <!--_____________________________________________-->

                        <!--Telefono-->
                            <div class="form-group">
                                <label for="Telefono" name="Telefono">Telefono:</label>
                                <input type="text" class="form-control" id="Telefono">
                            </div>
                        <!--_____________________________________________-->

                    </div>
                    <div class="col-md-6">

                        <!--Zona-->
                            <div class="form-group">
                            <label for="Zonas" name="Zonas">Zona:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="Zonas">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($Zonas as $i) {
                                        echo '<option  value="'.$i->depa_nom.'">'.$i->nombre.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        <!--_____________________________________________-->

                        <!--Fecha de alta-->
                            <div class="form-group">
                                <label for="Fechalta" name="Fecha_de_alta" class="form-label label-sm">Fecha de alta:</label>                                              
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control pull-right" id="fecha-alta">
                                    </div>
                                </div>
                            </div>
                        <!--_____________________________________________-->

                    </div>
                    <div class="row">
                    <div class="col-md-6">

                        <!--Descripcion-->
                            <div class="form-group">
                                <label for="Descripcion" name="Descripcion">Descripcion:</label>
                                <input type="text" class="form-control" id="Descripcion">                                                               
                            </div>
                        <!--_____________________________________________-->

                        <!--Contacto-->
                            <div class="form-group">
                                <label for="Contacto" name="Contacto">Contacto:</label>
                                <input type="text" class="form-control" id="Contacto">
                            </div>
                        <!--_____________________________________________-->

                    </div>
                    <div class="col-md-6">

                        <!--Fecha baja-->
                            <div class="form-group">
                                <label for="Fechabaja" name="Fecha_de_baja">Fecha de baja:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control pull-right" id="fecha-baja">
                                </div>
                            </div>
                        <!--_____________________________________________-->

                        <!--Tipo RSU autorizado-->
                            <div class="form-group">
                                <label for="Rsu" name="Rsu">Tipo de RSU autorizado:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="Rsu">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($tiporesiduo as $i) {
                                        echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                    }
                                    ?>
                                    </select>
                            </div>
                        <!--_____________________________________________-->

                        </div>
                    </div>
                </div>
            </form>

            <!--___________________________FIN FORMULARIO MODAL___________________________-->

            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Informacion Transportista</h5>
            </div>

            <div class="modal-body">

        <!--___________________________FORMULARIO MODAL___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">

                        <!--_____________________________________________-->

                        <!--Nombre/Razon social-->
                            <div class="form-group">
                                <label for="Nombre/Razon social" name="Nombre_razon">Nombre / Razon social:</label>
                                <input type="text" class="form-control pull-right" id="" readonly>
                            </div>
                        <!--_____________________________________________-->

                    </div>
                    <div class="col-md-6">

                        <!--Registro-->
                            <div class="form-group">
                                <label for="Registro" name="Registro">Registro:</label>
                                <input type="text" class="form-control pull-right" id="" readonly>
                            </div>
                            </div>                         
                            </div>
                        <!--_____________________________________________-->

                    <div class="row">
                    <div class="col-md-6">

                        <!--Direccion-->
                            <div class="form-group">
                                <label for="Direccion" name="Direccion">Direccion:</label>
                                <input type="text" class="form-control pull-right" id="" readonly>
                            </div>
                        <!--_____________________________________________-->

                        <!--Telefono-->
                            <div class="form-group">
                                <label for="Telefono" name="Telefono">Telefono:</label>
                                <input type="text" class="form-control pull-right" id="" readonly>
                            </div>
                        <!--_____________________________________________-->

                    </div>
                    <div class="col-md-6">

                        <!--Zona-->
                            <div class="form-group">
                                <label for="Zonag" name="Zona">Zona:</label>
                                <input type="text" class="form-control pull-right" id="" readonly>
                            </div>
                        <!--_____________________________________________-->

                        <!--Fecha de alta-->
                            <div class="form-group">
                                <label for="Fechalta" name="Fecha_de_alta" class="form-label label-sm">Fecha de alta:</label>                                              
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="" readonly>
                                </div>
                            </div>
                            </div>
                            </div>
                        <!--_____________________________________________-->

                    <div class="row">
                    <div class="col-md-6">

                        <!--Descripcion-->
                            <div class="form-group">
                                <label for="Descripcion" name="Descripcion">Descripcion:</label>
                                <input type="text" class="form-control pull-right" id="" readonly>                                                              
                            </div>
                        <!--_____________________________________________-->

                        <!--Contacto-->
                            <div class="form-group">
                                <label for="Contacto" name="Contacto">Contacto:</label>
                                <input type="text" class="form-control pull-right" id="" readonly>                                
                            </div>
                        <!--_____________________________________________-->

                    </div>
                    <div class="col-md-6">

                        <!--Fecha baja-->
                            <div class="form-group">
                                <label for="Fechabaja" name="Fecha_de_baja">Fecha de baja:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="" readonly>
                                </div>
                            </div>
                        <!--_____________________________________________-->

                <!--Tipo RSU autorizado-->
                <div class="form-group">
                    <label for="Rsu">Tipo RSU autorizado:</label>
                    <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                        <select class="form-control select2 select2-hidden-accesible" name="Rsu" id="Rsu">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                foreach ($tiporesiduo as $i) {
                                    echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                }
                                ?>
                        </select>
                    </div>
                </div>
                <!--____________________________________________________________________-->

                        <!--Tipo RSU autorizado-->
                           <!-- <div class="form-group">
                                <label for="Rsu" name="Rsu">Tipo de RSU autorizado:</label>
                                <input type="text" class="form-control pull-right" id="" readonly>
                            </div>
                            </div>
                            </div>
                            </div>
                            </form>-->
                        <!--_____________________________________________-->

            <!--___________________________FIN FORMULARIO MODAL___________________________-->

            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <!--<button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>-->
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!---//////////////////////////////////////--- FIN MODAL INFORMACION ---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- SCRIPTS---///////////////////////////////////////////////////////----->

<!--_____________________________________________________________-->

<!-- script modal -->

<script>
    $("#btnview").on("click", function() {
        $("#btnadd").removeClass("active");
        $("#btnview").addClass("active");
        $("#tablamodal").show();
        $("#formadd").hide();
        $("#btnsave").hide();
    });
    $("#btnadd").on("click", function() {
        $("#btnadd").addClass("active");
        $("#btnview").removeClass("active");
        $("#formadd").show();
        $("#tablamodal").hide();
        $("#btnsave").show();
    });
</script>
<!--_____________________________________________________________-->

<!--Script de guardado de datos y listado en Datatable-->
<script>
    $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Transportistas/Listar_Transportista");
    function Guardar_Transportista() {
        // datos = $('#formTransportistas').serialize();
        var datos = new FormData($('#formTransportistas')[0]);
        datos = formToObject(datos);
        datos.imagen = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN";
        datos.usuario_app = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario
        console.log(datos);

        //--------------------------------------------------------------

        if ($("#formTransportistas").data('bootstrapValidator').isValid()) {
            $.ajax({
                type: "POST",
                data: {datos},
                url: "general/Estructura/Transportista/Guardar_Transportista",
                success: function (r) {
                    console.log(r);
                    if (r == "ok") {
                        // //esta porcion de codigo me permite agregar una nueva fila a dataTable asignando al final un id unico a la fila agregada para luego identificarla
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
                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Transportistas/Listar_Transportista");
                        alertify.success("Agregado con exito");
                    } else {
                        //console.log(r);
                        alertify.error("error al agregar");
                    }
                }
            });
        }
    }
</script>
<!--__________________________________________________________________________________________-->

<!-- Script Agregar datos de registrar_transportista-->
<script>
    function agregarDato() {
        console.log("entro a agregar datos");
        $('#formTransportistas').on('submit', function(e) {
            e.preventDefault();
            var me = $(this);
            if (me.data('requestRunning')) {
                return;
            }
            me.data('requestRunning', true);
            datos = $('#formTransportistas').serialize();
            console.log(datos);

            //--------------------------------------------------------------

            $.ajax({
                type: "POST",
                data: datos,
                url: "ajax/Registrartransportista/guardarDato",
                success: function(r) {
                    if (r == "ok") {
                        console.log(datos);
                        $('#formTransportistas')[0].reset();
                        alertify.success("Agregado con exito");
                    } else {
                        console.log(r);
                        $('#formTransportistas')[0].reset();
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
<!--_____________________________________________________________-->

<script>
    $("#btnclose").on("click", function() {
        $("#boxDatos").hide(500);
        $("#botonAgregar").removeAttr("disabled");
        $('#formDatos').data('bootstrapValidator').resetForm();
        $("#formDatos")[0].reset();
        $('#selecmov').find('option').remove();
        $('#chofer').find('option').remove();
    });
</script>
<!--_____________________________________________________________-->

<!-- script Datatables -->
<script>
    DataTable($('#tabla_transportistas'))
</script>
<!--_____________________________________________________________-->

<!--Script Bootstrap Validacion.-->
<script>
    $('#formTransportistas').bootstrapValidator({
        message: 'This value is not valid',
        /*feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        //excluded: ':disabled',
        fields: {
            Nombre_razon: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            Descripcion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            Direccion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            Telefono: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            Contacto: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            Domicilio: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            Resolucion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            Registro: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            Fecha_de_alta: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            Fecha_de_baja: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            Rsu: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            }
        }
    }).on('success.form.bv', function(e) {
        e.preventDefault();
        //guardar();
    });
</script>
<!--_____________________________________________________________-->

<script>
    //este script me permite limpiar la validacion una vez cerrado el modal
    $("#modalEdit").on("hidden.bs.modal", function (e) {
        $("#formEditDatos").data('bootstrapValidator').resetForm();
    });
</script>