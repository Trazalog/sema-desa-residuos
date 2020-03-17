<!--__________________HEADER TABLA___________________________-->


<table id="tabla_circuitos" class="table table-bordered table-striped">
    <thead class="thead-dark" bgcolor="#eeeeee">

    <th>Acciones</th>
    <th>N° Acta</th>
    <th>Tipo de infraccion</th>
    <th>Inspector</th>
    <th>Destino de acta</th>


    </thead>

    <!--__________________BODY TABLA___________________________-->

    <tbody>
    <?php
                    if($infracciones)
                    {
                        foreach($infracciones as $fila)
                        {
                        echo '<tr data-json:'.json_encode($fila).'>';
                        echo    '<td>';
                        echo    '
                        <button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                        <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
                        <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';
                            
                        echo   '</td>';
                        echo    '<td>'.$fila->numero_acta.'</td>';
                        echo    '<td>'.$fila->tipo.'</td>';
                        echo    '<td>'.$fila->inspector_id.'</td>';
                        echo    '<td>'.$fila->destino.'</td>';
                        echo '</tr>';
                    }
                    }
                    ?>
    </tbody>
</table>

<!--__________________FIN TABLAa___________________________-->

<!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->

    
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Infraccion</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form class="formInfracciones" id="formInfraccionesEdit">


                <div class="modal-body">

                

                    <div class="row">                        

                            <div class="col-md-6">

                                <!--_____________________________________________-->
                                <!--Numero-->

                                <div class="form-group">
                                    <label for="Nombre">N° :</label>
                                    <input type="text" class="form-control" id="" name="e_numero" readonly>
                                </div>

                                <!--_____________________________________________-->
                                <!--Descripcion-->

                                <div class="form-group">
                                    <label for="Apellido">Descripcion:</label>
                                    <input type="text" class="form-control" id="" name="e_descripcion">
                                </div>

                                <!--_____________________________________________-->
                                <!--Generador-->

                                <div class="form-group">
                                    <label for="TipoInfraccion" >Generador:</label>
                                    <select class="form-control select2 select2-hidden-accesible" id="Generador" name="e_generador">
                                        <option value="" disabled selected>-Seleccione opcion-</option>
                                        
                                    </select>
                                </div>

                                <!--_____________________________________________-->
                                <!--Transportista-->

                                <div class="form-group">
                                    <label for="TipoInfraccion" >Transportista:</label>
                                    <select class="form-control select2 select2-hidden-accesible" id="Transportista" name="e_transportista">
                                        <option value="" disabled selected>-Seleccione opcion-</option>
                                        
                                    </select>
                                </div>


                            </div>

                            <!--**************************************************-->
                    

                            <div class="col-md-6">

                                <!--_____________________________________________-->
                                <!--Tipo de Infraccion-->

                                <div class="form-group">
                                    <label for="TipoInfraccion" >Tipo de Infraccion:</label>
                                    <select class="form-control select2 select2-hidden-accesible" id="TipoInfraccion" name="tipo_infraccion">
                                        <option value="" disabled selected>-Seleccione opcion-</option>
                                        
                                    </select>
                                </div>

                                <!--_____________________________________________-->
                                <!--N° Acta-->                

                                <div class="form-group">
                                    <label for="Direccion">N° Acta:</label>
                                    <input type="text" class="form-control" id="Acta" name="e_acta">
                                </div>

                                <!--_____________________________________________-->
                                <!--Inspector--> 

                                <div class="form-group">
                                    <label for="TipoInfraccion" >Inspector:</label>
                                    <select class="form-control select2 select2-hidden-accesible" id="Inspector"name="e_inspector">
                                        <option value="" disabled selected>-Seleccione opcion-</option>
                                        
                                    </select>
                                </div>

                                <!--_____________________________________________-->
                                <!--Destino de acta--> 

                                <div class="form-group">
                                    <label for="TipoInfraccion">Destino de acta:</label>
                                    <select class="form-control select2 select2-hidden-accesible" id="Destino"  name="e_destino">
                                        <option value="" disabled selected>-Seleccione opcion-</option>
                                        
                                    </select>
                                </div>

                               
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


<!---//////////////////////////////////////--- MODAL INFORMACION ---///////////////////////////////////////////////////////----->

    
<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion Infraccion</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="FormInfraccion" class="registerForm">


                <div class="modal-body">

                

                    <div class="row">                        

                            <div class="col-md-6">

                                <!--_____________________________________________-->
                                <!--Numero-->

                                <div class="form-group">
                                    <label for="Nombre">N° :</label>
                                    <input type="text" class="form-control" id="Numero" name="numero" readonly>
                                </div>

                                <!--_____________________________________________-->
                                <!--Descripcion-->

                                <div class="form-group">
                                    <label for="Apellido">Descripcion:</label>
                                    <input type="text" class="form-control" id="Descripcion" name="descripcion" readonly>
                                </div>

                                <!--_____________________________________________-->
                                <!--Generador-->

                                <div class="form-group">
                                    <label for="TipoInfraccion" name="tipo_infraccion">Generador:</label>
                                    <input type="text" class="form-control" id="Generador" name="generador" readonly>                                   
                                </div>

                                <!--_____________________________________________-->
                                <!--Transportista-->

                                <div class="form-group">
                                    <label for="TipoInfraccion" name="tipo_infraccion">Transportista:</label>
                                    <input type="text" class="form-control" id="Transportista" name="transportista" readonly>                                    
                                </div>


                            </div>

                            <!--**************************************************-->
                    

                            <div class="col-md-6">

                                <!--_____________________________________________-->
                                <!--Tipo de Infraccion-->

                                <div class="form-group">
                                    <label for="TipoInfraccion" name="tipo_infraccion">Tipo de Infraccion:</label>
                                    <input type="text" class="form-control" id="TipoInfraccion" name="tipoInfraccion" readonly>                                    
                                </div>

                                <!--_____________________________________________-->
                                <!--N° Acta-->                

                                <div class="form-group">
                                    <label for="Direccion">N° Acta:</label>
                                    <input type="text" class="form-control" id="Acta" name="acta" readonly>
                                </div>

                                <!--_____________________________________________-->
                                <!--Inspector--> 

                                <div class="form-group">
                                    <label for="TipoInfraccion" name="tipo_infraccion">Inspector:</label>
                                    <input type="text" class="form-control" id="Inspector" name="inspector" readonly>
                                </div>

                                <!--_____________________________________________-->
                                <!--Destino de acta--> 

                                <div class="form-group">
                                    <label for="TipoInfraccion" name="tipo_infraccion">Destino de acta:</label>
                                    <input type="text" class="form-control" id="Destinoacta" name="destinoacta" readonly>
                                </div>

                               
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


<!---//////////////////////////////////////--- FIN MODAL INFORMACION ---///////////////////////////////////////////////////////----->





<!--_____________________________________________________________-->
<!--Script Bootstrap Validacion MODAL EDITAR.-->

<script>
      $('#formInfraccionesEdit').bootstrapValidator({
      message: 'This value is not valid',
      /*feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },*/
      fields: {
            e_numero: {
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
            e_descripcion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            e_generador: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            e_transportista: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            e_tipo_infraccion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            e_acta: {
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
            e_inspector: {
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
            e_destino: {
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
        }
  }).on('success.form.bv', function(e){
      e.preventDefault();
      //guardar();
  });
</script>
