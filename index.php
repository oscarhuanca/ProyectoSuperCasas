<?php
// Reportar errores para saber qué falla exactamente
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Definir la ruta base para evitar problemas de carpetas
define('CONTROLADORES', 'controllers/');
define('MODELOS', 'models/');
define('VISTAS', 'views/');
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Super Casas S.R.L.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>

    <?php
        // 1. Cargar el Header (Las dos barras superiores)
        $headerPath = VISTAS . "modulos/header.php";
        if (file_exists($headerPath)) {
            include_once $headerPath;
        } else {
            echo "<div class='container mt-3'><div class='alert alert-danger'>Error: No se encuentra el header en: $headerPath</div></div>";
        }
    ?>

    <?php
        $inicioPath = VISTAS . "inmuebles/inicio.php";
        if (file_exists($inicioPath)) {
            include_once $inicioPath;
        } else {
            echo "<div class='container mt-3'><div class='alert alert-danger'>Error: No se encuentra el archivo de inicio en: $inicioPath</div></div>";
        }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>



<script>
document.addEventListener('DOMContentLoaded', function() {
    var btn = document.querySelector('[data-bs-target="#modalRegistro"]');
    if (btn) {
        btn.addEventListener('click', function() {
            var myModal = new bootstrap.Modal(document.getElementById('modalRegistro'));
            myModal.show();
        });
    }
});
</script>

<script>
    // Prueba esto: al hacer clic en cualquier cosa, veremos qué pasa en la consola
    document.addEventListener('click', function(e) {
        if(e.target.matches('[data-bs-target="#modalRegistro"]')) {
            console.log("¡Clic detectado en el botón!");
            var myModal = new bootstrap.Modal(document.getElementById('modalRegistro'));
            myModal.show();
        }
    });
</script>

</body>
</html>