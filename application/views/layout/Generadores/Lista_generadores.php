<!--__________________HEADER TABLA__________________-->


<table id="tabla_transportistas" class="table table-bordered table-striped">
    <thead class="thead-dark" bgcolor="#eeeeee">

    <th>Acciones</th>
    <th>Nombre / Razon social</th>
    <th>Departamento</th>
    <th>Registro</th>
    <!-- <th>Tipo</th> -->


    </thead>

    <!--__________________BODY TABLA__________________-->

    <tbody>
    <?php
        if($generadores)
        {
            foreach($generadores as $fila)
            {
            echo '<tr data-json:'.json_encode($fila).'>';
            echo    '<td>';
            echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                    <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
                    <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';                            
            echo   '</td>';
            echo    '<td>'.$fila->razon_social.'</td>';
            echo    '<td>'.$fila->zona_id.'</td>';
            echo    '<td>'.$fila->num_registro.'</td>';                       
            echo '</tr>';
        }
        }
        ?>
    </tbody>
</table>

<!--__________________FIN TABLA__________________-->



<!---//////////////////////////////////////--- MODAL INFORMACION ---///////////////////////////////////////////////////////----->

    
<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion Generador</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL __________________-->

            <form method="GET" autocomplete="off" id="formGeneradoresInfo" class="registerForm">
                <div class="modal-body">

                <!--Nombre/Razon social-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Nombre/Razon social" >Nombre / Razon social:</label>
                            <input type="text" class="form-control" id="I_Nombre/Razon social" name="i_nombre_razon" readonly>
                        </div>
                    </div>                        
                </div>
                <!--_____________________________________________________________-->

                <!--Registro-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="CUIT" name="Cuit">CUIT:</label>
                            <input type="text" class="form-control" id="CUIT" name="Cuit" readonly>
                        </div>
                    </div>
                </div>        
                <!--_____________________________________________________________-->

                <!--Tipo de residuo-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Dpto" name="Departamento">Departamento:</label>
                            <input type="text" class="form-control" id="Dpto" readonly>
                        </div>
                    </div>
                </div>
                <!--_____________________________________________________________-->

                <!--Descripcion-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Domicilio" name="Domicilio">Domicilio:</label>
                            <input type="text" class="form-control" id="Domicilio" readonly>
                        </div>
                    </div>
                </div>
                <!--_____________________________________________________________-->

                <!--Resolucion-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Zonag" name="Zona">Zona:</label>
                            <input type="text" class="form-control" id="zonaG" readonly>
                        </div>
                    </div>
                </div>
                <!--_____________________________________________________________-->

            <div class="row"> 

                        <!--_____________________________________________________________-->
                        <!--Numero de registro-->

                        <div class="col-md-6">
                            <label for="Numero de registro" name="Numero_registro">Numero de registro:</label>
                            <input type="text" class="form-control" id="Numero de registro" readonly>                            
                        </div>

                        <!--_____________________________________________________________-->
                        <!--Rubro-->

                        <div class="col-md-6">
                            <label for="Rubro" name="Rubro">Rubro:</label>
                            <input type="text" class="form-control" id="Rubro" readonly>
                        </div>                

                        <!--_____________________________________________________________-->
                        <!--Tipo-->

                        <div class="col-md-6">
                            <label for="TipoG" name="Tipo">Tipo:</label>
                            <input type="text" class="form-control" id="TipoG" readonly>
                        </div>

                        <!--_____________________________________________________________-->
                        <!--Tipo de residuos-->

                        <div class="col-md-6">
                            <label for="Tipo de residuos" name="Tipo_Residuo">Tipo de residuos:</label>
                            <input type="text" class="form-control" id="Tipo de residuos"readonly >
                        </div>
                    </div>
                    
                    
                </div>
                
            </form>

            <!--__________________ FIN FORMULARIO MODAL __________________-->

            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <!-- <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button> -->
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL INFORMACION ---///////////////////////////////////////////////////////----->




    <!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->

    
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Generador</h5>
            </div>

            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL __________________-->

            <form method="POST" autocomplete="off" id="formGeneradoresEdit" class="registerForm">
                <div class="modal-body">

                <!--_____________________________________________________________-->
                <!--Nombre/Razon social-->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Nombre/Razon social">Nombre / Razon social:</label>
                                <input type="text" class="form-control" id="E_Nombre/Razon social" name="e_nombre_razon">
                            </div>
                        </div>                        
                    </div>

                <!--_____________________________________________________________-->
                <!--Registro-->

                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="CUIT">CUIT:</label>
                                <input type="text" class="form-control" id="E_CUIT" name="e_cuit">
                            </div>
                <!--_____________________________________________________________-->
                <!--Tipo de residuo-->

                            <div class="form-group">
                            <label for="Dpto" >Departamento:</label>
                            <select class="form-control select2 select2-hidden-accesible" name="depa_id" id="Departamento">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                            foreach ($Departamentos as $i) {
                                echo '<option  value="'.$i->depa_id.'">'.$i->nombre.'</option>';

                                
                            }
                            ?>
                            </select>
                            </div>
                         </div>

                <!--_____________________________________________________________-->
                <!--Descripcion-->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Domicilio" >Domicilio:</label>
                                <input type="text" class="form-control" id="E_Domicilio" name="e_omicilio">
                            </div>

                <!--_____________________________________________________________-->
                <!--Resolucion-->

                            <div class="form-group">
                                <label for="Zonag" >Zona:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="E_Zonag" name="e_zonag">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                    foreach ($Zonas as $i) {
                                        echo '<option  value="'.$i->zona_id.'">'.$i->nombre.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                </div>

                <!--_____________________________________________________________-->
                <!--Fecha de Alta-->

                <div class="row">                        
                    <div class="col-md-6">
                        <label for="Numero de registro">Numero de registro:</label>
                        <input type="text" class="form-control" id="E_Numero de registro" name="e_numero_registro">
                    </div>
                    <div class="col-md-6">
                        <label for="Rubro">Rubro:</label>
                        <input type="text" class="form-control" id="E_Rubro" name="e_rubro">
                    </div>
                </div>

                <!--_____________________________________________________________-->
                <!--Fecha de Baja-->


                        <div class="col-md-6">
                            <label for="TipoG" >Tipo:</label>
                            <select class="form-control select2 select2-hidden-accesible" id="E_TipoG"name="e_tipo">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                foreach ($TipoG as $i) {
                                    echo '<option>'.$i->nombre.'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="Tipo de residuos" >Tipo de residuos:</label>
                            <input type="text" class="form-control" id="E_Tipo de residuos" name="e_tipo_Residuo">
                        </div>
                    </div>
                    
                    
                </div>
                
            </form>

            <!--__________________ FIN FORMULARIO MODAL __________________-->

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

<!--_____________________________________________________________-->

<!--Script Bootstrap Validacion.FORMULARIO MODAL EDITAR -->
<script>
    $('#formGeneradoresEdit').bootstrapValidator({
        message: 'This value is not valid',
        /*feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        //excluded: ':disabled',
        fields: {
            e_nombre_razon: {
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
            e_cuit: {
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
            e_zonag: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            e_rubro: {
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
            e_tipo: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            e_omicilio: {
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
            e_departamento: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            e_numero_registro: {
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
            e_tipo_Residuo: {
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
            }
        }
    }).on('success.form.bv', function(e) {
        e.preventDefault();
        //guardar();
    });
</script>

<script>
    DataTable($('#tabla_transportistas'));
    // DataTable($('#tabla_'));
</script>