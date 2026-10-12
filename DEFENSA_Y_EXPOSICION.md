# 🎤 Guía de Exposición Oral y Defensa de Proyecto (Rúbrica: 1.5 Puntos)

Esta guía ha sido diseñada para que el estudiante de 5to ciclo de Ingeniería de Sistemas y Software domine la sustentación del proyecto ante el docente o jurado evaluador, garantizando el máximo puntaje en los 4 criterios de **Exposición Oral**:

1. **Capacidad de Síntesis (0.50 pt)**: Explicación concisa y estructurada en 5 minutos.
2. **Dominio del Tema (0.50 pt)**: Seguridad técnica y argumentación de decisiones de ingeniería.
3. **No Lectura de Diapositivas (0.25 pt)**: Ideas fuerza nemotécnicas para hablar con naturalidad.
4. **Expresión Oral (0.25 pt)**: Postura, tono de voz, modulación y terminología profesional.

---

## ⏱️ 1. Estructura de la Presentación (Cronograma de 5 Minutos)

### Minuto 0:00 - 0:45 | Introducción y Contexto Real
> *"Buenos días, profesor y compañeros. Mi nombre es Paolo, estudiante de 5to ciclo de Ingeniería de Sistemas e Informática de la UTP. Hoy presento el desarrollo de la plataforma web corporativa y carta digital oficial de la **Panadería y Cafetería Danilo**, un negocio gastronómico con más de cuatro décadas de tradición ubicado frente a la Plaza de Armas de Chaclacayo."*
>
> *"El objetivo del proyecto fue diseñar una solución web moderna, de alto impacto visual y rendimiento óptimo, maquetada 100% bajo estándares semánticos HTML5, arquitectura responsive con CSS3 Grid y Flexbox, y una capa de interactividad nativa en Vanilla JavaScript ES6+ sin librerías externas."*

---

### Minuto 0:45 - 2:00 | Arquitectura Técnica y Cumplimiento de Rúbrica
> *"A nivel de arquitectura técnica, el proyecto se divide en dos módulos principales:*
>
> 1. *La **Landing Page Corporativa (`index.html`)**: Diseñada con una estructura semántica rigurosa (`<header>`, `<nav>`, `<main>`, `<section>`, `<article>`, `<footer>`). Cuenta con una cabecera fija inteligente con menú hamburguesa accesible mediante atributos ARIA (`aria-expanded` y `aria-controls`), un Hero Section multimedia con video institucional de fondo en bucle, la sección de pilares artesanales 'Somos Danilo', un banner panorámico interactivo con revelación por hover y un pie de página multicolumna.*
>
> 2. *La **Carta Comercial Interactiva (`carta.html`)**: Estructura la carta real del negocio en categorías comerciales. Incorpora una tabla semántica comparativa (`<table>`) para combos familiares con `<caption>`, `<thead>`, `<tbody>` y celdas con `scope`, así como un bloque `<aside>` para avisos de fin de semana.*
>
> 3. *En **CSS3 (`styles.css`)**: Implementamos un sistema de diseño con variables globales en `:root` para asegurar cohesión cromática basada en café espresso y dorado leña, garantizando accesibilidad y contraste WCAG AA. La responsividad se resolvió con media queries en breakpoints estratégicos (1024px, 860px y 600px).*

---

### Minuto 2:00 - 3:30 | Demostración en Vivo e Interactividad JavaScript
*(Aquí compartes pantalla y demuestras las funciones en vivo)*
> *"En la capa de JavaScript (`script.js`), aplicamos programación modular bajo `"use strict"` y buenas prácticas de ingeniería:*
>
> * **Buscador en Tiempo Real**: En la carta, al escribir cualquier término como 'chicharrón' o 'café', el DOM se filtra de forma instantánea sin recarga de página, informando al usuario a través de un contador dinámico de coincidencias.*
> * **Filtros por Categoría**: Los botones superiores filtran instantáneamente los platos utilizando atributos `data-category`.*
> * **Validación de Formularios y Feedback UX**: El formulario de suscripción valida el correo mediante una expresión regular estricta. Si el formato es erróneo, produce una microanimación de error; si es correcto, dispara un sistema propio de notificaciones Toast accesibles con `role="alert"` y temporizador de auto-cierre.*
> * **Efectos de Scroll**: La barra de navegación detecta el desplazamiento vertical para aplicar desenfoque y sombra de elevación, y activa el botón flotante 'Volver Arriba' para mejorar la usabilidad.*

---

