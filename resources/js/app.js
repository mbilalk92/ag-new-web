import './bootstrap';

function qs(selector, root = document) {
    return root.querySelector(selector);
}

function qsa(selector, root = document) {
    return Array.from(root.querySelectorAll(selector));
}

// Mobile nav toggle
const menuToggle = qs('#menu-toggle');
const primaryNav = qs('#primary-nav');

if (menuToggle && primaryNav) {
    menuToggle.addEventListener('click', () => {
        const isOpen = primaryNav.classList.toggle('is-open');
        menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    // On mobile, tapping the "Occasions" trigger expands the submenu instead
    // of relying on hover, which doesn't exist on touch.
    qsa('.site-header__dropdown-trigger').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            if (window.innerWidth <= 860) {
                trigger.closest('.site-header__dropdown').classList.toggle('is-open');
            }
        });
    });
}

// Cart drawer
const cartDrawer = qs('#cart-drawer');
const cartTrigger = qs('.site-header__cart');
const cartClose = qs('#cart-drawer-close');

function openCartDrawer() {
    cartDrawer?.classList.add('is-open');
    cartDrawer?.setAttribute('aria-hidden', 'false');
}

function closeCartDrawer() {
    cartDrawer?.classList.remove('is-open');
    cartDrawer?.setAttribute('aria-hidden', 'true');
}

cartClose?.addEventListener('click', closeCartDrawer);
cartDrawer?.addEventListener('click', (event) => {
    if (event.target === cartDrawer) {
        closeCartDrawer();
    }
});

// Intercept "add to cart" forms so the drawer opens with the fresh cart
// state instead of a full page reload.
qsa('.add-to-cart-form').forEach((form) => {
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const submitButton = form.querySelector('button[type="submit"]');
        const originalLabel = submitButton?.textContent;
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Adding…';
        }

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { Accept: 'text/html' },
            });

            if (!response.ok) {
                throw new Error('Could not add to cart');
            }

            const html = await response.text();
            const doc = new DOMParser().parseFromString(html, 'text/html');

            const freshDrawer = doc.querySelector('#cart-drawer');
            if (freshDrawer && cartDrawer) {
                cartDrawer.innerHTML = freshDrawer.innerHTML;
            }

            const freshCount = doc.querySelector('[data-cart-count]');
            const countEl = qs('[data-cart-count]');
            if (freshCount && countEl) {
                countEl.textContent = freshCount.textContent;
            }

            openCartDrawer();
            bindCartDrawerClose();
        } catch (error) {
            form.submit();
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = originalLabel;
            }
        }
    });
});

function bindCartDrawerClose() {
    qs('#cart-drawer-close')?.addEventListener('click', closeCartDrawer);
}

// Checkout: reveal bank details only when bank transfer is selected
const paymentInputs = qsa('input[name="payment_method"]');
const bankDetails = qs('#bank-details');

function syncPaymentFields() {
    const selected = paymentInputs.find((input) => input.checked);
    if (!bankDetails) return;
    bankDetails.hidden = !selected || selected.value !== 'bank_transfer';
}

paymentInputs.forEach((input) => input.addEventListener('change', syncPaymentFields));
syncPaymentFields();

// Sizing: toggle between a standard size and custom measurements
qsa('[data-sizing]').forEach((container) => {
    const standardBlock = qs('[data-standard-sizing]', container);
    const customBlock = qs('[data-custom-sizing]', container);
    const modeInput = qs('[data-sizing-mode]', container);
    const toggles = qsa('[data-sizing-toggle]', container);

    if (!modeInput || (!standardBlock && !customBlock)) return;

    function setMode(mode) {
        modeInput.value = mode;

        if (standardBlock) {
            standardBlock.hidden = mode !== 'standard';
            qsa('input', standardBlock).forEach((input) => {
                input.disabled = mode !== 'standard';
                input.required = mode === 'standard';
            });
        }

        if (customBlock) {
            customBlock.hidden = mode !== 'custom';
            qsa('input', customBlock).forEach((input) => {
                input.disabled = mode !== 'custom';
            });
        }
    }

    toggles.forEach((toggle) => {
        toggle.addEventListener('click', () => {
            setMode(modeInput.value === 'standard' ? 'custom' : 'standard');
        });
    });
});

