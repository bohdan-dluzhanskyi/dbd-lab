<?php

/**
 * Макет: Гарантийное обслуживание (_guarantee)
 */

$title       = get_sub_field('title');
$description = get_sub_field('description');
$cards       = get_sub_field('card'); 
?>

<section class="guarantee-section">
    <div class="container">
        <div class="guarantee-wrapper">

            <div class="guarantee-info">
                <?php if ($title) : ?>
                    <h2 class="guarantee-title">
                        <?php echo wp_kses_post($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <p class="guarantee-desc">
                        <?php echo nl2br(wp_kses_post($description)); ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php if (! empty($cards) && is_array($cards)) : ?>
                <div class="guarantee-cards">
                    <?php foreach ($cards as $index => $card) :
                        $subtitle  = $card['subtitle'];
                        $card_text = $card['text']; 
                        if (! $subtitle && ! $card_text) continue;

                        $item_index = $index + 1;
                    ?>
                        <div class="guarantee-card card-id-<?php echo $item_index; ?>">
                            <?php if ($subtitle) : ?>
                                <h3 class="guarantee-card-subtitle">
                                    <?php echo esc_html($subtitle); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if ($card_text) : ?>
                                <p class="guarantee-card-text">
                                    <?php echo nl2br(esc_html($card_text)); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>