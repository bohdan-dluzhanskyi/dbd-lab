<?php
if (!defined('ABSPATH')) exit;

// Define constants
if (!defined('_VERSION')) {
	define('_VERSION', '1.0.0');
}

// Include styles and scripts
require get_template_directory() . '/inc/_scripts.php';

// Post types
require get_template_directory() . '/inc/_post-types.php';

//menus
require get_template_directory() . '/inc/_menus.php';

// Подключение регистрации строк Polylang из папки inc
require get_template_directory() . '/inc/_polylang-strings.php';

require get_template_directory() . '/inc/_button.php';

require get_template_directory() . '/inc/_media-block.php';