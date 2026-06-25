<?php
if (!defined('ENTRADA_PERMITIDA')) define('ENTRADA_PERMITIDA', true);
$titulo = "Gestión de Talento Humano";
?>

<script>
function cargarModuloTalento(modulo) {
    const ruta = `admin.php?modulo=${modulo}&_=${Date.now()}`;
    fetch(ruta, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        }
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('contenido-principal').innerHTML = html;
    })
    .catch(err => console.error("Error:", err));
}
</script>

<div class="card p-4 mb-4 shadow-sm">
    <h3 class="text-primary">Gestión de Talento Humano</h3>
    <p class="text-muted mb-0">Aquí podrás administrar los registros, contratos y datos del talento humano.</p>
</div>

<div class="d-flex flex-wrap gap-2 mb-4">
    <button class="btn btn-outline-primary" onclick="cargarModuloTalento('RegistroPersonal')">📋 Registro de Personal</button>
    <button class="btn btn-outline-success" onclick="cargarModuloTalento('Capacitacionpersonal')">🎓 Capacitación de Personal</button>
    <button class="btn btn-outline-info" onclick="cargarModuloTalento('Evaluacionpersonal')">📊 Evaluación de Personal</button>
</div>

<div id="contenido-principal" class="bg-white p-4 rounded shadow-sm min-vh-50">
    <div class="text-center text-muted py-5">
        <i class="fa fa-users fa-3x mb-3"></i>
        <h5>Bienvenido a Talento Humano</h5>
        <p>Seleccione una opción para comenzar</p>
    </div>
</div>