<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrativo - Super Casas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --azul-sc: #0d3481; --verde-sc: #25a041; }

        /* Estructura Flexible */
        .admin-panel { display: flex; min-height: 100vh; }
        
        .sidebar { 
            width: 280px;            /* Aumentamos de 250px a 280px para dar más espacio */
            min-height: 100vh; 
            background: var(--azul-sc) !important; 
            color: #fff; 
        }

        .sidebar .nav-link { 
            font-size: 0.9rem;       /* Reducimos ligeramente la letra para que quepa mejor */
            white-space: nowrap;     /* Forzamos a que el texto NO se rompa en dos líneas */
            padding: 10px 15px;      /* Ajustamos el padding */
        }
        
        .content-wrapper { flex-grow: 1; display: flex; flex-direction: column; }
        
        /* Nueva Barra Superior */
        .top-bar { background: var(--azul-sc); color: white; padding: 15px 25px; }

        .nav-link { color: #adb5bd !important; }
        .nav-link:hover, .nav-link.active { 
            color: #fff !important; 
            background: var(--verde-sc) !important; 
            font-weight: bold;
        }

        .main-panel { padding: 25px; background-color: #f8f9fa; flex-grow: 1; }
    </style>
</head>
<body>

    <div class="admin-panel">
        <!-- Sidebar único y corregido -->
        <nav class="sidebar p-3">
            <div class="logo-area text-center py-3">
                <img src="assets/img/logo.png" alt="Logo" style="width: 80%;">
            </div>
            <h4 class="text-white text-center">Admin SAPN</h4>
            <hr class="text-white">
            <ul class="nav flex-column">
                
                <li class="nav-item"><a class="nav-link" href="/Super Casas/views/admin/Gusuarios.php">Gestión de Usuarios</a></li>
                <li class="nav-item"><a class="nav-link" href="/Super Casas/views/admin/Gtalentohumano.php">Gestión de Talento Humano</a></li>
                <li class="nav-item"><a class="nav-link" href="/Super Casas/views/admin/Gcomercial.php">Gestión Comercial</a></li>
                <li class="nav-item"><a class="nav-link" href="/Super Casas/views/admin/Reportes.php">Reportes</a></li>
                <li class="nav-item"><a class="nav-link" href="/Super Casas/views/admin/Csistema.php">Configuración del Sistema</a></li>
            </ul>
            <div class="mt-auto p-3">
                <a href="logout.php" class="nav-link text-danger">Cerrar Sesión</a>
            </div>
        </nav>

        <!-- Contenedor Derecho (Header + Contenido) -->
        <div class="content-wrapper">
            <header class="top-bar">
                <h2>Panel de Administración</h2>
            </header>
            <main class="main-panel">
                <?php if (isset($titulo)): ?>
                    <h1 class="mb-4"><?php echo $titulo; ?></h1>
                <?php endif; ?>
                <?php echo $contenido; ?>
            </main>
        </div>
    </div>

    <script>
        // Tu script de detección de página activa se mantiene igual
        document.addEventListener("DOMContentLoaded", function() {
            const path = window.location.pathname;
            const page = path.split("/").pop();
            document.querySelectorAll('.nav-link').forEach(link => {
                if (link.getAttribute('href') === page) link.classList.add('active');
            });
        });
    </script>
</body>
</html>