-- ==============================================================================
-- Panadería y Cafetería Danilo - Chaclacayo, Lima - Perú
-- Script de Base de Datos MySQL (danilo_db.sql)
--
-- Asignatura: Taller de Programación Web (Unidades 13-15)
-- Docente: Ing. Hernán Francisco Peña Carnero
-- Estudiante: Paolo (Ingeniería de Sistemas e Informática / Software - UTP)
-- ==============================================================================

-- 1. Creación de la Base de Datos con codificación UTF-8 Multilingüe
CREATE DATABASE IF NOT EXISTS danilo_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE danilo_db;

-- ------------------------------------------------------------------------------
-- 2. Tabla: pedidos (Almacena los pedidos y reservas del formulario modal)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_cliente VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    tipo_pedido ENUM('delivery', 'recojo_local', 'reserva_mesa') DEFAULT 'delivery',
    producto_combo VARCHAR(150) NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    fecha_entrega DATE NOT NULL,
    direccion_notas TEXT NULL,
    estado ENUM('pendiente', 'en_preparacion', 'entregado', 'cancelado') DEFAULT 'pendiente',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_fecha_entrega (fecha_entrega),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 3. Tabla: mensajes_contacto (Almacena consultas y mensajes del cliente)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS mensajes_contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL,
    telefono VARCHAR(20) NULL,
    asunto VARCHAR(150) NOT NULL,
    mensaje TEXT NOT NULL,
    leido TINYINT(1) DEFAULT 0,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 4. Tabla: suscripciones (Almacena suscriptores del newsletter del footer)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS suscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(120) NOT NULL UNIQUE,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 5. Tabla: productos_catalogo (Catálogo de referencia de la carta)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS productos_catalogo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria ENUM('combos', 'platos', 'cafeteria', 'postres', 'bar') NOT NULL,
    nombre VARCHAR(120) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(8,2) NOT NULL,
    disponible TINYINT(1) DEFAULT 1,
    destacado TINYINT(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 6. Inserción de Datos Iniciales / Semilla de Prueba (Seed Data)
-- ------------------------------------------------------------------------------
INSERT INTO productos_catalogo (categoria, nombre, descripcion, precio, disponible, destacado) VALUES
('combos', 'El Familión', '1/2 kg de chicharrón criollo a la leña, camote frito, sarza criolla, 4 tamales y 10 panes.', 68.00, 1, 1),
('combos', 'Familión de Panceta', '1/2 kg de panceta crocante a la leña, camote frito, sarza criolla, 4 tamales y 10 panes.', 72.00, 1, 1),
('combos', 'Combo Pareja Criollo', '250 g de chicharrón, camote frito, sarza criolla, 2 tamalitos y 4 panes.', 38.00, 1, 0),
('platos', 'Sándwich de Chicharrón Danilo', 'Chicharrón a la leña, camote frito crujiente y sarza criolla en pan francés caliente.', 14.50, 1, 1),
('platos', 'Sándwich de Panceta Crocante', 'Panceta horneada a la leña con piel ultra crujiente y sarza especial.', 15.50, 1, 0),
('cafeteria', 'Café Americano Pasado', 'Café de estricta altura de Villa Rica y Chanchamayo recién pasado.', 7.00, 1, 1),
('cafeteria', 'Jugo Especial Danilo', 'Surtido de frutas del valle, leche evaporada, huevo, algarrobina y miel.', 13.00, 1, 1),
('postres', 'Torta de Chocolate Tradicional', 'Bizcocho húmedo de cacao cusqueño con abundante fudge artesanal de olla.', 11.50, 1, 1);

INSERT INTO pedidos (nombre_cliente, email, telefono, tipo_pedido, producto_combo, cantidad, fecha_entrega, direccion_notas, estado) VALUES
('Carlos Mendoza', 'carlos.mendoza@gmail.com', '987654321', 'delivery', 'El Familión', 1, CURDATE(), 'Av. Los Laureles 340, Chaclacayo. Tocar timbre 2.', 'en_preparacion'),
('María Elena Gómez', 'maria.gomez@hotmail.com', '954123876', 'recojo_local', 'Familión de Panceta', 1, CURDATE(), 'Recojo en local a las 09:30 a. m.', 'pendiente'),
('Jorge Valdivia', 'jorge.valdivia@outlook.com', '912345678', 'reserva_mesa', 'Desayuno Ejecutivo', 2, CURDATE(), 'Mesa para 2 en terraza frente a la plaza.', 'entregado');

INSERT INTO suscripciones (email) VALUES
('vecinos.chaclacayo@gmail.com'),
('cliente.frecuente@outlook.com');
