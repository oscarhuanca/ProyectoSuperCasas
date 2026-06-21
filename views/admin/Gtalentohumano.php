<?php
// Iniciamos el buffer
ob_start();

// Definimos el título de la página
$titulo = "Gestión de Talento Humano"; 
?>

<div class="card p-4">
    <h3>Gestión de Personal</h3>
    <p>Aquí podrás administrar los registros, contratos y datos del talento humano.</p>
</div>

<?php
// Capturamos el contenido y cerramos el buffer
$contenido = ob_get_clean();

// Incluimos el layout principal
include '../layouts/admin_layout.php';
?>