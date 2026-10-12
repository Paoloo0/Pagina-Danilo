/**
 * ==============================================================================
 * Panadería y Cafetería Danilo - Chaclacayo, Lima - Perú
 * Script Principal (script.js)
 * 
 * Proyecto: Página Web Corporativa y Carta Oficial
 * Curso: Programación Web / Desarrollo de Aplicaciones Web
 * Nivel: 5to Ciclo - Ingeniería de Sistemas e Informática / Software (UTP)
 * ==============================================================================
 * 
 * Contenido del Módulo:
 *  1. Inicialización y Modo Estricto
 *  2. Navegación Móvil Accesible (Hamburger Menu + ARIA)
 *  3. Efecto Dinámico de Cabecera al Hacer Scroll (Navbar Scrolled)
 *  4. Sistema de Notificaciones Toast Accesible (Feedback UX)
 *  5. Validación y Envío Dinámico del Formulario Newsletter
 *  6. Filtro en Tiempo Real y Búsqueda Interactiva (carta.html)
 *  7. Botón Accesible "Volver Arriba" (Scroll to Top)
 *  8. Firma y Diagnóstico en Consola de Desarrollador
 * ==============================================================================
 */

"use strict";

document.addEventListener("DOMContentLoaded", () => {
    initMobileNav();
    initNavbarScroll();
    initNewsletterForm();
    initMenuSearchAndFilter();
    initScrollToTop();
    initConsoleBranding();
});

/**
 * ------------------------------------------------------------------------------
 * 1. NAVEGACIÓN MÓVIL ACCESIBLE (HAMBURGER MENU)
 * Gestiona la apertura y cierre del menú en dispositivos móviles actualizando
 * los estados ARIA para lectores de pantalla y accesibilidad (WCAG 2.1).
 * ------------------------------------------------------------------------------
 */
function initMobileNav() {
    const toggleBtn = document.querySelector(".mobile-menu-btn");
    const navMenu = document.querySelector(".nav-menu");

    if (!toggleBtn || !navMenu) return;

    /**
     * Alterna la visibilidad del menú móvil y el estado aria-expanded
     */
    const toggleMenu = () => {
        const isExpanded = toggleBtn.getAttribute("aria-expanded") === "true";
        toggleBtn.setAttribute("aria-expanded", String(!isExpanded));
        navMenu.classList.toggle("is-active");
        document.body.classList.toggle("nav-open");
    };

    /**
     * Cierra el menú móvil de forma segura
     */
    const closeMenu = () => {
        toggleBtn.setAttribute("aria-expanded", "false");
        navMenu.classList.remove("is-active");
        document.body.classList.remove("nav-open");
    };

    toggleBtn.addEventListener("click", toggleMenu);

    // Cierra el menú al hacer clic en cualquier enlace de navegación
    const navLinks = navMenu.querySelectorAll("a");
    navLinks.forEach((link) => {
        link.addEventListener("click", () => {
            if (navMenu.classList.contains("is-active")) {
                closeMenu();
            }
        });
    });

    // Cierra el menú con la tecla Escape
    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && navMenu.classList.contains("is-active")) {
            closeMenu();
            toggleBtn.focus();
        }
    });

    // Cierra el menú al hacer clic fuera del contenedor
    document.addEventListener("click", (event) => {
        if (
            navMenu.classList.contains("is-active") &&
            !navMenu.contains(event.target) &&
            !toggleBtn.contains(event.target)
        ) {
            closeMenu();
        }
    });
}

/**
 * ------------------------------------------------------------------------------
 * 2. EFECTO DINÁMICO DE CABECERA AL HACER SCROLL
 * Añade una clase cuando el usuario hace scroll hacia abajo para activar un fondo
 * translúcido con desenfoque (backdrop-filter) y sombra de elevación.
 * ------------------------------------------------------------------------------
 */
function initNavbarScroll() {
    const header = document.querySelector(".navbar-fixed");
    if (!header) return;

    const onScroll = () => {
        if (window.scrollY > 40) {
            header.classList.add("navbar-scrolled");
        } else {
            header.classList.remove("navbar-scrolled");
        }
    };

    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll(); // Verificación inicial al cargar
}

