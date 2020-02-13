                    
                    <!--__________________HEADER TABLA___________________________-->
                    <div class="row">

                    <div class="col-md-12"> <br></div>                       
                                <div class="col-md-12">

                                     

                                    <table id="tabla_pedidos" class="table table-bordered table-striped">
                                        <thead class="thead-dark" bgcolor="#eeeeee">

                                            <th>Acciones</th>
                                            <th>N° Solicitud</th>                                         
                                            <th>Cantidad pedida</th>
                                            <th>Cantidad entregada</th>
                                            <th>Stock</th>
                                            <th>Cantidad a entregar</th>                                        
                                            <th>Estado solicitud</th>
                                            
                                            

                                        </thead>

                                        

                                        <tbody>
                                        <tr>
                                            
                                            <td>
                                            <button type="button" title="Aprobar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalContenedor"><span class="glyphicon glyphicon-share" aria-hidden="true"></span></button>&nbsp
                                            <button type="button" title="Rechazar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalContenedor"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>&nbsp
                                            </td>                                            
                                            <td>DATO</td>
                                            <td>DATO</td>
                                            <td>DATO</td>
                                            <td>DATO</td>
                                            <td>DATO</td>
                                            <td>DATO</td>
                                            

                                        </tr>
                                        <tr>
                                            
                                            <td>
                                            <button type="button" title="Aprobar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-share" aria-hidden="true"></span></button>&nbsp
                                            <button type="button" title="Rechazar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalContenedor"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>&nbsp
                                            </td>
                                            <td>DATO</td>
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


                    



                    
<script>

DataTable($('#tabla_pedidos'))


</script>
           