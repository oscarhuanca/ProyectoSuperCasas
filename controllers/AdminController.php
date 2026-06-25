<?php

class AdminController
{
    private $db;

    public function __construct()
    {
        // Cargar conexión
        require_once __DIR__ . '/../config/database.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Página principal del panel
    public function index()
{
    $totalPropiedades = 0;
    $ruta_panel = __DIR__ . '/../views/admin/dashboard.php';
    
    // Solo para verificar
    if (!file_exists($ruta_panel)) {
        die("❌ No se encuentra el archivo del panel en: " . $ruta_panel);
    }

    require $ruta_panel;
}


    // Prueba de conexión
    public function probarConexion()
    {
        echo "<h2 style='color:green;'>✅ CONEXIÓN EXITOSA A POSTGRESQL</h2>";
        exit;
    }

    public function cargarVista($archivo)
{
    $archivo = trim($archivo);
    $acciones = [
        'guardar_usuario', 
        'probar_conexion', 
        'obtener_usuario', 
        'actualizar_usuario', 
        'eliminar_usuario',
        'activar_usuario',
        'desactivar_usuario'
    ];
    
    if (in_array($archivo, $acciones)) {
        return;
    }

    // ✅ RUTA FIJA: desde el controlador, subimos 1 nivel y luego vamos a views/admin
    // Controlador está en: /Super20Casas/controllers/
    // Entonces __DIR__ . '/../views/admin' = /Super20Casas/views/admin/
    $ruta = __DIR__ . '/../views/admin/' . $archivo . '.php';

    // Mostrar ruta para verificar (puedes quitarlo después)
    // echo "<!-- Ruta buscada: " . $ruta . " -->";

    if (!file_exists($ruta)) {
        echo "<div class='alert alert-danger'>❌ No encontrado: " . htmlspecialchars($ruta) . "</div>";
        return;
    }

    $controller = $this;
    require $ruta;
}

    public function guardarUsuario()
{
    try {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception("❌ Método no permitido");
        }

        // Recibir y limpiar datos
        $nombre     = trim($_POST['nombre'] ?? '');
        $apellido   = trim($_POST['apellido'] ?? '');
        $correo     = trim($_POST['correo'] ?? '');
        $contrasena = $_POST['contrasena'] ?? '';
        $telefono   = trim($_POST['telefono'] ?? '');
        $id_rol     = intval($_POST['id_rol'] ?? 0);

        // Validar campos
        if (empty($nombre) || empty($apellido) || empty($correo) || empty($contrasena) || empty($telefono) || $id_rol < 1) {
            throw new Exception("❌ Todos los campos son obligatorios");
        }

        // Cifrar contraseña
        $passHash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Consulta
        $sql = "INSERT INTO usuarios (id_rol, nombre, apellido, correo, contrasena, telefono, fecha_registro)
                VALUES (?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $id_rol,
            $nombre,
            $apellido,
            $correo,
            $passHash,
            $telefono
        ]);

        // Mensaje de éxito LIMPIO
        echo "✅ Usuario guardado correctamente";
        exit; // IMPORTANTE: detener ejecución aquí

    } catch (PDOException $e) {
        // Error específico de correo duplicado
        if ($e->getCode() === '23505') {
            echo "❌ Error: Ya existe un usuario con este correo";
        } else {
            echo "❌ Error en la base de datos: " . $e->getMessage();
        }
        exit;

    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
}

// ------------------------------
// 1. Obtener datos de un usuario para editar
// ------------------------------
public function obtenerUsuario() {
    try {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            throw new Exception("ID de usuario no válido");
        }

        $id = intval($_GET['id']);
        $sql = "SELECT id_usuario, id_rol, nombre, apellido, correo, telefono
                FROM usuarios WHERE id_usuario = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            throw new Exception("Usuario no encontrado");
        }

        // Devolvemos los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($usuario);
        exit;

    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(["error" => $e->getMessage()]);
        exit;
    }
}

/// 📋 Listar todos los usuarios con rol y estado
public function listarUsuarios() {
    try {
        // ✅ Cambio clave: usamos nombre_rol tal cual está en tu tabla
        $sql = "SELECT 
                    u.id_usuario, 
                    u.nombre, 
                    u.apellido, 
                    u.correo, 
                    u.telefono, 
                    COALESCE(r.nombre_rol, 'Sin rol') AS rol, 
                    u.fecha_registro, 
                    u.estado
                FROM usuarios u
                LEFT JOIN roles r ON u.id_rol = r.id_rol
                ORDER BY u.id_usuario DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Para confirmar: guarda en log cuántos registros trae
        error_log("✅ Usuarios cargados: " . count($resultado));
        return $resultado;

    } catch (PDOException $e) {
        error_log("❌ Error en listarUsuarios: " . $e->getMessage());
        return [];
    }
}
// 3. Actualizar usuario existente
public function actualizarUsuario() {
    try {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new Exception("Método no permitido");

        $id = intval($_POST['id_usuario'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $id_rol = intval($_POST['id_rol'] ?? 0);
        $contrasena = $_POST['contrasena'] ?? '';

        if ($id < 1 || !$nombre || !$apellido || !$correo || !$telefono || $id_rol < 1) {
            throw new Exception("❌ Todos los campos son obligatorios");
        }

        // Actualizar contraseña solo si se escribe una nueva
        if (!empty($contrasena)) {
            $hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios 
                    SET nombre=?, apellido=?, correo=?, telefono=?, id_rol=?, contrasena=?
                    WHERE id_usuario=?";
            $valores = [$nombre, $apellido, $correo, $telefono, $id_rol, $hash, $id];
        } else {
            $sql = "UPDATE usuarios 
                    SET nombre=?, apellido=?, correo=?, telefono=?, id_rol=?
                    WHERE id_usuario=?";
            $valores = [$nombre, $apellido, $correo, $telefono, $id_rol, $id];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($valores);

        echo "✅ Usuario actualizado correctamente";
    } catch (PDOException $e) {
        if ($e->getCode() === '23505') echo "❌ Ya existe un usuario con ese correo";
        else echo "❌ Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    exit;
}

// 4. Eliminar usuario
public function eliminarUsuario() {
    try {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new Exception("Método no permitido");
        $id = intval($_POST['id_usuario'] ?? 0);
        if ($id < 1) throw new Exception("ID inválido");

        $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        echo "✅ Usuario eliminado correctamente";
    } catch (PDOException $e) {
        // Error de llave foránea
        if ($e->getCode() === '23503') {
            echo "❌ No se puede eliminar: este usuario tiene propiedades o registros asignados";
        } else {
            echo "❌ Error: " . $e->getMessage();
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage();
    }
    exit;
}

// Activar usuario
public function activarUsuario() {
    try {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception("Método no permitido");
        }

        $id = intval($_POST['id_usuario'] ?? 0);
        if ($id < 1) {
            throw new Exception("ID de usuario inválido");
        }

        $sql = "UPDATE usuarios SET estado = 'activo' WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        echo "✅ Usuario activado correctamente";
        exit;
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage();
        exit;
    }
}

// Desactivar usuario
public function desactivarUsuario() {
    try {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception("Método no permitido");
        }

        $id = intval($_POST['id_usuario'] ?? 0);
        if ($id < 1) {
            throw new Exception("ID de usuario inválido");
        }

        $sql = "UPDATE usuarios SET estado = 'inactivo' WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        echo "✅ Usuario desactivado correctamente";
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() === '23503') {
            echo "❌ No se puede desactivar: tiene registros asociados";
        } else {
            echo "❌ Error: " . $e->getMessage();
        }
        exit;
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage();
        exit;
    }
}

}
?>