<?php
$subtitle    = get_sub_field('subtitle');
$title       = get_sub_field('title');
$description = get_sub_field('description');
$button      = get_sub_field('button');
$image       = get_sub_field('image');
?>

<section class="hero-section">
    <div class="container hero-section__container">

        <div class="hero-section__content">
            <div class="hero-section__title-wrapper">
                <?php if ($subtitle) : ?>
                    <span class="hero-section__subtitle"><?php echo esc_html($subtitle); ?></span>
                <?php endif; ?>

                <?php if ($title) : ?>
                    <h1 class="hero-section__title"><?php echo wp_kses_post($title); ?></h1>
                <?php endif; ?>
            </div>

            <div class="hero-section__text-wrapper">
                <?php if ($description) : ?>
                    <p class="hero-section__text"><?php echo wp_kses_post($description); ?></p>
                <?php endif; ?>

                <?php
                if (!empty($button['button'])) {
                    render_acf_button($button['button'], 'hero-section__btn');
                }
                ?>
            </div>

        </div>

        <div class="hero-section__image">
            <?php if ($image) : ?>
                <?php
                $img_url    = !empty($image['sizes']['large']) ? $image['sizes']['large'] : $image['url'];
                $img_width  = !empty($image['sizes']['large-width']) ? $image['sizes']['large-width'] : $image['width'];
                $img_height = !empty($image['sizes']['large-height']) ? $image['sizes']['large-height'] : $image['height'];
                ?>
                <img
                    fetchpriority="high"
                    loading="eager"
                    src="<?php echo esc_url($img_url); ?>"
                    width="<?php echo esc_attr($img_width); ?>"
                    height="<?php echo esc_attr($img_height); ?>"
                    alt="<?php echo esc_attr($image['alt']); ?>">
            <?php endif; ?>
        </div>


    </div>
</section>