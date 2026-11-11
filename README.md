# 🥖 Panadería y Cafetería Danilo - Chaclacayo ☕

[![HTML5 Validation](https://img.shields.io/badge/HTML5-W3C%20Valid%20Semantics-E34F26?logo=html5&logoColor=white)](#)
[![CSS3 Responsive](https://img.shields.io/badge/CSS3-Flexbox%20%26%20Grid-1572B6?logo=css3&logoColor=white)](#)
[![JavaScript ES6+](https://img.shields.io/badge/JavaScript-Vanilla%20ES6%2B%20Modal-F7DF1E?logo=javascript&logoColor=black)](#)
[![PHP Backend](https://img.shields.io/badge/PHP-8.x%20PDO%20Backend-777BB4?logo=php&logoColor=white)](#)
[![MySQL Database](https://img.shields.io/badge/MySQL-danilo__db%20Prepared%20Statements-4479A1?logo=mysql&logoColor=white)](#)
[![UTP Project](https://img.shields.io/badge/UTP-Taller%20de%20Programaci%C3%B3n%20Web-red)](#)


## 🛠️ Arquitectura y Estructura del Proyecto

```text
├── index.html                   # Landing page corporativa principal
├── carta.html                   # Carta comercial oficial interactiva
├── styles.css                   # Hoja de estilos CSS3 global con Google Fonts y Font Awesome
├── script.js                    # Interactividad Vanilla JS (Modal, Buscador, Toast, Menú)
├── backend/                     # Capa de Lógica y Servidor Backend PHP
│   ├── conexion.php             # Conexión segura PDO a MySQL con manejo de excepciones
│   ├── procesar_pedido.php      # Controlador que valida, sanitiza y guarda pedidos en BD
│   ├── procesar_contacto.php    # Controlador de suscripciones y mensajes de contacto
│   └── ver_pedidos.php          # Panel administrativo para auditar los registros en la BD
├── database/                    # Base de Datos Relacional MySQL
│   └── danilo_db.sql            # Script SQL completo de creación de BD, tablas y datos semilla
├── images/                      # Logotipos y recursos visuales
│   └── logo.png
├── videos/                      # Videos institucionales para el Hero Section
│   └── video.mp4
├── CONTRIBUTING.md              # Guía de contribución para desarrolladores colaboradores
├── DEFENSA_Y_EXPOSICION.md      # Guión de sustentación oral ante el Ing. Peña Carnero
└── README.md                    # Documentación oficial del repositorio
```

---

## 🚀 Guía de Instalación y Puesta en Marcha Local (XAMPP / Laragon)

Para ejecutar el proyecto con su funcionalidad completa (Frontend + Backend PHP + MySQL):

### Paso 1: Configurar el Servidor Local
1. Instala e inicia **XAMPP** o **Laragon** activando los servicios de **Apache** y **MySQL**.
2. Copia la carpeta del proyecto dentro del directorio web:
   * En XAMPP: `C:\xampp\htdocs\Pagina-Danilo`
   * En Laragon: `C:\laragon\www\Pagina-Danilo`

### Paso 2: Importar la Base de Datos
1. Abre tu navegador y accede a phpMyAdmin (`http://localhost/phpmyadmin`).
2. Ve a la pestaña **Importar**.
3. Selecciona el archivo `database/danilo_db.sql` ubicado en la carpeta del proyecto y haz clic en **Importar**.
4. Se creará automáticamente la base de datos `danilo_db` con sus tablas e información de prueba.

### Paso 3: Abrir la Aplicación
1. Accede desde tu navegador a:
   * Página Principal: `http://localhost/Pagina-Danilo/index.html`
   * Carta Digital: `http://localhost/Pagina-Danilo/carta.html`
   * Panel de Auditoría de Base de Datos: `http://localhost/Pagina-Danilo/backend/ver_pedidos.php`

> **Nota para visualización estática:** Si abres los archivos directamente con doble clic o con la extensión *Live Server* de VS Code, el frontend (modal, buscador, estilos y diseño) funcionará fluidamente gracias a un mecanismo de fallback que detecta si el servidor PHP está desconectado.

---

## 👨‍💻 Autor y Asignatura

* **Estudiante:** Paolo (5to Ciclo de Ingeniería de Sistemas e Informática / Software - UTP).
* **Asignatura:** Taller de Programación Web (Unidades 13-15).
* **Docente Evaluador:** Ing. Hernán Francisco Peña Carnero.
* **Empresa Real:** Panadería y Cafetería Danilo (Av. Nicolás Ayllón, frente a la Plaza de Armas de Chaclacayo, Lima - Perú).
