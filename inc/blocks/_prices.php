<?php
$title = get_sub_field('title');
$cards = get_sub_field('card');
$has_more = (!empty($cards) && is_array($cards) && count($cards) > 6);
?>
<section class="prices">
    <div class="container">
        <?php if ($title): ?>
            <h2 class="prices__title"><?php echo wp_kses_post($title); ?></h2>
        <?php endif; ?>

        <?php if ($cards): ?>
            <div class="prices__flex-list">
                <?php foreach ($cards as $card):
                    $subtitle = $card['subtitle'];
                    $price = $card['price'];
                    $description = $card['description'];
                ?>
                    <article class="prices__item">
                        <div class="prices__item-header">
                            <?php if ($subtitle): ?>
                                <h3 class="prices__item-subtitle"><?php echo esc_html($subtitle); ?></h3>
                            <?php endif; ?>
                            <?php if ($price): ?>
                                <span class="prices__item-value"><?php echo esc_html($price); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if ($description): ?>
                            <p class="prices__item-description"><?php echo esc_html($description); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php if ($has_more): ?>
                <div class="prices__more-wrap">
                    <button type="button" class="c-btn c-btn--outlined prices__more-btn">
                        <?php pll_e('Переглянути більше'); ?>
                    </button>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>