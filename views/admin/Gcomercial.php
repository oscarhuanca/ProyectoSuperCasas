<?php
// 1. Iniciamos el buffer ANTES de cualquier otra cosa
ob_start();

$titulo = "Gestión Comercial";
?>

<div class="card p-4">
    <h3>Gestión de Propiedades</h3>
    <p>Aquí realizarás el registro y venta de inmuebles.</p>
</div>

<?php
// 2. Capturamos todo lo anterior y cerramos el buffer
$contenido = ob_get_clean();

// 3. Incluimos el layout
include '../layouts/admin_layout.php';
?>