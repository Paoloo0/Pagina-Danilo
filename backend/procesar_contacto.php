<?php
/**
 * ==============================================================================
 * Panadería y Cafetería Danilo - Chaclacayo, Lima - Perú
 * Controlador Backend: Procesamiento de Contacto y Suscripciones (procesar_contacto.php)
 *
 * Asignatura: Taller de Programación Web (Unidades 13-15)
 * Docente: Ing. Hernán Francisco Peña Carnero
 * ==============================================================================
 */

require_once __DIR__ . '/conexion.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$input_raw = json_decode(file_get_contents('php://input'), true);
$data = $input_raw ? $input_raw : $_POST;

$accion = isset($data['accion']) ? trim($data['accion']) : 'newsletter';
$pdo = getDBConnection();

if ($accion === 'newsletter') {
    $email = isset($data['email']) ? filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL) : '';

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Por favor, ingresa un correo electrónico válido.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (!$pdo) {
        echo json_encode([
            'success' => true, 
            'message' => '¡Gracias por suscribirte al boletín de Panadería Danilo! (Modo demostración activo).'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    try {
        // Verificar si ya está suscrito
        $check = $pdo->prepare("SELECT id FROM suscripciones WHERE email = :email LIMIT 1");
        $check->execute([':email' => $email]);

        if ($check->fetch()) {
            echo json_encode(['success' => true, 'message' => 'Este correo ya se encuentra registrado en nuestro boletín.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO suscripciones (email, estado) VALUES (:email, 'activo')");
        $stmt->execute([':email' => $email]);

        echo json_encode([
            'success' => true, 
            'message' => '¡Suscripción exitosa! Recibirás nuestras novedades y promociones de Chaclacayo.'
        ], JSON_UNESCAPED_UNICODE);
        exit;

    } catch (PDOException $e) {
        error_log("Error en suscripción: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error al procesar la suscripción.'], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
?>
