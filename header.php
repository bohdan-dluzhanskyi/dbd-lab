<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://googleapis.com">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div id="page" class="site-wrapper">

        <header class="container site-header">

            <div class="header-socials">
                <a href="#" class="social-link tg" target="_blank" aria-label="Telegram">
                    <?php
                    $svg_path = get_theme_file_path('/assets/images/telegram.svg');
                    if (file_exists($svg_path)) {
                        echo file_get_contents($svg_path);
                    }
                    ?>
                </a>
                <a href="#" class="social-link ig" target="_blank" aria-label="Instagram">
                    <?php
                    $svg_path = get_theme_file_path('/assets/images/inst.svg');
                    if (file_exists($svg_path)) {
                        echo file_get_contents($svg_path);
                    }
                    ?>
                </a>
            </div>
            <div class="header-right-zone">

                <nav class="header-navigation-wrapper">

                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'left-menu',
                        'container'      => false,
                        'menu_class'     => 'main-menu menu-left',
                        'fallback_cb'    => false,
                    ));
                    ?>

                    <a href="<?php echo esc_url(home_url('/')); ?>" class="header-logo">
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

                <div class="header-actions">
                    <button href="#" class="btn-contact"><?php pll_e('Зв\'язатися з нами'); ?></button>
                </div>
            </div>

        </header>

        <div id="content" class="site-content">