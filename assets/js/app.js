/**
 * ==========================================================================
 * 1. ИНИЦИАЛИЗАЦИЯ ТЕМЫ (jQuery)
 * ==========================================================================
 */
(function ($) {
    class starterTheme {
        constructor() {
            this.setupStarterFunction();
        }

        setupStarterFunction() {
            // Базовая инициализация jQuery-скриптов
        }
    }

    window.starterTheme = new starterTheme();
})(window.jQuery);


/**
 * ==========================================================================
 * 2. ГЛОБАЛЬНЫЕ ФУНКЦИИ И МОДАЛЬНЫЕ ОКНА
 * ==========================================================================
 */
let modalOverlay = null;

// Закрытие модального окна (вынесено глобально для доступа из событий CF7)
function closeModal() {
    if (!modalOverlay) {
        modalOverlay = document.getElementById("custom-modal-overlay");
    }
    if (modalOverlay) {
        modalOverlay.classList.remove("is-active");
    }
    document.body.style.overflow = "";
    document.documentElement.classList.remove("modal-open");
    document.body.classList.remove("modal-open");
}

function initModals() {
    modalOverlay = document.getElementById("custom-modal-overlay");
    const openButtons = document.querySelectorAll(".open-callback-modal");
    const closeX = document.getElementById("modal-close-x");

    // Открытие модального окна
    openButtons.forEach(button => {
        button.addEventListener("click", (e) => {
            e.preventDefault();
            if (modalOverlay) {
                modalOverlay.classList.add("is-active");
                document.body.style.overflow = "hidden";
                document.documentElement.classList.add("modal-open");
                document.body.classList.add("modal-open");
            }
        });
    });

    // Закрытие по крестику
    if (closeX) {
        closeX.addEventListener("click", closeModal);
    }

    // Закрытие по клику на фон или кнопку "Отмена"
    if (modalOverlay) {
        modalOverlay.addEventListener("click", (e) => {
            if (e.target === modalOverlay || e.target.classList.contains("btn-cancel")) {
                e.preventDefault();
                closeModal();
            }
        });
    }
}


/**
 * ==========================================================================
 * 3. ШАПКА, МОБИЛЬНОЕ МЕНЮ И НАВИГАЦИЯ
 * ==========================================================================
 */
