        <!-- Enlace para crear categoria y productos -->
        <div class="text p-2">

            <h4 class="text-end me-5">
                <a href="<?php echo base_url('add_proveedor');?>" class="botones btn btn-dark text-white custom-link m-auto d-inline-block me-3 p-2">Proveedor</a>
                <a href="<?php echo base_url('add_categoria');?>" class="botones btn btn-light custom-link m-auto d-inline-block me-3 p-2">Categoria</a>
                <a href="<?php echo base_url('add_producto');?>" class="botones btn d-inline-block formulario me-3 p-2">Registrar Producto</a></h4>
        </div>

        <h1 class="display-3 text-center text-segundos m-2 pt-2 pb-2">Gestionar Lista de Productos</h1>

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
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Proveedor</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Stock</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Modificar</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($productos) && is_array($productos)) { ?>
                        <?php foreach($productos as $row) { ?>
                            <tr class="custom-row">
                                <td><?php echo $row['id_producto']; ?></td>
                                <td><?php echo $row['nombre_producto']; ?></td>
                                <td><?php echo $row['nombre_proveedor']; ?></td>
                                <td><?php echo $row['descripcion_producto']; ?></td>
                                <td>$<?php echo $row['precio_producto']; ?></td>
                                <td><img src="<?php echo base_url('assets/img/producto/' . $row['imagen_producto']); ?>" alt="Imagen del Producto" class="custom-image" /></td>
                                <td><?php echo $row['stock_producto']; ?></td>
                                <td><?php echo $row['nombre_categoria']; ?></td>
                                <td>
                                    <?php if ($row['id_estado'] == 1) { ?>
                                        <a class="btn btn-danger" href="<?php echo base_url('estado_producto/'.$row['id_producto'].'/0'); ?>">Eliminar</a>
                                    <?php } else { ?>
                                        <a class="btn btn-success" href="<?php echo base_url('estado_producto/'.$row['id_producto'].'/1'); ?>">Activar</a>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a class="btn btn-outline-dark" href="<?php echo base_url('editar/'.$row['id_producto']); ?>">Editar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr class="custom-empty-row">
                            <td colspan="8" class="text-center">No hay productos registrados.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <br>
    </div>

