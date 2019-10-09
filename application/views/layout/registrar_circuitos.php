<div class="box box-primary">
    <div class="box-header">
        <div class="box-tittle">
            <h3>Registrar Circuitos</h3>  
        </div>
    </div>
    <!--_____________________________________________-->
    <div class="box-body">
    <form class="formZonas" id="formZonas">
    <div class="col-md-6">
            <!--Codigo-->
                <div class="form-group">
                    <label for="Codigo" name="Codigo">Codigo:</label>
                    <input type="text" class="form-control" id="Codigo">
                </div>
            <!--_____________________________________________-->
    </div>        
    <div class="col-md-6">
            <!--Chofer-->
                <div class="form-group">
                    <label for="Chofer" name="Chofer">Chofer:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Chofer">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Chofer as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
            <!--_____________________________________________-->
    </div>
    <div class="col-md-12">
            <!--Descripcion-->
                <div class="form-group">
                    <label for="Descripcion" name="Descripcion">Descripcion:</label>
                    <input type="text" class="form-control" id="Descripcion">
                </div>
            <!--_____________________________________________-->
    </div>
    <div class="col-md-6">
            <!--Vehiculo-->
                <div class="form-group">
                    <label for="Vehiculo" name="Vehiculo">Vehiculo:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Vehiculo">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Vehiculo as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
            <!--_____________________________________________-->
    </div>
    <div class="col-md-6">
            <!--Tipo de residuo-->
                <div class="form-group">
                    <label for="Tiporesiduo" name="Tipo_residuo">Tipo de residuo:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Tiporesiduo">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Tiporesiduo as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
            <!--_____________________________________________-->
    </div>
    <div class="col-md-6">
            <!--Adjuntador de imagenes-->
                <br>
                <form action="cargar_archivo" method="post" enctype="multipart/form-data">
                    <input  type="file" name="upload">
                </form>
            <!--_____________________________________________-->
    </div>

    </div>
    </form>
</div>
<div class="box box-primary">
    <div class="box-header">
        <div class="box-tittle">
            <h3>Registrar Punto Critico</h3>  
        </div>
    </div>
    <!--_____________________________________________-->
<div class="box-body">
<form class="formZonas" id="formZonas">
    <div class="col-md-6">
            <!--Nombre-->
                <div class="form-group">
                    <label for="Nombre" name="Nombre">Nombre:</label>
                    <input type="text" class="form-control" id="Nombre">
                </div>
            <!--_____________________________________________-->
    </div>
    <div class="col-md-6">
            <!--Descripcion-->
                <div class="form-group">
                    <label for="Descripcion" name="Descripcion">Descripcion:</label>
                    <input type="text" class="form-control" id="Descripcion">
                </div>
            <!--_____________________________________________-->
    </div>
        </div>
    </form>
</div>