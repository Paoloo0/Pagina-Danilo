<?php
/**
 * ==============================================================================
 * Panadería y Cafetería Danilo - Chaclacayo, Lima - Perú
 * Panel Administrativo: Registro de Pedidos y Reservas de Clientes
 * ==============================================================================
 */

session_start();
require_once __DIR__ . '/conexion.php';

// Manejo de Cierre de Sesión
if (isset($_GET['logout'])) {
    unset($_SESSION['admin_auth']);
    unset($_SESSION['admin_user']);
    session_destroy();
    header("Location: ver_pedidos.php");
    exit;
}

// Manejo de Inicio de Sesión
$login_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($usuario === 'registro' && $password === '123') {
        $_SESSION['admin_auth'] = true;
        $_SESSION['admin_user'] = 'registro';
        header("Location: ver_pedidos.php");
        exit;
    } else {
        $login_error = 'Usuario o contraseña incorrectos. Intente nuevamente.';
    }
}

// Si no está autenticado, mostrar formulario de Login
$is_authenticated = !empty($_SESSION['admin_auth']) && $_SESSION['admin_auth'] === true;

$pdo = getDBConnection();
$fecha_filtro = isset($_GET['fecha']) ? trim($_GET['fecha']) : '';
$flash_msg = '';

if (isset($_SESSION['flash_msg'])) {
    $flash_msg = $_SESSION['flash_msg'];
    unset($_SESSION['flash_msg']);
}

// Si está autenticado, procesar cambios de estado
if ($is_authenticated && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'cambiar_estado') {
    $pedido_id = (int)($_POST['pedido_id'] ?? 0);
    $nuevo_estado = trim($_POST['nuevo_estado'] ?? '');
    $estados_permitidos = ['pendiente', 'en_preparacion', 'entregado', 'cancelado'];

    if ($pedido_id > 0 && in_array($nuevo_estado, $estados_permitidos, true)) {
        if ($pdo) {
            try {
                $stmt_up = $pdo->prepare("UPDATE pedidos SET estado = :estado WHERE id = :id");
                $stmt_up->execute([
                    ':estado' => $nuevo_estado,
                    ':id'     => $pedido_id
                ]);
                $nombres_estados = [
                    'pendiente'      => '⏳ Pendiente',
                    'en_preparacion' => '👨‍🍳 En Preparación',
                    'entregado'      => '✅ Entregado',
                    'cancelado'      => '❌ Cancelado'
                ];
                $_SESSION['flash_msg'] = "Estado del pedido #{$pedido_id} actualizado a " . ($nombres_estados[$nuevo_estado] ?? $nuevo_estado) . " exitosamente.";
            } catch (PDOException $e) {
                $_SESSION['flash_msg'] = "Error al actualizar estado: " . $e->getMessage();
            }
        }
    }
    $redirect_url = 'ver_pedidos.php' . ($fecha_filtro ? '?fecha=' . urlencode($fecha_filtro) : '');
    header("Location: $redirect_url");
    exit;
}

// Consulta de pedidos si está autenticado
$pedidos = [];
$total_pedidos = 0;
$count_pendientes = 0;
$count_preparacion = 0;
$count_entregados = 0;
$count_cancelados = 0;

