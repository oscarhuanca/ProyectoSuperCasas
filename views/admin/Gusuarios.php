<?php
// 1. Incluir conexión o configuración si es necesario
// require_once '../../config/config.php'; 

$titulo = "Gestión de Usuarios";
ob_start();
?>

<!-- TODO TU CONTENIDO HTML AQUÍ -->
<div class="card p-4">
    <h3>Administración de Usuarios</h3>
    <p>Aquí verás la tabla de usuarios del sistema.</p>
</div>

<?php
$contenido = ob_get_clean();
include '../layouts/admin_layout.php';
?>