/**
 * ------------------------------------------------------------------------------
 * 3. SISTEMA DE NOTIFICACIONES TOAST (FEEDBACK ACCESIBLE)
 * Muestra alertas visuales y accesibles para feedback de formularios y acciones.
 * 
 * @param {string} message - Texto descriptivo del mensaje.
 * @param {string} [type='success'] - Tipo de notificación: 'success', 'error', 'info'.
 * @param {number} [duration=4000] - Tiempo en milisegundos antes de ocultarse.
 * ------------------------------------------------------------------------------
 */
function showToast(message, type = "success", duration = 4000) {
    let container = document.getElementById("toast-container");

    if (!container) {
        container = document.createElement("div");
        container.id = "toast-container";
        container.className = "toast-container";
        container.setAttribute("role", "status");
        container.setAttribute("aria-live", "polite");
        document.body.appendChild(container);
    }

    const toast = document.createElement("div");
    toast.className = `toast-item toast-${type}`;
    toast.setAttribute("role", "alert");

    // Icono contextual según el tipo
    const icon = type === "success" ? "✓" : type === "error" ? "✕" : "ℹ";

    toast.innerHTML = `
        <span class="toast-icon" aria-hidden="true">${icon}</span>
        <span class="toast-text">${message}</span>
        <button type="button" class="toast-close" aria-label="Cerrar notificación">&times;</button>
    `;

    container.appendChild(toast);

    // Animación de entrada
    requestAnimationFrame(() => {
        toast.classList.add("is-visible");
    });

    const removeToast = () => {
        toast.classList.remove("is-visible");
        toast.addEventListener("transitionend", () => {
            if (toast.parentElement) {
                toast.remove();
            }
        });
    };

    // Botón de cerrar manual
    const closeBtn = toast.querySelector(".toast-close");
    if (closeBtn) {
        closeBtn.addEventListener("click", removeToast);
    }

    // Temporizador de auto-cierre
    setTimeout(removeToast, duration);
}

/**
 * ------------------------------------------------------------------------------
 * 4. VALIDACIÓN Y ENVÍO DINÁMICO DEL FORMULARIO NEWSLETTER
 * Valida el correo mediante expresión regular estricta, previene recarga y
 * brinda feedback inmediato cumpliendo la rúbrica de UX e Interactividad.
 * ------------------------------------------------------------------------------
 */
function initNewsletterForm() {
    const form = document.getElementById("newsletter-form");
    const input = document.getElementById("newsletter-email");

    if (!form || !input) return;

    form.addEventListener("submit", (event) => {
        event.preventDefault();

        const emailValue = input.value.trim();
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (!emailValue) {
            showToast("Por favor, ingresa tu correo electrónico.", "error");
            input.focus();
            input.classList.add("input-error");
            return;
        }

        if (!emailRegex.test(emailValue)) {
            showToast("Por favor, ingresa un correo electrónico válido (ej. usuario@gmail.com).", "error");
            input.focus();
            input.classList.add("input-error");
            return;
        }

        // Éxito: Simulación de suscripción corporativa
        input.classList.remove("input-error");
        input.value = "";
        showToast("¡Gracias por unirte a la familia Danilo! Recibirás nuestras novedades y promociones de Chaclacayo.", "success", 5000);
    });

    // Limpia el estado de error al escribir
    input.addEventListener("input", () => {
        if (input.classList.contains("input-error")) {
            input.classList.remove("input-error");
        }
    });
}

/**
 * ------------------------------------------------------------------------------
 * 5. BÚSQUEDA EN TIEMPO REAL Y FILTRO INTERACTIVO (CARTA.HTML)
 * Permite buscar productos por nombre o descripción al instante sin recarga,
 * además de filtrar interactivamente por categoría con contador de resultados.
 * ------------------------------------------------------------------------------
 */
