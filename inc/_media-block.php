<?php

function render_custom_media_block($args = [])
{
    $defaults = [
        'title'          => '',
        'text'           => '',
        'image'          => '',
        'image_position' => 'left',
        'text_alignment' => 'left',
        'text_width'     => '652', 
        'background'     => 'none',
        'button_data'    => [],
    ];

    $parsed_args = wp_parse_args($args, $defaults);

    if (empty($parsed_args['title']) && empty($parsed_args['text']) && empty($parsed_args['image'])) {
        return;
    }
    $block_classes = [
        'universal-promo',
        "universal-promo--img-{$parsed_args['image_position']}",
        "universal-promo--align-{$parsed_args['text_alignment']}",
        "universal-promo--width-{$parsed_args['text_width']}", 
        "universal-promo--bg-{$parsed_args['background']}"
    ];

    $class_string = implode(' ', array_map('sanitize_html_class', $block_classes));

    ob_start(); ?>
    <section class="<?php echo esc_attr($class_string); ?>">
        <div class="container universal-promo__container">

            <div class="universal-promo__image-wrap">
                <?php if (!empty($parsed_args['image']) && is_array($parsed_args['image']) && isset($parsed_args['image']['url'])) : ?>
                    <img class="universal-promo__image"
                        src="<?php echo esc_url($parsed_args['image']['url']); ?>"
                        alt="<?php echo esc_attr(!empty($parsed_args['image']['alt']) ? $parsed_args['image']['alt'] : $parsed_args['title']); ?>">
                <?php endif; ?>
            </div>

            <div class="universal-promo__content">
                <div class="universal-promo__content-wrap">

                    <?php if (!empty($parsed_args['title'])) : ?>
                        <h2 class="universal-promo__title"><?php echo wp_kses_post($parsed_args['title']); ?></h2>
                    <?php endif; ?>

                    <?php if (!empty($parsed_args['text'])) : ?>
                        <div class="universal-promo__text"><?php echo wp_kses_post($parsed_args['text']); ?></div>
                    <?php endif; ?>

                    <?php if (!empty($parsed_args['button_data'])) : ?>
                        <div class="universal-promo__button-wrap">
                            <?php
                            if (function_exists('render_acf_button')) {
                                render_acf_button($parsed_args['button_data'], 'universal-promo__btn');
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

        </div>
    </section>
<?php
    echo ob_get_clean();
}

/**
 *
 * @param array|false|null $acf_data Дані макета медіа-блоку з ACF.
 */
function render_acf_media_block(?array $acf_data)
{
    if (empty($acf_data)) {
        return;
    }

    if (isset($acf_data['_media-block']) && is_array($acf_data['_media-block'])) {
        $acf_data = $acf_data['_media-block'];
    }

    $block_args = [
        'title'          => $acf_data['title'] ?? '',
        'text'           => $acf_data['text'] ?? '',
        'image'          => $acf_data['image'] ?? '',
        'image_position' => $acf_data['image_position'] ?? 'left',
        'text_alignment' => $acf_data['text_alignment'] ?? 'left',
        'text_width'     => $acf_data['text_width'] ?? '652', // Передаємо значення з ACF (дефолт 652)
        'background'     => $acf_data['background'] ?? 'none',
        'button_data'    => [],
    ];

    if (!empty($acf_data['has_button'])) {
        $raw_button = [];

        if (!empty($acf_data['button']['button']) && is_array($acf_data['button']['button'])) {
            $raw_button = $acf_data['button']['button'];
        } elseif (!empty($acf_data['button']) && is_array($acf_data['button'])) {
            $raw_button = $acf_data['button'];
        }

        if (!empty($raw_button)) {
            $clean_button_data = [];

            foreach ($raw_button as $key => $value) {
                if (preg_match('/(button_text_|button_style_|button_icon|button_action_type|button_url_|modal_id_)/', $key, $matches)) {
                    $clean_button_data[$matches[0]] = $value;
                }
            }

            $block_args['button_data'] = $clean_button_data;
        }
    }

    render_custom_media_block($block_args);
}
