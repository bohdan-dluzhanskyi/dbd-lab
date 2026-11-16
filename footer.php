<footer class="site-footer">
    <div class="container footer-container">

        <div class="footer-top">
            <div class="footer-cta">
                <h3 class="footer-cta-title"><?php pll_e('Потрібна консультація?'); ?></h3>
                <p class="footer-cta-text"><?php pll_e('Допоможемо підібрати обладнання відповідно до ваших задач та бюджету'); ?></p>
                <button class="c-btn c-btn--filled  open-callback-modal"><?php pll_e('Отримати консультацію'); ?></button>
            </div>

            <nav class="footer-nav">

                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer-menu',
                    'container'      => false,
                    'menu_class'     => 'footer-menu',
                    'fallback_cb'    => false,
                ));
                ?>

                <address class="footer-contact-item">
                    <svg class="icon-phone" aria-hidden="true">
                        <use href="<?php echo esc_url(get_theme_file_uri('/assets/images/sprite.svg#icon-pin')); ?>"></use>
                    </svg>
                    <span><?php pll_e('м. Київ<br>вул. Білоруська, 36-А'); ?></span>
                </address>
                <a href="tel:+380501457310" class="footer-contact-item">
                    <svg class="icon-phone" aria-hidden="true">
                        <use href="<?php echo esc_url(get_theme_file_uri('/assets/images/sprite.svg#icon-phone')); ?>"></use>
                    </svg>
                    <span>+380 50 145 73 10<br>+380 97 262 66 24</span>
                </a>

                <a href="mailto:dbd.cosmo.lab@gmail.com" class="footer-contact-item">
                    <svg class="icon-mail" aria-hidden="true">
                        <use href="<?php echo esc_url(get_theme_file_uri('/assets/images/sprite.svg#icon-mail')); ?>"></use>
                    </svg>
                    <span>dbd.cosmo.lab@gmail.com</span>
                </a>
            </nav>


        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-row footer-socials-langs">
                <div class="footer-socials">
                    <?php
                    $telegram_url  = get_field('telegram', 'option');
                    $instagram_url = get_field('instagram', 'option');
                    ?>
                    <?php if (! empty($telegram_url)) : ?>
                        <a href="<?php echo esc_url($telegram_url); ?>" class="social-link tg" target="_blank" aria-label="Telegram">
                            <svg class="icon-telegram" aria-hidden="true">
                                <use href="<?php echo esc_url(get_theme_file_uri('/assets/images/sprite.svg#icon-telegram')); ?>"></use>
                            </svg>
                        </a>
                    <?php endif; ?>
                    <?php if (! empty($instagram_url)) : ?>
                        <a href="<?php echo esc_url($instagram_url); ?>" class="social-link ig" target="_blank" aria-label="Instagram">
                            <svg class="icon-instagram" aria-hidden="true">
                                <use href="<?php echo esc_url(get_theme_file_uri('/assets/images/sprite.svg#icon-inst')); ?>"></use>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="footer-langs">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-langs-menu',
                        'container'      => false,
                        'menu_class'     => 'footer-langs-menu',
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>
            </div>

            <div class="footer-bottom-row footer-copy-legal">
                <p class="footer-copy">&copy; <?php echo date('Y'); ?> <?php pll_e('DBD Cosmo Lab. Усі права захищені.'); ?></p>

                <div class="footer-legal">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-legal-menu',
                        'container'      => false,
                        'menu_class'     => 'footer-legal-menu',
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>
            </div>
        </div>

    </div>
</footer>

</div>

<div id="custom-modal-overlay" class="modal-overlay">
    <div class="modal-content-container">
        <button class="modal-close-x" id="modal-close-x" aria-label="<?php echo esc_attr(function_exists('pll__') ? pll__('Закрити модальне вікно') : 'Закрити модальне вікно'); ?>">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://w3.org">
                <path d="M18 18L12 12M12 12L6 6M12 12L18 6M12 12L6 18" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="#00C4C4" />
            </svg>
        </button>

        <?php
        $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'uk';

        if ($current_lang === 'en') {
            echo do_shortcode('[contact-form-7 id="c2bcaad" title="modal-en"]');
        } elseif ($current_lang === 'ru') {
            echo do_shortcode('[contact-form-7 id="0a92678" title="modal-ru"]');
        } else {
            echo do_shortcode('[contact-form-7 id="9f82a04" title="modal-uk"]');
        }
        ?>
    </div>
</div>
<div class="fixed-widget" id="fixed-connect-widget">

    <div class="fixed-widget__modal" id="widget-modal-window">
        <h3 class="fixed-widget__title"><?php pll_e('Потрібна консультація?'); ?></h3>
        <p class="fixed-widget__text"><?php pll_e('Наш менеджер допоможе з вибором та відповість на запитання.'); ?></p>

        <div class="fixed-widget__links">
            <button class="fixed-widget__link-item open-callback-modal" data-modal="callback">
                <svg class="icon-phone" aria-hidden="true">
                    <use href="<?php echo esc_url(get_theme_file_uri('/assets/images/sprite.svg#icon-phone')); ?>"></use>
                </svg>
                <span><?php pll_e('Замовити зворотній дзвінок'); ?></span>
            </button>

            <?php $tg_url = get_field('telegram', 'option');
            if (!empty($tg_url)) : ?>
                <a href="<?php echo esc_url($tg_url); ?>" class="fixed-widget__link-item" target="_blank" rel="nofollow">
                    <svg class="icon-telegram" aria-hidden="true">
                        <use href="<?php echo esc_url(get_theme_file_uri('/assets/images/sprite.svg#icon-telegram')); ?>"></use>
                    </svg>
                    <span><?php pll_e('Написати у Telegram'); ?></span>
                </a>
            <?php endif; ?>

            <?php $wa_url = get_field('whatsapp', 'option');
            if (!empty($wa_url)) : ?>
                <a href="<?php echo esc_url($wa_url); ?>" class="fixed-widget__link-item" target="_blank" rel="nofollow">
                    <svg class="icon-whatsapp" aria-hidden="true">
                        <use href="<?php echo esc_url(get_theme_file_uri('/assets/images/sprite.svg#icon-whatsapp')); ?>"></use>
                    </svg>
                    <span><?php pll_e('Написати у WhatsApp'); ?></span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <button class="fixed-widget__trigger" id="widget-trigger-btn" aria-label="Open support menu">
        <span class="fixed-widget__robot-icon">
            <?php
            $svg_path = get_theme_file_path('/assets/images/robot.svg');
            if (file_exists($svg_path)) {
                echo file_get_contents($svg_path);
            }
            ?>
        </span>
    </button>
</div>


<?php wp_footer(); ?>

</body>

</html>