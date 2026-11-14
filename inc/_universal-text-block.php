<?php

/**
 * Рендеринг промо-блока
 *
 * @param array $args Параметри блоку
 */
function render_custom_text_promo_block($args = [])
{
    $defaults = [
        'title'             => '',
        'text'              => '',
        'background'        => 'none',
        'has_margin_bottom' => true, // По умолчанию отступ есть (60px)
        'buttons'           => [],
    ];

    $parsed_args = wp_parse_args($args, $defaults);

    if (empty($parsed_args['title']) && empty($parsed_args['text'])) {
        return;
    }

    $block_classes = [
        'text-promo',
        "text-promo--bg-{$parsed_args['background']}"
    ];

    // Если галочка стоит — добавляем класс для отступа
    if ($parsed_args['has_padding_bottom']) {
        $block_classes[] = 'text-promo--has-padding';
    }

    $class_string = implode(' ', array_map('sanitize_html_class', $block_classes));

    ob_start(); ?>
    <section class="<?php echo esc_attr($class_string); ?>">
        <div class="container text-promo__container">
            <div class="text-promo__content">

                <?php if (!empty($parsed_args['title'])) : ?>
                    <h2 class="text-promo__title"><?php echo wp_kses_post($parsed_args['title']); ?></h2>
                <?php endif; ?>

                <?php if (!empty($parsed_args['text'])) : ?>
                    <div class="text-promo__text"><?php echo wp_kses_post($parsed_args['text']); ?></div>
                <?php endif; ?>

                <?php if (!empty($parsed_args['buttons']) && is_array($parsed_args['buttons'])) : ?>
                    <div class="text-promo__buttons-wrap">
                        <?php foreach ($parsed_args['buttons'] as $button_data) : ?>
                            <?php
                            if (!empty($button_data) && function_exists('render_acf_button')) {
                                render_acf_button($button_data, 'text-promo__btn');
                            }
                            ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>
<?php
    echo ob_get_clean();
}

/**
 * Подготовка данных из ACF
 *
 * @param array|false|null $acf_data Дані макета з ACF.
 */
function render_acf_text_promo_block(?array $acf_data)
{
    if (empty($acf_data)) {
        return;
    }

    if (isset($acf_data['_universal-text-block']) && is_array($acf_data['_universal-text-block'])) {
        $acf_data = $acf_data['_universal-text-block'];
    }

    $block_args = [
        'title'             => $acf_data['title'] ?? '',
        'text'              => $acf_data['text'] ?? '',
        'background'        => $acf_data['background'] ?? 'none',
        'has_padding_bottom' => isset($acf_data['has_padding_bottom']) ? (bool)$acf_data['has_padding_bottom'] : true, // Читаем галочку
        'buttons'           => [],
    ];

    if (!empty($acf_data['has_buttons']) && !empty($acf_data['buttons_repeater']) && is_array($acf_data['buttons_repeater'])) {
        foreach ($acf_data['buttons_repeater'] as $btn_item) {
            $raw_button = [];

            if (!empty($btn_item['button']['button']) && is_array($btn_item['button']['button'])) {
                $raw_button = $btn_item['button']['button'];
            } elseif (!empty($btn_item['button']) && is_array($btn_item['button'])) {
                $raw_button = $btn_item['button'];
            }

            if (!empty($raw_button)) {
                $clean_button_data = [];
                foreach ($raw_button as $key => $value) {
                    if (preg_match('/(button_text_|button_style_|button_icon|button_action_type|button_url_|modal_id_)/', $key, $matches)) {
                        $clean_button_data[$matches[0]] = $value;
                    }
                }
                $block_args['buttons'][] = $clean_button_data;
            }
        }
    }

    render_custom_text_promo_block($block_args);
}
