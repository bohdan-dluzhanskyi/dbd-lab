<?php

/**
 * Макет: Что мы предлагаем (_offer)
 */

$title = get_sub_field('title');
$photo = get_sub_field('photo'); // Image Array
$cards = get_sub_field('offer-card');
?>

<section class="offer-section">
    <div class="container">

        <?php if ($title) : ?>
            <h2 class="offer-main-title">
                <?php echo wp_kses_post($title); ?>
            </h2>
        <?php endif; ?>

        <div class="offer-grid-layout">

            <div class="offer-left-column">
                <?php if (! empty($photo) && is_array($photo)) :
                    $img_url = ! empty($photo['sizes']['large']) ? $photo['sizes']['large'] : $photo['url'];
                    $img_alt = ! empty($photo['alt']) ? $photo['alt'] : $photo['title'];
                ?>
                    <div class="offer-image-wrapper">
                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>" loading="lazy" decoding="async">
                    </div>
                <?php endif; ?>
            </div>

            <div class="offer-right-column">
                <?php if (! empty($cards) && is_array($cards)) : ?>
                    <div class="offer-list">
                        <?php foreach ($cards as $card) :
                            $subtitle  = $card['subtitle'];
                            $card_text = $card['text'];
                            if (! $subtitle && ! $card_text) continue;
                        ?>
                            <div class="offer-item">
                                <?php if ($subtitle) : ?>
                                    <h3 class="offer-item-subtitle">
                                        <?php echo esc_html($subtitle); ?>
                                    </h3>
                                <?php endif; ?>

                                <?php if ($card_text) : ?>
                                    <p class="offer-item-text">
                                        <?php echo nl2br(esc_html($card_text)); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>