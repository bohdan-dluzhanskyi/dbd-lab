<?php

/**
 * Макет: Для кого ми працюємо (_audience)
 */

$title = get_sub_field('title');
$cards = get_sub_field('card');
?>

<section class="audience-section">
    <div class="container">
        <div class="audience-grid">

            <div class="audience-card audience-main-title">
                <?php if ($title) : ?>
                    <h2><?php echo wp_kses_post($title); ?></h2>
                <?php endif; ?>
            </div>

            <?php if (! empty($cards) && is_array($cards)) : ?>
                <?php foreach ($cards as $card) :
                    $subtitle    = $card['subtitle'];
                    $description = $card['description'];
                    if (! $subtitle && ! $description) continue;
                ?>
                    <div class="audience-card">
                        <?php if ($subtitle) : ?>
                            <h3 class="audience-card-title">
                                <?php echo wp_kses_post($subtitle); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ($description) : ?>
                            <p class="audience-card-desc">
                                <?php echo nl2br(wp_kses_post($description)); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</section>