<?php
function render_custom_button($args = [])
{
    $defaults = [
        'text'          => '',
        'type'          => 'link',
        'url'           => '#',
        'style'         => 'filled',
        'icon'          => '',
        'icon_position' => 'left',
        'attributes'    => [],
        'class'         => '',
    ];
    $parsed_args = wp_parse_args($args, $defaults);
    extract($parsed_args);

    if (empty($text) && empty($icon)) return '';

    // Базові класи кнопки
    $base_classes = ['c-btn', "c-btn--{$style}"];

    if (!empty($icon)) {
        $base_classes[] = "c-btn--with-icon";
        $base_classes[] = "c-btn--icon-{$icon_position}";
    }

    // Якщо передано додаткові класи, розбиваємо їх по пробілах, щоб очистити кожен окремо
    if (!empty($class)) {
        $extra_classes = explode(' ', $class);
        foreach ($extra_classes as $single_class) {
            $cleaned = sanitize_html_class(trim($single_class));
            if (!empty($cleaned)) {
                $base_classes[] = $cleaned;
            }
        }
    }

    // Склеюємо всі класи строго через ОДИН пробіл
    $class_string = implode(' ', array_unique($base_classes));

    $attr_string = '';
    if (!empty($attributes)) {
        foreach ($attributes as $key => $val) {
            $attr_string .= ' ' . esc_attr($key) . '="' . esc_attr($val) . '"';
        }
    }

    $icon_html = '';
    if (!empty($icon)) {
        $icon_path = get_template_directory() . "/assets/images/icons/{$icon}.svg";

        if (file_exists($icon_path)) {
            $svg_content = file_get_contents($icon_path);
            $icon_html = '<span class="c-btn__icon icon-' . esc_attr($icon) . '">' . $svg_content . '</span>';
        }
    }

    switch ($type) {
        case 'button':
        case 'modal':
            $tag = 'button';
            $type_attr = 'type="button"';
            break;
        case 'dropdown':
            $tag = 'button';
            $type_attr = 'type="button"';
            $attr_string .= ' aria-haspopup="true" aria-expanded="false"';
            break;
        case 'link':
        default:
            $tag = 'a';
            $type_attr = 'href="' . esc_url($url) . '"';
            break;
    }

    ob_start(); ?>
    <<?php echo $tag; ?> <?php echo $type_attr; ?> class="<?php echo esc_attr($class_string); ?>" <?php echo $attr_string; ?>>
        <?php if ($icon_position === 'left') echo $icon_html; ?>
        <span class="c-btn__text"><?php echo esc_html($text); ?></span>
        <?php if ($icon_position === 'right') echo $icon_html; ?>
    </<?php echo $tag; ?>>
<?php echo ob_get_clean();
}

/**
 * Рендеринг кнопки на основі даних з масиву ACF.
 *
 * @param array|false|null $button_data Дані групи полів кнопки з ACF.
 * @param string           $extra_class Додатковий CSS-клас.
 */
function render_acf_button(array $button_data, string $extra_class = '')
{
    if (empty($button_data) || empty($button_data['button_text_'])) {
        return;
    }

    // Збираємо класи в масив, щоб уникнути будь-яких проблем із пробілами
    $classes = [];
    if (!empty($extra_class)) {
        $classes[] = trim($extra_class);
    }

    switch ($button_data['button_action_type']) {
        case 'modal':
            $type = 'modal';
            $classes[] = 'open-callback-modal'; // Ваш клас для модалки
            break;

        case 'dropdown':
            $type = 'dropdown';
            $classes[] = 'js-dropdown-trigger';
            break;

        case 'link':
        default:
            $type = 'link';
            break;
    }

    // Збираємо аргументи
    $btn_args = [
        'text'  => $button_data['button_text_'],
        'type'  => $type,
        'style' => $button_data['button_style_'] ?? 'filled',
        'icon'  => (isset($button_data['button_icon']) && $button_data['button_icon'] !== 'none') ? $button_data['button_icon'] : '',
        'class' => implode(' ', $classes), // Склеюємо класи через пробіл
    ];

    // Додаткові атрибути для посилань
    if ($type === 'link') {
        if (!empty($button_data['button_url_'])) {
            $btn_args['url'] = $button_data['button_url_'];
            $btn_args['attributes'] = ['target' => '_self'];
        } else {
            $btn_args['url'] = '#';
        }
    }

    render_custom_button($btn_args);
}
