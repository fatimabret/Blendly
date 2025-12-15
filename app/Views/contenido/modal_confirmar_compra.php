<div class="modal fade" id="modalConfirmarCompra" tabindex="-1" aria-labelledby="modalCompraLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content formulario">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar Compra</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="<?= base_url('guardar_compra') ?>" method="post">
        <div class="modal-body">

          <h6>Datos del Comprador</h6>

          <div class="row g-3 mb-3">

            <div class="col-md-6">
              <label>Nombre completo</label>
              <input type="text" name="nombre" class="form-control" value="<?= isset($usuario) ? esc($usuario['nombre_usuario'].' '.$usuario['apellido_usuario']) : '' ?>" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras y espacios" required>
            </div>

            <div class="col-md-6">
              <label>Teléfono</label>
              <input type="text" name="telefono" class="form-control" value="<?= isset($usuario) ? esc($usuario['telefono_usuario']) : '' ?>" pattern="^[0-9]{6,15}$" title="Solo números, entre 6 y 15 dígitos" required>
            </div>
          </div>

          <div class="mb-3">
            <label>DNI</label>
            <input type="text" name="dni" class="form-control" pattern="^[0-9]{7,11}$" title="Debe contener solo números (entre 7 y 11)" required>
          </div>

          <hr>

          <h6>Método de Entrega</h6>
          <select name="metodo" id="metodo_entrega" class="form-select mb-3" required>
            <option value="">Seleccionar...</option>
            <option value="retiro">Retiro en sucursal</option>
            <option value="envio">Envío a domicilio</option>
          </select>

          <div id="datos_envio" style="display:none">

            <h6>Dirección de entrega</h6>

            <div class="row mb-3">

              <div class="col-md-6">
                <label>Calle</label>
                <input type="text" name="calle" class="form-control" pattern="^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s]+$" title="Calle inválida">
              </div>

              <div class="col-md-2">
                <label>Número</label>
                <input type="text" name="numero" class="form-control" pattern="^[0-9]+$" title="Solo números">
              </div>

              <div class="col-md-4">
                <label>Piso/Depto</label>
                <input type="text" name="piso" class="form-control" pattern="^[A-Za-z0-9\s\-]*$" title="Campo opcional">

              </div>
            </div>

            <div class="row mb-3">

              <div class="col-md-4">
                <label>Ciudad</label>
                <input type="text" name="ciudad" class="form-control" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo letras y espacios">
              </div>

              <div class="col-md-4">
                <label>Provincia</label>
                <input type="text" name="provincia" class="form-control" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo letras y espacios">
              </div>

              <div class="col-md-4">
                <label>Código Postal</label>
                <input type="text" name="cp" class="form-control" pattern="^[0-9]{3,8}$" title="Solo números (entre 3 y 8 dígitos)">
              </div>
            </div>
          </div>

          <hr>

          <div class="mb-3">
            <label>Notas adicionales</label>
            <textarea name="notas" class="form-control" rows="2"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" onclick="mostrarResumen()"> Continuar </button>
          <button type="button" class="btn btn-warning" onclick="limpiarFormulario()">Limpiar campos</button>
        </div>

      </form>
    </div>
  </div>

  <script>
  document.getElementById("metodo_entrega").addEventListener("change", function() {
      const envio = document.getElementById("datos_envio");

      if (this.value === "envio") {
          envio.style.display = "block";
          envio.querySelectorAll("input").forEach(i => i.required = true);
      } else {
          envio.style.display = "none";
          envio.querySelectorAll("input").forEach(i => i.required = false);
      }
  });

  function limpiarFormulario() {
      document.querySelector("#modalConfirmarCompra form").reset();
      document.getElementById("datos_envio").style.display = "none";
  }
</script>


</div>