if ($is_authenticated && $pdo) {
    try {
        if (!empty($fecha_filtro)) {
            // Filtro por fecha (YYYY-MM-DD) usando LIKE compatible con SQLite y MySQL
            $stmt = $pdo->prepare("SELECT * FROM pedidos WHERE fecha_registro LIKE :f1 OR fecha_entrega LIKE :f2 ORDER BY id DESC");
            $pattern = $fecha_filtro . '%';
            $stmt->execute([':f1' => $pattern, ':f2' => $pattern]);
        } else {
            $stmt = $pdo->query("SELECT * FROM pedidos ORDER BY id DESC LIMIT 100");
        }
        $pedidos = $stmt->fetchAll();

        // Contadores
        $total_pedidos = count($pedidos);
        foreach ($pedidos as $p) {
            switch ($p['estado']) {
                case 'pendiente': $count_pendientes++; break;
                case 'en_preparacion': $count_preparacion++; break;
                case 'entregado': $count_entregados++; break;
                case 'cancelado': $count_cancelados++; break;
            }
        }
    } catch (PDOException $e) {
        $pedidos = [];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración • Pedidos | Danilo</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,800;1,400&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../styles.css">
    <style>
        :root {
            --danilo-dark: #170b05;
            --danilo-gold: #c8914b;
            --danilo-gold-light: #dfb278;
            --danilo-cream: #faf7f2;
            --danilo-border: #e6ded3;
        }
        body.admin-body {
            background-color: var(--danilo-cream);
            color: #2c1a11;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* LOGIN SCREEN STYLES */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background: radial-gradient(circle at top, #2b160a 0%, #170b05 100%);
        }
        .login-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.35);
            width: 100%;
            max-width: 440px;
            padding: 2.8rem 2.2rem;
            border-top: 6px solid var(--danilo-gold);
            text-align: center;
        }
        .login-logo {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--danilo-dark);
            margin-bottom: 0.2rem;
        }
        .login-sub {
            color: var(--danilo-gold);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 700;
            margin-bottom: 1.8rem;
        }
        .login-badge-info {
            background: #fdf5ea;
            border: 1px dashed var(--danilo-gold);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.6rem;
            font-size: 0.85rem;
            color: #6d4b24;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-align: left;
        }
        .login-form .form-group {
            text-align: left;
            margin-bottom: 1.3rem;
        }
        .login-form label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #4a3b32;
            margin-bottom: 0.4rem;
        }
        .login-form input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1.5px solid var(--danilo-border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.95rem;
            box-sizing: border-box;
            transition: all 0.2s ease;
        }
        .login-form input:focus {
            outline: none;
            border-color: var(--danilo-gold);
            box-shadow: 0 0 0 3px rgba(200, 145, 75, 0.15);
        }
        .btn-login {
            width: 100%;
            padding: 0.95rem;
            background: linear-gradient(135deg, var(--danilo-gold) 0%, #aa7332 100%);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(200, 145, 75, 0.35);
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(200, 145, 75, 0.45);
        }
        .login-back-link {
            display: inline-block;
            margin-top: 1.6rem;
            color: #8c7f76;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            transition: color 0.2s;
        }
        .login-back-link:hover {
            color: var(--danilo-gold);
        }
        .alert-error {
            background: #fde8e8;
            color: #c0392b;
            border: 1px solid #f8b4b4;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 1.3rem;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ADMIN DASHBOARD STYLES */
        .admin-nav {
            background: var(--danilo-dark);
            color: #ffffff;
            padding: 1rem 1.8rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            flex-wrap: wrap;
            gap: 1rem;
        }
        .admin-nav-brand {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            text-decoration: none;
            color: #ffffff;
        }
        .admin-nav-brand span.logo-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: #ffffff;
        }
        .admin-nav-brand span.badge-admin {
            background: var(--danilo-gold);
            color: #ffffff;
            font-size: 0.72rem;
            padding: 0.2rem 0.55rem;
            border-radius: 4px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .admin-nav-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .user-tag {
            background: rgba(255,255,255,0.1);
            padding: 0.4rem 0.85rem;
            border-radius: 20px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid rgba(255,255,255,0.15);
        }
        .btn-nav {
            padding: 0.45rem 0.9rem;
            border-radius: 6px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .btn-nav-public {
            background: rgba(255,255,255,0.08);
            color: #e5d8cc;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .btn-nav-public:hover {
            background: rgba(255,255,255,0.18);
            color: #ffffff;
        }
        .btn-nav-logout {
            background: #c0392b;
            color: #ffffff;
            border: none;
        }
        .btn-nav-logout:hover {
            background: #e74c3c;
        }

        .dashboard-container {
            max-width: 1350px;
            margin: 2rem auto;
            padding: 0 1.2rem 3rem;
        }

        .flash-alert {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 0.9rem 1.4rem;
            border-radius: 10px;
            margin-bottom: 1.8rem;
            display: flex;
            align-items: center;
            gap: 0.7rem;
            font-weight: 600;
            font-size: 0.92rem;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.12);
        }

        /* SECTION HEADER */
        .section-header-box {
            background: #ffffff;
            padding: 1.8rem 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.05);
            border-left: 6px solid var(--danilo-gold);
            margin-bottom: 1.8rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.2rem;
        }
        .section-header-box h1 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.7rem;
            color: var(--danilo-dark);
            margin: 0 0 0.3rem 0;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .section-header-box p {
            margin: 0;
            color: #7a6e65;
            font-size: 0.95rem;
        }

        /* FILTER & METRICS BAR */
        .toolbar-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1.5rem;
            align-items: center;
            background: #ffffff;
            padding: 1.3rem 1.8rem;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
            margin-bottom: 1.8rem;
        }
        @media (max-width: 900px) {
            .toolbar-grid {
                grid-template-columns: 1fr;
            }
        }
        .filter-form {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            flex-wrap: wrap;
        }
        .filter-form label {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--danilo-dark);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .filter-form input[type="date"] {
            padding: 0.55rem 0.9rem;
            border: 1.5px solid var(--danilo-border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.9rem;
            background: #ffffff;
            color: #2c1a11;
        }
        .btn-filter-submit {
            background: var(--danilo-gold);
            color: #ffffff;
            border: none;
            padding: 0.55rem 1.1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.88rem;
            cursor: pointer;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .btn-filter-submit:hover {
            background: #aa7332;
        }
        .btn-filter-reset {
            background: #f1eee9;
            color: #55483f;
            text-decoration: none;
            padding: 0.55rem 0.95rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .btn-filter-reset:hover {
            background: #e3ded5;
        }

        .metrics-chips {
            display: flex;
            gap: 0.7rem;
            flex-wrap: wrap;
        }
        .chip {
            padding: 0.45rem 0.85rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .chip-total { background: #f0f4f8; color: #1e3a8a; border: 1px solid #dbeafe; }
        .chip-pendiente { background: #fffbeb; color: #b45309; border: 1px solid #fef3c7; }
        .chip-preparacion { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .chip-entregado { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }

        /* TABLE CARD */
        .table-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            overflow: hidden;
            border: 1px solid var(--danilo-border);
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
        table.danilo-admin-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.88rem;
        }
        table.danilo-admin-table th {
            background: #f9f6f2;
            color: #53453c;
            padding: 1rem 1.1rem;
            font-weight: 700;
            border-bottom: 2px solid var(--danilo-border);
            white-space: nowrap;
        }
        table.danilo-admin-table td {
            padding: 1rem 1.1rem;
            border-bottom: 1px solid #f0eae1;
            vertical-align: middle;
            color: #33241b;
        }
        table.danilo-admin-table tr:hover {
            background: #fdfbf8;
        }

        .badge-pedido-tipo {
            display: inline-block;
            padding: 0.25rem 0.65rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            background: #fef3c7;
            color: #92400e;
        }
        .badge-pedido-combo {
            font-weight: 600;
            color: var(--danilo-dark);
        }

        /* STATUS SELECTOR */
        .select-estado-wrapper {
            display: inline-block;
        }
        .select-estado {
            font-family: inherit;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 0.45rem 0.75rem;
            border-radius: 20px;
            border: 1.5px solid transparent;
            cursor: pointer;
            outline: none;
            transition: all 0.2s ease;
        }
        .select-estado.estado-pendiente {
            background: #fff3cd;
            color: #856404;
            border-color: #ffeeba;
        }
        .select-estado.estado-en_preparacion {
            background: #d1ecf1;
            color: #0c5460;
            border-color: #bee5eb;
        }
        .select-estado.estado-entregado {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        .select-estado.estado-cancelado {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
        .select-estado:hover, .select-estado:focus {
            box-shadow: 0 0 0 3px rgba(0,0,0,0.08);
        }

        .empty-state {
            text-align: center;
            padding: 3.5rem 1rem;
            color: #8c7f76;
        }
        .empty-state i {
            font-size: 2.8rem;
            color: #dfb278;
            margin-bottom: 0.8rem;
        }
        .empty-state h3 {
            font-size: 1.15rem;
            color: var(--danilo-dark);
            margin: 0 0 0.4rem 0;
        }
    </style>
</head>
<body class="admin-body">

<?php if (!$is_authenticated): ?>
    <!-- PANTALLA DE INICIO DE SESIÓN -->
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-logo"><i class="fa-solid fa-bread-slice" style="color: var(--danilo-gold);"></i> Danilo</div>
            <div class="login-sub">Panadería &bull; Cafetería &bull; Chaclacayo</div>

            <?php if (!empty($login_error)): ?>
                <div class="alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?php echo htmlspecialchars($login_error); ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="ver_pedidos.php" class="login-form">
                <input type="hidden" name="action" value="login">
                
                <div class="form-group">
                    <label for="usuario"><i class="fa-solid fa-user"></i> Usuario</label>
                    <input type="text" id="usuario" name="usuario" required autocomplete="username" autofocus>
                </div>

                <div class="form-group">
                    <label for="password"><i class="fa-solid fa-key"></i> Contraseña</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password">
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Iniciar Sesión
                </button>
            </form>

            <a href="../index.html" class="login-back-link">
                <i class="fa-solid fa-arrow-left"></i> Volver a la página principal
            </a>
        </div>
    </div>

<?php else: ?>
    <!-- PANEL DE ADMINISTRACIÓN AUTENTICADO -->
    <nav class="admin-nav">
        <a href="ver_pedidos.php" class="admin-nav-brand">
            <i class="fa-solid fa-utensils" style="color: var(--danilo-gold);"></i>
            <span class="logo-title">Danilo</span>
            <span class="badge-admin">Gestión</span>
        </a>

        <div class="admin-nav-user">
            <span class="user-tag">
                <i class="fa-solid fa-circle-user" style="color: var(--danilo-gold);"></i>
                <strong>Usuario:</strong> <?php echo htmlspecialchars($_SESSION['admin_user'] ?? 'registro'); ?>
            </span>
            <a href="../index.html" target="_blank" class="btn-nav btn-nav-public">
                <i class="fa-solid fa-globe"></i> Ver Web
            </a>
            <a href="ver_pedidos.php?logout=1" class="btn-nav btn-nav-logout">
                <i class="fa-solid fa-power-off"></i> Cerrar Sesión
            </a>
        </div>
    </nav>

    <div class="dashboard-container">

        <?php if (!empty($flash_msg)): ?>
            <div class="flash-alert">
                <i class="fa-solid fa-circle-check"></i>
                <span><?php echo htmlspecialchars($flash_msg); ?></span>
            </div>
        <?php endif; ?>

        <!-- ENCABEZADO DE LA SECCIÓN SOLICITADO -->
        <div class="section-header-box">
            <div>
                <h1><i class="fa-solid fa-clipboard-list" style="color: var(--danilo-gold);"></i> Registro de Pedidos y Reservas de Clientes</h1>
                <p>Consulte pedidos en tiempo real, actualice el estado operativo y consulte el historial diario.</p>
            </div>
        </div>

        <!-- BARRA DE FILTRADO POR DÍA Y CONTADORES -->
        <div class="toolbar-grid">
            <form method="GET" action="ver_pedidos.php" class="filter-form">
                <label for="fecha_input">
                    <i class="fa-solid fa-calendar-days" style="color: var(--danilo-gold);"></i> Historial por día:
                </label>
                <input type="date" id="fecha_input" name="fecha" value="<?php echo htmlspecialchars($fecha_filtro); ?>">
                <button type="submit" class="btn-filter-submit">
                    <i class="fa-solid fa-filter"></i> Filtrar
                </button>
                <?php if (!empty($fecha_filtro)): ?>
                    <a href="ver_pedidos.php" class="btn-filter-reset">
                        <i class="fa-solid fa-rotate-left"></i> Ver Todos
                    </a>
                <?php endif; ?>
            </form>

            <div class="metrics-chips">
                <span class="chip chip-total">
                    <i class="fa-solid fa-list-check"></i> Total: <?php echo $total_pedidos; ?>
                </span>
                <span class="chip chip-pendiente">
                    <i class="fa-solid fa-clock"></i> Pendientes: <?php echo $count_pendientes; ?>
                </span>
                <span class="chip chip-preparacion">
                    <i class="fa-solid fa-kitchen-set"></i> Preparación: <?php echo $count_preparacion; ?>
                </span>
                <span class="chip chip-entregado">
                    <i class="fa-solid fa-check-double"></i> Entregados: <?php echo $count_entregados; ?>
                </span>
            </div>
        </div>

        <!-- TABLA DE PEDIDOS -->
        <div class="table-card">
            <div class="table-responsive">
                <table class="danilo-admin-table">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Fecha Pedido</th>
                            <th>Cliente</th>
                            <th>Contacto</th>
                            <th>Tipo</th>
                            <th>Producto / Combo</th>
                            <th>Cant.</th>
                            <th>Fecha Entrega</th>
                            <th>Dirección / Notas</th>
                            <th style="min-width: 170px;">Modificar Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pedidos)): ?>
                            <?php foreach ($pedidos as $p): ?>
                                <tr>
                                    <td><strong>#<?php echo htmlspecialchars($p['id']); ?></strong></td>
                                    <td>
                                        <small style="color: #6c5a4e; font-weight: 500;">
                                            <?php echo htmlspecialchars(substr($p['fecha_registro'], 0, 16)); ?>
                                        </small>
                                    </td>
                                    <td><strong><?php echo htmlspecialchars($p['nombre_cliente']); ?></strong></td>
                                    <td>
                                        <div><i class="fa-solid fa-phone" style="color: var(--danilo-gold);"></i> <strong><?php echo htmlspecialchars($p['telefono']); ?></strong></div>
                                        <small style="color: #7a6e65;"><i class="fa-solid fa-envelope"></i> <?php echo htmlspecialchars($p['email']); ?></small>
                                    </td>
                                    <td>
                                        <span class="badge-pedido-tipo"><?php echo htmlspecialchars($p['tipo_pedido']); ?></span>
                                    </td>
                                    <td>
                                        <span class="badge-pedido-combo"><?php echo htmlspecialchars($p['producto_combo']); ?></span>
                                    </td>
                                    <td>
                                        <strong style="font-size: 1rem; color: var(--danilo-dark);">x<?php echo htmlspecialchars($p['cantidad']); ?></strong>
                                    </td>
                                    <td>
                                        <i class="fa-regular fa-calendar-check" style="color: #27ae60;"></i>
                                        <?php echo htmlspecialchars($p['fecha_entrega']); ?>
                                    </td>
                                    <td style="max-width: 220px; font-size: 0.85rem; color: #55443a;">
                                        <?php echo htmlspecialchars($p['direccion_notas'] ?: '-'); ?>
                                    </td>
                                    <td>
                                        <!-- FORMULARIO INLINE PARA MODIFICAR ESTADO DEL PEDIDO -->
                                        <form method="POST" action="ver_pedidos.php<?php echo !empty($fecha_filtro) ? '?fecha=' . urlencode($fecha_filtro) : ''; ?>" class="select-estado-wrapper">
                                            <input type="hidden" name="action" value="cambiar_estado">
                                            <input type="hidden" name="pedido_id" value="<?php echo htmlspecialchars($p['id']); ?>">
                                            <select name="nuevo_estado" onchange="this.form.submit()" class="select-estado estado-<?php echo htmlspecialchars($p['estado']); ?>" title="Haga clic para cambiar el estado del pedido">
                                                <option value="pendiente" <?php echo $p['estado'] === 'pendiente' ? 'selected' : ''; ?>>⏳ Pendiente</option>
                                                <option value="en_preparacion" <?php echo $p['estado'] === 'en_preparacion' ? 'selected' : ''; ?>>👨‍🍳 En Preparación</option>
                                                <option value="entregado" <?php echo $p['estado'] === 'entregado' ? 'selected' : ''; ?>>✅ Entregado</option>
                                                <option value="cancelado" <?php echo $p['estado'] === 'cancelado' ? 'selected' : ''; ?>>❌ Cancelado</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10">
                                    <div class="empty-state">
                                        <i class="fa-solid fa-clipboard-question"></i>
                                        <h3>No se encontraron pedidos</h3>
                                        <p>
                                            <?php if (!empty($fecha_filtro)): ?>
                                                No hay pedidos registrados para la fecha seleccionada (<strong><?php echo htmlspecialchars($fecha_filtro); ?></strong>).
                                                <br><a href="ver_pedidos.php" style="color: var(--danilo-gold); font-weight: 600; margin-top: 0.5rem; display: inline-block;">Ver todo el historial</a>
                                            <?php else: ?>
                                                Aún no se han registrado pedidos en el sistema. Realice una prueba desde el formulario público.
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
<?php endif; ?>

</body>
</html>