### Minuto 3:30 - 4:30 | Conclusiones y Retos Superados
> *"Los principales retos superados fueron:*
> 1. *Lograr una experiencia de usuario fluida y reactiva prescindiendo de frameworks pesados como React o jQuery, manteniendo un peso ligero y velocidad de carga ultrarrápida.*
> 2. *Garantizar accesibilidad universal para personas que utilizan lectores de pantalla o navegación por teclado.*
> 3. *Documentar el repositorio en GitHub con un `README.md` exhaustivo y un `CONTRIBUTING.md` con guías claras para otros desarrolladores."*

---

### Minuto 4:30 - 5:00 | Cierre y Apertura a Preguntas
> *"Con esto concluyo la exposición de la plataforma web de Panadería y Cafetería Danilo, quedando a su disposición para cualquier consulta técnica sobre el código o la implementación. Muchas gracias."*

---

## 💡 2. Puntos Clave para NO Leer Diapositivas (Ideas Fuerza)

En lugar de leer texto, mantén en mente estas 4 ideas fuerza:

1. **Semántica y Accesibilidad:**
   * "Usamos etiquetas HTML5 nativas porque aportan significado a los motores de búsqueda (SEO) y a los lectores de pantalla."
   * "Evitamos la 'divitis' estructurando el contenido en `section`, `article`, `header`, `nav`, `aside` y `table`."

2. **Diseño Modular y Responsivo:**
   * "El CSS está centralizado mediante variables de color, Flexbox para ejes unidimensionales y CSS Grid para la grilla de productos."
   * "Es 100% responsivo, adaptándose desde teléfonos pequeños hasta pantallas 4K."

3. **Vanilla JS Eficiente:**
   * "No necesitamos librerías externas de 500 KB para un buscador o un menú. Vanilla JS nativo garantiza 100 de puntuación en rendimiento y compatibilidad universal."

4. **Feedback de Usuario (UX):**
   * "Toda acción del usuario tiene una respuesta visual clara: estados hover, animaciones de error al tipear y notificaciones toast de confirmación."

---

## ❓ 3. Banco de Preguntas y Respuestas Frecuentes del Jurado

### P1: ¿Por qué decidiste usar Vanilla JavaScript en lugar de un framework como React o una librería como jQuery?
> **Respuesta:** *"Como ingenieros de software, debemos aplicar la herramienta adecuada para el alcance del problema. Para una landing page corporativa y carta digital, un framework SPA introduce sobrecarga innecesaria de bundle size, complejidad de build steps y lentitud en la carga inicial. Vanilla JavaScript ES6+ nos ofrece control total del DOM, compatibilidad nativa en el 100% de los navegadores y una velocidad de respuesta instantánea con cero dependencias."*

### P2: ¿Cómo garantizaste la accesibilidad web en tu proyecto?
> **Respuesta:** *"Nos guiamos por las pautas WCAG 2.1 nivel AA: todas las imágenes cuentan con atributos `alt` descriptivos; los elementos interactivos como el menú hamburguesa manipulan dinámicamente el atributo `aria-expanded` para avisar a los lectores de pantalla; los mensajes Toast utilizan `role="status"` y `aria-live="polite"`; y los contrastes de color entre el texto y el fondo superan la relación mínima de 4.5:1."*

### P3: ¿Cómo interactúa el buscador de la carta con el DOM?
> **Respuesta:** *"El buscador escucha el evento `input` del campo de búsqueda con una función de debounce para optimizar el rendimiento. Recorre las tarjetas `.dish-card`, compara el texto con el nombre y los ingredientes, y aplica la clase `.dish-hidden` vía CSS (`display: none !important`), actualizando simultáneamente el contador accesible de resultados visibles."*

### P4: ¿Cómo organizaste el código CSS para que no fuera redundante?
> **Respuesta:** *"Declaramos una capa base con variables en `:root` para colores, fuentes, radios de borde y transiciones. Luego maquetamos componentes reutilizables como `.btn`, `.feature-card` y `.dish-card`. Esto evita duplicar código y permite que cualquier cambio de marca o color se realice en una sola línea."*

---

## 👔 4. Recomendaciones de Expresión Oral y Lenguaje Corporal

* **Postura:** Mantén la espalda erguida y los hombros relajados. Si expones de pie, apoya ambos pies con firmeza. Si expones sentado frente a la cámara web, mantén el encuadre centrado a la altura de los ojos.
* **Mirada:** Mira directamente a la cámara o a los ojos de los evaluadores, no te quedes mirando fijamente el código o la pantalla.
* **Tono y Ritmo:** Habla pausado, con voz firme y segura. Haz pausas de 1 segundo entre ideas para que el jurado asimile la información técnica.
* **Uso del puntero/mouse:** Cuando menciones el código o la página web, señala con el cursor exactamente la función o el bloque que estás describiendo para guiar la atención del docente.
