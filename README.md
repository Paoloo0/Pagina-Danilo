# 🥖 Panadería y Cafetería Danilo - Chaclacayo ☕

[![HTML5 Validation](https://img.shields.io/badge/HTML5-W3C%20Valid%20Semantics-E34F26?logo=html5&logoColor=white)](#)
[![CSS3 Responsive](https://img.shields.io/badge/CSS3-Flexbox%20%26%20Grid-1572B6?logo=css3&logoColor=white)](#)
[![JavaScript ES6+](https://img.shields.io/badge/JavaScript-Vanilla%20ES6%2B%20Modal-F7DF1E?logo=javascript&logoColor=black)](#)
[![PHP Backend](https://img.shields.io/badge/PHP-8.x%20PDO%20Backend-777BB4?logo=php&logoColor=white)](#)
[![MySQL Database](https://img.shields.io/badge/MySQL-danilo__db%20Prepared%20Statements-4479A1?logo=mysql&logoColor=white)](#)

Plataforma Web Oficial, Carta Digital Interactiva y Sistema de Pedidos Backend de la **Panadería y Cafetería Danilo**, emblemático negocio tradicional ubicado frente a la Plaza de Armas de **Chaclacayo, Lima - Perú**.

---

## 📋 Especificaciones Técnicas y Arquitectura del Sistema

| # | Módulo / Componente | Estándar Implementado | Descripción y Funcionalidad |
| :-: | :--- | :--- | :--- |
| **1** | **Estructura y Maquetación HTML5** | Estándar semántico W3C (`header`, `nav`, `main`, `section`, `article`, `footer`, `aside`, `table`). | 100% etiquetas semánticas nativas, menú fijo y responsive con enlaces activos y navegación cruzada completa. |
| **2** | **Estilos y Diseño con CSS3** | Tipografías e iconografía externa (**Google Fonts**, **Font Awesome 6**), Flexbox y CSS Grid. | Google Fonts (*Montserrat* y *Playfair Display*); Font Awesome 6.5.1 en íconos; breakpoints responsive en 1024px, 860px y 640px. |
| **3** | **Interactividad con JavaScript ES6+** | **Menú responsivo (hamburguesa)**, **Ventana flotante (modal)**, validación DOM y notificaciones Toast. | Menú accesible con ARIA; Ventana modal interactiva de Pedidos/Reservas con tecla `Esc` y backdrop; buscador en vivo en la carta. |
| **4** | **Backend con PHP 8.x** | Procesamiento asíncrono y tradicional con validación y sanitización estricta. | Controladores `backend/procesar_pedido.php` y `backend/procesar_contacto.php` con sanitización estricta (`htmlspecialchars`, `filter_var`) y respuesta JSON/HTML. |
| **5** | **Base de Datos Relacional** | Base de datos relacional (`danilo_db.sql`), sentencias preparadas PDO y fallback SQLite. | Script `danilo_db.sql` con tablas `pedidos`, `mensajes_contacto`, `suscripciones` y `productos_catalogo`. Conexión PDO con `prepare()` y `bindParam()`. |
| **6** | **Multimedia y Recursos** | Imágenes libres de copyright optimizadas y video institucional continuo. | Video de fondo MP4 en bucle continuo, póster de carga rápida y fotografías optimizadas en alta definición. |
| **7** | **Buenas Prácticas y Calidad** | Código limpio, modular, bien indentado y documentado. | Estructura modular: `backend/`, `database/`, `images/`, `videos/`, `index.html`, `carta.html`, `styles.css`, `script.js`. |
| **8** | **Presentación y Funcionalidad** | Experiencia de usuario completa e integración cliente-servidor fluida. | Flujo completo desde el frontend (botón/modal) hasta la persistencia en base de datos, con panel administrativo en `backend/ver_pedidos.php`. |
| **9** | **Seguridad del Sistema** | Protección contra **Inyección SQL** y ataques **XSS**. | `PDO::ATTR_EMULATE_PREPARES => false`, escape de cadenas con `ENT_QUOTES`, validación estricta de regex telefónico y email, restricción a métodos POST. |
| **10** | **Experiencia de Usuario (UX/UI)** | Búsqueda en tiempo real, modal interactivo y panel administrativo. | Buscador instantáneo con contador de platos, modal con autocompletado de producto, notificaciones Toast dinámicas y panel de auditoría. |

---

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
├── DEFENSA_Y_EXPOSICION.md      # Guión de sustentación y presentación del proyecto
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

## 📍 Ubicación y Contacto Comercial

* **Establecimiento:** Panadería y Cafetería Danilo
* **Ubicación:** Av. Nicolás Ayllón, frente a la Plaza de Armas de Chaclacayo, Lima - Perú.
* **Especialidades:** Chicharrones a la leña, café de altura, jugos naturales y pastelería tradicional.
* **Atención y Pedidos:** WhatsApp (+51) 953 877 620
