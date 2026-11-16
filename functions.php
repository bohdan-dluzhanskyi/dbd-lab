<?php
if (!defined('ABSPATH')) exit;

// Define constants
if (!defined('_VERSION')) {
	define('_VERSION', '1.0.0');
}

// Include styles and scripts
require get_template_directory() . '/inc/_scripts.php';



//menus
require get_template_directory() . '/inc/_menus.php';

// Подключение регистрации строк Polylang из папки inc
require get_template_directory() . '/inc/_polylang-strings.php';

require get_template_directory() . '/inc/_button.php';

require get_template_directory() . '/inc/_media-block.php';

require get_template_directory() . '/inc/_universal-text-block.php';

if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title'    => 'Глобальные настройки сайта',
		'menu_title'    => 'Настройки сайта',
		'menu_slug'     => 'theme-general-settings',
		'capability'    => 'edit_posts',
		'redirect'      => false
	));
}
function mytheme_add_woocommerce_support()
{
	add_theme_support('woocommerce');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');

	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');


add_filter('loop_shop_per_page', 'custom_loop_shop_per_page', 20);
function custom_loop_shop_per_page($cols)
{
	return 12;
}

add_action('woocommerce_product_query', 'custom_woocommerce_product_filter', 99);
function custom_woocommerce_product_filter(WP_Query $query)
{
	if (is_admin()) {
		return;
	}

	if (!empty($_GET['f_search'])) {
		$query->set('s', sanitize_text_field(wp_unslash($_GET['f_search'])));
	}

	if (isset($_GET['f_sub']) && !empty($_GET['f_sub'])) {
		$tax_query = (array) $query->get('tax_query');
		$tax_query[] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => array_map('sanitize_text_field', (array) wp_unslash($_GET['f_sub'])),
			'operator' => 'IN',
		);
		$query->set('tax_query', $tax_query);
	}
}



add_filter('woocommerce_breadcrumb_defaults', 'custom_dynamic_polylang_breadcrumbs', 99);
function custom_dynamic_polylang_breadcrumbs(array $defaults)
{
	$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'uk';
	$page_id = 22;

	if ($current_lang == 'uk') {
		$page_id = 22;
	} elseif ($current_lang == 'en') {
		$page_id = 109;
	} elseif ($current_lang == 'ru') {
		$page_id = 107;
	}

	$page_title = get_the_title($page_id);
	$page_url   = get_permalink($page_id);

	$defaults['home'] = $page_title;

	add_filter('woocommerce_breadcrumb_home_url', function () use ($page_url) {
		return $page_url;
	}, 99);

	return $defaults;
}

add_filter('woocommerce_redirect_single_search_result', 'custom_disable_single_search_redirect');
function custom_disable_single_search_redirect()
{
	return false;
}

add_filter('woocommerce_product_data_tabs', 'custom_clean_product_tabs', 99);
function custom_clean_product_tabs(array $tabs)
{
	unset($tabs['inventory']);
	unset($tabs['shipping']);
	unset($tabs['linked_product']);
	unset($tabs['attribute']);
	unset($tabs['advanced']);
	return $tabs;
}

add_filter('wp_lazy_loading_enabled', '__return_true');

// 1. Правильне підключення локального Fancybox 5 тільки для сторінок товарів
add_action('wp_enqueue_scripts', 'custom_theme_register_fancybox_v5', 10);
function custom_theme_register_fancybox_v5()
{
	// Реєструємо локальні файли з папки node_modules твоєї теми
	wp_register_style('theme-fancybox-css', get_template_directory_uri() . '/node_modules/@fancyapps/ui/dist/fancybox/fancybox.css', array(), '5.0');
	wp_register_script('theme-fancybox-js', get_template_directory_uri() . '/node_modules/@fancyapps/ui/dist/fancybox/fancybox.umd.js', array(), '5.0', true);

	if (!is_front_page() && (is_product() || is_single() || is_page())) {
		wp_enqueue_style('theme-fancybox-css');
		wp_enqueue_script('theme-fancybox-js');
	}
}

// 2. Додаємо атрибут defer для скриптів теми та Fancybox
add_filter('script_loader_tag', 'custom_theme_fancybox_defer_attribute', 10, 2);
function custom_theme_fancybox_defer_attribute(string $tag, string $handle): string
{
	$defer_scripts = ['theme-fancybox-js', 'dbd-script'];

	if (in_array($handle, $defer_scripts, true)) {
		return str_replace(' src', ' defer src', $tag);
	}
	return $tag;
}


add_filter('wpcf7_validate_intl_tel*', 'custom_intl_tel_validation', 20, 2);
add_filter('wpcf7_validate_intl_tel', 'custom_intl_tel_validation', 20, 2);

function custom_intl_tel_validation(WPCF7_Validation $result, WPCF7_FormTag $tag)
{
	if ('your-phone' === $tag->name) {
		$phone = isset($_POST['your-phone']) ? trim($_POST['your-phone']) : '';
		$digits = preg_replace('/[^0-9+]/', '', $phone);

		if (strpos($digits, '+380') === 0) {
			if (! preg_match('/^\+380\d{9}$/', $digits)) {
				$result->invalidate($tag, '');
			}
		} elseif (! preg_match('/^\+?[1-9]\d{9,14}$/', $digits)) {
			$result->invalidate($tag, 'Будь ласка, введіть коректний номер телефону.');
		}
	}
	return $result;
}
function dbd_lab_disable_woo_assets()
{
	if (function_exists('is_woocommerce') && is_front_page()) {
		wp_dequeue_style('woocommerce-general');
		wp_dequeue_style('woocommerce-layout');
		wp_dequeue_style('woocommerce-smallscreen');

		wp_dequeue_script('wc-add-to-cart');
		wp_dequeue_script('woocommerce');
		wp_dequeue_script('wc-cart-fragments');
		wp_dequeue_script('jquery-blockui');
		wp_dequeue_script('js-cookie');
		wp_dequeue_script('sourcebuster-js');
		wp_dequeue_script('wc-order-attribution');
	}
}
add_action('wp_enqueue_scripts', 'dbd_lab_disable_woo_assets', 99);

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

function dbd_lab_remove_jquery_migrate(WP_Scripts $scripts)
{
	if (! is_admin() && isset($scripts->registered['jquery'])) {
		$script = $scripts->registered['jquery'];
		if (! empty($script->deps)) {
			$script->deps = array_diff($script->deps, ['jquery-migrate']);
		}
	}
}
add_action('wp_default_scripts', 'dbd_lab_remove_jquery_migrate');
