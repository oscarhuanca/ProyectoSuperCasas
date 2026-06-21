<?php
// Iniciamos el buffer
ob_start();

// Definimos el título de la página
$titulo = "Reportes del Sistema"; 
?>

<div class="card p-4">
    <h3>Panel de Reportes y Estadísticas</h3>
    <p>Aquí podrás visualizar los reportes financieros y de rendimiento de ventas.</p>
</div>

<?php
// Capturamos el contenido y cerramos el buffer
$contenido = ob_get_clean();

// Incluimos el layout principal
include '../layouts/admin_layout.php';
?>