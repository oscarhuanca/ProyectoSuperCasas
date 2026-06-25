<?php
// Si viene un ID, cargamos los datos del usuario
$usuario = [];
if (!empty($_GET['id'])) {
    require_once __DIR__ . '/../../../config/database.php';
    require_once __DIR__ . '/../../../controllers/AdminController.php';
    $control = new AdminController();
    // Llamamos la función para obtener datos
    $datos = $control->obtenerUsuario();
    $usuario = json_decode($datos, true);
}
?>

<form id="formUsuario">
    <!-- Campo oculto con el ID, vacío si es nuevo -->
    <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?? '' ?>">

    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" required
               value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Apellido</label>
        <input type="text" name="apellido" class="form-control" required
               value="<?= htmlspecialchars($usuario['apellido'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Correo Electrónico</label>
        <input type="email" name="correo" class="form-control" required
               value="<?= htmlspecialchars($usuario['correo'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input type="password" name="contrasena" class="form-control"
               placeholder="<?= empty($usuario) ? 'Escriba la contraseña' : 'Deje vacío si no desea cambiarla' ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" class="form-control" required
               value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Rol</label>
        <select name="id_rol" class="form-select" required>
            <option value="1" <?= isset($usuario['id_rol']) && $usuario['id_rol'] == 1 ? 'selected' : '' ?>>Administrador</option>
            <option value="2" <?= isset($usuario['id_rol']) && $usuario['id_rol'] == 2 ? 'selected' : '' ?>>Vendedor</option>
            <option value="3" <?= isset($usuario['id_rol']) && $usuario['id_rol'] == 3 ? 'selected' : '' ?>>Propietario</option>
        </select>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>

<script>
// Enviar formulario
document.getElementById('formUsuario').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = this.id_usuario.value;
    const accion = id ? 'actualizar_usuario' : 'guardar_usuario';

    fetch('../../admin.php?modulo=' + accion, {
        method: 'POST',
        body: new FormData(this),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.text())
    .then(mensaje => {
        alert(mensaje.trim());
        if (mensaje.includes('✅')) {
            bootstrap.Modal.getInstance(document.getElementById('modalUsuario')).hide();
            cargarModulo('Gusuarios');
        }
    })
    .catch(err => {
        console.error(err);
        alert('❌ Error al procesar los datos');
    });
});
</script>