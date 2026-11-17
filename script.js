/**
 * ==============================================================================
 * Panadería y Cafetería Danilo - Chaclacayo, Lima - Perú
 * Script Principal de Interactividad y Backend (script.js)
 * ==============================================================================
 */

"use strict";

document.addEventListener("DOMContentLoaded", () => {
    initMobileNav();
    initNavbarScroll();
    initOrderModal();
    initNewsletterForm();
    initMenuSearchAndFilter();
    initScrollToTop();
    initConsoleBranding();
});

/**
 * ------------------------------------------------------------------------------
 * 1. NAVEGACIÓN MÓVIL ACCESIBLE (HAMBURGER MENU)
 * Controla apertura/cierre del menú en smartphones con atributos ARIA y teclado.
 * ------------------------------------------------------------------------------
 */
function initMobileNav() {
    const toggleBtn = document.querySelector(".mobile-menu-btn");
    const navMenu = document.querySelector(".nav-menu");

    if (!toggleBtn || !navMenu) return;

    const toggleMenu = () => {
        const isExpanded = toggleBtn.getAttribute("aria-expanded") === "true";
        toggleBtn.setAttribute("aria-expanded", String(!isExpanded));
        navMenu.classList.toggle("is-active");
        document.body.classList.toggle("nav-open");
    };

    const closeMenu = () => {
        toggleBtn.setAttribute("aria-expanded", "false");
        navMenu.classList.remove("is-active");
        document.body.classList.remove("nav-open");
    };

    toggleBtn.addEventListener("click", toggleMenu);

    // Cierre al presionar enlaces del menú
    const navLinks = navMenu.querySelectorAll("a, button");
    navLinks.forEach((link) => {
        link.addEventListener("click", () => {
            if (navMenu.classList.contains("is-active")) {
                closeMenu();
            }
        });
    });

    // Accesibilidad: Cierre con tecla Escape
    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && navMenu.classList.contains("is-active")) {
            closeMenu();
            toggleBtn.focus();
        }
    });

    // Cierre al hacer clic fuera del menú
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
 * Agrega sombra y desenfoque a la barra superior al desplazarse en la página.
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
    onScroll();
}

/**
 * ------------------------------------------------------------------------------
 * 3. VENTANA FLOTANTE (MODAL): HACER PEDIDO / RESERVA ONLINE
 * - Apertura accesible desde botones nav/carta
 * - Cierre con botón X, tecla Escape o clic en backdrop
 * - Envío asíncrono con Fetch API a backend/procesar_pedido.php
 * ------------------------------------------------------------------------------
 */
