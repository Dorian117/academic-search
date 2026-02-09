<?php
// Configuración de la base de datos

define('DB_HOST', 'localhost');
define('DB_NAME', 'academic_search');
define('DB_USER', 'root');
define('DB_PASS', ''); //Campo para contraseña de la base de datos, si es necesario

// Crear conexión a la base de datos
function getConnection() {
    try {
        $conn = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
?>
