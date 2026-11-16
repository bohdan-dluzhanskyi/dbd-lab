<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    

    <?php wp_head(); ?>


</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div id="page" class="site-wrapper">


        <header class="site-header">
            <!-- Кнопка бургера (видна только на планшете и мобилке) -->
            <button class="burger-btn" aria-label="Відкрити меню" aria-expanded="false">
                <span class="burger-line"></span>
                <span class="burger-line"></span>
                <span class="burger-line"></span>
            </button>

            <!-- Соцсети (на десктопе слева, на мобилке уедут в низ выпадающего меню) -->
            <div class="header-socials">
                <?php
                $telegram_url  = get_field('telegram', 'option');
                $instagram_url = get_field('instagram', 'option');
                ?>
                <?php if (! empty($telegram_url)) : ?>
                    <a href="<?php echo esc_url($telegram_url); ?>" class="social-link tg" target="_blank" rel="nofollow" aria-label="Telegram">
                        <?php
                        $svg_path = get_theme_file_path('/assets/images/telegram.svg');
                        if (file_exists($svg_path)) {
                            echo file_get_contents($svg_path);
                        }
                        ?>
                    </a>
                <?php endif; ?>
                <?php if (! empty($instagram_url)) : ?>
                    <a href="<?php echo esc_url($instagram_url); ?>" class="social-link ig" target="_blank" rel="nofollow" aria-label="Instagram">
                        <?php
                        $svg_path = get_theme_file_path('/assets/images/inst.svg');
                        if (file_exists($svg_path)) {
                            echo file_get_contents($svg_path);
                        }
                        ?>
                    </a>
                <?php endif; ?>
            </div>

            <a href="<?php echo esc_url(home_url('/')); ?>" class="header-logo mobile-only-logo" aria-label="<?php pll_e('На головну'); ?>">
                <?php
                $svg_path = get_theme_file_path('/assets/images/logo.svg');
                if (file_exists($svg_path)) {
                    echo file_get_contents($svg_path);
                }
                ?>
            </a>

            <div class="header-right-zone" id="mobileDrawer">
                <nav class="header-navigation-wrapper">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'left-menu',
                        'container'      => false,
                        'menu_class'     => 'main-menu menu-left',
                        'fallback_cb'    => false,
                    ));
                    ?>

                    <a href="<?php echo esc_url(home_url('/')); ?>" class="header-logo desktop-only-logo">
                        <?php
                        $svg_path = get_theme_file_path('/assets/images/logo.svg');
                        if (file_exists($svg_path)) {
                            echo file_get_contents($svg_path);
                        }
                        ?>
                    </a>

                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'right-menu',
                        'container'      => false,
                        'menu_class'     => 'main-menu menu-right',
                        'fallback_cb'    => false,
                    ));
                    ?>
                </nav>

                <div class="mobile-drawer-socials">
                    <?php if (! empty($telegram_url)) : ?>
                        <a href="<?php echo esc_url($telegram_url); ?>" class="social-link tg" target="_blank" rel="nofollow" aria-label="Telegram">
                            <?php
                            $svg_path = get_theme_file_path('/assets/images/telegram.svg');
                            if (file_exists($svg_path)) {
                                echo file_get_contents($svg_path);
                            }
                            ?>
                        </a>
                    <?php endif; ?>
                    <?php if (! empty($instagram_url)) : ?>
                        <a href="<?php echo esc_url($instagram_url); ?>" class="social-link ig" target="_blank" rel="nofollow" aria-label="Instagram">
                            <?php
                            $svg_path = get_theme_file_path('/assets/images/inst.svg');
                            if (file_exists($svg_path)) {
                                echo file_get_contents($svg_path);
                            }
                            ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="header-actions">
                <button class="btn-contact open-callback-modal" aria-label="<?php pll_e('Зв\'язатися з нами'); ?>">
                    <span class="btn-text"><?php pll_e('Зв\'язатися з нами'); ?></span>
                    <span class="btn-phone-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.12923 4C8.85616 4 9.50984 4.44258 9.77982 5.11753L10.7177 7.46053C10.9603 8.06681 10.8501 8.7573 10.4321 9.25894L9.9278 9.86372C9.33918 10.5701 9.38723 11.6086 10.0374 12.2587L11.7404 13.9634C12.3906 14.6135 13.4299 14.6604 14.1362 14.0717L14.741 13.5673C15.2426 13.1493 15.9329 13.0401 16.5392 13.2826L18.8826 14.2197C19.5575 14.4897 20 15.1433 20 15.8702L19.9996 18.3157C19.9996 19.2459 19.2457 20 18.3156 20C10.4094 20 4 13.5904 4 5.68403C4 4.75386 4.75403 4 5.68417 4H8.12923Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="white" />
                        </svg>
                    </span>
                </button>
            </div>
        </header>


        <div id="content" class="site-content">