function initOrderModal() {
    const modal = document.getElementById("order-modal");
    const openButtons = document.querySelectorAll("[data-open-modal]");
    const closeButtons = document.querySelectorAll("[data-close-modal]");
    const orderForm = document.getElementById("order-form");
    const productoInput = document.getElementById("order-producto");
    const fechaInput = document.getElementById("order-fecha");
    const submitBtn = document.getElementById("btn-submit-order");

    if (!modal) return;

    // Establecer fecha mínima como hoy
    if (fechaInput) {
        const today = new Date().toISOString().split("T")[0];
        fechaInput.min = today;
        if (!fechaInput.value) {
            fechaInput.value = today;
        }
    }

    /**
     * Abre el modal y enfoca el primer campo
     * @param {string} [productName=''] - Nombre del plato a preseleccionar
     */
    const openModal = (productName = "") => {
        modal.classList.add("is-active");
        modal.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden";

        if (productoInput && productName) {
            productoInput.value = productName;
        }

        const firstInput = modal.querySelector("input:not([type='hidden']), select");
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 150);
        }
    };

    /**
     * Cierra el modal de forma segura
     */
    const closeModal = () => {
        modal.classList.remove("is-active");
        modal.setAttribute("aria-hidden", "true");
        document.body.style.overflow = "";
    };

    // Listeners de apertura
    openButtons.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const productName = btn.getAttribute("data-product-name") || "";
            openModal(productName);
        });
    });

    // Listeners de cierre
    closeButtons.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            closeModal();
        });
    });

    // Cierre al hacer clic en el backdrop
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Cierre con tecla Escape
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && modal.classList.contains("is-active")) {
            closeModal();
        }
    });

    // Procesamiento y Validación del Formulario de Pedido (AJAX a PHP)
    if (orderForm) {
        orderForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const nombreInput = document.getElementById("order-nombre");
            const telefonoInput = document.getElementById("order-telefono");
            const emailInput = document.getElementById("order-email");

            // Validación del lado del cliente
            if (!nombreInput.value.trim() || nombreInput.value.trim().length < 3) {
                showToast("Por favor, ingresa tu nombre completo (mínimo 3 letras).", "error");
                nombreInput.focus();
                nombreInput.classList.add("input-error");
                return;
            }

            const phoneRegex = /^[0-9+ ]{7,15}$/;
            if (!phoneRegex.test(telefonoInput.value.trim())) {
                showToast("Por favor, ingresa un teléfono o WhatsApp válido (7 a 15 dígitos).", "error");
                telefonoInput.focus();
                telefonoInput.classList.add("input-error");
                return;
            }

            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test(emailInput.value.trim())) {
                showToast("Por favor, ingresa un correo electrónico válido.", "error");
                emailInput.focus();
                emailInput.classList.add("input-error");
                return;
            }

            // Estado de carga en botón
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Registrando en Sistema...`;
            }

            // Recopilar datos del formulario
            const formData = new FormData(orderForm);

            // Determinar la URL del endpoint (si se abrió como archivo local file://, apunta a localhost:8000)
            const backendEndpoint = (window.location.protocol === "file:")
                ? "http://localhost:8000/backend/procesar_pedido.php"
                : "backend/procesar_pedido.php";

            const viewEndpoint = (window.location.protocol === "file:")
                ? "http://localhost:8000/backend/ver_pedidos.php"
                : "backend/ver_pedidos.php";

            try {
                const response = await fetch(backendEndpoint, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                });

                const result = await response.json();

                if (result.success) {
                    showToast(
                        `${result.message} <br><a href="${viewEndpoint}" target="_blank" style="display:inline-block; margin-top:8px; padding:6px 12px; background:#c8914b; color:#fff; border-radius:4px; text-decoration:none; font-weight:700; font-size:0.85rem;"><i class="fa-solid fa-table-list"></i> Ver pedido en el Panel Backend &rarr;</a>`,
                        "success",
                        10000
                    );
                    orderForm.reset();
                    setTimeout(() => {
                        closeModal();
                    }, 2200);
                } else {
                    showToast(result.message || "Error al procesar el pedido.", "error");
                }
            } catch (error) {
                console.error("Error al procesar pedido:", error);
                showToast(
                    `⚠️ No se pudo conectar con el servidor backend (${error.message}). Recuerda abrir desde <strong>http://localhost:8000/index.html</strong>`,
                    "error",
                    8000
                );
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = `<span class="btn-text"><i class="fa-solid fa-paper-plane"></i> Confirmar Pedido en Sistema</span>`;
                }
            }
        });

        // Limpiar errores visuales al escribir
        orderForm.querySelectorAll(".form-control").forEach((input) => {
            input.addEventListener("input", () => {
                input.classList.remove("input-error");
            });
        });
    }
}

/**
 * ------------------------------------------------------------------------------
 * 4. SISTEMA DE NOTIFICACIONES TOAST (FEEDBACK ACCESIBLE)
 * ------------------------------------------------------------------------------
 */
function showToast(message, type = "success", duration = 4500) {
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

    const icon = type === "success" ? "✓" : type === "error" ? "✕" : "ℹ";

    toast.innerHTML = `
        <span class="toast-icon" aria-hidden="true">${icon}</span>
        <span class="toast-text">${message}</span>
        <button type="button" class="toast-close" aria-label="Cerrar notificación">&times;</button>
    `;

    container.appendChild(toast);

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

    const closeBtn = toast.querySelector(".toast-close");
    if (closeBtn) {
        closeBtn.addEventListener("click", removeToast);
    }

    setTimeout(removeToast, duration);
}

/**
 * ------------------------------------------------------------------------------
 * 5. VALIDACIÓN Y ENVÍO DEL NEWSLETTER (CONEXIÓN A BACKEND)
 * ------------------------------------------------------------------------------
 */
