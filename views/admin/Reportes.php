<?php
// ✅ Solo seguridad, NADA de código de diseño
if (!defined('ENTRADA_PERMITIDA')) define('ENTRADA_PERMITIDA', true);
$titulo = "Reportes";
?>

<div class="card p-4 mb-4 shadow-sm">
    <h3 class="text-primary">Reportes del Sistema</h3>
    <p class="text-muted mb-0">Visualiza y descarga reportes de actividad, ventas y propiedades.</p>
</div>

<div class="d-flex flex-wrap gap-2 mb-4">
    <button class="btn btn-outline-primary" onclick="cargarReporte('Ventas')">📊 Reporte de Ventas</button>
    <button class="btn btn-outline-success" onclick="cargarReporte('Propiedades')">🏠 Reporte de Propiedades</button>
    <button class="btn btn-outline-info" onclick="cargarReporte('Usuarios')">👤 Reporte de Usuarios</button>
    <button class="btn btn-outline-secondary" onclick="cargarReporte('Actividad')">📈 Actividad del Sistema</button>
</div>

<div id="contenido-reportes" class="bg-white p-4 rounded shadow-sm min-vh-50">
    <div class="text-center text-muted py-5">
        <i class="fa fa-chart-line fa-3x mb-3"></i>
        <h5>Bienvenido a Reportes</h5>
        <p>Seleccione un tipo de reporte para visualizar la información</p>
    </div>
</div>

<script>
function cargarReporte(tipo) {
    fetch(`admin.php?modulo=Reporte_${tipo}&_=${Date.now()}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('contenido-reportes').innerHTML = html;
    })
    .catch(err => console.error(err));
}
</script>