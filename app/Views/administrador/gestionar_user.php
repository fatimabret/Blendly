
        <h1 class="display-3 text-center text-white m-2 pt-2 pb-2">Gestionar Lista de Usuarios</h1>

    </main>

    <div class="container">
        
        <!--  Condicion para visualizar los errores de validacion  -->
        <?php if (session('mensaje')): ?>
            <div class="alert alert-light" role="alert">
                <?= session('mensaje') ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table id="mytable" class="table table-bordered table-striped table-hover custom-table formulario">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Edad</th>
                        <th>Correo</th>
                        <th>Estado</th>
                </thead>

                <tbody>
                    <?php if (!empty($clientes) && is_array($clientes)) { ?>
                        <?php foreach($clientes as $row) { ?>
                            <tr class="custom-row">
                                <td><?php echo $row['nombre_usuario']; ?></td>
                                <td><?php echo $row['apellido_usuario']; ?></td>
                                <td><?php echo $row['edad_usuario']; ?></td>
                                <td><?php echo $row['correo_usuario']; ?></td>
                                <td>
                                    <?php if ($row['id_estado'] == 1): ?>
                                        <a class="btn btn-success" href="<?php echo base_url('id_estado/'.$row['id_usuario'].'/0'); ?>">Alta</a>
                                    <?php else: ?>
                                        <a class="btn btn-danger" href="<?php echo base_url('id_estado/'.$row['id_usuario'].'/1'); ?>">Baja</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr class="custom-empty-row">
                            <td colspan="8" class="text-center">No hay usuarios registrados!</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <br>
    </div>

