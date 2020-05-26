<!--__________________HEADER TABLA___________________________-->
<div class="row">

  <div class="col-md-12"> <br></div>
  <div class="col-md-12">
    <table id="tabla_transportistas" class="table table-bordered table-striped">
      <thead class="thead-dark" bgcolor="#eeeeee">
        <th>Acciones</th>
        <th>Contenedor</th>
        <th>Tipo residuo</th>
        <th>Cantidad</th>
        <th>Generador</th>
        <th>Estado</th>
      </thead>
      <tbody>
        <tr>
          <td>
            <button type="button" title="Entregar" class="btn btn-primary btn-circle"><span
                class="glyphicon glyphicon-share" aria-hidden="true"></span></button>&nbsp
          </td>
          <td>DATO</td>
          <td>DATO</td>
          <td>DATO</td>
          <td>DATO</td>
          <td>DATO</td>
        </tr>
        <tr>
          <td>
            <button type="button" title="Entregar" class="btn btn-primary btn-circle"><span
                class="glyphicon glyphicon-share" aria-hidden="true"></span></button>&nbsp
          </td>
          <td>DATO</td>
          <td>DATO</td>
          <td>DATO</td>
          <td>DATO</td>
          <td>DATO</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!--__________________FIN TABLA___________________________-->




<!--MODAL EDITAR -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Editar Solicitud Contenedor</h5>
			</div>
			
      <div class="modal-body">
        <!--__________________ FORMULARIO MODAL ___________________________-->
        <form method="POST" autocomplete="off" id="formGeneradoresEdit" class="registerForm">
          <div class="modal-body">            
            <!--Nombre/Razon social-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="Nombre/Razon social">N° Solicitud:</label>
                  <input type="text" class="form-control" id="E_" name="e_" readonly>
                </div>
              </div>
            </div>
						<!--_____________________________________________-->
						
            <!--Registro-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="CUIT">Label:</label>
                  <input type="text" class="form-control" id="E_" name="e_">
                </div>
								<!--_____________________________________________-->
								
                <!--Tipo de residuo-->
                <div class="form-group">
                  <label for="Dpto">Label:</label>
                  <select class="form-control select2 select2-hidden-accesible" id="E_" name="e_">
                    <option value="" disabled selected>-Seleccione opcion-</option>
                    <?php
                                // foreach ($Dpto as $i) {
                                //     echo '<option>'.$i->nombre.'</option>';
                                // }
                                ?>
                  </select>
                </div>
              </div>
							<!--_____________________________________________-->
							
              <!--Descripcion-->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="Domicilio">Label:</label>
                  <input type="text" class="form-control" id="E_" name="e_">
                </div>
								<!--_____________________________________________-->
								
                <!--Resolucion-->
                <div class="form-group">
                  <label for="Zonag">Label:</label>
                  <select class="form-control select2 select2-hidden-accesible" id="E_" name="e_">
                    <option value="" disabled selected>-Seleccione opcion-</option>
                    <?php
                                    // foreach ($Zonag as $i) {
                                    //     echo '<option>'.$i->nombre.'</option>';
                                    // }
                                    ?>
                  </select>
                </div>
              </div>
            </div>
						<!--_____________________________________________-->
						
            <!--Fecha de Alta-->
            <div class="row">
              <div class="col-md-6">
                <label for="Numero de registro">Label:</label>
                <input type="text" class="form-control" id="E_" name="e_">
              </div>

              <div class="col-md-6">
                <label for="Rubro">Label:</label>
                <input type="text" class="form-control" id="E_" name="e_">
              </div>
							<!--_____________________________________________-->
							
              <!--Fecha de Baja-->
              <div class="col-md-6">
                <label for="TipoG">Label:</label>
                <select class="form-control select2 select2-hidden-accesible" id="E_" name="e_">
                  <option value="" disabled selected>-Seleccione opcion-</option>
                  <?php
                                // foreach ($TipoG as $i) {
                                //     echo '<option>'.$i->nombre.'</option>';
                                // }
                                ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="Tipo de residuos">Label:</label>
                <input type="text" class="form-control" id="E_" name="e_">
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
<!--FIN MODAL EDITAR-->


<!--MODAL CONTENEDORES -->

<div class="modal fade" id="modalContenedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Informacion Contenedores</h5>
      </div>
      <div class="modal-body">
        <!--__________________ FORMULARIO MODAL ___________________________-->
        <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">
          <div class="modal-body">           
            <!--Codigo-->
            <div class="row">
              <div class="col-md-6">   
                <div class="form-group">
                  <label for="Codigo" name="Codigo">N°:</label>
                  <input type="text" class="form-control" id="numero" name="Numero" readonly>
                </div>
              </div>

              <!--_____________________________________________-->
              <!--Vehiculo-->

              <div class="col-md-6">
                <div class="form-group">
                  <label for="Vehiculo" name="Vehiculo">Fecha:</label>
                  <input type="text" class="form-control" id="fecha" name="Fecha" readonly>
                </div>
              </div>
            </div>





            <!--_____________________________________________-->
            <!--Descripcion-->



            <!--_______________________SEPARADOR______________________-->

            <div class="col-md-12"><br><br></div>

            <!--_______________________SEPARADOR______________________-->

            <div class="row">

              <div class="col-md-12">

                <div class="box-header bg-blue">
                  <h5>Estado Contenedores</h5>
                </div>

              </div>

            </div>

            <!--_______________________SEPARADOR______________________-->

            <div class="col-md-12"><br></div>

            <!--_______________________SEPARADOR______________________-->


            <!--*******************************************-->

            <div class="row">

              <div class="col-md-12">



                <div class="col-md-12"><br>
                  <hr><br></div>

                <div class="row">
                  <div class="col-md-12">



                    <table id="tabla_contenedores" class="table table-bordered table-striped">
                      <thead class="thead-dark" bgcolor="#eeeeee">


                        <th>Tipo resido</th>
                        <th>Contenedor</th>
                        <th>Transportista</th>
                        <th>Estado</th>



                      </thead>



                      <tbody>
                        <tr>

                          <td>DATO</td>
                          <td>DATO</td>
                          <td>DATO</td>
                          <td>DATO</td>


                        </tr>
                        <tr>

                          <td>DATO</td>
                          <td>DATO</td>
                          <td>DATO</td>
                          <td>DATO</td>


                        </tr>


                      </tbody>
                    </table>


                  </div>
                </div>

              </div>

            </div>


          </div>

        </form>

        <!--__________________ FIN FORMULARIO MODAL ___________________________-->

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
<!--FIN MODAL CONTENEDORES-->







<script>
DataTable($('#tabla_transportistas'))
</script>