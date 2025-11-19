        <!-- Enlace para crear categoria y productos -->
        <div class="text p-2 text-end m-2">
                <a href="<?php echo base_url('add_proveedor');?>" class="botones btn btn-dark text-white custom-link m-auto d-inline-block m-3 p-2">Proveedor</a>
                <a href="<?php echo base_url('add_categoria');?>" class="botones btn btn-light custom-link m-auto d-inline-block m-3 p-2">Categoria</a>
                <a href="<?php echo base_url('add_producto');?>" class="botones btn d-inline-block formulario m-3 p-2">Registrar Producto</a> 
        </div>

        <h1 class="display-3 text-center text-segundos m-2 pt-2 pb-2">Gestionar Lista de Productos</h1>

    </main>

    <div class="container">
        <nav class="navba1r">
            <div class="container-fluid mt-3 mb-3">

                <form class="row g-3 mb-4 justify-content-center"
                    action="<?= base_url('buscar_gestion') ?>" method="get"
                    style="max-width: 900px; margin: auto;">

                    <div class="col-md-3">
                        <input type="number" step="0.01" name="precio_min" class="form-control" placeholder="Precio min">
                    </div>

                    <div class="col-md-3">
                        <input type="number" step="0.01" name="precio_max" class="form-control" placeholder="Precio max">
                    </div>

                    <div class="col-md-3">
                        <input type="number" name="stock_min" class="form-control" placeholder="Stock min">
                    </div>

                    <div class="col-md-3">
                        <input type="number" name="stock_max" class="form-control" placeholder="Stock max">
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="q" class="form-control"
                            placeholder="Nombre, categoría o proveedor"
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            title="Solo letras, no se permiten números">
                    </div>

                    <div class="col-md-4">
                        <select name="estado" class="form-select">
                            <option value="">Todos</option>
                            <option value="1">Activos</option>
                            <option value="0">Dados de baja</option>
                        </select>
                    </div>

                    <div class="col-md-2 text-center">
                        <button type="submit" style="background: #1b243a;"
                                class="btn btn-primary w-100 border-0">Buscar</button>
                    </div>

                </form>
            </div>
        </nav>


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

