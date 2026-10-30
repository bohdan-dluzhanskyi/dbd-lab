<?php
add_action('wp_enqueue_scripts', 'dbd_scripts');
function dbd_scripts()
{
    wp_enqueue_style(
        'dbd-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'dbd-style',
        get_template_directory_uri() . '/style.css',
        array(),
        _VERSION
    );

    wp_enqueue_script('jquery');
    wp_enqueue_script(
        'dbd-script',
        get_template_directory_uri() . '/assets/js/app.min.js',
        array(),
        _VERSION,
        true
    );
}
