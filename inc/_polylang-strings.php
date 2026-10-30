<?php

add_action('after_setup_theme', 'dbd_lab_register_theme_strings');
function dbd_lab_register_theme_strings()
{
    if (function_exists('pll_register_string')) {

        pll_register_string('Footer CTA Title', 'Потрібна консультація?', 'DBD Lab Footer');
        pll_register_string('Footer CTA Text', 'Допоможемо підібрати обладнання відповідно до ваших задач та бюджету', 'DBD Lab Footer');
        pll_register_string('Footer CTA Button', 'Отримати консультацію', 'DBD Lab Footer');
        pll_register_string('Footer Address', 'м. Київ<br>вул. Білоруська, 36-А', 'DBD Lab Footer');
        pll_register_string('Footer Copyright', 'DBD Cosmo Lab. Усі права захищені.', 'DBD Lab Footer');

        pll_register_string('Header Contact Button', 'Зв\'язатися з нами', 'DBD Lab Header');

    }
}
