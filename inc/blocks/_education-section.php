<?php

/**
 * Блок Education Section
 */

$media_block_data = get_sub_field('_media-block');

if (function_exists('render_acf_media_block')) {
    render_acf_media_block($media_block_data);
}
