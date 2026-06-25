<?php
if (!defined('ENTRADA_PERMITIDA')) define('ENTRADA_PERMITIDA', true);

$usuarios = isset($controller) ? $controller->listarUsuarios() : [];
?>

<!-- ✅ SCRIPT AL INICIO, SIN RUTAS FIJAS -->
<script>
console.log("✅ JS cargado correctamente");

function cargarModulo(modulo) {
    fetch(`admin.php?modulo=${modulo}`, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.ok ? res.text() : Promise.reject("Error de carga"))
    .then(html => {
        const contenedor = document.getElementById('contenido-principal');
        if (contenedor) contenedor.innerHTML = html;
        else window.location.reload();
    })
    .catch(err => {
        console.error(err);
        window.location.reload();
    });
}

function limpiarFormulario() {
    document.getElementById('formUsuario').reset();
    document.getElementById('id_usuario').value = '';
    document.getElementById('tituloFormulario').textContent = 'Nuevo Usuario';
    document.getElementById('contrasena').required = true;

    // Fuerza a borrar todo, sin importar lo que ponga el navegador
    document.getElementById('nombre').value = '';
    document.getElementById('apellido').value = '';
    document.getElementById('correo').value = '';
    document.getElementById('telefono').value = '';
    document.getElementById('id_rol').value = '';
    document.getElementById('contrasena').value = '';
}

// ✅ Editar usuario: igual que tenías
function editarUsuario(id) {
    console.log("Cargando usuario ID:", id);
    fetch(`admin.php?modulo=obtener_usuario&id=${id}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(datos => {
        if (datos.error) { alert("❌ " + datos.error); return; }
        document.getElementById('id_usuario').value = datos.id_usuario;
        document.getElementById('nombre').value = datos.nombre;
        document.getElementById('apellido').value = datos.apellido;
        document.getElementById('correo').value = datos.correo;
        document.getElementById('telefono').value = datos.telefono;
        document.getElementById('id_rol').value = datos.id_rol;
        document.getElementById('contrasena').value = '';
        document.getElementById('contrasena').required = false;
        document.getElementById('tituloFormulario').textContent = 'Editar Usuario';
    })
    .catch(err => {
        console.error(err);
        alert("❌ No se pudo cargar el usuario");
    });
}

// ✅ Cambiar estado
function cambiarEstado(id, nuevoEstado) {
    if (!confirm(`¿Seguro que quieres ${nuevoEstado === 'activo' ? 'activar' : 'desactivar'}?`)) return;
    const datos = new FormData();
    datos.append('id_usuario', id);
    fetch(`admin.php?modulo=${nuevoEstado === 'activo' ? 'activar_usuario' : 'desactivar_usuario'}`, {
        method: 'POST',
        body: datos,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.text())
    .then(msg => {
        alert(msg.trim());
        if (msg.includes('✅')) cargarModulo('Gusuarios');
    })
    .catch(err => alert("❌ Error"));
}

// ✅ Eliminar
function eliminarUsuario(id) {
    if (!confirm("¿Eliminar este usuario?")) return;
    const datos = new FormData();
    datos.append('id_usuario', id);
    fetch(`admin.php?modulo=eliminar_usuario`, {
        method: 'POST',
        body: datos,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.text())
    .then(msg => {
        alert(msg.trim());
        if (msg.includes('✅')) cargarModulo('Gusuarios');
    })
    .catch(err => alert("❌ Error"));
}

document.addEventListener('DOMContentLoaded', () => {
     limpiarFormulario(); // <-- ESTA LÍNEA ES LA ÚNICA QUE AGREGAS
    document.getElementById('formUsuario').addEventListener('submit', e => {
        e.preventDefault();
        const id = document.getElementById('id_usuario').value;
        const accion = id ? 'actualizar_usuario' : 'guardar_usuario';
        fetch(`admin.php?modulo=${accion}`, {
            method: 'POST',
            body: new FormData(this),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(msg => {
            alert(msg.trim());
            if (msg.includes('✅')) { limpiarFormulario(); cargarModulo('Gusuarios'); }
        });
    });
});
</script>

<div class="container-fluid mt-4">
    <h3 class="text-primary">Gestión de Usuarios</h3>
    <hr>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 id="tituloFormulario">Nuevo Usuario</h5>
        </div>
        <div class="card-body">
            <form id="formUsuario" autocomplete="off">
                <input type="hidden" name="id_usuario" id="id_usuario">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" required autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contraseña <small>(dejar vacío para no cambiar)</small></label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Rol</label>
                        <select class="form-select" id="id_rol" name="id_rol" required>
                            <option value="">Seleccione</option>
                            <option value="1">Administrador</option>
                            <option value="2">Gerente</option>
                            <option value="3">Asesor</option>
                            <option value="4">Recepción</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" onclick="limpiarFormulario()">Limpiar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>Lista de Usuarios</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= $u['id_usuario'] ?></td>
                        <td><?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido']) ?></td>
                        <td><?= htmlspecialchars($u['correo']) ?></td>
                        <td><?= htmlspecialchars($u['telefono']) ?></td>
                        <td><?= htmlspecialchars($u['rol']) ?></td>
                        <td>
                            <span class="badge <?= $u['estado'] === 'activo' ? 'bg-success' : 'bg-secondary' ?>">
                                <?= ucfirst($u['estado']) ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($u['fecha_registro'])) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning me-1" onclick="editarUsuario(<?= $u['id_usuario'] ?>)">Editar</button>
                            <?php if ($u['estado'] === 'activo'): ?>
                                <button class="btn btn-sm btn-secondary me-1" onclick="cambiarEstado(<?= $u['id_usuario'] ?>, 'inactivo')">Desactivar</button>
                            <?php else: ?>
                                <button class="btn btn-sm btn-success me-1" onclick="cambiarEstado(<?= $u['id_usuario'] ?>, 'activo')">Activar</button>
                            <?php endif; ?>
                            <button class="btn btn-sm btn-danger" onclick="eliminarUsuario(<?= $u['id_usuario'] ?>)">Eliminar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>