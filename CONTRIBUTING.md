# 🤝 Guía de Contribución para Desarrolladores (CONTRIBUTING.md)

¡Bienvenido al proyecto de **Panadería y Cafetería Danilo**! Esta guía proporciona instrucciones claras, directrices de código y buenas prácticas para cualquier desarrollador que desee colaborar, mantener o extender esta aplicación web.

---

## 🛠️ 1. Flujo de Trabajo con Git (Git Workflow)

Para mantener el repositorio organizado y evitar conflictos en la rama `main`:

1. **Crear una bifurcación (Fork) o clonar el repositorio:**
   ```bash
   git clone https://github.com/Paoloo0/Pagina-Danilo.git
   cd Pagina-Danilo
   ```

2. **Crear una rama temática descriptiva:**
   Utiliza nombres de ramas en inglés o español según el tipo de cambio:
   * Nuevas funcionalidades: `feature/nombre-de-la-mejora` (ej. `feature/filtro-precios`)
   * Corrección de errores: `fix/descripcion-del-bug` (ej. `fix/alineacion-footer-movil`)
   * Documentación: `docs/actualizacion-manual`

   ```bash
   git checkout -b feature/nuevo-combo-desayuno
   ```

3. **Estandarización de Commits (Conventional Commits):**
   Escribe mensajes de confirmación claros y concisos con prefijos convencionales:
   * `feat:` para nuevas características o componentes.
   * `fix:` para corrección de errores.
   * `docs:` para cambios exclusivos en documentación.
   * `style:` para formateo, espacios o ajustes visuales sin cambios de lógica.
   * `refactor:` para reorganización de código que no altera el comportamiento.

   *Ejemplo:*
   ```bash
   git commit -m "feat: agregar opcion de tamales vegetarianos en carta.html"
   ```

4. **Publicar y abrir un Pull Request:**
   ```bash
   git push origin feature/nuevo-combo-desayuno
   ```

---

## 📐 2. Estándares y Convenciones de Código

### A. Estándares de HTML5
* **Semántica Obligatoria:** Utiliza siempre la etiqueta con significado más preciso (`<header>`, `<nav>`, `<main>`, `<section>`, `<article>`, `<aside>`, `<table>`, `<footer>`, `<figure>`, `<address>`). Evita el uso indiscriminado de `<div>` ("divitis").
* **Accesibilidad (WCAG 2.1 AA):**
  * Todas las etiquetas `<img>` deben incluir un atributo `alt` descriptivo.
  * Los botones deben tener atributos `aria-label` si no contienen texto explícito.
  * Los campos de formulario deben estar asociados inequívocamente a un `<label for="...">`.
* **Indentación:** Utiliza 4 espacios de indentación. Mantén un código limpio y legible.

### B. Estándares de CSS3
* **Variables Globales:** Utiliza siempre los tokens de color y medidas definidos en `:root`:
  * `--color-dark-espresso`: Fondo oscuro corporativo.
  * `--color-gold`: Color de acento primario y botones.
  * `--color-cream`: Fondo claro para lectura.
* **Responsive Design:**
  * No uses valores fijos en píxeles para anchos de contenedores principales; utiliza porcentajes, `rem`, `max-width`, Flexbox y CSS Grid.
  * Ubica las media queries agrupadas al final del archivo o por componente.
* **Especificidad y Selectores:** Prefiere selectores de clase limpios (ej. `.dish-card`, `.nav-menu`). Evita el uso de `!important` salvo en utilidades universales como `.hidden`.

### C. Estándares de JavaScript (ES6+)
* **Modo Estricto:** Todo script debe ejecutarse bajo `"use strict";`.
* **Sintaxis Moderna:** Declara variables con `const` (inmutables) y `let` (mutables). No utilices `var`.
* **Documentación JSDoc:** Toda función debe contar con su bloque explicativo con `@param` y `@returns`.
* **Vanilla JS Puro:** No agregues librerías externas (jQuery, Bootstrap JS, Lodash) a menos que se justifique plenamente en el alcance del proyecto.

---

## 🍲 3. ¿Cómo agregar un nuevo plato a `carta.html`?

Para agregar un nuevo producto a la carta garantizando que el buscador y el filtro funcionen de inmediato:

1. Localiza la sección correspondiente (ej. `#combos`, `#platos`, `#cafeteria`, `#postres`, `#bar`).
2. Agrega la tarjeta siguiendo la siguiente plantilla HTML:

```html
<article class="dish-card" data-category="platos">
    <div class="dish-header">
        <h3 class="dish-name">Nombre del Plato</h3>
        <span class="dish-price">S/ 00.00</span>
    </div>
    <p class="dish-ingredients">
        Descripción detallada de los ingredientes frescos y preparación artesanal.
    </p>
    <div class="dish-footer">
        <span class="dish-yield">Porción individual</span>
        <a href="https://wa.me/51953877620?text=Hola%20Danilo,%20deseo%20pedir%20este%20plato" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="dish-order-link">
            Pedir por WhatsApp &rarr;
        </a>
    </div>
</article>
```
*Importante:* Asegúrate de que el atributo `data-category` coincida exactamente con la categoría de la sección (`combos`, `platos`, `cafeteria`, `postres`, `bar`).

---

## ✅ 4. Lista de Verificación (Checklist) antes de Enviar Cambios

Antes de solicitar la integración de tus cambios a la rama principal:

- [ ] ¿El archivo HTML pasa la validación sin errores ni etiquetas desbalanceadas?
- [ ] ¿La interfaz se adapta fluidamente tanto en pantallas móviles (<400px) como en pantallas de escritorio (>1200px)?
- [ ] ¿La consola del navegador (F12) está libre de advertencias o errores de JavaScript?
- [ ] ¿El formulario de newsletter sigue validando y mostrando la notificación Toast?
- [ ] ¿El buscador y los filtros de la carta continúan funcionando correctamente?
- [ ] ¿Todo el código nuevo está debidamente comentado y formateado?

---

¡Gracias por contribuir a mantener el estándar de excelencia universitaria y profesional de Panadería Danilo!
