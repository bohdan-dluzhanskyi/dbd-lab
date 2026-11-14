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

        pll_register_string('Catalog No Products', 'Нічого не знайдено', 'DBD Lab Catalog');
        pll_register_string('Catalog Empty Text', 'На жаль, за вашим запитом нічого не знайдено.', 'DBD Lab Catalog');
        pll_register_string('Catalog Clear Button', 'Очистити пошук', 'DBD Lab Catalog');
        pll_register_string('Catalog Filter No Subcats', 'Немає підкатегорій', 'DBD Lab Catalog');
        pll_register_string('Catalog Filter Apply', 'Застосувати', 'DBD Lab Catalog');
        pll_register_string('Catalog Sort Default', 'Сортувати', 'DBD Lab Catalog');
        pll_register_string('Catalog Sort Price Asc', 'За ціною: від нижчої', 'DBD Lab Catalog');
        pll_register_string('Catalog Sort Price Desc', 'За ціною: від вищої', 'DBD Lab Catalog');
        pll_register_string('Catalog Sort Alphabet', 'За алфавітом', 'DBD Lab Catalog');

        pll_register_string('Product Price Request', 'Ціна за запитом', 'DBD Lab Product');
        pll_register_string('Product Power Label', 'Потужність:', 'DBD Lab Product');
        pll_register_string('Product Price Notice', 'Ціни вказані без урахування доставки', 'DBD Lab Product');
        pll_register_string('Product Action Button', 'Отримати комерційну пропозицію', 'DBD Lab Product');
        pll_register_string('Product Specs Title', 'Технічні характеристики', 'DBD Lab Product');

        pll_register_string('Widget Title', 'Потрібна консультація?', 'DBD Lab Product');
        pll_register_string('Widget Text', 'Наш менеджер допоможе з вибором та відповість на запитання.', 'DBD Lab Product');
        pll_register_string('Widget Callback', 'Замовити зворотній дзвінок', 'DBD Lab Product');
        pll_register_string('Widget Telegram', 'Написати у Telegram', 'DBD Lab Product');
        pll_register_string('Widget WhatsApp', 'Написати у WhatsApp', 'DBD Lab Product');

        

    }
}
