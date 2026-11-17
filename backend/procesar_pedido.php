<?php
/**
 * ==============================================================================
 * Panadería y Cafetería Danilo - Chaclacayo, Lima - Perú
 * Controlador Backend: Procesamiento y Registro de Pedidos (procesar_pedido.php)
 * ==============================================================================
 */

require_once __DIR__ . '/conexion.php';

// Habilitar CORS para permitir peticiones tanto desde http://localhost:8000 como desde archivos locales (file://)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Detectar si la petición es asíncrona (AJAX / Fetch)
$is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') 
    || (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false)
    || (isset($_POST['ajax']) && $_POST['ajax'] === '1');

// Función auxiliar para responder JSON o HTML amigable
function responder($exito, $mensaje, $datos = [], $is_ajax = true) {
    if ($is_ajax) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => $exito,
            'message' => $mensaje,
            'data'    => $datos
        ], JSON_UNESCAPED_UNICODE);
        exit;
    } else {
        // Redirección o mensaje legible en HTML tradicional
        $color = $exito ? '#25d366' : '#e74c3c';
        $titulo = $exito ? '¡Pedido Registrado con Éxito!' : 'Error al Procesar Pedido';
        echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>{$titulo}</title>";
        echo "<link rel='stylesheet' href='../styles.css'></head><body style='font-family: sans-serif; background: #170b05; color: #fff; text-align: center; padding: 4rem 1rem;'>";
        echo "<div style='max-width: 500px; margin: 0 auto; background: #23120a; padding: 2.5rem; border-radius: 12px; border: 1px solid #c8914b;'>";
        echo "<h1 style='color: {$color}; font-size: 1.8rem; margin-bottom: 1rem;'>{$titulo}</h1>";
        echo "<p style='font-size: 1.1rem; line-height: 1.6; margin-bottom: 2rem;'>{$mensaje}</p>";
        echo "<a href='../index.html' style='display: inline-block; background: #c8914b; color: #fff; padding: 0.8rem 1.8rem; border-radius: 6px; text-decoration: none; font-weight: bold;'>Volver a la Página Principal</a>";
        echo "</div></body></html>";
        exit;
    }
}

// 1. Verificación de Seguridad: Método de Envío
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(false, 'Acceso no autorizado. El método debe ser POST.', [], $is_ajax);
}

// Leer datos enviados (soporta FormData y JSON crudo)
$input_raw = json_decode(file_get_contents('php://input'), true);
$data = $input_raw ? $input_raw : $_POST;

// 2. Sanitización Estricta de Entradas (Seguridad contra ataques XSS)
$nombre_cliente  = isset($data['nombre_cliente']) ? htmlspecialchars(strip_tags(trim($data['nombre_cliente'])), ENT_QUOTES, 'UTF-8') : '';
$email           = isset($data['email']) ? filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL) : '';
$telefono        = isset($data['telefono']) ? htmlspecialchars(strip_tags(trim($data['telefono'])), ENT_QUOTES, 'UTF-8') : '';
$tipo_pedido     = isset($data['tipo_pedido']) ? htmlspecialchars(strip_tags(trim($data['tipo_pedido'])), ENT_QUOTES, 'UTF-8') : 'delivery';
$producto_combo  = isset($data['producto_combo']) ? htmlspecialchars(strip_tags(trim($data['producto_combo'])), ENT_QUOTES, 'UTF-8') : '';
$cantidad        = isset($data['cantidad']) ? filter_var($data['cantidad'], FILTER_VALIDATE_INT) : 1;
$fecha_entrega   = isset($data['fecha_entrega']) ? htmlspecialchars(strip_tags(trim($data['fecha_entrega'])), ENT_QUOTES, 'UTF-8') : '';
$direccion_notas = isset($data['direccion_notas']) ? htmlspecialchars(strip_tags(trim($data['direccion_notas'])), ENT_QUOTES, 'UTF-8') : '';

