<?php
/**
 * ==============================================================================
 * Panadería y Cafetería Danilo - Chaclacayo, Lima - Perú
 * Módulo de Conexión a Base de Datos con PDO (conexion.php)
 * ==============================================================================
 */

// Parámetros de conexión para entorno local (XAMPP / Laragon / WampServer)
$db_host = 'localhost';
$db_name = 'danilo_db';
$db_user = 'root';
$db_pass = '';
$db_port = '3306';
$db_charset = 'utf8mb4';

// Variable global para registrar el motor de BD activo
$db_driver_active = 'none';

/**
 * Obtiene una instancia singleton o nueva conexión segura PDO
 * Soporta MySQL (prioritario para XAMPP/Laragon) y SQLite local como fallback
 * 
 * @return PDO|null
 */
function getDBConnection() {
    global $db_host, $db_name, $db_user, $db_pass, $db_port, $db_charset, $db_driver_active;
    static $pdo = null;

    if ($pdo !== null) {
        return $pdo;
    }

    // 1. Intentar conexión a MySQL (entorno oficial XAMPP/Laragon)
    try {
        $dsn = "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset={$db_charset}";
        $opciones = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$db_charset}"
        ];
        $pdo = new PDO($dsn, $db_user, $db_pass, $opciones);
        $db_driver_active = 'mysql';
        return $pdo;
    } catch (PDOException $e) {
        // MySQL no disponible en este momento
        error_log("MySQL no detectado en localhost:3306. Intentando SQLite de respaldo...");
    }

    // 2. Fallback inteligente a SQLite local (garantiza persistencia y pruebas inmediatas)
    try {
        $sqlite_file = dirname(__DIR__) . '/database/danilo.sqlite';
        $pdo = new PDO("sqlite:" . $sqlite_file);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Crear tablas si no existen
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS pedidos (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nombre_cliente TEXT NOT NULL,
                email TEXT NOT NULL,
                telefono TEXT NOT NULL,
                tipo_pedido TEXT DEFAULT 'delivery',
                producto_combo TEXT NOT NULL,
                cantidad INTEGER NOT NULL DEFAULT 1,
                fecha_entrega TEXT,
                direccion_notas TEXT,
                estado TEXT DEFAULT 'pendiente',
                fecha_registro TEXT DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS mensajes_contacto (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nombre TEXT NOT NULL,
                email TEXT NOT NULL,
                telefono TEXT,
                mensaje TEXT NOT NULL,
                fecha_envio TEXT DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS suscripciones (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email TEXT NOT NULL UNIQUE,
                fecha_registro TEXT DEFAULT CURRENT_TIMESTAMP
            );
        ");

        // Insertar datos de prueba si está vacía
        $count = $pdo->query("SELECT COUNT(*) FROM pedidos")->fetchColumn();
        if ($count == 0) {
            $pdo->exec("
                INSERT INTO pedidos (nombre_cliente, email, telefono, tipo_pedido, producto_combo, cantidad, fecha_entrega, direccion_notas, estado)
                VALUES 
                ('Carlos Mendoza', 'cmendoza@gmail.com', '987654321', 'delivery', 'Familión de Chicharrón Danilo', 1, date('now'), 'Urb. Los Ángeles Mz B Lt 14, Chaclacayo', 'en_preparacion'),
                ('Valeria Romero', 'valeria.r@hotmail.com', '912345678', 'recojo_local', 'Pastel de Acelga Tradicional', 2, date('now'), 'Para recoger al mediodía', 'pendiente'),
                ('Jorge Luis Alva', 'jalva@outlook.com', '998877665', 'delivery', 'Torta Danilo de Chocolate Especial', 1, date('now'), 'Frente al Parque Central de Chaclacayo', 'entregado');
            ");
        }

        $db_driver_active = 'sqlite';
        return $pdo;
    } catch (PDOException $e) {
        error_log("Error crítico de base de datos: " . $e->getMessage());
        return null;
    }
}
?>
