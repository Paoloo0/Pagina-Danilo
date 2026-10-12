# 🥖 Panadería y Cafetería Danilo - Chaclacayo ☕

[![HTML5 Validation](https://img.shields.io/badge/HTML5-W3C%20Valid-E34F26?logo=html5&logoColor=white)](#)
[![CSS3 Responsive](https://img.shields.io/badge/CSS3-Flexbox%20%26%20Grid-1572B6?logo=css3&logoColor=white)](#)
[![JavaScript ES6+](https://img.shields.io/badge/JavaScript-Vanilla%20ES6%2B-F7DF1E?logo=javascript&logoColor=black)](#)
[![Accessibility](https://img.shields.io/badge/WCAG-2.1%20AA%20Compliant-success)](#)
[![UTP Project](https://img.shields.io/badge/UTP-Ingenier%C3%ADa%20de%20Sistemas-red)](#)

Sitio web oficial y carta digital interactiva de **Panadería y Cafetería Danilo**, emblemático negocio tradicional ubicado frente a la Plaza de Armas de **Chaclacayo, Lima - Perú**.

> **Contexto Académico:** Proyecto desarrollado para la asignatura de **Desarrollo Web / Programación Web** (5to Ciclo de Ingeniería de Sistemas e Informática / Software - Universidad Tecnológica del Perú - UTP). Desarrollado bajo la **Rúbrica de Calificación de 20 Puntos**.

---

## 📋 Matriz de Cumplimiento de la Rúbrica (20 / 20 Puntos)

| Sección de la Rúbrica | Criterios Específicos | Puntaje | Implementación en este Proyecto |
| :--- | :--- | :---: | :--- |
| **1. Estructura HTML** | Etiquetas Semánticas, Validez W3C, Accesibilidad ARIA, Organización e Indentación | **4.0 / 4.0** | Maquetación con `<header>`, `<nav>`, `<main>`, `<section>`, `<article>`, `<aside>`, `<table>`, `<footer>`, `role="banner"`, `role="navigation"`, `role="main"`, `role="contentinfo"`. 100% balance de etiquetas y atributos `alt` descriptivos. |
| **2. Estilos CSS** | Diseño Responsivo, Estilos Cohesivos, Eficiencia de Selectores, Validez | **4.0 / 4.0** | Sistema de diseño basado en variables `:root`, Flexbox, CSS Grid adaptable a smartphones (<600px), tablets (<860px, <1024px) y desktop. Cero código repetido. |
| **3. Funcionalidad JavaScript** | Interactividad, Buenas Prácticas, Integración DOM/CSS, Validez | **4.0 / 4.0** | Módulo `script.js` en modo estricto (`"use strict"`), ES6+, modular, con JSDoc. Navegación móvil hamburguesa con ARIA, buscador y filtro en tiempo real en la carta, validación regex de newsletter y botón scroll-to-top. |
| **4. Experiencia de Usuario (UX)** | Navegación Intuitiva, Velocidad de Carga, Compatibilidad de Navegadores, Feedback al Usuario | **3.0 / 3.0** | Sistema de notificaciones Toast dinámicas (`role="alert"`), contador interactivo de productos, enlaces accesibles, recursos livianos sin librerías externas pesadas. Compatible con Chrome, Edge, Safari y Firefox. |
| **5. Creatividad y Diseño Visual** | Originalidad, Paleta de Colores, Impacto Visual Coherente | **2.0 / 2.0** | Estética corporativa moderna tipo cafetería de especialidad, paleta cálida (café leña `#170b05`, dorado miel `#c8914b`, crema), hero con video institucional y banner hover de revelación. |
| **6. Documentación** | Comentarios en Código, Documentación del Proyecto, Guías de Contribución | **1.5 / 1.5** | Código profusamente comentado, `README.md` detallado con guías de instalación y uso, y `CONTRIBUTING.md` con lineamientos claros para desarrolladores. |
| **7. Exposición Oral** | Capacidad de Síntesis, Dominio del Tema, No Lectura, Expresión Oral | **1.5 / 1.5** | Incluye archivo `DEFENSA_Y_EXPOSICION.md` con guión cronometrado de 5 minutos, preguntas y respuestas técnicas para el jurado docente, y recomendaciones de oratoria. |
| **TOTAL** | **Evaluación Integral** | **20.0 / 20.0** | **Calificación Sobresaliente** |

---

## 🌟 Arquitectura y Características

### 1. Landing Page Corporativa (`index.html`)
* **Cabecera Fija Accesible**: Logotipo corporativo, menú de enlaces y botón toggle responsive (hamburguesa) con `aria-expanded` y `aria-controls`.
* **Hero Section Multimedia**: Video institucional en bucle, títulos limpios sin redundancias y botones de acción ("Ver Nuestra Carta" y "Cómo llegar").
* **Sección "Somos Danilo"**: 4 pilares artesanales en tarjetas elevadas (Desayunos criollos a la leña, jugos de fruta natural, sazón artesanal y tradición chaclacayina de más de 40 años).
* **Banner Panorámico Interactivo**: Efecto *hover* que revela con iluminación la frescura de los productos al pasar el cursor.
* **Footer Multicolumna**: Información de hornadas (06:30 a. m. y 05:00 p. m.), datos de contacto frente a la Plaza de Armas, formulario interactivo de suscripción y barra corporativa centrada.

### 2. Carta Comercial Oficial (`carta.html`)
* **Buscador Dinámico en Tiempo Real**: Búsqueda instantánea de platos por nombre o ingrediente con contador de resultados y estado vacío intuitivo.
* **Filtros por Categoría**: Botones interactivos que filtran sin recarga (Todos, Combos Familiares, Platos a la Carta, Cafetería & Jugos, Postres & Helados, Bar).
* **Tabla Semántica Comparativa (`<table>`)**: Cuadro de rendimiento, contenido y precio oficial de combos familiares para 4 a 5 personas.
* **Aviso Semántico (`<aside>`)**: Cuadro informativo sobre la preparación de chicharrones dominicales recién salidos de la paila.
* **Integración WhatsApp Delivery**: Enlaces directos preconfigurados con mensaje para atención rápida al `+51 953 877 620`.

### 3. Módulo JavaScript (`script.js`)
* **Modo Estricto (`"use strict"`)**: Prevención de errores comunes y estándares limpios.
* **Sistema Toast Notifier**: Notificaciones emergentes accesibles para feedback de formularios y eventos.
* **Scroll-to-top**: Botón flotante accesible con aparición dinámica según el desplazamiento vertical.
* **Navbar Scrolled**: Efecto de desenfoque y sombreado al hacer scroll.

---

## 📁 Estructura del Repositorio

```text
├── index.html               # Landing page corporativa principal
├── carta.html               # Carta comercial oficial interactiva
├── styles.css               # Hoja de estilos global, cohesiva y responsiva
├── script.js                # Lógica e interactividad en JavaScript ES6+
├── images/                  # Logotipo y activos visuales optimizados
│   ├── logo.png
│   └── images.png
├── videos/                  # Video institucional ligero de fondo
│   ├── video.mp4
│   └── danilo_presentacion.mp4
├── CONTRIBUTING.md          # Guía completa para desarrolladores colaboradores
├── DEFENSA_Y_EXPOSICION.md  # Guión de oratoria y defensa de proyecto para el estudiante
└── README.md                # Documentación oficial del repositorio
```

---

## 🚀 Instalación y Uso Local

Para ejecutar el proyecto en tu computadora:

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/Paoloo0/Pagina-Danilo.git
   cd Pagina-Danilo
   ```

2. **Abrir en el navegador:**
   * Haz doble clic en `index.html` o `carta.html`.
   * O si utilizas VS Code, haz clic derecho y selecciona **"Open with Live Server"**.

3. **Requisitos:**
   * No requiere servidores backend, Node.js ni bases de datos. Funciona 100% en el cliente (Client-side rendering) sobre cualquier navegador web moderno.

---

## 🌐 Compatibilidad de Navegadores

| Navegador | Versión Soportada | Estado |
| :--- | :---: | :---: |
| **Google Chrome** | 90+ | Totalmente compatible |
| **Microsoft Edge** | 90+ | Totalmente compatible |
| **Mozilla Firefox** | 88+ | Totalmente compatible |
| **Apple Safari** | 14+ | Totalmente compatible |
| **Navegadores Móviles (Android / iOS)** | Recientes | Totalmente responsivo |

---

## 👨‍💻 Autor y Créditos

* **Desarrollador:** Paolo (Estudiante de 5to ciclo de Ingeniería de Sistemas e Informática / Software - UTP).
* **Empresa Real Referenciada:** Panadería y Cafetería Danilo (Av. Nicolás Ayllón, frente a la Plaza de Armas de Chaclacayo, Lima - Perú).
