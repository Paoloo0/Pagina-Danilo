<?php
/**
 * ==============================================================================
 * Panadería y Cafetería Danilo - Chaclacayo, Lima - Perú
 * Panel de Consulta y Verificación de Pedidos Registrados (ver_pedidos.php)
 * ==============================================================================
 */

require_once __DIR__ . '/conexion.php';

$pdo = getDBConnection();
$pedidos = [];
$error_conexion = false;

if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM pedidos ORDER BY id DESC LIMIT 50");
        $pedidos = $stmt->fetchAll();
    } catch (PDOException $e) {
        $error_conexion = true;
    }
} else {
    $error_conexion = true;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Pedidos Registrados | Panadería &amp; Cafetería Danilo</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,800;1,400&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../styles.css">
    <style>
        .admin-page {
            background-color: #f9f6f2;
            min-height: 100vh;
            padding: 2rem 1rem 4rem;
            color: #2c1a11;
        }
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 2rem;
            background: #ffffff;
            padding: 1.8rem 2.2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            border-left: 6px solid #c8914b;
        }
        .admin-title h1 {
            font-size: 1.6rem;
            color: #170b05;
            margin-bottom: 0.3rem;
        }
        .admin-title p {
            color: #7a6e65;
            font-size: 0.95rem;
        }
        .admin-actions {
            display: flex;
            gap: 0.8rem;
            flex-wrap: wrap;
        }
        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .status-pendiente { background: #ffeaa7; color: #d35400; }
        .status-en_preparacion { background: #dff9fb; color: #0984e3; }
        .status-entregado { background: #e8f8f5; color: #27ae60; }
        .status-cancelado { background: #fadbd8; color: #c0392b; }
        .db-status-bar {
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .db-online { background: #e8f8f5; color: #27ae60; border: 1px solid #a3e4d7; }
        .db-offline { background: #fef9e7; color: #b7950b; border: 1px solid #f9e79f; }
    </style>
</head>
<body class="admin-page">
    <div class="admin-container">
        
        <header class="admin-header">
            <div class="admin-title">
                <h1><i class="fa-solid fa-utensils"></i> Panadería y Cafetería Danilo &bull; Auditoría de Pedidos</h1>
                <p>Módulo de consulta backend PHP con consultas preparadas PDO en MySQL (Base de datos: <code>danilo_db</code>).</p>
            </div>
            <div class="admin-actions">
                <a href="../index.html" class="btn btn-hero-gold"><i class="fa-solid fa-house"></i> Ir al Inicio</a>
                <a href="../carta.html" class="btn btn-showcase"><i class="fa-solid fa-book-open"></i> Ver Carta</a>
            </div>
        </header>

        <?php if (!$error_conexion && $db_driver_active === 'mysql'): ?>
            <div class="db-status-bar db-online">
                <i class="fa-solid fa-circle-check"></i> Conexión activa a MySQL (Base de datos <code>danilo_db</code> vía PDO). Mostrando <?php echo count($pedidos); ?> registros.
            </div>
        <?php elseif (!$error_conexion && $db_driver_active === 'sqlite'): ?>
            <div class="db-status-bar db-online" style="background: #eaf2f8; color: #2980b9; border: 1px solid #aed6f1;">
                <i class="fa-solid fa-database"></i> Conexión activa a Base de Datos local (PDO SQLite <code>database/danilo.sqlite</code>). Mostrando <?php echo count($pedidos); ?> registros persistentes.
            </div>
        <?php else: ?>
            <div class="db-status-bar db-offline">
                <i class="fa-solid fa-triangle-exclamation"></i> Servidor de Base de Datos no detectado. Recuerda importar <code>database/danilo_db.sql</code> en phpMyAdmin si usas XAMPP.
            </div>
        <?php endif; ?>

        <div class="danilo-table-card">
            <h2 class="danilo-table-title"><i class="fa-solid fa-table-list"></i> Registro de Pedidos y Reservas de Clientes</h2>
            <p class="danilo-table-desc">Información persistida en tiempo real desde el formulario modal de la página principal.</p>

            <div class="table-responsive">
                <table class="danilo-table">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Cliente</th>
                            <th>Contacto</th>
                            <th>Tipo</th>
                            <th>Producto / Combo</th>
                            <th>Cant.</th>
                            <th>Fecha Entrega</th>
                            <th>Notas / Dirección</th>
                            <th>Estado</th>
                            <th>Fecha Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pedidos)): ?>
                            <?php foreach ($pedidos as $p): ?>
                                <tr>
                                    <td><strong>#<?php echo htmlspecialchars($p['id']); ?></strong></td>
                                    <td><strong><?php echo htmlspecialchars($p['nombre_cliente']); ?></strong></td>
                                    <td>
                                        <i class="fa-solid fa-envelope"></i> <?php echo htmlspecialchars($p['email']); ?><br>
                                        <i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars($p['telefono']); ?>
                                    </td>
                                    <td><span class="tag-highlight"><?php echo htmlspecialchars($p['tipo_pedido']); ?></span></td>
                                    <td><?php echo htmlspecialchars($p['producto_combo']); ?></td>
                                    <td><strong><?php echo htmlspecialchars($p['cantidad']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($p['fecha_entrega']); ?></td>
                                    <td><?php echo htmlspecialchars($p['direccion_notas'] ?: '-'); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo htmlspecialchars($p['estado']); ?>">
                                            <?php echo htmlspecialchars($p['estado']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($p['fecha_registro']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" style="text-align: center; padding: 2rem; color: #7a6e65;">
                                    <em>No hay registros de pedidos aún. Haz una prueba desde el botón "Hacer Pedido" en la página principal.</em>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
