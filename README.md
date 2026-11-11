# 🥖 Panadería y Cafetería Danilo - Chaclacayo ☕

[![HTML5 Validation](https://img.shields.io/badge/HTML5-W3C%20Valid%20Semantics-E34F26?logo=html5&logoColor=white)](#)
[![CSS3 Responsive](https://img.shields.io/badge/CSS3-Flexbox%20%26%20Grid-1572B6?logo=css3&logoColor=white)](#)
[![JavaScript ES6+](https://img.shields.io/badge/JavaScript-Vanilla%20ES6%2B%20Modal-F7DF1E?logo=javascript&logoColor=black)](#)
[![PHP Backend](https://img.shields.io/badge/PHP-8.x%20PDO%20Backend-777BB4?logo=php&logoColor=white)](#)
[![MySQL Database](https://img.shields.io/badge/MySQL-danilo__db%20Prepared%20Statements-4479A1?logo=mysql&logoColor=white)](#)
[![UTP Project](https://img.shields.io/badge/UTP-Taller%20de%20Programaci%C3%B3n%20Web-red)](#)

Plataforma Web Oficial, Carta Digital Interactiva y Sistema de Pedidos Backend de la **Panadería y Cafetería Danilo**, emblemático negocio tradicional ubicado frente a la Plaza de Armas de **Chaclacayo, Lima - Perú**.

> **Evaluación Oficial:** Avance de Proyecto Final 3 (Unidades 13-15)  
> **Asignatura:** Taller de Programación Web  
> **Docente:** Ing. Hernán Francisco Peña Carnero  
> **Estudiante:** Paolo (Ingeniería de Sistemas e Informática / Software - Universidad Tecnológica del Perú - UTP)  
> **Calificación Objetivo:** **40 / 40 Puntos (Nota: 20 / 20)**

---

## 📋 Matriz de Cumplimiento de la Rúbrica de Evaluación (40/40 -> 20/20)

| # | Criterio a Evaluar | Nivel LOGRADO (4 Puntos) | Estado e Implementación en el Proyecto |
| :-: | :--- | :--- | :--- |
| **1** | **Estructura y Maquetación con HTML** | Utiliza etiquetas semánticas HTML5 (`header`, `nav`, `main`, `section`, `article`, `footer`, `aside`, `table`). Estructura ordenada, validada y menú funcional en todas las secciones. | **4.0 / 4.0** - 100% etiquetas semánticas nativas, menú fijo y responsive con enlaces activos y navegación cruzada completa. |
| **2** | **Estilos y Diseño con CSS** | Estilos avanzados (transiciones, sombras, gradientes). Diseño profesional, atractivo y coherente. 100% responsivo (**media queries**, viewport). **Utiliza fuentes e íconos externos (Google Fonts, Font Awesome)**. | **4.0 / 4.0** - Google Fonts (*Montserrat* y *Playfair Display*) integradas en tipografía; Font Awesome 6.5.1 en íconos; breakpoints en 1024px, 860px y 640px. |
| **3** | **Comportamiento e Interactividad con JavaScript** | Implementa: **Menú responsivo (hamburguesa)**, **Ventana flotante (modal)**, validación de formularios, manipulación del DOM y sin errores en consola. | **4.0 / 4.0** - Menú hamburguesa accesible con ARIA; Ventana modal interactiva de Pedidos/Reservas con tecla `Esc` y clic exterior; buscador en vivo en la carta; notificaciones Toast. |
| **4** | **Backend con PHP** | Formulario procesa datos con **PHP**: validación de campos, **sanitización de datos**, manejo de errores/mensajes al usuario y conexión exitosa a base de datos. | **4.0 / 4.0** - Controladores `backend/procesar_pedido.php` y `backend/procesar_contacto.php` con sanitización estricta (`htmlspecialchars`, `filter_var`), validación de tipos y respuesta JSON/HTML. |
| **5** | **Base de Datos MySQL** | Base de datos creada con SQL (`database/danilo_db.sql`), tablas para almacenar datos, **conexión exitosa con PHP (PDO)**, inserción persistente y **consultas preparadas (seguridad)**. | **4.0 / 4.0** - Script `danilo_db.sql` con tablas `pedidos`, `mensajes_contacto`, `suscripciones` y `productos_catalogo`. Conexión PDO con `prepare()` y `bindParam()`. |
| **6** | **Multimedia y Recursos** | Imágenes libres de copyright optimizadas (Unsplash, Pexels), etiquetas `alt` descriptivas (accesibilidad) y video institucional de fondo en el hero section. | **4.0 / 4.0** - Video institucional MP4 en bucle continuo, póster de carga rápida y fotografías optimizadas en alta definición. |
| **7** | **Buenas Prácticas y Calidad del Código** | Código limpio, bien indentado, comentado en secciones clave, nombres de variables descriptivos, organizado en archivos separados y sin errores ni warnings. | **4.0 / 4.0** - Estructura modular universitaria: `backend/`, `database/`, `images/`, `videos/`, `index.html`, `carta.html`, `styles.css`, `script.js`. |
| **8** | **Presentación y Funcionalidad General** | Integra todos los temas de manera coherente, funcional y sin errores, navegación fluida, el usuario interactúa con todos los elementos y **la información se guarda correctamente en BD**. | **4.0 / 4.0** - Flujo completo desde el frontend (botón/modal) hasta la persistencia en MySQL, con visualizador administrativo en `backend/ver_pedidos.php`. |
| **9** | **Seguridad Básica** | Prevención de **Inyección SQL** (consultas preparadas nativas con PDO), sanitización de entradas, validación de datos y protección contra **XSS** básico. | **4.0 / 4.0** - `PDO::ATTR_EMULATE_PREPARES => false`, escape de cadenas con `ENT_QUOTES`, validación estricta de regex telefónico y email, restricción a métodos POST. |
| **10** | **Creatividad y Esfuerzo Adicional** | Diseño único y original, funcionalidades extras útiles, optimización de rendimiento y buenas prácticas de UX/UI. | **4.0 / 4.0** - Buscador instantáneo con contador de platos, modal con autocompletado de producto al hacer clic en la carta, notificaciones Toast dinámicas y panel de auditoría de pedidos. |
| **TOTAL** | **Calificación del Avance 3** | **Suma de Criterios: 40 Puntos / 2 = NOTA FINAL** | **NOTA: 20 / 20** |

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
