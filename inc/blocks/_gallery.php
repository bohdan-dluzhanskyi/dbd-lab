<?php

/**
 * Макет: Галерея / Деталі (_gallery)
 */

$title       = get_sub_field('title');
$description = get_sub_field('description');
$carousel    = get_sub_field('carousal');
?>

<section class="gallery-section">
    <div class="container">

        <div class="gallery-header">
            <?php if ($title) : ?>
                <h2 class="gallery-main-title">
                    <?php echo wp_kses_post($title); ?>
                </h2>
            <?php endif; ?>

            <?php if ($description) : ?>
                <p class="gallery-desc">
                    <?php echo nl2br(wp_kses_post($description)); ?>
                </p>
            <?php endif; ?>
        </div>

        <?php if (! empty($carousel) && is_array($carousel)) : ?>
            <div class="gallery-carousel-wrapper">

                <div class="native-carousel">
                    <?php foreach ($carousel as $image) :
                        $img_id = is_array($image) ? $image['ID'] : $image;
                        $full_img_url = wp_get_attachment_image_url($img_id, 'full');
                    ?>
                        <div class="carousel-slide">
                            <div class="gallery-slide-img">
                                <!-- Огорнули зображення в лінк для Fancybox 5 -->
                                <a href="<?php echo esc_url($full_img_url); ?>" data-fancybox="flexible-gallery" class="gallery-lightbox-link" style="display: block; width: 100%; height: 100%;">
                                    <?php echo wp_get_attachment_image($img_id, 'large', false, array(
                                        'loading' => 'lazy',
                                        'decoding' => 'async'
                                    )); ?>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="button" class="gallery-btn prev-btn" aria-label="Попередній слайд">
                    <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.75 8.75L0.75 4.75L4.75 0.75" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="white" />
                    </svg>
                </button>
                <button type="button" class="gallery-btn next-btn" aria-label="Наступний слайд">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 8L14 12L10 16" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="white" />
                    </svg>
                </button>

            </div>
        <?php endif; ?>

    </div>
</section>