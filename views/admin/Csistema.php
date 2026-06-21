<?php
$titulo = "Configuración del Sistema";
ob_start();
?>

<div class="card p-4">
    <h3>Ajustes Generales</h3>
    <p>Configura los parámetros de la empresa aquí.</p>
</div>

<?php
$contenido = ob_get_clean();
include '../layouts/admin_layout.php';
?>