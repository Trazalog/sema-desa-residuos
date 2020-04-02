<!--__________________HEADER TABLA___________________________-->


<table id="tabla_transportistas" class="table table-bordered table-striped">
    <thead class="thead-dark" bgcolor="#eeeeee">

    <th>Acciones</th>
    <th>Nombre / Razon social</th>
    <th>Departamento</th>
    <th>Registro</th>
    <!-- <th>Tipo</th> -->


    </thead>

    <!--__________________BODY TABLA___________________________-->

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

<!--__________________FIN TABLAa___________________________-->



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

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form  id="formGeneradoresInfo" class="registerForm">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <!--________Razon social__________-->
                                <div class="form-group">
                                    <label for="CUIT" name="Cuit">Nombre / Razon social:</label>
                                    <input type="text" class="form-control" id="" name="" readonly>
                                </div> 
                                <!--________CUIT__________-->
                                <div class="form-group">
                                    <label for="Dpto" name="Departamento">CUIT:</label>
                                    <input type="text" class="form-control" id="" readonly>
                                </div>
                                <!--________Zona__________-->
                                <div class="form-group">
                                    <label for="Domicilio" name="Domicilio">Zona:</label>
                                    <input type="text" class="form-control" id="" readonly>
                                </div>
                                <!--________Rubro__________-->
                                <div class="form-group">
                                    <label for="Zonag" name="Zona">Rubro:</label>
                                    <input type="text" class="form-control" id="" readonly>
                                </div>

                            </div>                 
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <!--________Tipo residuo__________-->
                                <div class="form-group">
                                    <label for="CUIT" name="Cuit">Tipo:</label>
                                    <input type="text" class="form-control" id="" name="" readonly>
                                </div> 
                                <!--________Domicilio__________-->
                                <div class="form-group">
                                    <label for="Dpto" name="Departamento">Domicilio:</label>
                                    <input type="text" class="form-control" id="" readonly>
                                </div>
                                <!--________Departamento__________-->
                                <div class="form-group">
                                    <label for="Domicilio" name="Domicilio">Departamento:</label>
                                    <input type="text" class="form-control" id="" readonly>
                                </div>
                                <!--________Numero Registro__________-->
                                <div class="form-group">
                                    <label for="Zonag" name="Zona">Numero de registro:</label>
                                    <input type="text" class="form-control" id="" readonly>
                                </div>

                            </div>
                        </div>
                    
                
            </form>

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            <div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
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

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="formGeneradoresEdit" class="registerForm">


                <div class="modal-body">

                <!--_____________________________________________-->
                <!--Nombre/Razon social-->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Nombre/Razon social">Nombre / Razon social:</label>
                                <input type="text" class="form-control" id="E_Nombre/Razon social" name="e_nombre_razon">
                            </div>
                        </div>                        
                    </div>

                <!--_____________________________________________-->
                <!--Registro-->

                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="CUIT">CUIT:</label>
                                <input type="text" class="form-control" id="E_CUIT" name="e_cuit">
                            </div>
                <!--_____________________________________________-->
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

                <!--_____________________________________________-->
                <!--Descripcion-->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Domicilio" >Domicilio:</label>
                                <input type="text" class="form-control" id="E_Domicilio" name="e_omicilio">
                            </div>

                <!--_____________________________________________-->
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

                <!--_____________________________________________-->
                <!--Fecha de Alta-->

                <div class="row">                        
                    <div class="col-md-6">
                        <label for="Numero de registro" >Numero de registro:</label>
                        <input type="text" class="form-control" id="E_Numero de registro" name="e_numero_registro">
                            
                        </div>

                        <div class="col-md-6">
                            <label for="Rubro" >Rubro:</label>
                            <input type="text" class="form-control" id="E_Rubro" name="e_rubro">
                        </div>

                <!--_____________________________________________-->
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

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

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
           