function initMenuSearchAndFilter() {
    const searchInput = document.getElementById("menu-search-input");
    const dishes = document.querySelectorAll(".dish-card");
    const counterEl = document.getElementById("search-results-counter");
    const emptyState = document.getElementById("search-empty-state");
    const catPills = document.querySelectorAll(".cat-filter-btn");

    // Si no estamos en carta.html o no existen los elementos, salir limpiamente
    if (!dishes.length) return;

    let activeCategory = "all";

    /**
     * Aplica el filtro combinado de texto y categoría
     */
    const filterDishes = () => {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : "";
        let visibleCount = 0;

        dishes.forEach((dish) => {
            const nameEl = dish.querySelector(".dish-name");
            const descEl = dish.querySelector(".dish-ingredients, .dish-desc, p");
            const dishCategory = dish.dataset.category || "all";

            const nameText = nameEl ? nameEl.textContent.toLowerCase() : "";
            const descText = descEl ? descEl.textContent.toLowerCase() : "";

            const matchesText = !query || nameText.includes(query) || descText.includes(query);
            const matchesCategory = activeCategory === "all" || dishCategory === activeCategory;

            if (matchesText && matchesCategory) {
                dish.classList.remove("dish-hidden");
                visibleCount++;
            } else {
                dish.classList.add("dish-hidden");
            }
        });

        // Ocultar o mostrar secciones de categoría vacías
        const categorySections = document.querySelectorAll(".menu-category-section");
        categorySections.forEach((section) => {
            const visibleInSec = section.querySelectorAll(".dish-card:not(.dish-hidden)").length;
            if (visibleInSec === 0 && (query || activeCategory !== "all")) {
                section.classList.add("section-hidden");
            } else {
                section.classList.remove("section-hidden");
            }
        });

        // Actualizar contador accesible
        if (counterEl) {
            if (query || activeCategory !== "all") {
                counterEl.textContent = `Mostrando ${visibleCount} producto${visibleCount === 1 ? "" : "s"}`;
                counterEl.classList.remove("hidden");
            } else {
                counterEl.classList.add("hidden");
            }
        }

        // Mostrar estado vacío si no hay coincidencias
        if (emptyState) {
            if (visibleCount === 0) {
                emptyState.classList.remove("hidden");
            } else {
                emptyState.classList.add("hidden");
            }
        }
    };

    // Búsqueda en tiempo real con debounce
    if (searchInput) {
        let debounceTimer;
        searchInput.addEventListener("input", () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(filterDishes, 150);
        });

        // Limpiar búsqueda con tecla Escape
        searchInput.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                searchInput.value = "";
                filterDishes();
            }
        });
    }

    // Botones de filtro por categoría
    if (catPills.length) {
        catPills.forEach((pill) => {
            pill.addEventListener("click", (e) => {
                e.preventDefault();
                catPills.forEach((p) => p.classList.remove("active"));
                pill.classList.add("active");
                activeCategory = pill.dataset.category || "all";
                filterDishes();
            });
        });
    }
}

/**
 * ------------------------------------------------------------------------------
 * 6. BOTÓN ACCESIBLE "VOLVER ARRIBA" (SCROLL TO TOP)
 * Muestra un botón flotante cuando el usuario baja en la página y permite
 * volver suavemente a la parte superior con un solo clic.
 * ------------------------------------------------------------------------------
 */
function initScrollToTop() {
    const scrollBtn = document.getElementById("scroll-top-btn");
    if (!scrollBtn) return;

    window.addEventListener("scroll", () => {
        if (window.scrollY > 350) {
            scrollBtn.classList.add("is-visible");
        } else {
            scrollBtn.classList.remove("is-visible");
        }
    }, { passive: true });

    scrollBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
}

/**
 * ------------------------------------------------------------------------------
 * 7. FIRMA Y DIAGNÓSTICO EN CONSOLA (ESTÁNDAR UTP)
 * Imprime un banner corporativo en DevTools con información técnica del proyecto.
 * ------------------------------------------------------------------------------
 */
function initConsoleBranding() {
    const brandStyle = "background: #23120a; color: #c8914b; font-size: 14px; font-weight: bold; padding: 6px 12px; border-radius: 4px; border: 1px solid #c8914b;";
    const subStyle = "color: #5d483c; font-size: 11px;";
    
    console.log("%c🥖 Panadería & Cafetería Danilo - Chaclacayo", brandStyle);
    console.log("%cSitio Web Oficial desarrollado con HTML5, CSS3 y JavaScript ES6+ (UTP 5to Ciclo).", subStyle);
}