// 3. Validación de Negocio y Campos Obligatorios
$errores = [];

if (empty($nombre_cliente) || mb_strlen($nombre_cliente) < 3) {
    $errores[] = 'El nombre completo es obligatorio y debe tener al menos 3 caracteres.';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'Por favor, proporciona un correo electrónico válido.';
}

if (empty($telefono) || !preg_match('/^[0-9+ ]{7,15}$/', $telefono)) {
    $errores[] = 'El teléfono de contacto debe contener entre 7 y 15 dígitos válidos.';
}

if (empty($producto_combo)) {
    $errores[] = 'Debe seleccionar o indicar el producto o combo de su pedido.';
}

if ($cantidad === false || $cantidad < 1 || $cantidad > 50) {
    $errores[] = 'La cantidad debe ser un número entero entre 1 y 50 unidades.';
}

if (empty($fecha_entrega)) {
    $fecha_entrega = date('Y-m-d');
} else {
    // Validar formato fecha YYYY-MM-DD
    $d = DateTime::createFromFormat('Y-m-d', $fecha_entrega);
    if (!$d || $d->format('Y-m-d') !== $fecha_entrega) {
        $errores[] = 'El formato de fecha de entrega no es válido.';
    }
}

$tipos_permitidos = ['delivery', 'recojo_local', 'reserva_mesa'];
if (!in_array($tipo_pedido, $tipos_permitidos)) {
    $tipo_pedido = 'delivery';
}

if (!empty($errores)) {
    responder(false, implode(' ', $errores), ['errores' => $errores], $is_ajax);
}

// 4. Conexión a Base de Datos MySQL
$pdo = getDBConnection();

if (!$pdo) {
    // Fallback didáctico para cuando no esté corriendo MySQL localmente:
    // Retornamos éxito simulado para la demostración en vivo con aviso
    responder(true, '¡Pedido registrado con éxito! (Modo demostración activa: base de datos local desconectada). En breve te contactaremos por WhatsApp.', [
        'cliente' => $nombre_cliente,
        'producto' => $producto_combo,
        'modo' => 'demostracion_sin_bd'
    ], $is_ajax);
}

// 5. Inserción Persistente con Consultas Preparadas (Prepared Statements PDO)
try {
    $sql = "INSERT INTO pedidos (
                nombre_cliente, email, telefono, tipo_pedido, 
                producto_combo, cantidad, fecha_entrega, direccion_notas, estado
            ) VALUES (
                :nombre, :email, :telefono, :tipo, 
                :producto, :cantidad, :fecha, :notas, 'pendiente'
            )";

    $stmt = $pdo->prepare($sql);

    // Vinculación segura de parámetros (Prevención de Inyección SQL)
    $stmt->bindParam(':nombre', $nombre_cliente, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
    $stmt->bindParam(':tipo', $tipo_pedido, PDO::PARAM_STR);
    $stmt->bindParam(':producto', $producto_combo, PDO::PARAM_STR);
    $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $fecha_entrega, PDO::PARAM_STR);
    $stmt->bindParam(':notas', $direccion_notas, PDO::PARAM_STR);

    $stmt->execute();
    $nuevo_id = $pdo->lastInsertId();

    responder(true, "¡Pedido #{$nuevo_id} registrado con éxito en Panadería Danilo! En breve nuestro equipo de Chaclacayo confirmará tu pedido por WhatsApp.", [
        'pedido_id' => $nuevo_id,
        'cliente'   => $nombre_cliente,
        'producto'  => $producto_combo,
        'telefono'  => $telefono
    ], $is_ajax);

} catch (PDOException $e) {
    error_log("Error al insertar pedido: " . $e->getMessage());
    responder(false, "Ocurrió un error al guardar el pedido en el servidor. Por favor, intenta de nuevo o comunícate al WhatsApp 953 877 620.", [], $is_ajax);
}
?>
