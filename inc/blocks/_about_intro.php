<?php
$left_text   = get_sub_field('left_text');
$left_title  = get_sub_field('left_title');
$right_text  = get_sub_field('right_text');
$right_title = get_sub_field('right_title');
$button      = get_sub_field('button');
$image       = get_sub_field('center_image');
?>

<section class="about-intro">
    <div class="container about-intro__container">

        <div class="about-intro__bg-layer">
            <div class="about-intro__title-left">
                <?php if ($left_title) : ?>
                    <h2 class="about-intro__title"><?php echo wp_kses_post($left_title); ?></h2>
                <?php endif; ?>
            </div>

            <div class="about-intro__image">
                <?php if (!empty($image) && is_array($image) && isset($image['url'])) : ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr(!empty($image['alt']) ? $image['alt'] : $left_title); ?>">
                <?php endif; ?>
            </div>

            <div class="about-intro__title-right">
                <?php if ($right_title) : ?>
                    <h2 class="about-intro__title"><?php echo wp_kses_post($right_title); ?></h2>
                <?php endif; ?>
            </div>
        </div>

        <div class="about-intro__content">
            <div class="about-intro__row-top">
                <div class="about-intro__text-left">
                    <?php if ($left_text) : ?>
                        <div class="about-intro__top-text"><?php echo wp_kses_post($left_text); ?></div>
                    <?php endif; ?>
                </div>
                <div class="about-intro__text-right">
                    <?php if ($right_text) : ?>
                        <div class="about-intro__top-text"><?php echo wp_kses_post($right_text); ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="about-intro__row-bottom">
                <div class="about-intro__benefits-wrap">
                    <?php if (have_rows('benefits_list')) : ?>
                        <div class="intro-benefits">
                            <?php while (have_rows('benefits_list')) : the_row();
                                $b_title = get_sub_field('title');
                                $b_desc  = get_sub_field('desc');
                            ?>
                                <div class="intro-benefit-card">
                                    <?php if ($b_title) : ?>
                                        <strong class="intro-benefit-card__number"><?php echo esc_html($b_title); ?></strong>
                                    <?php endif; ?>
                                    <?php if ($b_desc) : ?>
                                        <p class="intro-benefit-card__desc"><?php echo wp_kses_post($b_desc); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="about-intro__button-wrap">
                    <?php
                    if (!empty($button['button'])) {
                        render_acf_button($button['button'], 'hero-section__btn');
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</section>