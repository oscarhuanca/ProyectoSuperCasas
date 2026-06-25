<?php
// 1. Lógica de Autenticación
session_start();
require_once('../config/database.php');

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Consulta para verificar usuario (ajusta según tus campos en la tabla 'usuarios')
    $stmt = $db->prepare("SELECT id_usuario, contrasena FROM usuarios WHERE correo = :correo");
    $stmt->execute(['correo' => $usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificación simple (¡ojo! en producción usa password_verify)
    if ($user && $password == $user['contrasena']) {
        $_SESSION['usuario_id'] = $user['id_usuario']; // Creamos la sesión
       header("Location: admin/admin.php");

        exit();
    } else {
        echo "Credenciales incorrectas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SAPN Super Casas | Acceso Administrativo</title>
    <style>
       body {
        margin: 0;
        padding: 0;
        height: 100vh;
        /* Usamos la imagen de tu web como fondo */
        background: url('../assets/img/tu-imagen-de-fondo.jpg') no-repeat center center fixed;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Poppins', sans-serif;
    }

    /* El contenedor ahora será semitransparente (Glassmorphism) */
    .login-box {
        background: rgba(255, 255, 255, 0.85); /* Blanco con 85% de opacidad */
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        backdrop-filter: blur(10px); /* Efecto de desenfoque al fondo */
        width: 350px;
        text-align: center;
    }
    .login-box h2 { color: #1e293b; margin-top: 10px; margin-bottom: 5px; }
    .login-box p { color: #555; margin-bottom: 20px; }
    input { 
        width: 100%; 
        padding: 12px; 
        margin: 10px 0; 
        border: 1px solid #ddd; 
        border-radius: 5px; 
        box-sizing: border-box; /* Importante para que el padding no rompa el ancho */
    }
    button { 
        background: #28a745; 
        color: white; 
        border: none; 
        padding: 12px; 
        width: 100%; 
        border-radius: 5px; 
        cursor: pointer; 
        font-weight: bold; 
        margin-top: 10px; 
    }
    button:hover { background: #218838; }
    </style>
</head>
<body>

<div class="login-box">
    <?php if(file_exists("../assets/img/logo.jpeg")): ?>
        <img src="../assets/img/logo.jpeg" alt="Logo" style="max-width: 120px; margin: 0 auto;">
    <?php endif; ?>

    <h2>Iniciar Sesión</h2>
    <p>SAPN Super Casas S.R.L.</p>
    
    <form method="POST">
        <input type="text" name="usuario" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit" name="btn_ingresar">INGRESAR</button>
    </form>
    
    <div style="margin-top: 15px;">
        <a href="recuperar.php" style="color: #28a745; font-size: 0.85em;">¿Olvidaste tu contraseña? Clic aquí</a>
    </div>
</div>

</body>
</html>