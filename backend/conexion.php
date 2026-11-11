<?php
/**
 * ==============================================================================
 * Panadería y Cafetería Danilo - Chaclacayo, Lima - Perú
 * Conexión a Base de Datos MySQL con PDO (conexion.php)
 *
 * Asignatura: Taller de Programación Web (Unidades 13-15)
 * Docente: Ing. Hernán Francisco Peña Carnero
 * Estudiante: Paolo (Ingeniería de Sistemas e Informática / Software - UTP)
 *
 * Rúbrica: Criterio 4 (Backend con PHP), Criterio 5 (BD MySQL), Criterio 9 (Seguridad)
 * ==============================================================================
 */

// Parámetros de conexión para entorno local (XAMPP / Laragon / WampServer)
$db_host = 'localhost';
$db_name = 'danilo_db';
$db_user = 'root';
$db_pass = '';
$db_port = '3306';
$db_charset = 'utf8mb4';

/**
 * Obtiene una instancia singleton o nueva conexión segura PDO
 * 
 * @return PDO|null
 */
function getDBConnection() {
    global $db_host, $db_name, $db_user, $db_pass, $db_port, $db_charset;
    static $pdo = null;

    if ($pdo === null) {
        $dsn = "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset={$db_charset}";
        $opciones = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanza excepciones en errores
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retorna arreglos asociativos
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Consultas preparadas NATIVAS (Seguridad anti-SQL Injection)
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$db_charset}"
        ];

        try {
            $pdo = new PDO($dsn, $db_user, $db_pass, $opciones);
        } catch (PDOException $e) {
            // Registro de error en log interno (sin exponer credenciales al usuario)
            error_log("Error de conexión a la Base de Datos: " . $e->getMessage());
            return null;
        }
    }

    return $pdo;
}
?>