function initNewsletterForm() {
    const form = document.getElementById("newsletter-form");
    const input = document.getElementById("newsletter-email");

    if (!form || !input) return;

    form.addEventListener("submit", async (event) => {
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
            showToast("Por favor, ingresa un correo electrónico válido.", "error");
            input.focus();
            input.classList.add("input-error");
            return;
        }

        input.classList.remove("input-error");

        try {
            const response = await fetch("backend/procesar_contacto.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    accion: "newsletter",
                    email: emailValue
                })
            });

            const result = await response.json();
            if (result.success) {
                showToast(result.message, "success", 5000);
                input.value = "";
            } else {
                showToast(result.message, "error");
            }
        } catch (error) {
            // Demostración sin servidor activo
            showToast("¡Gracias por unirte a la familia Danilo! Recibirás nuestras novedades y promociones de Chaclacayo.", "success", 5000);
            input.value = "";
        }
    });

    input.addEventListener("input", () => {
        input.classList.remove("input-error");
    });
}

/**
 * ------------------------------------------------------------------------------
 * 6. BÚSQUEDA EN TIEMPO REAL Y FILTRO INTERACTIVO (CARTA.HTML)
 * ------------------------------------------------------------------------------
 */
function initMenuSearchAndFilter() {
    const searchInput = document.getElementById("menu-search-input");
    const dishes = document.querySelectorAll(".dish-card");
    const counterEl = document.getElementById("search-results-counter");
    const emptyState = document.getElementById("search-empty-state");
    const catPills = document.querySelectorAll(".cat-filter-btn");

    if (!dishes.length) return;

    // Vincular cada botón de plato con el modal para autocompletar el plato
    dishes.forEach((dish) => {
        const dishNameEl = dish.querySelector(".dish-name");
        const dishName = dishNameEl ? dishNameEl.textContent.trim() : "";
        const orderLink = dish.querySelector(".dish-order-link");

        if (orderLink && dishName) {
            orderLink.setAttribute("data-open-modal", "true");
            orderLink.setAttribute("data-product-name", dishName);
            orderLink.setAttribute("href", "#order-modal");
            orderLink.innerHTML = `<i class="fa-solid fa-cart-plus"></i> Pedir Combo &rarr;`;
        }
    });

    let activeCategory = "all";

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

        const categorySections = document.querySelectorAll(".menu-category-section");
        categorySections.forEach((section) => {
            const visibleInSec = section.querySelectorAll(".dish-card:not(.dish-hidden)").length;
            if (visibleInSec === 0 && (query || activeCategory !== "all")) {
                section.classList.add("section-hidden");
            } else {
                section.classList.remove("section-hidden");
            }
        });

        if (counterEl) {
            if (query || activeCategory !== "all") {
                counterEl.textContent = `Mostrando ${visibleCount} producto${visibleCount === 1 ? "" : "s"}`;
                counterEl.classList.remove("hidden");
            } else {
                counterEl.classList.add("hidden");
            }
        }

        if (emptyState) {
            if (visibleCount === 0) {
                emptyState.classList.remove("hidden");
            } else {
                emptyState.classList.add("hidden");
            }
        }
    };

    if (searchInput) {
        let debounceTimer;
        searchInput.addEventListener("input", () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(filterDishes, 150);
        });

        searchInput.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                searchInput.value = "";
                filterDishes();
            }
        });
    }

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
 * 7. BOTÓN ACCESIBLE "VOLVER ARRIBA" (SCROLL TO TOP)
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
 * 8. FIRMA Y DIAGNÓSTICO EN CONSOLA (ESTÁNDAR UTP)
 * ------------------------------------------------------------------------------
 */
function initConsoleBranding() {
    const brandStyle = "background: #23120a; color: #c8914b; font-size: 14px; font-weight: bold; padding: 6px 12px; border-radius: 4px; border: 1px solid #c8914b;";
    const subStyle = "color: #5d483c; font-size: 11px;";
    
    console.log("%c🥖 Panadería & Cafetería Danilo - Chaclacayo", brandStyle);
    console.log("%cProyecto Web Final: HTML5, CSS3, JavaScript ES6+, PHP Backend & MySQL PDO (UTP 5to Ciclo).", subStyle);
}