function initNavigation() {
    // --- Мобильное бургер-меню ---
    const burgerBtn = document.querySelector('.burger-btn');
    const mobileDrawer = document.getElementById('mobileDrawer');
    const submenuParents = document.querySelectorAll('.header-right-zone .menu-item-has-children > a');

    const closeMenu = () => {
        if (!burgerBtn || !mobileDrawer) return;
        burgerBtn.classList.remove('is-active');
        mobileDrawer.classList.remove('is-open');
        burgerBtn.setAttribute('aria-expanded', 'false');
        document.documentElement.classList.remove('menu-open');
        document.body.classList.remove('menu-open');
    };

    if (burgerBtn && mobileDrawer) {
        burgerBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpened = burgerBtn.classList.toggle('is-active');
            mobileDrawer.classList.toggle('is-open');
            burgerBtn.setAttribute('aria-expanded', isOpened);
            
            document.documentElement.classList.toggle('menu-open', isOpened);
            document.body.classList.toggle('menu-open', isOpened);
        });

        document.addEventListener('click', (e) => {
            if (!mobileDrawer.contains(e.target) && !burgerBtn.contains(e.target)) {
                closeMenu();
            }
        });
    }

    // Выпадающее подменю на мобильных устройствах
    submenuParents.forEach(link => {
        link.addEventListener('click', (e) => {
            if (window.innerWidth <= 1024) {
                e.preventDefault();
                link.parentElement.classList.toggle('is-submenu-open');
            }
        });
    });

    // --- Стрелка "Назад" в хлебных крошках для мобильных ---
    document.querySelectorAll('.breadcrumbs-list').forEach(list => {
        const items = list.querySelectorAll('li');
        if (items.length >= 2) {
            const currentItem = items[items.length - 1];
            const prevLink = items[items.length - 2].querySelector('a');

            if (currentItem && prevLink && !currentItem.querySelector('.mobile-back-arrow')) {
                const backArrow = document.createElement('a');
                backArrow.href = prevLink.href;
                backArrow.className = 'mobile-back-arrow';
                backArrow.setAttribute('aria-label', 'Назад');
                backArrow.innerHTML = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 16L10 12L14 8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="#626262" /></svg>`;
                currentItem.prepend(backArrow);
            }
        }
    });
}


/**
 * ==========================================================================
 * 4. КАТАЛОГ ТОВАРОВ (AJAX-ФИЛЬТРАЦИЯ И ВЫПАДАЮЩИЕ СПИСКИ)
 * ==========================================================================
 */
function initCatalog() {
    // --- Мобильные выпадающие окна фильтров и сортировки ---
    const filterToggle = document.querySelector('.bar-filter .filter-dropdown-toggle');
    const sortToggle = document.querySelector('.bar-sort .sort-dropdown-toggle');
    const barFilter = document.querySelector('.bar-filter');
    const barSort = document.querySelector('.bar-sort');

    if (filterToggle && barFilter) {
        filterToggle.addEventListener('click', (e) => {
            if (window.innerWidth <= 1024) {
                e.stopPropagation();
                barSort?.classList.remove('is-open');
                barFilter.classList.toggle('is-open');
            }
        });
    }

    if (sortToggle && barSort) {
        sortToggle.addEventListener('click', (e) => {
            if (window.innerWidth <= 1024) {
                e.stopPropagation();
                barFilter?.classList.remove('is-open');
                barSort.classList.toggle('is-open');
            }
        });
    }

    document.addEventListener('click', (e) => {
        if (barFilter && !barFilter.contains(e.target)) barFilter.classList.remove('is-open');
        if (barSort && !barSort.contains(e.target)) barSort.classList.remove('is-open');
    });

    // --- AJAX-подгрузка товаров ---
    const ajaxContainer = document.getElementById('catalog-ajax-container');
    if (!ajaxContainer) return;

    async function loadCatalog(url) {
        ajaxContainer.style.opacity = '0.5';
        ajaxContainer.style.transition = 'opacity 0.2s ease';

        try {
            const decodedUrl = decodeURIComponent(url);
            const response = await fetch(decodedUrl);
            if (!response.ok) throw new Error('Network error');
            
            const htmlText = await response.text();
            const doc = new DOMParser().parseFromString(htmlText, 'text/html');
            const newContent = doc.getElementById('catalog-ajax-container');

            if (newContent) {
                ajaxContainer.innerHTML = newContent.innerHTML;
                window.history.pushState({ url: decodedUrl }, '', decodedUrl);
            }
        } catch (error) {
            console.error('AJAX Catalog Error:', error);
        } finally {
            ajaxContainer.style.opacity = '1';
        }
    }

    // Отправка форм поиска и фильтрации в каталоге
    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (form.closest('.bar-search form') || form.closest('.bar-filter form')) {
            e.preventDefault();
            const params = new URLSearchParams();

            const searchInput = form.querySelector('input[name="s"]');
            if (searchInput && searchInput.value) {
                params.append('s', searchInput.value);
                const postType = form.querySelector('input[name="post_type"]');
                if (postType) params.append('post_type', postType.value);
            }

            form.querySelectorAll('input[name="f_sub[]"]:checked').forEach((checkbox) => {
                params.append('f_sub[]', checkbox.value);
            });

            const baseUrl = window.location.pathname;
            const queryString = decodeURIComponent(params.toString());
            loadCatalog(queryString ? `${baseUrl}?${queryString}` : baseUrl);
        }
    });

    // Клики по сортировке, пагинации и кнопке сброса
    document.addEventListener('click', (e) => {
        const link = e.target.closest('.bar-sort a, .catalog-pagination a, .btn-clear');
        if (link) {
            e.preventDefault();
            const targetUrl = link.getAttribute('href');
            if (targetUrl) loadCatalog(targetUrl);
        }
    });

    // Поддержка кнопок "Назад/Вперед" в браузере
    window.addEventListener('popstate', () => {
        loadCatalog(window.location.href);
    });
}


/**
 * ==========================================================================
 * 5. КАРТОЧКА ТОВАРА (ГАЛЕРЕЯ, LIGHTBOX, ВАРИАЦИИ ЦЕН)
 * ==========================================================================
 */
function initProductPage() {
        // --- 1. Галерея изображений и видео товара ---
    const thumbItems = document.querySelectorAll('.product-gallery .thumb-item');
    const mainImg = document.getElementById('main-product-img');
    const lightboxLink = document.getElementById('main-product-lightbox-link');
    const mainVideoWrap = document.getElementById('main-product-video-wrap');
    const prevBtn = document.getElementById('gallery-prev');
    const nextBtn = document.getElementById('gallery-next');

    if (thumbItems.length && mainImg && prevBtn && nextBtn) {
        let currentIndex = 0;

        function changeGalleryImage(index) {
            currentIndex = index;

            thumbItems.forEach(item => item.classList.remove('is-active'));
            const activeThumb = thumbItems[currentIndex];
            activeThumb.classList.add('is-active');

            const itemType = activeThumb.getAttribute('data-type') || 'image';

            if (itemType === 'video') {
                const youtubeId = activeThumb.getAttribute('data-youtube-id');
                
                if (lightboxLink) lightboxLink.style.display = 'none';
                if (mainVideoWrap && youtubeId) {
                    mainVideoWrap.style.display = 'flex';
                    if (!mainVideoWrap.querySelector('iframe')) {
                        const slash = String.fromCharCode(47);
                        const embedUrl = 'https:' + slash + slash + 'www.youtube-nocookie.com' + slash + 'embed' + slash + youtubeId + '?autoplay=1&rel=0';
                        mainVideoWrap.innerHTML = '<iframe src="' + embedUrl + '" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
                    }
                }
            } else {
                // Останавливаем видео (очищаем iframe), если переключились обратно на фото
                if (mainVideoWrap) {
                    mainVideoWrap.style.display = 'none';
                    mainVideoWrap.innerHTML = '';
                }
                if (lightboxLink) lightboxLink.style.display = 'flex';

                const newSrc = activeThumb.getAttribute('data-full');

                // Обновляем основное изображение и теги <source> внутри <picture>
                mainImg.setAttribute('src', newSrc);
                if (mainImg.hasAttribute('srcset')) mainImg.setAttribute('srcset', newSrc);

                const pictureParent = mainImg.closest('picture');
                if (pictureParent) {
                    pictureParent.querySelectorAll('source').forEach(source => {
                        source.setAttribute('srcset', newSrc);
                    });
                }

                if (lightboxLink) lightboxLink.setAttribute('href', newSrc);
            }

            activeThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        thumbItems.forEach((thumb, index) => {
            thumb.addEventListener('click', () => changeGalleryImage(index));
        });

        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            changeGalleryImage(currentIndex - 1 < 0 ? thumbItems.length - 1 : currentIndex - 1);
        });

        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            changeGalleryImage(currentIndex + 1 >= thumbItems.length ? 0 : currentIndex + 1);
        });
    }

        // --- 2. Fancybox (только для фото товара) ---
    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind('[data-fancybox]:not(#main-product-lightbox-link)', {
            Hash: false,
            Toolbar: { display: { left: ["infobar"], right: ["zoom", "close"] } },
            Images: { zoom: true },
            Thumbs: false
        });

        const mainLightboxLink = document.getElementById('main-product-lightbox-link');
        if (mainLightboxLink) {
            mainLightboxLink.addEventListener('click', function(e) {
                e.preventDefault();
                // Выбираем строго только фото-миниатюры
                const imageThumbs = document.querySelectorAll('.product-gallery .thumb-item[data-type="image"]');
                
                if (imageThumbs.length > 0) {
                    const galleryArray = [];
                    let activeIndex = 0;

                    imageThumbs.forEach((thumb, index) => {
                        galleryArray.push({ 
                            src: thumb.getAttribute('data-full'), 
                            type: 'image' 
                        });
                        if (thumb.classList.contains('is-active')) activeIndex = index;
                    });

                    Fancybox.show(galleryArray, {
                        startIndex: activeIndex,
                        Hash: false,
                        Toolbar: { display: { left: ["infobar"], right: ["zoom", "close"] } },
                        Images: { zoom: true },
                        Thumbs: false
                    });
                }
            });
        }
    }





    // --- 2. Fancybox (увеличение фото) ---
    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind('[data-fancybox]:not(#main-product-lightbox-link)', {
            Hash: false,
            Toolbar: { display: { left: ["infobar"], right: ["zoom", "close"] } },
            Images: { zoom: true },
            Thumbs: false
        });

        const mainLightboxLink = document.getElementById('main-product-lightbox-link');
        if (mainLightboxLink) {
            mainLightboxLink.addEventListener('click', function(e) {
                e.preventDefault();
                const thumbs = document.querySelectorAll('.product-gallery .thumb-item');
                
                if (thumbs.length > 0) {
                    const galleryArray = [];
                    let activeIndex = 0;

                    thumbs.forEach((thumb, index) => {
                        galleryArray.push({ src: thumb.getAttribute('data-full'), type: "image" });
                        if (thumb.classList.contains('is-active')) activeIndex = index;
                    });

                    Fancybox.show(galleryArray, {
                        startIndex: activeIndex,
                        Hash: false,
                        Toolbar: { display: { left: ["infobar"], right: ["zoom", "close"] } },
                        Images: { zoom: true },
                        Thumbs: false
                    });
                }
            });
        }
    }

    // --- 3. Вариации цены (статические через коэффициент) ---
    const variantBtns = document.querySelectorAll('.product-info__variants .variant-btn');
    const actualUahPriceEl = document.getElementById('actual-uah-price');
    const metaCurrencyPriceEl = document.getElementById('meta-currency-price');

    if (variantBtns.length && actualUahPriceEl) {
        const basePriceUah = parseFloat(actualUahPriceEl.getAttribute('data-base-price'));

        variantBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                variantBtns.forEach(b => b.classList.remove('is-active'));
                this.classList.add('is-active');

                const modifier = parseFloat(this.getAttribute('data-price-mod'));
                if (basePriceUah > 0) {
                    const newPriceUah = Math.round(basePriceUah * modifier);
                    actualUahPriceEl.textContent = newPriceUah.toLocaleString('uk-UA') + ' ₴';

                    if (metaCurrencyPriceEl) {
                        const basePriceUsd = Math.round(basePriceUah / 41.5);
                        const newPriceUsd = Math.round(basePriceUsd * modifier);
                        metaCurrencyPriceEl.textContent = `${newPriceUsd}$ / ${newPriceUsd}€`;
                    }
                }
            });
        });
    }

    // --- 4. Динамические вариации WooCommerce (JSON) ---
    const variationsWrapper = document.getElementById('woo-dynamic-variations');
    if (variationsWrapper) {
        const variationsData = JSON.parse(variationsWrapper.getAttribute('data-variations'));
        const wooVariantBtns = variationsWrapper.querySelectorAll('.variant-btn');

        function updateVariationPrice(activeSlug) {
            const found = variationsData.find(v => Object.values(v.attributes).includes(activeSlug));
            if (found && actualUahPriceEl && metaCurrencyPriceEl) {
                actualUahPriceEl.textContent = found.price_html;
                metaCurrencyPriceEl.textContent = found.meta_html;
            }
        }

        const firstActiveBtn = variationsWrapper.querySelector('.variant-btn.is-active');
        if (firstActiveBtn) {
            updateVariationPrice(firstActiveBtn.getAttribute('data-variant-slug'));
        }

        wooVariantBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                wooVariantBtns.forEach(b => b.classList.remove('is-active'));
                this.classList.add('is-active');
                updateVariationPrice(this.getAttribute('data-variant-slug'));
            });
        });
    }
}


/**
 * ==========================================================================
 * 6. ФОРМЫ, ВАЛИДАЦИЯ И CONTACT FORM 7
 * ==========================================================================
 */
function initForms() {
    // Разрешаем вводить в поле телефона только цифры и спецсимволы
    document.querySelectorAll('.phone-input').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9+\-\s()]/g, '');
        });
    });

    // Счетчик символов для текстового поля сообщения
    document.addEventListener("input", (event) => {
        if (event.target && event.target.matches('textarea[name="your-message"]')) {
            const counterSpan = document.getElementById("char-current");
            if (counterSpan) {
                counterSpan.textContent = event.target.value.length;
            }
        }
    });

    // Обработка успешной отправки формы Contact Form 7 (единый слушатель)
    document.addEventListener('wpcf7mailsent', function(event) {
        // 1. Закрываем модальное окно через 1 секунду
        setTimeout(closeModal, 1000);

        // 2. Плавно скрываем системное уведомление CF7 через 3 секунды
        const responseOutput = event.target.querySelector('.wpcf7-response-output');
        if (responseOutput) {
            responseOutput.classList.remove('is-hiding');
            setTimeout(() => {
                responseOutput.classList.add('is-hiding');
                setTimeout(() => {
                    responseOutput.style.display = 'none';
                    responseOutput.classList.remove('is-hiding');
                }, 400);
            }, 3000);
        }
    }, false);
}


/**
 * ==========================================================================
 * 7. КАРУСЕЛЬ, ПРАЙС-ЛИСТ И ПЛАВАЮЩИЙ ВИДЖЕТ СВЯЗИ
 * ==========================================================================
 */
function initUIWidgets() {
    // --- Нативная карусель ---
    const carousel = document.querySelector('.native-carousel');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    if (carousel && prevBtn && nextBtn) {
        const getScrollStep = () => {
            const slide = carousel.querySelector('.carousel-slide');
            return slide ? slide.clientWidth + 24 : 300;
        };

        nextBtn.addEventListener('click', () => carousel.scrollBy({ left: getScrollStep(), behavior: 'smooth' }));
        prevBtn.addEventListener('click', () => carousel.scrollBy({ left: -getScrollStep(), behavior: 'smooth' }));
    }

    // --- Кнопка "Показать еще" в блоке цен ---
    document.querySelectorAll('.prices__more-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.closest('.prices')?.classList.add('is-expanded');
        });
    });

    // --- Плавающий виджет связи в углу экрана ---
    const widget = document.getElementById('fixed-connect-widget');
    const triggerBtn = document.getElementById('widget-trigger-btn');
    const modalWindow = document.getElementById('widget-modal-window');
    const footer = document.querySelector('footer');

    if (widget && triggerBtn && modalWindow) {
        // Появление виджета через 3 секунды и запуск анимации подпрыгивания
        setTimeout(() => {
            widget.classList.add('is-visible');
            setTimeout(() => {
                setInterval(() => {
                    if (!modalWindow.classList.contains('is-open')) {
                        triggerBtn.classList.add('is-bouncing');
                        setTimeout(() => triggerBtn.classList.remove('is-bouncing'), 1200);
                    }
                }, 2000);
            }, 1500);
        }, 3000);

        // Открытие / закрытие окна виджета
        triggerBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            modalWindow.classList.toggle('is-open');
            triggerBtn.classList.remove('is-bouncing');
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('#fixed-connect-widget')) {
                modalWindow.classList.remove('is-open');
            }
        });

        // Отталкивание виджета от футера при прокрутке вниз
        if (footer) {
            window.addEventListener('scroll', () => {
                const footerRect = footer.getBoundingClientRect();
                const windowHeight = window.innerHeight;

                if (footerRect.top < windowHeight) {
                    const overlap = windowHeight - footerRect.top;
                    widget.style.bottom = `${overlap + 32}px`;
                } else {
                    widget.style.bottom = '32px';
                }
            });
        }
    }
}


/**
 * ==========================================================================
 * 8. ЗАПУСК ВСЕХ МОДУЛЕЙ ПОСЛЕ ЗАГРУЗКИ DOM
 * ==========================================================================
 */
document.addEventListener('DOMContentLoaded', () => {
    initModals();
    initNavigation();
    initCatalog();
    initProductPage();
    initForms();
    initUIWidgets();
});