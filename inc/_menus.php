<?php
if (!defined('ABSPATH')) exit;

function dbd_lab_register_menus()
{
    register_nav_menus(array(
        'left-menu'  => __('Меню в шапці (Ліва сторона)')   ,
        'right-menu' => __('Меню в шапці (Права сторона)'),
        'footer-menu' => __('Меню в футері'),
        'footer-langs-menu' => __('Footer Languages Menu'),
        'footer-legal-menu' => __('Footer Legal Menu'),
    ));
}
add_action('after_setup_theme', 'dbd_lab_register_menus');
