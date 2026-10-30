</div>

<footer class="site-footer">
    <div class="container footer-container">

        <div class="footer-top">
            <div class="footer-cta">
                <h3 class="footer-cta-title"><?php pll_e('Потрібна консультація?'); ?></h3>
                <p class="footer-cta-text"><?php pll_e('Допоможемо підібрати обладнання відповідно до ваших задач та бюджету'); ?></p>
                <button href="#" class="btn-contact"><?php pll_e('Отримати консультацію'); ?></button>
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
                    <a href="#" class="social-link tg" target="_blank" aria-label="Telegram">
                        <svg class="icon-telegram" aria-hidden="true">
                            <use href="<?php echo esc_url(get_theme_file_uri('/assets/images/sprite.svg#icon-telegram')); ?>"></use>
                        </svg>
                    </a>
                    <a href="#" class="social-link ig" target="_blank" aria-label="Instagram">
                        <svg class="icon-instagram" aria-hidden="true">
                            <use href="<?php echo esc_url(get_theme_file_uri('/assets/images/sprite.svg#icon-inst')); ?>"></use>
                        </svg>
                    </a>
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

<?php wp_footer(); ?>
</body>

</html>