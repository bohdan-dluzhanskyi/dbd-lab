<?php
$block_title    = get_sub_field('block_title');
$block_subtitle = get_sub_field('block_subtitle');
?>

<section class="directions-section">
    <div class="container directions-section__container">

        <?php if ($block_title || $block_subtitle) : ?>
            <div class="directions-section__header">
                <?php if ($block_title) : ?>
                    <h2 class="directions-section__main-title"><?php echo wp_kses_post($block_title); ?></h2>
                <?php endif; ?>

                <?php if ($block_subtitle) : ?>
                    <p class="directions-section__subtitle"><?php echo wp_kses_post($block_subtitle); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (have_rows('directions_list')) : ?>
            <div class="directions-grid">
                <?php while (have_rows('directions_list')) : the_row();
                    $raw_term = get_sub_field('category_link');

                    $term_id = 0;
                    if (!empty($raw_term)) {
                        if (is_array($raw_term) && isset($raw_term[0])) {
                            $term_id = (int)$raw_term[0];
                        } elseif (is_numeric($raw_term)) {
                            $term_id = (int)$raw_term;
                        } elseif (is_object($raw_term) && isset($raw_term->term_id)) {
                            $term_id = (int)$raw_term->term_id;
                        } elseif (is_array($raw_term) && isset($raw_term['term_id'])) {
                            $term_id = (int)$raw_term['term_id'];
                        }
                    }

                    $term_obj = ($term_id > 0) ? get_term($term_id, 'product_cat') : null;

                    if (!empty($term_obj) && !is_wp_error($term_obj)) {
                        $card_title = $term_obj->name;
                        $card_desc  = $term_obj->description;
                        $link_url   = get_term_link($term_obj);
                        if (is_wp_error($link_url)) $link_url = '#';
                    } else {
                        $card_title = 'Тестове напрямок';
                        $card_desc  = 'Будь ласка, перевірте вибір категорії в адмінці.';
                        $link_url   = '#';
                    }
                ?>
                    <a href="<?php echo esc_url($link_url); ?>" class="direction-card">

                        <div class="direction-card__circle-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 17L17 7M17 15V7H9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="white" />
                            </svg>
                        </div>

                        <div class="direction-card__content">
                            <h3 class="direction-card__title"><?php echo esc_html($card_title); ?></h3>
                            <?php if ($card_desc) : ?>
                                <p class="direction-card__desc"><?php echo wp_kses_post($card_desc); ?></p>
                            <?php endif; ?>
                        </div>

                    </a>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

    </div>
</section>