// Lightbox: click any [data-lightbox-group] element to open a full-screen
// viewer that can navigate to the other items sharing its group name.
const lightbox = qs('#lightbox');
const lightboxImage = qs('#lightbox-image');
const lightboxCaption = qs('#lightbox-caption');
const lightboxCounter = qs('#lightbox-counter');
let lightboxItems = [];
let lightboxIndex = 0;

function renderLightbox() {
    const item = lightboxItems[lightboxIndex];
    if (!item || !lightboxImage) return;
    lightboxImage.src = item.src;
    lightboxImage.alt = item.alt || '';
    if (lightboxCaption) lightboxCaption.textContent = item.alt || '';
    if (lightboxCounter) {
        lightboxCounter.textContent = lightboxItems.length > 1 ? `${lightboxIndex + 1} / ${lightboxItems.length}` : '';
    }
}

function openLightbox(items, startIndex) {
    if (!lightbox || !items.length) return;
    lightboxItems = items;
    lightboxIndex = startIndex;
    renderLightbox();
    lightbox.classList.add('is-open');
    lightbox.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    if (!lightbox) return;
    lightbox.classList.remove('is-open');
    lightbox.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
}

function stepLightbox(delta) {
    if (!lightboxItems.length) return;
    lightboxIndex = (lightboxIndex + delta + lightboxItems.length) % lightboxItems.length;
    renderLightbox();
}

qs('#lightbox-close')?.addEventListener('click', closeLightbox);
qs('#lightbox-prev')?.addEventListener('click', () => stepLightbox(-1));
qs('#lightbox-next')?.addEventListener('click', () => stepLightbox(1));
lightbox?.addEventListener('click', (event) => {
    if (event.target === lightbox) closeLightbox();
});
document.addEventListener('keydown', (event) => {
    if (!lightbox?.classList.contains('is-open')) return;
    if (event.key === 'Escape') closeLightbox();
    if (event.key === 'ArrowLeft') stepLightbox(-1);
    if (event.key === 'ArrowRight') stepLightbox(1);
});

qsa('[data-lightbox-group]').forEach((trigger) => {
    trigger.style.cursor = 'pointer';
    trigger.addEventListener('click', () => {
        const group = trigger.dataset.lightboxGroup;
        const groupEls = qsa(`[data-lightbox-group="${group}"]`);
        const items = groupEls.map((el) => ({ src: el.dataset.lightboxSrc, alt: el.dataset.lightboxAlt || '' }));
        openLightbox(items, groupEls.indexOf(trigger));
    });
});

// Product/bundle gallery: open the lightbox from the main image, navigating
// through whichever photo is currently swapped in via the thumbnails.
qsa('[data-gallery-main]').forEach((mainImage) => {
    mainImage.style.cursor = 'zoom-in';
    mainImage.addEventListener('click', () => {
        const thumbs = qsa('.product-gallery__thumb img');
        const items = thumbs.length
            ? thumbs.map((img) => ({ src: img.src, alt: img.alt }))
            : [{ src: mainImage.src, alt: mainImage.alt }];
        const startIndex = Math.max(0, items.findIndex((item) => item.src === mainImage.src));
        openLightbox(items, startIndex);
    });
});

// Hover zoom on the main product/bundle image: scale toward the cursor.
qsa('[data-zoom-container]').forEach((container) => {
    const img = qs('img', container);
    if (!img) return;

    container.addEventListener('mousemove', (event) => {
        const rect = container.getBoundingClientRect();
        const x = ((event.clientX - rect.left) / rect.width) * 100;
        const y = ((event.clientY - rect.top) / rect.height) * 100;
        img.style.transformOrigin = `${x}% ${y}%`;
    });

    container.addEventListener('mouseleave', () => {
        img.style.transformOrigin = 'center center';
    });
});

// Product gallery thumbnail swap
const galleryMain = qs('#gallery-main');
qsa('.product-gallery__thumb').forEach((thumb) => {
    thumb.addEventListener('click', () => {
        if (galleryMain) {
            galleryMain.src = thumb.dataset.src;
        }
    });
});
