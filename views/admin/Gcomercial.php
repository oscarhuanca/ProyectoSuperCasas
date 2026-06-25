<?php
// ✅ Solo seguridad, NADA DE DISEÑO
if (!defined('ENTRADA_PERMITIDA')) define('ENTRADA_PERMITIDA', true);
$titulo = "Gestión Comercial";
?>

<div class="card p-4 mb-4 shadow-sm">
    <h3 class="text-primary">Gestión Comercial</h3>
    <p class="text-muted mb-0">Aquí realizarás el registro, administración y venta de inmuebles.</p>
</div>

<div class="d-flex flex-wrap gap-2 mb-4">
    <button class="btn btn-outline-primary" onclick="cargarModuloComercial('Propiedades')">🏠 Gestión de Propiedades</button>
    <button class="btn btn-outline-success" onclick="cargarModuloComercial('Clientes')">👥 Gestión de Clientes</button>
    <button class="btn btn-outline-info" onclick="cargarModuloComercial('Contratos')">📄 Contratos</button>
    <button class="btn btn-outline-secondary" onclick="cargarModuloComercial('Ventas')">💼 Registro de Ventas</button>
</div>

<div id="contenido-comercial" class="bg-white p-4 rounded shadow-sm min-vh-50">
    <div class="text-center text-muted py-5">
        <i class="fa fa-building fa-3x mb-3"></i>
        <h5>Bienvenido a Gestión Comercial</h5>
        <p>Seleccione una opción para comenzar</p>
    </div>
</div>

<script>
function cargarModuloComercial(modulo) {
    fetch(`admin.php?modulo=${modulo}&_=${Date.now()}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        }
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('contenido-comercial').innerHTML = html;
    })
    .catch(err => console.error('Error:', err));
}
</script>