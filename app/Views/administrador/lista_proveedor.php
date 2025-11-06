
        <div class="text p-2">
            <h4 class="text-end me-5">
                <a href="<?php echo base_url('add_proveedor');?>" class="botones btn btn-light custom-link m-auto d-inline-block me-1 p-2">Registrar Proveedor</a>
            </h4>
        </div>

        <h1 class="display-3 text-center text-white m-2 pt-2 pb-2">Lista de Proveedores</h1>

    </main>

    <div class="container">
        <div class="table-responsive">
            <table id="mytable" class="table table-bordered table-striped table-hover custom-table formulario">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($proveedores) && is_array($proveedores)) { ?>
                        <?php foreach($proveedores as $row) { ?>
                            <tr class="custom-row">
                                <td><?php echo $row['nombre_proveedor']; ?></td>
                                <td><?php echo $row['correo_proveedor']; ?></td>
                                <td><?php echo $row['telefono_proveedor']; ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr class="custom-empty-row">
                            <td colspan="8" class="text-center">No hay proveedores registrados.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <br>
    </div>