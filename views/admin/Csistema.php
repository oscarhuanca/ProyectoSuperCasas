<?php
// ✅ Línea de seguridad obligatoria
if (!defined('ENTRADA_PERMITIDA')) define('ENTRADA_PERMITIDA', true);
$titulo = "Configuración del Sistema";
?>

<div class="card p-4 mb-4 shadow-sm">
    <h3 class="text-primary">Configuración del Sistema</h3>
    <p class="text-muted mb-0">Administra los parámetros generales, seguridad y preferencias de la plataforma.</p>
</div>

<div class="d-flex flex-wrap gap-2 mb-4">
    <button class="btn btn-outline-dark" onclick="cargarConfig('General')">⚙️ Configuración General</button>
    <button class="btn btn-outline-warning" onclick="cargarConfig('Seguridad')">🔒 Seguridad y Accesos</button>
    <button class="btn btn-outline-info" onclick="cargarConfig('Empresa')">🏢 Datos de la Empresa</button>
    <button class="btn btn-outline-secondary" onclick="cargarConfig('Respaldo')">💾 Respaldo y Restauración</button>
</div>

<div id="contenido-config" class="bg-white p-4 rounded shadow-sm min-vh-50">
    <div class="text-center text-muted py-5">
        <i class="fa fa-cogs fa-3x mb-3"></i>
        <h5>Bienvenido a Configuración</h5>
        <p>Seleccione una opción para modificar la configuración del sistema</p>
    </div>
</div>

<script>
// ✅ Función para cargar cada sección de configuración
function cargarConfig(seccion) {
    fetch(`admin.php?modulo=Config_${seccion}&_=${Date.now()}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        }
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('contenido-config').innerHTML = html;
    })
    .catch(err => {
        console.error('Error al cargar configuración:', err);
        document.getElementById('contenido-config').innerHTML = `<div class="alert alert-danger">No se pudo cargar la sección</div>`;
    });
}
</script>