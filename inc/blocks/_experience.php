<?php
$title = get_sub_field('title');
$description = get_sub_field('description');
$cards = get_sub_field('card');
?>
<section class="experience">
    <div class="container">
        <?php if ($title || $description): ?>
            <div class="experience__header">
                <?php if ($title): ?>
                    <h2 class="experience__title"><?php echo wp_kses_post($title); ?></h2>
                <?php endif; ?>
                <?php if ($description): ?>
                    <p class="experience__description"><?php echo wp_kses_post($description); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($cards): ?>
            <div class="experience__grid">
                <?php foreach ($cards as $card):
                    $subtitle = $card['subtitle'];
                    $text = $card['text'];
                ?>
                    <div class="experience__card">
                        <?php if ($subtitle): ?>
                            <h3 class="experience__card-subtitle"><?php echo esc_html($subtitle); ?></h3>
                        <?php endif; ?>
                        <?php if ($text): ?>
                            <p class="experience__card-text"><?php echo esc_html($text); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>