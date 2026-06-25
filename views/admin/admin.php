<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

require_once __DIR__ . '/../../controllers/AdminController.php';
$controller = new AdminController();

// ✅ DETECCIÓN FIJA DE LLAMADA AJAX
$esAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if (isset($_GET['modulo']) && !empty(trim($_GET['modulo']))) {
    $modulo = trim($_GET['modulo']);

    // Acciones de proceso
    if ($modulo === 'probar_conexion') { $controller->probarConexion(); exit; }
    if ($modulo === 'guardar_usuario') { $controller->guardarUsuario(); exit; }
    if ($modulo === 'obtener_usuario') { $controller->obtenerUsuario(); exit; }
    if ($modulo === 'actualizar_usuario') { $controller->actualizarUsuario(); exit; }
    if ($modulo === 'eliminar_usuario') { $controller->eliminarUsuario(); exit; }
    if ($modulo === 'activar_usuario') { $controller->activarUsuario(); exit; }
    if ($modulo === 'desactivar_usuario') { $controller->desactivarUsuario(); exit; }

    // ✅ SI ES AJAX: SOLO DEVOLVER CONTENIDO, NUNCA LAYOUT
    if ($esAjax) {
        ob_start();
        $controller->cargarVista($modulo);
        echo ob_get_clean();
        exit; // FIN AQUÍ, NO SIGUE NADA
    }

    // ✅ SOLO SI NO ES AJAX: CARGAR PÁGINA COMPLETA
    ob_start();
    $controller->cargarVista($modulo);
    $contenido = ob_get_clean();
    include __DIR__ . '/../layouts/admin_layout.php';
    exit;

} else {
    // Página inicial
    ob_start();
    $controller->index();
    $contenido = ob_get_clean();
    include __DIR__ . '/../layouts/admin_layout.php';
    exit;
}
?>