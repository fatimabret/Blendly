
        <h1 class="display-3 text-center text-white m-2 pb-2">Mis Consultas</h1>
    </main>

    <div class="container">
        <div class="table-responsive">
            <table id="mytable" class="table table-bordered table-striped table-hover custom-table formulario">
                <thead>
                    <tr>
                        <th>Asunto</th>
                        <th>Consulta</th>
                        <th>Estado / Respuesta</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($consulta as $row) { ?>
                        <tr>
                            <td><?php echo $row['motivo_consulta']; ?></td>
                            <td><?php echo $row['texto_consulta']; ?></td>
                            <td>

                                <?php if (isset($row['leido_consulta']) && $row['leido_consulta'] == 1) { ?>
                                    <?php if (!empty($row['respuesta_consulta'])) { ?>
                                        <?php echo $row['respuesta_consulta']; ?>
                                    <?php } else { ?>
                                        <h6 class="text-primary">Leido sin respuesta</h6>
                                    <?php } ?>
                                <?php } else { ?>
                                    <h6 class="text-danger">No leido</h6>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <br>
    </div>