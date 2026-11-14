<?php

/**
 * Блок Action Section
 */

$text_block_data = get_sub_field('_universal-text-block');

if (function_exists('render_acf_text_promo_block')) {
    render_acf_text_promo_block($text_block_data);
}
