
        <h1 class="display-3 text-center text-white m-2 pt-2 pb-2">Lista de Consultas</h1>

    </main>

    <div class="container">
        
        <!--  Condicion para visualizar los errores de validacion  -->
        <?php if (session('mensaje')): ?>
            <div class="alert alert-warning" role="alert">
                <?= session('mensaje') ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table id="mytable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th>Asunto</th>
                        <th>Consulta</th>
                        <th>Estado</th>
                        <th>Responder</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($consulta as $row) { ?>
                        <tr>
                            <td><?php echo $row['id_consulta']; ?></td>
                            <td><?php echo $row['correo_consulta']; ?></td>
                            <td><?php echo $row['telefono_consulta']; ?></td>
                            <td><?php echo $row['motivo_consulta']; ?></td>
                            <td><?php echo $row['texto_consulta']; ?></td>
                            <td>
                                <?php if (isset($row['leido_consulta']) && $row['leido_consulta'] == 0) { ?>
                                    <a class="btn btn-success" href="<?php echo base_url('consulta/leido/'.$row['id_consulta']); ?>">Leido</a>
                                <?php } else { ?>
                                    <a class="btn btn-danger" href="<?php echo base_url('consulta/leido/'.$row['id_consulta']); ?>">No Leido</a>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if (empty($row['respuesta_consulta'])) { ?>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $row['id_consulta']; ?>">Contestar</button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modal-<?php echo $row['id_consulta']; ?>" tabindex="-1" aria-labelledby="modal-respuesta-<?php echo $row['id_consulta']; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modal-respuesta-<?php echo $row['id_consulta']; ?>">Respuesta a <?php echo $row['correo_consulta']; ?></h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php echo form_open(base_url('consulta/responder/'.$row['id_consulta'])); ?>
                                                        <div class="mb-3">
                                                            <label for="respuesta_consulta" class="form-label">Respuesta:</label>
                                                            <?php echo form_textarea([
                                                                'name' => 'respuesta_consulta',
                                                                'id' => 'respuesta_consulta',
                                                                'class' => 'form-control form-textarea',
                                                                'rows' => '2',
                                                                'value' => set_value('respuesta_consulta'),
                                                                'placeholder' => 'Ej. Itaque, commodi nemo quae!!'
                                                            ]); ?>
                                                            <input type="hidden" name="id_consulta" value="<?php echo $row['id_consulta']; ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <?php echo form_submit('Enviar', 'Enviar', 'class="btn btn-primary"'); ?>
                                                        </div>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                        <!-- Botón "Editar" -->
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $row['id_consulta']; ?>">Editar</button>
                                    
                                        <!-- Modal -->
                                        <div class="modal fade" id="modal-<?php echo $row['id_consulta']; ?>" tabindex="-1" aria-labelledby="modal-respuesta-<?php echo $row['id_consulta']; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="modal-respuesta-<?php echo $row['id_consulta']; ?>">
                                                            <?php echo empty($row['respuesta_consulta']) ? 'Responder a ' . $row['correo_consulta'] : 'Editar respuesta a ' . $row['correo_consulta']; ?>
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php echo form_open(base_url('consulta/responder/'.$row['id_consulta'])); ?>
                                                            <div class="mb-3">
                                                                <label for="respuesta_consulta" class="form-label">Respuesta:</label>
                                                                <?php echo form_textarea([
                                                                    'name' => 'respuesta_consulta',
                                                                    'id' => 'respuesta_consulta_' . $row['id_consulta'],
                                                                    'class' => 'form-control form-textarea',
                                                                    'rows' => '2',
                                                                    'value' => set_value('respuesta_consulta', $row['respuesta_consulta']), 
                                                                    'placeholder' => 'Ej. Itaque, commodi nemo quae!'
                                                                ]); ?>
                                                                <input type="hidden" name="id_consulta" value="<?php echo $row['id_consulta']; ?>">
                                                            </div>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                                        <?php echo form_close(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </td>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
