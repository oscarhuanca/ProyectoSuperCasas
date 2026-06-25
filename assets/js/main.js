// assets/js/main.js
console.log("Sistema Web SC: JavaScript cargado correctamente");

function cargarModulo(modulo) {
    // Ruta correcta: solo una vez la carpeta views/admin
    fetch(`/Super%20Casas/views/admin/admin.php?modulo=${modulo}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error("Módulo no encontrado");
        return res.text();
    })
    .then(html => {
        document.querySelector('.main-panel').innerHTML = html;
    })
    .catch(err => {
        console.error('Error al cargar módulo:', err);
        document.querySelector('.main-panel').innerHTML = 
            `<div class="alert alert-danger m-3">❌ No se pudo cargar la vista</div>`;
    });
}

function abrirModalUsuario() {
    // Usamos la misma ruta base que ya funciona:
    // desde views/admin/ llamamos directamente a admin.php
    fetch('admin.php?modulo=formularios/usuario_form', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => {
        console.log("Estado:", res.status, "URL:", res.url);
        if (!res.ok) throw new Error(`Error: ${res.status}`);
        return res.text();
    })
    .then(html => {
        console.log("Contenido recibido:", html);
        const contenedor = document.getElementById('modalContent');
        if (contenedor) {
            contenedor.innerHTML = html;
            new bootstrap.Modal(document.getElementById('modalUsuario')).show();
        } else {
            console.error("No existe el contenedor #modalContent");
        }
    })
    .catch(err => console.error("Error en la petición:", err));
}
/// Abrir modal y cargar formulario para editar
function editarUsuario(id) {
    fetch(`views/admin/formularios/usuario_form.php?id=${id}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.text())
    .then(html => {
        const contenedor = document.getElementById('modalContent');
        if (contenedor) {
            contenedor.innerHTML = html;
            new bootstrap.Modal(document.getElementById('modalUsuario')).show();
        }
    })
    .catch(err => console.error("Error cargando formulario de edición:", err));
}

// Eliminar usuario
function eliminarUsuario(id) {
    if (!confirm('¿Seguro que deseas eliminar este usuario?')) return;

    const datos = new FormData();
    datos.append('id_usuario', id);

    fetch('admin.php?modulo=eliminar_usuario', {
        method: 'POST',
        body: datos,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.text())
    .then(mensaje => {
        alert(mensaje.trim());
        if (mensaje.includes('✅')) cargarModulo('Gusuarios');
    })
    .catch(err => {
        console.error(err);
        alert('❌ Error al eliminar');
    });
}

document.addEventListener('submit', function(e) {
    if (e.target.id === 'formUsuario') {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        fetch('admin.php?modulo=guardar_usuario', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(respuesta => respuesta.text())
        .then(texto => {
            // Limpiamos espacios o saltos de línea extra
            const mensaje = texto.trim();

            // Mostramos el mensaje real que vino del servidor
            alert(mensaje);

            // Si fue exitoso: cerramos modal y actualizamos lista
            if (mensaje.includes("✅")) {
                // Cerrar formulario
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalUsuario'));
                if (modal) modal.hide();

                // Recargar tabla de usuarios
                if (typeof cargarModulo === 'function') {
                    cargarModulo('Gusuarios');
                }

                // Limpiar campos
                form.reset();
            }
        })
        .catch(error => {
            // Solo se muestra si realmente falla la conexión
            console.error(error);
            alert("❌ No se pudo conectar con el servidor");
        });
    }
});