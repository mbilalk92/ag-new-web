import './bootstrap';

function qs(selector, root = document) {
    return root.querySelector(selector);
}

function qsa(selector, root = document) {
    return Array.from(root.querySelectorAll(selector));
}

// Header: swap to a frosted-glass fill once the page scrolls past the top,
// so the bar reads as flat chrome at rest and lifts off the page once it's
// sitting over content.
const siteHeader = qs('.site-header');
if (siteHeader) {
    const updateHeaderScrollState = () => {
        siteHeader.classList.toggle('is-scrolled', window.scrollY > 8);
    };
    updateHeaderScrollState();
    window.addEventListener('scroll', updateHeaderScrollState, { passive: true });
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
const cartClose = qs('#cart-drawer-close');

function openCartDrawer() {
    cartDrawer?.classList.add('is-open');
    cartDrawer?.setAttribute('aria-hidden', 'false');
}

function closeCartDrawer() {
    cartDrawer?.classList.remove('is-open');
    cartDrawer?.setAttribute('aria-hidden', 'true');
}

function bindCartDrawerClose() {
    qs('#cart-drawer-close')?.addEventListener('click', closeCartDrawer);
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

// Sizing: toggle between a standard size and custom measurements. Reusable
// so it also wires up the sizing form inside the shop-the-look modal.
function bindSizingToggles(root = document) {
    qsa('[data-sizing]', root).forEach((container) => {
        if (container.dataset.sizingBound) return;
        container.dataset.sizingBound = 'true';

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
}

bindSizingToggles();

// Scroll-reveal: fade/slide in feed items as they enter the viewport.
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

function observeReveals(root = document) {
    qsa('.reveal', root).forEach((el, i) => {
        el.style.transitionDelay = `${Math.min(i, 8) * 60}ms`;
        revealObserver.observe(el);
    });
}

observeReveals();

// Image skeletons: any [data-skeleton] wrapper shows a shimmer placeholder
// until its <img> has actually finished loading, then fades the real photo
// in. Keeps layout stable and avoids a flash of broken/empty image boxes.
function initMediaSkeletons(root = document) {
    qsa('[data-skeleton]', root).forEach((el) => {
        const img = qs('img', el);
        if (!img) {
            el.classList.add('is-loaded');
            return;
        }

        const markLoaded = () => el.classList.add('is-loaded');

        if (img.complete && img.naturalWidth > 0) {
            markLoaded();
        } else {
            img.addEventListener('load', markLoaded, { once: true });
            img.addEventListener('error', markLoaded, { once: true });
        }
    });
}

initMediaSkeletons();

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

function bindLightboxTriggers(root = document) {
    qsa('[data-lightbox-group]', root).forEach((trigger) => {
        if (trigger.dataset.lightboxBound) return;
        trigger.dataset.lightboxBound = 'true';
        trigger.style.cursor = 'pointer';

        trigger.addEventListener('click', (event) => {
            if (event.target.closest('[data-shop-look]')) return;

            const group = trigger.dataset.lightboxGroup;
            const groupEls = qsa(`[data-lightbox-group="${group}"]`);
            const items = groupEls.map((el) => ({ src: el.dataset.lightboxSrc, alt: el.dataset.lightboxAlt || '' }));
            openLightbox(items, groupEls.indexOf(trigger));
        });
    });
}

bindLightboxTriggers();

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
const galleryMainWrap = qs('[data-gallery-main-wrap]');
qsa('.product-gallery__thumb').forEach((thumb) => {
    thumb.addEventListener('click', () => {
        if (galleryMain) {
            galleryMainWrap?.classList.remove('is-loaded');
            galleryMain.src = thumb.dataset.src;
            galleryMain.addEventListener('load', () => galleryMainWrap?.classList.add('is-loaded'), { once: true });
        }
    });
});

// Shop the look: clicking the hover button on a client-diary photo opens a
// popup asking for the shopper's details and sizing, pre-filled with which
// photo they're interested in.
const lookModal = qs('#look-modal');
const lookModalImage = qs('#look-modal-image');
const lookModalPhotoId = qs('#look-modal-photo-id');
const lookModalClose = qs('#look-modal-close');

function openLookModal(photoId, photoSrc) {
    if (!lookModal) return;
    if (lookModalPhotoId) lookModalPhotoId.value = photoId || '';
    if (lookModalImage) {
        lookModalImage.src = photoSrc || '';
        lookModalImage.alt = '';
    }
    lookModal.classList.add('is-open');
    lookModal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
}

function closeLookModal() {
    if (!lookModal) return;
    lookModal.classList.remove('is-open');
    lookModal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
}

lookModalClose?.addEventListener('click', closeLookModal);
lookModal?.addEventListener('click', (event) => {
    if (event.target === lookModal) closeLookModal();
});
document.addEventListener('keydown', (event) => {
    if (lookModal?.classList.contains('is-open') && event.key === 'Escape') closeLookModal();
});

function bindShopLookTriggers(root = document) {
    qsa('[data-shop-look]', root).forEach((button) => {
        if (button.dataset.shopLookBound) return;
        button.dataset.shopLookBound = 'true';

        button.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            openLookModal(button.dataset.photoId, button.dataset.photoSrc);
        });
    });
}

bindShopLookTriggers();

// Client diaries: load more photos as the user scrolls, or via the
// "Load more" button fallback. Newly appended items join the reveal
// animation, lightbox, and shop-the-look wiring automatically.
const diaryFeed = qs('#diary-feed');

if (diaryFeed) {
    const loader = qs('#feed-loader');
    const loadMoreButton = qs('#feed-load-more');
    const moreUrl = diaryFeed.dataset.moreUrl;
    let isLoading = false;

    async function loadNextPage() {
        const nextPage = diaryFeed.dataset.nextPage;
        if (!nextPage || !moreUrl || isLoading) return;

        isLoading = true;
        if (loader) loader.hidden = false;

        try {
            const response = await fetch(`${moreUrl}?page=${nextPage}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });

            if (!response.ok) throw new Error('Failed to load more photos');

            const hasMore = response.headers.get('X-Has-More-Pages') === '1';
            const html = await response.text();
            const temp = document.createElement('div');
            temp.innerHTML = html.trim();
            const newItems = Array.from(temp.children);

            newItems.forEach((item) => diaryFeed.appendChild(item));
            observeReveals(diaryFeed);
            initMediaSkeletons(diaryFeed);
            bindShopLookTriggers(diaryFeed);
            bindLightboxTriggers(diaryFeed);

            diaryFeed.dataset.nextPage = hasMore ? String(Number(nextPage) + 1) : '';
        } catch (error) {
            // Leave nextPage as-is so the user (or the next scroll event) can retry.
        } finally {
            isLoading = false;
            if (loader) loader.hidden = true;
            if (!diaryFeed.dataset.nextPage && loadMoreButton) loadMoreButton.hidden = true;
        }
    }

    loadMoreButton?.addEventListener('click', loadNextPage);

    const sentinel = document.createElement('div');
    sentinel.setAttribute('aria-hidden', 'true');
    diaryFeed.insertAdjacentElement('afterend', sentinel);

    const scrollObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) loadNextPage();
        });
    }, { rootMargin: '600px 0px' });

    scrollObserver.observe(sentinel);
}
